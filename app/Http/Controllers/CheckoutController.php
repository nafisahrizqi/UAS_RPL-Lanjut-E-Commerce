<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Deposit;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('member.cart.index')->with('error', 'Keranjang belanja Anda kosong!');
        }

        $customer = Auth::guard('customer')->user();
        $total = 0;
        foreach ($cart as $details) {
            $total += $details['price'] * $details['quantity'];
        }

        // Get available sukarela balance
        $latestSukarela = Deposit::where('customer_id', $customer->id)
            ->whereIn('type', ['sukarela', 'penarikan'])
            ->latest('id')
            ->first();
        
        $sukarela_balance = $latestSukarela ? $latestSukarela->current_balance : 0;

        return view('member.checkout.index', compact('cart', 'total', 'customer', 'sukarela_balance'));
    }

    public function store(Request $request)
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('member.cart.index')->with('error', 'Keranjang belanja Anda kosong!');
        }

        $request->validate([
            'payment_method' => 'required|in:cash,deposit_deduction',
            'shipping_method' => 'required|in:pickup,delivery',
            'shipping_address' => 'required_if:shipping_method,delivery|nullable|string',
        ]);

        $customer = Auth::guard('customer')->user();
        $total = 0;
        foreach ($cart as $details) {
            $total += $details['price'] * $details['quantity'];
        }

        try {
            DB::beginTransaction();

            $paymentMethod = $request->payment_method;
            $paymentStatus = 'pending';

            if ($paymentMethod === 'deposit_deduction') {
                // Fetch latest sukarela/penarikan record to check balance
                $latestSukarela = Deposit::where('customer_id', $customer->id)
                    ->whereIn('type', ['sukarela', 'penarikan'])
                    ->lockForUpdate() // lock rows to prevent race conditions
                    ->latest('id')
                    ->first();

                $sukarela_balance = $latestSukarela ? $latestSukarela->current_balance : 0;

                if ($sukarela_balance < $total) {
                    throw new \Exception('Saldo simpanan sukarela Anda tidak mencukupi untuk pembayaran ini.');
                }

                // Create a "penarikan" deposit record to represent the deduction
                Deposit::create([
                    'customer_id' => $customer->id,
                    'type' => 'penarikan',
                    'amount' => $total,
                    'previous_balance' => $sukarela_balance,
                    'current_balance' => $sukarela_balance - $total,
                    'loan_id' => null,
                ]);

                $paymentStatus = 'paid';
            }

            // Generate Invoice Number
            $invoiceNumber = 'INV-' . Carbon::now()->format('ymdHis') . '-' . strtoupper(Str::random(4));

            // Create Order
            $order = Order::create([
                'customer_id' => $customer->id,
                'invoice_number' => $invoiceNumber,
                'total_amount' => $total,
                'payment_method' => $paymentMethod,
                'payment_status' => $paymentStatus,
                'order_status' => $paymentMethod === 'deposit_deduction' ? 'processing' : 'pending',
                'shipping_method' => $request->shipping_method,
                'shipping_address' => $request->shipping_method === 'delivery' ? ($request->shipping_address ?? $customer->address) : null,
                'order_date' => Carbon::now(),
            ]);

            // Create Order Items and update product stocks
            foreach ($cart as $productId => $details) {
                $product = Product::lockForUpdate()->findOrFail($productId);
                if ($product->stock < $details['quantity']) {
                    throw new \Exception("Stok untuk produk {$product->name} tidak mencukupi!");
                }

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'price' => $details['price'],
                    'quantity' => $details['quantity'],
                ]);

                // Decrement stock
                $product->decrement('stock', $details['quantity']);
            }

            DB::commit();

            // Clear Cart
            session()->forget('cart');

            return redirect()->route('member.orders.show', $order->id)
                ->with('success', 'Checkout berhasil! Terima kasih telah berbelanja.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function orderHistory()
    {
        $customer = Auth::guard('customer')->user();
        $orders = $customer->orders()->orderBy('created_at', 'desc')->paginate(10);
        return view('member.orders.index', compact('orders'));
    }

    public function showOrder($id)
    {
        $customer = Auth::guard('customer')->user();
        $order = Order::where('customer_id', $customer->id)->with('items.product')->findOrFail($id);
        return view('member.orders.show', compact('order'));
    }
}

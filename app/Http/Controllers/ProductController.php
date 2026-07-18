<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Deposit;
use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function dashboard()
    {
        $customer = Auth::guard('customer')->user();
        
        // Calculate deposits
        $pokok = Deposit::where('customer_id', $customer->id)->where('type', 'pokok')->sum('amount');
        $wajib = Deposit::where('customer_id', $customer->id)->where('type', 'wajib')->sum('amount');
        $sukarela = Deposit::where('customer_id', $customer->id)->where('type', 'sukarela')->sum('amount');
        $penarikan = Deposit::where('customer_id', $customer->id)->where('type', 'penarikan')->sum('amount');

        $sukarela_balance = $sukarela - $penarikan;
        $total_balance = $pokok + $wajib + $sukarela_balance;

        // Get loans
        $loans = Loan::where('customer_id', $customer->id)
            ->whereColumn('paid', '<', 'return_amount')
            ->get();

        // Get orders
        $orders = $customer->orders()->orderBy('created_at', 'desc')->take(5)->get();

        return view('member.dashboard', compact(
            'customer', 'pokok', 'wajib', 'sukarela', 'penarikan', 
            'sukarela_balance', 'total_balance', 'loans', 'orders'
        ));
    }

    public function index(Request $request)
    {
        $categories = Category::all();
        $query = Product::query();

        if ($request->has('category') && $request->category != '') {
            $category = Category::where('slug', $request->category)->firstOrFail();
            $query->where('category_id', $category->id);
        }

        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $products = $query->paginate(12);

        return view('member.products.index', compact('products', 'categories'));
    }

    public function show($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        return view('member.products.show', compact('product'));
    }
}

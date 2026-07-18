<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Customer;
use App\Models\User;
use App\Models\Loan;
use App\Models\Deposit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $total_customers = Customer::count();
        $total_users = User::count();
        $total_loans = Loan::sum('amount');
        $total_orders = DB::table('orders')->count();
        
        $total_deposits = Deposit::whereIn('type', ['pokok', 'wajib', 'sukarela'])->sum('amount') 
            - Deposit::where('type', 'penarikan')->sum('amount');

        // Recent customers
        $recent_customers = Customer::latest()->take(5)->get();

        // Recent visits for collector
        $recent_visits = DB::table('visits')
            ->join('customers', 'visits.customer_id', '=', 'customers.id')
            ->join('users', 'visits.user_id', '=', 'users.id')
            ->select('visits.*', 'customers.name as customer_name', 'users.name as collector_name')
            ->latest('visits.created_at')
            ->take(5)
            ->get();

        return view('pages.dashboard', [
            'title' => 'Dashboard',
            'total_customers' => $total_customers,
            'total_users' => $total_users,
            'total_loans' => $total_loans,
            'total_orders' => $total_orders,
            'total_deposits' => $total_deposits,
            'recent_customers' => $recent_customers,
            'recent_visits' => $recent_visits,
        ]);
    }

    public function profile()
    {
        return view('pages.profile', [
            'title' => 'Pengaturan',
            'profile' => Auth::user()
        ]);
    }

    public function update(UpdateProfileRequest $request)
    {
        try {
            $user = Auth::user();
            $data = $request->except('photo');
            $data['photo'] = $this->updateImage($request, $user->photo);
            $user->update($data);
            return back()->with('success', 'Berhasil mengupdate profil!');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }

    public function truncate()
    {
        try {
            Artisan::call('migrate:fresh --seed');
            Auth::logout();
            return back()->with('success', 'Berhasil mereset data!');
        } catch (\Throwable $th) {
            return back()->with('error', $th->getMessage());
        }
    }
}

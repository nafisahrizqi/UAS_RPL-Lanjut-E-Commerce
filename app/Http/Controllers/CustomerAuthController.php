<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class CustomerAuthController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::guard('web')->check()) {
            return redirect()->route('home');
        }
        if (Auth::guard('customer')->check()) {
            return redirect()->route('member.dashboard');
        }
        return redirect()->route('landing');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('username', 'password');

        // Check if user exists first and is active
        $customer = Customer::where('username', $request->username)->first();
        if ($customer && $customer->status !== 'active') {
            return back()->withErrors([
                'username' => 'Akun nasabah Anda dinonaktifkan atau masuk daftar hitam.',
            ])->withInput($request->only('username'));
        }

        if (Auth::guard('customer')->attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('member.dashboard'));
        }

        return back()->withErrors([
            'username' => 'Username atau password nasabah salah.',
        ])->withInput($request->only('username'));
    }

    public function showRegisterForm()
    {
        if (Auth::guard('customer')->check()) {
            return redirect()->route('member.dashboard');
        }
        return view('member.auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nik' => 'required|string|size:16|unique:customers',
            'name' => 'required|string|max:191',
            'phone' => 'required|string|unique:customers',
            'username' => 'required|string|min:4|unique:customers',
            'password' => 'required|string|min:6|confirmed',
            'email' => 'nullable|email|unique:customers',
            'address' => 'required|string',
        ]);

        // Generate customer number: CUST-XXXXXXXX
        $customerNumber = 'CUST-' . strtoupper(substr(md5(uniqid()), 0, 8));

        $customer = Customer::create([
            'nik' => $request->nik,
            'name' => $request->name,
            'number' => $customerNumber,
            'gender' => 'L', // default
            'phone' => $request->phone,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'email' => $request->email,
            'address' => $request->address,
            'status' => 'active',
            'joined_at' => Carbon::now(),
        ]);

        Auth::guard('customer')->login($customer);

        return redirect()->route('member.dashboard');
    }

    public function logout(Request $request)
    {
        Auth::guard('customer')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('member.login');
    }
}

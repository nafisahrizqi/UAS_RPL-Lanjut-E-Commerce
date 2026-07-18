<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DepositController;
use App\Http\Controllers\ForeclosureController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InstallmentController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VisitController;
use App\Http\Controllers\WithdrawalController;
use App\Http\Controllers\CustomerAuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    if (Illuminate\Support\Facades\Auth::guard('web')->check()) {
        return redirect()->route('home');
    }
    if (Illuminate\Support\Facades\Auth::guard('customer')->check()) {
        return redirect()->route('member.dashboard');
    }
    return view('landing');
})->name('landing');

Auth::routes(['login' => false]);

Route::get('/admin/login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('/admin/login', [App\Http\Controllers\Auth\LoginController::class, 'login']);

Route::middleware('auth')->group(function() {
    Route::get('/admin/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/pengaturan', [HomeController::class, 'profile'])->name('profile.show');
    Route::post('/pengaturan', [HomeController::class, 'update'])->name('profile.update');

    // ONLY MANAGER
    Route::middleware('role:manager')->group(function() {
        Route::resource('/karyawan', UserController::class, ['names' => 'user']);
        Route::post('/karyawan/cetak', [UserController::class, 'print'])->name('user.print');
        Route::delete('/pengaturan', [HomeController::class, 'truncate'])->name('profile.truncate');
    });

    // MASTER NASABAH (Accessible by manager, teller, collector)
    Route::resource('/nasabah', CustomerController::class, ['names' => 'customer']);
    Route::post('/nasabah/cetak', [CustomerController::class, 'print'])->name('customer.print');

    // TRANSAKSI (MANAGER & TELLER)
    Route::middleware('role:manager,teller')->group(function() {
        Route::as('transaction.')->prefix('transaksi')->group(function() {
            Route::resource('/pinjaman', LoanController::class, ['names' => 'loan']);
            Route::resource('/pembayaran', InstallmentController::class, ['names' => 'installment']);
            Route::resource('/simpanan', DepositController::class, ['names' => 'deposit']);
            Route::resource('/penarikan', WithdrawalController::class, ['names' => 'withdrawal']);

            Route::post('/pinjaman/cetak', [LoanController::class, 'print'])->name('loan.print');
            Route::post('/pembayaran/cetak', [InstallmentController::class, 'print'])->name('installment.print');
            Route::post('/simpanan/cetak', [DepositController::class, 'print'])->name('deposit.print');
            Route::post('/penarikan/cetak', [WithdrawalController::class, 'print'])->name('withdrawal.print');
        });
    });

    // KOLEKTOR (MANAGER & COLLECTOR)
    Route::middleware('role:manager,collector')->group(function() {
        Route::as('collection.')->prefix('kolektor')->group(function() {
            Route::resource('/nasabah-bermasalah', VisitController::class, ['names' => 'visit']);
            Route::resource('/penarikan-jaminan', ForeclosureController::class, ['names' => 'foreclosure']);

            Route::post('/nasabah-bermasalah/cetak', [VisitController::class, 'print'])->name('visit.print');
            Route::get('/nasabah-bermasalah/{nasabah_bermasalah}/cetak-slip', [VisitController::class, 'printSlip'])->name('visit.print_slip');
            Route::post('/penarikan-jaminan/cetak', [ForeclosureController::class, 'print'])->name('foreclosure.print');
        });
    });
});

// ==========================================
// NASABAH / MEMBER PORTAL & E-COMMERCE ROUTES
// ==========================================

use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;

Route::prefix('member')->group(function() {
    // Guest Routes
    Route::middleware('guest:customer')->group(function() {
        Route::get('/login', [CustomerAuthController::class, 'showLoginForm'])->name('member.login');
        Route::post('/login', [CustomerAuthController::class, 'login'])->name('member.login.submit');
        Route::get('/register', [CustomerAuthController::class, 'showRegisterForm'])->name('member.register');
        Route::post('/register', [CustomerAuthController::class, 'register'])->name('member.register.submit');
    });

    // Authenticated Routes
    Route::middleware('auth:customer')->group(function() {
        Route::post('/logout', [CustomerAuthController::class, 'logout'])->name('member.logout');
        
        // Member Dashboard & Account Information
        Route::get('/dashboard', [ProductController::class, 'dashboard'])->name('member.dashboard');
        
        // E-Commerce Catalog
        Route::get('/products', [ProductController::class, 'index'])->name('member.products.index');
        Route::get('/products/{slug}', [ProductController::class, 'show'])->name('member.products.show');
        
        // Cart
        Route::get('/cart', [CartController::class, 'index'])->name('member.cart.index');
        Route::post('/cart/add', [CartController::class, 'add'])->name('member.cart.add');
        Route::post('/cart/update', [CartController::class, 'update'])->name('member.cart.update');
        Route::post('/cart/remove', [CartController::class, 'remove'])->name('member.cart.remove');
        
        // Checkout & Orders
        Route::get('/checkout', [CheckoutController::class, 'index'])->name('member.checkout.index');
        Route::post('/checkout', [CheckoutController::class, 'store'])->name('member.checkout.store');
        Route::get('/orders', [CheckoutController::class, 'orderHistory'])->name('member.orders.index');
        Route::get('/orders/{id}', [CheckoutController::class, 'showOrder'])->name('member.orders.show');
    });
});



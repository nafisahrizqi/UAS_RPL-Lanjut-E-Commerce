@extends('layouts.app')

@section('content')
<style>
    .welcome-card {
        background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
        color: #ffffff;
        border: none;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.15);
        position: relative;
        overflow: hidden;
    }
    .welcome-card::after {
        content: '';
        position: absolute;
        width: 150px;
        height: 150px;
        background: rgba(255,255,255,0.05);
        border-radius: 50%;
        top: -30px;
        right: -30px;
    }
    .stat-card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
        overflow: hidden;
        color: #fff;
    }
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.12);
    }
    .bg-gradient-emerald {
        background: linear-gradient(135deg, #11998e, #38ef7d);
    }
    .bg-gradient-blue {
        background: linear-gradient(135deg, #1e3c72, #2a5298);
    }
    .bg-gradient-orange {
        background: linear-gradient(135deg, #f12711, #f5af19);
    }
    .bg-gradient-purple {
        background: linear-gradient(135deg, #654ea3, #eaafc8);
    }
    .action-btn {
        border-radius: 8px;
        transition: all 0.2s ease;
        font-weight: 500;
    }
    .action-btn:hover {
        transform: scale(1.02);
    }
    .recent-list-card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }
</style>

<div class="container-fluid pb-4">
    <!-- Welcome Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card welcome-card p-4">
                <div class="row align-items-center">
                    <div class="col-12 col-md-8">
                        <span class="badge badge-success px-3 py-2 mb-2 text-uppercase font-weight-bold" style="letter-spacing: 1px;">
                            Portal {{ Auth::user()->role }}
                        </span>
                        <h1 class="font-weight-bold text-white mb-2">Hai, {{ Auth::user()->name }}!</h1>
                        <p class="lead mb-0 text-white-50">
                            Selamat datang kembali di dashboard utama **Koperasi Kosunu**. Hari ini adalah hari yang baik untuk mengelola ekosistem digital kita.
                        </p>
                    </div>
                    <div class="col-12 col-md-4 text-md-right mt-3 mt-md-0">
                        <span class="d-inline-block p-3 rounded-lg bg-white-10 text-white font-weight-bold" style="background: rgba(255,255,255,0.1); backdrop-filter: blur(10px);">
                            <i class="far fa-calendar-alt mr-2"></i> {{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM Y') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats Grid -->
    <div class="row">
        <!-- Nasabah Count -->
        <div class="col-12 col-sm-6 col-md-3 mb-4">
            <div class="card stat-card bg-gradient-emerald h-100 p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-white-50 d-block text-uppercase small font-weight-bold">Total Nasabah</span>
                        <h2 class="font-weight-bold mb-0 mt-1">{{ number_format($total_customers) }}</h2>
                    </div>
                    <div class="icon-box" style="font-size: 2.5rem; opacity: 0.8;">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
                <div class="mt-3 text-white-50 small">
                    <i class="fas fa-check-circle mr-1"></i> Terdaftar dalam sistem aktif
                </div>
            </div>
        </div>

        <!-- Total Simpanan -->
        <div class="col-12 col-sm-6 col-md-3 mb-4">
            <div class="card stat-card bg-gradient-blue h-100 p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-white-50 d-block text-uppercase small font-weight-bold">Total Dana Simpanan</span>
                        <h2 class="font-weight-bold mb-0 mt-1" style="font-size: 1.5rem;">Rp{{ number_format($total_deposits, 0, ',', '.') }}</h2>
                    </div>
                    <div class="icon-box" style="font-size: 2.5rem; opacity: 0.8;">
                        <i class="fas fa-piggy-bank"></i>
                    </div>
                </div>
                <div class="mt-3 text-white-50 small">
                    <i class="fas fa-clock mr-1"></i> Akumulasi pokok, wajib & sukarela
                </div>
            </div>
        </div>

        <!-- Total Pinjaman -->
        <div class="col-12 col-sm-6 col-md-3 mb-4">
            <div class="card stat-card bg-gradient-orange h-100 p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-white-50 d-block text-uppercase small font-weight-bold">Pinjaman Disalurkan</span>
                        <h2 class="font-weight-bold mb-0 mt-1" style="font-size: 1.5rem;">Rp{{ number_format($total_loans, 0, ',', '.') }}</h2>
                    </div>
                    <div class="icon-box" style="font-size: 2.5rem; opacity: 0.8;">
                        <i class="fas fa-hand-holding-usd"></i>
                    </div>
                </div>
                <div class="mt-3 text-white-50 small">
                    <i class="fas fa-chart-line mr-1"></i> Total piutang anggota aktif
                </div>
            </div>
        </div>

        <!-- Total Orders E-Commerce -->
        <div class="col-12 col-sm-6 col-md-3 mb-4">
            <div class="card stat-card bg-gradient-purple h-100 p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <span class="text-white-50 d-block text-uppercase small font-weight-bold">Transaksi Toko</span>
                        <h2 class="font-weight-bold mb-0 mt-1">{{ number_format($total_orders) }}</h2>
                    </div>
                    <div class="icon-box" style="font-size: 2.5rem; opacity: 0.8;">
                        <i class="fas fa-shopping-basket"></i>
                    </div>
                </div>
                <div class="mt-3 text-white-50 small">
                    <i class="fas fa-shopping-cart mr-1"></i> E-Commerce Potong Saldo
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions Panel -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card recent-list-card">
                <div class="card-header bg-light">
                    <h5 class="card-title font-weight-bold mb-0 text-dark">
                        <i class="fas fa-bolt text-warning mr-2"></i> Menu Cepat / Pintasan Tindakan
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @if(Auth::user()->role === 'manager')
                            <div class="col-6 col-md-3 mb-2">
                                <a href="{{ route('user.index') }}" class="btn btn-block btn-outline-primary p-3 action-btn">
                                    <i class="fas fa-user-tie fa-2x mb-2 d-block"></i>
                                    Kelola Karyawan
                                </a>
                            </div>
                            <div class="col-6 col-md-3 mb-2">
                                <a href="{{ route('customer.index') }}" class="btn btn-block btn-outline-success p-3 action-btn">
                                    <i class="fas fa-users fa-2x mb-2 d-block"></i>
                                    Kelola Nasabah
                                </a>
                            </div>
                            <div class="col-6 col-md-3 mb-2">
                                <a href="{{ route('transaction.loan.index') }}" class="btn btn-block btn-outline-info p-3 action-btn">
                                    <i class="fas fa-file-invoice-dollar fa-2x mb-2 d-block"></i>
                                    Laporan Pinjaman
                                </a>
                            </div>
                            <div class="col-6 col-md-3 mb-2">
                                <a href="{{ route('collection.visit.index') }}" class="btn btn-block btn-outline-danger p-3 action-btn">
                                    <i class="fas fa-map-marked-alt fa-2x mb-2 d-block"></i>
                                    Pantau Kolektor
                                </a>
                            </div>
                        @elseif(Auth::user()->role === 'teller')
                            <div class="col-6 col-md-3 mb-2">
                                <a href="{{ route('transaction.deposit.index') }}" class="btn btn-block btn-outline-primary p-3 action-btn">
                                    <i class="fas fa-wallet fa-2x mb-2 d-block"></i>
                                    Setor Simpanan
                                </a>
                            </div>
                            <div class="col-6 col-md-3 mb-2">
                                <a href="{{ route('transaction.withdrawal.index') }}" class="btn btn-block btn-outline-danger p-3 action-btn">
                                    <i class="fas fa-money-bill-wave fa-2x mb-2 d-block"></i>
                                    Tarik Simpanan
                                </a>
                            </div>
                            <div class="col-6 col-md-3 mb-2">
                                <a href="{{ route('transaction.loan.index') }}" class="btn btn-block btn-outline-success p-3 action-btn">
                                    <i class="fas fa-hand-holding-usd fa-2x mb-2 d-block"></i>
                                    Input Pinjaman Baru
                                </a>
                            </div>
                            <div class="col-6 col-md-3 mb-2">
                                <a href="{{ route('transaction.installment.index') }}" class="btn btn-block btn-outline-warning p-3 action-btn">
                                    <i class="fas fa-receipt fa-2x mb-2 d-block"></i>
                                    Bayar Cicilan
                                </a>
                            </div>
                        @elseif(Auth::user()->role === 'collector')
                            <div class="col-6 col-md-4 mb-2">
                                <a href="{{ route('collection.visit.index') }}" class="btn btn-block btn-outline-danger p-3 action-btn">
                                    <i class="fas fa-street-view fa-2x mb-2 d-block"></i>
                                    Input Kunjungan Tagihan
                                </a>
                            </div>
                            <div class="col-6 col-md-4 mb-2">
                                <a href="{{ route('collection.foreclosure.index') }}" class="btn btn-block btn-outline-warning p-3 action-btn">
                                    <i class="fas fa-gavel fa-2x mb-2 d-block"></i>
                                    Penyitaan Jaminan
                                </a>
                            </div>
                            <div class="col-12 col-md-4 mb-2">
                                <a href="{{ route('customer.index') }}" class="btn btn-block btn-outline-primary p-3 action-btn">
                                    <i class="fas fa-address-book fa-2x mb-2 d-block"></i>
                                    Lihat Data Nasabah
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Lists Grid -->
    <div class="row">
        <!-- Recent Customers -->
        <div class="col-12 col-md-6 mb-4">
            <div class="card recent-list-card h-100">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="card-title font-weight-bold mb-0 text-dark">
                        <i class="fas fa-user-plus text-success mr-2"></i> Nasabah Baru Terdaftar
                    </h5>
                    <a href="{{ route('customer.index') }}" class="btn btn-xs btn-outline-secondary">Lihat Semua</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-items-center mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th>Rekening</th>
                                    <th>Nama Nasabah</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recent_customers as $cust)
                                    <tr>
                                        <td><code>{{ $cust->number }}</code></td>
                                        <td>
                                            <div class="font-weight-bold text-dark">{{ $cust->name }}</div>
                                            <small class="text-muted">{{ $cust->phone ?? '-' }}</small>
                                        </td>
                                        <td>
                                            <span class="badge badge-pill badge-success text-uppercase">{{ $cust->status }}</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center p-4 text-muted">Belum ada nasabah terdaftar.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Collector Visits -->
        <div class="col-12 col-md-6 mb-4">
            <div class="card recent-list-card h-100">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="card-title font-weight-bold mb-0 text-dark">
                        <i class="fas fa-map-marker-alt text-danger mr-2"></i> Kunjungan Kolektor Terkini
                    </h5>
                    @if(Auth::user()->role === 'manager' || Auth::user()->role === 'collector')
                        <a href="{{ route('collection.visit.index') }}" class="btn btn-xs btn-outline-secondary">Lihat Semua</a>
                    @endif
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-items-center mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th>Nasabah</th>
                                    <th>Tunggakan</th>
                                    <th>Kolektor</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recent_visits as $visit)
                                    <tr>
                                        <td>
                                            <div class="font-weight-bold text-dark">{{ $visit->customer_name }}</div>
                                            <small class="text-muted text-truncate d-inline-block" style="max-width: 180px;">
                                                "{{ $visit->description }}"
                                            </small>
                                        </td>
                                        <td class="font-weight-bold text-danger">
                                            Rp{{ number_format($visit->remaining_amount, 0, ',', '.') }}
                                        </td>
                                        <td>
                                            <span class="badge badge-info">{{ $visit->collector_name }}</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center p-4 text-muted">Belum ada kunjungan lapangan dicatat.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

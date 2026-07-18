@extends('layouts.member')

@section('title', 'Dashboard Nasabah')

@section('content')
<div class="row">
    <!-- Welcome Card -->
    <div class="col-md-12 mb-4">
        <div class="card bg-emerald text-white overflow-hidden shadow-sm" style="border: none;">
            <div class="card-body p-4 position-relative">
                <div style="z-index: 10; position: relative;">
                    <span class="badge badge-light mb-2 text-emerald font-weight-medium">Selamat Datang</span>
                    <h2 class="font-weight-bold mb-1">{{ $customer->name }}</h2>
                    <p class="mb-0 text-white-50">No. Rekening Anggota: <strong>{{ $customer->number }}</strong> | Anggota Sejak: {{ \Carbon\Carbon::parse($customer->joined_at)->isoFormat('D MMMM Y') }}</p>
                </div>
                <i class="fas fa-wallet position-absolute text-white" style="opacity: 0.1; font-size: 8rem; right: 20px; bottom: -10px;"></i>
            </div>
        </div>
    </div>
</div>

<!-- Savings Overview Section -->
<h4 class="font-weight-bold text-dark mb-3"><i class="fas fa-piggy-bank mr-2 text-emerald"></i> Simpanan Koperasi</h4>
<div class="row mb-4">
    <!-- Pokok -->
    <div class="col-md-3 col-sm-6 mb-3">
        <div class="card h-100 border-0 shadow-sm card-emerald">
            <div class="card-body">
                <div class="text-xs text-muted text-uppercase font-weight-bold mb-1">Simpanan Pokok</div>
                <h3 class="font-weight-bold text-dark mb-0">Rp{{ number_format($pokok, 0, ',', '.') }}</h3>
                <small class="text-secondary d-block mt-2">Simpanan wajib pertama</small>
            </div>
        </div>
    </div>

    <!-- Wajib -->
    <div class="col-md-3 col-sm-6 mb-3">
        <div class="card h-100 border-0 shadow-sm card-emerald">
            <div class="card-body">
                <div class="text-xs text-muted text-uppercase font-weight-bold mb-1">Simpanan Wajib</div>
                <h3 class="font-weight-bold text-dark mb-0">Rp{{ number_format($wajib, 0, ',', '.') }}</h3>
                <small class="text-secondary d-block mt-2">Iuran bulanan anggota</small>
            </div>
        </div>
    </div>

    <!-- Sukarela -->
    <div class="col-md-3 col-sm-6 mb-3">
        <div class="card h-100 border-0 shadow-sm bg-light-emerald" style="border-top: 3px solid #10B981 !important;">
            <div class="card-body">
                <div class="text-xs text-muted text-uppercase font-weight-bold mb-1">Simpanan Sukarela</div>
                <h3 class="font-weight-bold text-emerald mb-0">Rp{{ number_format($sukarela_balance, 0, ',', '.') }}</h3>
                <small class="text-secondary d-block mt-2">Tersedia untuk belanja</small>
            </div>
        </div>
    </div>

    <!-- Total Net Balance -->
    <div class="col-md-3 col-sm-6 mb-3">
        <div class="card h-100 border-0 shadow-sm bg-emerald text-white">
            <div class="card-body">
                <div class="text-xs text-white-50 text-uppercase font-weight-bold mb-1">Total Saldo Bersih</div>
                <h3 class="font-weight-bold text-white mb-0">Rp{{ number_format($total_balance, 0, ',', '.') }}</h3>
                <small class="text-white-50 d-block mt-2">Akumulasi tabungan</small>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Active Loans -->
    <div class="col-lg-6 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-0 pt-4 pb-0">
                <h5 class="card-title font-weight-bold text-dark mb-0">
                    <i class="fas fa-landmark mr-2 text-danger"></i> Pinjaman Aktif
                </h5>
            </div>
            <div class="card-body">
                @if($loans->isEmpty())
                    <div class="text-center py-5">
                        <i class="fas fa-file-contract text-muted fa-3x mb-3"></i>
                        <p class="text-muted mb-0">Anda tidak memiliki pinjaman aktif saat ini.</p>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead>
                                <tr class="text-muted text-xs uppercase">
                                    <th>Jaminan</th>
                                    <th>Total Pinjam</th>
                                    <th>Harus Kembali</th>
                                    <th>Terbayar</th>
                                    <th>Sisa</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($loans as $loan)
                                    <tr>
                                        <td>
                                            <span class="font-weight-medium">{{ $loan->collateral->name ?? 'Tanpa Jaminan' }}</span>
                                        </td>
                                        <td>Rp{{ number_format($loan->amount, 0, ',', '.') }}</td>
                                        <td>Rp{{ number_format($loan->return_amount, 0, ',', '.') }}</td>
                                        <td class="text-emerald">Rp{{ number_format($loan->paid, 0, ',', '.') }}</td>
                                        <td class="text-danger font-weight-bold">
                                            Rp{{ number_format($loan->return_amount - $loan->paid, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Recent Orders -->
    <div class="col-lg-6 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-0 pt-4 pb-0 d-flex justify-content-between align-items-center">
                <h5 class="card-title font-weight-bold text-dark mb-0">
                    <i class="fas fa-shopping-bag mr-2 text-warning"></i> Transaksi Belanja Terakhir
                </h5>
                <a href="{{ route('member.orders.index') }}" class="text-emerald text-sm font-weight-medium">Lihat Semua <i class="fas fa-chevron-right ml-1"></i></a>
            </div>
            <div class="card-body">
                @if($orders->isEmpty())
                    <div class="text-center py-5">
                        <i class="fas fa-shopping-basket text-muted fa-3x mb-3"></i>
                        <p class="text-muted mb-0">Belum ada riwayat transaksi belanja.</p>
                        <a href="{{ route('member.products.index') }}" class="btn btn-emerald btn-sm mt-3">Mulai Belanja</a>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead>
                                <tr class="text-muted text-xs uppercase">
                                    <th>No. Invoice</th>
                                    <th>Metode Bayar</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $order)
                                    <tr>
                                        <td>
                                            <a href="{{ route('member.orders.show', $order->id) }}" class="font-weight-medium text-emerald">
                                                {{ $order->invoice_number }}
                                            </a>
                                        </td>
                                        <td>
                                            @if($order->payment_method === 'deposit_deduction')
                                                <span class="badge badge-info">Potong Saldo</span>
                                            @else
                                                <span class="badge badge-secondary">Tunai</span>
                                            @endif
                                        </td>
                                        <td class="font-weight-bold">Rp{{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                        <td>
                                            @if($order->order_status === 'completed')
                                                <span class="badge badge-success">Selesai</span>
                                            @elseif($order->order_status === 'processing')
                                                <span class="badge badge-warning">Diproses</span>
                                            @elseif($order->order_status === 'cancelled')
                                                <span class="badge badge-danger">Dibatalkan</span>
                                            @else
                                                <span class="badge badge-secondary">Pending</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

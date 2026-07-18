@extends('layouts.member')

@section('title', 'Detail Pesanan & Invoice')

@section('content')
<div class="mb-3 d-flex justify-content-between align-items-center">
    <a href="{{ route('member.orders.index') }}" class="text-emerald font-weight-medium">
        <i class="fas fa-arrow-left mr-2"></i> Kembali ke Riwayat Pesanan
    </a>
    <button onclick="window.print();" class="btn btn-outline-secondary btn-sm px-3" style="border-radius: 8px;">
        <i class="fas fa-print mr-2"></i> Cetak Invoice
    </button>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 10px;">
        <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

<div class="card border-0 shadow-sm overflow-hidden" id="print-area">
    <div class="card-body p-5">
        <!-- Invoice Header -->
        <div class="row align-items-center mb-5">
            <div class="col-md-6 mb-4 mb-md-0">
                <div class="d-flex align-items-center">
                    <img src="{{ asset('logo.jpg') }}" alt="Logo" class="rounded mr-3" style="width: 60px; height: 60px;">
                    <div>
                        <h4 class="font-weight-bold text-dark mb-0">Koperasi Kosunu</h4>
                        <small class="text-secondary">Ekosistem Digital Simpan Pinjam & Marketplace</small>
                    </div>
                </div>
            </div>
            <div class="col-md-6 text-md-right">
                <h2 class="font-weight-bold text-emerald mb-1" style="font-size: 2.2rem; letter-spacing: -0.02em;">INVOICE</h2>
                <span class="text-secondary font-weight-medium">No: {{ $order->invoice_number }}</span>
            </div>
        </div>

        <hr class="mb-5" style="border-color: #f1f5f9;">

        <!-- Invoice Info -->
        <div class="row mb-5">
            <div class="col-md-6 mb-4 mb-md-0">
                <h6 class="text-xs text-uppercase text-muted font-weight-bold mb-3">Ditujukan Kepada:</h6>
                <h5 class="font-weight-bold text-dark mb-1">{{ $order->customer->name }}</h5>
                <p class="text-secondary text-sm mb-1">ID Anggota: {{ $order->customer->number }}</p>
                <p class="text-secondary text-sm mb-1">Telepon: {{ $order->customer->phone }}</p>
                <p class="text-secondary text-sm mb-0">Alamat: {{ $order->customer->address }}</p>
            </div>
            
            <div class="col-md-6 text-md-right">
                <h6 class="text-xs text-uppercase text-muted font-weight-bold mb-3">Informasi Pembayaran:</h6>
                <p class="text-secondary text-sm mb-1">
                    Tanggal Order: <strong>{{ \Carbon\Carbon::parse($order->order_date)->isoFormat('D MMMM Y, HH:mm') }} WIB</strong>
                </p>
                <p class="text-secondary text-sm mb-1">
                    Metode Pembayaran: 
                    @if($order->payment_method === 'deposit_deduction')
                        <strong class="text-emerald">Potong Saldo Simpanan</strong>
                    @else
                        <strong>Tunai / Cash</strong>
                    @endif
                </p>
                <p class="text-secondary text-sm mb-1">
                    Status Bayar: 
                    @if($order->payment_status === 'paid')
                        <span class="badge badge-success font-weight-medium px-2">Lunas / Terbayar</span>
                    @elseif($order->payment_status === 'failed')
                        <span class="badge badge-danger font-weight-medium px-2">Gagal</span>
                    @else
                        <span class="badge badge-warning font-weight-medium px-2">Belum Terbayar</span>
                    @endif
                </p>
                <p class="text-secondary text-sm mb-1">
                    Pengambilan Barang: 
                    @if($order->shipping_method === 'delivery')
                        <span class="badge badge-primary px-2"><i class="fas fa-truck mr-1"></i> Kirim ke Rumah</span>
                    @else
                        <span class="badge badge-secondary px-2"><i class="fas fa-store mr-1"></i> Ambil di Kantor</span>
                    @endif
                </p>
                @if($order->shipping_method === 'delivery')
                    <p class="text-secondary text-sm mb-0">
                        Alamat Kirim: <strong class="text-dark">{{ $order->shipping_address }}</strong>
                    </p>
                @endif
            </div>
        </div>

        <!-- Table Items -->
        <h6 class="text-xs text-uppercase text-muted font-weight-bold mb-3">Rincian Belanja</h6>
        <div class="table-responsive mb-5">
            <table class="table align-middle">
                <thead>
                    <tr class="text-muted text-xs uppercase bg-light">
                        <th class="border-0 pl-3">Produk</th>
                        <th class="border-0 text-center" style="width: 150px;">Harga Satuan</th>
                        <th class="border-0 text-center" style="width: 100px;">Jumlah</th>
                        <th class="border-0 text-right pr-3" style="width: 200px;">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                        <tr>
                            <td class="pl-3 align-middle">
                                <span class="font-weight-bold text-dark">{{ $item->product->name }}</span>
                                <small class="text-muted d-block">{{ $item->product->category->name }}</small>
                            </td>
                            <td class="text-center align-middle">
                                Rp{{ number_format($item->price, 0, ',', '.') }}
                            </td>
                            <td class="text-center align-middle font-weight-bold text-dark">
                                {{ $item->quantity }}
                            </td>
                            <td class="text-right pr-3 align-middle font-weight-bold text-dark">
                                Rp{{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Invoice Footer Summary -->
        <div class="row justify-content-end mb-4">
            <div class="col-md-5">
                <div class="p-3 bg-light rounded" style="border: 1px solid #f1f5f9;">
                    <div class="d-flex justify-content-between mb-2 text-secondary text-sm">
                        <span>Subtotal Belanja</span>
                        <span>Rp{{ number_format($order->total_amount, 0, ',', '.') }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2 text-secondary text-sm">
                        <span>Ongkos Kirim / Admin</span>
                        <span>Rp0</span>
                    </div>
                    <div class="dropdown-divider mb-3"></div>
                    <div class="d-flex justify-content-between">
                        <strong class="text-dark">Total Pembayaran</strong>
                        <strong class="text-emerald" style="font-size: 1.25rem;">
                            Rp{{ number_format($order->total_amount, 0, ',', '.') }}
                        </strong>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center text-muted text-xs mt-5">
            <p class="mb-1">Terima kasih telah berbelanja dan berkontribusi memajukan perekonomian Koperasi Kosunu.</p>
            <p class="mb-0">Dokumen ini sah dikeluarkan secara sistem dan tidak memerlukan tanda tangan basah.</p>
        </div>
    </div>
</div>

<style>
    @media print {
        body {
            background: white !important;
            font-size: 12px;
        }
        .main-header, .main-sidebar, .main-footer, .mb-3 {
            display: none !important;
        }
        .content-wrapper {
            margin-left: 0 !important;
            padding: 0 !important;
            margin-top: 0 !important;
        }
        .card {
            border: none !important;
            box-shadow: none !important;
        }
        #print-area {
            padding: 0 !important;
        }
    }
</style>
@endsection

@extends('layouts.member')

@section('title', 'Riwayat Pesanan Belanja')

@section('content')
<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        @if($orders->isEmpty())
            <div class="text-center py-5">
                <i class="fas fa-shopping-bag text-muted fa-4x mb-3"></i>
                <h5 class="font-weight-bold text-dark">Belum Ada Riwayat Belanja</h5>
                <p class="text-secondary mb-0">Silakan kunjungi marketplace koperasi untuk berbelanja produk berkualitas.</p>
                <a href="{{ route('member.products.index') }}" class="btn btn-emerald mt-3 px-4">Belanja Sekarang</a>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr class="text-muted text-xs uppercase bg-light">
                            <th class="border-0 pl-4">Tanggal Pesanan</th>
                            <th class="border-0">No. Invoice</th>
                            <th class="border-0">Metode Pembayaran</th>
                            <th class="border-0 text-right">Total Tagihan</th>
                            <th class="border-0 text-center">Status Pembayaran</th>
                            <th class="border-0 text-center">Status Pesanan</th>
                            <th class="border-0 pr-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                            <tr>
                                <td class="pl-4 align-middle">
                                    {{ \Carbon\Carbon::parse($order->order_date)->isoFormat('D MMMM Y, HH:mm') }} WIB
                                </td>
                                <td class="align-middle font-weight-bold text-dark">
                                    {{ $order->invoice_number }}
                                </td>
                                <td class="align-middle">
                                    @if($order->payment_method === 'deposit_deduction')
                                        <span class="badge bg-light-emerald text-emerald px-2 py-1"><i class="fas fa-wallet mr-1"></i> Potong Saldo</span>
                                    @else
                                        <span class="badge badge-secondary px-2 py-1"><i class="fas fa-money-bill mr-1"></i> Tunai / Cash</span>
                                    @endif
                                </td>
                                <td class="align-middle text-right font-weight-bold text-dark">
                                    Rp{{ number_format($order->total_amount, 0, ',', '.') }}
                                </td>
                                <td class="align-middle text-center">
                                    @if($order->payment_status === 'paid')
                                        <span class="badge badge-success px-2 py-1">Lunas</span>
                                    @elseif($order->payment_status === 'failed')
                                        <span class="badge badge-danger px-2 py-1">Gagal</span>
                                    @else
                                        <span class="badge badge-warning px-2 py-1">Belum Bayar</span>
                                    @endif
                                </td>
                                <td class="align-middle text-center">
                                    @if($order->order_status === 'completed')
                                        <span class="badge badge-success">Selesai</span>
                                    @elseif($order->order_status === 'processing')
                                        <span class="badge badge-warning">Diproses</span>
                                    @elseif($order->order_status === 'cancelled')
                                        <span class="badge badge-danger">Batal</span>
                                    @else
                                        <span class="badge badge-secondary">Pending</span>
                                    @endif
                                </td>
                                <td class="align-middle pr-4 text-center">
                                    <a href="{{ route('member.orders.show', $order->id) }}" class="btn btn-emerald btn-sm px-3" style="border-radius: 8px;">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            @if($orders->hasPages())
                <div class="card-footer bg-white border-0 pt-4">
                    <div class="d-flex justify-content-center">
                        {{ $orders->links() }}
                    </div>
                </div>
            @endif
        @endif
    </div>
</div>
@endsection

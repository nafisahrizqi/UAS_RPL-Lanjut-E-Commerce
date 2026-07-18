@extends('layouts.member')

@section('title', 'Konfirmasi Checkout')

@section('content')
<div class="row">
    <!-- Order Summary & Delivery Details -->
    <div class="col-lg-8 mb-4">
        <!-- Delivery info -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white border-0 pt-4 pb-0">
                <h5 class="font-weight-bold text-dark mb-0"><i class="fas fa-map-marker-alt text-emerald mr-2"></i> Informasi Pengiriman</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <span class="text-xs text-muted d-block mb-1">Nama Anggota</span>
                        <strong class="text-dark">{{ $customer->name }} ({{ $customer->number }})</strong>
                    </div>
                    <div class="col-md-6">
                        <span class="text-xs text-muted d-block mb-1">No. Telepon</span>
                        <strong class="text-dark">{{ $customer->phone }}</strong>
                    </div>
                    <div class="col-12 mt-3">
                        <span class="text-xs text-muted d-block mb-1">Alamat Lengkap</span>
                        <p class="text-secondary mb-0">{{ $customer->address }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Items list -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 pt-4 pb-0">
                <h5 class="font-weight-bold text-dark mb-0"><i class="fas fa-shopping-basket text-emerald mr-2"></i> Rincian Barang</h5>
            </div>
            <div class="card-body p-0 mt-3">
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead>
                            <tr class="text-muted text-xs uppercase bg-light">
                                <th class="border-0 pl-4">Produk</th>
                                <th class="border-0 text-center">Jumlah</th>
                                <th class="border-0 text-right pr-4">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cart as $id => $details)
                                <tr>
                                    <td class="pl-4">
                                        <div class="font-weight-bold text-dark">{{ $details['name'] }}</div>
                                        <small class="text-muted">Rp{{ number_format($details['price'], 0, ',', '.') }} / unit</small>
                                    </td>
                                    <td class="text-center align-middle">{{ $details['quantity'] }}</td>
                                    <td class="text-right pr-4 align-middle font-weight-bold">
                                        Rp{{ number_format($details['price'] * $details['quantity'], 0, ',', '.') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment & Checkout -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <form action="{{ route('member.checkout.store') }}" method="POST" id="checkout-form">
                    @csrf

                    <h5 class="font-weight-bold text-dark mb-3">Metode Pengambilan</h5>
                    
                    <!-- Shipping Methods Radio Group -->
                    <div class="mb-4">
                        <!-- Ambil Sendiri -->
                        <div class="custom-control custom-radio p-3 rounded mb-3 border border-emerald bg-light-emerald" style="cursor: pointer;" id="shipping-method-pickup-wrapper">
                            <input type="radio" id="shipping_method_pickup" name="shipping_method" value="pickup" class="custom-control-input" checked>
                            <label class="custom-control-label w-100" for="shipping_method_pickup" style="cursor: pointer;">
                                <div class="font-weight-bold text-dark mb-1">Ambil di Kantor Koperasi</div>
                                <div class="text-xs text-secondary">
                                    Ambil langsung ke kantor koperasi (Gratis).
                                </div>
                            </label>
                        </div>

                        <!-- Kirim ke Rumah -->
                        <div class="custom-control custom-radio p-3 rounded border border-light" style="cursor: pointer;" id="shipping-method-delivery-wrapper">
                            <input type="radio" id="shipping_method_delivery" name="shipping_method" value="delivery" class="custom-control-input">
                            <label class="custom-control-label w-100" for="shipping_method_delivery" style="cursor: pointer;">
                                <div class="font-weight-bold text-dark mb-1">Kirim ke Rumah</div>
                                <div class="text-xs text-secondary">
                                    Diantar oleh petugas kurir/kolektor koperasi.
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Delivery Address Input -->
                    <div class="mb-4 d-none" id="shipping-address-container">
                        <label for="shipping_address" class="font-weight-bold text-xs text-muted mb-2 uppercase">Alamat Pengiriman</label>
                        <textarea name="shipping_address" id="shipping_address" class="form-control" rows="3" placeholder="Masukkan alamat lengkap pengiriman">{{ $customer->address }}</textarea>
                    </div>

                    <div class="dropdown-divider mb-4"></div>

                    <h5 class="font-weight-bold text-dark mb-3">Metode Pembayaran</h5>
                    
                    <!-- Payment Methods Radio Group -->
                    <div class="mb-4">
                        <!-- Potong Saldo Simpanan -->
                        <div class="custom-control custom-radio p-3 rounded mb-3 border {{ $sukarela_balance >= $total ? 'border-emerald bg-light-emerald' : 'border-light bg-light text-muted' }}" style="cursor: pointer;" id="payment-method-deposit-wrapper">
                            <input type="radio" id="payment_method_deposit" name="payment_method" value="deposit_deduction" class="custom-control-input" {{ $sukarela_balance >= $total ? 'checked' : 'disabled' }}>
                            <label class="custom-control-label w-100" for="payment_method_deposit" style="cursor: pointer;">
                                <div class="font-weight-bold text-dark mb-1">Potong Saldo Simpanan</div>
                                <div class="text-xs {{ $sukarela_balance >= $total ? 'text-emerald' : 'text-danger' }}">
                                    Saldo Sukarela: <strong>Rp{{ number_format($sukarela_balance, 0, ',', '.') }}</strong>
                                </div>
                                @if($sukarela_balance < $total)
                                    <div class="text-xs text-danger font-weight-bold mt-1">
                                        <i class="fas fa-exclamation-circle mr-1"></i> Saldo simpanan tidak mencukupi
                                    </div>
                                @endif
                            </label>
                        </div>

                        <!-- Cash / Bayar Tunai -->
                        <div class="custom-control custom-radio p-3 rounded border border-light" style="cursor: pointer;" id="payment-method-cash-wrapper">
                            <input type="radio" id="payment_method_cash" name="payment_method" value="cash" class="custom-control-input" {{ $sukarela_balance < $total ? 'checked' : '' }}>
                            <label class="custom-control-label w-100" for="payment_method_cash" style="cursor: pointer;">
                                <div class="font-weight-bold text-dark mb-1">Bayar Tunai di Koperasi</div>
                                <div class="text-xs text-secondary">
                                    Bayar cash di loker teller kosunu
                                </div>
                            </label>
                        </div>
                    </div>

                    <div class="dropdown-divider mb-4"></div>

                    <!-- Checkout Summary -->
                    <div class="d-flex justify-content-between mb-4">
                        <span class="font-weight-bold text-dark">Total Pembayaran</span>
                        <span class="font-weight-bold text-emerald" style="font-size: 1.35rem;">
                            Rp{{ number_format($total, 0, ',', '.') }}
                        </span>
                    </div>

                    <button type="submit" class="btn btn-emerald btn-lg btn-block shadow-sm" id="btn-submit-checkout">
                        Proses Checkout
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    $(document).ready(function() {
        // Toggle active border styles for shipping wrappers
        $('input[name="shipping_method"]').on('change', function() {
            if ($(this).val() === 'delivery') {
                $('#shipping-method-delivery-wrapper').addClass('border-emerald bg-light-emerald').removeClass('border-light');
                $('#shipping-method-pickup-wrapper').removeClass('border-emerald bg-light-emerald').addClass('border-light');
                $('#shipping-address-container').removeClass('d-none');
            } else {
                $('#shipping-method-pickup-wrapper').addClass('border-emerald bg-light-emerald').removeClass('border-light');
                $('#shipping-method-delivery-wrapper').removeClass('border-emerald bg-light-emerald').addClass('border-light');
                $('#shipping-address-container').addClass('d-none');
            }
        });

        // Add visual clicks to shipping wrappers
        $('#shipping-method-pickup-wrapper').on('click', function() {
            $('#shipping_method_pickup').prop('checked', true).trigger('change');
        });

        $('#shipping-method-delivery-wrapper').on('click', function() {
            $('#shipping_method_delivery').prop('checked', true).trigger('change');
        });

        // Toggle active border styles for radio wrappers
        $('input[name="payment_method"]').on('change', function() {
            if ($(this).val() === 'deposit_deduction') {
                $('#payment-method-deposit-wrapper').addClass('border-emerald bg-light-emerald');
                $('#payment-method-cash-wrapper').removeClass('border-emerald bg-light-emerald').addClass('border-light');
            } else {
                $('#payment-method-cash-wrapper').addClass('border-emerald bg-light-emerald');
                $('#payment-method-deposit-wrapper').removeClass('border-emerald bg-light-emerald').addClass('border-light');
            }
        });

        // Add visual clicks to wrappers
        $('#payment-method-deposit-wrapper').on('click', function() {
            var radio = $('#payment_method_deposit');
            if (!radio.is(':disabled')) {
                radio.prop('checked', true).trigger('change');
            }
        });

        // Add visual clicks to cash wrapper
        $('#payment-method-cash-wrapper').on('click', function() {
            $('#payment_method_cash').prop('checked', true).trigger('change');
        });

        $('#checkout-form').on('submit', function() {
            $('#btn-submit-checkout').prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-2"></i> Memproses...');
        });
    });
</script>
@endpush

@extends('layouts.member')

@section('title', 'Detail Produk')

@section('content')
<div class="mb-3">
    <a href="{{ route('member.products.index') }}" class="text-emerald font-weight-medium">
        <i class="fas fa-arrow-left mr-2"></i> Kembali ke Katalog
    </a>
</div>

<div class="card border-0 shadow-sm overflow-hidden">
    <div class="card-body p-4">
        <div class="row">
            <!-- Product Image -->
            <div class="col-md-6 mb-4 mb-md-0">
                <div class="rounded-lg overflow-hidden position-relative" style="height: 350px; background-color: #f8fafc; border: 1px solid #f1f5f9;">
                    @if($product->image)
                        <div style="background-image: url('{{ asset($product->image) }}'); background-size: cover; background-position: center; height: 100%;"></div>
                    @else
                        <div class="d-flex align-items-center justify-content-center h-100 bg-light text-muted">
                            <i class="fas fa-image fa-4x"></i>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Product Details -->
            <div class="col-md-6">
                <span class="badge badge-emerald badge-pill px-3 py-1 mb-2 font-weight-medium">
                    {{ $product->category->name }}
                </span>
                <h2 class="font-weight-bold text-dark mb-2">{{ $product->name }}</h2>
                
                <div class="d-flex align-items-center mb-3">
                    <span class="text-muted text-sm mr-3">Stok Tersedia:</span>
                    <span class="badge {{ $product->stock > 0 ? 'badge-success' : 'badge-danger' }} font-weight-normal px-2">
                        {{ $product->stock }} Unit
                    </span>
                </div>

                <div class="p-3 bg-light rounded mb-4">
                    <div class="text-xs text-muted">Harga Khusus Anggota Koperasi</div>
                    <div class="font-weight-bold text-emerald" style="font-size: 2rem; line-height: 1.2;">
                        Rp{{ number_format($product->price, 0, ',', '.') }}
                    </div>
                </div>

                <h5 class="font-weight-bold text-dark mb-2">Deskripsi Produk</h5>
                <p class="text-secondary mb-4" style="line-height: 1.6;">
                    {{ $product->description ?: 'Tidak ada deskripsi produk.' }}
                </p>

                @if($product->stock > 0)
                    <form action="{{ route('member.cart.add') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        
                        <div class="row align-items-center">
                            <div class="col-md-4 mb-3 mb-md-0">
                                <label for="quantity" class="text-xs text-muted font-weight-bold text-uppercase d-block mb-1">Jumlah</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <button type="button" class="btn btn-outline-secondary px-3" id="qty-minus" style="border-radius: 8px 0 0 8px;">-</button>
                                    </div>
                                    <input type="number" name="quantity" id="quantity" class="form-control text-center font-weight-bold" value="1" min="1" max="{{ $product->stock }}" style="border-color: #ced4da;" readonly>
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-outline-secondary px-3" id="qty-plus" style="border-radius: 0 8px 8px 0;">+</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <label class="d-none d-md-block" style="visibility: hidden;">Spacer</label>
                                <button type="submit" class="btn btn-emerald btn-lg btn-block" style="border-radius: 8px;">
                                    <i class="fas fa-shopping-cart mr-2"></i> Tambahkan Ke Keranjang
                                </button>
                            </div>
                        </div>
                    </form>
                @else
                    <div class="alert alert-danger" role="alert" style="border-radius: 8px;">
                        Maaf, stok produk ini sedang kosong. Silakan cek kembali nanti.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
    $(document).ready(function() {
        var maxStock = {{ $product->stock }};
        
        $('#qty-minus').on('click', function() {
            var qty = parseInt($('#quantity').val());
            if (qty > 1) {
                $('#quantity').val(qty - 1);
            }
        });

        $('#qty-plus').on('click', function() {
            var qty = parseInt($('#quantity').val());
            if (qty < maxStock) {
                $('#quantity').val(qty + 1);
            }
        });
    });
</script>
@endpush

@extends('layouts.member')

@section('title', 'Katalog Marketplace')

@section('content')
<div class="row">
    <!-- Category Filter Sidebar -->
    <div class="col-md-3 mb-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 pt-4 pb-2">
                <h5 class="font-weight-bold text-dark mb-0"><i class="fas fa-filter text-emerald mr-2"></i> Kategori</h5>
            </div>
            <div class="card-body px-3 pt-2">
                <div class="list-group list-group-flush">
                    <a href="{{ route('member.products.index', request()->except('category')) }}" 
                       class="list-group-item list-group-item-action border-0 px-2 py-2 rounded mb-1 {{ !request('category') ? 'active bg-emerald text-white' : 'text-secondary' }}">
                        Semua Produk
                    </a>
                    @foreach($categories as $category)
                        <a href="{{ route('member.products.index', array_merge(request()->query(), ['category' => $category->slug])) }}" 
                           class="list-group-item list-group-item-action border-0 px-2 py-2 rounded mb-1 {{ request('category') === $category->slug ? 'active bg-emerald text-white' : 'text-secondary' }}">
                            {{ $category->name }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Product Grid & Search -->
    <div class="col-md-9">
        <!-- Search Bar -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body py-3">
                <form action="{{ route('member.products.index') }}" method="GET" class="row align-items-center">
                    @if(request('category'))
                        <input type="hidden" name="category" value="{{ request('category') }}">
                    @endif
                    <div class="col-md-9 mb-2 mb-md-0">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-light border-0"><i class="fas fa-search text-muted"></i></span>
                            </div>
                            <input type="text" name="search" class="form-control bg-light border-0" value="{{ request('search') }}" placeholder="Cari nama produk unggulan koperasi...">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-emerald btn-block">Cari Produk</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Product Grid -->
        @if($products->isEmpty())
            <div class="card border-0 shadow-sm text-center py-5">
                <div class="card-body">
                    <i class="fas fa-box-open text-muted fa-4x mb-3"></i>
                    <h5 class="font-weight-bold text-dark">Produk Tidak Ditemukan</h5>
                    <p class="text-secondary mb-0">Silakan cari kata kunci lain atau bersihkan filter pencarian.</p>
                    <a href="{{ route('member.products.index') }}" class="btn btn-emerald mt-3">Reset Pencarian</a>
                </div>
            </div>
        @else
            <div class="row">
                @foreach($products as $product)
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card h-100 border-0 shadow-sm overflow-hidden" style="transition: transform 0.2s ease-in-out;">
                            <div class="position-relative" style="height: 180px; background-color: #f8fafc;">
                                @if($product->image)
                                    <div style="background-image: url('{{ asset($product->image) }}'); background-size: cover; background-position: center; height: 100%;"></div>
                                @else
                                    <div class="d-flex align-items-center justify-content-center h-100 bg-light text-muted">
                                        <i class="fas fa-image fa-3x"></i>
                                    </div>
                                @endif
                                <span class="badge badge-emerald position-absolute px-2 py-1" style="top: 10px; left: 10px; font-weight: 500;">
                                    {{ $product->category->name }}
                                </span>
                            </div>
                            <div class="card-body d-flex flex-column p-3">
                                <h6 class="font-weight-bold text-dark mb-1 text-truncate" title="{{ $product->name }}">
                                    {{ $product->name }}
                                </h6>
                                <p class="text-xs text-muted mb-2 text-truncate-2" style="height: 32px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; white-space: normal;">
                                    {{ $product->description }}
                                </p>
                                <div class="mt-auto d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="text-xs text-muted">Harga Anggota</div>
                                        <div class="font-weight-bold text-emerald" style="font-size: 1.1rem;">
                                            Rp{{ number_format($product->price, 0, ',', '.') }}
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-xs text-muted">Stok</div>
                                        <span class="badge {{ $product->stock > 0 ? 'badge-success' : 'badge-danger' }} badge-pill font-weight-normal">
                                            {{ $product->stock }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer bg-white border-top-0 p-3">
                                <div class="row">
                                    <div class="col-6 pr-1">
                                        <a href="{{ route('member.products.show', $product->slug) }}" class="btn btn-outline-secondary btn-sm btn-block" style="border-radius: 8px;">Detail</a>
                                    </div>
                                    <div class="col-6 pl-1">
                                        <form action="{{ route('member.cart.add') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <input type="hidden" name="quantity" value="1">
                                            <button type="submit" class="btn btn-emerald btn-sm btn-block" {{ $product->stock <= 0 ? 'disabled' : '' }}>
                                                Beli
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $products->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

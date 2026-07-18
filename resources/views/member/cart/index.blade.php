@extends('layouts.member')

@section('title', 'Keranjang Belanja')

@section('content')
<div class="row">
    @if(empty($cart))
        <div class="col-md-12">
            <div class="card border-0 shadow-sm text-center py-5">
                <div class="card-body">
                    <i class="fas fa-shopping-cart text-muted fa-4x mb-3"></i>
                    <h4 class="font-weight-bold text-dark">Keranjang Belanja Kosong</h4>
                    <p class="text-secondary">Anda belum menambahkan produk apapun ke keranjang.</p>
                    <a href="{{ route('member.products.index') }}" class="btn btn-emerald mt-3 px-4">Mulai Belanja</a>
                </div>
            </div>
        </div>
    @else
        <!-- Cart Table -->
        <div class="col-lg-8 mb-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0" id="cart-table">
                            <thead>
                                <tr class="text-muted text-xs uppercase bg-light">
                                    <th class="border-0 pl-4">Produk</th>
                                    <th class="border-0">Harga</th>
                                    <th class="border-0 text-center" style="width: 150px;">Jumlah</th>
                                    <th class="border-0">Subtotal</th>
                                    <th class="border-0 pr-4">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cart as $id => $details)
                                    <tr data-id="{{ $id }}">
                                        <td class="pl-4">
                                            <div class="d-flex align-items-center">
                                                @if(isset($details['image']) && $details['image'])
                                                    <div class="rounded mr-3" style="width: 60px; height: 60px; background-image: url('{{ asset($details['image']) }}'); background-size: cover; background-position: center; border: 1px solid #e2e8f0;"></div>
                                                @else
                                                    <div class="rounded mr-3 d-flex align-items-center justify-content-center bg-light text-muted" style="width: 60px; height: 60px; border: 1px solid #e2e8f0;">
                                                        <i class="fas fa-image"></i>
                                                    </div>
                                                @endif
                                                <div>
                                                    <a href="{{ route('member.products.show', $details['slug']) }}" class="font-weight-bold text-dark d-block">
                                                        {{ $details['name'] }}
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="align-middle">
                                            Rp{{ number_format($details['price'], 0, ',', '.') }}
                                        </td>
                                        <td class="align-middle text-center">
                                            <div class="input-group input-group-sm mx-auto" style="width: 110px;">
                                                <div class="input-group-prepend">
                                                    <button class="btn btn-outline-secondary btn-qty-minus px-2" type="button">-</button>
                                                </div>
                                                <input type="number" class="form-control text-center font-weight-bold cart-qty" value="{{ $details['quantity'] }}" min="1" readonly>
                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-secondary btn-qty-plus px-2" type="button">+</button>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="align-middle font-weight-bold text-dark subtotal-value">
                                            Rp{{ number_format($details['price'] * $details['quantity'], 0, ',', '.') }}
                                        </td>
                                        <td class="align-middle pr-4">
                                            <button class="btn btn-sm btn-outline-danger remove-from-cart" style="border-radius: 8px;">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Summary -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h5 class="font-weight-bold text-dark mb-4">Ringkasan Belanja</h5>
                    
                    <div class="d-flex justify-content-between mb-3 text-secondary">
                        <span>Total Barang</span>
                        <span class="font-weight-medium" id="total-qty">{{ array_sum(array_column($cart, 'quantity')) }} Barang</span>
                    </div>
                    
                    <div class="dropdown-divider mb-4"></div>
                    
                    <div class="d-flex justify-content-between mb-4">
                        <span class="font-weight-bold text-dark">Total Tagihan</span>
                        <span class="font-weight-bold text-emerald" style="font-size: 1.35rem;" id="cart-total">
                            Rp{{ number_format($total, 0, ',', '.') }}
                        </span>
                    </div>

                    <a href="{{ route('member.checkout.index') }}" class="btn btn-emerald btn-lg btn-block shadow-sm">
                        Lanjut ke Checkout <i class="fas fa-arrow-right ml-2 text-xs"></i>
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection

@push('script')
<script>
    $(document).ready(function() {
        // AJAX updates for cart quantity
        function updateCart(id, qty, row) {
            $.ajax({
                url: "{{ route('member.cart.update') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id,
                    quantity: qty
                },
                success: function(response) {
                    if (response.success) {
                        row.find('.subtotal-value').text('Rp' + response.subtotal);
                        $('#cart-total').text('Rp' + response.total);
                        notification('success', 'Keranjang berhasil diperbarui!');
                        
                        // Recalculate total quantity
                        var totalQty = 0;
                        $('.cart-qty').each(function() {
                            totalQty += parseInt($(this).val());
                        });
                        $('#total-qty').text(totalQty + ' Barang');
                    }
                },
                error: function(xhr) {
                    notification('error', xhr.responseJSON.error || 'Terjadi kesalahan saat memperbarui keranjang.');
                    // Restore previous value
                    location.reload();
                }
            });
        }

        $('.btn-qty-minus').on('click', function() {
            var row = $(this).closest('tr');
            var id = row.data('id');
            var input = row.find('.cart-qty');
            var qty = parseInt(input.val());
            if (qty > 1) {
                input.val(qty - 1);
                updateCart(id, qty - 1, row);
            }
        });

        $('.btn-qty-plus').on('click', function() {
            var row = $(this).closest('tr');
            var id = row.data('id');
            var input = row.find('.cart-qty');
            var qty = parseInt(input.val());
            input.val(qty + 1);
            updateCart(id, qty + 1, row);
        });

        // AJAX remove from cart
        $('.remove-from-cart').on('click', function() {
            var row = $(this).closest('tr');
            var id = row.data('id');

            Swal.fire({
                title: 'Hapus Barang',
                text: 'Apakah Anda yakin ingin menghapus produk ini dari keranjang belanja?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal',
                customClass: {
                    confirmButton: 'btn btn-danger px-4 mr-2',
                    cancelButton: 'btn btn-secondary px-4'
                },
                buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('member.cart.remove') }}",
                        method: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            id: id
                        },
                        success: function(response) {
                            if (response.success) {
                                row.fadeOut(300, function() {
                                    $(this).remove();
                                    if ($('#cart-table tbody tr').length === 0) {
                                        location.reload(); // Reload to show empty cart view
                                    } else {
                                        $('#cart-total').text('Rp' + response.total);
                                        // Recalculate total quantity
                                        var totalQty = 0;
                                        $('.cart-qty').each(function() {
                                            totalQty += parseInt($(this).val());
                                        });
                                        $('#total-qty').text(totalQty + ' Barang');
                                        notification('success', 'Produk dihapus dari keranjang!');
                                    }
                                });
                            }
                        }
                    });
                }
            });
        });
    });
</script>
@endpush

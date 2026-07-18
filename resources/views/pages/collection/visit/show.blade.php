@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label>Tanggal Kunjungan</label>
                                    <input type="text" class="form-control-plaintext"
                                        value="{{ $visit->created_at->isoFormat('D MMMM Y') }}" disabled>
                                </div>
                                <div class="form-group">
                                    <label>Nasabah</label>
                                    <input type="text" class="form-control-plaintext"
                                        value="{{ $visit->customer->number . ' - ' . $visit->customer->name }}"
                                        placeholder="Nasabah" disabled>
                                </div>
                                <div class="form-group">
                                    <label>Kode Transaksi Pinjaman</label>
                                    <input type="text" class="form-control-plaintext"
                                        value="PI-{{ sprintf('%05d', $visit->loan->id) }} (Rp{{ number_format($visit->loan->amount) }})"
                                        disabled>
                                </div>
                                <div class="form-group">
                                    <label>Sisa Pembayaran (Rp)</label>
                                    <input type="text" class="form-control-plaintext"
                                        value="Rp{{ number_format($visit->remaining_amount, 2, ',', '.') }}" disabled>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label>Kolektor</label>
                                    <input type="text" class="form-control-plaintext"
                                        value="{{ $visit->user->name }}"
                                        placeholder="Nasabah" disabled>
                                </div>
                                <div class="form-group">
                                    <label>Keterangan</label>
                                    <input type="text" class="form-control-plaintext"
                                        value="{{ $visit->description }}"
                                        placeholder="Keterangan" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-light">
                        <a href="{{ route('collection.visit.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left mr-1"></i> Kembali
                        </a>
                        <a href="{{ route('collection.visit.print_slip', $visit) }}" class="btn btn-success ml-2">
                            <i class="fas fa-file-pdf mr-1"></i> Cetak Slip Kunjungan
                        </a>
                    </div>
                </div>
            </div>
            <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
    <!-- /.content -->
@endsection

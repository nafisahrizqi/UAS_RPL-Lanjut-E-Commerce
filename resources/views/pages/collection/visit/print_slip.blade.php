@extends('layouts.pdf')

@section('header')
<table style="width: 100%; border-bottom: 1px dashed #ccc; padding-bottom: 10px; margin-bottom: 10px;">
    <tr>
        <td style="width: 25%" class="font-weight-bold">No. Slip:</td>
        <td style="width: 40%">SLIP-{{ sprintf('%05d', $visit->id) }}</td>
        <td style="width: 20%" class="font-weight-bold">Tanggal Kunjungan:</td>
        <td style="width: 15%; text-align: right">{{ \Carbon\Carbon::parse($visit->created_at)->isoFormat('DD-MM-Y') }}</td>
    </tr>
    <tr>
        <td class="font-weight-bold">Petugas Kolektor:</td>
        <td>{{ $visit->user->name }} ({{ '@' . $visit->user->username }})</td>
        <td></td>
        <td></td>
    </tr>
</table>
@endsection

@section('content')
<div class="card p-3" style="border: 1px solid #ddd; background-color: #fafafa; border-radius: 4px;">
    <h5 class="text-secondary mb-3 border-bottom pb-2">Rincian Hasil Kunjungan Lapangan</h5>
    <table class="table table-sm table-borderless">
        <tr>
            <td style="width: 30%; font-weight: bold;">Nama Nasabah</td>
            <td style="width: 5%;">:</td>
            <td>{{ $visit->customer->name }}</td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Nomor Rekening</td>
            <td>:</td>
            <td><code>{{ $visit->customer->number }}</code></td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Alamat Nasabah</td>
            <td>:</td>
            <td>{{ $visit->customer->address ?? '-' }}</td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Nomor Telepon</td>
            <td>:</td>
            <td>{{ $visit->customer->phone ?? '-' }}</td>
        </tr>
        <tr>
            <td colspan="3"><hr style="margin: 8px 0;"></td>
        </tr>
        <tr>
            <td style="font-weight: bold;">Kode & Jumlah Kredit</td>
            <td>:</td>
            <td>
                @if($visit->loan)
                    PI-{{ sprintf('%05d', $visit->loan->id) }} (Rp{{ number_format($visit->loan->amount, 0, ',', '.') }})
                @else
                    -
                @endif
            </td>
        </tr>
        <tr>
            <td style="font-weight: bold; color: #c0392b;">Sisa Tunggakan (Kewajiban)</td>
            <td>:</td>
            <td style="font-weight: bold; color: #c0392b; font-size: 1.1em;">
                Rp{{ number_format($visit->remaining_amount, 2, ',', '.') }}
            </td>
        </tr>
        <tr>
            <td style="font-weight: bold; vertical-align: top;">Keterangan / Hasil Kunjungan</td>
            <td style="vertical-align: top;">:</td>
            <td style="font-style: italic; background-color: #fff; border: 1px solid #eee; padding: 6px; border-radius: 4px;">
                "{{ $visit->description }}"
            </td>
        </tr>
    </table>
</div>

<div style="margin-top: 40px; text-align: center;">
    <table style="width: 100%;">
        <tr>
            <td style="width: 50%;">
                <span class="d-block" style="font-size: 0.9em;">Nasabah (Ybs),</span>
                <br><br><br><br>
                <span class="d-block font-weight-bold" style="text-decoration: underline;">{{ $visit->customer->name }}</span>
            </td>
            <td style="width: 50%;">
                <span class="d-block" style="font-size: 0.9em;">Petugas Kolektor,</span>
                <br><br><br><br>
                <span class="d-block font-weight-bold" style="text-decoration: underline;">{{ $visit->user->name }}</span>
            </td>
        </tr>
    </table>
</div>
@endsection

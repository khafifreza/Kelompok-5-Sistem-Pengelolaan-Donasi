@extends('layouts.admin')
@section('title', 'Laporan')

@section('content')
<div class="page-header-custom">
    <div>
        <div class="breadcrumb-custom">Laporan &amp; Statistik</div>
        <h1 class="page-title">Ringkasan Donasi</h1>
        <p class="page-subtitle">Rekapitulasi transaksi yang tersimpan di aplikasi.</p>
    </div>
</div>

<div class="stats-row" style="grid-template-columns: repeat(3, 1fr);">
    <div class="stat-card">
        <div class="stat-icon"><i class="bi bi-graph-up"></i></div>
        <div>
            <small>Total Donasi Berhasil</small>
            <strong>{{ \App\Models\Program::rupiah($stats['successful_amount']) }}</strong>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon"><i class="bi bi-hourglass-split"></i></div>
        <div>
            <small>Donasi Menunggu</small>
            <strong>{{ \App\Models\Program::rupiah($stats['pending_amount']) }}</strong>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon"><i class="bi bi-people"></i></div>
        <div>
            <small>Akun Donatur</small>
            <strong>{{ $stats['donor_count'] }}</strong>
        </div>
    </div>
</div>

<div class="content-card mt-4">
    <div class="card-header-custom">
        <h5 class="card-title">Ringkasan 6 Bulan Terakhir</h5>
    </div>
    <div class="table-responsive">
        <table class="table admin-table">
            <thead>
                <tr>
                    <th>Periode</th>
                    <th>Donasi Berhasil</th>
                    <th>Menunggu</th>
                    <th>Jumlah Transaksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($monthlyReports as $report)
                    <tr>
                        <td><strong>{{ $report['period'] }}</strong></td>
                        <td>{{ \App\Models\Program::rupiah($report['success']) }}</td>
                        <td>{{ \App\Models\Program::rupiah($report['pending']) }}</td>
                        <td>{{ $report['transactions'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<p class="text-muted mt-3">Data penyaluran belum dapat dilaporkan karena pencatatan penyaluran belum tersedia di aplikasi.</p>
@endsection

@extends('layouts.admin')
@section('title', 'Laporan')

@section('content')
<div class="page-header-custom">
    <div>
        <div class="breadcrumb-custom">Laporan & Statistik</div>
        <h1 class="page-title">Laporan</h1>
        <p class="page-subtitle">Rekapitulasi keuangan dan dampak sosial untuk periode tertentu.</p>
    </div>
</div>

<!-- Summary Cards -->
<div class="stats-row" style="grid-template-columns: repeat(3, 1fr);">
    <div class="stat-card">
        <div class="stat-icon"><i class="bi bi-graph-up"></i></div>
        <div>
            <small>Total Donasi Masuk</small>
            <strong>Rp 284.600.000</strong>
            <span style="color: #28a745; font-size: 12px;">Tahun 2025</span>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon"><i class="bi bi-send-check"></i></div>
        <div>
            <small>Total Tersalurkan</small>
            <strong>Rp 216.200.000</strong>
            <span style="color: #28a745; font-size: 12px;">76% dari total</span>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon"><i class="bi bi-people"></i></div>
        <div>
            <small>Total Donatur</small>
            <strong>1.248</strong>
            <span style="color: #28a745; font-size: 12px;">+32 bulan ini</span>
        </div>
    </div>
</div>

<!-- Laporan Cards -->
<div class="row g-4">
    <div class="col-md-4">
        <div class="laporan-card">
            <div class="laporan-icon"><i class="bi bi-calendar-month"></i></div>
            <h4>Laporan Bulanan</h4>
            <p>Rekap donasi dan penyaluran per bulan.</p>
            <a href="#" class="btn-laporan">
                Unduh PDF <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    </div>
    <div class="col-md-4">
        <div class="laporan-card">
            <div class="laporan-icon"><i class="bi bi-calendar-year"></i></div>
            <h4>Laporan Tahunan</h4>
            <p>Ringkasan keuangan dan dampak satu tahun penuh.</p>
            <a href="#" class="btn-laporan">
                Unduh PDF <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    </div>
    <div class="col-md-4">
        <div class="laporan-card">
            <div class="laporan-icon"><i class="bi bi-bar-chart-line"></i></div>
            <h4>Laporan Dampak</h4>
            <p>Statistik penerima manfaat dan cerita sukses.</p>
            <a href="#" class="btn-laporan">
                Unduh PDF <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    </div>
</div>

<!-- Tabel Ringkasan -->
<div class="content-card mt-4">
    <div class="card-header-custom">
        <h5 class="card-title">Ringkasan 6 Bulan Terakhir</h5>
    </div>
    <div class="table-responsive">
        <table class="table admin-table">
            <thead>
                <tr>
                    <th>Periode</th>
                    <th>Donasi Masuk</th>
                    <th>Tersalurkan</th>
                    <th>Sisa Dana</th>
                    <th>Jumlah Donatur</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><strong>Juni 2025</strong></td>
                    <td>Rp 45.000.000</td>
                    <td>Rp 38.000.000</td>
                    <td>Rp 7.000.000</td>
                    <td>124</td>
                </tr>
                <tr>
                    <td><strong>Mei 2025</strong></td>
                    <td>Rp 52.000.000</td>
                    <td>Rp 48.000.000</td>
                    <td>Rp 4.000.000</td>
                    <td>138</td>
                </tr>
                <tr>
                    <td><strong>April 2025</strong></td>
                    <td>Rp 41.000.000</td>
                    <td>Rp 39.000.000</td>
                    <td>Rp 2.000.000</td>
                    <td>112</td>
                </tr>
                <tr>
                    <td><strong>Maret 2025</strong></td>
                    <td>Rp 48.000.000</td>
                    <td>Rp 42.000.000</td>
                    <td>Rp 6.000.000</td>
                    <td>125</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
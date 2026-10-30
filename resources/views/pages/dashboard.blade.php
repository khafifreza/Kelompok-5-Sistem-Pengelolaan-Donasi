@extends('layouts.dashboard')
@section('title', 'Donatur')
@section('content')
<section class="dashboard-section">
    <div class="wrap">
        <div class="dashboard-header">
            <div>
                <div class="eyebrow">DONATUR</div>
                <h1>Halo, Andi</h1>
                <p>Terima kasih sudah menjadi bagian dari perjalanan kebaikan ini.</p>
            </div>
            <button class="btn btn-primary" onclick="openModal('donasiModal')">Donasi Lagi <i class="bi bi-heart-fill"></i></button>
        </div>
        <div class="stats-row">
            <div class="stat-card">
                <div class="stat-icon"><i class="bi bi-wallet2"></i></div>
                <div><small>Total Donasi Saya</small><strong>Rp 4.750.000</strong><span>7 transaksi berhasil</span></div>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><i class="bi bi-people"></i></div>
                <div><small>Estimasi Dampak</small><strong>32 penerima</strong><span>Dari 4 program berbeda</span></div>
            </div>
            <div class="stat-card quote-card">
                <i class="bi bi-heart"></i>
                <p>"Kebaikan sekecil apa pun selalu punya tempat untuk tumbuh."</p>
            </div>
        </div>
        <div class="history-section">
            <div class="history-header">
                <div><h2>Riwayat Donasi Saya</h2><p>Semua kontribusi dan status pembayarannu.</p></div>
                <select class="status-filter"><option>Semua Status</option><option>Berhasil</option><option>Pending</option></select>
            </div>
            <div class="table-wrapper">
                <table>
                    <thead><tr><th>TANGGAL</th><th>PROGRAM</th><th>NOMINAL</th><th>STATUS</th></tr></thead>
                    <tbody>
                        @foreach($donations as $d)
                        <tr>
                            <td>{{ $d['date'] }}</td>
                            <td>{{ $d['program'] }}</td>
                            <td>{{ $d['amount'] }}</td>
                            <td><span class="status-badge {{ strtolower($d['status']) }}">{{ $d['status'] }}</span></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection
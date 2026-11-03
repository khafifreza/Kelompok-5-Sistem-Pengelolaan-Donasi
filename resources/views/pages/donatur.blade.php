@extends('layouts.donatur')
@section('title', 'Donatur')
@section('content')
<section class="dashboard-section">
    <div class="wrap">
        <div class="dashboard-header">
            <div>
                <div class="eyebrow">DONATUR</div>
                <h1>Halo, {{ auth()->user()->name }}</h1>
                <p>Terima kasih sudah menjadi bagian dari perjalanan kebaikan ini.</p>
            </div>
            <a class="btn btn-primary" href="{{ route('program.index') }}">Donasi Lagi <i class="bi bi-heart-fill"></i></a>
        </div>
        <div class="stats-row">
            <div class="stat-card">
                <div class="stat-icon"><i class="bi bi-wallet2"></i></div>
                <div><small>Total Donasi Saya</small><strong>{{ \App\Models\Program::rupiah($summary['total_amount']) }}</strong><span>{{ $summary['successful_count'] }} transaksi berhasil</span></div>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><i class="bi bi-people"></i></div>
                <div><small>Program Didukung</small><strong>{{ $summary['program_count'] }} program</strong><span>Dari donasi yang berhasil</span></div>
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
                        @forelse($donations as $d)
                        <tr>
                            <td>{{ $d['date'] }}</td>
                            <td>{{ $d['program'] }}</td>
                            <td>{{ $d['amount'] }}</td>
                            <td><span class="status-badge {{ strtolower($d['status']) }}">{{ $d['status'] }}</span></td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="text-center">Belum ada riwayat donasi.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection
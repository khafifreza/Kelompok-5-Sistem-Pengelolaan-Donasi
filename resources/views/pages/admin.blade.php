@extends('layouts.admin')
@section('title', 'Dashboard Admin')

@section('content')
<div class="stats-row" style="grid-template-columns: repeat(4, 1fr);">
    <div class="stat-card">
        <div class="stat-icon"><i class="bi bi-wallet2"></i></div>
        <div>
            <small>Donasi Berhasil</small>
            <strong>{{ \App\Models\Program::rupiah($stats['total_raised']) }}</strong>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon"><i class="bi bi-hourglass-split"></i></div>
        <div>
            <small>Menunggu Konfirmasi</small>
            <strong>{{ $stats['pending_count'] }}</strong>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon"><i class="bi bi-grid"></i></div>
        <div>
            <small>Program Aktif</small>
            <strong>{{ $stats['active_program_count'] }}</strong>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon"><i class="bi bi-people"></i></div>
        <div>
            <small>Donatur Terdaftar</small>
            <strong>{{ $stats['donor_count'] }}</strong>
        </div>
    </div>
</div>

<div class="quick-actions">
    <a href="{{ route('admin.program') }}" class="quick-action-btn"><i class="bi bi-plus-circle"></i><span>Kelola Program</span></a>
    <a href="{{ route('admin.donasi') }}" class="quick-action-btn"><i class="bi bi-check-circle"></i><span>Konfirmasi Donasi</span></a>
    <a href="{{ route('admin.donatur') }}" class="quick-action-btn"><i class="bi bi-people"></i><span>Data Donatur</span></a>
    <a href="{{ route('admin.laporan') }}" class="quick-action-btn"><i class="bi bi-bar-chart"></i><span>Lihat Laporan</span></a>
</div>

<div class="row g-4">
    <div class="col-12">
        <div class="content-card">
            <div class="card-header-custom">
                <h5 class="card-title">Donasi Terbaru</h5>
                <a href="{{ route('admin.donasi') }}" class="btn btn-outline-custom btn-sm">Lihat Semua</a>
            </div>
            <div class="table-responsive">
                <table class="table admin-table">
                    <thead>
                        <tr>
                            <th>Nama Donatur</th>
                            <th>Program</th>
                            <th>Nominal</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentDonations as $donation)
                            <tr>
                                <td><strong>{{ $donation->display_name }}</strong></td>
                                <td>{{ $donation->program->title }}</td>
                                <td><strong>{{ \App\Models\Program::rupiah($donation->amount) }}</strong></td>
                                <td>{{ $donation->created_at->locale('id')->isoFormat('D MMM YYYY') }}</td>
                                <td>
                                    @if($donation->status === \App\Models\Donation::STATUS_SUCCESS)
                                        <span class="status-badge berhasil">Berhasil</span>
                                    @elseif($donation->status === \App\Models\Donation::STATUS_PENDING)
                                        <span class="status-badge pending">Menunggu</span>
                                    @else
                                        <span class="badge text-bg-danger">Gagal</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center">Belum ada transaksi donasi.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.admin')
@section('title', 'Donasi Masuk')

@section('content')
<div class="page-header-custom">
    <div>
        <div class="breadcrumb-custom">Manajemen Keuangan</div>
        <h1 class="page-title">Donasi Masuk</h1>
        <p class="page-subtitle">Cari transaksi dan konfirmasi status donasi yang masih menunggu.</p>
    </div>
</div>

<div class="tabs-custom">
    <a href="{{ route('admin.donasi') }}" class="tab-item active">Donasi Masuk</a>
    <a href="{{ route('admin.penyaluran') }}" class="tab-item">Penyaluran Bantuan</a>
</div>

<div class="content-card">
    <form method="GET" action="{{ route('admin.donasi') }}" class="card-header-custom">
        <div class="search-box">
            <i class="bi bi-search"></i>
            <input type="search" name="q" value="{{ $search }}" placeholder="Cari nama, email, invoice, atau program..." aria-label="Cari donasi">
        </div>
        <div class="filter-group">
            <select class="form-control-custom" name="status" aria-label="Filter status">
                <option value="">Semua Status</option>
                <option value="pending" @selected($status === 'pending')>Menunggu</option>
                <option value="success" @selected($status === 'success')>Berhasil</option>
                <option value="failed" @selected($status === 'failed')>Gagal</option>
            </select>
            <button type="submit" class="btn btn-outline-custom">Filter</button>
            @if($search !== '' || in_array($status, ['pending', 'success', 'failed'], true))
                <a class="btn btn-ghost" href="{{ route('admin.donasi') }}">Reset</a>
            @endif
        </div>
    </form>

    <div class="table-responsive">
        <table class="table admin-table">
            <thead>
                <tr>
                    <th>Invoice</th>
                    <th>Nama Donatur</th>
                    <th>Program</th>
                    <th>Nominal</th>
                    <th>Tanggal</th>
                    <th>Status &amp; Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($donations as $donation)
                    <tr>
                        <td>{{ $donation->invoice }}</td>
                        <td>
                            <strong>{{ $donation->donor_name }}</strong>
                            @if($donation->donor_email)
                                <small class="d-block text-muted">{{ $donation->donor_email }}</small>
                            @endif
                        </td>
                        <td>{{ $donation->program->title }}</td>
                        <td><strong>{{ \App\Models\Program::rupiah($donation->amount) }}</strong></td>
                        <td>{{ $donation->created_at->locale('id')->isoFormat('D MMM YYYY') }}</td>
                        <td>
                            @if($donation->status === \App\Models\Donation::STATUS_PENDING)
                                <div class="d-flex flex-wrap gap-2">
                                    <form method="POST" action="{{ route('admin.donations.update', $donation) }}">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="success">
                                        <button class="btn btn-primary btn-sm" type="submit">Konfirmasi</button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.donations.update', $donation) }}">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="failed">
                                        <button class="btn btn-outline-danger btn-sm" type="submit">Tandai gagal</button>
                                    </form>
                                </div>
                            @elseif($donation->status === \App\Models\Donation::STATUS_SUCCESS)
                                <span class="status-badge berhasil">Berhasil</span>
                            @else
                                <span class="badge text-bg-danger">Gagal</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center">Belum ada transaksi yang cocok.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-3">{{ $donations->links() }}</div>
</div>
@endsection

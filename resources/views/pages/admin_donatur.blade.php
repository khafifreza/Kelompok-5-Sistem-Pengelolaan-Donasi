@extends('layouts.admin')
@section('title', 'Data Donatur')

@section('content')
<div class="page-header-custom">
    <div>
        <div class="breadcrumb-custom">Manajemen Pengguna</div>
        <h1 class="page-title">Data Donatur</h1>
        <p class="page-subtitle">Daftar akun donatur dan total donasi berhasil yang tercatat.</p>
    </div>
</div>

<div class="content-card">
    <form method="GET" action="{{ route('admin.donatur') }}" class="card-header-custom">
        <div class="search-box" style="flex: 1; max-width: 500px;">
            <i class="bi bi-search"></i>
            <input type="search" name="q" value="{{ $search }}" placeholder="Cari nama, email, atau nomor telepon..." aria-label="Cari donatur">
        </div>
        <button type="submit" class="btn btn-outline-custom">Cari</button>
        @if($search !== '')
            <a class="btn btn-ghost" href="{{ route('admin.donatur') }}">Reset</a>
        @endif
    </form>

    <div class="table-responsive">
        <table class="table admin-table">
            <thead>
                <tr>
                    <th>Nama Donatur</th>
                    <th>Email</th>
                    <th>No. Telepon</th>
                    <th>Jumlah Donasi</th>
                    <th>Total Berhasil</th>
                    <th>Bergabung</th>
                </tr>
            </thead>
            <tbody>
                @forelse($donors as $donor)
                    <tr>
                        <td><strong>{{ $donor->name }}</strong></td>
                        <td>{{ $donor->email }}</td>
                        <td>{{ $donor->phone ?? '-' }}</td>
                        <td>{{ $donor->donations_count }}</td>
                        <td><strong>{{ \App\Models\Program::rupiah($donor->successful_donations_amount ?? 0) }}</strong></td>
                        <td>{{ $donor->created_at->locale('id')->isoFormat('D MMM YYYY') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center">Belum ada donatur yang cocok.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-3">{{ $donors->links() }}</div>
</div>
@endsection

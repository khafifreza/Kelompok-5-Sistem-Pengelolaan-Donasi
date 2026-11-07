@extends('layouts.admin')
@section('title', 'Penyaluran Bantuan')

@section('content')
<div class="page-header-custom">
    <div>
        <div class="breadcrumb-custom">Manajemen Keuangan</div>
        <h1 class="page-title">Penyaluran Bantuan</h1>
        <p class="page-subtitle">Pencatatan penyaluran belum tersedia pada versi project saat ini.</p>
    </div>
</div>

<div class="tabs-custom">
    <a href="{{ route('admin.donasi') }}" class="tab-item">Donasi Masuk</a>
    <a href="{{ route('admin.penyaluran') }}" class="tab-item active">Penyaluran Bantuan</a>
</div>

<div class="content-card p-4" role="status">
    <h2 class="h5">Fitur belum tersedia</h2>
    <p class="mb-3">Saat ini database belum memiliki data penerima, catatan penyaluran, atau bukti bantuan. Informasi contoh tidak ditampilkan agar tidak disalahartikan sebagai transaksi nyata.</p>
    <a href="{{ route('admin.donasi') }}" class="btn btn-outline-custom">Lihat donasi masuk</a>
</div>
@endsection

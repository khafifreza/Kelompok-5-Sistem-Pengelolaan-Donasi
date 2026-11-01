<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') - PeduliLindungi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    

</head>
<body>

<div class="admin-layout">
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-brand">
            <a href="/" class="logo">
                <span class="logo-mark"><i class="bi bi-heart-fill"></i></span>
                PeduliLindungi<span class="logo-dot">.</span>
            </a>
        </div>
        <ul class="sidebar-menu">
            <li>
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-house"></i> Dashboard
                </a>
            </li>
            <li>
                <a href="{{ route('admin.donasi') }}" class="{{ request()->routeIs('admin.donasi') ? 'active' : '' }}">
                    <i class="bi bi-wallet2"></i> Donasi Masuk <span class="badge-notification">5</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.program') }}" class="{{ request()->routeIs('admin.program') ? 'active' : '' }}">
                    <i class="bi bi-grid"></i> Kelola Program
                </a>
            </li>
            <li>
                <a href="{{ route('admin.penyaluran') }}" class="{{ request()->routeIs('admin.penyaluran') ? 'active' : '' }}">
                    <i class="bi bi-send"></i> Penyaluran Bantuan
                </a>
            </li>
            <li>
                <a href="{{ route('admin.donatur') }}" class="{{ request()->routeIs('admin.donatur') ? 'active' : '' }}">
                    <i class="bi bi-people"></i> Data Donatur
                </a>
            </li>
            <li>
                <a href="{{ route('admin.laporan') }}" class="{{ request()->routeIs('admin.laporan') ? 'active' : '' }}">
                    <i class="bi bi-file-earmark-text"></i> Laporan
                </a>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="top-bar">
            <div>
                <div class="breadcrumb-custom">Panel Administrasi</div>
                <div class="date-display" style="font-size: 13px; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 4px;">
                    {{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
                </div>
                <h1 class="page-title">Selamat pagi, Rizky Admin</h1>
            </div>
            <div class="user-profile-admin">
                <div class="user-info-admin text-end">
                    <strong>Rizky Admin</strong>
                    <small>Super Admin</small>
                </div>
                <div class="user-avatar">RA</div>
            </div>
        </div>

        @yield('content')

        <div class="text-center mt-5 mb-3">
            <a href="/" class="btn btn-ghost btn-sm"><i class="bi bi-box-arrow-left"></i> Kembali ke Beranda</a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@yield('scripts')
</body>
</html>
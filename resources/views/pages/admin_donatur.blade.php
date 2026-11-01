@extends('layouts.admin')
@section('title', 'Data Donatur')

@section('content')
<div class="page-header-custom">
    <div>
        <div class="breadcrumb-custom">Manajemen Pengguna</div>
        <h1 class="page-title">Data Donatur</h1>
        <p class="page-subtitle">Daftar lengkap semua pengguna yang terdaftar sebagai donatur.</p>
    </div>
    <a href="#" class="btn btn-outline-custom"><i class="bi bi-download"></i> Ekspor Data</a>
</div>

<div class="content-card">
    <div class="card-header-custom">
        <div class="search-box" style="flex: 1; max-width: 400px;">
            <i class="bi bi-search"></i>
            <input type="text" placeholder="Cari donatur berdasarkan nama atau email...">
        </div>
        <div class="filter-group">
            <select class="form-control-custom" style="width: auto;">
                <option>Semua Status</option>
                <option>Aktif</option>
                <option>Nonaktif</option>
            </select>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table admin-table">
            <thead>
                <tr>
                    <th>Nama Donatur</th>
                    <th>Email</th>
                    <th>No. Telepon</th>
                    <th>Total Donasi</th>
                    <th>Bergabung</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><strong>Andi Pratama</strong></td>
                    <td>andi.pratama@email.com</td>
                    <td>0812-3456-7890</td>
                    <td><strong>Rp 4.500.000</strong></td>
                    <td>10 Jan 2025</td>
                </tr>
                <tr>
                    <td><strong>Sarah Wijaya</strong></td>
                    <td>sarah.w@email.com</td>
                    <td>0821-9876-5432</td>
                    <td><strong>Rp 7.200.000</strong></td>
                    <td>5 Feb 2025</td>
                </tr>
                <tr>
                    <td><strong>Budi Santoso</strong></td>
                    <td>budi.santoso@email.com</td>
                    <td>0856-1234-5678</td>
                    <td><strong>Rp 2.100.000</strong></td>
                    <td>18 Mar 2025</td>
                </tr>
                <tr>
                    <td><strong>Hamba Allah</strong></td>
                    <td>anonim@pedulilindungi.com</td>
                    <td>-</td>
                    <td><strong>Rp 15.000.000</strong></td>
                    <td>22 Apr 2025</td>
                </tr>
                <tr>
                    <td><strong>Rizky Admin</strong></td>
                    <td>admin@pedulilindungi.com</td>
                    <td>0878-1111-2222</td>
                    <td><strong>Rp 1.000.000</strong></td>
                    <td>1 Jun 2025</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
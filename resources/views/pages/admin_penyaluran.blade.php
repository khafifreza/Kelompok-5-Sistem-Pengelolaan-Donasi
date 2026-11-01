@extends('layouts.admin')
@section('title', 'Penyaluran Bantuan')

@section('content')
<div class="page-header-custom">
    <div>
        <div class="breadcrumb-custom">Manajemen Keuangan</div>
        <h1 class="page-title">Donasi & Penyaluran</h1>
        <p class="page-subtitle">Konfirmasi donasi masuk dan catat setiap bantuan yang disalurkan.</p>
    </div>
    <a href="#" class="btn btn-outline-custom"><i class="bi bi-download"></i> Ekspor Laporan</a>
</div>

<!-- Tabs -->
<div class="tabs-custom">
    <a href="{{ route('admin.donasi') }}" class="tab-item">Donasi Masuk <span class="tab-count">2</span></a>
    <a href="{{ route('admin.penyaluran') }}" class="tab-item active">Penyaluran Bantuan</a>
</div>

<div class="row g-4">
    <div class="col-md-7">
        <div class="content-card">
            <div class="card-header-custom">
                <div>
                    <h5 class="card-title">Catat Penyaluran</h5>
                    <p class="card-subtitle">Lengkapi detail bantuan dan bukti penyaluran.</p>
                </div>
            </div>
            <div class="form-group-custom">
                <label>Penerima Bantuan</label>
                <select class="form-control-custom">
                    <option>Pilih penerima terverifikasi</option>
                    <option>Siti Rahmawati</option>
                    <option>Budi Santoso</option>
                    <option>Nur Aisyah</option>
                    <option>Ahmad Fauzan</option>
                </select>
            </div>
            <div class="form-row-custom">
                <div class="form-group-custom">
                    <label>Bentuk Bantuan</label>
                    <input type="text" class="form-control-custom" placeholder="Contoh: Paket sembako">
                </div>
                <div class="form-group-custom">
                    <label>Nilai Bantuan</label>
                    <div class="input-with-rp">
                        <span class="rp-prefix">Rp</span>
                        <input type="number" placeholder="0">
                    </div>
                </div>
            </div>
            <div class="form-group-custom">
                <label>Keterangan</label>
                <textarea class="form-control-custom textarea-custom" placeholder="Tuliskan detail penyaluran..."></textarea>
            </div>
            <div class="form-group-custom">
                <label>Foto Bukti</label>
                <div class="upload-area">
                    <i class="bi bi-image"></i>
                    <div>
                        <strong>Unggah foto dokumentasi</strong>
                        <small>JPG atau PNG, maks. 5MB</small>
                    </div>
                </div>
            </div>
            <button class="btn-submit-program">
                Simpan Penyaluran <i class="bi bi-send"></i>
            </button>
        </div>
    </div>
    <div class="col-md-5">
        <div class="content-card">
            <div class="card-header-custom">
                <div>
                    <h5 class="card-title">Riwayat Terbaru</h5>
                    <p class="card-subtitle">Penyaluran 30 hari terakhir.</p>
                </div>
            </div>
            <div class="riwayat-list">
                <div class="riwayat-item">
                    <div class="riwayat-img" style="background: linear-gradient(135deg, #e8f5f0, #d4f1e8);">
                        <i class="bi bi-box-seam"></i>
                    </div>
                    <div class="riwayat-content">
                        <strong>Siti Rahmawati</strong>
                        <small>Paket sembako • Rp 750.000</small>
                        <span class="riwayat-date">22 Juni 2025</span>
                    </div>
                    <i class="bi bi-chevron-right riwayat-arrow"></i>
                </div>
                <div class="riwayat-item">
                    <div class="riwayat-img" style="background: linear-gradient(135deg, #fff3cd, #ffe69c);">
                        <i class="bi bi-book"></i>
                    </div>
                    <div class="riwayat-content">
                        <strong>Yusuf Kurnia</strong>
                        <small>Biaya pendidikan • Rp 1.200.000</small>
                        <span class="riwayat-date">22 Juni 2025</span>
                    </div>
                    <i class="bi bi-chevron-right riwayat-arrow"></i>
                </div>
                <div class="riwayat-item">
                    <div class="riwayat-img" style="background: linear-gradient(135deg, #e3f2fd, #bbdefb);">
                        <i class="bi bi-heart-pulse"></i>
                    </div>
                    <div class="riwayat-content">
                        <strong>Maya Lestari</strong>
                        <small>Bantuan kesehatan • Rp 2.500.000</small>
                        <span class="riwayat-date">22 Juni 2025</span>
                    </div>
                    <i class="bi bi-chevron-right riwayat-arrow"></i>
                </div>
                <div class="riwayat-item">
                    <div class="riwayat-img" style="background: linear-gradient(135deg, #f3e5f5, #e1bee7);">
                        <i class="bi bi-droplet"></i>
                    </div>
                    <div class="riwayat-content">
                        <strong>Ahmad Fauzan</strong>
                        <small>Air bersih • Rp 500.000</small>
                        <span class="riwayat-date">20 Juni 2025</span>
                    </div>
                    <i class="bi bi-chevron-right riwayat-arrow"></i>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@extends('layouts.admin')
@section('title', 'Kelola Program')

@section('content')
<div class="page-header-custom">
    <div>
        <div class="breadcrumb-custom">Manajemen Program</div>
        <h1 class="page-title">Kelola Program Donasi</h1>
        <p class="page-subtitle">Buat, edit, dan kelola semua program penggalangan dana.</p>
    </div>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalBuatProgram">
        <i class="bi bi-plus"></i> Buat Program
    </button>
</div>

<!-- Search & Filter -->
<div class="content-card">
    <div class="card-header-custom">
        <div class="search-box" style="flex: 1; max-width: 400px;">
            <i class="bi bi-search"></i>
            <input type="text" placeholder="Cari program...">
        </div>
        <div class="filter-group">
            <select class="form-control-custom" style="width: auto;">
                <option>Semua Kategori</option>
                <option>Pendidikan</option>
                <option>Kesehatan</option>
                <option>Kemanusiaan</option>
            </select>
            <select class="form-control-custom" style="width: auto;">
                <option>Semua Status</option>
                <option>Aktif</option>
                <option>Selesai</option>
                <option>Draft</option>
            </select>
        </div>
    </div>

    <!-- Program List -->
    <div class="program-admin-list">
        <div class="program-admin-item">
            <div class="program-admin-img" style="background: linear-gradient(135deg, #e8f5f0, #d4f1e8);">
                <i class="bi bi-book"></i>
            </div>
            <div class="program-admin-info">
                <h4>Pendidikan untuk Anak Pelosok</h4>
                <div class="program-admin-meta">
                    <span class="badge-category">Pendidikan</span>
                    <span><i class="bi bi-people"></i> 124 donatur</span>
                    <span><i class="bi bi-calendar"></i> Dibuat 15 Jun 2025</span>
                </div>
                <div class="program-admin-progress">
                    <div class="progress-label">
                        <strong>Rp 84.750.000</strong>
                        <span>71% dari Rp 120.000.000</span>
                    </div>
                    <div class="progress">
                        <i style="width: 71%;"></i>
                    </div>
                </div>
            </div>
            <div class="program-admin-actions">
                <button class="btn btn-ghost btn-sm"><i class="bi bi-pencil"></i></button>
                <button class="btn btn-ghost btn-sm"><i class="bi bi-eye"></i></button>
                <button class="btn btn-ghost btn-sm text-danger"><i class="bi bi-trash"></i></button>
            </div>
        </div>

        <div class="program-admin-item">
            <div class="program-admin-img" style="background: linear-gradient(135deg, #fff3cd, #ffe69c);">
                <i class="bi bi-basket"></i>
            </div>
            <div class="program-admin-info">
                <h4>Paket Pangan Keluarga Prasejahtera</h4>
                <div class="program-admin-meta">
                    <span class="badge-category" style="background: #fff3cd; color: #856404;">Kemanusiaan</span>
                    <span><i class="bi bi-people"></i> 89 donatur</span>
                    <span><i class="bi bi-calendar"></i> Dibuat 10 Jun 2025</span>
                </div>
                <div class="program-admin-progress">
                    <div class="progress-label">
                        <strong>Rp 62.400.000</strong>
                        <span>78% dari Rp 80.000.000</span>
                    </div>
                    <div class="progress">
                        <i style="width: 78%;"></i>
                    </div>
                </div>
            </div>
            <div class="program-admin-actions">
                <button class="btn btn-ghost btn-sm"><i class="bi bi-pencil"></i></button>
                <button class="btn btn-ghost btn-sm"><i class="bi bi-eye"></i></button>
                <button class="btn btn-ghost btn-sm text-danger"><i class="bi bi-trash"></i></button>
            </div>
        </div>

        <div class="program-admin-item">
            <div class="program-admin-img" style="background: linear-gradient(135deg, #e3f2fd, #bbdefb);">
                <i class="bi bi-heart-pulse"></i>
            </div>
            <div class="program-admin-info">
                <h4>Layanan Kesehatan Desa</h4>
                <div class="program-admin-meta">
                    <span class="badge-category" style="background: #e3f2fd; color: #1976d2;">Kesehatan</span>
                    <span><i class="bi bi-people"></i> 56 donatur</span>
                    <span><i class="bi bi-calendar"></i> Dibuat 5 Jun 2025</span>
                </div>
                <div class="program-admin-progress">
                    <div class="progress-label">
                        <strong>Rp 37.500.000</strong>
                        <span>50% dari Rp 75.000.000</span>
                    </div>
                    <div class="progress">
                        <i style="width: 50%;"></i>
                    </div>
                </div>
            </div>
            <div class="program-admin-actions">
                <button class="btn btn-ghost btn-sm"><i class="bi bi-pencil"></i></button>
                <button class="btn btn-ghost btn-sm"><i class="bi bi-eye"></i></button>
                <button class="btn btn-ghost btn-sm text-danger"><i class="bi bi-trash"></i></button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Buat Program (sama seperti di dashboard) -->
<div class="modal fade" id="modalBuatProgram" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modal-program">
            <button type="button" class="modal-close-btn" data-bs-dismiss="modal">
                <i class="bi bi-x-lg"></i>
            </button>
            <div class="modal-program-header">
                <div class="modal-eyebrow">KELOLA PROGRAM</div>
                <h2>Buat Program Baru</h2>
                <p>Lengkapi informasi utama program penggalangan dana.</p>
            </div>
            <form>
                <div class="form-group-custom">
                    <label>Nama Program</label>
                    <input type="text" class="form-control-custom" placeholder="Contoh: Bantuan Sekolah Pelosok">
                </div>
                <div class="form-row-custom">
                    <div class="form-group-custom">
                        <label>Kategori</label>
                        <select class="form-control-custom">
                            <option value="">Pilih kategori</option>
                            <option>Pendidikan</option>
                            <option>Kesehatan</option>
                            <option>Kemanusiaan</option>
                            <option>Lingkungan</option>
                        </select>
                    </div>
                    <div class="form-group-custom">
                        <label>Target Donasi</label>
                        <div class="input-with-rp">
                            <span class="rp-prefix">Rp</span>
                            <input type="number" placeholder="0">
                        </div>
                    </div>
                </div>
                <div class="form-group-custom">
                    <label>Deskripsi Singkat</label>
                    <textarea class="form-control-custom textarea-custom" placeholder="Jelaskan tujuan dan penerima manfaat program..."></textarea>
                </div>
                <div class="form-group-custom">
                    <label>Foto Sampul</label>
                    <div class="upload-area">
                        <i class="bi bi-image"></i>
                        <div>
                            <strong>Unggah foto program</strong>
                            <small>JPG atau PNG, maks. 5MB</small>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn-submit-program">
                    Simpan Program <i class="bi bi-plus"></i>
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
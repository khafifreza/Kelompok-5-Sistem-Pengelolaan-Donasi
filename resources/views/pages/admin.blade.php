@extends('layouts.admin')
@section('title', 'Dashboard Admin')

@section('content')

<!-- Stats Cards -->
<div class="stats-row" style="grid-template-columns: repeat(4, 1fr);">
    <div class="stat-card">
        <div class="stat-icon"><i class="bi bi-wallet2"></i></div>
        <div>
            <small>Total Donasi</small>
            <strong>Rp 284,6 Jt</strong>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon"><i class="bi bi-send-check"></i></div>
        <div>
            <small>Tersalurkan</small>
            <strong>Rp 216,2 Jt</strong>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon"><i class="bi bi-people"></i></div>
        <div>
            <small>Penerima Aktif</small>
            <strong>1.248</strong>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background: #fff3cd; color: #e6a817;"><i class="bi bi-hourglass-split"></i></div>
        <div>
            <small>Perlu Verifikasi</small>
            <strong>8</strong>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="quick-actions">
    <button type="button" class="quick-action-btn" data-bs-toggle="modal" data-bs-target="#modalBuatProgram" style="border: none; cursor: pointer;">
        <i class="bi bi-plus-circle"></i><span>Buat Program Baru</span>
    </button>
    <a href="{{ route('admin.donasi') }}" class="quick-action-btn"><i class="bi bi-check-circle"></i><span>Konfirmasi Donasi</span></a>
    <a href="{{ route('admin.penyaluran') }}" class="quick-action-btn"><i class="bi bi-send"></i><span>Salurkan Bantuan</span></a>
    <a href="{{ route('admin.laporan') }}" class="quick-action-btn"><i class="bi bi-download"></i><span>Ekspor Laporan</span></a>
</div>

<!-- Recent Donations Table -->
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
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>Andi Pratama</strong></td>
                            <td>Pendidikan Anak Pelosok</td>
                            <td><strong>Rp 1.500.000</strong></td>
                            <td>24 Jun 2025</td>
                        </tr>
                        <tr>
                            <td><strong>Hamba Allah</strong></td>
                            <td>Paket Pangan Keluarga</td>
                            <td><strong>Rp 500.000</strong></td>
                            <td>24 Jun 2025</td>
                        </tr>
                        <tr>
                            <td><strong>Sarah Wijaya</strong></td>
                            <td>Layanan Kesehatan Desa</td>
                            <td><strong>Rp 2.000.000</strong></td>
                            <td>23 Jun 2025</td>
                        </tr>
                        <tr>
                            <td><strong>Budi Santoso</strong></td>
                            <td>Air Bersih untuk NTT</td>
                            <td><strong>Rp 750.000</strong></td>
                            <td>22 Jun 2025</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Buat Program Baru -->
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

@section('scripts')
<script>
    // Auto-hide alert jika ada
    document.querySelectorAll('.alert-pending .btn-close').forEach(btn => {
        btn.addEventListener('click', function() {
            this.closest('.alert-pending').remove();
        });
    });
</script>
@endsection
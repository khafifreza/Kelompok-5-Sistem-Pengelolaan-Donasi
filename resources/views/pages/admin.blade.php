@extends('layouts.admin')
@section('title', 'Dashboard Admin')

@section('content')
<div class="alert-pending">
    <div>
        <h5><i class="bi bi-exclamation-triangle-fill"></i> 5 Donasi Menunggu Konfirmasi</h5>
        <p>Ada donasi yang belum dikonfirmasi pembayarannya. Segera tinjau dan proses.</p>
    </div>
    <a href="#" class="btn btn-primary">Lihat Donasi Pending</a>
</div>

<div class="stats-row" style="grid-template-columns: repeat(4, 1fr);">
    <div class="stat-card">
        <div class="stat-icon"><i class="bi bi-wallet2"></i></div>
        <div>
            <small>Total Donasi</small>
            <strong>Rp 284,6 Jt</strong>
            <span style="color: #28a745; font-size: 12px;"><i class="bi bi-arrow-up"></i> +12,5%</span>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon"><i class="bi bi-send-check"></i></div>
        <div>
            <small>Tersalurkan</small>
            <strong>Rp 216,2 Jt</strong>
            <span style="color: #28a745; font-size: 12px;"><i class="bi bi-arrow-up"></i> +8,4%</span>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon"><i class="bi bi-people"></i></div>
        <div>
            <small>Penerima Aktif</small>
            <strong>1.248</strong>
            <span style="color: #28a745; font-size: 12px;"><i class="bi bi-arrow-up"></i> +32 orang</span>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background: #fff3cd; color: #e6a817;"><i class="bi bi-hourglass-split"></i></div>
        <div>
            <small>Perlu Verifikasi</small>
            <strong>8</strong>
            <span style="color: #dc3545; font-size: 12px;">Perlu tindakan</span>
        </div>
    </div>
</div>

<div class="quick-actions">
    <a href="#" class="quick-action-btn"><i class="bi bi-plus-circle"></i><span>Buat Program Baru</span></a>
    <a href="#" class="quick-action-btn"><i class="bi bi-check-circle"></i><span>Konfirmasi Donasi</span></a>
    <a href="#" class="quick-action-btn"><i class="bi bi-send"></i><span>Salurkan Bantuan</span></a>
    <a href="#" class="quick-action-btn"><i class="bi bi-download"></i><span>Ekspor Laporan</span></a>
</div>

<div class="row g-4">
    <div class="col-md-8">
        <div class="content-card">
            <div class="card-header-custom">
                <h5 class="card-title">Grafik Donasi 7 Hari Terakhir</h5>
                <select class="form-select form-select-sm" style="width: auto;">
                    <option>Minggu Ini</option>
                    <option>Bulan Ini</option>
                </select>
            </div>
            <div class="chart-container">
                <canvas id="donationChart"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="content-card">
            <div class="card-header-custom">
                <h5 class="card-title">Aktivitas Terbaru</h5>
            </div>
            <div class="activity-item">
                <div class="activity-icon donation"><i class="bi bi-heart-fill"></i></div>
                <div class="activity-content">
                    <div class="activity-title">Donasi baru dari Andi Pratama</div>
                    <div class="activity-time">Rp 1.500.000 • 2 menit lalu</div>
                </div>
            </div>
            <div class="activity-item">
                <div class="activity-icon program"><i class="bi bi-grid-fill"></i></div>
                <div class="activity-content">
                    <div class="activity-title">Program "Pendidikan Anak" diperbarui</div>
                    <div class="activity-time">15 menit lalu</div>
                </div>
            </div>
            <div class="activity-item">
                <div class="activity-icon user"><i class="bi bi-person-plus-fill"></i></div>
                <div class="activity-content">
                    <div class="activity-title">Donatur baru: Budi Santoso</div>
                    <div class="activity-time">2 jam lalu</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="content-card mt-4">
    <div class="card-header-custom">
        <h5 class="card-title">Donasi Terbaru</h5>
        <a href="#" class="btn btn-outline-custom btn-sm">Lihat Semua</a>
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
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><strong>Andi Pratama</strong></td>
                    <td>Pendidikan Anak Pelosok</td>
                    <td><strong>Rp 1.500.000</strong></td>
                    <td>24 Jun 2025</td>
                    <td><span class="status-badge pending">Pending</span></td>
                    <td><button class="btn btn-primary btn-sm">Konfirmasi</button></td>
                </tr>
                <tr>
                    <td><strong>Hamba Allah</strong></td>
                    <td>Paket Pangan Keluarga</td>
                    <td><strong>Rp 500.000</strong></td>
                    <td>24 Jun 2025</td>
                    <td><span class="status-badge pending">Pending</span></td>
                    <td><button class="btn btn-primary btn-sm">Konfirmasi</button></td>
                </tr>
                <tr>
                    <td><strong>Sarah Wijaya</strong></td>
                    <td>Layanan Kesehatan Desa</td>
                    <td><strong>Rp 2.000.000</strong></td>
                    <td>23 Jun 2025</td>
                    <td><span class="status-badge berhasil">Berhasil</span></td>
                    <td><button class="btn btn-ghost btn-sm">Detail</button></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const ctx = document.getElementById('donationChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
            datasets: [{
                label: 'Donasi Masuk',
                data: [12, 19, 15, 25, 22, 30, 28],
                borderColor: '#1e6b54',
                backgroundColor: 'rgba(30, 107, 84, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.05)' } },
                x: { grid: { display: false } }
            }
        }
    });
</script>
@endsection
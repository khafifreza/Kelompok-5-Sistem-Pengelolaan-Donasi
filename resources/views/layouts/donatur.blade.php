<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - PeduliLindungi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

<nav class="navbar-custom dashboard-nav">
    <div class="navbar-inner">
        <a href="{{ route('home') }}" class="logo">
            <span class="logo-mark"><i class="bi bi-heart-fill"></i></span>
            PeduliLindungi<span class="logo-dot">.</span>
        </a>
        <div class="nav-links">
            <a href="{{ route('dashboard') }}" class="active">Dashboard</a>
            <a href="{{ route('program.index') }}">Program</a>
            <a href="#">Bantuan</a>
        </div>
        <div class="nav-actions">
            <div class="user-profile">
                <span class="avatar">AP</span>
                <div><strong>Andi Pratama</strong><small>Donatur</small></div>
                <i class="bi bi-chevron-right"></i>
            </div>
            <a href="{{ route('home') }}" class="btn-logout" title="Logout"><i class="bi bi-box-arrow-right"></i></a>
        </div>
    </div>
</nav>

<main>@yield('content')</main>

<!-- MODAL DONASI -->
<div class="modal-overlay" id="donasiModal">
    <div class="modal-box donasi-modal">
        <button class="modal-close" onclick="closeModal('donasiModal')">✕</button>
        <div class="modal-header">
            <div class="logo"><span class="logo-mark"><i class="bi bi-heart-fill"></i></span>PeduliLindungi<span class="logo-dot">.</span></div>
            <div class="modal-eyebrow">LANGKAH KEBAIKANMU</div>
            <h2>Isi Detail Donasi</h2>
            <p>Pilih nominal dan metode pembayaran yang paling nyaman.</p>
        </div>
        <form onsubmit="event.preventDefault(); alert('Fitur pembayaran akan segera hadir!');">
            <div class="form-group">
                <label>Program Donasi</label>
                <select class="form-select-custom">
                    <option>Pendidikan untuk Anak Pelosok</option>
                    <option>Paket Pangan Keluarga Prasejahtera</option>
                    <option>Layanan Kesehatan Desa</option>
                    <option>Air Bersih untuk NTT</option>
                </select>
            </div>
            <div class="form-group">
                <label>Pilih Nominal Donasi</label>
                <div class="nominal-grid">
                    <button type="button" class="nominal-btn" data-nominal="50000">Rp 50.000</button>
                    <button type="button" class="nominal-btn active" data-nominal="100000">Rp 100.000</button>
                    <button type="button" class="nominal-btn" data-nominal="200000">Rp 200.000</button>
                    <button type="button" class="nominal-btn" data-nominal="500000">Rp 500.000</button>
                </div>
                <div class="input-with-prefix">
                    <span class="prefix">Rp</span>
                    <input type="text" id="nominalLainnya" value="100.000">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group"><label>Nama Donatur</label><input type="text" value="Andi Pratama"></div>
                <div class="form-group"><label>Email</label><input type="email" value="andi@email.com"></div>
            </div>
            <div class="form-group">
                <label class="checkbox-label-custom"><input type="checkbox"><span>Sembunyikan nama saya</span></label>
                <small class="form-hint">Donasi akan dicantumkan sebagai Hamba Allah</small>
            </div>
            <div class="form-group">
                <label>Metode Pembayaran</label>
                <div class="payment-methods">
                    <label class="payment-option"><input type="radio" name="payment" checked><div class="payment-content"><strong>Transfer Bank</strong><small>BCA, BRI, Mandiri</small></div></label>
                    <label class="payment-option"><input type="radio" name="payment"><div class="payment-content"><strong>E-Wallet</strong><small>GoPay, OVO, DANA</small></div></label>
                    <label class="payment-option"><input type="radio" name="payment"><div class="payment-content"><strong>QRIS</strong><small>Semua e-Wallet</small></div></label>
                </div>
            </div>
            <div class="total-section">
                <div><small>Total Donasi</small><span class="total-note">100% disalurkan ke program</span></div>
                <strong class="total-amount" id="totalAmount">Rp 100.000</strong>
            </div>
            <button type="submit" class="modal-btn">Lanjutkan Pembayaran <i class="bi bi-arrow-right"></i></button>
        </form>
        <div class="modal-footer"><i class="bi bi-shield-check"></i> Transaksi aman dan data Anda terlindungi</div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function closeModal(id){ document.getElementById(id).classList.remove('active'); document.body.style.overflow=''; }
    function openModal(id){ document.getElementById(id).classList.add('active'); document.body.style.overflow='hidden'; }
    document.querySelectorAll('.modal-overlay').forEach(o=>o.addEventListener('click',function(e){if(e.target===this){this.classList.remove('active');document.body.style.overflow='';}}));
    document.querySelectorAll('.nominal-btn').forEach(btn=>{btn.addEventListener('click',function(){document.querySelectorAll('.nominal-btn').forEach(b=>b.classList.remove('active'));this.classList.add('active');const n=this.getAttribute('data-nominal');document.getElementById('nominalLainnya').value=parseInt(n).toLocaleString('id-ID');document.getElementById('totalAmount').textContent='Rp '+parseInt(n).toLocaleString('id-ID');});});
    document.getElementById('nominalLainnya').addEventListener('input',function(){document.querySelectorAll('.nominal-btn').forEach(b=>b.classList.remove('active'));const v=this.value.replace(/\D/g,'');document.getElementById('totalAmount').textContent='Rp '+parseInt(v||0).toLocaleString('id-ID');});
</script>
</body>
</html>
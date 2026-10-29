<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PeduliLindungi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

    <nav class="navbar-custom">
        <div class="navbar-inner">
            <a href="{{ route('home') }}" class="logo">
                <span class="logo-mark"><i class="bi bi-heart-fill"></i></span>
                PeduliLindungi<span class="logo-dot">.</span>
            </a>
            <div class="nav-links">
                <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Beranda</a>
                <a href="{{ route('program.index') }}" class="{{ request()->routeIs('program.*') ? 'active' : '' }}">Program</a>
                <a href="#transparansi">Transparansi</a>
            </div>
            <div class="nav-actions">
                <button class="btn btn-ghost" onclick="openModal('loginModal')">Login</button>
                <button class="btn btn-primary" onclick="openModal('registerModal')">Daftar</button>
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer>
        <div class="wrap footer-inner">
            <div class="logo" style="color: white;">
                <span class="logo-mark" style="background: white; color: var(--primary);"><i class="bi bi-heart-fill"></i></span>
                PeduliLindungi<span class="logo-dot" style="color: var(--accent);">.</span>
            </div>
            <span>Menyalurkan kebaikan, menghadirkan harapan.</span>
            <span>© 2025 PeduliLindungi Foundation</span>
        </div>
    </footer>

        <!-- MODAL LOGIN -->
    <div class="modal-overlay" id="loginModal">
        <div class="modal-box">
            <button class="modal-close" onclick="closeModal('loginModal')">✕</button>
            <div class="modal-header">
                <div class="logo">
                    <span class="logo-mark"><i class="bi bi-heart-fill"></i></span>
                    PeduliLindungi<span class="logo-dot">.</span>
                </div>
                <div class="modal-eyebrow">SELAMAT DATANG KEMBALI</div>
                <h2>Masuk ke akun Anda</h2>
                <p>Masukkan email dan kata sandi yang telah terdaftar.</p>
            </div>
            <form method="POST" action="{{ route('login.process') }}">
                @csrf
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" required placeholder="nama@email.com">
                </div>
                <div class="form-group">
                    <label>Kata Sandi</label>
                    <input type="password" name="password" required placeholder="Minimal 8 karakter">
                </div>
                <div style="text-align: right; margin-bottom: 20px;">
                    <a href="#" class="forgot-link" style="font-size: 13px;">Lupa kata sandi?</a>
                </div>
                <button type="submit" class="modal-btn">Masuk <i class="bi bi-arrow-right"></i></button>
            </form>
            <div class="modal-footer">
                Belum punya akun?<a onclick="switchModal('loginModal', 'registerModal')">Daftar sekarang</a>
            </div>
        </div>
    </div>

        <!-- MODAL REGISTER -->
    <div class="modal-overlay" id="registerModal">
        <div class="modal-box">
            <button class="modal-close" onclick="closeModal('registerModal')">✕</button>
            
            <div class="modal-header">
                <div class="logo">
                    <span class="logo-mark"><i class="bi bi-heart-fill"></i></span>
                    PeduliLindungi<span class="logo-dot">.</span>
                </div>
                <div class="modal-eyebrow">AKUN DONATUR BARU</div>
                <h2>Mulai perjalanan kebaikan</h2>
                <p>Daftar singkat untuk menyimpan dan menyertakan riwayat donasi.</p>
            </div>

            <form method="POST" action="{{ route('register.process') }}">
                @csrf
                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" name="name" required placeholder="Contoh: Andi Pratama">
                </div>
                <div class="form-group">
                    <label>E-mail</label>
                    <input type="email" name="email" required placeholder="nama@email.com">
                </div>
                <div class="form-group">
                    <label>No. WhatsApp</label>
                    <input type="tel" name="phone" required placeholder="0812 3456 7890">
                </div>
                <div class="form-group">
                    <label>Kata Sandi</label>
                    <input type="password" name="password" required placeholder="Minimal 8 karakter">
                </div>
                <button type="submit" class="modal-btn">Daftar sebagai Donatur <i class="bi bi-arrow-right"></i></button>
            </form>

            <div class="modal-footer">
                Sudah punya akun? <a onclick="switchModal('registerModal', 'loginModal')" style="font-weight: 700;">Masuk di sini</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function openModal(id) {
            document.getElementById(id).classList.add('active');
            document.body.style.overflow = 'hidden';
        }
        function closeModal(id) {
            document.getElementById(id).classList.remove('active');
            document.body.style.overflow = '';
        }
        function switchModal(closeId, openId) {
            closeModal(closeId);
            setTimeout(() => openModal(openId), 100);
        }
        document.querySelectorAll('.modal-overlay').forEach(overlay => {
            overlay.addEventListener('click', function(e) {
                if (e.target === this) {
                    this.classList.remove('active');
                    document.body.style.overflow = '';
                }
            });
        });
    </script>
</body>
</html>
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
                Peduli Lindungi</span>
            </a>
            <div class="nav-links">
                <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Beranda</a>
                <a href="{{ route('program.index') }}" class="{{ request()->routeIs('program.*') ? 'active' : '' }}">Program</a>
                <a href="#transparansi">Transparansi</a>
            </div>
            <div class="nav-actions">
                @auth
                    <a class="btn btn-ghost" href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('dashboard') }}">Dashboard</a>
                    <span>{{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="btn btn-primary" type="submit">Logout</button>
                    </form>
                @else
                    <button class="btn btn-ghost" onclick="openModal('loginRoleModal')">Login</button>
                    <button class="btn btn-primary" onclick="openModal('registerModal')">Daftar</button>
                @endauth
            </div>
        </div>
    </nav>

    <main>
        @if(session('success'))
            <div class="wrap alert alert-success mt-3" role="status">{{ session('success') }}</div>
        @endif
        @yield('content')
    </main>

    <footer>
        <div class="wrap footer-inner">
            <div class="logo" style="color: white;">
                <span class="logo-mark" style="background: white; color: var(--primary);"><i class="bi bi-heart-fill"></i></span>
                PeduliLindungi<span class="logo-dot" style="color: var(--accent);">.</span>
            </div>
            <span>Menyalurkan kebaikan, menghadirkan harapan.</span>
            <span>© 2026 Kelompok 5</span>
        </div>
    </footer>

    <!-- MODAL PILIH PERAN LOGIN -->
    <div class="modal-overlay" id="loginRoleModal">
        <div class="modal-box role-modal" role="dialog" aria-modal="true" aria-labelledby="login-role-title">
            <button class="modal-close" type="button" aria-label="Tutup" onclick="closeModal('loginRoleModal')">✕</button>
            <div class="modal-header">
                <div class="logo">
                    <span class="logo-mark"><i class="bi bi-heart-fill"></i></span>
                    PeduliLindungi<span class="logo-dot">.</span>
                </div>
                <div class="modal-eyebrow">MASUK KE AKUN ANDA</div>
                <h2 id="login-role-title">Masuk sebagai siapa?</h2>
                <p>Pilih jenis akun untuk melanjutkan.</p>
            </div>
            <div class="login-role-options">
                <button class="login-role-option" type="button" onclick="selectLoginRole('admin')">
                    <span class="login-role-icon"><i class="bi bi-shield-lock"></i></span>
                    <span class="login-role-copy">
                        <strong>Admin</strong>
                        <small>Kelola program dan pantau donasi</small>
                    </span>
                    <i class="bi bi-arrow-right login-role-arrow" aria-hidden="true"></i>
                </button>
                <button class="login-role-option" type="button" onclick="selectLoginRole('donor')">
                    <span class="login-role-icon"><i class="bi bi-heart"></i></span>
                    <span class="login-role-copy">
                        <strong>Donatur</strong>
                        <small>Berbagi kebaikan dan lihat riwayat donasi</small>
                    </span>
                    <i class="bi bi-arrow-right login-role-arrow" aria-hidden="true"></i>
                </button>
            </div>
            <div class="modal-footer">
                Belum punya akun?<a onclick="switchModal('loginRoleModal', 'registerModal')">Daftar sekarang</a>
            </div>
        </div>
    </div>

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
                <h2>Masuk sebagai <span id="loginRoleLabel">{{ old('role') === 'admin' ? 'Admin' : 'Donatur' }}</span></h2>
                <p>Masukkan email dan kata sandi yang telah terdaftar.</p>
            </div>
            <form method="POST" action="{{ route('login.process') }}">
                @csrf
                <input type="hidden" name="_form" value="login">
                <input type="hidden" name="role" id="loginRoleInput" value="{{ old('role', 'donor') }}">
                @if(old('_form') === 'login')
                    <div id="loginErrors">
                        @foreach($errors->all() as $error)
                            <div class="alert alert-danger" role="alert">{{ $error }}</div>
                        @endforeach
                    </div>
                @endif
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required placeholder="nama@email.com">
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
                <a onclick="switchModal('loginModal', 'loginRoleModal')">Ganti jenis akun</a>
                <span aria-hidden="true">·</span>
                <a onclick="switchModal('loginModal', 'registerModal')">Daftar</a>
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
                <input type="hidden" name="_form" value="register">
                @if(old('_form') === 'register')
                    @foreach($errors->all() as $error)
                        <div class="alert alert-danger" role="alert">{{ $error }}</div>
                    @endforeach
                @endif
                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name') }}" required placeholder="Contoh: Andi Pratama">
                </div>
                <div class="form-group">
                    <label>E-mail</label>
                    <input type="email" name="email" value="{{ old('email') }}" required placeholder="nama@email.com">
                </div>
                <div class="form-group">
                    <label>No. WhatsApp</label>
                    <input type="tel" name="phone" value="{{ old('phone') }}" required placeholder="0812 3456 7890">
                </div>
                <div class="form-group">
                    <label>Kata Sandi</label>
                    <input type="password" name="password" required placeholder="Minimal 8 karakter">
                </div>
                <button type="submit" class="modal-btn">Daftar sebagai Donatur <i class="bi bi-arrow-right"></i></button>
            </form>

            <div class="modal-footer">
                Sudah punya akun? <a onclick="switchModal('registerModal', 'loginRoleModal')" style="font-weight: 700;">Masuk di sini</a>
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
        function selectLoginRole(role) {
            const roles = {
                admin: 'Admin',
                donor: 'Donatur'
            };
            if (!Object.hasOwn(roles, role)) {
                return;
            }

            const loginRoleInput = document.getElementById('loginRoleInput');
            if (loginRoleInput.value !== role) {
                document.getElementById('loginErrors')?.remove();
                document.querySelector('#loginModal input[name="email"]').value = '';
                document.querySelector('#loginModal input[name="password"]').value = '';
            }

            loginRoleInput.value = role;
            document.getElementById('loginRoleLabel').textContent = roles[role];
            switchModal('loginRoleModal', 'loginModal');
        }
        document.querySelectorAll('.modal-overlay').forEach(overlay => {
            overlay.addEventListener('click', function(e) {
                if (e.target === this) {
                    this.classList.remove('active');
                    document.body.style.overflow = '';
                }
            });
        });
        @if(session('open_modal'))
            window.addEventListener('DOMContentLoaded', () => openModal(@json(session('open_modal'))));
        @elseif(old('_form') === 'login' || old('_form') === 'register')
            window.addEventListener('DOMContentLoaded', () => openModal(@json(old('_form') === 'register' ? 'registerModal' : 'loginModal')));
        @elseif(old('_form') === 'donation')
            window.addEventListener('DOMContentLoaded', () => openModal('donasiModalProgram'));
        @endif
    </script>
</body>
</html>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'IPWIJA SmartLab')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #f4f6fb;
            color: #111827;
            min-height: 100vh;
        }

        /* ── NAVBAR ── */
        .navbar {
            background: #fff;
            border-bottom: 1px solid #e5e7eb;
            padding: 0 16px;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        @media (min-width: 640px) {
            .navbar { padding: 0 32px; }
        }

        .nav-left { display: flex; align-items: center; gap: 12px; }

        .brand {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }

        /* Logo: sama persis dengan figma */
        .brand-logo {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            overflow: hidden;
            flex-shrink: 0;
            background: transparent;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        @media (min-width: 640px) {
            .brand-logo { width: 44px; height: 44px; }
        }

        .brand-logo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .brand-text {
            font-size: 12px;
            font-weight: 700;
            color: #111827;
            line-height: 1.3;
        }

        @media (min-width: 640px) {
            .brand-text { font-size: 13px; }
        }

        /* NAV LINKS — centered */
        .nav-links {
            display: none;
        }

        @media (min-width: 768px) {
            .nav-links {
                display: flex;
                position: absolute;
                left: 50%;
                transform: translateX(-50%);
                align-items: center;
                gap: 4px;
            }
        }

        .nav-links a {
            padding: 8px 16px;
            border-radius: 50px;
            font-size: 14px;
            font-weight: 600;
            color: #111827;
            text-decoration: none;
            transition: all 0.15s;
            white-space: nowrap;
        }

        .nav-links a:hover { background: #f3f4f6; }
        .nav-links a.active { color: #0284c7; background: #e0f2fe; }

        /* Mobile Nav Toggle */
        .mobile-menu-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border: none;
            background: transparent;
            color: #4b5563;
            cursor: pointer;
            border-radius: 8px;
        }
        
        .mobile-menu-btn:hover { background: #f3f4f6; }

        @media (min-width: 768px) {
            .mobile-menu-btn { display: none; }
        }

        /* Mobile Nav Menu */
        .mobile-nav {
            display: none;
            position: absolute;
            top: 70px;
            left: 0;
            width: 100%;
            background: #fff;
            border-bottom: 1px solid #e5e7eb;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            padding: 12px 16px;
            z-index: 99;
        }

        .mobile-nav.open { display: flex; flex-direction: column; gap: 4px; }

        .mobile-nav a {
            padding: 10px 16px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            color: #111827;
            text-decoration: none;
        }

        .mobile-nav a:hover { background: #f3f4f6; }
        .mobile-nav a.active { color: #0284c7; background: #e0f2fe; }

        .nav-right {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-btn {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 6px 8px;
            border-radius: 50px;
            background: transparent;
            cursor: pointer;
            transition: background 0.15s;
            border: none;
        }

        .user-btn:hover { background: #f3f4f6; }

        /* Avatar: seragam dengan figma */
        .avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: #e0f2fe;
            color: #0369a1;
            font-size: 14px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            overflow: hidden;
            letter-spacing: 0;
        }

        @media (min-width: 640px) {
            .avatar { width: 38px; height: 38px; font-size: 15px; }
        }

        .avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }

        .user-info { text-align: left; display: none; }
        
        @media (min-width: 640px) {
            .user-info { display: block; }
        }

        .user-name { font-size: 13px; font-weight: 600; color: #111827; line-height: 1.3; }
        .user-role { font-size: 11px; color: #9ca3af; }

        .chevron-icon {
            width: 16px;
            height: 16px;
            color: #9ca3af;
            flex-shrink: 0;
            display: none;
        }

        @media (min-width: 640px) {
            .chevron-icon { display: block; }
        }

        /* ── DROPDOWN ── */
        .user-wrapper { position: relative; }

        .dropdown {
            display: none;
            position: absolute;
            top: calc(100% + 8px);
            right: 0;
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.10);
            min-width: 180px;
            z-index: 200;
            overflow: hidden;
        }

        .dropdown.open { display: block; }

        .dropdown-header {
            padding: 12px 16px;
            border-bottom: 1px solid #f3f4f6;
        }

        .dropdown-header .d-name { font-size: 13px; font-weight: 600; color: #111827; }
        .dropdown-header .d-role { font-size: 11px; color: #9ca3af; margin-top: 2px; }

        .dropdown-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 16px;
            font-size: 13px;
            font-weight: 500;
            color: #374151;
            cursor: pointer;
            border: none;
            background: none;
            width: 100%;
            text-align: left;
            text-decoration: none;
            transition: background 0.12s;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .dropdown-item:hover { background: #f4f6fb; }
        .dropdown-item.logout { color: #dc2626; }
        .dropdown-item.logout:hover { background: #fef2f2; }

        .dropdown-item svg {
            width: 16px;
            height: 16px;
            flex-shrink: 0;
            fill: none;
            stroke: currentColor;
            stroke-width: 1.8;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        /* ── PAGE CONTENT ── */
        .page-content {
            max-width: 960px;
            margin: 0 auto;
            padding: 16px 16px;
        }
        
        @media (min-width: 640px) {
            .page-content { padding: 28px 24px; }
        }

    </style>

    @yield('styles')
</head>
<body>

    {{-- NAVBAR (satu file, tidak diulang di setiap page) --}}
    <nav class="navbar">
        <div class="nav-left">
            <button class="mobile-menu-btn" onclick="toggleMobileNav()">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="3" y1="12" x2="21" y2="12"></line>
                    <line x1="3" y1="6" x2="21" y2="6"></line>
                    <line x1="3" y1="18" x2="21" y2="18"></line>
                </svg>
            </button>
            <a href="{{ route('dashboard') }}" class="brand">
                <div class="brand-logo">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo IPWIJA"
                         onerror="this.style.display='none'; this.parentNode.innerHTML='<span style=\'color:#fff;font-size:11px;font-weight:700;\'>IP</span>'">
                </div>
                <div class="brand-text">IPWIJA<br>SmartLab</div>
            </a>
        </div>

        <div class="nav-links">
            <a href="{{ route('dashboard') }}" @class(['active' => request()->routeIs('dashboard')])>Dashboard</a>
            <a href="{{ route('katalog') }}" @class(['active' => request()->routeIs('katalog')])>Katalog Alat</a>
            <a href="{{ route('keranjang') }}" @class(['active' => request()->routeIs('keranjang')])>Keranjang</a>
            <a href="{{ route('peminjaman') }}" @class(['active' => request()->routeIs('peminjaman*')])>Peminjaman Saya</a>
            <a href="{{ route('profil') }}" @class(['active' => request()->routeIs('profil')])>Profil</a>
        </div>
        
        <div class="mobile-nav" id="mobileNav">
            <a href="{{ route('dashboard') }}" @class(['active' => request()->routeIs('dashboard')])>Dashboard</a>
            <a href="{{ route('katalog') }}" @class(['active' => request()->routeIs('katalog')])>Katalog Alat</a>
            <a href="{{ route('keranjang') }}" @class(['active' => request()->routeIs('keranjang')])>Keranjang</a>
            <a href="{{ route('peminjaman') }}" @class(['active' => request()->routeIs('peminjaman*')])>Peminjaman Saya</a>
            <a href="{{ route('profil') }}" @class(['active' => request()->routeIs('profil')])>Profil</a>
        </div>

        <div class="nav-right">
            <div class="user-wrapper">
                <div class="user-btn" onclick="toggleDropdown()" id="userBtn">
                    {{-- Avatar: foto profil atau inisial huruf pertama nama --}}
                    <div class="avatar" id="navbarAvatar">
                        @if(auth()->user()->foto_profil)
                            <img src="{{ asset('storage/' . auth()->user()->foto_profil) }}" alt="Foto Profil">
                        @else
                            {{ strtoupper(substr(auth()->user()->nama_lengkap ?? auth()->user()->name ?? 'U', 0, 1)) }}
                        @endif
                    </div>
                    <div class="user-info">
                        <div class="user-name">{{ auth()->user()->nama_lengkap ?? auth()->user()->name ?? 'Guest' }}</div>
                        {{-- FIX: kolom 'role' tidak ada di tabel users. Role sebenarnya disimpan di kolom 'name' --}}
                        <div class="user-role">{{ ucfirst(auth()->user()->name ?? 'Mahasiswa') }}</div>
                    </div>
                    <svg class="chevron-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="6 9 12 15 18 9"/>
                    </svg>
                </div>
                <div class="dropdown" id="dropdown">
                    <div class="dropdown-header">
                        <div class="d-name">{{ auth()->user()->nama_lengkap ?? auth()->user()->name ?? 'Guest' }}</div>
                        {{-- FIX: kolom 'role' tidak ada di tabel users. Role sebenarnya disimpan di kolom 'name' --}}
                        <div class="d-role">{{ ucfirst(auth()->user()->name ?? 'Mahasiswa') }}</div>
                    </div>
                    <button class="dropdown-item logout" onclick="triggerLogout()">
                        <svg viewBox="0 0 24 24">
                            <path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/>
                            <polyline points="16 17 21 12 16 7"/>
                            <line x1="21" y1="12" x2="9" y2="12"/>
                        </svg>
                        Logout
                    </button>
                </div>
            </div>
        </div>
    </nav>

    {{-- PAGE CONTENT (diisi oleh @section('content') di masing-masing page) --}}
    <div class="page-content">
        @yield('content')
    </div>

    {{-- Form Logout CSRF --}}
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <script>
        function toggleMobileNav() {
            document.getElementById('mobileNav').classList.toggle('open');
        }

        function toggleDropdown() {
            document.getElementById('dropdown').classList.toggle('open');
        }

        // Tutup dropdown jika klik di luar
        document.addEventListener('click', function(e) {
            const btn = document.getElementById('userBtn');
            const dd  = document.getElementById('dropdown');
            if (btn && dd && !btn.contains(e.target) && !dd.contains(e.target)) {
                dd.classList.remove('open');
            }
        });

        function triggerLogout() {
            document.getElementById('dropdown').classList.remove('open');
            Swal.fire({
                title: 'Yakin ingin keluar?',
                text: 'Kamu akan keluar dari sesi akun SmartLab IPWIJA.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#9ca3af',
                confirmButtonText: 'Ya, Keluar!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logout-form').submit();
                }
            });
        }
    </script>

    @yield('scripts')

</body>
</html>
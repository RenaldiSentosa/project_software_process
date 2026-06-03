<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Mahasiswa - IPWIJA SmartLab</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        /* CSS RESET GLOBAL */
        *, *::before, *::after { 
            box-sizing: border-box; 
            margin: 0; 
            padding: 0; 
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #f8f9fa;
            color: #111827;
            min-height: 100vh;
        }

        /* 1. COMPONENT NAVBAR UTAMA */
        .navbar {
            background: #fff;
            border-bottom: 1px solid #e5e7eb;
            padding: 0 40px;
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .nav-left { 
            display: flex; 
            align-items: center; 
            gap: 40px; 
        }
        
        .brand { 
            display: flex; 
            align-items: center; 
            gap: 12px; 
            text-decoration: none; 
        }
        .brand-logo { 
            width: 34px; 
            height: 34px; 
            border-radius: 50%; 
            overflow: hidden; 
            flex-shrink: 0; 
        }
        .brand-logo img { 
            width: 100%; 
            height: 100%; 
            object-fit: contain; 
        }
        .brand-text { 
            font-size: 12px; 
            font-weight: 700; 
            color: #111827; 
            line-height: 1.2; 
            text-transform: uppercase; 
        }
        .brand-subtext { 
            font-weight: 400; 
            color: #6b7280; 
            text-transform: none; 
        }
        
        .nav-links { 
            display: flex; 
            align-items: center; 
            gap: 8px; 
        }
        .nav-links a {
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            color: #4b5563;
            text-decoration: none;
            transition: all 0.15s ease;
        }
        .nav-links a:hover {
            color: #111827;
            background: #f3f4f6;
        }
        /* State Aktif Halaman Profil */
        .nav-links a.active { 
            color: #008ecc; 
            background: #e0f2fe; 
        }

        /* 2. DROPDOWN PROFIL POJOK KANAN */
        .user-profile-wrapper {
            position: relative;
        }

        .user-profile-trigger {
            display: flex;
            align-items: center;
            gap: 12px;
            cursor: pointer;
            padding: 6px 14px;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            user-select: none;
            background: #fff;
            transition: background 0.15s ease;
        }
        .user-profile-trigger:hover {
            background: #f9fafb;
        }

        .avatar-blue-circle {
            width: 36px;
            height: 36px;
            background: #e0f2fe;
            color: #008ecc;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 14px;
        }

        .user-meta-data {
            display: flex;
            flex-direction: column;
        }
        .meta-name {
            font-size: 13px;
            font-weight: 700;
            color: #111827;
        }
        .meta-role {
            font-size: 11px;
            color: #6b7280;
            margin-top: 1px;
        }

        .arrow-toggle-icon {
            width: 14px;
            height: 14px;
            color: #6b7280;
            margin-left: 6px;
            transition: transform 0.2s ease;
        }

        .user-profile-wrapper.show .arrow-toggle-icon {
            transform: rotate(180deg);
        }

        .custom-dropdown-box {
            position: absolute;
            right: 0;
            top: calc(100% + 8px);
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            width: 200px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.08), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
            display: none;
            flex-direction: column;
            padding: 12px 0 6px 0;
            z-index: 999;
        }

        .user-profile-wrapper.show .custom-dropdown-box {
            display: flex;
        }

        .dropdown-identity {
            padding: 4px 18px 12px 18px;
            display: flex;
            flex-direction: column;
        }
        .dropdown-identity .id-name {
            font-size: 14px;
            font-weight: 700;
            color: #111827;
        }
        .dropdown-identity .id-role {
            font-size: 12px;
            color: #6b7280;
            margin-top: 2px;
        }

        .custom-dropdown-box .logout-btn-custom {
            padding: 12px 18px;
            font-size: 13px;
            font-weight: 600;
            color: #dc2626;
            text-decoration: none;
            text-align: left;
            background: none;
            border: none;
            border-top: 1px solid #f3f4f6;
            width: 100%;
            font-family: inherit;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 10px;
            border-radius: 0 0 14px 14px;
            transition: background 0.15s ease;
        }
        .custom-dropdown-box .logout-btn-custom svg {
            width: 16px;
            height: 16px;
            stroke: #dc2626;
        }
        .custom-dropdown-box .logout-btn-custom:hover {
            background: #fef2f2;
        }

        /* 3. MAIN LAYOUT SYSTEM */
        .main { 
            max-width: 800px; 
            margin: 0 auto; 
            padding: 40px 20px; 
            display: flex;
            flex-direction: column;
            gap: 24px;
        }

        /* Header Card */
        .page-header {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 24px;
        }
        .page-header h1 { 
            font-size: 20px; 
            font-weight: 700; 
            color: #111827; 
            margin-bottom: 6px; 
        }
        .page-header p  { 
            font-size: 13px; 
            color: #4b5563; 
        }

        /* Alert System Styles */
        .alert {
            padding: 14px 20px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
        }
        .alert-success {
            background: #f0fdf4;
            color: #16a34a;
            border: 1px solid #bbf7d0;
        }
        .alert-danger {
            background: #fef2f2;
            color: #dc2626;
            border: 1px solid #fecaca;
        }

        /* User Identity Intro Card */
        .user-intro-card {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 24px;
            display: flex;
            align-items: center;
            gap: 20px;
        }
        .user-intro-avatar {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            background: #e0f2fe;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }
        .user-intro-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .user-intro-details {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }
        .user-intro-details h2 {
            font-size: 18px;
            font-weight: 700;
            color: #111827;
        }
        .user-intro-details p {
            font-size: 13px;
            color: #6b7280;
        }
        .pill-container {
            display: flex;
            gap: 8px;
            margin-top: 2px;
        }
        .identity-pill {
            background: #f3f4f6;
            color: #4b5563;
            font-size: 11px;
            font-weight: 600;
            padding: 4px 12px;
            border-radius: 20px;
            border: 1px solid #e5e7eb;
        }

        /* Detail Akun Section Grid */
        .section-card {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            overflow: hidden;
        }
        .section-title {
            font-size: 14px;
            font-weight: 700;
            color: #111827;
            padding: 20px 24px;
            border-bottom: 1px solid #e5e7eb;
        }
        
        .info-row {
            display: flex;
            align-items: center;
            gap: 20px;
            padding: 20px 24px;
            border-bottom: 1px solid #e5e7eb;
        }
        .info-row:last-child {
            border-bottom: none;
        }
        
        .info-icon-box {
            width: 44px;
            height: 44px;
            background: #f4f6fb;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            color: #008ecc;
        }
        .info-icon-box svg {
            width: 20px;
            height: 20px;
            fill: none;
            stroke: currentColor;
            stroke-width: 1.5;
        }

        .info-content {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }
        .info-label {
            font-size: 12px;
            font-weight: 500;
            color: #8b93a7;
        }
        .info-value {
            font-size: 14px;
            font-weight: 600;
            color: #111827;
        }

        /* Security Form Controls */
        .form-padding {
            padding: 24px;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        .form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        .form-group label {
            font-size: 12px;
            font-weight: 600;
            color: #111827;
        }
        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }
        .input-wrapper input {
            width: 100%;
            padding: 12px 40px 12px 16px;
            font-family: inherit;
            font-size: 13px;
            color: #111827;
            background: #fff;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            outline: none;
            transition: border-color 0.15s;
        }
        .input-wrapper input:focus {
            border-color: #008ecc;
        }
        .input-wrapper input::placeholder {
            color: #9ca3af;
        }
        .eye-icon {
            position: absolute;
            right: 14px;
            cursor: pointer;
            color: #9ca3af;
            display: flex;
            align-items: center;
        }
        .eye-icon svg {
            width: 18px;
            height: 18px;
            fill: none;
            stroke: currentColor;
            stroke-width: 2;
        }

        /* Action Save Button Component */
        .form-actions {
            display: flex;
            justify-content: flex-end;
            padding: 0 24px 24px 24px;
        }
        .btn-submit {
            background: #008ecc;
            color: #fff;
            border: none;
            padding: 12px 28px;
            font-family: inherit;
            font-size: 13px;
            font-weight: 600;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.15s;
        }
        .btn-submit:hover {
            background: #0077aa;
        }
    </style>
</head>
<body>

    <nav class="navbar">
        <div class="nav-left">
            <a href="{{ route('dashboard') }}" class="brand">
                <div class="brand-logo"><img src="{{ asset('images/logo.png') }}" alt="Logo"></div>
                <div class="brand-text">IPWIJA <span class="brand-subtext">SmartLab</span></div>
            </a>
            <div class="nav-links">
                <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a>
                <a href="{{ route('katalog') }}" class="{{ request()->routeIs('katalog') ? 'active' : '' }}">Katalog Alat</a>
                <a href="{{ route('keranjang') }}" class="{{ request()->routeIs('keranjang') ? 'active' : '' }}">Keranjang</a>
                <a href="{{ route('peminjaman') }}" class="{{ request()->routeIs('peminjaman') ? 'active' : '' }}">Peminjaman Saya</a>
                <a href="{{ route('profil') }}" class="active">Profil</a>
            </div>
        </div>
        
        <div class="user-profile-wrapper" id="customUserWrapper">
            <div class="user-profile-trigger" onclick="toggleCustomDropdown(event)">
                <div class="avatar-blue-circle">{{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}</div>
                <div class="user-meta-data">
                    <span class="meta-name">{{ auth()->user()->name ?? 'User' }}</span>
                    <span class="meta-role">Mahasiswa</span>
                </div>
                <svg class="arrow-toggle-icon" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5"></path>
                </svg>
            </div>

            <div class="custom-dropdown-box">
                <div class="dropdown-identity">
                    <span class="id-name">{{ auth()->user()->name ?? 'User' }}</span>
                    <span class="id-role">Mahasiswa</span>
                </div>
                
                <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                    @csrf
                    <button type="submit" class="logout-btn-custom">
                        <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" />
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <main class="main">
        <div class="page-header">
            <h1>Profil Mahasiswa</h1>
            <p>Informasi akun dan preferensi.</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                {{ $errors->first() }}
            </div>
        @endif

        <div class="user-intro-card">
            <div class="user-intro-avatar">
                <img src="{{ asset('images/avatar-illustration.png') }}" alt="Avatar">
            </div>
            <div class="user-intro-details">
                <h2>{{ auth()->user()->name ?? 'Aprizal' }}</h2>
                <p>{{ auth()->user()->email ?? 'MuhamadAprizal01@gmail.com' }}</p>
                <div class="pill-container">
                    <span class="identity-pill">Mahasiswa</span>
                    <span class="identity-pill">{{ auth()->user()->jurusan ?? 'Teknik Informatika' }}</span>
                </div>
            </div>
        </div>

        <div class="section-card">
            <div class="section-title">Detail Akun</div>
            
            <div class="info-row">
                <div class="info-icon-box">
                    <svg viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Zm6-10.125a1.875 1.875 0 1 1-3.75 0 1.875 1.875 0 0 1 3.75 0Zm1.294 6.336a6.721 6.721 0 0 1-3.17.789 6.721 6.721 0 0 1-3.168-.789 3.376 3.376 0 0 1 6.338 0Z"/></svg>
                </div>
                <div class="info-content">
                    <span class="info-label">NIM</span>
                    <span class="info-value">{{ auth()->user()->nim ?? '202301110011' }}</span>
                </div>
            </div>

            <div class="info-row">
                <div class="info-icon-box">
                    <svg viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75"/></svg>
                </div>
                <div class="info-content">
                    <span class="info-label">Email</span>
                    <span class="info-value">{{ auth()->user()->email ?? 'MuhamadAprizal01@gmail.com' }}</span>
                </div>
            </div>

            <div class="info-row">
                <div class="info-icon-box">
                    <svg viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0 0 12 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18"/></svg>
                </div>
                <div class="info-content">
                    <span class="info-label">Jurusan</span>
                    <span class="info-value">{{ auth()->user()->jurusan ?? 'Teknik Informatika' }}</span>
                </div>
            </div>

            <div class="info-row">
                <div class="info-icon-box">
                    <svg viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z"/></svg>
                </div>
                <div class="info-content">
                    <span class="info-label">Peran</span>
                    <span class="info-value">Mahasiswa / Peminjam</span>
                </div>
            </div>
        </div>

        <div class="section-card">
            <div class="section-title">Keamanan</div>
            
            <form action="{{ route('profil.update') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-padding">
                    <div class="form-group">
                        <label for="password">Password Baru</label>
                        <div class="input-wrapper">
                            <input type="password" id="password" name="password" placeholder="Masukkan password baru" required>
                            <span class="eye-icon" onclick="togglePasswordVisibility('password')">
                                <svg viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/></svg>
                            </span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">Konfirmasi Password Baru</label>
                        <div class="input-wrapper">
                            <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Konfirmasi password baru" required>
                            <span class="eye-icon" onclick="togglePasswordVisibility('password_confirmation')">
                                <svg viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/></svg>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-submit">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </main>

    <script>
        // Mengontrol Aktif Dropdown Pojok Kanan Atas
        function toggleCustomDropdown(event) {
            event.stopPropagation(); 
            const wrapper = document.getElementById('customUserWrapper');
            wrapper.classList.toggle('show');
        }

        // Auto Close Dropdown jika mengklik sembarang tempat
        window.addEventListener('click', function(e) {
            const wrapper = document.getElementById('customUserWrapper');
            if (wrapper && !wrapper.contains(e.target)) {
                wrapper.classList.remove('show');
            }
        });

        // Fitur klik intip password/hide password input
        function togglePasswordVisibility(id) {
            const input = document.getElementById(id);
            if (input.type === "password") {
                input.type = "text";
            } else {
                input.type = "password";
            }
        }
    </script>
</body>
</html>
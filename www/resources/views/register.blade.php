<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - IPWIJA SmartLab</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #e8edf3;
            margin: 0;
            padding: 0;
            overflow: hidden;
        }

        .app-wrapper {
            height: 100vh;
            width: 100vw;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .card {
            display: flex;
            flex-direction: row;
            width: 100%;
            height: 100%;
            background: #fff;
            overflow: hidden;
        }

        /* ── LEFT PANEL ── */
        .left {
            flex: 0 0 58%;
            position: relative;
            overflow: hidden;
            padding: 48px 52px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            background-color: #1a7fd4;
        }

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(rgba(30, 144, 255, 0.45), rgba(20, 110, 210, 0.55));
            z-index: 0;
        }

        .branding, .left-body, .quote {
            position: relative;
            z-index: 1;
        }

        .branding {
            display: flex;
            align-items: center;
            gap: 12px;
            align-self: flex-start;
        }

        .logo-icon {
            width: 44px;
            height: 44px;
            flex-shrink: 0;
            border-radius: 50%;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            background: transparent;
        }

        .logo-icon img {
            width: 44px;
            height: 44px;
            object-fit: contain;
        }

        .logo-text {
            font-size: 12.5px;
            font-weight: 700;
            line-height: 1.25;
            letter-spacing: 0.07em;
            text-transform: uppercase;
            color: #ffffff;
        }

        .left-body {
            margin: auto 0;
            max-width: 90%;
        }

        .left-body h2 {
            font-size: 30px;
            font-weight: 800;
            line-height: 1.25;
            color: #fff;
            margin-bottom: 12px;
            white-space: nowrap;
        }

        .left-body p {
            font-size: 13px;
            line-height: 1.7;
            color: #fff;
            opacity: 0.9;
            margin-bottom: 24px;
        }

        .badges {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .badge {
            background: rgba(255, 255, 255, 0.18);
            border: 1px solid rgba(255, 255, 255, 0.35);
            border-radius: 50px;
            font-size: 12px;
            font-weight: 500;
            padding: 5px 16px;
            color: #fff;
        }

        .quote {
            align-self: flex-end;
            width: 100%;
            font-size: 11.5px;
            font-style: italic;
            line-height: 1.7;
            color: #fff;
            opacity: 0.75;
            border-left: 2px solid rgba(255, 255, 255, 0.4);
            padding-left: 12px;
        }

        /* ── RIGHT PANEL ── */
        .right {
            flex: 1;
            padding: 36px 52px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: #ffffff;
            overflow-y: auto;
        }

        /* TABS ROW — Login/Daftar + Mahasiswa/Dosen sejajar */
        .tabs-row {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 24px;
            flex-wrap: wrap;
        }

        .tabs {
            display: flex;
            width: fit-content;
            border: 1.5px solid #c9cdd4;
            border-radius: 50px;
            overflow: hidden;
            background: #fff;
        }

        .tab {
            padding: 7px 22px;
            font-size: 14px;
            font-weight: 400;
            color: #6b7280;
            text-decoration: none;
            display: inline-block;
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: transparent;
            border: none;
            cursor: pointer;
            line-height: 1.5;
            transition: color 0.15s;
            white-space: nowrap;
        }

        .tab:not(:last-child) {
            border-right: 1.5px solid #c9cdd4;
        }

        .tab.active {
            color: #111827;
            font-weight: 700;
            background: #fff;
        }

        /* LABEL */
        .field-label {
            font-size: 13.5px;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 7px;
            display: block;
        }

        /* FIELD GROUP */
        .field {
            margin-bottom: 14px;
        }

        /* INPUT WRAP */
        .input-wrap {
            display: flex;
            align-items: center;
            border: 1px solid #c9cdd4;
            border-radius: 10px;
            padding: 0 14px;
            height: 46px;
            gap: 10px;
            background: #fff;
            transition: border-color 0.15s, box-shadow 0.15s;
        }

        .input-wrap:focus-within {
            border-color: #2196f3;
            box-shadow: 0 0 0 3px rgba(33, 150, 243, 0.12);
        }

        .input-wrap .ico {
            width: 17px;
            height: 17px;
            flex-shrink: 0;
            fill: none;
            stroke: #9ca3af;
            stroke-width: 1.7;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .input-wrap input,
        .input-wrap select {
            flex: 1;
            border: none;
            outline: none;
            background: transparent;
            font-size: 14px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: #111827;
            appearance: none;
            width: 100%;
        }

        .input-wrap input::placeholder { color: #9ca3af; }
        .input-wrap select.placeholder { color: #9ca3af; }

        .toggle-pw {
            background: none;
            border: none;
            cursor: pointer;
            padding: 0;
            display: flex;
            align-items: center;
            color: #9ca3af;
            flex-shrink: 0;
        }

        .toggle-pw:hover { color: #6b7280; }

        .toggle-pw svg {
            width: 17px;
            height: 17px;
            fill: none;
            stroke: currentColor;
            stroke-width: 1.7;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .error-msg {
            font-size: 12px;
            color: #dc2626;
            margin-top: 5px;
        }

        /* TOMBOL DAFTAR */
        .btn-daftar {
            width: 100%;
            height: 48px;
            background: #2196f3;
            border: none;
            border-radius: 10px;
            color: #fff;
            font-size: 15px;
            font-weight: 600;
            font-family: 'Plus Jakarta Sans', sans-serif;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 18px;
            transition: background 0.15s;
        }

        .btn-daftar:hover { background: #1976d2; }
        .btn-daftar:active { background: #1565c0; }

        .btn-daftar svg {
            width: 18px;
            height: 18px;
            fill: none;
            stroke: #fff;
            stroke-width: 2.2;
            stroke-linecap: round;
            stroke-linejoin: round;
            flex-shrink: 0;
        }

        /* LOGIN LINK */
        .login-link {
            text-align: center;
            font-size: 13.5px;
            color: #6b7280;
            margin-top: 16px;
        }

        .login-link a {
            color: #2196f3;
            font-weight: 600;
            text-decoration: none;
        }

        .login-link a:hover { text-decoration: underline; }

        /* FORM PANEL VISIBILITY */
        .form-panel { display: none; }
        .form-panel.active { display: block; }

        /* STEP BAR */
        .steps {
            display: flex;
            gap: 8px;
            margin-bottom: 18px;
        }

        .step-bar {
            flex: 1;
            height: 4px;
            border-radius: 4px;
            background: #e5e7eb;
            transition: background 0.3s;
        }

        .step-bar.active { background: #2196f3; }

        /* STEP VISIBILITY */
        .step { display: none; }
        .step.active { display: block; }

        .btn-row {
            display: flex;
            gap: 10px;
            margin-top: 8px;
        }

        .btn {
            flex: 1;
            height: 48px;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 600;
            font-family: 'Plus Jakarta Sans', sans-serif;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            border: none;
            transition: background 0.15s;
        }

        .btn-back {
            background: #f0f4f9;
            color: #374151;
        }

        .btn-back:hover { background: #e2e8f0; }

        .btn-primary {
            background: #2196f3;
            color: #fff;
        }

        .btn-primary:hover { background: #1976d2; }
        .btn-primary:active { background: #1565c0; }

        .btn svg {
            width: 18px;
            height: 18px;
            fill: none;
            stroke: currentColor;
            stroke-width: 2.2;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .swal2-popup {
            font-family: 'Plus Jakarta Sans', sans-serif !important;
            border-radius: 16px !important;
        }

        /* RESPONSIVE */
        @media (max-width: 768px) {
            body { overflow-y: auto; }
            .card { flex-direction: column; height: auto; }
            .left { flex: none; height: 260px; padding: 36px 28px; }
            .left-body h2 { white-space: normal; font-size: 22px; }
            .right { padding: 28px 24px; overflow-y: visible; }
            .tabs-row { gap: 8px; }
        }
    </style>
</head>
<body>

<div class="app-wrapper">
    <div class="card">

    {{-- LEFT PANEL --}}
    <div class="left" style="background-image: url('{{ asset('images/GEDUNG IPWIJA.jpg.jpeg') }}'); background-size: cover; background-position: center center; background-repeat: no-repeat; background-color: #1a7fd4;">
        <div class="overlay"></div>

        {{-- A. BRANDING --}}
        <div class="branding">
            <div class="logo-icon">
                <img src="{{ asset('images/logo.png') }}" alt="Logo IPWIJA">
            </div>
            <div class="logo-text">IPWIJA<br>SMARTLAB</div>
        </div>

        {{-- B. KONTEN TENGAH --}}
        <div class="left-body">
            <h2>Bergabung dengan SmartLab IPWIJA</h2>
            <p>Daftar sekarang untuk mengakses katalog alat lab dan mengajukan peminjaman secara online.</p>
            <div class="badges">
                <span class="badge">500+ Alat Lab</span>
                <span class="badge">2,000+ Mahasiswa</span>
            </div>
        </div>

        {{-- C. QUOTE --}}
        <p class="quote">"Inovasi dimulai dari eksperimen. Setiap alat adalah langkah menuju penemuan baru."</p>
    </div>

    {{-- RIGHT PANEL --}}
    <div class="right">

        {{-- TABS ROW: Login/Daftar + Mahasiswa/Dosen --}}
        <div class="tabs-row">
            <div class="tabs">
                <a href="{{ route('login') }}" class="tab">Login</a>
                <a href="{{ route('register') }}" class="tab active">Daftar</a>
            </div>
            <div class="tabs" id="role-tabs">
                <button type="button" class="tab active" id="tab-mahasiswa" onclick="switchRole('mahasiswa')">Mahasiswa</button>
                <button type="button" class="tab" id="tab-dosen" onclick="switchRole('dosen')">Dosen</button>
            </div>
        </div>

        {{-- ══ FORM MAHASISWA ══ --}}
        <div class="form-panel active" id="panel-mahasiswa">
            <form method="POST" action="{{ route('register.proses') }}" id="registerForm">
                @csrf
                <input type="hidden" name="role" value="mahasiswa">

                {{-- STEP 1 --}}
                <div class="step active" id="step1">

                    <div class="field">
                        <label class="field-label" for="nama_lengkap">Nama Mahasiswa</label>
                        <div class="input-wrap">
                            <svg class="ico" viewBox="0 0 24 24">
                                <circle cx="12" cy="7" r="4"/>
                                <path d="M2 21c0-4 4-7 10-7s10 3 10 7"/>
                            </svg>
                            <input type="text" id="nama_lengkap" name="nama_lengkap"
                                value="{{ old('nama_lengkap') }}"
                                placeholder="Nama lengkap mahasiswa"
                                autocomplete="name">
                        </div>
                        @error('nama_lengkap') <p class="error-msg">{{ $message }}</p> @enderror
                    </div>

                    <div class="field">
                        <label class="field-label" for="nim">NIM</label>
                        <div class="input-wrap">
                            <svg class="ico" viewBox="0 0 24 24">
                                <rect x="3" y="4" width="18" height="16" rx="2"/>
                                <path d="M7 8h10M7 12h6"/>
                            </svg>
                            <input type="text" id="nim" name="nim"
                                value="{{ old('nim') }}"
                                placeholder="Nomor induk mahasiswa"
                                autocomplete="off">
                        </div>
                        @error('nim') <p class="error-msg">{{ $message }}</p> @enderror
                    </div>

                    <div class="field">
                        <label class="field-label" for="email">Email Aktif</label>
                        <div class="input-wrap">
                            <svg class="ico" viewBox="0 0 24 24">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                                <polyline points="22,6 12,13 2,6"/>
                            </svg>
                            <input type="email" id="email" name="email"
                                value="{{ old('email') }}"
                                placeholder="Nama@gmail.com"
                                autocomplete="email">
                        </div>
                        @error('email') <p class="error-msg">{{ $message }}</p> @enderror
                    </div>

                    <div class="field">
                        <label class="field-label" for="program_studi">Program Studi</label>
                        <div class="input-wrap">
                            <svg class="ico" viewBox="0 0 24 24">
                                <path d="M12 3L1 9l11 6 9-4.91V17M1 9v6m11-3v6"/>
                            </svg>
                            <select id="program_studi" name="program_studi"
                                class="{{ old('program_studi') ? '' : 'placeholder' }}"
                                onchange="this.classList.remove('placeholder')">
                                <option value="" disabled {{ old('program_studi') ? '' : 'selected' }}>Pilih Program Studi</option>
                                <option value="Teknik Informatika" {{ old('program_studi') == 'Teknik Informatika' ? 'selected' : '' }}>Teknik Informatika</option>
                                <option value="Rekayasa Perangkat Lunak" {{ old('program_studi') == 'Rekayasa Perangkat Lunak' ? 'selected' : '' }}>Rekayasa Perangkat Lunak (RPL)</option>
                                <option value="Sistem Informasi" {{ old('program_studi') == 'Sistem Informasi' ? 'selected' : '' }}>Sistem Informasi</option>
                            </select>
                            <svg class="ico" viewBox="0 0 24 24" style="stroke:#9ca3af; flex-shrink:0;">
                                <polyline points="6 9 12 15 18 9"/>
                            </svg>
                        </div>
                        @error('program_studi') <p class="error-msg">{{ $message }}</p> @enderror
                    </div>

                    <div class="field">
                        <label class="field-label" for="password">Password</label>
                        <div class="input-wrap">
                            <svg class="ico" viewBox="0 0 24 24">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                            </svg>
                            <input type="password" id="password" name="password"
                                placeholder="Minimal 8 karakter"
                                autocomplete="new-password">
                            <button type="button" class="toggle-pw" onclick="togglePw('password')" aria-label="Tampilkan password">
                                <svg viewBox="0 0 24 24">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                    <circle cx="12" cy="12" r="3"/>
                                </svg>
                            </button>
                        </div>
                        @error('password') <p class="error-msg">{{ $message }}</p> @enderror
                    </div>

                    <div class="field">
                        <label class="field-label" for="password_confirmation">Konfirmasi Password</label>
                        <div class="input-wrap">
                            <svg class="ico" viewBox="0 0 24 24">
                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                            </svg>
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                placeholder="Ulangi Password"
                                autocomplete="new-password">
                            <button type="button" class="toggle-pw" onclick="togglePw('password_confirmation')" aria-label="Tampilkan konfirmasi password">
                                <svg viewBox="0 0 24 24">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                    <circle cx="12" cy="12" r="3"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="btn-daftar">
                        <svg viewBox="0 0 24 24">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                            <circle cx="9" cy="7" r="4"/>
                            <line x1="19" y1="8" x2="19" y2="14"/>
                            <line x1="22" y1="11" x2="16" y2="11"/>
                        </svg>
                        Daftar Sekarang
                    </button>

                </div>
            </form>
        </div>

        {{-- ══ FORM DOSEN ══ --}}
        <div class="form-panel" id="panel-dosen">
            <form method="POST" action="{{ route('register.proses') }}">
                @csrf
                <input type="hidden" name="role" value="dosen">

                <div class="field">
                    <label class="field-label" for="nama_dosen">Nama Dosen</label>
                    <div class="input-wrap">
                        <svg class="ico" viewBox="0 0 24 24">
                            <circle cx="12" cy="7" r="4"/>
                            <path d="M2 21c0-4 4-7 10-7s10 3 10 7"/>
                        </svg>
                        <input type="text" id="nama_dosen" name="nama_lengkap"
                            value="{{ old('nama_lengkap') }}"
                            placeholder="Nama lengkap dosen"
                            autocomplete="name">
                    </div>
                    @error('nama_lengkap') <p class="error-msg">{{ $message }}</p> @enderror
                </div>

                <div class="field">
                    <label class="field-label" for="nuptk">NUPTK</label>
                    <div class="input-wrap">
                        <svg class="ico" viewBox="0 0 24 24">
                            <rect x="3" y="4" width="18" height="16" rx="2"/>
                            <path d="M7 8h10M7 12h6"/>
                        </svg>
                        <input type="text" id="nuptk" name="nim"
                            value="{{ old('nim') }}"
                            placeholder="Nomor Unik Pendidik Tenaga Kependidikan"
                            autocomplete="off">
                    </div>
                    @error('nim') <p class="error-msg">{{ $message }}</p> @enderror
                </div>

                <div class="field">
                    <label class="field-label" for="email_dosen">Email Aktif</label>
                    <div class="input-wrap">
                        <svg class="ico" viewBox="0 0 24 24">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                            <polyline points="22,6 12,13 2,6"/>
                        </svg>
                        <input type="email" id="email_dosen" name="email"
                            value="{{ old('email') }}"
                            placeholder="Nama@gmail.com"
                            autocomplete="email">
                    </div>
                    @error('email') <p class="error-msg">{{ $message }}</p> @enderror
                </div>

                <div class="field">
                    <label class="field-label" for="password_dosen">Password</label>
                    <div class="input-wrap">
                        <svg class="ico" viewBox="0 0 24 24">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                        </svg>
                        <input type="password" id="password_dosen" name="password"
                            placeholder="Minimal 8 karakter"
                            autocomplete="new-password">
                        <button type="button" class="toggle-pw" onclick="togglePw('password_dosen')" aria-label="Tampilkan password">
                            <svg viewBox="0 0 24 24">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                        </button>
                    </div>
                    @error('password') <p class="error-msg">{{ $message }}</p> @enderror
                </div>

                <div class="field">
                    <label class="field-label" for="password_confirmation_dosen">Konfirmasi Password</label>
                    <div class="input-wrap">
                        <svg class="ico" viewBox="0 0 24 24">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                        </svg>
                        <input type="password" id="password_confirmation_dosen" name="password_confirmation"
                            placeholder="Ulangi Password"
                            autocomplete="new-password">
                        <button type="button" class="toggle-pw" onclick="togglePw('password_confirmation_dosen')" aria-label="Tampilkan konfirmasi password">
                            <svg viewBox="0 0 24 24">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn-daftar">
                    <svg viewBox="0 0 24 24">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                        <line x1="19" y1="8" x2="19" y2="14"/>
                        <line x1="22" y1="11" x2="16" y2="11"/>
                    </svg>
                    Daftar Sekarang
                </button>

            </form>
        </div>

        <p class="login-link">Sudah Punya Akun? <a href="{{ route('login') }}">Login</a></p>

    </div>
</div>
</div>

<script>
    function togglePw(id) {
        const input = document.getElementById(id);
        input.type = input.type === 'password' ? 'text' : 'password';
    }

    function switchRole(role) {
        // Update tab active state
        document.getElementById('tab-mahasiswa').classList.toggle('active', role === 'mahasiswa');
        document.getElementById('tab-dosen').classList.toggle('active', role === 'dosen');

        // Show/hide form panels
        document.getElementById('panel-mahasiswa').classList.toggle('active', role === 'mahasiswa');
        document.getElementById('panel-dosen').classList.toggle('active', role === 'dosen');
    }

    // Blok Handling Notifikasi dari Backend Laravel Controller
    @if (session('error'))
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: "{{ session('error') }}",
                confirmButtonColor: '#2196f3'
            });
        });
    @endif

    @if ($errors->has('password') || $errors->has('program_studi'))
        document.addEventListener('DOMContentLoaded', function () {
            // Jika error dari form mahasiswa, pastikan panel mahasiswa aktif
            switchRole('mahasiswa');
        });
    @endif
</script>
</body>
</html>
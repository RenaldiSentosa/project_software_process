<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - IPWIJA SmartLab</title>
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
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px 20px;
        }

        .card {
            display: flex;
            flex-direction: row;
            width: 100%;
            max-width: 960px;
            min-height: 600px;
            background: #fff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 8px 40px rgba(0, 0, 0, 0.08);
        }

        /* ── LEFT PANEL ── */
        .left {
            flex: 0 0 42%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 44px 38px;
            color: #fff;
            background:
                linear-gradient(rgba(30, 144, 255, 0.38), rgba(20, 110, 210, 0.48)),
                url('{{ asset("images/Rectangle 15.png") }}') center / cover no-repeat;
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
        }

        .left-body h2 {
            font-size: 28px;
            font-weight: 800;
            line-height: 1.3;
            color: #fff;
            margin-bottom: 12px;
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
            padding: 52px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: #ffffff;
        }

        /* TABS */
        .tabs {
            display: flex;
            width: fit-content;
            margin-bottom: 32px;
            border: 1.5px solid #c9cdd4;
            border-radius: 50px;
            overflow: hidden;
            background: #fff;
        }

        .tab {
            padding: 7px 26px;
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
            margin-bottom: 18px;
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

        .input-wrap input {
            flex: 1;
            border: none;
            outline: none;
            background: transparent;
            font-size: 14px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: #111827;
        }

        .input-wrap input::placeholder {
            color: #9ca3af;
        }

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

        /* TOMBOL LOGIN */
        .btn-login {
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
            margin-top: 26px;
            transition: background 0.15s;
        }

        .btn-login:hover { background: #1976d2; }
        .btn-login:active { background: #1565c0; }

        .btn-login svg {
            width: 18px;
            height: 18px;
            fill: none;
            stroke: #fff;
            stroke-width: 2.2;
            stroke-linecap: round;
            stroke-linejoin: round;
            flex-shrink: 0;
        }

        /* REGISTER LINK */
        .register-link {
            text-align: center;
            font-size: 13.5px;
            color: #6b7280;
            margin-top: 20px;
        }

        .register-link a {
            color: #2196f3;
            font-weight: 600;
            text-decoration: none;
        }

        .register-link a:hover { text-decoration: underline; }

        /* RESPONSIVE */
        @media (max-width: 768px) {
            .card { flex-direction: column; min-height: auto; }
            .left { flex: none; min-height: 300px; padding: 36px 28px; }
            .right { padding: 36px 28px; }
            .left-body h2 { font-size: 22px; }
        }
    </style>
</head>
<body>

<div class="card">

    {{-- LEFT PANEL --}}
    <div class="left">
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
        <div class="tabs">
            <a href="{{ route('login') }}" class="tab active">Login</a>
            <a href="{{ route('register') }}" class="tab">Daftar</a>
        </div>

        <form method="POST" action="{{ route('login.proses') }}">
            @csrf

            <label class="field-label" for="login_input">Email/NIM/NUPTK</label>
            <div class="input-wrap">
                <svg class="ico" viewBox="0 0 24 24">
                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                    <polyline points="22,6 12,13 2,6"/>
                </svg>
                <input
                    type="text"
                    id="login_input"
                    name="login_input"
                    placeholder="Masukan Email/NIM/NUPTK"
                    value="{{ old('login_input') }}"
                    autocomplete="username"
                    required
                >
            </div>

            <label class="field-label" for="password">Password</label>
            <div class="input-wrap">
                <svg class="ico" viewBox="0 0 24 24">
                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                    <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                </svg>
                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Masukan Password"
                    autocomplete="current-password"
                    required
                >
                <button type="button" class="toggle-pw" onclick="togglePw()" aria-label="Tampilkan/sembunyikan password">
                    <svg viewBox="0 0 24 24">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                        <circle cx="12" cy="12" r="3"/>
                    </svg>
                </button>
            </div>

            <button type="submit" class="btn-login">
                <svg viewBox="0 0 24 24">
                    <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/>
                    <polyline points="10 17 15 12 10 7"/>
                    <line x1="15" y1="12" x2="3" y2="12"/>
                </svg>
                Login
            </button>
        </form>

        <p class="register-link">Belum punya akun? <a href="{{ route('register') }}">Registrasi</a></p>
    </div>
</div>

<script>
    // 1. Fungsi toggle show/hide password
    function togglePw() {
        const input = document.getElementById('password');
        input.type = input.type === 'password' ? 'text' : 'password';
    }

    // 2. SweetAlert Integrasi dari Session Laravel
    document.addEventListener('DOMContentLoaded', function() {
        // Jika ada error validasi atau login gagal dari Laravel ($errors)
        @if ($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Login Gagal',
                text: '{{ $errors->first() }}',
                confirmButtonColor: '#2196f3',
                fontFamily: 'Plus Jakarta Sans'
            });
        @endif

        // Jika ada flash message sukses (misal setelah registrasi atau logout)
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: '{{ session('success') }}',
                confirmButtonColor: '#2196f3',
                fontFamily: 'Plus Jakarta Sans'
            });
        @endif
    });
</script>
</body>
</html>
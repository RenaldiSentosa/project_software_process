<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - IPWIJA SmartLab</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #f0f4f9;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }

        .card {
            display: flex;
            width: 100%;
            max-width: 900px;
            min-height: 520px;
            background: #fff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 8px 40px rgba(0,0,0,0.10);
        }

        /* LEFT PANEL */
        .left {
            flex: 0 0 42%;
            background:
                linear-gradient(rgba(10,50,110,0.70), rgba(5,35,85,0.80)),
                url('{{ asset("images/Rectangle 15.png") }}') center/cover no-repeat;
            color: #fff;
            display: flex;
            flex-direction: column;
            padding: 32px 28px;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: auto;
        }

        .logo-icon {
            width: 46px;
            height: 46px;
            border-radius: 50%;
            border: 1.5px solid rgba(255,255,255,0.45);
            background: rgba(255,255,255,0.12);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .logo-text {
            font-size: 13px;
            font-weight: 600;
            line-height: 1.4;
            letter-spacing: 0.03em;
        }

        .left-body h2 {
            font-size: 20px;
            font-weight: 600;
            line-height: 1.4;
            margin-bottom: 10px;
        }

        .left-body p {
            font-size: 13px;
            opacity: 0.82;
            line-height: 1.7;
            margin-bottom: 18px;
        }

        .badges {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            margin-bottom: 20px;
        }

        .badge {
            background: rgba(255,255,255,0.15);
            border: 0.5px solid rgba(255,255,255,0.3);
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
            padding: 5px 13px;
        }

        .quote {
            font-size: 11.5px;
            opacity: 0.55;
            font-style: italic;
            line-height: 1.6;
        }

        /* RIGHT PANEL */
        .right {
            flex: 1;
            padding: 40px 36px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .tabs {
            display: flex;
            gap: 4px;
            background: #f0f4f9;
            border-radius: 10px;
            padding: 4px;
            width: fit-content;
            margin-bottom: 24px;
        }

        .tab {
            padding: 7px 22px;
            border-radius: 7px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            border: none;
            background: transparent;
            color: #6b7280;
            text-decoration: none;
            transition: all 0.18s;
        }

        .tab.active,
        .tab:hover {
            background: #fff;
            color: #111827;
            box-shadow: 0 1px 4px rgba(0,0,0,0.08);
        }

        /* Fields */
        .field { margin-bottom: 18px; }

        .field label {
            font-size: 13px;
            font-weight: 500;
            color: #374151;
            display: block;
            margin-bottom: 7px;
        }

        .input-wrap {
            display: flex;
            align-items: center;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            padding: 0 13px;
            height: 44px;
            gap: 9px;
            background: #fff;
            transition: border-color 0.15s, box-shadow 0.15s;
        }

        .input-wrap:focus-within {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37,99,235,0.12);
        }

        .input-wrap svg {
            width: 18px;
            height: 18px;
            flex-shrink: 0;
            color: #9ca3af;
            fill: none;
            stroke: currentColor;
            stroke-width: 1.8;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .input-wrap input {
            border: none;
            outline: none;
            background: transparent;
            font-size: 14px;
            font-family: inherit;
            flex: 1;
            color: #111827;
            width: 100%;
        }

        .input-wrap input::placeholder { color: #9ca3af; }

        .toggle-pw {
            background: none;
            border: none;
            cursor: pointer;
            padding: 0;
            display: flex;
            align-items: center;
            color: #9ca3af;
        }

        .toggle-pw svg {
            width: 18px;
            height: 18px;
            fill: none;
            stroke: currentColor;
            stroke-width: 1.8;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        /* Alert Status */
        .alert-error {
            background: #fef2f2;
            border: 1px solid #fecaca;
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 13px;
            color: #dc2626;
            margin-bottom: 16px;
        }

        .alert-success {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 13px;
            color: #16a34a;
            margin-bottom: 16px;
        }

        .btn-primary {
            width: 100%;
            height: 44px;
            background: #2563eb;
            border: none;
            border-radius: 10px;
            color: #fff;
            font-size: 15px;
            font-weight: 600;
            font-family: inherit;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: background 0.15s;
            margin-top: 6px;
        }

        .btn-primary:hover { background: #1d4ed8; }
        .btn-primary:active { transform: scale(0.99); }

        .register-link {
            text-align: center;
            font-size: 13px;
            color: #6b7280;
            margin-top: 20px;
        }

        .register-link a {
            color: #2563eb;
            text-decoration: none;
            font-weight: 600;
        }

        .register-link a:hover { text-decoration: underline; }

        @media (max-width: 640px) {
            .card { flex-direction: column; }
            .left { flex: none; min-height: 220px; }
            .right { padding: 28px 22px; }
        }
    </style>
</head>
<body>

<div class="card">

    {{-- LEFT PANEL --}}
    <div class="left">
        <div class="logo">
            <div class="logo-icon">
                <img src="{{ asset('images/logo.png') }}" style="width:36px; height:36px; object-fit:contain;">
            </div>
            <div class="logo-text">IPWIJA<br>SMARTLAB</div>
        </div>

        <div class="left-body">
            <h2>Sistem Informasi Laboratorium</h2>
            <p>Satu akun untuk mengelola peminjaman alat praktik dan memantau ketersediaan inventaris ruang lab komputer.</p>
            <div class="badges">
                <span class="badge">Efisien</span>
                <span class="badge">Real-time</span>
            </div>
            <p class="quote">"Kemudahan manajemen laboratorium berada dalam genggaman Anda."</p>
        </div>
    </div>

    {{-- RIGHT PANEL --}}
    <div class="right">

        {{-- LINK TAB ATAS AKAN BERGANTIAN SECARA LANCAR --}}
        <div class="tabs">
            <a href="{{ route('login') }}" class="tab active">Login</a>
            <a href="{{ route('register') }}" class="tab">Daftar</a>
        </div>

        {{-- Alert kalau ada registrasi sukses --}}
        @if (session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        {{-- Alert kalau login gagal --}}
        @if ($errors->has('login_error'))
            <div class="alert-error">{{ $errors->first('login_error') }}</div>
        @endif

        <form method="POST" action="{{ route('login.proses') }}">
            @csrf

            {{-- Input Email / NIM --}}
            <div class="field">
                <label for="login_input">Email atau NIM</label>
                <div class="input-wrap">
                    <svg viewBox="0 0 24 24"><circle cx="12" cy="7" r="4"/><path d="M2 21c0-4 4-7 10-7s10 3 10 7"/></svg>
                    <input type="text" id="login_input" name="login_input" value="{{ old('login_input') }}" placeholder="Masukkan Email atau NIM Anda" required autocomplete="username">
                </div>
            </div>

            {{-- Input Password --}}
            <div class="field">
                <label for="password">Password</label>
                <div class="input-wrap">
                    <svg viewBox="0 0 24 24"><rect x="5" y="11" width="14" height="10" rx="2"/><path d="M8 11V7a4 4 0 018 0v4"/></svg>
                    <input type="password" id="password" name="password" placeholder="Masukkan password Anda" required autocomplete="current-password">
                    <button type="button" class="toggle-pw" onclick="togglePw()">
                        <svg id="eye-icon" viewBox="0 0 24 24"><path d="M1 12S5 4 12 4s11 8 11 8-4 8-11 8S1 12 1 12z"/><circle cx="12" cy="12" r="3"/></svg>
                    </button>
                </div>
            </div>

            <button type="submit" class="btn-primary">
                Masuk ke Akun
            </button>
        </form>

        {{-- LINK REGISTER BAGIAN BAWAH AKAN LANGSUNG MASUK KE HALAMAN REGISTER --}}
        <p class="register-link">
            Belum punya akun? <a href="{{ route('register') }}">Registrasi</a>
        </p>

    </div>
</div>

<script>
    function togglePw() {
        const input = document.getElementById('password');
        input.type = input.type === 'password' ? 'text' : 'password';
    }
</script>

</body>
</html>
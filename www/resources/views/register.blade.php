<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - IPWIJA SmartLab</title>
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
            margin-bottom: 20px;
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

        /* Step progress bar */
        .steps {
            display: flex;
            gap: 6px;
            margin-bottom: 24px;
        }

        .step-bar {
            flex: 1;
            height: 4px;
            border-radius: 4px;
            background: #e5e7eb;
            transition: background 0.3s;
        }

        .step-bar.active { background: #2563eb; }

        /* Fields */
        .field { margin-bottom: 16px; }

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

        .input-wrap input,
        .input-wrap select {
            border: none;
            outline: none;
            background: transparent;
            font-size: 14px;
            font-family: inherit;
            flex: 1;
            color: #111827;
            appearance: none;
            width: 100%;
        }

        .input-wrap input::placeholder,
        .input-wrap select.placeholder { color: #9ca3af; }

        .select-wrap {
            position: relative;
        }

        .select-wrap .chevron {
            pointer-events: none;
            flex-shrink: 0;
        }

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

        .error-msg {
            font-size: 12px;
            color: #dc2626;
            margin-top: 5px;
        }

        .alert-error {
            background: #fef2f2;
            border: 1px solid #fecaca;
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 13px;
            color: #dc2626;
            margin-bottom: 16px;
        }

        /* Buttons */
        .btn-row {
            display: flex;
            gap: 10px;
            margin-top: 4px;
        }

        .btn {
            flex: 1;
            height: 44px;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 600;
            font-family: inherit;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: background 0.15s;
            border: none;
        }

        .btn-back {
            background: #f0f4f9;
            color: #374151;
        }

        .btn-back:hover { background: #e5e7eb; }

        .btn-primary {
            background: #2563eb;
            color: #fff;
        }

        .btn-primary:hover { background: #1d4ed8; }
        .btn-primary:active { transform: scale(0.99); }

        .btn svg {
            width: 18px;
            height: 18px;
            fill: none;
            stroke: currentColor;
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .login-link {
            text-align: center;
            font-size: 13px;
            color: #6b7280;
            margin-top: 16px;
        }

        .login-link a {
            color: #2563eb;
            text-decoration: none;
            font-weight: 600;
        }

        .login-link a:hover { text-decoration: underline; }

        /* Step visibility */
        .step { display: none; }
        .step.active { display: block; }

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
            <h2>Bergabung dengan SmartLab IPWIJA</h2>
            <p>Daftar sekarang untuk mengakses katalog alat lab dan mengajukan peminjaman secara online.</p>
            <div class="badges">
                <span class="badge">500+ Alat Lab</span>
                <span class="badge">2,000+ Mahasiswa</span>
            </div>
            <p class="quote">"Inovasi dimulai dari eksperimen. Setiap alat adalah langkah menuju penemuan baru."</p>
        </div>
    </div>

    {{-- RIGHT PANEL --}}
    <div class="right">

        <div class="tabs">
            <a href="{{ route('login') }}" class="tab">Login</a>
            <a href="{{ route('register') }}" class="tab active">Daftar</a>
        </div>

        {{-- Step progress --}}
        <div class="steps">
            <div class="step-bar active" id="bar1"></div>
            <div class="step-bar" id="bar2"></div>
        </div>

        @if (session('error'))
            <div class="alert-error">{{ session('error') }}</div>
        @endif

        {{-- Action kita arahkan ke route register.proses --}}
        <form method="POST" action="{{ route('register.proses') }}" id="registerForm">
            @csrf

            {{-- STEP 1 --}}
            <div class="step active" id="step1">

                <div class="field">
                    <label for="nama_lengkap">Nama Mahasiswa</label>
                    <div class="input-wrap">
                        <svg viewBox="0 0 24 24"><circle cx="12" cy="7" r="4"/><path d="M2 21c0-4 4-7 10-7s10 3 10 7"/></svg>
                        {{-- Name diubah jadi nama_lengkap --}}
                        <input type="text" id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap') }}" placeholder="Nama lengkap mahasiswa" autocomplete="name">
                    </div>
                    @error('nama_lengkap') <p class="error-msg">{{ $message }}</p> @enderror
                </div>

                <div class="field">
                    <label for="nim">NIM</label>
                    <div class="input-wrap">
                        <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="16" rx="2"/><path d="M7 8h10M7 12h6"/></svg>
                        <input type="text" id="nim" name="nim" value="{{ old('nim') }}" placeholder="Contoh: 202301110011" autocomplete="off">
                    </div>
                    @error('nim') <p class="error-msg">{{ $message }}</p> @enderror
                </div>

                <div class="field">
                    <label for="email">Email Aktif</label>
                    <div class="input-wrap">
                        <svg viewBox="0 0 24 24"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="M2 7l10 7 10-7"/></svg>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="Nama@gmail.com" autocomplete="email">
                    </div>
                    @error('email') <p class="error-msg">{{ $message }}</p> @enderror
                </div>

                <div class="btn-row">
                    <button type="button" class="btn btn-primary" onclick="goStep2()">
                        Lanjut
                        <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                    </button>
                </div>

            </div>

            {{-- STEP 2 --}}
            <div class="step" id="step2">

                <div class="field">
                    <label for="password">Password</label>
                    <div class="input-wrap">
                        <svg viewBox="0 0 24 24"><rect x="5" y="11" width="14" height="10" rx="2"/><path d="M8 11V7a4 4 0 018 0v4"/></svg>
                        <input type="password" id="password" name="password" placeholder="Minimal 6 karakter" autocomplete="new-password">
                        <button type="button" class="toggle-pw" onclick="togglePw('password')">
                            <svg viewBox="0 0 24 24"><path d="M1 12S5 4 12 4s11 8 11 8-4 8-11 8S1 12 1 12z"/><circle cx="12" cy="12" r="3"/></svg>
                        </button>
                    </div>
                    @error('password') <p class="error-msg">{{ $message }}</p> @enderror
                </div>

                <div class="field">
                    <label for="password_confirmation">Konfirmasi Password</label>
                    <div class="input-wrap">
                        <svg viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                        <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Ulangi Password" autocomplete="new-password">
                        <button type="button" class="toggle-pw" onclick="togglePw('password_confirmation')">
                            <svg viewBox="0 0 24 24"><path d="M1 12S5 4 12 4s11 8 11 8-4 8-11 8S1 12 1 12z"/><circle cx="12" cy="12" r="3"/></svg>
                        </button>
                    </div>
                </div>

                <div class="field">
                    <label for="program_studi">Program Studi</label>
                    <div class="input-wrap select-wrap">
                        <svg viewBox="0 0 24 24"><path d="M12 3L1 9l11 6 9-4.91V17M1 9v6m11-3v6"/></svg>
                        {{-- Name diubah jadi program_studi --}}
                        <select id="program_studi" name="program_studi" class="{{ old('program_studi') ? '' : 'placeholder' }}" onchange="this.classList.remove('placeholder')">
                            <option value="" disabled {{ old('program_studi') ? '' : 'selected' }}>Pilih Program Studi</option>
                            <option value="Teknik Informatika" {{ old('program_studi') == 'Teknik Informatika' ? 'selected' : '' }}>Teknik Informatika</option>
                            <option value="Rekayasa Perangkat Lunak" {{ old('program_studi') == 'Rekayasa Perangkat Lunak' ? 'selected' : '' }}>Rekayasa Perangkat Lunak (RPL)</option>
                            <option value="Sistem Informasi" {{ old('program_studi') == 'Sistem Informasi' ? 'selected' : '' }}>Sistem Informasi</option>
                        </select>
                        <svg class="chevron" viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"/></svg>
                    </div>
                    @error('program_studi') <p class="error-msg">{{ $message }}</p> @enderror
                </div>

                <div class="btn-row">
                    <button type="button" class="btn btn-back" onclick="goStep1()">
                        <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                        Kembali
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                        Daftar
                    </button>
                </div>

            </div>

        </form>

        <p class="login-link">
            Sudah Punya Akun? <a href="{{ route('login') }}">Login</a>
        </p>

    </div>
</div>

<script>
    function goStep2() {
        const nama = document.getElementById('nama_lengkap').value.trim();
        const nim = document.getElementById('nim').value.trim();
        const email = document.getElementById('email').value.trim();
        
        if (!nama || !nim || !email) {
            alert('Harap isi semua field terlebih dahulu.');
            return;
        }
        
        document.getElementById('step1').classList.remove('active');
        document.getElementById('step2').classList.add('active');
        document.getElementById('bar1').classList.add('active');
        document.getElementById('bar2').classList.add('active');
    }

    function goStep1() {
        document.getElementById('step2').classList.remove('active');
        document.getElementById('step1').classList.add('active');
        document.getElementById('bar2').classList.remove('active');
    }

    function togglePw(id) {
        const input = document.getElementById(id);
        input.type = input.type === 'password' ? 'text' : 'password';
    }

    // LOGIKA OTOMATIS: Jika ada error di Step 2 setelah reload/submit, otomatis buka Step 2
    @if ($errors->has('password') || $errors->has('program_studi'))
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById('step1').classList.remove('active');
            document.getElementById('step2').classList.add('active');
            document.getElementById('bar1').classList.add('active');
            document.getElementById('bar2').classList.add('active');
        });
    @endif
</script>

</body>
</html>
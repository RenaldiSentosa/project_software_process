@extends('layouts.mahasiswa')

@section('title', 'Profil - IPWIJA SmartLab')

@section('styles')
<style>
    .main-content { max-width: 800px; margin: 0 auto; display: flex; flex-direction: column; gap: 24px; }

    .page-header { background: #fff; border: 1px solid #e5e7eb; border-radius: 12px; padding: 24px; }
    .page-header h1 { font-size: 20px; font-weight: 700; color: #111827; margin-bottom: 6px; }
    .page-header p  { font-size: 13px; color: #4b5563; }

    .alert { padding: 14px 20px; border-radius: 8px; font-size: 13px; font-weight: 600; }
    .alert-success { background: #f0fdf4; color: #16a34a; border: 1px solid #bbf7d0; }
    .alert-danger  { background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; }

    .user-intro-card { background: #fff; border: 1px solid #e5e7eb; border-radius: 12px; padding: 24px; display: flex; align-items: center; gap: 20px; }

    .avatar-upload-wrapper { position: relative; flex-shrink: 0; }
    .user-intro-avatar { width: 72px; height: 72px; border-radius: 50%; background: #e0f2fe; display: flex; align-items: center; justify-content: center; overflow: hidden; border: 3px solid #e5e7eb; cursor: pointer; transition: border-color 0.15s; }
    .user-intro-avatar:hover { border-color: #2563eb; }
    .user-intro-avatar img { width: 100%; height: 100%; object-fit: cover; }
    .avatar-upload-overlay { position: absolute; bottom: 0; right: 0; width: 24px; height: 24px; background: #2563eb; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; border: 2px solid #fff; transition: background 0.15s; }
    .avatar-upload-overlay:hover { background: #1d4ed8; }
    .avatar-upload-overlay svg { width: 12px; height: 12px; fill: none; stroke: #fff; stroke-width: 2.5; }
    #fotoProfilInput { display: none; }

    .user-intro-details { display: flex; flex-direction: column; gap: 6px; }
    .user-intro-details h2 { font-size: 18px; font-weight: 700; color: #111827; }
    .user-intro-details p { font-size: 13px; color: #6b7280; }
    .pill-container { display: flex; gap: 8px; margin-top: 2px; }
    .identity-pill { background: #f3f4f6; color: #4b5563; font-size: 11px; font-weight: 600; padding: 4px 12px; border-radius: 20px; border: 1px solid #e5e7eb; }

    .section-card { background: #fff; border: 1px solid #e5e7eb; border-radius: 12px; overflow: hidden; }
    .section-title { font-size: 14px; font-weight: 700; color: #111827; padding: 20px 24px; border-bottom: 1px solid #e5e7eb; }

    .info-row { display: flex; align-items: center; gap: 20px; padding: 20px 24px; border-bottom: 1px solid #e5e7eb; }
    .info-row:last-child { border-bottom: none; }
    .info-icon-box { width: 44px; height: 44px; background: #f4f6fb; border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; color: #2563eb; }
    .info-icon-box svg { width: 20px; height: 20px; fill: none; stroke: currentColor; stroke-width: 1.5; }
    .info-content { display: flex; flex-direction: column; gap: 2px; }
    .info-label { font-size: 12px; font-weight: 500; color: #8b93a7; }
    .info-value { font-size: 14px; font-weight: 600; color: #111827; }

    .form-padding { padding: 24px; display: flex; flex-direction: column; gap: 20px; }
    .form-group { display: flex; flex-direction: column; gap: 8px; }
    .form-group label { font-size: 12px; font-weight: 600; color: #111827; }
    .input-wrapper { position: relative; display: flex; align-items: center; }
    .input-wrapper input { width: 100%; padding: 12px 40px 12px 16px; font-family: inherit; font-size: 13px; color: #111827; background: #fff; border: 1px solid #d1d5db; border-radius: 8px; outline: none; transition: border-color 0.15s; }
    .input-wrapper input:focus { border-color: #2563eb; }
    .input-wrapper input::placeholder { color: #9ca3af; }
    .eye-icon { position: absolute; right: 14px; cursor: pointer; color: #9ca3af; display: flex; align-items: center; }
    .eye-icon svg { width: 18px; height: 18px; fill: none; stroke: currentColor; stroke-width: 2; }

    .form-actions { display: flex; justify-content: flex-end; padding: 0 24px 24px 24px; }
    .btn-submit { background: #2563eb; color: #fff; border: none; padding: 12px 28px; font-family: inherit; font-size: 13px; font-weight: 600; border-radius: 8px; cursor: pointer; transition: background 0.15s; }
    .btn-submit:hover { background: #1d4ed8; }
</style>
@endsection

@section('content')
@php
    $roleRaw   = auth()->user()->role ?? 'Mahasiswa';
    $isDosen   = strtolower($roleRaw) === 'dosen';
    $nimLabel  = $isDosen ? 'NUPTK' : 'NIM';
    $peranText = $isDosen ? 'Dosen / Peminjam' : 'Mahasiswa / Peminjam';
@endphp
<div class="main-content">
    <div class="page-header">
        <h1>Profil {{ $isDosen ? 'Dosen' : 'Mahasiswa' }}</h1>
        <p>Informasi akun dan preferensi.</p>
    </div>

    {{-- Form Upload Foto Profil --}}
    <form action="{{ route('profil.foto') }}" method="POST" enctype="multipart/form-data" id="fotoForm">
        @csrf
        @method('PUT')
        <input type="file" id="fotoProfilInput" name="foto_profil" accept="image/*">
    </form>

    <div class="user-intro-card">
        <div class="avatar-upload-wrapper">
            <div class="user-intro-avatar" onclick="document.getElementById('fotoProfilInput').click()">
                @if(auth()->user()->foto_profil)
                    <img id="previewFoto" src="{{ asset('storage/' . auth()->user()->foto_profil) }}" alt="Avatar">
                    <div id="initialAvatar" style="display: none; width: 100%; height: 100%; align-items: center; justify-content: center; font-size: 28px; font-weight: 700; color: #0369a1;">
                        {{ strtoupper(substr(auth()->user()->nama_lengkap ?? auth()->user()->name ?? 'U', 0, 1)) }}
                    </div>
                @else
                    <img id="previewFoto" src="" alt="Avatar" style="display: none;">
                    <div id="initialAvatar" style="display: flex; width: 100%; height: 100%; align-items: center; justify-content: center; font-size: 28px; font-weight: 700; color: #0369a1;">
                        {{ strtoupper(substr(auth()->user()->nama_lengkap ?? auth()->user()->name ?? 'U', 0, 1)) }}
                    </div>
                @endif
            </div>
            <div class="avatar-upload-overlay" onclick="document.getElementById('fotoProfilInput').click()">
                <svg viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0ZM18.75 10.5h.008v.008h-.008V10.5Z"/>
                </svg>
            </div>
        </div>
        <div class="user-intro-details">
            <h2>{{ auth()->user()->nama_lengkap ?? 'Guest User' }}</h2>
            <p>{{ auth()->user()->email }}</p>
            <div class="pill-container">
                <span class="identity-pill">{{ $isDosen ? 'Dosen' : 'Mahasiswa' }}</span>
                <span class="identity-pill">{{ $isDosen ? '-' : (auth()->user()->program_studi ?? 'Teknik Informatika') }}</span>
            </div>
        </div>
    </div>

    <div class="section-card">
        <div class="section-title">Detail Akun</div>

        <div class="info-row">
            <div class="info-icon-box"><svg viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 9h3.75M15 12h3.75M15 15h3.75M4.5 19.5h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Zm6-10.125a1.875 1.875 0 1 1-3.75 0 1.875 1.875 0 0 1 3.75 0Zm1.294 6.336a6.721 6.721 0 0 1-3.17.789 6.721 6.721 0 0 1-3.168-.789 3.376 3.376 0 0 1 6.338 0Z"/></svg></div>
            <div class="info-content"><span class="info-label">{{ $nimLabel }}</span><span class="info-value">{{ auth()->user()->nim ?? '-' }}</span></div>
        </div>
        <div class="info-row">
            <div class="info-icon-box"><svg viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75"/></svg></div>
            <div class="info-content"><span class="info-label">Email</span><span class="info-value">{{ auth()->user()->email }}</span></div>
        </div>
        <div class="info-row">
            <div class="info-icon-box"><svg viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0 0 12 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18"/></svg></div>
            <div class="info-content"><span class="info-label">Program Studi</span><span class="info-value">{{ $isDosen ? '-' : (auth()->user()->program_studi ?? 'Teknik Informatika') }}</span></div>
        </div>
        <div class="info-row">
            <div class="info-icon-box"><svg viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z"/></svg></div>
            <div class="info-content"><span class="info-label">Peran</span><span class="info-value">{{ $peranText }}</span></div>
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
                        <input type="password" id="password" name="password" placeholder="Kosongkan jika tidak ingin mengubah password">
                        <span class="eye-icon" onclick="togglePasswordVisibility('password')">
                            <svg viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/></svg>
                        </span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="password_confirmation">Konfirmasi Password Baru</label>
                    <div class="input-wrapper">
                        <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Kosongkan jika tidak ingin mengubah password">
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
</div>
@endsection

@section('scripts')
<script>
    @if(session('success'))
        Swal.fire({ icon: 'success', title: 'Berhasil!', text: "{{ session('success') }}", confirmButtonColor: '#2563eb' });
    @endif
    @if($errors->any())
        Swal.fire({ icon: 'error', title: 'Oops...', text: "{{ $errors->first() }}", confirmButtonColor: '#2563eb' });
    @endif

    function togglePasswordVisibility(id) {
        const input = document.getElementById(id);
        input.type = input.type === "password" ? "text" : "password";
    }

    document.getElementById('fotoProfilInput').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (!file) return;

        if (file.size > 2 * 1024 * 1024) {
            Swal.fire({ icon: 'error', title: 'File terlalu besar', text: 'Ukuran foto maksimal 2MB.', confirmButtonColor: '#2563eb' });
            return;
        }

        const reader = new FileReader();
        reader.onload = function(ev) {
            document.getElementById('previewFoto').src = ev.target.result;
            document.getElementById('previewFoto').style.display = 'block';
            const initial = document.getElementById('initialAvatar');
            if(initial) initial.style.display = 'none';
        };
        reader.readAsDataURL(file);

        document.getElementById('fotoForm').submit();
    });
</script>
@endsection
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - IPWIJA SmartLab</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #f4f6fb;
            color: #111827;
            min-height: 100vh;
        }

        /* NAVBAR */
        .navbar {
            background: #fff;
            border-bottom: 1px solid #e5e7eb;
            padding: 0 32px;
            height: 56px;
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
            gap: 32px;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }

        .brand-logo {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            overflow: hidden;
            flex-shrink: 0;
        }

        .brand-logo img { width: 100%; height: 100%; object-fit: contain; }

        .brand-text {
            font-size: 13px;
            font-weight: 700;
            color: #111827;
            line-height: 1.3;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .nav-links a {
            padding: 6px 14px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            color: #6b7280;
            text-decoration: none;
            transition: all 0.15s;
        }

        .nav-links a:hover { background: #f4f6fb; color: #111827; }
        .nav-links a.active { color: #2563eb; background: #eff6ff; font-weight: 600; }

        .nav-right {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 5px 10px 5px 5px;
            border-radius: 10px;
            border: 1px solid #e5e7eb;
            background: #fff;
            cursor: pointer;
            transition: background 0.15s;
        }

        .user-btn:hover { background: #f4f6fb; }

        .avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: #dbeafe;
            color: #2563eb;
            font-size: 13px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .user-info { text-align: left; }
        .user-name { font-size: 13px; font-weight: 600; color: #111827; line-height: 1.3; }
        .user-role { font-size: 11px; color: #9ca3af; }

        .chevron-icon {
            width: 16px;
            height: 16px;
            color: #9ca3af;
            flex-shrink: 0;
        }

        /* MAIN */
        .main {
            max-width: 960px;
            margin: 0 auto;
            padding: 28px 24px;
        }

        /* GREETING */
        .greeting {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            padding: 20px 24px;
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 20px;
        }

        .greeting-avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: #dbeafe;
            color: #2563eb;
            font-size: 18px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .greeting h2 { font-size: 16px; font-weight: 600; margin-bottom: 4px; }
        .greeting p { font-size: 13px; color: #6b7280; }

        /* STAT CARDS */
        .stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
            margin-bottom: 20px;
        }

        .stat-card {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 16px;
        }

        .stat-icon {
            width: 34px;
            height: 34px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 10px;
        }

        .stat-icon svg {
            width: 18px;
            height: 18px;
            fill: none;
            stroke: currentColor;
            stroke-width: 1.8;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .stat-icon.orange { background: #fff7ed; color: #f97316; }
        .stat-icon.blue   { background: #eff6ff; color: #2563eb; }
        .stat-icon.green  { background: #f0fdf4; color: #16a34a; }
        .stat-icon.purple { background: #f5f3ff; color: #7c3aed; }

        .stat-value { font-size: 22px; font-weight: 600; margin-bottom: 2px; }
        .stat-label { font-size: 12px; color: #6b7280; font-weight: 500; }
        .stat-sub   { font-size: 11px; color: #9ca3af; margin-top: 2px; }

        /* SECTION */
        .section {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            padding: 20px 24px;
            margin-bottom: 20px;
        }

        .section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 16px;
        }

        .section-title { font-size: 15px; font-weight: 600; }

        .lihat-semua {
            font-size: 13px;
            color: #2563eb;
            text-decoration: none;
            font-weight: 500;
        }

        .lihat-semua:hover { text-decoration: underline; }

        /* PEMINJAMAN LIST (HEADER-DETAIL MATCHING PDF SPEC) */
        .pinjam-list { display: flex; flex-direction: column; gap: 0; }

        .pinjam-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 0;
            border-bottom: 1px solid #f3f4f6;
        }

        .pinjam-item:last-child { border-bottom: none; }

        .pinjam-info h4 { font-size: 14px; font-weight: 600; margin-bottom: 3px; color: #111827; }
        .pinjam-info .meta-desc { font-size: 12px; color: #4b5563; margin-bottom: 2px; }
        .pinjam-info .meta-time { font-size: 11px; color: #9ca3af; }

        .badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .badge-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
        }

        /* Badge color mappings matching Database Spec ENUM */
        .badge.menunggu      { background: #fff7ed; color: #f97316; }
        .badge.menunggu .badge-dot   { background: #f97316; }
        
        .badge.disetujui      { background: #eff6ff; color: #2563eb; }
        .badge.disetujui .badge-dot  { background: #2563eb; }

        .badge.dipinjam      { background: #f5f3ff; color: #7c3aed; }
        .badge.dipinjam .badge-dot   { background: #7c3aed; }
        
        .badge.ditolak       { background: #fef2f2; color: #dc2626; }
        .badge.ditolak .badge-dot    { background: #dc2626; }
        
        .badge.dikembalikan { background: #f0fdf4; color: #16a34a; }
        .badge.dikembalikan .badge-dot { background: #16a34a; }

        /* AKSI CEPAT */
        .aksi-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
        }

        .aksi-card {
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 16px;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 14px;
            transition: all 0.15s;
        }

        .aksi-card:hover { border-color: #bfdbfe; background: #f8fbff; }

        .aksi-icon {
            width: 42px;
            height: 42px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .aksi-icon svg {
            width: 20px;
            height: 20px;
            fill: none;
            stroke: currentColor;
            stroke-width: 1.8;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .aksi-icon.blue   { background: #eff6ff; color: #2563eb; }
        .aksi-icon.purple { background: #f5f3ff; color: #7c3aed; }
        .aksi-icon.orange { background: #fff7ed; color: #f97316; }

        .aksi-text h4 { font-size: 13px; font-weight: 600; margin-bottom: 3px; color: #111827; }
        .aksi-text p  { font-size: 12px; color: #9ca3af; }

        /* DROPDOWN */
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

        /* MODAL */
        .modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.45);
            z-index: 500;
            align-items: center;
            justify-content: center;
        }

        .modal-overlay.open { display: flex; }

        .modal {
            background: #fff;
            border-radius: 16px;
            padding: 28px 28px 24px;
            width: 100%;
            max-width: 340px;
            text-align: center;
            box-shadow: 0 16px 48px rgba(0,0,0,0.15);
        }

        .modal-icon {
            width: 48px;
            height: 48px;
            background: #fef2f2;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px;
        }

        .modal-icon svg {
            width: 22px;
            height: 22px;
            fill: none;
            stroke: #dc2626;
            stroke-width: 1.8;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .modal h3 { font-size: 16px; font-weight: 600; margin-bottom: 8px; }
        .modal p  { font-size: 13px; color: #6b7280; margin-bottom: 24px; }

        .modal-btns { display: flex; gap: 10px; }

        .modal-btn {
            flex: 1;
            height: 40px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            font-family: inherit;
            cursor: pointer;
            border: none;
            transition: background 0.15s;
        }

        .modal-btn.cancel  { background: #f3f4f6; color: #374151; }
        .modal-btn.cancel:hover  { background: #e5e7eb; }
        .modal-btn.confirm { background: #dc2626; color: #fff; }
        .modal-btn.confirm:hover { background: #b91c1c; }

        @media (max-width: 640px) {
            .stats { grid-template-columns: repeat(2, 1fr); }
            .nav-links { display: none; }
            .aksi-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

    {{-- NAVBAR --}}
    <nav class="navbar">
        <div class="nav-left">
            <a href="{{ route('dashboard') }}" class="brand">
                <div class="brand-logo">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo IPWIJA">
                </div>
                <div class="brand-text">IPWIJA<br>SmartLab</div>
            </a>
            <div class="nav-links">
                <a href="{{ route('dashboard') }}" class="active">Dashboard</a>
                <a href="{{ route('katalog') }}">Katalog Alat</a>
                <a href="{{ route('keranjang') }}">Keranjang</a>
                <a href="{{ route('peminjaman') }}">Peminjaman Saya</a>
                <a href="{{ route('profil') }}">Profil</a>
            </div>
        </div>
        <div class="nav-right">
            <div class="user-wrapper">
                <div class="user-btn" onclick="toggleDropdown()" id="userBtn">
                    <div class="avatar">{{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}</div>
                    <div class="user-info">
                        <div class="user-name">{{ auth()->user()->name ?? 'Aprizal' }}</div>
                        <div class="user-role">Mahasiswa</div>
                    </div>
                    <svg class="chevron-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="6 9 12 15 18 9"/>
                    </svg>
                </div>
                <div class="dropdown" id="dropdown">
                    <div class="dropdown-header">
                        <div class="d-name">{{ auth()->user()->name ?? 'Aprizal' }}</div>
                        <div class="d-role">Mahasiswa</div>
                    </div>
                    <button class="dropdown-item logout" onclick="openLogoutModal()">
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

    {{-- MAIN --}}
    <main class="main">

        {{-- Greeting --}}
        <div class="greeting">
            <div class="greeting-avatar">{{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}</div>
            <div>
                <h2>Halo, {{ auth()->user()->name ?? 'Aprizal' }}!</h2>
                <p>Selamat datang di Portal Peminjaman Lab. Ada banyak alat tersedia untuk dipinjam.</p>
            </div>
        </div>

        {{-- Stat Cards - Disesuaikan dengan Target Riil Enum Status Database --}}
        <div class="stats">
            <div class="stat-card">
                <div class="stat-icon orange">
                    <svg viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"/><rect x="9" y="3" width="6" height="4" rx="1"/></svg>
                </div>
                <div class="stat-value">{{ $total_peminjaman ?? '0' }}</div>
                <div class="stat-label">Total Pengajuan</div>
                <div class="stat-sub">Semua riwayat</div>
            </div>

            <div class="stat-card">
                <div class="stat-icon blue">
                    <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                </div>
                <div class="stat-value">{{ $total_menunggu ?? '0' }}</div>
                <div class="stat-label">Menunggu Review</div>
                <div class="stat-sub">Butuh approval admin</div>
            </div>

            <div class="stat-card">
                <div class="stat-icon green">
                    <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                </div>
                <div class="stat-value{{ ($total_terlambat ?? 0) > 0 ? ' text-red-600' : '' }}">{{ $total_dipinjam ?? '0' }}</div>
                <div class="stat-label">Sedang Dipinjam</div>
                <div class="stat-sub">Ada di tanganmu</div>
            </div>

            <div class="stat-card">
                <div class="stat-icon purple">
                    <svg viewBox="0 0 24 24"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2"/></svg>
                </div>
                <div class="stat-value">{{ $total_selesai ?? '0' }}</div>
                <div class="stat-label">Sudah Kembali</div>
                <div class="stat-sub">Transaksi beres</div>
            </div>
        </div>

        {{-- Peminjaman Terbaru (Berbasis Grouping Keranjang Sesuai PDF SRS) --}}
        <div class="section">
            <div class="section-header">
                <span class="section-title">Aktivitas Peminjaman Terbaru</span>
                <a href="{{ route('peminjaman') }}" class="lihat-semua">Lihat Semua</a>
            </div>

            <div class="pinjam-list">
                @forelse ($peminjaman ?? [] as $item)
                    <div class="pinjam-item">
                        <div class="pinjam-info">
                            <h4>ID Transaksi: #{{ $item->id ?? 'TRX-001' }}</h4>
                            <p class="meta-desc">Keperluan: {{ $item->keperluan ?? 'Praktikum Jaringan Komputer' }} ({{ $item->items_count ?? 3 }} Jenis Alat)</p>
                            <p class="meta-time">Rencana Pinjam: {{ $item->tanggal_pinjam ?? '2026-05-10' }} s/d {{ $item->tanggal_kembali ?? '2026-05-15' }}</p>
                        </div>
                        <span class="badge {{ strtolower($item->status ?? 'menunggu') }}">
                            <span class="badge-dot"></span>
                            {{ ucfirst($item->status ?? 'Menunggu') }}
                        </span>
                    </div>
                @empty
                    {{-- Dummy Data yang strukturnya sudah disamakan dengan logical Database Header-Detail --}}
                    <div class="pinjam-item">
                        <div class="pinjam-info">
                            <h4>ID Transaksi: #LMS-20260510-02</h4>
                            <p class="meta-desc">Keperluan: Tugas Akhir Splicing Fiber Optic (3 Jenis Alat)</p>
                            <p class="meta-time">Rencana Pinjam: 2026-05-10 s/d 2026-05-15</p>
                        </div>
                        <span class="badge dipinjam"><span class="badge-dot"></span> Dipinjam</span>
                    </div>
                    <div class="pinjam-item">
                        <div class="pinjam-info">
                            <h4>ID Transaksi: #LMS-20260514-05</h4>
                            <p class="meta-desc">Keperluan: Uji Coba Mikrotik Router VTP (1 Jenis Alat)</p>
                            <p class="meta-time">Rencana Pinjam: 2026-05-15 s/d 2026-05-18</p>
                        </div>
                        <span class="badge menunggu"><span class="badge-dot"></span> Menunggu</span>
                    </div>
                    <div class="pinjam-item">
                        <div class="pinjam-info">
                            <h4>ID Transaksi: #LMS-20260502-01</h4>
                            <p class="meta-desc">Keperluan: Praktikum Mandiri Sistem Operasi (2 Jenis Alat)</p>
                            <p class="meta-time">Rencana Pinjam: 2026-05-02 s/d 2026-05-05</p>
                        </div>
                        <span class="badge dikembalikan"><span class="badge-dot"></span> Dikembalikan</span>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Aksi Cepat --}}
        <div class="section">
            <div class="section-header">
                <span class="section-title">Aksi Cepat</span>
            </div>
            <div class="aksi-grid">
                <a href="{{ route('katalog') }}" class="aksi-card">
                    <div class="aksi-icon blue">
                        <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    </div>
                    <div class="aksi-text">
                        <h4>Jelajahi Katalog</h4>
                        <p>Temukan alat lab</p>
                    </div>
                </a>
                <a href="{{ route('keranjang') }}" class="aksi-card">
                    <div class="aksi-icon purple">
                        <svg viewBox="0 0 24 24"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
                    </div>
                    <div class="aksi-text">
                        <h4>Keranjang Anda</h4>
                        <p>Lanjutkan peminjaman</p>
                    </div>
                </a>
                <a href="{{ route('peminjaman') }}" class="aksi-card">
                    <div class="aksi-icon orange">
                        <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    </div>
                    <div class="aksi-text">
                        <h4>Peminjaman Saya</h4>
                        <p>Pantau status log</p>
                    </div>
                </a>
            </div>
        </div>

    </main>

    {{-- MODAL LOGOUT --}}
    <div class="modal-overlay" id="logoutModal">
        <div class="modal">
            <div class="modal-icon">
                <svg viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
            </div>
            <h3>Yakin ingin keluar?</h3>
            <p>Kamu akan keluar dari sesi akun SmartLab IPWIJA.</p>
            <div class="modal-btns">
                <button class="modal-btn cancel" onclick="closeLogoutModal()">Batal</button>
                <form method="POST" action="{{ route('logout') }}" style="flex:1;">
                    @csrf
                    <button type="submit" class="modal-btn confirm" style="width:100%;">Keluar</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function toggleDropdown() {
            document.getElementById('dropdown').classList.toggle('open');
        }

        document.addEventListener('click', function(e) {
            const btn = document.getElementById('userBtn');
            const dd  = document.getElementById('dropdown');
            if (btn && dd && !btn.contains(e.target) && !dd.contains(e.target)) {
                dd.classList.remove('open');
            }
        });

        function openLogoutModal() {
            document.getElementById('dropdown').classList.remove('open');
            document.getElementById('logoutModal').classList.add('open');
        }

        function closeLogoutModal() {
            document.getElementById('logoutModal').classList.remove('open');
        }

        document.getElementById('logoutModal').addEventListener('click', function(e) {
            if (e.target === this) closeLogoutModal();
        });
    </script>

</body>
</html>
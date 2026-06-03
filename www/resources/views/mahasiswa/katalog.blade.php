<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Alat - IPWIJA SmartLab</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600&display=swap" rel="stylesheet">
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
            font-weight: 600;
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
        .nav-links a.active { color: #2563eb; background: #eff6ff; }

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

        /* MODAL LOGOUT */
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

        /* MAIN */
        .main { max-width: 1100px; margin: 0 auto; padding: 28px 24px; }

        /* HEADER */
        .page-header {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            padding: 20px 24px;
            margin-bottom: 20px;
        }

        .page-header h1 { font-size: 18px; font-weight: 600; margin-bottom: 4px; }
        .page-header p  { font-size: 13px; color: #6b7280; }

        /* TOOLBAR */
        .toolbar {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 14px;
        }

        .search-wrap {
            display: flex;
            align-items: center;
            gap: 8px;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            padding: 0 12px;
            height: 38px;
            background: #fff;
            flex: 1;
            max-width: 320px;
            transition: border-color 0.15s, box-shadow 0.15s;
        }

        .search-wrap:focus-within { border-color: #2563eb; box-shadow: 0 0 0 3px rgba(37,99,235,0.10); }
        .search-wrap svg { width: 16px; height: 16px; color: #9ca3af; flex-shrink: 0; fill: none; stroke: currentColor; stroke-width: 1.8; stroke-linecap: round; stroke-linejoin: round; }
        .search-wrap input { border: none; outline: none; background: transparent; font-size: 13px; font-family: inherit; flex: 1; color: #111827; }
        .search-wrap input::placeholder { color: #9ca3af; }

        .select-wrap {
            display: flex;
            align-items: center;
            gap: 6px;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            padding: 0 12px;
            height: 38px;
            background: #fff;
            cursor: pointer;
        }

        .select-wrap select {
            border: none;
            outline: none;
            background: transparent;
            font-size: 13px;
            font-family: inherit;
            color: #374151;
            cursor: pointer;
            appearance: none;
            padding-right: 4px;
        }

        .select-wrap svg { width: 14px; height: 14px; color: #9ca3af; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; pointer-events: none; }

        .btn-filter {
            height: 38px;
            padding: 0 18px;
            background: #2563eb;
            color: #fff;
            border: none;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 600;
            font-family: inherit;
            cursor: pointer;
            transition: background 0.15s;
        }

        .btn-filter:hover { background: #1d4ed8; }

        .count-label { font-size: 13px; color: #6b7280; margin-bottom: 16px; }
        .count-label span { font-weight: 600; color: #111827; }

        /* GRID */
        .grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 14px;
        }

        /* CARD */
        .card {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            overflow: hidden;
            transition: box-shadow 0.15s, border-color 0.15s;
        }

        .card:hover { box-shadow: 0 4px 20px rgba(0,0,0,0.08); border-color: #bfdbfe; }

        .card-img {
            width: 100%;
            height: 130px;
            background: #e0f0ff;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .card-img img { width: 80%; height: 80%; object-fit: contain; }

        .card-badge {
            position: absolute;
            top: 8px;
            left: 8px;
            padding: 3px 8px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
        }

        .card-badge.tersedia  { background: #dcfce7; color: #16a34a; }
        .card-badge.habis     { background: #fef2f2; color: #dc2626; }
        .card-badge.terbatas  { background: #fff7ed; color: #f97316; }

        .card-body { padding: 12px 14px 14px; }
        .card-cat { font-size: 11px; color: #2563eb; font-weight: 600; margin-bottom: 3px; }
        .card-name { font-size: 14px; font-weight: 600; margin-bottom: 8px; }

        .card-stock {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 12px;
            color: #6b7280;
            margin-bottom: 12px;
        }

        .card-stock svg { width: 13px; height: 13px; fill: none; stroke: currentColor; stroke-width: 1.8; stroke-linecap: round; stroke-linejoin: round; }
        .card-stock .stok-habis { color: #dc2626; }
        .card-stock .stok-ok    { color: #16a34a; }

        .btn-keranjang {
            width: 100%;
            height: 34px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
            font-family: inherit;
            cursor: pointer;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            transition: background 0.15s;
        }

        .btn-keranjang svg { width: 14px; height: 14px; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }
        .btn-keranjang.tambah   { background: #eff6ff; color: #2563eb; }
        .btn-keranjang.tambah:hover { background: #dbeafe; }
        .btn-keranjang.ditambah { background: #f0fdf4; color: #16a34a; cursor: default; }
        .btn-keranjang.nonaktif { background: #f3f4f6; color: #9ca3af; cursor: not-allowed; }

        @media (max-width: 900px) { .grid { grid-template-columns: repeat(3, 1fr); } }
        @media (max-width: 640px) { .grid { grid-template-columns: repeat(2, 1fr); .nav-links { display: none; } } }
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
                <a href="{{ route('dashboard') }}">Dashboard</a>
                <a href="{{ route('katalog') }}" class="active">Katalog Alat</a>
                <a href="{{ route('keranjang') }}">Keranjang</a>
                <a href="{{ route('peminjaman') }}">Peminjaman Saya</a>
                <a href="{{ route('profil') }}" class="{{ request()->routeIs('profil') ? 'active' : '' }}">Profil</a>
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
                    </</svg>
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

        {{-- Header --}}
        <div class="page-header">
            <h1>Katalog Alat</h1>
            <p>Jelajahi peralatan lab yang tersedia dan tambahkan ke keranjang peminjaman.</p>
        </div>

        {{-- Toolbar --}}
        <div class="toolbar">
            <div class="search-wrap">
                <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                <input type="text" id="searchInput" placeholder="Cari alat berdasarkan nama..." oninput="filterAlat()">
            </div>
            <div class="select-wrap">
                <select id="kategoriSelect" onchange="filterAlat()">
                    <option value="semua">Semua</option>
                    <option value="hardware">Hardware</option>
                    <option value="network">Network</option>
                    <option value="iot">IoT</option>
                </select>
                <svg viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"/></svg>
            </div>
            <button class="btn-filter" onclick="filterAlat()">Filter</button>
        </div>

        <p class="count-label">Menampilkan <span id="countLabel">0</span> alat</p>

        {{-- Grid --}}
        <div class="grid" id="alatGrid">

            @php
            $alatList = $alat ?? [
                (object) ['nama' => 'Router Cisco', 'kategori' => 'Network', 'lokasi' => 'Workshop', 'stok' => 5, 'status' => 'tersedia', 'cart' => false],
                (object) ['nama' => 'Switch Hub', 'kategori' => 'Network', 'lokasi' => 'Workshop', 'stok' => 5, 'status' => 'tersedia', 'cart' => false],
                (object) ['nama' => 'LAN Tester', 'kategori' => 'Network', 'lokasi' => 'Workshop', 'stok' => 0, 'status' => 'habis',    'cart' => false],
                (object) ['nama' => 'Arduino Uno', 'kategori' => 'IoT', 'lokasi' => 'Laboratorium', 'stok' => 5, 'status' => 'tersedia', 'cart' => true],
                (object) ['nama' => 'Raspberry Pi 4', 'kategori' => 'IoT', 'lokasi' => 'Laboratorium', 'stok' => 5, 'status' => 'tersedia', 'cart' => false],
                (object) ['nama' => 'NodeMCU ESP8266', 'kategori' => 'IoT', 'lokasi' => 'Laboratorium', 'stok' => 2, 'status' => 'terbatas', 'cart' => false],
                (object) ['nama' => 'Tang Crimping', 'kategori' => 'Hardware', 'lokasi' => 'Workshop', 'stok' => 5, 'status' => 'tersedia', 'cart' => false],
                (object) ['nama' => 'Obeng Set', 'kategori' => 'Hardware', 'lokasi' => 'Workshop', 'stok' => 5, 'status' => 'tersedia', 'cart' => true],
            ];
            @endphp

            @foreach ($alatList as $item)
            @php 
                $nama = is_object($item) ? $item->nama : $item['nama'];
                $kategori = is_object($item) ? $item->kategori : $item['kategori'];
                $lokasi = is_object($item) ? $item->lokasi : $item['lokasi'];
                $stok = is_object($item) ? $item->stok : $item['stok'];
                $status = is_object($item) ? $item->status : $item['status'];
                $inCart = is_object($item) ? $item->cart : $item['cart'];
            @endphp
            
            <div class="card" data-nama="{{ strtolower($nama) }}" data-kategori="{{ strtolower($kategori) }}">
                <div class="card-img">
                    <img src="{{ asset('images/router.png') }}" alt="{{ $nama }}" onerror="this.style.display='none'">
                    <span class="card-badge {{ $status }}">
                        {{ ucfirst($status) }}
                    </span>
                </div>
                <div class="card-body">
                    <div class="card-cat">{{ $kategori }}</div>
                    <div class="card-name">{{ $nama }}</div>
                    <div class="card-stock">
                        <svg viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
                        {{ $lokasi }} &nbsp;·&nbsp;
                        @if ($stok == 0)
                            <span class="stok-habis">Stok habis</span>
                        @else
                            <span class="stok-ok">{{ $stok }} stok tersedia</span>
                        @endif
                    </div>
                    
                    @if ($inCart)
                        <button class="btn-keranjang ditambah">
                            <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                            Sudah Ditambah
                        </button>
                    @elseif ($stok == 0)
                        <button class="btn-keranjang nonaktif" disabled>
                            <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                            Stok Habis
                        </button>
                    @else
                        <button class="btn-keranjang tambah" onclick="tambahKeranjang(this)">
                            <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                            Tambah ke keranjang
                        </button>
                    @endif
                </div>
            </div>
            @endforeach

        </div>
    </main>

    {{-- MODAL LOGOUT --}}
    <div class="modal-overlay" id="logoutModal">
        <div class="modal">
            <div class="modal-icon">
                <svg viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
            </div>
            <h3>Yakin mau logout?</h3>
            <p>Kamu akan keluar dari akun SmartLab IPWIJA.</p>
            <div class="modal-btns">
                <button class="modal-btn cancel" onclick="closeLogoutModal()">Batal</button>
                <form method="POST" action="{{ route('logout') }}" style="flex:1;">
                    @csrf
                    <button type="submit" class="modal-btn confirm" style="width:100%;">Ya, Keluar</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            filterAlat();
        });

        // Dropdown user
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

        // Modal logout
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

        // Filter & search (FIXED logic style property)
        function filterAlat() {
            const keyword  = document.getElementById('searchInput').value.toLowerCase();
            const kategori = document.getElementById('kategoriSelect').value.toLowerCase();
            const cards    = document.querySelectorAll('#alatGrid .card');
            let count = 0;

            cards.forEach(card => {
                const nama = card.dataset.nama;
                const kat  = card.dataset.kategori;
                const matchNama = nama.includes(keyword);
                const matchKat  = kategori === 'semua' || kat === kategori;

                if (matchNama && matchKat) {
                    card.style.setProperty('display', '', 'important'); 
                    count++;
                } else {
                    card.style.display = 'none';
                }
            });

            document.getElementById('countLabel').textContent = count;
        }

        // Tambah ke keranjang (UI only)
        function tambahKeranjang(btn) {
            btn.classList.remove('tambah');
            btn.classList.add('ditambah');
            btn.innerHTML = `<svg viewBox="0 0 24 24" style="width:14px;height:14px;fill:none;stroke:currentColor;stroke-width:2;stroke-linecap:round;stroke-linejoin:round"><polyline points="20 6 9 17 4 12"/></svg> Sudah Ditambah`;
            btn.onclick = null;
        }
    </script>
</body>
</html>
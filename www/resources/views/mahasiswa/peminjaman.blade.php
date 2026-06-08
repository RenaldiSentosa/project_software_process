<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peminjaman Saya - IPWIJA SmartLab</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    
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
            font-size: 13px; 
            font-weight: 700; 
            color: #111827; 
            line-height: 1.3;
        }
        
        .nav-links { 
            display: flex; 
            align-items: center; 
            gap: 8px;
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
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
        /* State Menu Navigasi Aktif */
        .nav-links a.active { 
            color: #008ecc; 
            background: #e0f2fe; 
        }

        /* 2. PROFIL POJOK KANAN */
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

        /* MENU BOX DROPDOWN */
        .custom-dropdown-box {
            position: absolute;
            right: 0;
            top: calc(100% + 8px);
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            width: 220px;
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

        /* 3. MAIN SYSTEMS LAYOUT */
        .main { 
            max-width: 1040px; 
            margin: 0 auto; 
            padding: 40px 20px; 
        }

        .page-header {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 24px;
            margin-bottom: 24px;
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

        /* Filter Row Tools */
        .filter-wrapper {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 24px;
        }
        .select-custom {
            position: relative;
            width: 200px;
        }
        .select-custom select {
            width: 100%;
            padding: 10px 36px 10px 16px;
            font-family: inherit;
            font-size: 13px;
            color: #374151;
            background: #fff;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            appearance: none;
            cursor: pointer;
        }
        .select-custom::after {
            content: "";
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            width: 10px;
            height: 6px;
            background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 10 6'%3E%3Cpath stroke='%236B7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m1 1 4 4 4-4'/%3E%3C/svg%3E") no-repeat center;
        }
        .btn-filter {
            background: #008ecc;
            color: #fff;
            border: none;
            padding: 10px 24px;
            font-family: inherit;
            font-size: 13px;
            font-weight: 600;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.15s;
        }
        .btn-filter:hover { 
            background: #0077aa; 
        }

        /* 4. DESIGN CUSTOM DATA TABLE */
        .table-container {
            background: #fff;
            border: 1px solid #d1d5db;
            border-radius: 10px;
            overflow: hidden;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        th {
            background: #fff;
            padding: 12px 16px;
            font-size: 11px;
            font-weight: 600;
            color: #111827;
            border-bottom: 1px solid #d1d5db;
        }

        td {
            padding: 14px 16px;
            font-size: 12px;
            color: #111827;
            border-bottom: 1px solid #e5e7eb;
            background: #fff;
        }
        tr:last-child td { 
            border-bottom: none; 
        }

        /* Sisi Kiri Berdasarkan Status */
        .row-disetujui { border-left: 4px solid #38bdf8; }
        .row-menunggu { border-left: 4px solid #fbbf24; }
        .row-ditolak { border-left: 4px solid #f87171; }
        .row-dikembalikan { border-left: 4px solid #34d399; }
        .row-dipinjam { border-left: 4px solid #a78bfa; }

        /* Badge Pill Bulat Status Row */
        .badge-pill {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: 600;
            border: 1px solid transparent;
        }
        .badge-pill::before {
            content: "";
            width: 5px;
            height: 5px;
            border-radius: 50%;
            display: inline-block;
        }
        
        .badge-pill.disetujui { background: #e0f2fe; color: #0369a1; border-color: #bae6fd; }
        .badge-pill.disetujui::before { background: #0284c7; }

        .badge-pill.menunggu { background: #fef3c7; color: #b45309; border-color: #fde68a; }
        .badge-pill.menunggu::before { background: #d97706; }

        .badge-pill.ditolak { background: #fee2e2; color: #b91c1c; border-color: #fecaca; }
        .badge-pill.ditolak::before { background: #dc2626; }

        .badge-pill.dikembalikan { background: #dcfce7; color: #15803d; border-color: #bbf7d0; }
        .badge-pill.dikembalikan::before { background: #16a34a; }

        .badge-pill.dipinjam { background: #f3e8ff; color: #6b21a8; border-color: #e9d5ff; }
        .badge-pill.dipinjam::before { background: #8b5cf6; }

        /* 5. TOMBOL LIHAT DETAIL FULL ROUNDED PILL */
        .btn-detail {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #e0f2fe;
            border: none;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            color: #008ecc;
            text-decoration: none;
            transition: all 0.15s ease;
        }
        .btn-detail:hover {
            background: #bae6fd;
            color: #0284c7;
        }
        .btn-detail svg { 
            width: 14px; 
            height: 14px; 
            fill: none;
            stroke: currentColor;
            stroke-width: 2;
        }

        /* State Empty Table Styling */
        .empty-table-state {
            padding: 48px 16px;
            text-align: center;
            color: #6b7280;
            font-size: 14px;
        }

        @media(max-width:700px){
            .nav-links { display: none; }
        }
    </style>
</head>
<body>

    <nav class="navbar">
        <div class="nav-left">
            <a href="{{ route('dashboard') }}" class="brand">
                <div class="brand-logo"><img src="{{ asset('images/logo.png') }}" alt="Logo IPWIJA"></div>
                <div class="brand-text">IPWIJA<br>SmartLab</div>
            </a>
        </div>

        <div class="nav-links">
            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a>
            <a href="{{ route('katalog') }}" class="{{ request()->routeIs('katalog') ? 'active' : '' }}">Katalog Alat</a>
            <a href="{{ route('keranjang') }}" class="{{ request()->routeIs('keranjang') ? 'active' : '' }}">Keranjang</a>
            <a href="{{ route('peminjaman') }}" class="{{ request()->routeIs('peminjaman') || request()->is('peminjaman*') ? 'active' : '' }}">Peminjaman Saya</a>
            <a href="{{ route('profil') }}" class="{{ request()->routeIs('profil') ? 'active' : '' }}">Profil</a>
        </div>
        
        <div class="user-profile-wrapper" id="customUserWrapper">
            <div class="user-profile-trigger" onclick="toggleCustomDropdown(event)">
               <div class="avatar">
                        @if(auth()->user()->foto_profil)
                            <img src="{{ asset('storage/' . auth()->user()->foto_profil) }}" style="width:100%;height:100%;object-fit:cover;border-radius:50%;">
                        @else
                            {{ strtoupper(substr(auth()->user()->nama_lengkap ?? 'U', 0, 1)) }}
                        @endif
                    </div>
                <div class="user-meta-data">
                    <span class="meta-name">{{ auth()->user()->nama_lengkap ?? 'Guest User' }}</span>
                    <span class="meta-role">Mahasiswa</span>
                </div>
                <svg class="arrow-toggle-icon" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5"></path>
                </svg>
            </div>

            <div class="custom-dropdown-box">
                <div class="dropdown-identity">
                    <span class="id-name">{{ auth()->user()->nama_lengkap ?? 'Guest User' }}</span>
                    <span class="id-role">Mahasiswa</span>
                </div>

                {{-- Menu Profil Saya dihapus sesuai permintaan --}}

                <form action="{{ route('logout') }}" method="POST" style="margin: 0;" id="logoutForm">
                    @csrf
                    <button type="button" class="logout-btn-custom" onclick="confirmLogout()">
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
            <h1>Peminjaman Saya</h1>
            <p>Pantau status semua permintaan peminjaman peralatan lab Anda secara real-time.</p>
        </div>

        <div class="filter-wrapper">
            <div class="select-custom">
                <select id="statusFilter">
                    <option value="all">Semua Permintaan</option>
                    <option value="menunggu">Menunggu Persetujuan</option>
                    <option value="disetujui">Disetujui</option>
                    <option value="dipinjam">Sedang Dipinjam</option>
                    <option value="dikembalikan">Sudah Dikembalikan</option>
                    <option value="ditolak">Ditolak</option>
                </select>
            </div>
            <button class="btn-filter" onclick="applyFilter()">Filter</button>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th style="width: 15%;">ID Pinjam</th>
                        <th style="width: 25%;">Nama Alat Laboratorium</th>
                        <th style="width: 18%;">Tanggal Pengajuan</th>
                        <th style="width: 25%;">Periode Peminjaman</th>
                        <th style="width: 12%;">Status</th>
                        <th style="width: 10%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($peminjaman as $item)
                    @php 
                        $statusClean = strtolower($item['status']); 
                    @endphp
                    <tr class="table-row row-{{ $statusClean }}" data-status="{{ $statusClean }}">
                        <td style="font-weight: 600; color: #4b5563;">{{ $item['id'] }}</td>
                        <td style="font-weight: 500;">{{ $item['alat'] }}</td>
                        <td>{{ $item['tgl_aju'] }}</td>
                        <td>{{ $item['periode'] }}</td>
                        <td>
                            <span class="badge-pill {{ $statusClean }}">
                                @if($statusClean == 'menunggu')
                                    Menunggu
                                @elseif($statusClean == 'disetujui')
                                    Disetujui
                                @elseif($statusClean == 'dipinjam')
                                    Dipinjam
                                @elseif($statusClean == 'dikembalikan')
                                    Dikembalikan
                                @else
                                    Ditolak
                                @endif
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('peminjaman.detail', $item['id']) }}" class="btn-detail">
                                <svg viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                </svg>
                                Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="empty-table-state">
                            Belum ada riwayat permintaan peminjaman alat.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Catch Notifikasi session flash Laravel & transform to SweetAlert2
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                fontFamily: 'Plus Jakarta Sans',
                confirmButtonColor: '#008ecc'
            });
        @endif

        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: "{{ session('error') }}",
                fontFamily: 'Plus Jakarta Sans',
                confirmButtonColor: '#008ecc'
            });
        @endif

        // Toggle Aktif Buka-Tutup Dropdown Profile
        function toggleCustomDropdown(event) {
            event.stopPropagation(); 
            const wrapper = document.getElementById('customUserWrapper');
            wrapper.classList.toggle('show');
        }

        // Auto Close Dropdown jika diklik sembarang di luar menu
        window.addEventListener('click', function(e) {
            const wrapper = document.getElementById('customUserWrapper');
            if (wrapper && !wrapper.contains(e.target)) {
                wrapper.classList.remove('show');
            }
        });

        // Filter tabel data di sisi frontend
        function applyFilter() {
            const selectedStatus = document.getElementById('statusFilter').value;
            const rows = document.querySelectorAll('.table-row');
            
            rows.forEach(row => {
                if (selectedStatus === 'all' || row.dataset.status === selectedStatus) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        // Konfirmasi SweetAlert2 sebelum Logout
        function confirmLogout() {
            Swal.fire({
                icon: 'warning',
                title: 'Yakin ingin keluar?',
                text: 'Kamu akan keluar dari sesi akun SmartLab IPWIJA.',
                showCancelButton: true,
                confirmButtonText: 'Ya, Keluar!',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                fontFamily: 'Plus Jakarta Sans',
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logoutForm').submit();
                }
            });
        }
    </script>
</body>
</html>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang - IPWIJA SmartLab</title>
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

        .nav-left { display: flex; align-items: center; gap: 32px; }
        .brand { display: flex; align-items: center; gap: 10px; text-decoration: none; }
        .brand-logo { width: 36px; height: 36px; border-radius: 50%; overflow: hidden; flex-shrink: 0; }
        .brand-logo img { width: 100%; height: 100%; object-fit: contain; }
        .brand-text { font-size: 13px; font-weight: 600; color: #111827; line-height: 1.3; }
        .nav-links { display: flex; align-items: center; gap: 4px; }

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
        .nav-right { display: flex; align-items: center; gap: 10px; }
        .user-wrapper { position: relative; }

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
            width: 32px; height: 32px; border-radius: 50%;
            background: #dbeafe; color: #2563eb;
            font-size: 13px; font-weight: 600;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }

        .user-info { text-align: left; }
        .user-name { font-size: 13px; font-weight: 600; color: #111827; line-height: 1.3; }
        .user-role { font-size: 11px; color: #9ca3af; }
        .chevron-icon { width: 16px; height: 16px; color: #9ca3af; flex-shrink: 0; }

        /* DROPDOWN */
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
        .dropdown-header { padding: 12px 16px; border-bottom: 1px solid #f3f4f6; }
        .dropdown-header .d-name { font-size: 13px; font-weight: 600; color: #111827; }
        .dropdown-header .d-role { font-size: 11px; color: #9ca3af; margin-top: 2px; }

        .dropdown-item {
            display: flex; align-items: center; gap: 10px;
            padding: 10px 16px; font-size: 13px; font-weight: 500;
            color: #374151; cursor: pointer; border: none; background: none;
            width: 100%; text-align: left; text-decoration: none;
            transition: background 0.12s;
        }

        .dropdown-item:hover { background: #f4f6fb; }
        .dropdown-item.logout { color: #dc2626; }
        .dropdown-item.logout:hover { background: #fef2f2; }

        .dropdown-item svg {
            width: 16px; height: 16px; flex-shrink: 0;
            fill: none; stroke: currentColor; stroke-width: 1.8;
            stroke-linecap: round; stroke-linejoin: round;
        }

        /* MODAL LOGOUT */
        .modal-overlay {
            display: none; position: fixed; inset: 0;
            background: rgba(0,0,0,0.45); z-index: 500;
            align-items: center; justify-content: center;
        }

        .modal-overlay.open { display: flex; }

        .modal {
            background: #fff; border-radius: 16px; padding: 28px 28px 24px;
            width: 100%; max-width: 340px; text-align: center;
            box-shadow: 0 16px 48px rgba(0,0,0,0.15);
        }

        .modal-icon {
            width: 48px; height: 48px; background: #fef2f2; border-radius: 50%;
            display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;
        }

        .modal-icon svg { width: 22px; height: 22px; fill: none; stroke: #dc2626; stroke-width: 1.8; stroke-linecap: round; stroke-linejoin: round; }
        .modal h3 { font-size: 16px; font-weight: 600; margin-bottom: 8px; }
        .modal p  { font-size: 13px; color: #6b7280; margin-bottom: 24px; }
        .modal-btns { display: flex; gap: 10px; }

        .modal-btn {
            flex: 1; height: 40px; border-radius: 10px;
            font-size: 14px; font-weight: 600; font-family: inherit;
            cursor: pointer; border: none; transition: background 0.15s;
        }

        .modal-btn.cancel  { background: #f3f4f6; color: #374151; }
        .modal-btn.cancel:hover  { background: #e5e7eb; }
        .modal-btn.confirm { background: #dc2626; color: #fff; }
        .modal-btn.confirm:hover { background: #b91c1c; }

        /* MAIN */
        .main {
            max-width: 920px;
            margin: auto;
            padding: 30px 20px;
        }

        /* CARD */
        .card {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            padding: 22px;
            margin-bottom: 18px;
        }

        .title {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 4px;
        }

        .sub {
            font-size: 13px;
            color: #9ca3af;
        }

        /* ALERT FLASH MESSAGES */
        .alert {
            padding: 12px 16px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 500;
            margin-bottom: 18px;
        }
        .alert-danger { background: #fef2f2; color: #dc2626; border: 1px solid #fca5a5; }

        /* ITEM */
        .item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 16px 0;
            border-bottom: 1px solid #eceff4;
        }

        .item:last-child { border: none; }
        .left { display: flex; align-items: center; gap: 14px; }

        .image {
            width: 54px; height: 54px;
            background: #2563eb;
            border-radius: 12px;
            display: flex;
            justify-content: center; align-items: center;
            font-size: 24px;
            color: white;
            overflow: hidden;
        }
        .image img { width: 100%; height: 100%; object-fit: cover; }

        .name { font-size: 14px; font-weight: 600; }
        .cat { font-size: 12px; color: #9ca3af; }
        .right { display: flex; align-items: center; gap: 14px; }
        .qty { display: flex; align-items: center; gap: 10px; }

        .qty button {
            width: 22px; height: 22px;
            border: none;
            background: none;
            cursor: pointer;
            font-size: 15px;
            color: #374151;
        }

        .qty input.jumlah-input {
            width: 30px;
            text-align: center;
            border: none;
            background: transparent;
            font-family: inherit;
            font-size: 14px;
            font-weight: 600;
            color: #111827;
            outline: none;
        }

        /* Menyembunyikan spinner up/down bawaan browser pada input number */
        .qty input.jumlah-input::-webkit-outer-spin-button,
        .qty input.jumlah-input::-webkit-inner-spin-button {
            -webkit-appearance: none; margin: 0;
        }

        .delete {
            cursor: pointer;
            color: #9ca3af;
            font-size: 14px;
            padding: 4px;
            transition: color 0.15s;
        }
        .delete:hover { color: #dc2626; }

        /* DETAIL */
        .header2 { font-size: 18px; font-weight: 600; margin-bottom: 5px; }
        .desc { font-size: 13px; color: #9ca3af; margin-bottom: 20px; }
        .grid { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px; }
        .group { display: flex; flex-direction: column; gap: 8px; }
        .group label { font-size: 13px; font-weight: 600; }

        .group input, textarea {
            padding: 12px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-family: inherit;
            font-size: 13px;
            outline: none;
        }
        .group input:focus, textarea:focus { border-color: #2563eb; }
        textarea { resize: none; height: 110px; }
        .full { grid-column: 1/3; }

        .btn {
            margin-top: 10px;
            background: #2563eb;
            color: white;
            border: none;
            padding: 12px 18px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 13px;
            font-weight: 600;
            transition: background 0.15s;
            width: auto;
        }
        .btn:hover { background: #1d4ed8; }

        .empty-cart {
            text-align: center;
            padding: 40px 20px;
            color: #6b7280;
        }
        .empty-cart p { margin-bottom: 15px; font-size: 14px; }

        @media(max-width:700px){
            .grid { grid-template-columns: 1fr; }
            .full { grid-column: auto; }
            .nav-links { display: none; }
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
                <a href="{{ route('dashboard') }}">Dashboard</a>
                <a href="{{ route('katalog') }}">Katalog Alat</a>
                <a href="{{ route('keranjang') }}" class="active">Keranjang</a>
                <a href="{{ route('peminjaman') }}">Peminjaman Saya</a>
                <a href="{{ route('profil') }}" class="{{ request()->routeIs('profil') ? 'active' : '' }}">Profil</a>
            </div>
        </div>
        <div class="nav-right">
            <div class="user-wrapper">
                <div class="user-btn" onclick="toggleDropdown()" id="userBtn">
                    <div class="avatar">{{ strtoupper(substr(auth()->user()->nama_lengkap ?? auth()->user()->name ?? 'A', 0, 1)) }}</div>
                    <div class="user-info">
                        <div class="user-name">{{ auth()->user()->nama_lengkap ?? auth()->user()->name ?? 'Aprizal' }}</div>
                        <div class="user-role">Mahasiswa</div>
                    </div>
                    <svg class="chevron-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="6 9 12 15 18 9"/>
                    </svg>
                </div>
                <div class="dropdown" id="dropdown">
                    <div class="dropdown-header">
                        <div class="d-name">{{ auth()->user()->nama_lengkap ?? auth()->user()->name ?? 'Aprizal' }}</div>
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
    <div class="main">
        {{-- Flash message jika terjadi validasi error server-side --}}
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div class="card">
            <div class="title">Keranjang Peminjaman</div>
            <div class="sub" id="summaryCount">{{ count($cart ?? []) }} item dipilih</div>
        </div>

        {{-- Form Utama Pembungkus Data sesuai Aturan API Spesifikasi LMS --}}
        <form id="borrowForm" method="POST" action="{{ route('peminjaman.store') }}">
            @csrf

            <div class="card" id="cartCard">
                @if(isset($cart) && count($cart) > 0)
                    @foreach($cart as $id => $details)
                        {{-- Struktur Item Dinamis Mengikuti Data Session/Database --}}
                        <div class="item" data-id="{{ $id }}">
                            <div class="left">
                                <div class="image">
                                    @if(isset($details['foto_alat']) && $details['foto_alat'])
                                        <img src="{{ asset('storage/' . $details['foto_alat']) }}" alt="{{ $details['nama_alat'] }}">
                                    @else
                                        📡
                                    @endif
                                </div>
                                <div>
                                    <div class="name">{{ $details['nama_alat'] ?? 'Nama Alat' }}</div>
                                    <div class="cat">{{ $details['kategori'] ?? 'Kategori' }}</div>
                                    <small style="color: #6b7280;">Tersedia: <span class="max-stok">{{ $details['stok_tersedia'] ?? 0 }}</span> unit</small>
                                </div>
                            </div>
                            <div class="right">
                                <div class="qty">
                                    <button type="button" onclick="minus(this)">−</button>
                                    {{-- Menggunakan input hidden/number agar jumlah_unit dari array item masuk ke request submit --}}
                                    <input type="number" name="items[{{ $id }}][jumlah_unit]" class="jumlah-input" value="{{ $details['jumlah_unit'] ?? 1 }}" min="1" max="{{ $details['stok_tersedia'] ?? 10 }}" readonly>
                                    <button type="button" onclick="plus(this)">+</button>
                                </div>
                                <div class="delete" onclick="hapus(this)">✕</div>
                            </div>
                        </div>
                    @endforeach
                @else
                    {{-- State Tampilan Jika Keranjang Kosong --}}
                    <div class="empty-cart">
                        <p>Keranjang kamu masih kosong dek. Silakan pilih alat di katalog terlebih dahulu.</p>
                        <a href="{{ route('katalog') }}" class="btn" style="text-decoration:none; display:inline-block;">Lihat Katalog Alat</a>
                    </div>
                @endif
            </div>

            {{-- Detail Permintaan Form, Hanya tampil jika item ada --}}
            @if(isset($cart) && count($cart) > 0)
                <div class="card" id="detailCard">
                    <div class="header2">Detail Permintaan</div>
                    <div class="desc">Isi formulir di bawah untuk mengirim permintaan peminjaman.</div>
                    
                    <div class="grid">
                        <div class="group">
                            <label for="tgl_rencana_pinjam">Tanggal Peminjaman *</label>
                            <input type="date" id="tgl_rencana_pinjam" name="tgl_rencana_pinjam" required value="{{ old('tgl_rencana_pinjam') }}">
                        </div>
                        <div class="group">
                            <label for="tgl_rencana_kembali">Tanggal Pengembalian *</label>
                            <input type="date" id="tgl_rencana_kembali" name="tgl_rencana_kembali" required value="{{ old('tgl_rencana_kembali') }}">
                        </div>
                        <div class="group full">
                            <label for="keperluan">Tujuan Penggunaan *</label>
                            <textarea id="keperluan" name="keperluan" placeholder="Jelaskan untuk apa alat ini akan digunakan (projek kursus, penelitian, sesi lab, dll.)" required>{{ old('keperluan') }}</textarea>
                        </div>
                    </div>
                    <button type="submit" class="btn">📝 Kirim Permintaan Peminjaman</button>
                </div>
            @endif
        </form>
    </div>

    {{-- MODAL LOGOUT --}}
    <div class="modal-overlay" id="logoutModal">
        <div class="modal">
            <div class="modal-icon">
                <svg viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
            </div>
            <h3>Yakin mau logout dek??</h3>
            <p>Kamu akan keluar dari akun SmartLab IPWIJA.</p>
            <div class="modal-btns">
                <button type="button" class="modal-btn cancel" onclick="closeLogoutModal()">No</button>
                <form method="POST" action="{{ route('logout') }}" style="flex:1;">
                    @csrf
                    <button type="submit" class="modal-btn confirm" style="width:100%;">Yes</button>
                </form>
            </div>
        </div>
    </div>

    <script>
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

        // Qty Logic (Ditambahkan pengaman batas maksimum stok ketersediaan alat sesuai aturan bisnis)
        function plus(btn){
            let input = btn.parentElement.querySelector('.jumlah-input');
            let maxStok = parseInt(btn.closest('.item').querySelector('.max-stok').innerText);
            let val = parseInt(input.value);
            
            if(val < maxStok) {
                input.value = val + 1;
                // Opsional: lakukan AJAX patch request untuk update session keranjang di server
            } else {
                alert('Jumlah unit tidak boleh melebihi stok yang tersedia saat ini!');
            }
        }

        function minus(btn){
            let input = btn.parentElement.querySelector('.jumlah-input');
            let val = parseInt(input.value);
            if(val > 1){
                input.value = val - 1;
                // Opsional: lakukan AJAX patch request untuk update session keranjang di server
            }
        }

        // Hapus Item dengan penanganan UI dinamis
        function hapus(btn){
            let itemRow = btn.closest('.item');
            let itemId = itemRow.getAttribute('data-id');
            
            // Logika Client-Side Penghapusan Elemen
            itemRow.remove();
            updateCount();

            // Skenario tambahan: Mengirim AJAX request untuk menghapus data item di session backend Laravel
            /*
            fetch(`/keranjang/hapus/${itemId}`, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
            });
            */
        }

        // Update Total Item di UI secara real-time
        function updateCount(){
            let total = document.querySelectorAll('.item').length;
            document.getElementById('summaryCount').innerText = total + " item dipilih";
            
            // Jika item habis, tampilkan layout kosong
            if(total === 0){
                document.getElementById('cartCard').innerHTML = `
                    <div class="empty-cart">
                        <p>Keranjang kamu masih kosong dek. Silakan pilih alat di katalog terlebih dahulu.</p>
                        <a href="{{ route('katalog') }}" class="btn" style="text-decoration:none; display:inline-block;">Lihat Katalog Alat</a>
                    </div>`;
                let detailCard = document.getElementById('detailCard');
                if(detailCard) detailCard.remove();
            }
        }

        // Validasi Sederhana sebelum Submit Form di Client-side
        document.getElementById('borrowForm')?.addEventListener('submit', function(e) {
            let tglPinjam = new Date(document.getElementById('tgl_rencana_pinjam').value);
            let tglKembali = new Date(document.getElementById('tgl_rencana_kembali').value);
            let hariIni = new Date();
            hariIni.setHours(0,0,0,0);

            if(tglPinjam < hariIni) {
                e.preventDefault();
                alert('Tanggal rencana peminjaman tidak boleh di masa lalu!');
                return false;
            }

            if(tglKembali < tglPinjam) {
                e.preventDefault();
                alert('Tanggal pengembalian tidak boleh mendahului tanggal peminjaman!');
                return false;
            }
        });
    </script>
</body>
</html>
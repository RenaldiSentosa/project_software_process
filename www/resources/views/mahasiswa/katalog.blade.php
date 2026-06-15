@extends('layouts.mahasiswa')

@section('title', 'Katalog Alat - IPWIJA SmartLab')

@section('styles')
<style>
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

    /* FILTER TOOLBAR */
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

    /* GRID SYSTEM */
    .grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 14px;
    }

    .empty-state {
        grid-column: span 4;
        background: #fff;
        border: 1px dashed #d1d5db;
        border-radius: 14px;
        padding: 40px;
        text-align: center;
        color: #6b7280;
        font-size: 14px;
    }

    /* CARD COMPONENT */
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
    .btn-keranjang.tambah   { background: #eff6ff; color: #2563eb; width: 100%; }
    .btn-keranjang.tambah:hover { background: #dbeafe; }
    .btn-keranjang.ditambah { background: #f0fdf4; color: #16a34a; cursor: default; }
    .btn-keranjang.nonaktif { background: #f3f4f6; color: #9ca3af; cursor: not-allowed; }

    @media (max-width: 900px) { .grid { grid-template-columns: repeat(3, 1fr); } .empty-state { grid-column: span 3; } }
    @media (max-width: 640px) { .grid { grid-template-columns: repeat(2, 1fr); } .empty-state { grid-column: span 2; } }
</style>
@endsection

@section('content')
    <div class="page-header">
        <h1>Katalog Alat</h1>
        <p>Jelajahi peralatan lab yang tersedia dan tambahkan ke keranjang peminjaman.</p>
    </div>

    {{-- Toolbar Filter & Cari --}}
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

    {{-- Grid Card Alat --}}
    <div class="grid" id="alatGrid">
        @php
            $alatList = $tools ?? [];
            $cartIds  = array_keys(session()->get('cart', []));
        @endphp

        @forelse ($alatList as $item)
        @php
            $id      = $item->id;
            $nama    = $item->nama_alat;
            $kategori = $item->kategori;
            $lokasi  = $item->lokasi;
            $stok    = $item->stok_tersedia;
            $status  = $item->status_alat;
            $inCart  = in_array($id, $cartIds);
        @endphp

        <div class="card" data-nama="{{ strtolower($nama) }}" data-kategori="{{ strtolower($kategori) }}">
            <div class="card-img">
                <img src="{{ $item->foto_alat ? asset('storage/'.$item->foto_alat) : asset('images/router.png') }}" alt="{{ $nama }}" onerror="this.src='{{ asset('images/router.png') }}'">
                <span class="card-badge {{ strtolower($status) == 'tersedia' ? 'tersedia' : 'habis' }}">{{ ucfirst($status) }}</span>
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
                    {{-- Sudah ada di keranjang --}}
                    <button class="btn-keranjang ditambah" disabled>
                        <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                        Sudah Ditambah
                    </button>
                @elseif ($stok == 0)
                    {{-- Stok habis --}}
                    <button class="btn-keranjang nonaktif" disabled>
                        <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                        Stok Habis
                    </button>
                @else
                    {{-- FIX: action sekarang ke keranjang.store, bukan peminjaman.store --}}
                    <form action="{{ route('keranjang.store') }}" method="POST" onsubmit="return tambahKeranjangAjax(this, '{{ $nama }}')">
                        @csrf
                        <input type="hidden" name="alat_id" value="{{ $id }}">
                        <button type="submit" class="btn-keranjang tambah">
                            <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                            Tambah ke keranjang
                        </button>
                    </form>
                @endif
            </div>
        </div>
        @empty
        <div class="empty-state">
            <p>Belum ada data alat tersedia.</p>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div style="margin-top: 24px;">
        {{ $tools->links() }}
    </div>
@endsection

@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() { filterAlat(); });

    function tambahKeranjangAjax(form, namaAlat) {
        const btn = form.querySelector('button[type="submit"]');
        btn.classList.remove('tambah');
        btn.classList.add('ditambah');
        btn.disabled = true;
        btn.innerHTML = `<svg viewBox="0 0 24 24" style="width:14px;height:14px;fill:none;stroke:currentColor;stroke-width:2;stroke-linecap:round;stroke-linejoin:round"><polyline points="20 6 9 17 4 12"/></svg> Sudah Ditambah`;

        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2500,
            timerProgressBar: true,
        });

        Toast.fire({ icon: 'success', title: `${namaAlat} berhasil dimasukkan ke keranjang` });
        return true;
    }

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

        const countLabel = document.getElementById('countLabel');
        if (countLabel) countLabel.textContent = count;
    }
</script>
@endsection
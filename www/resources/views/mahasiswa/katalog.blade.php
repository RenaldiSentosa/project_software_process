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
        max-width: 180px;
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
    .card-img .placeholder-icon { width: 40px; height: 40px; color: #93c5fd; fill: none; stroke: currentColor; stroke-width: 1.5; stroke-linecap: round; stroke-linejoin: round; }

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
    .card-name { font-size: 14px; font-weight: 600; margin-bottom: 8px; min-height: 36px; }

    .card-stock {
        display: flex;
        align-items: center;
        gap: 5px;
        font-size: 12px;
        color: #6b7280;
        margin-bottom: 12px;
        flex-wrap: wrap;
    }

    .card-stock svg { width: 13px; height: 13px; flex-shrink:0; fill: none; stroke: currentColor; stroke-width: 1.8; stroke-linecap: round; stroke-linejoin: round; }
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

    /* ====== PAGINATION (custom, dibuat manual di blade ini) ====== */
    .pg-custom { display: flex; flex-direction: column; align-items: center; gap: 12px; margin-top: 28px; }
    .pg-custom ul { display: flex; align-items: center; gap: 6px; list-style: none; margin: 0; padding: 0; flex-wrap: wrap; justify-content: center; }
    .pg-custom li { list-style: none; }

    .pg-custom li > a,
    .pg-custom li > span {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 36px;
        height: 36px;
        padding: 0 8px;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        background: #fff;
        color: #374151;
        font-size: 13px;
        font-weight: 600;
        font-family: inherit;
        text-decoration: none;
        transition: background 0.15s, border-color 0.15s, color 0.15s;
    }

    .pg-custom li > a:hover { background: #eff6ff; border-color: #bfdbfe; color: #2563eb; }

    .pg-custom li > a svg,
    .pg-custom li > span svg { width: 16px; height: 16px; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }

    .pg-custom li.active > span { background: #2563eb; border-color: #2563eb; color: #fff; }
    .pg-custom li.disabled > span { color: #d1d5db; border-color: #f3f4f6; cursor: not-allowed; background: #f9fafb; }

    .pg-info { font-size: 12px; color: #9ca3af; margin: 0; }

    @media (max-width: 900px) { .grid { grid-template-columns: repeat(3, 1fr); } .empty-state { grid-column: span 3; } }
    @media (max-width: 640px) { .grid { grid-template-columns: repeat(2, 1fr); } .empty-state { grid-column: span 2; } }
</style>
@endsection

@section('content')
    <div class="page-header">
        <h1>Katalog Alat</h1>
        <p>Jelajahi peralatan lab yang tersedia dan tambahkan ke keranjang peminjaman.</p>
    </div>

    @php
        $kategoriList = isset($tools) ? $tools->pluck('kategori')->unique()->filter()->sort()->values() : collect();
    @endphp

    {{-- Toolbar Filter & Cari --}}
    <div class="toolbar">
        <div class="search-wrap">
            <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            <input type="text" id="searchInput" placeholder="Cari alat berdasarkan nama..." oninput="filterAlat()">
        </div>
        <div class="select-wrap">
            <select id="kategoriSelect" onchange="filterAlat()">
                <option value="semua">Semua Kategori</option>
                @foreach($kategoriList as $kat)
                    <option value="{{ strtolower($kat) }}">{{ $kat }}</option>
                @endforeach
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
                @if($item->foto_alat)
                    <img src="{{ asset('storage/'.$item->foto_alat) }}" alt="{{ $nama }}" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                    <svg class="placeholder-icon" style="display:none" viewBox="0 0 24 24"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
                @else
                    <svg class="placeholder-icon" viewBox="0 0 24 24"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
                @endif
                <span class="card-badge {{ ($stok == 0) ? 'habis' : 'tersedia' }}">{{ $stok == 0 ? 'Stok Habis' : 'Tersedia' }}</span>
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
                    <button class="btn-keranjang ditambah" disabled>
                        <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                        Sudah Ditambah
                    </button>
                @elseif ($stok == 0)
                    <button class="btn-keranjang nonaktif" disabled>
                        <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                        Stok Habis
                    </button>
                @else
                    <form class="form-tambah-keranjang" action="{{ route('keranjang.store') }}" method="POST" onsubmit="tambahKeranjangAjax(event, this, '{{ $nama }}')">
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

    {{-- ============================================================ --}}
    {{-- PAGINATION: dibuat manual di sini, bukan {{ $tools->links() }} --}}
    {{-- supaya stylingnya gampang disamain sama tema card di atas    --}}
    {{-- ============================================================ --}}
    @if ($tools->hasPages())
    <nav class="pg-custom" aria-label="Pagination">
        <ul>
            {{-- Tombol Previous --}}
            @if ($tools->onFirstPage())
                <li class="disabled">
                    <span><svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></span>
                </li>
            @else
                <li>
                    <a href="{{ $tools->previousPageUrl() }}" rel="prev">
                        <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                    </a>
                </li>
            @endif

            {{-- Nomor halaman --}}
            @foreach ($tools->getUrlRange(1, $tools->lastPage()) as $page => $url)
                @if ($page == $tools->currentPage())
                    <li class="active"><span>{{ $page }}</span></li>
                @else
                    <li><a href="{{ $url }}">{{ $page }}</a></li>
                @endif
            @endforeach

            {{-- Tombol Next --}}
            @if ($tools->hasMorePages())
                <li>
                    <a href="{{ $tools->nextPageUrl() }}" rel="next">
                        <svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                    </a>
                </li>
            @else
                <li class="disabled">
                    <span><svg viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></span>
                </li>
            @endif
        </ul>

        <p class="pg-info">
            Menampilkan {{ $tools->firstItem() }}–{{ $tools->lastItem() }} dari {{ $tools->total() }} alat
        </p>
    </nav>
    @endif
@endsection

@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() { filterAlat(); });

    async function tambahKeranjangAjax(event, form, namaAlat) {
        event.preventDefault();

        const btn = form.querySelector('button[type="submit"]');
        const originalHtml = btn.innerHTML;
        btn.disabled = true;

        try {
            const formData = new FormData(form);

            const response = await fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });

            if (!response.ok) {
                throw new Error('Request gagal');
            }

            btn.classList.remove('tambah');
            btn.classList.add('ditambah');
            btn.innerHTML = `<svg viewBox="0 0 24 24" style="width:14px;height:14px;fill:none;stroke:currentColor;stroke-width:2;stroke-linecap:round;stroke-linejoin:round"><polyline points="20 6 9 17 4 12"/></svg> Sudah Ditambah`;

            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 2500,
                timerProgressBar: true,
            });

            Toast.fire({ icon: 'success', title: `${namaAlat} berhasil dimasukkan ke keranjang` });

        } catch (err) {
            btn.disabled = false;
            btn.innerHTML = originalHtml;

            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: 'Alat gagal ditambahkan ke keranjang. Coba lagi.',
                confirmButtonColor: '#2563eb'
            });
        }
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
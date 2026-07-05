@extends('layouts.mahasiswa')

@section('title', 'Dashboard - IPWIJA SmartLab')

@section('styles')
<style>
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

    /* PEMINJAMAN LIST */
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

    .badge-dot { width: 7px; height: 7px; border-radius: 50%; }

    .badge.menunggu        { background: #fff7ed; color: #f97316; }
    .badge.menunggu .badge-dot   { background: #f97316; }
    .badge.disetujui      { background: #eff6ff; color: #2563eb; }
    .badge.disetujui .badge-dot  { background: #2563eb; }
    .badge.dipinjam      { background: #f5f3ff; color: #7c3aed; }
    .badge.dipinjam .badge-dot   { background: #7c3aed; }
    .badge.ditolak        { background: #fef2f2; color: #dc2626; }
    .badge.ditolak .badge-dot    { background: #dc2626; }
    .badge.dikembalikan { background: #f0fdf4; color: #16a34a; }
    .badge.dikembalikan .badge-dot { background: #16a34a; }

    .empty-state { padding: 32px 16px; text-align: center; color: #9ca3af; }
    .empty-state p { font-size: 13px; margin-top: 4px; color: #6b7280; }

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

    @media (max-width: 640px) {
        .stats { grid-template-columns: repeat(2, 1fr); }
        .aksi-grid { grid-template-columns: 1fr; }
    }
</style>
@endsection

@section('content')
    {{-- Greeting Card --}}
    <div class="greeting">
        <div class="greeting-avatar" style="overflow: hidden;">
            @if(auth()->user()->foto_profil)
                <img src="{{ asset('storage/' . auth()->user()->foto_profil) }}" alt="Avatar" style="width: 100%; height: 100%; object-fit: cover;">
            @else
                {{ strtoupper(substr(auth()->user()->nama_lengkap ?? auth()->user()->name ?? 'U', 0, 1)) }}
            @endif
        </div>
        <div>
            <h2>Halo, {{ auth()->user()->nama_lengkap ?? 'Guest User' }}!</h2>
            <p>Selamat datang di Portal Peminjaman Lab. Ada banyak alat tersedia untuk dipinjam.</p>
        </div>
    </div>

    {{-- Stat Cards --}}
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
            <div class="stat-value">{{ $total_dipinjam ?? '0' }}</div>
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

    {{-- Peminjaman Terbaru --}}
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
                <div class="empty-state">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#9ca3af" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom: 8px;">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                        <line x1="16" y1="13" x2="8" y2="13"></line>
                        <line x1="16" y1="17" x2="8" y2="17"></line>
                        <polyline points="10 9 9 9 8 9"></polyline>
                    </svg>
                    <p>Belum ada riwayat aktivitas peminjaman.</p>
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
@endsection
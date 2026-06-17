@extends('layouts.mahasiswa')

@section('title', 'Detail Peminjaman - IPWIJA SmartLab')

@section('styles')
<style>
    .page-header { background: #fff; border: 1px solid #e5e7eb; border-radius: 12px; padding: 20px 24px; margin-bottom: 20px; display: flex; align-items: center; justify-content: space-between; }
    .page-header h1 { font-size: 18px; font-weight: 700; color: #111827; }
    .header-right { display: flex; align-items: center; gap: 12px; }
    .id-label { font-size: 13px; color: #6b7280; font-weight: 500; }

    .card { background: #fff; border: 1px solid #e5e7eb; border-radius: 12px; padding: 24px; margin-bottom: 16px; }
    .section-title { display: flex; align-items: center; gap: 8px; font-size: 13px; font-weight: 700; color: #374151; margin-bottom: 16px; }
    .section-title svg { width: 16px; height: 16px; fill: none; stroke: currentColor; stroke-width: 2; stroke-linecap: round; stroke-linejoin: round; }

    /* Informasi Mahasiswa */
    .mhs-grid { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 16px; }
    .mhs-item label { font-size: 11px; color: #6b7280; display: block; margin-bottom: 3px; }
    .mhs-item span  { font-size: 14px; font-weight: 600; color: #111827; }

    /* Tanggal */
    .date-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 20px; }
    .date-box { border: 1px solid #e5e7eb; border-radius: 10px; padding: 14px 16px; display: flex; align-items: center; gap: 12px; }
    .date-box.pinjam  { background: #eff6ff; border-color: #bfdbfe; }
    .date-box.kembali { background: #fff7ed; border-color: #fed7aa; }
    .date-box svg { width: 20px; height: 20px; flex-shrink: 0; fill: none; stroke: currentColor; stroke-width: 1.8; stroke-linecap: round; stroke-linejoin: round; }
    .date-box.pinjam  svg { color: #2563eb; }
    .date-box.kembali svg { color: #f97316; }
    .date-label { font-size: 11px; font-weight: 600; margin-bottom: 2px; }
    .date-box.pinjam  .date-label { color: #2563eb; }
    .date-box.kembali .date-label { color: #f97316; }
    .date-val { font-size: 14px; font-weight: 700; color: #111827; }

    /* Keperluan */
    .keperluan-text { font-size: 13px; color: #374151; line-height: 1.6; }

    /* Tabel alat */
    .table-wrap { border: 1px solid #e5e7eb; border-radius: 10px; overflow: hidden; }
    table { width: 100%; border-collapse: collapse; }
    th { background: #f9fafb; padding: 10px 16px; font-size: 11px; font-weight: 600; color: #374151; border-bottom: 1px solid #e5e7eb; text-align: left; }
    td { padding: 12px 16px; font-size: 13px; color: #111827; border-bottom: 1px solid #e5e7eb; }
    tr:last-child td { border-bottom: none; }
    .total-row td { font-weight: 700; background: #f9fafb; }

    /* Badge kondisi */
    .kondisi-badge { display: inline-block; padding: 2px 8px; border-radius: 10px; font-size: 11px; font-weight: 600; }
    .kondisi-badge.baik { background: #dcfce7; color: #15803d; }
    .kondisi-badge.rusak-ringan { background: #fef3c7; color: #b45309; }
    .kondisi-badge.rusak-berat  { background: #fee2e2; color: #b91c1c; }
    .kondisi-badge.hilang       { background: #f3f4f6; color: #6b7280; }

    /* Status badge (header) */
    .badge-pill { display: inline-flex; align-items: center; gap: 5px; padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 600; border: 1px solid transparent; }
    .badge-pill::before { content: ""; width: 5px; height: 5px; border-radius: 50%; display: inline-block; }
    .badge-pill.disetujui    { background: #e0f2fe; color: #0369a1; border-color: #bae6fd; }
    .badge-pill.disetujui::before    { background: #0284c7; }
    .badge-pill.menunggu     { background: #fef3c7; color: #b45309; border-color: #fde68a; }
    .badge-pill.menunggu::before     { background: #d97706; }
    .badge-pill.ditolak      { background: #fee2e2; color: #b91c1c; border-color: #fecaca; }
    .badge-pill.ditolak::before      { background: #dc2626; }
    .badge-pill.dikembalikan { background: #dcfce7; color: #15803d; border-color: #bbf7d0; }
    .badge-pill.dikembalikan::before { background: #16a34a; }
    .badge-pill.dipinjam     { background: #f3e8ff; color: #6b21a8; border-color: #e9d5ff; }
    .badge-pill.dipinjam::before     { background: #8b5cf6; }

    /* Status box */
    .status-box { border-radius: 10px; padding: 16px; display: flex; align-items: flex-start; gap: 14px; }
    .status-box.menunggu     { background: #fefce8; border: 1px solid #fde68a; }
    .status-box.disetujui    { background: #eff6ff; border: 1px solid #bfdbfe; }
    .status-box.dipinjam     { background: #f5f3ff; border: 1px solid #e9d5ff; }
    .status-box.dikembalikan { background: #f0fdf4; border: 1px solid #bbf7d0; }
    .status-box.ditolak      { background: #fef2f2; border: 1px solid #fecaca; }

    /* Status icon: sekarang bulatan solid polos, warnanya sama persis dengan dot di badge-pill */
    .status-icon { width: 14px; height: 14px; border-radius: 50%; flex-shrink: 0; margin-top: 5px; }
    .status-icon.menunggu     { background: #d97706; }
    .status-icon.disetujui    { background: #0284c7; }
    .status-icon.dipinjam     { background: #8b5cf6; }
    .status-icon.dikembalikan { background: #16a34a; }
    .status-icon.ditolak      { background: #dc2626; }

    .status-content-title { font-size: 13px; font-weight: 700; margin-bottom: 4px; }
    .status-content-title.menunggu     { color: #92400e; }
    .status-content-title.disetujui    { color: #1e40af; }
    .status-content-title.dipinjam     { color: #5b21b6; }
    .status-content-title.dikembalikan { color: #15803d; }
    .status-content-title.ditolak      { color: #991b1b; }

    .status-content-desc { font-size: 12px; color: #6b7280; line-height: 1.5; }

    .btn-kembali { display: block; width: 100%; padding: 14px; background: #2563eb; color: #fff; border: none; border-radius: 10px; font-size: 14px; font-weight: 700; font-family: inherit; cursor: pointer; text-align: center; text-decoration: none; transition: background 0.15s; margin-top: 8px; }
    .btn-kembali:hover { background: #1d4ed8; }

    @media(max-width: 640px) { .mhs-grid { grid-template-columns: 1fr 1fr; } .date-grid { grid-template-columns: 1fr; } }
</style>
@endsection

@section('content')
@php
    $statusClean = strtolower($detail->status);
    $tglAju      = \Carbon\Carbon::parse($detail->created_at)->translatedFormat('d F Y \p\u\k\u\l H.i');
    $tglPinjam   = \Carbon\Carbon::parse($detail->tgl_rencana_pinjam)->translatedFormat('l, d F Y');
    $tglKembali  = \Carbon\Carbon::parse($detail->tgl_rencana_kembali)->translatedFormat('l, d F Y');
    $idFormatted = 'PMJ-' . \Carbon\Carbon::parse($detail->created_at)->format('Y') . '-' . str_pad($detail->id, 3, '0', STR_PAD_LEFT);
    $totalUnit   = $detail->items->sum('jumlah_unit');
@endphp

{{-- Header --}}
<div class="page-header">
    <h1>Detail Peminjaman</h1>
    <div class="header-right">
        <span class="id-label">ID Peminjaman : {{ str_pad($detail->id, 3, '0', STR_PAD_LEFT) }}</span>
        <span class="badge-pill {{ $statusClean }}">
            @if($statusClean == 'menunggu') Menunggu
            @elseif($statusClean == 'disetujui') Disetujui
            @elseif($statusClean == 'dipinjam') Sedang Dipinjam
            @elseif($statusClean == 'dikembalikan') Dikembalikan
            @else Ditolak @endif
        </span>
    </div>
</div>

<div class="card">
    {{-- Informasi Mahasiswa --}}
    <div class="section-title">
        <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
        Informasi Mahasiswa
    </div>
    <div class="mhs-grid" style="margin-bottom: 24px;">
        <div class="mhs-item">
            <label>Nama</label>
            <span>{{ $user->name ?? '-' }}</span>
        </div>
        <div class="mhs-item">
            <label>NIM</label>
            <span>{{ $user->nim ?? '-' }}</span>
        </div>
        <div class="mhs-item">
            <label>Program Studi</label>
            <span>{{ $user->program_studi ?? '-' }}</span>
        </div>
    </div>

    {{-- Tanggal --}}
    <div class="date-grid">
        <div class="date-box pinjam">
            <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            <div>
                <div class="date-label">Tanggal Peminjaman</div>
                <div class="date-val">{{ $tglPinjam }}</div>
            </div>
        </div>
        <div class="date-box kembali">
            <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            <div>
                <div class="date-label">Tanggal Pengembalian</div>
                <div class="date-val">{{ $tglKembali }}</div>
            </div>
        </div>
    </div>

    {{-- Keperluan --}}
    <div class="section-title">
        <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
        Keperluan Peminjaman
    </div>
    <p class="keperluan-text">{{ $detail->keperluan }}</p>
</div>

{{-- Daftar Alat --}}
<div class="card">
    <div class="section-title">
        <svg viewBox="0 0 24 24"><polyline points="9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
        Daftar Alat yang Diminta
    </div>
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th style="width:50%">Nama Alat</th>
                    <th style="width:30%">Kategori</th>
                    <th style="width:20%">Jumlah</th>
                </tr>
            </thead>
            <tbody>
                @forelse($detail->items as $item)
                <tr>
                    <td style="font-weight:500">{{ $item->tool->nama_alat ?? '-' }}</td>
                    <td style="color:#6b7280">{{ $item->tool->kategori ?? '-' }}</td>
                    <td>{{ $item->jumlah_unit }}</td>
                </tr>
                @empty
                <tr><td colspan="3" style="text-align:center;color:#6b7280;padding:24px">Tidak ada alat.</td></tr>
                @endforelse
                <tr class="total-row">
                    <td colspan="2">Total Item</td>
                    <td>{{ $totalUnit }} Item</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

{{-- Status Box --}}
<div class="card">
    @if($statusClean == 'menunggu')
        <div class="section-title">
            <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            Menunggu Persetujuan Admin
        </div>
        <div class="status-box menunggu">
            <div class="status-icon menunggu"></div>
            <div>
                <div class="status-content-title menunggu">Menunggu Review Admin</div>
                <div class="status-content-desc">
                    Diajukan {{ $tglAju }}.<br>
                    Permintaan kamu sedang dalam antrian review. Kamu akan menerima notifikasi email otomatis ketika admin memproses permintaan ini. Mohon menunggu maksimal 1–2 hari kerja.
                </div>
            </div>
        </div>

    @elseif($statusClean == 'disetujui')
        <div class="section-title">
            <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
            Detail Peminjaman Disetujui
        </div>
        <div class="status-box disetujui">
            <div class="status-icon disetujui"></div>
            <div>
                <div class="status-content-title disetujui">Disetujui oleh Admin</div>
                <div class="status-content-desc">
                    Silakan mengambil alat di laboratorium IT Universitas IPWIJA.
                </div>
            </div>
        </div>

    @elseif($statusClean == 'dipinjam')
        <div class="section-title">
            <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            Status Peminjaman Aktif
        </div>
        <div class="status-box dipinjam">
            <div class="status-icon dipinjam"></div>
            <div>
                <div class="status-content-title dipinjam">Sedang Dipinjam</div>
                <div class="status-content-desc">
                    Pastikan mengembalikan alat sebelum tanggal {{ $tglKembali }}.
                </div>
            </div>
        </div>

    @elseif($statusClean == 'dikembalikan')
        <div class="section-title">
            <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
            Status Pengembalian
        </div>
        <div class="status-box dikembalikan">
            <div class="status-icon dikembalikan"></div>
            <div>
                <div class="status-content-title dikembalikan">Telah Dikembalikan</div>
                <div class="status-content-desc">
                    Terima kasih telah berhasil mengembalikan alat dengan kondisi sebagai berikut.
                </div>
            </div>
        </div>

        {{-- Tabel kondisi pengembalian --}}
        @if($detail->items->whereNotNull('kondisi')->count() > 0)
        <div class="table-wrap" style="margin-top:16px">
            <table>
                <thead>
                    <tr>
                        <th style="width:50%">Nama Alat</th>
                        <th style="width:30%">Kondisi</th>
                        <th style="width:20%">Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($detail->items as $item)
                    <tr>
                        <td style="font-weight:500">{{ $item->tool->nama_alat ?? '-' }}</td>
                        <td>
                            @php $k = strtolower(str_replace(' ', '-', $item->kondisi ?? 'baik')); @endphp
                            <span class="kondisi-badge {{ $k }}">{{ $item->kondisi ?? 'Baik' }}</span>
                        </td>
                        <td>{{ $item->jumlah_unit }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif

    @elseif($statusClean == 'ditolak')
        <div class="section-title">
            <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
            Catatan Admin
        </div>
        <div class="status-box ditolak">
            <div class="status-icon ditolak"></div>
            <div>
                <div class="status-content-title ditolak">Permintaan Ditolak</div>
                <div class="status-content-desc">
                    {{ $detail->catatan_admin ?? 'Permintaan tidak dapat diproses. Silakan ajukan ulang dengan memperhatikan ketentuan peminjaman.' }}<br>
                    Mohon ajukan ulang dengan syarat-syarat yang lebih sesuai dan alasan peminjaman.
                </div>
            </div>
        </div>
    @endif
</div>

<a href="{{ route('peminjaman') }}" class="btn-kembali">Kembali</a>
@endsection

@section('scripts')
<script>
    @if(session('success'))
        Swal.fire({ icon: 'success', title: 'Berhasil!', text: "{{ session('success') }}", confirmButtonColor: '#2563eb' });
    @endif
</script>
@endsection
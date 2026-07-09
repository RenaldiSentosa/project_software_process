@extends('layouts.admin')

@section('title', 'Peminjaman Admin - IPWIJA SmartLab')

@push('scripts-head')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush

@section('styles')
<style>
body { font-family: 'Inter', sans-serif; background-color: #F8FAFC; }
::-webkit-scrollbar { width: 6px; }
::-webkit-scrollbar-track { background: #f1f1f1; }
::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
input[type=number].kondisi-input::-webkit-inner-spin-button,
input[type=number].kondisi-input::-webkit-outer-spin-button { opacity: 1; }
</style>
@endsection

@section('content')

<div class="mb-6">
    <h2 class="text-2xl font-bold text-slate-900 tracking-tight">Manajemen Peminjaman</h2>
    <p class="text-slate-500 text-sm mt-1">Kelola pengajuan peminjaman alat laboratorium Universitas IPWIJA.</p>
</div>

{{-- SEARCH & FILTER BAR --}}
<form method="GET" action="{{ route('admin.peminjaman') }}" class="flex flex-col sm:flex-row gap-3 mb-6">
    <div class="relative flex-1">
        <i class="fa-solid fa-magnifying-glass text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2 text-xs"></i>
        <input
            type="text"
            name="q"
            value="{{ request('q') }}"
            placeholder="Cari ID peminjaman atau nama peminjam..."
            class="w-full pl-9 pr-4 py-2.5 bg-white border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 transition shadow-sm"
        >
    </div>
    <div class="relative">
        <select name="status" class="appearance-none bg-white border border-slate-200 pl-4 pr-10 py-2.5 rounded-xl text-xs font-medium text-slate-600 focus:outline-none focus:ring-1 focus:ring-blue-500 shadow-sm cursor-pointer min-w-[160px]">
            <option value="">Semua Status</option>
            <option value="Menunggu" {{ request('status') == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
            <option value="Disetujui" {{ request('status') == 'Disetujui' ? 'selected' : '' }}>Disetujui</option>
            <option value="Dipinjam" {{ request('status') == 'Dipinjam' ? 'selected' : '' }}>Dipinjam</option>
            <option value="Diproses" {{ request('status') == 'Diproses' ? 'selected' : '' }}>Diproses</option>
            <option value="Dikembalikan" {{ request('status') == 'Dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
            <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
            <option value="Ditolak" {{ request('status') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
        </select>
        <i class="fa-solid fa-chevron-down absolute right-3.5 top-1/2 -translate-y-1/2 text-[10px] text-slate-400 pointer-events-none"></i>
    </div>
    <button
        type="submit"
        class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2.5 rounded-xl text-xs transition shadow-sm flex items-center gap-2"
    >
        <i class="fa-solid fa-filter"></i> Filter
    </button>
    <a href="{{ route('admin.peminjaman') }}"
        class="bg-slate-200 hover:bg-slate-300 text-slate-700 font-semibold px-4 py-2.5 rounded-xl text-xs transition shadow-sm flex items-center"
    >
        Reset
    </a>
</form>

<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-100">
        <h3 class="font-bold text-slate-800 text-sm">Permintaan Peminjaman</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs border-collapse">
            <thead>
                <tr class="border-b border-slate-100 text-slate-400 font-semibold uppercase tracking-wider text-[10px]">
                    <th class="py-3 px-6">ID Peminjaman</th>
                    <th class="py-3 px-6">Peminjam</th>
                    <th class="py-3 px-6">Prodi</th>
                    <th class="py-3 px-6">Tanggal Pengajuan</th>
                    <th class="py-3 px-6">Jumlah Alat</th>
                    <th class="py-3 px-6">Status</th>
                    <th class="py-3 px-6 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-slate-700" id="tbody-peminjaman">
                @forelse($borrowings ?? [] as $borrowing)
                    @php
                        $namaPeminjam = $borrowing->mahasiswa->nama_lengkap ?? $borrowing->mahasiswa->name ?? 'Unknown';
                        $idTampil     = 'PJM-' . str_pad($borrowing->id, 3, '0', STR_PAD_LEFT);
                        $userRole     = strtolower($borrowing->mahasiswa->role ?? $borrowing->mahasiswa->name ?? '');
                        $isDosen      = $userRole === 'dosen';
                        $prodiTampil  = $isDosen ? '—' : ($borrowing->mahasiswa->program_studi ?? '—');
                        $nimLabel     = $borrowing->mahasiswa->nim ?? $borrowing->mahasiswa->nip ?? '';
                        $st           = $borrowing->status;
                    @endphp
                    <tr class="hover:bg-slate-50/60 transition item-row">
                        <td class="py-4 px-6 font-semibold text-slate-800 text-xs">{{ $idTampil }}</td>
                        <td class="py-4 px-6">
                            <span class="font-semibold text-slate-800 block text-xs">{{ $namaPeminjam }}</span>
                            @if($nimLabel)
                                <span class="text-slate-400 text-[11px]">{{ $nimLabel }}</span>
                            @endif
                        </td>
                        <td class="py-4 px-6 text-xs text-slate-600">{{ $prodiTampil }}</td>
                        <td class="py-4 px-6 text-xs text-slate-500">
                            {{ \Carbon\Carbon::parse($borrowing->created_at)->translatedFormat('d M Y') }}
                        </td>
                        <td class="py-4 px-6 text-xs text-slate-600">
                            {{ $borrowing->items->count() }} jenis,
                            <span class="font-bold">{{ $borrowing->items->sum('jumlah_unit') }}</span> unit
                        </td>
                        <td class="py-4 px-6">
                            @if($st === 'Disetujui')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-blue-50 text-blue-600 text-[10px] font-bold">
                                    <span class="w-1.5 h-1.5 bg-blue-500 rounded-full"></span>Disetujui
                                </span>
                            @elseif($st === 'Dipinjam' || $st === 'Diproses')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-purple-50 text-purple-600 text-[10px] font-bold">
                                    <span class="w-1.5 h-1.5 bg-purple-500 rounded-full"></span>Dipinjam
                                </span>
                            @elseif($st === 'Menunggu')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-amber-50 text-amber-600 text-[10px] font-bold">
                                    <span class="w-1.5 h-1.5 bg-amber-500 rounded-full"></span>Menunggu
                                </span>
                            @elseif($st === 'Ditolak')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-rose-50 text-rose-600 text-[10px] font-bold">
                                    <span class="w-1.5 h-1.5 bg-rose-500 rounded-full"></span>Ditolak
                                </span>
                            @elseif($st === 'Selesai' || $st === 'Dikembalikan')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-600 text-[10px] font-bold">
                                    <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>Selesai
                                </span>
                            @endif
                        </td>
                        <td class="py-4 px-6">
                            <div class="flex justify-center items-center gap-1.5">
                                {{-- Tombol lihat detail — satu tombol untuk semua status --}}
                                <button
                                    onclick="toggleModal('modal-detail-{{ $borrowing->id }}')"
                                    class="w-7 h-7 flex items-center justify-center rounded-lg text-slate-400 hover:text-slate-700 hover:bg-slate-100 transition"
                                    title="Lihat Detail"
                                >
                                    <i class="fa-regular fa-eye text-sm"></i>
                                </button>

                                @if($st === 'Menunggu')
                                    <form action="{{ route('admin.peminjaman.approve', $borrowing->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="w-7 h-7 flex items-center justify-center rounded-lg text-slate-400 hover:text-blue-600 hover:bg-blue-50 transition" title="Setujui">
                                            <i class="fa-solid fa-check text-xs"></i>
                                        </button>
                                    </form>
                                    <button type="button" onclick="openPenolakanLangsung({{ $borrowing->id }})" class="w-7 h-7 flex items-center justify-center rounded-lg text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition" title="Tolak">
                                        <i class="fa-solid fa-xmark text-xs"></i>
                                    </button>
                                @elseif($st === 'Disetujui')
                                    <form action="{{ route('admin.peminjaman.borrow', $borrowing->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="w-7 h-7 flex items-center justify-center rounded-lg text-slate-400 hover:text-purple-600 hover:bg-purple-50 transition" title="Catat Peminjaman">
                                            <i class="fa-solid fa-clipboard-check text-xs"></i>
                                        </button>
                                    </form>
                                @elseif($st === 'Dipinjam' || $st === 'Diproses')
                                    {{-- Icon return di tabel tetap ada, buka modal-detail (scroll ke form kondisi) --}}
                                    <button
                                        type="button"
                                        onclick="toggleModal('modal-detail-{{ $borrowing->id }}')"
                                        class="w-7 h-7 flex items-center justify-center rounded-lg text-slate-400 hover:text-emerald-600 hover:bg-emerald-50 transition"
                                        title="Catat Pengembalian"
                                    >
                                        <i class="fa-solid fa-rotate-left text-xs"></i>
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-12 text-slate-400 text-xs">
                            <i class="fa-regular fa-folder-open text-2xl mb-2 block"></i>
                            Belum ada data peminjaman.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        @if($borrowings->isEmpty())
        <p class="text-center py-10 text-slate-400 text-xs">
            <i class="fa-solid fa-magnifying-glass text-xl mb-2 block"></i>
            Tidak ada peminjaman yang cocok dengan pencarian/filter.
        </p>
        @endif
    </div>
    <div class="px-6 py-4 border-t border-slate-100 flex items-center justify-between">
        <p class="text-xs text-slate-400">
            Menampilkan {{ $borrowings->firstItem() }}–{{ $borrowings->lastItem() }} dari {{ $borrowings->total() }} peminjaman
        </p>
        {{ $borrowings->links() }}
    </div>
</div>

{{-- ============================================================
     SATU MODAL DETAIL PER BORROWING
     Isi footer berubah sesuai status:
       - Menunggu  → Tolak (merah) + Setujui (biru) + Tutup
       - Disetujui → Catat Peminjaman (ungu) + Tutup
       - Dipinjam  → form kondisi di body + Catat Pengembalian (hijau) + Tutup
       - Ditolak   → Tutup saja
     ============================================================ --}}
@foreach($borrowings as $b)
    @php
        $bRole     = strtolower($b->mahasiswa->role ?? $b->mahasiswa->name ?? '');
        $bIsDosen  = $bRole === 'dosen';
        $bProdi    = $bIsDosen ? null : ($b->mahasiswa->program_studi ?? null);
        $bNim      = $b->mahasiswa->nim ?? $b->mahasiswa->nip ?? '-';
        $bNama     = $b->mahasiswa->nama_lengkap ?? $b->mahasiswa->name ?? '-';
        $bEmail    = $b->mahasiswa->email ?? '-';
        $bSt       = $b->status;
        $bIdLabel  = 'PJM-' . str_pad($b->id, 3, '0', STR_PAD_LEFT);
        $totalUnit = $b->items->sum('jumlah_unit');
        $isDipinjam = $bSt === 'Dipinjam' || $bSt === 'Diproses';
    @endphp

    <div id="modal-detail-{{ $b->id }}"
         class="fixed inset-0 z-50 hidden bg-slate-900/50 backdrop-blur-sm opacity-0 flex items-center justify-center p-4 transition-opacity duration-300">
        <div class="bg-white rounded-2xl shadow-xl w-full {{ $isDipinjam ? 'max-w-2xl' : 'max-w-xl' }} overflow-hidden scale-95 transition-transform duration-300 max-h-[92vh] flex flex-col">

            {{-- ── HEADER: ID kiri, badge status kanan ── --}}
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between flex-shrink-0">
                <div>
                    <p class="text-[10px] text-slate-400 font-semibold uppercase tracking-wider">ID Peminjaman</p>
                    <h3 class="font-bold text-slate-800 text-sm mt-0.5">{{ $bIdLabel }}</h3>
                </div>
                <div class="flex items-center gap-3">
                    {{-- Badge status --}}
                    @if($bSt === 'Dipinjam' || $bSt === 'Diproses')
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-purple-50 text-purple-600 text-[10px] font-bold">
                            <span class="w-1.5 h-1.5 bg-purple-500 rounded-full"></span>Dipinjam
                        </span>
                    @elseif($bSt === 'Menunggu')
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-amber-50 text-amber-600 text-[10px] font-bold">
                            <span class="w-1.5 h-1.5 bg-amber-500 rounded-full"></span>Menunggu
                        </span>
                    @elseif($bSt === 'Disetujui')
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-blue-50 text-blue-600 text-[10px] font-bold">
                            <span class="w-1.5 h-1.5 bg-blue-500 rounded-full"></span>Disetujui
                        </span>
                    @elseif($bSt === 'Ditolak')
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-rose-50 text-rose-600 text-[10px] font-bold">
                            <span class="w-1.5 h-1.5 bg-rose-500 rounded-full"></span>Ditolak
                        </span>
                    @elseif($bSt === 'Selesai' || $bSt === 'Dikembalikan')
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-600 text-[10px] font-bold">
                            <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>Selesai
                        </span>
                    @endif
                    <button onclick="toggleModal('modal-detail-{{ $b->id }}')"
                            class="w-8 h-8 flex items-center justify-center rounded-lg text-slate-400 hover:text-rose-500 hover:bg-rose-50 transition">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            </div>

            {{-- ── BODY SCROLLABLE ── --}}
            {{-- Wrap dalam form jika Dipinjam (karena footer-nya submit form pengembalian) --}}
            @if($isDipinjam)
            <form action="{{ route('admin.peminjaman.return', $b->id) }}" method="POST" id="form-return-{{ $b->id }}" class="flex flex-col flex-1 overflow-hidden">
                @csrf
            @endif

                <div class="overflow-y-auto flex-1 p-6 space-y-5">

                    {{-- Data Peminjam --}}
                    <div class="rounded-xl border border-slate-100 bg-slate-50/60 p-4">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-3">Data {{ $bIsDosen ? 'Dosen' : 'Mahasiswa' }}</p>
                        <div class="grid grid-cols-2 gap-x-6 gap-y-3">
                            <div>
                                <p class="text-[10px] text-slate-400 mb-0.5">Nama Lengkap</p>
                                <p class="text-xs font-semibold text-slate-800">{{ $bNama }}</p>
                            </div>
                            <div>
                                <p class="text-[10px] text-slate-400 mb-0.5">{{ $bIsDosen ? 'NIP' : 'NIM' }}</p>
                                <p class="text-xs font-semibold text-slate-800">{{ $bNim }}</p>
                            </div>
                            @if(!$bIsDosen && $bProdi)
                            <div>
                                <p class="text-[10px] text-slate-400 mb-0.5">Program Studi</p>
                                <p class="text-xs font-semibold text-slate-800">{{ $bProdi }}</p>
                            </div>
                            @endif
                            <div>
                                <p class="text-[10px] text-slate-400 mb-0.5">Email</p>
                                <p class="text-xs font-semibold text-slate-800">{{ $bEmail }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Keperluan / Tujuan --}}
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2">Keperluan / Tujuan</p>
                        <div class="rounded-xl border border-slate-100 bg-slate-50/60 p-4">
                            <p class="text-xs text-slate-700 leading-relaxed">{{ $b->keperluan ?? '-' }}</p>
                        </div>
                    </div>

                    {{-- Tanggal --}}
                    <div class="grid grid-cols-2 gap-3">
                        <div class="rounded-xl border border-slate-100 bg-slate-50/60 p-3">
                            <p class="text-[10px] text-slate-400 mb-1">Tanggal Peminjaman</p>
                            <p class="text-xs font-bold text-slate-800">{{ \Carbon\Carbon::parse($b->tgl_rencana_pinjam)->translatedFormat('d M Y') }}</p>
                        </div>
                        <div class="rounded-xl border border-slate-100 bg-slate-50/60 p-3">
                            <p class="text-[10px] text-slate-400 mb-1">Tanggal Pengembalian</p>
                            <p class="text-xs font-bold text-slate-800">{{ \Carbon\Carbon::parse($b->tgl_rencana_kembali)->translatedFormat('d M Y') }}</p>
                        </div>
                    </div>

                    {{-- Daftar Alat --}}
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2">Daftar Alat yang Dipinjam</p>
                        <div class="rounded-xl border border-slate-100 overflow-hidden">
                            <table class="w-full text-xs">
                                <thead>
                                    <tr class="bg-slate-50 border-b border-slate-100 text-slate-500 font-semibold">
                                        <th class="py-2.5 px-4 text-left">Nama Alat</th>
                                        <th class="py-2.5 px-4 text-left">Kategori</th>
                                        <th class="py-2.5 px-4 text-right font-bold">Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @foreach($b->items as $bi)
                                    <tr class="bg-white">
                                        <td class="py-3 px-4 font-medium text-slate-800">{{ $bi->tool->nama_alat ?? 'Alat tidak ditemukan' }}</td>
                                        <td class="py-3 px-4 text-slate-500">{{ $bi->tool->kategori ?? '-' }}</td>
                                        <td class="py-3 px-4 text-right font-bold text-slate-800">{{ $bi->jumlah_unit }}</td>
                                    </tr>
                                    @endforeach
                                    <tr class="bg-slate-50 border-t border-slate-200">
                                        <td class="py-2.5 px-4 font-semibold text-slate-600" colspan="2">Total item</td>
                                        <td class="py-2.5 px-4 text-right font-bold text-slate-800">{{ $totalUnit }} item</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- Catatan admin jika ditolak --}}
                    @if($bSt === 'Ditolak' && $b->catatan_admin)
                    <div>
                        <p class="text-[10px] font-bold text-rose-400 uppercase tracking-wider mb-2">Alasan Penolakan</p>
                        <div class="rounded-xl border border-rose-100 bg-rose-50 p-4">
                            <p class="text-xs text-rose-700 leading-relaxed">{{ $b->catatan_admin }}</p>
                        </div>
                    </div>
                    @endif

                    {{-- ── FORM KONDISI — hanya muncul jika status Dipinjam ── --}}
                    @if($isDipinjam)
                    <div>
                        <p class="text-xs font-bold text-slate-700 mb-1">
                            Isi kondisi setiap alat yang dikembalikan. Pastikan total jumlah sesuai.
                            <span class="text-rose-500">*</span>
                        </p>
                        <div class="rounded-xl border border-slate-200 overflow-hidden">
                            <table class="w-full text-xs">
                                <thead>
                                    <tr class="bg-slate-50 border-b border-slate-100 text-slate-500 font-semibold text-[11px]">
                                        <th class="py-2.5 px-4 text-left">Nama Alat</th>
                                        <th class="py-2.5 px-3 text-center">Dipinjam</th>
                                        <th class="py-2.5 px-3 text-center text-emerald-600">Baik</th>
                                        <th class="py-2.5 px-3 text-center text-amber-600">Rusak Ringan</th>
                                        <th class="py-2.5 px-3 text-center text-rose-600">Rusak Berat</th>
                                        <th class="py-2.5 px-3 text-center font-bold">Total</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @foreach($b->items as $bi)
                                    <tr class="bg-white" data-dipinjam="{{ $bi->jumlah_unit }}" data-item-row>
                                        <td class="py-3 px-4 font-medium text-slate-800">{{ $bi->tool->nama_alat ?? '-' }}</td>
                                        <td class="py-3 px-3 text-center">
                                            <span class="inline-flex items-center justify-center w-7 h-7 bg-slate-100 text-slate-700 rounded-lg font-bold">{{ $bi->jumlah_unit }}</span>
                                        </td>
                                        <td class="py-3 px-3 text-center">
                                            <input type="number" name="kondisi_baik[{{ $bi->id }}]"
                                                   min="0" max="{{ $bi->jumlah_unit }}" value="0"
                                                   class="kondisi-input w-14 border border-emerald-200 rounded-lg px-1 py-1.5 text-center text-xs font-semibold text-emerald-700 focus:outline-none focus:ring-1 focus:ring-emerald-400"
                                                   onchange="hitungTotal(this)">
                                        </td>
                                        <td class="py-3 px-3 text-center">
                                            <input type="number" name="kondisi_rusak_ringan[{{ $bi->id }}]"
                                                   min="0" max="{{ $bi->jumlah_unit }}" value="0"
                                                   class="kondisi-input w-14 border border-amber-200 rounded-lg px-1 py-1.5 text-center text-xs font-semibold text-amber-700 focus:outline-none focus:ring-1 focus:ring-amber-400"
                                                   onchange="hitungTotal(this)">
                                        </td>
                                        <td class="py-3 px-3 text-center">
                                            <input type="number" name="kondisi_rusak_berat[{{ $bi->id }}]"
                                                   min="0" max="{{ $bi->jumlah_unit }}" value="0"
                                                   class="kondisi-input w-14 border border-rose-200 rounded-lg px-1 py-1.5 text-center text-xs font-semibold text-rose-700 focus:outline-none focus:ring-1 focus:ring-rose-400"
                                                   onchange="hitungTotal(this)">
                                        </td>
                                        <td class="py-3 px-3 text-center">
                                            <span class="total-kondisi font-bold text-slate-800">0</span>
                                            <span class="text-slate-400">/ {{ $bi->jumlah_unit }}</span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- Catatan pengembalian --}}
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2">Catatan :</p>
                        <textarea name="catatan_pengembalian" rows="3"
                                  placeholder="Catatan tambahan (opsional)..."
                                  class="w-full border border-slate-200 rounded-xl p-3 text-xs focus:outline-none focus:ring-1 focus:ring-blue-400 transition resize-none"></textarea>
                    </div>
                    @endif

                </div>{{-- /overflow-y-auto --}}

            {{-- ── FOOTER — berubah sesuai status ── --}}
            <div class="flex justify-end gap-2 px-6 py-4 border-t border-slate-100 bg-slate-50/50 flex-shrink-0">
                @if($bSt === 'Menunggu')
                    {{-- Menunggu: Tolak + Setujui + Tutup --}}
                    <button type="button" onclick="openPenolakanDariDetail({{ $b->id }})"
                            class="px-4 py-2 bg-rose-500 hover:bg-rose-600 text-white rounded-xl text-xs font-semibold transition">
                        Tolak
                    </button>
                    <form action="{{ route('admin.peminjaman.approve', $b->id) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit"
                                class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-semibold transition">
                            Setujui
                        </button>
                    </form>
                    <button type="button" onclick="toggleModal('modal-detail-{{ $b->id }}')"
                            class="px-4 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded-xl text-xs font-semibold transition">
                        Tutup
                    </button>

                @elseif($bSt === 'Disetujui')
                    {{-- Disetujui: Catat Peminjaman (ungu) + Tutup --}}
                    <form action="{{ route('admin.peminjaman.borrow', $b->id) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit"
                                class="px-5 py-2 bg-violet-600 hover:bg-violet-700 text-white rounded-xl text-xs font-semibold transition">
                            <i class="fa-solid fa-clipboard-check mr-1.5"></i>Catat Peminjaman
                        </button>
                    </form>
                    <button type="button" onclick="toggleModal('modal-detail-{{ $b->id }}')"
                            class="px-4 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded-xl text-xs font-semibold transition">
                        Tutup
                    </button>

                @elseif($isDipinjam)
                    {{-- Dipinjam: Catat Pengembalian (hijau) + Tutup --}}
                    <button type="button" onclick="toggleModal('modal-detail-{{ $b->id }}')"
                            class="px-4 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded-xl text-xs font-semibold transition">
                        Tutup
                    </button>
                    <button type="button"
                            onclick="validasiDanSubmitPengembalian('form-return-{{ $b->id }}')"
                            class="px-5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-semibold transition">
                        <i class="fa-solid fa-rotate-left mr-1.5"></i>Catat Pengembalian
                    </button>

                @else
                    {{-- Ditolak / Selesai: hanya Tutup --}}
                    <button type="button" onclick="toggleModal('modal-detail-{{ $b->id }}')"
                            class="px-4 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded-xl text-xs font-semibold transition">
                        Tutup
                    </button>
                @endif
            </div>

            @if($isDipinjam)
            </form>
            @endif

        </div>{{-- /modal inner --}}
    </div>{{-- /modal overlay --}}

@endforeach

{{-- MODAL KONFIRMASI PENOLAKAN --}}
<div id="modal-konfirmasi-penolakan"
     class="fixed inset-0 z-[60] hidden bg-slate-900/50 backdrop-blur-sm opacity-0 flex items-center justify-center p-4 transition-opacity duration-300">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md overflow-hidden scale-95 transition-transform duration-300">
        <form id="form-penolakan" method="POST" action="">
            @csrf
            <div class="px-6 py-4 border-b border-slate-100">
                <h3 class="font-bold text-slate-800 text-sm">Konfirmasi Penolakan</h3>
                <p class="text-xs text-slate-400 mt-0.5">Berikan alasan penolakan peminjaman ini.</p>
            </div>
            <div class="p-6">
                <label for="catatan_admin" class="block text-xs font-semibold text-slate-700 mb-2">
                    Alasan Penolakan <span class="text-rose-500">*</span>
                </label>
                <textarea name="catatan_admin" id="catatan_admin" rows="4" required maxlength="1000"
                          placeholder="Contoh: Alat sedang dalam perbaikan."
                          class="w-full border border-slate-200 rounded-xl p-3 text-xs focus:outline-none focus:ring-1 focus:ring-rose-400 focus:border-rose-400 transition resize-none"></textarea>
            </div>
            <div class="flex justify-end gap-2 px-6 py-4 border-t border-slate-100 bg-slate-50/50">
                <button type="button" onclick="closePenolakan()"
                        class="px-4 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded-xl text-xs font-semibold transition">
                    Batal
                </button>
                <button type="submit"
                        class="px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white rounded-xl text-xs font-semibold transition">
                    <i class="fa-solid fa-xmark mr-1.5"></i>Tolak Peminjaman
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
// ================================================================
// MODAL HELPERS
// ================================================================
let activeDetailModalId = null;

function toggleModal(modalId) {
    const modal = document.getElementById(modalId);
    if (!modal) return;
    const content = modal.querySelector('div');

    if (modal.classList.contains('hidden')) {
        modal.classList.remove('hidden');
        if (modalId !== 'modal-konfirmasi-penolakan') {
            activeDetailModalId = modalId;
        }
        requestAnimationFrame(() => {
            modal.classList.remove('opacity-0');
            content.classList.remove('scale-95');
        });
    } else {
        modal.classList.add('opacity-0');
        content.classList.add('scale-95');
        setTimeout(() => {
            modal.classList.add('hidden');
            if (modalId === activeDetailModalId) activeDetailModalId = null;
        }, 300);
    }
}

function setFormPenolakanAction(borrowingId) {
    document.getElementById('form-penolakan').action = `/admin/peminjaman/${borrowingId}/reject`;
    document.getElementById('catatan_admin').value = '';
}

function openPenolakanDariDetail(borrowingId) {
    // Sembunyikan modal detail dulu
    if (activeDetailModalId) {
        const m = document.getElementById(activeDetailModalId);
        m.classList.add('opacity-0');
        m.querySelector('div').classList.add('scale-95');
        setTimeout(() => m.classList.add('hidden'), 300);
    }
    setFormPenolakanAction(borrowingId);
    toggleModal('modal-konfirmasi-penolakan');
}

function openPenolakanLangsung(borrowingId) {
    activeDetailModalId = null;
    setFormPenolakanAction(borrowingId);
    toggleModal('modal-konfirmasi-penolakan');
}

function closePenolakan() {
    toggleModal('modal-konfirmasi-penolakan');
    // Kalau modal detail sebelumnya terbuka, tampilkan lagi
    if (activeDetailModalId) {
        const savedId = activeDetailModalId;
        setTimeout(() => {
            const m = document.getElementById(savedId);
            if (!m) return;
            m.classList.remove('hidden');
            requestAnimationFrame(() => {
                m.classList.remove('opacity-0');
                m.querySelector('div').classList.remove('scale-95');
            });
        }, 310);
    }
}

// Klik overlay untuk tutup modal
window.addEventListener('click', function (e) {
    const id = e.target.id;
    if (!id || !id.startsWith('modal-')) return;
    if (id === 'modal-konfirmasi-penolakan') {
        closePenolakan();
    } else {
        toggleModal(id);
    }
});

// ================================================================
// HITUNG TOTAL KONDISI (validasi real-time)
// ================================================================
function hitungTotal(inputEl) {
    const row = inputEl.closest('tr[data-item-row]');
    if (!row) return;

    const dipinjam = parseInt(row.dataset.dipinjam) || 0;
    const inputs   = row.querySelectorAll('input[type=number]');
    let total = 0;
    inputs.forEach(inp => total += (parseInt(inp.value) || 0));

    const totalEl = row.querySelector('.total-kondisi');
    if (!totalEl) return;

    totalEl.textContent = total;
    totalEl.classList.remove('text-rose-600', 'text-emerald-600', 'text-slate-800');
    if (total > dipinjam)       totalEl.classList.add('text-rose-600');
    else if (total === dipinjam) totalEl.classList.add('text-emerald-600');
    else                         totalEl.classList.add('text-slate-800');
}

// ================================================================
// VALIDASI KONDISI SEBELUM SUBMIT PENGEMBALIAN
// ================================================================
function validasiDanSubmitPengembalian(formId) {
    const form = document.getElementById(formId);
    if (!form) return;

    const rows = form.querySelectorAll('tr[data-item-row]');
    let adaYangBelumLengkap = false;
    let namaAlat = '';

    rows.forEach(function (row) {
        const dipinjam = parseInt(row.dataset.dipinjam) || 0;
        const inputs   = row.querySelectorAll('input[type=number]');
        let total = 0;
        inputs.forEach(inp => total += (parseInt(inp.value) || 0));

        if (total !== dipinjam) {
            adaYangBelumLengkap = true;
            if (!namaAlat) {
                // Ambil nama alat dari kolom pertama row ini
                const namaEl = row.querySelector('td:first-child');
                if (namaEl) namaAlat = namaEl.textContent.trim();
            }
        }
    });

    if (adaYangBelumLengkap) {
        Swal.fire({
            icon: 'warning',
            title: 'Kondisi Belum Lengkap',
            html: `Total kondisi setiap alat harus sama dengan jumlah yang dipinjam.<br><br>
                   <span class="text-sm text-slate-500">Pastikan kolom <b>Baik + Rusak Ringan + Rusak Berat = Dipinjam</b> untuk setiap alat.</span>`,
            confirmButtonText: 'Oke, saya isi dulu',
            confirmButtonColor: '#10b981',
            customClass: {
                popup: 'rounded-2xl text-sm',
                title: 'text-base font-bold',
            }
        });
        return;
    }

    // Semua valid → submit
    form.submit();
}


</script>
@endsection
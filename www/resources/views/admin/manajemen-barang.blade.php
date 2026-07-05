@extends('layouts.admin')

@section('title', 'Manajemen Barang - IPWIJA SmartLab')

@section('styles')
<style>
body { font-family: 'Inter', sans-serif; background-color: #F8FAFC; }
::-webkit-scrollbar { width: 6px; }
::-webkit-scrollbar-track { background: #f1f1f1; }
::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
</style>
@endsection

@section('content')

<div class="flex justify-between items-center mb-6">
    <div>
        <h2 class="text-2xl font-bold text-slate-900 tracking-tight">Manajemen Barang</h2>
        <p class="text-slate-500 text-sm mt-1">Atur inventaris barang laboratorium Universitas IPWIJA.</p>
    </div>
    <button onclick="toggleModal('modal-tambah')"
            class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2.5 rounded-xl text-xs transition shadow-sm flex items-center gap-2">
        <i class="fa-solid fa-plus"></i> Tambah Barang
    </button>
</div>

{{-- FILTER BAR --}}
<div class="flex flex-col sm:flex-row gap-3 mb-6">
    <div class="relative flex-1">
        <i class="fa-solid fa-magnifying-glass text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2 text-xs"></i>
        <input type="text" id="input-cari-barang"
               placeholder="Cari nama alat, kode, atau lokasi..."
               class="w-full pl-9 pr-4 py-2.5 bg-white border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 transition shadow-sm">
    </div>
    <div class="relative">
        <select id="filter-kategori" class="appearance-none bg-white border border-slate-200 pl-4 pr-10 py-2.5 rounded-xl text-xs font-medium text-slate-600 focus:outline-none focus:ring-1 focus:ring-blue-500 shadow-sm cursor-pointer min-w-[160px]">
            <option value="">Semua Kategori</option>
            <option value="Furniture">Furniture</option>
            <option value="Elektronik">Elektronik</option>
            <option value="Jaringan">Jaringan</option>
            <option value="ATK">ATK</option>
            <option value="Multimedia">Multimedia</option>
            <option value="Lainnya">Lainnya</option>
        </select>
        <i class="fa-solid fa-chevron-down absolute right-3.5 top-1/2 -translate-y-1/2 text-[10px] text-slate-400 pointer-events-none"></i>
    </div>
    <div class="relative">
        <select id="filter-kondisi" class="appearance-none bg-white border border-slate-200 pl-4 pr-10 py-2.5 rounded-xl text-xs font-medium text-slate-600 focus:outline-none focus:ring-1 focus:ring-blue-500 shadow-sm cursor-pointer min-w-[160px]">
            <option value="">Semua Kondisi</option>
            <option value="Baik">Baik</option>
            <option value="Rusak Ringan">Rusak Ringan</option>
            <option value="Rusak Berat">Rusak Berat</option>
            <option value="Tidak Layak">Tidak Layak</option>
        </select>
        <i class="fa-solid fa-chevron-down absolute right-3.5 top-1/2 -translate-y-1/2 text-[10px] text-slate-400 pointer-events-none"></i>
    </div>
    <button id="btn-terapkan-filter" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2.5 rounded-xl text-xs transition shadow-sm flex items-center gap-2">
        <i class="fa-solid fa-filter"></i> Filter
    </button>
</div>

{{-- TABLE --}}
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs border-collapse">
            <thead>
                <tr class="border-b border-slate-100 text-slate-400 font-semibold uppercase tracking-wider text-[10px]">
                    <th class="py-3 px-6">Kode Barang</th>
                    <th class="py-3 px-6">Nama Barang</th>
                    <th class="py-3 px-6">Kategori</th>
                    <th class="py-3 px-6">Stok</th>
                    <th class="py-3 px-6">Satuan</th>
                    <th class="py-3 px-6">Lokasi</th>
                    <th class="py-3 px-6">Kondisi</th>
                    <th class="py-3 px-6 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-slate-700" id="tbody-barang">
                @forelse($items ?? [] as $item)
                @php
                    $kondisiNorm = $item->kondisi ?? '';
                @endphp
                <tr class="hover:bg-slate-50/60 transition"
                    data-nama="{{ strtolower($item->nama_barang) }}"
                    data-kode="{{ strtolower($item->kode_barang) }}"
                    data-lokasi="{{ strtolower($item->lokasi) }}"
                    data-kategori="{{ $item->kategori }}"
                    data-kondisi="{{ $kondisiNorm }}">
                    <td class="py-4 px-6 font-semibold text-slate-800 text-xs">{{ $item->kode_barang }}</td>
                    <td class="py-4 px-6 font-semibold text-slate-800 text-xs">{{ $item->nama_barang }}</td>
                    <td class="py-4 px-6">
                        <span class="px-2 py-1 rounded bg-slate-100 text-slate-600 font-medium text-[11px]">{{ $item->kategori }}</span>
                    </td>
                    <td class="py-4 px-6 font-bold text-xs {{ $item->stok == 0 ? 'text-rose-600' : (isset($item->stok_minimum) && $item->stok <= $item->stok_minimum ? 'text-amber-600' : 'text-slate-800') }}">
                        {{ $item->stok }}
                    </td>
                    <td class="py-4 px-6 text-slate-500 text-xs">{{ $item->satuan }}</td>
                    <td class="py-4 px-6 text-slate-500 text-xs font-medium">
                        <i class="fa-solid fa-location-dot text-slate-300 mr-1"></i>{{ $item->lokasi }}
                    </td>
                    <td class="py-4 px-6">
                        @if($kondisiNorm === 'Baik')
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-600 text-[10px] font-bold">
                                <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>Baik
                            </span>
                        @elseif($kondisiNorm === 'Rusak Ringan')
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-amber-50 text-amber-600 text-[10px] font-bold">
                                <span class="w-1.5 h-1.5 bg-amber-500 rounded-full"></span>Rusak Ringan
                            </span>
                        @elseif($kondisiNorm === 'Rusak Berat' || $kondisiNorm === 'Rusak')
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-rose-50 text-rose-600 text-[10px] font-bold">
                                <span class="w-1.5 h-1.5 bg-rose-500 rounded-full"></span>Rusak Berat
                            </span>
                        @elseif($kondisiNorm === 'Tidak Layak')
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-slate-100 text-slate-500 text-[10px] font-bold">
                                <span class="w-1.5 h-1.5 bg-slate-400 rounded-full"></span>Tidak Layak
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-slate-100 text-slate-500 text-[10px] font-bold">
                                <span class="w-1.5 h-1.5 bg-slate-400 rounded-full"></span>{{ $kondisiNorm }}
                            </span>
                        @endif
                    </td>
                    <td class="py-4 px-6">
                        <div class="flex items-center justify-center gap-1.5">
                            <button onclick="toggleModal('modal-detail-{{ $item->id }}')"
                                    class="w-7 h-7 flex items-center justify-center rounded-lg text-slate-400 hover:text-slate-700 hover:bg-slate-100 transition" title="Lihat Detail">
                                <i class="fa-regular fa-eye text-sm"></i>
                            </button>
                            <button onclick="toggleModal('modal-edit-{{ $item->id }}')"
                                    class="w-7 h-7 flex items-center justify-center rounded-lg text-slate-400 hover:text-blue-600 hover:bg-blue-50 transition" title="Edit">
                                <i class="fa-regular fa-pen-to-square text-sm"></i>
                            </button>
                            <button onclick="toggleModal('modal-mutasi-{{ $item->id }}')"
                                    class="w-7 h-7 flex items-center justify-center rounded-lg text-slate-400 hover:text-emerald-600 hover:bg-emerald-50 transition" title="Mutasi Stok">
                                <i class="fa-solid fa-right-left text-sm"></i>
                            </button>
                            <button type="button"
                                    onclick="konfirmasiHapus({{ $item->id }}, '{{ addslashes($item->nama_barang) }}')"
                                    class="w-7 h-7 flex items-center justify-center rounded-lg text-slate-400 hover:text-rose-600 hover:bg-rose-50 transition" title="Hapus">
                                <i class="fa-solid fa-trash text-sm"></i>
                            </button>
                            {{-- Hidden form hapus --}}
                            <form id="form-hapus-{{ $item->id }}"
                                  action="{{ route('admin.manajemen_barang.destroy', $item->id) }}"
                                  method="POST" class="hidden">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-12 text-slate-400 text-xs">
                        <i class="fa-regular fa-folder-open text-2xl mb-2 block"></i>
                        Belum ada data barang.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <p id="pesan-kosong-barang" class="hidden text-center py-10 text-slate-400 text-xs">
            <i class="fa-solid fa-magnifying-glass text-xl mb-2 block"></i>
            Tidak ada barang yang cocok dengan pencarian/filter.
        </p>
    </div>
    <div class="px-6 py-4 border-t border-slate-100 flex items-center justify-between">
        <p class="text-xs text-slate-400">
            Menampilkan {{ $items->firstItem() }}–{{ $items->lastItem() }} dari {{ $items->total() }} alat
        </p>
        {{ $items->links() }}
    </div>
</div>

{{-- ============================================================
     MODAL TAMBAH BARANG
     ============================================================ --}}
<div id="modal-tambah"
     class="fixed inset-0 z-50 hidden bg-slate-900/50 backdrop-blur-sm opacity-0 flex items-center justify-center p-4 transition-opacity duration-300">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg overflow-hidden scale-95 transition-transform duration-300 max-h-[92vh] flex flex-col">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between flex-shrink-0">
            <h3 class="font-bold text-slate-800 text-sm">Tambah Alat Baru</h3>
            <button onclick="toggleModal('modal-tambah')"
                    class="w-8 h-8 flex items-center justify-center rounded-lg text-slate-400 hover:text-rose-500 hover:bg-rose-50 transition">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <div class="overflow-y-auto flex-1 p-6">
            <form action="{{ route('admin.manajemen_barang.store') }}" method="POST" id="form-tambah">
                @csrf
                <div class="space-y-4">
                    {{-- Kode Barang --}}
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Kode Barang</label>
                        <input type="text" name="kode_barang" required placeholder="BRG-001"
                               class="w-full px-3 py-2.5 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 transition">
                    </div>
                    {{-- Nama Barang --}}
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Nama Barang</label>
                        <input type="text" name="nama_barang" required
                               class="w-full px-3 py-2.5 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 transition">
                    </div>
                    {{-- Kategori + Satuan --}}
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1.5">Kategori</label>
                            <div class="relative">
                                <select name="kategori" required
                                        class="w-full px-3 py-2.5 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 transition appearance-none bg-white pr-8">
                                    <option value="">Pilih kategori</option>
                                    <option value="Furniture">Furniture</option>
                                    <option value="Elektronik">Elektronik</option>
                                    <option value="Jaringan">Jaringan</option>
                                    <option value="ATK">ATK</option>
                                    <option value="Multimedia">Multimedia</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                                <i class="fa-solid fa-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-[10px] text-slate-400 pointer-events-none"></i>
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1.5">Satuan</label>
                            <input type="text" name="satuan" required placeholder="pcs, unit, roll..."
                                   class="w-full px-3 py-2.5 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 transition">
                        </div>
                    </div>
                    {{-- Stok Saat Ini + Stok Minimum --}}
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1.5">Stok Saat Ini</label>
                            <input type="number" name="stok" required min="0" value="0"
                                   class="w-full px-3 py-2.5 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 transition">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1.5">Stok Minimum</label>
                            <input type="number" name="stok_minimum" required min="0" value="0"
                                   class="w-full px-3 py-2.5 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 transition">
                        </div>
                    </div>
                    {{-- Kondisi + Lokasi --}}
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1.5">Kondisi</label>
                            <div class="relative">
                                <select name="kondisi" required
                                        class="w-full px-3 py-2.5 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 transition appearance-none bg-white pr-8">
                                    <option value="">Pilih kondisi</option>
                                    <option value="Baik">Baik</option>
                                    <option value="Rusak Ringan">Rusak Ringan</option>
                                    <option value="Rusak Berat">Rusak Berat</option>
                                    <option value="Tidak Layak">Tidak Layak</option>
                                </select>
                                <i class="fa-solid fa-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-[10px] text-slate-400 pointer-events-none"></i>
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1.5">Lokasi</label>
                            <input type="text" name="lokasi" required placeholder="Gedung, Ruangan..."
                                   class="w-full px-3 py-2.5 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 transition">
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="flex justify-end gap-2 px-6 py-4 border-t border-slate-100 bg-slate-50/50 flex-shrink-0">
            <button type="button" onclick="toggleModal('modal-tambah')"
                    class="px-4 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded-xl text-xs font-semibold transition">
                Batal
            </button>
            <button type="submit" form="form-tambah"
                    class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-semibold transition">
                Tambah Barang
            </button>
        </div>
    </div>
</div>

{{-- ============================================================
     MODALS PER ITEM
     ============================================================ --}}
@foreach($items ?? [] as $item)
@php
    $kondisiNorm = $item->kondisi ?? '';
    $stokMin     = $item->stok_minimum ?? 0;
    $stokStat = match(true) {
        $kondisiNorm === 'Tidak Layak'  => 'Tidak Layak',
        $item->stok == 0                => 'Habis',
        $item->stok <= $stokMin         => 'Stok Rendah',
        default                         => 'Aman',
    };
    $stokStatColor = match($stokStat) {
        'Habis'        => 'text-rose-600',
        'Stok Rendah'  => 'text-amber-500',
        'Tidak Layak'  => 'text-slate-500',
        default        => 'text-emerald-600',
    };
    $tglRestock = $item->updated_at ?? $item->created_at;
@endphp

{{-- ── MODAL DETAIL ── --}}
<div id="modal-detail-{{ $item->id }}"
     class="fixed inset-0 z-50 hidden bg-slate-900/50 backdrop-blur-sm opacity-0 flex items-center justify-center p-4 transition-opacity duration-300">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md overflow-hidden scale-95 transition-transform duration-300 max-h-[90vh] flex flex-col">

        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between flex-shrink-0">
            <div>
                <p class="text-[10px] text-slate-400 font-semibold uppercase tracking-wider">Kode Barang</p>
                <h3 class="font-bold text-slate-800 text-sm mt-0.5">{{ $item->kode_barang }}</h3>
            </div>
            <button onclick="toggleModal('modal-detail-{{ $item->id }}')"
                    class="w-8 h-8 flex items-center justify-center rounded-lg text-slate-400 hover:text-rose-500 hover:bg-rose-50 transition">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <div class="overflow-y-auto flex-1 p-6 space-y-4">
            {{-- Nama + badge kondisi + kategori --}}
            <div>
                <p class="text-base font-bold text-slate-900">{{ $item->nama_barang }}</p>
                <div class="flex items-center gap-2 mt-1.5">
                    <span class="px-2 py-0.5 bg-slate-100 text-slate-600 rounded text-[11px] font-medium">{{ $item->kategori }}</span>
                    @if($kondisiNorm === 'Baik')
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-600 text-[10px] font-bold">
                            <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>Baik
                        </span>
                    @elseif($kondisiNorm === 'Rusak Ringan')
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-amber-50 text-amber-600 text-[10px] font-bold">
                            <span class="w-1.5 h-1.5 bg-amber-500 rounded-full"></span>Rusak Ringan
                        </span>
                    @elseif($kondisiNorm === 'Rusak Berat' || $kondisiNorm === 'Rusak')
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-rose-50 text-rose-600 text-[10px] font-bold">
                            <span class="w-1.5 h-1.5 bg-rose-500 rounded-full"></span>Rusak Berat
                        </span>
                    @elseif($kondisiNorm === 'Tidak Layak')
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-slate-100 text-slate-500 text-[10px] font-bold">
                            <span class="w-1.5 h-1.5 bg-slate-400 rounded-full"></span>Tidak Layak
                        </span>
                    @endif
                </div>
            </div>

            {{-- Informasi Stok --}}
            <div class="rounded-xl border border-slate-100 bg-slate-50/60 p-4">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-3">Informasi Stok</p>
                <div class="grid grid-cols-4 gap-2 text-center">
                    <div>
                        <p class="text-[9px] text-slate-400 mb-1">Stok Saat Ini</p>
                        <p class="text-sm font-bold {{ $item->stok == 0 ? 'text-rose-600' : 'text-slate-800' }}">{{ $item->stok }}</p>
                    </div>
                    <div>
                        <p class="text-[9px] text-slate-400 mb-1">Stok Minimum</p>
                        <p class="text-sm font-bold text-slate-800">{{ $stokMin }}</p>
                    </div>
                    <div>
                        <p class="text-[9px] text-slate-400 mb-1">Status Stok</p>
                        <p class="text-xs font-bold {{ $stokStatColor }}">{{ $stokStat }}</p>
                    </div>
                    <div>
                        <p class="text-[9px] text-slate-400 mb-1">Terakhir Restock</p>
                        <p class="text-[10px] font-semibold text-slate-700">
                            {{ \Carbon\Carbon::parse($tglRestock)->translatedFormat('d M Y') }}
                        </p>
                    </div>
                </div>
                @if($stokStat === 'Stok Rendah')
                <p class="mt-3 text-[10px] text-amber-600 font-semibold flex items-center gap-1">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    Stok di bawah batas minimum ({{ $stokMin }} pcs)
                </p>
                @elseif($stokStat === 'Tidak Layak')
                <p class="mt-3 text-[10px] text-slate-500 font-semibold flex items-center gap-1">
                    <i class="fa-solid fa-circle-xmark"></i>
                    Barang dalam kondisi {{ $kondisiNorm }}, tidak dapat dipinjam
                </p>
                @elseif($stokStat === 'Habis')
                <p class="mt-3 text-[10px] text-rose-600 font-semibold flex items-center gap-1">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    Stok habis, segera lakukan restock
                </p>
                @endif
            </div>

            {{-- Detail Barang --}}
            <div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2">Detail Barang</p>
                <div class="grid grid-cols-2 gap-3">
                    <div class="rounded-xl border border-slate-100 bg-slate-50/60 p-3">
                        <p class="text-[9px] text-slate-400 mb-1">Lokasi Penyimpanan</p>
                        <p class="text-xs font-semibold text-slate-800 flex items-center gap-1">
                            <i class="fa-solid fa-location-dot text-slate-400 text-[10px]"></i>
                            {{ $item->lokasi }}
                        </p>
                    </div>
                    <div class="rounded-xl border border-slate-100 bg-slate-50/60 p-3">
                        <p class="text-[9px] text-slate-400 mb-1">Satuan</p>
                        <p class="text-xs font-semibold text-slate-800 uppercase">{{ $item->satuan }}</p>
                    </div>
                </div>
                <div class="mt-3 rounded-xl border border-slate-100 bg-slate-50/60 p-3">
                    <p class="text-[9px] text-slate-400 mb-1">Kategori</p>
                    <p class="text-xs font-semibold text-slate-800">{{ $item->kategori }}</p>
                </div>
            </div>
        </div>

        <div class="flex justify-end px-6 py-4 border-t border-slate-100 bg-slate-50/50 flex-shrink-0">
            <button onclick="toggleModal('modal-detail-{{ $item->id }}')"
                    class="px-4 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded-xl text-xs font-semibold transition">
                Tutup
            </button>
        </div>
    </div>
</div>

{{-- ── MODAL EDIT ── --}}
<div id="modal-edit-{{ $item->id }}"
     class="fixed inset-0 z-50 hidden bg-slate-900/50 backdrop-blur-sm opacity-0 flex items-center justify-center p-4 transition-opacity duration-300">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg overflow-hidden scale-95 transition-transform duration-300 max-h-[92vh] flex flex-col">

        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between flex-shrink-0">
            <h3 class="font-bold text-slate-800 text-sm">Edit Barang</h3>
            <button onclick="toggleModal('modal-edit-{{ $item->id }}')"
                    class="w-8 h-8 flex items-center justify-center rounded-lg text-slate-400 hover:text-rose-500 hover:bg-rose-50 transition">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <div class="overflow-y-auto flex-1 p-6">
            <form action="{{ route('admin.manajemen_barang.update', $item->id) }}" method="POST" id="form-edit-{{ $item->id }}">
                @csrf
                @method('PUT')
                <div class="space-y-4">
                    {{-- Kode Barang (readonly) --}}
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Kode Barang</label>
                        <input type="text" value="{{ $item->kode_barang }}" readonly
                               class="w-full px-3 py-2.5 border border-slate-100 rounded-xl text-xs bg-slate-50 text-slate-400 cursor-not-allowed">
                    </div>
                    {{-- Nama Barang --}}
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Nama Barang</label>
                        <input type="text" name="nama_barang" required value="{{ $item->nama_barang }}"
                               class="w-full px-3 py-2.5 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-1 focus:ring-blue-500 transition">
                    </div>
                    {{-- Kategori + Satuan --}}
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1.5">Kategori</label>
                            <div class="relative">
                                <select name="kategori" required
                                        class="w-full px-3 py-2.5 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-1 focus:ring-blue-500 transition appearance-none bg-white pr-8">
                                    @foreach(['Furniture','Elektronik','Jaringan','ATK','Multimedia','Lainnya'] as $kat)
                                    <option value="{{ $kat }}" {{ $item->kategori == $kat ? 'selected' : '' }}>{{ $kat }}</option>
                                    @endforeach
                                </select>
                                <i class="fa-solid fa-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-[10px] text-slate-400 pointer-events-none"></i>
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1.5">Satuan</label>
                            <input type="text" name="satuan" required value="{{ $item->satuan }}"
                                   class="w-full px-3 py-2.5 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-1 focus:ring-blue-500 transition">
                        </div>
                    </div>
                    {{-- Stok Saat Ini + Stok Minimum --}}
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1.5">Stok Saat Ini</label>
                            <input type="number" name="stok" required min="0" value="{{ $item->stok }}"
                                   class="w-full px-3 py-2.5 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-1 focus:ring-blue-500 transition">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1.5">Stok Minimum</label>
                            <input type="number" name="stok_minimum" required min="0" value="{{ $item->stok_minimum ?? 0 }}"
                                   class="w-full px-3 py-2.5 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-1 focus:ring-blue-500 transition">
                        </div>
                    </div>
                    {{-- Kondisi + Lokasi --}}
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1.5">Kondisi</label>
                            <div class="relative">
                                <select name="kondisi" required
                                        class="w-full px-3 py-2.5 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-1 focus:ring-blue-500 transition appearance-none bg-white pr-8">
                                    @foreach(['Baik','Rusak Ringan','Rusak Berat','Tidak Layak'] as $kond)
                                    <option value="{{ $kond }}" {{ $item->kondisi == $kond ? 'selected' : '' }}>{{ $kond }}</option>
                                    @endforeach
                                </select>
                                <i class="fa-solid fa-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-[10px] text-slate-400 pointer-events-none"></i>
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1.5">Lokasi</label>
                            <input type="text" name="lokasi" required value="{{ $item->lokasi }}"
                                   class="w-full px-3 py-2.5 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-1 focus:ring-blue-500 transition">
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="flex justify-end gap-2 px-6 py-4 border-t border-slate-100 bg-slate-50/50 flex-shrink-0">
            <button type="button" onclick="toggleModal('modal-edit-{{ $item->id }}')"
                    class="px-4 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded-xl text-xs font-semibold transition">
                Batal
            </button>
            <button type="submit" form="form-edit-{{ $item->id }}"
                    class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-semibold transition">
                Simpan Perubahan
            </button>
        </div>
    </div>
</div>

{{-- ── MODAL MUTASI STOK ── --}}
<div id="modal-mutasi-{{ $item->id }}"
     class="fixed inset-0 z-50 hidden bg-slate-900/50 backdrop-blur-sm opacity-0 flex items-center justify-center p-4 transition-opacity duration-300">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md overflow-hidden scale-95 transition-transform duration-300 max-h-[90vh] flex flex-col">

        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between flex-shrink-0">
            <div>
                <h3 class="font-bold text-slate-800 text-sm">Mutasi Stok</h3>
                <p class="text-[11px] text-slate-400 mt-0.5">{{ $item->nama_barang }} ({{ $item->kode_barang }})</p>
            </div>
            <button onclick="toggleModal('modal-mutasi-{{ $item->id }}')"
                    class="w-8 h-8 flex items-center justify-center rounded-lg text-slate-400 hover:text-rose-500 hover:bg-rose-50 transition">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <div class="overflow-y-auto flex-1 p-6">
            <form action="{{ route('admin.manajemen_barang.mutasi', $item->id) }}" method="POST" id="form-mutasi-{{ $item->id }}">
                @csrf

                {{-- Stok saat ini --}}
                <div class="mb-5">
                    <label class="block text-[10px] text-slate-400 font-semibold uppercase tracking-wider mb-1.5">Stok saat ini</label>
                    <div class="flex items-center px-1">
                        <span class="text-2xl font-black text-slate-800">{{ $item->stok }}</span>
                    </div>
                </div>

                {{-- Tipe Mutasi --}}
                <div class="mb-5">
                    <label class="block text-xs font-semibold text-slate-700 mb-2">Tipe Mutasi <span class="text-rose-500">*</span></label>
                    <div class="grid grid-cols-2 gap-3">
                        <label class="cursor-pointer">
                            <input type="radio" name="tipe_mutasi" value="masuk" class="peer hidden" required>
                            <div class="border border-slate-200 rounded-xl p-3.5 flex items-center justify-center gap-2 transition
                                        peer-checked:border-emerald-500 peer-checked:bg-emerald-50 peer-checked:text-emerald-600
                                        text-slate-500 hover:bg-slate-50">
                                <i class="fa-solid fa-arrow-down text-sm"></i>
                                <span class="text-xs font-bold">Stok Masuk</span>
                            </div>
                        </label>
                        <label class="cursor-pointer">
                            <input type="radio" name="tipe_mutasi" value="keluar" class="peer hidden" required>
                            <div class="border border-slate-200 rounded-xl p-3.5 flex items-center justify-center gap-2 transition
                                        peer-checked:border-rose-500 peer-checked:bg-rose-50 peer-checked:text-rose-600
                                        text-slate-500 hover:bg-slate-50">
                                <i class="fa-solid fa-arrow-up text-sm"></i>
                                <span class="text-xs font-bold">Stok Keluar</span>
                            </div>
                        </label>
                    </div>
                </div>

                {{-- Jumlah --}}
                <div class="mb-5">
                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Jumlah <span class="text-rose-500">*</span></label>
                    <div class="relative">
                        <input type="number" name="jumlah" required min="1"
                               placeholder="Masukan jumlah"
                               class="w-full px-3 py-2.5 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-1 focus:ring-blue-500 transition">
                    </div>
                </div>

                {{-- Keterangan --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">
                        Keterangan <span class="text-rose-500">*</span>
                    </label>
                    <textarea name="keterangan" rows="3" required maxlength="500"
                              placeholder="Contoh: Penambahan meja karena meja pada rusak"
                              class="w-full px-3 py-2.5 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-1 focus:ring-blue-500 transition resize-none"
                              id="keterangan-mutasi-{{ $item->id }}"
                              oninput="document.getElementById('ktr-count-{{ $item->id }}').textContent = this.value.length"></textarea>
                    <p class="text-right text-[10px] text-slate-400 mt-1">
                        <span id="ktr-count-{{ $item->id }}">0</span>/500
                    </p>
                </div>
            </form>
        </div>

        <div class="flex justify-end gap-2 px-6 py-4 border-t border-slate-100 bg-slate-50/50 flex-shrink-0">
            <button type="button" onclick="toggleModal('modal-mutasi-{{ $item->id }}')"
                    class="px-4 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded-xl text-xs font-semibold transition">
                Batal
            </button>
            <button type="submit" form="form-mutasi-{{ $item->id }}"
                    id="btn-submit-mutasi-{{ $item->id }}"
                    class="px-5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-semibold transition">
                <i class="fa-solid fa-arrow-down mr-1.5"></i>Tambah Stok
            </button>
        </div>
    </div>
</div>

@endforeach

@endsection

@section('scripts')
<script>
// ================================================================
// MODAL HELPERS
// ================================================================
function toggleModal(modalId) {
    const modal = document.getElementById(modalId);
    if (!modal) return;
    const content = modal.querySelector('div');

    if (modal.classList.contains('hidden')) {
        modal.classList.remove('hidden');
        requestAnimationFrame(() => {
            modal.classList.remove('opacity-0');
            content.classList.remove('scale-95');
        });
    } else {
        modal.classList.add('opacity-0');
        content.classList.add('scale-95');
        setTimeout(() => modal.classList.add('hidden'), 300);
    }
}

window.addEventListener('click', function (e) {
    const id = e.target.id;
    if (id && id.startsWith('modal-')) toggleModal(id);
});

// ================================================================
// HAPUS BARANG — SweetAlert konfirmasi
// ================================================================
function konfirmasiHapus(itemId, namaBarang) {
    Swal.fire({
        icon: 'warning',
        title: 'Hapus Barang?',
        html: `Barang <b>${namaBarang}</b> akan dihapus secara permanen.<br>
               <span class="text-sm text-slate-500">Tindakan ini tidak bisa dibatalkan.</span>`,
        showCancelButton: true,
        confirmButtonText: 'Ya, Hapus',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#e11d48',
        cancelButtonColor: '#94a3b8',
        customClass: {
            popup: 'rounded-2xl text-sm',
            title: 'text-base font-bold',
        }
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('form-hapus-' + itemId).submit();
        }
    });
}

// ================================================================
// MUTASI STOK — update label tombol submit & style sesuai tipe
// ================================================================
document.querySelectorAll('input[name="tipe_mutasi"]').forEach(function(radio) {
    radio.addEventListener('change', function() {
        // Cari form-mutasi terdekat
        const form = this.closest('form');
        if (!form) return;
        const formId   = form.id; // "form-mutasi-{id}"
        const itemId   = formId.replace('form-mutasi-', '');
        const btnSubmit = document.getElementById('btn-submit-mutasi-' + itemId);
        if (!btnSubmit) return;

        if (this.value === 'masuk') {
            btnSubmit.className = 'px-5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-semibold transition';
            btnSubmit.innerHTML = '<i class="fa-solid fa-arrow-down mr-1.5"></i>Tambah Stok';
        } else {
            btnSubmit.className = 'px-5 py-2 bg-rose-600 hover:bg-rose-700 text-white rounded-xl text-xs font-semibold transition';
            btnSubmit.innerHTML = '<i class="fa-solid fa-arrow-up mr-1.5"></i>Kurangi Stok';
        }
    });
});

// ================================================================
// FILTER & SEARCH — client-side
// ================================================================
(function () {
    const inputCari    = document.getElementById('input-cari-barang');
    const filterKat    = document.getElementById('filter-kategori');
    const filterKond   = document.getElementById('filter-kondisi');
    const tbody        = document.getElementById('tbody-barang');
    const pesanKosong  = document.getElementById('pesan-kosong-barang');
    const btnFilter    = document.getElementById('btn-terapkan-filter');
    if (!tbody || !btnFilter) return;

    const baris = Array.from(tbody.querySelectorAll('tr[data-nama]'));

    function terapkanFilter() {
        const kata    = inputCari.value.trim().toLowerCase();
        const kat     = filterKat.value;
        const kond    = filterKond.value;
        let ada = false;

        baris.forEach(function(tr) {
            const cocokKata = kata === '' ||
                tr.dataset.nama.includes(kata) ||
                tr.dataset.kode.includes(kata) ||
                tr.dataset.lokasi.includes(kata);
            const cocokKat  = kat  === '' || tr.dataset.kategori === kat;
            const cocokKond = kond === '' || tr.dataset.kondisi === kond;
            const tampil = cocokKata && cocokKat && cocokKond;
            tr.classList.toggle('hidden', !tampil);
            if (tampil) ada = true;
        });

        if (pesanKosong) pesanKosong.classList.toggle('hidden', ada || baris.length === 0);
    }

    btnFilter.addEventListener('click', terapkanFilter);
    inputCari.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') terapkanFilter();
    });
})();
</script>
@endsection
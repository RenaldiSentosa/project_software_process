@extends('layouts.admin')

@section('title', 'Manajemen Alat - IPWIJA SmartLab')

@section('styles')
<style>
body {
            font-family: 'Inter', sans-serif;
            background-color: #F8FAFC;
        }
        ::-webkit-scrollbar {
            width: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
        .stepper-btn {
            width: 22px;
            height: 22px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
            transition: background-color .15s;
        }
        .stepper-btn:hover {
            background-color: rgba(0,0,0,0.06);
        }
</style>
@endsection

@section('content')
            
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="text-2xl font-bold text-slate-900 tracking-tight">Manajemen Alat</h2>
                    <p class="text-slate-500 text-sm mt-1">Kelola data alat laboratorium Universitas IPWIJA.</p>
                </div>
                <button onclick="toggleModal('modal-tambah')" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2.5 rounded-lg flex items-center gap-2 transition text-sm shadow-sm">
                    <i class="fa-solid fa-plus text-xs"></i>
                    Tambah Alat
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-5">
                <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center gap-4">
                    <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center text-lg"><i class="fa-solid fa-circle-check"></i></div>
                    <div>
                        <span class="text-xs font-medium text-slate-400 uppercase tracking-wider block">Tersedia</span>
                        <span class="text-2xl font-bold text-slate-800 block">{{ $statusTersedia ?? '10' }}</span>
                    </div>
                </div>
                <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center gap-4">
                    <div class="w-12 h-12 bg-purple-50 text-purple-600 rounded-xl flex items-center justify-center text-lg"><i class="fa-solid fa-right-left rotate-90"></i></div>
                    <div>
                        <span class="text-xs font-medium text-slate-400 uppercase tracking-wider block">Dipinjam</span>
                        <span class="text-2xl font-bold text-slate-800 block">{{ $statusDipinjam ?? '35' }}</span>
                    </div>
                </div>
                <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center gap-4">
                    <div class="w-12 h-12 bg-rose-50 text-rose-600 rounded-xl flex items-center justify-center text-lg"><i class="fa-solid fa-circle-xmark"></i></div>
                    <div>
                        <span class="text-xs font-medium text-slate-400 uppercase tracking-wider block">Rusak</span>
                        <span class="text-2xl font-bold text-slate-800 block">{{ $statusRusak ?? '13' }}</span>
                    </div>
                </div>
                <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center gap-4">
                    <div class="w-12 h-12 bg-amber-50 text-amber-500 rounded-xl flex items-center justify-center text-lg"><i class="fa-solid fa-screwdriver-wrench"></i></div>
                    <div>
                        <span class="text-xs font-medium text-slate-400 uppercase tracking-wider block">Dalam Perbaikan</span>
                        <span class="text-2xl font-bold text-slate-800 block">{{ $statusPerbaikan ?? '5' }}</span>
                    </div>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row gap-3">
                <div class="relative flex-1">
                    <i class="fa-solid fa-magnifying-glass text-slate-400 absolute left-4 top-3.5 text-xs"></i>
                    <input type="text" placeholder="Cari nama alat, kode, atau lokasi..." class="w-full pl-10 pr-4 py-2.5 bg-white border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-blue-500 transition shadow-sm">
                </div>
                <div class="relative">
                    <select class="appearance-none bg-white border border-slate-200 pl-4 pr-10 py-2.5 rounded-xl text-xs font-medium text-slate-600 focus:outline-none shadow-sm cursor-pointer min-w-[140px]">
                        <option>Semua Kategori</option>
                        <option>Hardware</option>
                        <option>Network</option>
                        <option>IoT</option>
                        <option>Lainnya</option>
                    </select>
                    <i class="fa-solid fa-chevron-down absolute right-4 top-4 text-[10px] text-slate-400 pointer-events-none"></i>
                </div>
                <div class="relative">
                    <select class="appearance-none bg-white border border-slate-200 pl-4 pr-10 py-2.5 rounded-xl text-xs font-medium text-slate-600 focus:outline-none shadow-sm cursor-pointer min-w-[140px]">
                        <option>Semua Status</option>
                        <option>Tersedia</option>
                        <option>Dipinjam</option>
                        <option>Rusak</option>
                        <option>Dalam Perbaikan</option>
                    </select>
                    <i class="fa-solid fa-chevron-down absolute right-4 top-4 text-[10px] text-slate-400 pointer-events-none"></i>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="p-5 border-b border-slate-100">
                    <h3 class="font-bold text-slate-800 text-sm">Daftar Alat Laboratorium</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs border-collapse">
                        <thead>
                            <tr class="bg-slate-50/70 border-b border-slate-100 text-slate-400 font-semibold uppercase tracking-wider">
                                <th class="py-4 px-6">Kode Alat</th>
                                <th class="py-4 px-6">Nama Alat</th>
                                <th class="py-4 px-6">Kategori</th>
                                <th class="py-4 px-6">Stok Total</th>
                                <th class="py-4 px-6">Tersedia</th>
                                <th class="py-4 px-6">Lokasi</th>
                                <th class="py-4 px-6">Status</th>
                                <th class="py-4 px-6 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-700">
                            @forelse($alatList ?? [] as $alat)
                                @php
                                    // ===== Perhitungan tampilan distribusi unit (TIDAK disimpan ke DB) =====
                                    // Karena tabel alat belum punya kolom per-status, angka di bawah ini
                                    // hanya disusun dari kolom yang sudah ada (stok_total & stok_tersedia)
                                    // supaya modal Detail & Edit bisa menampilkan breakdown sesuai mockup.
                                    $dTersedia = $alat->stok_tersedia ?? 0;
                                    $sisaUnit  = max(($alat->stok_total ?? 0) - $dTersedia, 0);

                                    // Sisa unit (yang tidak tersedia) dibagi ke Dipinjam/Rusak/Perbaikan
                                    // berdasarkan status_alat saat ini, sebagai contoh tampilan saja.
                                    $dDipinjam  = 0;
                                    $dRusak     = 0;
                                    $dPerbaikan = 0;

                                    if ($alat->status_alat == 'Dipinjam') {
                                        $dDipinjam = $sisaUnit;
                                    } elseif ($alat->status_alat == 'Rusak') {
                                        $dRusak = $sisaUnit;
                                    } elseif ($alat->status_alat == 'Dalam Perbaikan') {
                                        $dPerbaikan = $sisaUnit;
                                    } else {
                                        $dDipinjam = $sisaUnit;
                                    }
                                @endphp
                                <tr class="hover:bg-slate-50/50 transition">
                                    <td class="py-4 px-6 font-medium text-slate-500">{{ $alat->kode_alat }}</td>
                                    <td class="py-4 px-6"><span class="font-semibold text-slate-800 block">{{ $alat->nama_alat }}</span><span class="text-slate-400 text-[11px]">{{ $alat->kondisi_fisik }}</span></td>
                                    <td class="py-4 px-6"><span class="px-2 py-0.5 bg-blue-50 text-blue-600 rounded text-[11px] font-medium">{{ $alat->kategori }}</span></td>
                                    <td class="py-4 px-6 font-medium">{{ $alat->stok_total }}</td>
                                    <td class="py-4 px-6 font-medium @if($alat->stok_tersedia == 0) text-rose-600 @endif">{{ $alat->stok_tersedia }}</td>
                                    <td class="py-4 px-6 text-slate-500 font-medium"><i class="fa-solid fa-location-dot mr-1.5 text-slate-400"></i>{{ $alat->lokasi }}</td>
                                    <td class="py-4 px-6">
                                        @if($alat->status_alat == 'Tersedia')
                                            <span class="px-2 py-0.5 rounded bg-emerald-50 text-emerald-600 text-[10px] font-bold">Tersedia</span>
                                        @elseif($alat->status_alat == 'Dipinjam')
                                            <span class="px-2 py-0.5 rounded bg-purple-50 text-purple-600 text-[10px] font-bold">Dipinjam</span>
                                        @elseif($alat->status_alat == 'Rusak')
                                            <span class="px-2 py-0.5 rounded bg-rose-50 text-rose-600 text-[10px] font-bold">Rusak</span>
                                        @elseif($alat->status_alat == 'Dalam Perbaikan')
                                            <span class="px-2 py-0.5 rounded bg-amber-50 text-amber-600 text-[10px] font-bold">Dalam Perbaikan</span>
                                        @elseif($alat->status_alat == 'Nonaktif')
                                            <span class="px-2 py-0.5 rounded bg-slate-100 text-slate-500 text-[10px] font-bold">Nonaktif</span>
                                        @else
                                            <span class="px-2 py-0.5 rounded bg-amber-50 text-amber-600 text-[10px] font-bold">{{ $alat->status_alat }}</span>
                                        @endif
                                    </td>
                                    <td class="py-4 px-6 text-center space-x-2 flex justify-center items-center">
                                        <button onclick="toggleModal('modal-detail-{{ $alat->id }}')" class="text-slate-400 hover:text-slate-600"><i class="fa-regular fa-eye"></i></button>
                                        <button onclick="toggleModal('modal-edit-{{ $alat->id }}')" class="text-slate-400 hover:text-blue-600"><i class="fa-regular fa-pen-to-square"></i></button>
                                        @if($alat->status_alat == 'Nonaktif')
                                            <form action="{{ route('admin.manajemen_alat.aktifkan', $alat->id) }}" method="POST" class="inline form-aktifkan-alat" data-nama-alat="{{ $alat->nama_alat }}">
                                                @csrf
                                                @method('PATCH')
                                                <button type="button" onclick="konfirmasiAktifkan(this)" class="text-slate-400 hover:text-emerald-600" title="Aktifkan alat"><i class="fa-solid fa-circle-check"></i></button>
                                            </form>
                                        @else
                                            <form action="{{ route('admin.manajemen_alat.nonaktifkan', $alat->id) }}" method="POST" class="inline form-nonaktifkan-alat" data-nama-alat="{{ $alat->nama_alat }}">
                                                @csrf
                                                @method('PATCH')
                                                <button type="button" onclick="konfirmasiNonaktifkan(this)" class="text-slate-400 hover:text-rose-600" title="Nonaktifkan alat"><i class="fa-solid fa-ban"></i></button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-8 text-slate-500">Belum ada data alat.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-5 border-t border-slate-100">
                    {{ $alatList->links() }}
                </div>
            </div>

            <!-- Modal Tambah Alat -->
            <div id="modal-tambah" class="fixed inset-0 z-50 hidden bg-slate-900/50 backdrop-blur-sm transition-opacity opacity-0 flex items-center justify-center p-4">
                <div class="bg-white rounded-xl shadow-xl w-full max-w-lg overflow-hidden transform scale-95 transition-transform duration-300 max-h-[90vh] overflow-y-auto">
                    <div class="p-5 border-b border-slate-100 flex justify-between items-center bg-slate-50 sticky top-0 z-10">
                        <h3 class="font-bold text-slate-800 text-base">Tambah Alat Baru</h3>
                        <button onclick="toggleModal('modal-tambah')" class="text-slate-400 hover:text-rose-500 transition"><i class="fa-solid fa-xmark text-lg"></i></button>
                    </div>
                    <div class="p-6">
                        <form action="{{ route('admin.manajemen_alat.store') }}" method="POST" class="form-edit-alat">
                            @csrf

                            <div class="mb-4">
                                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Kode Alat</label>
                                <input type="text" name="kode_alat" placeholder="ALT-XXX" disabled class="w-full px-3 py-2 border border-slate-200 bg-slate-50 text-slate-400 rounded-lg text-xs focus:outline-none">
                                <p class="text-[10px] text-slate-400 mt-1">Kode alat akan dibuat otomatis oleh sistem.</p>
                            </div>

                            <div class="mb-4">
                                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Nama Alat</label>
                                <input type="text" name="nama_alat" required class="w-full px-3 py-2 border border-slate-200 rounded-lg text-xs focus:outline-none focus:border-blue-500">
                            </div>

                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Kategori</label>
                                    <select name="kategori" required class="w-full px-3 py-2 border border-slate-200 rounded-lg text-xs focus:outline-none focus:border-blue-500">
                                        <option value="Hardware">Hardware</option>
                                        <option value="Network">Network</option>
                                        <option value="IoT">IoT</option>
                                        <option value="Lainnya">Lainnya</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Kondisi</label>
                                    <select name="kondisi_fisik" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-xs focus:outline-none focus:border-blue-500">
                                        <option value="Tersedia">Tersedia</option>
                                        <option value="Dipinjam">Dipinjam</option>
                                        <option value="Rusak">Rusak</option>
                                        <option value="Dalam Perbaikan">Dalam Perbaikan</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Total Unit</label>
                                <input type="number" name="stok_total" required min="0" value="0"
                                       class="input-total-unit w-full px-3 py-2 border border-slate-200 rounded-lg text-xs focus:outline-none focus:border-blue-500">
                            </div>

                            <div class="flex justify-between items-center mb-2">
                                <span class="text-xs font-semibold text-slate-700">Status Unit Alat</span>
                                <span class="text-[11px] font-medium text-slate-400">Jumlah Unit: <span class="label-jumlah-unit">0</span></span>
                            </div>

                            <div class="grid grid-cols-2 gap-3 mb-5">
                                <div class="border border-emerald-200 bg-emerald-50/40 rounded-xl p-3">
                                    <span class="flex items-center gap-1.5 text-[11px] font-semibold text-emerald-600 mb-1.5"><span class="w-2 h-2 rounded-full bg-emerald-500"></span>Tersedia</span>
                                    <div class="flex items-center justify-between bg-white border border-emerald-200 rounded-lg px-2 py-1">
                                        <input type="number" name="stok_tersedia_display" min="0"
                                               value="0"
                                               class="input-status-unit w-full bg-transparent text-emerald-700 font-bold text-sm focus:outline-none" data-status="tersedia">
                                        <div class="flex flex-col">
                                            <button type="button" class="stepper-btn stepper-up text-emerald-600 text-[10px]"><i class="fa-solid fa-chevron-up"></i></button>
                                            <button type="button" class="stepper-btn stepper-down text-emerald-600 text-[10px]"><i class="fa-solid fa-chevron-down"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="border border-purple-200 bg-purple-50/40 rounded-xl p-3">
                                    <span class="flex items-center gap-1.5 text-[11px] font-semibold text-purple-600 mb-1.5"><span class="w-2 h-2 rounded-full bg-purple-500"></span>Dipinjam</span>
                                    <div class="flex items-center justify-between bg-white border border-purple-200 rounded-lg px-2 py-1">
                                        <input type="number" name="stok_dipinjam_display" min="0"
                                               value="0"
                                               class="input-status-unit w-full bg-transparent text-purple-700 font-bold text-sm focus:outline-none" data-status="dipinjam">
                                        <div class="flex flex-col">
                                            <button type="button" class="stepper-btn stepper-up text-purple-600 text-[10px]"><i class="fa-solid fa-chevron-up"></i></button>
                                            <button type="button" class="stepper-btn stepper-down text-purple-600 text-[10px]"><i class="fa-solid fa-chevron-down"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="border border-rose-200 bg-rose-50/40 rounded-xl p-3">
                                    <span class="flex items-center gap-1.5 text-[11px] font-semibold text-rose-600 mb-1.5"><span class="w-2 h-2 rounded-full bg-rose-500"></span>Rusak</span>
                                    <div class="flex items-center justify-between bg-white border border-rose-200 rounded-lg px-2 py-1">
                                        <input type="number" name="stok_rusak_display" min="0"
                                               value="0"
                                               class="input-status-unit w-full bg-transparent text-rose-700 font-bold text-sm focus:outline-none" data-status="rusak">
                                        <div class="flex flex-col">
                                            <button type="button" class="stepper-btn stepper-up text-rose-600 text-[10px]"><i class="fa-solid fa-chevron-up"></i></button>
                                            <button type="button" class="stepper-btn stepper-down text-rose-600 text-[10px]"><i class="fa-solid fa-chevron-down"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="border border-amber-200 bg-amber-50/40 rounded-xl p-3">
                                    <span class="flex items-center gap-1.5 text-[11px] font-semibold text-amber-600 mb-1.5"><span class="w-2 h-2 rounded-full bg-amber-500"></span>Dalam Perbaikan</span>
                                    <div class="flex items-center justify-between bg-white border border-amber-200 rounded-lg px-2 py-1">
                                        <input type="number" name="stok_perbaikan_display" min="0"
                                               value="0"
                                               class="input-status-unit w-full bg-transparent text-amber-700 font-bold text-sm focus:outline-none" data-status="perbaikan">
                                        <div class="flex flex-col">
                                            <button type="button" class="stepper-btn stepper-up text-amber-600 text-[10px]"><i class="fa-solid fa-chevron-up"></i></button>
                                            <button type="button" class="stepper-btn stepper-down text-amber-600 text-[10px]"><i class="fa-solid fa-chevron-down"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <p class="peringatan-total hidden text-[11px] text-rose-500 font-medium -mt-3 mb-4">Jumlah Tersedia + Dipinjam + Rusak + Dalam Perbaikan harus sama dengan Total Unit.</p>

                            <div class="mb-4">
                                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Status Dominan (otomatis)</label>
                                <input type="text" class="label-status-dominan w-full px-3 py-2 border border-slate-200 bg-slate-50 text-slate-500 rounded-lg text-xs focus:outline-none" value="Tersedia" disabled>
                                <input type="hidden" name="status_alat" class="input-status-dominan" value="Tersedia">
                            </div>

                            <div class="grid grid-cols-2 gap-4 mb-5">
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Lokasi</label>
                                    <input type="text" name="lokasi" required class="w-full px-3 py-2 border border-slate-200 rounded-lg text-xs focus:outline-none focus:border-blue-500">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Tanggal Pengadaan</label>
                                    <input type="date" name="tanggal_pengadaan" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-xs focus:outline-none focus:border-blue-500">
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4 mb-5">
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Upload Foto</label>
                                    <label class="flex items-center justify-center w-full h-24 border-2 border-dashed border-slate-200 rounded-lg cursor-pointer hover:border-blue-400 transition bg-slate-50 overflow-hidden">
                                        <input type="file" name="foto" accept="image/*" class="hidden input-foto-alat">
                                        <span class="preview-foto-kosong flex flex-col items-center text-slate-400">
                                            <i class="fa-solid fa-image text-lg mb-1"></i>
                                            <span class="text-[10px]">Pilih gambar</span>
                                        </span>
                                        <img class="preview-foto hidden w-full h-full object-cover" src="" alt="Preview Foto Alat">
                                    </label>
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Deskripsi</label>
                                    <textarea name="deskripsi" rows="4" class="w-full h-24 px-3 py-2 border border-slate-200 rounded-lg text-xs focus:outline-none focus:border-blue-500 resize-none"></textarea>
                                </div>
                            </div>

                            <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                                <button type="button" onclick="toggleModal('modal-tambah')" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-lg text-xs font-semibold transition">Batal</button>
                                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-xs font-semibold transition">Simpan Alat</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Modals Detail & Edit per Alat -->
            @foreach($alatList ?? [] as $alat)
                @php
                    $dTersedia = $alat->stok_tersedia ?? 0;
                    $sisaUnit  = max(($alat->stok_total ?? 0) - $dTersedia, 0);
                    $dDipinjam  = 0;
                    $dRusak     = 0;
                    $dPerbaikan = 0;

                    if ($alat->status_alat == 'Dipinjam') {
                        $dDipinjam = $sisaUnit;
                    } elseif ($alat->status_alat == 'Rusak') {
                        $dRusak = $sisaUnit;
                    } elseif ($alat->status_alat == 'Dalam Perbaikan') {
                        $dPerbaikan = $sisaUnit;
                    } else {
                        $dDipinjam = $sisaUnit;
                    }
                @endphp

                <!-- Modal Detail -->
                <div id="modal-detail-{{ $alat->id }}" class="fixed inset-0 z-50 hidden bg-slate-900/50 backdrop-blur-sm transition-opacity opacity-0 flex items-center justify-center p-4">
                    <div class="bg-white rounded-xl shadow-xl w-full max-w-md overflow-hidden transform scale-95 transition-transform duration-300">
                        <div class="p-5 border-b border-slate-100 flex justify-between items-center bg-slate-50">
                            <h3 class="font-bold text-slate-800 text-base">Detail Alat</h3>
                            <button onclick="toggleModal('modal-detail-{{ $alat->id }}')" class="text-slate-400 hover:text-rose-500 transition"><i class="fa-solid fa-xmark text-lg"></i></button>
                        </div>
                        <div class="p-6">
                            <span class="text-[11px] font-medium text-slate-400 block">{{ $alat->kode_alat }}</span>
                            <h4 class="text-lg font-bold text-slate-900 mb-2">{{ $alat->nama_alat }}</h4>
                            <span class="inline-block px-2 py-0.5 bg-blue-50 text-blue-600 rounded text-[11px] font-medium mb-5">{{ $alat->kategori }}</span>

                            <div class="bg-slate-50 rounded-xl p-4 mb-5">
                                <div class="flex justify-between items-center mb-3">
                                    <span class="text-xs font-bold text-slate-700">Distribusi Unit</span>
                                    <span class="px-2.5 py-1 bg-white border border-slate-200 rounded-full text-[11px] font-semibold text-slate-600">Total: {{ $alat->stok_total }} Unit</span>
                                </div>
                                <div class="grid grid-cols-4 gap-3">
                                    <div class="bg-white border border-slate-200 rounded-lg p-3">
                                        <span class="flex items-center gap-1.5 text-[11px] font-medium text-slate-500 mb-1"><span class="w-2 h-2 rounded-full bg-emerald-500"></span>Tersedia</span>
                                        <span class="text-lg font-bold text-slate-800">{{ $dTersedia }}</span>
                                    </div>
                                    <div class="bg-white border border-slate-200 rounded-lg p-3">
                                        <span class="flex items-center gap-1.5 text-[11px] font-medium text-slate-500 mb-1"><span class="w-2 h-2 rounded-full bg-purple-500"></span>Dipinjam</span>
                                        <span class="text-lg font-bold text-slate-800">{{ $dDipinjam }}</span>
                                    </div>
                                    <div class="bg-white border border-slate-200 rounded-lg p-3">
                                        <span class="flex items-center gap-1.5 text-[11px] font-medium text-slate-500 mb-1"><span class="w-2 h-2 rounded-full bg-rose-500"></span>Rusak</span>
                                        <span class="text-lg font-bold text-slate-800">{{ $dRusak }}</span>
                                    </div>
                                    <div class="bg-white border border-slate-200 rounded-lg p-3">
                                        <span class="flex items-center gap-1.5 text-[11px] font-medium text-slate-500 mb-1"><span class="w-2 h-2 rounded-full bg-amber-500"></span>Dalam Perbaikan</span>
                                        <span class="text-lg font-bold text-slate-800">{{ $dPerbaikan }}</span>
                                    </div>
                                </div>
                            </div>

                            <span class="text-xs font-bold text-slate-700 block mb-3">Informasi Lengkap</span>
                            <div class="grid grid-cols-2 gap-4 mb-6">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-9 h-9 rounded-lg bg-blue-100 flex-shrink-0"></div>
                                    <div>
                                        <span class="text-[10px] text-slate-400 block">Kode Alat</span>
                                        <span class="text-xs font-semibold text-slate-700">{{ $alat->kode_alat }}</span>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2.5">
                                    <div class="w-9 h-9 rounded-lg bg-purple-100 flex-shrink-0"></div>
                                    <div>
                                        <span class="text-[10px] text-slate-400 block">Kategori</span>
                                        <span class="text-xs font-semibold text-slate-700">{{ $alat->kategori }}</span>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2.5">
                                    <div class="w-9 h-9 rounded-lg bg-emerald-100 flex-shrink-0"></div>
                                    <div>
                                        <span class="text-[10px] text-slate-400 block">Lokasi</span>
                                        <span class="text-xs font-semibold text-slate-700">{{ $alat->lokasi }}</span>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2.5">
                                    <div class="w-9 h-9 rounded-lg bg-amber-100 flex-shrink-0"></div>
                                    <div>
                                        <span class="text-[10px] text-slate-400 block">Tanggal Pengadaan</span>
                                        <span class="text-xs font-semibold text-slate-700">{{ $alat->tanggal_pengadaan ?? '-' }}</span>
                                    </div>
                                </div>
                            </div>

                            @if($alat->deskripsi)
                                <div class="mb-5">
                                    <span class="text-[10px] text-slate-400 block mb-1">Deskripsi</span>
                                    <p class="text-xs text-slate-600">{{ $alat->deskripsi }}</p>
                                </div>
                            @endif

                            <div class="flex justify-end pt-4 border-t border-slate-100">
                                <button type="button" onclick="toggleModal('modal-detail-{{ $alat->id }}')" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-lg text-xs font-semibold transition">Tutup</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Edit -->
                <div id="modal-edit-{{ $alat->id }}" class="fixed inset-0 z-50 hidden bg-slate-900/50 backdrop-blur-sm transition-opacity opacity-0 flex items-center justify-center p-4">
                    <div class="bg-white rounded-xl shadow-xl w-full max-w-lg overflow-hidden transform scale-95 transition-transform duration-300 max-h-[90vh] overflow-y-auto">
                        <div class="p-5 border-b border-slate-100 flex justify-between items-center bg-slate-50 sticky top-0 z-10">
                            <h3 class="font-bold text-slate-800 text-base">Edit Alat</h3>
                            <button onclick="toggleModal('modal-edit-{{ $alat->id }}')" class="text-slate-400 hover:text-rose-500 transition"><i class="fa-solid fa-xmark text-lg"></i></button>
                        </div>
                        <div class="p-6">
                            <form action="{{ route('admin.manajemen_alat.update', $alat->id) }}" method="POST" class="form-edit-alat" data-alat-id="{{ $alat->id }}">
                                @csrf
                                @method('PUT')

                                <div class="mb-4">
                                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Kode Alat</label>
                                    <input type="text" value="{{ $alat->kode_alat }}" disabled class="w-full px-3 py-2 border border-slate-200 bg-slate-50 text-slate-400 rounded-lg text-xs focus:outline-none">
                                </div>

                                <div class="mb-4">
                                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Nama Alat</label>
                                    <input type="text" name="nama_alat" required value="{{ $alat->nama_alat }}" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-xs focus:outline-none focus:border-blue-500">
                                </div>

                                <div class="grid grid-cols-2 gap-4 mb-4">
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Kategori</label>
                                        <select name="kategori" required class="w-full px-3 py-2 border border-slate-200 rounded-lg text-xs focus:outline-none focus:border-blue-500">
                                            <option value="Hardware" {{ $alat->kategori == 'Hardware' ? 'selected' : '' }}>Hardware</option>
                                            <option value="Network" {{ $alat->kategori == 'Network' ? 'selected' : '' }}>Network</option>
                                            <option value="IoT" {{ $alat->kategori == 'IoT' ? 'selected' : '' }}>IoT</option>
                                            <option value="Lainnya" {{ $alat->kategori == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Kondisi</label>
                                        <select name="kondisi_fisik" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-xs focus:outline-none focus:border-blue-500">
                                            <option value="Tersedia" {{ $alat->kondisi_fisik == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                                            <option value="Dipinjam" {{ $alat->kondisi_fisik == 'Dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                                            <option value="Rusak" {{ $alat->kondisi_fisik == 'Rusak' ? 'selected' : '' }}>Rusak</option>
                                            <option value="Dalam Perbaikan" {{ $alat->kondisi_fisik == 'Dalam Perbaikan' ? 'selected' : '' }}>Dalam Perbaikan</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Total Unit</label>
                                    <input type="number" name="stok_total" required min="0"
                                           value="{{ $alat->stok_total }}"
                                           class="input-total-unit w-full px-3 py-2 border border-slate-200 rounded-lg text-xs focus:outline-none focus:border-blue-500">
                                </div>

                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-xs font-semibold text-slate-700">Status Unit Alat</span>
                                    <span class="text-[11px] font-medium text-slate-400">Jumlah Unit: <span class="label-jumlah-unit">{{ $alat->stok_total }}</span></span>
                                </div>

                                <div class="grid grid-cols-2 gap-3 mb-5">
                                    <div class="border border-emerald-200 bg-emerald-50/40 rounded-xl p-3">
                                        <span class="flex items-center gap-1.5 text-[11px] font-semibold text-emerald-600 mb-1.5"><span class="w-2 h-2 rounded-full bg-emerald-500"></span>Tersedia</span>
                                        <div class="flex items-center justify-between bg-white border border-emerald-200 rounded-lg px-2 py-1">
                                            <input type="number" name="stok_tersedia_display" min="0"
                                                   value="{{ $dTersedia }}"
                                                   class="input-status-unit w-full bg-transparent text-emerald-700 font-bold text-sm focus:outline-none" data-status="tersedia">

                                        </div>
                                    </div>
                                    <div class="border border-purple-200 bg-purple-50/40 rounded-xl p-3">
                                        <span class="flex items-center gap-1.5 text-[11px] font-semibold text-purple-600 mb-1.5"><span class="w-2 h-2 rounded-full bg-purple-500"></span>Dipinjam</span>
                                        <div class="flex items-center justify-between bg-white border border-purple-200 rounded-lg px-2 py-1">
                                            <input type="number" name="stok_dipinjam_display" min="0"
                                                   value="{{ $dDipinjam }}"
                                                   class="input-status-unit w-full bg-transparent text-purple-700 font-bold text-sm focus:outline-none" data-status="dipinjam">

                                        </div>
                                    </div>
                                    <div class="border border-rose-200 bg-rose-50/40 rounded-xl p-3">
                                        <span class="flex items-center gap-1.5 text-[11px] font-semibold text-rose-600 mb-1.5"><span class="w-2 h-2 rounded-full bg-rose-500"></span>Rusak</span>
                                        <div class="flex items-center justify-between bg-white border border-rose-200 rounded-lg px-2 py-1">
                                            <input type="number" name="stok_rusak_display" min="0"
                                                   value="{{ $dRusak }}"
                                                   class="input-status-unit w-full bg-transparent text-rose-700 font-bold text-sm focus:outline-none" data-status="rusak">

                                        </div>
                                    </div>
                                    <div class="border border-amber-200 bg-amber-50/40 rounded-xl p-3">
                                        <span class="flex items-center gap-1.5 text-[11px] font-semibold text-amber-600 mb-1.5"><span class="w-2 h-2 rounded-full bg-amber-500"></span>Dalam Perbaikan</span>
                                        <div class="flex items-center justify-between bg-white border border-amber-200 rounded-lg px-2 py-1">
                                            <input type="number" name="stok_perbaikan_display" min="0"
                                                   value="{{ $dPerbaikan }}"
                                                   class="input-status-unit w-full bg-transparent text-amber-700 font-bold text-sm focus:outline-none" data-status="perbaikan">

                                        </div>
                                    </div>
                                </div>
                                <p class="peringatan-total hidden text-[11px] text-rose-500 font-medium -mt-3 mb-4">Jumlah Tersedia + Dipinjam + Rusak + Dalam Perbaikan harus sama dengan Total Unit.</p>

                                <div class="mb-4">
                                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Status Dominan (otomatis)</label>
                                    <input type="text" class="label-status-dominan w-full px-3 py-2 border border-slate-200 bg-slate-50 text-slate-500 rounded-lg text-xs focus:outline-none" value="{{ $alat->status_alat }}" disabled>
                                    <!-- Ini yang benar-benar dikirim & disimpan ke kolom status_alat -->
                                    <input type="hidden" name="status_alat" class="input-status-dominan" value="{{ $alat->status_alat }}">
                                </div>

                                <div class="grid grid-cols-2 gap-4 mb-5">
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Lokasi</label>
                                        <input type="text" name="lokasi" required value="{{ $alat->lokasi }}" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-xs focus:outline-none focus:border-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Tanggal Pengadaan</label>
                                        <input type="date" name="tanggal_pengadaan" value="{{ $alat->tanggal_pengadaan ?? '' }}" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-xs focus:outline-none focus:border-blue-500">
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-4 mb-5">
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Upload Foto</label>
                                        <label class="flex items-center justify-center w-full h-24 border-2 border-dashed border-slate-200 rounded-lg cursor-pointer hover:border-blue-400 transition bg-slate-50 overflow-hidden">
                                            <input type="file" name="foto" accept="image/*" class="hidden input-foto-alat">
                                            <span class="preview-foto-kosong flex flex-col items-center text-slate-400">
                                                <i class="fa-solid fa-image text-lg mb-1"></i>
                                                <span class="text-[10px]">Pilih gambar</span>
                                            </span>
                                            <img class="preview-foto hidden w-full h-full object-cover" src="" alt="Preview Foto Alat">
                                        </label>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Deskripsi</label>
                                        <textarea name="deskripsi" rows="4" class="w-full h-24 px-3 py-2 border border-slate-200 rounded-lg text-xs focus:outline-none focus:border-blue-500 resize-none">{{ $alat->deskripsi }}</textarea>
                                    </div>
                                </div>

                                <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                                    <button type="button" onclick="toggleModal('modal-edit-{{ $alat->id }}')" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-lg text-xs font-semibold transition">Batal</button>
                                    <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-xs font-semibold transition">Simpan Perubahan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function toggleModal(modalId) {
            const modal = document.getElementById(modalId);
            const modalContent = modal.querySelector('div');

            if (modal.classList.contains('hidden')) {
                // Tampilkan Modal
                modal.classList.remove('hidden');
                setTimeout(() => {
                    modal.classList.remove('opacity-0');
                    modalContent.classList.remove('scale-95');
                }, 20);
            } else {
                // Sembunyikan Modal dengan Animasi Fade Out
                modal.classList.add('opacity-0');
                modalContent.classList.add('scale-95');
                setTimeout(() => {
                    modal.classList.add('hidden');
                }, 300);
            }
        }

        // Close modal when clicking outside content area
        window.onclick = function(event) {
            if (event.target.attributes.id && event.target.attributes.id.value.startsWith('modal-')) {
                toggleModal(event.target.id);
            }
        }

        // =========================================================
        // Logika form Edit Alat: stepper, total unit, status dominan
        // (Catatan: nilai per-status di bawah ini HANYA untuk tampilan
        // di modal, karena kolomnya belum ada di database)
        // =========================================================
        document.querySelectorAll('.form-edit-alat').forEach(function (form) {
            const totalInput     = form.querySelector('.input-total-unit');
            const labelJumlah    = form.querySelector('.label-jumlah-unit');
            const statusInputs   = form.querySelectorAll('.input-status-unit');
            const peringatan     = form.querySelector('.peringatan-total');
            const labelDominan   = form.querySelector('.label-status-dominan');
            const hiddenDominan  = form.querySelector('.input-status-dominan');

            const statusMeta = {
                tersedia:  { label: 'Tersedia' },
                dipinjam:  { label: 'Dipinjam' },
                rusak:     { label: 'Rusak' },
                perbaikan: { label: 'Dalam Perbaikan' },
            };

            function hitungUlang() {
                let total = 0;
                let dominanKey = null;
                let dominanVal = -1;

                statusInputs.forEach(function (input) {
                    const val = parseInt(input.value, 10) || 0;
                    total += val;
                    if (val > dominanVal) {
                        dominanVal = val;
                        dominanKey = input.dataset.status;
                    }
                });

                const totalUnit = parseInt(totalInput.value, 10) || 0;
                labelJumlah.textContent = totalUnit;

                if (total !== totalUnit) {
                    peringatan.classList.remove('hidden');
                } else {
                    peringatan.classList.add('hidden');
                }

                if (dominanKey && dominanVal > 0) {
                    const labelStatus = statusMeta[dominanKey].label;
                    labelDominan.value = labelStatus;
                    hiddenDominan.value = labelStatus;
                } else {
                    labelDominan.value = 'Tersedia';
                    hiddenDominan.value = 'Tersedia';
                }
            }

            statusInputs.forEach(function (input) {
                input.addEventListener('input', hitungUlang);
            });
            totalInput.addEventListener('input', hitungUlang);

            // Tombol stepper +/-
            form.querySelectorAll('.stepper-up, .stepper-down').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    const wrapper = btn.closest('div').parentElement;
                    const input = wrapper.querySelector('.input-status-unit');
                    let val = parseInt(input.value, 10) || 0;
                    val = btn.classList.contains('stepper-up') ? val + 1 : Math.max(val - 1, 0);
                    input.value = val;
                    hitungUlang();
                });
            });

            // Preview foto
            const inputFoto = form.querySelector('.input-foto-alat');
            if (inputFoto) {
                inputFoto.addEventListener('change', function (e) {
                    const file = e.target.files[0];
                    const previewImg = form.querySelector('.preview-foto');
                    const previewKosong = form.querySelector('.preview-foto-kosong');
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function (ev) {
                            previewImg.src = ev.target.result;
                            previewImg.classList.remove('hidden');
                            previewKosong.classList.add('hidden');
                        };
                        reader.readAsDataURL(file);
                    }
                });
            }

            // Hitung pertama kali saat modal dibuka
            hitungUlang();
        });
        // =========================================================
        // Konfirmasi Nonaktifkan Alat (pakai SweetAlert2, bukan confirm() bawaan)
        // =========================================================
        function konfirmasiNonaktifkan(btn) {
            const form = btn.closest('form');
            const namaAlat = form.dataset.namaAlat || 'alat ini';

            Swal.fire({
                title: 'Nonaktifkan Alat?',
                html: `Alat <b>${namaAlat}</b> akan ditandai sebagai <b>Nonaktif</b> dan tidak bisa dipinjam lagi. Data alat tidak akan dihapus.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e11d48',
                cancelButtonColor: '#94a3b8',
                confirmButtonText: 'Ya, Nonaktifkan',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        }

        // =========================================================
        // Konfirmasi Aktifkan Alat (pakai SweetAlert2)
        // =========================================================
        function konfirmasiAktifkan(btn) {
            const form = btn.closest('form');
            const namaAlat = form.dataset.namaAlat || 'alat ini';

            Swal.fire({
                title: 'Aktifkan Alat?',
                html: `Alat <b>${namaAlat}</b> akan diaktifkan kembali dan statusnya berubah menjadi <b>Tersedia</b>.`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#059669',
                cancelButtonColor: '#94a3b8',
                confirmButtonText: 'Ya, Aktifkan',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        }
</script>
@endsection
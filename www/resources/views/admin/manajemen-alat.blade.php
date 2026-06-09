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
                    </select>
                    <i class="fa-solid fa-chevron-down absolute right-4 top-4 text-[10px] text-slate-400 pointer-events-none"></i>
                </div>
                <div class="relative">
                    <select class="appearance-none bg-white border border-slate-200 pl-4 pr-10 py-2.5 rounded-xl text-xs font-medium text-slate-600 focus:outline-none shadow-sm cursor-pointer min-w-[140px]">
                        <option>Semua Status</option>
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
                                        @else
                                            <span class="px-2 py-0.5 rounded bg-amber-50 text-amber-600 text-[10px] font-bold">{{ $alat->status_alat }}</span>
                                        @endif
                                    </td>
                                    <td class="py-4 px-6 text-center space-x-2 flex justify-center items-center">
                                        <button onclick="toggleModal('modal-detail-{{ $alat->id }}')" class="text-slate-400 hover:text-slate-600"><i class="fa-regular fa-eye"></i></button>
                                        <button onclick="toggleModal('modal-edit-{{ $alat->id }}')" class="text-slate-400 hover:text-blue-600"><i class="fa-regular fa-pen-to-square"></i></button>
                                        <form action="{{ route('admin.manajemen_alat.destroy', $alat->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus alat ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-slate-400 hover:text-rose-600"><i class="fa-solid fa-trash"></i></button>
                                        </form>
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
                <div class="bg-white rounded-xl shadow-xl w-full max-w-lg overflow-hidden transform scale-95 transition-transform duration-300">
                    <div class="p-5 border-b border-slate-100 flex justify-between items-center bg-slate-50">
                        <h3 class="font-bold text-slate-800 text-base">Tambah Alat Baru</h3>
                        <button onclick="toggleModal('modal-tambah')" class="text-slate-400 hover:text-rose-500 transition"><i class="fa-solid fa-xmark text-lg"></i></button>
                    </div>
                    <div class="p-6">
                        <form action="{{ route('admin.manajemen_alat.store') }}" method="POST">
                            @csrf
                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Kode Alat</label>
                                    <input type="text" name="kode_alat" required class="w-full px-3 py-2 border border-slate-200 rounded-lg text-xs focus:outline-none focus:border-blue-500">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Kategori</label>
                                    <select name="kategori" required class="w-full px-3 py-2 border border-slate-200 rounded-lg text-xs focus:outline-none focus:border-blue-500">
                                        <option value="Mikroskop">Mikroskop</option>
                                        <option value="Elektronik">Elektronik</option>
                                        <option value="Alat Ukur">Alat Ukur</option>
                                        <option value="Lainnya">Lainnya</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Nama Alat</label>
                                <input type="text" name="nama_alat" required class="w-full px-3 py-2 border border-slate-200 rounded-lg text-xs focus:outline-none focus:border-blue-500">
                            </div>
                            <div class="mb-4">
                                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Deskripsi</label>
                                <textarea name="deskripsi" rows="2" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-xs focus:outline-none focus:border-blue-500"></textarea>
                            </div>
                            <div class="grid grid-cols-3 gap-4 mb-5">
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Stok Total</label>
                                    <input type="number" name="stok_total" required min="0" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-xs focus:outline-none focus:border-blue-500">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Status</label>
                                    <select name="status_alat" required class="w-full px-3 py-2 border border-slate-200 rounded-lg text-xs focus:outline-none focus:border-blue-500">
                                        <option value="Tersedia">Tersedia</option>
                                        <option value="Rusak">Rusak</option>
                                        <option value="Dalam Perbaikan">Dalam Perbaikan</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Lokasi</label>
                                    <input type="text" name="lokasi" required class="w-full px-3 py-2 border border-slate-200 rounded-lg text-xs focus:outline-none focus:border-blue-500">
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

            <!-- Modals Edit -->
            @foreach($alatList ?? [] as $alat)
            <div id="modal-edit-{{ $alat->id }}" class="fixed inset-0 z-50 hidden bg-slate-900/50 backdrop-blur-sm transition-opacity opacity-0 flex items-center justify-center p-4">
                <div class="bg-white rounded-xl shadow-xl w-full max-w-lg overflow-hidden transform scale-95 transition-transform duration-300">
                    <div class="p-5 border-b border-slate-100 flex justify-between items-center bg-slate-50">
                        <h3 class="font-bold text-slate-800 text-base">Edit Alat ({{ $alat->kode_alat }})</h3>
                        <button onclick="toggleModal('modal-edit-{{ $alat->id }}')" class="text-slate-400 hover:text-rose-500 transition"><i class="fa-solid fa-xmark text-lg"></i></button>
                    </div>
                    <div class="p-6">
                        <form action="{{ route('admin.manajemen_alat.update', $alat->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Kategori</label>
                                    <select name="kategori" required class="w-full px-3 py-2 border border-slate-200 rounded-lg text-xs focus:outline-none focus:border-blue-500">
                                        <option value="Mikroskop" {{ $alat->kategori == 'Mikroskop' ? 'selected' : '' }}>Mikroskop</option>
                                        <option value="Elektronik" {{ $alat->kategori == 'Elektronik' ? 'selected' : '' }}>Elektronik</option>
                                        <option value="Alat Ukur" {{ $alat->kategori == 'Alat Ukur' ? 'selected' : '' }}>Alat Ukur</option>
                                        <option value="Lainnya" {{ $alat->kategori == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Lokasi</label>
                                    <input type="text" name="lokasi" required value="{{ $alat->lokasi }}" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-xs focus:outline-none focus:border-blue-500">
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Nama Alat</label>
                                <input type="text" name="nama_alat" required value="{{ $alat->nama_alat }}" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-xs focus:outline-none focus:border-blue-500">
                            </div>
                            <div class="mb-4">
                                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Deskripsi</label>
                                <textarea name="deskripsi" rows="2" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-xs focus:outline-none focus:border-blue-500">{{ $alat->deskripsi }}</textarea>
                            </div>
                            <div class="grid grid-cols-2 gap-4 mb-5">
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Stok Total</label>
                                    <input type="number" name="stok_total" required min="0" value="{{ $alat->stok_total }}" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-xs focus:outline-none focus:border-blue-500">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Status</label>
                                    <select name="status_alat" required class="w-full px-3 py-2 border border-slate-200 rounded-lg text-xs focus:outline-none focus:border-blue-500">
                                        <option value="Tersedia" {{ $alat->status_alat == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                                        <option value="Dipinjam" {{ $alat->status_alat == 'Dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                                        <option value="Rusak" {{ $alat->status_alat == 'Rusak' ? 'selected' : '' }}>Rusak</option>
                                        <option value="Dalam Perbaikan" {{ $alat->status_alat == 'Dalam Perbaikan' ? 'selected' : '' }}>Dalam Perbaikan</option>
                                    </select>
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
</script>
@endsection

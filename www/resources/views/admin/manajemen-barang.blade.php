@extends('layouts.admin')

@section('title', 'Manajemen Barang - IPWIJA SmartLab')

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
                    <h2 class="text-2xl font-bold text-slate-900 tracking-tight">Manajemen Barang</h2>
                    <p class="text-slate-500 text-sm mt-1">Atur inventaris barang laboratorium Universitas IPWIJA.</p>
                </div>
                <button onclick="toggleModal('modal-tambah')" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2.5 rounded-xl text-xs transition shadow-sm flex items-center gap-2">
                    <i class="fa-solid fa-plus"></i> Tambah Barang
                </button>
            </div>

            <div class="flex flex-col sm:flex-row gap-3">
                <div class="relative flex-1">
                    <i class="fa-solid fa-magnifying-glass text-slate-400 absolute left-4 top-3.5 text-xs"></i>
                    <input type="text" placeholder="Cari nama alat, kode, atau lokasi..." class="w-full pl-10 pr-4 py-2.5 bg-white border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-blue-500 transition shadow-sm">
                </div>
                <div class="relative">
                    <select class="appearance-none bg-white border border-slate-200 pl-4 pr-10 py-2.5 rounded-xl text-xs font-medium text-slate-600 focus:outline-none shadow-sm cursor-pointer min-w-[160px]">
                        <option>Semua Kategori</option>
                    </select>
                    <i class="fa-solid fa-chevron-down absolute right-4 top-4 text-[10px] text-slate-400 pointer-events-none"></i>
                </div>
                <div class="relative">
                    <select class="appearance-none bg-white border border-slate-200 pl-4 pr-10 py-2.5 rounded-xl text-xs font-medium text-slate-600 focus:outline-none shadow-sm cursor-pointer min-w-[160px]">
                        <option>Semua Kondisi</option>
                    </select>
                    <i class="fa-solid fa-chevron-down absolute right-4 top-4 text-[10px] text-slate-400 pointer-events-none"></i>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs border-collapse">
                        <thead>
                            <tr class="bg-slate-50/70 border-b border-slate-100 text-slate-400 font-semibold uppercase tracking-wider">
                                <th class="py-4 px-6">Kode Barang</th>
                                <th class="py-4 px-6">Nama Barang</th>
                                <th class="py-4 px-6">Kategori</th>
                                <th class="py-4 px-6">Stok</th>
                                <th class="py-4 px-6">Satuan</th>
                                <th class="py-4 px-6">Lokasi</th>
                                <th class="py-4 px-6">Kondisi</th>
                                <th class="py-4 px-6 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-700">
                            @forelse($items ?? [] as $item)
                            <tr class="hover:bg-slate-50/50 transition">
                                <td class="py-4 px-6 font-semibold text-slate-800">{{ $item->kode_barang }}</td>
                                <td class="py-4 px-6 font-semibold text-slate-800">{{ $item->nama_barang }}</td>
                                <td class="py-4 px-6"><span class="px-2 py-1 rounded bg-slate-100 text-slate-600 font-medium text-[11px]">{{ $item->kategori }}</span></td>
                                <td class="py-4 px-6 font-semibold @if($item->stok == 0) text-rose-600 @else text-slate-800 @endif">{{ $item->stok }}</td>
                                <td class="py-4 px-6 text-slate-500">{{ $item->satuan }}</td>
                                <td class="py-4 px-6 text-slate-500 font-medium"><i class="fa-solid fa-location-dot text-slate-300 mr-1"></i> {{ $item->lokasi }}</td>
                                <td class="py-4 px-6">
                                    @if($item->kondisi == 'Baik' || $item->kondisi == 'Tersedia')
                                        <span class="px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-600 text-[10px] font-bold flex items-center gap-1.5 w-fit"><span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>Baik</span>
                                    @elseif($item->kondisi == 'Rusak Berat' || $item->kondisi == 'Rusak')
                                        <span class="px-2 py-0.5 rounded-full bg-rose-50 text-rose-600 text-[10px] font-bold flex items-center gap-1.5 w-fit"><span class="w-1.5 h-1.5 bg-rose-500 rounded-full"></span>Rusak Berat</span>
                                    @else
                                        <span class="px-2 py-0.5 rounded-full bg-amber-50 text-amber-600 text-[10px] font-bold flex items-center gap-1.5 w-fit"><span class="w-1.5 h-1.5 bg-amber-500 rounded-full"></span>{{ $item->kondisi }}</span>
                                    @endif
                                </td>
                                <td class="py-4 px-6 text-center space-x-2.5 flex items-center justify-center">
                                    <button onclick="toggleModal('modal-detail-{{ $item->id }}')" class="text-slate-400 hover:text-slate-600" title="Lihat Detail"><i class="fa-regular fa-eye text-sm"></i></button>
                                    <button onclick="toggleModal('modal-edit-{{ $item->id }}')" class="text-slate-400 hover:text-blue-600" title="Ubah Data"><i class="fa-regular fa-pen-to-square text-sm"></i></button>
                                    <button onclick="toggleModal('modal-mutasi-{{ $item->id }}')" class="text-slate-400 hover:text-emerald-600" title="Mutasi Stok"><i class="fa-solid fa-arrows-rotate text-sm"></i></button>
                                    <form action="{{ route('admin.manajemen_barang.destroy', $item->id) }}" method="POST" class="inline ml-2" onsubmit="return confirm('Apakah Anda yakin ingin menghapus barang ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-slate-400 hover:text-rose-600"><i class="fa-solid fa-trash text-sm"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center py-8 text-slate-500">Belum ada data barang.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-5 border-t border-slate-100">
                    {{ $items->links() }}
                </div>
            </div>

            <!-- Modal Tambah Barang -->
            <div id="modal-tambah" class="fixed inset-0 z-50 hidden bg-slate-900/50 backdrop-blur-sm transition-opacity opacity-0 flex items-center justify-center p-4">
                <div class="bg-white rounded-xl shadow-xl w-full max-w-lg overflow-hidden transform scale-95 transition-transform duration-300">
                    <div class="p-5 border-b border-slate-100 flex justify-between items-center bg-slate-50">
                        <h3 class="font-bold text-slate-800 text-base">Tambah Barang Baru</h3>
                        <button onclick="toggleModal('modal-tambah')" class="text-slate-400 hover:text-rose-500 transition"><i class="fa-solid fa-xmark text-lg"></i></button>
                    </div>
                    <div class="p-6">
                        <form action="{{ route('admin.manajemen_barang.store') }}" method="POST">
                            @csrf
                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Kode Barang</label>
                                    <input type="text" name="kode_barang" required class="w-full px-3 py-2 border border-slate-200 rounded-lg text-xs focus:outline-none focus:border-blue-500">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Kategori</label>
                                    <select name="kategori" required class="w-full px-3 py-2 border border-slate-200 rounded-lg text-xs focus:outline-none focus:border-blue-500">
                                        <option value="Glassware">Glassware</option>
                                        <option value="Chemicals">Chemicals</option>
                                        <option value="Safety">Safety</option>
                                        <option value="Consumables">Consumables</option>
                                        <option value="Lainnya">Lainnya</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Nama Barang</label>
                                <input type="text" name="nama_barang" required class="w-full px-3 py-2 border border-slate-200 rounded-lg text-xs focus:outline-none focus:border-blue-500">
                            </div>
                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Stok</label>
                                    <input type="number" name="stok" required min="0" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-xs focus:outline-none focus:border-blue-500">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Satuan</label>
                                    <input type="text" name="satuan" required class="w-full px-3 py-2 border border-slate-200 rounded-lg text-xs focus:outline-none focus:border-blue-500" placeholder="Pcs, Pack, Dus...">
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4 mb-5">
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Kondisi</label>
                                    <select name="kondisi" required class="w-full px-3 py-2 border border-slate-200 rounded-lg text-xs focus:outline-none focus:border-blue-500">
                                        <option value="Baik">Baik</option>
                                        <option value="Rusak">Rusak</option>
                                        <option value="Rusak Berat">Rusak Berat</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Lokasi</label>
                                    <input type="text" name="lokasi" required class="w-full px-3 py-2 border border-slate-200 rounded-lg text-xs focus:outline-none focus:border-blue-500">
                                </div>
                            </div>
                            <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                                <button type="button" onclick="toggleModal('modal-tambah')" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-lg text-xs font-semibold transition">Batal</button>
                                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-xs font-semibold transition">Simpan Barang</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Modals Edit Barang -->
            @foreach($items ?? [] as $item)
            <div id="modal-edit-{{ $item->id }}" class="fixed inset-0 z-50 hidden bg-slate-900/50 backdrop-blur-sm transition-opacity opacity-0 flex items-center justify-center p-4">
                <div class="bg-white rounded-xl shadow-xl w-full max-w-lg overflow-hidden transform scale-95 transition-transform duration-300">
                    <div class="p-5 border-b border-slate-100 flex justify-between items-center bg-slate-50">
                        <h3 class="font-bold text-slate-800 text-base">Edit Barang ({{ $item->kode_barang }})</h3>
                        <button onclick="toggleModal('modal-edit-{{ $item->id }}')" class="text-slate-400 hover:text-rose-500 transition"><i class="fa-solid fa-xmark text-lg"></i></button>
                    </div>
                    <div class="p-6">
                        <form action="{{ route('admin.manajemen_barang.update', $item->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Kategori</label>
                                    <select name="kategori" required class="w-full px-3 py-2 border border-slate-200 rounded-lg text-xs focus:outline-none focus:border-blue-500">
                                        <option value="Glassware" {{ $item->kategori == 'Glassware' ? 'selected' : '' }}>Glassware</option>
                                        <option value="Chemicals" {{ $item->kategori == 'Chemicals' ? 'selected' : '' }}>Chemicals</option>
                                        <option value="Safety" {{ $item->kategori == 'Safety' ? 'selected' : '' }}>Safety</option>
                                        <option value="Consumables" {{ $item->kategori == 'Consumables' ? 'selected' : '' }}>Consumables</option>
                                        <option value="Lainnya" {{ $item->kategori == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Nama Barang</label>
                                    <input type="text" name="nama_barang" required value="{{ $item->nama_barang }}" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-xs focus:outline-none focus:border-blue-500">
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Stok</label>
                                    <input type="number" name="stok" required min="0" value="{{ $item->stok }}" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-xs focus:outline-none focus:border-blue-500">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Satuan</label>
                                    <input type="text" name="satuan" required value="{{ $item->satuan }}" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-xs focus:outline-none focus:border-blue-500">
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4 mb-5">
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Kondisi</label>
                                    <select name="kondisi" required class="w-full px-3 py-2 border border-slate-200 rounded-lg text-xs focus:outline-none focus:border-blue-500">
                                        <option value="Baik" {{ $item->kondisi == 'Baik' ? 'selected' : '' }}>Baik</option>
                                        <option value="Rusak" {{ $item->kondisi == 'Rusak' ? 'selected' : '' }}>Rusak</option>
                                        <option value="Rusak Berat" {{ $item->kondisi == 'Rusak Berat' ? 'selected' : '' }}>Rusak Berat</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Lokasi</label>
                                    <input type="text" name="lokasi" required value="{{ $item->lokasi }}" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-xs focus:outline-none focus:border-blue-500">
                                </div>
                            </div>
                            <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                                <button type="button" onclick="toggleModal('modal-edit-{{ $item->id }}')" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-lg text-xs font-semibold transition">Batal</button>
                                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-xs font-semibold transition">Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Modal Mutasi Stok -->
            <div id="modal-mutasi-{{ $item->id }}" class="fixed inset-0 z-50 hidden bg-slate-900/50 backdrop-blur-sm transition-opacity opacity-0 flex items-center justify-center p-4">
                <div class="bg-white rounded-xl shadow-xl w-full max-w-md overflow-hidden transform scale-95 transition-transform duration-300">
                    <div class="p-5 border-b border-slate-100 flex justify-between items-center bg-slate-50">
                        <h3 class="font-bold text-slate-800 text-base">Mutasi Stok ({{ $item->nama_barang }})</h3>
                        <button onclick="toggleModal('modal-mutasi-{{ $item->id }}')" class="text-slate-400 hover:text-rose-500 transition"><i class="fa-solid fa-xmark text-lg"></i></button>
                    </div>
                    <div class="p-6">
                        <form action="{{ route('admin.manajemen_barang.mutasi', $item->id) }}" method="POST">
                            @csrf
                            <div class="mb-5 grid grid-cols-2 gap-3">
                                <label>
                                    <input type="radio" name="tipe_mutasi" value="masuk" class="peer hidden" required>
                                    <div class="border border-slate-200 rounded-xl p-3 flex flex-col items-center justify-center cursor-pointer transition peer-checked:border-emerald-500 peer-checked:bg-emerald-50 peer-checked:text-emerald-600 text-slate-500 hover:bg-slate-50">
                                        <i class="fa-solid fa-arrow-down mb-1 text-lg"></i>
                                        <span class="text-xs font-bold">Barang Masuk</span>
                                    </div>
                                </label>
                                <label>
                                    <input type="radio" name="tipe_mutasi" value="keluar" class="peer hidden" required>
                                    <div class="border border-slate-200 rounded-xl p-3 flex flex-col items-center justify-center cursor-pointer transition peer-checked:border-rose-500 peer-checked:bg-rose-50 peer-checked:text-rose-600 text-slate-500 hover:bg-slate-50">
                                        <i class="fa-solid fa-arrow-up mb-1 text-lg"></i>
                                        <span class="text-xs font-bold">Barang Keluar</span>
                                    </div>
                                </label>
                            </div>
                            
                            <div class="mb-4">
                                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Jumlah</label>
                                <input type="number" name="jumlah" required min="1" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-xs focus:outline-none focus:border-blue-500" placeholder="0">
                                <p class="text-[10px] text-slate-500 mt-1">Stok saat ini: <span class="font-bold text-slate-700">{{ $item->stok }} {{ $item->satuan }}</span></p>
                            </div>

                            <div class="mb-5">
                                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Keterangan (Opsional)</label>
                                <textarea name="keterangan" rows="2" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-xs focus:outline-none focus:border-blue-500" placeholder="Contoh: Barang restock bulan Juni"></textarea>
                            </div>
                            
                            <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                                <button type="button" onclick="toggleModal('modal-mutasi-{{ $item->id }}')" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-lg text-xs font-semibold transition">Batal</button>
                                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-xs font-semibold transition">Simpan Mutasi</button>
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
            if (!modal) return;
            const modalContent = modal.querySelector('div');

            if (modal.classList.contains('hidden')) {
                modal.classList.remove('hidden');
                setTimeout(() => {
                    modal.classList.remove('opacity-0');
                    modalContent.classList.remove('scale-95');
                }, 20);
            } else {
                modal.classList.add('opacity-0');
                modalContent.classList.add('scale-95');
                setTimeout(() => {
                    modal.classList.add('hidden');
                }, 300);
            }
        }

        // Menutup modal ketika pengguna mengeklik area luar (backdrop) kosong
        window.onclick = function(event) {
            if (event.target.attributes.id && event.target.attributes.id.value.startsWith('modal-')) {
                toggleModal(event.target.id);
            }
        }

        // Handler interaktif perpindahan Tipe Mutasi Stok (Masuk / Keluar)
        const mutasiLabels = document.querySelectorAll('#modal-mutasi-stok font, #modal-mutasi-stok label');
        const mutasiRadios = document.querySelectorAll('input[name="tipe_mutasi"]');
        
        mutasiRadios.forEach((radio) => {
            radio.addEventListener('change', function() {
                mutasiRadios.forEach(r => {
                    const label = r.closest('label');
                    const icon = label.querySelector('i');
                    const btnSubmit = document.querySelector('#modal-mutasi-stok button[type="submit"]');
                    
                    if (r.checked) {
                        if(r.value === 'masuk') {
                            label.className = "border-2 border-emerald-500 bg-emerald-50/30 rounded-xl p-3.5 flex items-center justify-center gap-2 cursor-pointer font-bold text-emerald-600 transition";
                            btnSubmit.className = "bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-5 py-2.5 rounded-xl transition shadow-sm flex items-center gap-1.5";
                            btnSubmit.innerHTML = "Tambah Stok";
                        } else {
                            label.className = "border-2 border-rose-500 bg-rose-50/30 rounded-xl p-3.5 flex items-center justify-center gap-2 cursor-pointer font-bold text-rose-600 transition";
                            btnSubmit.className = "bg-rose-600 hover:bg-rose-700 text-white font-bold px-5 py-2.5 rounded-xl transition shadow-sm flex items-center gap-1.5";
                            btnSubmit.innerHTML = "Kurangi Stok";
                        }
                    } else {
                        label.className = "border border-slate-200 hover:border-slate-300 rounded-xl p-3.5 flex items-center justify-center gap-2 cursor-pointer font-semibold text-slate-600 transition";
                    }
                });
            });
        });
</script>
@endsection

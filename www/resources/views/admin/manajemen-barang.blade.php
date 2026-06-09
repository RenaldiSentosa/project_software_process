@extends('layouts.admin')

@section('title', 'Manajemen Barang - IPWIJA SmartLab')
@section('page-header', 'Manajemen Barang')

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
                <button onclick="toggleModal('modal-tambah-barang')" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2.5 rounded-xl text-xs transition shadow-sm flex items-center gap-2">
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
                            <tr class="hover:bg-slate-50/50 transition">
                                <td class="py-4 px-6 font-semibold text-slate-800">BRG-001</td>
                                <td class="py-4 px-6 font-semibold text-slate-800">Meja</td>
                                <td class="py-4 px-6"><span class="px-2 py-1 rounded bg-slate-100 text-slate-600 font-medium text-[11px]">Furnitur</span></td>
                                <td class="py-4 px-6 font-semibold text-slate-800">45</td>
                                <td class="py-4 px-6 text-slate-500">pcs</td>
                                <td class="py-4 px-6 text-slate-500 font-medium"><i class="fa-solid fa-location-dot text-slate-300 mr-1"></i> Gedung Sumitro</td>
                                <td class="py-4 px-6"><span class="px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-600 text-[10px] font-bold flex items-center gap-1.5 w-fit"><span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>Baik</span></td>
                                <td class="py-4 px-6 text-center space-x-2.5">
                                    <button onclick="toggleModal('modal-detail-baik')" class="text-slate-400 hover:text-slate-600" title="Lihat Detail"><i class="fa-regular fa-eye text-sm"></i></button>
                                    <button onclick="toggleModal('modal-edit-barang')" class="text-slate-400 hover:text-blue-600" title="Ubah Data"><i class="fa-regular fa-pen-to-square text-sm"></i></button>
                                    <button onclick="toggleModal('modal-mutasi-stok')" class="text-slate-400 hover:text-emerald-600" title="Mutasi Stok"><i class="fa-solid fa-arrows-rotate text-sm"></i></button>
                                </td>
                            </tr>
                            <tr class="hover:bg-slate-50/50 transition">
                                <td class="py-4 px-6 font-semibold text-slate-800">BRG-003</td>
                                <td class="py-4 px-6 font-semibold text-slate-800">Komputer Lab</td>
                                <td class="py-4 px-6"><span class="px-2 py-1 rounded bg-slate-100 text-slate-600 font-medium text-[11px]">elektronik</span></td>
                                <td class="py-4 px-6 font-bold text-rose-600">0</td>
                                <td class="py-4 px-6 text-slate-500">unit</td>
                                <td class="py-4 px-6 text-slate-500 font-medium"><i class="fa-solid fa-location-dot text-slate-300 mr-1"></i> Gedung Sumitro</td>
                                <td class="py-4 px-6"><span class="px-2 py-0.5 rounded-full bg-rose-50 text-rose-600 text-[10px] font-bold flex items-center gap-1.5 w-fit"><span class="w-1.5 h-1.5 bg-rose-500 rounded-full"></span>Rusak Berat</span></td>
                                <td class="py-4 px-6 text-center space-x-2.5">
                                    <button onclick="toggleModal('modal-detail-kritis')" class="text-slate-400 hover:text-slate-600" title="Lihat Detail"><i class="fa-regular fa-eye text-sm"></i></button>
                                    <button onclick="toggleModal('modal-edit-barang')" class="text-slate-400 hover:text-blue-600" title="Ubah Data"><i class="fa-regular fa-pen-to-square text-sm"></i></button>
                                    <button onclick="toggleModal('modal-mutasi-stok')" class="text-slate-400 hover:text-emerald-600" title="Mutasi Stok"><i class="fa-solid fa-arrows-rotate text-sm"></i></button>
                                </td>
                            </tr>
                            <tr class="hover:bg-slate-50/50 transition">
                                <td class="py-4 px-6 font-semibold text-slate-800">BRG-005</td>
                                <td class="py-4 px-6 font-semibold text-slate-800">Kabel LAN CAT6</td>
                                <td class="py-4 px-6"><span class="px-2 py-1 rounded bg-slate-100 text-slate-600 font-medium text-[11px]">Jaringan</span></td>
                                <td class="py-4 px-6 font-semibold text-slate-800">45</td>
                                <td class="py-4 px-6 text-slate-500">roll</td>
                                <td class="py-4 px-6 text-slate-500 font-medium"><i class="fa-solid fa-location-dot text-slate-300 mr-1"></i> Gedung Sumitro</td>
                                <td class="py-4 px-6"><span class="px-2 py-0.5 rounded-full bg-amber-50 text-amber-600 text-[10px] font-bold flex items-center gap-1.5 w-fit"><span class="w-1.5 h-1.5 bg-amber-500 rounded-full"></span>Rusak Ringan</span></td>
                                <td class="py-4 px-6 text-center space-x-2.5">
                                    <button onclick="toggleModal('modal-detail-baik')" class="text-slate-400 hover:text-slate-600" title="Lihat Detail"><i class="fa-regular fa-eye text-sm"></i></button>
                                    <button onclick="toggleModal('modal-edit-barang')" class="text-slate-400 hover:text-blue-600" title="Ubah Data"><i class="fa-regular fa-pen-to-square text-sm"></i></button>
                                    <button onclick="toggleModal('modal-mutasi-stok')" class="text-slate-400 hover:text-emerald-600" title="Mutasi Stok"><i class="fa-solid fa-arrows-rotate text-sm"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="p-5 border-t border-slate-100 flex justify-between items-center text-xs text-slate-500">
                    <span>Menampilkan 1-8 dari 120 alat</span>
                    <div class="flex gap-1">
                        <button class="w-7 h-7 flex items-center justify-center rounded border border-slate-200 hover:bg-slate-50"><i class="fa-solid fa-chevron-left text-[10px]"></i></button>
                        <button class="w-7 h-7 flex items-center justify-center rounded bg-blue-600 text-white font-medium">1</button>
                        <button class="w-7 h-7 flex items-center justify-center rounded border border-slate-200 hover:bg-slate-50">2</button>
                        <button class="w-7 h-7 flex items-center justify-center rounded border border-slate-200 hover:bg-slate-50">3</button>
                        <button class="w-7 h-7 flex items-center justify-center rounded border border-slate-200 hover:bg-slate-50"><i class="fa-solid fa-chevron-right text-[10px]"></i></button>
                    </div>
                </div>
            </div>
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

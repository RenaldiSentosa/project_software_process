@extends('layouts.admin')

@section('title', 'Manajemen Alat - IPWIJA SmartLab')
@section('page-header', 'Manajemen Alat')

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
                                @empty
                                <tr class="hover:bg-slate-50/50 transition">
                                    <td class="py-4 px-6 font-medium text-slate-500">ALT-001</td>
                                    <td class="py-4 px-6"><span class="font-semibold text-slate-800 block">Router</span><span class="text-slate-400 text-[11px]">Baik</span></td>
                                    <td class="py-4 px-6"><span class="px-2 py-0.5 bg-blue-50 text-blue-600 rounded text-[11px] font-medium">Network</span></td>
                                    <td class="py-4 px-6 font-medium">5</td>
                                    <td class="py-4 px-6 font-medium">2</td>
                                    <td class="py-4 px-6 text-slate-500 font-medium"><i class="fa-solid fa-location-dot mr-1.5 text-slate-400"></i>workshop</td>
                                    <td class="py-4 px-6"><span class="px-2 py-0.5 rounded bg-purple-50 text-purple-600 text-[10px] font-bold">Dipinjam</span></td>
                                    <td class="py-4 px-6 text-center space-x-2">
                                        <button onclick="toggleModal('modal-detail')" class="text-slate-400 hover:text-slate-600"><i class="fa-regular fa-eye"></i></button>
                                        <button onclick="toggleModal('modal-edit')" class="text-slate-400 hover:text-blue-600"><i class="fa-regular fa-pen-to-square"></i></button>
                                        <button class="text-slate-400 hover:text-rose-600"><i class="fa-regular fa-clock"></i></button>
                                    </td>
                                </tr>
                                <tr class="hover:bg-slate-50/50 transition">
                                    <td class="py-4 px-6 font-medium text-slate-500">ALT-002</td>
                                    <td class="py-4 px-6"><span class="font-semibold text-slate-800 block">Keyboard</span><span class="text-slate-400 text-[11px]">Rusak</span></td>
                                    <td class="py-4 px-6"><span class="px-2 py-0.5 bg-slate-100 text-slate-600 rounded text-[11px] font-medium">Hardware</span></td>
                                    <td class="py-4 px-6 font-medium">5</td>
                                    <td class="py-4 px-6 font-medium text-rose-600">0</td>
                                    <td class="py-4 px-6 text-slate-500 font-medium"><i class="fa-solid fa-location-dot mr-1.5 text-slate-400"></i>workshop</td>
                                    <td class="py-4 px-6"><span class="px-2 py-0.5 rounded bg-rose-50 text-rose-600 text-[10px] font-bold">Rusak</span></td>
                                    <td class="py-4 px-6 text-center space-x-2">
                                        <button onclick="toggleModal('modal-detail')" class="text-slate-400 hover:text-slate-600"><i class="fa-regular fa-eye"></i></button>
                                        <button onclick="toggleModal('modal-edit')" class="text-slate-400 hover:text-blue-600"><i class="fa-regular fa-pen-to-square"></i></button>
                                        <button class="text-slate-400 hover:text-rose-600"><i class="fa-regular fa-clock"></i></button>
                                    </td>
                                </tr>
                                <tr class="hover:bg-slate-50/50 transition">
                                    <td class="py-4 px-6 font-medium text-slate-500">ALT-003</td>
                                    <td class="py-4 px-6"><span class="font-semibold text-slate-800 block">Arduino Uno</span><span class="text-slate-400 text-[11px]">Baik</span></td>
                                    <td class="py-4 px-6"><span class="px-2 py-0.5 bg-indigo-50 text-indigo-600 rounded text-[11px] font-medium">IoT</span></td>
                                    <td class="py-4 px-6 font-medium">5</td>
                                    <td class="py-4 px-6 font-medium">2</td>
                                    <td class="py-4 px-6 text-slate-500 font-medium"><i class="fa-solid fa-location-dot mr-1.5 text-slate-400"></i>workshop</td>
                                    <td class="py-4 px-6"><span class="px-2 py-0.5 rounded bg-emerald-50 text-emerald-600 text-[10px] font-bold">Tersedia</span></td>
                                    <td class="py-4 px-6 text-center space-x-2">
                                        <button onclick="toggleModal('modal-detail')" class="text-slate-400 hover:text-slate-600"><i class="fa-regular fa-eye"></i></button>
                                        <button onclick="toggleModal('modal-edit')" class="text-slate-400 hover:text-blue-600"><i class="fa-regular fa-pen-to-square"></i></button>
                                        <button class="text-slate-400 hover:text-rose-600"><i class="fa-regular fa-clock"></i></button>
                                    </td>
                                </tr>
                                <tr class="hover:bg-slate-50/50 transition">
                                    <td class="py-4 px-6 font-medium text-slate-500">ALT-004</td>
                                    <td class="py-4 px-6"><span class="font-semibold text-slate-800 block">Router</span><span class="text-slate-400 text-[11px]">Perbaikan</span></td>
                                    <td class="py-4 px-6"><span class="px-2 py-0.5 bg-blue-50 text-blue-600 rounded text-[11px] font-medium">Network</span></td>
                                    <td class="py-4 px-6 font-medium">5</td>
                                    <td class="py-4 px-6 font-medium">2</td>
                                    <td class="py-4 px-6 text-slate-500 font-medium"><i class="fa-solid fa-location-dot mr-1.5 text-slate-400"></i>workshop</td>
                                    <td class="py-4 px-6"><span class="px-2 py-0.5 rounded bg-amber-50 text-amber-600 text-[10px] font-bold">Dalam Perbaikan</span></td>
                                    <td class="py-4 px-6 text-center space-x-2">
                                        <button onclick="toggleModal('modal-detail')" class="text-slate-400 hover:text-slate-600"><i class="fa-regular fa-eye"></i></button>
                                        <button onclick="toggleModal('modal-edit')" class="text-slate-400 hover:text-blue-600"><i class="fa-regular fa-pen-to-square"></i></button>
                                        <button class="text-slate-400 hover:text-rose-600"><i class="fa-regular fa-clock"></i></button>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-5 border-t border-slate-100 flex justify-between items-center text-xs text-slate-500">
                    <span>Menampilkan 1-4 dari 120 alat</span>
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

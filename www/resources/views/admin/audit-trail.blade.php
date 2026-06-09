@extends('layouts.admin')

@section('title', 'Audit Trail - IPWIJA SmartLab')
@section('page-header', 'Audit Trail')

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
            
            <div>
                <h2 class="text-2xl font-bold text-slate-900 tracking-tight">Audit Trail</h2>
                <p class="text-slate-500 text-sm mt-1">Pantau rekaman jejak aktivitas sistem dan perubahan data secara berkala.</p>
            </div>

            <div class="flex flex-col sm:flex-row gap-3">
                <div class="relative flex-1">
                    <i class="fa-solid fa-magnifying-glass text-slate-400 absolute left-4 top-3.5 text-xs"></i>
                    <input type="text" placeholder="Cari aktivitas, nama user, atau modul..." class="w-full pl-10 pr-4 py-2.5 bg-white border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-blue-500 transition shadow-sm">
                </div>
                <div class="relative">
                    <select class="appearance-none bg-white border border-slate-200 pl-4 pr-10 py-2.5 rounded-xl text-xs font-medium text-slate-600 focus:outline-none shadow-sm cursor-pointer min-w-[160px]">
                        <option>Semua Aksi</option>
                    </select>
                    <i class="fa-solid fa-chevron-down absolute right-4 top-4 text-[10px] text-slate-400 pointer-events-none"></i>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs border-collapse">
                        <thead>
                            <tr class="bg-slate-50/70 border-b border-slate-100 text-slate-400 font-semibold uppercase tracking-wider">
                                <th class="py-4 px-6">Waktu</th>
                                <th class="py-4 px-6">User</th>
                                <th class="py-4 px-6">Peran</th>
                                <th class="py-4 px-6">Modul</th>
                                <th class="py-4 px-6">Aksi</th>
                                <th class="py-4 px-6">Aktivitas</th>
                                <th class="py-4 px-6 text-center">Detail</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-700 font-medium">
                            <tr class="hover:bg-slate-50/50 transition">
                                <td class="py-4 px-6 text-slate-500">28 Mei 2026, 14:30</td>
                                <td class="py-4 px-6 text-slate-900 font-bold">Sandy Aryadi</td>
                                <td class="py-4 px-6 text-slate-500">Admin</td>
                                <td class="py-4 px-6 text-slate-800">Manajemen Barang</td>
                                <td class="py-4 px-6"><span class="px-2.5 py-0.5 rounded-full bg-emerald-50 text-emerald-600 text-[10px] font-bold">CREATE</span></td>
                                <td class="py-4 px-6 text-slate-600">Menambahkan barang baru Meja (BRG-001)</td>
                                <td class="py-4 px-6 text-center">
                                    <button onclick="toggleModal('modal-audit-create')" class="text-slate-400 hover:text-slate-600"><i class="fa-regular fa-eye text-sm"></i></button>
                                </td>
                            </tr>
                            <tr class="hover:bg-slate-50/50 transition">
                                <td class="py-4 px-6 text-slate-500">28 Mei 2026, 13:15</td>
                                <td class="py-4 px-6 text-slate-900 font-bold">Sandy Aryadi</td>
                                <td class="py-4 px-6 text-slate-500">Admin</td>
                                <td class="py-4 px-6 text-slate-800">Manajemen Alat</td>
                                <td class="py-4 px-6"><span class="px-2.5 py-0.5 rounded-full bg-amber-50 text-amber-600 text-[10px] font-bold">UPDATE</span></td>
                                <td class="py-4 px-6 text-slate-600">Mengubah data alat proyektor (ALT-002)</td>
                                <td class="py-4 px-6 text-center">
                                    <button onclick="toggleModal('modal-audit-update')" class="text-slate-400 hover:text-slate-600"><i class="fa-regular fa-eye text-sm"></i></button>
                                </td>
                            </tr>
                            <tr class="hover:bg-slate-50/50 transition">
                                <td class="py-4 px-6 text-slate-500">28 Mei 2026, 11:00</td>
                                <td class="py-4 px-6 text-slate-900 font-bold">Sandy Aryadi</td>
                                <td class="py-4 px-6 text-slate-500">Admin</td>
                                <td class="py-4 px-6 text-slate-800">Manajemen Barang</td>
                                <td class="py-4 px-6"><span class="px-2.5 py-0.5 rounded-full bg-rose-50 text-rose-600 text-[10px] font-bold">DELETE</span></td>
                                <td class="py-4 px-6 text-slate-600">Menghapus data barang BRG-009</td>
                                <td class="py-4 px-6 text-center">
                                    <button onclick="toggleModal('modal-audit-delete')" class="text-slate-400 hover:text-slate-600"><i class="fa-regular fa-eye text-sm"></i></button>
                                </td>
                            </tr>
                            <tr class="hover:bg-slate-50/50 transition">
                                <td class="py-4 px-6 text-slate-500">28 Mei 2026, 09:45</td>
                                <td class="py-4 px-6 text-slate-900 font-bold">Sandy Aryadi</td>
                                <td class="py-4 px-6 text-slate-500">Admin</td>
                                <td class="py-4 px-6 text-slate-800">Peminjaman</td>
                                <td class="py-4 px-6"><span class="px-2.5 py-0.5 rounded-full bg-blue-50 text-blue-600 text-[10px] font-bold">APPROVE</span></td>
                                <td class="py-4 px-6 text-slate-600">Menyetujui pengajuan peminjaman PMJ-004</td>
                                <td class="py-4 px-6 text-center">
                                    <button onclick="toggleModal('modal-audit-approve')" class="text-slate-400 hover:text-slate-600"><i class="fa-regular fa-eye text-sm"></i></button>
                                </td>
                            </tr>
                            <tr class="hover:bg-slate-50/50 transition">
                                <td class="py-4 px-6 text-slate-500">28 Mei 2026, 09:30</td>
                                <td class="py-4 px-6 text-slate-900 font-bold">Sandy Aryadi</td>
                                <td class="py-4 px-6 text-slate-500">Admin</td>
                                <td class="py-4 px-6 text-slate-800">Peminjaman</td>
                                <td class="py-4 px-6"><span class="px-2.5 py-0.5 rounded-full bg-red-50 text-red-600 text-[10px] font-bold">REJECT</span></td>
                                <td class="py-4 px-6 text-slate-600">Menolak pengajuan peminjaman PMJ-002</td>
                                <td class="py-4 px-6 text-center">
                                    <button onclick="toggleModal('modal-audit-rejected')" class="text-slate-400 hover:text-slate-600"><i class="fa-regular fa-eye text-sm"></i></button>
                                </td>
                            </tr>
                            <tr class="hover:bg-slate-50/50 transition">
                                <td class="py-4 px-6 text-slate-500">28 Mei 2026, 08:50</td>
                                <td class="py-4 px-6 text-slate-900 font-bold">Sandy Aryadi</td>
                                <td class="py-4 px-6 text-slate-500">Admin</td>
                                <td class="py-4 px-6 text-slate-800">Laporan</td>
                                <td class="py-4 px-6"><span class="px-2.5 py-0.5 rounded-full bg-purple-50 text-purple-600 text-[10px] font-bold">EXPORT</span></td>
                                <td class="py-4 px-6 text-slate-600">Mengekspor data laporan log mutasi stok ke Excel</td>
                                <td class="py-4 px-6 text-center">
                                    <button onclick="toggleModal('modal-audit-export')" class="text-slate-400 hover:text-slate-600"><i class="fa-regular fa-eye text-sm"></i></button>
                                </td>
                            </tr>
                            <tr class="hover:bg-slate-50/50 transition">
                                <td class="py-4 px-6 text-slate-500">28 Mei 2026, 08:00</td>
                                <td class="py-4 px-6 text-slate-900 font-bold">Sandy Aryadi</td>
                                <td class="py-4 px-6 text-slate-500">Admin</td>
                                <td class="py-4 px-6 text-slate-800">Autentikasi</td>
                                <td class="py-4 px-6"><span class="px-2.5 py-0.5 rounded-full bg-teal-50 text-teal-600 text-[10px] font-bold">LOGIN</span></td>
                                <td class="py-4 px-6 text-slate-600">User berhasil masuk ke dalam sistem</td>
                                <td class="py-4 px-6 text-center">
                                    <button onclick="toggleModal('modal-audit-login')" class="text-slate-400 hover:text-slate-600"><i class="fa-regular fa-eye text-sm"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="p-5 border-t border-slate-100 flex justify-between items-center text-xs text-slate-500">
                    <span>Menampilkan 1-7 dari 340 log</span>
                    <div class="flex gap-1">
                        <button class="w-7 h-7 flex items-center justify-center rounded border border-slate-200 hover:bg-slate-50"><i class="fa-solid fa-chevron-left text-[10px]"></i></button>
                        <button class="w-7 h-7 flex items-center justify-center rounded bg-blue-600 text-white font-medium">1</button>
                        <button class="w-7 h-7 flex items-center justify-center rounded border border-slate-200 hover:bg-slate-50">2</button>
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

        // Menutup modal ketika mengeklik backdrop kosong di luar modal box
        window.onclick = function(event) {
            if (event.target.attributes.id && event.target.attributes.id.value.startsWith('modal-')) {
                toggleModal(event.target.id);
            }
        }
</script>
@endsection

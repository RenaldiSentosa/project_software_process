@extends('layouts.admin')

@section('title', 'Manajemen User - IPWIJA SmartLab')
@section('page-header', 'Manajemen User')

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
            
            <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-slate-900 tracking-tight">Manajemen User</h2>
                    <p class="text-slate-500 text-sm mt-1">Kelola data pengguna, hak akses peran sistem, serta status keaktifan akun.</p>
                </div>
                <button class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2.5 rounded-xl text-xs transition shadow-sm flex items-center gap-2 self-start sm:self-auto">
                    <i class="fa-solid fa-plus text-[10px]"></i> Tambah User Baru
                </button>
            </div>

            <div class="flex flex-col sm:flex-row gap-3">
                <div class="relative flex-1">
                    <i class="fa-solid fa-magnifying-glass text-slate-400 absolute left-4 top-3.5 text-xs"></i>
                    <input type="text" placeholder="Cari nama, NIM/NIDN, email, atau program studi..." class="w-full pl-10 pr-4 py-2.5 bg-white border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-blue-500 transition shadow-sm">
                </div>
                <div class="relative">
                    <select class="appearance-none bg-white border border-slate-200 pl-4 pr-10 py-2.5 rounded-xl text-xs font-medium text-slate-600 focus:outline-none shadow-sm cursor-pointer min-w-[140px]">
                        <option>Semua Peran</option>
                        <option>Admin</option>
                        <option>Mahasiswa</option>
                    </select>
                    <i class="fa-solid fa-chevron-down absolute right-4 top-4 text-[10px] text-slate-400 pointer-events-none"></i>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs border-collapse">
                        <thead>
                            <tr class="bg-slate-50/70 border-b border-slate-100 text-slate-400 font-semibold uppercase tracking-wider">
                                <th class="py-4 px-6">No Identitas (NIM/NIDN)</th>
                                <th class="py-4 px-6">Nama</th>
                                <th class="py-4 px-6">Email</th>
                                <th class="py-4 px-6">Program Studi</th>
                                <th class="py-4 px-6">Peran</th>
                                <th class="py-4 px-6 text-center">Status</th>
                                <th class="py-4 px-6 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-700 font-medium">
                            <tr class="hover:bg-slate-50/50 transition">
                                <td class="py-4 px-6 text-slate-600 font-mono">202301110011</td>
                                <td class="py-4 px-6 text-slate-900 font-bold">Muhamad Aprijal</td>
                                <td class="py-4 px-6 text-slate-500">aprijal@student.ipwija.ac.id</td>
                                <td class="py-4 px-6 text-slate-800">Teknik Informatika</td>
                                <td class="py-4 px-6">
                                    <span class="px-2.5 py-0.5 rounded-full bg-purple-50 text-purple-600 text-[10px] font-bold">MAHASISWA</span>
                                </td>
                                <td class="py-4 px-6 text-center">
                                    <span class="mx-auto px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-600 text-[10px] font-bold flex items-center gap-1 w-fit"><span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>Aktif</span>
                                </td>
                                <td class="py-4 px-6 text-center flex items-center justify-center gap-2.5">
                                    <button onclick="toggleModal('modal-user-aktif')" class="text-slate-400 hover:text-slate-600" title="Detail"><i class="fa-regular fa-eye text-sm"></i></button>
                                    <button class="text-slate-400 hover:text-amber-600" title="Ubah"><i class="fa-regular fa-pen-to-square text-sm"></i></button>
                                </td>
                            </tr>
                            <tr class="hover:bg-slate-50/50 transition">
                                <td class="py-4 px-6 text-slate-600 font-mono">202301110099</td>
                                <td class="py-4 px-6 text-slate-900 font-bold">Rachmad Taufik</td>
                                <td class="py-4 px-6 text-slate-500">rachmad@student.ipwija.ac.id</td>
                                <td class="py-4 px-6 text-slate-800">Sistem Informasi</td>
                                <td class="py-4 px-6">
                                    <span class="px-2.5 py-0.5 rounded-full bg-purple-50 text-purple-600 text-[10px] font-bold">MAHASISWA</span>
                                </td>
                                <td class="py-4 px-6 text-center">
                                    <span class="mx-auto px-2 py-0.5 rounded-full bg-slate-100 text-slate-500 text-[10px] font-bold flex items-center gap-1 w-fit"><span class="w-1.5 h-1.5 bg-slate-400 rounded-full"></span>Nonaktif</span>
                                </td>
                                <td class="py-4 px-6 text-center flex items-center justify-center gap-2.5">
                                    <button onclick="toggleModal('modal-user-nonaktif')" class="text-slate-400 hover:text-slate-600" title="Detail"><i class="fa-regular fa-eye text-sm"></i></button>
                                    <button class="text-slate-400 hover:text-amber-600" title="Ubah"><i class="fa-regular fa-pen-to-square text-sm"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="p-5 border-t border-slate-100 flex justify-between items-center text-xs text-slate-500">
                    <span>Menampilkan 1-2 dari 48 user</span>
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

        // Menutup modal secara otomatis saat pengguna mengklik luar area box kontainer modal
        window.onclick = function(event) {
            if (event.target.attributes.id && event.target.attributes.id.value.startsWith('modal-')) {
                toggleModal(event.target.id);
            }
        }
</script>
@endsection

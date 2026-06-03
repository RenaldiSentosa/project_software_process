<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $pageTitle ?? 'IPWIJA SmartLab - Audit Trail' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
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
</head>
<body class="text-slate-700 min-h-screen flex">

    <div class="w-64 bg-white border-r border-slate-200 flex flex-col justify-between fixed h-full z-10">
        <div>
            <div class="p-6 flex items-center gap-3 border-b border-slate-100">
                <div class="w-10 h-10 bg-blue-900 rounded-full flex items-center justify-center text-white font-bold text-xs shadow-inner">
                    <i class="fa-solid fa-graduation-cap"></i>
                </div>
                <div>
                    <h1 class="font-bold text-blue-900 leading-tight tracking-wide">IPWIJA</h1>
                    <p class="text-xs text-slate-500 font-medium">SmartLab</p>
                </div>
            </div>

            <nav class="p-4 space-y-1">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-lg text-slate-500 hover:bg-slate-50 hover:text-slate-800 transition">
                    <i class="fa-solid fa-table-columns text-base w-5 text-center"></i>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('admin.manajemen_alat') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-lg text-slate-500 hover:bg-slate-50 hover:text-slate-800 transition">
                    <i class="fa-solid fa-gear text-base w-5 text-center"></i>
                    <span>Manajemen Alat</span>
                </a>
                <a href="{{ route('admin.peminjaman') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-lg text-slate-500 hover:bg-slate-50 hover:text-slate-800 transition">
                    <i class="fa-solid fa-calendar-check text-base w-5 text-center"></i>
                    <span>Peminjaman</span>
                </a>
                <a href="{{ route('admin.manajemen_barang') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-lg text-slate-500 hover:bg-slate-50 hover:text-slate-800 transition">
                    <i class="fa-solid fa-box-open text-base w-5 text-center"></i>
                    <span>Manajemen Barang</span>
                </a>
                <a href="{{ route('admin.laporan') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-lg text-slate-500 hover:bg-slate-50 hover:text-slate-800 transition">
                    <i class="fa-solid fa-chart-simple text-base w-5 text-center"></i>
                    <span>Laporan</span>
                </a>
                <a href="{{ route('admin.audit_trail') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-semibold rounded-lg bg-blue-50 text-blue-600 transition">
                    <i class="fa-solid fa-shield-halved text-base w-5 text-center"></i>
                    <span>Audit Trail</span>
                </a>
                <a href="{{ route('admin.manajemen_user') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-lg text-slate-500 hover:bg-slate-50 hover:text-slate-800 transition">
                    <i class="fa-solid fa-users text-base w-5 text-center"></i>
                    <span>Manajemen User</span>
                </a>
            </nav>
        </div>
    </div>

    <div class="flex-1 pl-64 flex flex-col min-h-screen">
        
        <header class="h-20 bg-white border-b border-slate-200 flex items-center justify-end px-8 sticky top-0 z-10">
            <div class="flex items-center gap-3 cursor-pointer hover:opacity-80 transition">
                <div class="w-10 h-10 bg-slate-100 rounded-full border border-slate-200 flex items-center justify-center font-semibold text-slate-600 shadow-sm">
                    S
                </div>
                <div class="text-right">
                    <h4 class="text-sm font-semibold text-slate-800 leading-none">Sandy Aryadi</h4>
                    <p class="text-xs text-slate-500 font-medium mt-1">Admin Lab</p>
                </div>
                <i class="fa-solid fa-chevron-down text-xs text-slate-400 ml-1"></i>
            </div>
        </header>

        <main class="p-8 space-y-6 flex-1 max-w-7xl w-full mx-auto">
            
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
        </main>
    </div>

    <div id="modal-audit-create" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-center justify-center hidden opacity-0 transition-opacity duration-300">
        <div class="bg-white rounded-2xl w-full max-w-lg shadow-xl overflow-hidden transform scale-95 transition-transform duration-300 p-6 space-y-4">
            <div class="border-b border-slate-100 pb-3 flex justify-between items-center">
                <h3 class="text-base font-bold text-slate-900">Detail Audit Trail</h3>
                <span class="px-2.5 py-0.5 rounded-full bg-emerald-50 text-emerald-600 text-[10px] font-bold">CREATE</span>
            </div>
            <div class="grid grid-cols-3 gap-y-3.5 text-xs">
                <div class="text-slate-400">Waktu Aktivitas</div>
                <div class="col-span-2 text-slate-800 font-semibold">28 Mei 2026, 14:30:12</div>
                <div class="text-slate-400">Nama Pengguna</div>
                <div class="col-span-2 text-slate-800 font-semibold">Sandy Aryadi</div>
                <div class="text-slate-400">Peran Kontrol</div>
                <div class="col-span-2 text-slate-800 font-semibold">Admin Lab</div>
                <div class="text-slate-400">Modul Sistem</div>
                <div class="col-span-2 text-slate-800 font-semibold">Manajemen Barang</div>
                <div class="text-slate-400">Alamat IP</div>
                <div class="col-span-2 text-slate-700 font-mono">192.168.1.12</div>
                <div class="text-slate-400">Aktivitas Log</div>
                <div class="col-span-2 text-slate-800 font-medium bg-slate-50 border border-slate-100 rounded-xl p-3 leading-relaxed">Menambahkan barang baru Meja (BRG-001)</div>
            </div>
            <div class="flex justify-end pt-2 border-t border-slate-50">
                <button onclick="toggleModal('modal-audit-create')" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold px-5 py-2 rounded-xl text-xs transition">Tutup</button>
            </div>
        </div>
    </div>

    <div id="modal-audit-update" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-center justify-center hidden opacity-0 transition-opacity duration-300">
        <div class="bg-white rounded-2xl w-full max-w-lg shadow-xl overflow-hidden transform scale-95 transition-transform duration-300 p-6 space-y-4">
            <div class="border-b border-slate-100 pb-3 flex justify-between items-center">
                <h3 class="text-base font-bold text-slate-900">Detail Audit Trail</h3>
                <span class="px-2.5 py-0.5 rounded-full bg-amber-50 text-amber-600 text-[10px] font-bold">UPDATE</span>
            </div>
            <div class="grid grid-cols-3 gap-y-3.5 text-xs">
                <div class="text-slate-400">Waktu Aktivitas</div>
                <div class="col-span-2 text-slate-800 font-semibold">28 Mei 2026, 13:15:04</div>
                <div class="text-slate-400">Nama Pengguna</div>
                <div class="col-span-2 text-slate-800 font-semibold">Sandy Aryadi</div>
                <div class="text-slate-400">Peran Kontrol</div>
                <div class="col-span-2 text-slate-800 font-semibold">Admin Lab</div>
                <div class="text-slate-400">Modul Sistem</div>
                <div class="col-span-2 text-slate-800 font-semibold">Manajemen Alat</div>
                <div class="text-slate-400">Alamat IP</div>
                <div class="col-span-2 text-slate-700 font-mono">192.168.1.12</div>
                <div class="text-slate-400">Aktivitas Log</div>
                <div class="col-span-2 text-slate-800 font-medium bg-slate-50 border border-slate-100 rounded-xl p-3 leading-relaxed">Mengubah data alat proyektor (ALT-002)</div>
            </div>
            <div class="space-y-2">
                <h4 class="text-xs font-bold text-slate-800 tracking-wide"><i class="fa-solid fa-code-compare text-slate-400 mr-1"></i> Riwayat Perubahan Data</h4>
                <div class="border border-slate-100 rounded-xl overflow-hidden text-[11px]">
                    <div class="grid grid-cols-2 bg-slate-50 border-b border-slate-100 p-2 font-semibold text-slate-400 uppercase text-center">
                        <div>Data Lama</div>
                        <div>Data Baru</div>
                    </div>
                    <div class="grid grid-cols-2 p-3 font-medium text-slate-700 gap-4">
                        <div class="bg-rose-50/50 text-rose-700 p-2.5 rounded-lg border border-rose-100/50">
                            <span class="block text-[10px] uppercase font-bold text-rose-400 mb-1">Kondisi</span>
                            Baik
                        </div>
                        <div class="bg-emerald-50/50 text-emerald-700 p-2.5 rounded-lg border border-emerald-100/50">
                            <span class="block text-[10px] uppercase font-bold text-emerald-400 mb-1">Kondisi</span>
                            Rusak Ringan
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex justify-end pt-2 border-t border-slate-50">
                <button onclick="toggleModal('modal-audit-update')" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold px-5 py-2 rounded-xl text-xs transition">Tutup</button>
            </div>
        </div>
    </div>

    <div id="modal-audit-delete" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-center justify-center hidden opacity-0 transition-opacity duration-300">
        <div class="bg-white rounded-2xl w-full max-w-lg shadow-xl overflow-hidden transform scale-95 transition-transform duration-300 p-6 space-y-4">
            <div class="border-b border-slate-100 pb-3 flex justify-between items-center">
                <h3 class="text-base font-bold text-slate-900">Detail Audit Trail</h3>
                <span class="px-2.5 py-0.5 rounded-full bg-rose-50 text-rose-600 text-[10px] font-bold">DELETE</span>
            </div>
            <div class="grid grid-cols-3 gap-y-3.5 text-xs">
                <div class="text-slate-400">Waktu Aktivitas</div>
                <div class="col-span-2 text-slate-800 font-semibold">28 Mei 2026, 11:00:55</div>
                <div class="text-slate-400">Nama Pengguna</div>
                <div class="col-span-2 text-slate-800 font-semibold">Sandy Aryadi</div>
                <div class="text-slate-400">Peran Kontrol</div>
                <div class="col-span-2 text-slate-800 font-semibold">Admin Lab</div>
                <div class="text-slate-400">Modul Sistem</div>
                <div class="col-span-2 text-slate-800 font-semibold">Manajemen Barang</div>
                <div class="text-slate-400">Alamat IP</div>
                <div class="col-span-2 text-slate-700 font-mono">192.168.1.12</div>
                <div class="text-slate-400">Aktivitas Log</div>
                <div class="col-span-2 text-slate-800 font-medium bg-slate-50 border border-slate-100 rounded-xl p-3 leading-relaxed">Menghapus data barang BRG-009</div>
            </div>
            <div class="flex justify-end pt-2 border-t border-slate-50">
                <button onclick="toggleModal('modal-audit-delete')" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold px-5 py-2 rounded-xl text-xs transition">Tutup</button>
            </div>
        </div>
    </div>

    <div id="modal-audit-approve" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-center justify-center hidden opacity-0 transition-opacity duration-300">
        <div class="bg-white rounded-2xl w-full max-w-lg shadow-xl overflow-hidden transform scale-95 transition-transform duration-300 p-6 space-y-4">
            <div class="border-b border-slate-100 pb-3 flex justify-between items-center">
                <h3 class="text-base font-bold text-slate-900">Detail Audit Trail</h3>
                <span class="px-2.5 py-0.5 rounded-full bg-blue-50 text-blue-600 text-[10px] font-bold">APPROVE</span>
            </div>
            <div class="grid grid-cols-3 gap-y-3.5 text-xs">
                <div class="text-slate-400">Waktu Aktivitas</div>
                <div class="col-span-2 text-slate-800 font-semibold">28 Mei 2026, 09:45:22</div>
                <div class="text-slate-400">Nama Pengguna</div>
                <div class="col-span-2 text-slate-800 font-semibold">Sandy Aryadi</div>
                <div class="text-slate-400">Peran Kontrol</div>
                <div class="col-span-2 text-slate-800 font-semibold">Admin Lab</div>
                <div class="text-slate-400">Modul Sistem</div>
                <div class="col-span-2 text-slate-800 font-semibold">Peminjaman</div>
                <div class="text-slate-400">Alamat IP</div>
                <div class="col-span-2 text-slate-700 font-mono">192.168.1.12</div>
                <div class="text-slate-400">Aktivitas Log</div>
                <div class="col-span-2 text-slate-800 font-medium bg-slate-50 border border-slate-100 rounded-xl p-3 leading-relaxed">Menyetujui pengajuan peminjaman PMJ-004</div>
            </div>
            <div class="flex justify-end pt-2 border-t border-slate-50">
                <button onclick="toggleModal('modal-audit-approve')" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold px-5 py-2 rounded-xl text-xs transition">Tutup</button>
            </div>
        </div>
    </div>

    <div id="modal-audit-rejected" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-center justify-center hidden opacity-0 transition-opacity duration-300">
        <div class="bg-white rounded-2xl w-full max-w-lg shadow-xl overflow-hidden transform scale-95 transition-transform duration-300 p-6 space-y-4">
            <div class="border-b border-slate-100 pb-3 flex justify-between items-center">
                <h3 class="text-base font-bold text-slate-900">Detail Audit Trail</h3>
                <span class="px-2.5 py-0.5 rounded-full bg-red-50 text-red-600 text-[10px] font-bold">REJECT</span>
            </div>
            <div class="grid grid-cols-3 gap-y-3.5 text-xs">
                <div class="text-slate-400">Waktu Aktivitas</div>
                <div class="col-span-2 text-slate-800 font-semibold">28 Mei 2026, 09:30:11</div>
                <div class="text-slate-400">Nama Pengguna</div>
                <div class="col-span-2 text-slate-800 font-semibold">Sandy Aryadi</div>
                <div class="text-slate-400">Peran Kontrol</div>
                <div class="col-span-2 text-slate-800 font-semibold">Admin Lab</div>
                <div class="text-slate-400">Modul Sistem</div>
                <div class="col-span-2 text-slate-800 font-semibold">Peminjaman</div>
                <div class="text-slate-400">Alamat IP</div>
                <div class="col-span-2 text-slate-700 font-mono">192.168.1.12</div>
                <div class="text-slate-400">Aktivitas Log</div>
                <div class="col-span-2 text-slate-800 font-medium bg-slate-50 border border-slate-100 rounded-xl p-3 leading-relaxed">Menolak pengajuan peminjaman PMJ-002</div>
            </div>
            <div class="flex justify-end pt-2 border-t border-slate-50">
                <button onclick="toggleModal('modal-audit-rejected')" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold px-5 py-2 rounded-xl text-xs transition">Tutup</button>
            </div>
        </div>
    </div>

    <div id="modal-audit-export" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-center justify-center hidden opacity-0 transition-opacity duration-300">
        <div class="bg-white rounded-2xl w-full max-w-lg shadow-xl overflow-hidden transform scale-95 transition-transform duration-300 p-6 space-y-4">
            <div class="border-b border-slate-100 pb-3 flex justify-between items-center">
                <h3 class="text-base font-bold text-slate-900">Detail Audit Trail</h3>
                <span class="px-2.5 py-0.5 rounded-full bg-purple-50 text-purple-600 text-[10px] font-bold">EXPORT</span>
            </div>
            <div class="grid grid-cols-3 gap-y-3.5 text-xs">
                <div class="text-slate-400">Waktu Aktivitas</div>
                <div class="col-span-2 text-slate-800 font-semibold">28 Mei 2026, 08:50:41</div>
                <div class="text-slate-400">Nama Pengguna</div>
                <div class="col-span-2 text-slate-800 font-semibold">Sandy Aryadi</div>
                <div class="text-slate-400">Peran Kontrol</div>
                <div class="col-span-2 text-slate-800 font-semibold">Admin Lab</div>
                <div class="text-slate-400">Modul Sistem</div>
                <div class="col-span-2 text-slate-800 font-semibold">Laporan</div>
                <div class="text-slate-400">Alamat IP</div>
                <div class="col-span-2 text-slate-700 font-mono">192.168.1.12</div>
                <div class="text-slate-400">Aktivitas Log</div>
                <div class="col-span-2 text-slate-800 font-medium bg-slate-50 border border-slate-100 rounded-xl p-3 leading-relaxed">Mengekspor data laporan log mutasi stok ke Excel</div>
            </div>
            <div class="flex justify-end pt-2 border-t border-slate-50">
                <button onclick="toggleModal('modal-audit-export')" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold px-5 py-2 rounded-xl text-xs transition">Tutup</button>
            </div>
        </div>
    </div>

    <div id="modal-audit-login" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-center justify-center hidden opacity-0 transition-opacity duration-300">
        <div class="bg-white rounded-2xl w-full max-w-lg shadow-xl overflow-hidden transform scale-95 transition-transform duration-300 p-6 space-y-4">
            <div class="border-b border-slate-100 pb-3 flex justify-between items-center">
                <h3 class="text-base font-bold text-slate-900">Detail Audit Trail</h3>
                <span class="px-2.5 py-0.5 rounded-full bg-teal-50 text-teal-600 text-[10px] font-bold">LOGIN</span>
            </div>
            <div class="grid grid-cols-3 gap-y-3.5 text-xs">
                <div class="text-slate-400">Waktu Aktivitas</div>
                <div class="col-span-2 text-slate-800 font-semibold">28 Mei 2026, 08:00:02</div>
                <div class="text-slate-400">Nama Pengguna</div>
                <div class="col-span-2 text-slate-800 font-semibold">Sandy Aryadi</div>
                <div class="text-slate-400">Peran Kontrol</div>
                <div class="col-span-2 text-slate-800 font-semibold">Admin Lab</div>
                <div class="text-slate-400">Modul Sistem</div>
                <div class="col-span-2 text-slate-800 font-semibold">Autentikasi</div>
                <div class="text-slate-400">Alamat IP</div>
                <div class="col-span-2 text-slate-700 font-mono">192.168.1.12</div>
                <div class="text-slate-400">Aktivitas Log</div>
                <div class="col-span-2 text-slate-800 font-medium bg-slate-50 border border-slate-100 rounded-xl p-3 leading-relaxed">User berhasil masuk ke dalam sistem</div>
            </div>
            <div class="flex justify-end pt-2 border-t border-slate-50">
                <button onclick="toggleModal('modal-audit-login')" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold px-5 py-2 rounded-xl text-xs transition">Tutup</button>
            </div>
        </div>
    </div>

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
</body>
</html>
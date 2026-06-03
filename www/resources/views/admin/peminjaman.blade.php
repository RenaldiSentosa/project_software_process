<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $pageTitle ?? 'IPWIJA SmartLab - Manajemen Peminjaman' }}</title>
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
                <a href="{{ route('admin.peminjaman') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-semibold rounded-lg bg-blue-50 text-blue-600 transition">
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
                <a href="{{ route('admin.audit_trail') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-lg text-slate-500 hover:bg-slate-50 hover:text-slate-800 transition">
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
                <h2 class="text-2xl font-bold text-slate-900 tracking-tight">Manajemen Peminjaman</h2>
                <p class="text-slate-500 text-sm mt-1">Kelola pengajuan peminjaman alat laboratorium Universitas IPWIJA.</p>
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
                <button class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2.5 rounded-xl text-xs transition shadow-sm uppercase tracking-wider">
                    Filter
                </button>
            </div>

            <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="p-5 border-b border-slate-100">
                    <h3 class="font-bold text-slate-800 text-sm">Permintaan Peminjaman</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs border-collapse">
                        <thead>
                            <tr class="bg-slate-50/70 border-b border-slate-100 text-slate-400 font-semibold uppercase tracking-wider">
                                <th class="py-4 px-6">ID Peminjaman</th>
                                <th class="py-4 px-6">Mahasiswa</th>
                                <th class="py-4 px-6">Prodi</th>
                                <th class="py-4 px-6">Tanggal Pengajuan</th>
                                <th class="py-4 px-6">Jumlah Alat</th>
                                <th class="py-4 px-6">Status</th>
                                <th class="py-4 px-6 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-700">
                            <tr class="hover:bg-slate-50/50 transition">
                                <td class="py-4 px-6 font-semibold text-slate-800">PJM-001</td>
                                <td class="py-4 px-6"><span class="font-semibold text-slate-800 block">Muhamad Aprijal</span><span class="text-slate-400 text-[11px]">202301110011</span></td>
                                <td class="py-4 px-6 font-medium text-slate-600">Teknik Informatika</td>
                                <td class="py-4 px-6 font-medium text-slate-500">18 Mei 2026</td>
                                <td class="py-4 px-6 font-medium text-slate-600">2 jenis, 6 unit</td>
                                <td class="py-4 px-6"><span class="px-2 py-0.5 rounded-full bg-blue-50 text-blue-500 text-[10px] font-bold flex items-center gap-1 w-fit"><span class="w-1 h-1 bg-blue-500 rounded-full"></span>Disetujui</span></td>
                                <td class="py-4 px-6 text-center space-x-3">
                                    <button onclick="toggleModal('modal-detail-disetujui')" class="text-slate-400 hover:text-slate-600" title="Lihat Detail"><i class="fa-regular fa-eye text-sm"></i></button>
                                    <button class="text-slate-400 hover:text-purple-600" title="Catat Peminjaman"><i class="fa-solid fa-clipboard-check text-sm"></i></button>
                                </td>
                            </tr>
                            <tr class="hover:bg-slate-50/50 transition">
                                <td class="py-4 px-6 font-semibold text-slate-800">PJM-003</td>
                                <td class="py-4 px-6"><span class="font-semibold text-slate-800 block">Muhamad Aprijal</span><span class="text-slate-400 text-[11px]">202301110011</span></td>
                                <td class="py-4 px-6 font-medium text-slate-600">Teknik Informatika</td>
                                <td class="py-4 px-6 font-medium text-slate-500">18 Mei 2026</td>
                                <td class="py-4 px-6 font-medium text-slate-600">2 jenis, 6 unit</td>
                                <td class="py-4 px-6"><span class="px-2 py-0.5 rounded-full bg-purple-50 text-purple-500 text-[10px] font-bold flex items-center gap-1 w-fit"><span class="w-1 h-1 bg-purple-500 rounded-full"></span>Dipinjam</span></td>
                                <td class="py-4 px-6 text-center space-x-3">
                                    <button onclick="toggleModal('modal-detail-dipinjam')" class="text-slate-400 hover:text-slate-600" title="Lihat Detail"><i class="fa-regular fa-eye text-sm"></i></button>
                                    <button class="text-slate-400 hover:text-emerald-600" title="Catat Pengembalian"><i class="fa-solid fa-rotate-left text-sm"></i></button>
                                </td>
                            </tr>
                            <tr class="hover:bg-slate-50/50 transition">
                                <td class="py-4 px-6 font-semibold text-slate-800">PJM-005</td>
                                <td class="py-4 px-6"><span class="font-semibold text-slate-800 block">Muhamad Aprijal</span><span class="text-slate-400 text-[11px]">202301110011</span></td>
                                <td class="py-4 px-6 font-medium text-slate-600">Teknik Informatika</td>
                                <td class="py-4 px-6 font-medium text-slate-500">18 Mei 2026</td>
                                <td class="py-4 px-6 font-medium text-slate-600">4 jenis, 7 unit</td>
                                <td class="py-4 px-6"><span class="px-2 py-0.5 rounded-full bg-amber-50 text-amber-600 text-[10px] font-bold flex items-center gap-1 w-fit"><span class="w-1.5 h-1.5 bg-amber-500 rounded-full"></span>Menunggu</span></td>
                                <td class="py-4 px-6 text-center space-x-3">
                                    <button onclick="toggleModal('modal-detail-menunggu')" class="text-slate-400 hover:text-slate-600" title="Lihat Detail"><i class="fa-regular fa-eye text-sm"></i></button>
                                    <button class="text-slate-400 hover:text-blue-600" title="Setujui"><i class="fa-solid fa-check text-sm"></i></button>
                                    <button onclick="openPenolakanLangsung()" class="text-slate-400 hover:text-rose-600" title="Tolak"><i class="fa-solid fa-xmark text-sm"></i></button>
                                </td>
                            </tr>
                            <tr class="hover:bg-slate-50/50 transition">
                                <td class="py-4 px-6 font-semibold text-slate-800">PJM-007</td>
                                <td class="py-4 px-6"><span class="font-semibold text-slate-800 block">Muhamad Aprijal</span><span class="text-slate-400 text-[11px]">202301110011</span></td>
                                <td class="py-4 px-6 font-medium text-slate-600">Teknik Informatika</td>
                                <td class="py-4 px-6 font-medium text-slate-500">18 Mei 2026</td>
                                <td class="py-4 px-6 font-medium text-slate-600">2 jenis, 6 unit</td>
                                <td class="py-4 px-6"><span class="px-2 py-0.5 rounded-full bg-rose-50 text-rose-600 text-[10px] font-bold flex items-center gap-1 w-fit"><span class="w-1 h-1 bg-rose-500 rounded-full"></span>Ditolak</span></td>
                                <td class="py-4 px-6 text-center shadow-sm">
                                    <button class="text-slate-300 cursor-not-allowed" disabled><i class="fa-regular fa-eye text-sm"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="p-5 border-t border-slate-100 flex justify-between items-center text-xs text-slate-500">
                    <span>Menampilkan 1-7 dari 120 alat</span>
                    <div class="flex gap-1">
                        <button class="w-7 h-7 flex items-center justify-center rounded border border-slate-200 hover:bg-slate-50"><i class="fa-solid fa-chevron-left text-[10px]"></i></button>
                        <button class="w-7 h-7 flex items-center justify-center rounded bg-blue-600 text-white font-medium">1</button>
                        <button class="w-7 h-7 flex items-center justify-center rounded border border-slate-200 hover:bg-slate-50">2</button>
                        <button class="w-7 h-7 flex items-center justify-center rounded border border-slate-200 hover:bg-slate-50">3</button>
                        <button class="w-7 h-7 flex items-center justify-center rounded border border-slate-200 hover:bg-slate-50"><i class="fa-solid fa-chevron-right text-[10px]"></i></button>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <div id="modal-detail-disetujui" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-center justify-center hidden opacity-0 transition-opacity duration-300">
        <div class="bg-white rounded-2xl w-full max-w-xl shadow-xl overflow-hidden transform scale-95 transition-transform duration-300 p-6 space-y-6">
            <div class="flex justify-between items-start">
                <div>
                    <span class="text-[11px] font-bold text-slate-400 block uppercase">ID Peminjaman</span>
                    <h3 class="text-lg font-bold text-slate-900">PJM-001</h3>
                </div>
                <span class="px-3 py-1 rounded-full bg-blue-50 text-blue-500 text-[11px] font-bold flex items-center gap-1.5">
                    <span class="w-1.5 h-1.5 bg-blue-500 rounded-full"></span>Disetujui
                </span>
            </div>

            <div class="border border-slate-100 rounded-2xl p-5 space-y-4 bg-slate-50/30">
                <h4 class="text-xs font-bold text-slate-800 tracking-wide">Data Mahasiswa</h4>
                <div class="grid grid-cols-2 gap-y-4 gap-x-6 text-xs">
                    <div>
                        <span class="text-slate-400 block mb-0.5">Nama Lengkap</span>
                        <span class="font-semibold text-slate-800">Muhamad Aprijal</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block mb-0.5">NIM</span>
                        <span class="font-semibold text-slate-800">202301110011</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block mb-0.5">Program Studi</span>
                        <span class="font-semibold text-slate-800">Teknik Informatika</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block mb-0.5">Email</span>
                        <span class="font-semibold text-slate-800">muhamadaprijal17@gmail.com</span>
                    </div>
                </div>
            </div>

            <div class="space-y-3">
                <h4 class="text-xs font-bold text-slate-800 tracking-wide">Daftar Alat yang Dipinjam</h4>
                <div class="border border-slate-100 rounded-xl overflow-hidden">
                    <table class="w-full text-left text-xs border-collapse">
                        <thead>
                            <tr class="bg-slate-50 text-slate-500 font-semibold border-b border-slate-100">
                                <th class="py-3 px-4">Nama Alat</th>
                                <th class="py-3 px-4">Kategori</th>
                                <th class="py-3 px-4 text-center">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-700 font-medium">
                            <tr>
                                <td class="py-3 px-4 font-semibold text-slate-800">Router</td>
                                <td class="py-3 px-4 text-slate-500">Network</td>
                                <td class="py-3 px-4 text-center font-bold">1</td>
                            </tr>
                            <tr>
                                <td class="py-3 px-4 font-semibold text-slate-800">Tang crimping</td>
                                <td class="py-3 px-4 text-slate-500">Network</td>
                                <td class="py-3 px-4 text-center font-bold">1</td>
                            </tr>
                            <tr>
                                <td class="py-3 px-4 font-semibold text-slate-800">Konektor RJ 45</td>
                                <td class="py-3 px-4 text-slate-500">Network</td>
                                <td class="py-3 px-4 text-center font-bold">4</td>
                            </tr>
                            <tr>
                                <td class="py-3 px-4 font-semibold text-slate-800">Lan Tester</td>
                                <td class="py-3 px-4 text-slate-500">Network</td>
                                <td class="py-3 px-4 text-center font-bold">1</td>
                            </tr>
                            <tr class="bg-slate-50/50 font-bold text-slate-800 border-t border-slate-100">
                                <td colspan="2" class="py-3 px-4">Total item</td>
                                <td class="py-3 px-4 text-center">7 item</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="flex justify-end gap-2 pt-4 border-t border-slate-100">
                <button class="bg-purple-600 hover:bg-purple-700 text-white font-bold px-5 py-2.5 rounded-xl transition text-xs shadow-sm">Catat Peminjaman</button>
                <button onclick="toggleModal('modal-detail-disetujui')" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold px-5 py-2.5 rounded-xl transition text-xs">Tutup</button>
            </div>
        </div>
    </div>

    <div id="modal-detail-dipinjam" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-center justify-center hidden opacity-0 transition-opacity duration-300">
        <div class="bg-white rounded-2xl w-full max-w-xl shadow-xl overflow-hidden transform scale-95 transition-transform duration-300 p-6 space-y-6">
            <div class="flex justify-between items-start">
                <div>
                    <span class="text-[11px] font-bold text-slate-400 block uppercase">ID Peminjaman</span>
                    <h3 class="text-lg font-bold text-slate-900">PJM-001</h3>
                </div>
                <span class="px-3 py-1 rounded-full bg-purple-50 text-purple-500 text-[11px] font-bold flex items-center gap-1.5">
                    <span class="w-1.5 h-1.5 bg-purple-500 rounded-full"></span>Dipinjam
                </span>
            </div>

            <div class="border border-slate-100 rounded-2xl p-5 space-y-4 bg-slate-50/30">
                <h4 class="text-xs font-bold text-slate-800 tracking-wide">Data Mahasiswa</h4>
                <div class="grid grid-cols-2 gap-y-4 gap-x-6 text-xs">
                    <div>
                        <span class="text-slate-400 block mb-0.5">Nama Lengkap</span>
                        <span class="font-semibold text-slate-800">Muhamad Aprijal</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block mb-0.5">NIM</span>
                        <span class="font-semibold text-slate-800">202301110011</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block mb-0.5">Program Studi</span>
                        <span class="font-semibold text-slate-800">Teknik Informatika</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block mb-0.5">Email</span>
                        <span class="font-semibold text-slate-800">muhamadaprijal17@gmail.com</span>
                    </div>
                </div>
            </div>

            <div class="space-y-3">
                <h4 class="text-xs font-bold text-slate-800 tracking-wide">Daftar Alat yang Dipinjam</h4>
                <div class="border border-slate-100 rounded-xl overflow-hidden">
                    <table class="w-full text-left text-xs border-collapse">
                        <thead>
                            <tr class="bg-slate-50 text-slate-500 font-semibold border-b border-slate-100">
                                <th class="py-3 px-4">Nama Alat</th>
                                <th class="py-3 px-4">Kategori</th>
                                <th class="py-3 px-4 text-center">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-700 font-medium">
                            <tr>
                                <td class="py-3 px-4 font-semibold text-slate-800">Router</td>
                                <td class="py-3 px-4 text-slate-500">Network</td>
                                <td class="py-3 px-4 text-center font-bold">1</td>
                            </tr>
                            <tr>
                                <td class="py-3 px-4 font-semibold text-slate-800">Tang crimping</td>
                                <td class="py-3 px-4 text-slate-500">Network</td>
                                <td class="py-3 px-4 text-center font-bold">1</td>
                            </tr>
                            <tr>
                                <td class="py-3 px-4 font-semibold text-slate-800">Konektor RJ 45</td>
                                <td class="py-3 px-4 text-slate-500">Network</td>
                                <td class="py-3 px-4 text-center font-bold">4</td>
                            </tr>
                            <tr>
                                <td class="py-3 px-4 font-semibold text-slate-800">Lan Tester</td>
                                <td class="py-3 px-4 text-slate-500">Network</td>
                                <td class="py-3 px-4 text-center font-bold">1</td>
                            </tr>
                            <tr class="bg-slate-50/50 font-bold text-slate-800 border-t border-slate-100">
                                <td colspan="2" class="py-3 px-4">Total item</td>
                                <td class="py-3 px-4 text-center">7 item</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="flex justify-end gap-2 pt-4 border-t border-slate-100">
                <button class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-5 py-2.5 rounded-xl transition text-xs shadow-sm">Catat Pengembalian</button>
                <button onclick="toggleModal('modal-detail-dipinjam')" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold px-5 py-2.5 rounded-xl transition text-xs">Tutup</button>
            </div>
        </div>
    </div>

    <div id="modal-detail-menunggu" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-center justify-center hidden opacity-0 transition-opacity duration-300">
        <div class="bg-white rounded-2xl w-full max-w-xl shadow-xl overflow-hidden transform scale-95 transition-transform duration-300 p-6 space-y-6">
            <div class="flex justify-between items-start">
                <div>
                    <span class="text-[11px] font-bold text-slate-400 block uppercase">ID Peminjaman</span>
                    <h3 class="text-lg font-bold text-slate-900">PJM-001</h3>
                </div>
                <span class="px-3 py-1 rounded-full bg-amber-50 text-amber-600 text-[11px] font-bold flex items-center gap-1.5">
                    <span class="w-1.5 h-1.5 bg-amber-500 rounded-full"></span>Menunggu
                </span>
            </div>

            <div class="border border-slate-100 rounded-2xl p-5 space-y-4 bg-slate-50/30">
                <h4 class="text-xs font-bold text-slate-800 tracking-wide">Data Mahasiswa</h4>
                <div class="grid grid-cols-2 gap-y-4 gap-x-6 text-xs">
                    <div>
                        <span class="text-slate-400 block mb-0.5">Nama Lengkap</span>
                        <span class="font-semibold text-slate-800">Muhamad Aprijal</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block mb-0.5">NIM</span>
                        <span class="font-semibold text-slate-800">202301110011</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block mb-0.5">Program Studi</span>
                        <span class="font-semibold text-slate-800">Teknik Informatika</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block mb-0.5">Email</span>
                        <span class="font-semibold text-slate-800">muhamadaprijal17@gmail.com</span>
                    </div>
                </div>
            </div>

            <div class="space-y-3">
                <h4 class="text-xs font-bold text-slate-800 tracking-wide">Daftar Alat yang Dipinjam</h4>
                <div class="border border-slate-100 rounded-xl overflow-hidden">
                    <table class="w-full text-left text-xs border-collapse">
                        <thead>
                            <tr class="bg-slate-50 text-slate-500 font-semibold border-b border-slate-100">
                                <th class="py-3 px-4">Nama Alat</th>
                                <th class="py-3 px-4">Kategori</th>
                                <th class="py-3 px-4 text-center">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-700 font-medium">
                            <tr>
                                <td class="py-3 px-4 font-semibold text-slate-800">Router</td>
                                <td class="py-3 px-4 text-slate-500">Network</td>
                                <td class="py-3 px-4 text-center font-bold">1</td>
                            </tr>
                            <tr>
                                <td class="py-3 px-4 font-semibold text-slate-800">Tang crimping</td>
                                <td class="py-3 px-4 text-slate-500">Network</td>
                                <td class="py-3 px-4 text-center font-bold">1</td>
                            </tr>
                            <tr>
                                <td class="py-3 px-4 font-semibold text-slate-800">Konektor RJ 45</td>
                                <td class="py-3 px-4 text-slate-500">Network</td>
                                <td class="py-3 px-4 text-center font-bold">4</td>
                            </tr>
                            <tr>
                                <td class="py-3 px-4 font-semibold text-slate-800">Lan Tester</td>
                                <td class="py-3 px-4 text-slate-500">Network</td>
                                <td class="py-3 px-4 text-center font-bold">1</td>
                            </tr>
                            <tr class="bg-slate-50/50 font-bold text-slate-800 border-t border-slate-100">
                                <td colspan="2" class="py-3 px-4">Total item</td>
                                <td class="py-3 px-4 text-center">7 item</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="flex justify-end gap-2 pt-4 border-t border-slate-100">
                <button onclick="openPenolakanDariDetail()" class="bg-red-600 hover:bg-red-700 text-white font-bold px-5 py-2.5 rounded-xl transition text-xs shadow-sm">Tolak</button>
                <button class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-5 py-2.5 rounded-xl transition text-xs shadow-sm">Setujui</button>
                <button onclick="toggleModal('modal-detail-menunggu')" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold px-5 py-2.5 rounded-xl transition text-xs">Tutup</button>
            </div>
        </div>
    </div>

    <div id="modal-konfirmasi-penolakan" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-[60] flex items-center justify-center hidden opacity-0 transition-opacity duration-300">
        <div class="bg-white rounded-2xl w-full max-w-md shadow-xl overflow-hidden transform scale-95 transition-transform duration-300 p-6 space-y-4">
            <div>
                <h3 class="text-base font-bold text-slate-900">Konfirmasi Penolakan</h3>
                <p class="text-slate-500 text-xs mt-1">Mohon berikan alasan penolakan peminjaman ini.</p>
            </div>
            
            <form action="#" method="POST" class="space-y-4 text-xs">
                @csrf
                <div>
                    <label class="block font-semibold text-slate-700 mb-1.5">Alasan Penolakan <span class="text-rose-500">*</span></label>
                    <textarea rows="4" placeholder="Contoh: Alat tiba-tiba rusak" class="w-full border border-slate-200 rounded-xl p-3 focus:outline-none focus:border-blue-500 text-slate-600 placeholder-slate-400 resize-none"></textarea>
                </div>
                
                <div class="flex justify-end gap-2 pt-2">
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold px-5 py-2.5 rounded-xl transition shadow-sm">Tolak</button>
                    <button type="button" onclick="closePenolakan()" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold px-5 py-2.5 rounded-xl transition">Batal</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Track stack modal detail yang sedang terbuka agar bisa kembali dengan benar
        let activeDetailModalId = null;

        function toggleModal(modalId) {
            const modal = document.getElementById(modalId);
            if (!modal) return;
            const modalContent = modal.querySelector('div');

            if (modal.classList.contains('hidden')) {
                modal.classList.remove('hidden');
                if(modalId !== 'modal-konfirmasi-penolakan') {
                    activeDetailModalId = modalId;
                }
                setTimeout(() => {
                    modal.classList.remove('opacity-0');
                    modalContent.classList.remove('scale-95');
                }, 20);
            } else {
                modal.classList.add('opacity-0');
                modalContent.classList.add('scale-95');
                setTimeout(() => {
                    modal.classList.add('hidden');
                    if(modalId === activeDetailModalId) activeDetailModalId = null;
                }, 300);
            }
        }

        // Alur pembukaan penolakan dari dalam modal detail
        function openPenolakanDariDetail() {
            // Sembunyikan detail peminjaman terlebih dahulu
            if (activeDetailModalId) {
                const currentDetail = document.getElementById(activeDetailModalId);
                currentDetail.classList.add('opacity-0');
                currentDetail.querySelector('div').classList.add('scale-95');
                setTimeout(() => { currentDetail.classList.add('hidden'); }, 300);
            }
            // Tampilkan dialog alasan penolakan
            toggleModal('modal-konfirmasi-penolakan');
        }

        // Alur pembukaan penolakan langsung dari tombol aksi tabel utama
        function openPenolakanLangsung() {
            activeDetailModalId = null; 
            toggleModal('modal-konfirmasi-penolakan');
        }

        // Menutup modal penolakan, mengembalikan modal detail jika sebelumnya dibuka melaluinya
        function closePenolakan() {
            toggleModal('modal-konfirmasi-penolakan');
            if (activeDetailModalId) {
                setTimeout(() => {
                    const currentDetail = document.getElementById(activeDetailModalId);
                    currentDetail.classList.remove('hidden');
                    setTimeout(() => {
                        currentDetail.classList.remove('opacity-0');
                        currentDetail.querySelector('div').classList.remove('scale-95');
                    }, 20);
                }, 300);
            }
        }

        // Menutup modal ketika pengguna mengeklik area luar (backdrop) kosong
        window.onclick = function(event) {
            if (event.target.attributes.id && event.target.attributes.id.value.startsWith('modal-')) {
                if (event.target.id === 'modal-konfirmasi-penolakan') {
                    closePenolakan();
                } else {
                    toggleModal(event.target.id);
                }
            }
        }
    </script>
</body>
</html>
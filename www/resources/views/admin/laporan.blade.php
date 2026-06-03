<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $pageTitle ?? 'IPWIJA SmartLab - Laporan' }}</title>
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
                <a href="{{ route('admin.laporan') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-semibold rounded-lg bg-blue-50 text-blue-600 transition">
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
                <h2 class="text-2xl font-bold text-slate-900 tracking-tight">Laporan & Rekapitulasi</h2>
                <p class="text-slate-500 text-sm mt-1">Pantau, analisis, dan ekspor data operasional laboratorium Universitas IPWIJA.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm flex flex-col justify-between hover:shadow-md transition">
                    <div class="space-y-4">
                        <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center text-lg shadow-sm">
                            <i class="fa-solid fa-boxes-stacked"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-800 text-base">Laporan Status Inventaris</h3>
                            <p class="text-slate-400 text-xs mt-1.5 leading-relaxed">Rekap kondisi aset alat dan barang laboratorium secara menyeluruh beserta penanda stok minimum.</p>
                        </div>
                    </div>
                    <div class="pt-6">
                        <button onclick="toggleModal('modal-laporan-inventaris')" class="w-full bg-slate-50 hover:bg-slate-100 text-slate-700 font-semibold py-2.5 px-4 rounded-xl text-xs transition border border-slate-200 flex items-center justify-center gap-2">
                            <span>Lihat Laporan</span> <i class="fa-solid fa-arrow-right text-[10px]"></i>
                        </button>
                    </div>
                </div>

                <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm flex flex-col justify-between hover:shadow-md transition">
                    <div class="space-y-4">
                        <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center text-lg shadow-sm">
                            <i class="fa-solid fa-clock-rotate-left"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-800 text-base">Laporan Log Mutasi Stok</h3>
                            <p class="text-slate-400 text-xs mt-1.5 leading-relaxed">Jurnal riwayat aktivitas keluar dan masuknya stok barang laboratorium beserta keterangan mutasi.</p>
                        </div>
                    </div>
                    <div class="pt-6">
                        <button onclick="toggleModal('modal-laporan-mutasi')" class="w-full bg-slate-50 hover:bg-slate-100 text-slate-700 font-semibold py-2.5 px-4 rounded-xl text-xs transition border border-slate-200 flex items-center justify-center gap-2">
                            <span>Lihat Laporan</span> <i class="fa-solid fa-arrow-right text-[10px]"></i>
                        </button>
                    </div>
                </div>

                <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm flex flex-col justify-between hover:shadow-md transition">
                    <div class="space-y-4">
                        <div class="w-12 h-12 bg-purple-50 text-purple-600 rounded-xl flex items-center justify-center text-lg shadow-sm">
                            <i class="fa-solid fa-user-graduate"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-800 text-base">Laporan Rekap Mahasiswa</h3>
                            <p class="text-slate-400 text-xs mt-1.5 leading-relaxed">Daftar akumulasi performa frekuensi peminjaman alat oleh mahasiswa berdasarkan program studi.</p>
                        </div>
                    </div>
                    <div class="pt-6">
                        <button onclick="toggleModal('modal-laporan-mahasiswa')" class="w-full bg-slate-50 hover:bg-slate-100 text-slate-700 font-semibold py-2.5 px-4 rounded-xl text-xs transition border border-slate-200 flex items-center justify-center gap-2">
                            <span>Lihat Laporan</span> <i class="fa-solid fa-arrow-right text-[10px]"></i>
                        </button>
                    </div>
                </div>

            </div>

        </main>
    </div>

    <div id="modal-laporan-inventaris" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-center justify-center hidden opacity-0 transition-opacity duration-300 p-4">
        <div class="bg-white rounded-2xl w-full max-w-5xl shadow-xl overflow-hidden transform scale-95 transition-transform duration-300 flex flex-col max-h-[90vh]">
            <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-white">
                <div>
                    <h3 class="text-lg font-bold text-slate-900">Laporan Status Inventaris</h3>
                    <p class="text-slate-400 text-xs mt-0.5">Kondisi fisik real-time dan statistik ketersediaan barang lab.</p>
                </div>
                <div class="flex gap-2">
                    <button class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-xl text-xs transition shadow-sm flex items-center gap-2">
                        <i class="fa-solid fa-file-pdf"></i> Cetak PDF
                    </button>
                    <button class="bg-emerald-600 hover:bg-emerald-700 text-white font-semibold px-4 py-2 rounded-xl text-xs transition shadow-sm flex items-center gap-2">
                        <i class="fa-solid fa-file-excel"></i> Ekspor Excel
                    </button>
                    <button onclick="toggleModal('modal-laporan-inventaris')" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold px-4 py-2 rounded-xl text-xs transition">
                        Tutup
                    </button>
                </div>
            </div>
            
            <div class="p-6 overflow-y-auto flex-1 bg-slate-50/50">
                <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                    <table class="w-full text-left text-xs border-collapse">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 font-semibold uppercase tracking-wider">
                                <th class="py-3.5 px-5">Kode Barang</th>
                                <th class="py-3.5 px-5">Nama Barang</th>
                                <th class="py-3.5 px-5">Kategori</th>
                                <th class="py-3.5 px-5 text-center">Bagus</th>
                                <th class="py-3.5 px-5 text-center">Rusak Ringan</th>
                                <th class="py-3.5 px-5 text-center">Rusak Berat</th>
                                <th class="py-3.5 px-5 text-center">Total Stok</th>
                                <th class="py-3.5 px-5 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-700 font-medium">
                            <tr class="hover:bg-slate-50/60 transition">
                                <td class="py-3.5 px-5 font-bold text-slate-800">BRG-001</td>
                                <td class="py-3.5 px-5 font-bold text-slate-800">Meja</td>
                                <td class="py-3.5 px-5 text-slate-500">Furnitur</td>
                                <td class="py-3.5 px-5 text-center font-bold text-emerald-600">45</td>
                                <td class="py-3.5 px-5 text-center text-slate-500">0</td>
                                <td class="py-3.5 px-5 text-center text-slate-500">0</td>
                                <td class="py-3.5 px-5 text-center font-bold">45</td>
                                <td class="py-3.5 px-5 text-center"><span class="mx-auto px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-600 text-[10px] font-bold flex items-center gap-1 w-fit"><span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>Aman</span></td>
                            </tr>
                            <tr class="hover:bg-slate-50/60 transition">
                                <td class="py-3.5 px-5 font-bold text-slate-800">BRG-002</td>
                                <td class="py-3.5 px-5 font-bold text-slate-800">Kursi</td>
                                <td class="py-3.5 px-5 text-slate-500">Furnitur</td>
                                <td class="py-3.5 px-5 text-center font-bold text-emerald-600">40</td>
                                <td class="py-3.5 px-5 text-center text-amber-600">5</td>
                                <td class="py-3.5 px-5 text-center text-slate-500">0</td>
                                <td class="py-3.5 px-5 text-center font-bold">45</td>
                                <td class="py-3.5 px-5 text-center"><span class="mx-auto px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-600 text-[10px] font-bold flex items-center gap-1 w-fit"><span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>Aman</span></td>
                            </tr>
                            <tr class="hover:bg-slate-50/60 transition">
                                <td class="py-3.5 px-5 font-bold text-slate-800">BRG-003</td>
                                <td class="py-3.5 px-5 font-bold text-slate-800">Komputer Lab</td>
                                <td class="py-3.5 px-5 text-slate-500">Elektronik</td>
                                <td class="py-3.5 px-5 text-center text-slate-500">0</td>
                                <td class="py-3.5 px-5 text-center text-slate-500">0</td>
                                <td class="py-3.5 px-5 text-center font-bold text-rose-600">15</td>
                                <td class="py-3.5 px-5 text-center font-bold text-rose-600">0</td>
                                <td class="py-3.5 px-5 text-center"><span class="mx-auto px-2 py-0.5 rounded-full bg-rose-50 text-rose-600 text-[10px] font-bold flex items-center gap-1 w-fit"><span class="w-1.5 h-1.5 bg-rose-500 rounded-full"></span>Kritis</span></td>
                            </tr>
                            <tr class="hover:bg-slate-50/60 transition">
                                <td class="py-3.5 px-5 font-bold text-slate-800">BRG-004</td>
                                <td class="py-3.5 px-5 font-bold text-slate-800">Switch Hub 24 Port</td>
                                <td class="py-3.5 px-5 text-slate-500">Jaringan</td>
                                <td class="py-3.5 px-5 text-center font-bold text-emerald-600">4</td>
                                <td class="py-3.5 px-5 text-center text-slate-500">0</td>
                                <td class="py-3.5 px-5 text-center text-slate-500">0</td>
                                <td class="py-3.5 px-5 text-center font-bold">4</td>
                                <td class="py-3.5 px-5 text-center"><span class="mx-auto px-2 py-0.5 rounded-full bg-amber-50 text-amber-600 text-[10px] font-bold flex items-center gap-1 w-fit"><span class="w-1.5 h-1.5 bg-amber-500 rounded-full"></span>Stok Rendah</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div id="modal-laporan-mutasi" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-center justify-center hidden opacity-0 transition-opacity duration-300 p-4">
        <div class="bg-white rounded-2xl w-full max-w-5xl shadow-xl overflow-hidden transform scale-95 transition-transform duration-300 flex flex-col max-h-[90vh]">
            <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-white">
                <div>
                    <h3 class="text-lg font-bold text-slate-900">Laporan Log Mutasi Stok</h3>
                    <p class="text-slate-400 text-xs mt-0.5">Jurnal rekam aktivitas penambahan dan pengurangan stok barang lab.</p>
                </div>
                <div class="flex gap-2">
                    <button class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-xl text-xs transition shadow-sm flex items-center gap-2">
                        <i class="fa-solid fa-file-pdf"></i> Cetak PDF
                    </button>
                    <button class="bg-emerald-600 hover:bg-emerald-700 text-white font-semibold px-4 py-2 rounded-xl text-xs transition shadow-sm flex items-center gap-2">
                        <i class="fa-solid fa-file-excel"></i> Ekspor Excel
                    </button>
                    <button onclick="toggleModal('modal-laporan-mutasi')" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold px-4 py-2 rounded-xl text-xs transition">
                        Tutup
                    </button>
                </div>
            </div>
            
            <div class="p-6 overflow-y-auto flex-1 bg-slate-50/50">
                <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                    <table class="w-full text-left text-xs border-collapse">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 font-semibold uppercase tracking-wider">
                                <th class="py-3.5 px-5">Waktu Mutasi</th>
                                <th class="py-3.5 px-5">Kode Barang</th>
                                <th class="py-3.5 px-5">Nama Barang</th>
                                <th class="py-3.5 px-5">Tipe Mutasi</th>
                                <th class="py-3.5 px-5 text-center">Jumlah</th>
                                <th class="py-3.5 px-5">Keterangan</th>
                                <th class="py-3.5 px-5">Oleh</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-700 font-medium">
                            <tr class="hover:bg-slate-50/60 transition">
                                <td class="py-3.5 px-5 text-slate-500 whitespace-nowrap">28 Mei 2026, 14:30</td>
                                <td class="py-3.5 px-5 font-bold text-slate-800">BRG-001</td>
                                <td class="py-3.5 px-5 font-bold text-slate-800">Meja</td>
                                <td class="py-3.5 px-5"><span class="px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-600 text-[10px] font-bold flex items-center gap-1 w-fit"><i class="fa-solid fa-arrow-down text-[9px]"></i> Stok Masuk</span></td>
                                <td class="py-3.5 px-5 text-center font-bold text-emerald-600">+10</td>
                                <td class="py-3.5 px-5 text-slate-600">Pengadaan meja baru oleh yayasan</td>
                                <td class="py-3.5 px-5 text-slate-800">Sandy Aryadi</td>
                            </tr>
                            <tr class="hover:bg-slate-50/60 transition">
                                <td class="py-3.5 px-5 text-slate-500 whitespace-nowrap">28 Mei 2026, 11:15</td>
                                <td class="py-3.5 px-5 font-bold text-slate-800">BRG-003</td>
                                <td class="py-3.5 px-5 font-bold text-slate-800">Komputer Lab</td>
                                <td class="py-3.5 px-5"><span class="px-2 py-0.5 rounded-full bg-rose-50 text-rose-600 text-[10px] font-bold flex items-center gap-1 w-fit"><i class="fa-solid fa-arrow-up text-[9px]"></i> Stok Keluar</span></td>
                                <td class="py-3.5 px-5 text-center font-bold text-rose-600">-15</td>
                                <td class="py-3.5 px-5 text-slate-600">Unit rusak total akibat korsleting listrik</td>
                                <td class="py-3.5 px-5 text-slate-800">Sandy Aryadi</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div id="modal-laporan-mahasiswa" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-center justify-center hidden opacity-0 transition-opacity duration-300 p-4">
        <div class="bg-white rounded-2xl w-full max-w-5xl shadow-xl overflow-hidden transform scale-95 transition-transform duration-300 flex flex-col max-h-[90vh]">
            <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-white">
                <div>
                    <h3 class="text-lg font-bold text-slate-900">Laporan Rekap Mahasiswa</h3>
                    <p class="text-slate-400 text-xs mt-0.5">Akumulasi statistik aktivitas peminjaman mahasiswa internal kampus.</p>
                </div>
                <div class="flex gap-2">
                    <button class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-xl text-xs transition shadow-sm flex items-center gap-2">
                        <i class="fa-solid fa-file-pdf"></i> Cetak PDF
                    </button>
                    <button class="bg-emerald-600 hover:bg-emerald-700 text-white font-semibold px-4 py-2 rounded-xl text-xs transition shadow-sm flex items-center gap-2">
                        <i class="fa-solid fa-file-excel"></i> Ekspor Excel
                    </button>
                    <button onclick="toggleModal('modal-laporan-mahasiswa')" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold px-4 py-2 rounded-xl text-xs transition">
                        Tutup
                    </button>
                </div>
            </div>
            
            <div class="p-6 overflow-y-auto flex-1 bg-slate-50/50">
                <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                    <table class="w-full text-left text-xs border-collapse">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 font-semibold uppercase tracking-wider">
                                <th class="py-3.5 px-5">NIM</th>
                                <th class="py-3.5 px-5">Nama Lengkap</th>
                                <th class="py-3.5 px-5">Program Studi</th>
                                <th class="py-3.5 px-5 text-center">Menunggu</th>
                                <th class="py-3.5 px-5 text-center">Disetujui</th>
                                <th class="py-3.5 px-5 text-center">Dipinjam</th>
                                <th class="py-3.5 px-5 text-center">Ditolak</th>
                                <th class="py-3.5 px-5 text-center">Total Pengajuan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-700 font-medium">
                            <tr class="hover:bg-slate-50/60 transition">
                                <td class="py-3.5 px-5 text-slate-600">202301110011</td>
                                <td class="py-3.5 px-5 font-bold text-slate-800">Muhamad Aprijal</td>
                                <td class="py-3.5 px-5 text-slate-600">Teknik Informatika</td>
                                <td class="py-3.5 px-5 text-center font-bold text-amber-600">1</td>
                                <td class="py-3.5 px-5 text-center font-bold text-blue-600">1</td>
                                <td class="py-3.5 px-5 text-center font-bold text-purple-600">1</td>
                                <td class="py-3.5 px-5 text-center font-bold text-rose-600">1</td>
                                <td class="py-3.5 px-5 text-center font-bold text-slate-900 bg-slate-50/30">4</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
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

        // Menutup modal ketika pengguna mengeklik area luar (backdrop) kosong
        window.onclick = function(event) {
            if (event.target.attributes.id && event.target.attributes.id.value.startsWith('modal-')) {
                toggleModal(event.target.id);
            }
        }
    </script>
</body>
</html>
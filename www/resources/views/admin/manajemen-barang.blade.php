<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $pageTitle ?? 'IPWIJA SmartLab - Manajemen Barang' }}</title>
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
                <a href="{{ route('admin.manajemen_barang') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-semibold rounded-lg bg-blue-50 text-blue-600 transition">
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
        </main>
    </div>

    <div id="modal-tambah-barang" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-center justify-center hidden opacity-0 transition-opacity duration-300">
        <div class="bg-white rounded-2xl w-full max-w-xl shadow-xl overflow-hidden transform scale-95 transition-transform duration-300 p-6 space-y-5">
            <div>
                <h3 class="text-lg font-bold text-slate-900">Tambah Barang Baru</h3>
            </div>
            
            <form action="#" method="POST" class="space-y-4 text-xs">
                @csrf
                <div>
                    <label class="block font-semibold text-slate-700 mb-1.5">Kode Barang</label>
                    <input type="text" placeholder="BRG-001" class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-slate-400 focus:outline-none cursor-not-allowed" readonly>
                </div>
                <div>
                    <label class="block font-semibold text-slate-700 mb-1.5">Nama Barang</label>
                    <input type="text" placeholder="Masukkan nama barang" class="w-full border border-slate-200 rounded-xl p-3 focus:outline-none focus:border-blue-500 text-slate-700">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="relative">
                        <label class="block font-semibold text-slate-700 mb-1.5">Kategori</label>
                        <select class="w-full appearance-none bg-white border border-slate-200 p-3 rounded-xl focus:outline-none focus:border-blue-500 text-slate-600 cursor-pointer">
                            <option value="" disabled selected>Pilih Kategori</option>
                            <option>Furnitur</option>
                            <option>Multimedia</option>
                            <option>Jaringan</option>
                            <option>Elektronik</option>
                        </select>
                        <i class="fa-solid fa-chevron-down absolute right-4 bottom-4 text-[10px] text-slate-400 pointer-events-none"></i>
                    </div>
                    <div>
                        <label class="block font-semibold text-slate-700 mb-1.5">Satuan</label>
                        <input type="text" placeholder="Contoh: pcs, unit, box" class="w-full border border-slate-200 rounded-xl p-3 focus:outline-none focus:border-blue-500 text-slate-700">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block font-semibold text-slate-700 mb-1.5">Stok Saat ini</label>
                        <input type="number" value="0" class="w-full border border-slate-200 rounded-xl p-3 focus:outline-none focus:border-blue-500 text-slate-700">
                    </div>
                    <div>
                        <label class="block font-semibold text-slate-700 mb-1.5">Stok Minimum</label>
                        <input type="number" value="0" class="w-full border border-slate-200 rounded-xl p-3 focus:outline-none focus:border-blue-500 text-slate-700">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="relative">
                        <label class="block font-semibold text-slate-700 mb-1.5">Kondisi</label>
                        <select class="w-full appearance-none bg-white border border-slate-200 p-3 rounded-xl focus:outline-none focus:border-blue-500 text-slate-600 cursor-pointer">
                            <option value="" disabled selected>Pilih Kondisi</option>
                            <option>Baik</option>
                            <option>Rusak Ringan</option>
                            <option>Rusak Berat</option>
                        </select>
                        <i class="fa-solid fa-chevron-down absolute right-4 bottom-4 text-[10px] text-slate-400 pointer-events-none"></i>
                    </div>
                    <div>
                        <label class="block font-semibold text-slate-700 mb-1.5">Lokasi</label>
                        <input type="text" placeholder="Masukkan lokasi penyimpanan" class="w-full border border-slate-200 rounded-xl p-3 focus:outline-none focus:border-blue-500 text-slate-700">
                    </div>
                </div>
                
                <div class="flex justify-end gap-2 pt-4 border-t border-slate-100">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2.5 rounded-xl transition shadow-sm">Tambah Barang</button>
                    <button type="button" onclick="toggleModal('modal-tambah-barang')" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold px-5 py-2.5 rounded-xl transition">Batal</button>
                </div>
            </form>
        </div>
    </div>

    <div id="modal-edit-barang" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-center justify-center hidden opacity-0 transition-opacity duration-300">
        <div class="bg-white rounded-2xl w-full max-w-xl shadow-xl overflow-hidden transform scale-95 transition-transform duration-300 p-6 space-y-5">
            <div>
                <h3 class="text-lg font-bold text-slate-900">Edit Barang</h3>
            </div>
            
            <form action="#" method="POST" class="space-y-4 text-xs">
                @csrf
                @method('PUT')
                <div>
                    <label class="block font-semibold text-slate-700 mb-1.5">Kode Barang</label>
                    <input type="text" value="BRG-001" class="w-full bg-slate-100 border border-slate-200 rounded-xl p-3 text-slate-400 focus:outline-none cursor-not-allowed" readonly>
                </div>
                <div>
                    <label class="block font-semibold text-slate-700 mb-1.5">Nama Barang</label>
                    <input type="text" value="Meja" class="w-full border border-slate-200 rounded-xl p-3 focus:outline-none focus:border-blue-500 text-slate-700 font-medium">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="relative">
                        <label class="block font-semibold text-slate-700 mb-1.5">Kategori</label>
                        <select class="w-full appearance-none bg-white border border-slate-200 p-3 rounded-xl focus:outline-none focus:border-blue-500 text-slate-700 font-medium cursor-pointer">
                            <option selected>Furnitur</option>
                            <option>Multimedia</option>
                            <option>Jaringan</option>
                            <option>Elektronik</option>
                        </select>
                        <i class="fa-solid fa-chevron-down absolute right-4 bottom-4 text-[10px] text-slate-400 pointer-events-none"></i>
                    </div>
                    <div>
                        <label class="block font-semibold text-slate-700 mb-1.5">Satuan</label>
                        <input type="text" value="PCS" class="w-full border border-slate-200 rounded-xl p-3 focus:outline-none focus:border-blue-500 text-slate-700 font-medium">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block font-semibold text-slate-700 mb-1.5">Stok Saat ini</label>
                        <input type="number" value="45" class="w-full border border-slate-200 rounded-xl p-3 focus:outline-none focus:border-blue-500 text-slate-700 font-medium">
                    </div>
                    <div>
                        <label class="block font-semibold text-slate-700 mb-1.5">Stok Minimum</label>
                        <input type="number" value="10" class="w-full border border-slate-200 rounded-xl p-3 focus:outline-none focus:border-blue-500 text-slate-700 font-medium">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div class="relative">
                        <label class="block font-semibold text-slate-700 mb-1.5">Kondisi</label>
                        <select class="w-full appearance-none bg-white border border-slate-200 p-3 rounded-xl focus:outline-none focus:border-blue-500 text-slate-700 font-medium cursor-pointer">
                            <option selected>Baik</option>
                            <option>Rusak Ringan</option>
                            <option>Rusak Berat</option>
                        </select>
                        <i class="fa-solid fa-chevron-down absolute right-4 bottom-4 text-[10px] text-slate-400 pointer-events-none"></i>
                    </div>
                    <div>
                        <label class="block font-semibold text-slate-700 mb-1.5">Lokasi</label>
                        <input type="text" value="Workshop" class="w-full border border-slate-200 rounded-xl p-3 focus:outline-none focus:border-blue-500 text-slate-700 font-medium">
                    </div>
                </div>
                
                <div class="flex justify-end gap-2 pt-4 border-t border-slate-100">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2.5 rounded-xl transition shadow-sm">Simpan perubahan</button>
                    <button type="button" onclick="toggleModal('modal-edit-barang')" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold px-5 py-2.5 rounded-xl transition">Batal</button>
                </div>
            </form>
        </div>
    </div>

    <div id="modal-mutasi-stok" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-center justify-center hidden opacity-0 transition-opacity duration-300">
        <div class="bg-white rounded-2xl w-full max-w-md shadow-xl overflow-hidden transform scale-95 transition-transform duration-300 p-6 space-y-5">
            <div>
                <h3 class="text-base font-bold text-slate-900">Mutasi Stok</h3>
                <p class="text-slate-400 text-[11px] mt-0.5">Meja (BRG-001)</p>
            </div>
            
            <form action="#" method="POST" class="space-y-4 text-xs">
                @csrf
                <div>
                    <label class="block font-semibold text-slate-400 mb-1.5">Stok saat ini</label>
                    <div class="w-full bg-slate-50 border border-slate-100 rounded-xl p-3 flex justify-between font-bold text-slate-700">
                        <span></span>
                        <span>45 <span class="text-slate-400 font-medium">Meja</span></span>
                    </div>
                </div>

                <div>
                    <label class="block font-semibold text-slate-700 mb-2">Tipe Mutasi <span class="text-rose-500">*</span></label>
                    <div class="grid grid-cols-2 gap-3">
                        <label class="border-2 border-emerald-500 bg-emerald-50/30 rounded-xl p-3.5 flex items-center justify-center gap-2 cursor-pointer font-bold text-emerald-600 transition">
                            <input type="radio" name="tipe_mutasi" value="masuk" class="hidden" checked>
                            <i class="fa-solid fa-arrow-down text-sm"></i> Stok Masuk
                        </label>
                        <label class="border border-slate-200 hover:border-slate-300 rounded-xl p-3.5 flex items-center justify-center gap-2 cursor-pointer font-semibold text-slate-600 transition">
                            <input type="radio" name="tipe_mutasi" value="keluar" class="hidden">
                            <i class="fa-solid fa-arrow-up text-sm"></i> Stok Keluar
                        </label>
                    </div>
                </div>

                <div>
                    <label class="block font-semibold text-slate-700 mb-1.5">Jumlah <span class="text-rose-500">*</span></label>
                    <div class="relative">
                        <input type="number" placeholder="Masukan jumlah" class="w-full border border-slate-200 rounded-xl p-3 pr-12 focus:outline-none focus:border-blue-500 text-slate-700">
                        <span class="absolute right-4 top-3.5 text-slate-800 font-bold">Meja</span>
                    </div>
                </div>

                <div>
                    <label class="block font-semibold text-slate-700 mb-1.5">Keterangan <span class="text-rose-500">*</span></label>
                    <textarea rows="3" placeholder="Contoh : Penambahna meja karen meja pada rusak" class="w-full border border-slate-200 rounded-xl p-3 focus:outline-none focus:border-blue-500 text-slate-600 placeholder-slate-400 resize-none"></textarea>
                    <div class="text-right text-[10px] text-slate-400 mt-1">0/500</div>
                </div>
                
                <div class="flex justify-end gap-2 pt-2">
                    <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-5 py-2.5 rounded-xl transition shadow-sm flex items-center gap-1.5">Tambah Stok</button>
                    <button type="button" onclick="toggleModal('modal-mutasi-stok')" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold px-5 py-2.5 rounded-xl transition">Batal</button>
                </div>
            </form>
        </div>
    </div>

    <div id="modal-detail-baik" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-center justify-center hidden opacity-0 transition-opacity duration-300">
        <div class="bg-white rounded-2xl w-full max-w-xl shadow-xl overflow-hidden transform scale-95 transition-transform duration-300 p-6 space-y-5">
            <div class="flex justify-between items-start border-b border-slate-50 pb-2">
                <div>
                    <span class="text-[10px] font-bold text-slate-400 block uppercase tracking-wider">Code Barang</span>
                    <h3 class="text-base font-bold text-slate-900">BRG-001</h3>
                </div>
            </div>

            <div class="space-y-1">
                <h2 class="text-xl font-bold text-slate-900">Meja</h2>
                <div class="flex gap-2 pt-1">
                    <span class="px-2 py-0.5 bg-slate-100 rounded text-slate-600 font-medium text-[11px]">Furnitur</span>
                    <span class="px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-600 text-[10px] font-bold flex items-center gap-1"><span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>Baik</span>
                </div>
            </div>

            <div class="bg-slate-50/50 border border-slate-100 rounded-2xl p-5">
                <h4 class="text-xs font-bold text-slate-800 tracking-wide mb-4">Informasi Stok</h4>
                <div class="grid grid-cols-4 gap-4 text-xs">
                    <div>
                        <span class="text-slate-400 block mb-1">Stok Saat Ini</span>
                        <span class="text-base font-bold text-slate-800">45</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block mb-1">Stok Minimum</span>
                        <span class="text-base font-bold text-slate-800">10</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block mb-1">Status Stok</span>
                        <span class="text-base font-bold text-emerald-600">Aman</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block mb-1">Terakhir Restock</span>
                        <span class="text-sm font-semibold text-slate-800 whitespace-nowrap">28 Mei 2026</span>
                    </div>
                </div>
            </div>

            <div class="space-y-3">
                <h4 class="text-xs font-bold text-slate-800 tracking-wide">Detail Barang</h4>
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-slate-50/50 border border-slate-100 rounded-xl p-4 flex flex-col gap-1">
                        <span class="text-slate-400 text-xs">Lokasi Penyimpanan</span>
                        <span class="text-xs font-bold text-slate-800 flex items-center gap-1.5 mt-1"><i class="fa-solid fa-location-dot text-slate-400"></i> Workshop</span>
                    </div>
                    <div class="bg-slate-50/50 border border-slate-100 rounded-xl p-4 flex flex-col gap-1">
                        <span class="text-slate-400 text-xs">Satuan</span>
                        <span class="text-xs font-bold text-slate-800 mt-1">PCS</span>
                    </div>
                </div>
                <div class="bg-slate-50/50 border border-slate-100 rounded-xl p-4 flex flex-col gap-1">
                    <span class="text-slate-400 text-xs">Kategori</span>
                    <span class="text-xs font-bold text-slate-800 mt-1">Furnitur</span>
                </div>
            </div>

            <div class="flex justify-end pt-2">
                <button onclick="toggleModal('modal-detail-baik')" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold px-6 py-2.5 rounded-xl transition text-xs">Tutup</button>
            </div>
        </div>
    </div>

    <div id="modal-detail-kritis" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-center justify-center hidden opacity-0 transition-opacity duration-300">
        <div class="bg-white rounded-2xl w-full max-w-xl shadow-xl overflow-hidden transform scale-95 transition-transform duration-300 p-6 space-y-5">
            <div class="flex justify-between items-start border-b border-slate-50 pb-2">
                <div>
                    <span class="text-[10px] font-bold text-slate-400 block uppercase tracking-wider">Code Barang</span>
                    <h3 class="text-base font-bold text-slate-900">BRG-003</h3>
                </div>
            </div>

            <div class="space-y-1">
                <h2 class="text-xl font-bold text-slate-900">Komputer Lab</h2>
                <div class="flex gap-2 pt-1">
                    <span class="px-2 py-0.5 bg-slate-100 rounded text-slate-600 font-medium text-[11px]">Elektronik</span>
                    <span class="px-2 py-0.5 rounded-full bg-rose-50 text-rose-600 text-[10px] font-bold flex items-center gap-1"><span class="w-1.5 h-1.5 bg-rose-500 rounded-full"></span>Rusak Berat</span>
                </div>
            </div>

            <div class="bg-slate-50/50 border border-slate-100 rounded-2xl p-5 space-y-4">
                <h4 class="text-xs font-bold text-slate-800 tracking-wide">Informasi Stok</h4>
                <div class="grid grid-cols-4 gap-4 text-xs">
                    <div>
                        <span class="text-slate-400 block mb-1">Stok Saat Ini</span>
                        <span class="text-base font-bold text-rose-600">0</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block mb-1">Stok Minimum</span>
                        <span class="text-base font-bold text-slate-800">15</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block mb-1">Status Stok</span>
                        <span class="text-base font-bold text-rose-600">Stok Rendah</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block mb-1">Terakhir Restock</span>
                        <span class="text-sm font-semibold text-slate-800 whitespace-nowrap">28 Mei 2026</span>
                    </div>
                </div>
                <div class="bg-amber-50/60 border border-amber-100 rounded-xl p-3 flex items-center gap-2 text-amber-700 text-xs font-medium">
                    <i class="fa-regular fa-bell text-sm text-amber-500"></i>
                    <span>Stok di bawah batas minimum (15 pcs)</span>
                </div>
            </div>

            <div class="space-y-3">
                <h4 class="text-xs font-bold text-slate-800 tracking-wide">Detail Barang</h4>
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-slate-50/50 border border-slate-100 rounded-xl p-4 flex flex-col gap-1">
                        <span class="text-slate-400 text-xs">Lokasi Penyimpanan</span>
                        <span class="text-xs font-bold text-slate-800 flex items-center gap-1.5 mt-1"><i class="fa-solid fa-location-dot text-slate-400"></i> Workshop</span>
                    </div>
                    <div class="bg-slate-50/50 border border-slate-100 rounded-xl p-4 flex flex-col gap-1">
                        <span class="text-slate-400 text-xs">Satuan</span>
                        <span class="text-xs font-bold text-slate-800 mt-1">Unit</span>
                    </div>
                </div>
                <div class="bg-slate-50/50 border border-slate-100 rounded-xl p-4 flex flex-col gap-1">
                    <span class="text-slate-400 text-xs">Kategori</span>
                    <span class="text-xs font-bold text-slate-800 mt-1">Elektronik</span>
                </div>
            </div>

            <div class="flex justify-end pt-2">
                <button onclick="toggleModal('modal-detail-kritis')" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold px-6 py-2.5 rounded-xl transition text-xs">Tutup</button>
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
</body>
</html>
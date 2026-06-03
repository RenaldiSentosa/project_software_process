<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $pageTitle ?? 'IPWIJA SmartLab - Manajemen Alat' }}</title>
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
                <a href="{{ route('admin.manajemen_alat') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-semibold rounded-lg bg-blue-50 text-blue-600 transition">
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
                    {{ substr(Auth::user()->name ?? 'Sandy Aryadi', 0, 1) }}
                </div>
                <div class="text-right">
                    <h4 class="text-sm font-semibold text-slate-800 leading-none">{{ Auth::user()->name ?? 'Sandy Aryadi' }}</h4>
                    <p class="text-xs text-slate-500 font-medium mt-1">{{ Auth::user()->role ?? 'Admin Lab' }}</p>
                </div>
                <i class="fa-solid fa-chevron-down text-xs text-slate-400 ml-1"></i>
            </div>
        </header>

        <main class="p-8 space-y-6 flex-1 max-w-7xl w-full mx-auto">
            
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
        </main>
    </div>

    <div id="modal-tambah" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-center justify-center hidden opacity-0 transition-opacity duration-300">
        <div class="bg-white rounded-2xl w-full max-w-lg shadow-xl overflow-hidden transform scale-95 transition-transform duration-300">
            <div class="p-6 border-b border-slate-100 flex justify-between items-center">
                <h3 class="text-base font-bold text-slate-800">Tambah Alat Baru</h3>
                <button onclick="toggleModal('modal-tambah')" class="text-slate-400 hover:text-slate-600"><i class="fa-solid fa-xmark text-sm"></i></button>
            </div>
            <form action="#" method="POST" class="p-6 space-y-4 text-xs">
                @csrf
                <div>
                    <label class="block font-semibold text-slate-700 mb-1.5">Kode Alat</label>
                    <input type="text" name="kode_alat" placeholder="ALT-XXX" class="w-full border border-slate-200 rounded-lg p-2.5 focus:outline-none focus:border-blue-500 text-slate-600 bg-slate-50/50">
                </div>
                <div>
                    <label class="block font-semibold text-slate-700 mb-1.5">Nama Alat</label>
                    <input type="text" name="nama_alat" class="w-full border border-slate-200 rounded-lg p-2.5 focus:outline-none focus:border-blue-500 text-slate-600">
                </div>
                <div>
                    <label class="block font-semibold text-slate-700 mb-1.5">Kategori</label>
                    <div class="relative">
                        <select name="kategori" class="w-full border border-slate-200 rounded-lg p-2.5 focus:outline-none focus:border-blue-500 text-slate-600 appearance-none bg-white cursor-pointer">
                            <option value="">Pilih Kategori</option>
                            <option value="Network">Network</option>
                            <option value="Hardware">Hardware</option>
                            <option value="IoT">IoT</option>
                        </select>
                        <i class="fa-solid fa-chevron-down absolute right-3 top-3.5 text-slate-400 pointer-events-none"></i>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block font-semibold text-slate-700 mb-1.5">Stok Total</label>
                        <input type="number" name="stok_total" class="w-full border border-slate-200 rounded-lg p-2.5 focus:outline-none focus:border-blue-500 text-slate-600">
                    </div>
                    <div>
                        <label class="block font-semibold text-slate-700 mb-1.5">Tersedia</label>
                        <input type="number" name="tersedia" class="w-full border border-slate-200 rounded-lg p-2.5 focus:outline-none focus:border-blue-500 text-slate-600">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block font-semibold text-slate-700 mb-1.5">Status</label>
                        <div class="relative">
                            <select name="status" class="w-full border border-slate-200 rounded-lg p-2.5 focus:outline-none focus:border-blue-500 text-slate-600 appearance-none bg-white cursor-pointer">
                                <option value="Tersedia">Tersedia</option>
                                <option value="Dipinjam">Dipinjam</option>
                                <option value="Rusak">Rusak</option>
                                <option value="Dalam Perbaikan">Dalam Perbaikan</option>
                            </select>
                            <i class="fa-solid fa-chevron-down absolute right-3 top-3.5 text-slate-400 pointer-events-none"></i>
                        </div>
                    </div>
                    <div>
                        <label class="block font-semibold text-slate-700 mb-1.5">Lokasi</label>
                        <input type="text" name="lokasi" class="w-full border border-slate-200 rounded-lg p-2.5 focus:outline-none focus:border-blue-500 text-slate-600">
                    </div>
                </div>
                <div>
                    <label class="block font-semibold text-slate-700 mb-1.5">Terakhir Maintenance</label>
                    <input type="date" name="terakhir_maintenance" class="w-full border border-slate-200 rounded-lg p-2.5 focus:outline-none focus:border-blue-500 text-slate-400">
                </div>
                <div class="flex justify-end gap-2 pt-4 border-t border-slate-100">
                    <button type="button" onclick="toggleModal('modal-tambah')" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold px-4 py-2 rounded-lg transition">Batal</button>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-4 py-2 rounded-lg transition shadow-sm">Tambah Alat</button>
                </div>
            </form>
        </div>
    </div>

    <div id="modal-detail" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-center justify-center hidden opacity-0 transition-opacity duration-300">
        <div class="bg-white rounded-2xl w-full max-w-lg shadow-xl overflow-hidden transform scale-95 transition-transform duration-300">
            <div class="p-6 space-y-5">
                <div>
                    <span class="text-[11px] font-bold text-slate-400 tracking-wider block uppercase">ALT-001</span>
                    <h3 class="text-xl font-bold text-slate-900 mt-0.5">Router zxz</h3>
                </div>
                <div class="flex gap-2">
                    <span class="px-2.5 py-0.5 bg-slate-100 text-slate-600 text-[11px] font-semibold rounded-md">Network</span>
                    <span class="px-2.5 py-0.5 bg-purple-50 text-purple-600 text-[11px] font-bold rounded-md flex items-center gap-1.5">
                        <span class="w-1.5 h-1.5 bg-purple-500 rounded-full"></span>
                        Dipinjam
                    </span>
                </div>
                
                <div class="bg-slate-50/70 border border-slate-100 rounded-xl p-4 grid grid-cols-3 gap-4 text-center">
                    <div>
                        <span class="text-[11px] font-medium text-slate-400 block">Stok Total</span>
                        <span class="text-lg font-bold text-slate-800 mt-1 block">5</span>
                    </div>
                    <div>
                        <span class="text-[11px] font-medium text-slate-400 block">Tersedia</span>
                        <span class="text-lg font-bold text-slate-800 mt-1 block">2</span>
                    </div>
                    <div>
                        <span class="text-[11px] font-medium text-slate-400 block">Dipinjam</span>
                        <span class="text-lg font-bold text-slate-800 mt-1 block">3</span>
                    </div>
                </div>

                <div class="space-y-3.5 text-xs">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 bg-sky-100 text-sky-600 rounded-xl flex items-center justify-center text-sm"><i class="fa-solid fa-location-dot"></i></div>
                        <div>
                            <span class="text-[10px] font-medium text-slate-400 block">Lokasi</span>
                            <span class="font-semibold text-slate-800">Workshop</span>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 bg-purple-100 text-purple-600 rounded-xl flex items-center justify-center text-sm"><i class="fa-regular fa-calendar-check"></i></div>
                        <div>
                            <span class="text-[10px] font-medium text-slate-400 block">Terakhir Maintenance</span>
                            <span class="font-semibold text-slate-800">10 Mei 2026</span>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-9 h-9 bg-slate-100 text-slate-500 rounded-xl flex items-center justify-center text-sm flex-shrink-0"><i class="fa-solid fa-align-left"></i></div>
                        <div>
                            <span class="text-[10px] font-medium text-slate-400 block">Deskripsi</span>
                            <p class="font-medium text-slate-600 mt-0.5 leading-relaxed">Digunak untuk praktek blablabla</p>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end pt-4 border-t border-slate-100">
                    <button onclick="toggleModal('modal-detail')" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold px-5 py-2 rounded-lg transition text-xs">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <div id="modal-edit" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-center justify-center hidden opacity-0 transition-opacity duration-300">
        <div class="bg-white rounded-2xl w-full max-w-lg shadow-xl overflow-hidden transform scale-95 transition-transform duration-300">
            <div class="p-6 border-b border-slate-100 flex justify-between items-center">
                <h3 class="text-base font-bold text-slate-800">Edit Alat</h3>
                <button onclick="toggleModal('modal-edit')" class="text-slate-400 hover:text-slate-600"><i class="fa-solid fa-xmark text-sm"></i></button>
            </div>
            <form action="#" method="POST" class="p-6 space-y-4 text-xs">
                @csrf
                @method('PUT')
                <div>
                    <label class="block font-semibold text-slate-700 mb-1.5">Kode Alat</label>
                    <input type="text" value="ALT-001" disabled class="w-full border border-slate-200 rounded-lg p-2.5 text-slate-400 bg-slate-100 cursor-not-allowed">
                </div>
                <div>
                    <label class="block font-semibold text-slate-700 mb-1.5">Nama Alat</label>
                    <input type="text" name="nama_alat" value="Router" class="w-full border border-slate-200 rounded-lg p-2.5 focus:outline-none focus:border-blue-500 text-slate-600">
                </div>
                <div>
                    <label class="block font-semibold text-slate-700 mb-1.5">Kategori</label>
                    <div class="relative">
                        <select name="kategori" class="w-full border border-slate-200 rounded-lg p-2.5 focus:outline-none focus:border-blue-500 text-slate-600 appearance-none bg-white cursor-pointer">
                            <option value="Network" selected>Network</option>
                            <option value="Hardware">Hardware</option>
                            <option value="IoT">IoT</option>
                        </select>
                        <i class="fa-solid fa-chevron-down absolute right-3 top-3.5 text-slate-400 pointer-events-none"></i>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block font-semibold text-slate-700 mb-1.5">Stok Total</label>
                        <input type="number" name="stok_total" value="5" class="w-full border border-slate-200 rounded-lg p-2.5 focus:outline-none focus:border-blue-500 text-slate-600">
                    </div>
                    <div>
                        <label class="block font-semibold text-slate-700 mb-1.5">Tersedia</label>
                        <input type="number" name="tersedia" value="2" class="w-full border border-slate-200 rounded-lg p-2.5 focus:outline-none focus:border-blue-500 text-slate-600">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block font-semibold text-slate-700 mb-1.5">Status</label>
                        <div class="relative">
                            <select name="status" class="w-full border border-slate-200 rounded-lg p-2.5 focus:outline-none focus:border-blue-500 text-slate-600 appearance-none bg-white cursor-pointer">
                                <option value="Tersedia">Tersedia</option>
                                <option value="Dipinjam" selected>Dipinjam</option>
                                <option value="Rusak">Rusak</option>
                                <option value="Dalam Perbaikan">Dalam Perbaikan</option>
                            </select>
                            <i class="fa-solid fa-chevron-down absolute right-3 top-3.5 text-slate-400 pointer-events-none"></i>
                        </div>
                    </div>
                    <div>
                        <label class="block font-semibold text-slate-700 mb-1.5">Lokasi</label>
                        <input type="text" name="lokasi" value="Workshop" class="w-full border border-slate-200 rounded-lg p-2.5 focus:outline-none focus:border-blue-500 text-slate-600">
                    </div>
                </div>
                <div>
                    <label class="block font-semibold text-slate-700 mb-1.5">Terakhir Maintenance</label>
                    <input type="text" name="terakhir_maintenance" value="10 Mei 2026" class="w-full border border-slate-200 rounded-lg p-2.5 focus:outline-none focus:border-blue-500 text-slate-600">
                </div>
                <div class="flex justify-end gap-2 pt-4 border-t border-slate-100">
                    <button type="button" onclick="toggleModal('modal-edit')" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold px-4 py-2 rounded-lg transition">Batal</button>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-4 py-2 rounded-lg transition shadow-sm">Simpan perubahan</button>
                </div>
            </form>
        </div>
    </div>

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
</body>
</html>
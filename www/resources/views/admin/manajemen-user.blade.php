<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $pageTitle ?? 'IPWIJA SmartLab - Manajemen User' }}</title>
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
                <a href="{{ route('admin.audit_trail') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-lg text-slate-500 hover:bg-slate-50 hover:text-slate-800 transition">
                    <i class="fa-solid fa-shield-halved text-base w-5 text-center"></i>
                    <span>Audit Trail</span>
                </a>
                <a href="{{ route('admin.manajemen_user') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-semibold rounded-lg bg-blue-50 text-blue-600 transition">
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
        </main>
    </div>

    <div id="modal-user-aktif" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-center justify-center hidden opacity-0 transition-opacity duration-300 p-4">
        <div class="bg-white rounded-2xl w-full max-w-lg shadow-xl overflow-hidden transform scale-95 transition-transform duration-300 p-6 space-y-4">
            <div class="border-b border-slate-100 pb-3 flex justify-between items-center">
                <h3 class="text-base font-bold text-slate-900">Detail Akun Pengguna</h3>
                <span class="px-2.5 py-0.5 rounded-full bg-emerald-50 text-emerald-600 text-[10px] font-bold flex items-center gap-1"><span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>Aktif</span>
            </div>
            
            <div class="grid grid-cols-3 gap-y-3.5 text-xs">
                <div class="text-slate-400">No Identitas</div>
                <div class="col-span-2 text-slate-800 font-semibold font-mono">202301110011</div>
                
                <div class="text-slate-400">Nama Lengkap</div>
                <div class="col-span-2 text-slate-800 font-bold">Muhamad Aprijal</div>
                
                <div class="text-slate-400">Alamat Email</div>
                <div class="col-span-2 text-slate-800 font-medium">aprijal@student.ipwija.ac.id</div>
                
                <div class="text-slate-400">Program Studi</div>
                <div class="col-span-2 text-slate-800 font-semibold">Teknik Informatika</div>
                
                <div class="text-slate-400">Peran Akses</div>
                <div class="col-span-2">
                    <span class="px-2.5 py-0.5 rounded-full bg-purple-50 text-purple-600 text-[10px] font-bold">MAHASISWA</span>
                </div>
                
                <div class="text-slate-400">Dibuat Pada</div>
                <div class="col-span-2 text-slate-500">12 Januari 2026, 10:22</div>
            </div>
            
            <div class="flex justify-end pt-3 border-t border-slate-100 gap-2">
                <button class="bg-amber-500 hover:bg-amber-600 text-white font-semibold px-4 py-2 rounded-xl text-xs transition shadow-sm flex items-center gap-1.5">
                    <i class="fa-regular fa-pen-to-square"></i> Ubah Akun
                </button>
                <button onclick="toggleModal('modal-user-aktif')" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold px-4 py-2 rounded-xl text-xs transition">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <div id="modal-user-nonaktif" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-center justify-center hidden opacity-0 transition-opacity duration-300 p-4">
        <div class="bg-white rounded-2xl w-full max-w-lg shadow-xl overflow-hidden transform scale-95 transition-transform duration-300 p-6 space-y-4">
            <div class="border-b border-slate-100 pb-3 flex justify-between items-center">
                <h3 class="text-base font-bold text-slate-900">Detail Akun Pengguna</h3>
                <span class="px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-500 text-[10px] font-bold flex items-center gap-1"><span class="w-1.5 h-1.5 bg-slate-400 rounded-full"></span>Nonaktif</span>
            </div>
            
            <div class="grid grid-cols-3 gap-y-3.5 text-xs">
                <div class="text-slate-400">No Identitas</div>
                <div class="col-span-2 text-slate-800 font-semibold font-mono">202301110099</div>
                
                <div class="text-slate-400">Nama Lengkap</div>
                <div class="col-span-2 text-slate-800 font-bold">Rachmad Taufik</div>
                
                <div class="text-slate-400">Alamat Email</div>
                <div class="col-span-2 text-slate-800 font-medium">rachmad@student.ipwija.ac.id</div>
                
                <div class="text-slate-400">Program Studi</div>
                <div class="col-span-2 text-slate-800 font-semibold">Sistem Informasi</div>
                
                <div class="text-slate-400">Peran Akses</div>
                <div class="col-span-2">
                    <span class="px-2.5 py-0.5 rounded-full bg-purple-50 text-purple-600 text-[10px] font-bold">MAHASISWA</span>
                </div>
                
                <div class="text-slate-400">Dibuat Pada</div>
                <div class="col-span-2 text-slate-500">15 Februari 2026, 08:45</div>
            </div>
            
            <div class="flex justify-end pt-3 border-t border-slate-100 gap-2">
                <button class="bg-amber-500 hover:bg-amber-600 text-white font-semibold px-4 py-2 rounded-xl text-xs transition shadow-sm flex items-center gap-1.5">
                    <i class="fa-regular fa-pen-to-square"></i> Ubah Akun
                </button>
                <button onclick="toggleModal('modal-user-nonaktif')" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold px-4 py-2 rounded-xl text-xs transition">
                    Tutup
                </button>
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

        // Menutup modal secara otomatis saat pengguna mengklik luar area box kontainer modal
        window.onclick = function(event) {
            if (event.target.attributes.id && event.target.attributes.id.value.startsWith('modal-')) {
                toggleModal(event.target.id);
            }
        }
    </script>
</body>
</html>
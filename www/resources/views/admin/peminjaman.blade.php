@extends('layouts.admin')

@section('title', 'Peminjaman Admin - IPWIJA SmartLab')
@section('page-header', 'Peminjaman Admin')

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
@endsection

@section('scripts')
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
@endsection

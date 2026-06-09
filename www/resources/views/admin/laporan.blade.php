@extends('layouts.admin')

@section('title', 'Laporan - IPWIJA SmartLab')
@section('page-header', 'Laporan')

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

        // Menutup modal ketika pengguna mengeklik area luar (backdrop) kosong
        window.onclick = function(event) {
            if (event.target.attributes.id && event.target.attributes.id.value.startsWith('modal-')) {
                toggleModal(event.target.id);
            }
        }
</script>
@endsection

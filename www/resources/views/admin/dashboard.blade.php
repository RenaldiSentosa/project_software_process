@extends('layouts.admin')

@section('title', 'Dashboard Admin - IPWIJA SmartLab')

@section('styles')
<style>
body {
            font-family: 'Inter', sans-serif;
            background-color: #F8FAFC;
        }
        /* Custom scrollbar soft effect */
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
            
            <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm flex items-center gap-4 mb-5">
                <div class="w-12 h-12 rounded-full bg-blue-100 text-blue-700 text-lg font-bold flex items-center justify-center flex-shrink-0">
                    {{ strtoupper(substr(Auth::user()->nama_lengkap ?? Auth::user()->name ?? 'A', 0, 1)) }}
                </div>
                <div>
                    <h2 class="text-xl font-bold text-slate-900 tracking-tight">Halo, {{ Auth::user()->nama_lengkap ?? Auth::user()->name ?? 'Admin' }}!</h2>
                    <p class="text-slate-500 text-sm mt-0.5">Selamat datang di pusat manajemen laboratorium Universitas IPWIJA.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-5">
                <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex justify-between items-start">
                    <div class="space-y-2">
                        <span class="text-xs font-semibold text-slate-400 tracking-wider uppercase block">Total Alat</span>
                        <span class="text-3xl font-bold text-slate-900 block">{{ $totalAlat ?? '342' }}</span>
                        <span class="text-xs text-blue-600 font-medium bg-blue-50 px-2 py-0.5 rounded-full inline-block">{{ $alatBaruBulanIni > 0 ? '+' . $alatBaruBulanIni : '0' }} bulan ini</span>
                    </div>
                    <div class="w-10 h-10 bg-blue-50 rounded-lg flex items-center justify-center text-blue-600">
                        <i class="fa-solid fa-wrench text-sm"></i>
                    </div>
                </div>
                <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex justify-between items-start">
                    <div class="space-y-2">
                        <span class="text-xs font-semibold text-slate-400 tracking-wider uppercase block">Peminjaman Aktif</span>
                        <span class="text-3xl font-bold text-slate-900 block">{{ $peminjamanAktif ?? '58' }}</span>
                        <span class="text-xs text-emerald-600 font-medium bg-emerald-50 px-2 py-0.5 rounded-full inline-block">{{ $peminjamanBulanIni > 0 ? '+' . $peminjamanBulanIni : '0' }} bulan ini</span>
                    </div>
                    <div class="w-10 h-10 bg-emerald-50 rounded-lg flex items-center justify-center text-emerald-600">
                        <i class="fa-solid fa-right-left text-sm rotate-90"></i>
                    </div>
                </div>
                <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex justify-between items-start">
                    <div class="space-y-2">
                        <span class="text-xs font-semibold text-slate-400 tracking-wider uppercase block">Barang Rendah Stok</span>
                        <span class="text-3xl font-bold text-slate-900 block">{{ $rendahStok ?? '7' }}</span>
                        <span class="text-xs text-amber-600 font-semibold bg-amber-50 px-2 py-0.5 rounded-full inline-block">{{ $rendahStokBulanIni > 0 ? '+' . $rendahStokBulanIni : '0' }} bulan ini</span>
                    </div>
                    <div class="w-10 h-10 bg-amber-50 rounded-lg flex items-center justify-center text-amber-500">
                        <i class="fa-solid fa-circle-exclamation text-sm"></i>
                    </div>
                </div>
                <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex justify-between items-start">
                    <div class="space-y-2">
                        <span class="text-xs font-semibold text-slate-400 tracking-wider uppercase block">Total Mahasiswa</span>
                        <span class="text-3xl font-bold text-slate-900 block">{{ $totalMahasiswa ?? '1.247' }}</span>
                        <span class="text-xs text-indigo-600 font-medium bg-indigo-50 px-2 py-0.5 rounded-full inline-block">{{ $mahasiswaBaruBulanIni > 0 ? '+' . $mahasiswaBaruBulanIni : '0' }} bulan ini</span>
                    </div>
                    <div class="w-10 h-10 bg-indigo-50 rounded-lg flex items-center justify-center text-indigo-600">
                        <i class="fa-solid fa-user-graduate text-sm"></i>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                <div class="bg-white rounded-xl border border-slate-200 shadow-sm lg:col-span-5 flex flex-col justify-between">
                    <div>
                        <div class="p-5 border-b border-slate-100 flex justify-between items-center">
                            <h3 class="font-bold text-slate-800 text-sm">Aktivitas Terbaru</h3>
                            <a href="{{ route('admin.audit_trail') }}" class="text-xs font-semibold text-blue-600 hover:underline">Lihat Semua</a>
                        </div>
                        <div class="p-5 space-y-4 max-h-[390px] overflow-y-auto">
                            @forelse($aktivitasTerbaru ?? [] as $aktivitas)
                                <div class="flex items-start gap-4">
                                    <div class="w-8 h-8 rounded-full bg-blue-50 flex items-center justify-center text-xs font-semibold text-blue-600 flex-shrink-0">
                                        {{ strtoupper(substr($aktivitas['nama'], 0, 2)) }}
                                    </div>
                                    <div class="text-xs">
                                        <p class="font-semibold text-slate-800">{{ $aktivitas['nama'] }}</p>
                                        <p class="text-slate-500 mt-0.5">{{ $aktivitas['pesan'] }}</p>
                                        <span class="text-[10px] text-slate-400 block mt-1">{{ $aktivitas['waktu'] }}</span>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-4">
                                    <p class="text-sm text-slate-500">Belum ada aktivitas terbaru.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl border border-slate-200 shadow-sm lg:col-span-7 flex flex-col justify-between">
                    <div>
                        <div class="p-5 border-b border-slate-100 flex justify-between items-center">
                            <h3 class="font-bold text-slate-800 text-sm">Peringatan Stok Rendah</h3>
                            <a href="{{ route('admin.manajemen_barang') }}" class="text-xs font-semibold text-blue-600 hover:underline">Kelola Stok</a>
                        </div>
                        <div class="p-5 space-y-[15px]">
                            @forelse($stokRendahList ?? [] as $barang)
                                <div>
                                    <div class="flex justify-between items-start text-xs mb-1">
                                        <div>
                                            <div class="flex items-center gap-2">
                                                <span class="font-semibold text-slate-800">{{ $barang['nama'] }}</span>
                                                <span class="bg-slate-100 text-slate-500 px-1.5 py-0.2 rounded text-[10px]">{{ $barang['kategori'] }}</span>
                                            </div>
                                            <p class="text-slate-400 text-[11px] mt-0.5">{{ $barang['lokasi'] }} &bull; {{ $barang['stok'] }} / {{ $barang['max_stok'] }} {{ $barang['satuan'] }}</p>
                                        </div>
                                        <div class="text-right">
                                            <span class="{{ $barang['persentase'] <= 20 ? 'text-rose-500' : 'text-amber-500' }} font-bold">{{ $barang['persentase'] }}%</span>
                                            <p class="text-[10px] text-slate-400">Restock</p>
                                        </div>
                                    </div>
                                    <div class="w-full bg-slate-100 h-1.5 rounded-full overflow-hidden">
                                        <div class="{{ $barang['persentase'] <= 20 ? 'bg-rose-500' : 'bg-amber-400' }} h-full rounded-full" style="width: {{ $barang['persentase'] }}%"></div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-4">
                                    <p class="text-sm text-slate-500">Semua stok alat dalam kondisi aman.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="p-5 border-b border-slate-100 flex flex-col sm:flex-row justify-between sm:items-center gap-4">
                    <h3 class="font-bold text-slate-800 text-sm">Permintaan Peminjaman Terbaru</h3>
                    <div class="flex bg-slate-100 p-0.5 rounded-lg text-xs font-medium text-slate-500">
                        <a href="?status=Semua" class="px-3 py-1.5 rounded-md {{ request('status', 'Semua') == 'Semua' ? 'bg-white text-slate-800 shadow-sm' : 'hover:text-slate-800' }}">Semua</a>
                        <a href="?status=Menunggu" class="px-3 py-1.5 rounded-md {{ request('status') == 'Menunggu' ? 'bg-white text-slate-800 shadow-sm' : 'hover:text-slate-800' }}">Menunggu</a>
                        <a href="?status=Aktif" class="px-3 py-1.5 rounded-md {{ request('status') == 'Aktif' ? 'bg-white text-slate-800 shadow-sm' : 'hover:text-slate-800' }}">Aktif</a>
                        <a href="?status=Selesai" class="px-3 py-1.5 rounded-md {{ request('status') == 'Selesai' ? 'bg-white text-slate-800 shadow-sm' : 'hover:text-slate-800' }}">Selesai</a>
                    </div>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs border-collapse">
                        <thead>
                            <tr class="bg-slate-50/70 border-b border-slate-100 text-slate-400 font-semibold uppercase tracking-wider">
                                <th class="py-4 px-6">ID</th>
                                <th class="py-4 px-6">Mahasiswa</th>
                                <th class="py-4 px-6">Jurusan</th>
                                <th class="py-4 px-6">Alat</th>
                                <th class="py-4 px-6">Tanggal</th>
                                <th class="py-4 px-6">Status</th>
                                <th class="py-4 px-6 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-700">
                            @forelse($peminjamanList ?? [] as $peminjaman)
                                <tr class="hover:bg-slate-50/50 transition">
                                    <td class="py-4 px-6 text-slate-500 font-medium">{{ $peminjaman['uid'] }}</td>
                                    <td class="py-4 px-6">
                                        <span class="font-semibold text-slate-800 block">{{ $peminjaman['mhs_nama'] }}</span>
                                        <span class="text-slate-400 text-[11px]">{{ $peminjaman['mhs_nim'] }}</span>
                                    </td>
                                    <td class="py-4 px-6 text-slate-600 font-medium">{{ $peminjaman['jurusan'] }}</td>
                                    <td class="py-4 px-6 text-slate-800 font-medium">{{ $peminjaman['alat_nama'] }}</td>
                                    <td class="py-4 px-6 text-slate-500">
                                        {{ $peminjaman['tgl_mulai'] }} <br>
                                        <span class="text-[11px] text-slate-400">s/d {{ $peminjaman['tgl_selesai'] }}</span>
                                    </td>
                                    <td class="py-4 px-6">
                                        @php
                                            $statusColors = [
                                                'Diproses' => 'bg-orange-50 text-orange-600 border-orange-100',
                                                'Disetujui' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                                'Menunggu' => 'bg-blue-50 text-blue-600 border-blue-100',
                                                'Dikembalikan' => 'bg-slate-100 text-slate-600 border-slate-200',
                                                'Ditolak' => 'bg-rose-50 text-rose-600 border-rose-100',
                                            ];
                                            $colorClass = $statusColors[$peminjaman['status']] ?? 'bg-slate-50 text-slate-600';
                                        @endphp
                                        <span class="px-2 py-1 text-[10px] font-bold rounded border {{ $colorClass }}">{{ $peminjaman['status'] }}</span>
                                    </td>
                                    <td class="py-4 px-6 text-center">
                                        <a href="{{ route('admin.peminjaman') }}" class="text-slate-400 hover:text-slate-600"><i class="fa-regular fa-eye text-sm"></i></a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="py-6 px-6 text-center text-slate-500 font-medium">Belum ada permintaan peminjaman baru.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="p-5 border-b border-slate-100 flex flex-col sm:flex-row justify-between sm:items-center gap-4">
                    <h3 class="font-bold text-slate-800 text-sm">Aksi Cepat</h3>
                </div>
                <div class="p-5">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                        <a href="{{ route('admin.manajemen_barang') }}" class="bg-emerald-50 border border-emerald-100 hover:border-emerald-200 text-slate-800 font-bold p-6 rounded-xl flex items-center justify-center gap-4 transition shadow-sm group cursor-pointer block">
                            <div class="w-10 h-10 bg-white rounded-lg border border-emerald-100 flex items-center justify-center text-emerald-600 group-hover:scale-110 transition-transform">
                                <i class="fa-solid fa-box text-base"></i>
                            </div>
                            <span class="text-sm">Tambah Barang</span>
                        </a>
                        <a href="{{ route('admin.laporan') }}" class="bg-indigo-50 border border-indigo-100 hover:border-indigo-200 text-slate-800 font-bold p-6 rounded-xl flex items-center justify-center gap-4 transition shadow-sm group cursor-pointer block">
                            <div class="w-10 h-10 bg-white rounded-lg border border-indigo-100 flex items-center justify-center text-indigo-600 group-hover:scale-110 transition-transform">
                                <i class="fa-solid fa-file-invoice text-base"></i>
                            </div>
                            <span class="text-sm">Generate Laporan</span>
                        </a>
                        <a href="{{ route('admin.manajemen_user') }}" class="bg-orange-50 border border-orange-100 hover:border-orange-200 text-slate-800 font-bold p-6 rounded-xl flex items-center justify-center gap-4 transition shadow-sm group cursor-pointer block">
                            <div class="w-10 h-10 bg-white rounded-lg border border-orange-100 flex items-center justify-center text-orange-500 group-hover:scale-110 transition-transform">
                                <i class="fa-solid fa-user-gear text-base"></i>
                            </div>
                            <span class="text-sm">Kelola User</span>
                        </a>
                    </div>
                </div>
            </div>

@endsection

@section('scripts')
<script>

</script>
@endsection

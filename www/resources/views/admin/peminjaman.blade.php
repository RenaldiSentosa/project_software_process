@extends('layouts.admin')

@section('title', 'Peminjaman Admin - IPWIJA SmartLab')

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
                            @forelse($borrowings ?? [] as $borrowing)
                                <tr class="hover:bg-slate-50/50 transition">
                                    <td class="py-4 px-6 font-semibold text-slate-800">PJM-{{ str_pad($borrowing->id, 3, '0', STR_PAD_LEFT) }}</td>
                                    <td class="py-4 px-6"><span class="font-semibold text-slate-800 block">{{ $borrowing->mahasiswa->nama_lengkap ?? $borrowing->mahasiswa->name ?? 'Unknown' }}</span><span class="text-slate-400 text-[11px]">{{ $borrowing->mahasiswa->nim ?? '-' }}</span></td>
                                    <td class="py-4 px-6 font-medium text-slate-600">{{ $borrowing->mahasiswa->program_studi ?? '-' }}</td>
                                    <td class="py-4 px-6 font-medium text-slate-500">{{ \Carbon\Carbon::parse($borrowing->created_at)->translatedFormat('d M Y') }}</td>
                                    <td class="py-4 px-6 font-medium text-slate-600">{{ $borrowing->items->count() }} jenis, {{ $borrowing->items->sum('jumlah_unit') }} unit</td>
                                    <td class="py-4 px-6">
                                        @if($borrowing->status == 'Disetujui')
                                            <span class="px-2 py-0.5 rounded-full bg-blue-50 text-blue-500 text-[10px] font-bold flex items-center gap-1 w-fit"><span class="w-1 h-1 bg-blue-500 rounded-full"></span>Disetujui</span>
                                        @elseif($borrowing->status == 'Dipinjam' || $borrowing->status == 'Diproses')
                                            <span class="px-2 py-0.5 rounded-full bg-purple-50 text-purple-500 text-[10px] font-bold flex items-center gap-1 w-fit"><span class="w-1 h-1 bg-purple-500 rounded-full"></span>Dipinjam</span>
                                        @elseif($borrowing->status == 'Menunggu')
                                            <span class="px-2 py-0.5 rounded-full bg-amber-50 text-amber-600 text-[10px] font-bold flex items-center gap-1 w-fit"><span class="w-1.5 h-1.5 bg-amber-500 rounded-full"></span>Menunggu</span>
                                        @elseif($borrowing->status == 'Ditolak')
                                            <span class="px-2 py-0.5 rounded-full bg-rose-50 text-rose-600 text-[10px] font-bold flex items-center gap-1 w-fit"><span class="w-1 h-1 bg-rose-500 rounded-full"></span>Ditolak</span>
                                        @elseif($borrowing->status == 'Selesai' || $borrowing->status == 'Dikembalikan')
                                            <span class="px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-600 text-[10px] font-bold flex items-center gap-1 w-fit"><span class="w-1 h-1 bg-emerald-500 rounded-full"></span>Selesai</span>
                                        @endif
                                    </td>
                                    <td class="py-4 px-6 text-center space-x-3 flex justify-center items-center">
                                        <button onclick="toggleModal('modal-detail-{{ $borrowing->id }}')" class="text-slate-400 hover:text-slate-600" title="Lihat Detail"><i class="fa-regular fa-eye text-sm"></i></button>
                                        @if($borrowing->status == 'Menunggu')
                                            <form action="{{ route('admin.peminjaman.approve', $borrowing->id) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="text-slate-400 hover:text-blue-600" title="Setujui"><i class="fa-solid fa-check text-sm"></i></button>
                                            </form>
                                            <button type="button" onclick="openPenolakanLangsung({{ $borrowing->id }})" class="text-slate-400 hover:text-rose-600" title="Tolak"><i class="fa-solid fa-xmark text-sm"></i></button>
                                        @elseif($borrowing->status == 'Disetujui')
                                            <form action="{{ route('admin.peminjaman.borrow', $borrowing->id) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="text-slate-400 hover:text-purple-600" title="Catat Peminjaman"><i class="fa-solid fa-clipboard-check text-sm"></i></button>
                                            </form>
                                        @elseif($borrowing->status == 'Dipinjam' || $borrowing->status == 'Diproses')
                                            <form action="{{ route('admin.peminjaman.return', $borrowing->id) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="text-slate-400 hover:text-emerald-600" title="Catat Pengembalian"><i class="fa-solid fa-rotate-left text-sm"></i></button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-8 text-slate-500">Belum ada data peminjaman.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-5 border-t border-slate-100">
                    {{ $borrowings->links() }}
                </div>
            </div>

            <!-- Modals Detail Peminjaman -->
            @foreach($borrowings as $b)
            <div id="modal-detail-{{ $b->id }}" class="fixed inset-0 z-50 hidden bg-slate-900/50 backdrop-blur-sm transition-opacity opacity-0 flex items-center justify-center p-4">
                <div class="bg-white rounded-xl shadow-xl w-full max-w-lg overflow-hidden transform scale-95 transition-transform duration-300">
                    <div class="p-5 border-b border-slate-100 flex justify-between items-center bg-slate-50">
                        <h3 class="font-bold text-slate-800 text-base">Detail Peminjaman</h3>
                        <button onclick="toggleModal('modal-detail-{{ $b->id }}')" class="text-slate-400 hover:text-rose-500 transition"><i class="fa-solid fa-xmark text-lg"></i></button>
                    </div>
                    <div class="p-6">
                        <div class="mb-4">
                            <p class="text-xs text-slate-500 mb-1">Peminjam</p>
                            <p class="text-sm font-semibold text-slate-800">{{ $b->mahasiswa->nama_lengkap ?? $b->mahasiswa->name ?? '-' }} ({{ $b->mahasiswa->nim ?? '-' }})</p>
                        </div>
                        <div class="mb-4">
                            <p class="text-xs text-slate-500 mb-1">Kegiatan</p>
                            <p class="text-sm font-semibold text-slate-800">{{ $b->kegiatan }}</p>
                        </div>
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <p class="text-xs text-slate-500 mb-1">Tanggal Rencana Pinjam</p>
                                <p class="text-sm font-semibold text-slate-800">{{ \Carbon\Carbon::parse($b->tgl_rencana_pinjam)->format('d M Y') }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500 mb-1">Tanggal Rencana Kembali</p>
                                <p class="text-sm font-semibold text-slate-800">{{ \Carbon\Carbon::parse($b->tgl_rencana_kembali)->format('d M Y') }}</p>
                            </div>
                        </div>
                        <div class="mb-4">
                            <p class="text-xs text-slate-500 mb-2">Item Dipinjam:</p>
                            <ul class="list-disc list-inside text-sm font-semibold text-slate-800">
                                @foreach($b->items as $bi)
                                    <li>{{ $bi->tool->nama_alat ?? 'Alat tidak ditemukan' }} ({{ $bi->jumlah_unit }} unit)</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="flex justify-end gap-3 p-4 border-t border-slate-100 bg-slate-50">
                        @if($b->status == 'Menunggu')
                            <button type="button" onclick="openPenolakanDariDetail({{ $b->id }})" class="px-4 py-2 bg-rose-50 hover:bg-rose-100 text-rose-600 rounded-lg text-xs font-semibold transition">Tolak</button>
                        @endif
                        <button onclick="toggleModal('modal-detail-{{ $b->id }}')" class="px-4 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded-lg text-xs font-semibold transition">Tutup</button>
                    </div>
                </div>
            </div>
            @endforeach

            <!-- Modal Konfirmasi Penolakan (Global, dipakai untuk semua baris) -->
            <div id="modal-konfirmasi-penolakan" class="fixed inset-0 z-50 hidden bg-slate-900/50 backdrop-blur-sm transition-opacity opacity-0 flex items-center justify-center p-4">
                <div class="bg-white rounded-xl shadow-xl w-full max-w-md overflow-hidden transform scale-95 transition-transform duration-300">
                    <form id="form-penolakan" method="POST" action="">
                        @csrf
                        <div class="p-5 border-b border-slate-100 bg-slate-50">
                            <h3 class="font-bold text-slate-800 text-base">Konfirmasi Penolakan</h3>
                            <p class="text-xs text-slate-500 mt-1">Mohon berikan alasan penolakan peminjaman ini.</p>
                        </div>
                        <div class="p-6">
                            <label for="catatan_admin" class="block text-xs font-semibold text-slate-700 mb-2">Alasan Penolakan <span class="text-rose-500">*</span></label>
                            <textarea name="catatan_admin" id="catatan_admin" rows="4" required maxlength="1000" placeholder="Contoh: Alat tiba-tiba rusak." class="w-full border border-slate-200 rounded-lg p-3 text-xs focus:outline-none focus:border-rose-400 transition resize-none"></textarea>
                        </div>
                        <div class="flex justify-end gap-3 p-4 border-t border-slate-100 bg-slate-50">
                            <button type="submit" class="px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white rounded-lg text-xs font-semibold transition">Tolak</button>
                            <button type="button" onclick="closePenolakan()" class="px-4 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded-lg text-xs font-semibold transition">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
@endsection

@section('scripts')
<script>
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

        // Set action form penolakan ke route reject sesuai id peminjaman, lalu tampilkan modal
        function setFormPenolakanAction(borrowingId) {
            const form = document.getElementById('form-penolakan');
            form.action = `/admin/peminjaman/${borrowingId}/reject`;
            document.getElementById('catatan_admin').value = '';
        }

        // Alur pembukaan penolakan dari dalam modal detail
        function openPenolakanDariDetail(borrowingId) {
            // Sembunyikan detail peminjaman terlebih dahulu
            if (activeDetailModalId) {
                const currentDetail = document.getElementById(activeDetailModalId);
                currentDetail.classList.add('opacity-0');
                currentDetail.querySelector('div').classList.add('scale-95');
                setTimeout(() => { currentDetail.classList.add('hidden'); }, 300);
            }
            setFormPenolakanAction(borrowingId);
            // Tampilkan dialog alasan penolakan
            toggleModal('modal-konfirmasi-penolakan');
        }

        // Alur pembukaan penolakan langsung dari tombol aksi tabel utama
        function openPenolakanLangsung(borrowingId) {
            activeDetailModalId = null; 
            setFormPenolakanAction(borrowingId);
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
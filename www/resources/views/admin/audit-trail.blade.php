@extends('layouts.admin')

@section('title', 'Audit Trail - IPWIJA SmartLab')

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
                            @forelse($logs ?? [] as $log)
                            <tr class="hover:bg-slate-50/50 transition">
                                <td class="py-4 px-6 text-slate-500">{{ \Carbon\Carbon::parse($log->created_at)->translatedFormat('d M Y, H:i') }}</td>
                                <td class="py-4 px-6 text-slate-900 font-bold">{{ $log->nama_pelaku ?? 'System' }}</td>
                                <td class="py-4 px-6 text-slate-500">{{ $log->role_pelaku ?? '-' }}</td>
                                <td class="py-4 px-6 text-slate-800">{{ $log->modul }}</td>
                                <td class="py-4 px-6">
                                    @php
                                        $aksiColor = 'bg-slate-50 text-slate-600';
                                        if($log->aksi == 'CREATE') $aksiColor = 'bg-emerald-50 text-emerald-600';
                                        elseif($log->aksi == 'UPDATE') $aksiColor = 'bg-amber-50 text-amber-600';
                                        elseif($log->aksi == 'DELETE') $aksiColor = 'bg-rose-50 text-rose-600';
                                        elseif($log->aksi == 'APPROVE') $aksiColor = 'bg-blue-50 text-blue-600';
                                        elseif($log->aksi == 'REJECT') $aksiColor = 'bg-red-50 text-red-600';
                                        elseif($log->aksi == 'LOGIN') $aksiColor = 'bg-teal-50 text-teal-600';
                                        elseif($log->aksi == 'EXPORT') $aksiColor = 'bg-purple-50 text-purple-600';
                                    @endphp
                                    <span class="px-2.5 py-0.5 rounded-full {{ $aksiColor }} text-[10px] font-bold">{{ $log->aksi }}</span>
                                </td>
                                <td class="py-4 px-6 text-slate-600">{{ $log->id_record ? $log->modul . ' ID: ' . $log->id_record : '-' }}</td>
                                <td class="py-4 px-6 text-center">
                                    <button onclick="toggleModal('modal-audit-detail-{{ $log->id }}')" class="text-slate-400 hover:text-slate-600"><i class="fa-regular fa-eye text-sm"></i></button>
                                </td>
                                
                                <!-- Modal Detail Audit -->
                                <div id="modal-audit-detail-{{ $log->id }}" class="fixed inset-0 z-50 hidden bg-slate-900/50 backdrop-blur-sm transition-opacity opacity-0 flex items-center justify-center p-4">
                                    <div class="bg-white rounded-xl shadow-xl w-full max-w-lg overflow-hidden transform scale-95 transition-transform duration-300">
                                        <div class="p-5 border-b border-slate-100 flex justify-between items-center bg-slate-50">
                                            <h3 class="font-bold text-slate-800 text-base">Detail Aktivitas Audit</h3>
                                            <button onclick="toggleModal('modal-audit-detail-{{ $log->id }}')" class="text-slate-400 hover:text-rose-500 transition"><i class="fa-solid fa-xmark text-lg"></i></button>
                                        </div>
                                        <div class="p-6">
                                            <div class="space-y-4 text-xs text-slate-700">
                                                <div class="grid grid-cols-3 gap-2 border-b border-slate-100 pb-3">
                                                    <div class="font-semibold text-slate-500">Waktu</div>
                                                    <div class="col-span-2">{{ \Carbon\Carbon::parse($log->created_at)->translatedFormat('d F Y, H:i:s') }}</div>
                                                </div>
                                                <div class="grid grid-cols-3 gap-2 border-b border-slate-100 pb-3">
                                                    <div class="font-semibold text-slate-500">Pelaku (User)</div>
                                                    <div class="col-span-2 font-bold">{{ $log->nama_pelaku ?? 'System' }} <span class="text-slate-400 font-normal">({{ $log->role_pelaku ?? '-' }})</span></div>
                                                </div>
                                                <div class="grid grid-cols-3 gap-2 border-b border-slate-100 pb-3">
                                                    <div class="font-semibold text-slate-500">Modul</div>
                                                    <div class="col-span-2">{{ $log->modul }}</div>
                                                </div>
                                                <div class="grid grid-cols-3 gap-2 border-b border-slate-100 pb-3">
                                                    <div class="font-semibold text-slate-500">Jenis Aksi</div>
                                                    <div class="col-span-2">
                                                        <span class="px-2.5 py-0.5 rounded-full {{ $aksiColor }} text-[10px] font-bold">{{ $log->aksi }}</span>
                                                    </div>
                                                </div>
                                                <div class="grid grid-cols-3 gap-2 border-b border-slate-100 pb-3">
                                                    <div class="font-semibold text-slate-500">ID Record</div>
                                                    <div class="col-span-2">{{ $log->id_record ?? '-' }}</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="p-4 border-t border-slate-100 bg-slate-50 flex justify-end">
                                            <button onclick="toggleModal('modal-audit-detail-{{ $log->id }}')" class="px-4 py-2 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 rounded-lg text-xs font-semibold transition">Tutup</button>
                                        </div>
                                    </div>
                                </div>

                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-8 text-slate-500">Belum ada riwayat audit trail.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-5 border-t border-slate-100">
                    {{ $logs->links() }}
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

        // Menutup modal ketika mengeklik backdrop kosong di luar modal box
        window.onclick = function(event) {
            if (event.target.attributes.id && event.target.attributes.id.value.startsWith('modal-')) {
                toggleModal(event.target.id);
            }
        }
</script>
@endsection

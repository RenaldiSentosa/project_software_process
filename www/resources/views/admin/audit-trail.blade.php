@extends('layouts.admin')

@section('title', 'Audit Trail - IPWIJA SmartLab')

@section('styles')
<style>
body {
    font-family: 'Inter', sans-serif;
    background-color: #F8FAFC;
}
::-webkit-scrollbar { width: 6px; }
::-webkit-scrollbar-track { background: #f1f1f1; }
::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }

.badge-create  { background:#ECFDF5; color:#059669; }
.badge-update  { background:#EFF6FF; color:#2563EB; }
.badge-delete  { background:#FEF2F2; color:#DC2626; }
.badge-approve { background:#F0FDF4; color:#16A34A; }
.badge-reject  { background:#FFF7ED; color:#EA580C; }
.badge-login   { background:#F5F3FF; color:#7C3AED; }
.badge-logout  { background:#EFF6FF; color:#0284C7; }
.badge-export  { background:#F0FDFA; color:#0D9488; }
.badge-default { background:#F8FAFC; color:#64748B; }

.dot-create  { background:#059669; }
.dot-update  { background:#2563EB; }
.dot-delete  { background:#DC2626; }
.dot-approve { background:#16A34A; }
.dot-reject  { background:#EA580C; }
.dot-login   { background:#7C3AED; }
.dot-logout  { background:#0284C7; }
.dot-export  { background:#0D9488; }
.dot-default { background:#64748B; }

.panel-before { background:#F8FAFC; border:1px solid #FCA5A5; border-radius:12px; overflow:hidden; }
.panel-after  { background:#F8FAFC; border:1px solid #6EE7B7; border-radius:12px; overflow:hidden; }
.panel-header-before { background:#FEF2F2; border-bottom:1px solid #FCA5A5; padding:12px 16px; display:flex; align-items:center; gap:8px; }
.panel-header-after  { background:#ECFDF5; border-bottom:1px solid #6EE7B7; padding:12px 16px; display:flex; align-items:center; gap:8px; }
.panel-body { padding:16px; }
.panel-field-label { color:#94A3B8; font-size:11px; margin-bottom:4px; font-weight:500; }
.panel-field-value { font-weight:600; color:#0F172A; font-size:13px; line-height:1.4; }
</style>
@endsection

@section('content')

<div>
    <h2 class="text-2xl font-bold text-slate-900 tracking-tight">Audit Trail</h2>
    <p class="text-slate-500 text-sm mt-1">Pantau seluruh riwayat aktivitas dan perubahan data yang terjadi di dalam sistem.</p>
</div>

{{-- Search bar --}}
<form method="GET" action="{{ route('admin.audit_trail') }}" id="filter-form" class="mt-4 space-y-3">

    <div class="relative">
        <i class="fa-solid fa-magnifying-glass text-slate-400 absolute left-4 top-3.5 text-xs"></i>
        <input type="text" name="search" value="{{ request('search') }}"
            placeholder="Cari user, module, aksi, record ID dll..."
            class="w-full pl-10 pr-4 py-2.5 bg-white border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-blue-500 transition shadow-sm">
    </div>

    {{-- Filter row --}}
    <div class="flex flex-wrap gap-3 items-center">

        {{-- Tanggal --}}
        <input type="date" name="date" value="{{ request('date') }}"
            onchange="document.getElementById('filter-form').submit()"
            class="bg-white border border-slate-200 px-4 py-2.5 rounded-xl text-xs font-medium text-slate-600 focus:outline-none shadow-sm cursor-pointer min-w-[150px]">

        {{-- Role --}}
        <div class="relative">
            <select name="role" onchange="document.getElementById('filter-form').submit()"
                class="appearance-none bg-white border border-slate-200 pl-4 pr-10 py-2.5 rounded-xl text-xs font-medium text-slate-600 focus:outline-none shadow-sm cursor-pointer min-w-[160px]">
                <option value="">Semua Role</option>
                <option value="Admin Laboratorium" {{ request('role') == 'Admin Laboratorium' ? 'selected' : '' }}>Admin Laboratorium</option>
                <option value="mahasiswa"          {{ request('role') == 'mahasiswa'          ? 'selected' : '' }}>Mahasiswa</option>
            </select>
            <i class="fa-solid fa-chevron-down absolute right-4 top-4 text-[10px] text-slate-400 pointer-events-none"></i>
        </div>

        {{-- Modul --}}
        <div class="relative">
            <select name="modul" onchange="document.getElementById('filter-form').submit()"
                class="appearance-none bg-white border border-slate-200 pl-4 pr-10 py-2.5 rounded-xl text-xs font-medium text-slate-600 focus:outline-none shadow-sm cursor-pointer min-w-[160px]">
                <option value="">Semua Module</option>
                <option value="Manajemen Alat"   {{ request('modul') == 'Manajemen Alat'   ? 'selected' : '' }}>Manajemen Alat</option>
                <option value="Manajemen Barang" {{ request('modul') == 'Manajemen Barang' ? 'selected' : '' }}>Manajemen Barang</option>
                <option value="Peminjaman"       {{ request('modul') == 'Peminjaman'       ? 'selected' : '' }}>Peminjaman</option>
                <option value="Manajemen User"   {{ request('modul') == 'Manajemen User'   ? 'selected' : '' }}>Manajemen User</option>
                <option value="Laporan"          {{ request('modul') == 'Laporan'          ? 'selected' : '' }}>Laporan</option>
                <option value="Login"            {{ request('modul') == 'Login'            ? 'selected' : '' }}>Login</option>
            </select>
            <i class="fa-solid fa-chevron-down absolute right-4 top-4 text-[10px] text-slate-400 pointer-events-none"></i>
        </div>

        {{-- Aksi --}}
        <div class="relative">
            <select name="aksi" onchange="document.getElementById('filter-form').submit()"
                class="appearance-none bg-white border border-slate-200 pl-4 pr-10 py-2.5 rounded-xl text-xs font-medium text-slate-600 focus:outline-none shadow-sm cursor-pointer min-w-[160px]">
                <option value="">Semua Aksi</option>
                <option value="CREATE"  {{ request('aksi') == 'CREATE'  ? 'selected' : '' }}>Create</option>
                <option value="UPDATE"  {{ request('aksi') == 'UPDATE'  ? 'selected' : '' }}>Update</option>
                <option value="DELETE"  {{ request('aksi') == 'DELETE'  ? 'selected' : '' }}>Hapus</option>
                <option value="APPROVE" {{ request('aksi') == 'APPROVE' ? 'selected' : '' }}>Disetujui</option>
                <option value="REJECT"  {{ request('aksi') == 'REJECT'  ? 'selected' : '' }}>Ditolak</option>
                <option value="LOGIN"   {{ request('aksi') == 'LOGIN'   ? 'selected' : '' }}>Login</option>
                <option value="LOGOUT"  {{ request('aksi') == 'LOGOUT'  ? 'selected' : '' }}>Logout</option>
                <option value="EXPORT"  {{ request('aksi') == 'EXPORT'  ? 'selected' : '' }}>Export</option>
            </select>
            <i class="fa-solid fa-chevron-down absolute right-4 top-4 text-[10px] text-slate-400 pointer-events-none"></i>
        </div>

        {{-- Reset filter --}}
        @if(request()->hasAny(['search','date','role','modul','aksi']))
        <a href="{{ route('admin.audit_trail') }}"
            class="text-xs text-slate-400 hover:text-slate-600 underline transition">
            Reset filter
        </a>
        @endif

        {{-- Export CSV — kirim filter aktif juga --}}
        <div class="ml-auto">
            <a href="{{ route('admin.audit_trail.export', request()->only(['search','date','role','modul','aksi'])) }}"
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-teal-600 hover:bg-teal-700 text-white rounded-xl text-xs font-semibold transition shadow-sm">
                <i class="fa-solid fa-file-csv"></i>
                Export CSV
            </a>
        </div>

    </div>

</form>

{{-- Tabel --}}
<div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden mt-2">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs border-collapse">
            <thead>
                <tr class="bg-slate-50/70 border-b border-slate-100 text-slate-400 font-semibold uppercase tracking-wider">
                    <th class="py-4 px-5">Timestamp</th>
                    <th class="py-4 px-5">User</th>
                    <th class="py-4 px-5">Role</th>
                    <th class="py-4 px-5">Modul</th>
                    <th class="py-4 px-5">Aksi</th>
                    <th class="py-4 px-5">Record ID</th>
                    <th class="py-4 px-5">IP Address</th>
                    <th class="py-4 px-5 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-slate-700 font-medium">
                @forelse($logs as $log)
                @php
                    $aksi = strtoupper($log->aksi ?? '');
                    $badgeMap = [
                        'CREATE'  => 'badge-create',
                        'UPDATE'  => 'badge-update',
                        'DELETE'  => 'badge-delete',
                        'APPROVE' => 'badge-approve',
                        'REJECT'  => 'badge-reject',
                        'LOGIN'   => 'badge-login',
                        'LOGOUT'  => 'badge-logout',
                        'EXPORT'  => 'badge-export',
                    ];
                    $labelMap = [
                        'CREATE'  => 'CREATE',
                        'UPDATE'  => 'UPDATE',
                        'DELETE'  => 'HAPUS',
                        'APPROVE' => 'DISETUJUI',
                        'REJECT'  => 'DITOLAK',
                        'LOGIN'   => 'LOGIN',
                        'LOGOUT'  => 'LOGOUT',
                        'EXPORT'  => 'EXPORT',
                    ];
                    $badgeClass = $badgeMap[$aksi] ?? 'badge-default';
                    $aksiLabel  = $labelMap[$aksi]  ?? $aksi;
                @endphp
                <tr class="hover:bg-slate-50/50 transition">
                    <td class="py-4 px-5 text-slate-500 whitespace-nowrap">
                        {{ \Carbon\Carbon::parse($log->created_at)->format('Y-m-d H:i:s') }}
                    </td>
                    <td class="py-4 px-5 text-blue-600 font-semibold cursor-pointer hover:underline"
                        onclick="openModal('modal-{{ $log->id }}')">
                        {{ $log->nama_pelaku ?? 'System' }}
                    </td>
                    <td class="py-4 px-5 text-slate-500">{{ $log->role_pelaku ?? '-' }}</td>
                    <td class="py-4 px-5 text-slate-800">{{ $log->modul }}</td>
                    <td class="py-4 px-5">
                        <span class="px-2.5 py-0.5 rounded-full {{ $badgeClass }} text-[10px] font-bold">
                            {{ $aksiLabel }}
                        </span>
                    </td>
                    <td class="py-4 px-5 text-slate-700 font-mono">{{ $log->id_record ?? '-' }}</td>
                    <td class="py-4 px-5 text-slate-500 font-mono">{{ $log->ip_address ?? '-' }}</td>
                    <td class="py-4 px-5 text-center">
                        <button onclick="openModal('modal-{{ $log->id }}')"
                            class="text-slate-400 hover:text-slate-600 transition">
                            <i class="fa-regular fa-eye text-sm"></i>
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-10 text-slate-400">
                        <i class="fa-regular fa-folder-open text-2xl mb-2 block"></i>
                        Belum ada riwayat audit trail.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="p-5 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500 flex-wrap gap-2">
        <span>
            Menampilkan {{ $logs->firstItem() ?? 0 }}–{{ $logs->lastItem() ?? 0 }}
            dari {{ number_format($logs->total()) }} entri
        </span>
        {{ $logs->links() }}
    </div>
</div>

{{-- ============================================================
     MODAL DETAIL — satu per log, render di luar tabel
     ============================================================ --}}
@foreach($logs as $log)
@php
    $aksi2 = strtoupper($log->aksi ?? '');
    $badgeMap2 = [
        'CREATE'  => 'badge-create',
        'UPDATE'  => 'badge-update',
        'DELETE'  => 'badge-delete',
        'APPROVE' => 'badge-approve',
        'REJECT'  => 'badge-reject',
        'LOGIN'   => 'badge-login',
        'LOGOUT'  => 'badge-logout',
        'EXPORT'  => 'badge-export',
    ];
    $dotMap2 = [
        'CREATE'  => 'dot-create',
        'UPDATE'  => 'dot-update',
        'DELETE'  => 'dot-delete',
        'APPROVE' => 'dot-approve',
        'REJECT'  => 'dot-reject',
        'LOGIN'   => 'dot-login',
        'LOGOUT'  => 'dot-logout',
        'EXPORT'  => 'dot-export',
    ];
    $labelMap2 = [
        'CREATE'  => 'Create',
        'UPDATE'  => 'Update',
        'DELETE'  => 'Hapus',
        'APPROVE' => 'Disetujui',
        'REJECT'  => 'Ditolak',
        'LOGIN'   => 'Login',
        'LOGOUT'  => 'Logout',
        'EXPORT'  => 'Export',
    ];
    $badgeClass2 = $badgeMap2[$aksi2] ?? 'badge-default';
    $dotClass2   = $dotMap2[$aksi2]   ?? 'dot-default';
    $aksiLabel2  = $labelMap2[$aksi2]  ?? $aksi2;

    $dataBefore = is_string($log->data_sebelum) ? json_decode($log->data_sebelum, true) : (array)($log->data_sebelum ?? []);
    $dataAfter  = is_string($log->data_sesudah)  ? json_decode($log->data_sesudah, true)  : (array)($log->data_sesudah  ?? []);
@endphp

<div id="modal-{{ $log->id }}"
    class="fixed inset-0 z-50 hidden bg-slate-900/50 backdrop-blur-sm flex items-center justify-center p-4 opacity-0 transition-opacity duration-300">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg transform scale-95 transition-transform duration-300 overflow-hidden">

        {{-- Header: ID Audit --}}
        <div class="px-6 pt-6 pb-4 border-b border-slate-100">
            <p class="text-xs text-slate-400 uppercase tracking-widest font-semibold">ID Audit</p>
            <p class="text-lg font-bold text-slate-900 mt-0.5">AUD-{{ str_pad($log->id, 3, '0', STR_PAD_LEFT) }}</p>
        </div>

        <div class="px-6 py-5 space-y-5 max-h-[72vh] overflow-y-auto">

            {{-- Badge aksi + timestamp --}}
            <div class="flex items-center gap-3 flex-wrap">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full {{ $badgeClass2 }} text-xs font-bold">
                    <span class="w-2 h-2 rounded-full {{ $dotClass2 }} inline-block"></span>
                    {{ $aksiLabel2 }}
                </span>
                <span class="flex items-center gap-1.5 text-xs text-slate-400">
                    <i class="fa-regular fa-clock"></i>
                    {{ \Carbon\Carbon::parse($log->created_at)->format('Y-m-d H:i:s') }}
                </span>
            </div>

            {{-- 2×2 info cards --}}
            <div class="grid grid-cols-2 gap-3">
                <div class="bg-slate-50 rounded-xl p-3.5">
                    <p class="text-[10px] text-slate-400 mb-1">Pengguna</p>
                    <p class="text-xs font-bold text-slate-900 leading-tight">{{ $log->nama_pelaku ?? 'System' }}</p>
                    <p class="text-[10px] text-slate-400 mt-0.5">{{ $log->role_pelaku ?? '-' }}</p>
                </div>
                <div class="bg-slate-50 rounded-xl p-3.5">
                    <p class="text-[10px] text-slate-400 mb-1">Alamat IP</p>
                    <p class="text-xs font-bold text-slate-900 flex items-center gap-1.5">
                        <i class="fa-solid fa-wifi text-slate-400 text-[10px]"></i>
                        {{ $log->ip_address ?? '-' }}
                    </p>
                </div>
                <div class="bg-slate-50 rounded-xl p-3.5">
                    <p class="text-[10px] text-slate-400 mb-1">Modul</p>
                    <p class="text-xs font-bold text-slate-900">{{ $log->modul }}</p>
                </div>
                <div class="bg-slate-50 rounded-xl p-3.5">
                    <p class="text-[10px] text-slate-400 mb-1">Record ID</p>
                    <p class="text-xs font-bold text-slate-900 font-mono">{{ $log->id_record ?? '-' }}</p>
                </div>
            </div>

            {{-- Deskripsi Aktivitas --}}
            <div>
                <p class="text-xs font-semibold text-slate-700 mb-2">Deskripsi Aktivitas</p>
                <div class="bg-slate-50 rounded-xl px-4 py-3 text-xs text-slate-600 leading-relaxed">
                    {{ $log->deskripsi ?? '-' }}
                </div>
            </div>

            {{-- Perubahan Data --}}
            @if(!empty($dataBefore) || !empty($dataAfter))
            <div>
                <p class="text-xs font-semibold text-slate-700 mb-2">Perubahan Data</p>
                <div class="grid gap-3 {{ ($aksi2 === 'CREATE' || $aksi2 === 'DELETE') ? 'grid-cols-1' : 'grid-cols-2' }}">

                    {{-- Data Sebelum — sembunyikan untuk CREATE --}}
                    @if($aksi2 !== 'CREATE' && !empty($dataBefore))
                    <div class="panel-before">
                        <div class="panel-header-before">
                            <i class="fa-solid fa-arrow-left text-red-400 text-[10px]"></i>
                            <span class="text-xs font-bold text-red-600">Data Sebelum</span>
                        </div>
                        <div class="panel-body space-y-4">
                            @foreach($dataBefore as $key => $val)
                            <div>
                                <p class="panel-field-label">{{ ucwords(str_replace('_', ' ', $key)) }}</p>
                                <p class="panel-field-value">{{ $val === null || $val === '' ? 'null' : $val }}</p>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    {{-- Data Sesudah — sembunyikan untuk DELETE --}}
                    @if($aksi2 !== 'DELETE' && !empty($dataAfter))
                    <div class="panel-after">
                        <div class="panel-header-after">
                            <i class="fa-solid fa-arrow-right text-green-500 text-[10px]"></i>
                            <span class="text-xs font-bold text-green-600">Data Sesudah</span>
                        </div>
                        <div class="panel-body space-y-4">
                            @foreach($dataAfter as $key => $val)
                            <div>
                                <p class="panel-field-label">{{ ucwords(str_replace('_', ' ', $key)) }}</p>
                                <p class="panel-field-value">{{ $val === null || $val === '' ? 'null' : $val }}</p>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                </div>
            </div>
            @endif

        </div>

        {{-- Footer --}}
        <div class="px-6 py-4 border-t border-slate-100 bg-slate-50 flex justify-end">
            <button onclick="closeModal('modal-{{ $log->id }}')"
                class="px-5 py-2 bg-white border border-slate-200 hover:bg-slate-100 text-slate-700 rounded-xl text-xs font-semibold transition">
                Tutup
            </button>
        </div>

    </div>
</div>
@endforeach

@endsection

@section('scripts')
<script>
function openModal(id) {
    const modal = document.getElementById(id);
    if (!modal) return;
    modal.classList.remove('hidden');
    requestAnimationFrame(() => {
        modal.classList.remove('opacity-0');
        modal.querySelector('div').classList.remove('scale-95');
    });
}

function closeModal(id) {
    const modal = document.getElementById(id);
    if (!modal) return;
    modal.classList.add('opacity-0');
    modal.querySelector('div').classList.add('scale-95');
    setTimeout(() => modal.classList.add('hidden'), 300);
}

// Tutup modal klik backdrop
document.addEventListener('click', function (e) {
    if (e.target.id && e.target.id.startsWith('modal-')) {
        closeModal(e.target.id);
    }
});

// Tutup modal ESC
document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') {
        document.querySelectorAll('[id^="modal-"]:not(.hidden)').forEach(m => closeModal(m.id));
    }
});

// Submit form saat ketik di search (delay 500ms biar ga spam)
let searchTimer;
document.querySelector('input[name="search"]').addEventListener('input', function () {
    clearTimeout(searchTimer);
    searchTimer = setTimeout(() => {
        document.getElementById('filter-form').submit();
    }, 500);
});
</script>
@endsection
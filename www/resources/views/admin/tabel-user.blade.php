<table class="w-full text-left text-xs border-collapse">
    <thead>
        <tr class="bg-slate-50/70 border-b border-slate-100 text-slate-400 font-semibold uppercase tracking-wider">
            <th class="py-4 px-6">ID User</th>
            <th class="py-4 px-6">Nama</th>
            <th class="py-4 px-6">Email</th>
            <th class="py-4 px-6">Program Studi</th>
            <th class="py-4 px-6">Role</th>
            <th class="py-4 px-6 text-center">Status Akun</th>
            <th class="py-4 px-6 text-center">Aksi</th>
        </tr>
    </thead>
    <tbody class="divide-y divide-slate-100 text-slate-700 font-medium">
        @forelse($users ?? [] as $u)
        <tr class="hover:bg-slate-50/50 transition">
            <td class="py-4 px-6 text-slate-600 font-mono">{{ $u->id_user ?? $u->nim ?? '-' }}</td>
            <td class="py-4 px-6">
                <p class="text-slate-900 font-bold">{{ $u->nama_lengkap ?? $u->name }}</p>
                <p class="text-slate-400 font-normal">{{ $u->nim ?? '-' }}</p>
            </td>
            <td class="py-4 px-6 text-slate-500">{{ $u->email }}</td>
            <td class="py-4 px-6 text-slate-800">{{ strtolower($u->role) == 'mahasiswa' ? ($u->program_studi ?? '-') : '-' }}</td>
            <td class="py-4 px-6">
                @if(strtolower($u->role) == 'admin')
                    <span class="px-2.5 py-0.5 rounded-full bg-blue-50 text-blue-600 text-[10px] font-bold">ADMIN</span>
                @else
                    <span class="px-2.5 py-0.5 rounded-full bg-purple-50 text-purple-600 text-[10px] font-bold">MAHASISWA</span>
                @endif
            </td>
            <td class="py-4 px-6 text-center">
                @if($u->is_active)
                    <span class="mx-auto px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-600 text-[10px] font-bold flex items-center gap-1 w-fit"><span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>Aktif</span>
                @else
                    <span class="mx-auto px-2 py-0.5 rounded-full bg-rose-50 text-rose-600 text-[10px] font-bold flex items-center gap-1 w-fit"><span class="w-1.5 h-1.5 bg-rose-500 rounded-full"></span>Nonaktif</span>
                @endif
            </td>
            <td class="py-4 px-6 text-center flex items-center justify-center gap-2.5">
                @if($u->is_active)
                    <form id="form-toggle-{{ $u->id }}" action="{{ route('admin.manajemen_user.toggle_status', $u->id) }}" method="POST" class="inline">
                        @csrf
                        @method('PATCH')
                        <button type="button" onclick="confirmToggleStatus('{{ $u->id }}', false, '{{ $u->nama_lengkap ?? $u->name }}')" class="text-slate-400 hover:text-rose-600" title="Nonaktifkan"><i class="fa-solid fa-xmark text-sm"></i></button>
                    </form>
                @else
                    <form id="form-toggle-{{ $u->id }}" action="{{ route('admin.manajemen_user.toggle_status', $u->id) }}" method="POST" class="inline">
                        @csrf
                        @method('PATCH')
                        <button type="button" onclick="confirmToggleStatus('{{ $u->id }}', true, '{{ $u->nama_lengkap ?? $u->name }}')" class="text-slate-400 hover:text-emerald-600" title="Aktifkan"><i class="fa-solid fa-check text-sm"></i></button>
                    </form>
                @endif
                <button onclick="toggleModal('modal-detail-{{ $u->id }}')" class="text-slate-400 hover:text-slate-600" title="Detail"><i class="fa-regular fa-eye text-sm"></i></button>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="7" class="text-center py-8 text-slate-500">Tidak ada user yang cocok dengan filter ini.</td>
        </tr>
        @endforelse
    </tbody>
</table>

@if(isset($users) && $users instanceof \Illuminate\Pagination\AbstractPaginator)
<div class="p-5 border-t border-slate-100" id="pagination-area">
    {{ $users->links() }}
</div>
@endif

<!-- Modal Detail User (digenerate ulang setiap kali hasil filter berubah) -->
@foreach($users ?? [] as $u)
<div id="modal-detail-{{ $u->id }}" class="fixed inset-0 z-50 hidden bg-slate-900/50 backdrop-blur-sm transition-opacity opacity-0 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-lg overflow-hidden transform scale-95 transition-transform duration-300">
        <div class="p-5 border-b border-slate-100 flex justify-between items-start bg-slate-50">
            <div>
                <h3 class="font-bold text-slate-800 text-base">{{ $u->nama_lengkap ?? $u->name }}</h3>
                <p class="text-xs text-slate-500 mt-0.5">{{ $u->id_user ?? '-' }} &mdash; {{ $u->nim ?? '-' }}</p>
            </div>
            <div class="flex items-center gap-3">
                @if($u->is_active)
                    <span class="px-2.5 py-1 rounded-full bg-emerald-50 text-emerald-600 text-[10px] font-bold flex items-center gap-1"><span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>Aktif</span>
                @else
                    <span class="px-2.5 py-1 rounded-full bg-rose-50 text-rose-600 text-[10px] font-bold flex items-center gap-1"><span class="w-1.5 h-1.5 bg-rose-500 rounded-full"></span>Nonaktif</span>
                @endif
                <button onclick="toggleModal('modal-detail-{{ $u->id }}')" class="text-slate-400 hover:text-rose-500 transition"><i class="fa-solid fa-xmark text-lg"></i></button>
            </div>
        </div>
        <div class="p-6">
            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-3">Detail Akun</p>
            <div class="grid grid-cols-4 gap-3 mb-6">
                <div class="bg-slate-50 rounded-lg p-3 text-center">
                    <p class="text-[10px] text-slate-500 mb-1">Total Peminjaman</p>
                    <p class="text-lg font-bold text-slate-800">{{ $u->total_peminjaman ?? 0 }}</p>
                </div>
                <div class="bg-slate-50 rounded-lg p-3 text-center">
                    <p class="text-[10px] text-slate-500 mb-1">Aktif</p>
                    <p class="text-lg font-bold text-purple-600">{{ $u->peminjaman_aktif ?? 0 }}</p>
                </div>
                <div class="bg-slate-50 rounded-lg p-3 text-center">
                    <p class="text-[10px] text-slate-500 mb-1">Selesai</p>
                    <p class="text-lg font-bold text-emerald-600">{{ $u->peminjaman_selesai ?? 0 }}</p>
                </div>
                <div class="bg-slate-50 rounded-lg p-3 text-center">
                    <p class="text-[10px] text-slate-500 mb-1">Role</p>
                    <p class="text-lg font-bold text-blue-600">{{ $u->role }}</p>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <p class="text-xs text-slate-500 mb-1">Nama Lengkap</p>
                    <p class="text-sm font-semibold text-slate-800">{{ $u->nama_lengkap ?? $u->name }}</p>
                </div>
                <div>
                    <p class="text-xs text-slate-500 mb-1">NIM</p>
                    <p class="text-sm font-semibold text-slate-800">{{ $u->nim ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-xs text-slate-500 mb-1">Email</p>
                    <p class="text-sm font-semibold text-slate-800">{{ $u->email }}</p>
                </div>
                <div>
                    <p class="text-xs text-slate-500 mb-1">Role</p>
                    <p class="text-sm font-semibold text-slate-800">{{ $u->role }}</p>
                </div>
                <div>
                    <p class="text-xs text-slate-500 mb-1">Program Studi</p>
                    <p class="text-sm font-semibold text-slate-800">{{ strtolower($u->role) == 'mahasiswa' ? ($u->program_studi ?? '-') : '-' }}</p>
                </div>
                <div>
                    <p class="text-xs text-slate-500 mb-1">Login Terakhir</p>
                    <p class="text-sm font-semibold text-slate-800">{{ optional($u->last_login_at)->translatedFormat('d M Y, H:i') ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-xs text-slate-500 mb-1">Tanggal Daftar</p>
                    <p class="text-sm font-semibold text-slate-800">{{ optional($u->created_at)->translatedFormat('d M Y') ?? '-' }}</p>
                </div>
            </div>

            <div class="bg-slate-50 rounded-lg p-4 flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Status Akun</p>
                    @if($u->is_active)
                        <p class="text-sm font-semibold text-slate-800 flex items-center gap-2">
                            <span class="w-2 h-2 bg-emerald-500 rounded-full"></span>
                            Akun saat ini <span class="text-emerald-600">AKTIF</span>
                        </p>
                    @else
                        <p class="text-sm font-semibold text-slate-800 flex items-center gap-2">
                            <span class="w-2 h-2 bg-rose-500 rounded-full"></span>
                            Akun saat ini <span class="text-rose-600">NONAKTIF</span>
                        </p>
                    @endif
                </div>
                <p class="text-xs text-slate-500">User dapat login dan meminjam alat</p>
            </div>
        </div>
        <div class="flex justify-end gap-3 p-4 border-t border-slate-100 bg-slate-50">
            @if($u->is_active)
                <button type="button" onclick="confirmToggleStatus('{{ $u->id }}', false, '{{ $u->nama_lengkap ?? $u->name }}')" class="px-4 py-2 bg-rose-50 hover:bg-rose-100 text-rose-600 rounded-lg text-xs font-semibold transition flex items-center gap-1.5">
                    <i class="fa-solid fa-xmark"></i> Nonaktifkan
                </button>
            @else
                <button type="button" onclick="confirmToggleStatus('{{ $u->id }}', true, '{{ $u->nama_lengkap ?? $u->name }}')" class="px-4 py-2 bg-emerald-50 hover:bg-emerald-100 text-emerald-600 rounded-lg text-xs font-semibold transition flex items-center gap-1.5">
                    <i class="fa-solid fa-check"></i> Aktifkan
                </button>
            @endif
            <button onclick="toggleModal('modal-detail-{{ $u->id }}')" class="px-4 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded-lg text-xs font-semibold transition">Tutup</button>
        </div>
    </div>
</div>
@endforeach
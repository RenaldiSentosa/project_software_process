@extends('layouts.admin')

@section('title', 'Manajemen User - IPWIJA SmartLab')

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
            
            <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-4">
                <div>
                    <h2 class="text-2xl font-bold text-slate-900 tracking-tight">Manajemen User</h2>
                    <p class="text-slate-500 text-sm mt-1">Kelola data pengguna, hak akses peran sistem, serta status keaktifan akun.</p>
                </div>
                <button onclick="toggleModal('modal-tambah-user')" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2.5 rounded-xl text-xs transition shadow-sm flex items-center gap-2 self-start sm:self-auto">
                    <i class="fa-solid fa-plus text-[10px]"></i> Tambah User Baru
                </button>
            </div>

            <form method="GET" action="{{ route('admin.manajemen_user') }}" class="flex flex-col sm:flex-row gap-3 mb-6">
                <div class="relative flex-1">
                    <i class="fa-solid fa-magnifying-glass text-slate-400 absolute left-4 top-3.5 text-xs"></i>
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama, NIM/NIDN, email, atau program studi..." class="w-full pl-10 pr-4 py-2.5 bg-white border border-slate-200 rounded-xl text-xs focus:outline-none focus:border-blue-500 transition shadow-sm">
                </div>
                <div class="relative">
                    <select name="role" class="appearance-none bg-white border border-slate-200 pl-4 pr-10 py-2.5 rounded-xl text-xs font-medium text-slate-600 focus:outline-none shadow-sm cursor-pointer min-w-[140px]">
                        <option value="">Semua Peran</option>
                        <option value="Admin" {{ strcasecmp(request('role'), 'Admin') == 0 ? 'selected' : '' }}>Admin</option>
                        <option value="Mahasiswa" {{ strcasecmp(request('role'), 'Mahasiswa') == 0 ? 'selected' : '' }}>Mahasiswa</option>
                        <option value="Dosen" {{ strcasecmp(request('role'), 'Dosen') == 0 ? 'selected' : '' }}>Dosen</option>
                    </select>
                    <i class="fa-solid fa-chevron-down absolute right-4 top-4 text-[10px] text-slate-400 pointer-events-none"></i>
                </div>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2.5 rounded-xl text-xs transition shadow-sm flex items-center gap-2">
                    <i class="fa-solid fa-filter"></i> Filter
                </button>
            </form>

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
                        <tbody id="tbody-user" class="divide-y divide-slate-100 text-slate-700 font-medium">
                            @forelse($users ?? [] as $u)
                            @php
                                $roleNorm = strtolower($u->role);
                            @endphp
                            <tr class="hover:bg-slate-50/50 transition user-row">
                                <td class="py-4 px-6 text-slate-600 font-mono">{{ $u->nim ?? '-' }}</td>
                                <td class="py-4 px-6 text-slate-900 font-bold">{{ $u->nama_lengkap ?? $u->name }}</td>
                                <td class="py-4 px-6 text-slate-500">{{ $u->email }}</td>
                                <td class="py-4 px-6 text-slate-800">{{ $u->program_studi ?? '-' }}</td>
                                <td class="py-4 px-6">
                                    @if(strtolower($u->role) == 'admin')
                                        <span class="px-2.5 py-0.5 rounded-full bg-blue-50 text-blue-600 text-[10px] font-bold">ADMIN</span>
                                    @else
                                        <span class="px-2.5 py-0.5 rounded-full bg-purple-50 text-purple-600 text-[10px] font-bold">MAHASISWA</span>
                                    @endif
                                </td>
                                <td class="py-4 px-6 text-center">
                                    @if(!isset($u->is_active) || $u->is_active !== 0)
                                        <span class="mx-auto px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-600 text-[10px] font-bold flex items-center gap-1 w-fit"><span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>Aktif</span>
                                    @else
                                        <span class="mx-auto px-2 py-0.5 rounded-full bg-rose-50 text-rose-600 text-[10px] font-bold flex items-center gap-1 w-fit"><span class="w-1.5 h-1.5 bg-rose-500 rounded-full"></span>Nonaktif</span>
                                    @endif
                                </td>
                                <td class="py-4 px-6 text-center flex items-center justify-center gap-2.5">
                                    <button onclick="toggleModal('modal-detail-{{ $u->id }}')" class="text-slate-400 hover:text-slate-600" title="Detail"><i class="fa-regular fa-eye text-sm"></i></button>
                                    <button onclick="toggleModal('modal-edit-{{ $u->id }}')" class="text-slate-400 hover:text-amber-600" title="Ubah"><i class="fa-regular fa-pen-to-square text-sm"></i></button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-8 text-slate-500">Belum ada data user.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    @if($users->isEmpty())
                    <p class="text-center py-10 text-slate-400 text-xs">
                        <i class="fa-solid fa-magnifying-glass text-xl mb-2 block"></i>
                        Tidak ada user yang cocok dengan pencarian/filter.
                    </p>
                    @endif
                </div>
                <div class="p-5 border-t border-slate-100">
                    {{ $users->links() }}
                </div>
            </div>

            <!-- Modal Tambah User -->
            <div id="modal-tambah-user" class="fixed inset-0 z-50 hidden bg-slate-900/50 backdrop-blur-sm transition-opacity opacity-0 flex items-center justify-center p-4">
                <div class="bg-white rounded-xl shadow-xl w-full max-w-lg overflow-hidden transform scale-95 transition-transform duration-300">
                    <div class="p-5 border-b border-slate-100 flex justify-between items-center bg-slate-50">
                        <h3 class="font-bold text-slate-800 text-base">Tambah User Baru</h3>
                        <button onclick="toggleModal('modal-tambah-user')" class="text-slate-400 hover:text-rose-500 transition"><i class="fa-solid fa-xmark text-lg"></i></button>
                    </div>
                    <div class="p-6">
                        <form action="{{ route('admin.manajemen_user.store') }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Nama Lengkap</label>
                                <input type="text" name="name" required class="w-full px-3 py-2 border border-slate-200 rounded-lg text-xs focus:outline-none focus:border-blue-500">
                            </div>
                            <div class="mb-4">
                                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Email</label>
                                <input type="email" name="email" required class="w-full px-3 py-2 border border-slate-200 rounded-lg text-xs focus:outline-none focus:border-blue-500">
                            </div>
                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">NIM/NIDN</label>
                                    <input type="text" name="nim" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-xs focus:outline-none focus:border-blue-500">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Program Studi</label>
                                    <input type="text" name="program_studi" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-xs focus:outline-none focus:border-blue-500">
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4 mb-5">
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Peran</label>
                                    <select name="role" required class="w-full px-3 py-2 border border-slate-200 rounded-lg text-xs focus:outline-none focus:border-blue-500">
                                        <option value="Mahasiswa">Mahasiswa</option>
                                        <option value="Admin">Admin</option>
                                        <option value="Dosen">Dosen</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Password</label>
                                    <input type="password" name="password" required class="w-full px-3 py-2 border border-slate-200 rounded-lg text-xs focus:outline-none focus:border-blue-500" placeholder="Minimal 8 karakter">
                                </div>
                            </div>
                            
                            <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                                <button type="button" onclick="toggleModal('modal-tambah-user')" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-lg text-xs font-semibold transition">Batal</button>
                                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-xs font-semibold transition">Simpan User</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Modals Edit & Detail User -->
            @foreach($users as $u)
            <div id="modal-detail-{{ $u->id }}" class="fixed inset-0 z-50 hidden bg-slate-900/50 backdrop-blur-sm transition-opacity opacity-0 flex items-center justify-center p-4">
                <div class="bg-white rounded-2xl shadow-xl w-full max-w-3xl overflow-hidden transform scale-95 transition-transform duration-300 flex flex-col max-h-[95vh]">
                    
                    <div class="px-8 pt-8 pb-6 border-b border-slate-100 flex justify-between items-start">
                        <div>
                            <h3 class="font-bold text-slate-900 text-lg">{{ $u->nama_lengkap ?? $u->name }}</h3>
                            <p class="text-xs text-slate-500 mt-1">{{ $u->nim ? $u->nim . ' - ' : '' }}{{ $u->email }}</p>
                        </div>
                        <button onclick="toggleModal('modal-detail-{{ $u->id }}')" class="text-slate-400 hover:text-rose-500 transition"><i class="fa-solid fa-xmark text-lg"></i></button>
                    </div>

                    <div class="p-8 overflow-y-auto">
                        <div class="mb-8">
                            <h4 class="text-sm font-bold text-slate-800 mb-4">Detail Akun</h4>
                            <div class="grid grid-cols-4 gap-4">
                                <div class="bg-slate-50 rounded-xl p-5 text-center flex flex-col justify-center border border-slate-100">
                                    <p class="text-xs text-slate-500 mb-2 font-medium">Total Peminjaman</p>
                                    <p class="text-2xl font-bold text-slate-900">{{ $u->borrowings ? $u->borrowings->count() : 0 }}</p>
                                </div>
                                <div class="bg-slate-50 rounded-xl p-5 text-center flex flex-col justify-center border border-slate-100">
                                    <p class="text-xs text-slate-500 mb-2 font-medium">Aktif</p>
                                    <p class="text-2xl font-bold text-purple-600">{{ $u->borrowings ? $u->borrowings->whereIn('status', ['Dipinjam', 'Disetujui', 'Menunggu', 'Diproses'])->count() : 0 }}</p>
                                </div>
                                <div class="bg-slate-50 rounded-xl p-5 text-center flex flex-col justify-center border border-slate-100">
                                    <p class="text-xs text-slate-500 mb-2 font-medium">Selesai</p>
                                    <p class="text-2xl font-bold text-emerald-600">{{ $u->borrowings ? $u->borrowings->where('status', 'Dikembalikan')->count() : 0 }}</p>
                                </div>
                                <div class="bg-slate-50 rounded-xl p-5 text-center flex flex-col justify-center border border-slate-100">
                                    <p class="text-xs text-slate-500 mb-2 font-medium">Role</p>
                                    <p class="text-lg font-bold text-blue-600 mt-1">{{ ucfirst(strtolower($u->role)) }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-y-6 gap-x-6 mb-8">
                            <div>
                                <p class="text-xs text-slate-400 font-medium mb-1.5">Nama Lengkap</p>
                                <p class="text-sm font-bold text-slate-900">{{ $u->nama_lengkap ?? $u->name }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-slate-400 font-medium mb-1.5">NIM</p>
                                <p class="text-sm font-bold text-slate-900">{{ $u->nim ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-slate-400 font-medium mb-1.5">Email</p>
                                <p class="text-sm font-bold text-slate-900">{{ $u->email }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-slate-400 font-medium mb-1.5">Role</p>
                                <p class="text-sm font-bold text-slate-900">{{ ucfirst(strtolower($u->role)) }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-slate-400 font-medium mb-1.5">Program Studi</p>
                                <p class="text-sm font-bold text-slate-900">{{ $u->program_studi ?? $u->ProgramStudi ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-slate-400 font-medium mb-1.5">Login Terakhir</p>
                                <p class="text-sm font-bold text-slate-900">-</p>
                            </div>
                            <div>
                                <p class="text-xs text-slate-400 font-medium mb-1.5">Tanggal Daftar</p>
                                <p class="text-sm font-bold text-slate-900">{{ $u->created_at ? $u->created_at->translatedFormat('d M Y') : '-' }}</p>
                            </div>
                        </div>

                        <div class="bg-slate-50 rounded-xl p-5 flex items-center justify-between border border-slate-100">
                            <div>
                                <p class="text-xs font-bold text-slate-900 mb-2">Status Akun</p>
                                <p class="text-xs text-slate-500 flex items-center gap-2">
                                    <span class="w-2.5 h-2.5 rounded-full {{ !isset($u->is_active) || $u->is_active !== 0 ? 'bg-emerald-500' : 'bg-red-500' }}"></span>
                                    Akun saat ini <strong class="{{ !isset($u->is_active) || $u->is_active !== 0 ? 'text-emerald-600' : 'text-red-600' }}">{{ !isset($u->is_active) || $u->is_active !== 0 ? 'AKTIF' : 'NONAKTIF' }}</strong>
                                </p>
                            </div>
                            <p class="text-xs text-slate-500">
                                {{ !isset($u->is_active) || $u->is_active !== 0 ? 'User dapat login dan meminjam alat' : 'User tidak dapat login' }}
                            </p>
                        </div>
                    </div>

                    <div class="flex justify-end gap-3 px-8 py-5 border-t border-slate-100 bg-white">
                        <form action="{{ route('admin.manajemen_user.toggle_status', $u->id) }}" method="POST" class="inline">
                            @csrf
                            @method('PATCH')
                            @if(!isset($u->is_active) || $u->is_active !== 0)
                                <button type="submit" class="px-5 py-2.5 bg-rose-50 hover:bg-rose-100 text-rose-600 rounded-xl text-xs font-bold transition flex items-center gap-1.5">
                                    <i class="fa-solid fa-xmark"></i> Nonaktifkan
                                </button>
                            @else
                                <button type="submit" class="px-5 py-2.5 bg-emerald-50 hover:bg-emerald-100 text-emerald-600 rounded-xl text-xs font-bold transition flex items-center gap-1.5">
                                    <i class="fa-solid fa-check"></i> Aktifkan
                                </button>
                            @endif
                        </form>
                        <button onclick="toggleModal('modal-detail-{{ $u->id }}')" class="px-6 py-2.5 bg-slate-200 hover:bg-slate-300 text-slate-800 rounded-xl text-xs font-bold transition">Tutup</button>
                    </div>
                </div>
            </div>

            <div id="modal-edit-{{ $u->id }}" class="fixed inset-0 z-50 hidden bg-slate-900/50 backdrop-blur-sm transition-opacity opacity-0 flex items-center justify-center p-4">
                <div class="bg-white rounded-xl shadow-xl w-full max-w-lg overflow-hidden transform scale-95 transition-transform duration-300">
                    <div class="p-5 border-b border-slate-100 flex justify-between items-center bg-slate-50">
                        <h3 class="font-bold text-slate-800 text-base">Edit User</h3>
                        <button onclick="toggleModal('modal-edit-{{ $u->id }}')" class="text-slate-400 hover:text-rose-500 transition"><i class="fa-solid fa-xmark text-lg"></i></button>
                    </div>
                    <div class="p-6">
                        <form action="{{ route('admin.manajemen_user.update', $u->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-4">
                                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Nama Lengkap</label>
                                <input type="text" name="name" value="{{ $u->name }}" required class="w-full px-3 py-2 border border-slate-200 rounded-lg text-xs focus:outline-none focus:border-blue-500">
                            </div>
                            <div class="mb-4">
                                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Email</label>
                                <input type="email" name="email" value="{{ $u->email }}" required class="w-full px-3 py-2 border border-slate-200 rounded-lg text-xs focus:outline-none focus:border-blue-500">
                            </div>
                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">NIM/NIDN</label>
                                    <input type="text" name="nim" value="{{ $u->nim }}" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-xs focus:outline-none focus:border-blue-500">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Program Studi</label>
                                    <input type="text" name="program_studi" value="{{ $u->program_studi }}" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-xs focus:outline-none focus:border-blue-500">
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4 mb-5">
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Peran</label>
                                    <select name="role" required class="w-full px-3 py-2 border border-slate-200 rounded-lg text-xs focus:outline-none focus:border-blue-500">
                                        <option value="Mahasiswa" {{ strtolower($u->role) == 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                                        <option value="Admin" {{ strtolower($u->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                                        <option value="Dosen" {{ strtolower($u->role) == 'dosen' ? 'selected' : '' }}>Dosen</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Password Baru (Opsional)</label>
                                    <input type="password" name="password" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-xs focus:outline-none focus:border-blue-500" placeholder="Kosongkan jika tidak diubah">
                                </div>
                            </div>
                            
                            <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                                <button type="button" onclick="toggleModal('modal-edit-{{ $u->id }}')" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-lg text-xs font-semibold transition">Batal</button>
                                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-xs font-semibold transition">Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
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

        // Menutup modal secara otomatis saat pengguna mengklik luar area box kontainer modal
        window.onclick = function(event) {
            if (event.target.attributes.id && event.target.attributes.id.value.startsWith('modal-')) {
                toggleModal(event.target.id);
            }
        }
</script>
@endsection
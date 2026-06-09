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
                            @forelse($users ?? [] as $u)
                            <tr class="hover:bg-slate-50/50 transition">
                                <td class="py-4 px-6 text-slate-600 font-mono">{{ $u->nim ?? '-' }}</td>
                                <td class="py-4 px-6 text-slate-900 font-bold">{{ $u->nama_lengkap ?? $u->name }}</td>
                                <td class="py-4 px-6 text-slate-500">{{ $u->email }}</td>
                                <td class="py-4 px-6 text-slate-800">{{ $u->ProgramStudi ?? '-' }}</td>
                                <td class="py-4 px-6">
                                    @if(strtolower($u->role) == 'admin')
                                        <span class="px-2.5 py-0.5 rounded-full bg-blue-50 text-blue-600 text-[10px] font-bold">ADMIN</span>
                                    @else
                                        <span class="px-2.5 py-0.5 rounded-full bg-purple-50 text-purple-600 text-[10px] font-bold">MAHASISWA</span>
                                    @endif
                                </td>
                                <td class="py-4 px-6 text-center">
                                    <span class="mx-auto px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-600 text-[10px] font-bold flex items-center gap-1 w-fit"><span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>Aktif</span>
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
                                    <input type="text" name="ProgramStudi" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-xs focus:outline-none focus:border-blue-500">
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4 mb-5">
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Peran</label>
                                    <select name="role" required class="w-full px-3 py-2 border border-slate-200 rounded-lg text-xs focus:outline-none focus:border-blue-500">
                                        <option value="Mahasiswa">Mahasiswa</option>
                                        <option value="Admin">Admin</option>
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
                <div class="bg-white rounded-xl shadow-xl w-full max-w-md overflow-hidden transform scale-95 transition-transform duration-300">
                    <div class="p-5 border-b border-slate-100 flex justify-between items-center bg-slate-50">
                        <h3 class="font-bold text-slate-800 text-base">Detail User</h3>
                        <button onclick="toggleModal('modal-detail-{{ $u->id }}')" class="text-slate-400 hover:text-rose-500 transition"><i class="fa-solid fa-xmark text-lg"></i></button>
                    </div>
                    <div class="p-6">
                        <div class="mb-4">
                            <p class="text-xs text-slate-500 mb-1">Nama Lengkap</p>
                            <p class="text-sm font-semibold text-slate-800">{{ $u->nama_lengkap ?? $u->name }}</p>
                        </div>
                        <div class="mb-4">
                            <p class="text-xs text-slate-500 mb-1">Email</p>
                            <p class="text-sm font-semibold text-slate-800">{{ $u->email }}</p>
                        </div>
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <p class="text-xs text-slate-500 mb-1">NIM / NIDN</p>
                                <p class="text-sm font-semibold text-slate-800">{{ $u->nim ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-slate-500 mb-1">Program Studi</p>
                                <p class="text-sm font-semibold text-slate-800">{{ $u->ProgramStudi ?? '-' }}</p>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-xs text-slate-500 mb-1">Peran</p>
                                <p class="text-sm font-semibold text-slate-800">{{ $u->role }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-end gap-3 p-4 border-t border-slate-100 bg-slate-50">
                        <button onclick="toggleModal('modal-detail-{{ $u->id }}')" class="px-4 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded-lg text-xs font-semibold transition">Tutup</button>
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
                                    <input type="text" name="ProgramStudi" value="{{ $u->ProgramStudi }}" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-xs focus:outline-none focus:border-blue-500">
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4 mb-5">
                                <div>
                                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Peran</label>
                                    <select name="role" required class="w-full px-3 py-2 border border-slate-200 rounded-lg text-xs focus:outline-none focus:border-blue-500">
                                        <option value="Mahasiswa" {{ strtolower($u->role) == 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                                        <option value="Admin" {{ strtolower($u->role) == 'admin' ? 'selected' : '' }}>Admin</option>
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

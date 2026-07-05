<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'IPWIJA SmartLab - Admin')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body { font-family: 'Inter', sans-serif; background-color: #F8FAFC; }
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
    </style>

    @yield('styles')
</head>
<body class="text-slate-700 min-h-screen flex">

    {{-- Overlay / Backdrop untuk mobile --}}
    <div id="mobile-sidebar-backdrop" class="fixed inset-0 bg-slate-900/50 z-40 hidden md:hidden" onclick="toggleSidebar()"></div>

    {{-- SIDEBAR (satu file, tidak diulang di setiap page admin) --}}
    <div id="admin-sidebar" class="w-64 bg-white border-r border-slate-200 flex flex-col justify-between fixed h-full z-50 transform -translate-x-full md:translate-x-0 transition-transform duration-300">
        <div>
            {{-- Sidebar Header: Logo IPWIJA --}}
            <div class="p-6 flex items-center justify-between border-b border-slate-100">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/logo.png') }}"
                         alt="Logo IPWIJA"
                         class="h-10"
                         onerror="this.onerror=null; this.parentNode.innerHTML='<div class=\'w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center\'><span class=\'text-blue-700 font-bold text-xs\'>IP</span></div>'">
                    <div>
                        <h1 class="font-bold text-blue-900 text-lg leading-tight tracking-wide">IPWIJA</h1>
                        <p class="text-xs text-slate-500 font-medium">SmartLab</p>
                    </div>
                </div>
                <button onclick="toggleSidebar()" class="md:hidden text-slate-500 hover:text-slate-800">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>

            {{-- Sidebar Nav --}}
            <nav class="p-4 space-y-1">
                <a href="{{ route('admin.dashboard') }}"
                   class="flex items-center gap-3 px-4 py-3 text-sm rounded-lg transition
                          {{ request()->routeIs('admin.dashboard') ? 'bg-sky-100 text-sky-700 font-semibold' : 'text-slate-500 font-medium hover:bg-slate-50 hover:text-slate-800' }}">
                    <i class="fa-solid fa-table-columns text-base w-5 text-center"></i>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('admin.manajemen_alat') }}"
                   class="flex items-center gap-3 px-4 py-3 text-sm rounded-lg transition
                          {{ request()->routeIs('admin.manajemen_alat') ? 'bg-sky-100 text-sky-700 font-semibold' : 'text-slate-500 font-medium hover:bg-slate-50 hover:text-slate-800' }}">
                    <i class="fa-solid fa-gear text-base w-5 text-center"></i>
                    <span>Manajemen Alat</span>
                </a>
                <a href="{{ route('admin.peminjaman') }}"
                   class="flex items-center gap-3 px-4 py-3 text-sm rounded-lg transition
                          {{ request()->routeIs('admin.peminjaman') ? 'bg-sky-100 text-sky-700 font-semibold' : 'text-slate-500 font-medium hover:bg-slate-50 hover:text-slate-800' }}">
                    <i class="fa-solid fa-calendar-check text-base w-5 text-center"></i>
                    <span>Peminjaman</span>
                </a>
                <a href="{{ route('admin.manajemen_barang') }}"
                   class="flex items-center gap-3 px-4 py-3 text-sm rounded-lg transition
                          {{ request()->routeIs('admin.manajemen_barang') ? 'bg-sky-100 text-sky-700 font-semibold' : 'text-slate-500 font-medium hover:bg-slate-50 hover:text-slate-800' }}">
                    <i class="fa-solid fa-box-open text-base w-5 text-center"></i>
                    <span>Manajemen Barang</span>
                </a>
                <a href="{{ route('admin.laporan') }}"
                   class="flex items-center gap-3 px-4 py-3 text-sm rounded-lg transition
                          {{ request()->routeIs('admin.laporan') ? 'bg-sky-100 text-sky-700 font-semibold' : 'text-slate-500 font-medium hover:bg-slate-50 hover:text-slate-800' }}">
                    <i class="fa-solid fa-chart-simple text-base w-5 text-center"></i>
                    <span>Laporan</span>
                </a>
                <a href="{{ route('admin.audit_trail') }}"
                   class="flex items-center gap-3 px-4 py-3 text-sm rounded-lg transition
                          {{ request()->routeIs('admin.audit_trail') ? 'bg-sky-100 text-sky-700 font-semibold' : 'text-slate-500 font-medium hover:bg-slate-50 hover:text-slate-800' }}">
                    <i class="fa-solid fa-shield-halved text-base w-5 text-center"></i>
                    <span>Audit Trail</span>
                </a>
                <a href="{{ route('admin.manajemen_user') }}"
                   class="flex items-center gap-3 px-4 py-3 text-sm rounded-lg transition
                          {{ request()->routeIs('admin.manajemen_user') ? 'bg-sky-100 text-sky-700 font-semibold' : 'text-slate-500 font-medium hover:bg-slate-50 hover:text-slate-800' }}">
                    <i class="fa-solid fa-users text-base w-5 text-center"></i>
                    <span>Manajemen User</span>
                </a>
            </nav>
        </div>

    </div>

    {{-- MAIN AREA --}}
    <div class="flex-1 flex flex-col min-h-screen md:pl-64 w-full transition-all duration-300">

        {{-- TOPBAR --}}
        <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-4 sm:px-8 sticky top-0 z-10">
            <div class="flex items-center gap-4">
                <button onclick="toggleSidebar()" class="md:hidden text-slate-500 hover:text-slate-800 focus:outline-none">
                    <i class="fa-solid fa-bars text-xl"></i>
                </button>
            </div>

            {{-- User info topbar: avatar seragam 36x36, foto profil atau inisial nama --}}
            <div class="relative">
                <button onclick="toggleProfileDropdown()" class="flex items-center gap-3 focus:outline-none">
                    <div class="w-9 h-9 rounded-full flex items-center justify-center font-bold text-blue-700 text-sm overflow-hidden flex-shrink-0 bg-blue-100">
                        @if(Auth::user()->foto_profil)
                            <img src="{{ asset('storage/' . Auth::user()->foto_profil) }}"
                                 alt="Foto Profil"
                                 class="w-full h-full object-cover"
                                 onerror="this.style.display='none'; this.parentNode.innerHTML='{{ strtoupper(substr(Auth::user()->nama_lengkap ?? Auth::user()->name ?? 'A', 0, 1)) }}'">
                        @else
                            {{ strtoupper(substr(Auth::user()->nama_lengkap ?? Auth::user()->name ?? 'A', 0, 1)) }}
                        @endif
                    </div>
                    <div class="text-left flex items-center gap-2">
                        <div>
                            <h4 class="text-sm font-semibold text-slate-800 leading-none">
                                {{ Auth::user()->nama_lengkap ?? Auth::user()->name ?? 'Admin' }}
                            </h4>
                            <p class="text-[10px] text-slate-500 font-medium mt-1 uppercase tracking-wider">
                                {{ Auth::user()->role ?? 'Admin' }}
                            </p>
                        </div>
                        <i class="fa-solid fa-chevron-down text-[10px] text-slate-400"></i>
                    </div>
                </button>

                {{-- Dropdown Menu --}}
                <div id="profile-dropdown" class="hidden absolute right-0 mt-2 w-36 bg-white rounded-xl shadow-lg border border-slate-100 py-1 z-50">
                    <button onclick="triggerLogout()" class="w-full text-left px-4 py-2.5 text-sm text-rose-600 hover:bg-rose-50 flex items-center gap-2 transition">
                        <i class="fa-solid fa-right-from-bracket w-4 text-center"></i> Logout
                    </button>
                </div>
            </div>
        </header>

        {{-- PAGE CONTENT (diisi oleh @section('content') di masing-masing page admin) --}}
        <main class="p-4 sm:p-8 space-y-6 flex-1 max-w-[1440px] w-full mx-auto">
            @yield('content')
        </main>
    </div>

    {{-- Form Logout CSRF --}}
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('admin-sidebar');
            const backdrop = document.getElementById('mobile-sidebar-backdrop');
            
            if (sidebar.classList.contains('-translate-x-full')) {
                // Open sidebar
                sidebar.classList.remove('-translate-x-full');
                backdrop.classList.remove('hidden');
            } else {
                // Close sidebar
                sidebar.classList.add('-translate-x-full');
                backdrop.classList.add('hidden');
            }
        }

        function toggleProfileDropdown() {
            const dropdown = document.getElementById('profile-dropdown');
            dropdown.classList.toggle('hidden');
        }

        // Tutup dropdown saat klik di luar
        window.addEventListener('click', function(e) {
            const dropdown = document.getElementById('profile-dropdown');
            const button = dropdown.previousElementSibling;
            if (!button.contains(e.target) && !dropdown.contains(e.target)) {
                dropdown.classList.add('hidden');
            }
        });

        function triggerLogout() {
            Swal.fire({
                title: 'Yakin ingin keluar?',
                text: 'Kamu akan keluar dari sesi akun SmartLab IPWIJA.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#9ca3af',
                confirmButtonText: 'Ya, Keluar!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logout-form').submit();
                }
            });
        }
    </script>

    @yield('scripts')

</body>
</html>

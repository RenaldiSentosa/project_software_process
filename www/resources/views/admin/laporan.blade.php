@extends('layouts.admin')

@section('title', 'Laporan & Statistik - IPWIJA SmartLab')

@section('styles')
    <style>
        .metric-card {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 20px;
            display: flex;
            align-items: center;
            gap: 16px;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        }

        .metric-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
        }

        .metric-value {
            font-size: 24px;
            font-weight: 700;
            color: #111827;
            line-height: 1.2;
        }

        .metric-label {
            font-size: 13px;
            color: #6b7280;
            font-weight: 500;
            margin-top: 2px;
        }

        .metric-trend {
            font-size: 12px;
            margin-top: 4px;
            display: flex;
            align-items: center;
            gap: 4px;
            font-weight: 600;
        }

        .chart-container {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        }

        .chart-title {
            font-size: 16px;
            font-weight: 700;
            color: #111827;
            margin-bottom: 20px;
        }

        .chart-bar-wrap {
            display: flex;
            align-items: flex-end;
            gap: 16px;
            height: 200px;
            margin-top: 20px;
        }

        .chart-col {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            align-items: center;
            gap: 8px;
        }

        .chart-bar {
            width: 100%;
            max-width: 48px;
            background: #3b82f6;
            border-radius: 6px 6px 0 0;
            transition: height 0.3s;
            position: relative;
        }

        .chart-bar:hover {
            background: #2563eb;
        }

        .chart-bar-value {
            position: absolute;
            top: -24px;
            left: 50%;
            transform: translateX(-50%);
            font-size: 12px;
            font-weight: 700;
            color: #4b5563;
        }

        .chart-label {
            font-size: 11px;
            color: #6b7280;
            text-align: center;
            width: 100%;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* TABS */
        .tabs-wrapper {
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            gap: 32px;
            margin-bottom: 24px;
            overflow-x: auto;
        }

        .tab-btn {
            padding: 12px 0;
            font-size: 14px;
            font-weight: 600;
            color: #6b7280;
            background: transparent;
            border: none;
            border-bottom: 2px solid transparent;
            cursor: pointer;
            transition: all 0.2s;
            white-space: nowrap;
        }

        .tab-btn:hover {
            color: #374151;
        }

        .tab-btn.active {
            color: #2563eb;
            border-bottom-color: #2563eb;
        }

        .tab-content {
            display: none;
            animation: fadeIn 0.3s;
        }

        .tab-content.active {
            display: block;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(5px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .table-card {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }

        .table-toolbar {
            padding: 16px 20px;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #f9fafb;
        }
    </style>
@endsection

@section('content')
    <div class="space-y-6">

        <!-- HEADER -->
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Laporan & Statistik</h1>
                <p class="text-sm text-slate-500 mt-1">Pantau performa peminjaman, inventaris, dan aktivitas lab Anda.</p>
            </div>
            <button onclick="window.print()"
                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg flex items-center gap-2 text-sm transition">
                <i class="fa-solid fa-file-export"></i> Ekspor Laporan
            </button>
        </div>

        <!-- METRICS 4 CARDS -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            <div class="metric-card">
                <div class="metric-icon bg-blue-50 text-blue-600"><i class="fa-solid fa-clipboard-list"></i></div>
                <div>
                    <div class="metric-value">{{ $totalPeminjaman }}</div>
                    <div class="metric-label">Total Peminjaman</div>
                    <div class="metric-trend text-blue-600"><i class="fa-solid fa-arrow-trend-up text-[10px]"></i>
                        {{ $peminjamanBulanIni > 0 ? '+' . $peminjamanBulanIni : '0' }} bulan ini</div>
                </div>
            </div>
            <div class="metric-card">
                <div class="metric-icon bg-amber-50 text-amber-600"><i class="fa-solid fa-hourglass-half"></i></div>
                <div>
                    <div class="metric-value">{{ $peminjamanAktif }}</div>
                    <div class="metric-label">Peminjaman Aktif</div>
                    <div class="metric-trend text-amber-600"><i class="fa-solid fa-clock text-[10px]"></i>
                        {{ $peminjamanMenungguBulanIni > 0 ? '+' . $peminjamanMenungguBulanIni : '0' }} bulan ini</div>
                </div>
            </div>
            <div class="metric-card">
                <div class="metric-icon bg-rose-50 text-rose-600"><i class="fa-solid fa-triangle-exclamation"></i></div>
                <div>
                    <div class="metric-value">{{ $alatRusak }}</div>
                    <div class="metric-label">Alat Rusak / Perbaikan</div>
                    <div class="metric-trend text-rose-600"><i class="fa-solid fa-circle-exclamation text-[10px]"></i>
                        {{ $alatRusakBulanIni > 0 ? '+' . $alatRusakBulanIni : '0' }} bulan ini</div>
                </div>
            </div>
            <div class="metric-card">
                <div class="metric-icon bg-emerald-50 text-emerald-600"><i class="fa-solid fa-user-graduate"></i></div>
                <div>
                    <div class="metric-value">{{ $totalMahasiswa }}</div>
                    <div class="metric-label">Total Mahasiswa</div>
                    <div class="metric-trend text-emerald-600"><i class="fa-solid fa-user-plus text-[10px]"></i>
                        {{ $mahasiswaBaruBulanIni > 0 ? '+' . $mahasiswaBaruBulanIni : '0' }} bulan ini</div>
                </div>
            </div>
        </div>

        <!-- CHART SECTION -->
        <div class="chart-container">
            <div class="flex justify-between items-center mb-4">
                <h3 class="chart-title !mb-0">Alat Paling Sering Dipinjam</h3>
                <span class="text-xs font-semibold text-slate-500 bg-slate-100 py-1 px-3 rounded-full">Top 5</span>
            </div>
            @if ($alatSeringDipinjam->count() > 0)
                @php
                    $maxVal = $alatSeringDipinjam->max('total');
                    // prevent div by zero
                    $maxVal = $maxVal > 0 ? $maxVal : 1;
                @endphp
                <div class="chart-bar-wrap">
                    @foreach ($alatSeringDipinjam as $alat)
                        @php
                            $heightPct = ($alat->total / $maxVal) * 100;
                            // Minimum height so it's visible
                            $heightPct = $heightPct < 5 ? 5 : $heightPct;
                        @endphp
                        <div class="chart-col">
                            <div class="chart-bar" style="height: {{ $heightPct }}%">
                                <span class="chart-bar-value">{{ $alat->total }}</span>
                            </div>
                            <div class="chart-label" title="{{ $alat->nama_alat }}">{{ Str::limit($alat->nama_alat, 15) }}
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="h-[200px] flex items-center justify-center text-slate-400 text-sm">
                    Belum ada data peminjaman untuk menampilkan grafik.
                </div>
            @endif
        </div>

        <!-- TABS -->
        <div class="tabs-wrapper mt-8">
            <button class="tab-btn active" onclick="switchTab('tab-peminjaman', this)">Rekap Peminjaman</button>
            <button class="tab-btn" onclick="switchTab('tab-inventaris', this)">Status Inventaris</button>
            <button class="tab-btn" onclick="switchTab('tab-mutasi', this)">Log Mutasi Stok</button>
            <button class="tab-btn" onclick="switchTab('tab-mahasiswa', this)">Rekap Mahasiswa</button>
        </div>

        <!-- TAB CONTENTS -->

        <!-- TAB 1: Rekap Peminjaman -->
        <div id="tab-peminjaman" class="tab-content active">
            <div class="table-card">
                <div class="table-toolbar">
                    <h3 class="font-bold text-slate-800 text-sm">Data Rekap Peminjaman</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm border-collapse">
                        <thead>
                            <tr class="bg-white border-b border-slate-200 text-slate-500 font-semibold">
                                <th class="py-3 px-5">ID Peminjaman</th>
                                <th class="py-3 px-5">Mahasiswa</th>
                                <th class="py-3 px-5">Alat (Qty)</th>
                                <th class="py-3 px-5">Tgl Rencana</th>
                                <th class="py-3 px-5">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-700">
                            @forelse($rekapPeminjaman as $pjm)
                                <tr class="hover:bg-slate-50/50">
                                    <td class="py-3 px-5 font-semibold text-slate-800">
                                        PJM-{{ str_pad($pjm->id, 4, '0', STR_PAD_LEFT) }}</td>
                                    <td class="py-3 px-5">
                                        {{ $pjm->mahasiswa->nama_lengkap ?? ($pjm->mahasiswa->name ?? '-') }}<br><span
                                            class="text-xs text-slate-400">{{ $pjm->mahasiswa->nim ?? '' }}</span></td>
                                    <td class="py-3 px-5">
                                        @if ($pjm->items->count() > 0)
                                            {{ $pjm->items->first()->tool->nama_alat ?? 'Alat Dihapus' }}
                                            ({{ $pjm->items->first()->jumlah_unit }})
                                            @if ($pjm->items->count() > 1)
                                                <span class="text-xs text-slate-400">+{{ $pjm->items->count() - 1 }}
                                                    lain</span>
                                            @endif
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="py-3 px-5 text-xs">
                                        {{ \Carbon\Carbon::parse($pjm->tgl_rencana_pinjam)->format('d M Y') }} s/d<br>
                                        {{ \Carbon\Carbon::parse($pjm->tgl_rencana_kembali)->format('d M Y') }}
                                    </td>
                                    <td class="py-3 px-5">
                                        @php
                                            $statusColors = [
                                                'Menunggu' => 'bg-amber-50 text-amber-600',
                                                'Disetujui' => 'bg-blue-50 text-blue-600',
                                                'Diproses' => 'bg-indigo-50 text-indigo-600',
                                                'Dipinjam' => 'bg-purple-50 text-purple-600',
                                                'Dikembalikan' => 'bg-emerald-50 text-emerald-600',
                                                'Ditolak' => 'bg-rose-50 text-rose-600',
                                            ];
                                            $color = $statusColors[$pjm->status] ?? 'bg-slate-50 text-slate-600';
                                        @endphp
                                        <span
                                            class="px-2.5 py-1 text-[11px] font-bold rounded-full {{ $color }}">{{ $pjm->status }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-6 px-5 text-center text-slate-500">Belum ada riwayat
                                        peminjaman</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- TAB 2: Status Inventaris -->
        <div id="tab-inventaris" class="tab-content">
            <div class="table-card">
                <div class="table-toolbar">
                    <h3 class="font-bold text-slate-800 text-sm">Laporan Status Fisik Inventaris</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm border-collapse">
                        <thead>
                            <tr class="bg-white border-b border-slate-200 text-slate-500 font-semibold">
                                <th class="py-3 px-5">Kode Barang</th>
                                <th class="py-3 px-5">Nama Barang</th>
                                <th class="py-3 px-5 text-center">Stok Fisik</th>
                                <th class="py-3 px-5 text-center">Bagus</th>
                                <th class="py-3 px-5 text-center">Rusak</th>
                                <th class="py-3 px-5 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-700">
                            @forelse($inventarisList as $inv)
                                <tr class="hover:bg-slate-50/50">
                                    <td class="py-3 px-5 font-semibold text-slate-800">
                                        BRG-{{ str_pad($inv->id, 3, '0', STR_PAD_LEFT) }}</td>
                                    <td class="py-3 px-5">{{ $inv->nama_barang }}</td>
                                    <td class="py-3 px-5 text-center font-bold text-slate-900">{{ $inv->stok }}</td>
                                    <td class="py-3 px-5 text-center text-emerald-600 font-medium">
                                        {{ $inv->kondisi == 'Baik' ? $inv->stok : 0 }}</td>
                                    <td class="py-3 px-5 text-center text-rose-600 font-medium">
                                        {{ $inv->kondisi != 'Baik' ? $inv->stok : 0 }}</td>
                                    <td class="py-3 px-5 text-center">
                                        @if ($inv->stok > 10)
                                            <span
                                                class="px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-600 text-[11px] font-bold">Aman</span>
                                        @elseif($inv->stok > 0)
                                            <span
                                                class="px-2 py-0.5 rounded-full bg-amber-50 text-amber-600 text-[11px] font-bold">Rendah</span>
                                        @else
                                            <span
                                                class="px-2 py-0.5 rounded-full bg-rose-50 text-rose-600 text-[11px] font-bold">Habis</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-6 px-5 text-center text-slate-500">Belum ada data
                                        inventaris</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- TAB 3: Log Mutasi -->
        <div id="tab-mutasi" class="tab-content">
            <div class="table-card">
                <div class="table-toolbar">
                    <h3 class="font-bold text-slate-800 text-sm">Jurnal Log Mutasi Stok</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm border-collapse">
                        <thead>
                            <tr class="bg-white border-b border-slate-200 text-slate-500 font-semibold">
                                <th class="py-3 px-5">Waktu Mutasi</th>
                                <th class="py-3 px-5">Oleh (User)</th>
                                <th class="py-3 px-5">Aksi / Keterangan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-700">
                            @forelse($mutasiList as $mutasi)
                                <tr class="hover:bg-slate-50/50">
                                    <td class="py-3 px-5 whitespace-nowrap text-slate-500">
                                        {{ $mutasi->created_at ? $mutasi->created_at->format('d M Y, H:i') : '-' }}
                                    </td>
                                    <td class="py-3 px-5 font-semibold text-slate-800">{{ $mutasi->nama_pelaku }}</td>
                                    <td class="py-3 px-5">
                                        @if (str_contains(strtolower($mutasi->aksi), 'masuk'))
                                            <span
                                                class="px-2 py-0.5 rounded-md bg-emerald-50 text-emerald-600 text-[11px] font-bold inline-block mb-1">Stok
                                                Masuk</span>
                                        @elseif(str_contains(strtolower($mutasi->aksi), 'keluar'))
                                            <span
                                                class="px-2 py-0.5 rounded-md bg-rose-50 text-rose-600 text-[11px] font-bold inline-block mb-1">Stok
                                                Keluar</span>
                                        @else
                                            <span
                                                class="px-2 py-0.5 rounded-md bg-blue-50 text-blue-600 text-[11px] font-bold inline-block mb-1">{{ $mutasi->aksi }}</span>
                                        @endif
                                        <div class="text-slate-500 text-xs mt-1">Pada item ID: {{ $mutasi->id_record }}
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="py-6 px-5 text-center text-slate-500">Belum ada riwayat
                                        mutasi</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- TAB 4: Rekap Mahasiswa -->
        <div id="tab-mahasiswa" class="tab-content">
            <div class="table-card">
                <div class="table-toolbar">
                    <h3 class="font-bold text-slate-800 text-sm">Akumulasi Aktivitas Mahasiswa</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm border-collapse">
                        <thead>
                            <tr class="bg-white border-b border-slate-200 text-slate-500 font-semibold">
                                <th class="py-3 px-5">NIM</th>
                                <th class="py-3 px-5">Nama Lengkap</th>
                                <th class="py-3 px-5 text-center">Menunggu</th>
                                <th class="py-3 px-5 text-center">Dipinjam</th>
                                <th class="py-3 px-5 text-center">Ditolak</th>
                                <th class="py-3 px-5 text-center bg-slate-50">Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-700">
                            @forelse($rekapMahasiswa as $mhs)
                                <tr class="hover:bg-slate-50/50">
                                    <td class="py-3 px-5 text-slate-500">{{ $mhs->nim ?? '-' }}</td>
                                    <td class="py-3 px-5 font-semibold text-slate-800">
                                        {{ $mhs->nama_lengkap ?? $mhs->name }}</td>
                                    <td class="py-3 px-5 text-center text-amber-600 font-bold">{{ $mhs->menunggu }}</td>
                                    <td class="py-3 px-5 text-center text-purple-600 font-bold">{{ $mhs->dipinjam }}</td>
                                    <td class="py-3 px-5 text-center text-rose-600 font-bold">{{ $mhs->ditolak }}</td>
                                    <td class="py-3 px-5 text-center bg-slate-50/50 font-bold text-slate-900">
                                        {{ $mhs->total_pengajuan }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-6 px-5 text-center text-slate-500">Belum ada data
                                        mahasiswa</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('scripts')
    <script>
        function switchTab(tabId, btnElement) {
            // Hide all tabs
            const contents = document.querySelectorAll('.tab-content');
            contents.forEach(content => content.classList.remove('active'));

            // Remove active state from all buttons
            const btns = document.querySelectorAll('.tab-btn');
            btns.forEach(btn => btn.classList.remove('active'));

            // Show selected tab
            document.getElementById(tabId).classList.add('active');

            // Set active state on clicked button
            btnElement.classList.add('active');
        }
    </script>
@endsection

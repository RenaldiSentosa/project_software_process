@extends('layouts.admin')

@section('title', 'Laporan - IPWIJA SmartLab')

@section('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<style>
    /* ===================== METRIC CARDS ===================== */
    .metric-card {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 20px 24px;
        box-shadow: 0 1px 2px rgba(0,0,0,0.04);
    }
    .metric-label {
        font-size: 13px;
        color: #6b7280;
        margin-bottom: 4px;
    }
    .metric-value {
        font-size: 28px;
        font-weight: 700;
        color: #111827;
        line-height: 1.1;
    }
    .metric-trend {
        font-size: 12px;
        color: #6b7280;
        margin-top: 4px;
    }
    .metric-icon-wrap {
        width: 44px;
        height: 44px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        float: right;
        margin-top: -4px;
    }

    /* ===================== CHART ===================== */
    .chart-section {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 24px;
        box-shadow: 0 1px 2px rgba(0,0,0,0.04);
    }
    .chart-section h3 {
        font-size: 15px;
        font-weight: 700;
        color: #111827;
        margin-bottom: 20px;
    }
    .bar-item {
        display: flex;
        align-items: center;
        gap: 14px;
        margin-bottom: 14px;
    }
    .bar-item-label {
        width: 120px;
        font-size: 13px;
        font-weight: 600;
        color: #111827;
        flex-shrink: 0;
    }
    .bar-track {
        flex: 1;
        height: 12px;
        background: #f1f5f9;
        border-radius: 99px;
        overflow: hidden;
    }
    .bar-fill {
        height: 100%;
        background: #3b82f6;
        border-radius: 99px;
        transition: width 0.6s ease;
    }
    .bar-count {
        width: 48px;
        text-align: right;
        font-size: 13px;
        font-weight: 700;
        color: #374151;
        flex-shrink: 0;
    }

    /* ===================== FILTER BAR ===================== */
    .filter-bar {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 18px 20px;
        box-shadow: 0 1px 2px rgba(0,0,0,0.04);
    }
    .filter-bar label {
        font-size: 12px;
        font-weight: 600;
        color: #374151;
        display: block;
        margin-bottom: 6px;
    }
    .filter-select, .filter-input {
        width: 100%;
        height: 38px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        padding: 0 10px;
        font-size: 13px;
        color: #374151;
        background: #fff;
        outline: none;
        transition: border-color 0.2s;
    }
    .filter-select:focus, .filter-input:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59,130,246,0.1);
    }
    .btn-export {
        height: 38px;
        background: #1d4ed8;
        color: #fff;
        font-size: 13px;
        font-weight: 600;
        border: none;
        border-radius: 8px;
        padding: 0 20px;
        cursor: pointer;
        white-space: nowrap;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: background 0.2s;
        margin-top: 20px;
    }
    .btn-export:hover { background: #1e40af; }

    /* ===================== TABS ===================== */
    .tabs-nav {
        display: flex;
        gap: 0;
        border-bottom: 2px solid #e5e7eb;
        background: #fff;
        border-radius: 0;
        overflow-x: auto;
    }
    .tab-btn {
        padding: 12px 20px;
        font-size: 13px;
        font-weight: 600;
        color: #6b7280;
        background: transparent;
        border: none;
        border-bottom: 2px solid transparent;
        cursor: pointer;
        white-space: nowrap;
        margin-bottom: -2px;
        transition: all 0.2s;
    }
    .tab-btn:hover { color: #374151; }
    .tab-btn.active {
        color: #2563eb;
        border-bottom-color: #2563eb;
    }
    .tab-content { display: none; }
    .tab-content.active { display: block; }

    /* ===================== TABLE ===================== */
    .table-card {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 1px 2px rgba(0,0,0,0.04);
        margin-top: 0;
    }
    .data-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }
    .data-table thead tr {
        background: #fff;
        border-bottom: 1px solid #e5e7eb;
    }
    .data-table th {
        padding: 12px 16px;
        font-size: 12px;
        font-weight: 600;
        color: #6b7280;
        text-align: left;
        white-space: nowrap;
    }
    .data-table tbody tr {
        border-bottom: 1px solid #f1f5f9;
        transition: background 0.15s;
    }
    .data-table tbody tr:hover { background: #f9fafb; }
    .data-table td {
        padding: 13px 16px;
        color: #374151;
        vertical-align: middle;
    }

    /* ===================== BADGES ===================== */
    .badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 3px 10px;
        border-radius: 99px;
        font-size: 11px;
        font-weight: 700;
    }
    .badge-dot {
        width: 7px; height: 7px; border-radius: 50%; display: inline-block;
    }
    .badge-dipinjam   { background: #ede9fe; color: #7c3aed; }
    .badge-dikembalikan { background: #d1fae5; color: #065f46; }
    .badge-menunggu   { background: #fef3c7; color: #92400e; }
    .badge-ditolak    { background: #fee2e2; color: #991b1b; }
    .badge-disetujui  { background: #dbeafe; color: #1e40af; }
    .badge-diproses   { background: #e0e7ff; color: #3730a3; }

    .badge-baik        { background: #d1fae5; color: #065f46; }
    .badge-rusak-berat { background: #fee2e2; color: #991b1b; }
    .badge-rusak-ringan{ background: #fef3c7; color: #92400e; }
    .badge-tidak-layak { background: #f3f4f6; color: #6b7280; }

    .badge-masuk  { background: #d1fae5; color: #065f46; }
    .badge-keluar { background: #fee2e2; color: #991b1b; }

    .tag-kategori {
        display: inline-block;
        padding: 2px 10px;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 600;
        background: #f3f4f6;
        color: #374151;
    }

    /* ===================== PAGINATION ===================== */
    .pagination-wrap {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 14px 18px;
        border-top: 1px solid #e5e7eb;
        font-size: 12px;
        color: #6b7280;
    }
    .pagination-wrap a, .pagination-wrap span {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 32px;
        height: 32px;
        border-radius: 6px;
        border: 1px solid #e5e7eb;
        margin: 0 2px;
        font-size: 12px;
        font-weight: 600;
        color: #374151;
        text-decoration: none;
        transition: all 0.15s;
        padding: 0 8px;
    }
    .pagination-wrap span.active-page {
        background: #2563eb;
        border-color: #2563eb;
        color: #fff;
    }
    .pagination-wrap a:hover { background: #f3f4f6; }

    /* empty state */
    .empty-state {
        text-align: center;
        padding: 48px 20px;
        color: #9ca3af;
    }
    .empty-state i { font-size: 32px; margin-bottom: 10px; display: block; }
    .empty-state p { font-size: 13px; }

    /* status filter hidden state (rekap mahasiswa tidak punya status) */
    .filter-status-wrap.is-hidden { display: none; }
</style>
@endsection

@section('content')
<div class="space-y-5">

    {{-- ===================== HEADER ===================== --}}
    <div>
        <h1 class="text-2xl font-bold text-slate-900">Laporan</h1>
        <p class="text-sm text-slate-500 mt-1">Lihat dan ekspor laporan peminjaman, inventaris, dan aktivitas laboratorium Universitas IPWIJA.</p>
    </div>

    {{-- ===================== METRIC CARDS ===================== --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        {{-- Total Peminjaman --}}
        <div class="metric-card">
            <div class="metric-icon-wrap bg-slate-100">
                <i class="fa-solid fa-clipboard-list text-slate-500 text-lg"></i>
            </div>
            <div class="metric-label">Total Peminjaman</div>
            <div class="metric-value">{{ number_format($totalPeminjaman) }}</div>
            <div class="metric-trend">+{{ $peminjamanBulanIni }} bulan ini</div>
        </div>
        {{-- Peminjaman Aktif --}}
        <div class="metric-card">
            <div class="metric-icon-wrap bg-green-50">
                <i class="fa-solid fa-hourglass-half text-green-500 text-lg"></i>
            </div>
            <div class="metric-label">Peminjaman Aktif</div>
            <div class="metric-value">{{ number_format($peminjamanAktif) }}</div>
            <div class="metric-trend">+{{ $peminjamanMenungguBulanIni }} minggu ini</div>
        </div>
        {{-- Alat Rusak --}}
        <div class="metric-card">
            <div class="metric-icon-wrap bg-yellow-50">
                <i class="fa-solid fa-triangle-exclamation text-yellow-500 text-lg"></i>
            </div>
            <div class="metric-label">Alat Rusak</div>
            <div class="metric-value">{{ number_format($alatRusak) }}</div>
            <div class="metric-trend text-slate-400">perlu penanganan</div>
        </div>
        {{-- Total Mahasiswa --}}
        <div class="metric-card">
            <div class="metric-icon-wrap bg-blue-50">
                <i class="fa-solid fa-user-graduate text-blue-500 text-lg"></i>
            </div>
            <div class="metric-label">Total Mahasiswa</div>
            <div class="metric-value">{{ number_format($totalMahasiswa) }}</div>
            <div class="metric-trend">+{{ $mahasiswaBaruBulanIni }} bulan ini</div>
        </div>
    </div>

    {{-- ===================== CHART HORIZONTAL BAR ===================== --}}
    <div class="chart-section">
        <h3>Alat Paling Sering Dipinjam</h3>
        @if($alatSeringDipinjam->count() > 0)
            @php $maxVal = $alatSeringDipinjam->max('total') ?: 1; @endphp
            @foreach($alatSeringDipinjam as $alat)
            @php $pct = ($alat->total / $maxVal) * 100; @endphp
            <div class="bar-item">
                <div class="bar-item-label">{{ $alat->nama_alat }}</div>
                <div class="bar-track">
                    <div class="bar-fill" style="width: {{ $pct }}%"></div>
                </div>
                <div class="bar-count">{{ $alat->total }} x</div>
            </div>
            @endforeach
        @else
            <div class="empty-state">
                <i class="fa-solid fa-chart-bar"></i>
                <p>Belum ada data peminjaman</p>
            </div>
        @endif
    </div>

    {{-- ===================== FILTER BAR ===================== --}}
    <div class="filter-bar">
        <div class="flex flex-wrap items-end gap-4">
            {{-- Jenis Laporan --}}
            <div class="flex-1 min-w-[150px]">
                <label>Jenis Laporan</label>
                <select id="filterJenis" class="filter-select" onchange="handleFilterChange()">
                    <option value="semua">Semua Laporan</option>
                    <option value="peminjaman">Rekap Peminjaman</option>
                    <option value="inventaris">Status Inventaris</option>
                    <option value="mutasi">Log Mutasi Stok</option>
                    <option value="mahasiswa">Rekap Mahasiswa</option>
                </select>
            </div>
            {{-- Status (opsinya berubah otomatis ikut Jenis Laporan) --}}
            <div class="flex-1 min-w-[140px] filter-status-wrap" id="filterStatusWrap">
                <label>Status</label>
                <select id="filterStatus" class="filter-select">
                    <option value="">Semua</option>
                </select>
            </div>
            {{-- Dari Tanggal --}}
            <div class="flex-1 min-w-[140px]">
                <label>Dari Tanggal</label>
                <input type="date" id="filterDari" class="filter-input">
            </div>
            {{-- Sampai Tanggal --}}
            <div class="flex-1 min-w-[140px]">
                <label>Sampai Tanggal</label>
                <input type="date" id="filterSampai" class="filter-input">
            </div>
            {{-- Export CSV --}}
            <div>
                <button class="btn-export" onclick="exportCSV()">
                    <i class="fa-solid fa-file-csv"></i> Export CSV
                </button>
            </div>
        </div>
    </div>

    {{-- ===================== TABS + TABLE ===================== --}}
    <div class="table-card">
        {{-- Tab Nav --}}
        <div class="tabs-nav px-2 pt-1">
            <button class="tab-btn active" onclick="switchTab('tab-peminjaman', this)" id="btn-peminjaman">Rekap Peminjaman</button>
            <button class="tab-btn" onclick="switchTab('tab-inventaris', this)" id="btn-inventaris">Status Inventaris</button>
            <button class="tab-btn" onclick="switchTab('tab-mutasi', this)" id="btn-mutasi">Log Mutasi Stok</button>
            <button class="tab-btn" onclick="switchTab('tab-mahasiswa', this)" id="btn-mahasiswa">Rekap Mahasiswa</button>
        </div>

        {{-- ===== TAB 1: Rekap Peminjaman ===== --}}
        <div id="tab-peminjaman" class="tab-content active">
            <div class="overflow-x-auto">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ID peminjaman</th>
                            <th>Mahasiswa</th>
                            <th>Prodi</th>
                            <th>Jumlah Alat</th>
                            <th>Tanggal Pinjam</th>
                            <th>Status</th>
                            <th>Tgl Kembali</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rekapPeminjaman as $pjm)
                        <tr>
                            <td class="font-semibold text-slate-800">PJM-{{ str_pad($pjm->id, 3, '0', STR_PAD_LEFT) }}</td>
                            <td>
                                <div class="font-semibold text-slate-800">{{ $pjm->mahasiswa->nama_lengkap ?? ($pjm->mahasiswa->name ?? '-') }}</div>
                                <div class="text-xs text-slate-400">{{ $pjm->mahasiswa->nim ?? '' }}</div>
                            </td>
                            <td class="text-slate-600">{{ $pjm->mahasiswa->prodi ?? 'Informatika' }}</td>
                            <td class="text-center font-semibold text-slate-800">{{ $pjm->items->sum('jumlah_unit') }}</td>
                            <td class="text-slate-600 text-xs">{{ \Carbon\Carbon::parse($pjm->tgl_rencana_pinjam)->format('d M Y') }}</td>
                            <td>
                                @php
                                    $statusMap = [
                                        'Dipinjam'    => 'badge-dipinjam',
                                        'Dikembalikan'=> 'badge-dikembalikan',
                                        'Menunggu'    => 'badge-menunggu',
                                        'Ditolak'     => 'badge-ditolak',
                                        'Disetujui'   => 'badge-disetujui',
                                        'Diproses'    => 'badge-diproses',
                                    ];
                                    $dotColor = [
                                        'Dipinjam'    => '#7c3aed',
                                        'Dikembalikan'=> '#065f46',
                                        'Menunggu'    => '#92400e',
                                        'Ditolak'     => '#991b1b',
                                        'Disetujui'   => '#1e40af',
                                        'Diproses'    => '#3730a3',
                                    ];
                                    $cls = $statusMap[$pjm->status] ?? 'badge-diproses';
                                    $dot = $dotColor[$pjm->status] ?? '#6b7280';
                                @endphp
                                <span class="badge {{ $cls }}">
                                    <span class="badge-dot" style="background:{{ $dot }}"></span>
                                    {{ $pjm->status }}
                                </span>
                            </td>
                            <td class="text-slate-600 text-xs">
                                @if($pjm->tgl_rencana_kembali)
                                    {{ \Carbon\Carbon::parse($pjm->tgl_rencana_kembali)->format('d M Y') }}
                                @else
                                    <span class="text-slate-300">-</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7">
                                <div class="empty-state">
                                    <i class="fa-solid fa-inbox"></i>
                                    <p>Belum ada riwayat peminjaman</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if(method_exists($rekapPeminjaman, 'links'))
            <div class="pagination-wrap">
                <span>Menampilkan {{ $rekapPeminjaman->firstItem() }}–{{ $rekapPeminjaman->lastItem() }} dari {{ $rekapPeminjaman->total() }} data</span>
                <div>{{ $rekapPeminjaman->links('vendor.pagination.simple-tailwind') }}</div>
            </div>
            @endif
        </div>

        {{-- ===== TAB 2: Status Inventaris ===== --}}
        <div id="tab-inventaris" class="tab-content">
            <div class="overflow-x-auto">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Nama Barang</th>
                            <th>Kategori</th>
                            <th>Stok</th>
                            <th>Min Stok</th>
                            <th>Kondisi</th>
                            <th>Lokasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($inventarisList as $inv)
                        <tr>
                            <td class="font-semibold text-slate-800">BRG-{{ str_pad($inv->id, 3, '0', STR_PAD_LEFT) }}</td>
                            <td class="font-medium text-slate-800">{{ $inv->nama_barang }}</td>
                            <td><span class="tag-kategori">{{ $inv->kategori ?? '-' }}</span></td>
                            <td class="font-bold text-slate-900">{{ $inv->stok }}</td>
                            <td class="text-slate-500">{{ $inv->min_stok ?? 10 }}</td>
                            <td>
                                @php
                                    $kondisi = $inv->kondisi ?? 'Baik';
                                    $kondisiClass = match($kondisi) {
                                        'Baik'        => 'badge-baik',
                                        'Rusak Berat' => 'badge-rusak-berat',
                                        'Rusak Ringan'=> 'badge-rusak-ringan',
                                        'Tidak Layak' => 'badge-tidak-layak',
                                        default       => 'badge-tidak-layak',
                                    };
                                    $kondisiDot = match($kondisi) {
                                        'Baik'        => '#059669',
                                        'Rusak Berat' => '#dc2626',
                                        'Rusak Ringan'=> '#d97706',
                                        default       => '#9ca3af',
                                    };
                                @endphp
                                <span class="badge {{ $kondisiClass }}">
                                    <span class="badge-dot" style="background:{{ $kondisiDot }}"></span>
                                    {{ $kondisi }}
                                </span>
                            </td>
                            <td class="text-slate-600 text-xs">
                                @if($inv->lokasi ?? null)
                                <i class="fa-solid fa-location-dot text-slate-400 mr-1"></i>{{ $inv->lokasi }}
                                @else
                                <span class="text-slate-300">-</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7">
                                <div class="empty-state">
                                    <i class="fa-solid fa-boxes-stacked"></i>
                                    <p>Belum ada data inventaris</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if(method_exists($inventarisList, 'links'))
            <div class="pagination-wrap">
                <span>Menampilkan {{ $inventarisList->firstItem() }}–{{ $inventarisList->lastItem() }} dari {{ $inventarisList->total() }} data</span>
                <div>{{ $inventarisList->links('vendor.pagination.simple-tailwind') }}</div>
            </div>
            @endif
        </div>

        {{-- ===== TAB 3: Log Mutasi Stok ===== --}}
        <div id="tab-mutasi" class="tab-content">
            <div class="overflow-x-auto">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Id Mutasi</th>
                            <th>Tanggal Mutasi</th>
                            <th>nama barang</th>
                            <th>Tipe Mutasi</th>
                            <th>Jumlah</th>
                            <th>Keterangan</th>
                            <th>Operator</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($mutasiList as $mutasi)
                        <tr>
                            <td class="font-semibold text-slate-800">MUT-{{ str_pad($mutasi->id, 3, '0', STR_PAD_LEFT) }}</td>
                            <td class="text-slate-600 text-xs">
                                {{ $mutasi->created_at ? $mutasi->created_at->format('Y-m-d') : '-' }}<br>
                                <span class="text-slate-400">{{ $mutasi->created_at ? $mutasi->created_at->format('H:i') : '' }}</span>
                            </td>
                            <td class="font-medium text-slate-800">{{ $mutasi->nama_barang ?? ($mutasi->barang->nama_barang ?? '-') }}</td>
                            <td>
                                @php
                                    $isMasuk = str_contains(strtolower($mutasi->aksi ?? $mutasi->tipe ?? ''), 'masuk');
                                @endphp
                                @if($isMasuk)
                                <span class="badge badge-masuk">
                                    <i class="fa-solid fa-arrow-down text-[9px]"></i> Masuk
                                </span>
                                @else
                                <span class="badge badge-keluar">
                                    <i class="fa-solid fa-arrow-up text-[9px]"></i> Keluar
                                </span>
                                @endif
                            </td>
                            <td class="font-bold text-slate-800">{{ $mutasi->jumlah ?? $mutasi->qty ?? '-' }}</td>
                            <td class="text-slate-500 text-xs max-w-[160px] truncate" title="{{ $mutasi->keterangan ?? $mutasi->aksi ?? '' }}">
                                {{ Str::limit($mutasi->keterangan ?? $mutasi->aksi ?? '-', 22) }}
                            </td>
                            <td class="text-slate-600">{{ $mutasi->nama_pelaku ?? $mutasi->operator ?? 'Admin Lab' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7">
                                <div class="empty-state">
                                    <i class="fa-solid fa-clock-rotate-left"></i>
                                    <p>Belum ada riwayat mutasi stok</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if(method_exists($mutasiList, 'links'))
            <div class="pagination-wrap">
                <span>Menampilkan {{ $mutasiList->firstItem() }}–{{ $mutasiList->lastItem() }} dari {{ $mutasiList->total() }} data</span>
                <div>{{ $mutasiList->links('vendor.pagination.simple-tailwind') }}</div>
            </div>
            @endif
        </div>

        {{-- ===== TAB 4: Rekap Mahasiswa ===== --}}
        <div id="tab-mahasiswa" class="tab-content">
            <div class="overflow-x-auto">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Mahasiswa</th>
                            <th>NIM</th>
                            <th>Prodi</th>
                            <th class="text-center">Total</th>
                            <th class="text-center">Aktif</th>
                            <th class="text-center">Selesai</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rekapMahasiswa as $mhs)
                        <tr>
                            <td class="font-semibold text-slate-800">{{ $mhs->nama_lengkap ?? $mhs->name }}</td>
                            <td class="text-slate-500 text-xs">{{ $mhs->nim ?? '-' }}</td>
                            <td class="text-slate-600">{{ $mhs->prodi ?? 'Teknik Informatika' }}</td>
                            <td class="text-center font-bold text-slate-900">{{ $mhs->total_pengajuan }}</td>
                            <td class="text-center font-bold text-blue-500">{{ $mhs->dipinjam }}</td>
                            <td class="text-center font-bold text-emerald-500">{{ ($mhs->total_pengajuan ?? 0) - ($mhs->dipinjam ?? 0) - ($mhs->ditolak ?? 0) - ($mhs->menunggu ?? 0) }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6">
                                <div class="empty-state">
                                    <i class="fa-solid fa-user-graduate"></i>
                                    <p>Belum ada data mahasiswa</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if(method_exists($rekapMahasiswa, 'links'))
            <div class="pagination-wrap">
                <span>Menampilkan {{ $rekapMahasiswa->firstItem() }}–{{ $rekapMahasiswa->lastItem() }} dari {{ $rekapMahasiswa->total() }} data</span>
                <div>{{ $rekapMahasiswa->links('vendor.pagination.simple-tailwind') }}</div>
            </div>
            @endif
        </div>

    </div>{{-- end table-card --}}

</div>{{-- end space-y-5 --}}
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
/* ===================== OPSI STATUS PER JENIS LAPORAN ===================== */
/* "" tidak dimasukkan di sini -- opsi "Semua" selalu ditambahkan otomatis di renderStatusOptions() */
const STATUS_OPTIONS = {
    semua: [
        { value: 'Dipinjam',      label: 'Dipinjam' },
        { value: 'Dikembalikan',  label: 'Dikembalikan' },
        { value: 'Ditolak',       label: 'Ditolak' },
        { value: 'Menunggu',      label: 'Menunggu' },
        { value: 'Disetujui',     label: 'Disetujui' },
        { value: 'Diproses',      label: 'Diproses' },
    ],
    peminjaman: [
        { value: 'Dipinjam',      label: 'Dipinjam' },
        { value: 'Dikembalikan',  label: 'Dikembalikan' },
        { value: 'Ditolak',       label: 'Ditolak' },
        { value: 'Menunggu',      label: 'Menunggu' },
        { value: 'Disetujui',     label: 'Disetujui' },
        { value: 'Diproses',      label: 'Diproses' },
    ],
    inventaris: [
        { value: 'Baik',          label: 'Baik' },
        { value: 'Rusak Ringan',  label: 'Rusak Ringan' },
        { value: 'Rusak Berat',   label: 'Rusak Berat' },
        { value: 'Tidak Layak',   label: 'Tidak Layak' },
    ],
    mutasi: [
        { value: 'Masuk',  label: 'Masuk' },
        { value: 'Keluar', label: 'Keluar' },
    ],
    mahasiswa: [], // tidak ada status untuk rekap mahasiswa
};

/* ===================== RENDER OPSI STATUS ===================== */
function renderStatusOptions(jenis) {
    const select = document.getElementById('filterStatus');
    const wrap   = document.getElementById('filterStatusWrap');
    const opsi   = STATUS_OPTIONS[jenis] || STATUS_OPTIONS.semua;

    // reset isi select
    select.innerHTML = '';

    // opsi "Semua" selalu ada di awal
    const optSemua = document.createElement('option');
    optSemua.value = '';
    optSemua.textContent = 'Semua';
    select.appendChild(optSemua);

    opsi.forEach(o => {
        const opt = document.createElement('option');
        opt.value = o.value;
        opt.textContent = o.label;
        select.appendChild(opt);
    });

    // kalau jenis = mahasiswa, sembunyikan filter status sepenuhnya (tidak relevan)
    if (jenis === 'mahasiswa') {
        wrap.classList.add('is-hidden');
    } else {
        wrap.classList.remove('is-hidden');
    }
}

/* ===================== SWITCH TAB ===================== */
function switchTab(tabId, btn) {
    document.querySelectorAll('.tab-content').forEach(el => el.classList.remove('active'));
    document.querySelectorAll('.tab-btn').forEach(el => el.classList.remove('active'));
    document.getElementById(tabId).classList.add('active');
    btn.classList.add('active');
}

/* ===================== FILTER JENIS — sync with tabs + status options ===================== */
function handleFilterChange() {
    const val = document.getElementById('filterJenis').value;
    const map = {
        peminjaman : { tab: 'tab-peminjaman', btn: 'btn-peminjaman' },
        inventaris : { tab: 'tab-inventaris',  btn: 'btn-inventaris' },
        mutasi     : { tab: 'tab-mutasi',      btn: 'btn-mutasi' },
        mahasiswa  : { tab: 'tab-mahasiswa',   btn: 'btn-mahasiswa' },
    };
    if (map[val]) {
        const btn = document.getElementById(map[val].btn);
        switchTab(map[val].tab, btn);
    }

    // setiap kali jenis laporan berganti, opsi status ikut berganti
    // dan otomatis di-reset ke "Semua" supaya tidak ada nilai status lama
    // yang nyangkut dan tidak sesuai dengan jenis laporan yang baru dipilih
    renderStatusOptions(val);
}

/* ===================== INIT SAAT HALAMAN DIMUAT ===================== */
document.addEventListener('DOMContentLoaded', function () {
    const jenisAwal = document.getElementById('filterJenis').value || 'semua';
    renderStatusOptions(jenisAwal);
});

/* ===================== EXPORT CSV ===================== */
function exportCSV() {
    const jenis   = document.getElementById('filterJenis').value;
    const status  = document.getElementById('filterStatus').value;
    const dari    = document.getElementById('filterDari').value;
    const sampai  = document.getElementById('filterSampai').value;

    // Validasi tanggal
    if (dari && sampai && dari > sampai) {
        Swal.fire({
            icon: 'warning',
            title: 'Rentang Tanggal Tidak Valid',
            text: '"Dari Tanggal" tidak boleh lebih besar dari "Sampai Tanggal".',
            confirmButtonColor: '#2563eb',
            confirmButtonText: 'OK'
        });
        return;
    }

    // Konfirmasi export
    Swal.fire({
        title: 'Ekspor Laporan CSV?',
        html: `
            <div style="text-align:left;font-size:14px;line-height:2">
                <b>Jenis Laporan:</b> ${getJenisLabel(jenis)}<br>
                <b>Status:</b> ${status || 'Semua'}<br>
                <b>Dari:</b> ${dari || '-'}<br>
                <b>Sampai:</b> ${sampai || '-'}
            </div>`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#1d4ed8',
        cancelButtonColor: '#6b7280',
        confirmButtonText: '<i class="fa-solid fa-file-csv"></i> Ya, Ekspor',
        cancelButtonText: 'Batal',
    }).then((result) => {
        if (result.isConfirmed) {
            // Build URL
            const params = new URLSearchParams();
            if (jenis)  params.set('jenis', jenis);
            if (status) params.set('status', status);
            if (dari)   params.set('dari', dari);
            if (sampai) params.set('sampai', sampai);

            // Trigger download
            window.location.href = '{{ route("admin.laporan.export") }}?' + params.toString();

            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: 'File CSV sedang diunduh.',
                confirmButtonColor: '#2563eb',
                timer: 2500,
                showConfirmButton: false
            });
        }
    });
}

function getJenisLabel(val) {
    const labels = {
        semua      : 'Semua Laporan',
        peminjaman : 'Rekap Peminjaman',
        inventaris : 'Status Inventaris',
        mutasi     : 'Log Mutasi Stok',
        mahasiswa  : 'Rekap Mahasiswa',
    };
    return labels[val] || 'Semua Laporan';
}
</script>
@endsection
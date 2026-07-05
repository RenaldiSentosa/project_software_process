@extends('layouts.mahasiswa')

@section('title', 'Peminjaman Saya - IPWIJA SmartLab')

@section('styles')
<style>
    .page-header { background: #fff; border: 1px solid #e5e7eb; border-radius: 12px; padding: 24px; margin-bottom: 24px; }
    .page-header h1 { font-size: 20px; font-weight: 700; color: #111827; margin-bottom: 6px; }
    .page-header p  { font-size: 13px; color: #4b5563; }

    .filter-wrapper { display: flex; align-items: center; gap: 12px; margin-bottom: 24px; }
    .select-custom { position: relative; width: 200px; }
    .select-custom select { width: 100%; padding: 10px 36px 10px 16px; font-family: inherit; font-size: 13px; color: #374151; background: #fff; border: 1px solid #d1d5db; border-radius: 8px; appearance: none; cursor: pointer; }
    .select-custom::after { content: ""; position: absolute; right: 14px; top: 50%; transform: translateY(-50%); width: 10px; height: 6px; background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 10 6'%3E%3Cpath stroke='%236B7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m1 1 4 4 4-4'/%3E%3C/svg%3E") no-repeat center; }

    .btn-filter { background: #2563eb; color: #fff; border: none; padding: 10px 24px; font-family: inherit; font-size: 13px; font-weight: 600; border-radius: 8px; cursor: pointer; transition: background 0.15s; }
    .btn-filter:hover { background: #1d4ed8; }

    .table-container { background: #fff; border: 1px solid #d1d5db; border-radius: 10px; overflow: hidden; }

    table { width: 100%; border-collapse: collapse; text-align: left; }
    th { background: #fff; padding: 12px 16px; font-size: 11px; font-weight: 600; color: #111827; border-bottom: 1px solid #d1d5db; }
    td { padding: 14px 16px; font-size: 12px; color: #111827; border-bottom: 1px solid #e5e7eb; background: #fff; }
    tr:last-child td { border-bottom: none; }

    .row-disetujui { border-left: 4px solid #38bdf8; }
    .row-menunggu { border-left: 4px solid #fbbf24; }
    .row-ditolak { border-left: 4px solid #f87171; }
    .row-dikembalikan { border-left: 4px solid #34d399; }
    .row-dipinjam { border-left: 4px solid #a78bfa; }

    .badge-pill { display: inline-flex; align-items: center; gap: 5px; padding: 4px 10px; border-radius: 12px; font-size: 10px; font-weight: 600; border: 1px solid transparent; }
    .badge-pill::before { content: ""; width: 5px; height: 5px; border-radius: 50%; display: inline-block; }
    .badge-pill.disetujui { background: #e0f2fe; color: #0369a1; border-color: #bae6fd; }
    .badge-pill.disetujui::before { background: #0284c7; }
    .badge-pill.menunggu { background: #fef3c7; color: #b45309; border-color: #fde68a; }
    .badge-pill.menunggu::before { background: #d97706; }
    .badge-pill.ditolak { background: #fee2e2; color: #b91c1c; border-color: #fecaca; }
    .badge-pill.ditolak::before { background: #dc2626; }
    .badge-pill.dikembalikan { background: #dcfce7; color: #15803d; border-color: #bbf7d0; }
    .badge-pill.dikembalikan::before { background: #16a34a; }
    .badge-pill.dipinjam { background: #f3e8ff; color: #6b21a8; border-color: #e9d5ff; }
    .badge-pill.dipinjam::before { background: #8b5cf6; }

    .btn-detail { display: inline-flex; align-items: center; gap: 6px; background: #e0f2fe; border: none; padding: 6px 14px; border-radius: 20px; font-size: 11px; font-weight: 600; color: #0369a1; text-decoration: none; transition: all 0.15s ease; }
    .btn-detail:hover { background: #bae6fd; }
    .btn-detail svg { width: 14px; height: 14px; fill: none; stroke: currentColor; stroke-width: 2; }

    .empty-table-state { padding: 48px 16px; text-align: center; color: #6b7280; font-size: 14px; }
</style>
@endsection

@section('content')
    <div class="page-header">
        <h1>Peminjaman Saya</h1>
        <p>Pantau status semua permintaan peminjaman peralatan lab Anda secara real-time.</p>
    </div>

    <div class="filter-wrapper">
        <div class="select-custom">
            <select id="statusFilter">
                <option value="all">Semua Permintaan</option>
                <option value="menunggu">Menunggu Persetujuan</option>
                <option value="disetujui">Disetujui</option>
                <option value="dipinjam">Sedang Dipinjam</option>
                <option value="dikembalikan">Sudah Dikembalikan</option>
                <option value="ditolak">Ditolak</option>
            </select>
        </div>
        <button class="btn-filter" onclick="applyFilter()">Filter</button>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th style="width: 15%;">ID Pinjam</th>
                    <th style="width: 25%;">Nama Alat Laboratorium</th>
                    <th style="width: 18%;">Tanggal Pengajuan</th>
                    <th style="width: 25%;">Periode Peminjaman</th>
                    <th style="width: 12%;">Status</th>
                    <th style="width: 10%;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($peminjaman as $item)
                @php $statusClean = strtolower($item['status']); @endphp
                <tr class="table-row row-{{ $statusClean }}" data-status="{{ $statusClean }}">
                    <td style="font-weight: 600; color: #4b5563;">{{ $item['id'] }}</td>
                    <td style="font-weight: 500;">{{ $item['alat'] }}</td>
                    <td>{{ $item['tgl_aju'] }}</td>
                    <td>{{ $item['periode'] }}</td>
                    <td>
                        <span class="badge-pill {{ $statusClean }}">
                            @if($statusClean == 'menunggu') Menunggu
                            @elseif($statusClean == 'disetujui') Disetujui
                            @elseif($statusClean == 'dipinjam') Dipinjam
                            @elseif($statusClean == 'dikembalikan') Dikembalikan
                            @else Ditolak @endif
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('peminjaman.detail', $item['raw_id']) }}" class="btn-detail">
                            <svg viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/></svg>
                            Detail
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="empty-table-state">Belum ada riwayat permintaan peminjaman alat.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div style="margin-top: 20px;">
        {{ $peminjaman->links() }}
    </div>
@endsection

@section('scripts')
<script>
    @if(session('success'))
        Swal.fire({ icon: 'success', title: 'Berhasil!', text: "{{ session('success') }}", confirmButtonColor: '#2563eb' });
    @endif
    @if(session('error'))
        Swal.fire({ icon: 'error', title: 'Oops...', text: "{{ session('error') }}", confirmButtonColor: '#2563eb' });
    @endif

    function applyFilter() {
        const selectedStatus = document.getElementById('statusFilter').value;
        document.querySelectorAll('.table-row').forEach(row => {
            row.style.display = (selectedStatus === 'all' || row.dataset.status === selectedStatus) ? '' : 'none';
        });
    }
</script>
@endsection
@extends('layouts.mahasiswa')

@section('title', 'Keranjang - IPWIJA SmartLab')

@section('styles')
<style>
    .card {
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 14px;
        padding: 22px;
        margin-bottom: 18px;
    }

    .title { font-size: 24px; font-weight: 600; margin-bottom: 4px; }
    .sub { font-size: 13px; color: #9ca3af; }

    .alert { padding: 12px 16px; border-radius: 8px; font-size: 13px; font-weight: 500; margin-bottom: 18px; }
    .alert-danger { background: #fef2f2; color: #dc2626; border: 1px solid #fca5a5; }
    .alert-success { background: #f0fdf4; color: #16a34a; border: 1px solid #bbf7d0; }

    .item { display: flex; justify-content: space-between; align-items: center; padding: 16px 0; border-bottom: 1px solid #eceff4; }
    .item:last-child { border: none; }
    .item-left { display: flex; align-items: center; gap: 14px; }

    .image { width: 54px; height: 54px; background: #eef2f6; border-radius: 12px; display: flex; justify-content: center; align-items: center; font-size: 24px; overflow: hidden; }
    .image img { width: 100%; height: 100%; object-fit: cover; }

    .name { font-size: 14px; font-weight: 600; }
    .cat { font-size: 12px; color: #9ca3af; }
    .item-right { display: flex; align-items: center; gap: 14px; }
    .qty { display: flex; align-items: center; gap: 10px; }

    .qty button { width: 22px; height: 22px; border: none; background: none; cursor: pointer; font-size: 15px; color: #9ca3af; display: flex; align-items: center; justify-content: center; transition: color 0.15s; }
    .qty button:hover { color: #111827; }

    .qty input.jumlah-input { width: 35px; text-align: center; border: 1px solid #e5e7eb; border-radius: 4px; background: #fff; font-family: inherit; font-size: 14px; font-weight: 600; color: #111827; outline: none; }
    .qty input.jumlah-input::-webkit-outer-spin-button, .qty input.jumlah-input::-webkit-inner-spin-button { -webkit-appearance: none; margin: 0; }

    .delete { cursor: pointer; color: #9ca3af; font-size: 14px; padding: 4px; transition: color 0.15s; }
    .delete:hover { color: #dc2626; }

    .header2 { font-size: 18px; font-weight: 600; margin-bottom: 5px; }
    .desc { font-size: 13px; color: #9ca3af; margin-bottom: 20px; }
    .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 15px; }
    .group { display: flex; flex-direction: column; gap: 8px; }
    .group label { font-size: 13px; font-weight: 600; }

    .group input, textarea { padding: 12px; border: 1px solid #d1d5db; border-radius: 8px; font-family: inherit; font-size: 13px; outline: none; background: #fff; }
    .group input:focus, textarea:focus { border-color: #2563eb; }
    textarea { resize: none; height: 110px; }
    .full { grid-column: 1/3; }

    .btn { margin-top: 10px; background: #2563eb; color: white; border: none; padding: 12px 18px; border-radius: 8px; cursor: pointer; font-size: 13px; font-weight: 600; transition: background 0.15s; }
    .btn:hover { background: #1d4ed8; }

    .empty-cart { text-align: center; padding: 40px 20px; color: #6b7280; }
    .empty-cart p { margin-bottom: 15px; font-size: 14px; }

    @media(max-width:700px) { .form-grid { grid-template-columns: 1fr; } .full { grid-column: auto; } }
</style>
@endsection

@section('content')
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="title">Keranjang Peminjaman</div>
        <div class="sub" id="summaryCount">{{ (isset($cart) && count($cart) > 0) ? count($cart) : 0 }} item dipilih.</div>
    </div>

    <form id="borrowForm" method="POST" action="{{ route('peminjaman.store') }}">
        @csrf

        <div class="card" id="cartCard">
            @if(isset($cart) && count($cart) > 0)
                @foreach($cart as $id => $details)
                    <div class="item" data-id="{{ $id }}">
                        <div class="item-left">
                            <div class="image">
                                @if(isset($details['foto_alat']) && $details['foto_alat'])
                                    <img src="{{ asset('storage/' . $details['foto_alat']) }}" alt="{{ $details['nama_alat'] }}">
                                @else
                                    📡
                                @endif
                            </div>
                            <div>
                                <div class="name">{{ $details['nama_alat'] ?? 'Nama Alat' }}</div>
                                <div class="cat">{{ $details['kategori'] ?? 'Kategori' }}</div>
                                <small style="color: #9ca3af; font-size: 11px;">Tersedia: <span class="max-stok">{{ $details['stok_tersedia'] ?? 10 }}</span> unit</small>
                            </div>
                        </div>
                        <div class="item-right">
                            <div class="qty">
                                <button type="button" onclick="minus(this)">−</button>
                                <input type="number" name="items[{{ $id }}][jumlah_unit]" class="jumlah-input" value="{{ $details['jumlah_unit'] ?? 1 }}" min="1" max="{{ $details['stok_tersedia'] ?? 10 }}" onchange="validateOnInput(this)">
                                <button type="button" onclick="plus(this)">+</button>
                            </div>
                            <div class="delete" onclick="hapus('{{ $id }}', this)">✕</div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="empty-cart">
                    <p>Keranjang kamu masih kosong. Silakan pilih alat di katalog terlebih dahulu.</p>
                    <a href="{{ route('katalog') }}" class="btn" style="text-decoration:none; display:inline-block;">Lihat katalog Alat</a>
                </div>
            @endif
        </div>

        <div class="card" id="detailCard" style="{{ (isset($cart) && count($cart) > 0) ? '' : 'display: none;' }}">
            <div class="header2">Detail Permintaan</div>
            <div class="desc">Isi formulir di bawah untuk mengirim permintaan peminjaman.</div>

            <div class="form-grid">
                <div class="group">
                    <label for="tgl_rencana_pinjam">Tanggal Peminjaman *</label>
                    <input type="date" id="tgl_rencana_pinjam" name="tgl_rencana_pinjam" required value="{{ old('tgl_rencana_pinjam') }}">
                </div>
                <div class="group">
                    <label for="tgl_rencana_kembali">Tanggal Pengembalian *</label>
                    <input type="date" id="tgl_rencana_kembali" name="tgl_rencana_kembali" required value="{{ old('tgl_rencana_kembali') }}">
                </div>
                <div class="group full" style="position: relative;">
                    <label for="keperluan">Tujuan Penggunaan *</label>
                    <textarea id="keperluan" name="keperluan" maxlength="500" placeholder="Jelaskan untuk apa alat ini akan digunakan (projek kursus, penelitian, sesi lab, dll.)" required oninput="updateCharCount(this)">{{ old('keperluan') }}</textarea>
                    <div style="text-align: right; font-size: 11px; color: #9ca3af; margin-top: 4px;" id="charCount">0/500</div>
                </div>
            </div>
            <button type="submit" class="btn">🚀 Kirim Permintaan Peminjaman</button>
        </div>
    </form>

    {{-- Form Hidden khusus hapus item --}}
    <form id="deleteItemForm" method="POST" action="" style="display:none;">
        @csrf
        @method('DELETE')
    </form>
@endsection

@section('scripts')
<script>
    function updateCharCount(textarea) {
        document.getElementById('charCount').innerText = `${textarea.value.length}/500`;
    }

    document.addEventListener('DOMContentLoaded', function() {
        const textarea = document.getElementById('keperluan');
        if (textarea) updateCharCount(textarea);
    });

    function plus(btn) {
        let input = btn.parentElement.querySelector('.jumlah-input');
        let maxStok = parseInt(btn.closest('.item').querySelector('.max-stok').innerText) || 10;
        let val = parseInt(input.value) || 0;
        if (val < maxStok) { input.value = val + 1; }
        else { alert('Jumlah unit tidak boleh melebihi stok yang tersedia!'); }
    }

    function minus(btn) {
        let input = btn.parentElement.querySelector('.jumlah-input');
        let val = parseInt(input.value) || 0;
        if (val > 1) { input.value = val - 1; }
    }

    function validateOnInput(input) {
        let maxStok = parseInt(input.closest('.item').querySelector('.max-stok').innerText) || 10;
        let val = parseInt(input.value);
        if (isNaN(val) || val < 1) { input.value = 1; }
        else if (val > maxStok) { alert('Jumlah unit melebihi stok ketersediaan!'); input.value = maxStok; }
    }

    function hapus(itemId, btnElement) {
        if (confirm('Hapus alat ini dari keranjang?')) {
            let deleteForm = document.getElementById('deleteItemForm');
            deleteForm.action = `/keranjang/hapus/${itemId}`;
            deleteForm.submit();
        }
    }

    document.getElementById('borrowForm')?.addEventListener('submit', function(e) {
        let tglPinjam  = new Date(document.getElementById('tgl_rencana_pinjam').value);
        let tglKembali = new Date(document.getElementById('tgl_rencana_kembali').value);
        let hariIni    = new Date(); hariIni.setHours(0,0,0,0);

        if (!document.getElementById('tgl_rencana_pinjam').value || !document.getElementById('tgl_rencana_kembali').value) {
            e.preventDefault(); alert('Tanggal peminjaman dan pengembalian wajib diisi!'); return false;
        }
        if (tglPinjam < hariIni) {
            e.preventDefault(); alert('Tanggal rencana peminjaman tidak boleh di masa lalu!'); return false;
        }
        if (tglKembali < tglPinjam) {
            e.preventDefault(); alert('Tanggal pengembalian tidak boleh kurang dari tanggal peminjaman!'); return false;
        }
    });
</script>
@endsection
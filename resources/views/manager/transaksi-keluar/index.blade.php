@extends('layouts.app')

@section('title', 'Transaksi Keluar')
@section('page-title', 'Transaksi Keluar')
@section('page-subtitle', 'Kelola konfirmasi barang keluar gudang')

@section('sidebar')
    @include('components.sidebar-manager')
@endsection

@section('content')
<div class="space-y-6">

    {{-- ===== SECTION PENDING ===== --}}
    <div class="bg-white rounded-xl border border-gray-200">
        <div class="flex items-center justify-between px-5 py-4 border-b border-gray-200">
            <div>
                <h3 class="text-sm font-semibold text-gray-800">Menunggu Konfirmasi</h3>
                <p class="text-xs text-gray-400 mt-0.5">Transaksi keluar yang perlu ditindaklanjuti</p>
            </div>
            @if($pending->count() > 0)
                <span class="text-xs font-semibold px-2.5 py-1 bg-yellow-100 text-yellow-700 rounded-full">
                    {{ $pending->count() }} pending
                </span>
            @endif
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">#</th>
                        <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Produk</th>
                        <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">Jumlah</th>
                        <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">Stok Saat Ini</th>
                        <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Diajukan Oleh</th>
                        <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Catatan</th>
                        <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($pending as $index => $trx)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-5 py-3 text-gray-500">{{ $index + 1 }}</td>
                            <td class="px-5 py-3">
                                <p class="font-medium text-gray-800">{{ $trx->product->name ?? '—' }}</p>
                                <p class="text-xs text-gray-400">{{ $trx->product->sku ?? '' }}</p>
                            </td>
                            <td class="px-5 py-3 text-center">
                                <span class="text-sm font-bold text-red-600">-{{ $trx->quantity }}</span>
                            </td>
                            <td class="px-5 py-3 text-center">
                                @php
                                    $stok = $stockMap[$trx->product_id] ?? 0;
                                    $cukup = $stok >= $trx->quantity;
                                @endphp
                                <div class="flex flex-col items-center gap-1">
                                    <span class="text-xs font-semibold px-2.5 py-1 rounded-full
                                        {{ $stok <= ($trx->product->minimum_stock ?? 0) ? 'bg-red-100 text-red-600' : 'bg-green-100 text-green-700' }}">
                                        {{ $stok }}
                                    </span>
                                    @if(!$cukup)
                                        <span class="text-xs text-red-500 font-medium">Stok kurang!</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-5 py-3 text-gray-600 text-xs">{{ $trx->user->name ?? '—' }}</td>
                            <td class="px-5 py-3 text-gray-500 text-xs">
                                {{ $trx->date ? $trx->date->format('d M Y') : '—' }}
                            </td>
                            <td class="px-5 py-3 text-gray-500 text-xs max-w-xs truncate">
                                {{ $trx->notes ?? '—' }}
                            </td>
                            <td class="px-5 py-3 text-center">
                                <div class="flex items-center justify-center gap-2">

                                    {{-- Tombol Konfirmasi --}}
                                    <form id="konfirmasi-{{ $trx->id }}"
                                          method="POST"
                                          action="{{ route('manager.transaksi-keluar.konfirmasi', $trx->id) }}">
                                        @csrf
                                    </form>
                                    <button
                                        onclick="showKonfirmasiModal('konfirmasi-{{ $trx->id }}', '{{ addslashes($trx->product->name ?? '') }}', {{ $trx->quantity }}, {{ $stok }})"
                                        {{ !$cukup ? 'disabled' : '' }}
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium rounded-lg transition
                                            {{ $cukup ? 'text-green-600 bg-green-50 hover:bg-green-100' : 'text-gray-400 bg-gray-100 cursor-not-allowed' }}">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        Keluarkan
                                    </button>

                                    {{-- Tombol Tolak --}}
                                    <form id="tolak-{{ $trx->id }}"
                                          method="POST"
                                          action="{{ route('manager.transaksi-keluar.tolak', $trx->id) }}">
                                        @csrf
                                    </form>
                                    <button onclick="showTolakModal('tolak-{{ $trx->id }}', '{{ addslashes($trx->product->name ?? '') }}')"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                        Tolak
                                    </button>

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-5 py-10 text-center text-gray-400 text-sm">
                                <svg class="w-10 h-10 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Tidak ada transaksi yang menunggu konfirmasi.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- ===== RIWAYAT SEMUA TRANSAKSI KELUAR ===== --}}
    <div class="bg-white rounded-xl border border-gray-200">
        <div class="px-5 py-4 border-b border-gray-200">
            <h3 class="text-sm font-semibold text-gray-800">Riwayat Transaksi Keluar</h3>
            <p class="text-xs text-gray-400 mt-0.5">Semua transaksi keluar yang pernah diajukan</p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">#</th>
                        <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Produk</th>
                        <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">Jumlah</th>
                        <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Diajukan Oleh</th>
                        <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Catatan</th>
                        <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($allKeluar as $index => $trx)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-5 py-3 text-gray-500">{{ $index + 1 }}</td>
                            <td class="px-5 py-3">
                                <p class="font-medium text-gray-800">{{ $trx->product->name ?? '—' }}</p>
                                <p class="text-xs text-gray-400">{{ $trx->product->sku ?? '' }}</p>
                            </td>
                            <td class="px-5 py-3 text-center font-semibold text-red-600">
                                -{{ $trx->quantity }}
                            </td>
                            <td class="px-5 py-3 text-gray-600 text-xs">{{ $trx->user->name ?? '—' }}</td>
                            <td class="px-5 py-3 text-gray-500 text-xs">
                                {{ $trx->date ? $trx->date->format('d M Y') : '—' }}
                            </td>
                            <td class="px-5 py-3 text-gray-500 text-xs max-w-xs truncate">
                                {{ $trx->notes ?? '—' }}
                            </td>
                            <td class="px-5 py-3 text-center">
                                @php
                                    $statusColor = match($trx->status) {
                                        'Pending'     => 'bg-yellow-100 text-yellow-700',
                                        'Dikeluarkan' => 'bg-blue-100 text-blue-700',
                                        'Ditolak'     => 'bg-red-100 text-red-700',
                                        default       => 'bg-gray-100 text-gray-600',
                                    };
                                @endphp
                                <span class="text-xs font-medium px-2.5 py-1 rounded-full {{ $statusColor }}">
                                    {{ $trx->status }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-5 py-10 text-center text-gray-400 text-sm">
                                Belum ada riwayat transaksi keluar.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

{{-- ===== MODAL KONFIRMASI KELUARKAN ===== --}}
<div id="modal-konfirmasi"
     class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md mx-4 p-6">

        <div class="flex justify-center mb-4">
            <div class="w-16 h-16 rounded-full bg-blue-100 flex items-center justify-center">
                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                </svg>
            </div>
        </div>

        <div class="text-center mb-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-1">Konfirmasi Pengeluaran</h3>
            <p class="text-sm text-gray-500">
                Keluarkan
                <span id="konfirmasi-qty" class="font-semibold text-red-600"></span> unit
                <span id="konfirmasi-product-name" class="font-semibold text-gray-800"></span>
                dari gudang?
            </p>
            <p class="text-sm text-gray-500 mt-1">
                Stok tersedia: <span id="konfirmasi-stok" class="font-semibold text-blue-600"></span> unit
            </p>
            <p class="text-xs text-blue-500 mt-2">Stok produk akan otomatis berkurang setelah dikonfirmasi.</p>
        </div>

        <div class="flex items-center gap-3">
            <button onclick="hideKonfirmasiModal()"
                    class="flex-1 px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-lg transition">
                Batal
            </button>
            <button onclick="submitKonfirmasiForm()"
                    class="flex-1 px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition">
                Ya, Keluarkan
            </button>
        </div>

    </div>
</div>

{{-- ===== MODAL TOLAK ===== --}}
<div id="modal-tolak"
     class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md mx-4 p-6">

        <div class="flex justify-center mb-4">
            <div class="w-16 h-16 rounded-full bg-red-100 flex items-center justify-center">
                <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </div>
        </div>

        <div class="text-center mb-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-1">Tolak Transaksi</h3>
            <p class="text-sm text-gray-500">
                Tolak transaksi keluar untuk
                <span id="tolak-product-name" class="font-semibold text-gray-800"></span>?
            </p>
            <p class="text-xs text-red-500 mt-2">Stok tidak akan berubah dan transaksi ditandai ditolak.</p>
        </div>

        <div class="flex items-center gap-3">
            <button onclick="hideTolakModal()"
                    class="flex-1 px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-lg transition">
                Batal
            </button>
            <button onclick="submitTolakForm()"
                    class="flex-1 px-4 py-2.5 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg transition">
                Ya, Tolak
            </button>
        </div>

    </div>
</div>

<script>
    let _konfirmasiFormId = null;
    let _tolakFormId      = null;

    function showKonfirmasiModal(formId, productName, qty, stok) {
        _konfirmasiFormId = formId;
        document.getElementById('konfirmasi-product-name').textContent = productName;
        document.getElementById('konfirmasi-qty').textContent = qty;
        document.getElementById('konfirmasi-stok').textContent = stok;
        const modal = document.getElementById('modal-konfirmasi');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function hideKonfirmasiModal() {
        document.getElementById('modal-konfirmasi').classList.add('hidden');
        document.getElementById('modal-konfirmasi').classList.remove('flex');
        _konfirmasiFormId = null;
    }
    function submitKonfirmasiForm() {
        if (_konfirmasiFormId) {
            document.getElementById(_konfirmasiFormId).submit();
        }
    }

    function showTolakModal(formId, productName) {
        _tolakFormId = formId;
        document.getElementById('tolak-product-name').textContent = productName;
        const modal = document.getElementById('modal-tolak');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function hideTolakModal() {
        document.getElementById('modal-tolak').classList.add('hidden');
        document.getElementById('modal-tolak').classList.remove('flex');
        _tolakFormId = null;
    }

    function submitTolakForm() {
        if (_tolakFormId) {
            document.getElementById(_tolakFormId).submit();
        }
    }

    document.getElementById('modal-konfirmasi').addEventListener('click', function(e) {
        if (e.target === this) hideKonfirmasiModal();
    });

    document.getElementById('modal-tolak').addEventListener('click', function(e) {
        if (e.target === this) hideTolakModal();
    });
</script>

@endsection
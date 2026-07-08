@extends('layouts.app')

@section('title', 'Laporan Transaksi')
@section('page-title', 'Laporan Transaksi')
@section('page-subtitle', 'Laporan transaksi stok masuk dan keluar')

@section('sidebar')
    @include('components.sidebar-manager')
@endsection

@section('content')
<div class="space-y-5">

    {{-- Filter & Export --}}
    <div class="bg-white rounded-xl border border-gray-200 p-5">
        <form method="GET" action="{{ route('manager.laporan.transaksi') }}">
            <div class="grid grid-cols-1 md:grid-cols-5 gap-3 mb-3">
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Tipe</label>
                    <select name="type"
                        class="w-full px-3 py-2 text-sm border border-gray-200 bg-slate-50 rounded-lg outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20">
                        <option value="">Semua Tipe</option>
                        <option value="Masuk" {{ ($filters['type'] ?? '') === 'Masuk' ? 'selected' : '' }}>Masuk</option>
                        <option value="Keluar" {{ ($filters['type'] ?? '') === 'Keluar' ? 'selected' : '' }}>Keluar</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Status</label>
                    <select name="status"
                        class="w-full px-3 py-2 text-sm border border-gray-200 bg-slate-50 rounded-lg outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20">
                        <option value="">Semua Status</option>
                        <option value="Pending" {{ ($filters['status'] ?? '') === 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="Diterima" {{ ($filters['status'] ?? '') === 'Diterima' ? 'selected' : '' }}>Diterima</option>
                        <option value="Dikeluarkan" {{ ($filters['status'] ?? '') === 'Dikeluarkan' ? 'selected' : '' }}>Dikeluarkan</option>
                        <option value="Ditolak" {{ ($filters['status'] ?? '') === 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Produk</label>
                    <select name="product_id"
                        class="w-full px-3 py-2 text-sm border border-gray-200 bg-slate-50 rounded-lg outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20">
                        <option value="">Semua Produk</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" {{ ($filters['product_id'] ?? '') == $product->id ? 'selected' : '' }}>
                                {{ $product->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Dari Tanggal</label>
                    <input type="date" name="date_from" value="{{ $filters['date_from'] ?? '' }}"
                        class="w-full px-3 py-2 text-sm border border-gray-200 bg-slate-50 rounded-lg outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Sampai Tanggal</label>
                    <input type="date" name="date_to" value="{{ $filters['date_to'] ?? '' }}"
                        class="w-full px-3 py-2 text-sm border border-gray-200 bg-slate-50 rounded-lg outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20">
                </div>
            </div>
            <div class="flex items-center gap-2">
                <button type="submit"
                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition">
                    Filter
                </button>
                <a href="{{ route('manager.laporan.transaksi') }}"
                   class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-lg transition">
                    Reset
                </a>
                <a href="{{ route('manager.laporan.transaksi.pdf', request()->query()) }}"
                   class="inline-flex items-center gap-2 px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg transition ml-auto">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Export PDF
                </a>
            </div>
        </form>
    </div>

    {{-- Summary Cards --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl border border-gray-200 p-4 text-center">
            <p class="text-xs text-gray-500 mb-1">Total Masuk (Diterima)</p>
            <p class="text-2xl font-bold text-green-600">{{ $summary['totalMasuk'] }}</p>
            <p class="text-xs text-gray-400">unit</p>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 p-4 text-center">
            <p class="text-xs text-gray-500 mb-1">Total Keluar (Dikeluarkan)</p>
            <p class="text-2xl font-bold text-red-600">{{ $summary['totalKeluar'] }}</p>
            <p class="text-xs text-gray-400">unit</p>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 p-4 text-center">
            <p class="text-xs text-gray-500 mb-1">Masih Pending</p>
            <p class="text-2xl font-bold text-yellow-600">{{ $summary['totalPending'] }}</p>
            <p class="text-xs text-gray-400">transaksi</p>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 p-4 text-center">
            <p class="text-xs text-gray-500 mb-1">Ditolak</p>
            <p class="text-2xl font-bold text-gray-500">{{ $summary['totalDitolak'] }}</p>
            <p class="text-xs text-gray-400">transaksi</p>
        </div>
    </div>

    {{-- Tabel Transaksi --}}
    <div class="bg-white rounded-xl border border-gray-200">
        <div class="flex items-center justify-between px-5 py-4 border-b border-gray-200">
            <h3 class="text-sm font-semibold text-gray-800">Detail Transaksi</h3>
            <p class="text-xs text-gray-400">{{ $transactions->count() }} transaksi</p>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">#</th>
                        <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Produk</th>
                        <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">Tipe</th>
                        <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">Jumlah</th>
                        <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Oleh</th>
                        <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Catatan</th>
                        <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($transactions as $index => $trx)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-5 py-3 text-gray-500">{{ $index + 1 }}</td>
                            <td class="px-5 py-3">
                                <p class="font-medium text-gray-800">{{ $trx->product->name ?? '—' }}</p>
                                <p class="text-xs text-gray-400">{{ $trx->product->sku ?? '' }}</p>
                            </td>
                            <td class="px-5 py-3 text-center">
                                <span class="text-xs font-medium px-2.5 py-1 rounded-full
                                    {{ $trx->type === 'Masuk' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                    {{ $trx->type }}
                                </span>
                            </td>
                            <td class="px-5 py-3 text-center font-semibold
                                {{ $trx->type === 'Masuk' ? 'text-green-600' : 'text-red-600' }}">
                                {{ $trx->type === 'Masuk' ? '+' : '-' }}{{ $trx->quantity }}
                            </td>
                            <td class="px-5 py-3 text-gray-600 text-xs">{{ $trx->user->name ?? '—' }}</td>
                            <td class="px-5 py-3 text-gray-500 text-xs">
                                {{ $trx->date?->format('d M Y') ?? '—' }}
                            </td>
                            <td class="px-5 py-3 text-gray-500 text-xs max-w-xs truncate">
                                {{ $trx->notes ?? '—' }}
                            </td>
                            <td class="px-5 py-3 text-center">
                                @php
                                    $statusColor = match($trx->status) {
                                        'Pending'     => 'bg-yellow-100 text-yellow-700',
                                        'Diterima'    => 'bg-green-100 text-green-700',
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
                            <td colspan="8" class="px-5 py-10 text-center text-gray-400 text-sm">
                                Tidak ada transaksi yang sesuai filter.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
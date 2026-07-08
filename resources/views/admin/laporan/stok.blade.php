@extends('layouts.app')

@section('title', 'Laporan Stok')
@section('page-title', 'Laporan Stok')
@section('page-subtitle', 'Kondisi stok barang gudang saat ini')

@section('sidebar')
    @include('components.sidebar-admin')
@endsection

@section('content')
<div class="space-y-5">

    {{-- Filter & Export --}}
    <div class="bg-white rounded-xl border border-gray-200 p-5">
        <form method="GET" action="{{ route('admin.laporan.stok') }}">
            <div class="flex flex-wrap items-end gap-3">
                <div class="flex-1 min-w-48">
                    <label class="block text-xs font-medium text-gray-500 mb-1">Filter Kategori</label>
                    <select name="category_id"
                        class="w-full px-3 py-2 text-sm border border-gray-200 bg-slate-50 rounded-lg outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ $categoryId == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit"
                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition">
                    Filter
                </button>
                <a href="{{ route('admin.laporan.stok') }}"
                   class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-lg transition">
                    Reset
                </a>
                <a href="{{ route('admin.laporan.stok.pdf', request()->query()) }}"
                   class="inline-flex items-center gap-2 px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg transition ml-auto">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Export PDF
                </a>
            </div>
        </form>
    </div>

    {{-- Summary per Kategori --}}
    <div class="bg-white rounded-xl border border-gray-200">
        <div class="px-5 py-4 border-b border-gray-200">
            <h3 class="text-sm font-semibold text-gray-800">Ringkasan per Kategori</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Kategori</th>
                        <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">Total Produk</th>
                        <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">Total Stok</th>
                        <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">Stok Menipis</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($perKategori as $kat)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-5 py-3 font-medium text-gray-800">{{ $kat->name }}</td>
                            <td class="px-5 py-3 text-center text-gray-600">{{ $kat->total_produk }}</td>
                            <td class="px-5 py-3 text-center font-semibold text-gray-800">{{ $kat->total_stok }}</td>
                            <td class="px-5 py-3 text-center">
                                @if($kat->total_menipis > 0)
                                    <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-red-100 text-red-600">
                                        {{ $kat->total_menipis }} produk
                                    </span>
                                @else
                                    <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-green-100 text-green-700">
                                        Aman
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Detail Stok per Produk --}}
    <div class="bg-white rounded-xl border border-gray-200">
        <div class="flex items-center justify-between px-5 py-4 border-b border-gray-200">
            <h3 class="text-sm font-semibold text-gray-800">Detail Stok per Produk</h3>
            <p class="text-xs text-gray-400">{{ $produk->count() }} produk</p>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">#</th>
                        <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Produk</th>
                        <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">SKU</th>
                        <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Kategori</th>
                        <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Supplier</th>
                        <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">Min. Stok</th>
                        <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">Stok Saat Ini</th>
                        <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($produk as $index => $p)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-5 py-3 text-gray-500">{{ $index + 1 }}</td>
                            <td class="px-5 py-3 font-medium text-gray-800">{{ $p->name }}</td>
                            <td class="px-5 py-3">
                                <span class="font-mono text-xs bg-gray-100 px-2 py-1 rounded">{{ $p->sku }}</span>
                            </td>
                            <td class="px-5 py-3 text-gray-600">{{ $p->category->name }}</td>
                            <td class="px-5 py-3 text-gray-600">{{ $p->supplier->name }}</td>
                            <td class="px-5 py-3 text-center text-gray-600">{{ $p->minimum_stock }}</td>
                            <td class="px-5 py-3 text-center">
                                <span class="text-sm font-bold
                                    {{ $p->current_stock <= $p->minimum_stock ? 'text-red-600' : 'text-green-600' }}">
                                    {{ $p->current_stock }}
                                </span>
                            </td>
                            <td class="px-5 py-3 text-center">
                                <span class="text-xs font-medium px-2.5 py-1 rounded-full
                                    {{ $p->stock_status === 'Menipis' ? 'bg-red-100 text-red-600' : 'bg-green-100 text-green-700' }}">
                                    {{ $p->stock_status }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-5 py-10 text-center text-gray-400 text-sm">
                                Tidak ada data produk.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
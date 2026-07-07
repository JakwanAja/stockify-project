@extends('layouts.app')

@section('title', 'Daftar Produk')
@section('page-title', 'Daftar Produk')
@section('page-subtitle', 'Informasi produk gudang')

@section('sidebar')
    @include('components.sidebar-manager')
@endsection

@section('content')
<div class="bg-white rounded-xl border border-gray-200">
    {{-- Header --}}
    <div class="px-5 py-4 border-b border-gray-200">
        <p class="text-sm text-gray-500">Total <span class="font-semibold text-gray-800">{{ $products->count() }}</span> produk</p>
    </div>
    {{-- Tabel --}}
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider w-12">#</th>
                    <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Produk</th>
                    <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">SKU</th>
                    <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Kategori</th>
                    <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Supplier</th>
                    <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">Min. Stok</th>
                    <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">Stok</th>
                    <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($products as $index => $product)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-5 py-3 text-gray-500">{{ $index + 1 }}</td>
                        <td class="px-5 py-3">
                            <div class="flex items-center gap-3">
                                @if($product->image)
                                    <img src="{{ asset('images/products/' . $product->image) }}"
                                         alt="{{ $product->name }}"
                                         class="w-10 h-10 rounded-lg object-cover border border-gray-200">
                                @else
                                    <div class="w-10 h-10 rounded-lg bg-gray-100 border border-gray-200 flex items-center justify-center">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                        </svg>
                                    </div>
                                @endif
                                <p class="font-medium text-gray-900">{{ $product->name }}</p>
                            </div>
                        </td>
                        <td class="px-5 py-3">
                            <span class="font-mono text-xs bg-gray-100 px-2 py-1 rounded">{{ $product->sku }}</span>
                        </td>
                        <td class="px-5 py-3 text-gray-600">{{ $product->category->name }}</td>
                        <td class="px-5 py-3 text-gray-600">{{ $product->supplier->name }}</td>
                        <td class="px-5 py-3 text-center text-gray-600">{{ $product->minimum_stock }}</td>
                        <td class="px-5 py-3 text-center">
                            @php $stok = $stockMap[$product->id] ?? 0; @endphp
                            <span class="text-xs font-semibold px-2.5 py-1 rounded-full
                                {{ $stok <= $product->minimum_stock ? 'bg-red-100 text-red-600' : 'bg-green-100 text-green-700' }}">
                                {{ $stok }}
                            </span>
                        </td>
                        <td class="px-5 py-3 text-center">
                            <a href="{{ route('manager.products.show', $product->id) }}"
                               class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-blue-600 bg-blue-50 hover:bg-blue-100 rounded-lg transition">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-5 py-12 text-center text-gray-400 text-sm">
                            Belum ada produk terdaftar.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
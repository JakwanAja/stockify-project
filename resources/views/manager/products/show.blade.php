@extends('layouts.app')

@section('title', 'Detail Produk')
@section('page-title', 'Detail Produk')
@section('page-subtitle', $product->name)

@section('sidebar')
    @include('components.sidebar-manager')
@endsection

@section('content')
<div class="max-w-2xl space-y-5">

    {{-- Info Utama --}}
    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <div class="flex items-start gap-5 mb-6">
            {{-- Gambar --}}
            @if($product->image)
                <img src="{{ asset('images/products/' . $product->image) }}"
                     alt="{{ $product->name }}"
                     class="w-24 h-24 rounded-xl object-cover border border-gray-200 flex-shrink-0">
            @else
                <div class="w-24 h-24 rounded-xl bg-gray-100 border border-gray-200 flex items-center justify-center flex-shrink-0">
                    <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
            @endif

            <div class="flex-1">
                <h2 class="text-xl font-bold text-gray-900 mb-1">{{ $product->name }}</h2>
                <span class="font-mono text-xs bg-gray-100 px-2 py-1 rounded">{{ $product->sku }}</span>
                @if($product->description)
                    <p class="text-sm text-gray-500 mt-2">{{ $product->description }}</p>
                @endif
            </div>

            {{-- Badge Stok --}}
            <div class="text-center flex-shrink-0">
                <p class="text-xs text-gray-400 mb-1">Stok Saat Ini</p>
                <span class="text-2xl font-bold px-4 py-2 rounded-xl
                    {{ $stock <= $product->minimum_stock ? 'bg-red-100 text-red-600' : 'bg-green-100 text-green-700' }}">
                    {{ $stock }}
                </span>
            </div>
        </div>

        {{-- Detail Grid --}}
        <div class="grid grid-cols-2 gap-4">
            <div class="bg-gray-50 rounded-lg p-4">
                <p class="text-xs text-gray-400 mb-1">Kategori</p>
                <p class="text-sm font-semibold text-gray-800">{{ $product->category->name ?? '—' }}</p>
            </div>
            <div class="bg-gray-50 rounded-lg p-4">
                <p class="text-xs text-gray-400 mb-1">Supplier</p>
                <p class="text-sm font-semibold text-gray-800">{{ $product->supplier->name ?? '—' }}</p>
            </div>
            <div class="bg-gray-50 rounded-lg p-4">
                <p class="text-xs text-gray-400 mb-1">Harga Beli</p>
                <p class="text-sm font-semibold text-gray-800">Rp {{ number_format($product->purchase_price, 0, ',', '.') }}</p>
            </div>
            <div class="bg-gray-50 rounded-lg p-4">
                <p class="text-xs text-gray-400 mb-1">Harga Jual</p>
                <p class="text-sm font-semibold text-gray-800">Rp {{ number_format($product->selling_price, 0, ',', '.') }}</p>
            </div>
            <div class="bg-gray-50 rounded-lg p-4">
                <p class="text-xs text-gray-400 mb-1">Minimum Stok</p>
                <p class="text-sm font-semibold text-gray-800">{{ $product->minimum_stock }}</p>
            </div>
            <div class="bg-gray-50 rounded-lg p-4">
                <p class="text-xs text-gray-400 mb-1">Status Stok</p>
                <p class="text-sm font-semibold
                    {{ $stock <= $product->minimum_stock ? 'text-red-600' : 'text-green-600' }}">
                    {{ $stock <= $product->minimum_stock ? '⚠ Stok Menipis' : '✓ Stok Aman' }}
                </p>
            </div>
        </div>
    </div>

    {{-- Atribut --}}
    @if($attributes->count() > 0)
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h3 class="text-sm font-semibold text-gray-800 mb-4">Atribut Produk</h3>
            <div class="space-y-2">
                @foreach($attributes as $attr)
                    <div class="flex items-center justify-between py-2 border-b border-gray-100 last:border-0">
                        <span class="text-sm text-gray-500">{{ $attr->name }}</span>
                        <span class="text-sm font-medium text-gray-800">{{ $attr->value }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    {{-- Tombol Kembali --}}
    <div>
        <a href="{{ route('manager.products.index') }}"
           class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-lg transition">
            ← Kembali ke Daftar Produk
        </a>
    </div>

</div>
@endsection
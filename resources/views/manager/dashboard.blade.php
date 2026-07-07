@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Selamat datang kembali, ' . Auth::user()->name)

@section('sidebar')
    @include('components.sidebar-manager')
@endsection

@section('content')

{{-- ===== STAT CARDS ===== --}}
<div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-6">

    {{-- Transaksi Pending --}}
    <div class="bg-white rounded-xl border border-gray-200 p-5 flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl bg-yellow-50 flex items-center justify-center flex-shrink-0">
            <svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <div>
            <p class="text-sm text-gray-500">Total Pending</p>
            <p class="text-2xl font-bold text-gray-900">{{ $totalPending }}</p>
            <p class="text-xs text-gray-400">Perlu ditindaklanjuti</p>
        </div>
    </div>

    {{-- Masuk Hari Ini --}}
    <div class="bg-white rounded-xl border border-gray-200 p-5 flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl bg-green-50 flex items-center justify-center flex-shrink-0">
            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
            </svg>
        </div>
        <div>
            <p class="text-sm text-gray-500">Masuk Hari Ini</p>
            <p class="text-2xl font-bold text-gray-900">{{ $masukHariIni }}</p>
            <p class="text-xs text-gray-400">Transaksi masuk</p>
        </div>
    </div>

    {{-- Keluar Hari Ini --}}
    <div class="bg-white rounded-xl border border-gray-200 p-5 flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl bg-red-50 flex items-center justify-center flex-shrink-0">
            <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
            </svg>
        </div>
        <div>
            <p class="text-sm text-gray-500">Keluar Hari Ini</p>
            <p class="text-2xl font-bold text-gray-900">{{ $keluarHariIni }}</p>
            <p class="text-xs text-gray-400">Transaksi keluar</p>
        </div>
    </div>

</div>

{{-- ===== ROW 2: PENDING MASUK + PENDING KELUAR ===== --}}
<div class="grid grid-cols-1 xl:grid-cols-2 gap-5 mb-6">

    {{-- Pending Masuk --}}
    <div class="bg-white rounded-xl border border-gray-200">
        <div class="flex items-center justify-between px-5 py-4 border-b border-gray-200">
            <h3 class="text-sm font-semibold text-gray-800">Pending Masuk</h3>
            <a href="{{ route('manager.transaksi-masuk.index') }}"
               class="text-xs text-blue-600 hover:underline">Lihat semua →</a>
        </div>
        <div class="divide-y divide-gray-100">
            @forelse($pendingMasuk as $trx)
                <div class="flex items-center justify-between px-5 py-3">
                    <div class="min-w-0">
                        <p class="text-sm font-medium text-gray-800 truncate">{{ $trx->product->name ?? '—' }}</p>
                        <p class="text-xs text-gray-400">oleh {{ $trx->user->name ?? '—' }} · {{ $trx->date?->format('d M Y') }}</p>
                    </div>
                    <span class="text-sm font-bold text-green-600 flex-shrink-0 ml-3">+{{ $trx->quantity }}</span>
                </div>
            @empty
                <div class="px-5 py-8 text-center text-gray-400 text-sm">
                    Tidak ada transaksi masuk yang pending.
                </div>
            @endforelse
        </div>
    </div>

    {{-- Pending Keluar --}}
    <div class="bg-white rounded-xl border border-gray-200">
        <div class="flex items-center justify-between px-5 py-4 border-b border-gray-200">
            <h3 class="text-sm font-semibold text-gray-800">Pending Keluar</h3>
            <a href="{{ route('manager.transaksi-keluar.index') }}"
               class="text-xs text-blue-600 hover:underline">Lihat semua →</a>
        </div>
        <div class="divide-y divide-gray-100">
            @forelse($pendingKeluar as $trx)
                <div class="flex items-center justify-between px-5 py-3">
                    <div class="min-w-0">
                        <p class="text-sm font-medium text-gray-800 truncate">{{ $trx->product->name ?? '—' }}</p>
                        <p class="text-xs text-gray-400">oleh {{ $trx->user->name ?? '—' }} · {{ $trx->date?->format('d M Y') }}</p>
                    </div>
                    <span class="text-sm font-bold text-red-600 flex-shrink-0 ml-3">-{{ $trx->quantity }}</span>
                </div>
            @empty
                <div class="px-5 py-8 text-center text-gray-400 text-sm">
                    Tidak ada transaksi keluar yang pending.
                </div>
            @endforelse
        </div>
    </div>

</div>

{{-- ===== ROW 3: STOK MENIPIS ===== --}}
<div class="bg-white rounded-xl border border-gray-200">
    <div class="px-5 py-4 border-b border-gray-200">
        <h3 class="text-sm font-semibold text-gray-800">Stok Menipis</h3>
        <p class="text-xs text-gray-400 mt-0.5">Produk dengan stok di bawah atau sama dengan minimum</p>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Produk</th>
                    <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Kategori</th>
                    <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">Stok Saat Ini</th>
                    <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">Minimum</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($lowStockProducts as $product)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-5 py-3 font-medium text-gray-800">{{ $product->name }}</td>
                        <td class="px-5 py-3 text-gray-500 text-xs">{{ $product->category->name ?? '—' }}</td>
                        <td class="px-5 py-3 text-center">
                            <span class="text-xs font-bold px-2.5 py-1 rounded-full bg-red-100 text-red-600">
                                {{ $product->current_stock }}
                            </span>
                        </td>
                        <td class="px-5 py-3 text-center text-xs text-gray-500">
                            {{ $product->minimum_stock }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-5 py-8 text-center text-gray-400 text-sm">
                            Semua produk dalam kondisi stok aman. 
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
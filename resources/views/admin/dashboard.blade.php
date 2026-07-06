@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Selamat datang kembali, ' . Auth::user()->name)

@section('sidebar')
    @include('components.sidebar-admin')
@endsection

@section('content')

{{-- ===== STAT CARDS ===== --}}
<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5 mb-6">

    {{-- Total Produk --}}
    <div class="bg-white rounded-xl border border-gray-200 p-5 flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center flex-shrink-0">
            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
            </svg>
        </div>
        <div>
            <p class="text-sm text-gray-500">Total Produk</p>
            <p class="text-2xl font-bold text-gray-900">{{ $totalProducts }}</p>
        </div>
    </div>

    {{-- Transaksi Masuk --}}
    <div class="bg-white rounded-xl border border-gray-200 p-5 flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl bg-green-50 flex items-center justify-center flex-shrink-0">
            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
            </svg>
        </div>
        <div>
            <p class="text-sm text-gray-500">Transaksi Masuk</p>
            <p class="text-2xl font-bold text-gray-900">{{ $totalTransaksiMasuk }}</p>
            <p class="text-xs text-gray-400">Bulan ini</p>
        </div>
    </div>

    {{-- Transaksi Keluar --}}
    <div class="bg-white rounded-xl border border-gray-200 p-5 flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl bg-red-50 flex items-center justify-center flex-shrink-0">
            <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
            </svg>
        </div>
        <div>
            <p class="text-sm text-gray-500">Transaksi Keluar</p>
            <p class="text-2xl font-bold text-gray-900">{{ $totalTransaksiKeluar }}</p>
            <p class="text-xs text-gray-400">Bulan ini</p>
        </div>
    </div>

    {{-- Total Pengguna --}}
    <div class="bg-white rounded-xl border border-gray-200 p-5 flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl bg-purple-50 flex items-center justify-center flex-shrink-0">
            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
            </svg>
        </div>
        <div>
            <p class="text-sm text-gray-500">Total Pengguna</p>
            <p class="text-2xl font-bold text-gray-900">{{ $totalUsers }}</p>
        </div>
    </div>

</div>

{{-- ===== ROW 2: GRAFIK + STOK MENIPIS ===== --}}
<div class="grid grid-cols-1 xl:grid-cols-3 gap-5 mb-6">

    {{-- Grafik Produk per Kategori --}}
    <div class="xl:col-span-2 bg-white rounded-xl border border-gray-200 p-5">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h3 class="text-sm font-semibold text-gray-800">Produk per Kategori</h3>
                <p class="text-xs text-gray-400 mt-0.5">Distribusi jumlah produk berdasarkan kategori</p>
            </div>
        </div>
        <div class="relative h-64">
            <canvas id="chartKategori"></canvas>
        </div>
    </div>

    {{-- Stok Menipis --}}
    <div class="bg-white rounded-xl border border-gray-200 p-5">
        <div class="mb-4">
            <h3 class="text-sm font-semibold text-gray-800">Perlu Perhatian</h3>
            <p class="text-xs text-gray-400 mt-0.5">Produk dengan minimum stok tinggi</p>
        </div>
        <div class="space-y-3">
            @forelse($lowStockProducts as $product)
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2 min-w-0">
                        <div class="w-8 h-8 rounded-lg bg-gray-100 flex items-center justify-center flex-shrink-0">
                            @if($product->image)
                                <img src="{{ asset('images/products/' . $product->image) }}"
                                     class="w-8 h-8 rounded-lg object-cover">
                            @else
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                </svg>
                            @endif
                        </div>
                        <div class="min-w-0">
                            <p class="text-sm font-medium text-gray-800 truncate">{{ $product->name }}</p>
                            <p class="text-xs text-gray-400">{{ $product->category->name }}</p>
                        </div>
                    </div>
                    <span class="text-xs font-semibold px-2 py-1 bg-red-100 text-red-600 rounded-full flex-shrink-0">
                        Min {{ $product->minimum_stock }}
                    </span>
                </div>
            @empty
                <p class="text-sm text-gray-400 text-center py-6">Semua produk dalam kondisi baik.</p>
            @endforelse
        </div>
    </div>

</div>

{{-- ===== ROW 3: AKTIVITAS TERBARU ===== --}}
<div class="bg-white rounded-xl border border-gray-200">
    <div class="flex items-center justify-between px-5 py-4 border-b border-gray-200">
        <div>
            <h3 class="text-sm font-semibold text-gray-800">Aktivitas Terbaru</h3>
            <p class="text-xs text-gray-400 mt-0.5">8 transaksi stok terakhir</p>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Produk</th>
                    <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Tipe</th>
                    <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Jumlah</th>
                    <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Oleh</th>
                    <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Tanggal</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($recentTransactions as $trx)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-5 py-3 font-medium text-gray-800">
                            {{ $trx->product->name ?? '—' }}
                        </td>
                        <td class="px-5 py-3">
                            <span class="inline-flex items-center gap-1 text-xs font-medium px-2.5 py-1 rounded-full
                                {{ $trx->type === 'Masuk' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ $trx->type }}
                            </span>
                        </td>
                        <td class="px-5 py-3 text-gray-600">{{ $trx->quantity }}</td>
                        <td class="px-5 py-3">
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
                        <td class="px-5 py-3 text-gray-500 text-xs">{{ $trx->user->name ?? '—' }}</td>
                        <td class="px-5 py-3 text-gray-500 text-xs">
                            {{ $trx->date ? $trx->date->format('d M Y') : '—' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-5 py-10 text-center text-gray-400 text-sm">
                            Belum ada aktivitas transaksi.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('chartKategori').getContext('2d');

    const labels = @json($stokPerKategori->pluck('name'));
    const data   = @json($stokPerKategori->pluck('products_count'));

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Jumlah Produk',
                data: data,
                backgroundColor: 'rgba(59, 130, 246, 0.15)',
                borderColor: 'rgba(59, 130, 246, 0.8)',
                borderWidth: 2,
                borderRadius: 6,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        font: { size: 11 },
                        color: '#9ca3af',
                    },
                    grid: { color: '#f3f4f6' },
                },
                x: {
                    ticks: {
                        font: { size: 11 },
                        color: '#6b7280',
                    },
                    grid: { display: false },
                }
            }
        }
    });
</script>
@endsection
@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('page-subtitle', 'Selamat datang kembali, ' . Auth::user()->name)

@section('sidebar')
    @include('components.sidebar-staff')
@endsection

@section('content')

{{-- ===== STAT CARDS ===== --}}
<div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-6">

    {{-- Total Pengajuan --}}
    <div class="bg-white rounded-xl border border-gray-200 p-5 flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center flex-shrink-0">
            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
        </div>
        <div>
            <p class="text-sm text-gray-500">Total Pengajuan</p>
            <p class="text-2xl font-bold text-gray-900">{{ $totalPengajuanSaya }}</p>
            <p class="text-xs text-gray-400">Semua transaksi saya</p>
        </div>
    </div>

    {{-- Pending Saya --}}
    <div class="bg-white rounded-xl border border-gray-200 p-5 flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl bg-yellow-50 flex items-center justify-center flex-shrink-0">
            <svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <div>
            <p class="text-sm text-gray-500">Menunggu Konfirmasi</p>
            <p class="text-2xl font-bold text-gray-900">{{ $pendingSaya }}</p>
            <p class="text-xs text-gray-400">Belum diproses manajer</p>
        </div>
    </div>

    {{-- Diproses Hari Ini --}}
    <div class="bg-white rounded-xl border border-gray-200 p-5 flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl bg-green-50 flex items-center justify-center flex-shrink-0">
            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
        </div>
        <div>
            <p class="text-sm text-gray-500">Diproses Hari Ini</p>
            <p class="text-2xl font-bold text-gray-900">{{ $diterimaHariIni }}</p>
            <p class="text-xs text-gray-400">Diterima/Dikeluarkan</p>
        </div>
    </div>

</div>

{{-- ===== RIWAYAT TERBARU ===== --}}
<div class="bg-white rounded-xl border border-gray-200">
    <div class="flex items-center justify-between px-5 py-4 border-b border-gray-200">
        <div>
            <h3 class="text-sm font-semibold text-gray-800">Aktivitas Terbaru Saya</h3>
            <p class="text-xs text-gray-400 mt-0.5">8 transaksi terakhir yang kamu ajukan</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('staff.transaksi-masuk.index') }}"
               class="text-xs text-blue-600 hover:underline">Masuk</a>
            <span class="text-gray-300">|</span>
            <a href="{{ route('staff.transaksi-keluar.index') }}"
               class="text-xs text-blue-600 hover:underline">Keluar</a>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">#</th>
                    <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Produk</th>
                    <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">Tipe</th>
                    <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">Jumlah</th>
                    <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Tanggal</th>
                    <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($riwayatTerbaru as $index => $trx)
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
                        <td class="px-5 py-3 text-gray-500 text-xs">
                            {{ $trx->date?->format('d M Y') ?? '—' }}
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
                        <td colspan="6" class="px-5 py-10 text-center text-gray-400 text-sm">
                            Belum ada aktivitas transaksi.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
@extends('layouts.app')

@section('title', 'Transaksi Keluar')
@section('page-title', 'Transaksi Keluar')
@section('page-subtitle', 'Input dan pantau transaksi barang keluar')

@section('sidebar')
    @include('components.sidebar-staff')
@endsection

@section('content')
<div class="space-y-6">

    {{-- ===== FORM INPUT TRANSAKSI ===== --}}
    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <h3 class="text-sm font-semibold text-gray-800 mb-4">Form Transaksi Keluar Baru</h3>

        <form method="POST" action="{{ route('staff.transaksi-keluar.store') }}">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">

                {{-- Produk --}}
                <div class="md:col-span-2">
                    <label for="product_id" class="block text-sm font-medium text-gray-700 mb-1.5">
                        Produk <span class="text-red-500">*</span>
                    </label>
                    <select id="product_id" name="product_id"
                        class="w-full px-4 py-2.5 text-sm border rounded-lg outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 {{ $errors->has('product_id') ? 'border-red-400 bg-red-50' : 'border-gray-200 bg-slate-50 focus:bg-white' }}">
                        <option value="">-- Pilih Produk --</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}"
                                {{ old('product_id') == $product->id ? 'selected' : '' }}
                                {{ $product->current_stock <= 0 ? 'disabled' : '' }}>
                                {{ $product->name }} — SKU: {{ $product->sku }}
                                (Stok: {{ $product->current_stock }})
                                {{ $product->current_stock <= 0 ? '— STOK HABIS' : '' }}
                            </option>
                        @endforeach
                    </select>
                    @error('product_id')
                        <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Jumlah --}}
                <div>
                    <label for="quantity" class="block text-sm font-medium text-gray-700 mb-1.5">
                        Jumlah <span class="text-red-500">*</span>
                    </label>
                    <input type="number" id="quantity" name="quantity"
                        value="{{ old('quantity') }}" min="1" placeholder="0"
                        class="w-full px-4 py-2.5 text-sm border rounded-lg outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 {{ $errors->has('quantity') ? 'border-red-400 bg-red-50' : 'border-gray-200 bg-slate-50 focus:bg-white' }}">
                    @error('quantity')
                        <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tanggal --}}
                <div>
                    <label for="date" class="block text-sm font-medium text-gray-700 mb-1.5">
                        Tanggal <span class="text-red-500">*</span>
                    </label>
                    <input type="date" id="date" name="date"
                        value="{{ old('date', now()->format('Y-m-d')) }}"
                        class="w-full px-4 py-2.5 text-sm border rounded-lg outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 {{ $errors->has('date') ? 'border-red-400 bg-red-50' : 'border-gray-200 bg-slate-50 focus:bg-white' }}">
                    @error('date')
                        <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Catatan --}}
                <div class="md:col-span-2">
                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-1.5">
                        Catatan <span class="text-gray-400 font-normal">(opsional)</span>
                    </label>
                    <textarea id="notes" name="notes" rows="2"
                        placeholder="Catatan tambahan untuk transaksi ini..."
                        class="w-full px-4 py-2.5 text-sm border border-gray-200 bg-slate-50 rounded-lg outline-none transition focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 resize-none">{{ old('notes') }}</textarea>
                </div>

            </div>

            <button type="submit"
                    class="px-5 py-2.5 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg transition">
                Ajukan Transaksi Keluar
            </button>

        </form>
    </div>

    {{-- ===== RIWAYAT TRANSAKSI STAFF ===== --}}
    <div class="bg-white rounded-xl border border-gray-200">
        <div class="px-5 py-4 border-b border-gray-200">
            <h3 class="text-sm font-semibold text-gray-800">Riwayat Pengajuan Saya</h3>
            <p class="text-xs text-gray-400 mt-0.5">Transaksi keluar yang pernah kamu ajukan</p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">#</th>
                        <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Produk</th>
                        <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">Jumlah</th>
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
                            <td class="px-5 py-3 text-center font-semibold text-red-600">
                                -{{ $trx->quantity }}
                            </td>
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
                            <td colspan="6" class="px-5 py-10 text-center text-gray-400 text-sm">
                                Belum ada transaksi keluar yang diajukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
@extends('layouts.app')

@section('title', 'Daftar Supplier')
@section('page-title', 'Daftar Supplier')
@section('page-subtitle', 'Informasi supplier produk gudang')

@section('sidebar')
    @include('components.sidebar-manager')
@endsection

@section('content')
<div class="bg-white rounded-xl border border-gray-200">

    <div class="px-5 py-4 border-b border-gray-200">
        <p class="text-sm text-gray-500">Total <span class="font-semibold text-gray-800">{{ $suppliers->count() }}</span> supplier</p>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider w-12">#</th>
                    <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama Supplier</th>
                    <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Email</th>
                    <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Telepon</th>
                    <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Alamat</th>
                    <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Jumlah Produk</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($suppliers as $index => $supplier)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-5 py-3 text-gray-500">{{ $index + 1 }}</td>
                        <td class="px-5 py-3 font-medium text-gray-900">{{ $supplier->name }}</td>
                        <td class="px-5 py-3 text-gray-500">{{ $supplier->email ?? '—' }}</td>
                        <td class="px-5 py-3 text-gray-500">{{ $supplier->phone ?? '—' }}</td>
                        <td class="px-5 py-3 text-gray-500 max-w-xs truncate">{{ $supplier->address ?? '—' }}</td>
                        <td class="px-5 py-3 text-gray-500">{{ $supplier->products->count() }} produk</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-5 py-12 text-center text-gray-400 text-sm">
                            Belum ada supplier terdaftar.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
@extends('layouts.app')

@section('title', 'Supplier')
@section('page-title', 'Supplier')
@section('page-subtitle', 'Kelola data supplier produk')

@section('sidebar')
    @include('components.sidebar-admin')
@endsection

@section('content')
<div class="bg-white rounded-xl border border-gray-200">

    {{-- Header --}}
    <div class="flex items-center justify-between px-5 py-4 border-b border-gray-200">
        <p class="text-sm text-gray-500">Total <span class="font-semibold text-gray-800">{{ $suppliers->count() }}</span> supplier</p>
        <a href="{{ route('admin.suppliers.create') }}"
           class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Supplier
        </a>
    </div>

    {{-- Tabel --}}
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider w-12">No</th>
                    <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama Supplier</th>
                    <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Email</th>
                    <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Telepon</th>
                    <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Alamat</th>
                    <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Jumlah Produk</th>
                    <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">Aksi</th>
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
                        <td class="px-5 py-3 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('admin.suppliers.edit', $supplier->id) }}"
                                   class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-blue-600 bg-blue-50 hover:bg-blue-100 rounded-lg transition">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                    Edit
                                </a>
                                <form method="POST" action="{{ route('admin.suppliers.destroy', $supplier->id) }}"
                                      onsubmit="return confirm('Hapus supplier {{ $supplier->name }}? Pastikan tidak ada produk yang menggunakan supplier ini.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-5 py-12 text-center text-gray-400">
                            <svg class="w-10 h-10 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                            Belum ada supplier.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection
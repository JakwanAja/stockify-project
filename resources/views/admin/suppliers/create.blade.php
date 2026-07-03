@extends('layouts.app')

@section('title', 'Tambah Supplier')
@section('page-title', 'Tambah Supplier')
@section('page-subtitle', 'Daftarkan supplier baru')

@section('sidebar')
    @include('components.sidebar-admin')
@endsection

@section('content')
<div class="max-w-xl">
    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <form method="POST" action="{{ route('admin.suppliers.store') }}">
            @csrf

            {{-- Nama --}}
            <div class="mb-5">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1.5">
                    Nama Supplier <span class="text-red-500">*</span>
                </label>
                <input type="text" id="name" name="name" value="{{ old('name') }}"
                    placeholder="Contoh: PT. Maju Bersama"
                    class="w-full px-4 py-2.5 text-sm border rounded-lg outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 {{ $errors->has('name') ? 'border-red-400 bg-red-50' : 'border-gray-200 bg-slate-50 focus:bg-white' }}">
                @error('name')
                    <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Email --}}
            <div class="mb-5">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">
                    Email <span class="text-gray-400 font-normal">(opsional)</span>
                </label>
                <input type="email" id="email" name="email" value="{{ old('email') }}"
                    placeholder="supplier@email.com"
                    class="w-full px-4 py-2.5 text-sm border rounded-lg outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 {{ $errors->has('email') ? 'border-red-400 bg-red-50' : 'border-gray-200 bg-slate-50 focus:bg-white' }}">
                @error('email')
                    <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Telepon --}}
            <div class="mb-5">
                <label for="phone" class="block text-sm font-medium text-gray-700 mb-1.5">
                    Nomor Telepon <span class="text-gray-400 font-normal">(opsional)</span>
                </label>
                <input type="text" id="phone" name="phone" value="{{ old('phone') }}"
                    placeholder="Contoh: 08123456789"
                    class="w-full px-4 py-2.5 text-sm border rounded-lg outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 {{ $errors->has('phone') ? 'border-red-400 bg-red-50' : 'border-gray-200 bg-slate-50 focus:bg-white' }}">
                @error('phone')
                    <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Alamat --}}
            <div class="mb-6">
                <label for="address" class="block text-sm font-medium text-gray-700 mb-1.5">
                    Alamat <span class="text-red-500">*</span>
                </label>
                <textarea id="address" name="address" rows="3"
                    placeholder="Alamat lengkap supplier..."
                    class="w-full px-4 py-2.5 text-sm border border-gray-200 bg-slate-50 rounded-lg outline-none transition focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 resize-none">{{ old('address') }}</textarea>
            </div>

            {{-- Actions --}}
            <div class="flex items-center gap-3">
                <button type="submit"
                        class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition">
                    Simpan Supplier
                </button>
                <a href="{{ route('admin.suppliers.index') }}"
                   class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-lg transition">
                    Batal
                </a>
            </div>

        </form>
    </div>
</div>
@endsection
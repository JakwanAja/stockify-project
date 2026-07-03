@extends('layouts.app')

@section('title', 'Edit Kategori')
@section('page-title', 'Edit Kategori')
@section('page-subtitle', 'Perbarui data kategori')

@section('sidebar')
    @include('components.sidebar-admin')
@endsection

@section('content')
<div class="max-w-xl">
    <div class="bg-white rounded-xl border border-gray-200 p-6">

        <form method="POST" action="{{ route('admin.categories.update', $category->id) }}">
            @csrf
            @method('PUT')

            {{-- Nama --}}
            <div class="mb-5">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1.5">
                    Nama Kategori <span class="text-red-500">*</span>
                </label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name', $category->name) }}"
                    placeholder="Contoh: Elektronik"
                    class="w-full px-4 py-2.5 text-sm border rounded-lg outline-none transition
                           focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20
                           {{ $errors->has('name') ? 'border-red-400 bg-red-50' : 'border-gray-200 bg-slate-50 focus:bg-white' }}"
                >
                @error('name')
                    <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Deskripsi --}}
            <div class="mb-6">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1.5">
                    Deskripsi <span class="text-gray-400 font-normal">(opsional)</span>
                </label>
                <textarea
                    id="description"
                    name="description"
                    rows="3"
                    placeholder="Deskripsi singkat kategori ini..."
                    class="w-full px-4 py-2.5 text-sm border border-gray-200 bg-slate-50 rounded-lg outline-none transition focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 resize-none"
                >{{ old('description', $category->description) }}</textarea>
            </div>

            {{-- Actions --}}
            <div class="flex items-center gap-3">
                <button type="submit"
                        class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition">
                    Perbarui Kategori
                </button>
                <a href="{{ route('admin.categories.index') }}"
                   class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-lg transition">
                    Batal
                </a>
            </div>

        </form>
    </div>
</div>
@endsection
@extends('layouts.app')

@section('title', 'Edit Produk')
@section('page-title', 'Edit Produk')
@section('page-subtitle', 'Perbarui data produk')

@section('sidebar')
    @include('components.sidebar-admin')
@endsection

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <form method="POST" action="{{ route('admin.products.update', $product->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">

                {{-- Nama Produk --}}
                <div class="md:col-span-2">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1.5">
                        Nama Produk <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}"
                        class="w-full px-4 py-2.5 text-sm border rounded-lg outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 {{ $errors->has('name') ? 'border-red-400 bg-red-50' : 'border-gray-200 bg-slate-50 focus:bg-white' }}">
                    @error('name') <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                {{-- SKU --}}
                <div>
                    <label for="sku" class="block text-sm font-medium text-gray-700 mb-1.5">
                        SKU <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="sku" name="sku" value="{{ old('sku', $product->sku) }}"
                        class="w-full px-4 py-2.5 text-sm border rounded-lg outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 {{ $errors->has('sku') ? 'border-red-400 bg-red-50' : 'border-gray-200 bg-slate-50 focus:bg-white' }}">
                    @error('sku') <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                {{-- Minimum Stok --}}
                <div>
                    <label for="minimum_stock" class="block text-sm font-medium text-gray-700 mb-1.5">
                        Minimum Stok <span class="text-red-500">*</span>
                    </label>
                    <input type="number" id="minimum_stock" name="minimum_stock" value="{{ old('minimum_stock', $product->minimum_stock) }}"
                        min="0"
                        class="w-full px-4 py-2.5 text-sm border rounded-lg outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 {{ $errors->has('minimum_stock') ? 'border-red-400 bg-red-50' : 'border-gray-200 bg-slate-50 focus:bg-white' }}">
                    @error('minimum_stock') <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                {{-- Kategori --}}
                <div>
                    <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1.5">
                        Kategori <span class="text-red-500">*</span>
                    </label>
                    <select id="category_id" name="category_id"
                        class="w-full px-4 py-2.5 text-sm border rounded-lg outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 border-gray-200 bg-slate-50 focus:bg-white">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id') <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                {{-- Supplier --}}
                <div>
                    <label for="supplier_id" class="block text-sm font-medium text-gray-700 mb-1.5">
                        Supplier <span class="text-red-500">*</span>
                    </label>
                    <select id="supplier_id" name="supplier_id"
                        class="w-full px-4 py-2.5 text-sm border rounded-lg outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 border-gray-200 bg-slate-50 focus:bg-white">
                        <option value="">-- Pilih Supplier --</option>
                        @foreach($suppliers as $supplier)
                            <option value="{{ $supplier->id }}" {{ old('supplier_id', $product->supplier_id) == $supplier->id ? 'selected' : '' }}>
                                {{ $supplier->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('supplier_id') <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                {{-- Harga Beli --}}
                <div>
                    <label for="purchase_price" class="block text-sm font-medium text-gray-700 mb-1.5">
                        Harga Beli <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm text-gray-400 font-medium">Rp</span>
                        <input type="number" id="purchase_price" name="purchase_price" value="{{ old('purchase_price', $product->purchase_price) }}"
                            min="0" step="100"
                            class="w-full pl-10 pr-4 py-2.5 text-sm border rounded-lg outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 border-gray-200 bg-slate-50 focus:bg-white">
                    </div>
                    @error('purchase_price') <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                {{-- Harga Jual --}}
                <div>
                    <label for="selling_price" class="block text-sm font-medium text-gray-700 mb-1.5">
                        Harga Jual <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm text-gray-400 font-medium">Rp</span>
                        <input type="number" id="selling_price" name="selling_price" value="{{ old('selling_price', $product->selling_price) }}"
                            min="0" step="100"
                            class="w-full pl-10 pr-4 py-2.5 text-sm border rounded-lg outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 border-gray-200 bg-slate-50 focus:bg-white">
                    </div>
                    @error('selling_price') <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

            </div>

            {{-- Deskripsi --}}
            <div class="mb-5">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1.5">
                    Deskripsi <span class="text-gray-400 font-normal">(opsional)</span>
                </label>
                <textarea id="description" name="description" rows="3"
                    class="w-full px-4 py-2.5 text-sm border border-gray-200 bg-slate-50 rounded-lg outline-none transition focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 resize-none">{{ old('description', $product->description) }}</textarea>
            </div>

            {{-- Gambar --}}
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                    Gambar Produk <span class="text-gray-400 font-normal">(opsional — kosongkan jika tidak ingin mengubah)</span>
                </label>

                {{-- Preview gambar saat ini --}}
                @if($product->image)
                    <div class="mb-3 flex items-center gap-3">
                        <img src="{{ asset('images/products/' . $product->image) }}"
                             alt="{{ $product->name }}"
                             class="w-20 h-20 rounded-lg object-cover border border-gray-200">
                        <p class="text-xs text-gray-400">Gambar saat ini. Upload baru untuk mengganti.</p>
                    </div>
                @endif

                <div class="border-2 border-dashed border-gray-200 rounded-lg p-6 text-center hover:border-blue-400 transition cursor-pointer"
                     onclick="document.getElementById('image').click()">
                    <div id="image-preview-wrapper">
                        <svg class="w-8 h-8 mx-auto text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <p class="text-sm text-gray-400">Klik untuk upload gambar baru</p>
                    </div>
                    <img id="image-preview" src="" alt="Preview" class="hidden mx-auto max-h-40 rounded-lg object-contain">
                </div>
                <input type="file" id="image" name="image" accept="image/*" class="hidden" onchange="previewImage(this)">
                @error('image') <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p> @enderror
            </div>
            <div class="mb-6">
                <div class="flex items-center justify-between mb-3">
                    <div>
                        <h3 class="text-sm font-semibold text-gray-800">Atribut Produk</h3>
                        <p class="text-xs text-gray-400 mt-0.5">Contoh: Warna → Merah, Ukuran → XL</p>
                    </div>
                    <button type="button" onclick="addAttribute()"
                            class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-blue-600 bg-blue-50 hover:bg-blue-100 rounded-lg transition">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Tambah Atribut
                    </button>
                </div>

                <div id="attributes-container" class="space-y-2">
                    {{-- Atribut existing dari database --}}
                    @foreach($attributes as $attr)
                        <div class="flex items-center gap-2 attribute-row">
                            <input type="text" name="attributes[{{ $loop->index }}][name]"
                                value="{{ $attr->name }}"
                                placeholder="Nama (contoh: Warna)"
                                class="flex-1 px-3 py-2 text-sm border border-gray-200 bg-slate-50 rounded-lg outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 focus:bg-white transition">
                            <input type="text" name="attributes[{{ $loop->index }}][value]"
                                value="{{ $attr->value }}"
                                placeholder="Nilai (contoh: Merah)"
                                class="flex-1 px-3 py-2 text-sm border border-gray-200 bg-slate-50 rounded-lg outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 focus:bg-white transition">
                            <button type="button" onclick="removeAttribute(this)"
                                    class="p-2 text-red-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition flex-shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                    @endforeach
                </div>
                <div id="attributes-empty"
                    class="{{ $attributes->count() > 0 ? 'hidden' : '' }} mt-3 p-4 border border-dashed border-gray-200 rounded-lg text-center">
                    <p class="text-xs text-gray-400">Belum ada atribut. Klik "Tambah Atribut" untuk menambahkan.</p>
                </div>
            </div>
            {{-- Actions --}}
            <div class="flex items-center gap-3">
                <button type="submit"
                        class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition">
                    Perbarui Produk
                </button>
                <a href="{{ route('admin.products.index') }}"
                   class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-lg transition">
                    Batal
                </a>
            </div>

        </form>
    </div>
</div>

<script>
    function previewImage(input) {
        const preview = document.getElementById('image-preview');
        const wrapper = document.getElementById('image-preview-wrapper');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = (e) => {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                wrapper.classList.add('hidden');
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    let attrIndex = {{ $attributes->count() }};
    
    function addAttribute() {
        const container = document.getElementById('attributes-container');
        const empty     = document.getElementById('attributes-empty');
    
        const row = document.createElement('div');
        row.className = 'flex items-center gap-2 attribute-row';
        row.innerHTML = `
            <input type="text" name="attributes[${attrIndex}][name]"
                   placeholder="Nama (contoh: Ukuran)"
                   class="flex-1 px-3 py-2 text-sm border border-gray-200 bg-slate-50 rounded-lg outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 focus:bg-white transition">
            <input type="text" name="attributes[${attrIndex}][value]"
                   placeholder="Nilai (contoh: XL)"
                   class="flex-1 px-3 py-2 text-sm border border-gray-200 bg-slate-50 rounded-lg outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 focus:bg-white transition">
            <button type="button" onclick="removeAttribute(this)"
                    class="p-2 text-red-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition flex-shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        `;
    
        container.appendChild(row);
        empty.classList.add('hidden');
        attrIndex++;
    }
    
    function removeAttribute(btn) {
        const row       = btn.closest('.attribute-row');
        const container = document.getElementById('attributes-container');
        row.remove();
    
        if (container.querySelectorAll('.attribute-row').length === 0) {
            document.getElementById('attributes-empty').classList.remove('hidden');
        }
    }
    </script>
@endsection
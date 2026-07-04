@extends('layouts.app')

@section('title', 'Tambah Produk')
@section('page-title', 'Tambah Produk')
@section('page-subtitle', 'Daftarkan produk baru ke gudang')

@section('sidebar')
    @include('components.sidebar-admin')
@endsection

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
            @csrf

            {{-- Grid 2 kolom --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">

                {{-- Nama Produk --}}
                <div class="md:col-span-2">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1.5">
                        Nama Produk <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}"
                        placeholder="Contoh: Laptop ASUS VivoBook"
                        class="w-full px-4 py-2.5 text-sm border rounded-lg outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 {{ $errors->has('name') ? 'border-red-400 bg-red-50' : 'border-gray-200 bg-slate-50 focus:bg-white' }}">
                    @error('name')
                        <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- SKU --}}
                <div>
                    <label for="sku" class="block text-sm font-medium text-gray-700 mb-1.5">
                        SKU <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="sku" name="sku" value="{{ old('sku') }}"
                        placeholder="Contoh: LPT-ASUS-001"
                        class="w-full px-4 py-2.5 text-sm border rounded-lg outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 {{ $errors->has('sku') ? 'border-red-400 bg-red-50' : 'border-gray-200 bg-slate-50 focus:bg-white' }}">
                    @error('sku')
                        <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Minimum Stok --}}
                <div>
                    <label for="minimum_stock" class="block text-sm font-medium text-gray-700 mb-1.5">
                        Minimum Stok <span class="text-red-500">*</span>
                    </label>
                    <input type="number" id="minimum_stock" name="minimum_stock" value="{{ old('minimum_stock', 0) }}"
                        min="0" placeholder="0"
                        class="w-full px-4 py-2.5 text-sm border rounded-lg outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 {{ $errors->has('minimum_stock') ? 'border-red-400 bg-red-50' : 'border-gray-200 bg-slate-50 focus:bg-white' }}">
                    @error('minimum_stock')
                        <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Kategori --}}
                <div>
                    <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1.5">
                        Kategori <span class="text-red-500">*</span>
                    </label>
                    <select id="category_id" name="category_id"
                        class="w-full px-4 py-2.5 text-sm border rounded-lg outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 {{ $errors->has('category_id') ? 'border-red-400 bg-red-50' : 'border-gray-200 bg-slate-50 focus:bg-white' }}">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Supplier --}}
                <div>
                    <label for="supplier_id" class="block text-sm font-medium text-gray-700 mb-1.5">
                        Supplier <span class="text-red-500">*</span>
                    </label>
                    <select id="supplier_id" name="supplier_id"
                        class="w-full px-4 py-2.5 text-sm border rounded-lg outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 {{ $errors->has('supplier_id') ? 'border-red-400 bg-red-50' : 'border-gray-200 bg-slate-50 focus:bg-white' }}">
                        <option value="">-- Pilih Supplier --</option>
                        @foreach($suppliers as $supplier)
                            <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                {{ $supplier->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('supplier_id')
                        <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Harga Beli --}}
                <div>
                    <label for="purchase_price" class="block text-sm font-medium text-gray-700 mb-1.5">
                        Harga Beli <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm text-gray-400 font-medium">Rp</span>
                        <input type="number" id="purchase_price" name="purchase_price" value="{{ old('purchase_price') }}"
                            min="0" step="100" placeholder="0"
                            class="w-full pl-10 pr-4 py-2.5 text-sm border rounded-lg outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 {{ $errors->has('purchase_price') ? 'border-red-400 bg-red-50' : 'border-gray-200 bg-slate-50 focus:bg-white' }}">
                    </div>
                    @error('purchase_price')
                        <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Harga Jual --}}
                <div>
                    <label for="selling_price" class="block text-sm font-medium text-gray-700 mb-1.5">
                        Harga Jual <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm text-gray-400 font-medium">Rp</span>
                        <input type="number" id="selling_price" name="selling_price" value="{{ old('selling_price') }}"
                            min="0" step="100" placeholder="0"
                            class="w-full pl-10 pr-4 py-2.5 text-sm border rounded-lg outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 {{ $errors->has('selling_price') ? 'border-red-400 bg-red-50' : 'border-gray-200 bg-slate-50 focus:bg-white' }}">
                    </div>
                    @error('selling_price')
                        <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            {{-- Deskripsi --}}
            <div class="mb-5">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1.5">
                    Deskripsi <span class="text-gray-400 font-normal">(opsional)</span>
                </label>
                <textarea id="description" name="description" rows="3"
                    placeholder="Deskripsi singkat produk..."
                    class="w-full px-4 py-2.5 text-sm border border-gray-200 bg-slate-50 rounded-lg outline-none transition focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 resize-none">{{ old('description') }}</textarea>
            </div>

            {{-- Upload Gambar --}}
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">
                    Gambar Produk <span class="text-gray-400 font-normal">(opsional)</span>
                </label>
                <div class="border-2 border-dashed border-gray-200 rounded-lg p-6 text-center hover:border-blue-400 transition cursor-pointer"
                     onclick="document.getElementById('image').click()">
                    <div id="image-preview-wrapper">
                        <svg class="w-10 h-10 mx-auto text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <p class="text-sm text-gray-400">Klik untuk upload gambar</p>
                        <p class="text-xs text-gray-300 mt-1">JPG, PNG, WEBP — Maks. 2MB</p>
                    </div>
                    <img id="image-preview" src="" alt="Preview" class="hidden mx-auto max-h-40 rounded-lg object-contain">
                </div>
                <input type="file" id="image" name="image" accept="image/*" class="hidden"
                       onchange="previewImage(this)">
                @error('image')
                    <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Actions --}}
            <div class="flex items-center gap-3">
                <button type="submit"
                        class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition">
                    Simpan Produk
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
</script>
@endsection
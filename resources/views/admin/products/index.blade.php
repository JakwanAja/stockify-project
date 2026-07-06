@extends('layouts.app')

@section('title', 'Produk')
@section('page-title', 'Produk')
@section('page-subtitle', 'Kelola data produk gudang')

@section('sidebar')
    @include('components.sidebar-admin')
@endsection

@section('content')
<div class="bg-white rounded-xl border border-gray-200">

    {{-- Header --}}
    <div class="flex items-center justify-between px-5 py-4 border-b border-gray-200">
        <p class="text-sm text-gray-500">Total <span class="font-semibold text-gray-800">{{ $products->count() }}</span> produk</p>
        <button onclick="openCreateModal()"
                class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Produk
        </button>
    </div>

    {{-- Tabel --}}
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider w-12">#</th>
                    <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Produk</th>
                    <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">SKU</th>
                    <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Kategori</th>
                    <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Supplier</th>
                    <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Harga Beli</th>
                    <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Harga Jual</th>
                    <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">Min. Stok</th>
                    <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">Stok</th>
                    <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($products as $index => $product)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-5 py-3 text-gray-500">{{ $index + 1 }}</td>
                        <td class="px-5 py-3">
                            <div class="flex items-center gap-3">
                                @if($product->image)
                                    <img src="{{ asset('images/products/' . $product->image) }}"
                                         alt="{{ $product->name }}"
                                         class="w-10 h-10 rounded-lg object-cover border border-gray-200">
                                @else
                                    <div class="w-10 h-10 rounded-lg bg-gray-100 border border-gray-200 flex items-center justify-center">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                        </svg>
                                    </div>
                                @endif
                                <div>
                                    <p class="font-medium text-gray-900">{{ $product->name }}</p>
                                    @if($product->description)
                                        <p class="text-xs text-gray-400 truncate max-w-xs">{{ Str::limit($product->description, 40) }}</p>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-3">
                            <span class="font-mono text-xs bg-gray-100 px-2 py-1 rounded">{{ $product->sku }}</span>
                        </td>
                        <td class="px-5 py-3 text-gray-600">{{ $product->category->name }}</td>
                        <td class="px-5 py-3 text-gray-600">{{ $product->supplier->name }}</td>
                        <td class="px-5 py-3 text-gray-600">Rp {{ number_format($product->purchase_price, 0, ',', '.') }}</td>
                        <td class="px-5 py-3 text-gray-600">Rp {{ number_format($product->selling_price, 0, ',', '.') }}</td>
                        <td class="px-5 py-3 text-center">
                            <span class="text-xs font-medium px-2 py-1 rounded-full {{ $product->minimum_stock <= 5 ? 'bg-red-100 text-red-600' : 'bg-gray-100 text-gray-600' }}">
                                {{ $product->minimum_stock }}
                            </span>
                        </td>
                        {{-- Cell Stok Aktual --}}
                        <td class="px-5 py-3 text-center">
                            @php $stok = $stockMap[$product->id] ?? 0; @endphp
                            <span class="text-xs font-semibold px-2.5 py-1 rounded-full
                                {{ $stok <= $product->minimum_stock ? 'bg-red-100 text-red-600' : 'bg-green-100 text-green-700' }}">
                                {{ $stok }}
                            </span>
                        </td>
                        <td class="px-5 py-3 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('admin.products.edit', $product->id) }}"
                                   class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-blue-600 bg-blue-50 hover:bg-blue-100 rounded-lg transition">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                    Edit
                                </a>
                                <form id="delete-product-{{ $product->id }}" method="POST"
                                      action="{{ route('admin.products.destroy', $product->id) }}">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                <button onclick="showDeleteModal('delete-product-{{ $product->id }}', '{{ $product->name }}')"
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                    Hapus
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="px-5 py-12 text-center text-gray-400">
                            <svg class="w-10 h-10 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                            Belum ada produk. Tambahkan produk pertama!
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

{{-- ===== MODAL CREATE PRODUK ===== --}}
<div id="modal-create-product"
     class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm">

    {{-- Wrapper modal: flex-col agar header/body/footer bisa dipisah --}}
    <div class="relative bg-white rounded-2xl shadow-xl w-full max-w-2xl mx-4 max-h-[90vh] flex flex-col">

        {{-- Modal Header — flex-shrink-0 agar tidak ikut scroll --}}
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 flex-shrink-0 rounded-t-2xl">
            <h3 class="text-lg font-semibold text-gray-900">Tambah Produk Baru</h3>
            <button onclick="closeCreateModal()" class="text-gray-400 hover:text-gray-600 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Modal Body — flex-1 + overflow-y-auto = bagian ini yang jadi scrollable --}}
        <div class="px-6 py-5 overflow-y-auto flex-1">

            {{-- Validation Errors --}}
            @if($errors->any())
                <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                    <ul class="text-sm text-red-600 space-y-1">
                        @foreach($errors->all() as $error)
                            <li>• {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Form tanpa footer (tombol dipindah ke luar) --}}
            <form id="form-create-product" method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">

                    {{-- Nama Produk --}}
                    <div class="md:col-span-2">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1.5">
                            Nama Produk <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}"
                            placeholder="Contoh: Laptop ASUS VivoBook"
                            class="w-full px-4 py-2.5 text-sm border rounded-lg outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 {{ $errors->has('name') ? 'border-red-400 bg-red-50' : 'border-gray-200 bg-slate-50 focus:bg-white' }}">
                    </div>

                    {{-- SKU --}}
                    <div>
                        <label for="sku" class="block text-sm font-medium text-gray-700 mb-1.5">
                            SKU <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="sku" name="sku" value="{{ old('sku') }}"
                            placeholder="Contoh: LPT-ASUS-001"
                            class="w-full px-4 py-2.5 text-sm border rounded-lg outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 {{ $errors->has('sku') ? 'border-red-400 bg-red-50' : 'border-gray-200 bg-slate-50 focus:bg-white' }}">
                    </div>

                    {{-- Minimum Stok --}}
                    <div>
                        <label for="minimum_stock" class="block text-sm font-medium text-gray-700 mb-1.5">
                            Minimum Stok <span class="text-red-500">*</span>
                        </label>
                        <input type="number" id="minimum_stock" name="minimum_stock" value="{{ old('minimum_stock', 0) }}"
                            min="0"
                            class="w-full px-4 py-2.5 text-sm border rounded-lg outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 {{ $errors->has('minimum_stock') ? 'border-red-400 bg-red-50' : 'border-gray-200 bg-slate-50 focus:bg-white' }}">
                    </div>
                    <td class="px-5 py-3 text-center">
                        @php $stok = $stockMap[$product->id] ?? 0; @endphp
                        <span class="text-xs font-semibold px-2.5 py-1 rounded-full
                            {{ $stok <= $product->minimum_stock ? 'bg-red-100 text-red-600' : 'bg-green-100 text-green-700' }}">
                            {{ $stok }}
                        </span>
                    </td>

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
                    </div>

                </div>

                {{-- Deskripsi --}}
                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1.5">
                        Deskripsi <span class="text-gray-400 font-normal">(opsional)</span>
                    </label>
                    <textarea id="description" name="description" rows="2"
                        placeholder="Deskripsi singkat produk..."
                        class="w-full px-4 py-2.5 text-sm border border-gray-200 bg-slate-50 rounded-lg outline-none transition focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 resize-none">{{ old('description') }}</textarea>
                </div>

                {{-- Upload Gambar --}}
                <div class="mb-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">
                        Gambar Produk <span class="text-gray-400 font-normal">(opsional)</span>
                    </label>
                    <div class="border-2 border-dashed border-gray-200 rounded-lg p-5 text-center hover:border-blue-400 transition cursor-pointer"
                         onclick="document.getElementById('modal-image').click()">
                        <div id="modal-image-preview-wrapper">
                            <svg class="w-8 h-8 mx-auto text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <p class="text-sm text-gray-400">Klik untuk upload gambar</p>
                            <p class="text-xs text-gray-300 mt-1">JPG, PNG, WEBP — Maks. 2MB</p>
                        </div>
                        <img id="modal-image-preview" src="" alt="Preview" class="hidden mx-auto max-h-32 rounded-lg object-contain">
                    </div>
                    <input type="file" id="modal-image" name="image" accept="image/*" class="hidden"
                           onchange="previewModalImage(this)">
                </div>

            </form>
        </div>

        {{-- Modal Footer — flex-shrink-0, selalu terlihat, tidak ikut scroll --}}
        <div class="flex items-center gap-3 px-6 py-4 border-t border-gray-100 flex-shrink-0 rounded-b-2xl bg-white">
            <button type="submit" form="form-create-product"
                    class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition">
                Simpan Produk
            </button>
            <button type="button" onclick="closeCreateModal()"
                    class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-lg transition">
                Batal
            </button>
        </div>

    </div>
</div>

<script>
    function openCreateModal() {
        const modal = document.getElementById('modal-create-product');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeCreateModal() {
        const modal = document.getElementById('modal-create-product');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    // Tutup modal kalau klik background
    document.getElementById('modal-create-product').addEventListener('click', function(e) {
        if (e.target === this) closeCreateModal();
    });

    // Auto buka modal kalau ada validation error (setelah submit gagal)
    @if($errors->any())
        openCreateModal();
    @endif

    function previewModalImage(input) {
        const preview = document.getElementById('modal-image-preview');
        const wrapper = document.getElementById('modal-image-preview-wrapper');
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
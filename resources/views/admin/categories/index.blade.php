@extends('layouts.app')

@section('title', 'Kategori')
@section('page-title', 'Kategori')
@section('page-subtitle', 'Kelola data kategori produk')

@section('sidebar')
    @include('components.sidebar-admin')
@endsection

@section('content')
<div class="bg-white rounded-xl border border-gray-200">

    {{-- Header Tabel --}}
    <div class="flex items-center justify-between px-5 py-4 border-b border-gray-200">
        <p class="text-sm text-gray-500">Total <span class="font-semibold text-gray-800">{{ $categories->count() }}</span> kategori</p>
        <button onclick="openCreateModal()"
                class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Kategori
        </button>
    </div>

    {{-- Tabel --}}
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider w-12">No</th>
                    <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama Kategori</th>
                    <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Deskripsi</th>
                    <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Jumlah Produk</th>
                    <th class="px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($categories as $index => $category)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-5 py-3 text-gray-500">{{ $index + 1 }}</td>
                        <td class="px-5 py-3 font-medium text-gray-900">{{ $category->name }}</td>
                        <td class="px-5 py-3 text-gray-500">{{ $category->description ?? '—' }}</td>
                        <td class="px-5 py-3 text-gray-500">{{ $category->products->count() }} produk</td>
                        <td class="px-5 py-3 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <button onclick="openEditModal({{ $category->id }}, '{{ addslashes($category->name) }}', '{{ addslashes($category->description ?? '') }}')"
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-blue-600 bg-blue-50 hover:bg-blue-100 rounded-lg transition">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                    Edit
                                </button>
                                <form id="delete-category-{{ $category->id }}"
                                      method="POST"
                                      action="{{ route('admin.categories.destroy', $category->id) }}">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                <button onclick="showDeleteModal('delete-category-{{ $category->id }}', '{{ $category->name }}')"
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
                        <td colspan="5" class="px-5 py-12 text-center text-gray-400">
                            <svg class="w-10 h-10 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                            </svg>
                            Belum ada kategori. Tambahkan kategori pertama!
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

{{-- ===== MODAL CREATE KATEGORI ===== --}}
<div id="modal-create-category"
     class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm">

    <div class="relative bg-white rounded-2xl shadow-xl w-full max-w-lg mx-4 max-h-[90vh] flex flex-col">

        {{-- Header --}}
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 flex-shrink-0 rounded-t-2xl">
            <h3 class="text-lg font-semibold text-gray-900">Tambah Kategori Baru</h3>
            <button onclick="closeCreateModal()" class="text-gray-400 hover:text-gray-600 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Body --}}
        <div class="px-6 py-5 overflow-y-auto flex-1">

            @if($errors->any() && !session('edit_mode'))
                <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                    <ul class="text-sm text-red-600 space-y-1">
                        @foreach($errors->all() as $error)
                            <li>• {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form id="form-create-category" method="POST" action="{{ route('admin.categories.store') }}">
                @csrf

                {{-- Nama --}}
                <div class="mb-5">
                    <label for="create-name" class="block text-sm font-medium text-gray-700 mb-1.5">
                        Nama Kategori <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="create-name" name="name" value="{{ old('name') }}"
                        placeholder="Contoh: Elektronik"
                        class="w-full px-4 py-2.5 text-sm border rounded-lg outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 {{ $errors->has('name') && !session('edit_mode') ? 'border-red-400 bg-red-50' : 'border-gray-200 bg-slate-50 focus:bg-white' }}">
                    @if($errors->has('name') && !session('edit_mode'))
                        <p class="mt-1.5 text-xs text-red-500">{{ $errors->first('name') }}</p>
                    @endif
                </div>

                {{-- Deskripsi --}}
                <div class="mb-2">
                    <label for="create-description" class="block text-sm font-medium text-gray-700 mb-1.5">
                        Deskripsi <span class="text-gray-400 font-normal">(opsional)</span>
                    </label>
                    <textarea id="create-description" name="description" rows="3"
                        placeholder="Deskripsi singkat kategori ini..."
                        class="w-full px-4 py-2.5 text-sm border border-gray-200 bg-slate-50 rounded-lg outline-none transition focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 resize-none">{{ old('description') }}</textarea>
                </div>

            </form>
        </div>

        {{-- Footer --}}
        <div class="flex items-center gap-3 px-6 py-4 border-t border-gray-100 flex-shrink-0 rounded-b-2xl bg-white">
            <button type="submit" form="form-create-category"
                    class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition">
                Simpan Kategori
            </button>
            <button type="button" onclick="closeCreateModal()"
                    class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-lg transition">
                Batal
            </button>
        </div>

    </div>
</div>

{{-- ===== MODAL EDIT KATEGORI ===== --}}
<div id="modal-edit-category"
     class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm">

    <div class="relative bg-white rounded-2xl shadow-xl w-full max-w-lg mx-4 max-h-[90vh] flex flex-col">

        {{-- Header --}}
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 flex-shrink-0 rounded-t-2xl">
            <h3 class="text-lg font-semibold text-gray-900">Edit Kategori</h3>
            <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Body --}}
        <div class="px-6 py-5 overflow-y-auto flex-1">

            @if($errors->any() && session('edit_mode'))
                <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                    <ul class="text-sm text-red-600 space-y-1">
                        @foreach($errors->all() as $error)
                            <li>• {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form id="form-edit-category" method="POST" action="" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Nama --}}
                <div class="mb-5">
                    <label for="edit-name" class="block text-sm font-medium text-gray-700 mb-1.5">
                        Nama Kategori <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="edit-name" name="name"
                        placeholder="Contoh: Elektronik"
                        class="w-full px-4 py-2.5 text-sm border rounded-lg outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 {{ $errors->has('name') && session('edit_mode') ? 'border-red-400 bg-red-50' : 'border-gray-200 bg-slate-50 focus:bg-white' }}">
                    @if($errors->has('name') && session('edit_mode'))
                        <p class="mt-1.5 text-xs text-red-500">{{ $errors->first('name') }}</p>
                    @endif
                </div>

                {{-- Deskripsi --}}
                <div class="mb-2">
                    <label for="edit-description" class="block text-sm font-medium text-gray-700 mb-1.5">
                        Deskripsi <span class="text-gray-400 font-normal">(opsional)</span>
                    </label>
                    <textarea id="edit-description" name="description" rows="3"
                        placeholder="Deskripsi singkat kategori ini..."
                        class="w-full px-4 py-2.5 text-sm border border-gray-200 bg-slate-50 rounded-lg outline-none transition focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 resize-none"></textarea>
                </div>

            </form>
        </div>

        {{-- Footer --}}
        <div class="flex items-center gap-3 px-6 py-4 border-t border-gray-100 flex-shrink-0 rounded-b-2xl bg-white">
            <button type="submit" form="form-edit-category"
                    class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition">
                Perbarui Kategori
            </button>
            <button type="button" onclick="closeEditModal()"
                    class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-lg transition">
                Batal
            </button>
        </div>

    </div>
</div>

<script>
    // ===== MODAL CREATE =====
    function openCreateModal() {
        document.getElementById('modal-create-category').classList.remove('hidden');
        document.getElementById('modal-create-category').classList.add('flex');
    }

    function closeCreateModal() {
        document.getElementById('modal-create-category').classList.add('hidden');
        document.getElementById('modal-create-category').classList.remove('flex');
    }

    document.getElementById('modal-create-category').addEventListener('click', function(e) {
        if (e.target === this) closeCreateModal();
    });

    // ===== MODAL EDIT =====
    function openEditModal(id, name, description) {
        const form = document.getElementById('form-edit-category');
        form.action = `/admin/categories/${id}`;

        document.getElementById('edit-name').value = name;
        document.getElementById('edit-description').value = description;

        document.getElementById('modal-edit-category').classList.remove('hidden');
        document.getElementById('modal-edit-category').classList.add('flex');
    }

    function closeEditModal() {
        document.getElementById('modal-edit-category').classList.add('hidden');
        document.getElementById('modal-edit-category').classList.remove('flex');
    }

    document.getElementById('modal-edit-category').addEventListener('click', function(e) {
        if (e.target === this) closeEditModal();
    });

    @if($errors->any())
        @if(session('edit_mode'))
            openEditModal(
                {{ session('edit_id') }},
                '{{ addslashes(old('name', '')) }}',
                '{{ addslashes(old('description', '')) }}'
            );
        @else
            openCreateModal();
        @endif
    @endif
</script>
@endsection
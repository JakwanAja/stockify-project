<?php

namespace App\Http\Controllers\Admin;

use App\Services\Admin\CategoryService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class CategoryController extends Controller
{
    public function __construct(
        protected CategoryService $service
    ) {}

    public function index()
    {
        $categories = $this->service->getAllCategories();
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:45|unique:categories,name',
            'description' => 'nullable|string|max:255',
        ], [
            'name.required' => 'Nama kategori wajib diisi.',
            'name.unique'   => 'Nama kategori sudah ada.',
            'name.max'      => 'Nama kategori maksimal 45 karakter.',
        ]);

        $this->service->createCategory($request->all());

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit(int $id)
    {
        $category = $this->service->getCategoryById($id);
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, int $id)
    {
        $request->validate([
            'name'        => 'required|string|max:45|unique:categories,name,' . $id,
            'description' => 'nullable|string|max:255',
        ], [
            'name.required' => 'Nama kategori wajib diisi.',
            'name.unique'   => 'Nama kategori sudah ada.',
            'name.max'      => 'Nama kategori maksimal 45 karakter.',
        ]);

        $this->service->updateCategory($id, $request->all());

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(int $id)
    {
        $this->service->deleteCategory($id);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }
}
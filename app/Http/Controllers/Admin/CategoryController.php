<?php

namespace App\Http\Controllers\Admin;

use App\Services\Admin\CategoryService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;

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
        return redirect()->route('admin.categories.index');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'        => 'required|string|max:45|unique:categories,name',
            'description' => 'nullable|string|max:255',
        ], [
            'name.required' => 'Nama kategori wajib diisi.',
            'name.unique'   => 'Nama kategori sudah ada.',
            'name.max'      => 'Nama kategori maksimal 45 karakter.',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.categories.index')
                ->withErrors($validator)
                ->withInput();
            // Tidak flash edit_mode → blade akan buka modal CREATE
        }

        $this->service->createCategory($request->all());

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori berhasil ditambahkan.');
    }

    // Tidak diperlukan lagi, redirect ke index
    public function edit(int $id)
    {
        return redirect()->route('admin.categories.index');
    }

    public function update(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'name'        => 'required|string|max:45|unique:categories,name,' . $id,
            'description' => 'nullable|string|max:255',
        ], [
            'name.required' => 'Nama kategori wajib diisi.',
            'name.unique'   => 'Nama kategori sudah ada.',
            'name.max'      => 'Nama kategori maksimal 45 karakter.',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.categories.index')
                ->withErrors($validator)
                ->withInput()
                ->with('edit_mode', true)
                ->with('edit_id', $id);
            // Flash edit_mode + edit_id → blade akan buka modal EDIT
        }

        $this->service->updateCategory($id, $request->all());

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori berhasui diperbarui.');
    }

    public function destroy(int $id)
    {
        $this->service->deleteCategory($id);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }
}
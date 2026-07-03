<?php

namespace App\Http\Controllers\Admin;

use App\Services\Admin\SupplierService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class SupplierController extends Controller
{
    public function __construct(
        protected SupplierService $service
    ) {}

    public function index()
    {
        $suppliers = $this->service->getAllSuppliers();
        return view('admin.suppliers.index', compact('suppliers'));
    }

    public function create()
    {
        return view('admin.suppliers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:45|unique:suppliers,name',
            'address' => 'nullable|string',
            'phone'   => 'nullable|string|max:15',
            'email'   => 'nullable|email|max:45|unique:suppliers,email',
        ], [
            'name.required' => 'Nama supplier wajib diisi.',
            'name.unique'   => 'Nama supplier sudah terdaftar.',
            'name.max'      => 'Nama supplier maksimal 45 karakter.',
            'phone.max'     => 'Nomor telepon maksimal 15 karakter.',
            'email.email'   => 'Format email tidak valid.',
            'email.unique'  => 'Email supplier sudah terdaftar.',
        ]);

        $this->service->createSupplier($request->all());

        return redirect()->route('admin.suppliers.index')
            ->with('success', 'Supplier berhasil ditambahkan.');
    }

    public function edit(int $id)
    {
        $supplier = $this->service->getSupplierById($id);
        return view('admin.suppliers.edit', compact('supplier'));
    }

    public function update(Request $request, int $id)
    {
        $request->validate([
            'name'    => 'required|string|max:45|unique:suppliers,name,' . $id,
            'address' => 'required|string',
            'phone'   => 'nullable|string|max:15',
            'email'   => 'nullable|email|max:45|unique:suppliers,email,' . $id,
        ], [
            'name.required' => 'Nama supplier wajib diisi.',
            'address.required' => 'Alamat supplier wajib diisi.',
            'name.unique'   => 'Nama supplier sudah terdaftar.',
            'name.max'      => 'Nama supplier maksimal 45 karakter.',
            'phone.max'     => 'Nomor telepon maksimal 15 karakter.',
            'email.email'   => 'Format email tidak valid.',
            'email.unique'  => 'Email supplier sudah terdaftar.',
        ]);

        $this->service->updateSupplier($id, $request->all());

        return redirect()->route('admin.suppliers.index')
            ->with('success', 'Supplier berhasil diperbarui.');
    }

    public function destroy(int $id)
    {
        $this->service->deleteSupplier($id);

        return redirect()->route('admin.suppliers.index')
            ->with('success', 'Supplier berhasil dihapus.');
    }
}
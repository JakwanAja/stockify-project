<?php

namespace App\Http\Controllers\Admin;

use App\Services\Admin\SupplierService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;

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

    // Tidak diperlukan lagi, redirect ke index
    public function create()
    {
        return redirect()->route('admin.suppliers.index');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'    => 'required|string|max:45|unique:suppliers,name',
            'address' => 'nullable|string',
            'email'   => 'nullable|email|max:45|unique:suppliers,email',
            'phone'   => 'nullable|numeric', 
        ], [
            'name.required' => 'Nama supplier wajib diisi.',
            'name.unique'   => 'Nama supplier sudah terdaftar.',
            'name.max'      => 'Nama supplier maksimal 45 karakter.',
            'phone.max'     => 'Nomor telepon maksimal 15 karakter.',
            'email.email'   => 'Format email tidak valid.',
            'email.unique'  => 'Email supplier sudah terdaftar.',
            'phone.numeric' => 'Nomor telepon hanya boleh berisi angka.',
        ]);

        if ($validator->fails()) {
            return redirect()->route('admin.suppliers.index')
                ->withErrors($validator)
                ->withInput();
            // Tidak flash edit_mode → blade buka modal CREATE
        }

        $this->service->createSupplier($request->all());

        return redirect()->route('admin.suppliers.index')
            ->with('success', 'Supplier berhasil ditambahkan.');
    }

    // Tidak diperlukan lagi, redirect ke index
    public function edit(int $id)
    {
        return redirect()->route('admin.suppliers.index');
    }

    public function update(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'name'    => 'required|string|max:45|unique:suppliers,name,' . $id,
            'address' => 'nullable|string',
            'phone'   => 'nullable|string|max:15',
            'email'   => 'nullable|email|max:45|unique:suppliers,email,' . $id,
        ], [
            'name.required'    => 'Nama supplier wajib diisi.',
            'name.unique'      => 'Nama supplier sudah terdaftar.',
            'name.max'         => 'Nama supplier maksimal 45 karakter.',
            'phone.max'        => 'Nomor telepon maksimal 15 karakter.',
            'email.email'      => 'Format email tidak valid.',
            'email.unique'     => 'Email supplier sudah terdaftar.',
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
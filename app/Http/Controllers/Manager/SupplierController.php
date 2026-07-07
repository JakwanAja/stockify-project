<?php

namespace App\Http\Controllers\Manager;

use App\Services\Admin\SupplierService;
use Illuminate\Routing\Controller;

class SupplierController extends Controller
{
    public function __construct(
        protected SupplierService $service
    ) {}

    public function index()
    {
        $suppliers = $this->service->getAllSuppliers();
        return view('manager.suppliers.index', compact('suppliers'));
    }
}
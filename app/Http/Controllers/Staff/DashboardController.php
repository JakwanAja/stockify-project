<?php

namespace App\Http\Controllers\Staff;

use App\Services\StockTransactionService;
use App\Models\StockTransaction;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct(
        protected StockTransactionService $transactionService,
    ) {}

    public function index()
    {
        $userId = Auth::id();

        // Stat cards
        $totalPengajuanSaya = StockTransaction::where('user_id', $userId)->count();

        $pendingSaya = StockTransaction::where('user_id', $userId)
                        ->where('status', 'Pending')
                        ->count();

        $diterimaHariIni = StockTransaction::where('user_id', $userId)
                            ->whereIn('status', ['Diterima', 'Dikeluarkan'])
                            ->whereDate('updated_at', today())
                            ->count();

        // Riwayat terbaru milik staff ini
        $riwayatTerbaru = StockTransaction::with('product')
                            ->where('user_id', $userId)
                            ->latest('created_at')
                            ->take(8)
                            ->get();

        return view('staff.dashboard', compact(
            'totalPengajuanSaya',
            'pendingSaya',
            'diterimaHariIni',
            'riwayatTerbaru',
        ));
    }
}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LogEnergy;
use Carbon\Carbon;

class DashboardController extends Controller
{
public function index()
{
    // Hapus data lebih dari 2 hari
    LogEnergy::where('created_at', '<', now()->subDays(2))->delete();

    // Ambil data 2 hari terakhir, urutkan dari terbaru
    $data = LogEnergy::whereBetween('created_at', [
            now()->subDays(1)->startOfDay(),
            now()->endOfDay()
        ])
        ->orderBy('created_at', 'desc')
        ->paginate(50); // 50 data per halaman

    return view('dashboard', compact('data'));
}

   public function hasil()
{
    $query = LogEnergy::whereBetween('created_at', [
        now()->subDays(1)->startOfDay(),
        now()->endOfDay()
    ]);

    // Jumlah seluruh data
    $totalData = (clone $query)->count();

    // Data untuk tabel
    $data = $query
        ->orderBy('created_at', 'desc')
        ->paginate(50);

    return view('hasil', compact('data', 'totalData'));
}
}
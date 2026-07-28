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
        ->get();

    return view('dashboard', compact('data'));
}

    public function hasil()
    {
        $data = LogEnergy::whereBetween('created_at', [
            now()->subDays(1)->startOfDay(),
            now()->endOfDay()
        ])->latest()->get();

        return view('hasil', compact('data'));
    }
}
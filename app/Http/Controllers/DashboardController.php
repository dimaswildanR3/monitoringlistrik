<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LogEnergy;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // auto delete data lebih dari 2 hari
        // LogEnergy::where('waktu_log', '<', now()->subDays(2))->delete();

        // ambil hanya 2 hari terakhir
        $data = LogEnergy::whereBetween('waktu_log', [
            now()->subDays(1)->startOfDay(),
            now()->endOfDay()
        ])->latest()->get();

        return view('dashboard', compact('data'));
    }

    public function hasil()
    {
        $data = LogEnergy::whereBetween('waktu_log', [
            now()->subDays(1)->startOfDay(),
            now()->endOfDay()
        ])->latest()->get();

        return view('hasil', compact('data'));
    }
}
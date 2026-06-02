<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LogEnergy;


class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $query = LogEnergy::query();
    
        // kalau user kirim filter
        if ($request->start && $request->end) {
            $query->whereBetween('waktu_log', [
                $request->start,
                $request->end
            ]);
        } else {
            // DEFAULT: hari ini
            $query->whereDate('waktu_log', now()->toDateString());
        }
    
        $data = $query->latest()->get();
    
        return view('dashboard', compact('data'));
    }
    public function hasil()
{
    $data = LogEnergy::latest()->get();
    return view('hasil', compact('data'));
}
}

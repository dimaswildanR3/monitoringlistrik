<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LogEnergy;


class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $query = LogEnergy::query();
    
        if ($request->start && $request->end) {
            $query->whereBetween('waktu_log', [
                $request->start,
                $request->end
            ]);
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

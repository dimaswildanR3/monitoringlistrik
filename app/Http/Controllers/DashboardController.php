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

        // batas maksimal 2 hari
        $start = \Carbon\Carbon::parse($request->start);
        $end = \Carbon\Carbon::parse($request->end);

        if ($start->diffInDays($end) > 2) {
            $end = (clone $start)->addDays(2);
        }

        $query->whereBetween('waktu_log', [$start, $end]);

    } else {

        // DEFAULT: 2 hari terakhir (hari ini + kemarin)
        $query->whereBetween('waktu_log', [
            now()->subDays(1)->startOfDay(),
            now()->endOfDay()
        ]);
    }

    $data = $query->latest()->get();

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

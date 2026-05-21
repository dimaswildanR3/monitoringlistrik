<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LogEnergy;


class DashboardController extends Controller
{
    public function index()
{
    $data = LogEnergy::latest()->get();
    return view('dashboard', compact('data'));
}
    public function hasil()
{
    $data = LogEnergy::latest()->get();
    return view('hasil', compact('data'));
}
}

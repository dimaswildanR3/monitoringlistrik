<?php

namespace App\Http\Controllers;

use App\Models\LogEnergy;
use Illuminate\Http\Request;

class LogEnergyController extends Controller
{
    public function store(Request $request)
    {
        // =========================
        // AMBIL DATA
        // =========================
        $vrn = $request->vrn;
        $vsn = $request->vsn;
        $vtn = $request->vtn;

        $pf   = $request->pf;
        $thdv = $request->thdv;
        $thdi = $request->thdi;

        // =========================
        // 1. RATA-RATA TEGANGAN
        // =========================
        $avg = ($vrn + $vsn + $vtn) / 3;

        // =========================
        // 2. UNBALANCE (IEEE)
        // =========================
        $dev_r = abs($vrn - $avg);
        $dev_s = abs($vsn - $avg);
        $dev_t = abs($vtn - $avg);

        $max_dev = max($dev_r, $dev_s, $dev_t);

        $unbalance = ($avg != 0) ? ($max_dev / $avg) * 100 : 0;

        // =========================
        // 3. DEVIASI TEGANGAN
        // =========================
        $Vnominal = $request->v_nominal ?? 220; // bisa dinamis dari alat

        $deviasi = ($Vnominal != 0)
            ? (($avg - $Vnominal) / $Vnominal) * 100
            : 0;

        // =========================
        // 4. STATUS FUZZY INPUT
        // =========================

        // THD V (1–5 aman)
        $status_thdv = ($thdv >= 1 && $thdv <= 5) ? 1 : 0;

        // THD I (1–5 aman)
        $status_thdi = ($thdi >= 1 && $thdi <= 5) ? 1 : 0;

        // UNBALANCE (<= 2% aman)
        $status_unbalance = ($unbalance <= 2) ? 1 : 0;

        // DEVIASI (-10% s/d +5% aman)
        $status_deviasi = ($deviasi >= -10 && $deviasi <= 5) ? 1 : 0;

        // POWER FACTOR (>= 0.85 aman)
        $status_pf = ($pf >= 0.85) ? 1 : 0;

        // =========================
        // 5. TOTAL STATUS (FUZZY)
        // =========================
        $total_status =
            $status_thdv +
            $status_thdi +
            $status_unbalance +
            $status_deviasi +
            $status_pf;

        // =========================
        // 6. RULE BASE (SUGENO)
        // =========================
        // Semua harus standar → NORMAL

        $audit = ($total_status == 5) ? 1 : 0;

        $ir = $request->ir;
$is = $request->is;
$it = $request->it;

$imean = ($ir + $is + $it) / 3;
        // =========================
        // 7. SIMPAN DATABASE
        // =========================
        LogEnergy::create([
            'id_device' => $request->id_device,
'waktu_log' => $request->waktu_log ?? now(),
            // arus
            'ir' => $request->ir,
            'is' => $request->is,
            'it' => $request->it,
            'imean' => $imean,

            // tegangan
            'vrn' => $vrn,
            'vsn' => $vsn,
            'vtn' => $vtn,
            'vmean' => $avg,
            'v_nominal' => $Vnominal,

            'vrs' => $request->vrs,
            'vst' => $request->vst,
            'vtr' => $request->vtr,

            // daya
            'pr' => $request->pr,
            'ps' => $request->ps,
            'pt' => $request->pt,

            'pw' => $request->pw,
            'pvar' => $request->pvar,
            'pva' => $request->pva,

            // parameter
            'pf' => $pf,
            'freq' => $request->freq,
            'ener' => $request->ener,

            'thdv' => $thdv,
            'thdi' => $thdi,

            // hasil hitung
            'unbalance' => $unbalance,
            'deviasi' => $deviasi,

            // status
            'status_thdv' => $status_thdv,
            'status_thdi' => $status_thdi,
            'status_unbalance' => $status_unbalance,
            'status_deviasi' => $status_deviasi,
            'status_pf' => $status_pf,

            // hasil akhir
            'total_status' => $total_status,
            'audit' => $audit
        ]);

        // =========================
        // RESPONSE KE ESP32
        // =========================
        return response($audit == 1 ? "@1#" : "@0#");
    }
}
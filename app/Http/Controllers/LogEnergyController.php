<?php

namespace App\Http\Controllers;

use App\Models\LogEnergy;
use Illuminate\Http\Request;

class LogEnergyController extends Controller
{
    public function store(Request $request)
    {  
        $vrn = $request->vrn;
        $vsn = $request->vsn;
        $vtn = $request->vtn;
        $pf   = $request->pf;
        $thdv = $request->thdv;
        $thdi = $request->thdi;
        $avg = ($vrn + $vsn + $vtn) / 3;       
        $dev_r = abs($vrn - $avg);
        $dev_s = abs($vsn - $avg);
        $dev_t = abs($vtn - $avg);
        $max_dev = max($dev_r, $dev_s, $dev_t);
        $unbalance = ($avg != 0) ? ($max_dev / $avg) * 100 : 0;
        $Vnominal = $request->v_nominal ?? 220; 
        $deviasi = ($Vnominal != 0)
            ? (($avg - $Vnominal) / $Vnominal) * 100
            : 0;
        $status_thdv = ($thdv >= 1 && $thdv <= 5) ? 1 : 0;
        $status_thdi = ($thdi >= 1 && $thdi <= 5) ? 1 : 0;
        $status_unbalance = ($unbalance <= 2) ? 1 : 0;
        $status_deviasi = ($deviasi >= -10 && $deviasi <= 5) ? 1 : 0;
        $status_pf = ($pf >= 0.85) ? 1 : 0;
        $total_status =
            $status_thdv +
            $status_thdi +
            $status_unbalance +
            $status_deviasi +
            $status_pf;
        $audit = ($total_status == 5) ? 1 : 0;
        $ir = $request->ir;
        $is = $request->is;
        $it = $request->it;
        $imean = ($ir + $is + $it) / 3;
        LogEnergy::create([
            'id_device' => $request->id_device,
            'waktu_log' => $request->waktu_log ?? now(),
            'ir' => $request->ir,
            'is' => $request->is,
            'it' => $request->it,
            'imean' => $imean,
            'vrn' => $vrn,
            'vsn' => $vsn,
            'vtn' => $vtn,
            'vmean' => $avg,
            'v_nominal' => $Vnominal,
            'vrs' => $request->vrs,
            'vst' => $request->vst,
            'vtr' => $request->vtr,  
            'pr' => $request->pr,
            'ps' => $request->ps,
            'pt' => $request->pt,
            'pw' => $request->pw,
            'pvar' => $request->pvar,
            'pva' => $request->pva,    
            'pf' => $pf,
            'freq' => $request->freq,
            'ener' => $request->ener,
            'thdv' => $thdv,
            'thdi' => $thdi,  
            'unbalance' => $unbalance,
            'deviasi' => $deviasi,     
            'status_thdv' => $status_thdv,
            'status_thdi' => $status_thdi,
            'status_unbalance' => $status_unbalance,
            'status_deviasi' => $status_deviasi,
            'status_pf' => $status_pf,
            'total_status' => $total_status,
            'audit' => $audit
        ]);
        return response($audit == 1 ? "@1#" : "@0#");
    }
}
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
      
        
        $avg = ($vrn + $vsn + $vtn) / 3;       
        $dev_r = abs($vrn - $avg);
        $dev_s = abs($vsn - $avg);
        $dev_t = abs($vtn - $avg);
        $max_dev = max($dev_r, $dev_s, $dev_t);
        
        $unbalance = ($avg != 0) ? ($max_dev / $avg) * 100 : 0;
        $unbalance = round($unbalance, 2);
        $Vnominal = $request->v_nominal ?? 220; 
        
        if ($Vnominal != 0) {
            $dev_r_pct = (($vrn - $Vnominal) / $Vnominal) * 100;
            $dev_s_pct = (($vsn - $Vnominal) / $Vnominal) * 100;
            $dev_t_pct = (($vtn - $Vnominal) / $Vnominal) * 100;
            
            
            $deviasi = ($dev_r_pct + $dev_s_pct + $dev_t_pct) / 3;
            $deviasi = round($deviasi, 2);
        } else {
            $deviasi = 0;
        }
     
        
        $ir = $request->ir;
        $is = $request->is;
        $it = $request->it;
        $imean = ($ir + $is + $it) / 3;
        
        $T = $request->periode; 
        $freq = $request->freq;
        
        
        $vrt = round(sqrt(3) * $vrn, 2);
        $vts = round(sqrt(3) * $vsn, 2);
        $vsr = round(sqrt(3) * $vtn, 2);
        $v_harmonics = $request->v_harmonics; 
        $v1 = $request->v1 ?? $avg; 

        if (!empty($v_harmonics) && is_array($v_harmonics) && $v1 > 0) {
            $sum_squares_v = 0;
            foreach ($v_harmonics as $v_harm) {
                $sum_squares_v += pow($v_harm, 2);
            }
            $thdv = (sqrt($sum_squares_v) / $v1) * 100;
            $thdv = round($thdv, 2);
        } else {
            
            $thdv = $request->thdv ?? 0; 
        }

        
        $i_harmonics = $request->i_harmonics; 
        $i1 = $request->i1 ?? $imean; 

        if (!empty($i_harmonics) && is_array($i_harmonics) && $i1 > 0) {
            $sum_squares_i = 0;
            foreach ($i_harmonics as $i_harm) {
                $sum_squares_i += pow($i_harm, 2);
            }
            $thdi = (sqrt($sum_squares_i) / $i1) * 100;
            $thdi = round($thdi, 2);
        } else {
            
            $thdi = $request->thdi ?? 0;
        }

        
        $status_thdv = ($thdv > 0 && $thdv <= 5) ? 1 : 0;
        $status_thdi = ($thdi > 0 && $thdi <= 5) ? 1 : 0;
        $status_unbalance = ($unbalance >= 0 && $unbalance <= 2) ? 1 : 0;
        $status_deviasi = ($deviasi >= -10 && $deviasi <= 5) ? 1 : 0;
        $status_pf = ($pf >= 0.85 && $pf <= 1) ? 1 : 0;
        
        $total_status = $status_thdv + $status_thdi + $status_unbalance + $status_deviasi + $status_pf;
        $audit = ($total_status == 5 || $total_status == 4) ? 1 : 0;

        
        LogEnergy::create([
            'id_device' => $request->id_device,
            'periode' => $request->periode,
            'waktu_log' => $request->waktu_log ?? now(),
            'ir' => $request->ir,
            'is' => $request->is,
            'it' => $request->it,
            'imean' => $imean,
            'vrn' => $vrn,
            'vsn' => $vsn,
            'vtn' => $vtn,
            'vrt' => $vrt,
            'vts' => $vts,
            'vsr' => $vsr,
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
            'freq' => $freq,
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
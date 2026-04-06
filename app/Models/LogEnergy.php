<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogEnergy extends Model
{
    use HasFactory;

    protected $table = 'log_energies';

    protected $fillable = [
        'id_device',
'waktu_log',
        // arus
        'ir','is','it','imean',

        // tegangan
        'vrn','vsn','vtn','vmean',
        'vrs','vst','vtr',
        'v_nominal', // ✅ tambahan baru

        // daya
        'pr','ps','pt',
        'pw','pvar','pva',

        // parameter
        'pf','freq','ener',
        'thdv','thdi',

        // hasil perhitungan
        'unbalance','deviasi',

        // status fuzzy
        'status_thdv','status_thdi',
        'status_unbalance','status_deviasi','status_pf',

        // hasil akhir
        'total_status', // ✅ tambahan baru
        'audit'
    ];

    // 🔥 OPTIONAL (biar otomatis boolean)
    protected $casts = [
        'status_thdv' => 'boolean',
        'status_thdi' => 'boolean',
        'status_unbalance' => 'boolean',
        'status_deviasi' => 'boolean',
        'status_pf' => 'boolean',
        'audit' => 'boolean',
    ];
}
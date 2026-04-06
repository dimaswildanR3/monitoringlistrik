<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWaktuLogToLogEnergyTable extends Migration
{
    public function up()
    {
        Schema::table('log_energies', function (Blueprint $table) {
            $table->timestamp('waktu_log')->nullable()->after('created_at');
        });
    }

    public function down()
    {
        Schema::table('log_energies', function (Blueprint $table) {
            $table->dropColumn('waktu_log');
        });
    }
}
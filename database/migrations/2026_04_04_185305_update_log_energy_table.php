<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateLogEnergyTable extends Migration
{
    public function up()
    {
        Schema::table('log_energies', function (Blueprint $table) {

            // ❌ JANGAN pakai change() kalau tanpa DBAL

            // ✅ Tambah kolom baru saja
            if (!Schema::hasColumn('log_energy', 'v_nominal')) {
                $table->double('v_nominal')->default(220)->after('vmean');
            }

            if (!Schema::hasColumn('log_energy', 'total_status')) {
                $table->integer('total_status')->nullable()->after('audit');
            }
        });
    }

    public function down()
    {
        Schema::table('log_energies', function (Blueprint $table) {

            if (Schema::hasColumn('log_energy', 'v_nominal')) {
                $table->dropColumn('v_nominal');
            }

            if (Schema::hasColumn('log_energy', 'total_status')) {
                $table->dropColumn('total_status');
            }
        });
    }
}
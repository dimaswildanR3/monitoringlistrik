<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up()
{
    Schema::create('log_energies', function (Blueprint $table) {
        $table->id();
        $table->string('id_device');

        $table->float('ir')->nullable();
        $table->float('is')->nullable();
        $table->float('it')->nullable();
        $table->float('imean')->nullable();

        $table->float('vrn')->nullable();
        $table->float('vsn')->nullable();
        $table->float('vtn')->nullable();
        $table->float('vmean')->nullable();

        $table->float('vrs')->nullable();
        $table->float('vst')->nullable();
        $table->float('vtr')->nullable();

        $table->float('pr')->nullable();
        $table->float('ps')->nullable();
        $table->float('pt')->nullable();

        $table->float('pw')->nullable();
        $table->float('pvar')->nullable();
        $table->float('pva')->nullable();

        $table->float('pf')->nullable();
        $table->float('freq')->nullable();
        $table->float('ener')->nullable();

        $table->float('unbalance')->nullable();
$table->float('deviasi')->nullable();
$table->float('status_unbalance')->nullable();
$table->float('status_deviasi')->nullable();
$table->float('status_pf')->nullable();
$table->float('audit')->nullable(); // hasil fuzzy (0 / 1)
$table->float('thdv')->nullable();
$table->float('thdi')->nullable();


$table->float('status_thdv')->nullable();
$table->float('status_thdi')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('log_energies');
    }
};

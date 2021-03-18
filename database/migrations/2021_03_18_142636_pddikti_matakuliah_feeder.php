<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PddiktiMatakuliahFeeder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pddikti_matakuliah_feeder', function (Blueprint $table) {
            $table->increments('id');
            $table->string("kode_mk");
            $table->string("nama_mk");
            $table->float("bobot_mk",5);
            $table->string("prodi_pengampu");
            $table->string("jenis_mk");
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
        //
    }
}

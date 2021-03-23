<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PddiktiNilaiFeeder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('pddikti_nilai_feeder');
        Schema::create('pddikti_nilai_feeder', function (Blueprint $table) {
            $table->increments('id');
            $table->string("nim",11);
            $table->string("nama");
            $table->string("prodi");
            $table->string("kode_mk",11);
            $table->string("nama_mk");
            $table->float("bobot_mk",8,2);
            $table->float("nilai_angka",8,2);
            $table->string("nilai_huruf",2);
            $table->float("nilai_index",8,3);
            $table->string("tahun",4);
            $table->string("semester",1);
            $table->string("idrelasi");
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
        Schema::dropIfExists('pddikti_nilai_feeder');
    }
}

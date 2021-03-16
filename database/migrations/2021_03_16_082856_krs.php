<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Krs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('krs', function (Blueprint $table) {
            $table->increments('id');
            $table->string("nim",11);
            $table->string("nama");
            $table->string("prodi");
            $table->string("kode_mk",11);
            $table->string("nama_mk");
            $table->float("bobot_mk",1,2);
            $table->decimal("nilai_angka",3,2);
            $table->string("nilai_huruf",2);
            $table->decimal("nilai_index",3,3);
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
        Schema::dropIfExists('krs');
    }
}

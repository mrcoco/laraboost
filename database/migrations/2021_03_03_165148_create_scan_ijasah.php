<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScanIjasah extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scanijazah', function (Blueprint $table) {
            $table->increments('id');
            $table->string("nim")->nullable();
            $table->string("prodi")->nullable();
            $table->string("no_ijazah")->nullable();
            $table->string("file_ijazah")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('scanijazah', function (Blueprint $table) {
            //
        });
    }
}

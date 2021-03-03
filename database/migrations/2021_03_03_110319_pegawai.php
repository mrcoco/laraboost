<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Pegawai extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pegawai', function (Blueprint $table) {
            $table->increments('id');

            $table->string('id_siap')->nullable();
            $table->string('nama')->nullable();
            $table->string('nama_lengkap')->nullable();
            $table->string('gelar_depan')->nullable();
            $table->string('gelar_belakang')->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->string('tanggal_lahir')->nullable();
            $table->string('sub_bagian')->nullable();
            $table->string('bagian')->nullable();
            $table->string('unit')->nullable();
            $table->string('unit_detail')->nullable();
            $table->string('unit_identity')->nullable();
            $table->integer('unit_id')->nullable();
            $table->string('pangkat')->nullable();
            $table->string('golongan')->nullable();
            $table->string('jabatan')->nullable();
            $table->string('jenis_pegawai')->nullable();
            $table->string('status_pegawai')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('photo')->nullable();
            $table->string('jenjang_pendidikan')->nullable();
            $table->string('prodi')->nullable();
            $table->string('tahun_lulus')->nullable();
            $table->string('tempat_sekolah')->nullable();
            $table->string('check_sum')->nullable();
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

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameColumScan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('scanijazah', function (Blueprint $table) {
            $table->removeColumn("prodi");
            $table->integer("jenis_document");
            $table->renameColumn("no_ijazah","no_document");
            $table->renameColumn("file_ijazah","file");
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

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TblGenerosIdGenerosForeign extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_doadores', function (Blueprint $table) {
            $table->foreign('id_generos')->references('id_generos')->on('tbl_generos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_doadores', function (Blueprint $table) {
            $table->dropForeign('tbl_doadores_id_generos_foreign');
        });
    }
}

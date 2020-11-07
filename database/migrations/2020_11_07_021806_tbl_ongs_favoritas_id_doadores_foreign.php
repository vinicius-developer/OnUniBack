<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TblOngsFavoritasIdDoadoresForeign extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_ongs_favoritas', function(Blueprint $table) {
            $table->foreign('id_doadores')->references('id_doadores')->on('tbl_doadores');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_ongs_favoritas', function(Blueprint $table) {
            $table->dropForeign('tbl_ongs_favoritas_id_doadores_foreign');
        });
    }
}

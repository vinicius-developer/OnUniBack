<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TblOngsIdCausasSociaisForeign extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_ongs', function(Blueprint $table) {
            $table->foreign('id_causas_sociais')->references('id_causas_sociais')->on('tbl_causas_sociais');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_ongs', function(Blueprint $table) {
            $table->dropForeign('tbl_ongs_id_causas_sociais_foreign');
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TblReportOngDoadorFkIdDoadoresForeign extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_report_ong_doador', function(Blueprint $table){
			$table->foreign('fk_id_doadores')->references('id_doadores')->on('tbl_doadores');
		});
        //
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_report_ong_doador', function(Blueprint $table){
			$table->dropForeign('tbl_report_ong_doador_fk_id_doadores_foreign');
		});  
        //
    }
}

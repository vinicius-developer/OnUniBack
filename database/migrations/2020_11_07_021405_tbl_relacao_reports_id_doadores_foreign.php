<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TblRelacaoReportsIdDoadoresForeign extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_relacao_reports', function(Blueprint $table) {
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
        Schema::table('tbl_relacao_reports', function(Blueprint $table) {
            $table->dropForeign('tbl_relacao_reports_id_doadores_foreign');
        });
    }
}

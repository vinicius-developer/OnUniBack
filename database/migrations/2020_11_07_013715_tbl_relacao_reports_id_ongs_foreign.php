<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TblRelacaoReportsIdOngsForeign extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_relacao_reports', function(Blueprint $table) {
            $table->foreign('id_ongs')->references('id_ongs')->on('tbl_ongs');
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
            $table->dropForeign('tbl_relacao_reports_id_ongs_foreign');
        });
    }
}

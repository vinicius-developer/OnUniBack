<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TblRelacaoReports extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_relacao_reports', function(Blueprint $table) {
            $table->bigIncrements('id_relacao_reports');
            $table->string('id_doadores', 32)->nullable();
            $table->string('id_ongs', 32)->nullable();
            $table->unsignedInteger('id_reports');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tbl_relacao_reports');
    }
}

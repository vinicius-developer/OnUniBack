<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TblReportDoadorOng extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
	  {
		  Schema::create('tbl_report_doador_ong', function(Blueprint $table) {
			  $table->unsignedBigInteger('fk_id_doadores');
			  $table->unsignedBigInteger('fk_id_ongs');
			  $table->text('expicacao_report');
			  $table->timestamps();
			  $table->primary(['fk_id_doadores', 'fk_id_ongs']);
		  });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
	{
		Schema::drop('tbl_report_doador_ong');
    }
}

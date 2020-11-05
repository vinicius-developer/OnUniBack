<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TblOngsFkIdCausaSocialForeign extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::table('tbl_ongs', function(Blueprint $table){
			$table->foreign('fk_id_causa_social')->references('id_causa_social')->on('tbl_causas_sociais');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
	{
		Schema::table('tbl_ongs', function(Blueprint $table){
			$table->dropForeign('tbl_ongs_fk_id_causa_social_foreign');
		});
    }
}

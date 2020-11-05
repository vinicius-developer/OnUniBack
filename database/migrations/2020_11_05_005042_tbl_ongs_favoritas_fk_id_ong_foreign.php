<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TblOngsFavoritasFkIdOngForeign extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
	{
		Schema::table('tbl_ongs_favoritas', function(Blueprint $table){
			$table->foreign('fk_id_ong')->references('id_ong')->on('tbl_ongs');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
	{
		Schema::table('tbl_ongs_favoritas', function(Blueprint $table){
			$table->dropForeign('tbl_ongs_favoritas_fk_id_ong_foreign');
		}); 
        //
    }
}

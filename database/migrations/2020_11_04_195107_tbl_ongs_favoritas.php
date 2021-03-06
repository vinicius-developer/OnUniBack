<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TblOngsFavoritas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
	{
		Schema::create('tbl_ongs_favoritas', function(Blueprint $table) {
        	$table->bigIncrements('id_ongs_favoritas');
			$table->string('id_ongs', 32);
			$table->string('id_doadores', 32);
			$table->timestamps();
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
	{
		Schema::drop('tbl_ongs_favoritas');
    }
}

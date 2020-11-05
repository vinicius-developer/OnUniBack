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
			$table->unsignedBigInteger('fk_id_ong');
			$table->unsignedBigInteger('fk_id_doador');
			$table->timestamps();
			$table->primary(['fk_id_ong', 'fk_id_doador']);
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

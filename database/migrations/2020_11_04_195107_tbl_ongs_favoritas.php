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
			$table->bigInteger('id_causa_social');
			$table->bigInteger('nome_causa_social');
			$table->timestamps();
			$table->primary(['id_causa_social', 'nome_causa_social']);
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

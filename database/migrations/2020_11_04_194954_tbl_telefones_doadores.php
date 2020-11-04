<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TblTelefonesDoadores extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
	{
		Schema::create('tbl_telefones_doadores', function(Blueprint $table) {
			$table->bigInteger('fk_id_doadores');
			$table->string('numero_telefone', 14);
			$table->timestamps();
			$table->primary(['fk_id_doadores', 'numero_telefone']);
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
	{
		Schema::drop('tbl_telefones_doadores');
    }
}

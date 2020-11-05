<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TblTelefonesOngs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
	{
		Schema::create('tbl_telefones_ongs', function(Blueprint $table){
			$table->unsignedBigInteger('fk_id_ong');
			$table->string('numero_telefone', 14);
			$table->timestamps();
			$table->primary(['fk_id_ong', 'numero_telefone']);
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
	{
		Schema::drop('tbl_telefones_ongs');
    }
}

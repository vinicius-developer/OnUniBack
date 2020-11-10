<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TblListasPedidosOngs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
	{
		Schema::create('tbl_listas_pedidos_ongs', function(Blueprint $table) {
			$table->bigIncrements('id_listas_pedidos_ongs');
			$table->string('id_ongs', 32);
			$table->unsignedInteger('id_lojas');
			$table->string('nome_item', 40);
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
		Schema::drop('tbl_listas_pedidos_ongs');
    }
}

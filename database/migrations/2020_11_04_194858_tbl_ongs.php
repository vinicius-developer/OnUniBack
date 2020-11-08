<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TblOngs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
	{
		Schema::create('tbl_ongs', function (Blueprint $table){
			$table->increments('id_ongs');
			$table->unsignedSmallInteger('id_causas_sociais');
			$table->char('cnpj', 18)->unique();
			$table->string('nome_fantasia', 80);
			$table->string('razao_social', 80);
			$table->string('email', 80)->unique();
			$table->string('senha', 72);
			$table->text('descricao_ong');
			$table->string('img_perfil', 80); //disposto a mudança
			$table->enum('status', ['false', 'true']);
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
		Schema::drop('tbl_ongs');
    }
}

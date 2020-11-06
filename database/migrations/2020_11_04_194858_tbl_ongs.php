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
			$table->bigIncrements('id_ong');
			$table->unsignedSmallInteger('fk_id_causa_social');
			$table->char('cnpj', 18)->unique();
			$table->string('nome_fantasia', 80);
			$table->string('razao_social', 80);
			$table->string('email', 80)->unique();
			$table->string('senha', 72);
			$table->text('descricao_ong')->nullable();
			$table->string('rua_endereco_ong', 60);
			$table->smallInteger('numero_endereco_ong');
			$table->string('bairro_endereco_ong', 30);
			$table->string('cidade_endereco_ong', 30);
			$table->char('uf_endereco_ong', 2);
			$table->string('img_perfil', 80); //disposto a mudança
			$table->enum('status', ['true', 'false']);
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

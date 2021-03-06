<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TblDoadores extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
	{
		Schema::create('tbl_doadores', function(Blueprint $table) {
			$table->string('id_doadores', 32)->primary();
			$table->char('cpf', 14);
			$table->string('nome', 30);
			$table->string('sobrenome', 50);
			$table->string('email', 80)->unique();
			$table->unsignedSmallInteger('id_generos');
			$table->string('password', 72);
      		$table->string('img_perfil', 80);
			$table->enum('status', ['false', 'true']);
			$table->timestamps('');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
	{
		Schema::drop('tbl_doadores');
    }
}

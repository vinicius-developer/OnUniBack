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
			$table->increments('id_doadores');
			$table->string('nome', 30);
			$table->string('sobrenome', 50);
			$table->string('email', 80)->unique();
			$table->string('senha', 72);
      		$table->string('img_perfil', 80);
      		$table->enum('status', ['true', 'false']);
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

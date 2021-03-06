<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TblEnderecos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_enderecos', function(Blueprint $table) {
            $table->increments('id_enderecos');
            $table->string('id_ongs', 32);
            $table->string('rua', 40);
			$table->string('cep', 10);
            $table->unsignedSmallInteger('numero');
            $table->string('complemento', 25)->nullable();
            $table->string('cidade', 40);
            $table->string('bairro', 40);
            $table->unsignedSmallInteger('id_uf');
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
        Schema::drop('tbl_enderecos');
    }
}

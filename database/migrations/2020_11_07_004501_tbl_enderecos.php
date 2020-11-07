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
            $table->string('rua', 40);
            $table->unsignedSmallInteger('numero');
            $table->string('cidade', 40);
            $table->string('bairro', 40);
            $table->char('uf', 2);
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

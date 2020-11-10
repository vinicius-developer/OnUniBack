<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TblRelacaoTelefones extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_relacao_telefones', function(Blueprint $table) {
            $table->bigIncrements('id_relacao_telefones');
            $table->unsignedBigInteger('id_telefones');
            $table->string('id_doadores', 32)->nullable();
            $table->string('id_ongs', 32)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tbl_relacao_telefones');
    }
}

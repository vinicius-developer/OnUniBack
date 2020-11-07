<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TblRelacaoEnderecos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_relacao_enderecos', function(Blueprint $table) {
            $table->increments('id_relacao_enderecos');
            $table->unsignedInteger('id_enderecos');
            $table->unsignedInteger('id_ongs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tbl_relacao_enderecos');
    }
}

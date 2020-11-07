<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TblRelacaoEnderecosIdEnderecos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_relacao_enderecos', function(Blueprint $table) {
            $table->foreign('id_enderecos')->references('id_enderecos')->on('tbl_enderecos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_relacao_enderecos', function(Blueprint $table) {
            $table->dropForeign('tbl_relacao_enderecos_id_enderecos_foreign');
        });
    }
}

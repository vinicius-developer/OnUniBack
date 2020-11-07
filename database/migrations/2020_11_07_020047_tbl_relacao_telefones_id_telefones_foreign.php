<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TblRelacaoTelefonesIdTelefonesForeign extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_relacao_telefones', function(Blueprint $table) {
            $table->foreign('id_telefones')->references('id_telefones')->on('tbl_telefones');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_relacao_telefones', function(Blueprint $table) {
            $table->dropForeign('id_relacao_telefones_id_telefones_foreign');
        });
    }
}

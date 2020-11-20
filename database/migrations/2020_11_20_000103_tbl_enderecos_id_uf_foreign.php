<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TblEnderecosIdUfForeign extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_enderecos', function (Blueprint $table) {
            $table->foreign('id_uf')->references('id_uf')->on('tbl_uf');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_enderecos', function (Blueprint $table) {
            $table->dropForeign('tbl_enderecos_id_uf_foreign');
        });

    }
}

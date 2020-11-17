<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class LogTokenJwt extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_logs_tokens_jwt', function (Blueprint $table) {
            $table->bigIncrements('id_logs_tokes_jwt');
            $table->text("token");
            $table->string("email", 80);
            $table->enum('tipo_usuario', ['ong', 'doador']);
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
        Schema::drop('tbl_logs_tokens_jwt');
    }
}

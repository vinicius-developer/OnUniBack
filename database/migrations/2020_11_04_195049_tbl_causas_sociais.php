<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TblCausasSociais extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
	{
		Schema::create('tbl_causas_sociais', function(Blueprint $table) {
			$table->SmallIncrements('id_causas_sociais');
			$table->string('nome_causa_social', 30)->unique();
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
		Schema::drop('tbl_causas_sociais');
    }
}

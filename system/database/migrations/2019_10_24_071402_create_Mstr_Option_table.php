<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMstrOptionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('Mstr_Option', function(Blueprint $table)
		{
			$table->string('Section', 250)->nullable();
			$table->string('Keys', 250)->nullable();
			$table->string('Data', 250)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('Mstr_Option');
	}

}

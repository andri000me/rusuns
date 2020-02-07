<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUnitSewaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('Unit_Sewa', function(Blueprint $table)
		{
			$table->integer('Unit_Sewa_Id', true);
			$table->string('Kode_Unit', 15);
			$table->string('Name_Unit', 250)->nullable();
			$table->smallInteger('Lantai')->nullable();
			$table->string('Tipe_Sewa_Id', 11)->nullable();
			$table->integer('Tarif');
			$table->string('Keterangan', 250)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('Unit_Sewa');
	}

}

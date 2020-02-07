<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBulanTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('Bulan', function(Blueprint $table)
		{
			$table->smallInteger('Bulan_Id')->primary();
			$table->string('Nama_Bulan', 250)->nullable();
			$table->string('Singkatan', 10)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('Bulan');
	}

}

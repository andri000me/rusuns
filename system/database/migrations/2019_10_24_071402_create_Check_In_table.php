<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCheckInTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('Check_In', function(Blueprint $table)
		{
			$table->string('Check_In_Id', 50)->primary();
			$table->smallInteger('Unit_Sewa_Id');
			$table->integer('Penyewa_Id');
			$table->integer('Tipe_Sewa_Id')->nullable();
			$table->dateTime('Tgl_Check_In')->nullable();
			$table->integer('Listrik_Awal')->nullable();
			$table->integer('Air_Awal')->nullable();
			$table->dateTime('Tgl_Check_Out')->nullable();
			$table->integer('Listrik_Akhir')->nullable();
			$table->integer('Air_Akhir')->nullable();
			$table->string('Keterangan', 250)->nullable();
			$table->string('Created_By', 250)->nullable();
			$table->dateTime('Created_Date')->nullable();
			$table->string('Modified_By', 250)->nullable();
			$table->dateTime('Mofied_Date')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('Check_In');
	}

}

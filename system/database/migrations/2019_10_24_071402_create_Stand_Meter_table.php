<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateStandMeterTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('Stand_Meter', function(Blueprint $table)
		{
			$table->bigInteger('Stand_Meter_Id', true);
			$table->integer('Jns_Stand_Meter_Id')->nullable();
			$table->integer('Unit_Sewa_Id')->nullable();
			$table->smallInteger('Tahun')->nullable();
			$table->smallInteger('Bulan')->nullable();
			$table->integer('Meter_Awal')->nullable();
			$table->integer('Meter_Akhir')->nullable();
			$table->integer('Meter_Pakai')->nullable();
			$table->integer('Jumlah')->nullable();
			$table->string('Created_By', 250)->nullable();
			$table->dateTime('Created_Date')->nullable();
			$table->string('Modified_By', 250)->nullable();
			$table->dateTime('Modified_Date')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('Stand_Meter');
	}

}

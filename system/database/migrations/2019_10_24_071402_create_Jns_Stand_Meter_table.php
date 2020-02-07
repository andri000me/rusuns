<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateJnsStandMeterTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('Jns_Stand_Meter', function(Blueprint $table)
		{
			$table->smallInteger('Jns_Stand_Meter_Id')->default(0)->unique('Jns_Stand_Meter_Jns_Stand_Meter_Id_uindex');
			$table->integer('Nama_Stand_Meter')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('Jns_Stand_Meter');
	}

}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateHubunganKeluargaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('Hubungan_Keluarga', function(Blueprint $table)
		{
			$table->smallInteger('Hub_Keluarga_Id')->primary();
			$table->string('Nama_Hub_Keluarga', 250)->nullable();
			$table->smallInteger('Urut')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('Hubungan_Keluarga');
	}

}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePenyewaKeluaragaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('Penyewa_Keluaraga', function(Blueprint $table)
		{
			$table->integer('Penyewa_Keluarga_Id', true);
			$table->integer('Penyewa_Id')->nullable();
			$table->smallInteger('Urut')->nullable();
			$table->smallInteger('Hub_Keluarga_Id')->nullable();
			$table->string('Nama', 250)->nullable();
			$table->string('Tempat_Lahir', 250)->nullable();
			$table->date('Tgl_Lahir')->nullable();
			$table->string('Ktp_Nik', 250)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('Penyewa_Keluaraga');
	}

}

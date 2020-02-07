<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePenyewaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('Penyewa', function(Blueprint $table)
		{
			$table->integer('Penyewa_Id', true);
			$table->integer('No_Reg')->nullable();
			$table->string('Nama', 250)->nullable();
			$table->string('Tempat_Lahir', 250)->nullable();
			$table->date('Tgl_Lahir')->nullable();
			$table->integer('Ktp_Nik')->nullable();
			$table->string('Ktp_Alamat')->nullable();
			$table->string('No_Hp', 250)->nullable();
			$table->integer('Jml_Penghuni')->nullable();
			$table->integer('Is_Aktif')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('Penyewa');
	}

}

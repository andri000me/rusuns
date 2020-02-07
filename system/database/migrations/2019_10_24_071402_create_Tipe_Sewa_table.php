<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTipeSewaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('Tipe_Sewa', function(Blueprint $table)
		{
			$table->string('Tipe_Sewa_Id', 250)->unique('Tipe_Sewa_Tipe_Sewa_Id_uindex');
			$table->string('Nama_Tipe_Sewa', 250)->nullable();
			$table->string('Singkatan', 5)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('Tipe_Sewa');
	}

}

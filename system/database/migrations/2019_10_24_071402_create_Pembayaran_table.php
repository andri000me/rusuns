<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePembayaranTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('Pembayaran', function(Blueprint $table)
		{
			$table->integer('Pembayaran_Id');
			$table->string('Check_In_Id', 250)->nullable();
			$table->dateTime('Tgl_Bayar')->nullable();
			$table->string('Keterangan', 250)->nullable();
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
		Schema::drop('Pembayaran');
	}

}

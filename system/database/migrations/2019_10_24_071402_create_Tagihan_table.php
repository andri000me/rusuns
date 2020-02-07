<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTagihanTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('Tagihan', function(Blueprint $table)
		{
			$table->integer('Tagihan_Id');
			$table->string('Check_In_Id', 250)->nullable();
			$table->dateTime('Tgl_Tagihan')->nullable();
			$table->integer('Keterangan')->nullable();
			$table->smallInteger('Tahun')->nullable();
			$table->smallInteger('Bulan')->nullable();
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
		Schema::drop('Tagihan');
	}

}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePembayaranDetailTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('Pembayaran_Detail', function(Blueprint $table)
		{
			$table->bigInteger('Pemabayaran_Detail_Id')->unique('Pembayaran_Detail_Pemabayaran_Detail_Id_uindex');
			$table->integer('Pemabayaran_Id');
			$table->smallInteger('Item_Pembayaran_Id')->nullable();
			$table->smallInteger('Tahun')->nullable();
			$table->smallInteger('Bulan')->nullable();
			$table->integer('Meter_Awal')->nullable();
			$table->integer('Meter_Akhir')->nullable();
			$table->smallInteger('Meter_Pakai')->nullable();
			$table->integer('Jumlah')->nullable();
			$table->integer('Harga_Satuan')->nullable();
			$table->integer('Biaya_Beban')->nullable();
			$table->integer('PPJ')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('Pembayaran_Detail');
	}

}

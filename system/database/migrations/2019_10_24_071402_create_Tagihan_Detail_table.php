<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTagihanDetailTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('Tagihan_Detail', function(Blueprint $table)
		{
			$table->integer('Tagihan_Detail_Id', true);
			$table->integer('Tagihan_Id')->nullable();
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
		Schema::drop('Tagihan_Detail');
	}

}

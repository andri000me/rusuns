<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateItemPembayaranTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('Item_Pembayaran', function(Blueprint $table)
		{
			$table->smallInteger('Item_Pembayaran_Id', true);
			$table->string('Kode_Item', 250)->nullable();
			$table->string('Nama_Item', 5)->nullable();
			$table->string('Singkatan', 10)->nullable();
			$table->integer('Urut')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('Item_Pembayaran');
	}

}

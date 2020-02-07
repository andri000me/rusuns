<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCashFlowTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('Cash_Flow', function(Blueprint $table)
		{
			$table->bigInteger('Cash_Flow_Id', true);
			$table->dateTime('Tgl_Trans')->nullable();
			$table->smallInteger('Item_Pembayaran_Id')->nullable();
			$table->integer('Jml_Masuk')->nullable();
			$table->integer('Jml_Keluar')->nullable();
			$table->integer('Jml_Subsidi')->nullable();
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
		Schema::drop('Cash_Flow');
	}

}

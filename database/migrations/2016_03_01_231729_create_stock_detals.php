<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStockDetals extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('stock_details', function(Blueprint $table)
		{
			$table->increments('id');

			$table->unsignedInteger('branch_id');
			$table->foreign('branch_id')->references('id')->on('branches');
			$table->unsignedInteger('stock_info_id');
			$table->foreign('stock_info_id')->references('id')->on('stock_infos');
			$table->string('entry_type',255);
			$table->string('product_type',255);


			$table->unsignedInteger('product_id');
			$table->foreign('product_id')->references('id')->on('products');
			$table->integer('quantity');
			$table->string('consignment_name',255);

			$table->unsignedInteger('to_stock_info_id');
			$table->foreign('to_stock_info_id')->references('id')->on('stock_infos');

			$table->string('invoice_id', 255);

			$table->text('remarks');


			$table->timestamps();
			$table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('stock_details');
	}

}

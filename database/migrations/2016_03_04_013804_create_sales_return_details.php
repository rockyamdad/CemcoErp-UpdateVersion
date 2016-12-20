<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesReturnDetails extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sales_return_details', function(Blueprint $table)
		{
			$table->increments('id');

			$table->string('product_type',255);
			$table->unsignedInteger('product_id');
			$table->foreign('product_id')->references('id')->on('products');
			$table->integer('quantity');
			$table->float('unit_price');
			$table->float('return_amount');

			$table->string('consignment_name',255);
			$table->text('remarks');

			$table->string('invoice_id', 255);

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
		Schema::drop('sales_return_details');
	}

}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesReturnTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sales_return', function(Blueprint $table)
		{
			$table->increments('id');
			$table->unsignedInteger('branch_id');
			$table->foreign('branch_id')->references('id')->on('branches');
			$table->unsignedInteger('party_id');
			$table->foreign('party_id')->references('id')->on('parties');
			$table->unsignedInteger('product_id');
			$table->foreign('product_id')->references('id')->on('products');
			$table->string('cus_ref_no',255);
			$table->string('consignment_name',255);
			$table->integer('quantity');
			$table->float('return_amount');
			$table->text('remarks');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('sales_return');
	}

}

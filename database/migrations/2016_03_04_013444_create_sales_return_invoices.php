<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesReturnInvoices extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sales_return_invoices', function(Blueprint $table)
		{
			$table->increments('id');
			$table->unsignedInteger('branch_id');
			$table->foreign('branch_id')->references('id')->on('branches');
			$table->unsignedInteger('party_id');
			$table->foreign('party_id')->references('id')->on('parties');
			$table->string('product_status',255);
			$table->string('ref_no',255);
			$table->float('discount_percentage',255);
			$table->unsignedInteger('user_id');
			$table->foreign('user_id')->references('id')->on('users');
			$table->string('invoice_id', 255);
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
		Schema::drop('sales_return_invoices');
	}

}

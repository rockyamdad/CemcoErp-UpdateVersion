<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddToStockInfoIdToSalesReturnInvoicesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('sales_return_invoices', function(Blueprint $table)
		{
			$table->unsignedInteger('to_stock_info_id');
			$table->foreign('to_stock_info_id')->references('id')->on('stock_infos');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('sales_return_invoices', function(Blueprint $table)
		{
			Schema::drop('sales_return_invoices');
		});
	}

}

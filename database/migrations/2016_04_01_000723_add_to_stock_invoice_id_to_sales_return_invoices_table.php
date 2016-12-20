<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddToStockInvoiceIdToSalesReturnInvoicesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('sales_return_invoices', function(Blueprint $table)
		{
			$table->text('stock_invoice_id');
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

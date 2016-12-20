<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropInvoiceIdToPurchaseInvoiceDetails extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('purchase_invoice_details', function(Blueprint $table){
			$table->string('detail_invoice_id',255);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('purchase_invoice_details', function(Blueprint $table){
			$table->dropColumn('detail_invoice_id');
		});
	}

}

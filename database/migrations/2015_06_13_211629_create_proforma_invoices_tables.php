<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProformaInvoicesTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('proforma_invoices', function(Blueprint $table)
		{
			$table->increments('id');
            $table->string('invoice_no',255);
            $table->string('beneficiary_name',255);
            $table->string('terms',255);
            $table->unsignedInteger('import_id');
            $table->foreign('import_id')->references('id')->on('imports');
            $table->softDeletes();
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
		Schema::drop('proforma_invoices');
	}

}

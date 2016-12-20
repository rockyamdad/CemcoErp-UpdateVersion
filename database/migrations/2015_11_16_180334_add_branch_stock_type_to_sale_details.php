<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBranchStockTypeToSaleDetails extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('sale_details', function(Blueprint $table)
		{
			$table->unsignedInteger('branch_id');
			$table->foreign('branch_id')->references('id')->on('branches');
			$table->unsignedInteger('stock_info_id');
			$table->foreign('stock_info_id')->references('id')->on('stock_infos');
			$table->string('product_type',255);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('sale_details', function(Blueprint $table)
		{
			Schema::drop('sale_details');
		});
	}

}

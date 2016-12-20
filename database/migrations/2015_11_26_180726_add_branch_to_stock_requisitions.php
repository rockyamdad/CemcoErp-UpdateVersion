<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBranchToStockRequisitions extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('stock_requisitions', function(Blueprint $table)
		{
			$table->unsignedInteger('branch_id');
			$table->foreign('branch_id')->references('id')->on('branches');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('stock_requisitions', function(Blueprint $table)
		{
			Schema::drop('stock_requisitions');
		});
	}

}

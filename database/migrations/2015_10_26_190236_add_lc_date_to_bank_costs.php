<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLcDateToBankCosts extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('bank_costs', function(Blueprint $table)
		{
			$table->string('lc_date',255);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('bank_costs', function(Blueprint $table)
		{
			Schema::drop('bank_costs');
		});
	}

}

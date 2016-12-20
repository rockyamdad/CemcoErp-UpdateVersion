<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddClearingDateToCnfCosts extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('cnf_costs', function(Blueprint $table)
		{
			$table->string('clearing_date',255);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('cnf_costs', function(Blueprint $table)
		{
			Schema::drop('cnf_costs');
		});
	}

}

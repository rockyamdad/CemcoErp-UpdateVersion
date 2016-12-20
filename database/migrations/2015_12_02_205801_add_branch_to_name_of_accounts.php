<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBranchToNameOfAccounts extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('name_of_accounts', function(Blueprint $table)
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
		Schema::table('name_of_accounts', function(Blueprint $table)
		{
			Schema::drop('name_of_accounts');
		});
	}

}

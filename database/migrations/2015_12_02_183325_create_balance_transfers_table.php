<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBalanceTransfersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('balance_transfers', function(Blueprint $table)
		{
			$table->increments('id');
			$table->unsignedInteger('from_branch_id');
			$table->foreign('from_branch_id')->references('id')->on('branches');
			$table->unsignedInteger('to_branch_id');
			$table->foreign('to_branch_id')->references('id')->on('branches');
			$table->unsignedInteger('from_account_category_id');
			$table->foreign('from_account_category_id')->references('id')->on('account_categories');
			$table->unsignedInteger('to_account_category_id');
			$table->foreign('to_account_category_id')->references('id')->on('account_categories');
			$table->unsignedInteger('from_account_name_id');
			$table->foreign('from_account_name_id')->references('id')->on('name_of_accounts');
			$table->unsignedInteger('to_account_name_id');
			$table->foreign('to_account_name_id')->references('id')->on('name_of_accounts');
			$table->float('amount');
			$table->text('remarks');
			$table->unsignedInteger('user_id');
			$table->foreign('user_id')->references('id')->on('users');
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
		Schema::drop('balance_transfers');
	}

}

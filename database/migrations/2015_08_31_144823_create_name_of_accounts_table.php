<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNameOfAccountsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('name_of_accounts', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name',255);
			$table->unsignedInteger('account_category_id');
			$table->foreign('account_category_id')->references('id')->on('account_categories');
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
		Schema::drop('name_of_accounts');
	}

}

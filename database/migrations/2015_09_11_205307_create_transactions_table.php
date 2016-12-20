<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('transactions', function(Blueprint $table)
		{
			$table->increments('id');
			$table->bigInteger('invoice_id');
			$table->float('amount');
			$table->string('type',255);
			$table->string('payment_method',255);
			$table->unsignedInteger('account_category_id');
			$table->foreign('account_category_id')->references('id')->on('account_categories');
			$table->text('remarks');
			$table->unsignedInteger('account_name_id');
			$table->foreign('account_name_id')->references('id')->on('name_of_accounts');
			$table->unsignedInteger('user_id');
			$table->foreign('user_id')->references('id')->on('users');
			$table->timestamps();
			$table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('transactions');
	}

}

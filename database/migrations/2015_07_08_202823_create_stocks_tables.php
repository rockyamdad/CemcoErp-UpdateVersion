<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStocksTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('stocks', function(Blueprint $table)
		{
			$table->increments('id');
            $table->unsignedInteger('product_id');
            $table->foreign('product_id')->references('id')->on('products');
			$table->unsignedInteger('stock_info_id');
			$table->foreign('stock_info_id')->references('id')->on('stock_infos');
            $table->integer('product_quantity');
            $table->string('entry_type',255);
            $table->string('status',255);
            $table->text('remarks');
            $table->string('consignment_name',255);
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
		Schema::drop('stocks');
	}

}

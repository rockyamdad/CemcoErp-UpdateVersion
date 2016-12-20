<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStockRequisitionsTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('stock_requisitions', function(Blueprint $table)
		{
			$table->increments('id');
            $table->unsignedInteger('party_id');
            $table->foreign('party_id')->references('id')->on('parties');
            $table->string('requisition_id',255);
            $table->unsignedInteger('product_id');
            $table->foreign('product_id')->references('id')->on('products');
            $table->integer('requisition_quantity');
            $table->integer('issued_quantity');
            $table->string('remarks',255);
            $table->string('status',255);
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
		Schema::drop('stock_requisitions');
	}

}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOtherCostsTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('other_costs', function(Blueprint $table)
		{
			$table->increments('id');
            $table->double('dollar_to_bd_rate');
            $table->double('tt_charge');
            $table->unsignedInteger('import_id');
            $table->foreign('import_id')->references('id')->on('imports');
            $table->softDeletes();
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
		Schema::drop('other_costs');
	}

}

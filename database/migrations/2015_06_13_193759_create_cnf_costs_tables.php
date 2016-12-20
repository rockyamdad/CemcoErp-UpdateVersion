<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCnfCostsTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cnf_costs', function(Blueprint $table)
		{
			$table->increments('id');
            $table->string('clearing_agent_name',255);
            $table->string('bill_no',255);
            $table->string('bank_no',255);
            $table->double('association_fee');
            $table->double('po_cash');
            $table->double('port_charge');
            $table->double('shipping_charge');
            $table->double('noc_charge');
            $table->double('labour_charge');
            $table->double('jetty_charge');
            $table->double('agency_commission');
            $table->double('others_charge');
            $table->double('total_cnf_cost');
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
		Schema::drop('cnf_costs');
	}

}

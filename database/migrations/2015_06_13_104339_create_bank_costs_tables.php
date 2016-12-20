<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBankCostsTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('bank_costs', function(Blueprint $table)
		{
			$table->increments('id');
            $table->string('lc_no',255);
            $table->string('bank_name',255);
            $table->double('lc_commission_charge');
            $table->double('vat_commission');
            $table->double('stamp_charge');
            $table->double('swift_charge');
            $table->double('lca_charge');
            $table->double('insurance_charge');
            $table->double('bank_service_charge');
            $table->double('others_charge');
            $table->double('total_bank_cost');
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
		Schema::drop('bank_costs');
	}

}

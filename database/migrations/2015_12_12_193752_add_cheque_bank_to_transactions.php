<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddChequeBankToTransactions extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('transactions', function(Blueprint $table)
        {
            $table->string('cheque_bank',255);
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::table('transactions', function(Blueprint $table)
        {
            Schema::drop('transactions');
        });
	}

}

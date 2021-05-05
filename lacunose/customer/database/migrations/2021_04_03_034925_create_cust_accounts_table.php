<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cust_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');

            $table->string('no')->nullable();
            $table->bigInteger('customer_id');

            $table->string('currency');
            $table->double('exchange_rate_to_idr');
            
            $table->datetime('resetted_at')->nullable();
            $table->string('reset_period')->nullable();
            
            $table->double('verified_balance')->default(0);
            $table->double('pending_balance')->default(0);

            $table->string('status');
            
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
        Schema::dropIfExists('cust_accounts');
    }
}

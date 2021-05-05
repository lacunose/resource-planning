<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustCustomerMarksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cust_customer_marks', function (Blueprint $table) {
            $table->id();
            $table->integer('customer_id');

            $table->string('type')->default('favourite');
            $table->string('catalog_code');
            $table->string('catalog_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cust_customer_marks');
    }
}

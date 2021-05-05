<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cust_customers', function (Blueprint $table) {
            $table->id();

            $table->string('uuid')->nullable();
            $table->string('code')->nullable();

            $table->string('pid')->nullable();
            $table->string('name');
            $table->string('phone');
            $table->string('email')->unique();
            $table->string('address')->nullable();

            $table->string('status')->default('inactived');
            
            $table->timestamps();
            $table->softdeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cust_customers');
    }
}

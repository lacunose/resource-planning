<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProcureOrderPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('procure_order_payments', function (Blueprint $table) {
            $table->integer('order_id');
            $table->integer('user_id');
            $table->datetime('date');
            $table->string('description')->nullable();
            $table->string('method');
            $table->string('no_ref')->nullable();
            $table->double('amount');
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
        Schema::dropIfExists('procure_order_payments');
    }
}

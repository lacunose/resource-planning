<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubPlanBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_plan_bills', function (Blueprint $table) {
            $table->id();
            $table->integer('plan_id');
            $table->string('no')->nullable();
            $table->bigInteger('nth')->default(1);
            
            $table->datetime('issued_at');
            $table->datetime('paid_at')->nullable();

            $table->text('billing')->nullable();

            $table->datetime('due_at')->nullable();
            $table->double('due_amount')->nullable();

            $table->text('issuer')->nullable();
            $table->text('biller')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sub_plan_bills');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProcureOrderBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('procure_order_bills', function (Blueprint $table) {
            $table->id();
            $table->integer('order_id');
            $table->string('item_code')->nullable();
            $table->text('description');
            $table->integer('qty')->default(1);
            $table->integer('rcv')->default(0);
            $table->double('amount')->default(0);
            $table->text('note')->nullable();
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
        Schema::dropIfExists('procure_order_bills');
    }
}

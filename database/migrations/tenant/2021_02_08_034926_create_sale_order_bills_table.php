<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaleOrderBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_order_bills', function (Blueprint $table) {
            $table->id();
            $table->integer('order_id');
            $table->string('catalog_code')->nullable();
            $table->double('catalog_price')->default(0);
            $table->string('flag')->nullable();
            $table->text('description');
            $table->integer('qty')->default(1);
            $table->double('amount')->default(0);
            $table->string('promo_code')->nullable();
            $table->text('note')->nullable();
            $table->text('ux')->nullable();
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
        Schema::dropIfExists('sale_order_bills');
    }
}

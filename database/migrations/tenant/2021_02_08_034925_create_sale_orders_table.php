<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaleOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_orders', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->string('no')->unique();
            $table->string('no_ref')->nullable();
            
            $table->datetime('issued_at');

            $table->string('marketplace')->default('POS');
            $table->string('outlet')->default('default');
            $table->string('courier')->default('PICKUP');
            $table->string('warehouse')->nullable();
            
            $table->text('shipping')->nullable();
            $table->text('store')->nullable();
            $table->text('customer')->nullable();
            $table->text('processes')->nullable();
            
            $table->string('status')->default('opened');

            $table->boolean('is_printed')->default(false);
            $table->boolean('can_print')->default(false);
            $table->boolean('has_printed_before')->default(false);

            $table->bigInteger('user_id')->nullable();
            
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
        Schema::dropIfExists('sale_orders');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fin_orders', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');

            $table->string('no')->unique();
            $table->string('no_ref')->nullable();
            $table->datetime('issued_at');
            
            $table->string('mode')->nullable();
            $table->string('type')->nullable();
            $table->string('branch')->default('default');

            $table->text('billing')->nullable();
            $table->text('issuer')->nullable();
            $table->text('customer')->nullable();
           
            $table->text('payment')->nullable();
            
            $table->datetime('paid_at')->nullable();
            $table->bigInteger('paid_by')->nullable();
            
            $table->string('status')->default('opened');

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
        Schema::dropIfExists('fin_orders');
    }
}

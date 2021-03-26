<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaleMatrixesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_matrixes', function (Blueprint $table) {
            $table->id();
            $table->biginteger('order_id');
            $table->biginteger('user_id')->nullable();
            $table->string('outlet')->default('default');
            $table->datetime('date');
            $table->string('group');
            $table->string('attribute');
            $table->string('label');
            $table->double('amount')->default(0);
            $table->double('frequency')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sale_matrixes');
    }
}

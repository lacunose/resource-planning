<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProcureMatrixesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('procure_matrixes', function (Blueprint $table) {
            $table->id();
            $table->biginteger('order_id');
            $table->biginteger('user_id')->nullable();
            $table->datetime('date');
            $table->string('supplier');
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
        Schema::dropIfExists('procure_matrixes');
    }
}

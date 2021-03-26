<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWhMatrixesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wh_matrixes', function (Blueprint $table) {
            $table->id();
            $table->biginteger('item_id');
            $table->string('item_code');
            $table->string('warehouse')->default('default');
            $table->datetime('date');
            $table->string('group');
            $table->string('attribute');
            $table->string('label');
            $table->double('amount')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wh_matrixes');
    }
}

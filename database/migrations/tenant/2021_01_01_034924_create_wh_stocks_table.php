<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWhStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wh_stocks', function (Blueprint $table) {
            $table->id();
            $table->integer('document_id');
            $table->integer('item_id');
            $table->date('date');

            $table->string('batch')->nullable();
            $table->string('owner')->nullable();
            $table->string('warehouse')->nullable();
            $table->date('expired_at')->nullable();
            
            $table->string('description');
            $table->double('amount');
            $table->double('price')->default(0);
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
        Schema::dropIfExists('wh_stocks');
    }
}

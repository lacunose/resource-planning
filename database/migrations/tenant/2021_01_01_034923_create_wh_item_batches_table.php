<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWhItemBatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wh_item_batches', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('item_id');
            $table->string('batch');
            $table->string('owner')->nullable();
            $table->string('warehouse')->nullable();
            $table->date('expired_at')->nullable();
            $table->double('current_stock')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('wh_item_batches');
    }
}

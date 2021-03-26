<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWhItemStatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wh_item_stats', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('item_id');
            $table->string('warehouse')->nullable();

            $table->double('onhold_stock')->default(0);
            $table->double('current_stock')->default(0);
            $table->double('reserved_stock')->default(0);
            $table->double('incoming_stock')->default(0);

            //OPNAME STAT
            $table->datetime('opnamed_at')->nullable();
            $table->datetime('moved_at')->nullable();
            $table->double('frequency')->default(0);
           
            //REORDER STAT
            $table->double('max_usage')->default(0);
            $table->double('avg_usage')->default(0);

            //SUPPLIER DATA
            $table->string('last_owner')->nullable();
            $table->double('avg_polt_in_days')->default(0);
            $table->double('max_polt_in_days')->default(0);
            $table->double('purchase_price')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('wh_item_stats');
    }
}

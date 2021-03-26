<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProcureOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('procure_orders', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->string('no')->unique();
            $table->string('no_ref')->nullable();
            
            $table->datetime('issued_at');

            $table->string('mode')->default('POS');
            $table->string('supplier')->nullable();
            $table->string('warehouse')->nullable();
            
            $table->text('sender')->nullable();
            $table->text('processes')->nullable();
            
            $table->string('status')->default('opened');

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
        Schema::dropIfExists('procure_orders');
    }
}

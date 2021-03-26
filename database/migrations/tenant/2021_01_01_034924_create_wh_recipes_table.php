<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWhRecipesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wh_recipes', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');

            $table->bigInteger('item_id');
            $table->string('type');
            $table->string('status');
            
            $table->string('no')->nullable();
            $table->string('title');

            $table->longText('composition')->nullable();

            $table->datetime('drafted_at')->nullable();
            $table->integer('drafted_by')->nullable();

            $table->datetime('actived_at')->nullable();
            $table->integer('actived_by')->nullable();

            $table->datetime('archived_at')->nullable();
            $table->integer('archived_by')->nullable();

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
        Schema::dropIfExists('wh_recipes');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fin_assets', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');

            $table->string('type');
            $table->string('status');
            
            $table->string('no')->nullable();
            $table->double('book_value');
            $table->string('method');

            $table->datetime('date');
            $table->string('title');
            $table->double('historical_cost');

            $table->integer('nth')->default(0);
            $table->datetime('deprecated_at')->nullable();

            $table->longText('acquisition')->nullable();
            $table->longText('consumption')->nullable();
            $table->longText('disposition')->nullable();

            $table->datetime('drafted_at')->nullable();
            $table->integer('drafted_by')->nullable();

            $table->datetime('actived_at')->nullable();
            $table->integer('actived_by')->nullable();

            $table->datetime('disposed_at')->nullable();
            $table->integer('disposed_by')->nullable();

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
        Schema::dropIfExists('fin_assets');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_prices', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');

            $table->string('title');
            $table->string('membership');
            $table->string('period');

            $table->text('contract')->nullable();
            $table->text('scopes')->nullable();
            $table->text('clients')->nullable();
            $table->text('description')->nullable();

            $table->datetime('published_at')->nullable();
            $table->datetime('published_until')->nullable();

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
        Schema::dropIfExists('sub_prices');
    }
}

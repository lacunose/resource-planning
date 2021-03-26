<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaleProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_products', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->string('code')->unique();
            $table->string('name');
            $table->string('group');

            $table->text('galleries')->nullable();
            $table->text('description')->nullable();
            
            $table->double('price')->default(0);
            $table->double('max_price')->default(0);
            
            $table->boolean('has_item')->default(0);

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
        Schema::dropIfExists('sale_products');
    }
}

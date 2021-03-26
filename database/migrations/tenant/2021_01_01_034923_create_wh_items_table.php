<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWhItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wh_items', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->string('name');
            $table->string('code')->unique();
            $table->string('type')->nullable();
            $table->string('unit')->nullable();

            $table->string('status')->nullable();

            $table->datetime('drafted_at')->nullable();
            $table->integer('drafted_by')->nullable();

            $table->datetime('submitted_at')->nullable();
            $table->integer('submitted_by')->nullable();
            
            $table->datetime('archived_at')->nullable();
            $table->integer('archived_by')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('wh_items');
    }
}

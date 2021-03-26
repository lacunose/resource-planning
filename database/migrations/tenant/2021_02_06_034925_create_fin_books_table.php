<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fin_books', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');

            $table->string('type')->nullable();
            $table->string('cause')->nullable();
            $table->string('group')->nullable();
            $table->string('status')->nullable();

            $table->string('no')->nullable();
            $table->string('no_ref')->nullable();
            $table->datetime('date')->nullable();

            $table->json('lines')->nullable();
            $table->json('refs')->nullable();
            $table->json('journals')->nullable();

            $table->json('issuer')->nullable();
            $table->json('customer')->nullable();

            $table->datetime('drafted_at')->nullable();
            $table->integer('drafted_by')->nullable();

            $table->datetime('journaled_at')->nullable();
            $table->integer('journaled_by')->nullable();

            $table->datetime('locked_at')->nullable();
            $table->integer('locked_by')->nullable();

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
        Schema::dropIfExists('fin_books');
    }
}

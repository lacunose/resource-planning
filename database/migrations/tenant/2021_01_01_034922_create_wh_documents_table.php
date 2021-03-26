<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWhDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wh_documents', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');

            $table->string('no_ref')->nullable();
            $table->boolean('is_seen')->default(false);

            $table->string('type')->nullable();
            $table->string('cause')->nullable();
            $table->string('owner')->default('default');
            $table->string('warehouse')->default('default');
            $table->string('status')->nullable();

            $table->string('no')->nullable();
            $table->datetime('date')->nullable();
            $table->text('title')->nullable();

            $table->json('refs')->nullable();
            $table->json('stocks')->nullable();

            $table->json('sender')->nullable();
            $table->json('receiver')->nullable();

            $table->datetime('requested_at')->nullable();

            $table->datetime('drafted_at')->nullable();
            $table->integer('drafted_by')->nullable();

            $table->datetime('submitted_at')->nullable();
            $table->integer('submitted_by')->nullable();

            $table->datetime('stocked_at')->nullable();
            $table->integer('stocked_by')->nullable();

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
        Schema::dropIfExists('wh_documents');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWhDocumentTimersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wh_document_timers', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->bigInteger('document_id');
            $table->string('group');
            $table->datetime('started_at');
            $table->datetime('completed_at')->nullable();
            $table->double('duration')->default(0);
            $table->text('start_evidence')->nullable();
            $table->text('complete_evidence')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wh_document_timers');
    }
}

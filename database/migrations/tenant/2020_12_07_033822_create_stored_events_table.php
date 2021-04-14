<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoredEventsTable extends Migration
{
    public function up()
    {
        Schema::create('stored_events', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('aggregate_uuid')->nullable();
            $table->unsignedBigInteger('aggregate_version')->nullable();
            $table->string('event_class');
            $table->json('event_properties');
            $table->json('meta_data');
            $table->timestamp('created_at');
            $table->index('event_class');
            $table->index('aggregate_uuid');
        });
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if(in_array(env('APP_ENV', 'local'), ['local', 'beta'])) {
            Schema::dropIfExists('stored_events');
        }
    }
}

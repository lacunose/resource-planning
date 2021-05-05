<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustProgramsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cust_programs', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');

            $table->string('title');

            $table->string('trigger_event');
            $table->string('trigger_param');
            $table->string('trigger_value');
            $table->integer('trigger_loop')->default(0);

            $table->string('target_event');
            $table->string('target_field');
            $table->string('target_value');
            $table->double('target_gain')->default(0);
            
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
        Schema::dropIfExists('cust_programs');
    }
}

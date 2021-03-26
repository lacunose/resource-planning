<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_plans', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->bigInteger('user_id')->nullable();

            $table->string('no')->nullable();
            $table->string('website');
            $table->string('membership');
            $table->string('period');

            $table->text('issuer')->nullable();
            $table->text('biller')->nullable();
            
            $table->text('contract')->nullable();
            $table->text('scopes')->nullable();
            $table->text('clients')->nullable();

            $table->bigInteger('nth')->default(0);
            $table->bigInteger('is_extendable')->default(false);

            $table->datetime('started_at')->nullable();
            $table->datetime('ended_at')->nullable();
            
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
        Schema::dropIfExists('sub_plans');
    }
}

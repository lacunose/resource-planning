<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppConflictsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_conflicts', function (Blueprint $table) {
            $table->id();
            $table->string('topic');
            $table->string('code');
            $table->text('audiences')->nullable();
            $table->text('histories')->nullable();
            $table->text('stakes')->nullable();
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
        Schema::dropIfExists('app_conflicts');
    }
}

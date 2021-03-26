<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAclAccessesTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tacl_accesses', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');

            $table->string('website');
            $table->string('email');
            $table->string('role');

            $table->string('token')->nullable();
            $table->text('scopes');
            $table->text('clients');

            $table->datetime('accepted_at')->nullable();
            
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
        Schema::dropIfExists('tacl_accesses');
    }
}

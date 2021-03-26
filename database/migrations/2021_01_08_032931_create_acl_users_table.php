<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAclUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tacl_users', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->nullable();
            $table->string('name');
            $table->string('email')->unique();
            $table->datetime('email_verified_at')->nullable();
            $table->datetime('last_seen_at')->nullable();

            $table->text('scopes')->nullable();
            $table->string('level')->default('member');

            $table->string('password')->nullable();
            $table->string('email_verification_token')->nullable();
            $table->string('email_verification_token_expired_at')->nullable();
            
            $table->string('fcm_token')->nullable();

            $table->rememberToken();
            $table->timestamps();
            $table->softdeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tacl_users');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustAccountLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cust_account_logs', function (Blueprint $table) {
            $table->id();
            $table->integer('account_id');

            $table->datetime('issued_at');
            $table->datetime('verified_at')->nullable();

            $table->string('no_ref');
            $table->text('description');
            $table->double('amount')->default(0);

            $table->double('previous_balance')->default(0);
            
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
        Schema::dropIfExists('cust_account_logs');
    }
}

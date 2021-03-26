<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalePromosTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('sale_promos', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');

            $table->string('title');
            $table->string('code');
            $table->string('campaign');
            $table->string('mode');
            $table->string('type');
            $table->string('outlet')->default('default');
            
            $table->double('quota')->default(0);
            $table->string('quota_period')->default('daily');
            
            $table->datetime('activated_at')->nullable();
            $table->datetime('activated_until')->nullable();

            $table->string('repeat_day')->nullable();
            $table->time('repeat_hour_start')->nullable();
            $table->time('repeat_hour_end')->nullable();
            
            $table->longText('terms')->nullable();
            $table->longText('benefits')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('sale_promos');
    }
}

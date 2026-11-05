<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('currency_settings', function (Blueprint $table) {
            $table->id();
            $table->string('parent_currency')->default('usd')->nullable();
            $table->string('usd_rate')->nullable();
            $table->string('usd_symbol')->nullable();
            $table->string('jpn_rate')->nullable();
            $table->string('jpn_symbol')->nullable();
            $table->string('ksa_riyal')->nullable();
            $table->string('riyal_symbol')->nullable();
            $table->string('bdt_rate')->nullable();
            $table->string('bdt_symbol')->nullable();
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
        Schema::dropIfExists('currency_settings');
    }
};

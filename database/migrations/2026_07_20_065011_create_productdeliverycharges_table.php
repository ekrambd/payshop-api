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
        Schema::create('productdeliverycharges', function (Blueprint $table) {
            $table->id();
            $table->integer('vendor_id');
            $table->integer('product_id');
            $table->string('inside_base_charge');
            $table->string('outside_base_charge');
            $table->string('per_weight_charge');
            $table->string('product_weight');
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
        Schema::dropIfExists('productdeliverycharges');
    }
};

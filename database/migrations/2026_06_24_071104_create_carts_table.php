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
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->string('cart_session_id');
            $table->foreignId('product_id')->constrained()->cascadeOnDelete()->nullable();
            $table->foreignId('variant_id')->constrained()->cascadeOnDelete()->nullable();
            $table->integer('vendor_id');
            $table->string('cart_price');
            $table->string('cart_qty');
            $table->string('currency')->nullable();
            $table->string('unit_total')->nullable();
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
        Schema::dropIfExists('carts');
    }
};

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
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete()->nullable();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete()->nullable();
            $table->foreignId('product_variant_id')->constrained()->cascadeOnDelete()->nullable();
            $table->foreignId('payment_method_id')->constrained()->cascadeOnDelete()->nullable();
            $table->decimal('purchase_price', 10, 2);
            $table->decimal('purchase_discount', 10, 2)->default(0);
            $table->decimal('qty', 10, 2);
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
        Schema::dropIfExists('order_details');
    }
};

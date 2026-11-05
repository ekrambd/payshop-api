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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->foreignId('subcategory_id')->constrained()->cascadeOnDelete()->nullable();
            $table->foreignId('unit_id')->constrained()->cascadeOnDelete();
            $table->string('product_name');
            $table->string('slug');
            $table->decimal('product_price', 10, 2);
            $table->decimal('product_discount', 10, 2)->default(0);
            $table->decimal('stock_qty', 10, 2);
            $table->text('description');
            $table->string('featured_image');
            $table->enum('status', ['Active', 'Inactive']);
            $table->enum('admin_verify', ['No', 'Yes']);
            $table->index('product_name');
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
        Schema::dropIfExists('products');
    }
};

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
        Schema::create('admin_fields', function (Blueprint $table) {
            $table->id();

            $table->integer('role_id');
            $table->enum('slider_add', ['No', 'Yes'])->default('No');
            $table->enum('slider_edit', ['No', 'Yes'])->default('No');
            $table->enum('slider_lists', ['No', 'Yes'])->default('No');
            $table->enum('slider_delete', ['No', 'Yes'])->default('No');
            $table->enum('slider_status_update', ['No', 'Yes'])->default('No');
            $table->enum('category_add', ['No', 'Yes'])->default('No');
            $table->enum('category_edit', ['No', 'Yes'])->default('No');
            $table->enum('category_lists', ['No', 'Yes'])->default('No');
            $table->enum('category_delete', ['No', 'Yes'])->default('No');
            $table->enum('category_status_update', ['No', 'Yes'])->default('No');
            $table->enum('subcategory_add', ['No', 'Yes'])->default('No');
            $table->enum('subcategory_edit', ['No', 'Yes'])->default('No');
            $table->enum('subcategory_lists', ['No', 'Yes'])->default('No');
            $table->enum('subcategory_delete', ['No', 'Yes'])->default('No');
            $table->enum('subcategory_status_update', ['No', 'Yes'])->default('No');

            $table->enum('unit_add', ['No', 'Yes'])->default('No');
            $table->enum('unit_edit', ['No', 'Yes'])->default('No');
            $table->enum('unit_lists', ['No', 'Yes'])->default('No');
            $table->enum('unit_delete', ['No', 'Yes'])->default('No');
            $table->enum('unit_status_update', ['No', 'Yes'])->default('No');
            

            $table->enum('variant_add', ['No', 'Yes'])->default('No');
            $table->enum('vairant_edit', ['No', 'Yes'])->default('No');
            $table->enum('variant_lists', ['No', 'Yes'])->default('No');
            $table->enum('variant_delete', ['No', 'Yes'])->default('No');

            $table->enum('vendor_lists', ['No', 'Yes'])->default('No');
            $table->enum('vendor_product_verify', ['No', 'Yes'])->default('No');
            $table->enum('vendor_product_status_change', ['No', 'Yes'])->default('No');
            $table->enum('vendor_product_lists', ['No', 'Yes'])->default('No');
            $table->enum('vendor_edit_requests', ['No', 'Yes'])->default('No');


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
        Schema::dropIfExists('admin_fields');
    }
};

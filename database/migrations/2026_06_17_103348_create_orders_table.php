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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete()->nullable();
            $table->foreignId('payment_method_id')->constrained()->cascadeOnDelete()->nullable();
            $table->string('invoice_no');
            $table->date('date');
            $table->string('time');
            $table->string('timestamp');
            $table->decimal('sub_total', 10, 2);
            $table->decimal('vat_tax', 10, 2)->default(0);
            $table->decimal('total', 10, 2);
            $table->string('user_name')->nullable();
            $table->string('user_email')->nullable();
            $table->string('user_phone')->nullable();
            $table->text('user_address')->nullable();
            $table->string('user_city')->nullable();
            $table->string('user_country')->nullabe();
            $table->string('user_zipcode')->nullable();
            $table->enum('order_type', ['direct_order', 'authetic_order']);
            $table->string('delivery_charge')->nullable();
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
        Schema::dropIfExists('orders');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
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
            $table->bigInteger('shopify_id')->nullable();
            $table->string('order_number')->nullable();
            $table->text('note')->nullable();
            $table->string('date')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('currency')->nullable();
            $table->bigInteger('total_price')->nullable();
            $table->string('financial_status')->nullable();
            $table->string('fulfillment_status')->nullable();
            $table->bigInteger('customer_phone')->nullable();
            $table->string('items')->nullable();
            $table->integer('total_discount')->nullable();
            $table->integer('total_shipping')->nullable();
            $table->integer('sub_total')->nullable();
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
}

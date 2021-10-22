<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCheckoutOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('checkout_orders', function (Blueprint $table) {
            $table->id();
            $table->string('note')->nullable();
            $table->string('currency')->nullable();
            $table->integer('total_price')->nullable();
            $table->integer('total_discount')->nullable();
            $table->integer('total_weight')->nullable();
            $table->string('news')->nullable();
            $table->string('emailorphone')->nullable();
            $table->string('country')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('address')->nullable();
            $table->string('apartment')->nullable();
            $table->string('city')->nullable();
            $table->string('postal')->nullable();
            $table->string('province')->nullable();
            $table->boolean('status')->default(0);
            $table->string('create_status')->default('no');
            $table->string('draft_order_id')->nullable();
            $table->string('invoice_url')->nullable();
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
        Schema::dropIfExists('checkout_orders');
    }
}

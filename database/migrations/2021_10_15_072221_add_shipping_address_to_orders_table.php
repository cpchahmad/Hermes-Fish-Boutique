<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddShippingAddressToOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('customer_email')->nullable();
            $table->string('ship_name')->nullable();
            $table->string('ship_address1')->nullable();
            $table->string('ship_address2')->nullable();
            $table->string('ship_phone')->nullable();
            $table->string('ship_city')->nullable();
            $table->string('ship_zip')->nullable();
            $table->string('ship_province')->nullable();
            $table->string('ship_country')->nullable();
            $table->string('billing_name')->nullable();
            $table->string('billing_address1')->nullable();
            $table->string('billing_address2')->nullable();
            $table->string('billing_phone')->nullable();
            $table->string('billing_city')->nullable();
            $table->string('billing_zip')->nullable();
            $table->string('billing_province')->nullable();
            $table->string('billing_country')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            //
        });
    }
}

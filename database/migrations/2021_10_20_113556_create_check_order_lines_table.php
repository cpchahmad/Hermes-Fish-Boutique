<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCheckOrderLinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('check_order_lines', function (Blueprint $table) {
            $table->id();
            $table->integer('order_id')->nullable();
            $table->bigInteger('product_id')->nullable();
            $table->string('sku')->nullable();
            $table->string('title')->nullable();
            $table->integer('price')->nullable();
            $table->integer('quantity')->nullable();
            $table->bigInteger('variant_id')->nullable();
            $table->string('variant_title')->nullable();
            $table->string('image')->nullable();
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
        Schema::dropIfExists('check_order_lines');
    }
}

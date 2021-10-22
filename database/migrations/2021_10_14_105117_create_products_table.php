<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
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
            $table->bigInteger('shopify_id')->nullable();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->string('handle')->nullable();
            $table->string('vendor')->nullable();
            $table->string('type')->nullable();
            $table->text('featured_image')->nullable();
            $table->string('tags')->nullable();
            $table->text('options')->nullable();
            $table->text('status')->nullable();
            $table->string('published_at')->nullable();
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
}

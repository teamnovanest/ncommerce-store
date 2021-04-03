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
            $table->integer('category_id');
            $table->integer('subcategory_id');
            $table->integer('brand_id');
            $table->integer('merchant_organization_id');
            $table->string('product_name');
            $table->string('product_code');
            $table->integer('product_quantity');
            $table->text('product_details');
            $table->string('slug')->nullable();
            $table->string('sku')->nullable();
            $table->string('product_color');
            $table->string('product_size');
            $table->integer('selling_price'); // save price in peswas (selling_price * 100)
            $table->integer('discount_price')->nullable();
            $table->string('video_link')->nullable();
            // $table->integer('main_slider')->nullable();
            // $table->integer('hot_deal')->nullable();
            $table->integer('best_rated')->nullable();
            // $table->integer('mid_slider')->nullable();
            $table->integer('hot_new')->nullable();
            $table->integer('buyone_getone')->nullable();
            $table->integer('trend')->nullable();
            $table->string('image_one_public_id')->nullable();
            $table->string('image_one_secure_url')->nullable();
            $table->string('image_two_public_id')->nullable();
            $table->string('image_two_secure_url')->nullable();
            $table->string('image_three_public_id')->nullable();
            $table->string('image_three_secure_url')->nullable();
            $table->integer('status')->nullable();
            $table->softDeletes();
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

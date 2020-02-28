<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponItemMallCategoryTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::connection('srocms')->create('coupon_item_mall_category', function (Blueprint $table)
        {
            $table->bigIncrements('id');
            $table->bigInteger('coupon_id');
            $table->bigInteger('item_mall_category_id');
            $table->timestamps();

            $table->foreign('coupon_id')->references('id')->on('coupons')->onDelete('cascade');
            $table->foreign('item_mall_category_id')->references('id')->on('item_mall_categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::connection('srocms')->dropIfExists('coupon_item_mall_category');
    }
}

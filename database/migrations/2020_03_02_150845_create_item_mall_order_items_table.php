<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemMallOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::connection('srocms')->create('item_mall_order_items', function (Blueprint $table)
        {
            $table->bigIncrements('id');
            $table->bigInteger('item_mall_item_group_id');
            $table->bigInteger('item_mall_order_id');
            $table->integer('user_id');
            $table->integer('quantity')->default(1);
            $table->tinyInteger('payment_type')->default(1);
            $table->decimal('item_price', 13, 2);
            $table->decimal('total_paid', 13, 2);
            $table->decimal('points_earned', 13, 2)->default(0);
            $table->timestamps();

            $table->foreign('item_mall_item_group_id')->references('id')->on('item_mall_item_groups')->onDelete('cascade');
            $table->foreign('item_mall_order_id')->references('id')->on('item_mall_orders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::connection('srocms')->dropIfExists('item_mall_order_items');
    }
}

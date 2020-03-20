<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemMallCategoryItemMallItemGroupTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::connection('srocms')->create('item_mall_category_item_mall_item_group', function (Blueprint $table)
        {
            $table->id();
            $table->foreignId('item_mall_category_id');
            $table->foreignId('item_mall_item_group_id');
            $table->timestamps();

            $table->foreign('item_mall_category_id')->references('id')->on('item_mall_categories')->onDelete('cascade');
            $table->foreign('item_mall_item_group_id')->references('id')->on('item_mall_item_groups')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::connection('srocms')->dropIfExists('item_mall_category_item_mall_item_group');
    }
}

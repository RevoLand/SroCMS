<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemMallItemGroupPriceChangesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::connection('srocms')->create('item_mall_item_group_price_changes', function (Blueprint $table)
        {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('item_mall_item_group_id');
            $table->decimal('price_before', 13, 2)->default(0);
            $table->decimal('price_after', 13, 2)->default(0);
            $table->timestamps();

            $table->foreign('item_mall_item_group_id')->references('id')->on('item_mall_item_groups')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::connection('srocms')->dropIfExists('item_mall_item_group_price_changes');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemMallItemsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::connection('srocms')->create('item_mall_items', function (Blueprint $table)
        {
            $table->id();
            $table->foreignId('item_mall_item_group_id');
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->string('image')->nullable();
            $table->tinyInteger('type')->default(6);
            $table->string('codename')->nullable();
            $table->integer('amount')->nullable();
            $table->decimal('balance', 13, 2)->nullable();
            $table->tinyInteger('plus')->nullable();
            $table->boolean('enabled')->default(true);
            $table->timestamps();

            $table->foreign('item_mall_item_group_id')->references('id')->on('item_mall_item_groups')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::connection('srocms')->dropIfExists('item_mall_items');
    }
}

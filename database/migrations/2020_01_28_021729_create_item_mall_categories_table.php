<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemMallCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::connection('srocms')->create('item_mall_categories', function (Blueprint $table)
        {
            $table->bigIncrements('id');
            $table->string('name');
            $table->boolean('enabled')->default(true);
            $table->integer('order')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::connection('srocms')->dropIfExists('item_mall_categories');
    }
}

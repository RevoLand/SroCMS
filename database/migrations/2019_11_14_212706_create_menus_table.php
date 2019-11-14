<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::connection('srocms')->create('menus', function (Blueprint $table)
        {
            $table->bigIncrements('id');
            $table->string('title')->nullable();
            $table->string('href')->nullable();
            $table->integer('target_page_id')->nullable();
            $table->integer('order')->nullable();
            $table->string('location')->nullable();
            $table->boolean('enabled')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::connection('srocms')->dropIfExists('menus');
    }
}

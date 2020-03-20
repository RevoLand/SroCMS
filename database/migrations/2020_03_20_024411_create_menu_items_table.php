<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenuItemsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::connection('srocms')->create('menu_items', function (Blueprint $table)
        {
            /*
            Menü Tipleri:
                1 => Klasik, Title ve Href tanımlamaları kullanılacak.
                2 => Sayfa, Page_id ve belirtilmesi durumunda Title tanımlaması kullanılacak, aksi halde Sayfa'nın başlığı alınacak.
                3 => Route, Route ve Title tanımlamaları kullanılacak.
            */
            $table->id();
            $table->foreignId('menu_id');
            $table->tinyInteger('type')->default(1);
            $table->string('title')->nullable();
            $table->string('href')->nullable();
            $table->foreignId('page_id')->nullable();
            $table->string('route')->nullable();
            $table->foreignId('parent_id')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('guests_can_view')->default(true);
            $table->boolean('users_can_view')->default(true);
            $table->boolean('enabled')->default(true);
            $table->timestamps();

            $table->foreign('menu_id')->references('id')->on('menus')->onDelete('cascade');
            $table->foreign('page_id')->references('id')->on('pages')->onDelete('cascade');
            $table->foreign('parent_id')->references('id')->on('menu_items');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::connection('srocms')->dropIfExists('menu_items');
    }
}

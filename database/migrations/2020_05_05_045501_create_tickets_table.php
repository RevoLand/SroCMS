<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::connection('srocms')->create('tickets', function (Blueprint $table)
        {
            $table->id();
            $table->integer('user_id');
            $table->foreignId('ticket_category_id');
            $table->integer('assigned_user_id')->nullable();
            $table->foreignId('item_mall_order_id')->nullable();
            $table->string('title');
            $table->tinyInteger('priority')->default(0);
            $table->tinyInteger('status')->default(0);
            $table->ipAddress('ip');
            $table->timestamps();

            $table->foreign('ticket_category_id')->references('id')->on('ticket_categories')->onDelete('cascade');
            $table->foreign('item_mall_order_id')->references('id')->on('item_mall_orders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::connection('srocms')->dropIfExists('tickets');
    }
}

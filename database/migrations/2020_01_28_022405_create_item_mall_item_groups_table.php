<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemMallItemGroupsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::connection('srocms')->create('item_mall_item_groups', function (Blueprint $table)
        {
            $table->bigIncrements('id');
            $table->bigInteger('item_mall_category_id');
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('image')->nullable();
            $table->tinyInteger('payment_type')->default(1);
            $table->decimal('price', 13, 2);
            $table->string('price_item_codename')->nullable();
            $table->integer('price_item_amount')->nullable();
            $table->boolean('limit_total_purchases')->default(false);
            $table->integer('total_purchase_limit')->nullable();
            $table->boolean('limit_user_purchases')->default(false);
            $table->integer('user_purchase_limit')->nullable();
            $table->boolean('use_customized_referral_options')->default(false);
            $table->boolean('referral_commission_enabled')->default(true);
            $table->tinyInteger('referral_commission_reward_type')->default(2);
            $table->integer('referral_commission_percentage')->nullable();
            $table->boolean('featured')->default(false);
            $table->integer('order')->default(1)->nullable();
            $table->boolean('enabled')->default(true);
            $table->timestamps();

            $table->foreign('item_mall_category_id')
                ->references('id')
                ->on('item_mall_categories')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::connection('srocms')->dropIfExists('item_mall_item_groups');
    }
}

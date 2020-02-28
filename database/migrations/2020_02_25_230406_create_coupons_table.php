<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::connection('srocms')->create('coupons', function (Blueprint $table)
        {
            $table->bigIncrements('id');
            $table->string('code')->unique();
            $table->integer('user_id')->nullable();

            /*
            1 => Ürün
            2 => Kategori
            3 => Sepet
            4 => Ödeme Tipi
            */
            $table->tinyInteger('type')->default(1);

            /*
            1 => Miktar
            2 => Yüzde
            3 => Hediye Ürün
            */
            $table->tinyInteger('discount_type')->default(1);

            $table->boolean('limit_total_use')->default(false);
            $table->integer('total_use_limit')->default(1);

            $table->boolean('limit_user_use')->default(false);
            $table->integer('user_use_limit')->default(1);

            $table->integer('creater_id')->nullable();

            $table->boolean('enabled')->default(true);
            $table->timestamp('available_after')->nullable();
            $table->timestamp('expiry_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::connection('srocms')->dropIfExists('coupons');
    }
}

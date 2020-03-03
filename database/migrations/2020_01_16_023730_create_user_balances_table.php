<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserBalancesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::connection('srocms')->create('user_balances', function (Blueprint $table)
        {
            $table->bigIncrements('id');
            $table->bigInteger('user_id');
            $table->decimal('balance', 13, 2)->default(0);
            $table->decimal('balance_point', 13, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::connection('srocms')->dropIfExists('user_balances');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserBalanceLogsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::connection('srocms')->create('user_balance_logs', function (Blueprint $table)
        {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->decimal('balance_before', 13, 2);
            $table->decimal('balance_after', 13, 2);
            $table->tinyInteger('balance_type')->default(1);
            $table->tinyInteger('source')->default(0);
            $table->unsignedBigInteger('source_user_id')->nullable();
            $table->string('comment')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::connection('srocms')->dropIfExists('user_balance_logs');
    }
}

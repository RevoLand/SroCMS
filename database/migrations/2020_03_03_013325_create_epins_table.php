<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEpinsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::connection('srocms')->create('epins', function (Blueprint $table)
        {
            $table->bigIncrements('id');
            $table->string('code');
            $table->tinyInteger('type')->default(1);
            $table->decimal('balance')->default(0)->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('creater_user_id')->nullable();
            $table->boolean('used')->default(false);
            $table->boolean('enabled')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::connection('srocms')->dropIfExists('epins');
    }
}

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
            $table->id();
            $table->string('code')->unique();
            $table->tinyInteger('type')->default(1);
            $table->decimal('balance')->nullable();
            $table->bigInteger('user_id')->nullable();
            $table->foreignId('creater_user_id')->nullable();
            $table->boolean('enabled')->default(true);
            $table->timestamp('used_at')->nullable();
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

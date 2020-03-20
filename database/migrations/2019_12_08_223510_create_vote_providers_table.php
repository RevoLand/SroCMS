<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVoteProvidersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::connection('srocms')->create('vote_providers', function (Blueprint $table)
        {
            $table->id();
            $table->string('name');
            $table->string('url');
            $table->string('url_user_name')->default('id');
            $table->string('callback_secret');
            $table->string('callback_user_name');
            $table->string('callback_success_name');
            $table->integer('minutes_between_votes')->default(360);
            $table->boolean('enabled')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::connection('srocms')->dropIfExists('vote_providers');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVoteLogsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::connection('srocms')->create('vote_logs', function (Blueprint $table)
        {
            $table->bigIncrements('id');
            $table->bigInteger('user_id');
            $table->bigInteger('vote_provider_id');
            $table->bigInteger('selected_reward_group_id');
            $table->boolean('voted')->default(false);
            $table->timestamps();

            $table->foreign('vote_provider_id')->references('id')->on('vote_providers')->onDelete('cascade');
            $table->foreign('selected_reward_group_id')->references('id')->on('vote_provider_reward_groups')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::connection('srocms')->dropIfExists('vote_logs');
    }
}

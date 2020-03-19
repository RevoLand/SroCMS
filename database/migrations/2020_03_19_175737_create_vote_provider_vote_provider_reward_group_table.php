<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVoteProviderVoteProviderRewardGroupTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::connection('srocms')->create('vote_provider_vote_provider_reward_group', function (Blueprint $table)
        {
            $table->id();
            $table->bigInteger('vote_provider_id');
            $table->bigInteger('vote_provider_reward_group_id');
            $table->timestamps();

            $table->foreign('vote_provider_id')->references('id')->on('vote_providers')->onDelete('no action');
            $table->foreign('vote_provider_reward_group_id')->references('id')->on('vote_provider_reward_groups')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::connection('srocms')->dropIfExists('vote_provider_vote_provider_reward_group');
    }
}

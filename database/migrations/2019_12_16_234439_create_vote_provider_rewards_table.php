<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVoteProviderRewardsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::connection('srocms')->create('vote_provider_rewards', function (Blueprint $table)
        {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('vote_provider_reward_group_id');
            $table->tinyInteger('type')->default(3);
            $table->string('codename')->nullable();
            $table->integer('amount')->default(0);
            $table->decimal('balance', 13, 2)->default(0)->nullable();
            $table->tinyInteger('plus')->default(0);
            $table->boolean('enabled')->default(true);
            $table->timestamps();

            $table->foreign('vote_provider_reward_group_id')->references('id')->on('vote_provider_reward_groups')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::connection('srocms')->dropIfExists('vote_provider_rewards');
    }
}

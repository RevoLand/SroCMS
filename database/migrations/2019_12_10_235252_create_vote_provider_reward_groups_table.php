<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVoteProviderRewardGroupsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::connection('srocms')->create('vote_provider_reward_groups', function (Blueprint $table)
        {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('vote_provider_id');
            $table->string('name')->nullable();
            $table->boolean('enabled')->default(true);
            $table->timestamps();

            $table->foreign('vote_provider_id')->references('id')->on('vote_providers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::connection('srocms')->dropIfExists('vote_provider_reward_groups');
    }
}

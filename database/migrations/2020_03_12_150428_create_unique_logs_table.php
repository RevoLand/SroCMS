<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUniqueLogsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::connection('account')->create('unique_logs', function (Blueprint $table)
        {
            $table->id();
            $table->string('uniquecodename');
            $table->integer('CharacterID');
            $table->string('CharacterName');
            $table->integer('UserJID');
            $table->smallInteger('RegionId');
            $table->double('PosX');
            $table->double('PosY');
            $table->double('PosZ');
            $table->smallInteger('WorldID');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::connection('account')->dropIfExists('unique_logs');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketBansTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::connection('srocms')->create('ticket_bans', function (Blueprint $table)
        {
            $table->id();
            $table->integer('user_id');
            $table->integer('assigner_user_id');
            $table->string('reason', 500)->nullable();
            $table->timestamp('ban_start');
            $table->timestamp('ban_end');
            $table->timestamp('ban_cancelled_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::connection('srocms')->dropIfExists('ticket_bans');
    }
}

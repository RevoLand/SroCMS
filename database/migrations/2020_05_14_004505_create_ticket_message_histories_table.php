<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketMessageHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::connection('srocms')->create('ticket_message_histories', function (Blueprint $table)
        {
            $table->id();
            $table->foreignId('ticket_message_id');
            $table->integer('user_id');
            $table->string('old_content', 2000);
            $table->string('new_content', 2000);
            $table->timestamps();

            $table->foreign('ticket_message_id')->references('id')->on('ticket_messages')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::connection('srocms')->dropIfExists('ticket_message_histories');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketMessageAttachmentsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::connection('srocms')->create('ticket_message_attachments', function (Blueprint $table)
        {
            $table->id();
            $table->foreignId('ticket_message_id');
            $table->string('name');
            $table->timestamps();

            $table->foreign('ticket_message_id')->references('id')->on('ticket_messages')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::connection('srocms')->dropIfExists('ticket_message_attachments');
    }
}

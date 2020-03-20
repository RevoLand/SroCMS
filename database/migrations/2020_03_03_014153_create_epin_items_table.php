<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEpinItemsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::connection('srocms')->create('epin_items', function (Blueprint $table)
        {
            $table->id();
            $table->foreignId('epin_id');
            $table->string('codename');
            $table->integer('amount')->default(1);
            $table->integer('plus')->default(0);
            $table->timestamps();

            $table->foreign('epin_id')->references('id')->on('epins')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::connection('srocms')->dropIfExists('epin_items');
    }
}

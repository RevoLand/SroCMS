<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOnlineColumnToCharTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::connection('shard')->table('_Char', function (Blueprint $table)
        {
            $table->boolean('Online')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::connection('shard')->table('_Char', function (Blueprint $table)
        {
            $table->dropColumn('Online');
        });
    }
}

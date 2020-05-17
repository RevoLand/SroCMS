<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddJobsuitColumnToCharTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::connection('shard')->table('_Char', function (Blueprint $table)
        {
            $table->boolean('JobSuit')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::connection('shard')->table('_Char', function (Blueprint $table)
        {
            $table->dropColumn('JobSuit');
        });
    }
}

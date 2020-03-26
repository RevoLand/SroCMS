<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdColumnToReftelelinkTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::connection('shard')->table('_RefTeleLink', function (Blueprint $table)
        {
            $table->id('ID');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::connection('shard')->table('_RefTeleLink', function (Blueprint $table)
        {
            $table->dropColumn('ID');
        });
    }
}

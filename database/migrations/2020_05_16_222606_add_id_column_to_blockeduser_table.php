<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdColumnToBlockeduserTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::connection('account')->table('_BlockedUser', function (Blueprint $table)
        {
            $table->dropPrimary(['UserJID', 'Type']);
        });
        Schema::connection('account')->table('_BlockedUser', function (Blueprint $table)
        {
            $table->id();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::connection('account')->table('_BlockedUser', function (Blueprint $table)
        {
            // not works..ffs
            // $table->dropPrimary();
            // $table->dropColumn('id');
        });
        Schema::connection('account')->table('_BlockedUser', function (Blueprint $table)
        {
            // $table->primary(['UserJID', 'Type']);
        });
    }
}

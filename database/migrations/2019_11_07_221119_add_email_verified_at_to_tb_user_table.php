<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEmailVerifiedAtToTbUserTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::connection('account')->table('TB_User', function (Blueprint $table)
        {
            $table->timestamp('email_verified_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::connection('account')->table('TB_User', function (Blueprint $table)
        {
            $table->dropColumn('email_verified_at');
        });
    }
}

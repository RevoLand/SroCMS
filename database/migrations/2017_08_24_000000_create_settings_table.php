<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Set up the options.
     */
    public function __construct()
    {
        $this->table = config('setting.database.table');
        $this->key = config('setting.database.key');
        $this->value = config('setting.database.value');
    }

    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::connection('srocms')->create($this->table, function (Blueprint $table)
        {
            $table->id();
            $table->string($this->key)->index();
            $table->text($this->value);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::connection('srocms')->drop($this->table);
    }
}

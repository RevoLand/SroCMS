<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::connection('srocms')->create('articles', function (Blueprint $table)
        {
            $table->id();
            $table->string('slug');
            $table->string('title');
            $table->string('excerpt')->nullable();
            $table->text('content');
            $table->foreignId('author_id');
            $table->boolean('is_visible')->default(true);
            $table->boolean('can_comment_on')->default(true);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::connection('srocms')->dropIfExists('articles');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('srocms')->create('articles_comments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('article_id');
            $table->integer('user_id');
            $table->integer('parent_id')->nullable();
            $table->string('content', 500);
            $table->boolean('is_visible')->default(true);
            $table->boolean('is_approved')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('srocms')->dropIfExists('articles_comments');
    }
}

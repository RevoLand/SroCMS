<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticleCommentsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::connection('srocms')->create('article_comments', function (Blueprint $table)
        {
            $table->bigIncrements('id');
            $table->bigInteger('article_id');
            $table->integer('user_id');
            $table->integer('parent_id')->nullable();
            $table->string('content', 500);
            $table->boolean('is_visible')->default(true);
            $table->boolean('is_approved')->default(true);
            $table->timestamps();

            $table->foreign('article_id')
                ->references('id')->on('articles')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::connection('srocms')->dropIfExists('article_comments');
    }
}

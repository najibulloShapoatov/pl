<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateForumAnswerLikesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forum_answer_likes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('forum_answer_id');
            $table->integer('user_id');
            $table->timestamps();

            $table->foreign('forum_answer_id')->references('id')->on('forum_answers');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('forum_answer_likes');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommunityPostLikesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('community_post_likes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('community_post_id');
            $table->integer('user_id');
            $table->tinyInteger('sts'); //0-dislike  1-like
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
        Schema::dropIfExists('community_post_likes');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommunityPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('community_posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('community_id');
            $table->text('text')->nullable();
            $table->string('image')->nullable();
            $table->string('video')->nullable();

            $table->timestamps();

            $table->foreign('community_id')->references('id')->on('communities');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('community_posts');
    }
}

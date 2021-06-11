<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVideoCourseGalleriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('video_course_galleries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('video_course_id');
            $table->string('title');
            $table->string('image')->nullable();
            $table->string('video');
            $table->string('duration_video')->nullable();

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
        Schema::dropIfExists('video_course_galleries');
    }
}

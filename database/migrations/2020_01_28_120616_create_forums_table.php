<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateForumsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('forums', function (Blueprint $table) {
                    $table->bigIncrements('id');
                    $table->integer('user_id')->unsigned();
                    $table->integer('category_id')->unsigned();
                    $table->integer('f_like')->unsigned()->default(0);
                    $table->string('title');
                    $table->text('text');
                    $table->integer('viewed')->default(0);
                    $table->tinyInteger('is_active')->default(0);
                    $table->timestamps();

                    $table->foreign('category_id')->references('id')->on('forum_categories');
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
        Schema::dropIfExists('forums');
    }
}

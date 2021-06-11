<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePoolResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pool_results', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('pool_answer_id');
            $table->string('ip_cookie');
            $table->timestamps();
            $table->foreign('pool_answer_id')->references('id')->on('pool_answers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pool_results');
    }
}

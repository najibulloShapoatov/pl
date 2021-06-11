<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFedbackTosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fedback_tos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('facult_id');
            $table->string('place');
            $table->string('name');
            $table->string('email');
            $table->timestamps();

            $table->foreign('facult_id')->references('id')->on('faculties');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fedback_tos');
    }
}

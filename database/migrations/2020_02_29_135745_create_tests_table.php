<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            $table->integer('facult_id');
            $table->integer('cafedra_id');
            $table->string('lang');
            $table->string('subject');
            $table->tinyInteger('has_example')->default(0);
            $table->string('file')->nullable();
            $table->integer('test_timer')->nullable();
            $table->integer('check_point')->nullable();
            $table->tinyInteger('is_active')->default(0);
            $table->timestamps();

/*            $table->foreign('facult_id')->references('id')->on('faculties');
            $table->foreign('course_id')->references('id')->on('courses');
            $table->foreign('subject_id')->references('id')->on('subjects');*/
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
        Schema::dropIfExists('tests');
    }
}

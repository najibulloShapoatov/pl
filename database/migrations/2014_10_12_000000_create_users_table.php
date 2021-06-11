<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*Schema::create('roles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('role');
            $table->timestamps();

        });*/
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->integer('role_id')->default(5);
            $table->string('email')->unique();
            $table->string('password');
            $table->string('confirm_password');
            $table->tinyInteger('is_active')->default(1);
            $table->string('image')->nullable();
            $table->integer('facult_id')->nullable()->unsigned();
            $table->integer('special_id')->nullable()->unsigned();
            $table->integer('course_id')->nullable()->unsigned();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('facult_id')->references('id')->on('faculties');
            $table->foreign('special_id')->references('id')->on('specials');
            $table->foreign('course_id')->references('id')->on('courses');
            $table->foreign('role_id')->references('id')->on('roles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
        Schema::dropIfExists('users');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('type');
            $table->integer('type_id');
            $table->integer('parent_id');
            $table->integer('user_id');
            $table->text('text');
            $table->tinyInteger('is_active')->default(0);
            $table->timestamps();
        });
        Schema::create('rating', function (Blueprint $table) {
                    $table->bigIncrements('id');
                    $table->string('type');
                    $table->integer('type_id');
                    $table->integer('user_id');
                    $table->integer('point')->default(0);
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
        Schema::dropIfExists('comments');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
//            $table->integer('book_author_id');
            $table->string('image')->nullable();
            $table->text('description')->nullable();
            $table->integer('viewed')->default(0);
            $table->integer('read')->default(0);
            $table->integer('book_lang_id');
            $table->date('published_at');
            $table->integer('publish_year');
            $table->string('publishing_house')->nullable();
            $table->integer('book_license_id');
            $table->integer('book_category_id');
            $table->integer('pages');
            $table->integer('book_type_id');
            $table->string('isbn')->nullable();
            $table->timestamps();

//            $table->foreign('book_author_id')->references('id')->on('book_authors');
            $table->foreign('book_lang_id')->references('id')->on('book_langs');
            $table->foreign('book_license_id')->references('id')->on('book_licenses');
            $table->foreign('book_category_id')->references('id')->on('book_categories');
            $table->foreign('book_type_id')->references('id')->on('book_types');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('books');
    }
}

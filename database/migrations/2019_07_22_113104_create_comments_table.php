<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->bigInteger('parent_id')->unsigned()->nullable()->default(null);
            $table->bigInteger('article_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->text('body');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('article_id')->references('id')->on('articles');
            $table->foreign('parent_id')->references('id')->on('comments');
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

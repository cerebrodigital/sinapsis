<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function(Blueprint $table)
        {
          $table->increments('id');
          $table->integer('user_id')->unsigned()->default(0);
          $table->foreign('user_id')
              ->references('id')->on('users')
              ->onDelete('cascade');
          $table->string('title')->unique();
          $table->text('body');
          $table->text('featured_media');
          $table->integer('total_views');
          $table->string('slug')->unique();
          $table->enum('status', ['draft', 'publico', 'borrador', 'desactivado'])->default('draft');
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
        Schema::drop('posts');
    }
}

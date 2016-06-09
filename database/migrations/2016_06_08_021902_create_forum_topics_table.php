<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForumTopicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forum_topics', function(Blueprint $table) 
        {
            $table->increments('id');
            /* Attributes */
            $table->integer('parent_category')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')
                  ->references('id')->on('users')->onDelete('cascade');
            $table->string('title');
            $table->text('message');
            $table->string('tags');
            $table->string('status');
            $table->boolean('pinned')->nullable()->default(0);
            $table->boolean('locked')->nullable()->default(0);
            $table->string('slug');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('forum_topics');
    }
}

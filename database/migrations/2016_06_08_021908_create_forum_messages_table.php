<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForumMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forum_messages', function(Blueprint $table) 
        {
            $table->increments('id');
            
            /* Attributes */
            $table->integer('parent_topic')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')
                  ->references('id')->on('users')->onDelete('cascade');
            $table->integer('topic_id')->unsigned();
            $table->foreign('topic_id')
                    ->references('id')->on('forum_topics')->onDelete('cascade');
            $table->text('message');
            $table->boolean('correct_answer')->default(false);
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
        Schema::drop('forum_messages');
    }
}

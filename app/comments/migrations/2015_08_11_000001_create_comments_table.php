<?php



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
            $table->increments('id');
            $table->string('page_id')->index();
            $table->integer('user_id')->unsigned()->nullable();
            $table->string('author_name', 100)->nullable();
            $table->string('author_email')->nullable();
            $table->string('author_url')->nullable();
            $table->string('author_ip');
            $table->text('content');
            $table->enum('status', ['pending', 'approved', 'spam', 'trash'])->default('approved');
            $table->string('permalink');
            $table->string('user_agent');
            $table->integer('upvotes')->default(0);
            $table->integer('downvotes')->default(0);
            $table->integer('root_id')->unsigned()->nullable();
            $table->integer('parent_id')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('root_id')->references('id')->on('comments')->onDelete('cascade');
            $table->foreign('parent_id')->references('id')->on('comments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('comments');
    }
}

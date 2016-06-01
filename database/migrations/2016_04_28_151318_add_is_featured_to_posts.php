<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsFeaturedToPosts extends Migration
{
    /**
     * Run the migrations.
     * Esto no se grabo
     * @return void
     */
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->boolean('is_featured')->default(false);
            $table->enum('type', ['image', 'URLimage', 'video', 'audio'])->default('image');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('is_featured');
            $table->dropColumn('type');
        });
    }
}

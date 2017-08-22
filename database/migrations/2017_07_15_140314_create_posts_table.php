<?php

use Illuminate\Support\Facades\Schema;
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
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('author_id');
    
            $table->string('title');
            $table->string('short_title');
            $table->text('text');
    
            $table->unsignedInteger('likes');
            $table->unsignedInteger('comments');
            $table->unsignedInteger('views');
            $table->string('link');
    
            $table->string('date_time_string');
            $table->char('date_h', 11);
            $table->char('date_g', 11);
            $table->timestamp('published_at');
            $table->timestamps();
    
            $table->foreign('author_id')
                ->references('id')->on('authors')
                ->onDelete('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}

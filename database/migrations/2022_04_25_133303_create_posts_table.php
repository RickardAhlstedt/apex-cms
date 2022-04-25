<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->bigIncrements( 'id' );

            $table->string( 'title' );
            $table->string( 'slug' )->unique();

            $table->string( 'seo_title' )->nullable();
            $table->string( 'seo_description' )->nullable();
            $table->string( 'seo_keywords' )->nullable();

            $table->enum( 'status', [ 'draft', 'published' ] )->default( 'draft' );
            $table->bigInteger( 'author_id' )->unsigned();

            $table->integer( 'likes' )->default( 0 );

            $table->timestamps();

            $table->foreign( 'author_id' )->references( 'id' )->on( 'users' );
        } );

        Schema::create( 'blocks', function ( Blueprint $table ) {
            $table->bigIncrements( 'id' );

            $table->bigInteger( 'post_id' )->unsigned();

            $table->string( 'name' )->nullable();
            $table->longText( 'content' )->nullable();

            $table->enum( 'visibility', [ 'shown', 'hidden' ] )->default( 'shown' );
            $table->integer( 'order' )->default( 0 );

            $table->integer( 'likes' )->default( 0 );

            $table->timestamps();

            $table->foreign( 'post_id' )->references( 'id' )->on( 'posts' );
        } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blocks');
        Schema::dropIfExists('posts');
    }
}

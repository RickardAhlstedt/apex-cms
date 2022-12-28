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
        Schema::create( 'books', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger( 'user_id' );
            $table->string( 'name' );
            $table->text( 'description' );
            $table->timestamps();

            $table->foreign( 'user_id' )->references( 'id' )->on( 'users' )->onDelete( 'cascade' );
        } );

        Schema::create( 'contact_books', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger( 'contact_id' );
            $table->unsignedBigInteger( 'book_id' );
            $table->timestamps();

            $table->foreign( 'contact_id' )->references( 'id' )->on( 'contacts' );
            $table->foreign( 'book_id' )->references( 'id' )->on( 'books' )->onDelete( 'cascade' );
        } );

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists( 'contact_books' );
        Schema::dropIfExists( 'books' );
    }
}

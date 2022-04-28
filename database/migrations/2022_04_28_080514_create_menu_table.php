<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->bigIncrements( 'id' );
            $table->string( 'group' );
            $table->bigInteger( 'parent_id' )->unsigned()->nullable();
            $table->integer( 'sort' )->default( 0 );

            $table->string( 'name' );
            $table->string( 'class' )->nullable();
            $table->string( 'href' );
            $table->enum( 'behavior', [ '_self', '_blank', '_parent', '_top' ] )->default( '_self' );

            $table->string( 'prefix' )->nullable();
            $table->string( 'suffix' )->nullable();

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
        Schema::dropIfExists('menus');
    }
}

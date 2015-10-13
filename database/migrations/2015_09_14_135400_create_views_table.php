<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateViewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('views', function($table){
            $table->increments('view_id');
            $table->integer('guestUser_id')->unsigned();
            $table->integer('episode_id')->unsigned();
            $table->integer('numberOfViews')->unsigned();
            $table->timestamps();
            $table->foreign('episode_id')->references('episode_id')->on('episodes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('views');
    }
}

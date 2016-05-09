<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEpisodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('episodes', function($table){
            $table->increments('id');
            $table->string('episode_name');
            $table->integer('channel_id')->unsigned();
            $table->integer('view_count');
            $table->integer('status')->nullable();
            $table->string('image');
            $table->string('audio_mp3');
            $table->timestamps();

            $table->foreign('channel_id')
            ->references('id')
            ->on('channels')
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
        Schema::drop('episodes');
    }
}

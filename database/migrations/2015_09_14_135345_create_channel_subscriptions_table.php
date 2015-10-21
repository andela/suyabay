<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChannelSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('channel_subscriptions', function($table){
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('channel_id')->usigned();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
<<<<<<< HEAD
            $table->foreign('channel_id')->references('id')->on('channels')->onDelete('cascade');
=======
            $table->foreign('channel_id')->references('channel_id')->on('channels')->onDelete('cascade');
>>>>>>> initial commit for user registrationand authentication
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('channel_subscriptions');
    }
}

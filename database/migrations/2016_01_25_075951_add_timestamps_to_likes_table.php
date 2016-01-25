<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTimestampsToLikesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('likes', function (Blueprint $table) {
            if(!Schema::hasColumn('created_at', 'updated_at')) {
                $table->date('created_at')->default(date('Y-m-d G:i:s'));
                $table->date('updated_at')->default(date('Y-m-d G:i:s'));
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('likes', function (Blueprint $table) {
             if(Schema::hasColumn('created_at', 'updated_at')) {
                $table->dropColumn(['created_at', 'updated_at']);
            }
        });
    }
}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTimestampsToRoleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('roles', function (Blueprint $table) {
            $table->date('created_at')->default(date('Y-m-d H:i:s'));
            $table->date('updated_at')->default(date('Y-m-d H:i:s'));
            // $table->timestamp('created_at')->nullable();
            // $table->timestamp('updated_at')->nullable();
        });

        // Insert some stuff
        DB::table('roles')->insert([
            'id' => 1,
            'name' => 'Regular User',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('roles')->insert([
            'id' => 2,
            'name' => 'Premium User',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        DB::table('roles')->insert([
            'id' => 3,
            'name' => 'Super Admin',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('roles', function (Blueprint $table) {
            $table->dropColumn('created_at');
            $table->dropColumn('updated_at');
        });
    }
}
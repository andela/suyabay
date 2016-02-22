<?php

use Illuminate\Database\Seeder;

class EpisodeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Suyabay\User::class, 1)->create();
        factory(Suyabay\Channel::class, 1)->create();
        factory(Suyabay\Episode::class, 10)->create();
        factory(Suyabay\Comment::class, 0)->create();
    }
}

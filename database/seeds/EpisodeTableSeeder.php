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
        factory(Suyabay\Channel::class, 0)->create();
        factory(Suyabay\Episode::class, 5)->create();
        factory(Suyabay\Comment::class, 0)->create();
    }
}

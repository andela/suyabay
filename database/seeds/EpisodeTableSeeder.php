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
<<<<<<< HEAD
        factory(Suyabay\Channel::class, 10)->create();
=======
        factory(Suyabay\Channel::class, 1)->create();
>>>>>>> e0dea50cae38730e847ba7b19dcc0e6b1162d330
        factory(Suyabay\Episode::class, 10)->create();
        factory(Suyabay\Comment::class, 0)->create();
    }
}

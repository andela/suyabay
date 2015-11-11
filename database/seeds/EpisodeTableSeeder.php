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
        factory(Suyabay\Channel::class, 20)->create();
        factory(Suyabay\Episode::class, 20)->create();
    }
}

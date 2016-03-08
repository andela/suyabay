<?php

use Suyabay\Http\Repository\EpisodeRepository;

class TestCase extends \Illuminate\Foundation\Testing\TestCase
{
    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost';

    /**
     * Object of class EpisodeRepository
     *
     * @var Object
     */
    protected static $episodeRepository;

    public function setUp()
    {
        parent::setUp();
        $this->prepareTestDB();

        self::$episodeRepository = new EpisodeRepository();
    }

    public function tearDown()
    {
        $file = @fopen(storage_path("database.sqlite"), "r+");
        if ($file !== false) {
            ftruncate($file, 0);
            fclose($file);
        }
    }

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

        return $app;
    }

    public static function createNewEpisode()
    {
        return self::$episodeRepository->createEpisode([
            'episode_name' => 'Swanky new Episode',
            'episode_description' => 'Swanky New episode description',
            'view_count'            => 10,
            'image'                 => "http://goo.gl/8sorZR",
            'audio_mp3'             => "http://goo.gl/LkNP5M",
            'channel_id'            => 1,
            'status'                => 0,
            'likes'                 => 10
        ]);
    }

    /**
     * Prepare test database
     */
    public function prepareTestDB()
    {
        Config::set('database.default', 'sqlite');
        Artisan::call('migrate');
    }
}

<?php

namespace Suyabay\Providers;

use Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
    * Bootstrap any application services.
    *
    * @return void
    */
    public function boot()
    {
        Validator::extend('size_format', function ($attribute, $value, $parameters, $validator) {
            $bytes = filesize($value);
            $fileSize = $this->formatSizeUnits($bytes);
            return ($fileSize >= 1.00 && $fileSize <= 6.00);
        });
    }

        //return real size
    public function formatSizeUnits($bytes)
    {
        if ($bytes >= 1073741824) {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        } elseif ($bytes > 1) {
            $bytes = $bytes . ' bytes';
        } elseif ($bytes == 1) {
            $bytes = $bytes . ' byte';
        } else {
            $bytes = '0 bytes';
        }

        return $bytes;
}

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}

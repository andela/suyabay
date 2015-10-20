## Suyabay Podcast

[![Build Status](https://travis-ci.org/andela/suyabay.svg)](https://travis-ci.org/andela/suyabay)
[![License](https://poser.pugx.org/andela/suyabay/license.svg)](LICENSE.md)

Suyabay Podcast is an open source project using the full features of `laravel`. The main purpose of this project is to help Suya lovers find new podcasts and contents.

## Installation
1. Clone the repository into your project folder
2. Run composer install from `cmd ` to install all project dependencies
3. Run ```php artisan migrate``` to install the database migration

##Setup the environmental variables (.env file)

        APP_ENV    =local
        APP_DEBUG  =true
        APP_KEY    =LhsswvmAfygWZdKUhZXedm3bOTAOKLxH

        ### Database configuration
        DB_HOST    =localhost
        DB_DATABASE=
        DB_USERNAME=
        DB_PASSWORD=

        ### Test database configuration
        DB_TEST_HOST   =localhost
        DB_TEST_DATABASE=
        DB_TEST_USERNAME=
        DB_TEST_PASSWORD=

        CACHE_DRIVER=file
        SESSION_DRIVER=file
        QUEUE_DRIVER=sync

        ### Email configuration
        MAIL_DRIVER=smtp
        MAIL_HOST=
        MAIL_PORT=587
        MAIL_USERNAME=
        MAIL_PASSWORD=
        MAIL_ENCRYPTION=
        SENDER_ADDRESS=
        SENDER_NAME=

## Requirements

        php                   >=  5.5.9
        laravel/framework      =  5.1.17
        busayo/laravel-yearly  =  1.0.*
        guzzlehttp/guzzle      =  ~4.0

## Requirement for Development

        fzaninotto/faker = ~1.4
        phpunit/phpunit  = ~4.0
        phpspec/phpspec  = ~2.1
        mockery/mockery  = ^0.9.4

## Official Documentation

Documentation for Suyabay website can be found on the [Suyabay Wiki](https://github.com/andela/suyabay/wiki).

## Contributing

Thank you for considering contributing to the Suyabay project! The contribution guide can be found in the [Suyabay documentation](https://github.com/andela/suyabay/wiki/contributions).


### License

The SuyaBay project is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)

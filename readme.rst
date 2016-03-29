Suyabay Podcast
---------------

| |Build Status|
| |Coverage Status|

`SuyaBay`_ is a podcasting app built for suya lovers. Users can use the
app either as a **guest** or a **registered user**. Being a registered
user means a user has access to features such as **social integration
features** (liking and sharing favorite episodes), which is not
available to a guest user. A guest user can only have access to general
episodes if available. Documentation for Suyabay website can be found on
the `Suyabay Wiki`_.

Installation
------------

#. Clone the repository into your project folder
   ``git clone https://github.com/andela/suyabay.git``
#. Run ``composer install`` from cmd to install all project dependencies
#. Update the values in ``.env`` file
#. Run ``php artisan migrate`` to install the database migration

Install Composer
----------------

Download the installer from `getcomposer.org/download`_, execute it and
follow the instructions

Setup the environmental variables (.env file)
---------------------------------------------

::

        APP_ENV    =local
        APP_DEBUG  =true
        APP_KEY    =LhsswvmAfygWZdKUhZXedm3bOTAOKLxH

        ### Database configuration
        DB_HOST    =localhost
        DB_DATABASE=xxxxxxxx
        DB_USERNAME=xxxxxxxx
        DB_PASSWORD=xxxxxxxx

        ### Test database configuration
        DB_TEST_HOST   =localhost
        DB_TEST_DATABASE=xxxxxxxx
        DB_TEST_USERNAME=xxxxxxxx
        DB_TEST_PASSWORD=xxxxxxxx

        CACHE_DRIVER=file
        SESSION_DRIVER=file
        QUEUE_DRIVER=sync

        ### Email configuration
        MAIL_DRIVER=smtp
        MAIL_HOST=xxxxxxxx
        MAIL_PORT=xxx
        MAIL_USERNAME=xxxxxxxx
        MAIL_PASSWORD=xxxxxxxx
        MAIL_ENCRYPTION=xxxxxxxx
        SENDER_ADDRESS=xxxxxxxx
        SENDER_NAME=xxxxxxxx

Requirements
------------

::

        php                   >=  5.5.9
        laravel/framework      =  5.1.17
        busayo/laravel-yearly  =  1.0.*
        guzzlehttp/guzzle      =  ~4.0

Requirements for Development
----------------------------

::

        fzaninotto/faker       = ~1.4
        phpunit/phpunit        = ~4.0
        phpspec/phpspec        = ~2.1
        mockery/mockery        = ^0.9.4
        satooshi/php-coveralls = ^0.7.1

Credits
-------

`Okosun Florence`_

`Osuagwu Emeka`_

`Adeniyi Ibraheem`_

`Chris Vundi`_

`John Kariuki`_

`Temitope Olotin`_

`Ademola Raimi`_

SuyaBay Podcast App
-------------------

Welcome to the SuyaBay Podcast repository on GitHub. Here you can browse
the source, look at open issues and keep track of de

.. _SuyaBay: https://www.suyabay.com
.. _Suyabay Wiki: https://github.com/andela/suyabay/wiki
.. _getcomposer.org/download: https://getcomposer.org/doc/00-intro.md
.. _Okosun Florence: https://github.com/andela-fokosun
.. _Osuagwu Emeka: https://github.com/andela-eosuagwu
.. _Adeniyi Ibraheem: https://github.com/andela-iadeniyi
.. _Chris Vundi: https://github.com/andela-cvundi
.. _John Kariuki: https://github.com/andela-jkariuki
.. _Temitope Olotin: https://github.com/andela-tolotin
.. _Ademola Raimi: https://github.com/andela-araimi

.. |Build Status| image:: https://travis-ci.org/andela/suyabay.svg
   :target: https://travis-ci.org/andela/suyabay
.. |Coverage Status| image:: https://coveralls.io/repos/github/andela/suyabay/badge.svg?branch=staging
   :target: https://coveralls.io/github/andela/suyabay?branch=staging
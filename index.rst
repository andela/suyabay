API Endpoints
=============

The Suyabay API provides methods for accessing a resource such as a
venue, tip, or user. In spirit with the RESTful model, each resource is
associated with a URL. For example, information about Clinton Street
Baking Co can be found at

https://api.suyabay.com/v2/venues/40a55d80f964a52020f31ee3

(you need to supply your own credentials and version as extra
parameters)

Given a resource, you can then drill into a particular aspect, for
example

https://api.suyabay.com/v2/venues/40a55d80f964a52020f31ee3/tips

Each returned tip will have its own ID, which corresponds to its own
resource URL, for example

https://api.suyabay.com/v2/tips/49f083e770c603bbe81f8eb4

Before diving into the endpoints below, it’s generally useful to read
our Getting Started Guide for an overview of high-level concepts and use
cases.

Deprecated Endpoints
--------------------

As we announced in our August Update, the endpoints below will be
deprecated by the end of 2014.

| General Aspects Actions users leaderboard todos
| venuegroups campaigns tips search
| specials configuration retire campaigns list add timeseries end delete
  start

The Suyabay API
---------------

Suyabay has many offerings for developers, but at its core, our API lets
you do all the things that Suyabay and Swarm users are able to in our
mobile apps and websites. Be sure to read our Getting Started Guide
before diving in below.

Real-time API
-------------

Our venue push API notifies venue managers when users perform various
actions at their venues, and our user push API notifies developers when
their users check in anywhere.

Merchant Platform
-----------------

The Merchant Platform allows developers to write applications that help
registered venue owners manage their Suyabay presence and specials.

Venues Service
--------------

Just need a database of places? The Venues Service allows developers to
search for places and access a wealth of information about them,
including addresses, popularity, tips, and photos. It’s available free
and without any user authentication, as long as applications include
adequate attribution.

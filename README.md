# api-client

Simple connection to the xml.world API

## Instalation

You can add this library as a local, per-project dependency to your project using [Composer](https://getcomposer.org/):

    composer require xml-world/api-client

## Description

This library provides a quick way to integrate your booking system with the XML.world API.

You will be able to search for hotel accommodation scoped by several criteria, to book rooms, to check bookings, to 
update the reference as a trade, and to cancel it if needed.

The API will return and exhaustive summary of your booking.

## Use

You first need to apply for trading credentials from XML World.

Once you have them you can start the API like this:

```php
$xmlClient = new XMLClient(login: 'login', password: 'password');
```

The XMLClient exposes object exposes 5 methods from the API at XML.world

## Examples

you can find examples of use in the folder examples

<?php

namespace XMLWorld\ApiClient\Test\Common;

use XMLWorld\ApiClient\Common\Guest;
use XMLWorld\ApiClient\Common\Guests;

trait GuestsTrait
{
    protected function getGuest1() : array
    {
        $instance = new Guest(
            'Adult',
            'Sally',
            'Smith',
            'Mrs',
            null,
            'French'
        );

		$serialize = <<<'XML'
<Guest>
	<Type>Adult</Type>
	<FirstName>Sally</FirstName>
	<LastName>Smith</LastName>
	<Title>Mrs</Title>
	<Nationality>French</Nationality>
</Guest>
XML;

		$unserialize = <<<'XML'
<Guest>
	<Type>Adult</Type>
	<FirstName>Sally</FirstName>
	<LastName>Smith</LastName>
	<Title>Mrs</Title>
	<Nationality>French</Nationality>
</Guest>
XML;

		return [
			$instance,
			$serialize,
			$unserialize
		];
    }

	protected function getGuest2() : array
    {
        $instance = new Guest(
            'Child',
            'Jimmy',
            'Smith',
            null,
            5,
            'French'
        );

        $serialize = <<<'XML'
<Guest>
	<Type>Child</Type>
	<FirstName>Jimmy</FirstName>
	<LastName>Smith</LastName>
	<Age>5</Age>
	<Nationality>French</Nationality>
</Guest>
XML;

        $unserialize = <<<'XML'
<Guest>
	<Type>Child</Type>
	<FirstName>Jimmy</FirstName>
	<LastName>Smith</LastName>
	<Age>5</Age>
	<Nationality>French</Nationality>
</Guest>
XML;

		return [
			$instance,
			$serialize,
			$unserialize
		];
    }

	protected function getOneGuests(array $guest) : array
    {
		list($instance, $serialize, $unserialize) = $guest;

		$instance = new Guests($instance);

        $serialize = <<<XML
<Guests>
	$serialize
</Guests>
XML;


        $unserialize = <<<XML
<Guests>
	$unserialize
</Guests>
XML;

		return [
			$instance,
			$serialize,
			$unserialize
		];
    }

	protected function getTwoGuests(array $guest1, array $guest2) : array
    {
		list($guest1Instance, $guest1Serialize, $guest1Unserialize) = $guest1;
		list($guest2Instance, $guest2Serialize, $guest2Unserialize) = $guest2;

        $instance = new Guests(
			$guest1Instance,
			$guest2Instance
        );

        $serialize = <<<XML
<Guests>
	$guest1Serialize
	$guest2Serialize
</Guests>
XML;

        $unserialize = <<<XML
<Guests>
	$guest1Unserialize
	$guest2Unserialize
</Guests>
XML;

		return [
			$instance,
			$serialize,
			$unserialize
		];
    }
}
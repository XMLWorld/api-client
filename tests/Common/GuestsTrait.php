<?php

namespace XMLWorld\ApiClient\Test\Common;

use XMLWorld\ApiClient\Common\Guest;
use XMLWorld\ApiClient\Common\Guests;

trait GuestsTrait
{
    protected function getAdultGuest()
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

	protected function getChildGuest()
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

	protected function getOneGuests()
    {
		list($instance, $serialize, $unserialize) = $this->getAdultGuest();

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

	protected function getTwoGuests()
    {
		list($adultGuestBookInstance, $adultGuestBookSerialize, $adultGuestBookUnserialize) = $this->getAdultGuest();
		list($childGuestBookInstance, $childGuestBookSerialize, $childGuestBookUnserialize) = $this->getChildGuest();

        $instance = new Guests(
			$adultGuestBookInstance,
			$childGuestBookInstance
        );

        $serialize = <<<XML
<Guests>
	$adultGuestBookSerialize
	$childGuestBookSerialize
</Guests>
XML;

        $unserialize = <<<XML
<Guests>
	$adultGuestBookUnserialize
	$childGuestBookUnserialize
</Guests>
XML;

		return [
			$instance,
			$serialize,
			$unserialize
		];
    }
}
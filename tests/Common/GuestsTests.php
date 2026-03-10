<?php

namespace XMLWorld\ApiClient\Test\Common;

use PHPUnit\Framework\Attributes\Depends;
use PHPUnit\Framework\Attributes\Test;
use XMLWorld\ApiClient\Test\BaseSerializeXML;

class GuestsTests extends BaseSerializeXML
{
	use GuestsTrait;

	#[Test]
    public function guest1() : array
    {
		list($instance, , ) = $details = $this->getGuest1();

		/** @todo do assertions */

		$this->doTest(...$details);

		return $details;
    }

	#[Test]
    public function guest2() : array
    {
		list($instance, , ) = $details = $this->getGuest2();

		/** @todo do assertions */

		$this->doTest(...$details);

		return $details;
    }

	#[Test]
	#[Depends('guest1')]
    public function oneGuests(array $guest) : array
    {
		list($guestInstance, , ) = $guest;
		list($instance, , ) = $details = $this->getOneGuests($guest);

		/** @todo do assertions */

		$this->doTest(...$details);

		return $details;
    }

	#[Test]
	#[Depends('guest1')]
	#[Depends('guest2')]
    public function twoGuests(array $guest1, array $guest2) : array
    {
		list($guest1Instance, , ) = $guest1;
		list($guest2Instance, , ) = $guest2;
		list($instance, , ) = $details = $this->getTwoGuests($guest1, $guest2);

		/** @todo do assertions */

		$this->doTest(...$details);

		return $details;
    }
}
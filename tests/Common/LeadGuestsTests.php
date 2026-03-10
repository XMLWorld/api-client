<?php

namespace XMLWorld\ApiClient\Test\Common;

use PHPUnit\Framework\Attributes\Test;
use XMLWorld\ApiClient\Test\BaseSerializeXML;

class LeadGuestsTests extends BaseSerializeXML
{
	use LeadGuestsTrait;

	#[Test]
    public function simpleLeadGuest() : array
    {
		list($instance, , ) = $details = $this->getSimpleLeadGuest();

		$this->assertSame('Jim', $instance->firstName);
		$this->assertSame('Watsworth', $instance->lastName);
		$this->assertSame('Mr', $instance->title);
		$this->assertNull($instance->address1);
		$this->assertNull($instance->address2);
		$this->assertNull($instance->townCity);
		$this->assertNull($instance->county);
		$this->assertNull($instance->postcode);
		$this->assertNull($instance->phone);
		$this->assertNull($instance->email);
		$this->assertNull($instance->request);

		$this->doTest(...$details);

		return $details;
    }

    #[Test]
    public function leadGuest() : array
    {
        list($instance, , ) = $details = $this->getLeadGuest();

        $this->assertSame('Jim', $instance->firstName);
        $this->assertSame('Watsworth', $instance->lastName);
        $this->assertSame('Mr', $instance->title);
        $this->assertSame('Address line 1', $instance->address1);
        $this->assertNull($instance->address2);
        $this->assertSame('London', $instance->townCity);
        $this->assertNull($instance->county);
        $this->assertNull($instance->postcode);
        $this->assertNull($instance->phone);
        $this->assertSame('email@example.com', $instance->email);
        $this->assertNull($instance->request);

        $this->doTest(...$details);

        return $details;
    }
}

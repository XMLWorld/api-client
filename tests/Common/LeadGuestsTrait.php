<?php

namespace XMLWorld\ApiClient\Test\Common;

use XMLWorld\ApiClient\Common\LeadGuest;

trait LeadGuestsTrait
{
    protected function getSimpleLeadGuest() : array
    {
        $instance = new LeadGuest(
            'Jim',
            'Watsworth',
            'Mr'
        );

        $serialize = <<<'XML'
<LeadGuest>
	<FirstName>Jim</FirstName>
	<LastName>Watsworth</LastName>
	<Title>Mr</Title>
</LeadGuest>
XML;

        $unserialize = <<<'XML'
<LeadGuest>
<LastName>Watsworth</LastName>
	<FirstName>Jim</FirstName>

	<Title>Mr</Title>
</LeadGuest>
XML;
		return [
			$instance,
			$serialize,
			$unserialize
		];
    }

    protected function getLeadGuest()
    {
        $instance = new LeadGuest(
            'Jim',
            'Watsworth',
            'Mr',
            'Address line 1',
            null,
            'London',
            null,
            null,
            null,
            'email@example.com'
        );

        $serialize = <<<'XML'
<LeadGuest>
	<FirstName>Jim</FirstName>
	<LastName>Watsworth</LastName>
	<Title>Mr</Title>
	<Address1>Address line 1</Address1>
	<TownCity>London</TownCity>
	<Email>email@example.com</Email>
</LeadGuest>
XML;

        $unserialize = <<<'XML'
<LeadGuest>
	<FirstName>Jim</FirstName>
	<LastName>Watsworth</LastName>
	<Address1>Address line 1</Address1>
	<TownCity>London</TownCity>
	<Email>email@example.com</Email>
	<Title>Mr</Title>
</LeadGuest>
XML;
        return [
            $instance,
            $serialize,
            $unserialize
        ];
    }
}

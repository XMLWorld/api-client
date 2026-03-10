<?php

namespace XMLWorld\ApiClient\Test\Common;

use XMLWorld\ApiClient\Common\LeadGuest;

trait LeadGuestsTrait
{
    protected function getLeadGuest() : array
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
}
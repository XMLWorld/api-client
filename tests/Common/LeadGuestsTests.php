<?php

namespace XMLWorld\ApiClient\Test\Common;

use XMLWorld\ApiClient\Common\LeadGuest;
use XMLWorld\ApiClient\Test\BaseSerializeXML;

class LeadGuestsTests extends BaseSerializeXML
{
    public function testAdultGuest()
    {
        $simpleLeadGuestBook = new LeadGuest(
            'Jim',
            'Watsworth',
            'Mr'
        );

        $this->serialize(
            '<LeadGuest>
				<FirstName>Jim</FirstName>
				<LastName>Watsworth</LastName>
				<Title>Mr</Title>
			</LeadGuest>',
            $simpleLeadGuestBook
        );

        $this->unserialize(
            '<LeadGuest>
				<FirstName>Jim</FirstName>
				<LastName>Watsworth</LastName>
				<Title>Mr</Title>
			</LeadGuest>',
            $simpleLeadGuestBook
        );

        return $simpleLeadGuestBook;
    }
}
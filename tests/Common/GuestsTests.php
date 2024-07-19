<?php

namespace XMLWorld\ApiClient\Test\Common;

use XMLWorld\ApiClient\Common\Guest;
use XMLWorld\ApiClient\Common\Guests;
use XMLWorld\ApiClient\Test\BaseSerializeXML;

class GuestsTests extends BaseSerializeXML
{
    public function testAdultGuest()
    {
        $adultGuestBook = new Guest(
            'Adult',
            'Sally',
            'Smith',
            'Mrs',
            null,
            'French'
        );

        $this->serialize(
            '<Guest>
				<Type>Adult</Type>
				<FirstName>Sally</FirstName>
				<LastName>Smith</LastName>
				<Title>Mrs</Title>
				<Nationality>French</Nationality>
			</Guest>',
            $adultGuestBook
        );

        $this->unserialize(
            '<Guest>
				<Type>Adult</Type>
				<FirstName>Sally</FirstName>
				<LastName>Smith</LastName>
				<Title>Mrs</Title>
				<Nationality>French</Nationality>
			</Guest>',
            $adultGuestBook
        );

        return $adultGuestBook;
    }

    public function testChildGuest()
    {
        $childGuestBook = new Guest(
            'Child',
            'Jimmy',
            'Smith',
            null,
            5,
            'French'
        );

        $this->serialize(
            '<Guest>
				<Type>Child</Type>
				<FirstName>Jimmy</FirstName>
				<LastName>Smith</LastName>
				<Age>5</Age>
				<Nationality>French</Nationality>
			</Guest>',
            $childGuestBook
        );

        $this->unserialize(
            '<Guest>
				<Type>Child</Type>
				<FirstName>Jimmy</FirstName>
				<LastName>Smith</LastName>
				<Age>5</Age>
				<Nationality>French</Nationality>
			</Guest>',
            $childGuestBook
        );

        return $childGuestBook;
    }


    /**
     * @depends testAdultGuest
     */
    public function testOneGuests($adultGuestBook)
    {
        $oneGuests = new Guests($adultGuestBook);

        $this->serialize(
            '<Guests>
				<Guest>
					<Type>Adult</Type>
					<FirstName>Sally</FirstName>
					<LastName>Smith</LastName>
					<Title>Mrs</Title>
					<Nationality>French</Nationality>
				</Guest>
			</Guests>',
            $oneGuests
        );

        $this->unserialize(
            '<Guests>
				<Guest>
					<Type>Adult</Type>
					<FirstName>Sally</FirstName>
					<LastName>Smith</LastName>
					<Title>Mrs</Title>
					<Nationality>French</Nationality>
				</Guest>
			</Guests>',
            $oneGuests
        );

        return $oneGuests;
    }

    /**
     * @depends testAdultGuest
     * @depends testChildGuest
     */
    public function testTwoGuests($adultGuestBook, $childGuestBook)
    {
        $twoGuests = new Guests(
            $adultGuestBook,
            $childGuestBook
        );

        $this->serialize(
            '<Guests>
				<Guest>
					<Type>Adult</Type>
					<FirstName>Sally</FirstName>
					<LastName>Smith</LastName>
					<Title>Mrs</Title>
					<Nationality>French</Nationality>
				</Guest>
				<Guest>
					<Type>Child</Type>
					<FirstName>Jimmy</FirstName>
					<LastName>Smith</LastName>
					<Age>5</Age>
					<Nationality>French</Nationality>
				</Guest>
			</Guests>',
            $twoGuests
        );

        $this->unserialize(
            '<Guests>
				<Guest>
					<Type>Adult</Type>
					<FirstName>Sally</FirstName>
					<LastName>Smith</LastName>
					<Title>Mrs</Title>
					<Nationality>French</Nationality>
				</Guest>
				<Guest>
					<Type>Child</Type>
					<FirstName>Jimmy</FirstName>
					<LastName>Smith</LastName>
					<Age>5</Age>
					<Nationality>French</Nationality>
				</Guest>
			</Guests>',
            $twoGuests
        );

        return $twoGuests;
    }

}
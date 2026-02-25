<?php

namespace XMLWorld\ApiClient\Test\Requests;

use PHPUnit\Framework\Attributes\Depends;
use XMLWorld\ApiClient\Requests\BookRequest;

class BookRequestTest extends BookDetailsTest
{
	#[Depends('testLoginDetails')]
	#[Depends('testTwoRoomBookingDetails')]
    public function testBookRequest($loginDetails, $twoRoomBookingDetails)
    {
		list($loginDetailsInstance, 			$loginDetailsSerialize, 			$loginDetailsUnserialize) 			= $loginDetails;
		list($twoRoomBookingDetailsInstance,	$twoRoomBookingDetailsSerialize,	$twoRoomBookingDetailsUnserialize)	= $twoRoomBookingDetails;

        $instance = new BookRequest(
			$loginDetailsInstance,
			$twoRoomBookingDetailsInstance,
            true
        );

		$serialize = <<<XML
<BookRequest>
	$loginDetailsSerialize
	<Mock>True</Mock>
	$twoRoomBookingDetailsSerialize
</BookRequest>
XML;

		$unserialize = <<<XML
<BookRequest>
	$loginDetailsUnserialize
	<Mock>True</Mock>
	$twoRoomBookingDetailsUnserialize
</BookRequest>
XML;

		$bookDetails = [
			$instance,
			$serialize,
			$unserialize
		];

		$this->doTest(...$bookDetails);

        return $bookDetails;
    }
}
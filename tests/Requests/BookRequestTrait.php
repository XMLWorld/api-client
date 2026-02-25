<?php

namespace XMLWorld\ApiClient\Test\Requests;

use PHPUnit\Framework\Attributes\Depends;
use XMLWorld\ApiClient\Requests\BookRequest;

trait BookRequestTrait
{
	use LoginDetailsTrait;
	use BookDetailsTrait;

    protected function getBookRequest()
    {
		list($loginDetailsInstance, 			$loginDetailsSerialize, 			$loginDetailsUnserialize) 			= $this->getLoginDetails();
		list($twoRoomBookingDetailsInstance,	$twoRoomBookingDetailsSerialize,	$twoRoomBookingDetailsUnserialize)	= $this->getTwoRoomBookingDetails();

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
	$loginDetailsUnserialize <Mock>True</Mock>
	$twoRoomBookingDetailsUnserialize
</BookRequest>
XML;

		return [
			$instance,
			$serialize,
			$unserialize
		];
    }
}
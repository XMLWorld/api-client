<?php

namespace XMLWorld\ApiClient\Test\Responses;

use XMLWorld\ApiClient\Responses\ReturnStatus;

trait ReturnStatusTrait
{
    public function testRequestStatusTrue()
    {
        $instance = new ReturnStatus(true);

        $expected = '<ReturnStatus>
				<Success>True</Success>
			</ReturnStatus>';

        $returnStatusTrue = [
            $instance,
            $expected,
            $expected
        ];

        $this->doTest(...$returnStatusTrue);

        return $returnStatusTrue;
    }

    public function testReturnBookingStatusFalse()
    {
        $instance = new ReturnStatus(
            false,
            'Supplier Reference not found for Booking Reference HCL0011 in SupplierBooking'
        );

        $expected = '<ReturnStatus>
				<Success>False</Success>
				<Exception>Supplier Reference not found for Booking Reference HCL0011 in SupplierBooking</Exception>
			</ReturnStatus>';

        $returnSerachStatusFalse = [
            $instance,
            $expected,
            $expected
        ];

        $this->doTest(...$returnSerachStatusFalse);

        return $returnSerachStatusFalse;
    }

    public function testReturnSerachStatusFalse()
    {
        $instance = new ReturnStatus(
            false,
            'Could not find any rooms for RoomRequest'
        );

        $expected = '<ReturnStatus>
				<Success>False</Success>
				<Exception>Could not find any rooms for RoomRequest</Exception>
			</ReturnStatus>';

        $returnSerachStatusFalse = [
            $instance,
            $expected,
            $expected
        ];

        $this->doTest(...$returnSerachStatusFalse);

        return $returnSerachStatusFalse;
    }
}
<?php

namespace XMLWorld\ApiClient\Test\Responses;

use XMLWorld\ApiClient\Requests\LoginDetails;
use XMLWorld\ApiClient\Responses\RequestInfo;
use XMLWorld\ApiClient\Responses\ReturnStatus;
use XMLWorld\ApiClient\Test\BaseSerializeXML;

class ResponseTest extends BaseSerializeXML
{
    public function testResponseInfo()
    {
        $requestInfo = new RequestInfo(
            1687253937,
            '2023-06-20T09:38:57+00:00',
            'xml.centriumres.com.localdomain.ee',
            '10.0.1.182',
            '649173b14aadb8.17864349'
        );

        $this->serialize(
            '<RequestInfo>
				<Timestamp>1687253937</Timestamp>
				<TimestampISO>2023-06-20T09:38:57+00:00</TimestampISO>
				<Host>xml.centriumres.com.localdomain.ee</Host>
				<HostIP>10.0.1.182</HostIP>
				<ReqID>649173b14aadb8.17864349</ReqID>
			</RequestInfo>',
            $requestInfo
        );

        $this->unserialize(
            '<RequestInfo>
				<Timestamp>1687253937</Timestamp>
				<Host>xml.centriumres.com.localdomain.ee</Host>
				<HostIP>10.0.1.182</HostIP>
				<ReqID>649173b14aadb8.17864349</ReqID>
				<TimestampISO>2023-06-20T09:38:57+00:00</TimestampISO>
			</RequestInfo>',
            $requestInfo
        );

        return $requestInfo;
    }

    public function testReturnStatusTrue()
    {
        $returnStatusTrue = new ReturnStatus(true);

        $this->serialize(
            '<ReturnStatus>
				<Success>True</Success>
			</ReturnStatus>',
            $returnStatusTrue
        );

        $this->unserialize(
            '<ReturnStatus>
				<Success>True</Success>
				<Exception/>
			</ReturnStatus>',
            $returnStatusTrue
        );

        return $returnStatusTrue;
    }

    public function testReturnStatusFalse()
    {
        $returnBookingStatusFalse = new ReturnStatus(
            false,
            'Supplier Reference not found for Booking Reference HCL0011 in SupplierBooking'
        );

        $this->serialize(
            '<ReturnStatus>
				<Success>False</Success>
				<Exception>Supplier Reference not found for Booking Reference HCL0011 in SupplierBooking</Exception>
			</ReturnStatus>',
            $returnBookingStatusFalse
        );

        $this->unserialize(
            '<ReturnStatus>
				<Success>False</Success>
				<Exception>Supplier Reference not found for Booking Reference HCL0011 in SupplierBooking</Exception>
			</ReturnStatus>',
            $returnBookingStatusFalse
        );

        return $returnBookingStatusFalse;
    }
}
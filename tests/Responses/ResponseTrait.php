<?php

namespace XMLWorld\ApiClient\Test\Responses;

use XMLWorld\ApiClient\Responses\RequestInfo;
use XMLWorld\ApiClient\Responses\ReturnStatus;

trait ResponseTrait
{
    protected function getResponseInfo()
    {
        $instance = new RequestInfo(
            1687253937,
            '2023-06-20T09:38:57+00:00',
            'xml.centriumres.com.localdomain.ee',
            '10.0.1.182',
            '649173b14aadb8.17864349'
        );

        $serialize = <<<'XML'
<RequestInfo>
	<Timestamp>1687253937</Timestamp>
	<TimestampISO>2023-06-20T09:38:57+00:00</TimestampISO>
	<Host>xml.centriumres.com.localdomain.ee</Host>
	<HostIP>10.0.1.182</HostIP>
	<ReqID>649173b14aadb8.17864349</ReqID>
</RequestInfo>
XML;
		$unserialize = <<<'XML'
<RequestInfo>
	<Timestamp>1687253937</Timestamp>
	<Host>xml.centriumres.com.localdomain.ee</Host>
	<HostIP>10.0.1.182</HostIP>
	<ReqID>649173b14aadb8.17864349</ReqID>
	<TimestampISO>2023-06-20T09:38:57+00:00</TimestampISO>
</RequestInfo>
XML;

        return [
			$instance,
			$serialize,
			$unserialize
		];
    }

    protected function getReturnStatusTrue()
    {
        $instance = new ReturnStatus(true);

        $serialize = <<<'XML'
<ReturnStatus>
	<Success>True</Success>
</ReturnStatus>
XML;

        $unserialize = <<<'XML'
<ReturnStatus>
	<Success>True</Success>
	<Exception/>
</ReturnStatus>
XML;

        return [
			$instance,
			$serialize,
			$unserialize
		];
    }

    protected function getReturnStatusFalse()
    {
        $instance = new ReturnStatus(
            false,
            'Supplier Reference not found for Booking Reference HCL0011 in SupplierBooking'
        );

        $serialize = <<<'XML'
<ReturnStatus>
	<Success>False</Success>
	<Exception>Supplier Reference not found for Booking Reference HCL0011 in SupplierBooking</Exception>
</ReturnStatus>
XML;

        $unserialize = <<<'XML'
<ReturnStatus>
	<Success>False</Success>
	<Exception>Supplier Reference not found for Booking Reference HCL0011 in SupplierBooking</Exception>
</ReturnStatus>
XML;
		return [
			$instance,
			$serialize,
			$unserialize
		];
    }
}
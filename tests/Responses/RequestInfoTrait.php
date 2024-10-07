<?php

namespace XMLWorld\ApiClient\Test\Responses;

use XMLWorld\ApiClient\Responses\RequestInfo;

trait RequestInfoTrait
{
    public function testRequestInfo()
    {
        $instance = new RequestInfo(
            1687253937,
            '2023-06-20T09:38:57+00:00',
            'xml.centriumres.com.localdomain.ee',
            '10.0.1.182',
            '649173b14aadb8.17864349'
        );

        $expected = '<RequestInfo>
				<Timestamp>1687253937</Timestamp>
				<TimestampISO>2023-06-20T09:38:57+00:00</TimestampISO>
				<Host>xml.centriumres.com.localdomain.ee</Host>
				<HostIP>10.0.1.182</HostIP>
				<ReqID>649173b14aadb8.17864349</ReqID>
			</RequestInfo>';

        $requestInfo = [
            $instance,
            $expected,
            $expected
        ];

        $this->doTest(...$requestInfo);

        return $requestInfo;
    }
}
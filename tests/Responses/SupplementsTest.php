<?php

namespace XMLWorld\ApiClient\Test\Responses;

use XMLWorld\ApiClient\Requests\LoginDetails;
use XMLWorld\ApiClient\Responses\RequestInfo;
use XMLWorld\ApiClient\Responses\ReturnStatus;
use XMLWorld\ApiClient\Responses\RoomsAppliesTo;
use XMLWorld\ApiClient\Responses\Supplement;
use XMLWorld\ApiClient\Responses\Supplements;
use XMLWorld\ApiClient\Test\BaseSerializeXML;

class SupplementsTest extends BaseSerializeXML
{
    public function testSupplementWeekend()
    {
        $supplementWeekend = new Supplement(
            'Weekend Stay (Fri - Sun)',
            'Per Night',
            'Per Room',
            60
        );

        $this->serialize(
            '<Supplement>
				<Name>Weekend Stay (Fri - Sun)</Name>
				<Duration>Per Night</Duration>
				<Multiplier>Per Room</Multiplier>
				<Total>60</Total>
			</Supplement>',
            $supplementWeekend
        );

        $this->unserialize(
            '<Supplement>
				<Name>Weekend Stay (Fri - Sun)</Name>
				<Duration>Per Night</Duration>
				<Multiplier>Per Room</Multiplier>
				<PaxType/>
				<Total>60</Total>
			</Supplement>',
            $supplementWeekend
        );

        return $supplementWeekend;
    }

    public function testTestSupplement()
    {
        $testSupplement = new Supplement(
            'test supplement',
            'Per Night',
            'Per Person',
            220,
            'Adult Only'
        );

        $this->serialize(
            '<Supplement>
				<Name>test supplement</Name>
				<Duration>Per Night</Duration>
				<Multiplier>Per Person</Multiplier>
				<Total>220</Total>
				<PaxType>Adult Only</PaxType>
			</Supplement>',
            $testSupplement
        );

        $this->unserialize(
            '<Supplement>
				<Name>test supplement</Name>
				<Duration>Per Night</Duration>
				<Multiplier>Per Person</Multiplier>
				<PaxType>Adult Only</PaxType>
				<Total>220</Total>
			</Supplement>',
            $testSupplement
        );

        return $testSupplement;
    }

    /**
     * @depends testTostSupplement
     */
    public function testOneSupplements($testSupplement)
    {
        $oneSupplements = new Supplements($testSupplement);

        $this->serialize(
            '<Supplements>
				<Supplement>
					<Name>test supplement</Name>
					<Duration>Per Night</Duration>
					<Multiplier>Per Person</Multiplier>
					<Total>220</Total>
					<PaxType>Adult Only</PaxType>
				</Supplement>
			</Supplements>',
            $oneSupplements
        );

        $this->unserialize(
            '<Supplements>
				<Supplement>
					<Name>test supplement</Name>
					<Duration>Per Night</Duration>
					<Multiplier>Per Person</Multiplier>
					<Total>220</Total>
					<PaxType>Adult Only</PaxType>
				</Supplement>
			</Supplements>',
            $oneSupplements
        );

        return $oneSupplements;
    }

    /**
     * @depends testSupplementWeekend
     * @depends testTestSupplement
     */
    public function testTwoSupplements($supplementWeekend, $testSupplement)
    {
        $twoSupplements = new Supplements(
            $supplementWeekend,
            $testSupplement
        );

        $this->serialize(
            '<Supplements>
				<Supplement>
					<Name>Weekend Stay (Fri - Sun)</Name>
					<Duration>Per Night</Duration>
					<Multiplier>Per Room</Multiplier>
					<Total>60</Total>
				</Supplement>
				<Supplement>
					<Name>test supplement</Name>
					<Duration>Per Night</Duration>
					<Multiplier>Per Person</Multiplier>
					<Total>220</Total>
					<PaxType>Adult Only</PaxType>
				</Supplement>
			</Supplements>',
            $twoSupplements
        );

        $this->unserialize(
            '<Supplements>
				<Supplement>
					<Name>Weekend Stay (Fri - Sun)</Name>
					<Duration>Per Night</Duration>
					<Multiplier>Per Room</Multiplier>
					<Total>60</Total>
				</Supplement>
				<Supplement>
					<Name>test supplement</Name>
					<Duration>Per Night</Duration>
					<Multiplier>Per Person</Multiplier>
					<Total>220</Total>
					<PaxType>Adult Only</PaxType>
				</Supplement>
			</Supplements>',
            $twoSupplements
        );

        return $twoSupplements;
    }

}
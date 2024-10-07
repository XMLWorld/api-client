<?php

namespace XMLWorld\ApiClient\Test\Responses;

use XMLWorld\ApiClient\Requests\ChildAges;
use XMLWorld\ApiClient\Responses\Supplement;
use XMLWorld\ApiClient\Responses\Supplements;

trait SupplementsTrait
{
    public function testSupplementWeekend()
    {
        $instance = new Supplement(
            'Weekend Stay (Fri - Sun)',
            'Per Night',
            'Per Room',
            60
        );

        $serialize = '<Supplement>
				<Name>Weekend Stay (Fri - Sun)</Name>
				<Duration>Per Night</Duration>
				<Multiplier>Per Room</Multiplier>
				<Total>60</Total>
			</Supplement>';

        $unSerialize = '<Supplement>
				<Name>Weekend Stay (Fri - Sun)</Name>
				<Duration>Per Night</Duration>
				<Multiplier>Per Room</Multiplier>
				<PaxType/>
				<Total>60</Total>
			</Supplement>';

        $supplementWeekend = [
            $instance,
            $serialize,
            $unSerialize
        ];

        $this->doTest(...$supplementWeekend);

        return $supplementWeekend;
    }

    public function testSupplement()
    {
        $instance = new Supplement(
            'test supplement',
            'Per Night',
            'Per Person',
            220,
            'Adult Only'
        );

        $serialize = '<Supplement>
				<Name>test supplement</Name>
				<Duration>Per Night</Duration>
				<Multiplier>Per Person</Multiplier>
				<Total>220</Total>
				<PaxType>Adult Only</PaxType>
			</Supplement>';

        $unSerialize = '<Supplement>
				<Name>test supplement</Name>
				<Duration>Per Night</Duration>
				<Multiplier>Per Person</Multiplier>
				<PaxType>Adult Only</PaxType>
				<Total>220</Total>
			</Supplement>';

        $testSupplement = [
            $instance,
            $serialize,
            $unSerialize
        ];

        $this->doTest(...$testSupplement);

        return $testSupplement;
    }

    /**
     * @depends testSupplement
     */
    public function testOneSupplements($testSupplement)
    {
        list($instance, $serialize, $unserialize) = $testSupplement;

        $instance = new Supplements($instance);

        $twoSupplements = $this->wrap($instance, $serialize, $unserialize);

        $this->doTest(...$twoSupplements);

        return $twoSupplements;
    }

    /**
     * @depends testSupplementWeekend
     * @depends testSupplement
     */
    public function testTwoSupplements($supplementWeekend, $testSupplement)
    {
        $instances = $serializes = $unserializes = [];

        list($instances[0], $serializes[0], $unserializes[0]) = $supplementWeekend;
        list($instances[1], $serializes[1], $unserializes[1]) = $testSupplement;

        $instance = new Supplements(...$instances);

        $testTwoSupplements = $this->wrap(
            $instance,
            implode(PHP_EOL, $serializes),
            implode(PHP_EOL, $unserializes),
        );

        $this->doTest(...$testTwoSupplements);

        return $testTwoSupplements;
    }
}
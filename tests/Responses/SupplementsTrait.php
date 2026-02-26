<?php

namespace XMLWorld\ApiClient\Test\Responses;

use XMLWorld\ApiClient\Responses\Supplement;
use XMLWorld\ApiClient\Responses\Supplements;

trait SupplementsTrait
{
    protected function getSupplement1() : array
    {
        $instance = new Supplement(
            'Weekend Stay (Fri - Sun)',
            'Per Night',
            'Per Room',
            60
        );

        $serialize = <<<'XML'
<Supplement>
	<Name>Weekend Stay (Fri - Sun)</Name>
	<Duration>Per Night</Duration>
	<Multiplier>Per Room</Multiplier>
	<Total>60</Total>
</Supplement>
XML;

        $unSerialize = <<<'XML'
<Supplement>
	<Name>Weekend Stay (Fri - Sun)</Name>
	<Duration>Per Night</Duration>
	<Multiplier>Per Room</Multiplier>
	<PaxType/>
	<Total>60</Total>
</Supplement>
XML;

        return [
            $instance,
            $serialize,
            $unSerialize
        ];
    }

    protected function getSupplement2() : array
    {
        $instance = new Supplement(
            'test supplement',
            'Per Night',
            'Per Person',
            220,
            'Adult Only'
        );

        $serialize = <<<'XML'
<Supplement>
	<Name>test supplement</Name>
	<Duration>Per Night</Duration>
	<Multiplier>Per Person</Multiplier>
	<Total>220</Total>
	<PaxType>Adult Only</PaxType>
</Supplement>
XML;

        $unSerialize = <<<'XML'
<Supplement>
	<Name>test supplement</Name>
	<Duration>Per Night</Duration>
	<Multiplier>Per Person</Multiplier>
	<PaxType>Adult Only</PaxType>
	<Total>220</Total>
</Supplement>
XML;

        return [
            $instance,
            $serialize,
            $unSerialize
        ];
    }

	protected function getOneSupplements(array $supplement) : array
    {
        list($instance, $serialize, $unserialize) = $supplement;

        $instance = new Supplements($instance);

		$serialize = <<<XML
<Supplements>
	$serialize
</Supplements>
XML;

		$unSerialize = <<<XML
<Supplements>
	$unserialize
</Supplements>
XML;

		return [
			$instance,
			$serialize,
			$unSerialize
		];
    }

	protected function getTwoSupplements(array $supplement1, array $supplement2) : array
    {
        $instances = $serializes = $unserializes = [];

        list($instances[0], $serializes[0], $unserializes[0]) = $supplement1; //SupplementWeekend
        list($instances[1], $serializes[1], $unserializes[1]) = $supplement2; //TestSupplement

        $instance = new Supplements(...$instances);

		$serialize = <<<XML
<Supplements>
	$serializes[0]
	$serializes[1]
</Supplements>
XML;

		$unSerialize = <<<XML
<Supplements>
	$unserializes[0]
	$unserializes[1]
</Supplements>
XML;

		return [
			$instance,
			$serialize,
			$unSerialize
		];
    }
}
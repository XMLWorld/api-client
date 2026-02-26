<?php

namespace XMLWorld\ApiClient\Test\Responses;

use XMLWorld\ApiClient\Responses\Errata;
use XMLWorld\ApiClient\Responses\Erratum;

trait ErrataTrait
{
    protected function getErratum1() : array
    {
        $instance = new Erratum(
            '2020-08-04',
            '2020-08-11',
            'Small pool will be closed for maintenance'
        );

        $serialize = <<<'XML'
<Erratum>
	<StartDate>2020-08-04</StartDate>
	<EndDate>2020-08-11</EndDate>
	<Description>Small pool will be closed for maintenance</Description>
</Erratum>
XML;

        $unserialize = <<<'XML'
<Erratum>
	
	<EndDate>2020-08-11</EndDate> <StartDate>2020-08-04</StartDate>
	<Description>Small pool will be closed for maintenance</Description>
</Erratum>
XML;

        return [
			$instance,
			$serialize,
			$unserialize
		];
    }

	protected function getErratum2() : array
	{
		$instance = new Erratum(
			'2020-08-04',
			'2020-08-11',
			'There won\'t be mayonese at the restaurant'
		);

		$serialize = <<<'XML'
<Erratum>
	<StartDate>2020-08-04</StartDate>
	<EndDate>2020-08-11</EndDate>
	<Description>There won't be mayonese at the restaurant</Description>
</Erratum>
XML;

		$unserialize = <<<'XML'
<Erratum>
	<StartDate>2020-08-04</StartDate>
	
	<Description>There won't be mayonese at the restaurant</Description>
	<EndDate>2020-08-11</EndDate>
</Erratum>
XML;

		return [
			$instance,
			$serialize,
			$unserialize
		];
	}

	protected function getErratum3() : array
	{
		$instance = new Erratum(
			'2020-08-04',
			'2020-08-11',
			'some fees',
			true,
			10,
			'USD'
		);

		$serialize = <<<'XML'
<Erratum>
	<StartDate>2020-08-04</StartDate>
	<EndDate>2020-08-11</EndDate>
	<Description>some fees</Description>
	<AdditionalCharge>True</AdditionalCharge>
	<Amount>10</Amount>
	<Currency>USD</Currency>
</Erratum>
XML;

		$unserialize = <<<'XML'
<Erratum>
	<StartDate>2020-08-04</StartDate>
	<AdditionalCharge>True</AdditionalCharge>
	<Amount>10</Amount>
	<Currency>USD</Currency>
	<Description>some fees</Description>
	<EndDate>2020-08-11</EndDate>
</Erratum>
XML;

		return [
			$instance,
			$serialize,
			$unserialize
		];
	}

	protected function getOneErrata(array $image) : array
    {
		list($instance, $serialize, $unserialize) = $image;

		$instance = new Errata($instance);

        $serialize = <<<XML
<Errata>
	$serialize
</Errata>
XML;

        $unserialize = <<<XML
<Errata>
	$unserialize
</Errata>
XML;

        return [
			$instance,
			$serialize,
			$unserialize
		];
    }

    protected function getTwoErrata(array $errata1, array $errata2) : array
    {
		list($errata1Instance, $errata1Serialize, $errata1Unserialize) = $errata1;
		list($errata2Instance, $errata2Serialize, $errata2Unserialize) = $errata2;

		$instance = new Errata(
			$errata1Instance,
			$errata2Instance
        );

        $serialize = <<<XML
<Errata>
	$errata1Serialize
	$errata2Serialize
</Errata>
XML;

        $unserialize = <<<XML
<Errata>
	$errata1Unserialize
	$errata2Unserialize
</Errata>
XML;

        return [
			$instance,
			$serialize,
			$unserialize
		];
    }
}
<?php

namespace XMLWorld\ApiClient\Test\Responses;

use XMLWorld\ApiClient\Responses\Errata;
use XMLWorld\ApiClient\Responses\Erratum;

trait ErrataTrait
{
    protected function getErratum()
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
	<StartDate>2020-08-04</StartDate>
	<EndDate>2020-08-11</EndDate>
	<Description>Small pool will be closed for maintenance</Description>
</Erratum>
XML;

        return [
			$instance,
			$serialize,
			$unserialize
		];
    }

	protected function getOneErrata()
    {
		list($instance, $serialize, $unserialize) = $this->getErratum();

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

    protected function getTwoErrata()
    {
		list($instance, $serialize, $unserialize) = $this->getErratum();

		$instance = new Errata(
			$instance,
            new Erratum(
                '2020-08-04',
                '2020-08-11',
                'There won\'t be mayonese at the restaurant'
            )
        );

        $serialize = <<<XML
<Errata>
	$serialize
	<Erratum>
		<StartDate>2020-08-04</StartDate>
		<EndDate>2020-08-11</EndDate>
		<Description>There won't be mayonese at the restaurant</Description>
	</Erratum>
</Errata>
XML;

        $unserialize = <<<XML
<Errata>
	$unserialize
	<Erratum>
		<StartDate>2020-08-04</StartDate>
		<EndDate>2020-08-11</EndDate>
		<Description>There won't be mayonese at the restaurant</Description>
	</Erratum>
</Errata>
XML;

        return [
			$instance,
			$serialize,
			$unserialize
		];
    }

}
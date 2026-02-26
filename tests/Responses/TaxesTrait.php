<?php

namespace XMLWorld\ApiClient\Test\Responses;

use XMLWorld\ApiClient\Responses\Tax;
use XMLWorld\ApiClient\Responses\Taxes;

trait TaxesTrait
{
    protected function getTax()
    {
        $instance = new Tax(
            'test %',
            false,
            1148.55
        );

        $serialize = <<<'XML'
<Tax>
	<TaxName>test %</TaxName>
	<Inclusive>False</Inclusive>
	<Total>1148.55</Total>
</Tax>
XML;

        $unSerialize = <<<'XML'
<Tax>
	<Inclusive>False</Inclusive>
	<Total>1148.55</Total>
	<TaxName>test %</TaxName>
</Tax>
XML;

        return [
            $instance,
            $serialize,
            $unSerialize
        ];
    }

	protected function getOneTaxes()
    {
        list($instance, $serialize, $unserialize) = $this->getTax();

        $instance = new Taxes($instance);

		$serialize = <<<XML
<Taxes>
	$serialize
</Taxes>
XML;

		$unSerialize = <<<XML
<Taxes>
	$unserialize
</Taxes>
XML;

		return [
			$instance,
			$serialize,
			$unSerialize
		];
    }

	protected function getTaxes()
    {
        list($instance, $serialize, $unserialize) = $this->getTax();

        $instance = new Taxes(
            $instance,
            new Tax(
                'Government Tax',
                true,
                423.15
            ),
            new Tax(
                'Service Charge',
                true,
                604.5
            ),
            new Tax(
                'test',
                false,
                300
            ),
        );

        $serialize = <<<XML
<Taxes>
	$serialize
	<Tax>
		<TaxName>Government Tax</TaxName>
		<Inclusive>True</Inclusive>
		<Total>423.15</Total>
	</Tax>
	<Tax>
		<TaxName>Service Charge</TaxName>
		<Inclusive>True</Inclusive>
		<Total>604.5</Total>
	</Tax>
	<Tax>
		<TaxName>test</TaxName>
		<Inclusive>False</Inclusive>
		<Total>300</Total>
	</Tax>
</Taxes>
XML;

        $unSerialize = <<<XML
<Taxes>
	$unserialize
	<Tax>
		<TaxName>Government Tax</TaxName>
		<Inclusive>True</Inclusive>
		<Total>423.15</Total>
	</Tax>
	<Tax>
		<Total>604.5</Total>
		<TaxName>Service Charge</TaxName>
		<Inclusive>True</Inclusive>
	</Tax>
	<Tax>
		<TaxName>test</TaxName>
		<Inclusive>False</Inclusive>
		<Total>300</Total>
	</Tax>
</Taxes>
XML;

        return [
            $instance,
            $serialize,
            $unSerialize
        ];
    }
}
<?php

namespace XMLWorld\ApiClient\Test\Responses;

use XMLWorld\ApiClient\Responses\Tax;
use XMLWorld\ApiClient\Responses\Taxes;

trait TaxesTrait
{
    protected function getTax1() : array
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

	protected function getTax2() : array
	{
		$instance = new Tax(
			'Government Tax',
			true,
			423.15
		);

		$serialize = <<<'XML'
<Tax>
	<TaxName>Government Tax</TaxName>
	<Inclusive>True</Inclusive>
	<Total>423.15</Total>
</Tax>
XML;

		$unSerialize = <<<'XML'
<Tax>
	<Inclusive>True</Inclusive>
	<Total>423.15</Total>
	<TaxName>Government Tax</TaxName>
</Tax>
XML;

		return [
			$instance,
			$serialize,
			$unSerialize
		];
	}

	protected function getOneTaxes(array $tax1) : array
    {
        list($instance, $serialize, $unserialize) = $tax1;

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

	protected function getFourTaxes(array $tax1, array $tax2) : array
    {
        list($tax1Instance, $tax1Serialize, $tax1Unserialize) = $tax1;
		list($tax2Instance, $tax2Serialize, $tax2Unserialize) = $tax2;

        $instance = new Taxes(
			$tax1Instance,
			$tax2Instance,
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
	$tax1Serialize
	$tax2Serialize
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
	$tax1Unserialize
	$tax2Unserialize
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
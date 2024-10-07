<?php

namespace XMLWorld\ApiClient\Test\Responses;

use XMLWorld\ApiClient\Requests\LoginDetails;
use XMLWorld\ApiClient\Responses\RequestInfo;
use XMLWorld\ApiClient\Responses\ReturnStatus;
use XMLWorld\ApiClient\Responses\RoomsAppliesTo;
use XMLWorld\ApiClient\Responses\SpecialOffer;
use XMLWorld\ApiClient\Responses\SpecialOffers;
use XMLWorld\ApiClient\Responses\Supplement;
use XMLWorld\ApiClient\Responses\Supplements;
use XMLWorld\ApiClient\Responses\Tax;
use XMLWorld\ApiClient\Responses\Taxes;
use XMLWorld\ApiClient\Test\BaseSerializeXML;

trait TaxesTrait
{
    public function testTax()
    {
        $instance = new Tax(
            'test %',
            false,
            1148.55
        );

        $serialize = '<Tax>
				<TaxName>test %</TaxName>
				<Inclusive>False</Inclusive>
				<Total>1148.55</Total>
			</Tax>';

        $unSerialize = '<Tax>
				<Inclusive>False</Inclusive>
				<Total>1148.55</Total>
				<TaxName>test %</TaxName>
			</Tax>';

        $oneTax = [
            $instance,
            $serialize,
            $unSerialize
        ];

        $this->doTest(...$oneTax);

        return $oneTax;
    }

    /**
     * @depends testTax
     */
    public function testOneTaxes($oneTax)
    {
        list($instance, $serialize, $unserialize) = $oneTax;

        $instance = new Taxes($instance);

        $oneTaxes = $this->wrap($instance, $serialize, $unserialize);

        $this->doTest(...$oneTaxes);

        return $oneTaxes;
    }

    /**
     * @depends testTax
     */
    public function testTaxes($oneTax)
    {
        list($instance, $serialize, $unserialize) = $oneTax;

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

        $serialize = "<Taxes>
				{$serialize}
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
			</Taxes>";

        $unSerialize = "<Taxes>
				{$unserialize}
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
			</Taxes>";

        $fourTaxes = [
            $instance,
            $serialize,
            $unSerialize
        ];

        $this->doTest(...$fourTaxes);

        return $fourTaxes;
    }
}
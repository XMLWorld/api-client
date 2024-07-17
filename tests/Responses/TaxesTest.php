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

class TaxesTest extends BaseSerializeXML
{
    public function testTax()
    {
        $oneTax = new Tax(
            'test %',
            false,
            1148.55
        );

        $this->serialize(
            '<Tax>
				<TaxName>test %</TaxName>
				<Inclusive>False</Inclusive>
				<Total>1148.55</Total>
			</Tax>',
            $oneTax
        );

        $this->unserialize(
            '<Tax>
				<Inclusive>False</Inclusive>
				<Total>1148.55</Total>
				<TaxName>test %</TaxName>
			</Tax>',
            $oneTax
        );

        return $oneTax;
    }

    /**
     * @depends testTax
     */
    public function testOneTaxes($oneTax)
    {
        $oneTaxes = new Taxes($oneTax);

        $this->serialize(
            '<Taxes>
				<Tax>
					<TaxName>test %</TaxName>
					<Inclusive>False</Inclusive>
					<Total>1148.55</Total>
				</Tax>
			</Taxes>',
            $oneTaxes
        );

        $this->unserialize(
            '<Taxes>
				<Tax>
					<TaxName>test %</TaxName>
					<Inclusive>False</Inclusive>
					<Total>1148.55</Total>
				</Tax>
			</Taxes>',
            $oneTaxes
        );

        return $oneTaxes;
    }

    /**
     * @depends testTax
     */
    public function testTaxes($oneTax)
    {
        $fourTaxes = new Taxes(
            $oneTax,
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

        $this->serialize(
            '<Taxes>
				<Tax>
					<TaxName>test %</TaxName>
					<Inclusive>False</Inclusive>
					<Total>1148.55</Total>
				</Tax>
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
			</Taxes>',
            $fourTaxes
        );

        $this->unserialize(
            '<Taxes>
				<Tax>
					<TaxName>test %</TaxName>
					<Inclusive>False</Inclusive>
					<Total>1148.55</Total>
				</Tax>
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
			</Taxes>',
            $fourTaxes
        );

        return $fourTaxes;
    }
}
<?php

namespace XMLWorld\ApiClient\Test\Responses;

use XMLWorld\ApiClient\Responses\RoomBooking;
use XMLWorld\ApiClient\Responses\RoomBookings;
use XMLWorld\ApiClient\Test\Common\GuestsTrait;

trait RoomBookingsTrait
{
	use GuestsTrait;
	use SupplementsTrait;
	use SpecialOffersTrait;
	use TaxesTrait;
	use CancellationPoliciesTrait;

    protected function getLeadGuestOnlyBookResponse() : array
    {
        $instance = new RoomBooking(
            155558,
            'Executive Double',
            null,
            6,
            1,
            0,
            0,
            null,
            null,
            null,
            null,
            null,
            1040.23
        );

        $serialize = <<<'XML'
<RoomBooking>
	<RoomID>155558</RoomID>
	<Name>Executive Double</Name>
	<MealBasisID>6</MealBasisID>
	<Adults>1</Adults>
	<Children>0</Children>
	<Infants>0</Infants>
	<Guests/>
	<RoomPrice>1040.23</RoomPrice>
</RoomBooking>
XML;

        $unserialize = <<<'XML'
<RoomBooking>
	<RoomID>155558</RoomID>
	<Name>Executive Double</Name>
	<MealBasisID>6</MealBasisID>
	<Adults>1</Adults>
	<Children>0</Children>
	<Infants>0</Infants>
	<Guests/>
	<Supplements/>
	<SpecialOffers/>
	<Taxes/>
	<CancellationPolicies/>
	<RoomPrice>1040.23</RoomPrice>
</RoomBooking>
XML;

		return [
			$instance,
			$serialize,
			$unserialize
		];
    }

	protected function getLeadGuestAndGuestBookResponse() : array
    {
		list($oneGuestInstance, 		$oneGuestSerialize, 		$oneGuestUnserialize) 			= $this->getOneGuests();
		list($oneSupplementsInstance,	$oneSupplementsSerialize,	$oneSupplementsUnserialize)		= $this->getOneSupplements($this->getSupplement1());
		list($oneSpecialOffersInstance,	$oneSpecialOffersSerialize,	$oneSpecialOffersUnserialize)	= $this->getOneSpecialOffers($this->getSpecialOffer1());
		list($oneTaxesInstance,			$oneTaxesSerialize,			$oneTaxesUnserialize)			= $this->getOneTaxes($this->getTax1());
		list($oneCancellationsInstance,	$oneCancellationsSerialize,	$oneCancellationsUnserialize)	= $this->getOneCancellationPolicies($this->getCancellationPolicy1());

        $instance = new RoomBooking(
            155558,
            'Executive Double',
            'Sea View',
            6,
            2,
            0,
            0,
			$oneGuestInstance,
			$oneSupplementsInstance,
			$oneSpecialOffersInstance,
			$oneTaxesInstance,
			$oneCancellationsInstance,
            1040.23
        );

        $serialize = <<<XML
<RoomBooking>
	<RoomID>155558</RoomID>
	<Name>Executive Double</Name>
	<View>Sea View</View>
	<MealBasisID>6</MealBasisID>
	<Adults>2</Adults>
	<Children>0</Children>
	<Infants>0</Infants>
	$oneGuestSerialize
	$oneSupplementsSerialize
	$oneSpecialOffersSerialize
	$oneTaxesSerialize
	$oneCancellationsSerialize
	<RoomPrice>1040.23</RoomPrice>
</RoomBooking>
XML;

        $unserialize = <<<XML
<RoomBooking>
	<RoomID>155558</RoomID>
	<Name>Executive Double</Name>
	<View>Sea View</View>
	<MealBasisID>6</MealBasisID>
	<Adults>2</Adults>
	<Children>0</Children>
	<Infants>0</Infants>
	$oneGuestUnserialize
	$oneSupplementsUnserialize
	$oneSpecialOffersUnserialize
	$oneTaxesUnserialize
	$oneCancellationsUnserialize
	<RoomPrice>1040.23</RoomPrice>
</RoomBooking>
XML;

		return [
			$instance,
			$serialize,
			$unserialize
		];
    }

    protected function getAdultAndChildBookResponse() : array
    {
		list($twoGuestInstance, 		$twoGuestSerialize, 		$twoGuestUnserialize) 			= $this->getTwoGuests();
		list($twoSupplementsInstance,	$twoSupplementsSerialize,	$twoSupplementsUnserialize)		= $this->getTwoSupplements($this->getSupplement1(), $this->getSupplement2());
		list($twoSpecialOffersInstance,	$twoSpecialOffersSerialize,	$twoSpecialOffersUnserialize)	= $this->getTwoSpecialOffers($this->getSpecialOffer1(), $this->getSpecialOffer2());
		list($taxesInstance,			$taxesSerialize,			$taxesUnserialize)				= $this->getFourTaxes($this->getTax1(), $this->getTax2());
		list($twoCancellationsInstance,	$twoCancellationsSerialize,	$twoCancellationsUnserialize)	= $this->getTwoCancellationPolicies($this->getCancellationPolicy1(), $this->getCancellationPolicy2());

        $instance = new RoomBooking(
            155558,
            'Executive Double',
            'Sea View',
            6,
            1,
            1,
            0,
			$twoGuestInstance,
            $twoSupplementsInstance,
			$twoSpecialOffersInstance,
			$taxesInstance,
			$twoCancellationsInstance,
            1040.23
        );

        $serialize = <<<XML
<RoomBooking>
	<RoomID>155558</RoomID>
	<Name>Executive Double</Name>
	<View>Sea View</View>
	<MealBasisID>6</MealBasisID>
	<Adults>1</Adults>
	<Children>1</Children>
	<Infants>0</Infants>
	$twoGuestSerialize
	$twoSupplementsSerialize
	$twoSpecialOffersSerialize
	$taxesSerialize
	$twoCancellationsSerialize
	<RoomPrice>1040.23</RoomPrice>
</RoomBooking>
XML;

        $unserialize = <<<XML
<RoomBooking>
	<RoomID>155558</RoomID>
	<Name>Executive Double</Name>
	<View>Sea View</View>
	<MealBasisID>6</MealBasisID>
	<Adults>1</Adults>
	<Children>1</Children>
	<Infants>0</Infants>
	$twoGuestUnserialize
	$twoSupplementsUnserialize
	$twoSpecialOffersUnserialize
	$taxesUnserialize
	$twoCancellationsUnserialize
	<RoomPrice>1040.23</RoomPrice>
</RoomBooking>
XML;

		return [
			$instance,
			$serialize,
			$unserialize
		];
    }

    protected function getNoSupplementsEOTaxesCancellationsBookResponse() : array
    {
		list($oneGuestInstance, 		$oneGuestSerialize, 		$oneGuestUnserialize) 			= $this->getOneGuests();

		$instance = new RoomBooking(
            155558,
            'Executive Double',
            'Sea View',
            6,
            2,
            0,
            0,
			$oneGuestInstance,
            null,
            null,
            null,
            null,
            1040.23
        );

        $serialize = <<<XML
<RoomBooking>
	<RoomID>155558</RoomID>
	<Name>Executive Double</Name>
	<View>Sea View</View>
	<MealBasisID>6</MealBasisID>
	<Adults>2</Adults>
	<Children>0</Children>
	<Infants>0</Infants>
	$oneGuestSerialize
	<RoomPrice>1040.23</RoomPrice>
</RoomBooking>
XML;

        $unserialize = <<<XML
<RoomBooking>
	<RoomID>155558</RoomID>
	<Name>Executive Double</Name>
	<View>Sea View</View>
	<MealBasisID>6</MealBasisID>
	<Adults>2</Adults>
	<Children>0</Children>
	<Infants>0</Infants>
	$oneGuestUnserialize
	<Supplements/>
	<SpecialOffers/>
	<Taxes/>
	<CancellationPolicies/>
	<RoomPrice>1040.23</RoomPrice>
</RoomBooking>
XML;

		return [
			$instance,
			$serialize,
			$unserialize
		];
    }

    protected function getOneRoomBooking(array $roomBooking) : array
    {
		list($instance, $serialize, $unserialize) = $roomBooking;

		$instance = new RoomBookings($instance);

        $serialize = <<<XML
<RoomBookings>
	$serialize
</RoomBookings>
XML;

        $unserialize = <<<XML
<RoomBookings>
	$unserialize
</RoomBookings>
XML;

		return [
			$instance,
			$serialize,
			$unserialize
		];
    }

    protected function getTwoRoomBooking(array $roomBooking1, array $roomBooking2) : array
    {
		list($leadGuestAndGestBookInstance,	$leadGuestAndGestBookSerialize,	$leadGuestAndGestBookUnserialize)	= $roomBooking1;
		list($adultAndGildBookInstance,		$adultAndGildBookSerialize,		$adultAndGildBookUnserialize) 		= $roomBooking2;

		$instance = new RoomBookings(
			$leadGuestAndGestBookInstance,
			$adultAndGildBookInstance
        );

        $serialize = <<<XML
<RoomBookings>
	$leadGuestAndGestBookSerialize
	$adultAndGildBookSerialize
</RoomBookings>
XML;

        $unserialize = <<<XML
<RoomBookings>
	$leadGuestAndGestBookUnserialize
	$adultAndGildBookUnserialize
</RoomBookings>
XML;

		return [
			$instance,
			$serialize,
			$unserialize
		];
    }
}
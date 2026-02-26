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

    protected function getLeadGuestOnlyBookResponse()
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

	protected function getLeadGuestAndGuestBookResponse()
    {
		list($oneGuestInstance, 		$oneGuestSerialize, 		$oneGuestUnserialize) 			= $this->getOneGuests();
		list($oneSupplementsInstance,	$oneSupplementsSerialize,	$oneSupplementsUnserialize)		= $this->getOneSupplements();
		list($oneSpecialOffersInstance,	$oneSpecialOffersSerialize,	$oneSpecialOffersUnserialize)	= $this->getOneSpecialOffers();
		list($oneTaxesInstance,			$oneTaxesSerialize,			$oneTaxesUnserialize)			= $this->getOneTaxes();
		list($oneCancellationsInstance,	$oneCancellationsSerialize,	$oneCancellationsUnserialize)	= $this->getOneCancellationPolicies();

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

    protected function getAdultAndChildBookResponse()
    {
		list($twoGuestInstance, 		$twoGuestSerialize, 		$twoGuestUnserialize) 			= $this->getTwoGuests();
		list($twoSupplementsInstance,	$twoSupplementsSerialize,	$twoSupplementsUnserialize)		= $this->getTwoSupplements();
		list($twoSpecialOffersInstance,	$twoSpecialOffersSerialize,	$twoSpecialOffersUnserialize)	= $this->getTwoSpecialOffers();
		list($taxesInstance,			$taxesSerialize,			$taxesUnserialize)				= $this->getTaxes();
		list($twoCancellationsInstance,	$twoCancellationsSerialize,	$twoCancellationsUnserialize)	= $this->getCancellationPolicies();

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

    protected function getNoSupplementsEOTaxesCancellationsBookResponse()
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

    protected function getOneRoomBooking()
    {
		list($instance, $serialize, $unserialize) = $this->getLeadGuestOnlyBookResponse();

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

    protected function getTwoRoomBooking()
    {
		list($leadGuestAndGestBookInstance,	$leadGuestAndGestBookSerialize,	$leadGuestAndGestBookUnserialize)	= $this->getLeadGuestAndGuestBookResponse();
		list($adultAndGildBookInstance,		$adultAndGildBookSerialize,		$adultAndGildBookUnserialize) 		= $this->getAdultAndChildBookResponse();

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
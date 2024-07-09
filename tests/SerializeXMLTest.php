<?php

namespace XMLWorld\ApiClient\Test;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

use PHPUnit\Framework\TestCase;

use ReflectionClass;
use XMLWorld\ApiClient\Interfaces\Logger;
use XMLWorld\ApiClient\Interfaces\Serializer;
use XMLWorld\ApiClient\Interfaces\Serializable;

use XMLWorld\ApiClient\Requests\AbstractRequest;
use XMLWorld\ApiClient\Requests\BookDetails;
use XMLWorld\ApiClient\Requests\BookingRequest;
use XMLWorld\ApiClient\Requests\BookingUpdateRequest;
use XMLWorld\ApiClient\Requests\BookRequest;
use XMLWorld\ApiClient\Requests\CancelRequest;
use XMLWorld\ApiClient\Requests\ChildAge;
use XMLWorld\ApiClient\Requests\ChildAges;
use XMLWorld\ApiClient\Requests\LoginDetails;

use XMLWorld\ApiClient\Common\Guest;
use XMLWorld\ApiClient\Common\Guests;
use XMLWorld\ApiClient\Common\LeadGuest;

use XMLWorld\ApiClient\Requests\Properties;
use XMLWorld\ApiClient\Requests\RoomBooking;
use XMLWorld\ApiClient\Requests\RoomBookings;
use XMLWorld\ApiClient\Requests\RoomRequest;
use XMLWorld\ApiClient\Requests\RoomRequests;
use XMLWorld\ApiClient\Requests\SearchDetails;
use XMLWorld\ApiClient\Requests\SearchRequest;
use XMLWorld\ApiClient\Responses\BookingDetails;
use XMLWorld\ApiClient\Responses\BookResponse;
use XMLWorld\ApiClient\Responses\CancellationPolicies;
use XMLWorld\ApiClient\Responses\CancellationPolicy;
use XMLWorld\ApiClient\Responses\CancelResponse;
use XMLWorld\ApiClient\Responses\Errata;
use XMLWorld\ApiClient\Responses\Erratum;
use XMLWorld\ApiClient\Responses\Image;
use XMLWorld\ApiClient\Responses\Images;
use XMLWorld\ApiClient\Responses\Property;
use XMLWorld\ApiClient\Responses\PropertyResult;
use XMLWorld\ApiClient\Responses\PropertyResults;
use XMLWorld\ApiClient\Responses\RequestInfo;
use XMLWorld\ApiClient\Responses\ReturnStatus;

use XMLWorld\ApiClient\Responses\RoomsAppliesTo;
use XMLWorld\ApiClient\Responses\RoomType;
use XMLWorld\ApiClient\Responses\RoomTypes;
use XMLWorld\ApiClient\Responses\SearchResponse;
use XMLWorld\ApiClient\Responses\SpecialOffer;
use XMLWorld\ApiClient\Responses\SpecialOffers;
use XMLWorld\ApiClient\Responses\Supplement;
use XMLWorld\ApiClient\Responses\Supplements;
use XMLWorld\ApiClient\Responses\Supplier;
use XMLWorld\ApiClient\Responses\Tax;
use XMLWorld\ApiClient\Responses\Taxes;

use XMLWorld\ApiClient\Responses\RoomBooking as RoomBookingResponse;
use XMLWorld\ApiClient\Responses\RoomBookings as RoomBookingsResponse;
use XMLWorld\ApiClient\Responses\BookingDetails as BookingDetailsResponse;
use XMLWorld\ApiClient\Responses\BookingResponse;
use XMLWorld\ApiClient\Responses\BookingUpdateRequestResponse;


use XMLWorld\ApiClient\SerializeXML;
use XMLWorld\ApiClient\XMLClient;

class SerializeXMLTest extends TestCase
{
	protected static Serializer $serializer;

	public static function setUpBeforeClass(): void
	{
		self::$serializer = new SerializeXML;
	}

	/**
	 * @dataProvider dataProviderSerializePrimitives
	 * @param string $expected
	 * @param AbstractRequest $obj
	 */
	public function testSerialize(string $expected, Serializable $obj)
	{
		$this->assertEquals(
			str_replace(["\r\n", "\n", "\t"], '', $expected),
			self::$serializer->serialize($obj)
		);
	}

	/**
	 * @dataProvider dataProviderUnserializePrimitives
	 * @param AbstractRequest $expected
	 * @param string $xml
	 * @throws \Exception
	 */
	public function testUnserialize(string $xml, Serializable $expected)
	{
		$namespace = (new ReflectionClass($expected))->getNamespaceName();
		$this->assertEquals($expected, self::$serializer->unserialize($xml, $namespace));
	}

	/**
	 * @param string $expected
	 * @dataProvider dataProviderLogTests
	 */
	public function testLogging(array $expected)
	{
		//anonymous logger object
		$logger = new class($this, $expected) implements Logger {

			private SerializeXMLTest $test;
			private array $expected;

			public function __construct($test, $expected)
			{
				$this->test = $test;
				$this->expected = $expected;
			}

			public function logRequest(string $log) : void
			{
				$this->test->assertEquals($this->expected[0], $log);
			}

			public function logResponse(int $statusCode, string $log) : void
			{
				$this->test->assertEquals($this->expected[1], $log);
				$this->test->assertEquals($this->expected[2], $statusCode);
			}
		};

		$xmlClient = new class (
			'login',
			'pass',
			$expected,
			XMLClient::ENV_DEV,
			$logger
		) extends XMLClient {

			public function __construct(
				string $login,
				string $password,
				public array $expected,
				string $env = self::ENV_DEV,
				Logger $logger = null
			) {
				parent::__construct($login, $password, $env, $logger);
			}

			protected function getClient(): Client
			{
				$mock = new MockHandler(
					[
						new Response($this->expected[2], [], $this->expected[1]),
					]
				);

				$handlerStack = HandlerStack::create($mock);

				return new Client(['handler' => $handlerStack]);
			}
		};

		$xmlClient->booking('reference');
	}

	public static function dataProviderSerializePrimitives()
	{
		$proeprtyID = new Properties(2007);
		yield [
			'<Properties>
				<PropertyID>2007</PropertyID>
			</Properties>',
			$proeprtyID
		];

		$twoPropertyIDs = new Properties(2007, 3008);
		yield [
			'<Properties>
				<PropertyID>2007</PropertyID>
				<PropertyID>3008</PropertyID>
			</Properties>',
			$twoPropertyIDs
		];

		yield [
			'<ChildAge>
				<Age>15</Age>
			</ChildAge>',
			new ChildAge(15)
		];

		yield [
			'<ChildAges>
				<ChildAge>
					<Age>15</Age>
				</ChildAge>
			</ChildAges>',
			ChildAges::fromAges(
				15
			)
		];

		yield [
			'<ChildAges>
				<ChildAge>
					<Age>8</Age>
				</ChildAge>
				<ChildAge>
					<Age>15</Age>
				</ChildAge>
			</ChildAges>',
			ChildAges::fromAges(
				8, 15
			)
		];

		$twoAdults = RoomRequest::fromAges(2);
		yield [
			'<RoomRequest>
				<Adults>2</Adults>
				<Children>0</Children>
			</RoomRequest>',
			$twoAdults
		];

		$twoAdultsOneChild = RoomRequest::fromAges(
			2,
			10
		);

		yield [
			'<RoomRequest>
				<Adults>2</Adults>
				<Children>1</Children>
				<ChildAges>
					<ChildAge>
						<Age>10</Age>
					</ChildAge>
				</ChildAges>
			</RoomRequest>',
			$twoAdultsOneChild
		];

		$twoAdultsTwoInfants = RoomRequest::fromAges(
			2,
			1, 2
		);

		yield [
			'<RoomRequest>
				<Adults>2</Adults>
				<Children>2</Children>
				<ChildAges>
					<ChildAge>
						<Age>1</Age>
					</ChildAge>
					<ChildAge>
						<Age>2</Age>
					</ChildAge>
				</ChildAges>
			</RoomRequest>',
			$twoAdultsTwoInfants
		];

		$oneChildTwoInfants = RoomRequest::fromAges(
			null,
			1, 2, 10
		);

		yield [
			'<RoomRequest>
				<Adults>0</Adults>
				<Children>3</Children>
				<ChildAges>
					<ChildAge>
						<Age>1</Age>
					</ChildAge>
					<ChildAge>
						<Age>2</Age>
					</ChildAge>
					<ChildAge>
						<Age>10</Age>
					</ChildAge>
				</ChildAges>
			</RoomRequest>',
			$oneChildTwoInfants
		];

		$twoAdultsOneChildrenTwoInfants = RoomRequest::fromAges(
			2,
			1, 8, 2
		);

		yield [
			'<RoomRequest>
				<Adults>2</Adults>
				<Children>3</Children>
				<ChildAges>
					<ChildAge>
						<Age>1</Age>
					</ChildAge>
					<ChildAge>
						<Age>8</Age>
					</ChildAge>
					<ChildAge>
						<Age>2</Age>
					</ChildAge>
				</ChildAges>
			</RoomRequest>',
			$twoAdultsOneChildrenTwoInfants
		];

		$twoAdultsTwoChildrenTwoInfants = RoomRequest::fromAges(
			2,
			9, 1, 8, 2
		);

		yield [
			'<RoomRequest>
				<Adults>2</Adults>
				<Children>4</Children>
				<ChildAges>
					<ChildAge>
						<Age>9</Age>
					</ChildAge>
					<ChildAge>
						<Age>1</Age>
					</ChildAge>
					<ChildAge>
						<Age>8</Age>
					</ChildAge>
					<ChildAge>
						<Age>2</Age>
					</ChildAge>
				</ChildAges>
			</RoomRequest>',
			$twoAdultsTwoChildrenTwoInfants
		];

		yield [
			'<RoomRequests>
				<RoomRequest>
					<Adults>2</Adults>
					<Children>0</Children>
				</RoomRequest>
			</RoomRequests>',
			new RoomRequests(
				$twoAdults
			)
		];

		yield [
			'<RoomRequests>
				<RoomRequest>
					<Adults>2</Adults>
					<Children>2</Children>
					<ChildAges>
						<ChildAge>
							<Age>1</Age>
						</ChildAge>
						<ChildAge>
							<Age>2</Age>
						</ChildAge>
					</ChildAges>
				</RoomRequest>
			</RoomRequests>',
			new RoomRequests(
				$twoAdultsTwoInfants
			)
		];

		yield [
			'<RoomRequests>
				<RoomRequest>
					<Adults>2</Adults>
					<Children>1</Children>
					<ChildAges>
						<ChildAge>
							<Age>10</Age>
						</ChildAge>
					</ChildAges>
				</RoomRequest>
			</RoomRequests>',
			new RoomRequests(
				$twoAdultsOneChild
			)
		];

		yield [
			'<RoomRequests>
				<RoomRequest>
					<Adults>2</Adults>
					<Children>4</Children>
					<ChildAges>
						<ChildAge>
							<Age>9</Age>
						</ChildAge>
						<ChildAge>
							<Age>1</Age>
						</ChildAge>
						<ChildAge>
							<Age>8</Age>
						</ChildAge>
						<ChildAge>
							<Age>2</Age>
						</ChildAge>
					</ChildAges>
				</RoomRequest>
			</RoomRequests>',
			new RoomRequests(
				$twoAdultsTwoChildrenTwoInfants
			)
		];

		yield [
			'<RoomRequests>
				<RoomRequest>
					<Adults>2</Adults>
					<Children>2</Children>
					<ChildAges>
						<ChildAge>
							<Age>1</Age>
						</ChildAge>
						<ChildAge>
							<Age>2</Age>
						</ChildAge>
					</ChildAges>
				</RoomRequest>
				<RoomRequest>
					<Adults>2</Adults>
					<Children>1</Children>
					<ChildAges>
						<ChildAge>
							<Age>10</Age>
						</ChildAge>
					</ChildAges>
				</RoomRequest>
				<RoomRequest>
					<Adults>2</Adults>
					<Children>4</Children>
					<ChildAges>
						<ChildAge>
							<Age>9</Age>
						</ChildAge>
						<ChildAge>
							<Age>1</Age>
						</ChildAge>
						<ChildAge>
							<Age>8</Age>
						</ChildAge>
						<ChildAge>
							<Age>2</Age>
						</ChildAge>
					</ChildAges>
				</RoomRequest>
			</RoomRequests>',
			new RoomRequests(
				$twoAdultsTwoInfants,
				$twoAdultsOneChild,
				$twoAdultsTwoChildrenTwoInfants
			)
		];

		$loginDetails = new LoginDetails('login', 'pass', 'version');

		yield [
			'<LoginDetails>
				<Login>login</Login>
				<Password>pass</Password>
				<Version>version</Version>
			</LoginDetails>',
			$loginDetails
		];

		//two properties
		yield [
			'<SearchRequest>
				<LoginDetails>
					<Login>login</Login>
					<Password>pass</Password>
					<Version>version</Version>
				</LoginDetails>
				<Mock>True</Mock>
				<SearchDetails>
					<ArrivalDate>2023-08-01</ArrivalDate>
					<Duration>7</Duration>
					<RoomRequests>
						<RoomRequest>
							<Adults>2</Adults>
							<Children>2</Children>
							<ChildAges>
								<ChildAge>
									<Age>1</Age>
								</ChildAge>
								<ChildAge>
									<Age>2</Age>
								</ChildAge>
							</ChildAges>
						</RoomRequest>
						<RoomRequest>
							<Adults>2</Adults>
							<Children>4</Children>
							<ChildAges>
								<ChildAge>
									<Age>9</Age>
								</ChildAge>
								<ChildAge>
									<Age>1</Age>
								</ChildAge>
								<ChildAge>
									<Age>8</Age>
								</ChildAge>
								<ChildAge>
									<Age>2</Age>
								</ChildAge>
							</ChildAges>
						</RoomRequest>
					</RoomRequests>
					<Properties>
						<PropertyID>2007</PropertyID>
						<PropertyID>3008</PropertyID>
					</Properties>
					<MealBasisID>0</MealBasisID>
					<MinStarRating>0</MinStarRating>
					<MinimumPrice>0</MinimumPrice>
					<MaximumPrice>0</MaximumPrice>
				</SearchDetails>
			</SearchRequest>',
			new SearchRequest(
				$loginDetails,
				new SearchDetails(
					'2023-08-01',
					7,
					new RoomRequests(
						$twoAdultsTwoInfants,
						$twoAdultsTwoChildrenTwoInfants
					),
					$twoPropertyIDs,
					null,
					0,
					0,
					0,
					0
				),
				true
			)
		];

		//one property
		yield [
			'<SearchRequest>
				<LoginDetails>
					<Login>login</Login>
					<Password>pass</Password>
					<Version>version</Version>
				</LoginDetails>
				<Mock>True</Mock>
				<SearchDetails>
					<ArrivalDate>2023-08-01</ArrivalDate>
					<Duration>7</Duration>
					<RoomRequests>
						<RoomRequest>
							<Adults>2</Adults>
							<Children>2</Children>
							<ChildAges>
								<ChildAge>
									<Age>1</Age>
								</ChildAge>
								<ChildAge>
									<Age>2</Age>
								</ChildAge>
							</ChildAges>
						</RoomRequest>
						<RoomRequest>
							<Adults>2</Adults>
							<Children>4</Children>
							<ChildAges>
								<ChildAge>
									<Age>9</Age>
								</ChildAge>
								<ChildAge>
									<Age>1</Age>
								</ChildAge>
								<ChildAge>
									<Age>8</Age>
								</ChildAge>
								<ChildAge>
									<Age>2</Age>
								</ChildAge>
							</ChildAges>
						</RoomRequest>
					</RoomRequests>
					<PropertyID>2007</PropertyID>
					<MealBasisID>0</MealBasisID>
					<MinStarRating>0</MinStarRating>
					<MinimumPrice>0</MinimumPrice>
					<MaximumPrice>0</MaximumPrice>
				</SearchDetails>
			</SearchRequest>',
			new SearchRequest(
				$loginDetails,
				new SearchDetails(
					'2023-08-01',
					7,
					new RoomRequests(
						$twoAdultsTwoInfants,
						$twoAdultsTwoChildrenTwoInfants
					),
					null,
					2007,
					0,
					0,
					0,
					0
				),
				true
			)
		];

		$requestInfo = new RequestInfo(
			1687253937,
			'2023-06-20T09:38:57+00:00',
			'xml.centriumres.com.localdomain.ee',
			'10.0.1.182',
			'649173b14aadb8.17864349'
		);

		yield [
			'<RequestInfo>
				<Timestamp>1687253937</Timestamp>
				<TimestampISO>2023-06-20T09:38:57+00:00</TimestampISO>
				<Host>xml.centriumres.com.localdomain.ee</Host>
				<HostIP>10.0.1.182</HostIP>
				<ReqID>649173b14aadb8.17864349</ReqID>
			</RequestInfo>',
			$requestInfo
		];

		$returnStatusTrue = new ReturnStatus(true);

		yield [
			'<ReturnStatus>
				<Success>True</Success>
			</ReturnStatus>',
			$returnStatusTrue
		];

		$returnBookingStatusFalse = new ReturnStatus(
			false,
			'Supplier Reference not found for Booking Reference HCL0011 in SupplierBooking'
		);

		yield [
			'<ReturnStatus>
				<Success>False</Success>
				<Exception>Supplier Reference not found for Booking Reference HCL0011 in SupplierBooking</Exception>
			</ReturnStatus>',
			$returnBookingStatusFalse
		];

		$returnSerachStatusFalse = new ReturnStatus(
			false,
			'Could not find any rooms for RoomRequest'
		);

		yield [
			'<ReturnStatus>
				<Success>False</Success>
				<Exception>Could not find any rooms for RoomRequest</Exception>
			</ReturnStatus>',
			$returnSerachStatusFalse
		];

		$roomsAppliesTo = new RoomsAppliesTo(1);
		yield [
			'<RoomsAppliesTo>
				<RoomRequest>1</RoomRequest>
			</RoomsAppliesTo>',
			$roomsAppliesTo
		];

		yield [
			'<RoomsAppliesTo>
				<RoomRequest>1</RoomRequest>
				<RoomRequest>2</RoomRequest>
				<RoomRequest>3</RoomRequest>
				<RoomRequest>4</RoomRequest>
			</RoomsAppliesTo>',
			new RoomsAppliesTo(1, 2, 3, 4)
		];

		$supplementWeekend = new Supplement(
			'Weekend Stay (Fri - Sun)',
			'Per Night',
			'Per Room',
			60
		);

		yield [
			'<Supplement>
				<Name>Weekend Stay (Fri - Sun)</Name>
				<Duration>Per Night</Duration>
				<Multiplier>Per Room</Multiplier>
				<Total>60</Total>
			</Supplement>',
			$supplementWeekend
		];

		$testSupplement = new Supplement(
			'test supplement',
			'Per Night',
			'Per Person',
			220,
			'Adult Only'
		);

		yield [
			'<Supplement>
				<Name>test supplement</Name>
				<Duration>Per Night</Duration>
				<Multiplier>Per Person</Multiplier>
				<Total>220</Total>
				<PaxType>Adult Only</PaxType>
			</Supplement>',
			$testSupplement
		];

		$oneSupplement = new Supplements($testSupplement);

		yield [
			'<Supplements>
				<Supplement>
					<Name>test supplement</Name>
					<Duration>Per Night</Duration>
					<Multiplier>Per Person</Multiplier>
					<Total>220</Total>
					<PaxType>Adult Only</PaxType>
				</Supplement>
			</Supplements>',
			$oneSupplement
		];

		$twoSupplements = new Supplements(
			$supplementWeekend,
			$testSupplement
		);

		yield [
			'<Supplements>
				<Supplement>
					<Name>Weekend Stay (Fri - Sun)</Name>
					<Duration>Per Night</Duration>
					<Multiplier>Per Room</Multiplier>
					<Total>60</Total>
				</Supplement>
				<Supplement>
					<Name>test supplement</Name>
					<Duration>Per Night</Duration>
					<Multiplier>Per Person</Multiplier>
					<Total>220</Total>
					<PaxType>Adult Only</PaxType>
				</Supplement>
			</Supplements>',
			$twoSupplements
		];

		$specialOffer1 = new SpecialOffer(
			'Example special offer',
			'Value Added',
			null,
			null,
			null,
			'test desc'
		);

		yield [
			'<SpecialOffer>
				<Name>Example special offer</Name>
				<Type>Value Added</Type>
				<Desc>test desc</Desc>
			</SpecialOffer>',
			$specialOffer1
		];

		$specialOffer2 = new SpecialOffer(
			'Example special offer 2',
			'Free Kids',
			1,
			null,
			1000,
			'test desc'
		);

		yield [
			'<SpecialOffer>
				<Name>Example special offer 2</Name>
				<Type>Free Kids</Type>
				<Value>1</Value>
				<Total>1000</Total>
				<Desc>test desc</Desc>
			</SpecialOffer>',
			$specialOffer2
		];

		$oneSpecialOffer = new SpecialOffers($specialOffer1);
		yield [
			'<SpecialOffers>
				<SpecialOffer>
					<Name>Example special offer</Name>
					<Type>Value Added</Type>
					<Desc>test desc</Desc>
				</SpecialOffer>
			</SpecialOffers>',
			$oneSpecialOffer
		];

		$twoSpecialOffers = new SpecialOffers(
			$specialOffer1,
			$specialOffer2
		);

		yield [
			'<SpecialOffers>
				<SpecialOffer>
					<Name>Example special offer</Name>
					<Type>Value Added</Type>
					<Desc>test desc</Desc>
				</SpecialOffer>
				<SpecialOffer>
					<Name>Example special offer 2</Name>
					<Type>Free Kids</Type>
					<Value>1</Value>
					<Total>1000</Total>
					<Desc>test desc</Desc>
				</SpecialOffer>
			</SpecialOffers>',
			$twoSpecialOffers
		];

		$tax = new Tax(
			'test %',
			false,
			1148.55
		);

		yield [
			'<Tax>
				<TaxName>test %</TaxName>
				<Inclusive>False</Inclusive>
				<Total>1148.55</Total>
			</Tax>',
			$tax
		];

		$oneTax = new Taxes($tax);

		yield [
			'<Taxes>
				<Tax>
					<TaxName>test %</TaxName>
					<Inclusive>False</Inclusive>
					<Total>1148.55</Total>
				</Tax>
			</Taxes>',
			$oneTax
		];

		$fourTaxes = new Taxes(
			$tax,
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

		yield [
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
		];

		$cancellationPolicy = new CancellationPolicy(
			'2020-07-11',
			574.28
		);

		yield [
			'<CancellationPolicy>
				<CancelBy>2020-07-11</CancelBy>
				<Penalty>574.28</Penalty>
			</CancellationPolicy>',
			$cancellationPolicy
		];

		$oneCancellationPolicy = new CancellationPolicies($cancellationPolicy);
		yield [
			'<CancellationPolicies>
				<CancellationPolicy>
					<CancelBy>2020-07-11</CancelBy>
					<Penalty>574.28</Penalty>
				</CancellationPolicy>
			</CancellationPolicies>',
			$oneCancellationPolicy
		];


		$twoCancellationPolicy = new CancellationPolicies(
			$cancellationPolicy,
			new CancellationPolicy(
				'2020-07-18',
				1148.55
			)
		);

		yield [
			'<CancellationPolicies>
				<CancellationPolicy>
					<CancelBy>2020-07-11</CancelBy>
					<Penalty>574.28</Penalty>
				</CancellationPolicy>
				<CancellationPolicy>
					<CancelBy>2020-07-18</CancelBy>
					<Penalty>1148.55</Penalty>
				</CancellationPolicy>
			</CancellationPolicies>',
			$twoCancellationPolicy
		];

		$roomType = new RoomType(
			999,
			null,
			1,
			1,
			'Example Villa',
			'Sea View',
			2,
			2,
			1,
			true,
			5896.80,
			6565.35,
			$roomsAppliesTo,
			$oneSupplement,
			$twoSpecialOffers,
			$fourTaxes,
			$twoCancellationPolicy,
		);

		yield [
			'<RoomType>
				<RoomID>999</RoomID>
				<PropertyRoomTypeID>1</PropertyRoomTypeID>
				<MealBasisID>1</MealBasisID>
				<Name>Example Villa</Name>
				<View>Sea View</View>
				<Adults>2</Adults>
				<Children>2</Children>
				<Infants>1</Infants>
				<OnRequest>True</OnRequest>
				<SubTotal>5896.8</SubTotal>
				<Total>6565.35</Total>
				<RoomsAppliesTo>
					<RoomRequest>1</RoomRequest>
				</RoomsAppliesTo>
				<Supplements>
					<Supplement>
						<Name>test supplement</Name>
						<Duration>Per Night</Duration>
						<Multiplier>Per Person</Multiplier>
						<Total>220</Total>
						<PaxType>Adult Only</PaxType>
					</Supplement>
				</Supplements>
				<SpecialOffers>
					<SpecialOffer>
						<Name>Example special offer</Name>
						<Type>Value Added</Type>
						<Desc>test desc</Desc>
					</SpecialOffer>
					<SpecialOffer>
						<Name>Example special offer 2</Name>
						<Type>Free Kids</Type>
						<Value>1</Value>
						<Total>1000</Total>
						<Desc>test desc</Desc>
					</SpecialOffer>
				</SpecialOffers>
				<Taxes>
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
				</Taxes>
				<CancellationPolicies>
					<CancellationPolicy>
						<CancelBy>2020-07-11</CancelBy>
						<Penalty>574.28</Penalty>
					</CancellationPolicy>
					<CancellationPolicy>
						<CancelBy>2020-07-18</CancelBy>
						<Penalty>1148.55</Penalty>
					</CancellationPolicy>
				</CancellationPolicies>
			</RoomType>',
			$roomType
		];

		$oneRoomType = new RoomTypes($roomType);

		yield [
			'<RoomTypes>
				<RoomType>
					<RoomID>999</RoomID>
					<PropertyRoomTypeID>1</PropertyRoomTypeID>
					<MealBasisID>1</MealBasisID>
					<Name>Example Villa</Name>
					<View>Sea View</View>
					<Adults>2</Adults>
					<Children>2</Children>
					<Infants>1</Infants>
					<OnRequest>True</OnRequest>
					<SubTotal>5896.8</SubTotal>
					<Total>6565.35</Total>
					<RoomsAppliesTo>
						<RoomRequest>1</RoomRequest>
					</RoomsAppliesTo>
					<Supplements>
						<Supplement>
							<Name>test supplement</Name>
							<Duration>Per Night</Duration>
							<Multiplier>Per Person</Multiplier>
							<Total>220</Total>
							<PaxType>Adult Only</PaxType>
						</Supplement>
					</Supplements>
					<SpecialOffers>
						<SpecialOffer>
							<Name>Example special offer</Name>
							<Type>Value Added</Type>
							<Desc>test desc</Desc>
						</SpecialOffer>
						<SpecialOffer>
							<Name>Example special offer 2</Name>
							<Type>Free Kids</Type>
							<Value>1</Value>
							<Total>1000</Total>
							<Desc>test desc</Desc>
						</SpecialOffer>
					</SpecialOffers>
					<Taxes>
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
					</Taxes>
					<CancellationPolicies>
						<CancellationPolicy>
							<CancelBy>2020-07-11</CancelBy>
							<Penalty>574.28</Penalty>
						</CancellationPolicy>
						<CancellationPolicy>
							<CancelBy>2020-07-18</CancelBy>
							<Penalty>1148.55</Penalty>
						</CancellationPolicy>
					</CancellationPolicies>
				</RoomType>
			</RoomTypes>',
			$oneRoomType
		];

		$twoRoomType = new RoomTypes(
			$roomType,
			$roomType = new RoomType(
				998,
				null,
				null,
				1,
				'Example Villa',
				'Sea View',
				2,
				0,
				0,
				true,
				3960,
				4400,
				new RoomsAppliesTo(2),
				null,
				new SpecialOffers(
					new SpecialOffer(
						'Early Bird Booking',
						'Adult Only',
						10,
						'All',
						440
					)
				),
				new Taxes(
					new Tax(
						'Government Tax',
						true,
						423.15
					)
				),
				new CancellationPolicies(
					new CancellationPolicy(
						'2020-07-18',
						440
					)
				),
			)
		);


		yield [
			'<RoomTypes>
				<RoomType>
					<RoomID>999</RoomID>
					<PropertyRoomTypeID>1</PropertyRoomTypeID>
					<MealBasisID>1</MealBasisID>
					<Name>Example Villa</Name>
					<View>Sea View</View>
					<Adults>2</Adults>
					<Children>2</Children>
					<Infants>1</Infants>
					<OnRequest>True</OnRequest>
					<SubTotal>5896.8</SubTotal>
					<Total>6565.35</Total>
					<RoomsAppliesTo>
						<RoomRequest>1</RoomRequest>
					</RoomsAppliesTo>
					<Supplements>
						<Supplement>
							<Name>test supplement</Name>
							<Duration>Per Night</Duration>
							<Multiplier>Per Person</Multiplier>
							<Total>220</Total>
							<PaxType>Adult Only</PaxType>
						</Supplement>
					</Supplements>
					<SpecialOffers>
						<SpecialOffer>
							<Name>Example special offer</Name>
							<Type>Value Added</Type>
							<Desc>test desc</Desc>
						</SpecialOffer>
						<SpecialOffer>
							<Name>Example special offer 2</Name>
							<Type>Free Kids</Type>
							<Value>1</Value>
							<Total>1000</Total>
							<Desc>test desc</Desc>
						</SpecialOffer>
					</SpecialOffers>
					<Taxes>
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
					</Taxes>
					<CancellationPolicies>
						<CancellationPolicy>
							<CancelBy>2020-07-11</CancelBy>
							<Penalty>574.28</Penalty>
						</CancellationPolicy>
						<CancellationPolicy>
							<CancelBy>2020-07-18</CancelBy>
							<Penalty>1148.55</Penalty>
						</CancellationPolicy>
					</CancellationPolicies>
				</RoomType>
				<RoomType>
					<RoomID>998</RoomID>
					<MealBasisID>1</MealBasisID>
					<Name>Example Villa</Name>
					<View>Sea View</View>
					<Adults>2</Adults>
					<Children>0</Children>
					<Infants>0</Infants>
					<OnRequest>True</OnRequest>
					<SubTotal>3960</SubTotal>
					<Total>4400</Total>
					<RoomsAppliesTo>
						<RoomRequest>2</RoomRequest>
					</RoomsAppliesTo>
					<SpecialOffers>
						<SpecialOffer>
							<Name>Early Bird Booking</Name>
							<Type>Adult Only</Type>
							<Value>10</Value>
							<PaxType>All</PaxType>
							<Total>440</Total>
						</SpecialOffer>
					</SpecialOffers>
					<Taxes>
						<Tax>
							<TaxName>Government Tax</TaxName>
							<Inclusive>True</Inclusive>
							<Total>423.15</Total>
						</Tax>
					</Taxes>
					<CancellationPolicies>
						<CancellationPolicy>
							<CancelBy>2020-07-18</CancelBy>
							<Penalty>440</Penalty>
						</CancellationPolicy>
					</CancellationPolicies>
				</RoomType>
			</RoomTypes>',
			$twoRoomType
		];

		$supplier = new Supplier(
			6,
			'RMI'
		);

		yield [
			'<Supplier>
				<SupplierID>6</SupplierID>
				<SupplierName>RMI</SupplierName>
			</Supplier>',
			$supplier
		];

		$erratum = new Erratum(
			'2020-08-04',
			'2020-08-11',
			'Small pool will be closed for maintenance'
		);

		yield [
			'<Erratum>
				<StartDate>2020-08-04</StartDate>
				<EndDate>2020-08-11</EndDate>
				<Description>Small pool will be closed for maintenance</Description>
			</Erratum>',
			$erratum
		];

		$oneErratum = new Errata($erratum);

		yield [
			'<Errata>
				<Erratum>
					<StartDate>2020-08-04</StartDate>
					<EndDate>2020-08-11</EndDate>
					<Description>Small pool will be closed for maintenance</Description>
				</Erratum>
			</Errata>',
			$oneErratum
		];

		$twoErrata = new Errata(
			$erratum,
			new Erratum(
				'2020-08-04',
				'2020-08-11',
				'There won\'t be mayonese at the restaurant'
			)
		);

		yield [
			'<Errata>
				<Erratum>
					<StartDate>2020-08-04</StartDate>
					<EndDate>2020-08-11</EndDate>
					<Description>Small pool will be closed for maintenance</Description>
				</Erratum>
				<Erratum>
					<StartDate>2020-08-04</StartDate>
					<EndDate>2020-08-11</EndDate>
					<Description>There won\'t be mayonese at the restaurant</Description>
				</Erratum>
			</Errata>',
			$twoErrata
		];

		$image1000 = new Image(
			'CMSImage_1000.jpg',
			'CMSImageThumb_1000.jpg'
		);

		yield [
			'<Image>
				<FullSize>CMSImage_1000.jpg</FullSize>
				<Thumbnail>CMSImageThumb_1000.jpg</Thumbnail>
			</Image>',
			$image1000
		];

		$oneImage = new Images($image1000);

		yield [
			'<Images>
				<Image>
					<FullSize>CMSImage_1000.jpg</FullSize>
					<Thumbnail>CMSImageThumb_1000.jpg</Thumbnail>
				</Image>
			</Images>',
			$oneImage
		];

		$twoImages = new Images(
			$image1000,
			new Image(
				'CMSImage_1001.jpg',
				'CMSImageThumb_1001.jpg'
			)
		);

		yield [
			'<Images>
				<Image>
					<FullSize>CMSImage_1000.jpg</FullSize>
					<Thumbnail>CMSImageThumb_1000.jpg</Thumbnail>
				</Image>
				<Image>
					<FullSize>CMSImage_1001.jpg</FullSize>
					<Thumbnail>CMSImageThumb_1001.jpg</Thumbnail>
				</Image>
			</Images>',
			$twoImages
		];

		$propertyResult = new PropertyResult(
			99,
			$twoRoomType,
			'Example Island',
			99999,
			'USD',
			4.5,
			6,
			10,
			22,
			'West Indies',
			'St Vincent & Grenadines',
			'Example Island',
			null,
			null,
			null,
			null,
			null,
			null,
			'Intimate, exotic and all-inclusive',
			'Example Island, a high-end luxury resort',
			'https://xmlhost/custom/content/',
			'CMSImage_999.jpg',
			'CMSImageThumb_999.jpg',
			$twoImages,
			$oneErratum,
			$supplier
		);

		yield [
			'<PropertyResult>
				<PropertyID>99</PropertyID>
				<RoomTypes>
					<RoomType>
						<RoomID>999</RoomID>
						<PropertyRoomTypeID>1</PropertyRoomTypeID>
						<MealBasisID>1</MealBasisID>
						<Name>Example Villa</Name>
						<View>Sea View</View>
						<Adults>2</Adults>
						<Children>2</Children>
						<Infants>1</Infants>
						<OnRequest>True</OnRequest>
						<SubTotal>5896.8</SubTotal>
						<Total>6565.35</Total>
						<RoomsAppliesTo>
							<RoomRequest>1</RoomRequest>
						</RoomsAppliesTo>
						<Supplements>
							<Supplement>
								<Name>test supplement</Name>
								<Duration>Per Night</Duration>
								<Multiplier>Per Person</Multiplier>
								<Total>220</Total>
								<PaxType>Adult Only</PaxType>
							</Supplement>
						</Supplements>
						<SpecialOffers>
							<SpecialOffer>
								<Name>Example special offer</Name>
								<Type>Value Added</Type>
								<Desc>test desc</Desc>
							</SpecialOffer>
							<SpecialOffer>
								<Name>Example special offer 2</Name>
								<Type>Free Kids</Type>
								<Value>1</Value>
								<Total>1000</Total>
								<Desc>test desc</Desc>
							</SpecialOffer>
						</SpecialOffers>
						<Taxes>
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
						</Taxes>
						<CancellationPolicies>
							<CancellationPolicy>
								<CancelBy>2020-07-11</CancelBy>
								<Penalty>574.28</Penalty>
							</CancellationPolicy>
							<CancellationPolicy>
								<CancelBy>2020-07-18</CancelBy>
								<Penalty>1148.55</Penalty>
							</CancellationPolicy>
						</CancellationPolicies>
					</RoomType>
					<RoomType>
						<RoomID>998</RoomID>
						<MealBasisID>1</MealBasisID>
						<Name>Example Villa</Name>
						<View>Sea View</View>
						<Adults>2</Adults>
						<Children>0</Children>
						<Infants>0</Infants>
						<OnRequest>True</OnRequest>
						<SubTotal>3960</SubTotal>
						<Total>4400</Total>
						<RoomsAppliesTo>
							<RoomRequest>2</RoomRequest>
						</RoomsAppliesTo>
						<SpecialOffers>
							<SpecialOffer>
								<Name>Early Bird Booking</Name>
								<Type>Adult Only</Type>
								<Value>10</Value>
								<PaxType>All</PaxType>
								<Total>440</Total>
							</SpecialOffer>
						</SpecialOffers>
						<Taxes>
							<Tax>
								<TaxName>Government Tax</TaxName>
								<Inclusive>True</Inclusive>
								<Total>423.15</Total>
							</Tax>
						</Taxes>
						<CancellationPolicies>
							<CancellationPolicy>
								<CancelBy>2020-07-18</CancelBy>
								<Penalty>440</Penalty>
							</CancellationPolicy>
						</CancellationPolicies>
					</RoomType>
				</RoomTypes>
				<PropertyName>Example Island</PropertyName>
				<GIATAID>99999</GIATAID>
				<Currency>USD</Currency>
				<Rating>4.5</Rating>
				<GeographyLevel1ID>6</GeographyLevel1ID>
				<GeographyLevel2ID>10</GeographyLevel2ID>
				<GeographyLevel3ID>22</GeographyLevel3ID>
				<Country>West Indies</Country>
				<Area>St Vincent &amp; Grenadines</Area>
				<Region>Example Island</Region>
				<Strapline>Intimate, exotic and all-inclusive</Strapline>
				<Description>Example Island, a high-end luxury resort</Description>
				<CMSBaseURL>https://xmlhost/custom/content/</CMSBaseURL>
				<MainImage>CMSImage_999.jpg</MainImage>
				<MainImageThumbnail>CMSImageThumb_999.jpg</MainImageThumbnail>
				<Images>
					<Image>
						<FullSize>CMSImage_1000.jpg</FullSize>
						<Thumbnail>CMSImageThumb_1000.jpg</Thumbnail>
					</Image>
					<Image>
						<FullSize>CMSImage_1001.jpg</FullSize>
						<Thumbnail>CMSImageThumb_1001.jpg</Thumbnail>
					</Image>
				</Images>
				<Errata>
					<Erratum>
						<StartDate>2020-08-04</StartDate>
						<EndDate>2020-08-11</EndDate>
						<Description>Small pool will be closed for maintenance</Description>
					</Erratum>
				</Errata>
				<Supplier>
					<SupplierID>6</SupplierID>
					<SupplierName>RMI</SupplierName>
				</Supplier>
			</PropertyResult>',
			$propertyResult
		];

		$onePropertyResult = PropertyResults::fromPropertyResults($propertyResult);

		yield [
			'<PropertyResults>
				<TotalProperties>1</TotalProperties>
				<PropertyResult>
					<PropertyID>99</PropertyID>
					<RoomTypes>
						<RoomType>
							<RoomID>999</RoomID>
							<PropertyRoomTypeID>1</PropertyRoomTypeID>
							<MealBasisID>1</MealBasisID>
							<Name>Example Villa</Name>
							<View>Sea View</View>
							<Adults>2</Adults>
							<Children>2</Children>
							<Infants>1</Infants>
							<OnRequest>True</OnRequest>
							<SubTotal>5896.8</SubTotal>
							<Total>6565.35</Total>
							<RoomsAppliesTo>
								<RoomRequest>1</RoomRequest>
							</RoomsAppliesTo>
							<Supplements>
								<Supplement>
									<Name>test supplement</Name>
									<Duration>Per Night</Duration>
									<Multiplier>Per Person</Multiplier>
									<Total>220</Total>
									<PaxType>Adult Only</PaxType>
								</Supplement>
							</Supplements>
							<SpecialOffers>
								<SpecialOffer>
									<Name>Example special offer</Name>
									<Type>Value Added</Type>
									<Desc>test desc</Desc>
								</SpecialOffer>
								<SpecialOffer>
									<Name>Example special offer 2</Name>
									<Type>Free Kids</Type>
									<Value>1</Value>
									<Total>1000</Total>
									<Desc>test desc</Desc>
								</SpecialOffer>
							</SpecialOffers>
							<Taxes>
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
							</Taxes>
							<CancellationPolicies>
								<CancellationPolicy>
									<CancelBy>2020-07-11</CancelBy>
									<Penalty>574.28</Penalty>
								</CancellationPolicy>
								<CancellationPolicy>
									<CancelBy>2020-07-18</CancelBy>
									<Penalty>1148.55</Penalty>
								</CancellationPolicy>
							</CancellationPolicies>
						</RoomType>
						<RoomType>
							<RoomID>998</RoomID>
							<MealBasisID>1</MealBasisID>
							<Name>Example Villa</Name>
							<View>Sea View</View>
							<Adults>2</Adults>
							<Children>0</Children>
							<Infants>0</Infants>
							<OnRequest>True</OnRequest>
							<SubTotal>3960</SubTotal>
							<Total>4400</Total>
							<RoomsAppliesTo>
								<RoomRequest>2</RoomRequest>
							</RoomsAppliesTo>
							<SpecialOffers>
								<SpecialOffer>
									<Name>Early Bird Booking</Name>
									<Type>Adult Only</Type>
									<Value>10</Value>
									<PaxType>All</PaxType>
									<Total>440</Total>
								</SpecialOffer>
							</SpecialOffers>
							<Taxes>
								<Tax>
									<TaxName>Government Tax</TaxName>
									<Inclusive>True</Inclusive>
									<Total>423.15</Total>
								</Tax>
							</Taxes>
							<CancellationPolicies>
								<CancellationPolicy>
									<CancelBy>2020-07-18</CancelBy>
									<Penalty>440</Penalty>
								</CancellationPolicy>
							</CancellationPolicies>
						</RoomType>
					</RoomTypes>
					<PropertyName>Example Island</PropertyName>
					<GIATAID>99999</GIATAID>
					<Currency>USD</Currency>
					<Rating>4.5</Rating>
					<GeographyLevel1ID>6</GeographyLevel1ID>
					<GeographyLevel2ID>10</GeographyLevel2ID>
					<GeographyLevel3ID>22</GeographyLevel3ID>
					<Country>West Indies</Country>
					<Area>St Vincent &amp; Grenadines</Area>
					<Region>Example Island</Region>
					<Strapline>Intimate, exotic and all-inclusive</Strapline>
					<Description>Example Island, a high-end luxury resort</Description>
					<CMSBaseURL>https://xmlhost/custom/content/</CMSBaseURL>
					<MainImage>CMSImage_999.jpg</MainImage>
					<MainImageThumbnail>CMSImageThumb_999.jpg</MainImageThumbnail>
					<Images>
						<Image>
							<FullSize>CMSImage_1000.jpg</FullSize>
							<Thumbnail>CMSImageThumb_1000.jpg</Thumbnail>
						</Image>
						<Image>
							<FullSize>CMSImage_1001.jpg</FullSize>
							<Thumbnail>CMSImageThumb_1001.jpg</Thumbnail>
						</Image>
					</Images>
					<Errata>
						<Erratum>
							<StartDate>2020-08-04</StartDate>
							<EndDate>2020-08-11</EndDate>
							<Description>Small pool will be closed for maintenance</Description>
						</Erratum>
					</Errata>
					<Supplier>
						<SupplierID>6</SupplierID>
						<SupplierName>RMI</SupplierName>
					</Supplier>
				</PropertyResult>
			</PropertyResults>',
			$onePropertyResult
		];

		yield [
			'<PropertyResults>
				<TotalProperties>2</TotalProperties>
				<PropertyResult>
					<PropertyID>99</PropertyID>
					<RoomTypes>
						<RoomType>
							<RoomID>999</RoomID>
							<PropertyRoomTypeID>1</PropertyRoomTypeID>
							<MealBasisID>1</MealBasisID>
							<Name>Example Villa</Name>
							<View>Sea View</View>
							<Adults>2</Adults>
							<Children>2</Children>
							<Infants>1</Infants>
							<OnRequest>True</OnRequest>
							<SubTotal>5896.8</SubTotal>
							<Total>6565.35</Total>
							<RoomsAppliesTo>
								<RoomRequest>1</RoomRequest>
							</RoomsAppliesTo>
							<Supplements>
								<Supplement>
									<Name>test supplement</Name>
									<Duration>Per Night</Duration>
									<Multiplier>Per Person</Multiplier>
									<Total>220</Total>
									<PaxType>Adult Only</PaxType>
								</Supplement>
							</Supplements>
							<SpecialOffers>
								<SpecialOffer>
									<Name>Example special offer</Name>
									<Type>Value Added</Type>
									<Desc>test desc</Desc>
								</SpecialOffer>
								<SpecialOffer>
									<Name>Example special offer 2</Name>
									<Type>Free Kids</Type>
									<Value>1</Value>
									<Total>1000</Total>
									<Desc>test desc</Desc>
								</SpecialOffer>
							</SpecialOffers>
							<Taxes>
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
							</Taxes>
							<CancellationPolicies>
								<CancellationPolicy>
									<CancelBy>2020-07-11</CancelBy>
									<Penalty>574.28</Penalty>
								</CancellationPolicy>
								<CancellationPolicy>
									<CancelBy>2020-07-18</CancelBy>
									<Penalty>1148.55</Penalty>
								</CancellationPolicy>
							</CancellationPolicies>
						</RoomType>
						<RoomType>
							<RoomID>998</RoomID>
							<MealBasisID>1</MealBasisID>
							<Name>Example Villa</Name>
							<View>Sea View</View>
							<Adults>2</Adults>
							<Children>0</Children>
							<Infants>0</Infants>
							<OnRequest>True</OnRequest>
							<SubTotal>3960</SubTotal>
							<Total>4400</Total>
							<RoomsAppliesTo>
								<RoomRequest>2</RoomRequest>
							</RoomsAppliesTo>
							<SpecialOffers>
								<SpecialOffer>
									<Name>Early Bird Booking</Name>
									<Type>Adult Only</Type>
									<Value>10</Value>
									<PaxType>All</PaxType>
									<Total>440</Total>
								</SpecialOffer>
							</SpecialOffers>
							<Taxes>
								<Tax>
									<TaxName>Government Tax</TaxName>
									<Inclusive>True</Inclusive>
									<Total>423.15</Total>
								</Tax>
							</Taxes>
							<CancellationPolicies>
								<CancellationPolicy>
									<CancelBy>2020-07-18</CancelBy>
									<Penalty>440</Penalty>
								</CancellationPolicy>
							</CancellationPolicies>
						</RoomType>
					</RoomTypes>
					<PropertyName>Example Island</PropertyName>
					<GIATAID>99999</GIATAID>
					<Currency>USD</Currency>
					<Rating>4.5</Rating>
					<GeographyLevel1ID>6</GeographyLevel1ID>
					<GeographyLevel2ID>10</GeographyLevel2ID>
					<GeographyLevel3ID>22</GeographyLevel3ID>
					<Country>West Indies</Country>
					<Area>St Vincent &amp; Grenadines</Area>
					<Region>Example Island</Region>
					<Strapline>Intimate, exotic and all-inclusive</Strapline>
					<Description>Example Island, a high-end luxury resort</Description>
					<CMSBaseURL>https://xmlhost/custom/content/</CMSBaseURL>
					<MainImage>CMSImage_999.jpg</MainImage>
					<MainImageThumbnail>CMSImageThumb_999.jpg</MainImageThumbnail>
					<Images>
						<Image>
							<FullSize>CMSImage_1000.jpg</FullSize>
							<Thumbnail>CMSImageThumb_1000.jpg</Thumbnail>
						</Image>
						<Image>
							<FullSize>CMSImage_1001.jpg</FullSize>
							<Thumbnail>CMSImageThumb_1001.jpg</Thumbnail>
						</Image>
					</Images>
					<Errata>
						<Erratum>
							<StartDate>2020-08-04</StartDate>
							<EndDate>2020-08-11</EndDate>
							<Description>Small pool will be closed for maintenance</Description>
						</Erratum>
					</Errata>
					<Supplier>
						<SupplierID>6</SupplierID>
						<SupplierName>RMI</SupplierName>
					</Supplier>
				</PropertyResult>
				<PropertyResult>
					<PropertyID>99</PropertyID>
					<RoomTypes>
						<RoomType>
							<RoomID>999</RoomID>
							<PropertyRoomTypeID>1</PropertyRoomTypeID>
							<MealBasisID>1</MealBasisID>
							<Name>Example Villa</Name>
							<View>Sea View</View>
							<Adults>2</Adults>
							<Children>2</Children>
							<Infants>1</Infants>
							<OnRequest>True</OnRequest>
							<SubTotal>5896.8</SubTotal>
							<Total>6565.35</Total>
							<RoomsAppliesTo>
								<RoomRequest>1</RoomRequest>
							</RoomsAppliesTo>
							<Supplements>
								<Supplement>
									<Name>test supplement</Name>
									<Duration>Per Night</Duration>
									<Multiplier>Per Person</Multiplier>
									<Total>220</Total>
									<PaxType>Adult Only</PaxType>
								</Supplement>
							</Supplements>
							<SpecialOffers>
								<SpecialOffer>
									<Name>Example special offer</Name>
									<Type>Value Added</Type>
									<Desc>test desc</Desc>
								</SpecialOffer>
								<SpecialOffer>
									<Name>Example special offer 2</Name>
									<Type>Free Kids</Type>
									<Value>1</Value>
									<Total>1000</Total>
									<Desc>test desc</Desc>
								</SpecialOffer>
							</SpecialOffers>
							<Taxes>
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
							</Taxes>
							<CancellationPolicies>
								<CancellationPolicy>
									<CancelBy>2020-07-11</CancelBy>
									<Penalty>574.28</Penalty>
								</CancellationPolicy>
								<CancellationPolicy>
									<CancelBy>2020-07-18</CancelBy>
									<Penalty>1148.55</Penalty>
								</CancellationPolicy>
							</CancellationPolicies>
						</RoomType>
						<RoomType>
							<RoomID>998</RoomID>
							<MealBasisID>1</MealBasisID>
							<Name>Example Villa</Name>
							<View>Sea View</View>
							<Adults>2</Adults>
							<Children>0</Children>
							<Infants>0</Infants>
							<OnRequest>True</OnRequest>
							<SubTotal>3960</SubTotal>
							<Total>4400</Total>
							<RoomsAppliesTo>
								<RoomRequest>2</RoomRequest>
							</RoomsAppliesTo>
							<SpecialOffers>
								<SpecialOffer>
									<Name>Early Bird Booking</Name>
									<Type>Adult Only</Type>
									<Value>10</Value>
									<PaxType>All</PaxType>
									<Total>440</Total>
								</SpecialOffer>
							</SpecialOffers>
							<Taxes>
								<Tax>
									<TaxName>Government Tax</TaxName>
									<Inclusive>True</Inclusive>
									<Total>423.15</Total>
								</Tax>
							</Taxes>
							<CancellationPolicies>
								<CancellationPolicy>
									<CancelBy>2020-07-18</CancelBy>
									<Penalty>440</Penalty>
								</CancellationPolicy>
							</CancellationPolicies>
						</RoomType>
					</RoomTypes>
					<PropertyName>Example Island</PropertyName>
					<GIATAID>99999</GIATAID>
					<Currency>USD</Currency>
					<Rating>4.5</Rating>
					<GeographyLevel1ID>6</GeographyLevel1ID>
					<GeographyLevel2ID>10</GeographyLevel2ID>
					<GeographyLevel3ID>22</GeographyLevel3ID>
					<Country>West Indies</Country>
					<Area>St Vincent &amp; Grenadines</Area>
					<Region>Example Island</Region>
					<Strapline>Intimate, exotic and all-inclusive</Strapline>
					<Description>Example Island, a high-end luxury resort</Description>
					<CMSBaseURL>https://xmlhost/custom/content/</CMSBaseURL>
					<MainImage>CMSImage_999.jpg</MainImage>
					<MainImageThumbnail>CMSImageThumb_999.jpg</MainImageThumbnail>
					<Images>
						<Image>
							<FullSize>CMSImage_1000.jpg</FullSize>
							<Thumbnail>CMSImageThumb_1000.jpg</Thumbnail>
						</Image>
						<Image>
							<FullSize>CMSImage_1001.jpg</FullSize>
							<Thumbnail>CMSImageThumb_1001.jpg</Thumbnail>
						</Image>
					</Images>
					<Errata>
						<Erratum>
							<StartDate>2020-08-04</StartDate>
							<EndDate>2020-08-11</EndDate>
							<Description>Small pool will be closed for maintenance</Description>
						</Erratum>
					</Errata>
					<Supplier>
						<SupplierID>6</SupplierID>
						<SupplierName>RMI</SupplierName>
					</Supplier>
				</PropertyResult>
			</PropertyResults>',
			PropertyResults::fromPropertyResults(
				$propertyResult,
				$propertyResult
			)
		];

		yield [
			'<SearchResponse>
				<RequestInfo>
					<Timestamp>1687253937</Timestamp>
					<TimestampISO>2023-06-20T09:38:57+00:00</TimestampISO>
					<Host>xml.centriumres.com.localdomain.ee</Host>
					<HostIP>10.0.1.182</HostIP>
					<ReqID>649173b14aadb8.17864349</ReqID>
				</RequestInfo>
				<ReturnStatus>
					<Success>True</Success>
				</ReturnStatus>
				<PropertyResults>
					<TotalProperties>1</TotalProperties>
					<PropertyResult>
						<PropertyID>99</PropertyID>
						<RoomTypes>
							<RoomType>
								<RoomID>999</RoomID>
								<PropertyRoomTypeID>1</PropertyRoomTypeID>
								<MealBasisID>1</MealBasisID>
								<Name>Example Villa</Name>
								<View>Sea View</View>
								<Adults>2</Adults>
								<Children>2</Children>
								<Infants>1</Infants>
								<OnRequest>True</OnRequest>
								<SubTotal>5896.8</SubTotal>
								<Total>6565.35</Total>
								<RoomsAppliesTo>
									<RoomRequest>1</RoomRequest>
								</RoomsAppliesTo>
								<Supplements>
									<Supplement>
										<Name>test supplement</Name>
										<Duration>Per Night</Duration>
										<Multiplier>Per Person</Multiplier>
										<Total>220</Total>
										<PaxType>Adult Only</PaxType>
									</Supplement>
								</Supplements>
								<SpecialOffers>
									<SpecialOffer>
										<Name>Example special offer</Name>
										<Type>Value Added</Type>
										<Desc>test desc</Desc>
									</SpecialOffer>
									<SpecialOffer>
										<Name>Example special offer 2</Name>
										<Type>Free Kids</Type>
										<Value>1</Value>
										<Total>1000</Total>
										<Desc>test desc</Desc>
									</SpecialOffer>
								</SpecialOffers>
								<Taxes>
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
								</Taxes>
								<CancellationPolicies>
									<CancellationPolicy>
										<CancelBy>2020-07-11</CancelBy>
										<Penalty>574.28</Penalty>
									</CancellationPolicy>
									<CancellationPolicy>
										<CancelBy>2020-07-18</CancelBy>
										<Penalty>1148.55</Penalty>
									</CancellationPolicy>
								</CancellationPolicies>
							</RoomType>
							<RoomType>
								<RoomID>998</RoomID>
								<MealBasisID>1</MealBasisID>
								<Name>Example Villa</Name>
								<View>Sea View</View>
								<Adults>2</Adults>
								<Children>0</Children>
								<Infants>0</Infants>
								<OnRequest>True</OnRequest>
								<SubTotal>3960</SubTotal>
								<Total>4400</Total>
								<RoomsAppliesTo>
									<RoomRequest>2</RoomRequest>
								</RoomsAppliesTo>
								<SpecialOffers>
									<SpecialOffer>
										<Name>Early Bird Booking</Name>
										<Type>Adult Only</Type>
										<Value>10</Value>
										<PaxType>All</PaxType>
										<Total>440</Total>
									</SpecialOffer>
								</SpecialOffers>
								<Taxes>
									<Tax>
										<TaxName>Government Tax</TaxName>
										<Inclusive>True</Inclusive>
										<Total>423.15</Total>
									</Tax>
								</Taxes>
								<CancellationPolicies>
									<CancellationPolicy>
										<CancelBy>2020-07-18</CancelBy>
										<Penalty>440</Penalty>
									</CancellationPolicy>
								</CancellationPolicies>
							</RoomType>
						</RoomTypes>
						<PropertyName>Example Island</PropertyName>
						<GIATAID>99999</GIATAID>
						<Currency>USD</Currency>
						<Rating>4.5</Rating>
						<GeographyLevel1ID>6</GeographyLevel1ID>
						<GeographyLevel2ID>10</GeographyLevel2ID>
						<GeographyLevel3ID>22</GeographyLevel3ID>
						<Country>West Indies</Country>
						<Area>St Vincent &amp; Grenadines</Area>
						<Region>Example Island</Region>
						<Strapline>Intimate, exotic and all-inclusive</Strapline>
						<Description>Example Island, a high-end luxury resort</Description>
						<CMSBaseURL>https://xmlhost/custom/content/</CMSBaseURL>
						<MainImage>CMSImage_999.jpg</MainImage>
						<MainImageThumbnail>CMSImageThumb_999.jpg</MainImageThumbnail>
						<Images>
							<Image>
								<FullSize>CMSImage_1000.jpg</FullSize>
								<Thumbnail>CMSImageThumb_1000.jpg</Thumbnail>
							</Image>
							<Image>
								<FullSize>CMSImage_1001.jpg</FullSize>
								<Thumbnail>CMSImageThumb_1001.jpg</Thumbnail>
							</Image>
						</Images>
						<Errata>
							<Erratum>
								<StartDate>2020-08-04</StartDate>
								<EndDate>2020-08-11</EndDate>
								<Description>Small pool will be closed for maintenance</Description>
							</Erratum>
						</Errata>
						<Supplier>
							<SupplierID>6</SupplierID>
							<SupplierName>RMI</SupplierName>
						</Supplier>
					</PropertyResult>
				</PropertyResults>
			</SearchResponse>',
			new SearchResponse(
				$requestInfo,
				$returnStatusTrue,
				$onePropertyResult
			)
		];

		$simpleLeadGuestBook = new LeadGuest(
			'Jim',
			'Watsworth',
			'Mr'
		);

		yield [
			'<LeadGuest>
				<FirstName>Jim</FirstName>
				<LastName>Watsworth</LastName>
				<Title>Mr</Title>
			</LeadGuest>',
			$simpleLeadGuestBook
		];

		$leadGuestBook = new LeadGuest(
			'Jim',
			'Watsworth',
			'Mr',
			'Address line 1',
			null,
			'London',
			null,
			null,
			null,
			'email@example.com'
		);

		yield [
			'<LeadGuest>
				<FirstName>Jim</FirstName>
				<LastName>Watsworth</LastName>
				<Title>Mr</Title>
				<Address1>Address line 1</Address1>
				<TownCity>London</TownCity>
				<Email>email@example.com</Email>
			</LeadGuest>',
			$leadGuestBook
		];

		$adultGuestBook = new Guest(
			'Adult',
			'Sally',
			'Smith',
			'Mrs',
			null,
			'French'
		);
		yield [
			'<Guest>
				<Type>Adult</Type>
				<FirstName>Sally</FirstName>
				<LastName>Smith</LastName>
				<Title>Mrs</Title>
				<Nationality>French</Nationality>
			</Guest>',
			$adultGuestBook
		];

		$childGuestBook = new Guest(
			'Child',
			'Jimmy',
			'Smith',
			null,
			5,
			'French'
		);

		yield [
			'<Guest>
				<Type>Child</Type>
				<FirstName>Jimmy</FirstName>
				<LastName>Smith</LastName>
				<Age>5</Age>
				<Nationality>French</Nationality>
			</Guest>',
			$childGuestBook
		];

		$oneGuest = new Guests($adultGuestBook);
		yield [
			'<Guests>
				<Guest>
					<Type>Adult</Type>
					<FirstName>Sally</FirstName>
					<LastName>Smith</LastName>
					<Title>Mrs</Title>
					<Nationality>French</Nationality>
				</Guest>
			</Guests>',
			$oneGuest
		];

		$twoGuests = new Guests(
			$adultGuestBook,
			$childGuestBook
		);

		yield [
			'<Guests>
				<Guest>
					<Type>Adult</Type>
					<FirstName>Sally</FirstName>
					<LastName>Smith</LastName>
					<Title>Mrs</Title>
					<Nationality>French</Nationality>
				</Guest>
				<Guest>
					<Type>Child</Type>
					<FirstName>Jimmy</FirstName>
					<LastName>Smith</LastName>
					<Age>5</Age>
					<Nationality>French</Nationality>
				</Guest>
			</Guests>',
			$twoGuests
		];

		$roomBookingOneAdult = new RoomBooking(
			155558,
			1,
			1,
			0,
			0,
			$oneGuest
		);

		yield [
			'<RoomBooking>
				<RoomID>155558</RoomID>
				<MealBasisID>1</MealBasisID>
				<Adults>1</Adults>
				<Children>0</Children>
				<Infants>0</Infants>
				<Guests>
					<Guest>
						<Type>Adult</Type>
						<FirstName>Sally</FirstName>
						<LastName>Smith</LastName>
						<Title>Mrs</Title>
						<Nationality>French</Nationality>
					</Guest>
				</Guests>
			</RoomBooking>',
			$roomBookingOneAdult
		];

		$roomBookingOneAdultOnly = new RoomBooking(
			155558,
			1,
			1,
			0,
			0
		);

		yield [
			'<RoomBooking>
				<RoomID>155558</RoomID>
				<MealBasisID>1</MealBasisID>
				<Adults>1</Adults>
				<Children>0</Children>
				<Infants>0</Infants>
				<Guests/>
			</RoomBooking>',
			$roomBookingOneAdultOnly
		];

		$roomBookingTwoAdults = new RoomBooking(
			155558,
			1,
			2,
			0,
			0,
			$oneGuest
		);

		yield [
			'<RoomBooking>
				<RoomID>155558</RoomID>
				<MealBasisID>1</MealBasisID>
				<Adults>2</Adults>
				<Children>0</Children>
				<Infants>0</Infants>
				<Guests>
					<Guest>
						<Type>Adult</Type>
						<FirstName>Sally</FirstName>
						<LastName>Smith</LastName>
						<Title>Mrs</Title>
						<Nationality>French</Nationality>
					</Guest>
				</Guests>
			</RoomBooking>',
			$roomBookingTwoAdults
		];

		$roomBookingAdultAndChild = new RoomBooking(
			155448,
			1,
			1,
			1,
			0,
			$twoGuests
		);

		yield [
			'<RoomBooking>
				<RoomID>155448</RoomID>
				<MealBasisID>1</MealBasisID>
				<Adults>1</Adults>
				<Children>1</Children>
				<Infants>0</Infants>
				<Guests>
					<Guest>
						<Type>Adult</Type>
						<FirstName>Sally</FirstName>
						<LastName>Smith</LastName>
						<Title>Mrs</Title>
						<Nationality>French</Nationality>
					</Guest>
					<Guest>
						<Type>Child</Type>
						<FirstName>Jimmy</FirstName>
						<LastName>Smith</LastName>
						<Age>5</Age>
						<Nationality>French</Nationality>
					</Guest>
				</Guests>
			</RoomBooking>',
			$roomBookingAdultAndChild
		];

		$oneRoomBookings = new RoomBookings(
			$roomBookingAdultAndChild
		);

		yield [
			'<RoomBookings>
				<RoomBooking>
					<RoomID>155448</RoomID>
					<MealBasisID>1</MealBasisID>
					<Adults>1</Adults>
					<Children>1</Children>
					<Infants>0</Infants>
					<Guests>
						<Guest>
							<Type>Adult</Type>
							<FirstName>Sally</FirstName>
							<LastName>Smith</LastName>
							<Title>Mrs</Title>
							<Nationality>French</Nationality>
						</Guest>
						<Guest>
							<Type>Child</Type>
							<FirstName>Jimmy</FirstName>
							<LastName>Smith</LastName>
							<Age>5</Age>
							<Nationality>French</Nationality>
						</Guest>
					</Guests>
				</RoomBooking>
			</RoomBookings>',
			$oneRoomBookings
		];

		$twoRoomBookings = new RoomBookings(
			$roomBookingAdultAndChild,
			$roomBookingOneAdult
		);

		yield [
			'<RoomBookings>
				<RoomBooking>
					<RoomID>155448</RoomID>
					<MealBasisID>1</MealBasisID>
					<Adults>1</Adults>
					<Children>1</Children>
					<Infants>0</Infants>
					<Guests>
						<Guest>
							<Type>Adult</Type>
							<FirstName>Sally</FirstName>
							<LastName>Smith</LastName>
							<Title>Mrs</Title>
							<Nationality>French</Nationality>
						</Guest>
						<Guest>
							<Type>Child</Type>
							<FirstName>Jimmy</FirstName>
							<LastName>Smith</LastName>
							<Age>5</Age>
							<Nationality>French</Nationality>
						</Guest>
					</Guests>
				</RoomBooking>
				<RoomBooking>
					<RoomID>155558</RoomID>
					<MealBasisID>1</MealBasisID>
					<Adults>1</Adults>
					<Children>0</Children>
					<Infants>0</Infants>
					<Guests>
						<Guest>
							<Type>Adult</Type>
							<FirstName>Sally</FirstName>
							<LastName>Smith</LastName>
							<Title>Mrs</Title>
							<Nationality>French</Nationality>
						</Guest>
					</Guests>
				</RoomBooking>
			</RoomBookings>',
			$twoRoomBookings
		];

		yield [
			'<BookDetails>
				<ArrivalDate>2023-11-01</ArrivalDate>
				<Duration>5</Duration>
				<TradeReference>TEST_REF</TradeReference>
				<TotalPrice>1040</TotalPrice>
				<LeadGuest>
					<FirstName>Jim</FirstName>
					<LastName>Watsworth</LastName>
					<Title>Mr</Title>
				</LeadGuest>
				<RoomBookings>
					<RoomBooking>
						<RoomID>155558</RoomID>
						<MealBasisID>1</MealBasisID>
						<Adults>2</Adults>
						<Children>0</Children>
						<Infants>0</Infants>
						<Guests>
							<Guest>
								<Type>Adult</Type>
								<FirstName>Sally</FirstName>
								<LastName>Smith</LastName>
								<Title>Mrs</Title>
								<Nationality>French</Nationality>
							</Guest>
						</Guests>
					</RoomBooking>
				</RoomBookings>
			</BookDetails>',
			new BookDetails(
				'2023-11-01',
				5,
				'TEST_REF',
				1040,
				$simpleLeadGuestBook,
				new RoomBookings($roomBookingTwoAdults)
			)
		];

		$twoRoomBookingDetails = new BookDetails(
			'2023-11-01',
			5,
			'TEST_REF',
			1040,
			$simpleLeadGuestBook,
			$twoRoomBookings
		);

		yield [
			'<BookDetails>
				<ArrivalDate>2023-11-01</ArrivalDate>
				<Duration>5</Duration>
				<TradeReference>TEST_REF</TradeReference>
				<TotalPrice>1040</TotalPrice>
				<LeadGuest>
					<FirstName>Jim</FirstName>
					<LastName>Watsworth</LastName>
					<Title>Mr</Title>
				</LeadGuest>
				<RoomBookings>
					<RoomBooking>
						<RoomID>155448</RoomID>
						<MealBasisID>1</MealBasisID>
						<Adults>1</Adults>
						<Children>1</Children>
						<Infants>0</Infants>
						<Guests>
							<Guest>
								<Type>Adult</Type>
								<FirstName>Sally</FirstName>
								<LastName>Smith</LastName>
								<Title>Mrs</Title>
								<Nationality>French</Nationality>
							</Guest>
							<Guest>
								<Type>Child</Type>
								<FirstName>Jimmy</FirstName>
								<LastName>Smith</LastName>
								<Age>5</Age>
								<Nationality>French</Nationality>
							</Guest>
						</Guests>
					</RoomBooking>
					<RoomBooking>
						<RoomID>155558</RoomID>
						<MealBasisID>1</MealBasisID>
						<Adults>1</Adults>
						<Children>0</Children>
						<Infants>0</Infants>
						<Guests>
							<Guest>
								<Type>Adult</Type>
								<FirstName>Sally</FirstName>
								<LastName>Smith</LastName>
								<Title>Mrs</Title>
								<Nationality>French</Nationality>
							</Guest>
						</Guests>
					</RoomBooking>
				</RoomBookings>
			</BookDetails>',
			$twoRoomBookingDetails
		];

		yield [
			'<BookRequest>
				<LoginDetails>
					<Login>login</Login>
					<Password>pass</Password>
					<Version>version</Version>
				</LoginDetails>
				<Mock>True</Mock>
				<BookDetails>
					<ArrivalDate>2023-11-01</ArrivalDate>
					<Duration>5</Duration>
					<TradeReference>TEST_REF</TradeReference>
					<TotalPrice>1040</TotalPrice>
					<LeadGuest>
						<FirstName>Jim</FirstName>
						<LastName>Watsworth</LastName>
						<Title>Mr</Title>
					</LeadGuest>
					<RoomBookings>
						<RoomBooking>
							<RoomID>155448</RoomID>
							<MealBasisID>1</MealBasisID>
							<Adults>1</Adults>
							<Children>1</Children>
							<Infants>0</Infants>
							<Guests>
								<Guest>
									<Type>Adult</Type>
									<FirstName>Sally</FirstName>
									<LastName>Smith</LastName>
									<Title>Mrs</Title>
									<Nationality>French</Nationality>
								</Guest>
								<Guest>
									<Type>Child</Type>
									<FirstName>Jimmy</FirstName>
									<LastName>Smith</LastName>
									<Age>5</Age>
									<Nationality>French</Nationality>
								</Guest>
							</Guests>
						</RoomBooking>
						<RoomBooking>
							<RoomID>155558</RoomID>
							<MealBasisID>1</MealBasisID>
							<Adults>1</Adults>
							<Children>0</Children>
							<Infants>0</Infants>
							<Guests>
								<Guest>
									<Type>Adult</Type>
									<FirstName>Sally</FirstName>
									<LastName>Smith</LastName>
									<Title>Mrs</Title>
									<Nationality>French</Nationality>
								</Guest>
							</Guests>
						</RoomBooking>
					</RoomBookings>
				</BookDetails>
			</BookRequest>',
			new BookRequest(
				$loginDetails,
				$twoRoomBookingDetails,
				true
			)
		];

		$leadGuestOnlyBookResponse = new RoomBookingResponse(
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

		yield [
			'<RoomBooking>
				<RoomID>155558</RoomID>
				<Name>Executive Double</Name>
				<MealBasisID>6</MealBasisID>
				<Adults>1</Adults>
				<Children>0</Children>
				<Infants>0</Infants>
				<Guests/>
				<RoomPrice>1040.23</RoomPrice>
			</RoomBooking>',
			$leadGuestOnlyBookResponse
		];

		$leadGuestAndGuestBookResponse = new RoomBookingResponse(
			155558,
			'Executive Double',
			'Sea View',
			6,
			2,
			0,
			0,
			$oneGuest,
			$oneSupplement,
			$oneSpecialOffer,
			$oneTax,
			$oneCancellationPolicy,
			1040.23
		);

		yield [
			'<RoomBooking>
				<RoomID>155558</RoomID>
				<Name>Executive Double</Name>
				<View>Sea View</View>
				<MealBasisID>6</MealBasisID>
				<Adults>2</Adults>
				<Children>0</Children>
				<Infants>0</Infants>
				<Guests>
					<Guest>
						<Type>Adult</Type>
						<FirstName>Sally</FirstName>
						<LastName>Smith</LastName>
						<Title>Mrs</Title>
						<Nationality>French</Nationality>
					</Guest>
				</Guests>
				<Supplements>
					<Supplement>
						<Name>test supplement</Name>
						<Duration>Per Night</Duration>
						<Multiplier>Per Person</Multiplier>
						<Total>220</Total>
						<PaxType>Adult Only</PaxType>
					</Supplement>
				</Supplements>
				<SpecialOffers>
					<SpecialOffer>
						<Name>Example special offer</Name>
						<Type>Value Added</Type>
						<Desc>test desc</Desc>
					</SpecialOffer>
				</SpecialOffers>
				<Taxes>
					<Tax>
						<TaxName>test %</TaxName>
						<Inclusive>False</Inclusive>
						<Total>1148.55</Total>
					</Tax>
				</Taxes>
				<CancellationPolicies>
					<CancellationPolicy>
						<CancelBy>2020-07-11</CancelBy>
						<Penalty>574.28</Penalty>
					</CancellationPolicy>
				</CancellationPolicies>
				<RoomPrice>1040.23</RoomPrice>
			</RoomBooking>',
			$leadGuestAndGuestBookResponse
		];

		$adultAndChildBookResponse = new RoomBookingResponse(
			155558,
			'Executive Double',
			'Sea View',
			6,
			1,
			1,
			0,
			$twoGuests,
			$twoSupplements,
			$twoSpecialOffers,
			$fourTaxes,
			$twoCancellationPolicy,
			1040.23
		);

		yield [
			'<RoomBooking>
				<RoomID>155558</RoomID>
				<Name>Executive Double</Name>
				<View>Sea View</View>
				<MealBasisID>6</MealBasisID>
				<Adults>1</Adults>
				<Children>1</Children>
				<Infants>0</Infants>
				<Guests>
					<Guest>
						<Type>Adult</Type>
						<FirstName>Sally</FirstName>
						<LastName>Smith</LastName>
						<Title>Mrs</Title>
						<Nationality>French</Nationality>
					</Guest>
					<Guest>
						<Type>Child</Type>
						<FirstName>Jimmy</FirstName>
						<LastName>Smith</LastName>
						<Age>5</Age>
						<Nationality>French</Nationality>
					</Guest>
				</Guests>
				<Supplements>
					<Supplement>
						<Name>Weekend Stay (Fri - Sun)</Name>
						<Duration>Per Night</Duration>
						<Multiplier>Per Room</Multiplier>
						<Total>60</Total>
					</Supplement>
					<Supplement>
						<Name>test supplement</Name>
						<Duration>Per Night</Duration>
						<Multiplier>Per Person</Multiplier>
						<Total>220</Total>
						<PaxType>Adult Only</PaxType>
					</Supplement>
				</Supplements>
				<SpecialOffers>
					<SpecialOffer>
						<Name>Example special offer</Name>
						<Type>Value Added</Type>
						<Desc>test desc</Desc>
					</SpecialOffer>
					<SpecialOffer>
						<Name>Example special offer 2</Name>
						<Type>Free Kids</Type>
						<Value>1</Value>
						<Total>1000</Total>
						<Desc>test desc</Desc>
					</SpecialOffer>
				</SpecialOffers>
				<Taxes>
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
				</Taxes>
				<CancellationPolicies>
					<CancellationPolicy>
						<CancelBy>2020-07-11</CancelBy>
						<Penalty>574.28</Penalty>
					</CancellationPolicy>
					<CancellationPolicy>
						<CancelBy>2020-07-18</CancelBy>
						<Penalty>1148.55</Penalty>
					</CancellationPolicy>
				</CancellationPolicies>
				<RoomPrice>1040.23</RoomPrice>
			</RoomBooking>',
			$adultAndChildBookResponse
		];

		$oneRoomBooking = new RoomBookingsResponse($leadGuestOnlyBookResponse);
		yield [
			'<RoomBookings>
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
			</RoomBookings>',
			$oneRoomBooking
		];

		$twoRoomBooking = new RoomBookingsResponse(
			$leadGuestAndGuestBookResponse,
			$adultAndChildBookResponse
		);

		yield [
			'<RoomBookings>
				<RoomBooking>
					<RoomID>155558</RoomID>
					<Name>Executive Double</Name>
					<View>Sea View</View>
					<MealBasisID>6</MealBasisID>
					<Adults>2</Adults>
					<Children>0</Children>
					<Infants>0</Infants>
					<Guests>
						<Guest>
							<Type>Adult</Type>
							<FirstName>Sally</FirstName>
							<LastName>Smith</LastName>
							<Title>Mrs</Title>
							<Nationality>French</Nationality>
						</Guest>
					</Guests>
					<Supplements>
						<Supplement>
							<Name>test supplement</Name>
							<Duration>Per Night</Duration>
							<Multiplier>Per Person</Multiplier>
							<Total>220</Total>
							<PaxType>Adult Only</PaxType>
						</Supplement>
					</Supplements>
					<SpecialOffers>
						<SpecialOffer>
							<Name>Example special offer</Name>
							<Type>Value Added</Type>
							<Desc>test desc</Desc>
						</SpecialOffer>
					</SpecialOffers>
					<Taxes>
						<Tax>
							<TaxName>test %</TaxName>
							<Inclusive>False</Inclusive>
							<Total>1148.55</Total>
						</Tax>
					</Taxes>
					<CancellationPolicies>
						<CancellationPolicy>
							<CancelBy>2020-07-11</CancelBy>
							<Penalty>574.28</Penalty>
						</CancellationPolicy>
					</CancellationPolicies>
					<RoomPrice>1040.23</RoomPrice>
				</RoomBooking>
				<RoomBooking>
					<RoomID>155558</RoomID>
					<Name>Executive Double</Name>
					<View>Sea View</View>
					<MealBasisID>6</MealBasisID>
					<Adults>1</Adults>
					<Children>1</Children>
					<Infants>0</Infants>
					<Guests>
						<Guest>
							<Type>Adult</Type>
							<FirstName>Sally</FirstName>
							<LastName>Smith</LastName>
							<Title>Mrs</Title>
							<Nationality>French</Nationality>
						</Guest>
						<Guest>
							<Type>Child</Type>
							<FirstName>Jimmy</FirstName>
							<LastName>Smith</LastName>
							<Age>5</Age>
							<Nationality>French</Nationality>
						</Guest>
					</Guests>
					<Supplements>
						<Supplement>
							<Name>Weekend Stay (Fri - Sun)</Name>
							<Duration>Per Night</Duration>
							<Multiplier>Per Room</Multiplier>
							<Total>60</Total>
						</Supplement>
						<Supplement>
							<Name>test supplement</Name>
							<Duration>Per Night</Duration>
							<Multiplier>Per Person</Multiplier>
							<Total>220</Total>
							<PaxType>Adult Only</PaxType>
						</Supplement>
					</Supplements>
					<SpecialOffers>
						<SpecialOffer>
							<Name>Example special offer</Name>
							<Type>Value Added</Type>
							<Desc>test desc</Desc>
						</SpecialOffer>
						<SpecialOffer>
							<Name>Example special offer 2</Name>
							<Type>Free Kids</Type>
							<Value>1</Value>
							<Total>1000</Total>
							<Desc>test desc</Desc>
						</SpecialOffer>
					</SpecialOffers>
					<Taxes>
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
					</Taxes>
					<CancellationPolicies>
						<CancellationPolicy>
							<CancelBy>2020-07-11</CancelBy>
							<Penalty>574.28</Penalty>
						</CancellationPolicy>
						<CancellationPolicy>
							<CancelBy>2020-07-18</CancelBy>
							<Penalty>1148.55</Penalty>
						</CancellationPolicy>
					</CancellationPolicies>
					<RoomPrice>1040.23</RoomPrice>
				</RoomBooking>
			</RoomBookings>',
			$twoRoomBooking
		];

		$minProperty = new Property(
			70011,
			'BUSY ROOMS HOTEL EMEA',
			$supplier,
			null,
			4,
			null,
			45,
			76,
			87,
			null,
			null,
			null,
			'Ideal for the business travellers and couples looking for the perfect getaway or just to relax, as well as experience a cultural city or visit the islands on a pre or post cruise vacation.',
			'Ideal for the business travellers and couples looking for the perfect getaway or just to relax, as well as experience a cultural city or visit the islands on a pre or post cruise vacation.',
			'https://az416281.vo.msecnd.net/hotels/',
			'3000-Emea  Hotel - Hotels/original/Emea-3-525-Copy.jpg',
			'3000-Emea Copy.jpg',
			null
		);

		yield [
			'<Property>
				<PropertyID>70011</PropertyID>
				<PropertyName>BUSY ROOMS HOTEL EMEA</PropertyName>
				<Supplier>
					<SupplierID>6</SupplierID>
					<SupplierName>RMI</SupplierName>
				</Supplier>
				<Rating>4</Rating>
				<GeographyLevel1ID>45</GeographyLevel1ID>
				<GeographyLevel2ID>76</GeographyLevel2ID>
				<GeographyLevel3ID>87</GeographyLevel3ID>
				<Strapline>Ideal for the business travellers and couples looking for the perfect getaway or just to relax, as well as experience a cultural city or visit the islands on a pre or post cruise vacation.</Strapline>
				<Description>Ideal for the business travellers and couples looking for the perfect getaway or just to relax, as well as experience a cultural city or visit the islands on a pre or post cruise vacation.</Description>
				<CMSBaseURL>https://az416281.vo.msecnd.net/hotels/</CMSBaseURL>
				<MainImage>3000-Emea  Hotel - Hotels/original/Emea-3-525-Copy.jpg</MainImage>
				<MainImageThumbnail>3000-Emea Copy.jpg</MainImageThumbnail>
			</Property>',
			$minProperty
		];

		$sympleProperty = new Property(
			70011,
			'BUSY ROOMS HOTEL EMEA',
			$supplier,
			123,
			4,
			$oneErratum,
			45,
			76,
			87,
			'United Kingdom',
			'Malta',
			'Malta',
			'Ideal for the business travellers and couples looking for the perfect getaway or just to relax, as well as experience a cultural city or visit the islands on a pre or post cruise vacation.',
			'Ideal for the business travellers and couples looking for the perfect getaway or just to relax, as well as experience a cultural city or visit the islands on a pre or post cruise vacation.',
			'https://az416281.vo.msecnd.net/hotels/',
			'3000-Emea  Hotel - Hotels/original/Emea-3-525-Copy.jpg',
			'3000-Emea Copy.jpg',
			$oneImage
		);

		yield [
			'<Property>
				<PropertyID>70011</PropertyID>
				<PropertyName>BUSY ROOMS HOTEL EMEA</PropertyName>
				<Supplier>
					<SupplierID>6</SupplierID>
					<SupplierName>RMI</SupplierName>
				</Supplier>
				<GIATAID>123</GIATAID>
				<Rating>4</Rating>
				<Errata>
					<Erratum>
						<StartDate>2020-08-04</StartDate>
						<EndDate>2020-08-11</EndDate>
						<Description>Small pool will be closed for maintenance</Description>
					</Erratum>
				</Errata>
				<GeographyLevel1ID>45</GeographyLevel1ID>
				<GeographyLevel2ID>76</GeographyLevel2ID>
				<GeographyLevel3ID>87</GeographyLevel3ID>
				<Country>United Kingdom</Country>
				<Area>Malta</Area>
				<Region>Malta</Region>
				<Strapline>Ideal for the business travellers and couples looking for the perfect getaway or just to relax, as well as experience a cultural city or visit the islands on a pre or post cruise vacation.</Strapline>
				<Description>Ideal for the business travellers and couples looking for the perfect getaway or just to relax, as well as experience a cultural city or visit the islands on a pre or post cruise vacation.</Description>
				<CMSBaseURL>https://az416281.vo.msecnd.net/hotels/</CMSBaseURL>
				<MainImage>3000-Emea  Hotel - Hotels/original/Emea-3-525-Copy.jpg</MainImage>
				<MainImageThumbnail>3000-Emea Copy.jpg</MainImageThumbnail>
				<Images>
					<Image>
						<FullSize>CMSImage_1000.jpg</FullSize>
						<Thumbnail>CMSImageThumb_1000.jpg</Thumbnail>
					</Image>
				</Images>
			</Property>',
			$sympleProperty
		];

		$complexProperty = new Property(
			70011,
			'BUSY ROOMS HOTEL EMEA',
			$supplier,
			123,
			4,
			$twoErrata,
			45,
			76,
			87,
			'United Kingdom',
			'Malta',
			'Malta',
			'Ideal for the business travellers and couples looking for the perfect getaway or just to relax, as well as experience a cultural city or visit the islands on a pre or post cruise vacation.',
			'Ideal for the business travellers and couples looking for the perfect getaway or just to relax, as well as experience a cultural city or visit the islands on a pre or post cruise vacation.',
			'https://az416281.vo.msecnd.net/hotels/',
			'3000-Emea  Hotel - Hotels/original/Emea-3-525-Copy.jpg',
			'3000-Emea Copy.jpg',
			$twoImages
		);

		yield [
			'<Property>
				<PropertyID>70011</PropertyID>
				<PropertyName>BUSY ROOMS HOTEL EMEA</PropertyName>
				<Supplier>
					<SupplierID>6</SupplierID>
					<SupplierName>RMI</SupplierName>
				</Supplier>
				<GIATAID>123</GIATAID>
				<Rating>4</Rating>
				<Errata>
					<Erratum>
						<StartDate>2020-08-04</StartDate>
						<EndDate>2020-08-11</EndDate>
						<Description>Small pool will be closed for maintenance</Description>
					</Erratum>
					<Erratum>
						<StartDate>2020-08-04</StartDate>
						<EndDate>2020-08-11</EndDate>
						<Description>There won\'t be mayonese at the restaurant</Description>
					</Erratum>
				</Errata>
				<GeographyLevel1ID>45</GeographyLevel1ID>
				<GeographyLevel2ID>76</GeographyLevel2ID>
				<GeographyLevel3ID>87</GeographyLevel3ID>
				<Country>United Kingdom</Country>
				<Area>Malta</Area>
				<Region>Malta</Region>
				<Strapline>Ideal for the business travellers and couples looking for the perfect getaway or just to relax, as well as experience a cultural city or visit the islands on a pre or post cruise vacation.</Strapline>
				<Description>Ideal for the business travellers and couples looking for the perfect getaway or just to relax, as well as experience a cultural city or visit the islands on a pre or post cruise vacation.</Description>
				<CMSBaseURL>https://az416281.vo.msecnd.net/hotels/</CMSBaseURL>
				<MainImage>3000-Emea  Hotel - Hotels/original/Emea-3-525-Copy.jpg</MainImage>
				<MainImageThumbnail>3000-Emea Copy.jpg</MainImageThumbnail>
				<Images>
					<Image>
						<FullSize>CMSImage_1000.jpg</FullSize>
						<Thumbnail>CMSImageThumb_1000.jpg</Thumbnail>
					</Image>
					<Image>
						<FullSize>CMSImage_1001.jpg</FullSize>
						<Thumbnail>CMSImageThumb_1001.jpg</Thumbnail>
					</Image>
				</Images>
			</Property>',
			$complexProperty
		];

		$bookingDetails = new BookingDetailsResponse(
			'HCF0011',
			'8430154',
			'Live',
			null,
			'EUR',
			null,
			'2023-11-01',
			5,
			$simpleLeadGuestBook,
			null, //busyrooms have this
			'TEST_REF',
			1040,
			'2023-10-02',
			$twoRoomBooking,
			$complexProperty
		);

		yield [
			'<BookingDetails>
				<BookingReference>HCF0011</BookingReference>
				<SupplierReference>8430154</SupplierReference>
				<Status>Live</Status>
				<Currency>EUR</Currency>
				<ArrivalDate>2023-11-01</ArrivalDate>
				<Duration>5</Duration>
				<LeadGuest>
					<FirstName>Jim</FirstName>
					<LastName>Watsworth</LastName>
					<Title>Mr</Title>
				</LeadGuest>
				<TradeReference>TEST_REF</TradeReference>
				<TotalPrice>1040</TotalPrice>
				<DueDate>2023-10-02</DueDate>
				<RoomBookings>
					<RoomBooking>
						<RoomID>155558</RoomID>
						<Name>Executive Double</Name>
						<View>Sea View</View>
						<MealBasisID>6</MealBasisID>
						<Adults>2</Adults>
						<Children>0</Children>
						<Infants>0</Infants>
						<Guests>
							<Guest>
								<Type>Adult</Type>
								<FirstName>Sally</FirstName>
								<LastName>Smith</LastName>
								<Title>Mrs</Title>
								<Nationality>French</Nationality>
							</Guest>
						</Guests>
						<Supplements>
							<Supplement>
								<Name>test supplement</Name>
								<Duration>Per Night</Duration>
								<Multiplier>Per Person</Multiplier>
								<Total>220</Total>
								<PaxType>Adult Only</PaxType>
							</Supplement>
						</Supplements>
						<SpecialOffers>
							<SpecialOffer>
								<Name>Example special offer</Name>
								<Type>Value Added</Type>
								<Desc>test desc</Desc>
							</SpecialOffer>
						</SpecialOffers>
						<Taxes>
							<Tax>
								<TaxName>test %</TaxName>
								<Inclusive>False</Inclusive>
								<Total>1148.55</Total>
							</Tax>
						</Taxes>
						<CancellationPolicies>
							<CancellationPolicy>
								<CancelBy>2020-07-11</CancelBy>
								<Penalty>574.28</Penalty>
							</CancellationPolicy>
						</CancellationPolicies>
						<RoomPrice>1040.23</RoomPrice>
					</RoomBooking>
					<RoomBooking>
						<RoomID>155558</RoomID>
						<Name>Executive Double</Name>
						<View>Sea View</View>
						<MealBasisID>6</MealBasisID>
						<Adults>1</Adults>
						<Children>1</Children>
						<Infants>0</Infants>
						<Guests>
							<Guest>
								<Type>Adult</Type>
								<FirstName>Sally</FirstName>
								<LastName>Smith</LastName>
								<Title>Mrs</Title>
								<Nationality>French</Nationality>
							</Guest>
							<Guest>
								<Type>Child</Type>
								<FirstName>Jimmy</FirstName>
								<LastName>Smith</LastName>
								<Age>5</Age>
								<Nationality>French</Nationality>
							</Guest>
						</Guests>
						<Supplements>
							<Supplement>
								<Name>Weekend Stay (Fri - Sun)</Name>
								<Duration>Per Night</Duration>
								<Multiplier>Per Room</Multiplier>
								<Total>60</Total>
							</Supplement>
							<Supplement>
								<Name>test supplement</Name>
								<Duration>Per Night</Duration>
								<Multiplier>Per Person</Multiplier>
								<Total>220</Total>
								<PaxType>Adult Only</PaxType>
							</Supplement>
						</Supplements>
						<SpecialOffers>
							<SpecialOffer>
								<Name>Example special offer</Name>
								<Type>Value Added</Type>
								<Desc>test desc</Desc>
							</SpecialOffer>
							<SpecialOffer>
								<Name>Example special offer 2</Name>
								<Type>Free Kids</Type>
								<Value>1</Value>
								<Total>1000</Total>
								<Desc>test desc</Desc>
							</SpecialOffer>
						</SpecialOffers>
						<Taxes>
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
						</Taxes>
						<CancellationPolicies>
							<CancellationPolicy>
								<CancelBy>2020-07-11</CancelBy>
								<Penalty>574.28</Penalty>
							</CancellationPolicy>
							<CancellationPolicy>
								<CancelBy>2020-07-18</CancelBy>
								<Penalty>1148.55</Penalty>
							</CancellationPolicy>
						</CancellationPolicies>
						<RoomPrice>1040.23</RoomPrice>
					</RoomBooking>
				</RoomBookings>
				<Property>
					<PropertyID>70011</PropertyID>
					<PropertyName>BUSY ROOMS HOTEL EMEA</PropertyName>
					<Supplier>
						<SupplierID>6</SupplierID>
						<SupplierName>RMI</SupplierName>
					</Supplier>
					<GIATAID>123</GIATAID>
					<Rating>4</Rating>
					<Errata>
						<Erratum>
							<StartDate>2020-08-04</StartDate>
							<EndDate>2020-08-11</EndDate>
							<Description>Small pool will be closed for maintenance</Description>
						</Erratum>
						<Erratum>
							<StartDate>2020-08-04</StartDate>
							<EndDate>2020-08-11</EndDate>
							<Description>There won\'t be mayonese at the restaurant</Description>
						</Erratum>
					</Errata>
					<GeographyLevel1ID>45</GeographyLevel1ID>
					<GeographyLevel2ID>76</GeographyLevel2ID>
					<GeographyLevel3ID>87</GeographyLevel3ID>
					<Country>United Kingdom</Country>
					<Area>Malta</Area>
					<Region>Malta</Region>
					<Strapline>Ideal for the business travellers and couples looking for the perfect getaway or just to relax, as well as experience a cultural city or visit the islands on a pre or post cruise vacation.</Strapline>
					<Description>Ideal for the business travellers and couples looking for the perfect getaway or just to relax, as well as experience a cultural city or visit the islands on a pre or post cruise vacation.</Description>
					<CMSBaseURL>https://az416281.vo.msecnd.net/hotels/</CMSBaseURL>
					<MainImage>3000-Emea  Hotel - Hotels/original/Emea-3-525-Copy.jpg</MainImage>
					<MainImageThumbnail>3000-Emea Copy.jpg</MainImageThumbnail>
					<Images>
						<Image>
							<FullSize>CMSImage_1000.jpg</FullSize>
							<Thumbnail>CMSImageThumb_1000.jpg</Thumbnail>
						</Image>
						<Image>
							<FullSize>CMSImage_1001.jpg</FullSize>
							<Thumbnail>CMSImageThumb_1001.jpg</Thumbnail>
						</Image>
					</Images>
				</Property>
			</BookingDetails>',
			$bookingDetails
		];

		$bookResponse = new BookResponse(
			$requestInfo,
			$returnStatusTrue,
			$bookingDetails
		);

		yield [
			'<BookResponse>
				<RequestInfo>
					<Timestamp>1687253937</Timestamp>
					<TimestampISO>2023-06-20T09:38:57+00:00</TimestampISO>
					<Host>xml.centriumres.com.localdomain.ee</Host>
					<HostIP>10.0.1.182</HostIP>
					<ReqID>649173b14aadb8.17864349</ReqID>
				</RequestInfo>
				<ReturnStatus>
					<Success>True</Success>
				</ReturnStatus>
				<BookingDetails>
					<BookingReference>HCF0011</BookingReference>
					<SupplierReference>8430154</SupplierReference>
					<Status>Live</Status>
					<Currency>EUR</Currency>
					<ArrivalDate>2023-11-01</ArrivalDate>
					<Duration>5</Duration>
					<LeadGuest>
						<FirstName>Jim</FirstName>
						<LastName>Watsworth</LastName>
						<Title>Mr</Title>
					</LeadGuest>
					<TradeReference>TEST_REF</TradeReference>
					<TotalPrice>1040</TotalPrice>
					<DueDate>2023-10-02</DueDate>
					<RoomBookings>
						<RoomBooking>
							<RoomID>155558</RoomID>
							<Name>Executive Double</Name>
							<View>Sea View</View>
							<MealBasisID>6</MealBasisID>
							<Adults>2</Adults>
							<Children>0</Children>
							<Infants>0</Infants>
							<Guests>
								<Guest>
									<Type>Adult</Type>
									<FirstName>Sally</FirstName>
									<LastName>Smith</LastName>
									<Title>Mrs</Title>
									<Nationality>French</Nationality>
								</Guest>
							</Guests>
							<Supplements>
								<Supplement>
									<Name>test supplement</Name>
									<Duration>Per Night</Duration>
									<Multiplier>Per Person</Multiplier>
									<Total>220</Total>
									<PaxType>Adult Only</PaxType>
								</Supplement>
							</Supplements>
							<SpecialOffers>
								<SpecialOffer>
									<Name>Example special offer</Name>
									<Type>Value Added</Type>
									<Desc>test desc</Desc>
								</SpecialOffer>
							</SpecialOffers>
							<Taxes>
								<Tax>
									<TaxName>test %</TaxName>
									<Inclusive>False</Inclusive>
									<Total>1148.55</Total>
								</Tax>
							</Taxes>
							<CancellationPolicies>
								<CancellationPolicy>
									<CancelBy>2020-07-11</CancelBy>
									<Penalty>574.28</Penalty>
								</CancellationPolicy>
							</CancellationPolicies>
							<RoomPrice>1040.23</RoomPrice>
						</RoomBooking>
						<RoomBooking>
							<RoomID>155558</RoomID>
							<Name>Executive Double</Name>
							<View>Sea View</View>
							<MealBasisID>6</MealBasisID>
							<Adults>1</Adults>
							<Children>1</Children>
							<Infants>0</Infants>
							<Guests>
								<Guest>
									<Type>Adult</Type>
									<FirstName>Sally</FirstName>
									<LastName>Smith</LastName>
									<Title>Mrs</Title>
									<Nationality>French</Nationality>
								</Guest>
								<Guest>
									<Type>Child</Type>
									<FirstName>Jimmy</FirstName>
									<LastName>Smith</LastName>
									<Age>5</Age>
									<Nationality>French</Nationality>
								</Guest>
							</Guests>
							<Supplements>
								<Supplement>
									<Name>Weekend Stay (Fri - Sun)</Name>
									<Duration>Per Night</Duration>
									<Multiplier>Per Room</Multiplier>
									<Total>60</Total>
								</Supplement>
								<Supplement>
									<Name>test supplement</Name>
									<Duration>Per Night</Duration>
									<Multiplier>Per Person</Multiplier>
									<Total>220</Total>
									<PaxType>Adult Only</PaxType>
								</Supplement>
							</Supplements>
							<SpecialOffers>
								<SpecialOffer>
									<Name>Example special offer</Name>
									<Type>Value Added</Type>
									<Desc>test desc</Desc>
								</SpecialOffer>
								<SpecialOffer>
									<Name>Example special offer 2</Name>
									<Type>Free Kids</Type>
									<Value>1</Value>
									<Total>1000</Total>
									<Desc>test desc</Desc>
								</SpecialOffer>
							</SpecialOffers>
							<Taxes>
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
							</Taxes>
							<CancellationPolicies>
								<CancellationPolicy>
									<CancelBy>2020-07-11</CancelBy>
									<Penalty>574.28</Penalty>
								</CancellationPolicy>
								<CancellationPolicy>
									<CancelBy>2020-07-18</CancelBy>
									<Penalty>1148.55</Penalty>
								</CancellationPolicy>
							</CancellationPolicies>
							<RoomPrice>1040.23</RoomPrice>
						</RoomBooking>
					</RoomBookings>
					<Property>
						<PropertyID>70011</PropertyID>
						<PropertyName>BUSY ROOMS HOTEL EMEA</PropertyName>
						<Supplier>
							<SupplierID>6</SupplierID>
							<SupplierName>RMI</SupplierName>
						</Supplier>
						<GIATAID>123</GIATAID>
						<Rating>4</Rating>
						<Errata>
							<Erratum>
								<StartDate>2020-08-04</StartDate>
								<EndDate>2020-08-11</EndDate>
								<Description>Small pool will be closed for maintenance</Description>
							</Erratum>
							<Erratum>
								<StartDate>2020-08-04</StartDate>
								<EndDate>2020-08-11</EndDate>
								<Description>There won\'t be mayonese at the restaurant</Description>
							</Erratum>
						</Errata>
						<GeographyLevel1ID>45</GeographyLevel1ID>
						<GeographyLevel2ID>76</GeographyLevel2ID>
						<GeographyLevel3ID>87</GeographyLevel3ID>
						<Country>United Kingdom</Country>
						<Area>Malta</Area>
						<Region>Malta</Region>
						<Strapline>Ideal for the business travellers and couples looking for the perfect getaway or just to relax, as well as experience a cultural city or visit the islands on a pre or post cruise vacation.</Strapline>
						<Description>Ideal for the business travellers and couples looking for the perfect getaway or just to relax, as well as experience a cultural city or visit the islands on a pre or post cruise vacation.</Description>
						<CMSBaseURL>https://az416281.vo.msecnd.net/hotels/</CMSBaseURL>
						<MainImage>3000-Emea  Hotel - Hotels/original/Emea-3-525-Copy.jpg</MainImage>
						<MainImageThumbnail>3000-Emea Copy.jpg</MainImageThumbnail>
						<Images>
							<Image>
								<FullSize>CMSImage_1000.jpg</FullSize>
								<Thumbnail>CMSImageThumb_1000.jpg</Thumbnail>
							</Image>
							<Image>
								<FullSize>CMSImage_1001.jpg</FullSize>
								<Thumbnail>CMSImageThumb_1001.jpg</Thumbnail>
							</Image>
						</Images>
					</Property>
				</BookingDetails>
			</BookResponse>',
			$bookResponse
		];

		yield [
			'<BookResponse>
				<RequestInfo>
					<Timestamp>1687253937</Timestamp>
					<TimestampISO>2023-06-20T09:38:57+00:00</TimestampISO>
					<Host>xml.centriumres.com.localdomain.ee</Host>
					<HostIP>10.0.1.182</HostIP>
					<ReqID>649173b14aadb8.17864349</ReqID>
				</RequestInfo>
				<ReturnStatus>
					<Success>False</Success>
					<Exception>Invalid Booking RoomID:[20011m]</Exception>
				</ReturnStatus>
			</BookResponse>',
			new BookResponse(
				$requestInfo,
				new ReturnStatus(
					false,
					'Invalid Booking RoomID:[20011m]'
				)
			)
		];


		yield [
			'<BookingRequest>
				<LoginDetails>
					<Login>login</Login>
					<Password>pass</Password>
					<Version>version</Version>
				</LoginDetails>
				<Mock>True</Mock>
				<BookingReference>reference</BookingReference>
			</BookingRequest>',
			new BookingRequest(
				$loginDetails,
				'reference',
				true
			)
		];

		yield [
			'<BookingResponse>
				<RequestInfo>
					<Timestamp>1687253937</Timestamp>
					<TimestampISO>2023-06-20T09:38:57+00:00</TimestampISO>
					<Host>xml.centriumres.com.localdomain.ee</Host>
					<HostIP>10.0.1.182</HostIP>
					<ReqID>649173b14aadb8.17864349</ReqID>
				</RequestInfo>
				<ReturnStatus>
					<Success>True</Success>
				</ReturnStatus>
				<BookingDetails>
					<BookingReference>HCF0011</BookingReference>
					<SupplierReference>8430154</SupplierReference>
					<Status>Live</Status>
					<Currency>EUR</Currency>
					<ArrivalDate>2023-11-01</ArrivalDate>
					<Duration>5</Duration>
					<LeadGuest>
						<FirstName>Jim</FirstName>
						<LastName>Watsworth</LastName>
						<Title>Mr</Title>
					</LeadGuest>
					<TradeReference>TEST_REF</TradeReference>
					<TotalPrice>1040</TotalPrice>
					<DueDate>2023-10-02</DueDate>
					<RoomBookings>
						<RoomBooking>
							<RoomID>155558</RoomID>
							<Name>Executive Double</Name>
							<View>Sea View</View>
							<MealBasisID>6</MealBasisID>
							<Adults>2</Adults>
							<Children>0</Children>
							<Infants>0</Infants>
							<Guests>
								<Guest>
									<Type>Adult</Type>
									<FirstName>Sally</FirstName>
									<LastName>Smith</LastName>
									<Title>Mrs</Title>
									<Nationality>French</Nationality>
								</Guest>
							</Guests>
							<Supplements>
								<Supplement>
									<Name>test supplement</Name>
									<Duration>Per Night</Duration>
									<Multiplier>Per Person</Multiplier>
									<Total>220</Total>
									<PaxType>Adult Only</PaxType>
								</Supplement>
							</Supplements>
							<SpecialOffers>
								<SpecialOffer>
									<Name>Example special offer</Name>
									<Type>Value Added</Type>
									<Desc>test desc</Desc>
								</SpecialOffer>
							</SpecialOffers>
							<Taxes>
								<Tax>
									<TaxName>test %</TaxName>
									<Inclusive>False</Inclusive>
									<Total>1148.55</Total>
								</Tax>
							</Taxes>
							<CancellationPolicies>
								<CancellationPolicy>
									<CancelBy>2020-07-11</CancelBy>
									<Penalty>574.28</Penalty>
								</CancellationPolicy>
							</CancellationPolicies>
							<RoomPrice>1040.23</RoomPrice>
						</RoomBooking>
						<RoomBooking>
							<RoomID>155558</RoomID>
							<Name>Executive Double</Name>
							<View>Sea View</View>
							<MealBasisID>6</MealBasisID>
							<Adults>1</Adults>
							<Children>1</Children>
							<Infants>0</Infants>
							<Guests>
								<Guest>
									<Type>Adult</Type>
									<FirstName>Sally</FirstName>
									<LastName>Smith</LastName>
									<Title>Mrs</Title>
									<Nationality>French</Nationality>
								</Guest>
								<Guest>
									<Type>Child</Type>
									<FirstName>Jimmy</FirstName>
									<LastName>Smith</LastName>
									<Age>5</Age>
									<Nationality>French</Nationality>
								</Guest>
							</Guests>
							<Supplements>
								<Supplement>
									<Name>Weekend Stay (Fri - Sun)</Name>
									<Duration>Per Night</Duration>
									<Multiplier>Per Room</Multiplier>
									<Total>60</Total>
								</Supplement>
								<Supplement>
									<Name>test supplement</Name>
									<Duration>Per Night</Duration>
									<Multiplier>Per Person</Multiplier>
									<Total>220</Total>
									<PaxType>Adult Only</PaxType>
								</Supplement>
							</Supplements>
							<SpecialOffers>
								<SpecialOffer>
									<Name>Example special offer</Name>
									<Type>Value Added</Type>
									<Desc>test desc</Desc>
								</SpecialOffer>
								<SpecialOffer>
									<Name>Example special offer 2</Name>
									<Type>Free Kids</Type>
									<Value>1</Value>
									<Total>1000</Total>
									<Desc>test desc</Desc>
								</SpecialOffer>
							</SpecialOffers>
							<Taxes>
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
							</Taxes>
							<CancellationPolicies>
								<CancellationPolicy>
									<CancelBy>2020-07-11</CancelBy>
									<Penalty>574.28</Penalty>
								</CancellationPolicy>
								<CancellationPolicy>
									<CancelBy>2020-07-18</CancelBy>
									<Penalty>1148.55</Penalty>
								</CancellationPolicy>
							</CancellationPolicies>
							<RoomPrice>1040.23</RoomPrice>
						</RoomBooking>
					</RoomBookings>
					<Property>
						<PropertyID>70011</PropertyID>
						<PropertyName>BUSY ROOMS HOTEL EMEA</PropertyName>
						<Supplier>
							<SupplierID>6</SupplierID>
							<SupplierName>RMI</SupplierName>
						</Supplier>
						<GIATAID>123</GIATAID>
						<Rating>4</Rating>
						<Errata>
							<Erratum>
								<StartDate>2020-08-04</StartDate>
								<EndDate>2020-08-11</EndDate>
								<Description>Small pool will be closed for maintenance</Description>
							</Erratum>
							<Erratum>
								<StartDate>2020-08-04</StartDate>
								<EndDate>2020-08-11</EndDate>
								<Description>There won\'t be mayonese at the restaurant</Description>
							</Erratum>
						</Errata>
						<GeographyLevel1ID>45</GeographyLevel1ID>
						<GeographyLevel2ID>76</GeographyLevel2ID>
						<GeographyLevel3ID>87</GeographyLevel3ID>
						<Country>United Kingdom</Country>
						<Area>Malta</Area>
						<Region>Malta</Region>
						<Strapline>Ideal for the business travellers and couples looking for the perfect getaway or just to relax, as well as experience a cultural city or visit the islands on a pre or post cruise vacation.</Strapline>
						<Description>Ideal for the business travellers and couples looking for the perfect getaway or just to relax, as well as experience a cultural city or visit the islands on a pre or post cruise vacation.</Description>
						<CMSBaseURL>https://az416281.vo.msecnd.net/hotels/</CMSBaseURL>
						<MainImage>3000-Emea  Hotel - Hotels/original/Emea-3-525-Copy.jpg</MainImage>
						<MainImageThumbnail>3000-Emea Copy.jpg</MainImageThumbnail>
						<Images>
							<Image>
								<FullSize>CMSImage_1000.jpg</FullSize>
								<Thumbnail>CMSImageThumb_1000.jpg</Thumbnail>
							</Image>
							<Image>
								<FullSize>CMSImage_1001.jpg</FullSize>
								<Thumbnail>CMSImageThumb_1001.jpg</Thumbnail>
							</Image>
						</Images>
					</Property>
				</BookingDetails>
			</BookingResponse>',
			new BookingResponse(
				$requestInfo,
				$returnStatusTrue,
				$bookingDetails
			)
		];

		yield [
			'<BookingResponse>
				<RequestInfo>
					<Timestamp>1687253937</Timestamp>
					<TimestampISO>2023-06-20T09:38:57+00:00</TimestampISO>
					<Host>xml.centriumres.com.localdomain.ee</Host>
					<HostIP>10.0.1.182</HostIP>
					<ReqID>649173b14aadb8.17864349</ReqID>
				</RequestInfo>
				<ReturnStatus>
					<Success>False</Success>
					<Exception>Supplier Reference not found for Booking Reference HCG0011m in SupplierBooking</Exception>
				</ReturnStatus>
			</BookingResponse>',
			new BookingResponse(
				$requestInfo,
				new ReturnStatus(
					false,
					'Supplier Reference not found for Booking Reference HCG0011m in SupplierBooking'
				)
			)
		];

		yield [
			'<BookingUpdateRequest>
				<LoginDetails>
					<Login>login</Login>
					<Password>pass</Password>
					<Version>version</Version>
				</LoginDetails>
				<Mock>True</Mock>
				<BookingReference>reference</BookingReference>
				<TradeReference>trade_reference</TradeReference>
			</BookingUpdateRequest>',
			new BookingUpdateRequest(
				$loginDetails,
				'reference',
				'trade_reference',
				true
			)
		];

		yield [
			'<BookingUpdateRequestResponse>
				<RequestInfo>
					<Timestamp>1687253937</Timestamp>
					<TimestampISO>2023-06-20T09:38:57+00:00</TimestampISO>
					<Host>xml.centriumres.com.localdomain.ee</Host>
					<HostIP>10.0.1.182</HostIP>
					<ReqID>649173b14aadb8.17864349</ReqID>
				</RequestInfo>
				<ReturnStatus>
					<Success>True</Success>
				</ReturnStatus>
				<BookingDetails>
					<BookingReference>HCF0011</BookingReference>
					<SupplierReference>8430154</SupplierReference>
					<Status>Live</Status>
					<Currency>EUR</Currency>
					<ArrivalDate>2023-11-01</ArrivalDate>
					<Duration>5</Duration>
					<LeadGuest>
						<FirstName>Jim</FirstName>
						<LastName>Watsworth</LastName>
						<Title>Mr</Title>
					</LeadGuest>
					<TradeReference>TEST_REF</TradeReference>
					<TotalPrice>1040</TotalPrice>
					<DueDate>2023-10-02</DueDate>
					<RoomBookings>
						<RoomBooking>
							<RoomID>155558</RoomID>
							<Name>Executive Double</Name>
							<View>Sea View</View>
							<MealBasisID>6</MealBasisID>
							<Adults>2</Adults>
							<Children>0</Children>
							<Infants>0</Infants>
							<Guests>
								<Guest>
									<Type>Adult</Type>
									<FirstName>Sally</FirstName>
									<LastName>Smith</LastName>
									<Title>Mrs</Title>
									<Nationality>French</Nationality>
								</Guest>
							</Guests>
							<Supplements>
								<Supplement>
									<Name>test supplement</Name>
									<Duration>Per Night</Duration>
									<Multiplier>Per Person</Multiplier>
									<Total>220</Total>
									<PaxType>Adult Only</PaxType>
								</Supplement>
							</Supplements>
							<SpecialOffers>
								<SpecialOffer>
									<Name>Example special offer</Name>
									<Type>Value Added</Type>
									<Desc>test desc</Desc>
								</SpecialOffer>
							</SpecialOffers>
							<Taxes>
								<Tax>
									<TaxName>test %</TaxName>
									<Inclusive>False</Inclusive>
									<Total>1148.55</Total>
								</Tax>
							</Taxes>
							<CancellationPolicies>
								<CancellationPolicy>
									<CancelBy>2020-07-11</CancelBy>
									<Penalty>574.28</Penalty>
								</CancellationPolicy>
							</CancellationPolicies>
							<RoomPrice>1040.23</RoomPrice>
						</RoomBooking>
						<RoomBooking>
							<RoomID>155558</RoomID>
							<Name>Executive Double</Name>
							<View>Sea View</View>
							<MealBasisID>6</MealBasisID>
							<Adults>1</Adults>
							<Children>1</Children>
							<Infants>0</Infants>
							<Guests>
								<Guest>
									<Type>Adult</Type>
									<FirstName>Sally</FirstName>
									<LastName>Smith</LastName>
									<Title>Mrs</Title>
									<Nationality>French</Nationality>
								</Guest>
								<Guest>
									<Type>Child</Type>
									<FirstName>Jimmy</FirstName>
									<LastName>Smith</LastName>
									<Age>5</Age>
									<Nationality>French</Nationality>
								</Guest>
							</Guests>
							<Supplements>
								<Supplement>
									<Name>Weekend Stay (Fri - Sun)</Name>
									<Duration>Per Night</Duration>
									<Multiplier>Per Room</Multiplier>
									<Total>60</Total>
								</Supplement>
								<Supplement>
									<Name>test supplement</Name>
									<Duration>Per Night</Duration>
									<Multiplier>Per Person</Multiplier>
									<Total>220</Total>
									<PaxType>Adult Only</PaxType>
								</Supplement>
							</Supplements>
							<SpecialOffers>
								<SpecialOffer>
									<Name>Example special offer</Name>
									<Type>Value Added</Type>
									<Desc>test desc</Desc>
								</SpecialOffer>
								<SpecialOffer>
									<Name>Example special offer 2</Name>
									<Type>Free Kids</Type>
									<Value>1</Value>
									<Total>1000</Total>
									<Desc>test desc</Desc>
								</SpecialOffer>
							</SpecialOffers>
							<Taxes>
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
							</Taxes>
							<CancellationPolicies>
								<CancellationPolicy>
									<CancelBy>2020-07-11</CancelBy>
									<Penalty>574.28</Penalty>
								</CancellationPolicy>
								<CancellationPolicy>
									<CancelBy>2020-07-18</CancelBy>
									<Penalty>1148.55</Penalty>
								</CancellationPolicy>
							</CancellationPolicies>
							<RoomPrice>1040.23</RoomPrice>
						</RoomBooking>
					</RoomBookings>
					<Property>
						<PropertyID>70011</PropertyID>
						<PropertyName>BUSY ROOMS HOTEL EMEA</PropertyName>
						<Supplier>
							<SupplierID>6</SupplierID>
							<SupplierName>RMI</SupplierName>
						</Supplier>
						<GIATAID>123</GIATAID>
						<Rating>4</Rating>
						<Errata>
							<Erratum>
								<StartDate>2020-08-04</StartDate>
								<EndDate>2020-08-11</EndDate>
								<Description>Small pool will be closed for maintenance</Description>
							</Erratum>
							<Erratum>
								<StartDate>2020-08-04</StartDate>
								<EndDate>2020-08-11</EndDate>
								<Description>There won\'t be mayonese at the restaurant</Description>
							</Erratum>
						</Errata>
						<GeographyLevel1ID>45</GeographyLevel1ID>
						<GeographyLevel2ID>76</GeographyLevel2ID>
						<GeographyLevel3ID>87</GeographyLevel3ID>
						<Country>United Kingdom</Country>
						<Area>Malta</Area>
						<Region>Malta</Region>
						<Strapline>Ideal for the business travellers and couples looking for the perfect getaway or just to relax, as well as experience a cultural city or visit the islands on a pre or post cruise vacation.</Strapline>
						<Description>Ideal for the business travellers and couples looking for the perfect getaway or just to relax, as well as experience a cultural city or visit the islands on a pre or post cruise vacation.</Description>
						<CMSBaseURL>https://az416281.vo.msecnd.net/hotels/</CMSBaseURL>
						<MainImage>3000-Emea  Hotel - Hotels/original/Emea-3-525-Copy.jpg</MainImage>
						<MainImageThumbnail>3000-Emea Copy.jpg</MainImageThumbnail>
						<Images>
							<Image>
								<FullSize>CMSImage_1000.jpg</FullSize>
								<Thumbnail>CMSImageThumb_1000.jpg</Thumbnail>
							</Image>
							<Image>
								<FullSize>CMSImage_1001.jpg</FullSize>
								<Thumbnail>CMSImageThumb_1001.jpg</Thumbnail>
							</Image>
						</Images>
					</Property>
				</BookingDetails>
			</BookingUpdateRequestResponse>',
			new BookingUpdateRequestResponse(
				$requestInfo,
				$returnStatusTrue,
				$bookingDetails
			)
		];

		yield [
			'<BookingUpdateRequestResponse>
				<RequestInfo>
					<Timestamp>1687253937</Timestamp>
					<TimestampISO>2023-06-20T09:38:57+00:00</TimestampISO>
					<Host>xml.centriumres.com.localdomain.ee</Host>
					<HostIP>10.0.1.182</HostIP>
					<ReqID>649173b14aadb8.17864349</ReqID>
				</RequestInfo>
				<ReturnStatus>
					<Success>False</Success>
					<Exception>No response from supplier</Exception>
				</ReturnStatus>
			</BookingUpdateRequestResponse>',
			new BookingUpdateRequestResponse(
				$requestInfo,
				new ReturnStatus(
					false,
					'No response from supplier'
				)
			)
		];

		yield [
			'<CancelRequest>
				<LoginDetails>
					<Login>login</Login>
					<Password>pass</Password>
					<Version>version</Version>
				</LoginDetails>
				<BookingReference>reference</BookingReference>
				<Reason>Reason</Reason>
			</CancelRequest>',
			new CancelRequest(
				$loginDetails,
				'reference',
				'Reason'
			)
		];

		$bookingDetailsCancellation = new BookingDetails(
			'HCL0011',
			'2DE9D13',
			'Cancelled',
			'This is a test cancellation',
			'EUR',
			0.0
		);

		yield [
			'<CancelResponse>
				<RequestInfo>
					<Timestamp>1687253937</Timestamp>
					<TimestampISO>2023-06-20T09:38:57+00:00</TimestampISO>
					<Host>xml.centriumres.com.localdomain.ee</Host>
					<HostIP>10.0.1.182</HostIP>
					<ReqID>649173b14aadb8.17864349</ReqID>
				</RequestInfo>
				<ReturnStatus>
					<Success>True</Success>
				</ReturnStatus>
				<BookingDetails>
					<BookingReference>HCL0011</BookingReference>
					<SupplierReference>2DE9D13</SupplierReference>
					<Status>Cancelled</Status>
					<CancellationReason>This is a test cancellation</CancellationReason>
					<Currency>EUR</Currency>
					<Amount>0</Amount>
				</BookingDetails>
			</CancelResponse>',
			new CancelResponse(
				$requestInfo,
				$returnStatusTrue,
				$bookingDetailsCancellation
			)
		];

		yield [
			'<CancelResponse>
				<RequestInfo>
					<Timestamp>1687253937</Timestamp>
					<TimestampISO>2023-06-20T09:38:57+00:00</TimestampISO>
					<Host>xml.centriumres.com.localdomain.ee</Host>
					<HostIP>10.0.1.182</HostIP>
					<ReqID>649173b14aadb8.17864349</ReqID>
				</RequestInfo>
				<ReturnStatus>
					<Success>False</Success>
					<Exception>Supplier Reference not found for Booking Reference HCL0011 in SupplierBooking</Exception>
				</ReturnStatus>
			</CancelResponse>',
			new CancelResponse(
				$requestInfo,
				$returnBookingStatusFalse
			)
		];

		yield [
			'<BookingResponse>
				<RequestInfo>
					<Timestamp>1687253937</Timestamp>
					<TimestampISO>2023-06-20T09:38:57+00:00</TimestampISO>
					<Host>xml.centriumres.com.localdomain.ee</Host>
					<HostIP>10.0.1.182</HostIP>
					<ReqID>649173b14aadb8.17864349</ReqID>
				</RequestInfo>
				<ReturnStatus>
					<Success>True</Success>
				</ReturnStatus>
				<BookingDetails>
					<BookingReference>HCL0011</BookingReference>
					<SupplierReference>2DE9D13</SupplierReference>
					<Status>Cancelled</Status>
					<CancellationReason>This is a test cancellation</CancellationReason>
					<Currency>EUR</Currency>
					<Amount>0</Amount>
				</BookingDetails>
			</BookingResponse>',
			new BookingResponse(
				$requestInfo,
				$returnStatusTrue,
				$bookingDetailsCancellation
			)
		];
	}

	public static function dataProviderUnserializePrimitives()
	{
//1
		$proeprtyID = new Properties(2007);
		yield [
			'<Properties>
				<PropertyID>2007</PropertyID>
			</Properties>',
			$proeprtyID
		];

		$twoPropertyIDs = new Properties(2007, 3008);
		yield [
			'<Properties>
				<PropertyID>2007</PropertyID>
				<PropertyID>3008</PropertyID>
			</Properties>',
			$twoPropertyIDs
		];

		yield [
			'<ChildAge>
				<Age>15</Age>
			</ChildAge>',
			new ChildAge(15)
		];

		yield [
			'<ChildAges>
				<ChildAge>
					<Age>15</Age>
				</ChildAge>
			</ChildAges>',
			ChildAges::fromAges(
				15
			)
		];

		yield [
			'<ChildAges>
				<ChildAge>
					<Age>8</Age>
				</ChildAge>
				<ChildAge>
					<Age>15</Age>
				</ChildAge>
			</ChildAges>',
			ChildAges::fromAges(
				8, 15
			)
		];

		$twoAdults = RoomRequest::fromAges(2);
		yield [
			'<RoomRequest>
				<Children>0</Children>
				<Adults>2</Adults>
				<Infants>0</Infants>
				<ChildAges/>
			</RoomRequest>',
			$twoAdults
		];

		$twoAdultsOneChild = RoomRequest::fromAges(
			2,
			10
		);

		yield [
			'<RoomRequest>
				<ChildAges>
					<ChildAge>
						<Age>10</Age>
					</ChildAge>
				</ChildAges>
				<Adults>2</Adults>
				<Infants>0</Infants>
				<Children>1</Children>
			</RoomRequest>',
			$twoAdultsOneChild
		];

		$twoAdultsTwoInfants = RoomRequest::fromAges(
			2,
			1, 2
		);

		yield [
			'<RoomRequest>
				<Adults>2</Adults>
				<Children>2</Children>
				<ChildAges>
					<ChildAge>
						<Age>1</Age>
					</ChildAge>
					<ChildAge>
						<Age>2</Age>
					</ChildAge>
				</ChildAges>
			</RoomRequest>',
			$twoAdultsTwoInfants
		];

		$oneChildTwoInfants = RoomRequest::fromAges(
			null,
			1, 2, 10
		);

		yield [
			'<RoomRequest>
				<Adults>0</Adults>
				<Children>3</Children>
				<ChildAges>
					<ChildAge>
						<Age>1</Age>
					</ChildAge>
					<ChildAge>
						<Age>2</Age>
					</ChildAge>
					<ChildAge>
						<Age>10</Age>
					</ChildAge>
				</ChildAges>
			</RoomRequest>',
			$oneChildTwoInfants
		];

		$twoAdultsOneChildrenTwoInfants = RoomRequest::fromAges(
			2,
			1, 8, 2
		);
//10
		yield [
			'<RoomRequest>
				<Adults>2</Adults>
				<Children>3</Children>
				<ChildAges>
					<ChildAge>
						<Age>1</Age>
					</ChildAge>
					<ChildAge>
						<Age>8</Age>
					</ChildAge>
					<ChildAge>
						<Age>2</Age>
					</ChildAge>
				</ChildAges>
			</RoomRequest>',
			$twoAdultsOneChildrenTwoInfants
		];

		$twoAdultsTwoChildrenTwoInfants = RoomRequest::fromAges(
			2,
			9, 1, 8, 2
		);

		yield [
			'<RoomRequest>
				<Adults>2</Adults>
				<Children>4</Children>
				<Infants>2</Infants>
				<ChildAges>
					<ChildAge>
						<Age>9</Age>
					</ChildAge>
					<ChildAge>
						<Age>1</Age>
					</ChildAge>
					<ChildAge>
						<Age>8</Age>
					</ChildAge>
					<ChildAge>
						<Age>2</Age>
					</ChildAge>
				</ChildAges>
			</RoomRequest>',
			$twoAdultsTwoChildrenTwoInfants
		];

		yield [
			'<RoomRequests>
				<RoomRequest>
					<Adults>2</Adults>
					<Children>0</Children>
					<Infants>0</Infants>
				</RoomRequest>
			</RoomRequests>',
			new RoomRequests(
				$twoAdults
			)
		];

		yield [
			'<RoomRequests>
				<RoomRequest>
					<Adults>2</Adults>
					<ChildAges>
						<ChildAge>
							<Age>1</Age>
						</ChildAge>
						<ChildAge>
							<Age>2</Age>
						</ChildAge>
					</ChildAges>
					<Children>2</Children>
				</RoomRequest>
			</RoomRequests>',
			new RoomRequests(
				$twoAdultsTwoInfants
			)
		];

		yield [
			'<RoomRequests>
				<RoomRequest>
					<Adults>2</Adults>
					<Children>1</Children>
					<Infants>0</Infants>
					<ChildAges>
						<ChildAge>
							<Age>10</Age>
						</ChildAge>
					</ChildAges>
				</RoomRequest>
			</RoomRequests>',
			new RoomRequests(
				$twoAdultsOneChild
			)
		];

		yield [
			'<RoomRequests>
				<RoomRequest>
					<Adults>2</Adults>
					<Children>4</Children>
					<Infants>2</Infants>
					<ChildAges>
						<ChildAge>
							<Age>9</Age>
						</ChildAge>
						<ChildAge>
							<Age>1</Age>
						</ChildAge>
						<ChildAge>
							<Age>8</Age>
						</ChildAge>
						<ChildAge>
							<Age>2</Age>
						</ChildAge>
					</ChildAges>
				</RoomRequest>
			</RoomRequests>',
			new RoomRequests(
				$twoAdultsTwoChildrenTwoInfants
			)
		];

		yield [
			'<RoomRequests>
				<RoomRequest>
					<Adults>2</Adults>
					<Children>2</Children>
					<ChildAges>
						<ChildAge>
							<Age>1</Age>
						</ChildAge>
						<ChildAge>
							<Age>2</Age>
						</ChildAge>
					</ChildAges>
				</RoomRequest>
				<RoomRequest>
					<Adults>2</Adults>
					<Children>1</Children>
					<ChildAges>
						<ChildAge>
							<Age>10</Age>
						</ChildAge>
					</ChildAges>
				</RoomRequest>
				<RoomRequest>
					<Adults>2</Adults>
					<Children>4</Children>
					<ChildAges>
						<ChildAge>
							<Age>9</Age>
						</ChildAge>
						<ChildAge>
							<Age>1</Age>
						</ChildAge>
						<ChildAge>
							<Age>8</Age>
						</ChildAge>
						<ChildAge>
							<Age>2</Age>
						</ChildAge>
					</ChildAges>
				</RoomRequest>
			</RoomRequests>',
			new RoomRequests(
				$twoAdultsTwoInfants,
				$twoAdultsOneChild,
				$twoAdultsTwoChildrenTwoInfants
			)
		];

		$loginDetails = new LoginDetails('login', 'pass', 'version');

		yield [
			'<LoginDetails>
				<Login>login</Login>
				<Version>version</Version>
				<Password>pass</Password>
			</LoginDetails>',
			$loginDetails
		];

		//two properties
		yield [
			'<SearchRequest>
				<LoginDetails>
					<Login>login</Login>
					<Password>pass</Password>
					<Version>version</Version>
				</LoginDetails>
				<Mock>True</Mock>
				<SearchDetails>
					<ArrivalDate>2023-08-01</ArrivalDate>
					<Duration>7</Duration>
					<Properties>
						<PropertyID>2007</PropertyID>
						<PropertyID>3008</PropertyID>
					</Properties>
					<MealBasisID>0</MealBasisID>
					<MinStarRating>0</MinStarRating>
					<MinimumPrice>0</MinimumPrice>
					<MaximumPrice>0</MaximumPrice>
					<RoomRequests>
						<RoomRequest>
							<Adults>2</Adults>
							<Children>2</Children>
							<ChildAges>
								<ChildAge>
									<Age>1</Age>
								</ChildAge>
								<ChildAge>
									<Age>2</Age>
								</ChildAge>
							</ChildAges>
						</RoomRequest>
						<RoomRequest>
							<Adults>2</Adults>
							<Children>4</Children>
							<ChildAges>
								<ChildAge>
									<Age>9</Age>
								</ChildAge>
								<ChildAge>
									<Age>1</Age>
								</ChildAge>
								<ChildAge>
									<Age>8</Age>
								</ChildAge>
								<ChildAge>
									<Age>2</Age>
								</ChildAge>
							</ChildAges>
						</RoomRequest>
					</RoomRequests>
				</SearchDetails>
			</SearchRequest>',
			new SearchRequest(
				$loginDetails,
				new SearchDetails(
					'2023-08-01',
					7,
					new RoomRequests(
						$twoAdultsTwoInfants,
						$twoAdultsTwoChildrenTwoInfants
					),
					$twoPropertyIDs,
					null,
					0,
					0,
					0,
					0
				),
				true
			)
		];

		//one property
		yield [
			'<SearchRequest>
				<LoginDetails>
					<Login>login</Login>
					<Password>pass</Password>
					<Version>version</Version>
				</LoginDetails>
				<Mock>True</Mock>
				<SearchDetails>
					<ArrivalDate>2023-08-01</ArrivalDate>
					<Duration>7</Duration>
					<!-- a comment -->
					<PropertyID>2007</PropertyID>
					<MealBasisID>0</MealBasisID>
					<MinStarRating>0</MinStarRating>
					<MinimumPrice>0</MinimumPrice>
					<MaximumPrice>0</MaximumPrice>
					<RoomRequests>
						<RoomRequest>
							<Adults>2</Adults>
							<Children>2</Children>
							<ChildAges>
								<ChildAge>
									<Age>1</Age>
								</ChildAge>
								<ChildAge>
									<Age>2</Age>
								</ChildAge>
							</ChildAges>
						</RoomRequest>
						<RoomRequest>
							<Adults>2</Adults>
							<Children>4</Children>
							<ChildAges>
								<ChildAge>
									<Age>9</Age>
								</ChildAge>
								<ChildAge>
									<Age>1</Age>
								</ChildAge>
								<ChildAge>
									<Age>8</Age>
								</ChildAge>
								<ChildAge>
									<Age>2</Age>
								</ChildAge>
							</ChildAges>
						</RoomRequest>
					</RoomRequests>
				</SearchDetails>
			</SearchRequest>',
			new SearchRequest(
				$loginDetails,
				new SearchDetails(
					'2023-08-01',
					7,
					new RoomRequests(
						$twoAdultsTwoInfants,
						$twoAdultsTwoChildrenTwoInfants
					),
					null,
					2007,
					0,
					0,
					0,
					0
				),
				true
			)
		];
//20
		$requestInfo = new RequestInfo(
			1687253937,
			'2023-06-20T09:38:57+00:00',
			'xml.centriumres.com.localdomain.ee',
			'10.0.1.182',
			'649173b14aadb8.17864349'
		);

		yield [
			'<RequestInfo>
				<Timestamp>1687253937</Timestamp>
				<Host>xml.centriumres.com.localdomain.ee</Host>
				<HostIP>10.0.1.182</HostIP>
				<ReqID>649173b14aadb8.17864349</ReqID>
				<TimestampISO>2023-06-20T09:38:57+00:00</TimestampISO>
			</RequestInfo>',
			$requestInfo
		];

		$returnStatusTrue = new ReturnStatus(true);

		yield [
			'<ReturnStatus>
				<Success>True</Success>
				<Exception/>
			</ReturnStatus>',
			$returnStatusTrue
		];

		$returnBookingStatusFalse = new ReturnStatus(
			false,
			'Supplier Reference not found for Booking Reference HCL0011 in SupplierBooking'
		);

		yield [
			'<ReturnStatus>
				<Success>False</Success>
				<Exception>Supplier Reference not found for Booking Reference HCL0011 in SupplierBooking</Exception>
			</ReturnStatus>',
			$returnBookingStatusFalse
		];

		$returnSerachStatusFalse = new ReturnStatus(
			false,
			'Could not find any rooms for RoomRequest'
		);

		yield [
			'<ReturnStatus>
				<Success>False</Success>
				<Exception>Could not find any rooms for RoomRequest</Exception>
			</ReturnStatus>',
			$returnSerachStatusFalse
		];

		$roomsAppliesTo = new RoomsAppliesTo(1);
		yield [
			'<RoomsAppliesTo>
				<RoomRequest>1</RoomRequest>
			</RoomsAppliesTo>',
			$roomsAppliesTo
		];

		yield [
			'<RoomsAppliesTo>
				<RoomRequest>1</RoomRequest>
				<RoomRequest>2</RoomRequest>
				<RoomRequest>3</RoomRequest>
				<RoomRequest>4</RoomRequest>
			</RoomsAppliesTo>',
			new RoomsAppliesTo(1, 2, 3, 4)
		];

		$supplementWeekend = new Supplement(
			'Weekend Stay (Fri - Sun)',
			'Per Night',
			'Per Room',
			60
		);

		yield [
			'<Supplement>
				<Name>Weekend Stay (Fri - Sun)</Name>
				<Duration>Per Night</Duration>
				<Multiplier>Per Room</Multiplier>
				<PaxType/>
				<Total>60</Total>
			</Supplement>',
			$supplementWeekend
		];

		$testSupplement = new Supplement(
			'test supplement',
			'Per Night',
			'Per Person',
			220,
			'Adult Only'
		);

		yield [
			'<Supplement>
				<Name>test supplement</Name>
				<Duration>Per Night</Duration>
				<Multiplier>Per Person</Multiplier>
				<PaxType>Adult Only</PaxType>
				<Total>220</Total>
			</Supplement>',
			$testSupplement
		];

		$oneSupplement = new Supplements($testSupplement);

		yield [
			'<Supplements>
				<Supplement>
					<Name>test supplement</Name>
					<Duration>Per Night</Duration>
					<Multiplier>Per Person</Multiplier>
					<Total>220</Total>
					<PaxType>Adult Only</PaxType>
				</Supplement>
			</Supplements>',
			$oneSupplement
		];

		$twoSupplements = new Supplements(
			$supplementWeekend,
			$testSupplement
		);

		yield [
			'<Supplements>
				<Supplement>
					<Name>Weekend Stay (Fri - Sun)</Name>
					<Duration>Per Night</Duration>
					<Multiplier>Per Room</Multiplier>
					<Total>60</Total>
				</Supplement>
				<Supplement>
					<Name>test supplement</Name>
					<Duration>Per Night</Duration>
					<Multiplier>Per Person</Multiplier>
					<Total>220</Total>
					<PaxType>Adult Only</PaxType>
				</Supplement>
			</Supplements>',
			$twoSupplements
		];
//30
		$specialOffer1 = new SpecialOffer(
			'Example special offer',
			'Value Added',
			null,
			null,
			null,
			'test desc'
		);

		yield [
			'<SpecialOffer>
				<Name>Example special offer</Name>
				<Type>Value Added</Type>
				<Desc>test desc</Desc>
			</SpecialOffer>',
			$specialOffer1
		];

		$specialOffer2 = new SpecialOffer(
			'Example special offer 2',
			'Free Kids',
			1,
			null,
			1000,
			'test desc'
		);

		yield [
			'<SpecialOffer>
				<Name>Example special offer 2</Name>
				<Value>1</Value>
				<Type>Free Kids</Type>
				<Total>1000</Total>
				<Desc>test desc</Desc>
			</SpecialOffer>',
			$specialOffer2
		];

		$oneSpecialOffer = new SpecialOffers($specialOffer1);
		yield [
			'<SpecialOffers>
				<SpecialOffer>
					<Name>Example special offer</Name>
					<Type>Value Added</Type>
					<Desc>test desc</Desc>
				</SpecialOffer>
			</SpecialOffers>',
			$oneSpecialOffer
		];

		$twoSpecialOffers = new SpecialOffers(
			$specialOffer1,
			$specialOffer2
		);

		yield [
			'<SpecialOffers>
				<SpecialOffer>
					<Name>Example special offer</Name>
					<Type>Value Added</Type>
					<Desc>test desc</Desc>
				</SpecialOffer>
				<SpecialOffer>
					<Name>Example special offer 2</Name>
					<Type>Free Kids</Type>
					<Value>1</Value>
					<Total>1000</Total>
					<Desc>test desc</Desc>
				</SpecialOffer>
			</SpecialOffers>',
			$twoSpecialOffers
		];

		$tax = new Tax(
			'test %',
			false,
			1148.55
		);

		yield [
			'<Tax>
				<Inclusive>False</Inclusive>
				<Total>1148.55</Total>
				<TaxName>test %</TaxName>
			</Tax>',
			$tax
		];

		$oneTax = new Taxes($tax);

		yield [
			'<Taxes>
				<Tax>
					<TaxName>test %</TaxName>
					<Inclusive>False</Inclusive>
					<Total>1148.55</Total>
				</Tax>
			</Taxes>',
			$oneTax
		];

		$fourTaxes = new Taxes(
			$tax,
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

		yield [
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
		];

		$cancellationPolicy = new CancellationPolicy(
			'2020-07-11',
			574.28
		);

		yield [
			'<CancellationPolicy>
				<CancelBy>2020-07-11</CancelBy>
				<Penalty>574.28</Penalty>
			</CancellationPolicy>',
			$cancellationPolicy
		];

		$oneCancellationPolicy = new CancellationPolicies($cancellationPolicy);
		yield [
			'<CancellationPolicies>
				<CancellationPolicy>
					<CancelBy>2020-07-11</CancelBy>
					<Penalty>574.28</Penalty>
				</CancellationPolicy>
			</CancellationPolicies>',
			$oneCancellationPolicy
		];


		$twoCancellationPolicy = new CancellationPolicies(
			$cancellationPolicy,
			new CancellationPolicy(
				'2020-07-18',
				1148.55
			)
		);

		yield [
			'<CancellationPolicies>
				<CancellationPolicy>
					<Penalty>574.28</Penalty>
					<CancelBy>2020-07-11</CancelBy>
				</CancellationPolicy>
				<CancellationPolicy>
					<CancelBy>2020-07-18</CancelBy>
					<Penalty>1148.55</Penalty>
				</CancellationPolicy>
			</CancellationPolicies>',
			$twoCancellationPolicy
		];
//40
		$roomType = new RoomType(
			999,
			null,
			1,
			1,
			'Example Villa',
			'Sea View',
			2,
			2,
			1,
			true,
			5896.80,
			6565.35,
			$roomsAppliesTo,
			$oneSupplement,
			$twoSpecialOffers,
			$fourTaxes,
			$twoCancellationPolicy,
		);

		yield [
			'<RoomType>
				<RoomID>999</RoomID>
				<PropertyRoomTypeID>1</PropertyRoomTypeID>
				<MealBasisID>1</MealBasisID>
				<Name>Example Villa</Name>
				<View>Sea View</View>
				<Adults>2</Adults>
				<Children>2</Children>
				<Infants>1</Infants>
				<OnRequest>True</OnRequest>
				<SubTotal>5896.8</SubTotal>
				<Total>6565.35</Total>
				<RoomsAppliesTo>
					<RoomRequest>1</RoomRequest>
				</RoomsAppliesTo>
				<Supplements>
					<Supplement>
						<Name>test supplement</Name>
						<Duration>Per Night</Duration>
						<Multiplier>Per Person</Multiplier>
						<Total>220</Total>
						<PaxType>Adult Only</PaxType>
					</Supplement>
				</Supplements>
				<SpecialOffers>
					<SpecialOffer>
						<Name>Example special offer</Name>
						<Type>Value Added</Type>
						<Desc>test desc</Desc>
					</SpecialOffer>
					<SpecialOffer>
						<Name>Example special offer 2</Name>
						<Type>Free Kids</Type>
						<Value>1</Value>
						<Total>1000</Total>
						<Desc>test desc</Desc>
					</SpecialOffer>
				</SpecialOffers>
				<Taxes>
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
				</Taxes>
				<CancellationPolicies>
					<CancellationPolicy>
						<CancelBy>2020-07-11</CancelBy>
						<Penalty>574.28</Penalty>
					</CancellationPolicy>
					<CancellationPolicy>
						<CancelBy>2020-07-18</CancelBy>
						<Penalty>1148.55</Penalty>
					</CancellationPolicy>
				</CancellationPolicies>
			</RoomType>',
			$roomType
		];

		$oneRoomType = new RoomTypes($roomType);

		yield [
			'<RoomTypes>
				<RoomType>
					<RoomID>999</RoomID>
					<PropertyRoomTypeID>1</PropertyRoomTypeID>
					<MealBasisID>1</MealBasisID>
					<Name>Example Villa</Name>
					<View>Sea View</View>
					<Adults>2</Adults>
					<Children>2</Children>
					<Infants>1</Infants>
					<OnRequest>True</OnRequest>
					<SubTotal>5896.8</SubTotal>
					<Total>6565.35</Total>
					<RoomsAppliesTo>
						<RoomRequest>1</RoomRequest>
					</RoomsAppliesTo>
					<Supplements>
						<Supplement>
							<Name>test supplement</Name>
							<Duration>Per Night</Duration>
							<Multiplier>Per Person</Multiplier>
							<Total>220</Total>
							<PaxType>Adult Only</PaxType>
						</Supplement>
					</Supplements>
					<SpecialOffers>
						<SpecialOffer>
							<Name>Example special offer</Name>
							<Type>Value Added</Type>
							<Desc>test desc</Desc>
						</SpecialOffer>
						<SpecialOffer>
							<Name>Example special offer 2</Name>
							<Type>Free Kids</Type>
							<Value>1</Value>
							<Total>1000</Total>
							<Desc>test desc</Desc>
						</SpecialOffer>
					</SpecialOffers>
					<Taxes>
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
					</Taxes>
					<CancellationPolicies>
						<CancellationPolicy>
							<CancelBy>2020-07-11</CancelBy>
							<Penalty>574.28</Penalty>
						</CancellationPolicy>
						<CancellationPolicy>
							<CancelBy>2020-07-18</CancelBy>
							<Penalty>1148.55</Penalty>
						</CancellationPolicy>
					</CancellationPolicies>
				</RoomType>
			</RoomTypes>',
			$oneRoomType
		];

		$twoRoomType = new RoomTypes(
			$roomType,
			$roomType = new RoomType(
				998,
				null,
				null,
				1,
				'Example Villa',
				'Sea View',
				2,
				0,
				0,
				true,
				3960,
				4400,
				new RoomsAppliesTo(2),
				null,
				new SpecialOffers(
					new SpecialOffer(
						'Early Bird Booking',
						'Adult Only',
						10,
						'All',
						440
					)
				),
				new Taxes(
					new Tax(
						'Government Tax',
						true,
						423.15
					)
				),
				new CancellationPolicies(
					new CancellationPolicy(
						'2020-07-18',
						440
					)
				),
			)
		);


		yield [
			'<RoomTypes>
				<RoomType>
					<RoomID>999</RoomID>
					<PropertyRoomTypeID>1</PropertyRoomTypeID>
					<MealBasisID>1</MealBasisID>
					<Name>Example Villa</Name>
					<View>Sea View</View>
					<Adults>2</Adults>
					<Children>2</Children>
					<Infants>1</Infants>
					<OnRequest>True</OnRequest>
					<SubTotal>5896.8</SubTotal>
					<Total>6565.35</Total>
					<RoomsAppliesTo>
						<RoomRequest>1</RoomRequest>
					</RoomsAppliesTo>
					<Supplements>
						<Supplement>
							<Name>test supplement</Name>
							<Duration>Per Night</Duration>
							<Multiplier>Per Person</Multiplier>
							<Total>220</Total>
							<PaxType>Adult Only</PaxType>
						</Supplement>
					</Supplements>
					<SpecialOffers>
						<SpecialOffer>
							<Name>Example special offer</Name>
							<Type>Value Added</Type>
							<Desc>test desc</Desc>
						</SpecialOffer>
						<SpecialOffer>
							<Name>Example special offer 2</Name>
							<Type>Free Kids</Type>
							<Value>1</Value>
							<Total>1000</Total>
							<Desc>test desc</Desc>
						</SpecialOffer>
					</SpecialOffers>
					<Taxes>
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
					</Taxes>
					<CancellationPolicies>
						<CancellationPolicy>
							<CancelBy>2020-07-11</CancelBy>
							<Penalty>574.28</Penalty>
						</CancellationPolicy>
						<CancellationPolicy>
							<CancelBy>2020-07-18</CancelBy>
							<Penalty>1148.55</Penalty>
						</CancellationPolicy>
					</CancellationPolicies>
				</RoomType>
				<RoomType>
					<RoomID>998</RoomID>
					<PropertyRoomTypeID/>
					<MealBasisID>1</MealBasisID>
					<Name>Example Villa</Name>
					<View>Sea View</View>
					<Adults>2</Adults>
					<Children>0</Children>
					<Infants>0</Infants>
					<OnRequest>True</OnRequest>
					<SubTotal>3960</SubTotal>
					<Total>4400</Total>
					<RoomsAppliesTo>
						<RoomRequest>2</RoomRequest>
					</RoomsAppliesTo>
					<Supplements/>
					<SpecialOffers>
						<SpecialOffer>
							<Name>Early Bird Booking</Name>
							<Type>Adult Only</Type>
							<Value>10</Value>
							<PaxType>All</PaxType>
							<Total>440</Total>
							<Desc/>
						</SpecialOffer>
					</SpecialOffers>
					<Taxes>
						<Tax>
							<TaxName>Government Tax</TaxName>
							<Inclusive>True</Inclusive>
							<Total>423.15</Total>
						</Tax>
					</Taxes>
					<CancellationPolicies>
						<CancellationPolicy>
							<CancelBy>2020-07-18</CancelBy>
							<Penalty>440</Penalty>
						</CancellationPolicy>
					</CancellationPolicies>
				</RoomType>
			</RoomTypes>',
			$twoRoomType
		];

		$supplier = new Supplier(
			6,
			'RMI'
		);

		yield [
			'<Supplier>
				<SupplierID>6</SupplierID>
				<SupplierName>RMI</SupplierName>
			</Supplier>',
			$supplier
		];

		$erratum = new Erratum(
			'2020-08-04',
			'2020-08-11',
			'Small pool will be closed for maintenance'
		);

		yield [
			'<Erratum>
				<StartDate>2020-08-04</StartDate>
				<EndDate>2020-08-11</EndDate>
				<Description>Small pool will be closed for maintenance</Description>
			</Erratum>',
			$erratum
		];

		$oneErratum = new Errata($erratum);

		yield [
			'<Errata>
				<Erratum>
					<StartDate>2020-08-04</StartDate>
					<EndDate>2020-08-11</EndDate>
					<Description>Small pool will be closed for maintenance</Description>
				</Erratum>
			</Errata>',
			$oneErratum
		];

		$twoErrata = new Errata(
			$erratum,
			new Erratum(
				'2020-08-04',
				'2020-08-11',
				'There won\'t be mayonese at the restaurant'
			)
		);

		yield [
			'<Errata>
				<Erratum>
					<StartDate>2020-08-04</StartDate>
					<EndDate>2020-08-11</EndDate>
					<Description>Small pool will be closed for maintenance</Description>
				</Erratum>
				<Erratum>
					<StartDate>2020-08-04</StartDate>
					<EndDate>2020-08-11</EndDate>
					<Description>There won\'t be mayonese at the restaurant</Description>
				</Erratum>
			</Errata>',
			$twoErrata
		];

		$image1000 = new Image(
			'CMSImage_1000.jpg',
			'CMSImageThumb_1000.jpg'
		);

		yield [
			'<Image>
				<FullSize>CMSImage_1000.jpg</FullSize>
				<Thumbnail>CMSImageThumb_1000.jpg</Thumbnail>
			</Image>',
			$image1000
		];

		$oneImage = new Images($image1000);

		yield [
			'<Images>
				<Image>
					<FullSize>CMSImage_1000.jpg</FullSize>
					<Thumbnail>CMSImageThumb_1000.jpg</Thumbnail>
				</Image>
			</Images>',
			$oneImage
		];

		$twoImages = new Images(
			$image1000,
			new Image(
			'CMSImage_1001.jpg',
			'CMSImageThumb_1001.jpg'
			)
		);

		yield [
			'<Images>
				<Image>
					<FullSize>CMSImage_1000.jpg</FullSize>
					<Thumbnail>CMSImageThumb_1000.jpg</Thumbnail>
				</Image>
				<Image>
					<FullSize>CMSImage_1001.jpg</FullSize>
					<Thumbnail>CMSImageThumb_1001.jpg</Thumbnail>
				</Image>
			</Images>',
			$twoImages
		];
//50
		$propertyResult = new PropertyResult(
			99,
			$twoRoomType,
			'Example Island',
			99999,
			'USD',
			4.5,
			6,
			10,
			22,
			'West Indies',
			'St Vincent & Grenadines',
			'Example Island',
			null,
			null,
			null,
			null,
			null,
			null,
			'Intimate, exotic and all-inclusive',
			'Example Island, a high-end luxury resort',
			'https://xmlhost/custom/content/',
			'CMSImage_999.jpg',
			'CMSImageThumb_999.jpg',
			$twoImages,
			$oneErratum,
			$supplier
		);

		yield [
			'<PropertyResult>
				<PropertyID>99</PropertyID>
				<RoomTypes>
					<RoomType>
						<RoomID>999</RoomID>
						<PropertyRoomTypeID>1</PropertyRoomTypeID>
						<MealBasisID>1</MealBasisID>
						<Name>Example Villa</Name>
						<View>Sea View</View>
						<Adults>2</Adults>
						<Children>2</Children>
						<Infants>1</Infants>
						<OnRequest>True</OnRequest>
						<SubTotal>5896.8</SubTotal>
						<Total>6565.35</Total>
						<RoomsAppliesTo>
							<RoomRequest>1</RoomRequest>
						</RoomsAppliesTo>
						<Supplements>
							<Supplement>
								<Name>test supplement</Name>
								<Duration>Per Night</Duration>
								<Multiplier>Per Person</Multiplier>
								<Total>220</Total>
								<PaxType>Adult Only</PaxType>
							</Supplement>
						</Supplements>
						<SpecialOffers>
							<SpecialOffer>
								<Name>Example special offer</Name>
								<Type>Value Added</Type>
								<Desc>test desc</Desc>
							</SpecialOffer>
							<SpecialOffer>
								<Name>Example special offer 2</Name>
								<Type>Free Kids</Type>
								<Value>1</Value>
								<Total>1000</Total>
								<Desc>test desc</Desc>
							</SpecialOffer>
						</SpecialOffers>
						<Taxes>
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
						</Taxes>
						<CancellationPolicies>
							<CancellationPolicy>
								<CancelBy>2020-07-11</CancelBy>
								<Penalty>574.28</Penalty>
							</CancellationPolicy>
							<CancellationPolicy>
								<CancelBy>2020-07-18</CancelBy>
								<Penalty>1148.55</Penalty>
							</CancellationPolicy>
						</CancellationPolicies>
					</RoomType>
					<RoomType>
						<RoomID>998</RoomID>
						<MealBasisID>1</MealBasisID>
						<Name>Example Villa</Name>
						<View>Sea View</View>
						<Adults>2</Adults>
						<Children>0</Children>
						<Infants>0</Infants>
						<OnRequest>True</OnRequest>
						<SubTotal>3960</SubTotal>
						<Total>4400</Total>
						<RoomsAppliesTo>
							<RoomRequest>2</RoomRequest>
						</RoomsAppliesTo>
						<Supplements/>
						<SpecialOffers>
							<SpecialOffer>
								<Name>Early Bird Booking</Name>
								<Type>Adult Only</Type>
								<Value>10</Value>
								<PaxType>All</PaxType>
								<Total>440</Total>
								<Desc/>
							</SpecialOffer>
						</SpecialOffers>
						<Taxes>
							<Tax>
								<TaxName>Government Tax</TaxName>
								<Inclusive>True</Inclusive>
								<Total>423.15</Total>
							</Tax>
						</Taxes>
						<CancellationPolicies>
							<CancellationPolicy>
								<CancelBy>2020-07-18</CancelBy>
								<Penalty>440</Penalty>
							</CancellationPolicy>
						</CancellationPolicies>
					</RoomType>
				</RoomTypes>
				<PropertyName>Example Island</PropertyName>
				<Supplier>
					<SupplierID>6</SupplierID>
					<SupplierName>RMI</SupplierName>
				</Supplier>
				<GIATAID>99999</GIATAID>
				<Currency>USD</Currency>
				<Rating>4.5</Rating>
				<GeographyLevel1ID>6</GeographyLevel1ID>
				<GeographyLevel2ID>10</GeographyLevel2ID>
				<GeographyLevel3ID>22</GeographyLevel3ID>
				<Country>West Indies</Country>
				<Area>St Vincent &amp; Grenadines</Area>
				<Region>Example Island</Region>
				<Email/>
				<Postcode/>
				<Address1/>
				<Address2/>
				<Strapline>Intimate, exotic and all-inclusive</Strapline>
				<Description>Example Island, a high-end luxury resort</Description>
				<CMSBaseURL>https://xmlhost/custom/content/</CMSBaseURL>
				<MainImage>CMSImage_999.jpg</MainImage>
				<MainImageThumbnail>CMSImageThumb_999.jpg</MainImageThumbnail>
				<Images>
					<Image>
						<FullSize>CMSImage_1000.jpg</FullSize>
						<Thumbnail>CMSImageThumb_1000.jpg</Thumbnail>
					</Image>
					<Image>
						<FullSize>CMSImage_1001.jpg</FullSize>
						<Thumbnail>CMSImageThumb_1001.jpg</Thumbnail>
					</Image>
				</Images>
				<Errata>
					<Erratum>
						<StartDate>2020-08-04</StartDate>
						<EndDate>2020-08-11</EndDate>
						<Description>Small pool will be closed for maintenance</Description>
					</Erratum>
				</Errata>
			</PropertyResult>',
			$propertyResult
		];

		$onePropertyResult = PropertyResults::fromPropertyResults($propertyResult);

		yield [
			'<PropertyResults>
				<TotalProperties>1</TotalProperties>
				<PropertyResult>
					<PropertyID>99</PropertyID>
					<RoomTypes>
						<RoomType>
							<RoomID>999</RoomID>
							<PropertyRoomTypeID>1</PropertyRoomTypeID>
							<MealBasisID>1</MealBasisID>
							<Name>Example Villa</Name>
							<View>Sea View</View>
							<Adults>2</Adults>
							<Children>2</Children>
							<Infants>1</Infants>
							<OnRequest>True</OnRequest>
							<SubTotal>5896.8</SubTotal>
							<Total>6565.35</Total>
							<RoomsAppliesTo>
								<RoomRequest>1</RoomRequest>
							</RoomsAppliesTo>
							<Supplements>
								<Supplement>
									<Name>test supplement</Name>
									<Duration>Per Night</Duration>
									<Multiplier>Per Person</Multiplier>
									<Total>220</Total>
									<PaxType>Adult Only</PaxType>
								</Supplement>
							</Supplements>
							<SpecialOffers>
								<SpecialOffer>
									<Name>Example special offer</Name>
									<Type>Value Added</Type>
									<Desc>test desc</Desc>
								</SpecialOffer>
								<SpecialOffer>
									<Name>Example special offer 2</Name>
									<Type>Free Kids</Type>
									<Value>1</Value>
									<Total>1000</Total>
									<Desc>test desc</Desc>
								</SpecialOffer>
							</SpecialOffers>
							<Taxes>
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
							</Taxes>
							<CancellationPolicies>
								<CancellationPolicy>
									<CancelBy>2020-07-11</CancelBy>
									<Penalty>574.28</Penalty>
								</CancellationPolicy>
								<CancellationPolicy>
									<CancelBy>2020-07-18</CancelBy>
									<Penalty>1148.55</Penalty>
								</CancellationPolicy>
							</CancellationPolicies>
						</RoomType>
						<RoomType>
							<RoomID>998</RoomID>
							<MealBasisID>1</MealBasisID>
							<Name>Example Villa</Name>
							<View>Sea View</View>
							<Adults>2</Adults>
							<Children>0</Children>
							<Infants>0</Infants>
							<OnRequest>True</OnRequest>
							<SubTotal>3960</SubTotal>
							<Total>4400</Total>
							<RoomsAppliesTo>
								<RoomRequest>2</RoomRequest>
							</RoomsAppliesTo>
							<SpecialOffers>
								<SpecialOffer>
									<Name>Early Bird Booking</Name>
									<Type>Adult Only</Type>
									<Value>10</Value>
									<PaxType>All</PaxType>
									<Total>440</Total>
								</SpecialOffer>
							</SpecialOffers>
							<Taxes>
								<Tax>
									<TaxName>Government Tax</TaxName>
									<Inclusive>True</Inclusive>
									<Total>423.15</Total>
								</Tax>
							</Taxes>
							<CancellationPolicies>
								<CancellationPolicy>
									<CancelBy>2020-07-18</CancelBy>
									<Penalty>440</Penalty>
								</CancellationPolicy>
							</CancellationPolicies>
						</RoomType>
					</RoomTypes>
					<PropertyName>Example Island</PropertyName>
					<Supplier>
						<SupplierID>6</SupplierID>
						<SupplierName>RMI</SupplierName>
					</Supplier>
					<GIATAID>99999</GIATAID>
					<Currency>USD</Currency>
					<Rating>4.5</Rating>
					<GeographyLevel1ID>6</GeographyLevel1ID>
					<GeographyLevel2ID>10</GeographyLevel2ID>
					<GeographyLevel3ID>22</GeographyLevel3ID>
					<Country>West Indies</Country>
					<Area>St Vincent &amp; Grenadines</Area>
					<Region>Example Island</Region>
					<Email/>
					<Postcode/>
					<Address1/>
					<Address2/>
					<Strapline>Intimate, exotic and all-inclusive</Strapline>
					<Description>Example Island, a high-end luxury resort</Description>
					<CMSBaseURL>https://xmlhost/custom/content/</CMSBaseURL>
					<MainImage>CMSImage_999.jpg</MainImage>
					<MainImageThumbnail>CMSImageThumb_999.jpg</MainImageThumbnail>
					<Images>
						<Image>
							<FullSize>CMSImage_1000.jpg</FullSize>
							<Thumbnail>CMSImageThumb_1000.jpg</Thumbnail>
						</Image>
						<Image>
							<FullSize>CMSImage_1001.jpg</FullSize>
							<Thumbnail>CMSImageThumb_1001.jpg</Thumbnail>
						</Image>
					</Images>
					<Errata>
						<Erratum>
							<StartDate>2020-08-04</StartDate>
							<EndDate>2020-08-11</EndDate>
							<Description>Small pool will be closed for maintenance</Description>
						</Erratum>
					</Errata>
				</PropertyResult>
			</PropertyResults>',
			$onePropertyResult
		];

		yield [
			'<PropertyResults>
				<TotalProperties>2</TotalProperties>
				<PropertyResult>
					<PropertyID>99</PropertyID>
					<RoomTypes>
						<RoomType>
							<RoomID>999</RoomID>
							<PropertyRoomTypeID>1</PropertyRoomTypeID>
							<MealBasisID>1</MealBasisID>
							<Name>Example Villa</Name>
							<View>Sea View</View>
							<Adults>2</Adults>
							<Children>2</Children>
							<Infants>1</Infants>
							<OnRequest>True</OnRequest>
							<SubTotal>5896.8</SubTotal>
							<Total>6565.35</Total>
							<RoomsAppliesTo>
								<RoomRequest>1</RoomRequest>
							</RoomsAppliesTo>
							<Supplements>
								<Supplement>
									<Name>test supplement</Name>
									<Duration>Per Night</Duration>
									<Multiplier>Per Person</Multiplier>
									<Total>220</Total>
									<PaxType>Adult Only</PaxType>
								</Supplement>
							</Supplements>
							<SpecialOffers>
								<SpecialOffer>
									<Name>Example special offer</Name>
									<Type>Value Added</Type>
									<Desc>test desc</Desc>
								</SpecialOffer>
								<SpecialOffer>
									<Name>Example special offer 2</Name>
									<Type>Free Kids</Type>
									<Value>1</Value>
									<Total>1000</Total>
									<Desc>test desc</Desc>
								</SpecialOffer>
							</SpecialOffers>
							<Taxes>
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
							</Taxes>
							<CancellationPolicies>
								<CancellationPolicy>
									<CancelBy>2020-07-11</CancelBy>
									<Penalty>574.28</Penalty>
								</CancellationPolicy>
								<CancellationPolicy>
									<CancelBy>2020-07-18</CancelBy>
									<Penalty>1148.55</Penalty>
								</CancellationPolicy>
							</CancellationPolicies>
						</RoomType>
						<RoomType>
							<RoomID>998</RoomID>
							<MealBasisID>1</MealBasisID>
							<Name>Example Villa</Name>
							<View>Sea View</View>
							<Adults>2</Adults>
							<Children>0</Children>
							<Infants>0</Infants>
							<OnRequest>True</OnRequest>
							<SubTotal>3960</SubTotal>
							<Total>4400</Total>
							<RoomsAppliesTo>
								<RoomRequest>2</RoomRequest>
							</RoomsAppliesTo>
							<SpecialOffers>
								<SpecialOffer>
									<Name>Early Bird Booking</Name>
									<Type>Adult Only</Type>
									<Value>10</Value>
									<PaxType>All</PaxType>
									<Desc/>
									<Total>440</Total>
								</SpecialOffer>
							</SpecialOffers>
							<Taxes>
								<Tax>
									<TaxName>Government Tax</TaxName>
									<Inclusive>True</Inclusive>
									<Total>423.15</Total>
								</Tax>
							</Taxes>
							<CancellationPolicies>
								<CancellationPolicy>
									<CancelBy>2020-07-18</CancelBy>
									<Penalty>440</Penalty>
								</CancellationPolicy>
							</CancellationPolicies>
						</RoomType>
					</RoomTypes>
					<PropertyName>Example Island</PropertyName>
					<Supplier>
						<SupplierID>6</SupplierID>
						<SupplierName>RMI</SupplierName>
					</Supplier>
					<GIATAID>99999</GIATAID>
					<Currency>USD</Currency>
					<Rating>4.5</Rating>
					<GeographyLevel1ID>6</GeographyLevel1ID>
					<GeographyLevel2ID>10</GeographyLevel2ID>
					<GeographyLevel3ID>22</GeographyLevel3ID>
					<Country>West Indies</Country>
					<Area>St Vincent &amp; Grenadines</Area>
					<Region>Example Island</Region>
					<Email/>
					<Postcode/>
					<Address1/>
					<Address2/>
					<Strapline>Intimate, exotic and all-inclusive</Strapline>
					<Description>Example Island, a high-end luxury resort</Description>
					<CMSBaseURL>https://xmlhost/custom/content/</CMSBaseURL>
					<MainImage>CMSImage_999.jpg</MainImage>
					<MainImageThumbnail>CMSImageThumb_999.jpg</MainImageThumbnail>
					<Images>
						<Image>
							<FullSize>CMSImage_1000.jpg</FullSize>
							<Thumbnail>CMSImageThumb_1000.jpg</Thumbnail>
						</Image>
						<Image>
							<FullSize>CMSImage_1001.jpg</FullSize>
							<Thumbnail>CMSImageThumb_1001.jpg</Thumbnail>
						</Image>
					</Images>
					<Errata>
						<Erratum>
							<StartDate>2020-08-04</StartDate>
							<EndDate>2020-08-11</EndDate>
							<Description>Small pool will be closed for maintenance</Description>
						</Erratum>
					</Errata>
				</PropertyResult>
				<PropertyResult>
					<PropertyID>99</PropertyID>
					<RoomTypes>
						<RoomType>
							<RoomID>999</RoomID>
							<PropertyRoomTypeID>1</PropertyRoomTypeID>
							<MealBasisID>1</MealBasisID>
							<Name>Example Villa</Name>
							<View>Sea View</View>
							<Adults>2</Adults>
							<Children>2</Children>
							<Infants>1</Infants>
							<OnRequest>True</OnRequest>
							<SubTotal>5896.8</SubTotal>
							<Total>6565.35</Total>
							<RoomsAppliesTo>
								<RoomRequest>1</RoomRequest>
							</RoomsAppliesTo>
							<Supplements>
								<Supplement>
									<Name>test supplement</Name>
									<Duration>Per Night</Duration>
									<Multiplier>Per Person</Multiplier>
									<Total>220</Total>
									<PaxType>Adult Only</PaxType>
								</Supplement>
							</Supplements>
							<SpecialOffers>
								<SpecialOffer>
									<Name>Example special offer</Name>
									<Type>Value Added</Type>
									<Desc>test desc</Desc>
								</SpecialOffer>
								<SpecialOffer>
									<Name>Example special offer 2</Name>
									<Type>Free Kids</Type>
									<Value>1</Value>
									<Total>1000</Total>
									<Desc>test desc</Desc>
								</SpecialOffer>
							</SpecialOffers>
							<Taxes>
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
							</Taxes>
							<CancellationPolicies>
								<CancellationPolicy>
									<CancelBy>2020-07-11</CancelBy>
									<Penalty>574.28</Penalty>
								</CancellationPolicy>
								<CancellationPolicy>
									<CancelBy>2020-07-18</CancelBy>
									<Penalty>1148.55</Penalty>
								</CancellationPolicy>
							</CancellationPolicies>
						</RoomType>
						<RoomType>
							<RoomID>998</RoomID>
							<MealBasisID>1</MealBasisID>
							<Name>Example Villa</Name>
							<View>Sea View</View>
							<Adults>2</Adults>
							<Children>0</Children>
							<Infants>0</Infants>
							<OnRequest>True</OnRequest>
							<SubTotal>3960</SubTotal>
							<Total>4400</Total>
							<RoomsAppliesTo>
								<RoomRequest>2</RoomRequest>
							</RoomsAppliesTo>
							<SpecialOffers>
								<SpecialOffer>
									<Name>Early Bird Booking</Name>
									<Type>Adult Only</Type>
									<Value>10</Value>
									<PaxType>All</PaxType>
									<Total>440</Total>
								</SpecialOffer>
							</SpecialOffers>
							<Taxes>
								<Tax>
									<TaxName>Government Tax</TaxName>
									<Inclusive>True</Inclusive>
									<Total>423.15</Total>
								</Tax>
							</Taxes>
							<CancellationPolicies>
								<CancellationPolicy>
									<CancelBy>2020-07-18</CancelBy>
									<Penalty>440</Penalty>
								</CancellationPolicy>
							</CancellationPolicies>
						</RoomType>
					</RoomTypes>
					<PropertyName>Example Island</PropertyName>
					<Supplier>
						<SupplierID>6</SupplierID>
						<SupplierName>RMI</SupplierName>
					</Supplier>
					<GIATAID>99999</GIATAID>
					<Currency>USD</Currency>
					<Rating>4.5</Rating>
					<GeographyLevel1ID>6</GeographyLevel1ID>
					<GeographyLevel2ID>10</GeographyLevel2ID>
					<GeographyLevel3ID>22</GeographyLevel3ID>
					<Country>West Indies</Country>
					<Area>St Vincent &amp; Grenadines</Area>
					<Region>Example Island</Region>
					<Email/>
					<Postcode/>
					<Address1/>
					<Address2/>
					<Strapline>Intimate, exotic and all-inclusive</Strapline>
					<Description>Example Island, a high-end luxury resort</Description>
					<CMSBaseURL>https://xmlhost/custom/content/</CMSBaseURL>
					<MainImage>CMSImage_999.jpg</MainImage>
					<MainImageThumbnail>CMSImageThumb_999.jpg</MainImageThumbnail>
					<Images>
						<Image>
							<FullSize>CMSImage_1000.jpg</FullSize>
							<Thumbnail>CMSImageThumb_1000.jpg</Thumbnail>
						</Image>
						<Image>
							<FullSize>CMSImage_1001.jpg</FullSize>
							<Thumbnail>CMSImageThumb_1001.jpg</Thumbnail>
						</Image>
					</Images>
					<Errata>
						<Erratum>
							<StartDate>2020-08-04</StartDate>
							<EndDate>2020-08-11</EndDate>
							<Description>Small pool will be closed for maintenance</Description>
						</Erratum>
					</Errata>
				</PropertyResult>
			</PropertyResults>',
			PropertyResults::fromPropertyResults(
				$propertyResult,
				$propertyResult
			)
		];
//52
		yield [
			'<SearchResponse>
				<RequestInfo>
					<Timestamp>1687253937</Timestamp>
					<TimestampISO>2023-06-20T09:38:57+00:00</TimestampISO>
					<Host>xml.centriumres.com.localdomain.ee</Host>
					<HostIP>10.0.1.182</HostIP>
					<ReqID>649173b14aadb8.17864349</ReqID>
				</RequestInfo>
				<ReturnStatus>
					<Success>True</Success>
					<Exception/>
				</ReturnStatus>
				<PropertyResults>
					<TotalProperties>1</TotalProperties>
					<PropertyResult>
						<PropertyID>99</PropertyID>
						<RoomTypes>
							<RoomType>
								<RoomID>999</RoomID>
								<PropertyRoomTypeID>1</PropertyRoomTypeID>
								<MealBasisID>1</MealBasisID>
								<Name>Example Villa</Name>
								<View>Sea View</View>
								<Adults>2</Adults>
								<Children>2</Children>
								<Infants>1</Infants>
								<OnRequest>True</OnRequest>
								<SubTotal>5896.8</SubTotal>
								<Total>6565.35</Total>
								<RoomsAppliesTo>
									<RoomRequest>1</RoomRequest>
								</RoomsAppliesTo>
								<Supplements>
									<Supplement>
										<Name>test supplement</Name>
										<Duration>Per Night</Duration>
										<Multiplier>Per Person</Multiplier>
										<Total>220</Total>
										<PaxType>Adult Only</PaxType>
									</Supplement>
								</Supplements>
								<SpecialOffers>
									<SpecialOffer>
										<Name>Example special offer</Name>
										<Type>Value Added</Type>
										<Desc>test desc</Desc>
									</SpecialOffer>
									<SpecialOffer>
										<Name>Example special offer 2</Name>
										<Type>Free Kids</Type>
										<Value>1</Value>
										<Total>1000</Total>
										<Desc>test desc</Desc>
									</SpecialOffer>
								</SpecialOffers>
								<Taxes>
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
								</Taxes>
								<CancellationPolicies>
									<CancellationPolicy>
										<CancelBy>2020-07-11</CancelBy>
										<Penalty>574.28</Penalty>
									</CancellationPolicy>
									<CancellationPolicy>
										<CancelBy>2020-07-18</CancelBy>
										<Penalty>1148.55</Penalty>
									</CancellationPolicy>
								</CancellationPolicies>
							</RoomType>
							<RoomType>
								<RoomID>998</RoomID>
								<PropertyRoomTypeID/>
								<MealBasisID>1</MealBasisID>
								<Name>Example Villa</Name>
								<View>Sea View</View>
								<Adults>2</Adults>
								<Children>0</Children>
								<Infants>0</Infants>
								<OnRequest>True</OnRequest>
								<SubTotal>3960</SubTotal>
								<Total>4400</Total>
								<RoomsAppliesTo>
									<RoomRequest>2</RoomRequest>
								</RoomsAppliesTo>
								<SpecialOffers>
									<SpecialOffer>
										<Name>Early Bird Booking</Name>
										<Type>Adult Only</Type>
										<Value>10</Value>
										<PaxType>All</PaxType>
										<Total>440</Total>
										<Desc/>
									</SpecialOffer>
								</SpecialOffers>
								<Taxes>
									<Tax>
										<TaxName>Government Tax</TaxName>
										<Inclusive>True</Inclusive>
										<Total>423.15</Total>
									</Tax>
								</Taxes>
								<CancellationPolicies>
									<CancellationPolicy>
										<CancelBy>2020-07-18</CancelBy>
										<Penalty>440</Penalty>
									</CancellationPolicy>
								</CancellationPolicies>
							</RoomType>
						</RoomTypes>
						<PropertyName>Example Island</PropertyName>
						<Supplier>
							<SupplierID>6</SupplierID>
							<SupplierName>RMI</SupplierName>
						</Supplier>
						<GIATAID>99999</GIATAID>
						<Currency>USD</Currency>
						<Rating>4.5</Rating>
						<GeographyLevel1ID>6</GeographyLevel1ID>
						<GeographyLevel2ID>10</GeographyLevel2ID>
						<GeographyLevel3ID>22</GeographyLevel3ID>
						<Country>West Indies</Country>
						<Area>St Vincent &amp; Grenadines</Area>
						<Region>Example Island</Region>
						<Email/>
						<Postcode/>
						<Address1/>
						<Address2/>
						<Strapline>Intimate, exotic and all-inclusive</Strapline>
						<Description>Example Island, a high-end luxury resort</Description>
						<CMSBaseURL>https://xmlhost/custom/content/</CMSBaseURL>
						<MainImage>CMSImage_999.jpg</MainImage>
						<MainImageThumbnail>CMSImageThumb_999.jpg</MainImageThumbnail>
						<Images>
							<Image>
								<FullSize>CMSImage_1000.jpg</FullSize>
								<Thumbnail>CMSImageThumb_1000.jpg</Thumbnail>
							</Image>
							<Image>
								<FullSize>CMSImage_1001.jpg</FullSize>
								<Thumbnail>CMSImageThumb_1001.jpg</Thumbnail>
							</Image>
						</Images>
						<Errata>
							<Erratum>
								<StartDate>2020-08-04</StartDate>
								<EndDate>2020-08-11</EndDate>
								<Description>Small pool will be closed for maintenance</Description>
							</Erratum>
						</Errata>
					</PropertyResult>
				</PropertyResults>
			</SearchResponse>',
			new SearchResponse(
				$requestInfo,
				$returnStatusTrue,
				$onePropertyResult
			)
		];

		$simpleLeadGuestBook = new LeadGuest(
			'Jim',
			'Watsworth',
			'Mr'
		);
//53
		yield [
			'<LeadGuest>
				<FirstName>Jim</FirstName>
				<LastName>Watsworth</LastName>
				<Title>Mr</Title>
			</LeadGuest>',
			$simpleLeadGuestBook
		];

		$leadGuestBook = new LeadGuest(
			'Jim',
			'Watsworth',
			'Mr',
			'Address line 1',
			null,
			'London',
			null,
			null,
			null,
			'email@example.com'
		);

		yield [
			'<LeadGuest>
				<FirstName>Jim</FirstName>
				<LastName>Watsworth</LastName>
				<Title>Mr</Title>
				<Address1>Address line 1</Address1>
				<TownCity>London</TownCity>
				<Email>email@example.com</Email>
			</LeadGuest>',
			$leadGuestBook
		];

		$adultGuestBook = new Guest(
			'Adult',
			'Sally',
			'Smith',
			'Mrs',
			null,
			'French'
		);
		yield [
			'<Guest>
				<Type>Adult</Type>
				<FirstName>Sally</FirstName>
				<LastName>Smith</LastName>
				<Title>Mrs</Title>
				<Nationality>French</Nationality>
			</Guest>',
			$adultGuestBook
		];

		$childGuestBook = new Guest(
			'Child',
			'Jimmy',
			'Smith',
			null,
			5,
			'French'
		);

		yield [
			'<Guest>
				<Type>Child</Type>
				<FirstName>Jimmy</FirstName>
				<LastName>Smith</LastName>
				<Age>5</Age>
				<Nationality>French</Nationality>
			</Guest>',
			$childGuestBook
		];

		$oneGuest = new Guests($adultGuestBook);
		yield [
			'<Guests>
				<Guest>
					<Type>Adult</Type>
					<FirstName>Sally</FirstName>
					<LastName>Smith</LastName>
					<Title>Mrs</Title>
					<Nationality>French</Nationality>
				</Guest>
			</Guests>',
			$oneGuest
		];

		$twoGuests = new Guests(
			$adultGuestBook,
			$childGuestBook
		);

		yield [
			'<Guests>
				<Guest>
					<Type>Adult</Type>
					<FirstName>Sally</FirstName>
					<LastName>Smith</LastName>
					<Title>Mrs</Title>
					<Nationality>French</Nationality>
				</Guest>
				<Guest>
					<Type>Child</Type>
					<FirstName>Jimmy</FirstName>
					<LastName>Smith</LastName>
					<Age>5</Age>
					<Nationality>French</Nationality>
				</Guest>
			</Guests>',
			$twoGuests
		];

		$roomBookingOneAdult = new RoomBooking(
			155558,
			1,
			1,
			0,
			0,
			$oneGuest
		);

		yield [
			'<RoomBooking>
				<RoomID>155558</RoomID>
				<MealBasisID>1</MealBasisID>
				<Adults>1</Adults>
				<Children>0</Children>
				<Infants>0</Infants>
				<Guests>
					<Guest>
						<Type>Adult</Type>
						<FirstName>Sally</FirstName>
						<LastName>Smith</LastName>
						<Title>Mrs</Title>
						<Nationality>French</Nationality>
					</Guest>
				</Guests>
			</RoomBooking>',
			$roomBookingOneAdult
		];
//60

		$roomBookingOneAdultOnly = new RoomBooking(
			155558,
			1,
			1,
			0,
			0
		);

		yield [
			'<RoomBooking>
				<RoomID>155558</RoomID>
				<MealBasisID>1</MealBasisID>
				<Adults>1</Adults>
				<Children>0</Children>
				<Infants>0</Infants>
				<Guests/>
			</RoomBooking>',
			$roomBookingOneAdultOnly
		];

		$roomBookingTwoAdults = new RoomBooking(
			155558,
			1,
			2,
			0,
			0,
			$oneGuest
		);

		yield [
			'<RoomBooking>
				<RoomID>155558</RoomID>
				<MealBasisID>1</MealBasisID>
				<Adults>2</Adults>
				<Children>0</Children>
				<Infants>0</Infants>
				<Guests>
					<Guest>
						<Type>Adult</Type>
						<FirstName>Sally</FirstName>
						<LastName>Smith</LastName>
						<Title>Mrs</Title>
						<Nationality>French</Nationality>
					</Guest>
				</Guests>
			</RoomBooking>',
			$roomBookingTwoAdults
		];

		$roomBookingAdultAndChild = new RoomBooking(
			155448,
			1,
			1,
			1,
			0,
			$twoGuests
		);

		yield [
			'<RoomBooking>
				<RoomID>155448</RoomID>
				<MealBasisID>1</MealBasisID>
				<Adults>1</Adults>
				<Children>1</Children>
				<Infants>0</Infants>
				<Guests>
					<Guest>
						<Type>Adult</Type>
						<FirstName>Sally</FirstName>
						<LastName>Smith</LastName>
						<Title>Mrs</Title>
						<Nationality>French</Nationality>
					</Guest>
					<Guest>
						<Type>Child</Type>
						<FirstName>Jimmy</FirstName>
						<LastName>Smith</LastName>
						<Age>5</Age>
						<Nationality>French</Nationality>
					</Guest>
				</Guests>
			</RoomBooking>',
			$roomBookingAdultAndChild
		];

		$oneRoomBookings = new RoomBookings(
			$roomBookingAdultAndChild
		);

		yield [
			'<RoomBookings>
				<RoomBooking>
					<RoomID>155448</RoomID>
					<MealBasisID>1</MealBasisID>
					<Adults>1</Adults>
					<Children>1</Children>
					<Infants>0</Infants>
					<Guests>
						<Guest>
							<Type>Adult</Type>
							<FirstName>Sally</FirstName>
							<LastName>Smith</LastName>
							<Title>Mrs</Title>
							<Nationality>French</Nationality>
						</Guest>
						<Guest>
							<Type>Child</Type>
							<FirstName>Jimmy</FirstName>
							<LastName>Smith</LastName>
							<Age>5</Age>
							<Nationality>French</Nationality>
						</Guest>
					</Guests>
				</RoomBooking>
			</RoomBookings>',
			$oneRoomBookings
		];

		$twoRoomBookings = new RoomBookings(
			$roomBookingOneAdultOnly,
			$roomBookingAdultAndChild
		);

		yield [
			'<RoomBookings>
				<RoomBooking>
					<RoomID>155558</RoomID>
					<MealBasisID>1</MealBasisID>
					<Adults>1</Adults>
					<Children>0</Children>
					<Infants>0</Infants>
					<Guests/>
				</RoomBooking>
				<RoomBooking>
					<RoomID>155448</RoomID>
					<MealBasisID>1</MealBasisID>
					<Adults>1</Adults>
					<Children>1</Children>
					<Infants>0</Infants>
					<Guests>
						<Guest>
							<Type>Adult</Type>
							<FirstName>Sally</FirstName>
							<LastName>Smith</LastName>
							<Title>Mrs</Title>
							<Nationality>French</Nationality>
						</Guest>
						<Guest>
							<Type>Child</Type>
							<FirstName>Jimmy</FirstName>
							<LastName>Smith</LastName>
							<Age>5</Age>
							<Nationality>French</Nationality>
						</Guest>
					</Guests>
				</RoomBooking>
			</RoomBookings>',
			$twoRoomBookings
		];

		yield [
			'<BookDetails>
				<ArrivalDate>2023-11-01</ArrivalDate>
				<Duration>5</Duration>
				<TradeReference>TEST_REF</TradeReference>
				<TotalPrice>1040</TotalPrice>
				<LeadGuest>
					<FirstName>Jim</FirstName>
					<LastName>Watsworth</LastName>
					<Title>Mr</Title>
				</LeadGuest>
				<RoomBookings>
					<RoomBooking>
						<RoomID>155558</RoomID>
						<MealBasisID>1</MealBasisID>
						<Adults>1</Adults>
						<Children>0</Children>
						<Infants>0</Infants>
						<Guests/>
					</RoomBooking>
				</RoomBookings>
			</BookDetails>',
			new BookDetails(
				'2023-11-01',
				5,
				'TEST_REF',
				1040,
				$simpleLeadGuestBook,
				new RoomBookings($roomBookingOneAdultOnly)
			)
		];

		yield [
			'<BookDetails>
				<ArrivalDate>2023-11-01</ArrivalDate>
				<Duration>5</Duration>
				<TradeReference>TEST_REF</TradeReference>
				<TotalPrice>1040</TotalPrice>
				<LeadGuest>
					<FirstName>Jim</FirstName>
					<LastName>Watsworth</LastName>
					<Title>Mr</Title>
				</LeadGuest>
				<RoomBookings>
					<RoomBooking>
						<RoomID>155558</RoomID>
						<MealBasisID>1</MealBasisID>
						<Adults>2</Adults>
						<Children>0</Children>
						<Infants>0</Infants>
						<Guests>
							<Guest>
								<Type>Adult</Type>
								<FirstName>Sally</FirstName>
								<LastName>Smith</LastName>
								<Title>Mrs</Title>
								<Nationality>French</Nationality>
							</Guest>
						</Guests>
					</RoomBooking>
				</RoomBookings>
			</BookDetails>',
			new BookDetails(
				'2023-11-01',
				5,
				'TEST_REF',
				1040,
				$simpleLeadGuestBook,
				new RoomBookings($roomBookingTwoAdults)
			)
		];


		$twoRoomBookingDetails = new BookDetails(
			'2023-11-01',
			5,
			'TEST_REF',
			1040,
			$simpleLeadGuestBook,
			$twoRoomBookings
		);

		yield [
			'<BookDetails>
				<ArrivalDate>2023-11-01</ArrivalDate>
				<Duration>5</Duration>
				<TradeReference>TEST_REF</TradeReference>
				<TotalPrice>1040</TotalPrice>
				<LeadGuest>
					<FirstName>Jim</FirstName>
					<LastName>Watsworth</LastName>
					<Title>Mr</Title>
				</LeadGuest>
				<RoomBookings>
					<RoomBooking>
						<RoomID>155558</RoomID>
						<MealBasisID>1</MealBasisID>
						<Adults>1</Adults>
						<Children>0</Children>
						<Infants>0</Infants>
						<Guests/>
					</RoomBooking>
					<RoomBooking>
						<RoomID>155448</RoomID>
						<MealBasisID>1</MealBasisID>
						<Adults>1</Adults>
						<Children>1</Children>
						<Infants>0</Infants>
						<Guests>
							<Guest>
								<Type>Adult</Type>
								<FirstName>Sally</FirstName>
								<LastName>Smith</LastName>
								<Title>Mrs</Title>
								<Nationality>French</Nationality>
							</Guest>
							<Guest>
								<Type>Child</Type>
								<FirstName>Jimmy</FirstName>
								<LastName>Smith</LastName>
								<Age>5</Age>
								<Nationality>French</Nationality>
							</Guest>
						</Guests>
					</RoomBooking>
				</RoomBookings>
			</BookDetails>',
			$twoRoomBookingDetails
		];

		yield [
			'<BookRequest>
				<LoginDetails>
					<Login>login</Login>
					<Password>pass</Password>
					<Version>version</Version>
				</LoginDetails>
				<Mock>True</Mock>
				<BookDetails>
					<ArrivalDate>2023-11-01</ArrivalDate>
					<Duration>5</Duration>
					<TradeReference>TEST_REF</TradeReference>
					<TotalPrice>1040</TotalPrice>
					<LeadGuest>
						<FirstName>Jim</FirstName>
						<LastName>Watsworth</LastName>
						<Title>Mr</Title>
					</LeadGuest>
					<RoomBookings>
						<RoomBooking>
							<RoomID>155558</RoomID>
							<MealBasisID>1</MealBasisID>
							<Adults>1</Adults>
							<Children>0</Children>
							<Infants>0</Infants>
							<Guests/>
						</RoomBooking>
						<RoomBooking>
							<RoomID>155448</RoomID>
							<MealBasisID>1</MealBasisID>
							<Adults>1</Adults>
							<Children>1</Children>
							<Infants>0</Infants>
							<Guests>
								<Guest>
									<Type>Adult</Type>
									<FirstName>Sally</FirstName>
									<LastName>Smith</LastName>
									<Title>Mrs</Title>
									<Nationality>French</Nationality>
								</Guest>
								<Guest>
									<Type>Child</Type>
									<FirstName>Jimmy</FirstName>
									<LastName>Smith</LastName>
									<Age>5</Age>
									<Nationality>French</Nationality>
								</Guest>
							</Guests>
						</RoomBooking>
					</RoomBookings>
				</BookDetails>
			</BookRequest>',
			new BookRequest(
				$loginDetails,
				$twoRoomBookingDetails,
				true
			)
		];

		$leadGuestOnlyBookResponse = new RoomBookingResponse(
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

		yield [
			'<RoomBooking>
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
			</RoomBooking>',
			$leadGuestOnlyBookResponse
		];

		$leadGuestAndGuestBookResponse = new RoomBookingResponse(
			155558,
			'Executive Double',
			'Sea View',
			6,
			2,
			0,
			0,
			$oneGuest,
			$oneSupplement,
			$oneSpecialOffer,
			$oneTax,
			$oneCancellationPolicy,
			1040.23
		);

		yield [
			'<RoomBooking>
				<RoomID>155558</RoomID>
				<Name>Executive Double</Name>
				<View>Sea View</View>
				<MealBasisID>6</MealBasisID>
				<Adults>2</Adults>
				<Children>0</Children>
				<Infants>0</Infants>
				<Guests>
					<Guest>
						<Type>Adult</Type>
						<FirstName>Sally</FirstName>
						<LastName>Smith</LastName>
						<Title>Mrs</Title>
						<Nationality>French</Nationality>
					</Guest>
				</Guests>
				<Supplements>
					<Supplement>
						<Name>test supplement</Name>
						<Duration>Per Night</Duration>
						<Multiplier>Per Person</Multiplier>
						<Total>220</Total>
						<PaxType>Adult Only</PaxType>
					</Supplement>
				</Supplements>
				<SpecialOffers>
					<SpecialOffer>
						<Name>Example special offer</Name>
						<Type>Value Added</Type>
						<Desc>test desc</Desc>
					</SpecialOffer>
				</SpecialOffers>
				<Taxes>
					<Tax>
						<TaxName>test %</TaxName>
						<Inclusive>False</Inclusive>
						<Total>1148.55</Total>
					</Tax>
				</Taxes>
				<CancellationPolicies>
					<CancellationPolicy>
						<CancelBy>2020-07-11</CancelBy>
						<Penalty>574.28</Penalty>
					</CancellationPolicy>
				</CancellationPolicies>
				<RoomPrice>1040.23</RoomPrice>
			</RoomBooking>',
			$leadGuestAndGuestBookResponse
		];

		$adultAndChildBookResponse = new RoomBookingResponse(
			155558,
			'Executive Double',
			'Sea View',
			6,
			1,
			1,
			0,
			$twoGuests,
			$twoSupplements,
			$twoSpecialOffers,
			$fourTaxes,
			$twoCancellationPolicy,
			1040.23
		);

		yield [
			'<RoomBooking>
				<RoomID>155558</RoomID>
				<Name>Executive Double</Name>
				<View>Sea View</View>
				<MealBasisID>6</MealBasisID>
				<Adults>1</Adults>
				<Children>1</Children>
				<Infants>0</Infants>
				<Guests>
					<Guest>
						<Type>Adult</Type>
						<FirstName>Sally</FirstName>
						<LastName>Smith</LastName>
						<Title>Mrs</Title>
						<Nationality>French</Nationality>
					</Guest>
					<Guest>
						<Type>Child</Type>
						<FirstName>Jimmy</FirstName>
						<LastName>Smith</LastName>
						<Age>5</Age>
						<Nationality>French</Nationality>
					</Guest>
				</Guests>
				<Supplements>
					<Supplement>
						<Name>Weekend Stay (Fri - Sun)</Name>
						<Duration>Per Night</Duration>
						<Multiplier>Per Room</Multiplier>
						<Total>60</Total>
					</Supplement>
					<Supplement>
						<Name>test supplement</Name>
						<Duration>Per Night</Duration>
						<Multiplier>Per Person</Multiplier>
						<Total>220</Total>
						<PaxType>Adult Only</PaxType>
					</Supplement>
				</Supplements>
				<SpecialOffers>
					<SpecialOffer>
						<Name>Example special offer</Name>
						<Type>Value Added</Type>
						<Desc>test desc</Desc>
					</SpecialOffer>
					<SpecialOffer>
						<Name>Example special offer 2</Name>
						<Type>Free Kids</Type>
						<Value>1</Value>
						<Total>1000</Total>
						<Desc>test desc</Desc>
					</SpecialOffer>
				</SpecialOffers>
				<Taxes>
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
				</Taxes>
				<CancellationPolicies>
					<CancellationPolicy>
						<CancelBy>2020-07-11</CancelBy>
						<Penalty>574.28</Penalty>
					</CancellationPolicy>
					<CancellationPolicy>
						<CancelBy>2020-07-18</CancelBy>
						<Penalty>1148.55</Penalty>
					</CancellationPolicy>
				</CancellationPolicies>
				<RoomPrice>1040.23</RoomPrice>
			</RoomBooking>',
			$adultAndChildBookResponse
		];

		$oneRoomBooking = new RoomBookingsResponse($leadGuestOnlyBookResponse);
		yield [
			'<RoomBookings>
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
			</RoomBookings>',
			$oneRoomBooking
		];

		$twoRoomBooking = new RoomBookingsResponse(
			$leadGuestAndGuestBookResponse,
			$adultAndChildBookResponse
		);

		yield [
			'<RoomBookings>
				<RoomBooking>
					<RoomID>155558</RoomID>
					<Name>Executive Double</Name>
					<View>Sea View</View>
					<MealBasisID>6</MealBasisID>
					<Adults>2</Adults>
					<Children>0</Children>
					<Infants>0</Infants>
					<Guests>
						<Guest>
							<Type>Adult</Type>
							<FirstName>Sally</FirstName>
							<LastName>Smith</LastName>
							<Title>Mrs</Title>
							<Nationality>French</Nationality>
						</Guest>
					</Guests>
					<Supplements>
						<Supplement>
							<Name>test supplement</Name>
							<Duration>Per Night</Duration>
							<Multiplier>Per Person</Multiplier>
							<Total>220</Total>
							<PaxType>Adult Only</PaxType>
						</Supplement>
					</Supplements>
					<SpecialOffers>
						<SpecialOffer>
							<Name>Example special offer</Name>
							<Type>Value Added</Type>
							<Desc>test desc</Desc>
						</SpecialOffer>
					</SpecialOffers>
					<Taxes>
						<Tax>
							<TaxName>test %</TaxName>
							<Inclusive>False</Inclusive>
							<Total>1148.55</Total>
						</Tax>
					</Taxes>
					<CancellationPolicies>
						<CancellationPolicy>
							<CancelBy>2020-07-11</CancelBy>
							<Penalty>574.28</Penalty>
						</CancellationPolicy>
					</CancellationPolicies>
					<RoomPrice>1040.23</RoomPrice>
				</RoomBooking>
				<RoomBooking>
					<RoomID>155558</RoomID>
					<Name>Executive Double</Name>
					<View>Sea View</View>
					<MealBasisID>6</MealBasisID>
					<Adults>1</Adults>
					<Children>1</Children>
					<Infants>0</Infants>
					<Guests>
						<Guest>
							<Type>Adult</Type>
							<FirstName>Sally</FirstName>
							<LastName>Smith</LastName>
							<Title>Mrs</Title>
							<Nationality>French</Nationality>
						</Guest>
						<Guest>
							<Type>Child</Type>
							<FirstName>Jimmy</FirstName>
							<LastName>Smith</LastName>
							<Age>5</Age>
							<Nationality>French</Nationality>
						</Guest>
					</Guests>
					<Supplements>
						<Supplement>
							<Name>Weekend Stay (Fri - Sun)</Name>
							<Duration>Per Night</Duration>
							<Multiplier>Per Room</Multiplier>
							<Total>60</Total>
						</Supplement>
						<Supplement>
							<Name>test supplement</Name>
							<Duration>Per Night</Duration>
							<Multiplier>Per Person</Multiplier>
							<Total>220</Total>
							<PaxType>Adult Only</PaxType>
						</Supplement>
					</Supplements>
					<SpecialOffers>
						<SpecialOffer>
							<Name>Example special offer</Name>
							<Type>Value Added</Type>
							<Desc>test desc</Desc>
						</SpecialOffer>
						<SpecialOffer>
							<Name>Example special offer 2</Name>
							<Type>Free Kids</Type>
							<Value>1</Value>
							<Total>1000</Total>
							<Desc>test desc</Desc>
						</SpecialOffer>
					</SpecialOffers>
					<Taxes>
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
					</Taxes>
					<CancellationPolicies>
						<CancellationPolicy>
							<CancelBy>2020-07-11</CancelBy>
							<Penalty>574.28</Penalty>
						</CancellationPolicy>
						<CancellationPolicy>
							<CancelBy>2020-07-18</CancelBy>
							<Penalty>1148.55</Penalty>
						</CancellationPolicy>
					</CancellationPolicies>
					<RoomPrice>1040.23</RoomPrice>
				</RoomBooking>
			</RoomBookings>',
			$twoRoomBooking
		];

		$minProperty = new Property(
			70011,
			'BUSY ROOMS HOTEL EMEA',
			$supplier,
			null,
			4,
			null,
			45,
			76,
			87,
			null,
			null,
			null,
			'Ideal for the business travellers and couples looking for the perfect getaway or just to relax, as well as experience a cultural city or visit the islands on a pre or post cruise vacation.',
			'Ideal for the business travellers and couples looking for the perfect getaway or just to relax, as well as experience a cultural city or visit the islands on a pre or post cruise vacation.',
			'https://az416281.vo.msecnd.net/hotels/',
			'3000-Emea  Hotel - Hotels/original/Emea-3-525-Copy.jpg',
			'3000-Emea Copy.jpg',
			null
		);

		yield [
			'<Property>
				<PropertyID>70011</PropertyID>
				<PropertyName>BUSY ROOMS HOTEL EMEA</PropertyName>
				<Supplier>
					<SupplierID>6</SupplierID>
					<SupplierName>RMI</SupplierName>
				</Supplier>
				<GIATAID/>
				<Rating>4</Rating>
				<Errata/>
				<GeographyLevel1ID>45</GeographyLevel1ID>
				<GeographyLevel2ID>76</GeographyLevel2ID>
				<GeographyLevel3ID>87</GeographyLevel3ID>
				<Country/>
				<Area/>
				<Region/>
				<Strapline>Ideal for the business travellers and couples looking for the perfect getaway or just to relax, as well as experience a cultural city or visit the islands on a pre or post cruise vacation.</Strapline>
				<Description>Ideal for the business travellers and couples looking for the perfect getaway or just to relax, as well as experience a cultural city or visit the islands on a pre or post cruise vacation.</Description>
				<CMSBaseURL>https://az416281.vo.msecnd.net/hotels/</CMSBaseURL>
				<MainImage>3000-Emea  Hotel - Hotels/original/Emea-3-525-Copy.jpg</MainImage>
				<MainImageThumbnail>3000-Emea Copy.jpg</MainImageThumbnail>
				<Images/>
			</Property>',
			$minProperty
		];

		$sympleProperty = new Property(
			70011,
			'BUSY ROOMS HOTEL EMEA',
			$supplier,
			123,
			4,
			$oneErratum,
			45,
			76,
			87,
			'United Kingdom',
			'Malta',
			'Malta',
			'Ideal for the business travellers and couples looking for the perfect getaway or just to relax, as well as experience a cultural city or visit the islands on a pre or post cruise vacation.',
			'Ideal for the business travellers and couples looking for the perfect getaway or just to relax, as well as experience a cultural city or visit the islands on a pre or post cruise vacation.',
			'https://az416281.vo.msecnd.net/hotels/',
			'3000-Emea  Hotel - Hotels/original/Emea-3-525-Copy.jpg',
			'3000-Emea Copy.jpg',
			$oneImage
		);

		yield [
			'<Property>
				<PropertyID>70011</PropertyID>
				<PropertyName>BUSY ROOMS HOTEL EMEA</PropertyName>
				<Supplier>
					<SupplierID>6</SupplierID>
					<SupplierName>RMI</SupplierName>
				</Supplier>
				<GIATAID>123</GIATAID>
				<Rating>4</Rating>
				<Errata>
					<Erratum>
						<StartDate>2020-08-04</StartDate>
						<EndDate>2020-08-11</EndDate>
						<Description>Small pool will be closed for maintenance</Description>
					</Erratum>
				</Errata>
				<GeographyLevel1ID>45</GeographyLevel1ID>
				<GeographyLevel2ID>76</GeographyLevel2ID>
				<GeographyLevel3ID>87</GeographyLevel3ID>
				<Country>United Kingdom</Country>
				<Area>Malta</Area>
				<Region>Malta</Region>
				<Strapline>Ideal for the business travellers and couples looking for the perfect getaway or just to relax, as well as experience a cultural city or visit the islands on a pre or post cruise vacation.</Strapline>
				<Description>Ideal for the business travellers and couples looking for the perfect getaway or just to relax, as well as experience a cultural city or visit the islands on a pre or post cruise vacation.</Description>
				<CMSBaseURL>https://az416281.vo.msecnd.net/hotels/</CMSBaseURL>
				<MainImage>3000-Emea  Hotel - Hotels/original/Emea-3-525-Copy.jpg</MainImage>
				<MainImageThumbnail>3000-Emea Copy.jpg</MainImageThumbnail>
				<Images>
					<Image>
						<FullSize>CMSImage_1000.jpg</FullSize>
						<Thumbnail>CMSImageThumb_1000.jpg</Thumbnail>
					</Image>
				</Images>
			</Property>',
			$sympleProperty
		];

		$complexProperty = new Property(
			70011,
			'BUSY ROOMS HOTEL EMEA',
			$supplier,
			123,
			4,
			$twoErrata,
			45,
			76,
			87,
			'United Kingdom',
			'Malta',
			'Malta',
			'Ideal for the business travellers and couples looking for the perfect getaway or just to relax, as well as experience a cultural city or visit the islands on a pre or post cruise vacation.',
			'Ideal for the business travellers and couples looking for the perfect getaway or just to relax, as well as experience a cultural city or visit the islands on a pre or post cruise vacation.',
			'https://az416281.vo.msecnd.net/hotels/',
			'3000-Emea  Hotel - Hotels/original/Emea-3-525-Copy.jpg',
			'3000-Emea Copy.jpg',
			$twoImages
		);

		yield [
			'<Property>
				<PropertyID>70011</PropertyID>
				<PropertyName>BUSY ROOMS HOTEL EMEA</PropertyName>
				<Supplier>
					<SupplierID>6</SupplierID>
					<SupplierName>RMI</SupplierName>
				</Supplier>
				<GIATAID>123</GIATAID>
				<Rating>4</Rating>
				<Errata>
					<Erratum>
						<StartDate>2020-08-04</StartDate>
						<EndDate>2020-08-11</EndDate>
						<Description>Small pool will be closed for maintenance</Description>
					</Erratum>
					<Erratum>
						<StartDate>2020-08-04</StartDate>
						<EndDate>2020-08-11</EndDate>
						<Description>There won\'t be mayonese at the restaurant</Description>
					</Erratum>
				</Errata>
				<GeographyLevel1ID>45</GeographyLevel1ID>
				<GeographyLevel2ID>76</GeographyLevel2ID>
				<GeographyLevel3ID>87</GeographyLevel3ID>
				<Country>United Kingdom</Country>
				<Area>Malta</Area>
				<Region>Malta</Region>
				<Strapline>Ideal for the business travellers and couples looking for the perfect getaway or just to relax, as well as experience a cultural city or visit the islands on a pre or post cruise vacation.</Strapline>
				<Description>Ideal for the business travellers and couples looking for the perfect getaway or just to relax, as well as experience a cultural city or visit the islands on a pre or post cruise vacation.</Description>
				<CMSBaseURL>https://az416281.vo.msecnd.net/hotels/</CMSBaseURL>
				<MainImage>3000-Emea  Hotel - Hotels/original/Emea-3-525-Copy.jpg</MainImage>
				<MainImageThumbnail>3000-Emea Copy.jpg</MainImageThumbnail>
				<Images>
					<Image>
						<FullSize>CMSImage_1000.jpg</FullSize>
						<Thumbnail>CMSImageThumb_1000.jpg</Thumbnail>
					</Image>
					<Image>
						<FullSize>CMSImage_1001.jpg</FullSize>
						<Thumbnail>CMSImageThumb_1001.jpg</Thumbnail>
					</Image>
				</Images>
			</Property>',
			$complexProperty
		];

		$bookingDetails = new BookingDetailsResponse(
			'HCF0011',
			'8430154',
			'Live',
			null,
			'EUR',
			null,
			'2023-11-01',
			5,
			$simpleLeadGuestBook,
			null, //busyrooms have this
			'TEST_REF',
			1040,
			'2023-10-02',
			$twoRoomBooking,
			$complexProperty
		);

		yield [
			'<BookingDetails>
				<BookingReference>HCF0011</BookingReference>
				<SupplierReference>8430154</SupplierReference>
				<Status>Live</Status>
				<ArrivalDate>2023-11-01</ArrivalDate>
				<Duration>5</Duration>
				<LeadGuest>
					<FirstName>Jim</FirstName>
					<LastName>Watsworth</LastName>
					<Title>Mr</Title>
				</LeadGuest>
				<Request/>
				<TradeReference>TEST_REF</TradeReference>
				<TotalPrice>1040</TotalPrice>
				<Currency>EUR</Currency>
				<DueDate>2023-10-02</DueDate>
				<RoomBookings>
					<RoomBooking>
						<RoomID>155558</RoomID>
						<Name>Executive Double</Name>
						<View>Sea View</View>
						<MealBasisID>6</MealBasisID>
						<Adults>2</Adults>
						<Children>0</Children>
						<Infants>0</Infants>
						<Guests>
							<Guest>
								<Type>Adult</Type>
								<FirstName>Sally</FirstName>
								<LastName>Smith</LastName>
								<Title>Mrs</Title>
								<Nationality>French</Nationality>
							</Guest>
						</Guests>
						<Supplements>
							<Supplement>
								<Name>test supplement</Name>
								<Duration>Per Night</Duration>
								<Multiplier>Per Person</Multiplier>
								<Total>220</Total>
								<PaxType>Adult Only</PaxType>
							</Supplement>
						</Supplements>
						<SpecialOffers>
							<SpecialOffer>
								<Name>Example special offer</Name>
								<Type>Value Added</Type>
								<Desc>test desc</Desc>
							</SpecialOffer>
						</SpecialOffers>
						<Taxes>
							<Tax>
								<TaxName>test %</TaxName>
								<Inclusive>False</Inclusive>
								<Total>1148.55</Total>
							</Tax>
						</Taxes>
						<CancellationPolicies>
							<CancellationPolicy>
								<CancelBy>2020-07-11</CancelBy>
								<Penalty>574.28</Penalty>
							</CancellationPolicy>
						</CancellationPolicies>
						<RoomPrice>1040.23</RoomPrice>
					</RoomBooking>
					<RoomBooking>
						<RoomID>155558</RoomID>
						<Name>Executive Double</Name>
						<View>Sea View</View>
						<MealBasisID>6</MealBasisID>
						<Adults>1</Adults>
						<Children>1</Children>
						<Infants>0</Infants>
						<Guests>
							<Guest>
								<Type>Adult</Type>
								<FirstName>Sally</FirstName>
								<LastName>Smith</LastName>
								<Title>Mrs</Title>
								<Nationality>French</Nationality>
							</Guest>
							<Guest>
								<Type>Child</Type>
								<FirstName>Jimmy</FirstName>
								<LastName>Smith</LastName>
								<Age>5</Age>
								<Nationality>French</Nationality>
							</Guest>
						</Guests>
						<Supplements>
							<Supplement>
								<Name>Weekend Stay (Fri - Sun)</Name>
								<Duration>Per Night</Duration>
								<Multiplier>Per Room</Multiplier>
								<Total>60</Total>
							</Supplement>
							<Supplement>
								<Name>test supplement</Name>
								<Duration>Per Night</Duration>
								<Multiplier>Per Person</Multiplier>
								<Total>220</Total>
								<PaxType>Adult Only</PaxType>
							</Supplement>
						</Supplements>
						<SpecialOffers>
							<SpecialOffer>
								<Name>Example special offer</Name>
								<Type>Value Added</Type>
								<Desc>test desc</Desc>
							</SpecialOffer>
							<SpecialOffer>
								<Name>Example special offer 2</Name>
								<Type>Free Kids</Type>
								<Value>1</Value>
								<Total>1000</Total>
								<Desc>test desc</Desc>
							</SpecialOffer>
						</SpecialOffers>
						<Taxes>
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
						</Taxes>
						<CancellationPolicies>
							<CancellationPolicy>
								<CancelBy>2020-07-11</CancelBy>
								<Penalty>574.28</Penalty>
							</CancellationPolicy>
							<CancellationPolicy>
								<CancelBy>2020-07-18</CancelBy>
								<Penalty>1148.55</Penalty>
							</CancellationPolicy>
						</CancellationPolicies>
						<RoomPrice>1040.23</RoomPrice>
					</RoomBooking>
				</RoomBookings>
				<Property>
					<PropertyID>70011</PropertyID>
					<PropertyName>BUSY ROOMS HOTEL EMEA</PropertyName>
					<Supplier>
						<SupplierID>6</SupplierID>
						<SupplierName>RMI</SupplierName>
					</Supplier>
					<GIATAID>123</GIATAID>
					<Rating>4</Rating>
					<Errata>
						<Erratum>
							<StartDate>2020-08-04</StartDate>
							<EndDate>2020-08-11</EndDate>
							<Description>Small pool will be closed for maintenance</Description>
						</Erratum>
						<Erratum>
							<StartDate>2020-08-04</StartDate>
							<EndDate>2020-08-11</EndDate>
							<Description>There won\'t be mayonese at the restaurant</Description>
						</Erratum>
					</Errata>
					<GeographyLevel1ID>45</GeographyLevel1ID>
					<GeographyLevel2ID>76</GeographyLevel2ID>
					<GeographyLevel3ID>87</GeographyLevel3ID>
					<Country>United Kingdom</Country>
					<Area>Malta</Area>
					<Region>Malta</Region>
					<Strapline>Ideal for the business travellers and couples looking for the perfect getaway or just to relax, as well as experience a cultural city or visit the islands on a pre or post cruise vacation.</Strapline>
					<Description>Ideal for the business travellers and couples looking for the perfect getaway or just to relax, as well as experience a cultural city or visit the islands on a pre or post cruise vacation.</Description>
					<CMSBaseURL>https://az416281.vo.msecnd.net/hotels/</CMSBaseURL>
					<MainImage>3000-Emea  Hotel - Hotels/original/Emea-3-525-Copy.jpg</MainImage>
					<MainImageThumbnail>3000-Emea Copy.jpg</MainImageThumbnail>
					<Images>
						<Image>
							<FullSize>CMSImage_1000.jpg</FullSize>
							<Thumbnail>CMSImageThumb_1000.jpg</Thumbnail>
						</Image>
						<Image>
							<FullSize>CMSImage_1001.jpg</FullSize>
							<Thumbnail>CMSImageThumb_1001.jpg</Thumbnail>
						</Image>
					</Images>
				</Property>
			</BookingDetails>',
			$bookingDetails
		];

		$bookResponse = new BookResponse(
			$requestInfo,
			$returnStatusTrue,
			$bookingDetails
		);

		yield [
			'<BookResponse>
				<RequestInfo>
					<Timestamp>1687253937</Timestamp>
					<Host>xml.centriumres.com.localdomain.ee</Host>
					<HostIP>10.0.1.182</HostIP>
					<ReqID>649173b14aadb8.17864349</ReqID>
					<TimestampISO>2023-06-20T09:38:57+00:00</TimestampISO>
				</RequestInfo>
				<ReturnStatus>
					<Success>True</Success>
					<Exception/>
				</ReturnStatus>
				<BookingDetails>
					<BookingReference>HCF0011</BookingReference>
					<SupplierReference>8430154</SupplierReference>
					<Status>Live</Status>
					<Currency>EUR</Currency>
					<ArrivalDate>2023-11-01</ArrivalDate>
					<Duration>5</Duration>
					<LeadGuest>
						<FirstName>Jim</FirstName>
						<LastName>Watsworth</LastName>
						<Title>Mr</Title>
					</LeadGuest>
					<TradeReference>TEST_REF</TradeReference>
					<TotalPrice>1040</TotalPrice>
					<DueDate>2023-10-02</DueDate>
					<RoomBookings>
						<RoomBooking>
							<RoomID>155558</RoomID>
							<Name>Executive Double</Name>
							<View>Sea View</View>
							<MealBasisID>6</MealBasisID>
							<Adults>2</Adults>
							<Children>0</Children>
							<Infants>0</Infants>
							<Guests>
								<Guest>
									<Type>Adult</Type>
									<FirstName>Sally</FirstName>
									<LastName>Smith</LastName>
									<Title>Mrs</Title>
									<Nationality>French</Nationality>
								</Guest>
							</Guests>
							<Supplements>
								<Supplement>
									<Name>test supplement</Name>
									<Duration>Per Night</Duration>
									<Multiplier>Per Person</Multiplier>
									<Total>220</Total>
									<PaxType>Adult Only</PaxType>
								</Supplement>
							</Supplements>
							<SpecialOffers>
								<SpecialOffer>
									<Name>Example special offer</Name>
									<Type>Value Added</Type>
									<Desc>test desc</Desc>
								</SpecialOffer>
							</SpecialOffers>
							<Taxes>
								<Tax>
									<TaxName>test %</TaxName>
									<Inclusive>False</Inclusive>
									<Total>1148.55</Total>
								</Tax>
							</Taxes>
							<CancellationPolicies>
								<CancellationPolicy>
									<CancelBy>2020-07-11</CancelBy>
									<Penalty>574.28</Penalty>
								</CancellationPolicy>
							</CancellationPolicies>
							<RoomPrice>1040.23</RoomPrice>
						</RoomBooking>
						<RoomBooking>
							<RoomID>155558</RoomID>
							<Name>Executive Double</Name>
							<View>Sea View</View>
							<MealBasisID>6</MealBasisID>
							<Adults>1</Adults>
							<Children>1</Children>
							<Infants>0</Infants>
							<Guests>
								<Guest>
									<Type>Adult</Type>
									<FirstName>Sally</FirstName>
									<LastName>Smith</LastName>
									<Title>Mrs</Title>
									<Nationality>French</Nationality>
								</Guest>
								<Guest>
									<Type>Child</Type>
									<FirstName>Jimmy</FirstName>
									<LastName>Smith</LastName>
									<Age>5</Age>
									<Nationality>French</Nationality>
								</Guest>
							</Guests>
							<Supplements>
								<Supplement>
									<Name>Weekend Stay (Fri - Sun)</Name>
									<Duration>Per Night</Duration>
									<Multiplier>Per Room</Multiplier>
									<Total>60</Total>
								</Supplement>
								<Supplement>
									<Name>test supplement</Name>
									<Duration>Per Night</Duration>
									<Multiplier>Per Person</Multiplier>
									<Total>220</Total>
									<PaxType>Adult Only</PaxType>
								</Supplement>
							</Supplements>
							<SpecialOffers>
								<SpecialOffer>
									<Name>Example special offer</Name>
									<Type>Value Added</Type>
									<Desc>test desc</Desc>
								</SpecialOffer>
								<SpecialOffer>
									<Name>Example special offer 2</Name>
									<Type>Free Kids</Type>
									<Value>1</Value>
									<Total>1000</Total>
									<Desc>test desc</Desc>
								</SpecialOffer>
							</SpecialOffers>
							<Taxes>
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
							</Taxes>
							<CancellationPolicies>
								<CancellationPolicy>
									<CancelBy>2020-07-11</CancelBy>
									<Penalty>574.28</Penalty>
								</CancellationPolicy>
								<CancellationPolicy>
									<CancelBy>2020-07-18</CancelBy>
									<Penalty>1148.55</Penalty>
								</CancellationPolicy>
							</CancellationPolicies>
							<RoomPrice>1040.23</RoomPrice>
						</RoomBooking>
					</RoomBookings>
					<Property>
						<PropertyID>70011</PropertyID>
						<PropertyName>BUSY ROOMS HOTEL EMEA</PropertyName>
						<Supplier>
							<SupplierID>6</SupplierID>
							<SupplierName>RMI</SupplierName>
						</Supplier>
						<GIATAID>123</GIATAID>
						<Rating>4</Rating>
						<Errata>
							<Erratum>
								<StartDate>2020-08-04</StartDate>
								<EndDate>2020-08-11</EndDate>
								<Description>Small pool will be closed for maintenance</Description>
							</Erratum>
							<Erratum>
								<StartDate>2020-08-04</StartDate>
								<EndDate>2020-08-11</EndDate>
								<Description>There won\'t be mayonese at the restaurant</Description>
							</Erratum>
						</Errata>
						<GeographyLevel1ID>45</GeographyLevel1ID>
						<GeographyLevel2ID>76</GeographyLevel2ID>
						<GeographyLevel3ID>87</GeographyLevel3ID>
						<Country>United Kingdom</Country>
						<Area>Malta</Area>
						<Region>Malta</Region>
						<Strapline>Ideal for the business travellers and couples looking for the perfect getaway or just to relax, as well as experience a cultural city or visit the islands on a pre or post cruise vacation.</Strapline>
						<Description>Ideal for the business travellers and couples looking for the perfect getaway or just to relax, as well as experience a cultural city or visit the islands on a pre or post cruise vacation.</Description>
						<CMSBaseURL>https://az416281.vo.msecnd.net/hotels/</CMSBaseURL>
						<MainImage>3000-Emea  Hotel - Hotels/original/Emea-3-525-Copy.jpg</MainImage>
						<MainImageThumbnail>3000-Emea Copy.jpg</MainImageThumbnail>
						<Images>
							<Image>
								<FullSize>CMSImage_1000.jpg</FullSize>
								<Thumbnail>CMSImageThumb_1000.jpg</Thumbnail>
							</Image>
							<Image>
								<FullSize>CMSImage_1001.jpg</FullSize>
								<Thumbnail>CMSImageThumb_1001.jpg</Thumbnail>
							</Image>
						</Images>
					</Property>
				</BookingDetails>
			</BookResponse>',
			$bookResponse
		];

		yield [
			'<BookResponse>
				<RequestInfo>
					<Timestamp>1687253937</Timestamp>
					<TimestampISO>2023-06-20T09:38:57+00:00</TimestampISO>
					<Host>xml.centriumres.com.localdomain.ee</Host>
					<HostIP>10.0.1.182</HostIP>
					<ReqID>649173b14aadb8.17864349</ReqID>
				</RequestInfo>
				<ReturnStatus>
					<Success>False</Success>
					<Exception>Invalid Booking RoomID:[20011m]</Exception>
				</ReturnStatus>
			</BookResponse>',
			new BookResponse(
				$requestInfo,
				new ReturnStatus(
					false,
					'Invalid Booking RoomID:[20011m]'
				)
			)
		];

		yield [
			'<BookingRequest>
				<LoginDetails>
					<Login>login</Login>
					<Password>pass</Password>
					<Version>version</Version>
				</LoginDetails>
				<Mock>True</Mock>
				<BookingReference>reference</BookingReference>
			</BookingRequest>',
			new BookingRequest(
				$loginDetails,
				'reference',
				true
			)
		];

		yield [
			'<BookingResponse>
				<RequestInfo>
					<Timestamp>1687253937</Timestamp>
					<TimestampISO>2023-06-20T09:38:57+00:00</TimestampISO>
					<Host>xml.centriumres.com.localdomain.ee</Host>
					<HostIP>10.0.1.182</HostIP>
					<ReqID>649173b14aadb8.17864349</ReqID>
				</RequestInfo>
				<ReturnStatus>
					<Success>True</Success>
					<Exception/>
				</ReturnStatus>
				<BookingDetails>
					<BookingReference>HCF0011</BookingReference>
					<SupplierReference>8430154</SupplierReference>
					<Status>Live</Status>
					<Currency>EUR</Currency>
					<ArrivalDate>2023-11-01</ArrivalDate>
					<Duration>5</Duration>
					<LeadGuest>
						<FirstName>Jim</FirstName>
						<LastName>Watsworth</LastName>
						<Title>Mr</Title>
					</LeadGuest>
					<TradeReference>TEST_REF</TradeReference>
					<TotalPrice>1040</TotalPrice>
					<DueDate>2023-10-02</DueDate>
					<RoomBookings>
						<RoomBooking>
							<RoomID>155558</RoomID>
							<Name>Executive Double</Name>
							<View>Sea View</View>
							<MealBasisID>6</MealBasisID>
							<Adults>2</Adults>
							<Children>0</Children>
							<Infants>0</Infants>
							<Guests>
								<Guest>
									<Type>Adult</Type>
									<FirstName>Sally</FirstName>
									<LastName>Smith</LastName>
									<Title>Mrs</Title>
									<Nationality>French</Nationality>
								</Guest>
							</Guests>
							<Supplements>
								<Supplement>
									<Name>test supplement</Name>
									<Duration>Per Night</Duration>
									<Multiplier>Per Person</Multiplier>
									<Total>220</Total>
									<PaxType>Adult Only</PaxType>
								</Supplement>
							</Supplements>
							<SpecialOffers>
								<SpecialOffer>
									<Name>Example special offer</Name>
									<Type>Value Added</Type>
									<Desc>test desc</Desc>
								</SpecialOffer>
							</SpecialOffers>
							<Taxes>
								<Tax>
									<TaxName>test %</TaxName>
									<Inclusive>False</Inclusive>
									<Total>1148.55</Total>
								</Tax>
							</Taxes>
							<CancellationPolicies>
								<CancellationPolicy>
									<CancelBy>2020-07-11</CancelBy>
									<Penalty>574.28</Penalty>
								</CancellationPolicy>
							</CancellationPolicies>
							<RoomPrice>1040.23</RoomPrice>
						</RoomBooking>
						<RoomBooking>
							<RoomID>155558</RoomID>
							<Name>Executive Double</Name>
							<View>Sea View</View>
							<MealBasisID>6</MealBasisID>
							<Adults>1</Adults>
							<Children>1</Children>
							<Infants>0</Infants>
							<Guests>
								<Guest>
									<Type>Adult</Type>
									<FirstName>Sally</FirstName>
									<LastName>Smith</LastName>
									<Title>Mrs</Title>
									<Nationality>French</Nationality>
								</Guest>
								<Guest>
									<Type>Child</Type>
									<FirstName>Jimmy</FirstName>
									<LastName>Smith</LastName>
									<Age>5</Age>
									<Nationality>French</Nationality>
								</Guest>
							</Guests>
							<Supplements>
								<Supplement>
									<Name>Weekend Stay (Fri - Sun)</Name>
									<Duration>Per Night</Duration>
									<Multiplier>Per Room</Multiplier>
									<Total>60</Total>
								</Supplement>
								<Supplement>
									<Name>test supplement</Name>
									<Duration>Per Night</Duration>
									<Multiplier>Per Person</Multiplier>
									<Total>220</Total>
									<PaxType>Adult Only</PaxType>
								</Supplement>
							</Supplements>
							<SpecialOffers>
								<SpecialOffer>
									<Name>Example special offer</Name>
									<Type>Value Added</Type>
									<Desc>test desc</Desc>
								</SpecialOffer>
								<SpecialOffer>
									<Name>Example special offer 2</Name>
									<Type>Free Kids</Type>
									<Value>1</Value>
									<Total>1000</Total>
									<Desc>test desc</Desc>
								</SpecialOffer>
							</SpecialOffers>
							<Taxes>
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
							</Taxes>
							<CancellationPolicies>
								<CancellationPolicy>
									<CancelBy>2020-07-11</CancelBy>
									<Penalty>574.28</Penalty>
								</CancellationPolicy>
								<CancellationPolicy>
									<CancelBy>2020-07-18</CancelBy>
									<Penalty>1148.55</Penalty>
								</CancellationPolicy>
							</CancellationPolicies>
							<RoomPrice>1040.23</RoomPrice>
						</RoomBooking>
					</RoomBookings>
					<Property>
						<PropertyID>70011</PropertyID>
						<PropertyName>BUSY ROOMS HOTEL EMEA</PropertyName>
						<Supplier>
							<SupplierID>6</SupplierID>
							<SupplierName>RMI</SupplierName>
						</Supplier>
						<GIATAID>123</GIATAID>
						<Rating>4</Rating>
						<Errata>
							<Erratum>
								<StartDate>2020-08-04</StartDate>
								<EndDate>2020-08-11</EndDate>
								<Description>Small pool will be closed for maintenance</Description>
							</Erratum>
							<Erratum>
								<StartDate>2020-08-04</StartDate>
								<EndDate>2020-08-11</EndDate>
								<Description>There won\'t be mayonese at the restaurant</Description>
							</Erratum>
						</Errata>
						<GeographyLevel1ID>45</GeographyLevel1ID>
						<GeographyLevel2ID>76</GeographyLevel2ID>
						<GeographyLevel3ID>87</GeographyLevel3ID>
						<Country>United Kingdom</Country>
						<Area>Malta</Area>
						<Region>Malta</Region>
						<Strapline>Ideal for the business travellers and couples looking for the perfect getaway or just to relax, as well as experience a cultural city or visit the islands on a pre or post cruise vacation.</Strapline>
						<Description>Ideal for the business travellers and couples looking for the perfect getaway or just to relax, as well as experience a cultural city or visit the islands on a pre or post cruise vacation.</Description>
						<CMSBaseURL>https://az416281.vo.msecnd.net/hotels/</CMSBaseURL>
						<MainImage>3000-Emea  Hotel - Hotels/original/Emea-3-525-Copy.jpg</MainImage>
						<MainImageThumbnail>3000-Emea Copy.jpg</MainImageThumbnail>
						<Images>
							<Image>
								<FullSize>CMSImage_1000.jpg</FullSize>
								<Thumbnail>CMSImageThumb_1000.jpg</Thumbnail>
							</Image>
							<Image>
								<FullSize>CMSImage_1001.jpg</FullSize>
								<Thumbnail>CMSImageThumb_1001.jpg</Thumbnail>
							</Image>
						</Images>
					</Property>
				</BookingDetails>
			</BookingResponse>',
			new BookingResponse(
				$requestInfo,
				$returnStatusTrue,
				$bookingDetails
			)
		];

		yield [
			'<BookingResponse>
				<RequestInfo>
					<Timestamp>1687253937</Timestamp>
					<TimestampISO>2023-06-20T09:38:57+00:00</TimestampISO>
					<Host>xml.centriumres.com.localdomain.ee</Host>
					<HostIP>10.0.1.182</HostIP>
					<ReqID>649173b14aadb8.17864349</ReqID>
				</RequestInfo>
				<ReturnStatus>
					<Success>False</Success>
					<Exception>Supplier Reference not found for Booking Reference HCG0011m in SupplierBooking</Exception>
				</ReturnStatus>
			</BookingResponse>',
			new BookingResponse(
				$requestInfo,
				new ReturnStatus(
					false,
					'Supplier Reference not found for Booking Reference HCG0011m in SupplierBooking'
				)
			)
		];

		yield [
			'<BookingUpdateRequest>
				<LoginDetails>
					<Login>login</Login>
					<Password>pass</Password>
					<Version>version</Version>
				</LoginDetails>
				<Mock>True</Mock>
				<BookingReference>reference</BookingReference>
				<TradeReference>trade_reference</TradeReference>
			</BookingUpdateRequest>',
			new BookingUpdateRequest(
				$loginDetails,
				'reference',
				'trade_reference',
				true
			)
		];

		yield [
			'<BookingUpdateRequestResponse>
				<RequestInfo>
					<Timestamp>1687253937</Timestamp>
					<TimestampISO>2023-06-20T09:38:57+00:00</TimestampISO>
					<Host>xml.centriumres.com.localdomain.ee</Host>
					<HostIP>10.0.1.182</HostIP>
					<ReqID>649173b14aadb8.17864349</ReqID>
				</RequestInfo>
				<ReturnStatus>
					<Success>True</Success>
				</ReturnStatus>
				<BookingDetails>
					<BookingReference>HCF0011</BookingReference>
					<SupplierReference>8430154</SupplierReference>
					<Status>Live</Status>
					<Currency>EUR</Currency>
					<ArrivalDate>2023-11-01</ArrivalDate>
					<Duration>5</Duration>
					<LeadGuest>
						<FirstName>Jim</FirstName>
						<LastName>Watsworth</LastName>
						<Title>Mr</Title>
					</LeadGuest>
					<TradeReference>TEST_REF</TradeReference>
					<TotalPrice>1040</TotalPrice>
					<DueDate>2023-10-02</DueDate>
					<RoomBookings>
						<RoomBooking>
							<RoomID>155558</RoomID>
							<Name>Executive Double</Name>
							<View>Sea View</View>
							<MealBasisID>6</MealBasisID>
							<Adults>2</Adults>
							<Children>0</Children>
							<Infants>0</Infants>
							<Guests>
								<Guest>
									<Type>Adult</Type>
									<FirstName>Sally</FirstName>
									<LastName>Smith</LastName>
									<Title>Mrs</Title>
									<Nationality>French</Nationality>
								</Guest>
							</Guests>
							<Supplements>
								<Supplement>
									<Name>test supplement</Name>
									<Duration>Per Night</Duration>
									<Multiplier>Per Person</Multiplier>
									<Total>220</Total>
									<PaxType>Adult Only</PaxType>
								</Supplement>
							</Supplements>
							<SpecialOffers>
								<SpecialOffer>
									<Name>Example special offer</Name>
									<Type>Value Added</Type>
									<Desc>test desc</Desc>
								</SpecialOffer>
							</SpecialOffers>
							<Taxes>
								<Tax>
									<TaxName>test %</TaxName>
									<Inclusive>False</Inclusive>
									<Total>1148.55</Total>
								</Tax>
							</Taxes>
							<CancellationPolicies>
								<CancellationPolicy>
									<CancelBy>2020-07-11</CancelBy>
									<Penalty>574.28</Penalty>
								</CancellationPolicy>
							</CancellationPolicies>
							<RoomPrice>1040.23</RoomPrice>
						</RoomBooking>
						<RoomBooking>
							<RoomID>155558</RoomID>
							<Name>Executive Double</Name>
							<View>Sea View</View>
							<MealBasisID>6</MealBasisID>
							<Adults>1</Adults>
							<Children>1</Children>
							<Infants>0</Infants>
							<Guests>
								<Guest>
									<Type>Adult</Type>
									<FirstName>Sally</FirstName>
									<LastName>Smith</LastName>
									<Title>Mrs</Title>
									<Nationality>French</Nationality>
								</Guest>
								<Guest>
									<Type>Child</Type>
									<FirstName>Jimmy</FirstName>
									<LastName>Smith</LastName>
									<Age>5</Age>
									<Nationality>French</Nationality>
								</Guest>
							</Guests>
							<Supplements>
								<Supplement>
									<Name>Weekend Stay (Fri - Sun)</Name>
									<Duration>Per Night</Duration>
									<Multiplier>Per Room</Multiplier>
									<Total>60</Total>
								</Supplement>
								<Supplement>
									<Name>test supplement</Name>
									<Duration>Per Night</Duration>
									<Multiplier>Per Person</Multiplier>
									<Total>220</Total>
									<PaxType>Adult Only</PaxType>
								</Supplement>
							</Supplements>
							<SpecialOffers>
								<SpecialOffer>
									<Name>Example special offer</Name>
									<Type>Value Added</Type>
									<Desc>test desc</Desc>
								</SpecialOffer>
								<SpecialOffer>
									<Name>Example special offer 2</Name>
									<Type>Free Kids</Type>
									<Value>1</Value>
									<Total>1000</Total>
									<Desc>test desc</Desc>
								</SpecialOffer>
							</SpecialOffers>
							<Taxes>
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
							</Taxes>
							<CancellationPolicies>
								<CancellationPolicy>
									<CancelBy>2020-07-11</CancelBy>
									<Penalty>574.28</Penalty>
								</CancellationPolicy>
								<CancellationPolicy>
									<CancelBy>2020-07-18</CancelBy>
									<Penalty>1148.55</Penalty>
								</CancellationPolicy>
							</CancellationPolicies>
							<RoomPrice>1040.23</RoomPrice>
						</RoomBooking>
					</RoomBookings>
					<Property>
						<PropertyID>70011</PropertyID>
						<PropertyName>BUSY ROOMS HOTEL EMEA</PropertyName>
						<Supplier>
							<SupplierID>6</SupplierID>
							<SupplierName>RMI</SupplierName>
						</Supplier>
						<GIATAID>123</GIATAID>
						<Rating>4</Rating>
						<Errata>
							<Erratum>
								<StartDate>2020-08-04</StartDate>
								<EndDate>2020-08-11</EndDate>
								<Description>Small pool will be closed for maintenance</Description>
							</Erratum>
							<Erratum>
								<StartDate>2020-08-04</StartDate>
								<EndDate>2020-08-11</EndDate>
								<Description>There won\'t be mayonese at the restaurant</Description>
							</Erratum>
						</Errata>
						<GeographyLevel1ID>45</GeographyLevel1ID>
						<GeographyLevel2ID>76</GeographyLevel2ID>
						<GeographyLevel3ID>87</GeographyLevel3ID>
						<Country>United Kingdom</Country>
						<Area>Malta</Area>
						<Region>Malta</Region>
						<Strapline>Ideal for the business travellers and couples looking for the perfect getaway or just to relax, as well as experience a cultural city or visit the islands on a pre or post cruise vacation.</Strapline>
						<Description>Ideal for the business travellers and couples looking for the perfect getaway or just to relax, as well as experience a cultural city or visit the islands on a pre or post cruise vacation.</Description>
						<CMSBaseURL>https://az416281.vo.msecnd.net/hotels/</CMSBaseURL>
						<MainImage>3000-Emea  Hotel - Hotels/original/Emea-3-525-Copy.jpg</MainImage>
						<MainImageThumbnail>3000-Emea Copy.jpg</MainImageThumbnail>
						<Images>
							<Image>
								<FullSize>CMSImage_1000.jpg</FullSize>
								<Thumbnail>CMSImageThumb_1000.jpg</Thumbnail>
							</Image>
							<Image>
								<FullSize>CMSImage_1001.jpg</FullSize>
								<Thumbnail>CMSImageThumb_1001.jpg</Thumbnail>
							</Image>
						</Images>
					</Property>
				</BookingDetails>
			</BookingUpdateRequestResponse>',
			new BookingUpdateRequestResponse(
				$requestInfo,
				$returnStatusTrue,
				$bookingDetails
			)
		];

		yield [
			'<BookingUpdateRequestResponse>
				<RequestInfo>
					<Timestamp>1687253937</Timestamp>
					<TimestampISO>2023-06-20T09:38:57+00:00</TimestampISO>
					<Host>xml.centriumres.com.localdomain.ee</Host>
					<HostIP>10.0.1.182</HostIP>
					<ReqID>649173b14aadb8.17864349</ReqID>
				</RequestInfo>
				<ReturnStatus>
					<Success>False</Success>
					<Exception>No response from supplier</Exception>
				</ReturnStatus>
			</BookingUpdateRequestResponse>',
			new BookingUpdateRequestResponse(
				$requestInfo,
				new ReturnStatus(
					false,
					'No response from supplier'
				)
			)
		];

		yield [
			'<CancelRequest>
				<LoginDetails>
					<Login>login</Login>
					<Password>pass</Password>
					<Version>version</Version>
				</LoginDetails>
				<BookingReference>reference</BookingReference>
				<Reason>Reason</Reason>
			</CancelRequest>',
			new CancelRequest(
				$loginDetails,
				'reference',
				'Reason'
			)
		];

		$bookingDetailsCancellation = new BookingDetails(
			'HCL0011',
			'2DE9D13',
			'Cancelled',
			'This is a test cancellation',
			'EUR',
			0.0
		);

		yield [
			'<CancelResponse>
				<RequestInfo>
					<Timestamp>1687253937</Timestamp>
					<TimestampISO>2023-06-20T09:38:57+00:00</TimestampISO>
					<Host>xml.centriumres.com.localdomain.ee</Host>
					<HostIP>10.0.1.182</HostIP>
					<ReqID>649173b14aadb8.17864349</ReqID>
				</RequestInfo>
				<ReturnStatus>
					<Success>True</Success>
					<Exception/>
				</ReturnStatus>
				<BookingDetails>
					<BookingReference>HCL0011</BookingReference>
					<SupplierReference>2DE9D13</SupplierReference>
					<Status>Cancelled</Status>
					<CancellationReason>This is a test cancellation</CancellationReason>
					<Currency>EUR</Currency>
					<Amount>0</Amount>
				</BookingDetails>
			</CancelResponse>',
			new CancelResponse(
				$requestInfo,
				$returnStatusTrue,
				$bookingDetailsCancellation
			)
		];

		yield [
			'<CancelResponse>
				<RequestInfo>
					<Timestamp>1687253937</Timestamp>
					<TimestampISO>2023-06-20T09:38:57+00:00</TimestampISO>
					<Host>xml.centriumres.com.localdomain.ee</Host>
					<HostIP>10.0.1.182</HostIP>
					<ReqID>649173b14aadb8.17864349</ReqID>
				</RequestInfo>
				<ReturnStatus>
					<Success>False</Success>
					<Exception>Supplier Reference not found for Booking Reference HCL0011 in SupplierBooking</Exception>
				</ReturnStatus>
			</CancelResponse>',
			new CancelResponse(
				$requestInfo,
				$returnBookingStatusFalse
			)
		];

		yield [
			'<BookingResponse>
				<RequestInfo>
					<Timestamp>1687253937</Timestamp>
					<TimestampISO>2023-06-20T09:38:57+00:00</TimestampISO>
					<Host>xml.centriumres.com.localdomain.ee</Host>
					<HostIP>10.0.1.182</HostIP>
					<ReqID>649173b14aadb8.17864349</ReqID>
				</RequestInfo>
				<ReturnStatus>
					<Success>True</Success>
					<Exception/>
				</ReturnStatus>
				<BookingDetails>
					<BookingReference>HCL0011</BookingReference>
					<SupplierReference>2DE9D13</SupplierReference>
					<Status>Cancelled</Status>
					<CancellationReason>This is a test cancellation</CancellationReason>
					<Currency>EUR</Currency>
					<Amount>0</Amount>
				</BookingDetails>
			</BookingResponse>',
			new BookingResponse(
				$requestInfo,
				$returnStatusTrue,
				$bookingDetailsCancellation
			)
		];
	}

	public static function dataProviderLogTests()
	{
		//we need to respect the tabs and new lines in this test
		yield [
			[
				"<?xml version=\"1.0\"?>\n<BookingRequest><LoginDetails><Login>login</Login><Password>pass</Password><Version>6.0</Version></LoginDetails><Mock>True</Mock><BookingReference>reference</BookingReference></BookingRequest>\n",
				'<BookingResponse xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
    <RequestInfo>
        <Timestamp>1687272087</Timestamp>
        <TimestampISO>2023-06-20T14:41:27+00:00</TimestampISO>
        <Host>xml.centriumres.com.localdomain.ee</Host>
        <HostIP>10.0.1.182</HostIP>
        <ReqID>6491ba97b67730.15258201</ReqID>
    </RequestInfo>
    <ReturnStatus>
        <Success>False</Success>
        <Exception>Unknown BookingReference. Please check and try again.</Exception>
    </ReturnStatus>
</BookingResponse>',
				200
			]
		];
	}
}
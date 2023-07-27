<?php
declare(strict_types = 1);

namespace XmlWorld\ApiClient;

use GuzzleHttp\Client;
use InvalidArgumentException;
use SimpleXMLElement;
use Throwable;
use XmlWorld\ApiClient\Interfaces\Logger;
use XmlWorld\ApiClient\Interfaces\Serializable;
use XmlWorld\ApiClient\Interfaces\Serializer;

use XmlWorld\ApiClient\Requests\BookDetails;
use XmlWorld\ApiClient\Requests\BookingRequest;
use XmlWorld\ApiClient\Requests\BookingUpdateRequest;
use XmlWorld\ApiClient\Requests\BookRequest;
use XmlWorld\ApiClient\Requests\CancelRequest;
use XmlWorld\ApiClient\Requests\LoginDetails;
use XmlWorld\ApiClient\Requests\Request;
use XmlWorld\ApiClient\Requests\SearchDetails;
use XmlWorld\ApiClient\Requests\SearchRequest;
use XmlWorld\ApiClient\Responses\BookingResponse;
use XmlWorld\ApiClient\Responses\BookingUpdateRequestResponse;
use XmlWorld\ApiClient\Responses\BookResponse;
use XmlWorld\ApiClient\Responses\CancelResponse;
use XmlWorld\ApiClient\Responses\Response;

class XMLClient
{
	const ENV_DEV = 'DEV';
	const ENV_LIV = 'LIVE';

	/** @var string[] */
    protected static array $envs = [
        self::ENV_DEV => 'https://xmldev-xml.xml.world',
		self::ENV_LIV => 'https://xml.xml.world'
    ];

    const VERSION = '6.0';

    protected LoginDetails $loginDetails;

    protected Client $client;

    protected Logger $logger;

    protected Serializer $serializer;

	protected string $env;

	/**
	 * @param string $login
	 * @param string $password
	 * @param string $env
	 * @param Logger|null $logger
	 */
    public function __construct(string $login, string $password, string $env = self::ENV_LIV, Logger $logger = null)
    {
    	if(!isset(self::$envs[$env])){
    		throw new InvalidArgumentException('Invalid environment');
		}

		$this->env = $env;

    	if(is_null($logger)){
    		$this->logger = new NullLogger;
		} else {
			$this->logger = $logger;
		}

        $this->loginDetails = new LoginDetails($login, $password, self::VERSION);

		$this->client = $this->getClient();

		$this->serializer = new SerializeXML;
    }

	public static function setDevURL(string $url) : void
	{
		self::$envs[self::ENV_DEV] = $url;
	}

    protected function getClient() : Client
	{
		return new Client([
			'base_uri' => self::$envs[$this->env],
			'headers' => ['Content-Type' => 'text/xml; charset=utf-8']
		]);
	}

	/**
	 * @throws Throwable
	 */
	public function search(SearchDetails $searchDetails):Serializable
	{
		return $this->post(new SearchRequest(
			$this->loginDetails,
			$searchDetails,
			$this->env == self::ENV_DEV
		));
	}

	/**
	 * @throws Throwable
	 */
	public function book(BookDetails $bookingDetails) : Response | BookResponse
	{
		return $this->post(new BookRequest($this->loginDetails, $bookingDetails, $this->env == self::ENV_DEV));
	}

	/**
	 * @throws Throwable
	 */
	public function booking(string $reference) : Response | BookingResponse
    {
        return $this->post(new BookingRequest($this->loginDetails, $reference, $this->env == self::ENV_DEV));
    }

	/**
	 * @throws Throwable
	 */
	public function bookingUpdate(string $reference, string $tradeReference) : Response | BookingUpdateRequestResponse
	{
		return $this->post(new BookingUpdateRequest($this->loginDetails, $reference, $tradeReference, $this->env == self::ENV_DEV));
	}

	/**
	 * @throws Throwable
	 */
	public function cancel(string $reference, string $reason) : Response | CancelResponse
    {
        return $this->post(new CancelRequest($this->loginDetails, $reference, $reason, $this->env == self::ENV_DEV));
    }

    public function setLogger(Logger $logger):void
	{
    	$this->logger = $logger;
	}

	/**
	 * @throws Throwable
	 * @throws \Exception
	 */
	protected function post(Request $request): Response
    {
        //by doing this we add the xml version
        $xml = new SimpleXMLElement($this->serializer->serialize($request));

        $request_row = $xml->asXML();

        $this->logger->logRequest($request_row);

		$response = $this->client->request('POST', '', ['body' => $request_row]);

		$responseCode = $response->getStatusCode();
		$responseBody = $response->getBody()->__toString();

		//we log the response
		$this->logger->logResponse(
			$responseCode,
			$responseBody
		);

		// Request was successful, handle the response
        if ($responseCode == 200) {

            // Process the response data
			/** @var Response $ret */
            $ret = $this->serializer->unSerialize($responseBody);
        } else {
            // Request failed, handle the error
			/** @var Response $ret */
			$ret = $this->serializer->unserialize($responseBody);
        }

		return $ret;
    }
}

<?php
declare(strict_types = 1);

namespace xmlworld\apiclient;

use GuzzleHttp\Client;
use InvalidArgumentException;
use SimpleXMLElement;
use Throwable;
use xmlworld\apiclient\Interfaces\Logger;
use xmlworld\apiclient\Interfaces\Serializable;
use xmlworld\apiclient\Interfaces\Serializer;

use xmlworld\apiclient\Requests\BookDetails;
use xmlworld\apiclient\Requests\BookingRequest;
use xmlworld\apiclient\Requests\BookingUpdateRequest;
use xmlworld\apiclient\Requests\BookRequest;
use xmlworld\apiclient\Requests\CancelRequest;
use xmlworld\apiclient\Requests\LoginDetails;
use xmlworld\apiclient\Requests\Request;
use xmlworld\apiclient\Requests\SearchDetails;
use xmlworld\apiclient\Requests\SearchRequest;
use xmlworld\apiclient\Responses\BookingResponse;
use xmlworld\apiclient\Responses\BookingUpdateRequestResponse;
use xmlworld\apiclient\Responses\BookResponse;
use xmlworld\apiclient\Responses\CancelResponse;
use xmlworld\apiclient\Responses\Response;

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

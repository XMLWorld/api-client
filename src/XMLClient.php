<?php


namespace XmlWorld\ApiPackagePhp;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use InvalidArgumentException;
use SimpleXMLElement;
use Throwable;
use XmlWorld\ApiPackagePhp\Interfaces\Logger;
use XmlWorld\ApiPackagePhp\Interfaces\Serializable;
use XmlWorld\ApiPackagePhp\Interfaces\Serializer;

use XmlWorld\ApiPackagePhp\Requests\BookDetails;
use XmlWorld\ApiPackagePhp\Requests\BookingRequest;
use XmlWorld\ApiPackagePhp\Requests\BookingUpdateRequest;
use XmlWorld\ApiPackagePhp\Requests\BookRequest;
use XmlWorld\ApiPackagePhp\Requests\CancelRequest;
use XmlWorld\ApiPackagePhp\Requests\LoginDetails;
use XmlWorld\ApiPackagePhp\Requests\Request;
use XmlWorld\ApiPackagePhp\Requests\SearchDetails;
use XmlWorld\ApiPackagePhp\Requests\SearchRequest;
use XmlWorld\ApiPackagePhp\Responses\BookingResponse;
use XmlWorld\ApiPackagePhp\Responses\BookingUpdateRequestResponse;
use XmlWorld\ApiPackagePhp\Responses\BookResponse;
use XmlWorld\ApiPackagePhp\Responses\CancelResponse;
use XmlWorld\ApiPackagePhp\Responses\Response;

class XMLClient
{
	const ENV_DEV = 'DEV';
	const ENV_LIV = 'LIVE';
    const ENVS = [
        self::ENV_DEV => 'http://xml.centriumres.com.localdomain.ee',
		self::ENV_LIV => 'https://xml.centriumres.com'
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
    public function __construct(string $login, string $password, string $env = self::ENV_DEV, Logger $logger = null)
    {
    	if(!isset(self::ENVS[$env])){
    		throw new InvalidArgumentException('Invalid environment');
		}

		$this->env = $env;

    	if(is_null($logger)){
    		$this->logger = new NullLogger;
		} else {
			$this->logger = $logger;
		}


        $this->loginDetails = new LoginDetails($login, $password, self::VERSION);

		$this->client = $this->getClient($env);

		$this->serializer = new SerializeXML;
    }

    protected function getClient(string $env) : Client
	{
		return new Client([
			'base_uri' => self::ENVS[$env],
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
			true
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
		$responseBody = $response->getBody();

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

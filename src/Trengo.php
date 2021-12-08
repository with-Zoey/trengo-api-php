<?php

namespace WithZoey\Trengo;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use GuzzleHttp\ClientInterface;
use WithZoey\Trengo\Resources\Contact;
use WithZoey\Trengo\Resources\QuickReply;
use WithZoey\Trengo\Resources\Sms;
use WithZoey\Trengo\Resources\Ticket;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Exception\GuzzleException;
use WithZoey\Trengo\Exceptions\MissingApiKeyException;

class Trengo
{
    public const CLIENT_VERSION = '0.1.0';
    public const API_ENDPOINT = 'https://app.trengo.com/api/';
    public const API_VERSION = 'v2';
    public const TIMEOUT = 15;

    /** @var Client|ClientInterface|null */
    protected $httpClient;

    /** @var array */
    protected $userAgentComponent = [];

    /** @var string */
    private $apiKey;

    public $ticket;
    public $sms;
    public $contact;
    public $quickReply;

    /**
     * WeFact constructor.
     * @param ClientInterface|null $httpClient
     */
    public function __construct(ClientInterface $httpClient = null)
    {
        $this->httpClient = $httpClient ?
            $httpClient :
            new Client([
                RequestOptions::TIMEOUT => self::TIMEOUT,
            ]);

        $this->addUserAgentString('Trengo/' . self::CLIENT_VERSION);
        $this->addUserAgentString('PHP/' . phpversion());

        $this->ticket = new Ticket($this);
        $this->quickReply = new QuickReply($this);
        $this->sms = new Sms($this);
        $this->contact = new Contact($this);
    }

    /**
     * @param string $apiKey
     */
    public function setApiKey(string $apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * @return string
     */
    public function getApiUrl(): string
    {
        return sprintf(
            '%s%s/',
            self::API_ENDPOINT,
            self::API_VERSION
        );
    }

    /**
     * @param string $controller
     * @param string $action
     * @param array $body
     * @return mixed
     * @throws Exceptions\ApiException
     * @throws GuzzleException
     * @throws MissingApiKeyException
     */
    public function doHttpCall(string $method, string $url, array $body = [])
    {
        if (!$this->apiKey) {
            throw new MissingApiKeyException('Missing API Key.');
        }

        $headers = [
            'Accept'        => 'application/json',
            'Authorization' => 'Bearer ' . $this->apiKey
        ];

        $params = [
            'headers' => $headers
        ];
        if (count($body) > 0) {
            $params['form_params'] = $body;
        }

        $url = $this->getApiUrl() . $url;

        $response = $this->httpClient->request($method, $url, $params);
        return $this->parseResponse($response);
    }

    /**
     * @param ResponseInterface $httpResponse
     * @return mixed
     * @throws Exceptions\ApiException
     */
    public function parseResponse(ResponseInterface $httpResponse)
    {
        return ResponseFactory::createFromHttpResponse($httpResponse);
    }

    /**
     * @param string $string
     * @return $this
     */
    public function addUserAgentString(string $string)
    {
        $this->userAgentComponent[] = str_replace([" ", "\t", "\n", "\r"], '-', $string);
        return $this;
    }
}

<?php

namespace WithZoey\Trengo\Resources;

use WithZoey\Trengo\Exceptions\ApiException;
use WithZoey\Trengo\Exceptions\MissingApiKeyException;
use WithZoey\Trengo\Trengo;
use GuzzleHttp\Exception\GuzzleException;

abstract class Resource
{
    /**
     * @var Trengo $client
     */
    protected $client;

    /**
     * Resource constructor.
     * @param WeFact $client
     */
    public function __construct(Trengo $client)
    {
        $this->client = $client;
    }

    /**
     * @param array $parameters
     * @return mixed
     * @throws ApiException
     * @throws GuzzleException
     * @throws MissingApiKeyException
     */
    public function list(array $parameters = [])
    {
        $url = $this->getResourceName();
        return $this->client->doHttpCall('GET', $url);
    }

    /**
     * @return string
     */
    abstract public function getResourceName(): string;
}

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
     * @param Trengo $client
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

    /**
     * @param array $parameters
     * @param array $validParams
     * @return string
     */
    public function setParameters(array $parameters, array $validParams): string
    {
        if (count($parameters) > 0) {
            $urlParams = "?";
            $lastParameterKey = key(array_slice($parameters, -1, 1, true));

            foreach ($parameters as $label => $value) {
                //skip the params which are not available
                if (!in_array($label, $validParams)) {
                    continue;
                }

                if (is_array($value)) {
                    $lastArrayKey = key(array_slice($value, -1, 1, true));
                    foreach ($value as $key => $arrayParam) {
                        $urlParams .= "{$label}[]={$arrayParam}";
                        $urlParams .= $lastArrayKey !== $key ? '&' : '';
                    }
                } else {
                    $urlParams .= "{$label}={$value}";
                    $urlParams .= $lastParameterKey !== $label ? '&' : '';
                }
            }
            return $urlParams;
        }
        return '';
    }
}

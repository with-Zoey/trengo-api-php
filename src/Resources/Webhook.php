<?php

namespace WithZoey\Trengo\Resources;

use WithZoey\Trengo\Exceptions\ApiException;
use WithZoey\Trengo\Exceptions\MissingApiKeyException;

class Webhook extends Resource
{
    public const CONTROLLER_NAME = 'webhooks';

    /**
     * @return string
     */
    public function getResourceName(): string
    {
        return self::CONTROLLER_NAME;
    }

    /**
     * @param array $parameters
     * @return mixed
     * @throws ApiException
     * @throws MissingApiKeyException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function list(array $parameters = [])
    {
        $url = $this->getResourceName();
        $url .= $this->setParameters($parameters, ['page']);
        return $this->client->doHttpCall('GET', $url);
    }

    /**
     * @param int $id
     * @return mixed
     * @throws ApiException
     * @throws MissingApiKeyException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function get(int $id)
    {
        $url = $this->getResourceName() . "/{$id}";
        return $this->client->doHttpCall('GET', $url);
    }

    /**
     * @param string $name
     * @param string $type
     * @param string $url
     * @return mixed
     * @throws ApiException
     * @throws MissingApiKeyException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function create(string $name, string $type, string $url)
    {
        $url = $this->getResourceName();
        $body = [
            "name" => $name,
            "type" => $type,
            "url" => $url
        ];
        return $this->client->doHttpCall('POST', $url, $body);
    }

    /**
     * @param int $id
     * @param string $name
     * @param string $type
     * @param string $url
     * @return mixed
     * @throws ApiException
     * @throws MissingApiKeyException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function update(int $id, string $name, string $type, string $url)
    {
        $url = $this->getResourceName() . "/{$id}";
        $body = [
            "name" => $name,
            "type" => $type,
            "url" => $url
        ];
        return $this->client->doHttpCall('PUT', $url, $body);
    }

    /**
     * @param int $id
     * @return mixed
     * @throws ApiException
     * @throws MissingApiKeyException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function delete(int $id)
    {
        $url = $this->getResourceName() . "/{$id}";
        return $this->client->doHttpCall('DELETE', $url);
    }
}

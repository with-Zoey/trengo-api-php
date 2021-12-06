<?php

namespace WithZoey\Trengo\Resources;

use WithZoey\Trengo\Exceptions\ApiException;
use WithZoey\Trengo\Exceptions\MissingApiKeyException;

class ContactGroup extends Resource
{
    public const CONTROLLER_NAME = 'contact_groups';

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
     * @param array $parameters
     * @return mixed
     * @throws ApiException
     * @throws MissingApiKeyException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function get(int $id, array $parameters = [])
    {
        $url = $this->getResourceName() . "{$id}";
        $url .= $this->setParameters($parameters, ['page']);
        return $this->client->doHttpCall('GET', $url);
    }

    /**
     * @param string $name
     * @return mixed
     * @throws ApiException
     * @throws MissingApiKeyException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function create(string $name)
    {
        $url = $this->getResourceName();
        $body = [
            "name" => $name,
        ];
        return $this->client->doHttpCall('POST', $url, $body);
    }

    /**
     * @param int $quick_reply_id
     * @param string $title
     * @param string $message
     * @param string $type
     * @param array $channel_ids
     * @return mixed
     * @throws ApiException
     * @throws MissingApiKeyException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function update(int $id, string $name)
    {
        $url = $this->getResourceName() . "{$id}";
        $body = [
            "name" => $name,
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
        $url = $this->getResourceName() . "{$id}";
        return $this->client->doHttpCall('DELETE', $url);
    }
}

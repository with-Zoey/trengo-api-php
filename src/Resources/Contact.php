<?php

namespace WithZoey\Trengo\Resources;

use WithZoey\Trengo\Exceptions\ApiException;
use WithZoey\Trengo\Exceptions\MissingApiKeyException;

class Contact extends Resource
{
    public const CONTROLLER_NAME = 'contacts';

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
        $url .= $this->setParameters($parameters, ['page', 'term']);
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
    public function view(int $id, array $parameters = [])
    {
        $url = $this->getResourceName() . "/{$id}";
        $url .= $this->setParameters($parameters, ['include']);
        return $this->client->doHttpCall('GET', $url);
    }

    /**
     * @param int $channel_id
     * @param string $identifier
     * @param int|null $corresponding_channel_id
     * @return mixed
     * @throws ApiException
     * @throws MissingApiKeyException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function findOrCreate(int $channel_id, string $identifier = '', int $corresponding_channel_id = null)
    {
        $url = "channels/{$channel_id}/" . $this->getResourceName();
        $body = [
            "identifier" => $identifier,
            "channel_id" => $corresponding_channel_id,
        ];
        return $this->client->doHttpCall('POST', $url, $body);
    }

    /**
     * @param int $id
     * @param string $name
     * @param array $contact_group_ids
     * @return mixed
     * @throws ApiException
     * @throws MissingApiKeyException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function update(int $id, string $name = '', array $contact_group_ids = [])
    {
        $url = $this->getResourceName() . "/{$id}";
        $body = [
            "name" => $name,
            "contact_group_ids" => $contact_group_ids,
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

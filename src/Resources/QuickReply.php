<?php

namespace WithZoey\Trengo\Resources;

use WithZoey\Trengo\Exceptions\ApiException;
use WithZoey\Trengo\Exceptions\MissingApiKeyException;

class QuickReply extends Resource
{
    public const CONTROLLER_NAME = 'quick_replies';

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
        $url .= $this->setParameters($parameters, ['type']);
        return $this->client->doHttpCall('GET', $url);
    }

    /**
     * @param string $title
     * @param string $message
     * @param string $type
     * @param array $channel_ids
     * @return mixed
     * @throws ApiException
     * @throws MissingApiKeyException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function create(string $title, string $message, string $type, array $channel_ids = [])
    {
        $url = $this->getResourceName();
        $body = [
            "title" => $title,
            "message" => $message,
            "type" => $type,
            "channel_ids" => $channel_ids,
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
    public function update(int $quick_reply_id, string $title, string $message, string $type, array $channel_ids = [])
    {
        $url = $this->getResourceName() . "/{$quick_reply_id}";
        $body = [
            "title" => $title,
            "message" => $message,
            "type" => $type,
            "channel_ids" => $channel_ids,
        ];
        return $this->client->doHttpCall('PUT', $url, $body);
    }

    /**
     * @param int $quick_reply_id
     * @return mixed
     * @throws ApiException
     * @throws MissingApiKeyException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function delete(int $quick_reply_id)
    {
        $url = $this->getResourceName() . "/{$quick_reply_id}";
        return $this->client->doHttpCall('DELETE', $url);
    }
}

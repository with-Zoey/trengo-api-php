<?php

namespace WithZoey\Trengo\Resources;

use WithZoey\Trengo\Exceptions\ApiException;
use WithZoey\Trengo\Exceptions\MissingApiKeyException;

class Sms extends Resource
{
    public const CONTROLLER_NAME = 'sms_messages';

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
     * @param int $channel_id
     * @param string $to
     * @param string $message
     * @return mixed
     * @throws ApiException
     * @throws MissingApiKeyException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function send(int $channel_id, string $to, string $message = '')
    {
        $url = $this->getResourceName();
        $body = [
            "channel_id" => $channel_id,
            "message" => $message,
            "to" => $to
        ];
        return $this->client->doHttpCall('POST', $url, $body);
    }

    /**
     * @return mixed
     * @throws ApiException
     * @throws MissingApiKeyException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function fetchBalance()
    {
        $url = '/wallet/balance';
        return $this->client->doHttpCall('GET', $url);
    }
}

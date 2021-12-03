<?php

namespace WithZoey\Trengo\Resources;

use WithZoey\Trengo\Exceptions\ActionNotAvailableException;
use WithZoey\Trengo\Exceptions\ApiException;
use WithZoey\Trengo\Exceptions\MissingApiKeyException;

class Ticket extends Resource
{
    public const CONTROLLER_NAME = 'tickets';

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
        $url .= $this->setParameters($parameters, ['users', 'channels', 'labels']);
        return $this->client->doHttpCall('GET', $url);
    }

    /**
     * @param int $ticket_id
     * @param int $message_id
     * @return mixed
     * @throws ApiException
     * @throws MissingApiKeyException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function fetchMessage(int $ticket_id, int $message_id)
    {
        $url = $this->getResourceName() . "{$ticket_id}/messages/{$message_id}";
        return $this->client->doHttpCall('GET', $url);
    }

    /**
     * @param int $channel_id
     * @param int $contact_id
     * @param string $subject
     * @return mixed
     * @throws ApiException
     * @throws MissingApiKeyException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function create(int $channel_id, int $contact_id, string $subject = "")
    {
        $url = $this->getResourceName();
        $body = [
            "channel_id" => $channel_id,
            "contact_id" => $contact_id,
            "subject" => $subject,
        ];
        return $this->client->doHttpCall('POST', $url, $body);
    }


    /**
     * @param array $parameters
     * @return mixed|void
     * @throws ActionNotAvailableException
     */
    public function show(array $parameters = [])
    {
        throw new ActionNotAvailableException(
            sprintf('%s is not available for this controller.', __METHOD__)
        );
    }


    /**
     * @param array $data
     * @return mixed|void
     * @throws ActionNotAvailableException
     */
    public function edit(array $data)
    {
        throw new ActionNotAvailableException(
            sprintf('%s is not available for this controller.', __METHOD__)
        );
    }

    /**
     * @param array $parameters
     * @return mixed|void
     * @throws ActionNotAvailableException
     */
    public function delete(array $parameters)
    {
        throw new ActionNotAvailableException(
            sprintf('%s is not available for this controller.', __METHOD__)
        );
    }
}

<?php

namespace WithZoey\Trengo\Resources;

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
        $url .= $this->setParameters($parameters, ['page', 'status', 'contact_id', 'users', 'channels', 'labels']);
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
        $url = $this->getResourceName() . "/{$ticket_id}/messages/{$message_id}";
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
     * @param int $ticket_id
     * @return mixed
     * @throws ApiException
     * @throws MissingApiKeyException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function delete(int $ticket_id)
    {
        $url = $this->getResourceName() . "/{$ticket_id}";
        return $this->client->doHttpCall('DELETE', $url);
    }

    /**
     * @param int $ticket_id
     * @param string $message
     * @param bool|null $internal_note
     * @param string $subject
     * @param array $attachment_ids
     * @return mixed
     * @throws ApiException
     * @throws MissingApiKeyException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function sendTicketMessage(int $ticket_id, string $message, bool $internal_note = null, string $subject = '', array $attachment_ids = [])
    {
        $url = $this->getResourceName() . "/{$ticket_id}/messages";
        $body = [
            "message" => $message,
            "internal_note" => $internal_note,
            "subject" => $subject,
            "attachment_ids" => $attachment_ids,
        ];
        return $this->client->doHttpCall('POST', $url, $body);
    }

    /**
     * @param int $ticket_id
     * @param string $file
     * @param string $caption
     * @return mixed
     * @throws ApiException
     * @throws MissingApiKeyException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function sendTicketMediaMessage(int $ticket_id, string $file, string $caption = '')
    {
        $url = $this->getResourceName() . "/{$ticket_id}/messages/media";
        $body = [
            "caption" => $caption,
            "file" => $file
        ];
        return $this->client->doHttpCall('POST', $url, $body);
    }

    /**
     * @param $file
     * @return mixed
     * @throws ApiException
     * @throws MissingApiKeyException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function uploadFile($file)
    {
        $url = 'upload/messages/multipart';
        $body = [
            "file" => $file
        ];
        return $this->client->doHttpCall('POST', $url, $body);
    }

    /**
     * @param int $ticket_id
     * @param int $message_id
     * @return mixed
     * @throws ApiException
     * @throws MissingApiKeyException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function deleteMessage(int $ticket_id, int $message_id)
    {
        $url = $this->getResourceName() . "/{$ticket_id}/messages{$message_id}";
        return $this->client->doHttpCall('DELETE', $url);
    }
}

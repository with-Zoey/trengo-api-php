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
     * @throws GuzzleException
     * @throws MissingApiKeyException
     */
    public function list(array $parameters = [])
    {
        $url = $this->getResourceName();
        if (count($parameters) > 0) {
            $url .= "?";

            $array_params = ['users', 'channels', 'labels'];
            foreach($parameters as $label=>$value) {

                //skip the params which are arrays
                if (in_array($label, $array_params)) {
                    continue;
                }
                $url .= "{$label}={$value}&";
            }

            foreach($parameters as $label=>$value) {

                //build the params which are arrays
                if (!in_array($label, $array_params)) {
                    continue;
                }
                foreach ($value as $array_param) {
                    $url .= "{$label}[]={$array_param}&";
                }
                
            }
            $url = substr($url, 0, -1);
        }

        return $this->client->doHttpCall('GET', $url);
    }    
    
    /**
     * @param int $ticket_id
     * @param int $message_id
     * @return mixed
     * @throws ApiException
     * @throws GuzzleException
     * @throws MissingApiKeyException
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
     * @return mixed|void
     * @throws ApiException
     * @throws GuzzleException
     * @throws MissingApiKeyException
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

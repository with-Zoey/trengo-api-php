<?php

namespace WithZoey\Trengo\Resources;


class Whatsapp extends Resource
{
    public const CONTROLLER_NAME = 'wa_sessions';

    /**
     * @return string
     */
    public function getResourceName(): string
    {
        return self::CONTROLLER_NAME;
    }

    /**
     * @param string $ticket_id
     * @param int $hsm_id
     * @param array $params
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \WithZoey\Trengo\Exceptions\ApiException
     * @throws \WithZoey\Trengo\Exceptions\MissingApiKeyException
     */
    public function startConversation(string $ticket_id, int $hsm_id, array $params = [])
    {
        $url = $this->getResourceName();
        $body = [
            "ticket_id" => $ticket_id,
            "hsm_id" => $hsm_id,
            "params" => $params
        ];
        return $this->client->doHttpCall('POST', $url, $body);
    }
}

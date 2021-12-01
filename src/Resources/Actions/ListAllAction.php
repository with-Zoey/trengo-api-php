<?php

namespace WithZoey\Trengo\Resources\Actions;

use WithZoey\Trengo\Exceptions\ApiException;
use WithZoey\Trengo\Exceptions\MissingApiKeyException;
use WithZoey\Trengo\Resources\Resource;

trait ListAllAction
{
    /**
     * @return mixed
     * @throws ApiException
     * @throws GuzzleException
     * @throws MissingApiKeyException
     */
    public function listAll()
    {
        $controller = $this->getResourceName();

        return $this->client->doHttpCall(
            $controller,
            'cancelschedule'
        );
    }
}

<?php

namespace WithZoey\Trengo\Resources;

use WithZoey\Trengo\Exceptions\ActionNotAvailableException;
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
     * @throws GuzzleException
     * @throws MissingApiKeyException
     */
    public function list(array $parameters = [])
    {
        $url = $this->getResourceName();
        if (count($parameters) > 0) {
            $url .= "?";

            $valid_params = ['page'];
            foreach($parameters as $label=>$value) {

                //skip the params which are not available
                if (in_array($label, $valid_params)) {
                    continue;
                }
                $url .= "{$label}={$value}";
            }
        }

        return $this->client->doHttpCall('GET', $url);
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
    public function create(array $data)
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

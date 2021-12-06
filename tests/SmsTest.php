<?php

namespace Tests;

use WithZoey\Trengo\Exceptions\ApiException;
use WithZoey\Trengo\Exceptions\MissingApiKeyException;
use WithZoey\Trengo\Resources\Sms;
use WithZoey\Trengo\Trengo;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Response;

class SmsTest extends TestCase
{
    /** @var ClientInterface */
    private $guzzleClient;

    /** @var trengo */
    private $trengo;

    /**
     * @var Sms
     */
    private $sms;

    protected function setUp(): void
    {
        parent::setUp();
        $this->guzzleClient = $this->createMock(Client::class);
        $this->trengo = new Trengo($this->guzzleClient);
        $this->sms = new Sms($this->trengo);

        $this->trengo->setApiKey('test_api_key');
    }

    /**
     * @throws GuzzleException
     * @throws MissingApiKeyException
     * @throws ApiException
     */
    public function testGetSmsList()
    {
        $responseBody = '{
          "data": [],
          "links": {
            "first": "https://app.trengo.com/api/v2/sms_messages?page=1",
            "last": "https://app.trengo.com/api/v2/sms_messages?page=1",
            "prev": null,
            "next": null
          },
          "meta": {
            "current_page": 1,
            "from": null,
            "last_page": 1,
            "links": [
              {
                "url": null,
                "label": "pagination.previous",
                "active": false
              },
              {
                "url": "https://app.trengo.com/api/v2/sms_messages?page=1",
                "label": "1",
                "active": true
              },
              {
                "url": null,
                "label": "pagination.next",
                "active": false
              }
            ],
            "path": "https://app.trengo.com/api/v2/sms_messages",
            "per_page": 25,
            "to": null,
            "total": 0
          }
        }';
        $response = new Response(200, [], $responseBody);

        $this->guzzleClient
            ->expects($this->once())
            ->method('request')
            ->willReturn($response);

        $response = $this->sms->list();

        $this->assertEquals(
            json_decode($responseBody, true),
            $response
        );
    }
}

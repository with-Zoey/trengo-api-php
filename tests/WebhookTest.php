<?php

namespace Tests;

use WithZoey\Trengo\Exceptions\ApiException;
use WithZoey\Trengo\Exceptions\MissingApiKeyException;
use WithZoey\Trengo\Resources\Webhook;
use WithZoey\Trengo\Trengo;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Response;

class WebhookTest extends TestCase
{
    /** @var ClientInterface */
    private $guzzleClient;

    /** @var trengo */
    private $trengo;

    /** @var Webhook */
    private $webhook;

    protected function setUp(): void
    {
        parent::setUp();
        $this->guzzleClient = $this->createMock(Client::class);
        $this->trengo = new Trengo($this->guzzleClient);
        $this->webhook = new Webhook($this->trengo);

        $this->trengo->setApiKey('test_api_key');
    }

    /**
     * @throws GuzzleException
     * @throws MissingApiKeyException
     * @throws ApiException
     */
    public function testGetWebhookList()
    {
        $responseBody = '{
          "data": [
            {
              "id": 12,
              "title": "Webhook #12",
              "url": "http://test-url.com",
              "type": "INBOUND",
              "signing_secret": "0RLUURnwi5eGYX8CQqNR97wyFQ4h1cF9"
            },
            {
              "id": 7637,
              "title": "Webhook #7637",
              "url": "http://test-url2.com",
              "type": "INBOUND",
              "signing_secret": "vVxE8b2VEQtoFRvqYCcI2R4aYD2anCA4"
            }
          ],
          "links": {
            "first": "https://app.trengo.com/api/v2/webhooks?page=1",
            "last": "https://app.trengo.com/api/v2/webhooks?page=1",
            "prev": null,
            "next": null
          },
          "meta": {
            "current_page": 1,
            "from": 1,
            "last_page": 1,
            "links": [
              {
                "url": null,
                "label": "pagination.previous",
                "active": false
              },
              {
                "url": "https://app.trengo.com/api/v2/webhooks?page=1",
                "label": "1",
                "active": true
              },
              {
                "url": null,
                "label": "pagination.next",
                "active": false
              }
            ],
            "path": "https://app.trengo.com/api/v2/webhooks",
            "per_page": 999,
            "to": 2,
            "total": 2
          }
        }';
        $response = new Response(200, [], $responseBody);

        $this->guzzleClient
            ->expects($this->once())
            ->method('request')
            ->willReturn($response);

        $response = $this->webhook->list();

        $this->assertEquals(
            json_decode($responseBody),
            $response
        );
    }

    /**
     * @throws ApiException
     * @throws GuzzleException
     * @throws MissingApiKeyException
     */
    public function testGetWebhook()
    {
        $responseBody = '{
            "id": 7637,
            "title": "Webhook #7637",
            "url": "http://test-url.com",
            "type": "INBOUND",
            "signing_secret": "vVxE8b2VEQtoFRvqYCcI2R4aYD2anCA4"
        }';
        $response = new Response(200, [], $responseBody);

        $this->guzzleClient
            ->expects($this->once())
            ->method('request')
            ->willReturn($response);

        $response = $this->webhook->get(7637);

        $this->assertEquals(
            json_decode($responseBody),
            $response
        );
    }

    /**
     * @throws ApiException
     * @throws GuzzleException
     * @throws MissingApiKeyException
     */
    public function testGetWebhookFail()
    {
        $this->expectErrorMessage('Argument 1 passed to WithZoey\Trengo\Resources\Webhook::get() must be of the type int, string given, called in ');
        $this->webhook->get('test');
    }

    /**
     * @throws GuzzleException
     * @throws MissingApiKeyException
     * @throws ApiException
     */
    public function testCreateWebhook()
    {
        $responseBody = '{
            "id": 7637,
            "title": "Webhook #7637",
            "url": "http://test-url.com",
            "type": "INBOUND",
            "signing_secret": "vVxE8b2VEQtoFRvqYCcI2R4aYD2anCA4"
        }';
        $response = new Response(200, [], $responseBody);

        $this->guzzleClient
            ->expects($this->once())
            ->method('request')
            ->willReturn($response);

        $response = $this->webhook->create('webhook_name', 'INBOUND', 'www.test-url.com');

        $this->assertEquals(
            json_decode($responseBody),
            $response
        );
    }

    /**
     * @throws ApiException
     * @throws GuzzleException
     * @throws MissingApiKeyException
     */
    public function testUpdateWebhook()
    {
        $responseBody = '';
        $response = new Response(200, [], $responseBody);

        $this->guzzleClient
            ->expects($this->once())
            ->method('request')
            ->willReturn($response);

        $response = $this->webhook->update(7637, 'test', 'INBOUND', 'www.test-url.com');

        $this->assertEquals(
            null,
            $response
        );
    }

    /**
     * @throws ApiException
     * @throws GuzzleException
     * @throws MissingApiKeyException
     */
    public function testDeleteWebhook()
    {
        $response = new Response(200, [], '');

        $this->guzzleClient
            ->expects($this->once())
            ->method('request')
            ->willReturn($response);

        $response = $this->webhook->delete(7637);

        $this->assertEquals(
            null,
            $response
        );
    }

    /**
     * @throws ApiException
     * @throws GuzzleException
     * @throws MissingApiKeyException
     */
    public function testDeleteWebhookFail()
    {
        $this->expectErrorMessage('Argument 1 passed to WithZoey\Trengo\Resources\Webhook::delete() must be of the type int, string given, called in ');
        $this->webhook->delete('test');
    }
}

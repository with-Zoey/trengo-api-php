<?php

namespace Tests;

use WithZoey\Trengo\Exceptions\ApiException;
use WithZoey\Trengo\Exceptions\MissingApiKeyException;
use WithZoey\Trengo\Resources\QuickReply;
use WithZoey\Trengo\Trengo;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Response;

class QuickReplyTest extends TestCase
{
    /** @var ClientInterface */
    private $guzzleClient;

    /** @var trengo */
    private $trengo;

    /**
     * @var QuickReply
     */
    private $quickReply;

    protected function setUp(): void
    {
        parent::setUp();
        $this->guzzleClient = $this->createMock(Client::class);
        $this->trengo = new Trengo($this->guzzleClient);
        $this->quickReply = new QuickReply($this->trengo);

        $this->trengo->setApiKey('test_api_key');
    }

    /**
     * @throws GuzzleException
     * @throws MissingApiKeyException
     * @throws ApiException
     */
    public function testGetQuickReplyList()
    {
        $responseBody = '{
            "data": [
                {
                  "id": 4129,
                  "title": "Bedankt voor reactie SOPHIE",
                  "message": "Bedankt voor het doorgeven! Ik ga voor u aan de slag en u hoort snel weer van mij. Fijne dag! Groetjes, Sophie",
                  "type": "MESSAGING",
                  "attachments": []
                },
                {
                  "id": 4114,
                  "title": "Boekingsnummer opvragen SOPHIE",
                  "message": "Goedendag! Heeft u aanvullend ook uw boekingsnummer voor mij? Dan kan ik voor u aan de slag! Alvast bedankt. Groetjes, Sophie",
                  "type": "MESSAGING",
                  "attachments": []
                }
            ],
            "links": {
                "first": "https://app.trengo.com/api/v2/quick_replies?page=1",
                "last": "https://app.trengo.com/api/v2/quick_replies?page=1",
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
                        "url": "https://app.trengo.com/api/v2/quick_replies?page=1",
                        "label": "1",
                        "active": true
                    },
                    {
                        "url": null,
                        "label": "pagination.next",
                        "active": false
                    }
                ],
                "path": "https://app.trengo.com/api/v2/quick_replies",
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

        $response = $this->quickReply->list();

        $this->assertEquals(
            json_decode($responseBody, true),
            $response
        );
    }

    /**
     * @throws ApiException
     * @throws GuzzleException
     * @throws MissingApiKeyException
     */
    public function testCreateQuickReply()
    {
        $responseBody = '{
          "id": 567488,
          "title": "title",
          "message": "message",
          "type": "MESSAGING"
        }';
        $response = new Response(200, [], $responseBody);

        $this->guzzleClient
            ->expects($this->once())
            ->method('request')
            ->willReturn($response);

        $response = $this->quickReply->create('title', 'message', 'SMS');

        $this->assertEquals(
            json_decode($responseBody, true),
            $response
        );
    }

    /**
     * @throws ApiException
     * @throws GuzzleException
     * @throws MissingApiKeyException
     */
    public function testCreateQuickReplyFail()
    {
        $this->expectErrorMessage('Too few arguments to function WithZoey\Trengo\Resources\QuickReply::create(), 1 passed in ');
        $this->quickReply->create('');
    }

    /**
     * @throws ApiException
     * @throws GuzzleException
     * @throws MissingApiKeyException
     */
    public function testUpdateQuickReply()
    {
        $response = new Response(200, [], '');

        $this->guzzleClient
            ->expects($this->once())
            ->method('request')
            ->willReturn($response);

        $response = $this->quickReply->update(4129, 'title', 'message', 'SMS');

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
    public function testUpdateQuickReplyFail()
    {
        $this->expectErrorMessage('Argument 1 passed to WithZoey\Trengo\Resources\QuickReply::update() must be of the type int, string given, called in ');
        $this->quickReply->update('');
    }

    /**
     * @throws ApiException
     * @throws GuzzleException
     * @throws MissingApiKeyException
     */
    public function testDeleteQuickReply()
    {
        $response = new Response(200, [], '');

        $this->guzzleClient
            ->expects($this->once())
            ->method('request')
            ->willReturn($response);

        $response = $this->quickReply->delete(4129);

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
    public function testDeleteQuickReplyFail()
    {
        $this->expectErrorMessage('Argument 1 passed to WithZoey\Trengo\Resources\QuickReply::delete() must be of the type int, string given, called in ');
        $this->quickReply->delete('test');
    }
}

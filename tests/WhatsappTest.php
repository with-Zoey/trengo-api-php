<?php

namespace Tests;

use WithZoey\Trengo\Exceptions\ApiException;
use WithZoey\Trengo\Exceptions\MissingApiKeyException;
use WithZoey\Trengo\Resources\Whatsapp;
use WithZoey\Trengo\Trengo;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Response;

class WhatsappTest extends TestCase
{
    /** @var ClientInterface */
    private $guzzleClient;

    /** @var trengo */
    private $trengo;

    /**
     * @var Whatsapp
     */
    private $whatsapp;

    protected function setUp(): void
    {
        parent::setUp();
        $this->guzzleClient = $this->createMock(Client::class);
        $this->trengo = new Trengo($this->guzzleClient);
        $this->whatsapp = new Whatsapp($this->trengo);

        $this->trengo->setApiKey('test_api_key');
    }

    /**
     * @throws GuzzleException
     * @throws MissingApiKeyException
     * @throws ApiException
     */
    public function testStartConversation()
    {
        $responseBody = '{
          "message": {
            "ticket_id": 250163550,
            "contact_id": 166671205,
            "agency_id": 1249,
            "user_id": 3610,
            "message": "Hi, hopelijk gaat alles goed! \nHello World",
            "type": "OUTBOUND",
            "token": "b5jbtYec80",
            "body_type": "TEXT",
            "read": true,
            "updated_at": "2021-12-14 16:09:07",
            "created_at": "2021-12-14 16:09:07",
            "id": 1097415155,
            "message_class": "alert-success pull-right",
            "email_message_class": "email_outbound",
            "created_at_time": 1639494547,
            "created_at_time_day": 1639436400,
            "ticket": {
              "id": 250163550,
              "agency_id": 1249,
              "channel_id": 650788,
              "user_id": 3610,
              "team_id": null,
              "contact_id": 166671205,
              "assigned_by": 3610,
              "closed_by": null,
              "latest_message": "2021-12-14 14:24:54",
              "guid": null,
              "telegram_chat_id": null,
              "status": "ASSIGNED",
              "subject": null,
              "closed_at": null,
              "assigned_at": "2021-12-14 14:24:31",
              "contact_cc": null,
              "custom_data": null,
              "created_at": "2021-12-14T13:24:31.000000Z",
              "updated_at": "2021-12-14T15:09:07.000000Z",
              "deleted_at": null
            }
          }
        }';
        $response = new Response(200, [], $responseBody);

        $this->guzzleClient
            ->expects($this->once())
            ->method('request')
            ->willReturn($response);

        $response = $this->whatsapp->startConversation('123', 1);

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
    public function testStartConversationFail()
    {
        $this->expectErrorMessage('Too few arguments to function WithZoey\Trengo\Resources\Whatsapp::startConversation(), 0 passed in ');
        $this->whatsapp->startConversation();
    }
}

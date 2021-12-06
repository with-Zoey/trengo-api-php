<?php

namespace Tests;

use WithZoey\Trengo\Exceptions\ApiException;
use WithZoey\Trengo\Exceptions\MissingApiKeyException;
use WithZoey\Trengo\Resources\Ticket;
use WithZoey\Trengo\Trengo;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Response;

class TicketTest extends TestCase
{
    /** @var ClientInterface */
    private $guzzleClient;

    /** @var trengo */
    private $trengo;

    /**
     * @var Ticket
     */
    private $ticket;

    protected function setUp(): void
    {
        parent::setUp();
        $this->guzzleClient = $this->createMock(Client::class);
        $this->trengo = new Trengo($this->guzzleClient);
        $this->ticket = new Ticket($this->trengo);

        $this->trengo->setApiKey('test_api_key');
    }

    /**
     * @throws GuzzleException
     * @throws MissingApiKeyException
     * @throws ApiException
     */
    public function testGetTicketList()
    {
        $responseBody = '{
        "data": [
            {
              "id": 245404208,
              "status": "ASSIGNED",
              "subject": null,
              "closed_at": null,
              "created_at": "2021-12-06 12:09:14",
              "updated_at": "2021-12-06 12:09:45",
              "user_id": 3610,
              "team_id": null,
              "assigned_at": "2021-12-06 12:09:26",
              "contact_id": 163968078,
              "contact": {
                "id": 163968078,
                "name": "441134678552",
                "full_name": "441134678552",
                "email": null,
                "abbr": "4",
                "color": "#f44336",
                "profile_image": null,
                "is_phone": true,
                "phone": "441134678552",
                "formatted_phone": "+44 113 467 8552",
                "avatar": "https://app.trengo.com/img/defaultpic.png",
                "identifier": "+44 113 467 8552",
                "custom_field_data": null,
                "profile": [],
                "pivot": null,
                "formatted_custom_field_data": {
                  "Achternaam": null,
                  "Klantnummer": null,
                  "Voorkeuren": null,
                  "Voornaam": null
                },
                "display_name": "441134678552 (+44 113 467 8552)",
                "is_private": false
              },
              "channel": {
                "id": 650578,
                "name": null,
                "title": "Voip",
                "phone": null,
                "type": "VOIP",
                "auto_reply": null,
                "color": "#000000",
                "notification_email": null,
                "business_hour_id": null,
                "notification_sound": null,
                "status": null,
                "display_name": "Voip ()",
                "text": "Voip ()",
                "show_ticket_fields": null,
                "show_contact_fields": null,
                "users": [],
                "username": null,
                "password_is_null": false,
                "reopen_closed_ticket": null,
                "is_private": false,
                "reassign_reopened_ticket": false,
                "reopen_closed_ticket_time_window_days": "0",
                "password": null
              },
              "channelMeta": null,
              "latest_message": {
                "id": 1074356288,
                "type": "INBOUND",
                "message": "Inbound call",
                "created_at": "2021-12-06 12:09:45",
                "attachments": []
              },
              "labels": [],
              "custom_data": null,
              "messages_count": 1
            }
          ],
          "links": {
            "first": "https://app.trengo.com/api/v2/tickets?page=1",
            "last": null,
            "prev": null,
            "next": "https://app.trengo.com/api/v2/tickets?page=2"
          },
          "meta": {
            "current_page": 1,
            "from": 1,
            "path": "https://app.trengo.com/api/v2/tickets",
            "per_page": 25,
            "to": 25
          }
        }';
        $response = new Response(200, [], $responseBody);

        $this->guzzleClient
            ->expects($this->once())
            ->method('request')
            ->willReturn($response);

        $response = $this->ticket->list();

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
    public function testFetchMessageTicket()
    {
        $responseBody = '{
          "id": 1074356288,
          "ticket_id": 245404208,
          "type": "INBOUND",
          "body_type": "CALL_LOG",
          "message": "Inbound call",
          "file_name": "https://api.twilio.com/2010-04-01/Accounts/AC3f84d59206412725a03114dfb5163e33/Recordings/RE960d18e24cdb8a6190789875cbe009a1",
          "file_caption": null,
          "location_data": {
            "duration": 14
          },
          "created_at": "2021-12-06 12:09:45",
          "updated_at": "2021-12-06 12:50:17",
          "user_id": 3610,
          "contact": {
            "id": 163968078,
            "name": "441134678552",
            "full_name": "441134678552",
            "email": null,
            "abbr": "4",
            "color": "#f44336",
            "profile_image": null,
            "is_phone": true,
            "phone": "441134678552",
            "formatted_phone": "+44 113 467 8552",
            "avatar": "https://app.trengo.com/img/defaultpic.png",
            "identifier": "+44 113 467 8552",
            "custom_field_data": null,
            "pivot": null,
            "formatted_custom_field_data": {
              "Achternaam": null,
              "Klantnummer": null,
              "Voorkeuren": null,
              "Voornaam": null
            },
            "display_name": "441134678552 (+44 113 467 8552)",
            "is_private": false
          },
          "agent": {
            "id": 3610,
            "agency_id": 1249,
            "first_name": "Rajneesh",
            "last_name": "Badal",
            "name": "Rajneesh Badal",
            "full_name": "Rajneesh Badal",
            "email": "rajneesh@travelwithzoey.com",
            "abbr": "R",
            "phone": null,
            "color": "#009688",
            "locale_code": "nl-NL",
            "status": "ACTIVE",
            "text": "Rajneesh Badal",
            "is_online": 0,
            "user_status": "ONLINE",
            "chat_status": true,
            "voip_status": "ONLINE",
            "voip_device": "WEB",
            "profile_image": null,
            "authorization": "OWNER",
            "is_primary": 1,
            "timezone": "Europe/Amsterdam",
            "created_at": "2017-07-16 09:34:35",
            "two_factor_authentication_enabled": false
          },
          "attachments": [],
          "mentions": [],
          "contacts": [],
          "meta": null,
          "parent": null,
          "reactionSums": [],
          "diff_in_hours": 1,
          "messageEvents": [],
          "is_auto_reply": null
        }';
        $response = new Response(200, [], $responseBody);

        $this->guzzleClient
            ->expects($this->once())
            ->method('request')
            ->willReturn($response);

        $response = $this->ticket->fetchMessage(245404208, 1074356288);

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
    public function testFetchMessageTicketFail()
    {
        $this->expectErrorMessage('Argument 1 passed to WithZoey\Trengo\Resources\Ticket::fetchMessage() must be of the type int, string given, called in ');
        $this->ticket->fetchMessage('', 1074356288);
    }

    /**
     * @throws ApiException
     * @throws GuzzleException
     * @throws MissingApiKeyException
     */
    public function testCreateTicket()
    {
        $responseBody = '{
          "agency_id": 1249,
          "contact_id": 163968078,
          "status": "ASSIGNED",
          "user_id": 3610,
          "assigned_at": "2021-12-06T13:02:53.680017Z",
          "assigned_by": 3610,
          "channel_id": 650578,
          "subject": null,
          "updated_at": "2021-12-06T13:02:53.000000Z",
          "created_at": "2021-12-06T13:02:53.000000Z",
          "id": 245508948,
          "latest_message": "2021-12-06T13:02:53.000000Z",
          "channel": {
            "id": 650578,
            "phone": "31850004119",
            "name": null,
            "title": "Voip",
            "username": null,
            "password": null,
            "status_update": null,
            "status": "ACTIVE",
            "type": "VOIP",
            "business_hour_id": 16675,
            "is_wa_connector": 0,
            "logo_path": null,
            "account_type": null,
            "last_login_at": null,
            "last_activity_at": null,
            "expires_at": null,
            "telegram_last_update_id": null,
            "notification_email": null,
            "is_running": 0,
            "agency_id": 1249,
            "auto_reply": "ENABLED",
            "wa_server_id": null,
            "connection_error_notification_email": null,
            "price": "15.00",
            "color": "#000000",
            "show_ticket_fields": 1,
            "show_contact_fields": 1,
            "can_be_deleted_at": "2022-01-06 09:32:06",
            "requested_by": null,
            "reopen_closed_ticket": 0,
            "deleted_at": null,
            "created_at": "2021-12-06T08:32:06.000000Z",
            "updated_at": "2021-12-06T10:32:25.000000Z",
            "notification_sound": "chat.mp3",
            "formatted_phone": "085 000 4119",
            "password_is_null": false,
            "reassign_reopened_ticket": false,
            "reopen_closed_ticket_time_window_days": "0",
            "users": [],
            "agency": {
              "id": 1249,
              "name": "Travel with Zoey",
              "slug": "travel-with-zoey",
              "status": "ACTIVE",
              "trial_ends_at": null,
              "channel_prefix": "ewUfHDzotpW66gf0eo2d29CPmeNajNHRFZ1aT04DCakYt7B15pOBCu2E9OtUAunhddURYZMz0DY4ktpXeuEKPxeVZ0Kxc68Dh98AqIJLf8mgYuDYvQ9rVoEwAl4t8",
              "plan": null,
              "subscription_started_at": null,
              "moneybird_is_synced": 1,
              "moneybird_contact_id": null,
              "is_white_labelled": 0,
              "agency_parent_id": null,
              "price_package_a": "25.00",
              "price_package_b": "65.00",
              "price_package_c": "145.00",
              "locale_code": "nl-NL",
              "has_session_limit": 1,
              "enable_whatsapp": 1,
              "enable_bulk_sms": 1,
              "enable_invoicing": 0,
              "add_wa_contacts": 0,
              "deleted_at": null,
              "created_at": "2017-07-16T07:34:35.000000Z",
              "updated_at": "2021-11-30T12:38:29.000000Z",
              "pricing": {
                "A": "25.00",
                "B": "65.00",
                "C": "145.00"
              }
            }
          }
        }';
        $response = new Response(200, [], $responseBody);

        $this->guzzleClient
            ->expects($this->once())
            ->method('request')
            ->willReturn($response);

        $response = $this->ticket->create(650578, 163968078);

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
    public function testCreateTicketFail()
    {
        $this->expectErrorMessage('Argument 1 passed to WithZoey\Trengo\Resources\Ticket::create() must be of the type int, string given, called in ');
        $this->ticket->create('', '');
    }
}

<?php

namespace Tests;

use WithZoey\Trengo\Exceptions\ApiException;
use WithZoey\Trengo\Exceptions\MissingApiKeyException;
use WithZoey\Trengo\Resources\Contact;
use WithZoey\Trengo\Trengo;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Response;

class ContactTest extends TestCase
{
    /** @var ClientInterface */
    private $guzzleClient;

    /** @var trengo */
    private $trengo;

    /**
     * @var Contact
     */
    private $contact;

    protected function setUp(): void
    {
        parent::setUp();
        $this->guzzleClient = $this->createMock(Client::class);
        $this->trengo = new Trengo($this->guzzleClient);
        $this->contact = new Contact($this->trengo);

        $this->trengo->setApiKey('test_api_key');
    }

    /**
     * @throws GuzzleException
     * @throws MissingApiKeyException
     * @throws ApiException
     */
    public function testGetContactList()
    {
        $responseBody = '{
          "data": [
            {
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
              "channels": [
                {
                  "id": 650578,
                  "name": null,
                  "title": "Voip",
                  "phone": "31850004119",
                  "type": "VOIP",
                  "auto_reply": "ENABLED",
                  "color": "#000000",
                  "notification_email": null,
                  "business_hour_id": 16675,
                  "notification_sound": "chat.mp3",
                  "status": "ACTIVE",
                  "display_name": "Voip (31850004119)",
                  "text": "Voip (31850004119)",
                  "show_ticket_fields": 1,
                  "show_contact_fields": 1,
                  "emailChannel": null,
                  "users": [],
                  "username": null,
                  "password_is_null": false,
                  "reopen_closed_ticket": 0,
                  "is_private": false,
                  "reassign_reopened_ticket": false,
                  "reopen_closed_ticket_time_window_days": 0,
                  "password": null
                }
              ],
              "pivot": null,
              "formatted_custom_field_data": {
                "Achternaam": null,
                "Klantnummer": null,
                "Voorkeuren": null,
                "Voornaam": null
              },
              "display_name": "441134678552 (+44 113 467 8552)",
              "is_private": false
            }
          ],
          "links": {
            "first": "https://app.trengo.com/api/v2/contacts?page=1",
            "last": null,
            "prev": null,
            "next": "https://app.trengo.com/api/v2/contacts?page=2"
          },
          "meta": {
            "current_page": 1,
            "from": 1,
            "path": "https://app.trengo.com/api/v2/contacts",
            "per_page": 25,
            "to": 25
          }
        }';
        $response = new Response(200, [], $responseBody);

        $this->guzzleClient
            ->expects($this->once())
            ->method('request')
            ->willReturn($response);

        $response = $this->contact->list();

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
    public function testViewContact()
    {
        $responseBody = '{
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
          "channels": [
            {
              "id": 650578,
              "name": null,
              "title": "Voip",
              "phone": "31850004119",
              "type": "VOIP",
              "auto_reply": "ENABLED",
              "color": "#000000",
              "notification_email": null,
              "business_hour_id": 16675,
              "notification_sound": "chat.mp3",
              "status": "ACTIVE",
              "display_name": "Voip (31850004119)",
              "text": "Voip (31850004119)",
              "show_ticket_fields": 1,
              "show_contact_fields": 1,
              "users": [],
              "username": null,
              "password_is_null": false,
              "reopen_closed_ticket": 0,
              "is_private": false,
              "reassign_reopened_ticket": false,
              "reopen_closed_ticket_time_window_days": "0",
              "password": null
            }
          ],
          "pivot": null,
          "notes": [],
          "groups": [],
          "formatted_custom_field_data": {
            "Achternaam": null,
            "Klantnummer": null,
            "Voorkeuren": null,
            "Voornaam": null
          },
          "display_name": "441134678552 (+44 113 467 8552)",
          "is_private": false
        }';
        $response = new Response(200, [], $responseBody);

        $this->guzzleClient
            ->expects($this->once())
            ->method('request')
            ->willReturn($response);

        $response = $this->contact->view(163968078);

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
    public function testGetContactFail()
    {
        $this->expectErrorMessage('Argument 1 passed to WithZoey\Trengo\Resources\Contact::view() must be of the type int, string given, called in ');
        $this->contact->view('test');
    }

    /**
     * @throws ApiException
     * @throws GuzzleException
     * @throws MissingApiKeyException
     */
    public function testCreateContact()
    {
        $responseBody = '{
          "id": 164295777,
          "name": null,
          "full_name": null,
          "email": null,
          "abbr": "+",
          "color": "#ff9800",
          "profile_image": null,
          "is_phone": true,
          "phone": "+09912234567",
          "formatted_phone": "++09912234567",
          "avatar": "https://app.trengo.com/img/defaultpic.png",
          "identifier": "++09912234567",
          "custom_field_data": null,
          "pivot": null,
          "formatted_custom_field_data": {
            "Achternaam": null,
            "Klantnummer": null,
            "Voorkeuren": null,
            "Voornaam": null
          },
          "display_name": " (++09912234567)",
          "is_private": false
        }';
        $response = new Response(200, [], $responseBody);

        $this->guzzleClient
            ->expects($this->once())
            ->method('request')
            ->willReturn($response);

        $response = $this->contact->create(650578, '09912234567');

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
    public function testCreateContactFail()
    {
        $this->expectErrorMessage('Too few arguments to function WithZoey\Trengo\Resources\Contact::create(), 0 passed in ');
        $this->contact->create();
    }

    /**
     * @throws ApiException
     * @throws GuzzleException
     * @throws MissingApiKeyException
     */
    public function testUpdateContact()
    {
        $responseBody = '{
          "id": 164295777,
          "name": "test",
          "full_name": "test",
          "email": null,
          "abbr": "t",
          "color": "#ff9800",
          "profile_image": null,
          "is_phone": true,
          "phone": "+09912234567",
          "formatted_phone": "++09912234567",
          "avatar": "https://app.trengo.com/img/defaultpic.png",
          "identifier": "++09912234567",
          "custom_field_data": null,
          "profile": [],
          "channels": [
            {
              "id": 650578,
              "name": null,
              "title": "Voip",
              "phone": "31850004119",
              "type": "VOIP",
              "auto_reply": "ENABLED",
              "color": "#000000",
              "notification_email": null,
              "business_hour_id": 16675,
              "notification_sound": "chat.mp3",
              "status": "ACTIVE",
              "display_name": "Voip (31850004119)",
              "text": "Voip (31850004119)",
              "show_ticket_fields": 1,
              "show_contact_fields": 1,
              "users": [],
              "username": null,
              "password_is_null": false,
              "reopen_closed_ticket": 0,
              "is_private": false,
              "reassign_reopened_ticket": false,
              "reopen_closed_ticket_time_window_days": "0",
              "password": null
            }
          ],
          "pivot": null,
          "notes": [],
          "groups": [],
          "formatted_custom_field_data": {
            "Achternaam": null,
            "Klantnummer": null,
            "Voorkeuren": null,
            "Voornaam": null
          },
          "display_name": "test (++09912234567)",
          "is_private": false
        }';
        $response = new Response(200, [], $responseBody);

        $this->guzzleClient
            ->expects($this->once())
            ->method('request')
            ->willReturn($response);

        $response = $this->contact->update(164295777, 'test');

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
    public function testDeleteContact()
    {
        $response = new Response(200, [], '');

        $this->guzzleClient
            ->expects($this->once())
            ->method('request')
            ->willReturn($response);

        $response = $this->contact->delete(172118);

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
    public function testDeleteContactFail()
    {
        $this->expectErrorMessage('Argument 1 passed to WithZoey\Trengo\Resources\Contact::delete() must be of the type int, string given, called in ');
        $this->contact->delete('test');
    }
}

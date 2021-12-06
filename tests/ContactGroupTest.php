<?php

namespace Tests;

use WithZoey\Trengo\Exceptions\ApiException;
use WithZoey\Trengo\Exceptions\MissingApiKeyException;
use WithZoey\Trengo\Resources\ContactGroup;
use WithZoey\Trengo\Trengo;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Response;

class ContactGroupTest extends TestCase
{
    /** @var ClientInterface */
    private $guzzleClient;

    /** @var trengo */
    private $trengo;

    /**
     * @var ContactGroup
     */
    private $contactGroup;

    protected function setUp(): void
    {
        parent::setUp();
        $this->guzzleClient = $this->createMock(Client::class);
        $this->trengo = new Trengo($this->guzzleClient);
        $this->contactGroup = new ContactGroup($this->trengo);

        $this->trengo->setApiKey('test_api_key');
    }

    /**
     * @throws GuzzleException
     * @throws MissingApiKeyException
     * @throws ApiException
     */
    public function testGetContactGroupList()
    {
        $responseBody = '{
          "data": [
            {
                "id": 172113,
                "name": "test"
            }
          ],
          "links": {
                "first": "https://app.trengo.com/api/v2/contact_groups?page=1",
                "last": "https://app.trengo.com/api/v2/contact_groups?page=1",
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
                    "url": "https://app.trengo.com/api/v2/contact_groups?page=1",
                    "label": "1",
                    "active": true
                },
                {
                    "url": null,
                    "label": "pagination.next",
                    "active": false
                }
            ],
            "path": "https://app.trengo.com/api/v2/contact_groups",
            "per_page": 999,
            "to": 1,
            "total": 1
          }
        }';
        $response = new Response(200, [], $responseBody);

        $this->guzzleClient
            ->expects($this->once())
            ->method('request')
            ->willReturn($response);

        $response = $this->contactGroup->list();

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
    public function testGetContactGroup()
    {
        $responseBody = '{
            "id": 172113,
            "name": "test"
        }';
        $response = new Response(200, [], $responseBody);

        $this->guzzleClient
            ->expects($this->once())
            ->method('request')
            ->willReturn($response);

        $response = $this->contactGroup->get(172113);

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
    public function testGetContactGroupFail()
    {
        $this->expectErrorMessage('Argument 1 passed to WithZoey\Trengo\Resources\ContactGroup::get() must be of the type int, string given, called in ');
        $this->contactGroup->get('test');
    }

    /**
     * @throws ApiException
     * @throws GuzzleException
     * @throws MissingApiKeyException
     */
    public function testCreateContactGroup()
    {
        $responseBody = '{
            "id": 172118,
            "name": "test"
        }';
        $response = new Response(200, [], $responseBody);

        $this->guzzleClient
            ->expects($this->once())
            ->method('request')
            ->willReturn($response);

        $response = $this->contactGroup->create('test');

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
    public function testCreateContactGroupFail()
    {
        $this->expectErrorMessage('Too few arguments to function WithZoey\Trengo\Resources\ContactGroup::create(), 0 passed in ');
        $this->contactGroup->create();
    }

    /**
     * @throws ApiException
     * @throws GuzzleException
     * @throws MissingApiKeyException
     */
    public function testUpdateContactGroup()
    {
        $response = new Response(200, [], '');

        $this->guzzleClient
            ->expects($this->once())
            ->method('request')
            ->willReturn($response);

        $response = $this->contactGroup->update(172118, 'test_updated');

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
    public function testDeleteContactGroup()
    {
        $response = new Response(200, [], '');

        $this->guzzleClient
            ->expects($this->once())
            ->method('request')
            ->willReturn($response);

        $response = $this->contactGroup->delete(172118);

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
    public function testDeleteContactGroupFail()
    {
        $this->expectErrorMessage('Argument 1 passed to WithZoey\Trengo\Resources\ContactGroup::delete() must be of the type int, string given, called in ');
        $this->contactGroup->delete('test');
    }
}

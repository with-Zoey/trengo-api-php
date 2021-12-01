<?php

namespace Tests\Resources;

use WithZoey\Trengo\Trengo;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Tests\TestCase;

abstract class BaseResourceTest extends TestCase
{
    /**
     * @var Client
     */
    protected $guzzleClient;

    /**
     * @var Trengo
     */
    protected $Trengo;

    protected function mockApiCall(Request $expectedRequest, Response $response)
    {
        $this->guzzleClient = $this->createMock(Client::class);

        $this->Trengo = new Trengo($this->guzzleClient);
        $this->Trengo->setApiKey('test_key');

        $this->guzzleClient
            ->expects($this->once())
            ->method('send')
            ->with($this->isInstanceOf(Request::class))
            ->willReturnCallback(function (Request $request) use ($expectedRequest, $response) {
                $this->assertEquals($expectedRequest->getMethod(), $request->getMethod(), 'HTTP method must be identical');

                $requestBody = $request->getBody()->getContents();
                $expectedBody = $expectedRequest->getBody()->getContents();

                if (strlen($expectedBody) > 0 && strlen($requestBody) > 0) {
                    $this->assertJsonStringEqualsJsonString(
                        $expectedBody,
                        $requestBody,
                        'HTTP body must be identical'
                    );
                }

                return $response;
            });
    }
}

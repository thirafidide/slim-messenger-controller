<?php

class ControllerTest extends PHPUnit_Framework_TestCase
{
    public $appTokenMock = 'not_so_secret_token';
    public $verifyTokenMock = 'not_so_verify_token';
    public $unacceptedMethods = [
        'PUT',
        'DELETE',
        'HEAD',
        'PATCH',
        'OPTIONS'
    ];
    public $acceptedMethods = [
        'GET',
        'POST'
    ];

    public function __construct() {
        $this->controller = new SlimMessenger\Controller($this->verifyTokenMock, $this->appTokenMock);
    }

    public function testCanVerifyWebhook()
    {
        // Arrange
        $challangeMock = 'only_a_mock';

        $query = array(
            'hub_verify_token' => $this->verifyTokenMock,
            'hub_challenge' => $challangeMock
        );
        $request = HTTPMockFactory::mockRequest('GET', $query);
        $response = HTTPMockFactory::mockResponse();

        // Act
        $verifyResponse = $this->controller->__invoke($request, $response);

        // Assert
        $this->assertEquals($verifyResponse->getBody()->__toString(), $challangeMock);
    }

    public function testAlwaysReturn200IfMethodAccepted()
    {
        foreach ($this->acceptedMethods as $method) {
            $request = HTTPMockFactory::mockRequest($method);
            $response = HTTPMockFactory::mockResponse();

            $notFoundResponse = $this->controller->__invoke($request, $response);

            $this->assertEquals(200, $notFoundResponse->getStatusCode());
        }
    }

    public function testAlwaysReturn404IfMethodUnaccepted()
    {
        foreach ($this->unacceptedMethods as $method) {
            $request = HTTPMockFactory::mockRequest($method);
            $response = HTTPMockFactory::mockResponse();

            $notFoundResponse = $this->controller->__invoke($request, $response);

            $this->assertEquals(404, $notFoundResponse->getStatusCode());
        }
    }
}
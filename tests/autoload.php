<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Slim\Http\Collection;
use Slim\Http\Environment;
use Slim\Http\Headers;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\RequestBody;
use Slim\Http\UploadedFile;
use Slim\Http\Uri;

class HTTPMockFactory
{
    public static function mockRequest($method = 'GET', $query = [])
    {
        $env = Environment::mock();

        $queryString = http_build_query($query);
        $uri = Uri::createFromString('https://example.com/foo/bar?'. $queryString);
        $headers = Headers::createFromEnvironment($env);
        $cookies = [];
        $serverParams = $env->all();
        $body = new RequestBody();
        $request = new Request($method, $uri, $headers, $cookies, $serverParams, $body);

        return $request;
    }

    public static function mockResponse($statusCode = 200)
    {
        return new Response($statusCode);
    }
}
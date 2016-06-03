<?php

namespace SlimMessenger;

use Evenement\EventEmitter;

class Controller extends EventEmitter
{
    public function __construct($verifyToken, $appToken)
    {
        $this->verifyToken = $verifyToken;
        $this->appToken = $appToken;
    }

    public function verifyWebhook($request, $response)
    {
        $query = $request->getQueryParams();
        $body = $response->getBody();

        if (isset($query['hub_verify_token']) && 
            isset($query['hub_challenge']) && 
            $query['hub_verify_token'] === $this->verifyToken) 
        {
            $body->write($query['hub_challenge']);
        } else {
            $body->write('invalid requesto');
        }
        return $response->withBody($body);
    }

    public function responseEvent($request, $response)
    {
        $parsedBody = $request->getParsedBody();

        if (!isset($parsedBody['entry'][0]['messaging']))
        {
            return $response->withStatus(200);
        }
        
        $messaging_events = $parsedBody['entry'][0]['messaging'];

        foreach ($messaging_events as $event) {
            $senderId = $event['sender']['id'];

            if (isset($event['message']['text'])) 
            {
                $this->emit('message', [$senderId, $event['message']['text'], $event['timestamp']]);
            }

            if (isset($event['message']['attachment'])) {
                $this->emit('attachment', [$senderId, $event['attachment'], $event['timestamp']]);
            }

            if (isset($event['postback']['payload'])) {
                $this->emit('postback', [$senderId, $event['postback']['payload'], $event['timestamp']]);
            }
        }

        return $response->withStatus(200);
    }

    public function __invoke($request, $response)
    {
        $method = $request->getMethod();
        switch ($method) {
            case 'GET':
                return $this->verifyWebhook($request, $response);
                break;
            
            case 'POST':
                return $this->responseEvent($request, $response);
                break;

            default:
                return $response->withStatus(404);
        }
    }
}
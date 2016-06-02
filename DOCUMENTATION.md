# Documentation

## Construct
```php
$messengerBot = new SlimMessenger\Controller($verifyToken, $appToken);
```

## Verify Webhook
When receive `GET` request, Slim Messenger Controller will automatically assume that it is request send by facebook
to verify webhook and will react accordingly.

## Events
Slim Messenger Controller class extends [Evenement EventEmitter](https://github.com/igorw/evenement) to manage 
events and it's callbacks
```php
// receive message
$messengerBot->on('message', function($senderId, $messageText, $timestamp) { ... });

// receive attachment (image, video, ...)
$messengerBot->on('attachment', function($senderId, $attachmentObject, $timestamp) { ... });

// receive postback like when user click button from card that bot send
$messengerBot->on('postback', function($senderId, $postbackPayload, $timestamp) { ... });
```

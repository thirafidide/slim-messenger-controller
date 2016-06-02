Slim Messenger Controller
===============================
[![Build Status](https://travis-ci.org/iamn00b/slim-messenger-controller.svg?branch=master-dev)](https://travis-ci.org/iamn00b/slim-messenger-controller)
Easily set up your SlimPHP Routes to integrate with Facebook's Messenger Bot API. Slim Messenger Controller intended
to be a RESTful Controller to be used by SlimPHP routes, and easily set up to be injected at SlimPHP Container. While
this is created for SlimPHP, Slim Messenger Controller can be used as controller at any framework that implement PSR7 
interfaces for its Request and Response objects

## Installation
```bash
composer install slim-messenger/controller
```

## Usage
```php
$appToken = 'YOUR_APP_TOKEN';
$verifyToken = 'YOUR_VERIFY_TOKEN';

// initiate controller
$messengerController = new SlimMessenger\Controller($verifyToken, $appToken);

//slim routes
$app->any('/webhook[/]', $messengerController);
```

You can also inject it to SlimPHP Container
```php
$container = $app->getContainer();

$container['bot'] = function($c) {
    $appToken = 'YOUR_APP_TOKEN';
    $verifyToken = 'YOUR_VERIFY_TOKEN';

    $messangerBot = new SlimMessengerController($verifyToken, $appToken);

    return $messangerBot;
};

//slim routes
$app->any('/webhook[/]', $container['bot']);
```

## Documentation
see [DOCUMENTATION](https://raw.githubusercontent.com/iamn00b/slim-messenger-controller/master/DOCUMENTATION.md)
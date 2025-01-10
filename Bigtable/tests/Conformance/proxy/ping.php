<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use Google\Bigtable\Testproxy\CreateClientRequest;

$client = new \ProxyClient('127.0.0.1:9999', [
    'credentials' => \Grpc\ChannelCredentials::createInsecure(),
]);

$message = new CreateClientRequest();

[$response, $status] = $client->CreateClient($message)->wait();

echo $response->serializeToJsonString() . PHP_EOL;

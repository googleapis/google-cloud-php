<?php

/**
 * Sample GRPC PHP server.
 */

use Google\Bigtable\Testproxy\CloudBigtableV2TestProxyInterface;
use Spiral\RoadRunner\GRPC\Invoker;
use Spiral\RoadRunner\GRPC\Server;
use Spiral\RoadRunner\Worker;

require __DIR__ . '/vendor/autoload.php';

$server = new Server(new Invoker(), [
    'debug' => true, // optional (default: false)
]);

$server->registerService(CloudBigtableV2TestProxyInterface::class, new ProxyService());

$server->serve(Worker::create());

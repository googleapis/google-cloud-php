<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\JsonResponse;

$app = new Silex\Application();

$app->get('/', function() {
    return 'Silex version ' . Silex\Application::VERSION;
});

$app->get('/hello/{name}', function ($name) use ($app) {
    return 'Hello, ' . $name;
});

$app->get('/debuggee', function () use ($app, $agent) {
    $storage = new Google\Cloud\Debugger\BreakpointStorage\SysvBreakpointStorage();
    list($debuggeeId, $breakpoints) = $storage->load();
    return $app->json([
        'debuggeeId' => $debuggeeId,
        'numBreakpoints' => count($breakpoints)
    ], 200, ['Content-Type' => 'application/json']);
});

$app->get('/env', function() use ($app) {
    return $app->json($_SERVER, 200, ['Content-Type' => 'application/json']);
});

$app->get('/metadata/{key}', function($key) use ($app) {
    $uri = 'http://metadata.google.internal/computeMetadata/v1/' . $key;

    $client = new \GuzzleHttp\Client();
    $resp = $client->get($uri, [
        'headers' => [
            'Metadata-Flavor' => 'Google'
        ],
        'query' => [
            'recursive' => 'true'
        ]
    ]);
    $response = new JsonResponse($resp->getBody(), 200, [], true);
    return $response;
})->value('key', '');

$app->run();

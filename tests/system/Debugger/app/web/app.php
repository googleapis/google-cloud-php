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

$app->run();

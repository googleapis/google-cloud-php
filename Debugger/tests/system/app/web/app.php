<?php
/**
 * Copyright 2018 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

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

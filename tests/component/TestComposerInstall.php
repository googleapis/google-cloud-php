<?php

/**
 * Copyright 2017 Google Inc.
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

/**
 * This file tests that all google-cloud-php components can be installed alongside
 * each other at their latest versions.
 */

use Google\Cloud\Dev\GetComponentsTrait;

if (!extension_loaded('grpc')) {
    echo "gRPC Not Installed.";
    exit(0);
}

include __DIR__ .'/../../vendor/autoload.php';

define('BASE_PATH', __DIR__ .'/../..');

class GetComponentsImpl
{
    use GetComponentsTrait;

    public function components()
    {
        return $this->getComponents(
            BASE_PATH .'/src',
            BASE_PATH .'/composer.json'
        );
    }
}

$composer = [];
$composer['require'] = [];
$composer['repositories'] = [];
$composer['minimum-stability'] = 'dev';

foreach((new GetComponentsImpl)->components() as $component) {
    if ($component['id'] === 'google-cloud') continue;
    if ($component['id'] === 'cloud-core') continue;

    $composer['require']['google/'. $component['id']] = '*';
    $composer['repositories'][] = [
        'type' => 'path',
        'url' => BASE_PATH .'/'. $component['path']
    ];
}

file_put_contents(__DIR__ .'/composer.json', json_encode($composer, JSON_UNESCAPED_SLASHES));

$out = [];
$return = null;
exec('composer install --dry-run --working-dir='. __DIR__ .' 2>&1', $out, $return);
unlink(__DIR__ .'/composer.json');

if ($return !== 0) {
    echo "Problem installing components!" . PHP_EOL . PHP_EOL;

    echo implode("\n", $out);
    exit(1);
}

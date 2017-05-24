<?php

/**
 * Copyright 2016 Google Inc.
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

$res = shell_exec('cd '. __DIR__ .' && composer install --dry-run 2>&1');
unlink(__DIR__ .'/composer.json');

if (strpos($res, 'Your requirements could not be resolved to an installable set of packages.') !== false) {
    echo "Problem installing components!" . PHP_EOL . PHP_EOL;

    echo $res;
    exit(1);
}

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

class GetComponentsImpl
{
    use GetComponentsTrait;

    public function components()
    {
        return $this->getComponents(
            __DIR__ .'/../../src',
            __DIR__ .'/../../composer.json'
        );
    }
}

$composer = [];
$composer['require'] = [];

foreach((new GetComponentsImpl)->components() as $component) {
    if ($component['id'] === 'google-cloud') continue;

    $composer['require']['google/'. $component['id']] = '*';
}

file_put_contents(__DIR__ .'/composer.json', json_encode($composer));
$out = [];
$ret = null;
exec('cd '. __DIR__ .' && composer install --dry-run', $out, $ret);
unlink(__DIR__ .'/composer.json');

if ($ret !== 0) {
    echo "Problem installing components!";
    exit(1);
}

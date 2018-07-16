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

namespace Google\Cloud\Bigtable\Tests\System;

use Google\Cloud\Bigtable\BigtableClient;
use PHPUnit\Framework\TestCase;

class BigtableSystemTestCase extends TestCase
{
    private static $hasSetUp = false;

    protected static $client;

    public static function setUpBeforeClass()
    {
        if (self::$hasSetUp) {
            return;
        }

        self::getClient();

        self::$hasSetUp = true;
    }

    private static function getClient()
    {
        if (self::$client) {
            return self::$client;
        }

        $keyFilePath = getenv('GOOGLE_CLOUD_PHP_TESTS_KEY_PATH');
        self::$client = new BigtableClient([
            'keyFilePath' => $keyFilePath
        ]);

        return self::$client;
    }
}

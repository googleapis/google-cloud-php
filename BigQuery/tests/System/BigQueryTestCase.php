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

namespace Google\Cloud\BigQuery\Tests\System;

use Google\Cloud\BigQuery\BigQueryClient;
use Google\Cloud\Storage\StorageClient;
use Google\Cloud\Core\Testing\System\SystemTestCase;

class BigQueryTestCase extends SystemTestCase
{
    const TESTING_PREFIX = 'gcloud_testing_';

    protected static $bucket;
    protected static $client;
    protected static $dataset;
    protected static $table;
    private static $hasSetUp = false;

    public static function setUpBeforeClass()
    {
        if (self::$hasSetUp) {
            return;
        }

        $keyFilePath = getenv('GOOGLE_CLOUD_PHP_TESTS_KEY_PATH');
        $schema = json_decode(file_get_contents(__DIR__ . '/data/table-schema.json'), true);

        $storage = new StorageClient([
            'keyFilePath' => $keyFilePath
        ]);

        self::$bucket = self::createBucket($storage, uniqid(self::TESTING_PREFIX));

        self::$client = new BigQueryClient([
            'keyFilePath' => $keyFilePath
        ]);
        self::$dataset = self::createDataset(self::$client, uniqid(self::TESTING_PREFIX));
        self::$table = self::$dataset->createTable(uniqid(self::TESTING_PREFIX), [
            'schema' => [
                'fields' => $schema
            ]
        ]);

        self::$hasSetUp = true;
    }
}



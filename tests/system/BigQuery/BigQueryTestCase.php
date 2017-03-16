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

namespace Google\Cloud\Tests\System\BigQuery;

use Google\Cloud\BigQuery\BigQueryClient;
use Google\Cloud\Core\ExponentialBackoff;
use Google\Cloud\Storage\StorageClient;

class BigQueryTestCase extends \PHPUnit_Framework_TestCase
{
    const TESTING_PREFIX = 'gcloud_testing_';

    protected static $bucket;
    protected static $client;
    protected static $dataset;
    protected static $deletionQueue = [];
    protected static $table;
    private static $hasSetUp = false;

    public static function setUpBeforeClass()
    {
        if (self::$hasSetUp) {
            return;
        }

        $keyFilePath = getenv('GOOGLE_CLOUD_PHP_TESTS_KEY_PATH');
        $schema = json_decode(file_get_contents(__DIR__ . '/../data/table-schema.json'), true);
        self::$bucket = (new StorageClient([
            'keyFilePath' => $keyFilePath
        ]))->createBucket(uniqid(self::TESTING_PREFIX));
        self::$client = new BigQueryClient([
            'keyFilePath' => $keyFilePath
        ]);
        self::$dataset = self::$client->createDataset(uniqid(self::TESTING_PREFIX));
        self::$table = self::$dataset->createTable(uniqid(self::TESTING_PREFIX), [
            'schema' => [
                'fields' => $schema
            ]
        ]);
        self::$hasSetUp = true;
    }

    public static function tearDownFixtures()
    {
        if (!self::$hasSetUp) {
            return;
        }

        self::$deletionQueue[] = self::$bucket;
        self::$deletionQueue[] = self::$table;
        self::$deletionQueue[] = self::$dataset;

        $backoff = new ExponentialBackoff(8);

        foreach (self::$deletionQueue as $item) {
            $backoff->execute(function () use ($item) {
                $item->delete();
            });
        }
    }
}



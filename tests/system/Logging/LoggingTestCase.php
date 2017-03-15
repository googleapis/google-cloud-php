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

namespace Google\Cloud\Tests\System\Logging;

use Google\Cloud\Core\ExponentialBackoff;
use Google\Cloud\BigQuery\BigQueryClient;
use Google\Cloud\Logging\LoggingClient;
use Google\Cloud\PubSub\PubSubClient;
use Google\Cloud\Storage\StorageClient;

class LoggingTestCase extends \PHPUnit_Framework_TestCase
{
    const TESTING_PREFIX = 'gcloud_testing_';

    protected static $bucket;
    protected static $dataset;
    protected static $deletionQueue = [];
    protected static $grpcClient;
    protected static $restClient;
    protected static $topic;
    private static $hasSetUp = false;

    public function clientProvider()
    {
        self::setUpBeforeClass();

        return [
            [self::$restClient],
            [self::$grpcClient]
        ];
    }

    public static function setUpBeforeClass()
    {
        if (self::$hasSetUp) {
            return;
        }

        $keyFilePath = getenv('GOOGLE_CLOUD_PHP_TESTS_KEY_PATH');
        self::$bucket = (new StorageClient([
            'keyFilePath' => $keyFilePath
        ]))->createBucket(uniqid(self::TESTING_PREFIX));
        self::$dataset = (new BigQueryClient([
            'keyFilePath' => $keyFilePath
        ]))->createDataset(uniqid(self::TESTING_PREFIX));
        self::$restClient = new LoggingClient([
            'keyFilePath' => $keyFilePath,
            'transport' => 'rest'
        ]);
        self::$grpcClient = new LoggingClient([
            'keyFilePath' => $keyFilePath,
            'transport' => 'grpc'
        ]);
        self::$topic = (new PubSubClient([
            'keyFilePath' => $keyFilePath,
            'transport' => 'rest'
        ]))->createTopic(uniqid(self::TESTING_PREFIX));
        self::$hasSetUp = true;
    }

    public static function tearDownFixtures()
    {
        if (!self::$hasSetUp) {
            return;
        }

        self::$deletionQueue[] = self::$dataset;
        self::$deletionQueue[] = self::$bucket;
        self::$deletionQueue[] = self::$topic;
        $backoff = new ExponentialBackoff(8);

        foreach (self::$deletionQueue as $item) {
            $backoff->execute(function () use ($item) {
                $item->delete();
            });
        }
    }
}



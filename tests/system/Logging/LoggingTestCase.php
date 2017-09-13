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

use Google\Cloud\BigQuery\BigQueryClient;
use Google\Cloud\Core\ExponentialBackoff;
use Google\Cloud\Logging\LoggingClient;
use Google\Cloud\PubSub\PubSubClient;
use Google\Cloud\Storage\StorageClient;
use Google\Cloud\Tests\System\SystemTestCase;

class LoggingTestCase extends SystemTestCase
{
    const TESTING_PREFIX = 'gcloud_testing_';

    protected static $bucket;
    protected static $dataset;
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

        $storage = new StorageClient([
            'keyFilePath' => $keyFilePath
        ]);

        $bigquery = new BigQueryClient([
            'keyFilePath' => $keyFilePath
        ]);

        $pubsub = new PubSubClient([
            'keyFilePath' => $keyFilePath,
            'transport' => 'rest'
        ]);

        self::$bucket = self::createBucket($storage, uniqid(self::TESTING_PREFIX));
        self::$dataset = self::createDataset($bigquery, uniqid(self::TESTING_PREFIX));
        self::$topic = self::createTopic($pubsub, uniqid(self::TESTING_PREFIX));

        self::$restClient = new LoggingClient([
            'keyFilePath' => $keyFilePath,
            'transport' => 'rest'
        ]);

        self::$grpcClient = new LoggingClient([
            'keyFilePath' => $keyFilePath,
            'transport' => 'grpc'
        ]);

        self::$hasSetUp = true;
    }
}



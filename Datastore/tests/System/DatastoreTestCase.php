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

namespace Google\Cloud\Datastore\Tests\System;

use Google\Cloud\Core\ExponentialBackoff;
use Google\Cloud\Datastore\DatastoreClient;
use Google\Cloud\Core\Testing\System\DeletionQueue;
use Yoast\PHPUnitPolyfills\TestCases\TestCase;

/**
 * Datastore does not use the default deletion queue. Because of the way
 * datastore entities are deleted, a local queue is required.
 * Be sure to use `self::$localDeletionQueue` for all datastore entities.
 */
class DatastoreTestCase extends TestCase
{
    const TESTING_PREFIX = 'gcloud_testing_';

    protected static $restClient;
    protected static $grpcClient;
    protected static $returnInt64AsObjectClient;
    protected static $localDeletionQueue;
    private static $hasSetUp = false;

    public static function set_up_before_class()
    {
        if (self::$hasSetUp) {
            return;
        }

        self::$localDeletionQueue = new DeletionQueue(true);

        $config = [
            'keyFilePath' => getenv('GOOGLE_CLOUD_PHP_TESTS_KEY_PATH'),
            'namespaceId' => uniqid(self::TESTING_PREFIX),
            'databaseId' => '',
        ];

        self::$restClient = new DatastoreClient($config + [
            'transport' => 'rest'
        ]);
        self::$grpcClient = new DatastoreClient($config + [
            'transport' => 'grpc'
        ]);
        self::$returnInt64AsObjectClient = new DatastoreClient($config + [
            'returnInt64AsObject' => true
        ]);
        self::$hasSetUp = true;
    }

    public static function tearDownFixtures()
    {
        if (empty(self::$localDeletionQueue)) {
            return;
        }

        $backoff = new ExponentialBackoff(8);
        $transaction = self::$restClient->transaction();

        self::$localDeletionQueue->process(function ($items) use ($backoff, $transaction) {
            $backoff->execute(function () use ($items, $transaction) {
                $transaction->deleteBatch($items);
            });
        });
    }

    public function defaultDbClientProvider()
    {
        self::set_up_before_class();

        return [
            'restClient' => [self::$restClient],
            'grpcClient' => [self::$grpcClient]
        ];
    }
}

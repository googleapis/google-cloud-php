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

namespace Google\Cloud\Tests\System\Datastore;

use Google\Cloud\Core\ExponentialBackoff;
use Google\Cloud\Datastore\DatastoreClient;

class DatastoreTestCase extends \PHPUnit_Framework_TestCase
{
    const TESTING_PREFIX = 'gcloud_testing_';

    protected static $client;
    protected static $returnInt64AsObjectClient;
    protected static $deletionQueue = [];
    private static $hasSetUp = false;

    public static function setUpBeforeClass()
    {
        if (self::$hasSetUp) {
            return;
        }

        $config = [
            'keyFilePath' => getenv('GOOGLE_CLOUD_PHP_TESTS_KEY_PATH'),
            'namespaceId' => uniqid(self::TESTING_PREFIX)
        ];

        self::$client = new DatastoreClient($config);
        self::$returnInt64AsObjectClient = new DatastoreClient($config + [
            'returnInt64AsObject' => true
        ]);
        self::$hasSetUp = true;
    }

    public static function tearDownFixtures()
    {
        if (empty(self::$deletionQueue)) {
            return;
        }

        $backoff = new ExponentialBackoff(8);
        $transaction = self::$client->transaction();
        $backoff->execute(function () use ($transaction) {
            $transaction->deleteBatch(self::$deletionQueue);
        });
    }
}



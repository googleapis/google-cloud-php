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

namespace Google\Cloud\Firestore\Tests\System;

use Google\Cloud\Core\ExponentialBackoff;
use Google\Cloud\Core\Testing\System\DeletionQueue;
use Google\Cloud\Core\Testing\System\SystemTestCase;
use Google\Cloud\Firestore\FirestoreClient;

class FirestoreTestCase extends SystemTestCase
{
    const COLLECTION_NAME = 'system-test';
    const TEST_DB_NAME = 'system-tests-named-db';

    protected static $client;
    protected static $multiDbClient;
    protected static $collection;
    protected static $multiDbCollection;
    protected static $localDeletionQueue;
    private static $hasSetUp = false;

    public static function setUpBeforeClass(): void
    {
        if (self::$hasSetUp) {
            return;
        }

        self::$localDeletionQueue = new DeletionQueue(true);

        $keyFilePath = getenv('GOOGLE_CLOUD_PHP_FIRESTORE_TESTS_KEY_PATH');
        self::$client = new FirestoreClient([
            'keyFilePath' => $keyFilePath
        ]);
        self::$multiDbClient = new FirestoreClient([
            'keyFilePath' => $keyFilePath,
            'database' => self::TEST_DB_NAME
        ]);
        self::$collection = self::$client->collection(uniqid(self::COLLECTION_NAME));
        self::$multiDbCollection = self::$multiDbClient->collection(uniqid(self::COLLECTION_NAME));
        self::$localDeletionQueue->add(self::$collection);
        self::$localDeletionQueue->add(self::$multiDbCollection);

        self::$hasSetUp = true;
    }

    public static function tearDownFixtures()
    {
        if (empty(self::$localDeletionQueue)) {
            return;
        }

        $backoff = new ExponentialBackoff(8);

        self::$localDeletionQueue->process(function ($items) use ($backoff) {
            foreach ($items as $item) {
                $backoff->execute(function () use ($item) {
                    if ($item instanceof CollectionReference) {
                        foreach ($item->documents() as $document) {
                            $document->reference()->delete();
                        }
                    } elseif ($item instanceof DocumentReference) {
                        $item->delete();
                    } elseif ($item instanceof DocumentSnapshot) {
                        $item->reference()->delete();
                    }
                });
            }
        });
    }

    public static function skipEmulatorTests()
    {
        if ((bool) getenv("FIRESTORE_EMULATOR_HOST")) {
            self::markTestSkipped('This test is not supported by the emulator.');
        }
    }
}

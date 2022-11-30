<?php
/**
 * Copyright 2019 Google LLC.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Google\Cloud\Datastore\Tests\System;

use Google\Cloud\Datastore\DatastoreSessionHandler;

/**
 * @group datastore
 * @group datastore-session
 * @group datastore-multipledb
 *
 * @runTestsInSeparateProcesses
 */
class DatastoreSessionHandlerTest extends DatastoreMultipleDbTestCase
{
    public function testSessionHandler()
    {
        $client = current(self::defaultDbClientProvider())[0];

        $namespace = uniqid('sess-' . self::TESTING_PREFIX);
        $content = uniqid('foo');
        $storedValue = 'name|' . serialize($content);

        $handler = new DatastoreSessionHandler($client);

        session_set_save_handler($handler, true);
        session_save_path($namespace);
        session_start();

        $sessionId = session_id();
        $_SESSION['name'] = $content;

        session_write_close();
        sleep(2);

        $q = $client->query();
        $q->kind('PHPSESSID');

        $res = $client->runQuery($q, [
            'namespaceId' => $namespace,
        ]);

        $hasEntity = false;
        $keys = [];
        foreach ($res as $e) {
            if (!$hasEntity) {
                $hasEntity = $e['data'] === $storedValue;
            }

            self::$localDeletionQueue->add($e->key());
        }

        $this->assertTrue($hasEntity);
    }

    public function testMultipleDbSessionHandler()
    {
        $client = current(self::multiDbClientProvider())[0];

        $namespace = uniqid('sess-' . self::TESTING_PREFIX);
        $content = uniqid('foo');
        $storedValue = 'name|' . serialize($content);

        $handler = new DatastoreSessionHandler($client, 0, [
            'databaseId' => self::TEST_DB_NAME,
        ]);

        @session_set_save_handler($handler, true);
        @session_save_path($namespace);
        @session_start();

        $sessionId = session_id();

        $_SESSION['name'] = $content;

        session_write_close();
        sleep(2);

        $q = $client->query();
        $q->kind('PHPSESSID');

        // multi db should have data
        $res = $client->runQuery($q, [
            'namespaceId' => $namespace,
            'databaseId' => self::TEST_DB_NAME,
        ]);

        $hasEntity = false;
        foreach ($res as $e) {
            if (!$hasEntity) {
                $hasEntity = $e['data'] === $storedValue;
            }

            self::$localDeletionQueue->add($e->key());
        }

        $this->assertTrue($hasEntity);
    }
}

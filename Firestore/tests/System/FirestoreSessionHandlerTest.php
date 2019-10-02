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

namespace Google\Cloud\Firestore\Tests\System;

use Google\Cloud\Firestore\FirestoreSessionHandler;

/**
 * @group firestore
 * @group firestore-session
 *
 * @runTestsInSeparateProcesses
 */
class FirestoreSessionHandlerTest extends FirestoreTestCase
{
    public function testSessionWrite()
    {
        $client = self::$client;

        $namespace = uniqid('sess-' . self::COLLECTION_NAME);
        $content = 'foo';
        $storedValue = 'name|' . serialize($content);

        $handler = $client->sessionHandler();

        session_set_save_handler($handler, true);
        session_save_path($namespace);
        session_start();

        $sessionId = session_id();
        $_SESSION['name'] = $content;

        session_write_close();
        sleep(1);

        $hasDocument = false;
        $collection = $client->collection($namespace . ':' . session_name());
        self::$localDeletionQueue->add($collection);
        foreach ($collection->documents() as $snapshot) {
            if (!$hasDocument) {
                $hasDocument = $snapshot['data'] === $storedValue;
            }
        }

        $this->assertTrue($hasDocument);
    }

    public function testGarbageCollection()
    {
        $client = self::$client;

        // Set session max lifetime to 0 to ensure deletion
        ini_set('session.gc_maxlifetime', 0);

        // Disable probability-based GC
        ini_set('session.gc_probability', 0);

        $namespace = uniqid('sess-' . self::COLLECTION_NAME);
        $collection = $client->collection($namespace . ':' . session_name());
        self::$localDeletionQueue->add($collection);
        $collection->document('foo1')->set(['data' => 'foo1', 't' => time() - 1]);
        $collection->document('foo2')->set(['data' => 'foo2', 't' => time() - 1]);
        $collection->document('foo3')->set(['data' => 'foo3', 't' => time() + 1]);
        $this->assertCount(3, $collection->documents());

        $handler = $client->sessionHandler([
            'gcLimit' => 500,
        ]);

        session_set_save_handler($handler, true);
        session_save_path($namespace);
        session_start();

        session_gc();

        $this->assertCount(1, $collection->documents());
    }

    public function testGarbageCollectionBeforeWrite()
    {
        $client = self::$client;

        // Set session max lifetime to 0 to ensure deletion
        ini_set('session.gc_maxlifetime', 0);

        // Set GC divisor and probability to 1 so GC execution happens 100%
        ini_set('session.gc_divisor', 1);
        ini_set('session.gc_probability', 1);

        $namespace = uniqid('sess-' . self::COLLECTION_NAME);
        $content = 'foo';
        $storedValue = 'name|' . serialize($content);
        $collection = $client->collection($namespace . ':' . session_name());
        self::$localDeletionQueue->add($collection);
        $collection->document('foo1')->set(['data' => 'foo1', 't' => time() - 1]);
        $collection->document('foo2')->set(['data' => 'foo2', 't' => time() - 1]);
        $this->assertCount(2, $collection->documents());

        $handler = $client->sessionHandler(['gcLimit' => 500]);
        session_set_save_handler($handler, true);
        session_save_path($namespace);
        session_start();

        $sessionId = session_id();
        $_SESSION['name'] = $content;

        session_write_close();
        sleep(1);

        // assert old records have been removed and the new record has been added.
        $this->assertCount(1, $collection->documents());
    }

    public function testSessionGcReturnValue()
    {
        // "session_gc" returns false for user-defined session handlers.
        // The following test will always fail:
        // ```
        // $this->assertGreaterThan(0, session_gc());
        // ```
        // This test is to remind us to implement a test the issue is fixed.
        $this->markTestSkipped('session_gc returns false due to a core PHP bug');
    }
}

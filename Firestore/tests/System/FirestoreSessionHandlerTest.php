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
    public function testSessionHandler()
    {
        $client = self::$client;

        $namespace = uniqid('sess-' . self::COLLECTION_NAME);
        $content = 'foo';
        $storedValue = 'name|' . serialize($content);

        $handler = new FirestoreSessionHandler($client);

        session_set_save_handler($handler, true);
        session_save_path($namespace);
        session_start();

        $sessionId = session_id();
        $_SESSION['name'] = $content;

        session_write_close();
        sleep(1);

        $hasDocument = false;
        $query = $client->collection($namespace);
        foreach ($query->documents() as $snapshot) {
            self::$deletionQueue->add($snapshot->reference());
            if (!$hasDocument) {
                $hasDocument = $snapshot['data'] === $storedValue;
            }
        }

        $this->assertTrue($hasDocument);
    }
}

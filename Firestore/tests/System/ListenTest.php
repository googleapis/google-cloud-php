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

use Google\ApiCore\ApiException;
use Google\ApiCore\BidiStream;
use Google\Cloud\Firestore\V1\Client\FirestoreClient;
use Google\Cloud\Firestore\V1\ListenRequest;
use Google\Cloud\Firestore\V1\ListenResponse;

/**
 * @group firestore
 * @group firestore-listen
 */
class ListenTest extends FirestoreTestCase
{
    const DATABASE = 'projects/%s/databases/(default)';

    private $query;

    public function setUp(): void
    {
        $this->query = self::$client->collection(uniqid(self::COLLECTION_NAME));
        self::$localDeletionQueue->add($this->query);
        if (!$this->projectId = getenv('GOOGLE_CLOUD_FIRESTORE_PROJECT')) {
            $this->markTestSkipped('please set the GOOGLE_CLOUD_FIRESTORE_PROJECT env var');
        }
    }

    public function testListen()
    {
        $database = sprintf(self::DATABASE, $this->projectId);

        // Create a client.
        $firestoreClient = new FirestoreClient();

        // Prepare the request message.
        $request = (new ListenRequest())
            ->setDatabase($database);

        // Call the API and handle any network failures.
        /** @var BidiStream $stream */
        $stream = $firestoreClient->listen([
            'headers' => [
                'x-goog-request-params' => [
                    'database=' . $database
                ]
            ]
        ]);
        $stream->writeAll([$request,]);

        /** @var ListenResponse $element */
        foreach ($stream->closeWriteAndReadAll() as $element) {
            // TODO: Assert something
        }
        $this->assertTrue(true);
    }

    public function testListenThrowsExceptionWithoutDatabaseHeader()
    {
        $this->expectException(ApiException::class);
        $this->expectExceptionMessage(
            'Missing required http header (\'google-cloud-resource-prefix\' or \'x-goog-request-params\')'
            . ' or query param \'database\'.'
        );
        $database = sprintf(self::DATABASE, $this->projectId);

        // Create a client.
        $firestoreClient = new FirestoreClient();

        // Prepare the request message.
        $request = (new ListenRequest())
            ->setDatabase($database);

        // Call the API and handle any network failures.
        /** @var BidiStream $stream */
        $stream = $firestoreClient->listen();
        $stream->writeAll([$request,]);

        /** @var ListenResponse $element */
        foreach ($stream->closeWriteAndReadAll() as $element) {
            // TODO: Assert something
        }
    }
}

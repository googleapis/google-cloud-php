<?php
/**
 * Copyright 2018 Google Inc.
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

use Google\Cloud\Firestore\DocumentSnapshot;

/**
 * @group firestore
 * @group firestore-getalldocuments
 */
class GetAllDocumentsTest extends FirestoreTestCase
{
    const COLLECTION_NAME = 'system-test-get-all-documents';

    private static $refsExist = [];
    private static $refsNonExist = [];

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        $c = self::$client->collection(uniqid(self::COLLECTION_NAME));
        self::$localDeletionQueue->add($c);

        for ($i = 0; $i < 5; $i++) {
            $doc = $c->add([
                'name' => 'foo'
            ]);
            self::$refsExist[$doc->name()] = $doc;
        }

        for ($i = 0; $i < 5; $i++) {
            $doc = $c->newDocument();
            self::$refsNonExist[$doc->name()] = $doc;
        }
    }

    public function testDocumentsNonTransactional()
    {
        $f = self::$client;

        $paths = $this->interleave();
        $res = $f->documents($paths);

        $this->assertContainsOnlyInstancesOf(DocumentSnapshot::class, $res);
        foreach ($res as $i => $document) {
            $name = $document->name();

            // check order
            $this->assertEquals($paths[$i]->name(), $name);

            $exist = array_key_exists($name, self::$refsExist);

            $this->assertEquals($exist, $document->exists());
        }
    }

    public function testDocumentsTransactional()
    {
        $f = self::$client;

        $paths = $this->interleave();
        $res = [];
        $f->runTransaction(function ($t) use ($paths, &$res) {
            $res = $t->documents($paths);
        });

        $this->assertContainsOnlyInstancesOf(DocumentSnapshot::class, $res);
        foreach ($res as $i => $document) {
            $name = $document->name();

            // check order
            $this->assertEquals($paths[$i]->name(), $name);

            $exist = array_key_exists($name, self::$refsExist);

            $this->assertEquals($exist, $document->exists());
        }
    }

    private function interleave()
    {
        $exist = array_values(self::$refsExist);
        $nonExist = array_values(self::$refsNonExist);
        $docs = [];
        foreach ($exist as $i => $doc) {
            $docs[] = $doc;
            $docs[] = $nonExist[$i];
        }

        return $docs;
    }
}

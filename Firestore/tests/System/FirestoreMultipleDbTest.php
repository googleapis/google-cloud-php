<?php
/**
 * Copyright 2023 Google LLC
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

use Google\Cloud\Firestore\FieldPath;
use Google\Cloud\Firestore\Query;

/**
 * @group firestore
 * @group firestore-multipledb
 */
class FirestoreMultipleDbTest extends FirestoreTestCase
{
    private $document;

    public function setUp(): void
    {
        $this->document = self::$multiDbCollection->newDocument();
    }

    public function testInsert()
    {
        $this->assertFalse($this->document->snapshot()->exists());

        self::$multiDbClient->runTransaction(function ($t) {
            $t->create($this->document, [
                'foo' => 'bar'
            ]);
        });

        $this->assertTrue($this->document->snapshot()->exists());
    }

    public function testUpdate()
    {
        $this->document->create([
            'foo' => 'bar'
        ]);

        self::$multiDbClient->runTransaction(function ($t) {
            $t->update($this->document, [
                ['path' => 'bat', 'value' => 'baz']
            ]);
        });

        $this->assertEquals([
            'foo' => 'bar',
            'bat' => 'baz'
        ], $this->document->snapshot()->data());
    }


    public function testCollectionGroup()
    {
        // Create a random collection name, but make sure
        // it starts with 'b' for predictable ordering.
        $collectionGroup = 'b' . uniqid(self::COLLECTION_NAME);
        $query = $this->createDocuments([
            // following doc paths will match based on the collection group id
            'abc/123/%s/cg-doc1',
            'abc/123/%s/cg-doc2',
            '%s/cg-doc3',
            '%s/cg-doc4',
            'def/456/%s/cg-doc5',
            // following doc paths will NOT match with collection group id
            '%s/virtual-doc/nested-coll/not-cg-doc', // nested-coll
            'x%s/not-cg-doc',                        // x-prefix
            '%sx/not-cg-doc',                        // x-suffix
            'abc/123/%sx/not-cg-doc',                // x-prefix
            'abc/123/x%s/not-cg-doc',                // x-suffix
            'abc/%s',                                // abc
        ], $collectionGroup);

        $query = self::$multiDbClient->collectionGroup($collectionGroup);
        $documentIds = array_map(
            fn($doc) => $doc->id(),
            // Returns docs only with matching exact collection group id
            $query->documents()->rows()
        );
        $this->assertEqualsCanonicalizing(
            ['cg-doc1', 'cg-doc2', 'cg-doc3', 'cg-doc4', 'cg-doc5'],
            $documentIds
        );
    }

    private function createDocuments(array $paths, $collectionGroupId)
    {
        foreach ($paths as &$path) {
            $path = sprintf($path, $collectionGroupId);
        }
        $batch = self::$multiDbClient->bulkWriter();

        foreach ($paths as $docpath) {
            $doc = self::$multiDbClient->document($docpath);
            self::$localDeletionQueue->add($doc);
            $batch->set($doc, [
                'x' => 1
            ]);
        }

        $batch->flush();
        self::$localDeletionQueue->add($collectionGroupId);
    }
}

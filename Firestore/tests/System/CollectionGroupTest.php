<?php
/**
 * Copyright 2019 Google LLC
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
 * @group firestore-collectiongroup
 */
class CollectionGroupTest extends FirestoreTestCase
{
    public function testCollectionGroup()
    {
        list ($query) = $this->createDocuments([
            'abc/123/%s/cg-doc1',
            'abc/123/%s/cg-doc2',
            '%s/cg-doc3',
            '%s/cg-doc4',
            'def/456/%s/cg-doc5',
            '%s/virtual-doc/nested-coll/not-cg-doc',
            'x%s/not-cg-doc',
            '%sx/not-cg-doc',
            'abc/123/%sx/not-cg-doc',
            'abc/123/x%s/not-cg-doc',
            'abc/%s',
        ]);

        $this->assertEquals(
            ['cg-doc1', 'cg-doc2', 'cg-doc3', 'cg-doc4', 'cg-doc5'],
            $this->getIds($query)
        );
    }

    public function testCollectionGroupStartAtEndAt()
    {
        list ($query) = $this->createDocuments([
            'a/a/%s/cg-doc1',
            'a/b/a/b/%s/cg-doc2',
            'a/b/%s/cg-doc3',
            'a/b/c/d/%s/cg-doc4',
            'a/c/%s/cg-doc5',
            '%s/cg-doc6',
            'a/b/nope/nope'
        ]);

        $query = $query->orderBy(FieldPath::documentId())
            ->startAt(['a/b'])
            ->endAt(['a/b0']);

        $this->assertEquals(
            ['cg-doc2', 'cg-doc3', 'cg-doc4'],
            $this->getIds($query)
        );
    }

    public function testCollectionGroupStartAfterEndBefore()
    {
        list ($query, $paths, $group) = $this->createDocuments([
            'a/a/%s/cg-doc1',
            'a/b/a/b/%s/cg-doc2',
            'a/b/%s/cg-doc3',
            'a/b/c/d/%s/cg-doc4',
            'a/c/%s/cg-doc5',
            '%s/cg-doc6',
            'a/b/nope/nope'
        ]);

        $query = $query->orderBy(FieldPath::documentId())
            ->startAfter(['a/b'])
            ->endBefore([sprintf('a/b/%s/cg-doc3', $group)]);

        $this->assertEquals(
            ['cg-doc2'],
            $this->getIds($query)
        );
    }

    public function testCollectionGroupWhere()
    {
        list ($query, $paths, $group) = $this->createDocuments([
            'a/a/%s/cg-doc1',
            'a/b/a/b/%s/cg-doc2',
            'a/b/%s/cg-doc3',
            'a/b/c/d/%s/cg-doc4',
            'a/c/%s/cg-doc5',
            '%s/cg-doc6',
            'a/b/nope/nope'
        ]);

        $query = $query->where(FieldPath::documentId(), '>', 'a/b')
            ->where(FieldPath::documentId(), '<', sprintf(
                'a/b/%s/cg-doc3',
                $group
            ));

        $this->assertEquals(
            ['cg-doc2'],
            $this->getIds($query)
        );
    }

    public function testCollectionGroupWhereMultipleFilters()
    {
        list ($query, $paths, $group) = $this->createDocuments([
            'a/a/%s/cg-doc1',
            'a/b/a/b/%s/cg-doc2',
            'a/b/%s/cg-doc3',
            'a/b/c/d/%s/cg-doc4',
            'a/c/%s/cg-doc5',
            '%s/cg-doc6',
            'a/b/nope/nope'
        ]);

        $query = $query->where(FieldPath::documentId(), '>=', 'a/b')
            ->where(FieldPath::documentId(), '<=', 'a/b0');

        $this->assertEquals(
            ['cg-doc2', 'cg-doc3', 'cg-doc4'],
            $this->getIds($query)
        );
    }

    private function createDocuments(array $paths)
    {
        // Create a random collection name, but make sure
        // it starts with 'b' for predictable ordering.
        $collectionGroup = 'b' . uniqid(self::COLLECTION_NAME);
        $query = self::$client->collectionGroup($collectionGroup);

        foreach ($paths as &$path) {
            $path = sprintf($path, $collectionGroup);
        }

        $batch = self::$client->batch();
        foreach ($paths as $path) {
            $doc = self::$client->document($path);
            self::$deletionQueue->add($doc);
            $batch->set($doc, [
                'x' => 1
            ]);
        }

        $batch->commit();

        return [$query, $paths, $collectionGroup];
    }

    private function getIds(Query $query)
    {
        $documents = $query->documents()->rows();
        $ids = [];
        foreach ($documents as $document) {
            $ids[] = $document->id();
        }
        sort($ids);

        return $ids;
    }
}

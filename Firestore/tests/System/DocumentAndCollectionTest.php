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

use Google\Cloud\Firestore\CollectionReference;
use Google\Cloud\Firestore\DocumentReference;

/**
 * @group firestore
 * @group firestore-documentandcollection
 */
class DocumentAndCollectionTest extends FirestoreTestCase
{
    private $document;

    public function set_up()
    {
        $this->document = self::$collection->add([
            'firstName' => 'John',
            'country' => 'USA'
        ]);
    }

    public function testCreate()
    {
        $document = self::$collection->newDocument();
        $document->create(['firstName' => 'Kate']);
        $this->assertTrue($document->snapshot()->exists());
        $this->assertEquals(['firstName' => 'Kate'], $document->snapshot()->data());
    }

    public function testUpdate()
    {
        $this->assertEquals('John', $this->document->snapshot()['firstName']);

        $this->document->update([
            ['path' => 'firstName', 'value' => 'Dave']
        ]);

        $snapshot = $this->document->snapshot();
        $this->assertEquals('Dave', $snapshot['firstName']);
        $this->assertEquals('USA', $snapshot['country']);
    }

    public function testSet()
    {
        $this->assertEquals([
            'firstName' => 'John',
            'country' => 'USA'
        ], $this->document->snapshot()->data());

        $this->document->set([
            'firstName' => 'Dave'
        ]);

        $snapshot = $this->document->snapshot();
        $this->assertEquals('Dave', $snapshot['firstName']);

        $this->assertArrayNotHasKey('country', $snapshot->data());
    }

    public function testSetMerge()
    {
        $this->assertEquals([
            'firstName' => 'John',
            'country' => 'USA'
        ], $this->document->snapshot()->data());

        $this->document->set([
            'firstName' => 'Dave'
        ], ['merge' => true]);

        $snapshot = $this->document->snapshot();
        $this->assertEquals('Dave', $snapshot['firstName']);
        $this->assertEquals('USA', $snapshot['country']);
    }

    public function testDelete()
    {
        $this->assertTrue($this->document->snapshot()->exists());
        $this->document->delete();
        $this->assertFalse($this->document->snapshot()->exists());
    }

    public function testCollections()
    {
        $childName = uniqid(self::COLLECTION_NAME);
        $child = $this->document->collection($childName);
        self::$localDeletionQueue->add($child);
        $doc = $child->add(['name' => 'John']);

        $collection = $this->document->collections()->current();

        $this->assertEquals($childName, $collection->id());
    }

    public function testListDocuments()
    {
        $collection = self::$client->collection(uniqid(self::COLLECTION_NAME));
        self::$localDeletionQueue->add($collection);
        $doc = $collection->add(['a' => 'b']);

        $list = $collection->listDocuments();
        $this->assertCount(1, iterator_to_array($list));
        $this->assertContainsOnlyInstancesOf(DocumentReference::class, $list);
    }

    public function testNonAlphaNumericFieldPaths()
    {
        $paths = [
            [
                'path' => '`!.\\``.`\'!.\\``',
                'value' => 'foo'
            ]
        ];

        $this->document->update($paths);

        $snap = $this->document->snapshot();

        $this->assertEquals($paths[0]['value'], $snap->get($paths[0]['path']));
    }

    public function testDeeplyNestedFieldData()
    {
        $this->document->set([
            'level1' => [
                'level2' => [
                    'level3' => [
                        'level4' => [
                            'level5' => 'a value!'
                        ]
                    ],
                    'level3val' => 'another value'
                ]
            ]
        ]);

        $this->document->set([
            'level1' => [
                'level2' => [
                    'level3' => [
                        'level4' => [
                            'hello' => 'world'
                        ]
                    ],
                ]
            ]
        ], ['merge' => true]);

        $this->document->update([
            ['path' => 'level1.level2.level3.level4.final', 'value' => 'final']
        ]);

        $snap = $this->document->snapshot();
        $this->assertEquals('a value!', $snap->get('level1.level2.level3.level4.level5'));
        $this->assertEquals('another value', $snap->get('level1.level2.level3val'));
        $this->assertEquals('world', $snap->get('level1.level2.level3.level4.hello'));
        $this->assertEquals('final', $snap->get('level1.level2.level3.level4.final'));
    }

    public function testRootCollections()
    {
        $client = self::$client;
        $this->assertContainsOnlyInstancesOf(
            CollectionReference::class,
            iterator_to_array($client->collections())
        );
    }
}

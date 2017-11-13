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

namespace Google\Cloud\Tests\System\Firestore;

use Google\Cloud\Core\Timestamp;
use Google\Cloud\Firestore\FieldValue;
use Google\Cloud\Firestore\FirestoreClient;

/**
 * @group firestore
 * @group firestore-documentandcollection
 */
class DocumentAndCollectionTest extends FirestoreTestCase
{
    private $document;

    public function setUp()
    {
        $this->document = self::$collection->add([
            'firstName' => 'John',
            'country' => 'USA'
        ]);

        self::$deletionQueue->add($this->document);
    }

    public function testCreate()
    {
        $document = self::$collection->newDocument();
        self::$deletionQueue->add($document);
        $document->create(['firstName' => 'Kate']);
        $this->assertTrue($document->snapshot()->exists());
        $this->assertEquals(['firstName' => 'Kate'], $document->snapshot()->fields());
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
        ], $this->document->snapshot()->fields());

        $this->document->set([
            'firstName' => 'Dave'
        ]);

        $snapshot = $this->document->snapshot();
        $this->assertEquals('Dave', $snapshot['firstName']);

        try {
            $snapshot['country'];
            $this->assertTrue(false);
        } catch (\PHPUnit_Framework_Error_Notice $e) {
            $this->assertTrue(true);
        }
    }

    public function testSetMerge()
    {
        $this->assertEquals([
            'firstName' => 'John',
            'country' => 'USA'
        ], $this->document->snapshot()->fields());

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
        $doc = $this->document->collection('foo')->add(['name' => 'John']);
        self::$deletionQueue->add($doc);

        $collection = $this->document->collections()->current();

        $this->assertEquals('foo', $collection->id());
    }

    public function testDeleteField()
    {
        $this->document->set([
            'foo' => 'bar'
        ]);
        $this->assertEquals('bar', $this->document->snapshot()['foo']);

        $this->document->update([
            ['path' => 'foo', 'value' => FieldValue::deleteField()]
        ]);

        try {
            $this->document->snapshot()->get('foo');
            $this->assertTrue(false);
        } catch (\InvalidArgumentException $e) {
            $this->assertTrue(true);
        }
    }

    public function testServerTimestamp()
    {
        $this->document->set([
            'foo' => 'bar'
        ]);
        $this->assertEquals('bar', $this->document->snapshot()['foo']);

        $this->document->update([
            ['path' => 'foo', 'value' => FieldValue::serverTimestamp()]
        ]);

        $this->assertInstanceOf(Timestamp::class, $this->document->snapshot()['foo']);
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
}

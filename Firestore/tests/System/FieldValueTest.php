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

use Google\Cloud\Core\Timestamp;
use Google\Cloud\Firestore\FieldValue;

/**
 * @group firestore
 * @group firestore-write
 */
class FieldValueTest extends FirestoreTestCase
{
    private $document;

    public function set_up()
    {
        $this->document = self::$collection->add([
            'firstName' => 'John',
            'country' => 'USA'
        ]);
    }

    public function testServerTimestamp()
    {
        $this->document->update([
            ['path' => 'foo', 'value' => 'bar']
        ]);
        $this->assertEquals('bar', $this->document->snapshot()['foo']);

        $this->document->update([
            ['path' => 'foo', 'value' => FieldValue::serverTimestamp()]
        ]);

        $this->assertInstanceOf(Timestamp::class, $this->document->snapshot()['foo']);
    }

    public function testDelete()
    {
        $this->document->update([
            ['path' => 'foo', 'value' => 'bar']
        ]);
        $this->assertEquals('bar', $this->document->snapshot()['foo']);

        $this->document->update([
            ['path' => 'foo', 'value' => FieldValue::deleteField()]
        ]);

        $this->assertArrayNotHasKey('foo', $this->document->snapshot()->data());
    }

    /**
     * @dataProvider transforms
     */
    public function testTransform($initialValue, $fieldValue, $expectedValue)
    {
        $field = uniqid('transform-field');
        $this->document->update([
            ['path' => $field, 'value' => $initialValue]
        ]);
        $this->assertEquals($initialValue, $this->document->snapshot()[$field]);

        $this->document->update([
            ['path' => $field, 'value' => $fieldValue]
        ]);
        $this->assertEquals($expectedValue, $this->document->snapshot()[$field]);
    }

    public function transforms()
    {
        return [
            [
                ['a', 'b'],
                FieldValue::arrayUnion(['a', 'c', 'd']),
                ['a', 'b', 'c', 'd']
            ], [
                ['a', 'b'],
                FieldValue::arrayRemove(['a']),
                ['b']
            ], [
                1,
                FieldValue::increment(2),
                3
            ]
        ];
    }
}

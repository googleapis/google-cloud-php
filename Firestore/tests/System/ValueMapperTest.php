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

use Google\Cloud\Core\Blob;
use Google\Cloud\Core\GeoPoint;
use Google\Cloud\Core\Timestamp;

/**
 * @group firestore
 * @group firestore-valuemapper
 */
class ValueMapperTest extends FirestoreTestCase
{
    private static $document;
    private static $isSetup = false;

    const FIELD = 'testedField';

    public static function set_up_before_class()
    {
        parent::set_up_before_class();

        if (!self::$isSetup) {
            self::$document = self::$collection->add([]);
            self::$isSetup = true;
        }
    }

    /**
     * @dataProvider values
     */
    public function testValue($input, callable $expectation = null)
    {
        self::$document->update([
            ['path' => self::FIELD, 'value' => $input]
        ]);

        $snapshot = self::$document->snapshot();
        if ($expectation) {
            $this->assertTrue($expectation($snapshot[self::FIELD]));
        } elseif ($input instanceof Timestamp) {
            $this->assertEquals($input->formatAsString(), $snapshot[self::FIELD]->formatAsString());
        } else {
            $this->assertEquals($input, $snapshot[self::FIELD]);
        }
    }

    public function values()
    {
        self::set_up_before_class();

        return [
            [null],
            [true],
            [false],
            [10],
            [2147483647],
            [3.1415],
            [new Timestamp(\DateTime::createFromFormat('U', time()))],
            ['foo'],
            [self::$document],
            [new GeoPoint(10, -10)],
            [[1, 2, 3, 4]],
            [['foo' => 'bar', 'bat' => [1, 2, 3, 4]]],
            [(object) []],
            [NAN, function ($val) {
                return is_nan($val);
            }]
        ];
    }

    public function testBlob()
    {
        $blob = new Blob('foobar');

        self::$document->update([
            ['path' => self::FIELD, 'value' => $blob]
        ]);

        $snapshot = self::$document->snapshot();
        $this->assertEquals((string) $blob->get(), (string) $snapshot[self::FIELD]);
    }
}

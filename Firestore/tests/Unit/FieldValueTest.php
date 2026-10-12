<?php
/**
 * Copyright 2018 Google LLC
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

namespace Google\Cloud\Firestore\Tests\Unit;

use Google\Cloud\Firestore\FieldValue;
use Google\Cloud\Firestore\FieldValue\ArrayRemoveValue;
use Google\Cloud\Firestore\FieldValue\ArrayUnionValue;
use Google\Cloud\Firestore\FieldValue\IncrementValue;
use Google\Cloud\Firestore\FieldValue\ServerTimestampValue;
use Google\Cloud\Firestore\V1\DocumentTransform\FieldTransform\ServerValue;
use PHPUnit\Framework\TestCase;

/**
 * @group firestore
 * @group firestore-fieldvalue
 */
class FieldValueTest extends TestCase
{
    /**
     * @dataProvider statics
     */
    public function testStatics($name, $type, $args = [])
    {
        $v = FieldValue::$name($args);

        $this->assertInstanceOf($type, $v);
        $this->assertEquals($args, $v->args());
    }

    public function statics()
    {
        return [
            ['serverTimestamp', ServerTimestampValue::class, ServerValue::REQUEST_TIME],
            ['arrayUnion', ArrayUnionValue::class, ['a']],
            ['arrayRemove', ArrayRemoveValue::class, ['b']],
            ['increment', IncrementValue::class, 1],
        ];
    }
}

<?php
/**
 * Copyright 2018 Google Inc. All Rights Reserved.
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

namespace Google\Cloud\Storage\Tests\System;

use Google\Cloud\Core\Exception\ServiceException;

/**
 * @group storage
 * @group storage-object
 * @group storage-object-hold
 */
class HoldObjectsTest extends StorageTestCase
{
    /**
     * @dataProvider holdTypeProvider
     */
    public function testHold($holdType)
    {
        $code = null;
        // Upload an object with a hold enabled.
        $object = self::$bucket->upload('test-hold', [
            'name' => 'test-hold.txt',
            'metadata' => [
                $holdType => true
            ]
        ]);

        try {
            $object->delete();
        } catch (ServiceException $ex) {
            $code = $ex->getCode();
        }

        $this->assertEquals(403, $code);

        // Disable the hold.
        $object->update([
            $holdType => false
        ]);

        $this->assertNull($object->delete());
    }

    public function holdTypeProvider()
    {
        return [
            ['temporaryHold'],
            ['eventBasedHold']
        ];
    }
}

<?php
/**
 * Copyright 2016 Google Inc. All Rights Reserved.
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

namespace Google\Cloud\Tests\System\Datastore;

/**
 * @group datastore
 */
class AllocateKeyTest extends DatastoreTestCase
{
    public function testAllocateId()
    {
        $kind = 'Person';
        $key = self::$client->key($kind);
        $path = self::$client->allocateId($key)->path()[0];

        $this->assertTrue(is_numeric($path['id']));
        $this->assertEquals($kind, $path['kind']);
    }

    public function testAllocateIds()
    {
        $kind = 'Person';
        $keys = self::$client->keys($kind);
        $allocatedKeys = self::$client->allocateIds($keys);

        foreach ($allocatedKeys as $key) {
            $path = $key->path()[0];
            $this->assertTrue(is_numeric($path['id']));
            $this->assertEquals($kind, $path['kind']);
        }
    }
}

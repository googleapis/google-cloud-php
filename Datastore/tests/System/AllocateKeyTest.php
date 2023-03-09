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

namespace Google\Cloud\Datastore\Tests\System;

use Google\Cloud\Datastore\DatastoreClient;
use Yoast\PHPUnitPolyfills\Polyfills\AssertIsType;

/**
 * @group datastore
 * @group datastore-key
 */
class AllocateKeyTest extends DatastoreMultipleDbTestCase
{
    use AssertIsType;

    /**
     * @dataProvider clientProvider
     */
    public function testAllocateId(DatastoreClient $client)
    {
        $kind = 'Person';
        $key = $client->key($kind);
        $path = $client->allocateId($key)->path()[0];

        $this->assertIsNumeric($path['id']);
        $this->assertEquals($kind, $path['kind']);
    }

    /**
     * @dataProvider clientProvider
     */
    public function testAllocateIds(DatastoreClient $client)
    {
        $kind = 'Person';
        $keys = $client->keys($kind);
        $allocatedKeys = $client->allocateIds($keys);

        foreach ($allocatedKeys as $key) {
            $path = $key->path()[0];
            $this->assertIsNumeric($path['id']);
            $this->assertEquals($kind, $path['kind']);
        }
    }
}

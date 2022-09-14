<?php
/**
 * Copyright 2016 Google Inc.
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

namespace Google\Cloud\Datastore\Tests\Unit;

use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Datastore\DatastoreClient;
use Google\Cloud\Datastore\DatastoreTrait;
use Google\Cloud\Datastore\Key;
use Google\Cloud\Datastore\Transaction;
use Yoast\PHPUnitPolyfills\Polyfills\AssertIsType;
use Yoast\PHPUnitPolyfills\TestCases\TestCase;

/**
 * @group datastore
 */
class DatastoreTraitTest extends TestCase
{
    use AssertIsType;

    private $stub;

    public function set_up()
    {
        $this->stub = TestHelpers::impl(DatastoreTrait::class);
    }

    public function testPartitionId()
    {
        $res = $this->stub->call('partitionId', [
            'foo', 'bar'
        ]);

        $this->assertIsArray($res);
        $this->assertEquals('foo', $res['projectId']);
        $this->assertEquals('bar', $res['namespaceId']);
    }
}

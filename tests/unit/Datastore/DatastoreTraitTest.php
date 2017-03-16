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

namespace Google\Cloud\Tests\Unit\Datastore;

use Google\Cloud\Datastore\DatastoreClient;
use Google\Cloud\Datastore\DatastoreTrait;
use Google\Cloud\Datastore\Key;
use Google\Cloud\Datastore\Transaction;

/**
 * @group datastore
 */
class DatastoreTraitTest extends \PHPUnit_Framework_TestCase
{
    private $stub;

    public function setUp()
    {
        $this->stub = new DatastoreTraitStub;
    }

    public function testPartitionId()
    {
        $res = $this->stub->call('partitionId', [
            'foo', 'bar'
        ]);

        $this->assertTrue(is_array($res));
        $this->assertEquals('foo', $res['projectId']);
        $this->assertEquals('bar', $res['namespaceId']);
    }
}

class DatastoreTraitStub
{
    use DatastoreTrait;

    public function call($fn, array $args)
    {
        return call_user_func_array([$this, $fn], $args);
    }
}

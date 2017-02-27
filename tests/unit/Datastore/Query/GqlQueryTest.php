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

namespace Google\Cloud\Tests\Unit\Datastore\Query;

use Google\Cloud\Datastore\EntityMapper;
use Google\Cloud\Datastore\Query\GqlQuery;

/**
 * @group datastore
 */
class GqlQueryTest extends \PHPUnit_Framework_TestCase
{
    private $mapper;

    public function setUp()
    {
        $this->mapper = new EntityMapper('foo', true, false);
    }

    public function testBindingTypeAutomaticDetectionNamed()
    {
        $query = new GqlQuery($this->mapper, 'SELECT * FROM foo', [
            'bindings' => [
                'bind' => 'this'
            ]
        ]);

        $res = $query->queryObject();
        $this->assertEquals($res['namedBindings'], [
            'bind' => ['value' => ['stringValue' => 'this']]
        ]);
    }

    public function testBindingTypeAutomaticDetectionPositional()
    {
        $query = new GqlQuery($this->mapper, 'SELECT * FROM foo', [
            'bindings' => [
                'this'
            ]
        ]);

        $res = $query->queryObject();
        $this->assertEquals($res['positionalBindings'], [
            ['value' => ['stringValue' => 'this']]
        ]);
    }

    public function testAllowLiterals()
    {
        $query = new GqlQuery($this->mapper, 'SELECT * FROM foo');
        $res = $query->queryObject();
        $this->assertFalse($res['allowLiterals']);

        $query = new GqlQuery($this->mapper, 'SELECT * FROM foo', [
            'allowLiterals' => true
        ]);

        $res = $query->queryObject();
        $this->assertTrue($res['allowLiterals']);
    }

    public function testCanPaginateReturnsFalse()
    {
        $query = new GqlQuery($this->mapper, 'SELECT * FROM foo');
        $this->assertFalse($query->canPaginate());
    }

    public function testQueryKeyIsCorrect()
    {
        $query = new GqlQuery($this->mapper, 'SELECT * FROM foo');
        $this->assertEquals($query->queryKey(), 'gqlQuery');
    }

    public function testJsonSerialize()
    {
        $query = new GqlQuery($this->mapper, 'SELECT * FROM foo');
        $this->assertEquals($query->jsonSerialize(), $query->queryObject());
    }
}

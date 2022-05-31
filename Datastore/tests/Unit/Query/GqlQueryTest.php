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

namespace Google\Cloud\Datastore\Tests\Unit\Query;

use Google\Cloud\Datastore\Cursor;
use Google\Cloud\Datastore\EntityMapper;
use Google\Cloud\Datastore\Query\GqlQuery;
use Yoast\PHPUnitPolyfills\TestCases\TestCase;

/**
 * @group datastore
 */
class GqlQueryTest extends TestCase
{
    private $mapper;

    public function set_up()
    {
        $this->mapper = new EntityMapper('foo', true, false);
    }

    public function testBindingTypeAutomaticDetectionNamed()
    {
        $cursorValue = 'foo';
        $query = new GqlQuery($this->mapper, 'SELECT * FROM foo', [
            'bindings' => [
                'bind' => 'this',
                'offset' => new Cursor($cursorValue)
            ]
        ]);

        $res = $query->queryObject();
        $this->assertEquals($res['namedBindings'], [
            'bind' => ['value' => ['stringValue' => 'this']],
            'offset' => ['cursor' => $cursorValue]
        ]);
    }

    public function testBindingTypeAutomaticDetectionPositional()
    {
        $cursorValue = 'foo';
        $query = new GqlQuery($this->mapper, 'SELECT * FROM foo', [
            'bindings' => [
                'this',
                new Cursor($cursorValue)
            ]
        ]);

        $res = $query->queryObject();
        $this->assertEquals($res['positionalBindings'], [
            ['value' => ['stringValue' => 'this']],
            ['cursor' => $cursorValue]
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

    public function testCanPaginateReturnsTrue()
    {
        $query = new GqlQuery($this->mapper, 'SELECT * FROM foo');
        $this->assertTrue($query->canPaginate());
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

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

use Google\Cloud\Datastore\EntityMapper;
use Google\Cloud\Datastore\Query\Filter;
use Google\Cloud\Datastore\Key;
use Google\Cloud\Datastore\Query\Query;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * @group datastore
 */
class QueryTest extends TestCase
{
    private $query;
    private $mapper;

    public function setUp(): void
    {
        $this->mapper = new EntityMapper('foo', true, false);
        $this->query = new Query($this->mapper);
    }

    public function testConstructorOptions()
    {
        $query = new Query($this->mapper, ['foo' => 'bar']);

        $this->assertEquals($query->queryObject(), ['foo' => 'bar']);
    }

    public function testCanPaginateFlagIsTrue()
    {
        $this->assertTrue($this->query->canPaginate());
    }

    public function testQueryKeyIsCorrect()
    {
        $this->assertEquals($this->query->queryKey(), 'query');
    }

    public function testJsonSerialize()
    {
        $this->assertEquals($this->query->jsonSerialize(), $this->query->queryObject());
    }

    public function testProjection()
    {
        $property = 'propname';
        $self = $this->query->projection($property);
        $this->assertInstanceOf(Query::class, $self);

        $res = $this->query->queryObject();

        $this->assertEquals($res['projection'][0]['property']['name'], $property);
    }

    public function testProjectionWithArrayArgument()
    {
        $properties = ['propname', 'propname2'];
        $this->query->projection($properties);

        $res = $this->query->queryObject();

        $this->assertEquals($res['projection'][0]['property']['name'], $properties[0]);
        $this->assertEquals($res['projection'][1]['property']['name'], $properties[1]);
    }

    public function testKeysOnly()
    {
        $this->query->keysOnly();
        $res = $this->query->queryObject();

        $this->assertEquals($res['projection'][0]['property']['name'], '__key__');
    }

    public function testKind()
    {
        $self = $this->query->kind('kindName');
        $this->assertInstanceOf(Query::class, $self);

        $res = $this->query->queryObject();

        $this->assertEquals($res['kind'], [
            ['name' => 'kindName']
        ]);
    }

    public function testKindWithArrayArgument()
    {
        $this->query->kind(['kindName1', 'kindName2']);

        $res = $this->query->queryObject();

        $this->assertEquals($res['kind'], [
            ['name' => 'kindName1'],
            ['name' => 'kindName2'],
        ]);
    }

    public function testFilter()
    {
        $self = $this->query->filter('propname', '=', 'value');
        $this->assertInstanceOf(Query::class, $self);

        $res = $this->query->queryObject();

        $filters = $res['filter']['compositeFilter']['filters'];

        $this->assertEquals($filters[0]['propertyFilter'], [
            'property' => [
                'name' => 'propname'
            ],
            'value' => [
                'stringValue' => 'value'
            ],
            'op' => Query::OP_DEFAULT
        ]);
    }

    public function testFilterCustomOperator()
    {
        $self = $this->query->filter('propname', Query::OP_GREATER_THAN, 12);
        $this->assertInstanceOf(Query::class, $self);

        $res = $this->query->queryObject();

        $filters = $res['filter']['compositeFilter']['filters'];

        $this->assertEquals($filters[0]['propertyFilter'], [
            'property' => [
                'name' => 'propname'
            ],
            'value' => [
                'integerValue' => 12
            ],
            'op' => Query::OP_GREATER_THAN
        ]);
    }

    public function testFilterInvalidOperator()
    {
        $this->expectException(InvalidArgumentException::class);

        $this->query->filter('propname', 'foo', 12);
    }

    public function testFilterWithFilterArrayArgument()
    {
        $filter = Filter::or([
            Filter::and([
                Filter::where('bar', '>', 1),
                Filter::where('bar', '<', 4),
            ]),
            Filter::where('bar', '>', 8)
        ]);
        $expected = json_decode(file_get_contents(
            __DIR__ . '/../data/QueryApiArrayFormat.json'
        ), true);

        $query = new Query($this->mapper);
        $query->kind('Foo')->filter($filter);
        $queryObject = $query->queryObject();
        $this->assertEquals($expected, $queryObject);
    }

    /**
     * @dataProvider getOperatorCases
     */
    public function testOperators($operator, $resultingOperator)
    {
        $this->query->filter('propName', $operator, 'val');
        $res = $this->query->queryObject();

        $filters = $res['filter']['compositeFilter']['filters'];
        $this->assertEquals($resultingOperator, $filters[0]['propertyFilter']['op']);
    }

    public function testOrder()
    {
        $direction = 'DESCENDING';
        $self = $this->query->order('propname', Query::ORDER_DESCENDING);
        $this->assertInstanceOf(Query::class, $self);

        $res = $this->query->queryObject();

        $this->assertEquals($res['order'][0], [
            'property' => [
                'name' => 'propname'
            ],
            'direction' => $direction
        ]);
    }

    public function testOrderWithDefaultDireciton()
    {
        $direction = 'ASCENDING';
        $self = $this->query->order('propname');
        $this->assertInstanceOf(Query::class, $self);

        $res = $this->query->queryObject();

        $this->assertEquals($res['order'][0], [
            'property' => [
                'name' => 'propname'
            ],
            'direction' => $direction
        ]);
    }

    public function testHasAncestorWithKeyObject()
    {
        $key = (new Key('foo'))->pathElement('Kind', 'Name');

        $this->query->hasAncestor($key);

        $res = $this->query->queryObject();

        $propertyFilter = $res['filter']['compositeFilter']['filters'][0]['propertyFilter'];

        $this->assertEquals(
            '__key__',
            $propertyFilter['property']['name']
        );

        $this->assertEquals(
            'Kind',
            $propertyFilter['value']['keyValue']['path'][0]['kind']
        );

        $this->assertEquals(
            'Name',
            $propertyFilter['value']['keyValue']['path'][0]['name']
        );

        $this->assertEquals(
            'foo',
            $propertyFilter['value']['keyValue']['partitionId']['projectId']
        );
    }

    public function testDistinctOn()
    {
        $self = $this->query->distinctOn('propname');
        $this->assertInstanceOf(Query::class, $self);

        $res = $this->query->queryObject();

        $this->assertEquals($res['distinctOn'], [
            ['name' => 'propname']
        ]);
    }

    public function testDistinctOnWithArrayArgument()
    {
        $this->query->distinctOn(['propname1', 'propname2']);

        $res = $this->query->queryObject();

        $this->assertEquals($res['distinctOn'], [
            ['name' => 'propname1'],
            ['name' => 'propname2'],
        ]);
    }

    public function testStart()
    {
        $self = $this->query->start('1234');
        $this->assertInstanceOf(Query::class, $self);

        $res = $this->query->queryObject();

        $this->assertEquals($res['startCursor'], '1234');
    }

    public function testEnd()
    {
        $self = $this->query->end('1234');
        $this->assertInstanceOf(Query::class, $self);

        $res = $this->query->queryObject();

        $this->assertEquals($res['endCursor'], '1234');
    }

    public function testOffset()
    {
        $self = $this->query->offset(2);
        $this->assertInstanceOf(Query::class, $self);

        $res = $this->query->queryObject();

        $this->assertEquals($res['offset'], 2);
    }

    public function testLimit()
    {
        $self = $this->query->limit(2);
        $this->assertInstanceOf(Query::class, $self);

        $res = $this->query->queryObject();

        $this->assertEquals($res['limit'], 2);
    }

    public function getOperatorCases()
    {
        return [
            ['=', 'EQUAL'],
            [Query::OP_EQUALS, 'EQUAL'],
            [Query::OP_DEFAULT, 'EQUAL'],
            ['<', 'LESS_THAN'],
            [Query::OP_LESS_THAN, 'LESS_THAN'],
            ['<=', 'LESS_THAN_OR_EQUAL'],
            [Query::OP_LESS_THAN_OR_EQUAL, 'LESS_THAN_OR_EQUAL'],
            ['>', 'GREATER_THAN'],
            [Query::OP_GREATER_THAN, 'GREATER_THAN'],
            ['>=', 'GREATER_THAN_OR_EQUAL'],
            [Query::OP_GREATER_THAN_OR_EQUAL, 'GREATER_THAN_OR_EQUAL'],
            ['IN', 'IN'],
            [Query::OP_IN, 'IN'],
            ['NOT IN', 'NOT_IN'],
            [Query::OP_NOT_IN, 'NOT_IN'],
            ['!=', 'NOT_EQUAL'],
            [Query::OP_NOT_EQUALS, 'NOT_EQUAL'],
            [Query::OP_HAS_ANCESTOR, 'HAS_ANCESTOR']
        ];
    }
}

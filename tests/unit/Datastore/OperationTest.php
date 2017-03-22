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

use Google\Cloud\Datastore\Connection\ConnectionInterface;
use Google\Cloud\Datastore\Entity;
use Google\Cloud\Datastore\EntityIterator;
use Google\Cloud\Datastore\EntityMapper;
use Google\Cloud\Datastore\Key;
use Google\Cloud\Datastore\Operation;
use Google\Cloud\Datastore\Query\QueryInterface;
use Prophecy\Argument;

/**
 * @group datastore
 */
class OperationTest extends \PHPUnit_Framework_TestCase
{
    private $operation;
    private $mapper;
    private $connection;

    public function setUp()
    {
        $this->connection = $this->prophesize(ConnectionInterface::class);
        $this->mapper = new EntityMapper('foo', true, false);
        $this->operation = new OperationStub($this->connection->reveal(), 'foo', '', $this->mapper);
    }

    public function testKey()
    {
        $key = $this->operation->key('Foo', 'Bar');

        $this->assertInstanceOf(Key::class, $key);
        $this->assertEquals('Foo', $key->path()[0]['kind']);
        $this->assertEquals('Bar', $key->path()[0]['name']);
    }

    public function testKeyWithNamespaceId()
    {
        $op = new Operation($this->connection->reveal(), 'foo', 'namespace', $this->mapper);
        $key = $op->key('Person', 'Bob');
        $obj = $key->keyObject();

        $this->assertEquals('namespace', $obj['partitionId']['namespaceId']);
    }

    public function testKeyWithNamespaceIdOverride()
    {
        $op = new Operation($this->connection->reveal(), 'foo', 'namespace', $this->mapper);
        $key = $op->key('Person', 'Bob', [
            'namespaceId' => 'otherNamespace'
        ]);
        $obj = $key->keyObject();

        $this->assertEquals('otherNamespace', $obj['partitionId']['namespaceId']);
    }

    public function testKeys()
    {
        $keys = $this->operation->keys('Foo');
        $this->assertEquals(1, count($keys));
        $this->assertInstanceOf(Key::class, $keys[0]);
    }

    public function testKeysNumber()
    {
        $keys = $this->operation->keys('Foo', [
            'number' => 10
        ]);

        $this->assertEquals(10, count($keys));
    }

    public function testKeysAncestors()
    {
        $keys = $this->operation->keys('Foo', [
            'ancestors' => [
                ['kind' => 'Kind', 'id' => '10']
            ]
        ]);

        $this->assertEquals($keys[0]->path(), [
            ['kind' => 'Kind', 'id' => '10'],
            ['kind' => 'Foo']
        ]);
    }

    public function testKeysId()
    {
        $keys = $this->operation->keys('Foo', [
            'id' => '10'
        ]);

        $this->assertEquals($keys[0]->path(), [
            ['kind' => 'Foo', 'id' => '10']
        ]);
    }

    public function testKeysName()
    {
        $keys = $this->operation->keys('Foo', [
            'name' => '10'
        ]);

        $this->assertEquals($keys[0]->path(), [
            ['kind' => 'Foo', 'name' => '10']
        ]);
    }

    public function testEntity()
    {
        $key = $this->prophesize(Key::class);
        $e = $this->operation->entity($key->reveal());

        $this->assertInstanceOf(Entity::class, $e);
    }

    public function testEntityWithKind()
    {
        $e = $this->operation->entity('Foo');
        $this->assertInstanceOf(Entity::class, $e);
        $this->assertEquals($e->key()->state(), Key::STATE_INCOMPLETE);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testInvalidKeyType()
    {
        $this->operation->entity(1);
    }

    public function testEntityCustomClass()
    {
        $e = $this->operation->entity('Foo', [], [
            'className' => MyEntity::class
        ]);

        $this->assertInstanceOf(MyEntity::class, $e);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testEntityCustomClassInvalidType()
    {
        $e = $this->operation->entity('Foo', [], [
            'className' => Operation::class
        ]);
    }

    public function testAllocateIds()
    {
        $keys = [
            $this->operation->key('foo')
        ];

        $this->connection->allocateIds(Argument::type('array'))
            ->shouldBeCalled()
            ->willReturn([
                'keys' => [
                    [
                        'path' => [
                            ['kind' => 'foo', 'id' => '1']
                        ]
                    ]
                ]
            ]);

        $this->operation->setConnection($this->connection->reveal());

        $res = $this->operation->allocateIds($keys);

        $this->assertEquals($res[0]->state(), Key::STATE_NAMED);
        $this->assertEquals($res[0]->path()[0]['id'], '1');
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testAllocateIdsNamedKey()
    {
        $keys = [
            $this->operation->key('foo', 'Bar')
        ];

        $this->operation->allocateIds($keys);
    }

    public function testLookup()
    {
        $keys = [
            $this->operation->key('foo', 'Bar')
        ];

        $this->connection->lookup(Argument::type('array'))
            ->shouldBeCalled()
            ->willReturn([]);

        $this->operation->setConnection($this->connection->reveal());

        $res = $this->operation->lookup($keys);

        $this->assertTrue(is_array($res));
    }

    public function testLookupFound()
    {
        $body = json_decode(file_get_contents(__DIR__ .'/../fixtures/datastore/entity-batch-lookup.json'), true);
        $this->connection->lookup(Argument::any())->willReturn([
            'found' => $body
        ]);

        $this->operation->setConnection($this->connection->reveal());

        $key = $this->operation->key('Kind', 'ID');
        $res = $this->operation->lookup([$key]);

        $this->assertTrue(is_array($res));
        $this->assertTrue(isset($res['found']) && is_array($res['found']));

        $this->assertInstanceOf(Entity::class, $res['found'][0]);
        $this->assertEquals($res['found'][0]['Number'], $body[0]['entity']['properties']['Number']['stringValue']);

        $this->assertInstanceOf(Entity::class, $res['found'][1]);
        $this->assertEquals($res['found'][1]['Number'], $body[1]['entity']['properties']['Number']['stringValue']);
    }

    public function testLookupMissing()
    {
        $body = json_decode(file_get_contents(__DIR__ .'/../fixtures/datastore/entity-batch-lookup.json'), true);
        $this->connection->lookup(Argument::any())->willReturn([
            'missing' => $body
        ]);

        $this->operation->setConnection($this->connection->reveal());

        $key = $this->operation->key('Kind', 'ID');

        $res = $this->operation->lookup([$key]);

        $this->assertTrue(is_array($res));
        $this->assertTrue(isset($res['missing']) && is_array($res['missing']));

        $this->assertInstanceOf(Key::class, $res['missing'][0]);
        $this->assertInstanceOf(Key::class, $res['missing'][1]);
    }

    public function testLookupDeferred()
    {
        $body = json_decode(file_get_contents(__DIR__ .'/../fixtures/datastore/entity-batch-lookup.json'), true);
        $this->connection->lookup(Argument::any())->willReturn([
            'deferred' => [ $body[0]['entity']['key'] ]
        ]);

        $this->operation->setConnection($this->connection->reveal());

        $key = $this->operation->key('Kind', 'ID');

        $res = $this->operation->lookup([$key]);

        $this->assertTrue(is_array($res));
        $this->assertTrue(isset($res['deferred']) && is_array($res['deferred']));
        $this->assertInstanceOf(Key::class, $res['deferred'][0]);
    }

    public function testLookupWithReadOptionsFromTransaction()
    {
        $this->connection->lookup(Argument::withKey('readOptions'))->shouldBeCalled()->willReturn([]);

        $this->operation->setConnection($this->connection->reveal());

        $k = new Key('test-project', [
            'path' => [['kind' => 'kind', 'id' => '123']]
        ]);

        $this->operation->lookup([$k], ['transaction' => 'foo']);
    }

    public function testLookupWithReadOptionsFromReadConsistency()
    {
        $this->connection->lookup(Argument::withKey('readOptions'))->shouldBeCalled()->willReturn([]);

        $this->operation->setConnection($this->connection->reveal());

        $k = new Key('test-project', [
            'path' => [['kind' => 'kind', 'id' => '123']]
        ]);

        $this->operation->lookup([$k], ['readConsistency' => 'foo']);
    }

    public function testLookupWithoutReadOptions()
    {
        $this->connection->lookup(Argument::that(function ($args) {
            if (isset($args['readOptions'])) return false;

            return true;
        }))->shouldBeCalled()->willReturn([]);

        $this->operation->setConnection($this->connection->reveal());

        $k = new Key('test-project', [
            'path' => [['kind' => 'kind', 'id' => '123']]
        ]);

        $this->operation->lookup([$k]);
    }

    public function testLookupWithSort()
    {
        $data = json_decode(file_get_contents(__DIR__ .'/../fixtures/datastore/entity-lookup-bigsort.json'), true);

        $keys = [];
        foreach ($data['keys'] as $key) {
            $keys[] = new Key('test-project', [
                'path' => $key['path']
            ]);
        }

        $this->connection->lookup(Argument::any())->willReturn([
            'found' => $data['entities']
        ]);

        $this->operation->setConnection($this->connection->reveal());

        $res = $this->operation->lookup($keys, [
            'sort' => true
        ]);

        $found = $res['found'];

        foreach ($data['keys'] as $i => $key) {
            $this->assertEquals($key['path'][0]['id'], $found[$i]->key()->path()[0]['id']);
        }
    }

    public function testLookupWithoutSort()
    {
        $data = json_decode(file_get_contents(__DIR__ .'/../fixtures/datastore/entity-lookup-bigsort.json'), true);

        $keys = [];
        foreach ($data['keys'] as $key) {
            $keys[] = new Key('test-project', [
                'path' => $key['path']
            ]);
        }

        $this->connection->lookup(Argument::any())->willReturn([
            'found' => $data['entities'],
            'missing' => $data['missing']
        ]);

        $this->operation->setConnection($this->connection->reveal());

        $res = $this->operation->lookup($keys);

        $found = $res['found'];

        foreach ($data['entities'] as $i => $e) {
            $this->assertEquals($e['entity']['key']['path'][0]['id'], $found[$i]->key()->path()[0]['id']);
        }
    }

    public function testLookupWithSortAndMissingKey()
    {
        $data = json_decode(file_get_contents(__DIR__ .'/../fixtures/datastore/entity-lookup-bigsort.json'), true);

        // Move an entity to missing.
        $missing = $data['entities'][5];
        $data['missing'][] = $missing;
        unset($data['entities'][5]);

        $keys = [];
        foreach ($data['keys'] as $key) {
            $keys[] = new Key('test-project', [
                'path' => $key['path']
            ]);
        }

        $this->connection->lookup(Argument::any())->willReturn([
            'found' => $data['entities']
        ]);

        $this->operation->setConnection($this->connection->reveal());

        $res = $this->operation->lookup($keys, [
            'sort' => true
        ]);

        $found = $res['found'];

        $this->assertEquals($keys[0]->path()[0]['id'], $found[0]->key()->path()[0]['id']);
        $this->assertEquals($keys[1]->path()[0]['id'], $found[1]->key()->path()[0]['id']);
        $this->assertEquals($keys[2]->path()[0]['id'], $found[2]->key()->path()[0]['id']);
        $this->assertEquals($keys[3]->path()[0]['id'], $found[3]->key()->path()[0]['id']);
        $this->assertEquals($keys[4]->path()[0]['id'], $found[4]->key()->path()[0]['id']);
        $this->assertEquals($keys[6]->path()[0]['id'], $found[5]->key()->path()[0]['id']);
        $this->assertEquals($keys[7]->path()[0]['id'], $found[6]->key()->path()[0]['id']);
        $this->assertEquals($keys[8]->path()[0]['id'], $found[7]->key()->path()[0]['id']);
        $this->assertEquals($keys[9]->path()[0]['id'], $found[8]->key()->path()[0]['id']);
        $this->assertEquals($keys[10]->path()[0]['id'], $found[9]->key()->path()[0]['id']);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testLookupInvalidKey()
    {
        $key = $this->operation->key('Foo');

        $this->operation->lookup([$key]);
    }

    public function testRunQuery()
    {
        $queryResult = json_decode(file_get_contents(__DIR__ .'/../fixtures/datastore/query-results.json'), true);
        $this->connection->runQuery(Argument::type('array'))
            ->willReturn($queryResult['notPaged']);

        $this->operation->setConnection($this->connection->reveal());

        $q = $this->prophesize(QueryInterface::class);
        $q->queryKey()->shouldBeCalled()->willReturn('query');
        $q->queryObject()->shouldBeCalled()->willReturn([]);
        $q->canPaginate()->willReturn(true);
        $q->start(Argument::any());

        $res = $this->operation->runQuery($q->reveal());

        $this->assertInstanceOf(EntityIterator::class, $res);

        $arr = iterator_to_array($res);
        $this->assertEquals(count($arr), 2);
        $this->assertInstanceOf(Entity::class, $arr[0]);
    }

    public function testRunQueryPaged()
    {
        $queryResult = json_decode(file_get_contents(__DIR__ .'/../fixtures/datastore/query-results.json'), true);
        $this->connection->runQuery(Argument::type('array'))
            ->will(function($args, $mock) use ($queryResult) {
                // The 2nd call will return the 2nd page of results!
                $mock->runQuery(Argument::type('array'))
                    ->willReturn($queryResult['paged'][1]);
                return $queryResult['paged'][0];
            });

        $this->operation->setConnection($this->connection->reveal());

        $q = $this->prophesize(QueryInterface::class);
        $q->queryKey()->shouldBeCalled()->willReturn('query');
        $q->queryObject()->shouldBeCalled()->willReturn([]);
        $q->canPaginate()->willReturn(true);
        $q->start(Argument::any())->willReturn(null);

        $res = $this->operation->runQuery($q->reveal());

        $this->assertInstanceOf(EntityIterator::class, $res);

        $arr = iterator_to_array($res);
        $this->assertEquals(count($arr), 3);
        $this->assertInstanceOf(Entity::class, $arr[0]);
    }

    public function testRunQueryNoResults()
    {
        $queryResult = json_decode(file_get_contents(__DIR__ .'/../fixtures/datastore/query-results.json'), true);
        $this->connection->runQuery(Argument::type('array'))
            ->willReturn($queryResult['noResults']);

        $this->operation->setConnection($this->connection->reveal());

        $q = $this->prophesize(QueryInterface::class);
        $q->queryKey()->shouldBeCalled()->willReturn('query');
        $q->queryObject()->shouldBeCalled()->willReturn([]);
        $q->canPaginate()->shouldBeCalled()->willReturn(false);

        $res = $this->operation->runQuery($q->reveal());

        $this->assertInstanceOf(EntityIterator::class, $res);

        $arr = iterator_to_array($res);
        $this->assertEquals(count($arr), 0);
    }

    public function testRunQueryWithReadOptionsFromTransaction()
    {
        $this->connection->runQuery(Argument::withKey('readOptions'))->willReturn([]);

        $this->operation->setConnection($this->connection->reveal());

        $q = $this->prophesize(QueryInterface::class);
        $q->queryKey()->willReturn('query');
        $q->queryObject()->willReturn([]);

        $res = $this->operation->runQuery($q->reveal(), ['transaction' => 'foo']);
        iterator_to_array($res);
    }

    public function testRunQueryWithReadOptionsFromReadConsistency()
    {
        $this->connection->runQuery(Argument::withKey('readOptions'))->willReturn([]);

        $this->operation->setConnection($this->connection->reveal());

        $q = $this->prophesize(QueryInterface::class);
        $q->queryKey()->willReturn('query');
        $q->queryObject()->willReturn([]);

        $res = $this->operation->runQuery($q->reveal(), ['readConsistency' => 'foo']);
        iterator_to_array($res);
    }

    public function testRunQueryWithoutReadOptions()
    {
        $this->connection->runQuery(Argument::that(function ($args) {
            if (isset($args['readOptions'])) return false;

            return true;
        }))->willReturn([]);

        $this->operation->setConnection($this->connection->reveal());

        $q = $this->prophesize(QueryInterface::class);
        $q->queryKey()->willReturn('query');
        $q->queryObject()->willReturn([]);

        $res = $this->operation->runQuery($q->reveal());
        iterator_to_array($res);
    }

    public function testCommit()
    {
        $this->connection->commit(Argument::that(function($arg) {
            if ($arg['mode'] !== 'NON_TRANSACTIONAL') return false;

            if (count($arg['mutations']) > 0) return false;

            return true;
        }))
            ->shouldBeCalled()
            ->willReturn(['foo']);

        $this->operation->setConnection($this->connection->reveal());

        $this->assertEquals(['foo'], $this->operation->commit([]));
    }

    public function testCommitInTransaction()
    {
        $this->connection->commit(Argument::that(function($arg) {
            if ($arg['mode'] !== 'TRANSACTIONAL') return false;

            if (count($arg['mutations']) > 0) return false;

            return true;
        }))
            ->shouldBeCalled()
            ->willReturn(['foo']);

        $this->operation->setConnection($this->connection->reveal());

        $this->operation->commit([], [
            'transaction' => '1234'
        ]);
    }

    public function testCommitWithMutation()
    {
        $this->connection->commit(Argument::that(function($arg) {
            if (count($arg['mutations']) !== 1) return false;

            return true;
        }))
            ->shouldBeCalled()
            ->willReturn(['foo']);

        $this->operation->setConnection($this->connection->reveal());

        $key = $this->prophesize(Key::class);
        $e = new Entity($key->reveal());

        $mutation = $this->operation->mutation('insert', $e, Entity::class, null);

        $this->operation->commit([$mutation]);
    }

    public function testRollback()
    {
        $this->connection->rollback(Argument::exact(['projectId' => 'foo', 'transaction' => 'bar']))
            ->shouldBeCalled()
            ->willReturn(null);

        $this->operation->setConnection($this->connection->reveal());

        $this->operation->rollback('bar');
    }

    public function testAllocateIdsToEntities()
    {
        $this->connection->allocateIds(Argument::that(function ($arg) {
            if (count($arg['keys']) !== 1) return false;

            return true;
        }))
            ->shouldBeCalled()
            ->willReturn([
                'keys' => [
                    [
                        'path' => [
                            ['kind' => 'foo', 'id' => '1']
                        ]
                    ]
                ]
            ]);

        $this->operation->setConnection($this->connection->reveal());

        $entities = [
            $this->operation->entity($this->operation->key('Foo', 'Bar')),
            $this->operation->entity($this->operation->key('Foo'))
        ];

        $res = $this->operation->allocateIdsToEntities($entities);

        $this->assertInstanceOf(Entity::class, $res[0]);
        $this->assertInstanceOf(Entity::class, $res[1]);

        $this->assertEquals($res[0]->key()->state(), Key::STATE_NAMED);
        $this->assertEquals($res[1]->key()->state(), Key::STATE_NAMED);
    }

    public function testMutate()
    {
        $this->connection->commit(Argument::that(function ($arg) {
            if (count($arg['mutations']) !== 1) return false;

            if (!isset($arg['mutations'][0]['insert'])) return false;

            return true;
        }))->willReturn('foo');

        $this->operation->setConnection($this->connection->reveal());

        $key = $this->prophesize(Key::class);
        $e = new Entity($key->reveal());

        $mutation = $this->operation->mutation('insert', $e, Entity::class, null);
        $this->operation->commit([$mutation]);
    }

    public function testMutateWithBaseVersion()
    {
        $this->connection->commit(Argument::that(function ($arg) {
            if ($arg['mutations'][0]['baseVersion'] !== 1) return false;

            return true;
        }))->willReturn('foo');

        $this->operation->setConnection($this->connection->reveal());

        $key = $this->prophesize(Key::class);
        $e = new Entity($key->reveal(), [], [
            'baseVersion' => 1
        ]);

        $mutation = $this->operation->mutation('insert', $e, Entity::class);
        $this->operation->commit([$mutation]);
    }

    public function testMutateWithKey()
    {
        $this->connection->commit(Argument::that(function ($arg) {
            if (!isset($arg['mutations'][0]['delete'])) return false;
            if (!isset($arg['mutations'][0]['delete']['path'])) return false;

            return true;
        }))->willReturn('foo');

        $this->operation->setConnection($this->connection->reveal());

        $key = new Key('foo', [
            'path' => [['kind' => 'foo', 'id' => 1]]
        ]);

        $mutation = $this->operation->mutation('delete', $key, Key::class);
        $this->operation->commit([$mutation]);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testMutateInvalidType()
    {
        $this->operation->mutation('foo', (object)[], \stdClass::class);
    }

    public function testCheckOverwrite()
    {
        $e = $this->prophesize(Entity::class);
        $e->populatedByService()->willReturn(true);

        $this->operation->checkOverwrite([$e->reveal()]);
    }

    public function testCheckOverwriteWithFlagEnabled()
    {
        $e = $this->prophesize(Entity::class);
        $e->populatedByService()->willReturn(false);

        $this->operation->checkOverwrite([$e->reveal()], true);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testCheckOverwriteWithException()
    {
        $e = $this->prophesize(Entity::class);
        $e->populatedByService()->willReturn(false);
        $e->key()->willReturn('foo');

        $this->operation->checkOverwrite([$e->reveal()]);
    }

    public function testMapEntityResult()
    {
        $res = json_decode(file_get_contents(__DIR__ .'/../fixtures/datastore/entity-result.json'), true);

        $this->connection->lookup(Argument::type('array'))
            ->willReturn([
                'found' => $res
            ]);

        $this->operation->setConnection($this->connection->reveal());

        $k = $this->prophesize(Key::class);
        $k->state()->willReturn(Key::STATE_NAMED);

        $entity = $this->operation->lookup([$k->reveal()]);
        $this->assertInstanceOf(Entity::class, $entity['found'][0]);

        $this->assertEquals($entity['found'][0]->baseVersion(), $res[0]['version']);
        $this->assertEquals($entity['found'][0]->cursor(), $res[0]['cursor']);
        $this->assertEquals($entity['found'][0]->prop, $res[0]['entity']['properties']['prop']['stringValue']);
    }

    public function testMapEntityResultWithoutProperties()
    {
        $res = json_decode(file_get_contents(__DIR__ .'/../fixtures/datastore/entity-result-no-properties.json'), true);

        $this->connection->lookup(Argument::type('array'))
            ->willReturn([
                'found' => $res
            ]);

        $this->operation->setConnection($this->connection->reveal());

        $k = $this->prophesize(Key::class);
        $k->state()->willReturn(Key::STATE_NAMED);

        $entity = $this->operation->lookup([$k->reveal()]);
        $this->assertInstanceOf(Entity::class, $entity['found'][0]);

        $this->assertEquals($entity['found'][0]->baseVersion(), $res[0]['version']);
        $this->assertEquals($entity['found'][0]->cursor(), $res[0]['cursor']);
    }

    public function testMapEntityResultArrayOfClassNames()
    {
        $res = json_decode(file_get_contents(__DIR__ .'/../fixtures/datastore/entity-result.json'), true);

        $this->connection->lookup(Argument::type('array'))
            ->willReturn([
                'found' => $res
            ]);

        $this->operation->setConnection($this->connection->reveal());

        $k = $this->prophesize(Key::class);
        $k->state()->willReturn(Key::STATE_NAMED);

        $entity = $this->operation->lookup([$k->reveal()], [
            'className' => [
                'Kind' => MyEntity::class
            ]
        ]);

        $this->assertInstanceOf(MyEntity::class, $entity['found'][0]);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testMapEntityResultArrayOfClassNamesMissingKindMapItem()
    {
        $res = json_decode(file_get_contents(__DIR__ .'/../fixtures/datastore/entity-result.json'), true);

        $this->connection->lookup(Argument::type('array'))
            ->willReturn([
                'found' => $res
            ]);

        $this->operation->setConnection($this->connection->reveal());

        $k = $this->prophesize(Key::class);
        $k->state()->willReturn(Key::STATE_NAMED);

        $entity = $this->operation->lookup([$k->reveal()], [
            'className' => [
                'Kind2' => MyEntity::class
            ]
        ]);
    }

    public function testTransactionInReadOptions()
    {
        $this->connection->lookup(Argument::that(function ($arg) {
            if (!isset($arg['readOptions']['transaction'])) return false;

            return true;
        }))
            ->willReturn([]);

        $this->operation->setConnection($this->connection->reveal());

        $k = $this->prophesize(Key::class);
        $k->state()->willReturn(Key::STATE_NAMED);
        $this->operation->lookup([$k->reveal()], [
            'transaction' => '1234'
        ]);
    }

    public function testNonTransactionalReadOptions()
    {
        $this->connection->lookup(Argument::that(function ($arg) {
            if (!isset($arg['readOptions']['transaction'])) return true;

            return true;
        }))
            ->willReturn([]);

        $this->operation->setConnection($this->connection->reveal());

        $k = $this->prophesize(Key::class);
        $k->state()->willReturn(Key::STATE_NAMED);
        $this->operation->lookup([$k->reveal()]);
    }

    public function testReadConsistencyInReadOptions()
    {
        $this->connection->lookup(Argument::that(function ($arg) {
            if ($arg['readOptions']['readConsistency'] !== 'test') return true;

            return true;
        }))
            ->willReturn([]);

        $this->operation->setConnection($this->connection->reveal());

        $k = $this->prophesize(Key::class);
        $k->state()->willReturn(Key::STATE_NAMED);
        $this->operation->lookup([$k->reveal()], [
            'readConsistency' => 'test'
        ]);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testInvalidBatchType()
    {
        $this->operation->lookup(['foo']);
    }
}

class OperationStub extends Operation
{
    // public function runQuery(QueryInterface $q, array $args = [])
    // {
    //     echo 'test';
    //     exit;
    // }
    public function setConnection($connection)
    {
        $this->connection = $connection;
    }
}

class MyEntity extends Entity {}

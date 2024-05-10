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

use Google\ApiCore\Serializer;
use Google\Cloud\Core\ApiHelperTrait;
use Google\Cloud\Core\RequestHandler;
use Google\Cloud\Core\Testing\DatastoreOperationRefreshTrait;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Datastore\Entity;
use Google\Cloud\Datastore\EntityIterator;
use Google\Cloud\Datastore\EntityMapper;
use Google\Cloud\Datastore\Key;
use Google\Cloud\Datastore\Operation;
use Google\Cloud\Datastore\Query\GqlQuery;
use Google\Cloud\Datastore\Query\Query;
use Google\Cloud\Datastore\Query\QueryInterface;
use Google\Cloud\Datastore\V1\Client\DatastoreClient as V1DatastoreClient;
use Google\Cloud\Datastore\V1\CommitRequest\Mode;
use Google\Cloud\Datastore\V1\LookupRequest;
use Google\Cloud\Datastore\V1\RunQueryRequest;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;

/**
 * @group datastore
 * @group datastore-operation
 */
class OperationTest extends TestCase
{
    use ProphecyTrait;
    use ApiHelperTrait;
    use DatastoreOperationRefreshTrait;

    public const PROJECT = 'example-project';
    public const NAMESPACEID = 'namespace-id';
    public const DATABASEID = 'database-id';

    private $operation;
    private $requestHandler;

    public function setUp(): void
    {
        $this->requestHandler = $this->prophesize(RequestHandler::class);
        $this->operation = TestHelpers::stub(Operation::class, [
            $this->requestHandler->reveal(),
            $this->getSerializer(),
            self::PROJECT,
            null,
            new EntityMapper('foo', true, false),
            self::DATABASEID,
        ], ['requestHandler', 'namespaceId']);
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
        $this->operation->___setProperty('namespaceId', self::NAMESPACEID);
        $key = $this->operation->key('Person', 'Bob');
        $obj = $key->keyObject();

        $this->assertEquals(self::NAMESPACEID, $obj['partitionId']['namespaceId']);
    }

    public function testKeyWithDatabaseId()
    {
        $key = $this->operation->key('Person', 'Bob', ['databaseId' => self::DATABASEID]);
        $obj = $key->keyObject();

        $this->assertEquals(self::DATABASEID, $obj['partitionId']['databaseId']);
    }

    public function testKeyWithNamespaceIdOverride()
    {
        $this->operation->___setProperty('namespaceId', self::NAMESPACEID);
        $key = $this->operation->key('Person', 'Bob', [
            'namespaceId' => 'otherNamespace',
        ]);
        $obj = $key->keyObject();

        $this->assertEquals('otherNamespace', $obj['partitionId']['namespaceId']);
    }

    public function testKeyWithDatabaseIdOverride()
    {
        $key = $this->operation->key('Person', 'Bob', [
            'databaseId' => 'otherDatabaseId',
        ]);
        $obj = $key->keyObject();

        $this->assertEquals('otherDatabaseId', $obj['partitionId']['databaseId']);
    }

    public function testKeys()
    {
        $keys = $this->operation->keys('Foo');
        $this->assertCount(1, $keys);
        $this->assertInstanceOf(Key::class, $keys[0]);
    }

    public function testKeysNumber()
    {
        $keys = $this->operation->keys('Foo', [
            'number' => 10,
        ]);

        $this->assertCount(10, $keys);
    }

    public function testKeysNumberCopy()
    {
        $keys = $this->operation->keys('Foo', [
            'number' => 2,
        ]);

        $keys[0]->setLastElementIdentifier(10);
        $this->assertEquals(10, $keys[0]->pathEndIdentifier());
        $this->assertNull($keys[1]->pathEndIdentifier());
    }

    public function testKeysNumberZero()
    {
        $this->expectException(InvalidArgumentException::class);

        $this->operation->keys('Foo', [
            'number' => 0,
        ]);
    }

    public function testKeysAncestors()
    {
        $keys = $this->operation->keys('Foo', [
            'ancestors' => [
                ['kind' => 'Kind', 'id' => '10'],
            ],
        ]);

        $this->assertEquals($keys[0]->path(), [
            ['kind' => 'Kind', 'id' => '10'],
            ['kind' => 'Foo'],
        ]);
    }

    public function testKeysId()
    {
        $keys = $this->operation->keys('Foo', [
            'id' => '10',
        ]);

        $this->assertEquals($keys[0]->path(), [
            ['kind' => 'Foo', 'id' => '10'],
        ]);
    }

    public function testKeysName()
    {
        $keys = $this->operation->keys('Foo', [
            'name' => '10',
        ]);

        $this->assertEquals($keys[0]->path(), [
            ['kind' => 'Foo', 'name' => '10'],
        ]);
    }

    public function testEntity()
    {
        $key = $this->operation->key('Person');
        $e = $this->operation->entity($key);

        $this->assertInstanceOf(Entity::class, $e);
    }

    public function testEntityWithKind()
    {
        $e = $this->operation->entity('Foo');
        $this->assertInstanceOf(Entity::class, $e);
        $this->assertEquals($e->key()->state(), Key::STATE_INCOMPLETE);
        $this->assertEquals('Foo', $e->key()->pathEnd()['kind']);
    }

    public function testInvalidKeyType()
    {
        $this->expectException(InvalidArgumentException::class);

        $this->operation->entity(1);
    }

    public function testEntityCustomClass()
    {
        $e = $this->operation->entity('Foo', [], [
            'className' => SampleEntity::class,
        ]);

        $this->assertInstanceOf(SampleEntity::class, $e);
    }

    public function testEntityCustomClassInvalidType()
    {
        $this->expectException(InvalidArgumentException::class);

        $e = $this->operation->entity('Foo', [], [
            'className' => Operation::class,
        ]);
    }

    public function testAllocateIds()
    {
        $key = $this->operation->key('foo');

        $id = 12345;
        $keyWithId = clone $key;
        $keyWithId->setLastElementIdentifier($id);

        $this->requestHandler->sendRequest(
            V1DatastoreClient::class,
            'allocateIds',
            Argument::that(function ($req) use ($key) {
                $data = $this->getSerializer()->encodeMessage($req);
                return array_replace_recursive($data['keys'], [$key->keyObject()]) == $data['keys'];
            }),
            Argument::cetera()
        )->shouldBeCalled()->willReturn(['keys' => [$keyWithId->keyObject()]]);

        $this->operation->___setProperty('requestHandler', $this->requestHandler->reveal());

        $res = $this->operation->allocateIds([$key]);

        $this->assertEquals($res[0]->state(), Key::STATE_NAMED);
        $this->assertEquals($res[0]->path()[0]['id'], $id);
    }

    public function testAllocateIdsNamedKey()
    {
        $this->expectException(InvalidArgumentException::class);

        $key = $this->operation->key('foo', 'Bar');

        $this->operation->allocateIds([$key]);
    }

    public function testLookup()
    {
        $key = $this->operation->key('foo', 'Bar');

        $this->requestHandler->sendRequest(
            V1DatastoreClient::class,
            'lookup',
            Argument::type(LookupRequest::class),
            Argument::cetera()
        )->shouldBeCalled()->willReturn([]);

        $this->operation->___setProperty('requestHandler', $this->requestHandler->reveal());

        $res = $this->operation->lookup([$key]);

        $this->assertIsArray($res);
    }

    public function testLookupFound()
    {
        $body = json_decode(file_get_contents(Fixtures::ENTITY_BATCH_LOOKUP_FIXTURE()), true);
        $this->requestHandler->sendRequest(
            V1DatastoreClient::class,
            'lookup',
            Argument::type(LookupRequest::class),
            Argument::cetera()
        )->shouldBeCalled()->willReturn(['found' => $body,]);

        $this->operation->___setProperty('requestHandler', $this->requestHandler->reveal());

        $key = $this->operation->key('Kind', 'ID');
        $res = $this->operation->lookup([$key]);

        $this->assertIsArray($res);
        $this->assertTrue(isset($res['found']) && is_array($res['found']));

        $this->assertInstanceOf(Entity::class, $res['found'][0]);
        $this->assertEquals($res['found'][0]['Number'], $body[0]['entity']['properties']['Number']['stringValue']);

        $this->assertInstanceOf(Entity::class, $res['found'][1]);
        $this->assertEquals($res['found'][1]['Number'], $body[1]['entity']['properties']['Number']['stringValue']);
    }

    public function testLookupMissing()
    {
        $body = json_decode(file_get_contents(Fixtures::ENTITY_BATCH_LOOKUP_FIXTURE()), true);

        $this->requestHandler->sendRequest(
            V1DatastoreClient::class,
            'lookup',
            Argument::type(LookupRequest::class),
            Argument::cetera()
        )->shouldBeCalled()->willReturn(['missing' => $body,]);

        $this->operation->___setProperty('requestHandler', $this->requestHandler->reveal());

        $key = $this->operation->key('Kind', 'ID');

        $res = $this->operation->lookup([$key]);

        $this->assertIsArray($res);
        $this->assertTrue(isset($res['missing']) && is_array($res['missing']));

        $this->assertInstanceOf(Key::class, $res['missing'][0]);
        $this->assertInstanceOf(Key::class, $res['missing'][1]);
    }

    public function testLookupDeferred()
    {
        $body = json_decode(file_get_contents(Fixtures::ENTITY_BATCH_LOOKUP_FIXTURE()), true);

        $this->requestHandler->sendRequest(
            V1DatastoreClient::class,
            'lookup',
            Argument::type(LookupRequest::class),
            Argument::cetera()
        )->shouldBeCalled()->willReturn(['deferred' => [$body[0]['entity']['key']]]);

        $this->operation->___setProperty('requestHandler', $this->requestHandler->reveal());

        $key = $this->operation->key('Kind', 'ID');

        $res = $this->operation->lookup([$key]);

        $this->assertIsArray($res);
        $this->assertTrue(isset($res['deferred']) && is_array($res['deferred']));
        $this->assertInstanceOf(Key::class, $res['deferred'][0]);
    }

    public function testLookupWithReadOptionsFromTransaction()
    {
        $this->requestHandler->sendRequest(
            V1DatastoreClient::class,
            'lookup',
            Argument::that(function ($req) {
                $data = $this->getSerializer()->encodeMessage($req);
                return $data['readOptions']['transaction'] == 'foo';
            }),
            Argument::cetera()
        )->shouldBeCalled()->willReturn([]);

        $this->operation->___setProperty('requestHandler', $this->requestHandler->reveal());

        $k = new Key('test-project', [
            'path' => [['kind' => 'kind', 'id' => '123']],
        ]);

        $this->operation->lookup([$k], ['transaction' => 'foo']);
    }

    public function testLookupWithReadOptionsFromReadConsistency()
    {
        $this->requestHandler->sendRequest(
            V1DatastoreClient::class,
            'lookup',
            Argument::that(function ($req) {
                $data = $this->getSerializer()->encodeMessage($req);
                return $data['readOptions']['readConsistency'] == 123;
            }),
            Argument::cetera()
        )->shouldBeCalled()->willReturn([]);
        $this->operation->___setProperty('requestHandler', $this->requestHandler->reveal());

        $k = new Key('test-project', [
            'path' => [['kind' => 'kind', 'id' => '123']],
        ]);

        $this->operation->lookup([$k], ['readConsistency' => 123]);
    }

    public function testLookupWithoutReadOptions()
    {
        $this->requestHandler->sendRequest(
            Argument::any(),
            Argument::any(),
            Argument::that(function (LookupRequest $arg) {
                return !$arg->hasReadOptions();
            }),
            Argument::cetera()
        )->shouldBeCalled()->willReturn([]);
        $this->operation->___setProperty('requestHandler', $this->requestHandler->reveal());

        $k = new Key('test-project', [
            'path' => [['kind' => 'kind', 'id' => '123']],
        ]);

        $this->operation->lookup([$k]);
    }

    public function testLookupWithSort()
    {
        $data = json_decode(file_get_contents(Fixtures::ENTITY_LOOKUP_BIGSORT_FIXTURE()), true);

        $keys = [];
        foreach ($data['keys'] as $key) {
            $keys[] = new Key('test-project', [
                'path' => $key['path'],
            ]);
        }

        $this->requestHandler->sendRequest(
            V1DatastoreClient::class,
            'lookup',
            Argument::type(LookupRequest::class),
            Argument::cetera()
        )->shouldBeCalled()->willReturn(['found' => $data['entities']]);

        $this->operation->___setProperty('requestHandler', $this->requestHandler->reveal());

        $res = $this->operation->lookup($keys, [
            'sort' => true,
        ]);

        $found = $res['found'];

        foreach ($data['keys'] as $i => $key) {
            $this->assertEquals($key['path'][0]['id'], $found[$i]->key()->path()[0]['id']);
        }
    }

    public function testLookupWithoutSort()
    {
        $data = json_decode(file_get_contents(Fixtures::ENTITY_LOOKUP_BIGSORT_FIXTURE()), true);

        $keys = [];
        foreach ($data['keys'] as $key) {
            $keys[] = new Key('test-project', [
                'path' => $key['path'],
            ]);
        }

        $this->requestHandler->sendRequest(
            V1DatastoreClient::class,
            'lookup',
            Argument::type(LookupRequest::class),
            Argument::cetera()
        )->shouldBeCalled()->willReturn([
            'found' => $data['entities'],
            'missing' => $data['missing'],
        ]);
        $this->operation->___setProperty('requestHandler', $this->requestHandler->reveal());

        $res = $this->operation->lookup($keys);

        $found = $res['found'];

        foreach ($data['entities'] as $i => $e) {
            $this->assertEquals($e['entity']['key']['path'][0]['id'], $found[$i]->key()->path()[0]['id']);
        }
    }

    public function testLookupWithSortAndMissingKey()
    {
        $data = json_decode(file_get_contents(Fixtures::ENTITY_LOOKUP_BIGSORT_FIXTURE()), true);

        // Move an entity to missing.
        $missing = $data['entities'][5];
        $data['missing'][] = $missing;
        unset($data['entities'][5]);

        $keys = [];
        foreach ($data['keys'] as $key) {
            $keys[] = new Key('test-project', [
                'path' => $key['path'],
            ]);
        }

        $this->requestHandler->sendRequest(
            V1DatastoreClient::class,
            'lookup',
            Argument::type(LookupRequest::class),
            Argument::cetera()
        )->shouldBeCalled()->willReturn(['found' => $data['entities'],]);

        $this->operation->___setProperty('requestHandler', $this->requestHandler->reveal());

        $res = $this->operation->lookup($keys, [
            'sort' => true,
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

    public function testLookupInvalidKey()
    {
        $this->expectException(InvalidArgumentException::class);

        $key = $this->operation->key('Foo');

        $this->operation->lookup([$key]);
    }

    public function testRunQuery()
    {
        $queryResult = json_decode(file_get_contents(Fixtures::QUERY_RESULTS_FIXTURE()), true);

        $this->requestHandler->sendRequest(
            V1DatastoreClient::class,
            'runQuery',
            Argument::type(RunQueryRequest::class),
            Argument::cetera()
        )->shouldBeCalled()->willReturn($queryResult['notPaged']);

        $this->operation->___setProperty('requestHandler', $this->requestHandler->reveal());

        $q = $this->prophesize(QueryInterface::class);
        $q->queryKey()->shouldBeCalled()->willReturn('query');
        $q->queryObject()->shouldBeCalled()->willReturn([]);
        $q->canPaginate()->willReturn(true);
        $q->start(Argument::any());

        $res = $this->operation->runQuery($q->reveal());

        $this->assertInstanceOf(EntityIterator::class, $res);

        $arr = iterator_to_array($res);
        $this->assertCount(2, $arr);
        $this->assertInstanceOf(Entity::class, $arr[0]);
    }

    /**
     * @dataProvider queries
     */
    public function testRunQueryPaged($query)
    {
        $queryResult = json_decode(file_get_contents(Fixtures::QUERY_RESULTS_FIXTURE()), true);

        $outerThis = $this;
        $this->requestHandler->sendRequest(
            V1DatastoreClient::class,
            'runQuery',
            Argument::cetera()
        )->will(function ($args, $mock) use ($queryResult, $outerThis) {
                // The 2nd call will return the 2nd page of results!
                $mock->sendRequest(
                    V1DatastoreClient::class,
                    'runQuery',
                    Argument::that(function ($arg) use ($queryResult, $outerThis) {
                        $data = $outerThis->getSerializer()->encodeMessage($arg);
                        return $data['query']['startCursor'] == $queryResult['paged'][0]['batch']['endCursor'];
                    }),
                    Argument::any()
                )->willReturn($queryResult['paged'][1]);
                return $queryResult['paged'][0];
        });

        $this->operation->___setProperty('requestHandler', $this->requestHandler->reveal());

        $res = $this->operation->runQuery($query);

        $this->assertInstanceOf(EntityIterator::class, $res);

        $arr = iterator_to_array($res);
        $this->assertCount(3, $arr);
        $this->assertInstanceOf(Entity::class, $arr[0]);
    }

    public function queries()
    {
        $em = $this->prophesize(EntityMapper::class);
        $query = new Query($em->reveal());
        $gql = new GqlQuery($em->reveal(), 'SELECT 1');
        return [
            [$query],
            [$gql],
        ];
    }

    public function testRunQueryNoResults()
    {
        $queryResult = json_decode(file_get_contents(Fixtures::QUERY_RESULTS_FIXTURE()), true);
        $this->requestHandler->sendRequest(
            V1DatastoreClient::class,
            'runQuery',
            Argument::type(RunQueryRequest::class),
            Argument::cetera()
        )->shouldBeCalled()->willReturn($queryResult['noResults']);

        $this->operation->___setProperty('requestHandler', $this->requestHandler->reveal());

        $q = $this->prophesize(QueryInterface::class);
        $q->queryKey()->shouldBeCalled()->willReturn('query');
        $q->queryObject()->shouldBeCalled()->willReturn([]);
        $q->canPaginate()->shouldBeCalled()->willReturn(false);

        $res = $this->operation->runQuery($q->reveal());

        $this->assertInstanceOf(EntityIterator::class, $res);

        $arr = iterator_to_array($res);
        $this->assertCount(0, $arr);
    }

    public function testRunQueryWithReadOptionsFromTransaction()
    {
        $this->requestHandler->sendRequest(
            V1DatastoreClient::class,
            'runQuery',
            Argument::type(RunQueryRequest::class),
            Argument::cetera()
        )->shouldBeCalled()->willReturn([]);

        $this->operation->___setProperty('requestHandler', $this->requestHandler->reveal());

        $q = $this->prophesize(QueryInterface::class);
        $q->queryKey()->willReturn('query');
        $q->queryObject()->willReturn([]);

        $res = $this->operation->runQuery($q->reveal(), ['transaction' => 'foo']);
        iterator_to_array($res);
    }

    public function testRunQueryWithReadOptionsFromReadConsistency()
    {
        $this->requestHandler->sendRequest(
            V1DatastoreClient::class,
            'runQuery',
            Argument::type(RunQueryRequest::class),
            Argument::cetera()
        )->shouldBeCalled()->willReturn([]);

        $this->operation->___setProperty('requestHandler', $this->requestHandler->reveal());

        $q = $this->prophesize(QueryInterface::class);
        $q->queryKey()->willReturn('query');
        $q->queryObject()->willReturn([]);

        $res = $this->operation->runQuery($q->reveal(), ['readConsistency' => 123]);
        iterator_to_array($res);
    }

    public function testRunQueryWithoutReadOptions()
    {
        $this->requestHandler->sendRequest(
            V1DatastoreClient::class,
            'runQuery',
            Argument::that(function ($req) {
                return !$req->hasReadOptions();
            }),
            Argument::cetera()
        )->willReturn([])->shouldBeCalled();

        $this->operation->___setProperty('requestHandler', $this->requestHandler->reveal());

        $q = $this->prophesize(QueryInterface::class);
        $q->queryKey()->willReturn('query');
        $q->queryObject()->willReturn([]);

        $res = $this->operation->runQuery($q->reveal());
        iterator_to_array($res);
    }

    public function testRunQueryWithDatabaseIdOverride()
    {
        $this->requestHandler->sendRequest(
            V1DatastoreClient::class,
            'runQuery',
            Argument::that(function ($req) {
                $data = $this->getSerializer()->encodeMessage($req);
                return $data['databaseId'] == 'otherDatabaseId';
            }),
            Argument::cetera()
        )->shouldBeCalledTimes(1)->willReturn([]);

        $mapper = new EntityMapper('foo', true, false);
        $query = new Query($mapper);

        $iterator = $this->operation->runQuery(
            $query,
            ['databaseId' => 'otherDatabaseId']
        );
        $res = iterator_to_array($iterator);
    }

    public function testCommit()
    {
        $this->requestHandler->sendRequest(
            V1DatastoreClient::class,
            'commit',
            Argument::that(function ($req) {
                $data = $this->getSerializer()->encodeMessage($req);
                return $data['mode'] == Mode::NON_TRANSACTIONAL;
            }),
            Argument::cetera()
        )->shouldBeCalled()->willReturn(['foo']);

        $this->operation->___setProperty('requestHandler', $this->requestHandler->reveal());

        $this->assertEquals(['foo'], $this->operation->commit([]));
    }

    public function testCommitInTransaction()
    {
        $this->requestHandler->sendRequest(
            V1DatastoreClient::class,
            'commit',
            Argument::that(function ($req) {
                $data = $this->getSerializer()->encodeMessage($req);
                return $data['mode'] == Mode::TRANSACTIONAL;
            }),
            Argument::cetera()
        )->shouldBeCalled()->willReturn(['foo']);

        $this->operation->___setProperty('requestHandler', $this->requestHandler->reveal());

        $this->operation->commit([], [
            'transaction' => '1234',
        ]);
    }

    public function testCommitWithMutation()
    {
        $this->requestHandler->sendRequest(
            V1DatastoreClient::class,
            'commit',
            Argument::that(fn ($arg) => (count($arg->getMutations()) == 1)),
            Argument::any()
        )->shouldBeCalled()->willReturn(['foo']);

        $this->operation->___setProperty('requestHandler', $this->requestHandler->reveal());

        $key = $this->operation->key('Person');
        $e = new Entity($key);

        $mutation = $this->operation->mutation('insert', $e, Entity::class, null);

        $this->operation->commit([$mutation]);
    }

    public function testCommitWithDatabaseIdOverride()
    {
        $this->requestHandler->sendRequest(
            V1DatastoreClient::class,
            'commit',
            Argument::that(function ($req) {
                $data = $this->getSerializer()->encodeMessage($req);
                return $data['databaseId'] == 'otherDatabaseId';
            }),
            Argument::cetera()
        )->shouldBeCalledTimes(1)->willReturn([]);

        $this->operation->commit(
            [],
            ['databaseId' => 'otherDatabaseId']
        );
    }

    public function testRollback()
    {
        $this->requestHandler->sendRequest(
            V1DatastoreClient::class,
            'rollback',
            Argument::that(function ($req) {
                $data = $this->getSerializer()->encodeMessage($req);
                return $data['projectId'] == self::PROJECT
                    && $data['transaction'] == 'bar';
            }),
            Argument::cetera()
        )->shouldBeCalled()->willReturn(null);

        $this->operation->___setProperty('requestHandler', $this->requestHandler->reveal());

        $this->operation->rollback('bar');
    }

    public function testAllocateIdsToEntities()
    {
        $completeKey = $this->operation->key('Foo', 'Bar');
        $partialKey = $this->operation->key('Foo');

        $id = 12345;
        $keyWithId = clone $partialKey;
        $keyWithId->setLastElementIdentifier($id);

        $this->requestHandler->sendRequest(
            V1DatastoreClient::class,
            'allocateIds',
            Argument::that(function ($req) use ($partialKey) {
                $data = $this->getSerializer()->encodeMessage($req);
                return array_replace_recursive($data['keys'], [$partialKey->keyObject()]) == $data['keys'];
            }),
            Argument::cetera()
        )->shouldBeCalled()->willReturn(['keys' => [$keyWithId->keyObject()]]);

        $this->operation->___setProperty('requestHandler', $this->requestHandler->reveal());

        $entities = [
            $this->operation->entity($completeKey),
            $this->operation->entity($partialKey),
        ];

        $res = $this->operation->allocateIdsToEntities($entities);

        $this->assertInstanceOf(Entity::class, $res[0]);
        $this->assertInstanceOf(Entity::class, $res[1]);

        $this->assertEquals($res[0]->key()->state(), Key::STATE_NAMED);
        $this->assertEquals($res[1]->key()->state(), Key::STATE_NAMED);
    }

    public function testMutate()
    {
        $id = 12345;

        $this->requestHandler->sendRequest(
            V1DatastoreClient::class,
            'commit',
            Argument::that(
                fn ($arg) => (count($arg->getMutations()) == 1 && $arg->getMutations()[0]->hasInsert())
            ),
            Argument::any()
        )->shouldBeCalled();

        $this->operation->___setProperty('requestHandler', $this->requestHandler->reveal());

        $key = $this->operation->key('Person', $id);
        $e = new Entity($key);

        $mutation = $this->operation->mutation('insert', $e, Entity::class, null);
        $this->operation->commit([$mutation]);
    }

    public function testMutateWithBaseVersion()
    {
        $this->requestHandler->sendRequest(
            V1DatastoreClient::class,
            'commit',
            Argument::that(function ($req) {
                $data = $this->getSerializer()->encodeMessage($req);
                return array_replace_recursive($data['mutations'], [['baseVersion' => 1]])
                    == $data['mutations'];
            }),
            Argument::cetera()
        )->shouldBeCalled()->willReturn('foo');

        $this->operation->___setProperty('requestHandler', $this->requestHandler->reveal());

        $key = $this->prophesize(Key::class);
        $e = new Entity($key->reveal(), [], [
            'baseVersion' => 1,
        ]);

        $mutation = $this->operation->mutation('insert', $e, Entity::class);
        $ret = $this->operation->commit([$mutation]);
        $this->assertEquals('foo', $ret);
    }

    public function testMutateWithKey()
    {
        $this->requestHandler->sendRequest(
            V1DatastoreClient::class,
            'commit',
            Argument::that(function ($arg) {
                $data = $this->getSerializer()->encodeMessage($arg);
                $x = isset($data['mutations'][0]['delete']['path']);
                return isset($data['mutations'][0]['delete']['path']);
            }),
            Argument::any()
        )->shouldBeCalled()->willReturn('foo');

        $this->operation->___setProperty('requestHandler', $this->requestHandler->reveal());

        $key = new Key('foo', [
            'path' => [['kind' => 'foo', 'id' => 1]],
        ]);

        $mutation = $this->operation->mutation('delete', $key, Key::class);
        $ret = $this->operation->commit([$mutation]);
        $this->assertEquals('foo', $ret);
    }

    public function testMutateInvalidType()
    {
        $this->expectException(InvalidArgumentException::class);

        $this->operation->mutation('foo', (object) [], \stdClass::class);
    }

    public function testCheckOverwrite()
    {
        $e = $this->prophesize(Entity::class);
        $e->populatedByService()->willReturn(true)->shouldBeCalled();

        $this->operation->checkOverwrite([$e->reveal()]);
    }

    public function testCheckOverwriteWithFlagEnabled()
    {
        $e = $this->prophesize(Entity::class);
        $e->populatedByService()->willReturn(false)->shouldBeCalled();

        $this->operation->checkOverwrite([$e->reveal()], true);
    }

    public function testCheckOverwriteWithException()
    {
        $this->expectException(InvalidArgumentException::class);

        $e = $this->prophesize(Entity::class);
        $e->populatedByService()->willReturn(false);
        $e->key()->willReturn('foo');

        $this->operation->checkOverwrite([$e->reveal()]);
    }

    public function testMapEntityResult()
    {
        $res = json_decode(file_get_contents(Fixtures::ENTITY_RESULT_FIXTURE()), true);

        $this->requestHandler->sendRequest(
            V1DatastoreClient::class,
            'lookup',
            Argument::type(LookupRequest::class),
            Argument::cetera()
        )->shouldBeCalled()->willReturn(['found' => $res,]);

        $this->operation->___setProperty('requestHandler', $this->requestHandler->reveal());

        $key = $this->operation->key('Person', 12345);

        $entity = $this->operation->lookup([$key]);
        $this->assertInstanceOf(Entity::class, $entity['found'][0]);

        $this->assertEquals($entity['found'][0]->baseVersion(), $res[0]['version']);
        $this->assertEquals($entity['found'][0]->cursor(), $res[0]['cursor']);
        $this->assertEquals($entity['found'][0]->prop, $res[0]['entity']['properties']['prop']['stringValue']);
    }

    public function testMapEntityResultWithoutProperties()
    {
        $res = json_decode(file_get_contents(Fixtures::ENTITY_RESULT_NO_PROPERTIES_FIXTURE()), true);

        $this->requestHandler->sendRequest(
            V1DatastoreClient::class,
            'lookup',
            Argument::type(LookupRequest::class),
            Argument::cetera()
        )->shouldBeCalled()->willReturn(['found' => $res,]);

        $this->operation->___setProperty('requestHandler', $this->requestHandler->reveal());

        $key = $this->operation->key('Person', 12345);

        $entity = $this->operation->lookup([$key]);
        $this->assertInstanceOf(Entity::class, $entity['found'][0]);

        $this->assertEquals($entity['found'][0]->baseVersion(), $res[0]['version']);
        $this->assertEquals($entity['found'][0]->cursor(), $res[0]['cursor']);
    }

    public function testMapEntityResultArrayOfClassNames()
    {
        $res = json_decode(file_get_contents(Fixtures::ENTITY_RESULT_FIXTURE()), true);

        $this->requestHandler->sendRequest(
            V1DatastoreClient::class,
            'lookup',
            Argument::type(LookupRequest::class),
            Argument::cetera()
        )->shouldBeCalled()->willReturn(['found' => $res,]);

        $this->operation->___setProperty('requestHandler', $this->requestHandler->reveal());

        $key = $this->operation->key('Person', 12345);

        $entity = $this->operation->lookup([$key], [
            'className' => [
                'Kind' => SampleEntity::class,
            ],
        ]);

        $this->assertInstanceOf(SampleEntity::class, $entity['found'][0]);
    }

    public function testMapEntityResultArrayOfClassNamesMissingKindMapItem()
    {
        $this->expectException(InvalidArgumentException::class);

        $res = json_decode(file_get_contents(Fixtures::ENTITY_RESULT_FIXTURE()), true);

        $this->requestHandler->sendRequest(
            V1DatastoreClient::class,
            'lookup',
            Argument::type(LookupRequest::class),
            Argument::cetera()
        )->shouldBeCalled()->willReturn(['found' => $res,]);

        $this->operation->___setProperty('requestHandler', $this->requestHandler->reveal());

        $key = $this->operation->key('Person', 12345);

        $entity = $this->operation->lookup([$key], [
            'className' => [
                'Kind2' => SampleEntity::class,
            ],
        ]);
    }

    public function testTransactionInReadOptions()
    {
        $this->requestHandler->sendRequest(
            V1DatastoreClient::class,
            'lookup',
            Argument::that(function ($req) {
                $data = $this->getSerializer()->encodeMessage($req);
                return $data['readOptions']['transaction'] == '1234';
            }),
            Argument::cetera()
        )->shouldBeCalled()->willReturn([]);

        $this->operation->___setProperty('requestHandler', $this->requestHandler->reveal());

        $key = $this->operation->key('Person', 12345);
        $this->operation->lookup([$key], [
            'transaction' => '1234',
        ]);
    }

    public function testNonTransactionalReadOptions()
    {
        $this->requestHandler->sendRequest(
            Argument::any(),
            Argument::any(),
            Argument::that(function (LookupRequest $arg) {
                return (!$arg->hasReadOptions()) || (!$arg->getReadOptions()->hasTransaction());
            }),
            Argument::cetera()
        )->shouldBeCalled()->willReturn([]);
        $this->operation->___setProperty('requestHandler', $this->requestHandler->reveal());

        $key = $this->operation->key('Person', 12345);
        $this->operation->lookup([$key]);
    }

    public function testReadConsistencyInReadOptions()
    {
        $this->requestHandler->sendRequest(
            V1DatastoreClient::class,
            'lookup',
            Argument::that(function ($req) {
                $data = $this->getSerializer()->encodeMessage($req);
                return $data['readOptions']['readConsistency'] == 123;
            }),
            Argument::cetera()
        )->shouldBeCalled()->willReturn([]);

        $this->operation->___setProperty('requestHandler', $this->requestHandler->reveal());

        $key = $this->operation->key('Person', 12345);
        $this->operation->lookup([$key], [
            'readConsistency' => 123,
        ]);
    }

    public function testInvalidBatchType()
    {
        $this->expectException(InvalidArgumentException::class);

        $this->operation->lookup(['foo']);
    }

    public function testBeginTransactionWithDatabaseIdOverride()
    {
        $this->requestHandler->sendRequest(
            V1DatastoreClient::class,
            'beginTransaction',
            Argument::that(function ($req) {
                $data = $this->getSerializer()->encodeMessage($req);
                return $data['databaseId'] == 'otherDatabaseId';
            }),
            Argument::cetera()
        )->shouldBeCalled()->willReturn(['transaction' => 'valid_test_transaction']);

        $transactionId = $this->operation->beginTransaction(
            [],
            ['databaseId' => 'otherDatabaseId']
        );

        $this->assertEquals('valid_test_transaction', $transactionId);
    }

    public function testAllocateIdsWithDatabaseIdOverride()
    {
        $this->requestHandler->sendRequest(
            V1DatastoreClient::class,
            'allocateIds',
            Argument::that(function ($req) {
                $data = $this->getSerializer()->encodeMessage($req);
                return $data['databaseId'] == 'otherDatabaseId';
            }),
            Argument::cetera()
        )->shouldBeCalledTimes(1)->willReturn([]);

        $this->operation->___setProperty('requestHandler', $this->requestHandler->reveal());

        $this->operation->allocateIds(
            [],
            ['databaseId' => 'otherDatabaseId']
        );
    }

    public function testLookupWithDatabaseIdOverride()
    {
        $this->requestHandler->sendRequest(
            V1DatastoreClient::class,
            'lookup',
            Argument::that(function ($req) {
                $data = $this->getSerializer()->encodeMessage($req);
                return $data['databaseId'] == 'otherDatabaseId';
            }),
            Argument::cetera()
        )->shouldBeCalledTimes(1)->willReturn([]);

        $this->operation->lookup(
            [],
            ['databaseId' => 'otherDatabaseId']
        );
    }
}

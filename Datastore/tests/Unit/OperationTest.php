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

use Google\ApiCore\ApiException;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Core\Timestamp;
use Google\Cloud\Core\Exception\FailedPreconditionException;
use Google\Cloud\Datastore\Entity;
use Google\Cloud\Datastore\EntityIterator;
use Google\Cloud\Datastore\EntityMapper;
use Google\Cloud\Datastore\Key;
use Google\Cloud\Datastore\Operation;
use Google\Cloud\Datastore\Query\GqlQuery;
use Google\Cloud\Datastore\Query\Query;
use Google\Cloud\Datastore\Query\QueryInterface;
use Google\Cloud\Datastore\V1\AllocateIdsRequest;
use Google\Cloud\Datastore\V1\AllocateIdsResponse;
use Google\Cloud\Datastore\V1\BeginTransactionRequest;
use Google\Cloud\Datastore\V1\BeginTransactionResponse;
use Google\Cloud\Datastore\V1\Client\DatastoreClient;
use Google\Cloud\Datastore\V1\CommitRequest;
use Google\Cloud\Datastore\V1\CommitRequest\Mode;
use Google\Cloud\Datastore\V1\CommitResponse;
use Google\Cloud\Datastore\V1\Key as V1Key;
use Google\Cloud\Datastore\V1\LookupRequest;
use Google\Cloud\Datastore\V1\LookupResponse;
use Google\Cloud\Datastore\V1\MutationResult;
use Google\Cloud\Datastore\V1\ReadOptions\ReadConsistency;
use Google\Cloud\Datastore\V1\RollbackRequest;
use Google\Cloud\Datastore\V1\RollbackResponse;
use Google\Cloud\Datastore\V1\RunQueryRequest;
use Google\Cloud\Datastore\V1\RunQueryResponse;
use Google\Protobuf\Timestamp as ProtobufTimestamp;
use Google\Rpc\Code;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use TypeError;

/**
 * @group datastore
 * @group datastore-operation
 */
class OperationTest extends TestCase
{
    use ProphecyTrait;
    use ProtoEncodeTrait;

    const PROJECT = 'example-project';
    const NAMESPACEID = 'namespace-id';
    const DATABASEID = 'database-id';

    private $operation;
    private $gapicClient;

    public function setUp(): void
    {
        $this->gapicClient = $this->prophesize(DatastoreClient::class);
        $this->operation = TestHelpers::stub(Operation::class, [
            $this->gapicClient->reveal(),
            self::PROJECT,
            self::NAMESPACEID,
            new EntityMapper('foo', true, false),
            self::DATABASEID,
        ], ['gapicClient', 'namespaceId']);
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

        $responseData = [
            'keys' => [
                $keyWithId->keyObject(),
            ],
        ];

        $this->gapicClient->allocateIds(Argument::type(AllocateIdsRequest::class), Argument::any())
            ->shouldBeCalled()
            ->willReturn(self::generateProto(AllocateIdsResponse::class, $responseData));

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

        $this->gapicClient->lookup(Argument::type(LookupRequest::class), Argument::any())
            ->shouldBeCalled()
            ->willReturn(new LookupResponse());

        $res = $this->operation->lookup([$key]);

        $this->assertIsArray($res);
    }

    public function testLookupFound()
    {
        $body = json_decode(file_get_contents(Fixtures::ENTITY_BATCH_LOOKUP_FIXTURE()), true);

        $responseData = [
            'found' => $body,
        ];

        $this->gapicClient->lookup(Argument::any(), Argument::any())
            ->willReturn(self::generateProto(LookupResponse::class, $responseData));

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
        $this->gapicClient->lookup(Argument::any(), Argument::any())->willReturn(
            self::generateProto(LookupResponse::class, ['missing' => $body])
        );

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
        $this->gapicClient->lookup(Argument::any(), Argument::any())
            ->willReturn(self::generateProto(LookupResponse::class, [
                'deferred' => [$body[0]['entity']['key']],
            ]));

        $key = $this->operation->key('Kind', 'ID');

        $res = $this->operation->lookup([$key]);

        $this->assertIsArray($res);
        $this->assertTrue(isset($res['deferred']) && is_array($res['deferred']));
        $this->assertInstanceOf(Key::class, $res['deferred'][0]);
    }

    public function testLookupWithReadOptionsFromTransaction()
    {
        $this->gapicClient->lookup(Argument::type(LookupRequest::class), Argument::any())
            ->shouldBeCalled()
            ->willReturn(self::generateProto(LookupResponse::class, []));

        $k = new Key('test-project', [
            'path' => [['kind' => 'kind', 'id' => '123']],
        ]);

        $this->operation->lookup([$k], ['transaction' => 'foo']);
    }

    public function testLookupWithReadOptionsFromReadConsistency()
    {
        $this->gapicClient->lookup(Argument::that(function (LookupRequest $request) {
            return $request->getReadOptions()->getReadConsistency() === ReadConsistency::STRONG;
        }), Argument::any())
            ->shouldBeCalled()
            ->willReturn(self::generateProto(LookupResponse::class, []));

        $k = new Key('test-project', [
            'path' => [['kind' => 'kind', 'id' => '123']],
        ]);

        $this->operation->lookup([$k], ['readConsistency' => ReadConsistency::STRONG]);
    }

    public function testLookupWithoutReadOptions()
    {
        $this->gapicClient->lookup(Argument::that(function (LookupRequest $request) {
            return is_null($request->getReadOptions());
        }), Argument::any())->shouldBeCalled()->willReturn(self::generateProto(LookupResponse::class, []));

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

        $this->gapicClient->lookup(Argument::any(), Argument::any())
            ->willReturn(self::generateProto(LookupResponse::class, [
                'found' => $data['entities'],
            ]));

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

        $this->gapicClient->lookup(Argument::any(), Argument::any())
            ->willReturn(self::generateProto(LookupResponse::class, [
                'found' => $data['entities'],
                'missing' => $data['missing'],
            ]));

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

        $this->gapicClient->lookup(Argument::any(), Argument::any())
            ->willReturn(self::generateProto(LookupResponse::class, [
                'found' => $data['entities'],
            ]));

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
        $this->gapicClient->runQuery(Argument::type(RunQueryRequest::class), Argument::any())
            ->willReturn(self::generateProto(RunQueryResponse::class, $queryResult['notPaged']));

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
    // public function testRunQueryPaged($query)
    // {
    //     $queryResult = json_decode(file_get_contents(Fixtures::QUERY_RESULTS_FIXTURE()), true);
    //     $this->gapicClient->runQuery(Argument::type(RunQueryRequest::class), Argument::any())
    //         ->will(function ($args, $mock) use ($queryResult) {
    //             // The 2nd call will return the 2nd page of results!
    //             $mock->runQuery(Argument::that(function ($arg) use ($queryResult) {
    //                 return $arg['query']['startCursor'] === $queryResult['paged'][0]['batch']['endCursor'];
    //             }))->willReturn($queryResult['paged'][1]);

    //             return $queryResult['paged'][0];
    //         });

    //     $this->operation->___setProperty('gapicClient', $this->gapicClient->reveal());

    //     $res = $this->operation->runQuery($query);

    //     $this->assertInstanceOf(EntityIterator::class, $res);

    //     $arr = iterator_to_array($res);
    //     $this->assertCount(3, $arr);
    //     $this->assertInstanceOf(Entity::class, $arr[0]);
    // }

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
        $this->gapicClient->runQuery(Argument::type(RunQueryRequest::class), Argument::any())
            ->willReturn(self::generateProto(RunQueryResponse::class, $queryResult['noResults']));

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
        $this->gapicClient->runQuery(Argument::that(function (RunQueryRequest $request) {
            return !is_null($request->getReadOptions());
        }), Argument::any())->willReturn(self::generateProto(RunQueryResponse::class, []))
            ->shouldBeCalled()
            ->willReturn(self::generateProto(RunQueryResponse::class, []));

        $q = $this->prophesize(QueryInterface::class);
        $q->queryKey()->willReturn('query');
        $q->queryObject()->willReturn([]);

        $res = $this->operation->runQuery($q->reveal(), ['transaction' => 'foo']);
        iterator_to_array($res);
    }

    public function testRunQueryWithReadOptionsFromReadConsistency()
    {
        $this->gapicClient->runQuery(Argument::that(function (RunQueryRequest $request) {
            return !is_null($request->getReadOptions()->getReadConsistency());
        }), Argument::any())->willReturn(self::generateProto(RunQueryResponse::class, []))
            ->shouldBeCalled()
            ->willReturn(self::generateProto(RunQueryResponse::class, []));

        $q = $this->prophesize(QueryInterface::class);
        $q->queryKey()->willReturn('query');
        $q->queryObject()->willReturn([]);

        $res = $this->operation->runQuery($q->reveal(), ['readConsistency' => ReadConsistency::STRONG]);
        iterator_to_array($res);
    }

    public function testRunQueryWithoutReadOptions()
    {
        $this->gapicClient->runQuery(Argument::that(function (RunQueryRequest $request) {
            return is_null($request->getReadOptions());
        }), Argument::any())->willReturn(self::generateProto(RunQueryResponse::class, []))
            ->shouldBeCalled()
            ->willReturn(self::generateProto(RunQueryResponse::class, []));

        $q = $this->prophesize(QueryInterface::class);
        $q->queryKey()->willReturn('query');
        $q->queryObject()->willReturn([]);

        $res = $this->operation->runQuery($q->reveal());
        iterator_to_array($res);
    }

    public function testRunQueryWithDatabaseIdOverride()
    {
        $this->gapicClient
            ->runQuery(Argument::that(function (RunQueryRequest $request) {
                $this->assertEquals('otherDatabaseId', $request->getDatabaseId());
                return true;
            }), Argument::any())
            ->shouldBeCalledTimes(1)
            ->willReturn(self::generateProto(RunQueryResponse::class, []));

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
        $this->gapicClient->commit(Argument::that(function (CommitRequest $request) {
            return ($request->getMode() === Mode::NON_TRANSACTIONAL &&
                count($request->getMutations()) === 0);
        }), Argument::any())->shouldBeCalled()
            ->willReturn(self::generateProto(CommitResponse::class, []));

        $expectedResult = [
            'mutationResults' => [],
            'indexUpdates' => 0
        ];

        $this->assertEquals($expectedResult, $this->operation->commit([]));
    }

    public function testCommitInTransaction()
    {
        $this->gapicClient->commit(Argument::that(function (CommitRequest $request) {
            return ($request->getMode() === Mode::TRANSACTIONAL &&
                count($request->getMutations()) === 0);
        }), Argument::any())->shouldBeCalled()
            ->willReturn(self::generateProto(CommitResponse::class, []));

        $response = $this->operation->commit([], [
            'transaction' => '1234',
        ]);

        $expectedResult = [
            'mutationResults' => [],
            'indexUpdates' => 0
        ];

        $this->assertEquals($expectedResult, $response);
    }

    public function testCommitWithMutation()
    {
        $key = $this->operation->key('Person');
        $e = new Entity($key);

        $mutation = $this->operation->mutation('insert', $e, Entity::class, null);

        $allocatedKey = clone $key;
        $allocatedKey->setLastElementIdentifier('12345');

        $commitResponseData = [
            'mutationResults' => [
                [
                    'key' => $allocatedKey->keyObject(),
                    'version' => '1',
                    'conflictDetected' => false
                ]
            ],
            'indexUpdates' => 1
        ];

        $this->gapicClient->commit(Argument::that(function (CommitRequest $request) {
            return count($request->getMutations()) === 1;
        }), Argument::any())
            ->shouldBeCalled()
            ->willReturn(self::generateProto(CommitResponse::class, $commitResponseData));

        $res = $this->operation->commit([$mutation]);

        $this->assertIsArray($res);
        $this->assertEquals($commitResponseData['indexUpdates'], $res['indexUpdates']);
        $this->assertCount(1, $res['mutationResults']);
        $this->assertEquals('1', $res['mutationResults'][0]['version']);
    }

    public function testCommitWithDatabaseIdOverride()
    {
        $this->gapicClient
            ->commit(Argument::that(function (CommitRequest $request) {
                return $request->getDatabaseId() === 'otherDatabaseId';
            }), Argument::any())
            ->shouldBeCalledTimes(1)
            ->willReturn(self::generateProto(CommitResponse::class, []));

        $iterator = $this->operation->commit(
            [],
            ['databaseId' => 'otherDatabaseId']
        );
    }

    public function testRollback()
    {
        $rawTransactionId = 'testTransactionId';
        $decodedId = base64_decode($rawTransactionId);

        $this->gapicClient->rollback(Argument::that(function (RollbackRequest $request) use ($decodedId) {
            return $request->getProjectId() === self::PROJECT &&
                $request->getTransaction() === $decodedId;
        }), Argument::any())->shouldBeCalled()->willReturn(self::generateProto(RollbackResponse::class, []));

        $this->operation->rollback($rawTransactionId);
    }

    public function testAllocateIdsToEntities()
    {
        $completeKey = $this->operation->key('Foo', 'Bar');
        $partialKey = $this->operation->key('Foo');

        $id = 12345;
        $keyWithId = clone $partialKey;
        $keyWithId->setLastElementIdentifier($id);

        $this->gapicClient->allocateIds(Argument::that(function (AllocateIdsRequest $request) {
            return count($request->getKeys()) === 1;
        }), Argument::any())->shouldBeCalled()
            ->willReturn(self::generateProto(AllocateIdsResponse::class, [
                'keys' => [
                    $keyWithId->keyObject(),
                ],
            ]));

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
        $commitResponseData = [
            'mutationResults' => [
                [
                    'version' => 1,
                    'conflictDetected' => false,
                    'transformResults' => []
                ]
            ],
            'indexUpdates' => 1
        ];

        $this->gapicClient->commit(Argument::that(function (CommitRequest $request) {
            if (count($request->getMutations()) !== 1) {
                return false;
            }

            if (is_null($request->getMutations()[0]->getInsert())) {
                return false;
            }

            return true;
        }), Argument::any())
            ->shouldBeCalled()
            ->willReturn(self::generateProto(CommitResponse::class, $commitResponseData));

        $key = $this->operation->key('Person', $id);
        $e = new Entity($key);

        $mutation = $this->operation->mutation('insert', $e, Entity::class, null);
        $res = $this->operation->commit([$mutation]);

        $this->assertEquals($commitResponseData, $res);
    }


    public function testMutateWithBaseVersion()
    {
        $timestamp = new Timestamp(new \DateTime());
        $pTimestamp = new ProtobufTimestamp([
            'seconds' => $timestamp->get()->getTimestamp(),
            'nanos' => $timestamp->nanoSeconds()
        ]);
        $commitResponseData = [
            'mutationResults' => [
                [
                    'version' => 2,
                    'conflictDetected' => false,
                    'createTime' => $pTimestamp,
                    'updateTime' => $pTimestamp,
                    'transformResults' => [],
                ]
            ],
            'indexUpdates' => 1,
            'commitTime' => $pTimestamp,
        ];

        $this->gapicClient->commit(Argument::that(function (CommitRequest $request) {
            return $request->getMutations()[0]->getBaseVersion() === 1;
        }), Argument::any())->willReturn(self::generateProto(CommitResponse::class, $commitResponseData));

        $key = $this->operation->key('Person', 'Bob');
        $e = new Entity($key, [], [
            'baseVersion' => 1,
        ]);

        $mutation = $this->operation->mutation('insert', $e, Entity::class);
        $ret = $this->operation->commit([$mutation]);

        $expected = $commitResponseData;
        $encodedTimestamp = [
            'seconds' => $timestamp->get()->getTimestamp(),
            'nanos' => $timestamp->nanoSeconds()
        ];
        $expected['commitTime'] = $encodedTimestamp;
        $expected['mutationResults'][0]['createTime'] = $encodedTimestamp;
        $expected['mutationResults'][0]['updateTime'] = $encodedTimestamp;

        $this->assertEquals($expected, $ret);
    }

    public function testMutateWithKey()
    {
        $timestamp = new Timestamp(new \DateTime());
        $pTimestamp = new ProtobufTimestamp([
            'seconds' => $timestamp->get()->getTimestamp(),
            'nanos' => $timestamp->nanoSeconds()
        ]);
        $commitResponseData = [
            'mutationResults' => [
                [
                    // For a delete, the key is not returned, but a version is.
                    'version' => '2',
                    'conflictDetected' => false,
                    'transformResults' => [],
                ]
            ],
            'indexUpdates' => 1,
            'commitTime' => $pTimestamp,
        ];

        $this->gapicClient->commit(Argument::that(function (CommitRequest $request) {
            if (is_null($request->getMutations()[0]->getDelete())) {
                return false;
            }

            if (is_null($request->getMutations()[0]->getDelete()->getPath(0))) {
                return false;
            }

            return true;
        }), Argument::any())->willReturn(self::generateProto(CommitResponse::class, $commitResponseData));

        $key = new Key('foo', [
            'path' => [['kind' => 'foo', 'id' => 1]],
        ]);

        $mutation = $this->operation->mutation('delete', $key, Key::class);
        $ret = $this->operation->commit([$mutation]);

        $expected = $commitResponseData;
        $encodedTimestamp = [
            'seconds' => $timestamp->get()->getTimestamp(),
            'nanos' => $timestamp->nanoSeconds()
        ];
        $expected['commitTime'] = $encodedTimestamp;
        $this->assertEquals($expected, $ret);
    }

    public function testMutateInvalidType()
    {
        $this->expectException(TypeError::class);

        $this->operation->mutation('foo', new \stdClass(), \stdClass::class);
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
        $e->key()->willReturn(new Key('foo'));

        $this->operation->checkOverwrite([$e->reveal()]);
    }

    public function testMapEntityResultFromLookup()
    {
        $res = json_decode(file_get_contents(Fixtures::ENTITY_RESULT_FIXTURE()), true);
        // Cursors are not returned on lookups, so remove it from the test fixture.
        unset($res[0]['cursor']);

        $this->gapicClient->lookup(Argument::type(LookupRequest::class), Argument::any())
            ->willReturn(self::generateProto(LookupResponse::class, [
                'found' => $res,
            ]));

        $key = $this->operation->key('Person', 12345);

        $entity = $this->operation->lookup([$key]);
        $this->assertInstanceOf(Entity::class, $entity['found'][0]);

        $this->assertEquals($entity['found'][0]->baseVersion(), $res[0]['version']);
        $this->assertNull($entity['found'][0]->cursor());
        $this->assertEquals($entity['found'][0]->prop, $res[0]['entity']['properties']['prop']['stringValue']);
    }

    public function testMapEntityResultFromQuery()
    {
        $res = json_decode(file_get_contents(Fixtures::ENTITY_RESULT_FIXTURE()), true);

        $this->gapicClient->runQuery(Argument::type(RunQueryRequest::class), Argument::any())
            ->willReturn(self::generateProto(RunQueryResponse::class, [
                'batch' => ['entityResults' => $res]
            ]));

        $query = $this->prophesize(QueryInterface::class);
        $query->queryKey()->willReturn('query');
        $query->queryObject()->willReturn([]);
        $query->canPaginate()->willReturn(true);

        $entities = iterator_to_array($this->operation->runQuery($query->reveal()));

        $this->assertEquals($entities[0]->baseVersion(), $res[0]['version']);
        $this->assertEquals($res[0]['cursor'], $entities[0]->cursor());
        $this->assertEquals($entities[0]->prop, $res[0]['entity']['properties']['prop']['stringValue']);
    }

    public function testMapEntityResultWithoutProperties()
    {
        $res = json_decode(file_get_contents(Fixtures::ENTITY_RESULT_NO_PROPERTIES_FIXTURE()), true);
        // Cursors are not returned on lookups, so remove it from the test fixture.
        unset($res[0]['cursor']);

        $this->gapicClient->lookup(Argument::type(LookupRequest::class), Argument::any())
            ->willReturn(self::generateProto(LookupResponse::class, [
                'found' => $res,
            ]));

        $key = $this->operation->key('Person', 12345);

        $entity = $this->operation->lookup([$key]);
        $this->assertInstanceOf(Entity::class, $entity['found'][0]);

        $this->assertEquals($entity['found'][0]->baseVersion(), $res[0]['version']);
        $this->assertNull($entity['found'][0]->cursor());
    }

    public function testMapEntityResultArrayOfClassNames()
    {
        $res = json_decode(file_get_contents(Fixtures::ENTITY_RESULT_FIXTURE()), true);

        $this->gapicClient->lookup(Argument::type(LookupRequest::class), Argument::any())
            ->willReturn(self::generateProto(LookupResponse::class, [
                'found' => $res,
            ]));

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

        $this->gapicClient->lookup(Argument::type(LookupRequest::class), Argument::any())
            ->willReturn(self::generateProto(LookupResponse::class, [
                'found' => $res,
            ]));

        $key = $this->operation->key('Person', 12345);

        $entity = $this->operation->lookup([$key], [
            'className' => [
                'Kind2' => SampleEntity::class,
            ],
        ]);
    }

    public function testTransactionInReadOptions()
    {
        $this->gapicClient->lookup(Argument::that(function (LookupRequest $request) {
            return !is_null($request->getReadOptions()->getTransaction());
        }), Argument::any())
            ->willReturn(self::generateProto(LookupResponse::class, []))
            ->shouldBeCalled();

        $key = $this->operation->key('Person', 12345);
        $this->operation->lookup([$key], [
            'transaction' => '1234',
        ]);
    }

    public function testNonTransactionalReadOptions()
    {
        $this->gapicClient->lookup(Argument::that(function (LookupRequest $request) {
            return is_null($request->getReadOptions());
        }), Argument::any())
            ->willReturn(self::generateProto(LookupResponse::class, []))
            ->shouldBeCalled();

        $key = $this->operation->key('Person', 12345);
        $this->operation->lookup([$key]);
    }

    public function testReadConsistencyInReadOptions()
    {
        $this->gapicClient->lookup(Argument::that(function (LookupRequest $request) {
            return $request->getReadOptions()->getReadConsistency() === ReadConsistency::STRONG;
        }), Argument::any())->shouldBeCalled()
            ->willReturn(self::generateProto(LookupResponse::class, []));

        $key = $this->operation->key('Person', 12345);
        $this->operation->lookup([$key], [
            'readConsistency' => ReadConsistency::STRONG,
        ]);
    }

    public function testInvalidBatchType()
    {
        $this->expectException(InvalidArgumentException::class);

        $this->operation->lookup(['foo']);
    }

    public function testBeginTransactionWithDatabaseIdOverride()
    {
        $rawTransactionId = 'valid_test_transaction';

        $this->gapicClient
            ->beginTransaction(
                Argument::that(function (BeginTransactionRequest $request) {
                    return $request->getDatabaseId() === 'otherDatabaseId';
                }),
                Argument::any()
            )
            ->willReturn(self::generateProto(BeginTransactionResponse::class, [
                'transaction' => base64_encode($rawTransactionId)
            ]));

        $transactionId = $this->operation->beginTransaction(
            [],
            ['databaseId' => 'otherDatabaseId']
        );

        $this->assertEquals(base64_encode($rawTransactionId), $transactionId);
    }

    public function testAllocateIdsWithDatabaseIdOverride()
    {
        $this->gapicClient
            ->allocateIds(
                Argument::that(function (AllocateIdsRequest $request) {
                    return $request->getDatabaseId() === 'otherDatabaseId';
                }),
                Argument::any()
            )
            ->shouldBeCalledTimes(1)
            ->willReturn(self::generateProto(AllocateIdsResponse::class, []));

        $this->operation->allocateIds(
            [],
            ['databaseId' => 'otherDatabaseId']
        );
    }

    public function testLookupWithDatabaseIdOverride()
    {
        $this->gapicClient
            ->lookup(
                Argument::that(function (LookupRequest $request) {
                    return $request->getDatabaseId() === 'otherDatabaseId';
                }),
                Argument::any()
            )
            ->shouldBeCalledTimes(1)
            ->willReturn(self::generateProto(LookupResponse::class, []));

        $this->operation->lookup(
            [],
            ['databaseId' => 'otherDatabaseId']
        );
    }

    public function testRunQueryApiExceptionConversion()
    {
        $this->expectException(FailedPreconditionException::class);
        $this->expectExceptionMessage('Test exception');

        $query = $this->prophesize(Query::class);
        $query->queryObject()->willReturn([]);
        $query->queryKey()->willReturn('query');

        $this->gapicClient->runQuery(
            Argument::type(RunQueryRequest::class),
            Argument::type('array')
        )->willThrow(new ApiException(
            'Test exception',
            Code::FAILED_PRECONDITION,
            'FAILED_PRECONDITION'
        ));

        $iterator = $this->operation->runQuery($query->reveal());
        // The exception is thrown when we iterate
        $iterator->current();
    }
}

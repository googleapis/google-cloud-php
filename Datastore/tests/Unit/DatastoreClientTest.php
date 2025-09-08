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

use DateTime;
use Google\ApiCore\Transport\TransportInterface;
use Google\Cloud\Core\Int64;
use Google\Cloud\Core\Testing\DatastoreOperationRefreshTrait;
use Google\Cloud\Core\Testing\GrpcTestTrait;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Core\Timestamp;
use Google\Cloud\Datastore\Blob;
use Google\Cloud\Datastore\DatastoreClient;
use Google\Cloud\Datastore\Entity;
use Google\Cloud\Datastore\EntityMapper;
use Google\Cloud\Datastore\GeoPoint;
use Google\Cloud\Datastore\Key;
use Google\Cloud\Datastore\Operation;
use Google\Cloud\Datastore\Query\AggregationQuery;
use Google\Cloud\Datastore\Query\AggregationQueryResult;
use Google\Cloud\Datastore\Query\GqlQuery;
use Google\Cloud\Datastore\Query\Query;
use Google\Cloud\Datastore\Query\QueryInterface;
use Google\Cloud\Datastore\ReadOnlyTransaction;
use Google\Cloud\Datastore\Transaction;
use Google\Cloud\Datastore\V1\ExplainOptions;
use Google\Cloud\Datastore\V1\Client\DatastoreClient as GapicClient;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Google\Cloud\Datastore\V1\CommitRequest;
use Google\Cloud\Datastore\V1\CommitResponse;
use Google\Cloud\Datastore\V1\Entity as V1Entity;
use Google\Cloud\Datastore\V1\EntityResult;
use Google\Cloud\Datastore\V1\LookupRequest;
use Google\Cloud\Datastore\V1\LookupResponse;
use Prophecy\PhpUnit\ProphecyTrait;
use DG\BypassFinals;
use Google\Cloud\Datastore\V1\AllocateIdsRequest;
use Google\Cloud\Datastore\V1\AllocateIdsResponse;
use Google\Cloud\Datastore\V1\BeginTransactionRequest;
use Google\Cloud\Datastore\V1\BeginTransactionResponse;
use Google\Cloud\Datastore\V1\Key as V1Key;
use Google\Cloud\Datastore\V1\RunAggregationQueryRequest;
use Google\Cloud\Datastore\V1\RunAggregationQueryResponse;
use Google\Cloud\Datastore\V1\RunQueryRequest;
use Google\Cloud\Datastore\V1\RunQueryResponse;
use Google\Protobuf\Timestamp as ProtobufTimestamp;

/**
 * @group datastore
 * @group datastore-client
 */
class DatastoreClientTest extends TestCase
{
    use DatastoreOperationRefreshTrait;
    use GrpcTestTrait;
    use ProphecyTrait;

    const PROJECT = 'example-project';
    const DATABASE = 'example-database';
    const TRANSACTION = 'transaction-id';

    private $client;
    private $gapicClient;
    private $operation;

    public function setUp(): void
    {
        if (class_exists(BypassFinals::class)) {
            BypassFinals::enable(true);
        }

        $this->gapicClient = $this->prophesize(GapicClient::class);
        $this->client = new DatastoreClient([
            'projectId' => self::PROJECT,
            'databaseId' => self::DATABASE,
            'datastoreClient' => $this->gapicClient->reveal()
        ]);
    }

    public function testKeyIncomplete()
    {
        $key = $this->client->key('Person');
        $this->assertInstanceOf(Key::class, $key);
        $this->assertEquals(Key::STATE_INCOMPLETE, $key->state());
        $this->assertEquals('Person', $key->pathEnd()['kind']);
    }

    public function testKeyComplete()
    {
        $key = $this->client->key('Person', 'John');
        $this->assertInstanceOf(Key::class, $key);
        $this->assertEquals(Key::STATE_NAMED, $key->state());
        $this->assertEquals('Person', $key->pathEnd()['kind']);
        $this->assertEquals('John', $key->pathEnd()['name']);
    }

    public function testKeyCompleteForceIdentifierType()
    {
        $key = $this->client->key('Person', 'John', ['identifierType' => Key::TYPE_ID]);
        $this->assertInstanceOf(Key::class, $key);
        $this->assertEquals(Key::STATE_NAMED, $key->state());
        $this->assertEquals('Person', $key->pathEnd()['kind']);
        $this->assertEquals('John', $key->pathEnd()['id']);
    }

    public function testKeys()
    {
        $keys = $this->client->keys('Person');
        $this->assertCount(1, $keys);
        $this->assertContainsOnlyInstancesOf(Key::class, $keys);
        $this->assertEquals(Key::STATE_INCOMPLETE, $keys[0]->state());
        $this->assertEquals('Person', $keys[0]->pathEnd()['kind']);
    }

    public function testKeysNumber()
    {
        $keys = $this->client->keys('Person', ['number' => 10]);
        $this->assertCount(10, $keys);
        $this->assertContainsOnlyInstancesOf(Key::class, $keys);
        $this->assertEquals(Key::STATE_INCOMPLETE, $keys[0]->state());
        $this->assertEquals('Person', $keys[0]->pathEnd()['kind']);
    }

    public function testKeysId()
    {
        $keys = $this->client->keys('Person', ['id' => 'foo']);
        $this->assertCount(1, $keys);
        $this->assertContainsOnlyInstancesOf(Key::class, $keys);
        $this->assertEquals(Key::STATE_NAMED, $keys[0]->state());
        $this->assertEquals('Person', $keys[0]->pathEnd()['kind']);
        $this->assertEquals('foo', $keys[0]->pathEnd()['id']);
    }

    public function testEntity()
    {
        $key = $this->client->key('Person', 'John');
        $data = ['location' => 'Michigan'];
        $entity = $this->client->entity($key, $data);
        $this->assertInstanceOf(Entity::class, $entity);
        $this->assertEquals($key, $entity->key());
        $this->assertEquals($data, $entity->get());
    }

    public function testBlob()
    {
        $blob = $this->client->blob('foo');
        $this->assertInstanceOf(Blob::class, $blob);
        $this->assertEquals('foo', (string) $blob);
    }

    public function testInt64()
    {
        $int64 = $this->client->int64('12345');
        $this->assertInstanceOf(Int64::class, $int64);
        $this->assertEquals('12345', $int64->get());
    }

    public function testGeoPoint()
    {
        $point = $this->client->geoPoint(1.1, 0.1);
        $this->assertInstanceOf(GeoPoint::class, $point);
        $this->assertEquals($point->point(), [
            'latitude' => 1.1,
            'longitude' => 0.1
        ]);
    }

    public function testAllocateId()
    {
        // 1. Setup keys and expected gRPC request/response
        $incompleteKey = $this->client->key('Person');
        $id = 123;
        $completeKey = $this->client->key('Person', $id);

        $v1IncompleteKey = new V1Key();
        $v1IncompleteKey->mergeFromJsonString(json_encode($incompleteKey->keyObject()));

        $v1CompleteKey = new V1Key();
        $v1CompleteKey->mergeFromJsonString(json_encode($completeKey->keyObject()));

        $request = (new AllocateIdsRequest())
            ->setProjectId(self::PROJECT)
            ->setDatabaseId(self::DATABASE)
            ->setKeys([$v1IncompleteKey]);

        $response = new AllocateIdsResponse();
        $response->setKeys([$v1CompleteKey]);

        // 2. Set expectation on the mocked GapicClient
        $this->gapicClient->allocateIds($request, [])
            ->shouldBeCalled(1)
            ->willReturn($response);

        // 5. Call the method under test
        $responseKey = $this->client->allocateId($incompleteKey);

        // 6. Assert the result
        $this->assertInstanceOf(Key::class, $responseKey);
        $this->assertEquals($id, $responseKey->pathEndIdentifier());
        $this->assertEquals('Person', $responseKey->pathEnd()['kind']);
    }

    public function testAllocateIds()
    {
        $incompleteKeys = [$this->client->key('Person'), $this->client->key('Book')];
        $ids = [123, 456];
        $completeKeys = [$this->client->key('Person', $ids[0]), $this->client->key('Book', $ids[1])];

        $incompleteKey1 = new V1Key();
        $incompleteKey1->mergeFromJsonString(json_encode($incompleteKeys[0]->keyObject()));
        $incompleteKey2 = new V1Key();
        $incompleteKey2->mergeFromJsonString(json_encode($incompleteKeys[1]->keyObject()));

        $v1IncompleteKeys = [
            $incompleteKey1,
            $incompleteKey2
        ];
        $v1CompleteKey1 = new V1Key();
        $v1CompleteKey1->mergeFromJsonString(json_encode($completeKeys[0]->keyObject()));
        $v1CompleteKey2 = new V1Key();
        $v1CompleteKey2->mergeFromJsonString(json_encode($completeKeys[1]->keyObject()));
        $v1CompleteKeys = [
            $v1CompleteKey1,
            $v1CompleteKey2
        ];

        $request = (new AllocateIdsRequest())->setProjectId(self::PROJECT)->setDatabaseId(self::DATABASE)->setKeys($v1IncompleteKeys);
        $response = (new AllocateIdsResponse())->setKeys($v1CompleteKeys);

        $this->gapicClient->allocateIds($request, [])->shouldBeCalled(1)->willReturn($response);

        $responseKeys = $this->client->allocateIds($incompleteKeys);

        $this->assertCount(2, $responseKeys);
        $this->assertEquals($ids[0], $responseKeys[0]->pathEndIdentifier());
        $this->assertEquals($ids[1], $responseKeys[1]->pathEndIdentifier());
    }

    public function testTransaction()
    {
        $expectedId = 'transactionString';

        $response = new BeginTransactionResponse();
        $response->setTransaction($expectedId);

        $this->gapicClient->beginTransaction(Argument::that(function (BeginTransactionRequest $request) {
            $this->assertEquals($request->getProjectId(), self::PROJECT);
            $this->assertEquals($request->getDatabaseId(), self::DATABASE);
            $this->assertNotNull($request->getTransactionOptions()->getReadWrite());
            return true;
        }), [])
            ->shouldBeCalled(1)
            ->willReturn($response);

        $expectedTransaction = new Transaction(
            $this->getOperationMock(),
            self::PROJECT,
            base64_encode($expectedId)
        );

        $response = $this->client->transaction();
        $this->assertInstanceOf(Transaction::class, $response);
        $this->assertEquals($expectedTransaction, $response);
    }

    public function testReadOnlyTransaction()
    {
        $expectedId = 'transactionString';

        $expectedTransaction = new ReadOnlyTransaction(
            $this->getOperationMock(),
            self::PROJECT,
            base64_encode($expectedId)
        );

        $response = new BeginTransactionResponse();
        $response->setTransaction($expectedId);

        $this->gapicClient->beginTransaction(Argument::that(function (BeginTransactionRequest $request) {
            $this->assertEquals($request->getProjectId(), self::PROJECT);
            $this->assertEquals($request->getDatabaseId(), self::DATABASE);
            $this->assertNotNull($request->getTransactionOptions()->getReadOnly());
            return true;
        }), [])->shouldBeCalled(1)->willReturn($response);

        $response = $this->client->readOnlyTransaction();
        $this->assertInstanceOf(ReadOnlyTransaction::class, $response);
        $this->assertEquals($expectedTransaction, $response);
    }

    public function testTransactionWithOptions()
    {
        $options = ['previousTransaction' => 'previousId'];
        $expectedTransaction = new Transaction(
            $this->getOperationMock(),
            self::PROJECT,
            base64_encode(self::TRANSACTION),
            $options
        );

        $response = (new BeginTransactionResponse())->setTransaction('transaction-id');

        $this->gapicClient->beginTransaction(Argument::that(function(BeginTransactionRequest $request){
            $this->assertEquals($request->getProjectId(), self::PROJECT);
            $this->assertEquals($request->getDatabaseId(), self::DATABASE);
            $previousTransaction = $request->getTransactionOptions()
                ->getReadWrite()
                ->getPreviousTransaction();
            $this->assertNotEmpty($previousTransaction);
            $this->assertEquals($previousTransaction, 'previousId');
            return true;
        }), [])->shouldBeCalled(1)->willReturn(
            $response
        );

        $res = $this->client->transaction(['transactionOptions' => $options]);
        $this->assertInstanceOf(Transaction::class, $res);
        $this->assertEquals($expectedTransaction, $res);
    }

    public function testReadOnlyTransactionWithOptions()
    {
        $dateTime = new DateTime();
        $timestamp = new Timestamp($dateTime);
        $options = ['readTime' => $timestamp];
        $expectedTransaction = new ReadOnlyTransaction(
            $this->getOperationMock(),
            self::PROJECT,
            base64_encode(self::TRANSACTION),
            $options
        );

        $response = new BeginTransactionResponse();
        $response->setTransaction(self::TRANSACTION);

        $this->gapicClient->beginTransaction(Argument::that(function(BeginTransactionRequest $request) use ($timestamp) {
            $this->assertEquals($request->getProjectId(), self::PROJECT);
            $this->assertEquals($request->getDatabaseId(), self::DATABASE);
            $readTime = $request->getTransactionOptions()
                ->getReadOnly()
                ->getReadTime();
            $this->assertNotEmpty($readTime);
            $this->assertNull($request->getTransactionOptions()->getReadWrite());
            return true;
        }), [])->shouldBeCalled(1)->willReturn(
            $response
        );

        $res = $this->client->readOnlyTransaction(['transactionOptions' => $options]);
        $this->assertInstanceOf(ReadOnlyTransaction::class, $res);
        $this->assertEquals($expectedTransaction, $res);
    }

    public function testDatastoreCrudOperations()
    {
        $key = $this->client->key('Person', 'jeff');
        $data = ['firstName' => 'Jeff'];
        $entity = $this->client->entity($key, $data);

        // Common commit response for mutations
        $commitResponse = new CommitResponse();
        $commitResponse->mergeFromJsonString(json_encode($this->commitResponse()));

        // 1. Test Insert
        $this->gapicClient->commit(Argument::that(function(CommitRequest $request) {
            return $request->getMutations()[0]->getOperation() == 'insert';
        }), [
            'transaction' => null,
            'databaseId' => self::DATABASE
        ])->shouldBeCalledTimes(1)
            ->willReturn($commitResponse);

        $this->client->insert($entity);

        // 2. Test Update
        $updateData = ['firstName' => 'Jeffrey'];
        $updateEntity = $this->client->entity($key, $updateData, ['populatedByService' => true]);

        $this->gapicClient->commit(
            Argument::that(function (CommitRequest $request) {
                return $request->getMutations()[0]->getOperation() == 'update';
            }),
            [
                'transaction' => null,
                'databaseId' => self::DATABASE,
                'allowOverwrite' => false,
            ]
        )->shouldBeCalledTimes(1)
            ->willReturn($commitResponse);

        $this->client->update($updateEntity);

        // 3. Test Upsert
        $upsertData = ['firstName' => 'Geoff'];
        $upsertEntity = $this->client->entity($key, $upsertData);

        $this->gapicClient->commit(
            Argument::that(function (CommitRequest $request) {
                return $request->getMutations()[0]->getOperation() == 'upsert';
            }),
            [
                'transaction' => null,
                'databaseId' => self::DATABASE,
            ]
        )->shouldBeCalledTimes(1)
            ->willReturn($commitResponse);

        $this->client->upsert($upsertEntity);

        // 4. Test Delete
        $this->gapicClient->commit(Argument::that(function(CommitRequest $request) {
            return $request->getMutations()[0]->getOperation() == 'delete';
        }), [
            'baseVersion' => null,
            'transaction' => null,
            'databaseId' => self::DATABASE,
        ])->shouldBeCalledTimes(1)->willReturn($commitResponse);

        $this->client->delete($key);
    }

    public function testDatastoreBatchCrudOperations()
    {
        $key1 = $this->client->key('Person', 'jeff');
        $key2 = $this->client->key('Person', 'bob');
        $keys = [$key1, $key2];

        $entity1 = $this->client->entity($key1, ['firstName' => 'Jeff']);
        $entity2 = $this->client->entity($key2, ['firstName' => 'Bob']);
        $entities = [$entity1, $entity2];

        // Common commit response for mutations
        $commitResponse = new CommitResponse();
        $commitResponse->mergeFromJsonString(json_encode($this->commitResponse()));

        // Set all expectations up front
        $this->gapicClient->commit(Argument::that(function (CommitRequest $request) {
            $mutations = $request->getMutations();
            if (count($mutations) !== 2) return false;
            return $mutations[0]->getOperation() == 'insert' && $mutations[1]->getOperation() == 'insert';
        }), Argument::any())->shouldBeCalledTimes(1)->willReturn($commitResponse);

        $this->gapicClient->commit(Argument::that(function (CommitRequest $request) {
            $mutations = $request->getMutations();
            if (count($mutations) !== 2) return false;
            return $mutations[0]->getOperation() == 'update' && $mutations[1]->getOperation() == 'update';
        }), Argument::any())->shouldBeCalledTimes(1)->willReturn($commitResponse);

        $this->gapicClient->commit(Argument::that(function (CommitRequest $request) {
            $mutations = $request->getMutations();
            if (count($mutations) !== 2) return false;
            return $mutations[0]->getOperation() == 'upsert' && $mutations[1]->getOperation() == 'upsert';
        }), Argument::any())->shouldBeCalledTimes(1)->willReturn($commitResponse);

        $this->gapicClient->commit(Argument::that(function (CommitRequest $request) {
            $mutations = $request->getMutations();
            if (count($mutations) !== 2) return false;
            return $mutations[0]->getOperation() == 'delete' && $mutations[1]->getOperation() == 'delete';
        }), Argument::any())->shouldBeCalledTimes(1)->willReturn($commitResponse);

        // Execute the operations
        // 1. Test insertBatch
        $this->client->insertBatch($entities);

        // 2. Test updateBatch
        $updateEntity1 = $this->client->entity($key1, ['firstName' => 'Jeffrey'], ['populatedByService' => true]);
        $updateEntity2 = $this->client->entity($key2, ['firstName' => 'Bobby'], ['populatedByService' => true]);
        $this->client->updateBatch([$updateEntity1, $updateEntity2]);

        // 3. Test upsertBatch
        $upsertEntity1 = $this->client->entity($key1, ['firstName' => 'Geoff']);
        $upsertEntity2 = $this->client->entity($key2, ['firstName' => 'Rob']);
        $this->client->upsertBatch([$upsertEntity1, $upsertEntity2]);

        // 4. Test deleteBatch
        $this->client->deleteBatch($keys);
    }

    public function testInsertBatchWithIncompleteKey()
    {
        [$incompleteEntities, $protoIncompleteKeys, $protoCompleteKeys] = $this->getTestData();
        $response = new AllocateIdsResponse();
        $response->setKeys($protoCompleteKeys);

        $commitResponse = new CommitResponse();
        $commitResponse->mergeFromJsonString(json_encode($this->commitResponse()));

        $this->gapicClient->allocateIds(Argument::type(AllocateIdsRequest::class), [])
            ->shouldBeCalled(1)
            ->willReturn($response);

        $this->gapicClient->commit(Argument::that(function (CommitRequest $request) {
            if (count($request->getMutations()) !== 2) {
                return false;
            }

            return $request->getMutations()[0]->getOperation() == 'insert' && $request->getMutations()[1]->getOperation() == 'insert';
        }), Argument::any())
            ->shouldBeCalled(1)
            ->willReturn($commitResponse);

        $this->client->insertBatch($incompleteEntities);
    }

    public function testUpsertBatchWithIncompleteKey()
    {
        [$incompleteEntities, $protoIncompleteKeys, $protoCompleteKeys] = $this->getTestData();
        $response = new AllocateIdsResponse();
        $response->setKeys($protoCompleteKeys);

        $commitResponse = new CommitResponse();
        $commitResponse->mergeFromJsonString(json_encode($this->commitResponse()));

        $this->gapicClient->allocateIds(Argument::type(AllocateIdsRequest::class), [])
            ->shouldBeCalled(1)
            ->willReturn($response);

        $this->gapicClient->commit(Argument::that(function (CommitRequest $request) {
            if (count($request->getMutations()) !== 2) {
                return false;
            }

            return $request->getMutations()[0]->getOperation() == 'upsert' && $request->getMutations()[1]->getOperation() == 'upsert';
        }), Argument::any())
            ->shouldBeCalled(1)
            ->willReturn($commitResponse);

        $this->client->upsertBatch($incompleteEntities);
    }

    public function testSingleMutationConflict()
    {
        $this->expectException(\DomainException::class);

        $commitResponse = new CommitResponse();
        $commitResponse->mergeFromJsonString(json_encode($this->conflictCommitResponse()));

        $this->gapicClient->commit(Argument::type(CommitRequest::class), Argument::any())
            ->shouldBeCalled(1)
            ->willReturn($commitResponse);

        $entity = $this->client->entity($this->client->key('test', 'test'), ['name' => 'John']);
        $this->client->insert($entity);
    }

    public function testLookup()
    {
        $key = $this->client->key('Person', 'John');

        $data = [
            'found' => [
                [
                    'entity' => $this->entityArray($key)
                ]
            ]
        ];
        $response = new LookupResponse();
        $response->mergeFromJsonString(json_encode($data));

        $this->gapicClient->lookup(Argument::type(LookupRequest::class), Argument::any())
            ->shouldBeCalled(1)
            ->willReturn($response);

        $key = $this->client->key('Person', 'John');
        $res = $this->client->lookup($key);
        $this->assertInstanceOf(Entity::class, $res);
        $this->assertEquals($key->keyObject(), $res->key()->keyObject());
    }

    public function testLookupMissing()
    {
        $key = $this->client->key('Person', 'John');

        $data = [
            'missing' => [
                [
                    'entity' => $this->entityArray($key)
                ]
            ]
        ];
        $response = new LookupResponse();
        $response->mergeFromJsonString(json_encode($data));

        $this->gapicClient->lookup(Argument::type(LookupRequest::class), Argument::any())
            ->shouldBeCalled(1)
            ->willReturn($response);

        $key = $this->client->key('Person', 'John');
        $res = $this->client->lookup($key);
        $this->assertNull($res);
    }

    public function testLookupBatch()
    {
        $key = $this->client->key('Person', 'John');

        $data = [
            'found' => [
                [
                    'entity' => $this->entityArray($key)
                ]
            ],
            'missing' => [
                [
                    'entity' => $this->entityArray($key)
                ]
            ],
            'deferred' => [
                $key->keyObject()
            ]
        ];

        $response = new LookupResponse();
        $response->mergeFromJsonString(json_encode($data));

        $this->gapicClient->lookup(Argument::type(LookupRequest::class), Argument::any())
            ->shouldBeCalled(1)
            ->willReturn($response);

        $key = $this->client->key('Person', 'John');
        $res = $this->client->lookupBatch([$key]);

        $this->assertInstanceOf(Entity::class, $res['found'][0]);
        $this->assertInstanceOf(Key::class, $res['missing'][0]);
        $this->assertInstanceOf(Key::class, $res['deferred'][0]);
    }

    public function testLookupBatchWithReadTime()
    {
        $key = $this->client->key('Person', 'John');
        $time = new Timestamp(new \DateTime());
        $protoTime = new ProtobufTimestamp();
        $protoTime->mergeFromJsonString(json_encode($time));

        $data = [
            'found' => [
                [
                    'entity' => $this->entityArray($key)
                ]
            ]
        ];

        $response = new LookupResponse();
        $response->mergeFromJsonString(json_encode($data));

        $this->gapicClient->lookup(Argument::that(function(LookupRequest $request) use ($protoTime) {
            return $request->getReadOptions()->getReadTime()->getSeconds() === $protoTime->getSeconds();
        }), Argument::any())
            ->shouldBeCalled(1)
            ->willReturn($response);

        $res = $this->client->lookupBatch([$key], ['readTime' => $time]);
        $this->assertInstanceOf(Entity::class, $res['found'][0]);
    }

    public function testLookupWithReadTime()
    {
        $key = $this->client->key('Person', 'John');
        $time = new Timestamp(new \DateTime());
        $protoTime = new ProtobufTimestamp();
        $protoTime->mergeFromJsonString(json_encode($time));

        $data = [
            'found' => [
                [
                    'entity' => $this->entityArray($key)
                ]
            ]
        ];

        $response = new LookupResponse();
        $response->mergeFromJsonString(json_encode($data));

        $this->gapicClient->lookup(Argument::that(function(LookupRequest $request) use ($protoTime) {
            return $request->getReadOptions()->getReadTime()->getSeconds() === $protoTime->getSeconds();
        }), Argument::any())
            ->shouldBeCalled(1)
            ->willReturn($response);

        $res = $this->client->lookup($key, ['readTime' => $time]);
        $this->assertInstanceOf(Entity::class, $res);
    }

    public function testQuery()
    {
        $query = ['foo' => 'bar'];
        $q = $this->client->query($query);
        $this->assertInstanceOf(Query::class, $q);
        $this->assertEquals(['query' => $query], $q->queryObject());
    }

    public function testGqlQuery()
    {
        $query = 'SELECT 1=1';
        $q = $this->client->gqlQuery($query);
        $this->assertInstanceOf(GqlQuery::class, $q);
        $this->assertEquals($query, $q->queryObject()['queryString']);
    }

    public function testRunQuery()
    {
        $key = $this->client->key('Person', 'John');

        $data = [
            'batch' => [
                'entityResults' => [
                    [
                        'entity' => $this->entityArray($key)
                    ]
                ]
            ]
        ];
        $response = new RunQueryResponse();
        $response->mergeFromJsonString(json_encode($data));

        $this->gapicClient->runQuery(Argument::type(RunQueryRequest::class), Argument::any())
            ->shouldBeCalled(1)
            ->willReturn($response);

        $query = $this->prophesize(QueryInterface::class);
        $query->queryKey()->willReturn('gqlQuery');
        $query->queryObject()->willReturn(['queryString' => 'SELECT 1=1']);
        $query->canPaginate()->willReturn(true);

        $res = iterator_to_array($this->client->runQuery($query->reveal()));
        $this->assertContainsOnlyInstancesOf(Entity::class, $res);
    }

    public function testRunAggregationQuery()
    {
        $time = new Timestamp(new \DateTime());

        $data = [
            'batch' => [
                'aggregationResults' => [
                    [
                        'aggregateProperties' => [
                            'property_1' => [
                                'integerValue' => 1
                            ]
                        ]
                    ]
                ],
                'readTime' => $time
            ]
        ];
        $response = new RunAggregationQueryResponse();
        $response->mergeFromJsonString(json_encode($data));

        $this->gapicClient->runAggregationQuery(Argument::type(RunAggregationQueryRequest::class), Argument::any())
            ->shouldBeCalled(1)
            ->willReturn($response);

        $query = $this->prophesize(AggregationQuery::class);
        $query->queryObject()->willReturn([
            'gqlQuery' => [
                'queryString' => 'AGGREGATE (COUNT(*)) over (SELECT 1=1)'
            ]
        ]);

        $res = $this->client->runAggregationQuery($query->reveal());
        $this->assertInstanceOf(AggregationQueryResult::class, $res);
    }

    /**
     * @dataProvider aggregationReturnTypesCases
     */
    public function testAggregationQueryWithDifferentReturnTypes($response, $expected)
    {
        $responseData = [
            'batch' => [
                'aggregationResults' => [
                    [
                        'aggregateProperties' => ['property_1' => $response]
                    ]
                ],
                'readTime' => new Timestamp(new \DateTime())
            ]
        ];

        $response = new RunAggregationQueryResponse();
        $response->mergeFromJsonString(json_encode($responseData));

        $this->gapicClient->runAggregationQuery(Argument::type(RunAggregationQueryRequest::class), Argument::any())
            ->shouldBeCalled(1)
            ->willReturn($response);

        $query = $this->prophesize(AggregationQuery::class);
        $query->queryObject()->willReturn([
            'gqlQuery' => [
                'queryString' => 'foo bar'
            ]
        ]);

        $res = $this->client->runAggregationQuery($query->reveal());
        $this->assertInstanceOf(AggregationQueryResult::class, $res);
        $this->compareResult($expected, $res->get('property_1'));
    }

    public function testRunQueryWithReadTime()
    {
        $key = $this->client->key('Person', 'John');
        $time = new Timestamp(new \DateTime());

        $responseData = [
            'batch' => [
                'entityResults' => [
                    [
                        'entity' => $this->entityArray($key)
                    ]
                ]
            ]
        ];

        $response = new RunQueryResponse();
        $response->mergeFromJsonString(json_encode($responseData));

        $this->gapicClient->runQuery(Argument::type(RunQueryRequest::class), Argument::any())
            ->shouldBeCalled(1)
            ->willReturn($response);

        $query = $this->prophesize(QueryInterface::class);
        $query->queryKey()->willReturn('gqlQuery');
        $query->queryObject()->willReturn(['queryString' => 'SELECT 1=1']);
        $query->canPaginate()->willReturn(true);

        $res = iterator_to_array($this->client->runQuery($query->reveal(), ['readTime' => $time]));
        $this->assertContainsOnlyInstancesOf(Entity::class, $res);
    }

    public function testRunQuerySendsExplainOptions()
    {
        $key = $this->client->key('Person', 'John');
        $explainOptions = new ExplainOptions();
        $explainOptions->setAnalyze(true);

        $responseData = [
            'batch' => [
                'entityResults' => [
                    [
                        'entity' => $this->entityArray($key)
                    ]
                ]
            ]
        ];
        $response = new RunQueryResponse();
        $response->mergeFromJsonString(json_encode($responseData));

        $this->gapicClient->runQuery(Argument::type(RunQueryRequest::class), Argument::any())
            ->shouldBeCalled(1)
            ->willReturn($response);

        $query = $this->prophesize(QueryInterface::class);
        $query->queryKey()->willReturn('gqlQuery');
        $query->queryObject()->willReturn(['queryString' => 'SELECT 1=1']);
        $query->canPaginate()->willReturn(true);

        $result = $this->client->runQuery($query->reveal(), ['explainOptions' => $explainOptions]);

        iterator_to_array($result);
    }

    public function aggregationReturnTypesCases()
    {
        return [
            [['integerValue' => 1], 1],
            [['doubleValue' => 1.1], 1.1],
            [['doubleValue' => 'Infinity'], INF],
            [['doubleValue' => '-Infinity'], -INF],
            [['doubleValue' => 'NaN'], NAN],
            [['nullValue' => null], null],
        ];
    }

    private function commitResponse()
    {
        return [
            'mutationResults' => [
                [
                    'version' => 1
                ]
            ]
        ];
    }

    private function conflictCommitResponse()
    {
        return [
            'mutationResults' => [
                [
                    'conflictDetected' => true
                ]
            ]
        ];
    }

    private function entityArray(Key $key)
    {
        return [
            'key' => $key->keyObject(),
            'properties' => [
                'name' => [
                    'stringValue' => 'John'
                ]
            ]
        ];
    }

    private function mutationsProviderProvider($id, $partialKey = false)
    {
        $key = new Key(self::PROJECT);
        $key->pathElement('Person', !$partialKey ? $id : null);
        $mutation = $this->entityArray($key);

        if ($partialKey) {
            $mutation['key']['path'][0]['id'] = $id;
        }

        return [
            ['insert', $mutation, clone $key, $id],
            ['update', $mutation, clone $key, $id],
            ['upsert', $mutation, clone $key, $id],
        ];
    }

    private function compareResult($expected, $actual)
    {
        if (is_float($expected)) {
            if (is_nan($expected)) {
                $this->assertNan($actual);
            } else {
                $this->assertEqualsWithDelta($expected, $actual, 0.01);
            }
        } else {
            // Used because assertEquals(null, '') doesn't fails
            $this->assertSame($expected, $actual);
        }
    }

    private function getOperationMock(): Operation
    {
        $entityMapper = new EntityMapper(self::PROJECT, true, false);
        return new Operation(
            $this->gapicClient->reveal(),
            self::PROJECT,
            null, // namespaceId
            $entityMapper,
            self::DATABASE
        );
    }

    private function getTestData(): array
    {
        // Setup keys and entities
        $incompleteKey1 = $this->client->key('Person');
        $incompleteKey2 = $this->client->key('Book');
        $incompleteEntities = [
            $this->client->entity($incompleteKey1, ['name' => 'John']),
            $this->client->entity($incompleteKey2, ['title' => 'The Stand'])
        ];
        $ids = [123, 456];

        // Setup proto keys
        $incompleteProtoKey1 = new V1Key();
        $incompleteProtoKey1->mergeFromJsonString(json_encode($incompleteKey1->keyObject()));
        $incompleteProtoKey2 = new V1Key();
        $incompleteProtoKey2->mergeFromJsonString(json_encode($incompleteKey2->keyObject()));

        // Setup complete proto keys
        $completeProtoKey1 = new V1Key();
        $completeProtoKey1->mergeFromJsonString(json_encode($this->client->key('Person', $ids[0])->keyObject()));
        $completeProtoKey2 = new V1Key();
        $completeProtoKey2->mergeFromJsonString(json_encode($this->client->key('Book', $ids[1])->keyObject()));

        $v1IncompleteKeys = [
            $incompleteProtoKey1,
            $incompleteProtoKey2
        ];
        $v1CompleteKeys = [
            $completeProtoKey1,
            $completeProtoKey2
        ];

        return [
            $incompleteEntities,
            $v1IncompleteKeys,
            $v1CompleteKeys
        ];
    }

    private function getClient(null|GapicClient $client): DatastoreClient
    {
        $config = [
            'databaseId' => self::DATABASE,
            'projectId' => self::PROJECT
        ];

        if (!is_null($client)) {
            $config['client'] = $client;
        }

        return new DatastoreClient($config);
    }
}

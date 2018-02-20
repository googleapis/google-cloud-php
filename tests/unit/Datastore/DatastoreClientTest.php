<?php
/**
 * Copyright 2017 Google Inc.
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

use Google\Cloud\Core\Int64;
use Google\Cloud\Core\Testing\DatastoreOperationRefreshTrait;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Cloud\Datastore\Blob;
use Google\Cloud\Datastore\Connection\ConnectionInterface;
use Google\Cloud\Datastore\DatastoreClient;
use Google\Cloud\Datastore\Entity;
use Google\Cloud\Datastore\GeoPoint;
use Google\Cloud\Datastore\Key;
use Google\Cloud\Datastore\Query\GqlQuery;
use Google\Cloud\Datastore\Query\Query;
use Google\Cloud\Datastore\Query\QueryInterface;
use Google\Cloud\Datastore\ReadOnlyTransaction;
use Google\Cloud\Datastore\Transaction;
use Prophecy\Argument;

/**
 * @group datastore
 * @group datastore-client
 */
class DatastoreClientTest extends \PHPUnit_Framework_TestCase
{
    use DatastoreOperationRefreshTrait;

    const PROJECT = 'example-project';
    const TRANSACTION = 'transaction-id';

    private $connection;
    private $client;

    public function setUp()
    {
        $this->connection = $this->prophesize(ConnectionInterface::class);
        $this->client = TestHelpers::stub(DatastoreClient::class, [
            ['projectId' => self::PROJECT]
        ], [
            'operation'
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

    /**
     * @dataProvider allocateIdProvider
     */
    public function testAllocateId($method, $batch = false)
    {
        $key = new Key('foo');
        $key->pathElement('Person');
        $id = 12345;
        $keyWithId = clone $key;
        $keyWithId->setLastElementIdentifier($id);

        $this->connection->allocateIds(Argument::withEntry('keys', [
            $key->keyObject()
        ]))->shouldBeCalled()->willReturn([
            'keys' => [
                $keyWithId->keyObject()
            ]
        ]);

        $this->refreshOperation($this->client, $this->connection->reveal());

        $res = $batch
            ? $this->client->$method([$key])[0]
            : $this->client->$method($key);

        $this->assertInstanceOf(Key::class, $res);
        $this->assertEquals($id, $res->pathEnd()['id']);
        $this->assertEquals('Person', $res->pathEnd()['kind']);
    }

    public function allocateIdProvider()
    {
        return [
            ['allocateId'],
            ['allocateIds', true]
        ];
    }

    /**
     * @dataProvider transactionProvider
     */
    public function testTransaction($method, $type, $key)
    {
        $this->connection->beginTransaction(Argument::allOf(
            Argument::withEntry('projectId', self::PROJECT),
            // can't do direct comparisons between (object)[].
            Argument::that(function ($arg) use ($key) {
                if (!($arg['transactionOptions'][$key] instanceof \stdClass)) return false;
                if ((array) $arg['transactionOptions'][$key]) return false;

                return true;
            })
        ))->shouldBeCalled()->willReturn([
            'transaction' => self::TRANSACTION
        ]);

        $this->refreshOperation($this->client, $this->connection->reveal(), ['projectId' => self::PROJECT]);
        $res = $this->client->$method();
        $this->assertInstanceOf($type, $res);
    }

    /**
     * @dataProvider transactionProvider
     */
    public function testTransactionWithOptions($method, $type, $key)
    {
        $options = ['foo' => 'bar'];

        $this->connection->beginTransaction(Argument::allOf(
            Argument::withEntry('projectId', self::PROJECT),
            Argument::withEntry('transactionOptions', [
                $key => $options
            ])
        ))->shouldBeCalled()->willReturn([
            'transaction' => self::TRANSACTION
        ]);

        // Make sure the correct transaction ID was injected.
        $this->connection->runQuery(Argument::withEntry('transaction', self::TRANSACTION))
            ->shouldBeCalled()
            ->willReturn([]);

        $this->refreshOperation($this->client, $this->connection->reveal());

        $res = $this->client->$method(['transactionOptions' => $options]);
        $this->assertInstanceOf($type, $res);

        iterator_to_array($res->runQuery($this->client->gqlQuery('SELECT 1=1')));
    }

    public function transactionProvider()
    {
        return [
            ['readOnlyTransaction', ReadOnlyTransaction::class, 'readOnly'],
            ['transaction', Transaction::class, 'readWrite']
        ];
    }

    /**
     * @dataProvider mutationsProvider
     */
    public function testEntityMutations($method, $mutation, $key)
    {
        $this->connection->commit(Argument::allOf(
            Argument::withEntry('transaction', null),
            Argument::withEntry('mode', 'NON_TRANSACTIONAL'),
            Argument::withEntry('mutations', [[$method => $mutation]])
        ))->shouldBeCalled()->willReturn($this->commitResponse());

        $this->refreshOperation($this->client, $this->connection->reveal());

        $entity = $this->client->entity($key, ['name' => 'John']);
        $res = $this->client->$method($entity, ['allowOverwrite' => true]);

        $this->assertEquals($this->commitResponse()['mutationResults'][0]['version'], $res);
    }

    /**
     * @dataProvider mutationsProvider
     */
    public function testEntityMutationsBatch($method, $mutation, $key)
    {
        $this->connection->commit(Argument::allOf(
            Argument::withEntry('transaction', null),
            Argument::withEntry('mode', 'NON_TRANSACTIONAL'),
            Argument::withEntry('mutations', [[$method => $mutation]])
        ))->shouldBeCalled()->willReturn($this->commitResponse());

        $this->refreshOperation($this->client, $this->connection->reveal());

        $method = $method . 'Batch';

        $entity = $this->client->entity($key, ['name' => 'John']);
        $res = $this->client->$method([$entity], ['allowOverwrite' => true]);

        $this->assertEquals($this->commitResponse(), $res);
    }

    public function mutationsProvider()
    {
        return $this->mutationsProviderProvider(123245);
    }

    /**
     * @dataProvider partialKeyMutationsProvider
     */
    public function testMutationsWithPartialKey($method, $mutation, $key, $id)
    {
        $this->connection->commit(Argument::allOf(
            Argument::withEntry('transaction', null),
            Argument::withEntry('mode', 'NON_TRANSACTIONAL'),
            Argument::withEntry('mutations', [[$method => $mutation]])
        ))->shouldBeCalled()->willReturn($this->commitResponse());

        $keyWithId = clone $key;
        $keyWithId->setLastElementIdentifier($id);
        $this->connection->allocateIds(Argument::allOf(
            Argument::withEntry('keys', [$key->keyObject()])
        ))->shouldBeCalled()->willReturn([
            'keys' => [
                $keyWithId->keyObject()
            ]
        ]);

        $this->refreshOperation($this->client, $this->connection->reveal());

        $entity = $this->client->entity($key, ['name' => 'John']);
        $this->client->$method($entity);
    }

    /**
     * @dataProvider partialKeyMutationsProvider
     */
    public function testBatchMutationsWithPartialKey($method, $mutation, $key, $id)
    {
        $this->connection->commit(Argument::allOf(
            Argument::withEntry('transaction', null),
            Argument::withEntry('mode', 'NON_TRANSACTIONAL'),
            Argument::withEntry('mutations', [[$method => $mutation]])
        ))->shouldBeCalled()->willReturn($this->commitResponse());

        $keyWithId = clone $key;
        $keyWithId->setLastElementIdentifier($id);
        $this->connection->allocateIds(Argument::allOf(
            Argument::withEntry('keys', [$key->keyObject()])
        ))->shouldBeCalled()->willReturn([
            'keys' => [
                $keyWithId->keyObject()
            ]
        ]);

        $this->refreshOperation($this->client, $this->connection->reveal());

        $method = $method . 'Batch';
        $entity = $this->client->entity($key, ['name' => 'John']);
        $this->client->$method([$entity]);
    }

    public function partialKeyMutationsProvider()
    {
        $res = $this->mutationsProviderProvider(12345, true);
        return array_filter($res, function ($case) {
            return $case[0] !== 'update';
        });
    }

    public function testDelete()
    {
        $key = $this->client->key('Person', 'John');

        $this->connection->commit(Argument::allOf(
            Argument::withEntry('transaction', null),
            Argument::withEntry('mode', 'NON_TRANSACTIONAL'),
            Argument::withEntry('mutations', [
                [
                    'delete' => $key->keyObject()
                ]
            ])
        ))->shouldBeCalled()->willReturn($this->commitResponse());

        $this->refreshOperation($this->client, $this->connection->reveal());

        $res = $this->client->delete($key);

        $this->assertEquals($this->commitResponse()['mutationResults'][0]['version'], $res);
    }

    public function testDeleteBatch()
    {
        $key = $this->client->key('Person', 'John');

        $this->connection->commit(Argument::allOf(
            Argument::withEntry('transaction', null),
            Argument::withEntry('mode', 'NON_TRANSACTIONAL'),
            Argument::withEntry('mutations', [
                [
                    'delete' => $key->keyObject()
                ]
            ])
        ))->shouldBeCalled()->willReturn($this->commitResponse());

        $this->refreshOperation($this->client, $this->connection->reveal());

        $res = $this->client->deleteBatch([$key]);

        $this->assertEquals($this->commitResponse(), $res);
    }

    public function testLookup()
    {
        $key = $this->client->key('Person', 'John');

        $this->connection->lookup(
            Argument::withEntry('keys', [$key->keyObject()])
        )->shouldBeCalled()->willReturn([
            'found' => [
                [
                    'entity' => $this->entityArray($key)
                ]
            ]
        ]);

        $this->refreshOperation($this->client, $this->connection->reveal());

        $key = $this->client->key('Person', 'John');
        $res = $this->client->lookup($key);
        $this->assertInstanceOf(Entity::class, $res);
        $this->assertEquals($key->keyObject(), $res->key()->keyObject());
    }

    public function testLookupMissing()
    {
        $key = $this->client->key('Person', 'John');

        $this->connection->lookup(
            Argument::withEntry('keys', [$key->keyObject()])
        )->shouldBeCalled()->willReturn([
            'missing' => [
                [
                    'entity' => $this->entityArray($key)
                ]
            ]
        ]);

        $this->refreshOperation($this->client, $this->connection->reveal());

        $key = $this->client->key('Person', 'John');
        $res = $this->client->lookup($key);
        $this->assertNull($res);
    }

    public function testLookupBatch()
    {
        $key = $this->client->key('Person', 'John');

        $this->connection->lookup(
            Argument::withEntry('keys', [$key->keyObject()])
        )->shouldBeCalled()->willReturn([
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
        ]);

        $this->refreshOperation($this->client, $this->connection->reveal());

        $key = $this->client->key('Person', 'John');
        $res = $this->client->lookupBatch([$key]);
        $this->assertInstanceOf(Entity::class, $res['found'][0]);
        $this->assertInstanceOf(Key::class, $res['missing'][0]);
        $this->assertInstanceOf(Key::class, $res['deferred'][0]);
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

        $this->connection->runQuery(Argument::allOf(
            Argument::withEntry('partitionId', ['projectId' => self::PROJECT]),
            Argument::withEntry('gqlQuery', ['queryString' => 'SELECT 1=1'])
        ))->shouldBeCalled()->willReturn([
            'batch' => [
                'entityResults' => [
                    [
                        'entity' => $this->entityArray($key)
                    ]
                ]
            ]
        ]);

        $this->refreshOperation($this->client, $this->connection->reveal());

        $query = $this->prophesize(QueryInterface::class);
        $query->queryKey()->willReturn('gqlQuery');
        $query->queryObject()->willReturn(['queryString' => 'SELECT 1=1']);

        $res = iterator_to_array($this->client->runQuery($query->reveal()));
        $this->assertContainsOnlyInstancesOf(Entity::class, $res);
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
}

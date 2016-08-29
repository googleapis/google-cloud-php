<?php
/**
 * Copyright 2016 Google Inc. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Google\Cloud\Datastore;

use Google\Cloud\ClientTrait;
use Google\Cloud\Datastore\Connection\Rest;
use Google\Cloud\Datastore\Query\GqlQuery;
use Google\Cloud\Datastore\Query\Query;
use Google\Cloud\Datastore\Query\QueryBuilder;
use Google\Cloud\Datastore\Query\QueryInterface;
use InvalidArgumentException;

/**
 * Google Cloud Datastore client. Cloud Datastore is a highly-scalable NoSQL
 * database for your applications.  Find more information at
 * [Google Cloud Datastore docs](https://cloud.google.com/datastore/docs/).
 */
class DatastoreClient
{
    use ClientTrait;
    use DatastoreTrait;

    const FULL_CONTROL_SCOPE = 'https://www.googleapis.com/auth/datastore';

    const DEFAULT_READ_CONSISTENCY = 'EVENTUAL';

    /**
     * @var ConnectionInterface
     */
    protected $connection;

    /**
     * Create a Datastore client.
     *
     * Example:
     * ```
     * use Google\Cloud\ServiceBuilder;
     *
     * $cloud = new ServiceBuilder([
     *     'projectId' => 'my-awesome-project'
     * ]);
     *
     * $datastore = $cloud->datastore();
     * ```
     *
     * ```
     * // The Datastore client can also be instantianted directly.
     * use Google\Cloud\Datastore\DatastoreClient;
     *
     * $datastore = new DatastoreClient([
     *     'projectId' => 'my-awesome-project'
     * ]);
     * ```
     *
     * @param array $config {
     *     Configuration Options.
     *
     *     @type string $projectId The project ID from the Google Developer's
     *           Console.
     *     @type callable $authHttpHandler A handler used to deliver Psr7
     *           requests specifically for authentication.
     *     @type callable $httpHandler A handler used to deliver Psr7 requests.
     *     @type string $keyFile The contents of the service account
     *           credentials .json file retrieved from the Google Developers
     *           Console.
     *     @type string $keyFilePath The full path to your service account
     *           credentials .json file retrieved from the Google Developers
     *           Console.
     *     @type int $retries Number of retries for a failed request. Defaults
     *           to 3.
     *     @type array $scopes Scopes to be used for the request.
     * }
     * @throws \InvalidArgumentException
     */
    public function __construct(array $config = [])
    {
        if (!isset($config['scopes'])) {
            $config['scopes'] = [self::FULL_CONTROL_SCOPE];
        }

        $this->connection = new Rest($this->configureAuthentication($config));
    }

    /**
     * Create a single Key instance
     *
     * Example:
     * ```
     * $key = $datastore->key('Person', 'Bob');
     * ```
     *
     * ```
     * // To override the internal detection of identifier type, you can specify
     * // which type to use.
     *
     * $key = $datastore->key('Robots', '1337', [
     *     'identifierType' => Key::TYPE_NAME
     * ]);
     * ```
     *
     * @see https://cloud.google.com/datastore/reference/rest/v1beta3/Key Key
     * @see https://cloud.google.com/datastore/reference/rest/v1beta3/Key#PathElement PathElement
     *
     * @param string $kind The kind
     * @param string|int $identifier The ID or name.
     * @param array $options {
     *     Configuration Options
     *
     *     @type string $identifierType If omitted, type will be determined
     *           internally. In cases where any ambiguity can be expected (i.e.
     *           if you want to create keys with `name` but you anticipate a
     *           numeric name), this value should be explicitly set using
     *           `Key::TYPE_ID` or `Key::TYPE_NAME`.
     *     @type string $namespaceId Partitions data under a namespace. Useful for
     *           [Multitenant Projects](https://cloud.google.com/datastore/docs/concepts/multitenancy)
     * }
     * @return Key
     */
    public function key($kind, $identifier = null, array $options = [])
    {
        $options = $options + [
            'namespaceId' => null,
            'identifierType' => null
        ];

        $key = new Key($this->projectId, $options);
        $key->pathElement($kind, $identifier, $options['identifierType']);

        return $key;
    }

    /**
     * Create multiple keys with the same configuration.
     *
     * When inserting multiple entities, creating a set of keys at once can be
     * useful. By defining the Key's kind and any ancestors up front, and
     * allowing Cloud Datastore to allocate IDs, you can be sure that your
     * entity settings are correct and that there will be no collisions during
     * the insert operation.
     *
     * By default, IDs will be allocated to each key, requiring a service
     * request. This can be disabled in the method options. Note that only a
     * single service request will be executed, regardless of the number of keys
     * generated, up to 500 keys (due to limits in Cloud Datastore).
     *
     * Example:
     * ```
     * $keys = $datastore->keys('Person', [
     *     'number' => 10
     * ]);
     * ```
     *
     * ```
     * // You can disable automatic allocation of IDs
     * $keys = $datastore->keys('Person', [
     *     'number' => 10,
     *     'allocateIds' => false
     * ]);
     *
     * echo $keys[0]->state(); // 'incomplete'
     *
     * $keys = $datastore->allocateIds($keys);
     *
     * echo $keys[0]->state(); // 'complete'
     * ```
     *
     * ```
     * // Ancestor paths can be specified
     * $keys = $datastore->keys('Person', [
     *     'ancestors' => [
     *         ['kind' => 'Person', 'name' => 'Grandpa Joe'],
     *         ['kind' => 'Person', 'name' => 'Dad Mike']
     *     ],
     *     'number' => 3
     * ]);
     * ```
     *
     * @see https://cloud.google.com/datastore/reference/rest/v1beta3/Key Key
     * @see https://cloud.google.com/datastore/reference/rest/v1beta3/Key#PathElement PathElement
     *
     * @param string $kind The kind to use in the final path element
     * @param array $options {
     *     Configuration Options
     *
     *     @type array[] $ancestors An array of
     *           [PathElement](https://cloud.google.com/datastore/reference/rest/v1/Key#PathElement) arrays. Use to
     *           create [ancestor paths](https://cloud.google.com/datastore/docs/concepts/entities#ancestor_paths).
     *     @type bool $allocateIds Whether to automatically allocate IDs in the Datastore service. Set to `true` by
     *           default. If set to `true`, a service request will be executed.
     *     @type string $namespaceId Partitions data under a namespace. Useful for
     *           [Multitenant Projects](https://cloud.google.com/datastore/docs/concepts/multitenancy)
     *     @type int $number The number of keys to generate
     *     @type string|int $id The ID for the last pathElement
     *     @type string $name The Name for the last pathElement
     * }
     * @return Key[]
     */
    public function keys($kind, array $options = [])
    {
        $options = $options + [
            'number' => 1,
            'allocateIds' => true,
            'namespaceId' => null,
            'ancestors' => [],
            'id' => null,
            'name' => null
        ];

        $path = [];
        if (count($options['ancestors']) > 0) {
            $path = $options['ancestors'];
        }

        $path[] = array_filter([
            'kind' => $kind,
            'id' => $options['id'],
            'name' => $options['name']
        ]);

        $key = new Key($this->projectId, [
            'path' => $path,
            'namespaceId' => $options['namespaceId']
        ]);

        $keys = array_fill(0, $options['number'], $key);

        if ($options['allocateIds']) {
            $keys = $this->allocateIds($keys);
        }

        return $keys;
    }

    /**
     * Create an entity.
     *
     * This method does not execute any service requests.
     *
     * ```
     * $key = $datastore->key('Person', 'Bob');
     * $entity = $datastore->entity($key, [
     *     'firstName' => 'Bob',
     *     'lastName' => 'Testguy'
     * ]);
     * ```
     *
     * ```
     * // Entities can be manipulated via PHP's arrayaccess:
     * $entity['firstName'] = 'Bob';
     * $entity['lastName'] = 'Testguy';
     *
     * echo $entity['firstName']; // 'Bob'
     * ```
     *
     * @see https://cloud.google.com/datastore/reference/rest/v1beta3/Entity Entity
     *
     * @param Key $key The Key used to uniquely identify this entity. Only
     *        complete keys may be used.
     * @param array $entity The data to fill the entity with.
     * @param array $options See {@see Google\Cloud\Datastore\Entity::__construct()} for documentation.
     * @return Entity
     */
    public function entity(Key $key, array $entity = [], array $options = [])
    {
        return new Entity($key, $entity, $options);
    }

    /**
     * Allocates an available ID to a given incomplete key
     *
     * Key MUST be in an incomplete state (i.e. including a kind but not an ID
     * or name in its final pathElement).
     *
     * This method will execute a service request.
     *
     * Example:
     * ```
     * $key = $datastore->key('Person');
     * $allocatedId = $datastore->allocateId($key);
     * ```
     *
     * @see https://cloud.google.com/datastore/reference/rest/v1beta3/projects/allocateIds allocateIds
     *
     * @param Key $key The incomplete key
     * @param array $options Configuration options
     * @return Key
     */
    public function allocateId(Key $key, array $options = [])
    {
        $res = $this->allocateIds([$key], $options);
        return $res[0];
    }

    /**
     * Allocate available IDs to a set of keys
     *
     * Keys MUST be in an incomplete state (i.e. including a kind but not an ID
     * or name in their final pathElement).
     *
     * This method will execute a service request.
     *
     * Example:
     * ```
     * $keys = [
     *     $datastore->key('Person'),
     *     $datastore->key('Person')
     * ];
     *
     * $allocatedIds = $datastore->allocateIds($keys);
     * ```
     *
     * @see https://cloud.google.com/datastore/reference/rest/v1beta3/projects/allocateIds allocateIds
     *
     * @param Key[] $keys The incomplete keys
     * @param array $options Configuration options
     * @return Key[]
     */
    public function allocateIds(array $keys, array $options = [])
    {
        // Validate the given keys. First check types, then state of each.
        // The API will throw a 400 if the key is complete, but it's an easy
        // check we can handle before going to the API to save a request.
        // @todo replace with json schema
        $this->validateBatch($keys, Key::class, function ($key) {
            if ($key->state() !== Key::STATE_INCOMPLETE) {
                throw new InvalidArgumentException(sprintf(
                    'Given $key is in an invalid state. Can only allocate IDs for incomplete keys. ' .
                    'Given path was %s',
                    (string) $key
                ));
            }
        });

        $res = $this->connection->allocateIds([
            'projectId' => $this->projectId,
            'keys' => $keys
        ] + $options);

        $keys = [];
        if (isset($res['keys'])) {
            foreach ($res['keys'] as $key) {
                $keys[] = new Key($this->projectId, [
                    'path' => $key['path'],
                    'namespaceId' => (isset($key['partitionId']['namespaceId']))
                        ? $key['partitionId']['namespaceId']
                        : null
                ]);
            }
        }

        return $keys;
    }

    /**
     * Create a transaction instance from an existing transaction ID
     *
     * Example:
     * ```
     * $transaction = $datastore->transaction($transactionId);
     * ```
     *
     * @see https://cloud.google.com/datastore/docs/concepts/transactions Datastore Transactions
     *
     * @param string $transactionId The unique transaction identifier.
     * @return Transaction
     */
    public function transaction($transactionId)
    {
        return new Transaction(
            $this->connection,
            $this->projectId,
            $transactionId
        );
    }

    /**
     * Begin a new transaction
     *
     * Example:
     * ```
     * $transaction = $datastore->beginTransaction();
     * ```
     *
     * @see https://cloud.google.com/datastore/docs/concepts/transactions Datastore Transactions
     * @see https://cloud.google.com/datastore/reference/rest/v1beta3/projects/beginTransaction beginTransaction
     *
     * @return Transaction
     */
    public function beginTransaction(array $options = [])
    {
        $res = $this->connection->beginTransaction($options + [
            'projectId' => $this->projectId
        ]);

        return $this->transaction($res['transaction']);
    }

    /**
     * Create an operation
     *
     * An Operation can be used to build complex queries before committing.
     *
     * Example:
     * ```
     * $operation = $datastore->operation();
     * ```
     *
     * @param array $options {
     *     @type bool $runInTransaction If true, a new transaction will be
     *           started.
     *     @type Transaction $transaction If a Transaction is given, operation
     *           will run in transaction.
     * }
     * @return Operation
     */
    public function operation(array $options = [])
    {
        $options = $options + [
            'runInTransaction' => false,
            'transaction' => null
        ];

        if ($options['transaction'] && !($options['transaction'] instanceof Transaction)) {
            throw new InvalidArgumentException(
                'Given $transaction must be an instance of Transaction'
            );
        }

        $transaction = null;
        if ($options['transaction']) {
            $transaction = $options['transaction'];
        } elseif ($options['runInTransaction']) {
            $transaction = $this->beginTransaction($options);
        }

        return new Operation($this->connection, $this->projectId, $transaction);
    }

    /**
     * Insert an entity
     *
     * Example:
     * ```
     * $key = $datastore->key('person', 'Bob');
     * $entity = $datastore->entity($key, ['firstName' => 'Bob']);
     *
     * $datastore->insert($entity);
     * ```
     *
     * @param Entity $entity The entity to be inserted
     * @param array $options {
     *     Configuration Options
     *
     *     @type Transaction $transaction Run this operation in a transaction.
     * }
     * @return void
     */
    public function insert(Entity $entity, array $options = [])
    {
        $this->runOperation('insertBatch', [$entity], $options);
    }

    /**
     * Insert multiple entities
     *
     * Example:
     * ```
     * $keys = $datastore->keys(['kind' => 'person'], [
     *     'allocateIds' => true,
     *     'number' => 2
     * ]);
     *
     * $entities = [
     *     $datastore->entity($key[0], ['firstName' => 'Bob']),
     *     $datastore->entity($key[1], ['firstName' => 'John'])
     * ];
     *
     * $datastore->insertBatch($entities);
     * ```
     *
     * @param Entity[] $entities The entities to be inserted
     * @param array $options {
     *     Configuration Options
     *
     *     @type Transaction $transaction Run this operation in a transaction.
     * }
     * @return void
     */
    public function insertBatch(array $entities, array $options = [])
    {
        return $this->runOperation('insertBatch', $entities, $options);
    }

    /**
     * Update an entity
     *
     * Example:
     * ```
     * $entity['firstName'] = 'Bob';
     *
     * $datastore->update($entity);
     * ```
     *
     * @param Entity $entity The entity to be updated
     * @param array $options {
     *     Configuration Options
     *
     *     @type Transaction $transaction Run this operation in a transaction.
     * }
     * @return void
     */
    public function update(Entity $entity, array $options = [])
    {
        return  $this->runOperation('updateBatch', [$entity], $options);
    }

    /**
     * Update multiple entities
     *
     * Example:
     * ```
     * $entities[0]['firstName'] = 'Bob';
     * $entities[1]['firstName'] = 'John';
     *
     * $datastore->updateBatch($entities);
     * ```
     *
     * @param Entity[] $entities The entities to be updated
     * @param array $options {
     *     Configuration Options
     *
     *     @type Transaction $transaction Run this operation in a transaction.
     * }
     * @return void
     */
    public function updateBatch(array $entities, array $options = [])
    {
        return $this->runOperation('updateBatch', $entities, $options);
    }

    /**
     * Upsert an entity
     *
     * Upsert will create a record if one does not already exist, or overwrite
     * existing record if one already exists.
     *
     * Example:
     * ```
     * $key = $datastore->key('person', 'Bob']);
     * $entity = $datastore->entity($key, ['firstName' => 'Bob']);
     *
     * $datastore->upsert($entity);
     * ```
     *
     * @param Entity $entity The entity to be upserted
     * @param array $options {
     *     Configuration Options
     *
     *     @type Transaction $transaction Run this operation in a transaction.
     * }
     * @return void
     */
    public function upsert(Entity $entity, array $options = [])
    {
        return $this->runOperation('upsertBatch', [$entity], $options);
    }

    /**
     * Upsert multiple entities
     *
     * Upsert will create a record if one does not already exist, or overwrite
     * existing record if one already exists.
     *
     * Example:
     * ```
     * $keys = $datastore->keys(['kind' => 'person'], [
     *     'allocateIds' => true,
     *     'number' => 2
     * ]);
     *
     * $entities = [
     *     $datastore->entity($key[0], ['firstName' => 'Bob']),
     *     $datastore->entity($key[1], ['firstName' => 'John'])
     * ];
     *
     * $datastore->upsertBatch($entities);
     * ```
     *
     * @param Entity[] $entities The entities to be upserted
     * @param array $options {
     *     Configuration Options
     *
     *     @type Transaction $transaction Run this operation in a transaction.
     * }
     * @return void
     */
    public function upsertBatch(array $entities, array $options = [])
    {
        return $this->runOperation('upsertBatch', $entities, $options);
    }

    /**
     * Delete an entity
     *
     * Example:
     * ```
     * $key = $datastore->key('person', 'Bob']);
     *
     * $datastore->delete($key);
     * ```
     *
     * @param Key $key The identifier to delete
     * @param array $options {
     *     Configuration Options
     *
     *     @type Transaction $transaction Run this operation in a transaction.
     * }
     * @return void
     */
    public function delete(Key $key, array $options = [])
    {
        return $this->runOperation('deleteBatch', [$key], $options);
    }

    /**
     * Delete multiple entities
     *
     * Example:
     * ```
     * $keys = [
     *     $datastore->key('person', 'Bob'),
     *     $datastore->key('person', 'John')
     * ];
     *
     * $datastore->deleteBatch($keys);
     * ```
     *
     * @param Key[] $keys The identifiers to delete
     * @param array $options {
     *     Configuration Options
     *
     *     @type Transaction $transaction Run this operation in a transaction.
     * }
     * @return void
     */
    public function deleteBatch(array $keys, array $options = [])
    {
        return $this->runOperation('deleteBatch', $keys, $options);
    }

    /**
     * Retrieve an entity from the datastore
     *
     * Example:
     * ```
     * $key = $datastore->key('person', 'Bob');
     *
     * $entity = $datastore->lookup($key);
     * if (!is_null($entity)) {
     *     echo $entity['firstName']; // 'Bob'
     * }
     * ```
     *
     * @param Key $key $key The identifier to use to locate a desired entity
     * @param Transaction $transaction Run the lookup in a {@see Google\Cloud\Datastore\Transaction}
     * @param array $options See {@see Google\Cloud\Datastore\DatastoreClient::getBatch()}.
     * @return Entity|null
     */
    public function lookup(Key $key, array $options = [])
    {
        $res = $this->lookupBatch([$key], $options);

        return (isset($res['found'][0]))
            ? $res['found'][0]
            : null;
    }

    /**
     * Get multiple entities
     *
     * Example:
     * ```
     * $keys = [
     *     $datastore->key('Person', 'Bob'),
     *     $datastore->key('Person', 'John')
     * ];
     *
     * $entities = $datastore->lookup($keys);
     *
     * foreach ($entities['found'] as $entity) {
     *     echo $entity['firstName'];
     * }
     * ```
     *
     * @codingStandardsIgnoreStart
     * @param Key[] $key The identifier to look up.
     * @param array $options {
     *     Configuration Options
     *
     *     @type string $readConsistency See
     *           [ReadConsistency](https://cloud.google.com/datastore/reference/rest/v1beta3/ReadOptions#ReadConsistency).
     *     @type Transaction $transaction Run the lookup in a {@see Google\Cloud\Datastore\Transaction}
     * }
     * @return array
     * @codingStandardsIgnoreEnd
     */
    public function lookupBatch(array $keys, array $options = [])
    {
        $this->validateBatch($keys, Key::class, function ($key) {
            if ($key->state() !== Key::STATE_COMPLETE) {
                throw new InvalidArgumentException(sprintf(
                    'Given $key is in an invalid state. Can only lookup records when given a complete key. ' .
                    'Given path was %s',
                    (string) $key
                ));
            }
        });

        $res = $this->connection->lookup($options + [
            'projectId' => $this->projectId,
            'readOptions' => $this->readOptions($options),
            'keys' => $keys
        ]);

        $result = [];
        if (isset($res['found'])) {
            $result['found'] = $this->mapEntityResult($res['found']);
        }

        if (isset($res['missing'])) {
            $result['missing'] = $this->mapEntityResult($res['missing']);
        }

        if (isset($res['deferred'])) {
            $result['deferred'] = [];
            foreach ($res['deferred'] as $deferred) {
                $key = $this->key(
                    $deferred['path'],
                    $deferred['partitionId']
                );

                $result['deferred'][] = $key;
            }
        }

        return $result;
    }

    /**
     * Create a Query
     *
     * The Query class can be used as a builder, or it can accept a query
     * representation at instantiation.
     *
     * Example:
     * ```
     * $query = $datastore->query();
     * ```
     *
     * @param array $options {
     *     Query Options
     *
     *     @type array $query [Query](https://cloud.google.com/datastore/reference/rest/v1beta3/projects/runQuery#query)
     * }
     * @return Query
     */
    public function query(array $options = [])
    {
        return new Query($this->projectId, $options);
    }

    /**
     * Create a GqlQuery
     *
     * Example:
     * ```
     * $query = $datastore->gqlQuery('SELECT * FROM people');
     * ```
     *
     * ```
     * // Literals must be provided as bound parameters by default:
     * $query = $datastore->gqlQuery('SELECT * FROM people WHERE firstName = @firstName', [
     *     'bindings' => [
     *         'firstName' => 'Bob'
     *     ]
     * ]);
     * ```
     *
     * ```
     * // Positional binding is also supported
     * $query = $datastore->gqlQuery('SELECT * FROM Companies WHERE companyName = @1 LIMIT 1', [
     *     'bindings' => [
     *         'Google'
     *     ]
     * ]);
     * ```
     *
     * ```
     * // While not recommended, you can use literals in your query string:
     * $query = $datastore->gqlQuery("SELECT * FROM people WHERE firstName = 'Bob'", [
     *     'allowLiterals' => true
     * ]);
     * ```
     *
     * @param string $query The [GQL Query](https://cloud.google.com/datastore/docs/apis/gql/gql_reference) string
     * @param array $options See {@see Google\Cloud\Datastore\Query\GqlQuery::__construct()} for supported options.
     * @return GqlQuery
     */
    public function gqlQuery($query, array $options = [])
    {
        return new GqlQuery($query, $this->projectId, $options);
    }

    /**
     * Run a query and return entities
     *
     * Example:
     * ```
     * $result = $datastore->runQuery($query);
     *
     * foreach ($result as $entity) {
     *     echo $entity['firstName'];
     * }
     * ```
     *
     * @param QueryInterface $query
     * @param array $options Configuration Options
     * @return \Generator<Google\Cloud\Datastore\Entity>
     */
    public function runQuery(QueryInterface $query, array $options = [])
    {
        $moreResults = true;
        do {
            $request = $query->queryObject();

            $res = $this->connection->runQuery($request + $options + [
                'projectId' => $this->projectId
            ]);

            if (isset($res['batch']['entityResults']) && is_array($res['batch']['entityResults'])) {
                $results = $this->mapEntityResult($res['batch']['entityResults']);
                foreach ($results as $result) {
                    yield $result;
                }

                if ($query->canPaginate() && $res['batch']['moreResults'] !== 'NO_MORE_RESULTS') {
                    $query->start($res['batch']['endCursor']);
                } else {
                    $moreResults = false;
                }
            } else {
                $moreResults = false;
            }
        } while ($moreResults);
    }

    private function runOperation($method, array $entities, array $options = [])
    {
        $operation = $this->operation($options);

        call_user_func_array([$operation, $method], [$entities]);

        return $operation->commit($options);
    }

    /**
     * Convert an EntityResult into an array of entities
     *
     * @param array $entityResult [EntityResult](https://cloud.google.com/datastore/reference/rest/v1beta3/EntityResult)
     * @return Entity[]
     */
    private function mapEntityResult(array $entityResult)
    {
        $entities = [];

        foreach ($entityResult as $result) {
            $namespaceId = (isset($result['entity']['key']['partitionId']['namespaceId']))
                ? $result['entity']['key']['partitionId']['namespaceId']
                : null;

            $key = new Key($this->projectId, [
                'path' => $result['entity']['key']['path'],
                'namespaceId' => $namespaceId
            ]);

            $props = $result['entity']['properties'];
            array_walk($props, function (&$property) {
                $property = current($property);
            });

            $entities[] = $this->entity($key, $props, [
                'cursor' => (isset($result['cursor']))
                    ? $result['cursor']
                    : null
            ]);
        }

        return $entities;
    }
}

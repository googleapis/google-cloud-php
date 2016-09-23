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

use DomainException;
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
 *
 * Cloud Datastore supports [multi-tenant](https://cloud.google.com/datastore/docs/concepts/multitenancy) applications
 * through use of data partitions. A partition ID can be supplied when creating an instance of Cloud Datastore, and will
 * be used in all operations executed in that instance.
 *
 * Example:
 * ```
 * use Google\Cloud\ServiceBuilder;
 *
 * $cloud = new ServiceBuilder();
 *
 * $datastore = $cloud->datastore();
 * ```
 *
 * ```
 * // DatastoreClient can be instantiated directly.
 * use Google\Cloud\Datastore\DatastoreClient;
 *
 * $datastore = new DatastoreClient();
 * ```
 *
 * ```
 * // Multi-tenant applications can supply a namespace ID.
 * use Google\Cloud\ServiceBuilder;
 *
 * $cloud = new ServiceBuilder();
 *
 * $datastore = $cloud->datastore([
 *     'projectId' => 'my-awesome-project',
 *     'namespaceId' => 'my-application-namespace'
 * ]);
 * ```
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
     * @var Operation
     */
    protected $operation;

    /**
     * @var EntityMapper
     */
    private $entityMapper;

    /**
     * Create a Datastore client.
     *
     * @param array $config [optional] {
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
     *     @type int $retries Number of retries for a failed request. **Defaults
     *           to** `3`.
     *     @type array $scopes Scopes to be used for the request.
     *     @type string $namespaceId Partitions data under a namespace. Useful for
     *           [Multitenant Projects](https://cloud.google.com/datastore/docs/concepts/multitenancy).
     * }
     * @throws \InvalidArgumentException
     */
    public function __construct(array $config = [])
    {
        $config = $config + [
            'namespaceId' => null
        ];

        if (!isset($config['scopes'])) {
            $config['scopes'] = [self::FULL_CONTROL_SCOPE];
        }

        $this->connection = new Rest($this->configureAuthentication($config));

        // The second parameter here should change to a variable
        // when gRPC support is added for variable encoding.
        $this->entityMapper = new EntityMapper($this->projectId, true);
        $this->operation = new Operation(
            $this->connection,
            $this->projectId,
            $config['namespaceId'],
            $this->entityMapper
        );
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
     * @see https://cloud.google.com/datastore/reference/rest/v1/Key Key
     * @see https://cloud.google.com/datastore/reference/rest/v1/Key#PathElement PathElement
     *
     * @param string $kind The kind.
     * @param string|int $identifier [optional] The ID or name.
     * @param array $options [optional] {
     *     Configuration Options
     *
     *     @type string $identifierType If omitted, type will be determined
     *           internally. In cases where any ambiguity can be expected (i.e.
     *           if you want to create keys with `name` but your values may
     *           pass PHP's `is_numeric()` check), this value may be
     *           explicitly set using `Key::TYPE_ID` or `Key::TYPE_NAME`.
     * }
     * @return Key
     */
    public function key($kind, $identifier = null, array $options = [])
    {
        return $this->operation->key($kind, $identifier, $options);
    }

    /**
     * Create multiple keys with the same configuration.
     *
     * When inserting multiple entities, creating a set of keys at once can be
     * useful. By defining the Key's kind and any ancestors up front, and
     * allowing Cloud Datastore to allocate IDs, you can be sure that your
     * entity identity and ancestry are correct and that there will be no
     * collisions during the insert operation.
     *
     * Example:
     * ```
     * $keys = $datastore->keys('Person', [
     *     'number' => 10
     * ]);
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
     * @see https://cloud.google.com/datastore/reference/rest/v1/Key Key
     * @see https://cloud.google.com/datastore/reference/rest/v1/Key#PathElement PathElement
     *
     * @param string $kind The kind to use in the final path element.
     * @param array $options [optional] {
     *     Configuration Options
     *
     *     @type array[] $ancestors An array of
     *           [PathElement](https://cloud.google.com/datastore/reference/rest/v1/Key#PathElement) arrays. Use to
     *           create [ancestor paths](https://cloud.google.com/datastore/docs/concepts/entities#ancestor_paths).
     *     @type int $number The number of keys to generate.
     *     @type string|int $id The ID for the last pathElement.
     *     @type string $name The Name for the last pathElement.
     * }
     * @return Key[]
     */
    public function keys($kind, array $options = [])
    {
        return $this->operation->keys($kind, $options);
    }

    /**
     * Create an entity.
     *
     * This method does not execute any service requests.
     *
     * Entities are created with a Datastore Key, or by specifying a Kind. Kinds
     * are only allowed for insert operations. For any other case, you must
     * specify a complete key. If a kind is given, an ID will be automatically
     * allocated for the entity upon insert. Additionally, if your entity
     * requires a complex key elementPath, you must create the key separately.
     *
     * In complex applications you may want to create your own entity types.
     * Google Cloud PHP supports subclassing of {@see Google\Cloud\Datastore\Entity}.
     * If the name of a subclass of Entity is given in the options array, an
     * entity will be created with that class rather than the default class.
     *
     * Example:
     * ```
     * $key = $datastore->key('Person', 'Bob');
     * $entity = $datastore->entity($key, [
     *     'firstName' => 'Bob',
     *     'lastName' => 'Testguy'
     * ]);
     * ```
     *
     * ```
     * // Both of the following has the identical effect as the previous example.
     * $entity = $datastore->entity($key);
     *
     * $entity['firstName'] = 'Bob';
     * $entity['lastName'] = 'Testguy';
     *
     * $entity = $datastore->entity($key);
     *
     * $entity->firstName = 'Bob';
     * $entity->lastName = 'Testguy';
     * ```
     *
     * ```
     * // Entities can be created with a Kind only, for inserting into datastore
     * $entity = $datastore->entity('Person');
     * ```
     *
     * ```
     * // Entities can be custom classes extending the built-in Entity class.
     * class Person extends Google\Cloud\Datastore\Entity
     * {}
     *
     * $person = $datastore->entity('Person', [ 'firstName' => 'Bob'], [
     *     'className' => Person::class
     * ]);
     *
     * echo get_class($person); // `Person`
     * ```
     *
     * ```
     * // If you wish to exclude certain properties from datastore indexes,
     * // property names may be supplied in the method $options:
     *
     * $entity = $datastore->entity('Person', [
     *     'firstName' => 'Bob',
     *     'dateOfBirth' => new DateTime('January 31, 1969')
     * ], [
     *     'excludeFromIndexes' => [
     *         'dateOfBirth'
     *     ]
     * ]);
     * ```
     *
     * @see https://cloud.google.com/datastore/reference/rest/v1/Entity Entity
     *
     * @param Key|string $key The key used to identify the record, or a string $kind.
     * @param array $entity [optional] The data to fill the entity with.
     * @param array $options [optional] {
     *     Configuration Options
     *
     *     @type string $className The name of a class extending {@see Google\Cloud\Datastore\Entity}.
     *           If provided, an instance of that class will be returned instead of Entity.
     *           If not set, {@see Google\Cloud\Datastore\Entity} will be used.
     *     @type array $excludeFromIndexes A list of entity keys to exclude from
     *           datastore indexes.
     * }
     * @return Entity
     */
    public function entity($key, array $entity = [], array $options = [])
    {
        return $this->operation->entity($key, $entity, $options);
    }

    /**
     * Create a new GeoPoint
     *
     * Example:
     * ```
     * $geoPoint = $datastore->geoPoint(37.4220, -122.0841);
     * ```
     *
     * @see https://cloud.google.com/datastore/reference/rest/Shared.Types/LatLng LatLng
     *
     * @param float $latitude The latitude
     * @param float $longitude The longitude
     * @return GeoPoint
     */
    public function geoPoint($latitude, $longitude)
    {
        return new GeoPoint($latitude, $longitude);
    }

    /**
     * Create a new Blob
     *
     * Example:
     * ```
     * $blob = $datastore->blob('hello world');
     * ```
     *
     * ```
     * // Blobs can be used to store binary data
     * $blob = $datastore->blob(file_get_contents(__DIR__ .'/family-photo.jpg'));
     * ```
     *
     * @param string|resource|StreamInterface $value
     * @return Blob
     */
    public function blob($value)
    {
        return new Blob($value);
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
     * $keyWithAllocatedId = $datastore->allocateId($key);
     * ```
     *
     * @see https://cloud.google.com/datastore/reference/rest/v1/projects/allocateIds allocateIds
     *
     * @param Key $key The incomplete key.
     * @param array $options [optional] Configuration options.
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
     * $keysWithAllocatedIds = $datastore->allocateIds($keys);
     * ```
     *
     * @see https://cloud.google.com/datastore/reference/rest/v1/projects/allocateIds allocateIds
     *
     * @param Key[] $keys The incomplete keys.
     * @param array $options [optional] Configuration options.
     * @return Key[]
     */
    public function allocateIds(array $keys, array $options = [])
    {
        return $this->operation->allocateIds($keys, $options);
    }

    /**
     * Create a Transaction
     *
     * Example:
     * ```
     * $transaction = $datastore->transaction();
     * ```
     *
     * @see https://cloud.google.com/datastore/docs/concepts/transactions Datastore Transactions
     *
     * @param array $options [optional] Configuration options.
     * @return Transaction
     */
    public function transaction(array $options = [])
    {
        $res = $this->connection->beginTransaction($options + [
            'projectId' => $this->projectId
        ]);

        return new Transaction(
            clone $this->operation,
            $this->projectId,
            $res['transaction']
        );
    }

    /**
     * Insert an entity
     *
     * An entity with incomplete keys will be allocated an ID prior to insertion.
     *
     * Insert by this method is non-transactional. If you need transaction
     * support, use {@see Google\Cloud\Datastore\Transaction::insert()}.
     *
     * Example:
     * ```
     * $key = $datastore->key('Person', 'Bob');
     * $entity = $datastore->entity($key, ['firstName' => 'Bob']);
     *
     * $datastore->insert($entity);
     * ```
     *
     * @param Entity $entity The entity to be inserted.
     * @param array $options [optional] Configuration options.
     * @return string The entity version.
     * @throws DomainException If a conflict occurs, fail.
     */
    public function insert(Entity $entity, array $options = [])
    {
        $res = $this->insertBatch([$entity], $options);
        return $this->parseSingleMutationResult($res);
    }

    /**
     * Insert multiple entities
     *
     * Any entity with incomplete keys will be allocated an ID prior to insertion.
     *
     * Insert by this method is non-transactional. If you need transaction
     * support, use {@see Google\Cloud\Datastore\Transaction::insertBatch()}.
     *
     * Example:
     * ```
     *
     * $entities = [
     *     $datastore->entity('Person', ['firstName' => 'Bob']),
     *     $datastore->entity('Person', ['firstName' => 'John'])
     * ];
     *
     * $datastore->insertBatch($entities);
     * ```
     *
     * @param Entity[] $entities The entities to be inserted.
     * @param array $options [optional] Configuration options.
     * @return array [Response Body](https://cloud.google.com/datastore/reference/rest/v1/projects/commit#response-body)
     */
    public function insertBatch(array $entities, array $options = [])
    {
        $entities = $this->operation->allocateIdsToEntities($entities);
        $this->operation->mutate('insert', $entities, Entity::class);
        return $this->operation->commit($options);
    }

    /**
     * Update an entity
     *
     * Please note that updating a record in Cloud Datastore will replace the
     * existing record. Adding, editing or removing a single property is only
     * possible by first retrieving the entire entity in its existing state.
     *
     * Update by this method is non-transactional. If you need transaction
     * support, use {@see Google\Cloud\Datastore\Transaction::update()}.
     *
     * Example:
     * ```
     * $entity = $datastore->lookup($datastore->key('Person', 'Bob'));
     * $entity['firstName'] = 'John';
     *
     * $datastore->update($entity);
     * ```
     *
     * @param Entity $entity The entity to be updated.
     * @param array $options [optional] {
     *     Configuration Options
     *
     *     @type bool $allowOverwrite Entities must be updated as an entire
     *           resource. Patch operations are not supported. Because entities
     *           can be created manually, or obtained by a lookup or query, it
     *           is possible to accidentally overwrite an existing record with a
     *           new one when manually creating an entity. To provide additional
     *           safety, this flag must be set to `true` in order to update a
     *           record when the entity provided was not obtained through a
     *           lookup or query. **Defaults to** `false`.
     * }
     * @return string The entity version.
     * @throws DomainException If a conflict occurs, fail.
     */
    public function update(Entity $entity, array $options = [])
    {
        $res = $this->updateBatch([$entity], $options);
        return $this->parseSingleMutationResult($res);
    }

    /**
     * Update multiple entities
     *
     * Please note that updating a record in Cloud Datastore will replace the
     * existing record. Adding, editing or removing a single property is only
     * possible by first retrieving the entire entity in its existing state.
     *
     * Update by this method is non-transactional. If you need transaction
     * support, use {@see Google\Cloud\Datastore\Transaction::updateBatch()}.
     *
     * Example:
     * ```
     * $entities[0]['firstName'] = 'Bob';
     * $entities[1]['firstName'] = 'John';
     *
     * $datastore->updateBatch($entities);
     * ```
     *
     * @param Entity[] $entities The entities to be updated.
     * @param array $options [optional] {
     *     Configuration Options
     *
     *     @type bool $allowOverwrite Entities must be updated as an entire
     *           resource. Patch operations are not supported. Because entities
     *           can be created manually, or obtained by a lookup or query, it
     *           is possible to accidentally overwrite an existing record with a
     *           new one when manually creating an entity. To provide additional
     *           safety, this flag must be set to `true` in order to update a
     *           record when the entity provided was not obtained through a
     *           lookup or query. **Defaults to** `false`.
     * }
     * @return array [Response Body](https://cloud.google.com/datastore/reference/rest/v1/projects/commit#response-body)
     */
    public function updateBatch(array $entities, array $options = [])
    {
        $options += [
            'allowOverwrite' => false
        ];

        $this->operation->checkOverwrite($entities, $options['allowOverwrite']);
        $this->operation->mutate('update', $entities, Entity::class);
        return $this->operation->commit($options);
    }

    /**
     * Upsert an entity
     *
     * Upsert will create a record if one does not already exist, or overwrite
     * existing record if one already exists.
     *
     * Please note that upserting a record in Cloud Datastore will replace the
     * existing record, if one exists. Adding, editing or removing a single
     * property is only possible by first retrieving the entire entity in its
     * existing state.
     *
     * Upsert by this method is non-transactional. If you need transaction
     * support, use {@see Google\Cloud\Datastore\Transaction::upsert()}.
     *
     * Example:
     * ```
     * $key = $datastore->key('Person', 'Bob']);
     * $entity = $datastore->entity($key, ['firstName' => 'Bob']);
     *
     * $datastore->upsert($entity);
     * ```
     *
     * @param Entity $entity The entity to be upserted.
     * @param array $options [optional] Configuration Options.
     * @return string The entity version.
     * @throws DomainException If a conflict occurs, fail.
     */
    public function upsert(Entity $entity, array $options = [])
    {
        $res = $this->upsertBatch([$entity], $options);
        return $this->parseSingleMutationResult($res);
    }

    /**
     * Upsert multiple entities
     *
     * Upsert will create a record if one does not already exist, or overwrite
     * an existing record if one already exists.
     *
     * Please note that upserting a record in Cloud Datastore will replace the
     * existing record, if one exists. Adding, editing or removing a single
     * property is only possible by first retrieving the entire entity in its
     * existing state.
     *
     * Upsert by this method is non-transactional. If you need transaction
     * support, use {@see Google\Cloud\Datastore\Transaction::upsertBatch()}.
     *
     * Example:
     * ```
     * $keys = [
     *     $datastore->key('Person', 'Bob'),
     *     $datastore->key('Person', 'John')
     * ];
     *
     * $entities = [
     *     $datastore->entity($key[0], ['firstName' => 'Bob']),
     *     $datastore->entity($key[1], ['firstName' => 'John'])
     * ];
     *
     * $datastore->upsertBatch($entities);
     * ```
     *
     * @param Entity[] $entities The entities to be upserted.
     * @param array $options [optional] Configuration Options.
     * @return array [Response Body](https://cloud.google.com/datastore/reference/rest/v1/projects/commit#response-body)
     */
    public function upsertBatch(array $entities, array $options = [])
    {
        $this->operation->mutate('upsert', $entities, Entity::class);
        return $this->operation->commit($options);
    }

    /**
     * Delete an entity
     *
     * Deletion by this method is non-transactional. If you need transaction
     * support, use {@see Google\Cloud\Datastore\Transaction::delete()}.
     *
     * Example:
     * ```
     * $key = $datastore->key('Person', 'Bob');
     *
     * $datastore->delete($key);
     * ```
     *
     * @param Key $key The identifier to delete.
     * @param array $options [optional] {
     *     Configuration options
     *
     *     @type string $baseVersion Provides concurrency control. The version
     *           of the entity that this mutation is being applied to. If this
     *           does not match the current version on the server, the mutation
     *           conflicts.
     * }
     * @return string The updated entity version number.
     * @throws DomainException If a conflict occurs, fail.
     */
    public function delete(Key $key, array $options = [])
    {
        $res = $this->deleteBatch([$key], $options);
        return $this->parseSingleMutationResult($res);
    }

    /**
     * Delete multiple entities
     *
     * Deletion by this method is non-transactional. If you need transaction
     * support, use {@see Google\Cloud\Datastore\Transaction::deleteBatch()}.
     *
     * Example:
     * ```
     * $keys = [
     *     $datastore->key('Person', 'Bob'),
     *     $datastore->key('Person', 'John')
     * ];
     *
     * $datastore->deleteBatch($keys);
     * ```
     *
     * @param Key[] $keys The identifiers to delete.
     * @param array $options [optional] {
     *     Configuration options
     *
     *     @type string $baseVersion Provides concurrency control. The version
     *           of the entity that this mutation is being applied to. If this
     *           does not match the current version on the server, the mutation
     *           conflicts.
     * }
     * @return array [Response Body](https://cloud.google.com/datastore/reference/rest/v1/projects/commit#response-body)
     */
    public function deleteBatch(array $keys, array $options = [])
    {
        $options += [
            'baseVersion' => null
        ];

        $this->operation->mutate('delete', $keys, Key::class, $options['baseVersion']);
        return $this->operation->commit($options);
    }

    /**
     * Retrieve an entity from the datastore
     *
     * To lookup an entity inside a transaction, use
     * {@see Google\Cloud\Datastore\Transaction::lookup()}.
     *
     * Example:
     * ```
     * $key = $datastore->key('Person', 'Bob');
     *
     * $entity = $datastore->lookup($key);
     * if (!is_null($entity)) {
     *     echo $entity['firstName']; // 'Bob'
     * }
     * ```
     *
     * @param Key $key $key The identifier to use to locate a desired entity.
     * @param array $options [optional] {
     *     Configuration Options
     *
     *     @type string $readConsistency See
     *           [ReadConsistency](https://cloud.google.com/datastore/reference/rest/v1/ReadOptions#ReadConsistency).
     *           **Defaults to** `"EVENTUAL"`.
     *     @type string $className The name of the class to return results as.
     *           Must be a subclass of {@see Google\Cloud\Datastore\Entity}.
     *           If not set, {@see Google\Cloud\Datastore\Entity} will be used.
     * }
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
     * To lookup entities inside a transaction, use
     * {@see Google\Cloud\Datastore\Transaction::lookupBatch()}.
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
     * @param Key[] $key The identifiers to look up.
     * @param array $options [optional] {
     *     Configuration Options
     *
     *     @type string $readConsistency See
     *           [ReadConsistency](https://cloud.google.com/datastore/reference/rest/v1/ReadOptions#ReadConsistency).
     *           **Defaults to** `"EVENTUAL"`.
     *     @type string|array $className If a string, the name of the class to return results as.
     *           Must be a subclass of {@see Google\Cloud\Datastore\Entity}.
     *           If not set, {@see Google\Cloud\Datastore\Entity} will be used.
     *           If an array is given, it must be an associative array, where
     *           the key is a Kind and the value is the name of a subclass of
     *           {@see Google\Cloud\Datastore\Entity}.
     * }
     * @return array Returns an array with keys [`found`, `missing`, and `deferred`].
     *         Members of `found` will be instance of
     *         {@see Google\Cloud\Datastore\Entity}. Members of `missing` and
     *         `deferred` will be instance of {@see Google\Cloud\Datastore\Key}.
     */
    public function lookupBatch(array $keys, array $options = [])
    {
        return $this->operation->lookup($keys, $options);
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
     * @param array $options [optional] {
     *     Query Options
     *
     *     @type array $query [Query](https://cloud.google.com/datastore/reference/rest/v1/projects/runQuery#query)
     * }
     * @return Query
     */
    public function query(array $options = [])
    {
        return new Query($this->entityMapper, $options);
    }

    /**
     * Create a GqlQuery
     *
     * Example:
     * ```
     * $query = $datastore->gqlQuery('SELECT * FROM Companies');
     * ```
     *
     * ```
     * // Literals must be provided as bound parameters by default:
     * $query = $datastore->gqlQuery('SELECT * FROM Companies WHERE companyName = @companyName', [
     *     'bindings' => [
     *         'companyName' => 'Bob'
     *     ]
     * ]);
     * ```
     *
     * ```
     * // Positional binding is also supported:
     * $query = $datastore->gqlQuery('SELECT * FROM Companies WHERE companyName = @1 LIMIT 1', [
     *     'bindings' => [
     *         'Google'
     *     ]
     * ]);
     * ```
     *
     * ```
     * // While not recommended, you can use literals in your query string:
     * $query = $datastore->gqlQuery("SELECT * FROM Companies WHERE companyName = 'Google'", [
     *     'allowLiterals' => true
     * ]);
     * ```
     *
     * @param string $query The [GQL Query](https://cloud.google.com/datastore/docs/apis/gql/gql_reference) string.
     * @param array $options [optional] {
     *     Configuration Options
     *
     *     @type bool $allowLiterals Whether literal values will be allowed in
     *           the query string. Parameter binding is strongly encouraged over
     *           literals. **Defaults to** `false`.
     *     @type array $bindings An array of values to bind to the query string.
     *           Queries using Named Bindings should provide a key/value set,
     *           while queries using Positional Bindings must provide a simple
     *           array.
     *     @type string $readConsistency See
     *           [ReadConsistency](https://cloud.google.com/datastore/reference/rest/v1/ReadOptions#ReadConsistency).
     *           **Defaults to** `"EVENTUAL"`.
     * }
     * @return GqlQuery
     */
    public function gqlQuery($query, array $options = [])
    {
        return new GqlQuery($this->entityMapper, $query, $options);
    }

    /**
     * Run a query and return entities
     *
     * To query datastore inside a transaction, use
     * {@see Google\Cloud\Datastore\Transaction::runQuery()}.
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
     * @param QueryInterface $query A query object.
     * @param array $options [optional] {
     *     Configuration Options
     *
     *     @type string $className The name of the class to return results as.
     *           Must be a subclass of {@see Google\Cloud\Datastore\Entity}.
     *           If not set, {@see Google\Cloud\Datastore\Entity} will be used.
     *     @type string $readConsistency See
     *           [ReadConsistency](https://cloud.google.com/datastore/reference/rest/v1/ReadOptions#ReadConsistency).
     *           **Defaults to** `"EVENTUAL"`.
     * }
     * @return \Generator<Google\Cloud\Datastore\Entity>
     */
    public function runQuery(QueryInterface $query, array $options = [])
    {
        return $this->operation->runQuery($query, $options);
    }

    /**
     * Handle mutation results
     *
     * @codingStandardsIgnoreStart
     * @param array $res [MutationResult](https://cloud.google.com/datastore/reference/rest/v1/projects/commit#MutationResult)
     * @return string
     * @throws DomainException
     * @codingStandardsIgnoreEnd
     */
    private function parseSingleMutationResult(array $res)
    {
        $mutationResult = $res['mutationResults'][0];

        if (isset($mutationResult['conflictDetected'])) {
            throw new DomainException(
                'A conflict was detected in the mutation. ' .
                'The operation failed.'
            );
        }

        return $mutationResult['version'];
    }
}

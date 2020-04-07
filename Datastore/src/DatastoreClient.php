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
use Google\Auth\FetchAuthTokenInterface;
use Google\Cloud\Core\ArrayTrait;
use Google\Cloud\Core\ClientTrait;
use Google\Cloud\Core\Int64;
use Google\Cloud\Datastore\Connection\ConnectionInterface;
use Google\Cloud\Datastore\Connection\Grpc;
use Google\Cloud\Datastore\Connection\Rest;
use Google\Cloud\Datastore\Query\GqlQuery;
use Google\Cloud\Datastore\Query\Query;
use Google\Cloud\Datastore\Query\QueryInterface;
use InvalidArgumentException;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Http\Message\StreamInterface;

/**
 * Google Cloud Datastore is a highly-scalable NoSQL database for your
 * applications. Find more information at the
 * [Google Cloud Datastore docs](https://cloud.google.com/datastore/docs/).
 *
 * Cloud Datastore supports
 * [multi-tenant](https://cloud.google.com/datastore/docs/concepts/multitenancy)
 * applications through use of data partitions. A partition ID can be supplied
 * when creating an instance of Cloud Datastore, and will be used in all
 * operations executed in that instance.
 *
 * To enable the
 * [Google Cloud Datastore Emulator](https://cloud.google.com/datastore/docs/tools/datastore-emulator),
 * set the [`DATASTORE_EMULATOR_HOST`](https://goo.gl/vCVZrY) environment variable.
 *
 * Example:
 * ```
 * use Google\Cloud\Datastore\DatastoreClient;
 *
 * $datastore = new DatastoreClient();
 * ```
 *
 * ```
 * // Multi-tenant applications can supply a namespace ID.
 * use Google\Cloud\Datastore\DatastoreClient;
 *
 * $datastore = new DatastoreClient([
 *     'namespaceId' => 'my-application-namespace'
 * ]);
 * ```
 *
 * ```
 * // Using the Datastore Emulator
 * use Google\Cloud\Datastore\DatastoreClient;
 *
 * // Be sure to use the port specified when starting the emulator.
 * // `8900` is used as an example only.
 * putenv('DATASTORE_EMULATOR_HOST=localhost:8900');
 *
 * $datastore = new DatastoreClient();
 * ```
 */
class DatastoreClient
{
    use ArrayTrait;
    use ClientTrait;
    use DatastoreTrait;

    const VERSION = '1.11.2';

    const FULL_CONTROL_SCOPE = 'https://www.googleapis.com/auth/datastore';

    /**
     * @deprecated
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
     *     @type string $apiEndpoint A hostname with optional port to use in
     *           place of the service's default endpoint.
     *     @type string $projectId The project ID from the Google Developer's
     *           Console.
     *     @type CacheItemPoolInterface $authCache A cache for storing access
     *           tokens. **Defaults to** a simple in memory implementation.
     *     @type array $authCacheOptions Cache configuration options.
     *     @type callable $authHttpHandler A handler used to deliver Psr7
     *           requests specifically for authentication.
     *     @type FetchAuthTokenInterface $credentialsFetcher A credentials
     *           fetcher instance.
     *     @type callable $httpHandler A handler used to deliver Psr7 requests.
     *           Only valid for requests sent over REST.
     *     @type array $keyFile The contents of the service account credentials
     *           .json file retrieved from the Google Developer's Console.
     *           Ex: `json_decode(file_get_contents($path), true)`.
     *     @type string $keyFilePath The full path to your service account
     *           credentials .json file retrieved from the Google Developers
     *           Console.
     *     @type float $requestTimeout Seconds to wait before timing out the
     *           request. **Defaults to** `0` with REST and `60` with gRPC.
     *     @type int $retries Number of retries for a failed request. **Defaults
     *           to** `3`.
     *     @type array $scopes Scopes to be used for the request.
     *     @type string $namespaceId Partitions data under a namespace. Useful for
     *           [Multitenant Projects](https://cloud.google.com/datastore/docs/concepts/multitenancy).
     *     @type bool $returnInt64AsObject If true, 64 bit integers will be
     *           returned as a {@see Google\Cloud\Core\Int64} object for 32 bit
     *           platform compatibility. **Defaults to** false.
     * }
     * @throws \InvalidArgumentException
     */
    public function __construct(array $config = [])
    {
        $emulatorHost = getenv('DATASTORE_EMULATOR_HOST');

        $connectionType = $this->getConnectionType($config);

        $config += [
            'namespaceId' => null,
            'returnInt64AsObject' => false,
            'scopes' => [self::FULL_CONTROL_SCOPE],
            'projectIdRequired' => true,
            'hasEmulator' => (bool) $emulatorHost,
            'emulatorHost' => $emulatorHost
        ];

        $config = $this->configureAuthentication($config);
        $this->connection = $connectionType === 'grpc'
            ? new Grpc($config)
            : new Rest($config);

        // The second parameter here should change to a variable
        // when gRPC support is added for variable encoding.
        $this->entityMapper = new EntityMapper($this->projectId, true, $config['returnInt64AsObject']);
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
     * specify a named key. If a kind is given, an ID will be automatically
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
     * //[snippet=array]
     * // Entity values can be assigned and accessed via the array syntax.
     * $entity = $datastore->entity($key);
     *
     * $entity['firstName'] = 'Bob';
     * $entity['lastName'] = 'Testguy';
     * ```
     *
     * ```
     * //[snippet=object_accessor]
     * // Entity values can also be assigned and accessed via an object syntax.
     * $entity = $datastore->entity($key);
     *
     * $entity->firstName = 'Bob';
     * $entity->lastName = 'Testguy';
     * ```
     *
     * ```
     * //[snippet=incomplete]
     * // Entities can be created with a Kind only, for inserting into datastore
     * $entity = $datastore->entity('Person');
     * ```
     *
     * ```
     * //[snippet=custom_class_interface]
     * // Entities can be custom classes implementing the Datastore entity interface.
     * use Google\Cloud\Datastore\EntityTrait;
     * use Google\Cloud\Datastore\EntityInterface;
     *
     * class PersonEntity implements EntityInterface
     * {
     *     use EntityTrait;
     * }
     *
     * $person = $datastore->entity('Person', [ 'firstName' => 'Bob'], [
     *     'className' => PersonEntity::class
     * ]);
     *
     * echo get_class($person); // `Person`
     * ```
     *
     * ```
     * //[snippet=custom_class_extends]
     * // Custom entity types may also extend the built-in Entity class.
     * use Google\Cloud\Datastore\Entity;
     *
     * class OtherPersonEntity extends Entity
     * {}
     *
     * $person = $datastore->entity('Person', [ 'firstName' => 'Bob'], [
     *     'className' => OtherPersonEntity::class
     * ]);
     *
     * echo get_class($person); // `Person`
     * ```
     *
     * ```
     * //[snippet=exclude_indexes]
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
     * @param Key|string|null $key [optional] The key used to identify the record, or
     *        a string $kind. The key may be null only if the entity will be
     *        used as an embedded entity within another entity. Attempting to
     *        use keyless entities as root entities will result in error.
     *        **Defaults to** `null`.
     * @param array $entity [optional] The data, provided as an array of keys
     *        and values to fill the entity with. **Defaults to** `[]`.
     * @param array $options [optional] {
     *     Configuration Options
     *
     *     @type string $className If set, the given class will be returned.
     *           Value must be the name of a class implementing
     *           {@see Google\Cloud\Datastore\EntityInterface}. **Defaults to**
     *           {@see Google\Cloud\Datastore\Entity}.
     *     @type array $excludeFromIndexes A list of entity keys to exclude from
     *           datastore indexes.
     * }
     * @return EntityInterface
     */
    public function entity($key = null, array $entity = [], array $options = [])
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
     * @param bool $allowNull [optional] Whether null values are allowed.
     *        **Defaults to** `false`.
     * @return GeoPoint
     */
    public function geoPoint($latitude, $longitude, $allowNull = false)
    {
        return new GeoPoint($latitude, $longitude, $allowNull);
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
     * @param string|resource|StreamInterface $value The value to store in a blob.
     * @return Blob
     */
    public function blob($value)
    {
        return new Blob($value);
    }

    /**
     * Create an Int64 object. This can be used to work with 64 bit integers as
     * a string value while on a 32 bit platform.
     *
     * Example:
     * ```
     * $int64 = $datastore->int64('9223372036854775807');
     * ```
     *
     * @param string $value
     * @return Int64
     */
    public function int64($value)
    {
        return new Int64($value);
    }

    /**
     * Create a Cursor.
     *
     * A cursor points to a position within a set of entities. Cloud Datastore
     * uses Cursors for paginating query results.
     *
     * Example:
     * ```
     * $cursor = $datastore->cursor($cursorValue);
     * ```
     *
     * @param string|int $cursorValue
     * @return Cursor
     */
    public function cursor($cursorValue)
    {
        return new Cursor($cursorValue);
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
     * Create a Transaction.
     *
     * Example:
     * ```
     * $transaction = $datastore->transaction();
     * ```
     *
     * @see https://cloud.google.com/datastore/docs/concepts/transactions Datastore Transactions
     * @see https://cloud.google.com/datastore/docs/reference/rest/v1/projects/beginTransaction beginTransaction
     *
     * @codingStandardsIgnoreStart
     * @param array $options {
     *     Configuration options.
     *
     *     @type array $transactionOptions Transaction configuration. See
     *           [ReadWrite](https://cloud.google.com/datastore/docs/reference/rest/v1/projects/beginTransaction#ReadWrite).
     * }
     * @return Transaction
     * @codingStandardsIgnoreEnd
     */
    public function transaction(array $options = [])
    {
        $transaction = $this->operation->beginTransaction([
            // if empty, force request to encode as {} rather than [].
            'readWrite' => $this->pluck('transactionOptions', $options, false) ?: (object) []
        ], $options);

        return new Transaction(
            $this->operation,
            $this->projectId,
            $transaction
        );
    }
    /**
     * Create a Read-Only Transaction.
     *
     * Example:
     * ```
     * $transaction = $datastore->readOnlyTransaction();
     * ```
     *
     * @see https://cloud.google.com/datastore/docs/concepts/transactions Datastore Transactions
     * @see https://cloud.google.com/datastore/docs/reference/rest/v1/projects/beginTransaction beginTransaction
     *
     * @codingStandardsIgnoreStart
     * @param array $options {
     *     Configuration options.
     *
     *     @type array $transactionOptions See
     *           [ReadOnly](https://cloud.google.com/datastore/docs/reference/rest/v1/projects/beginTransaction#ReadOnly).
     * }
     * @return ReadOnlyTransaction
     * @codingStandardsIgnoreEnd
     */
    public function readOnlyTransaction(array $options = [])
    {
        $transaction = $this->operation->beginTransaction([
            // if empty, force request to encode as {} rather than [].
            'readOnly' => $this->pluck('transactionOptions', $options, false) ?: (object) []
        ], $options);

        return new ReadOnlyTransaction(
            $this->operation,
            $this->projectId,
            $transaction
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
     * @see https://cloud.google.com/datastore/docs/reference/rest/v1/projects/commit Commit API documentation
     *
     * @param EntityInterface $entity The entity to be inserted.
     * @param array $options [optional] Configuration options.
     * @return string The entity version.
     * @throws DomainException If a conflict occurs, fail.
     */
    public function insert(EntityInterface $entity, array $options = [])
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
     * @see https://cloud.google.com/datastore/docs/reference/rest/v1/projects/commit Commit API documentation
     *
     * @param EntityInterface[] $entities The entities to be inserted.
     * @param array $options [optional] Configuration options.
     * @return array [Response Body](https://cloud.google.com/datastore/reference/rest/v1/projects/commit#response-body)
     */
    public function insertBatch(array $entities, array $options = [])
    {
        $entities = $this->operation->allocateIdsToEntities($entities);
        $mutations = [];
        foreach ($entities as $entity) {
            $mutations[] = $this->operation->mutation('insert', $entity, Entity::class);
        }

        return $this->operation->commit($mutations, $options);
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
     * $entity['firstName'] = 'John';
     *
     * $datastore->update($entity);
     * ```
     *
     * @see https://cloud.google.com/datastore/docs/reference/rest/v1/projects/commit Commit API documentation
     *
     * @param EntityInterface $entity The entity to be updated.
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
    public function update(EntityInterface $entity, array $options = [])
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
     * @see https://cloud.google.com/datastore/docs/reference/rest/v1/projects/commit Commit API documentation
     *
     * @param EntityInterface[] $entities The entities to be updated.
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
        $mutations = [];
        foreach ($entities as $entity) {
            $mutations[] = $this->operation->mutation('update', $entity, Entity::class);
        }

        return $this->operation->commit($mutations, $options);
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
     * An entity with incomplete keys will be allocated an ID prior to insertion.
     *
     * Upsert by this method is non-transactional. If you need transaction
     * support, use {@see Google\Cloud\Datastore\Transaction::upsert()}.
     *
     * Example:
     * ```
     * $key = $datastore->key('Person', 'Bob');
     * $entity = $datastore->entity($key, ['firstName' => 'Bob']);
     *
     * $datastore->upsert($entity);
     * ```
     *
     * @see https://cloud.google.com/datastore/docs/reference/rest/v1/projects/commit Commit API documentation
     *
     * @param EntityInterface $entity The entity to be upserted.
     * @param array $options [optional] Configuration Options.
     * @return string The entity version.
     * @throws DomainException If a conflict occurs, fail.
     */
    public function upsert(EntityInterface $entity, array $options = [])
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
     * Any entity with incomplete keys will be allocated an ID prior to insertion.
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
     *     $datastore->entity($keys[0], ['firstName' => 'Bob']),
     *     $datastore->entity($keys[1], ['firstName' => 'John'])
     * ];
     *
     * $datastore->upsertBatch($entities);
     * ```
     *
     * @see https://cloud.google.com/datastore/docs/reference/rest/v1/projects/commit Commit API documentation
     *
     * @param EntityInterface[] $entities The entities to be upserted.
     * @param array $options [optional] Configuration Options.
     * @return array [Response Body](https://cloud.google.com/datastore/reference/rest/v1/projects/commit#response-body)
     */
    public function upsertBatch(array $entities, array $options = [])
    {
        $entities = $this->operation->allocateIdsToEntities($entities);
        $mutations = [];
        foreach ($entities as $entity) {
            $mutations[] = $this->operation->mutation('upsert', $entity, Entity::class);
        }

        return $this->operation->commit($mutations, $options);
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
     * @see https://cloud.google.com/datastore/docs/reference/rest/v1/projects/commit Commit API documentation
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
     * @see https://cloud.google.com/datastore/docs/reference/rest/v1/projects/commit Commit API documentation
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

        $mutations = [];
        foreach ($keys as $key) {
            $mutations[] = $this->operation->mutation('delete', $key, Key::class, $options['baseVersion']);
        }

        return $this->operation->commit($mutations, $options);
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
     * @see https://cloud.google.com/datastore/docs/reference/rest/v1/projects/lookup Lookup API documentation
     *
     * @param Key $key The identifier to use to locate a desired entity.
     * @param array $options [optional] {
     *     Configuration Options
     *
     *     @type string $readConsistency See
     *           [ReadConsistency](https://cloud.google.com/datastore/reference/rest/v1/ReadOptions#ReadConsistency).
     *     @type string $className If set, the given class will be returned.
     *           Value must be the name of a class implementing
     *           {@see Google\Cloud\Datastore\EntityInterface}. **Defaults to**
     *           {@see Google\Cloud\Datastore\Entity}.
     * }
     * @return EntityInterface|null
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
     * $entities = $datastore->lookupBatch($keys);
     *
     * foreach ($entities['found'] as $entity) {
     *     echo $entity['firstName'] . PHP_EOL;
     * }
     * ```
     *
     * @see https://cloud.google.com/datastore/docs/reference/rest/v1/projects/lookup Lookup API documentation
     *
     * @param Key[] $keys The identifiers to look up.
     * @param array $options [optional] {
     *     Configuration Options
     *
     *     @type string $readConsistency See
     *           [ReadConsistency](https://cloud.google.com/datastore/reference/rest/v1/ReadOptions#ReadConsistency).
     *     @type string|array $className If a string, the given class will be
     *           returned. Value must be the name of a class implementing
     *           {@see Google\Cloud\Datastore\EntityInterface}.
     *           If an array is given, it must be an associative array, where
     *           the key is a Kind and the value must implement
     *           {@see Google\Cloud\Datastore\EntityInterface}. **Defaults to**
     *           {@see Google\Cloud\Datastore\Entity}.
     *     @type bool $sort If set to true, results in each set will be sorted
     *           to match the order given in $keys. **Defaults to** `false`.
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
     * Create a Query object.
     *
     * The Query class can be used as a builder, or it can accept a query
     * representation at instantiation.
     *
     * Example:
     * ```
     * $query = $datastore->query();
     * ```
     *
     * @param array $query [Query](https://cloud.google.com/datastore/reference/rest/v1/projects/runQuery#query)
     * @return Query
     */
    public function query(array $query = [])
    {
        return new Query($this->entityMapper, [
            'query' => $query
        ]);
    }

    /**
     * Create a GqlQuery object.
     *
     * Returns a Query object which can be executed using
     * {@see Google\Cloud\Datastore\DatastoreClient::runQuery()}.
     *
     * Example:
     * ```
     * $query = $datastore->gqlQuery('SELECT * FROM Companies');
     * ```
     *
     * ```
     * //[snippet=bindings]
     * // Literals must be provided as bound parameters by default:
     * $query = $datastore->gqlQuery('SELECT * FROM Companies WHERE companyName = @companyName', [
     *     'bindings' => [
     *         'companyName' => 'Google'
     *     ]
     * ]);
     * ```
     *
     * ```
     * //[snippet=pos_bindings]
     * // Positional binding is also supported:
     * $query = $datastore->gqlQuery('SELECT * FROM Companies WHERE companyName = @1 LIMIT 1', [
     *     'bindings' => [
     *         'Google'
     *     ]
     * ]);
     * ```
     *
     * ```
     * //[snippet=literals]
     * // While not recommended, you can use literals in your query string:
     * $query = $datastore->gqlQuery('SELECT * FROM Companies WHERE companyName = \'Google\'', [
     *     'allowLiterals' => true
     * ]);
     * ```
     *
     * ```
     * //[snippet=cursor]
     * // Using cursors as query bindings:
     * $cursor = $datastore->cursor($cursorValue);
     *
     * $query = $datastore->gqlQuery('SELECT * FROM Companies OFFSET @offset', [
     *     'bindings' => [
     *         'offset' => $cursor
     *     ]
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
     *           array. Query cursors may be provided using instances of
     *           {@see Google\Cloud\Datastore\Cursor}.
     *     @type string $readConsistency See
     *           [ReadConsistency](https://cloud.google.com/datastore/reference/rest/v1/ReadOptions#ReadConsistency).
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
     * @see https://cloud.google.com/datastore/docs/reference/rest/v1/projects/runQuery RunQuery API documentation
     *
     * @param QueryInterface $query A query object.
     * @param array $options [optional] {
     *     Configuration Options
     *
     *     @type string $className If set, the given class will be returned.
     *           Value must be the name of a class implementing
     *           {@see Google\Cloud\Datastore\EntityInterface}. **Defaults to**
     *           {@see Google\Cloud\Datastore\Entity}.
     *     @type string $readConsistency See
     *           [ReadConsistency](https://cloud.google.com/datastore/reference/rest/v1/ReadOptions#ReadConsistency).
     * }
     * @return EntityIterator<EntityInterface>
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

        if (isset($mutationResult['conflictDetected']) && $mutationResult['conflictDetected']) {
            throw new DomainException(
                'A conflict was detected in the mutation. ' .
                'The operation failed.'
            );
        }

        // cast to string for conformance between REST and gRPC.
        return (string) $mutationResult['version'];
    }
}

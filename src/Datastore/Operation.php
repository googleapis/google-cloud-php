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

use Google\Cloud\Core\ValidateTrait;
use Google\Cloud\Datastore\Connection\ConnectionInterface;
use Google\Cloud\Datastore\Connection\Rest;
use Google\Cloud\Datastore\Query\QueryInterface;
use InvalidArgumentException;

/**
 * Run lookups and queries and commit changes.
 *
 * This class is used by {@see Google\Cloud\Datastore\DatastoreClient}
 * and {@see Google\Cloud\Datastore\Transaction} and is not intended to be used
 * directly.
 *
 * Examples are omitted for brevity. Detailed usage examples can be found in
 * {@see Google\Cloud\Datastore\DatastoreClient} and
 * {@see Google\Cloud\Datastore\Transaction}.
 */
class Operation
{
    use DatastoreTrait;
    use ValidateTrait;

    /**
     * @var ConnectionInterface
     */
    protected $connection;

    /**
     * @var string
     */
    private $projectId;

    /**
     * @var string
     */
    private $namespaceId;

    /**
     * @var string
     */
    private $entityMapper;

    /**
     * Create an operation
     *
     * @param ConnectionInterface $connection A connection to Google Cloud Platform's Datastore API.
     * @param string $projectId The Google Cloud Platform project ID.
     * @param string $namespaceId The namespace to use for all service requests.
     */
    public function __construct(
        ConnectionInterface $connection,
        $projectId,
        $namespaceId,
        EntityMapper $entityMapper
    ) {
        $this->connection = $connection;
        $this->projectId = $projectId;
        $this->namespaceId = $namespaceId;
        $this->entityMapper = $entityMapper;
    }

    /**
     * Create a single Key instance
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
        $options += [
            'namespaceId' => $this->namespaceId
        ];

        $key = new Key($this->projectId, $options);
        $key->pathElement($kind, $identifier, $options);

        return $key;
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
        $options += [
            'number' => 1,
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
            'namespaceId' => $this->namespaceId
        ]);

        $keys = array_fill(0, $options['number'], $key);

        return $keys;
    }

    /**
     * Create an entity
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
     * instance of the subclass will be returned instead of Entity.
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
     * @throws InvalidArgumentException
     */
    public function entity($key, array $entity = [], array $options = [])
    {
        $options += [
            'className' => null
        ];

        if (!is_string($key) && !($key instanceof Key)) {
            throw new InvalidArgumentException(
                '$key must be an instance of Key or a string'
            );
        }

        if (is_string($key)) {
            $key = $this->key($key);
        }

        $className = $options['className'];
        if (!is_null($className) && !is_subclass_of($className, Entity::class)) {
            throw new InvalidArgumentException(sprintf(
                'Given classname %s is not a subclass of Entity',
                $className
            ));
        }

        if (is_null($className)) {
            $className = Entity::class;
        }

        return new $className($key, $entity, $options);
    }

    /**
     * Allocate available IDs to a set of keys
     *
     * Keys MUST be in an incomplete state (i.e. including a kind but not an ID
     * or name in their final pathElement).
     *
     * This method will execute a service request.
     *
     * @see https://cloud.google.com/datastore/reference/rest/v1/projects/allocateIds allocateIds
     *
     * @param Key[] $keys The incomplete keys.
     * @param array $options [optional] Configuration Options.
     * @return Key[]
     * @throws InvalidArgumentException
     */
    public function allocateIds(array $keys, array $options = [])
    {
        // Validate the given keys. First check types, then state of each.
        // The API will throw a 400 if the key is named, but it's an easy
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

        if (isset($res['keys'])) {
            foreach ($res['keys'] as $index => $key) {
                if (!isset($keys[$index])) {
                    continue;
                }

                $end = end($key['path']);
                $id = $end['id'];
                $keys[$index]->setLastElementIdentifier($id);
            }
        }

        return $keys;
    }

    /**
     * Lookup records by key
     *
     * @param Key[] $keys The identifiers to look up.
     * @param array $options [optional] {
     *     Configuration Options
     *
     *     @type string $readConsistency See
     *           [ReadConsistency](https://cloud.google.com/datastore/reference/rest/v1/ReadOptions#ReadConsistency).
     *     @type string $transaction The transaction ID, if the query should be
     *           run in a transaction.
     *     @type string|array $className If a string, the name of the class to return results as.
     *           Must be a subclass of {@see Google\Cloud\Datastore\Entity}.
     *           If not set, {@see Google\Cloud\Datastore\Entity} will be used.
     *           If an array is given, it must be an associative array, where
     *           the key is a Kind and the value is the name of a subclass of
     *           {@see Google\Cloud\Datastore\Entity}.
     *     @type bool $sort If set to true, results in each set will be sorted
     *           to match the order given in $keys. **Defaults to** `false`.
     * }
     * @return array Returns an array with keys [`found`, `missing`, and `deferred`].
     *         Members of `found` will be instance of
     *         {@see Google\Cloud\Datastore\Entity}. Members of `missing` and
     *         `deferred` will be instance of {@see Google\Cloud\Datastore\Key}.
     * @throws InvalidArgumentException
     */
    public function lookup(array $keys, array $options = [])
    {
        $options += [
            'className' => null,
            'sort' => false
        ];

        $this->validateBatch($keys, Key::class, function ($key) {
            if ($key->state() !== Key::STATE_NAMED) {
                throw new InvalidArgumentException(sprintf(
                    'Given $key is in an invalid state. Can only lookup records when given a complete key. ' .
                    'Given path was %s',
                    (string) $key
                ));
            }
        });

        $res = $this->connection->lookup($options + $this->readOptions($options) + [
            'projectId' => $this->projectId,
            'keys' => $keys
        ]);

        $result = [];
        if (isset($res['found'])) {
            foreach ($res['found'] as $found) {
                $result['found'][] = $this->mapEntityResult($found, $options['className']);
            }

            if ($options['sort']) {
                $result['found'] = $this->sortEntities($result['found'], $keys);
            }
        }

        if (isset($res['missing'])) {
            $result['missing'] = [];
            foreach ($res['missing'] as $missing) {
                $key = $this->key(
                    $missing['entity']['key']['path'],
                    $missing['entity']['key']['partitionId']
                );

                $result['missing'][] = $key;
            }
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
     * Run a query and return entities
     *
     * @param QueryInterface $query The query object.
     * @param array $options [optional] {
     *     Configuration Options
     *
     *     @type string $transaction The transaction ID, if the query should be
     *           run in a transaction.
     *     @type string $className The name of the class to return results as.
     *           Must be a subclass of {@see Google\Cloud\Datastore\Entity}.
     *           If not set, {@see Google\Cloud\Datastore\Entity} will be used.
     *     @type string $readConsistency See
     *           [ReadConsistency](https://cloud.google.com/datastore/reference/rest/v1/ReadOptions#ReadConsistency).
     * }
     * @return EntityIterator<Google\Cloud\Datastore\Entity>
     */
    public function runQuery(QueryInterface $query, array $options = [])
    {
        $options += [
            'className' => null,
            'namespaceId' => $this->namespaceId
        ];
        $request = $options + $this->readOptions($options) + [
            'projectId' => $this->projectId,
            'partitionId' => $this->partitionId($this->projectId, $options['namespaceId']),
            $query->queryKey() => $query->queryObject()
        ];
        $iteratorConfig = [
            'itemsKey' => 'batch.entityResults',
            'resultTokenKey' => 'query.startCursor',
            'nextResultTokenKey' => 'batch.endCursor',
            'setNextResultTokenCondition' => function ($res) use ($query) {
                if (isset($res['batch']['moreResults'])) {
                    return $query->canPaginate() && $res['batch']['moreResults'] === 'NOT_FINISHED';
                }

                return false;
            }
        ];

        return new EntityIterator(
            new EntityPageIterator(
                function (array $entityResult) use ($options) {
                    return $this->mapEntityResult($entityResult, $options['className']);
                },
                [$this->connection, 'runQuery'],
                $request,
                $iteratorConfig
            )
        );
    }

    /**
     * Commit all mutations
     *
     * Calling this method will end the operation (and close the transaction,
     * if one is specified).
     *
     * @codingStandardsIgnoreStart
     * @param array $mutations [Mutation[]](https://cloud.google.com/datastore/docs/reference/rest/v1/projects/commit#Mutation).
     * @param array $options [optional] {
     *     Configuration Options
     *
     *     @type string $transaction The transaction ID, if the query should be
     *           run in a transaction.
     * }
     * @return array [Response Body](https://cloud.google.com/datastore/reference/rest/v1/projects/commit#response-body)
     * @codingStandardsIgnoreEnd
     */
    public function commit(array $mutations, array $options = [])
    {
        $options += [
            'transaction' => null
        ];

        $res = $this->connection->commit($options + [
            'mode' => ($options['transaction']) ? 'TRANSACTIONAL' : 'NON_TRANSACTIONAL',
            'mutations' => $mutations,
            'projectId' => $this->projectId
        ]);

        return $res;
    }

    /**
     * Patch any incomplete keys in the given array of entities
     *
     * Any incomplete keys will be allocated an ID. Named keys in the input
     * will remain unchanged.
     *
     * @param Entity[] $entities A list of entities
     * @return Entity[]
     */
    public function allocateIdsToEntities(array $entities)
    {
        $this->validateBatch($entities, Entity::class);

        $incompleteKeys = [];
        foreach ($entities as $entity) {
            if ($entity->key()->state() === Key::STATE_INCOMPLETE) {
                $incompleteKeys[] = $entity->key();
            }
        }

        if (!empty($incompleteKeys)) {
            $keys = $this->allocateIds($incompleteKeys);
        }

        return $entities;
    }

    /**
     * Enqueue a mutation
     *
     * A mutation is a change to the datastore. Create, Update and Delete are
     * examples of mutations, while Read is not.
     *
     * Google Cloud Datastore supports multiple mutations in a single API call,
     * subject to the limits of the service. Adding mutations separately from
     * committing the changes allows you to create complex operations, both
     * inside a transaction and not.
     *
     * @see https://cloud.google.com/datastore/docs/concepts/limits Limits
     *
     * @param string $operation The operation to execute. "Insert", "Upsert",
     *        "Update" or "Delete".
     * @param Entity|Key $input The entity or key to mutate.
     * @param string $type The type of the input array.
     * @param string $baseVersion [optional] The version of the entity that this mutation
     *        is being applied to. If this does not match the current version on
     *        the server, the mutation conflicts.
     * @return array [Mutation](https://cloud.google.com/datastore/docs/reference/rest/v1/projects/commit#Mutation).
     * @throws InvalidArgumentException
     */
    public function mutation(
        $operation,
        $input,
        $type,
        $baseVersion = null
    ) {
        // If the given element is an Entity, it will use that baseVersion.
        if ($input instanceof Entity) {
            $baseVersion = $input->baseVersion();
            $data = $this->entityMapper->objectToRequest($input);
        } elseif ($input instanceof Key) {
            $data = $input->keyObject();
        } else {
            throw new InvalidArgumentException(sprintf(
                'Input must be a Key or Entity, %s given',
                get_class($input)
            ));
        }

        return array_filter([
            $operation => $data,
            'baseVersion' => $baseVersion
        ]);
    }

    /**
     * Roll back a transaction
     *
     * @param string $transactionId The transaction to roll back
     * @return void
     */
    public function rollback($transactionId)
    {
        $this->connection->rollback([
            'projectId' => $this->projectId,
            'transaction' => $transactionId
        ]);
    }

    /**
     * Check whether an update or upsert operation may proceed safely
     *
     * @param Entity[] $entities the entities to be updated or upserted.
     * @param bool $allowOverwrite If `true`, entities may be overwritten.
     *        **Defaults to** `false`.
     * @throws InvalidArgumentException
     * @return void
     */
    public function checkOverwrite(array $entities, $allowOverwrite = false)
    {
        $this->validateBatch($entities, Entity::class);

        foreach ($entities as $entity) {
            if (!$entity->populatedByService() && !$allowOverwrite) {
                throw new InvalidArgumentException(sprintf(
                    'Given entity cannot be saved because it may overwrite an '.
                    'existing record. When manually creating entities for '.
                    'update operations, please set the options '.
                    '`$allowOverwrite` flag to `true`. Invalid entity key was %s',
                    (string) $entity->key()
                ));
            }
        }
    }

    /**
     * Convert an EntityResult into an array of entities
     *
     * @see https://cloud.google.com/datastore/reference/rest/v1/EntityResult EntityResult
     *
     * @param array $result The EntityResult from a Lookup.
     * @param string|array $class If a string, the name of the class to return results as.
     *        Must be a subclass of {@see Google\Cloud\Datastore\Entity}.
     *        If not set, {@see Google\Cloud\Datastore\Entity} will be used.
     *        If an array is given, it must be an associative array, where
     *        the key is a Kind and the value is the name of a subclass of
     *        {@see Google\Cloud\Datastore\Entity}.
     * @return Entity[]
     */
    private function mapEntityResult(array $result, $class)
    {
        $entity = $result['entity'];

        $properties = [];
        $excludes = [];
        $meanings = [];

        if (isset($entity['properties'])) {
            $res = $this->entityMapper->responseToEntityProperties($entity['properties']);

            $properties = $res['properties'];
            $excludes = $res['excludes'];
            $meanings = $res['meanings'];
        }

        $namespaceId = (isset($entity['key']['partitionId']['namespaceId']))
            ? $entity['key']['partitionId']['namespaceId']
            : null;

        $key = new Key($this->projectId, [
            'path' => $entity['key']['path'],
            'namespaceId' => $namespaceId
        ]);

        if (is_array($class)) {
            $lastPathElement = $key->pathEnd();
            if (!array_key_exists($lastPathElement['kind'], $class)) {
                throw new InvalidArgumentException(sprintf(
                    'No class found for kind %s',
                    $lastPathElement['kind']
                ));
            }

            $className = $class[$lastPathElement['kind']];
        } else {
            $className = $class;
        }

        return $this->entity($key, $properties, [
            'cursor' => (isset($result['cursor']))
                ? $result['cursor']
                : null,
            'baseVersion' => (isset($result['version']))
                ? $result['version']
                : null,
            'className' => $className,
            'populatedByService' => true,
            'excludeFromIndexes' => $excludes,
            'meanings' => $meanings
        ]);
    }

    /**
     * Format the readOptions
     *
     * @param array $options [optional] {
     *      Read Options
     *
     *      @type string $transaction If set, query or lookup will run in transaction.
     *      @type string $readConsistency See
     *           [ReadConsistency](https://cloud.google.com/datastore/reference/rest/v1/ReadOptions#ReadConsistency).
     * }
     * @return array
     */
    private function readOptions(array $options = [])
    {
        $options += [
            'readConsistency' => null,
            'transaction' => null
        ];

        $readOptions = array_filter([
            'readConsistency' => $options['readConsistency'],
            'transaction' => $options['transaction']
        ]);

        return array_filter([
            'readOptions' => $readOptions
        ]);
    }

    /**
     * Sort entities into the order given in $keys.
     *
     * @param Entity[] $entities
     * @param Key[] $keys
     * @return Entity[]
     */
    private function sortEntities(array $entities, array $keys)
    {
        $map = [];
        foreach ($entities as $entity) {
            $map[(string) $entity->key()] = $entity;
        }

        $ret = [];
        foreach ($keys as $key) {
            if (isset($map[(string) $key])) {
                $ret[] = $map[(string) $key];
            }
        }

        return $ret;
    }
}

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

use Google\Cloud\Datastore\Connection\ConnectionInterface;
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
     * @var array
     */
    private $mutations = [];

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
        $namespaceId
    ) {
        $this->connection = $connection;
        $this->projectId = $projectId;
        $this->namespaceId = $namespaceId;
    }

    /**
     * Create a single Key instance
     *
     * @see https://cloud.google.com/datastore/reference/rest/v1/Key Key
     * @see https://cloud.google.com/datastore/reference/rest/v1/Key#PathElement PathElement
     *
     * @param string $kind The kind.
     * @param string|int $identifier The ID or name.
     * @param array $options {
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
            'identifierType' => null,
            'namespaceId' => $this->namespaceId
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
     * entity identity and ancestry are correct and that there will be no
     * collisions during the insert operation.
     *
     * @see https://cloud.google.com/datastore/reference/rest/v1/Key Key
     * @see https://cloud.google.com/datastore/reference/rest/v1/Key#PathElement PathElement
     *
     * @param string $kind The kind to use in the final path element.
     * @param array $options {
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
     * specify a complete key. If a kind is given, an ID will be automatically
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
     * @param array $entity The data to fill the entity with.
     * @param array $options {
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
     * @param array $options Configuration options.
     * @return Key[]
     * @throws InvalidArgumentException
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

        if (isset($res['keys'])) {
            foreach ($res['keys'] as $index => $key) {
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
     * @codingStandardsIgnoreStart
     * @param Key[] $key The identifiers to look up.
     * @param array $options {
     *     Configuration Options
     *
     *     @type string $readConsistency If not in a transaction, set to STRONG
     *           or EVENTUAL, depending on default value in DatastoreClient.
     *           See
     *           [ReadConsistency](https://cloud.google.com/datastore/reference/rest/v1/ReadOptions#ReadConsistency).
     *     @type string $transaction The transaction ID, if the query should be
     *           run in a transaction.
     *     @type string $className The name of the class to return results as.
     *           Must be a subclass of {@see Google\Cloud\Datastore\Entity}.
     *           If not set, {@see Google\Cloud\Datastore\Entity} will be used.
     * }
     * @return array Returns an array with keys [`found`, `missing`, and `deferred`].
     *         Members of `found` will be instance of
     *         {@see Google\Cloud\Datastore\Entity}. Members of `missing` and
     *         `deferred` will be instance of {@see Google\Cloud\Datastore\Key}.
     * @throws InvalidArgumentException
     * @codingStandardsIgnoreEnd
     */
    public function lookup(array $keys, array $options = [])
    {
        $options += [
            'className' => null
        ];

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
            $result['found'] = $this->mapEntityResult(
                $res['found'],
                $options['className']
            );
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
     * @param array $options {
     *     Configuration Options
     *
     *     @type string $transaction The transaction ID, if the query should be
     *           run in a transaction.
     *     @type string $className The name of the class to return results as.
     *           Must be a subclass of {@see Google\Cloud\Datastore\Entity}.
     *           If not set, {@see Google\Cloud\Datastore\Entity} will be used.
     *     @type string $readConsistency If not in a transaction, set to STRONG
     *           or EVENTUAL, depending on default value in DatastoreClient.
     *           See
     *           [ReadConsistency](https://cloud.google.com/datastore/reference/rest/v1/ReadOptions#ReadConsistency).
     * }
     * @return \Generator<Google\Cloud\Datastore\Entity>
     */
    public function runQuery(QueryInterface $query, array $options = [])
    {
        $options += [
            'className' => null
        ];

        $moreResults = true;
        do {
            $res = $this->connection->runQuery($options + [
                'projectId' => $this->projectId,
                'partitionId' => $this->partitionId($this->projectId, $this->namespaceId),
                'readOptions' => $this->readOptions($options),
                $query->queryKey() => $query->queryObject()
            ]);

            if (isset($res['batch']['entityResults']) && is_array($res['batch']['entityResults'])) {
                $results = $this->mapEntityResult(
                    $res['batch']['entityResults'],
                    $options['className']
                );

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

    /**
     * Commit all mutations
     *
     * Calling this method will end the operation (and close the transaction,
     * if one is specified).
     *
     * @param array $options {
     *     Configuration Options
     *
     *     @type string $transaction The transaction ID, if the query should be
     *           run in a transaction.
     * }
     * @return array [Response Body](https://cloud.google.com/datastore/reference/rest/v1/projects/commit#response-body)
     */
    public function commit(array $options = [])
    {
        $options += [
            'transaction' => null
        ];

        $res = $this->connection->commit($options + [
            'mode' => ($options['transaction']) ? 'TRANSACTIONAL' : 'NON_TRANSACTIONAL',
            'mutations' => $this->mutations,
            'projectId' => $this->projectId
        ]);

        $this->mutations = [];

        return $res;
    }

    /**
     * Patch any incomplete keys in the given array of entities
     *
     * Any incomplete keys will be allocated an ID. Complete keys in the input
     * will remain unchanged.
     *
     * @param Entity[]
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

        $this->allocateIds($incompleteKeys);

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
     * @param Entity[]|Key[] $input The entities or keys to mutate.
     * @param string $type The type of the input array.
     * @param string $baseVersion The version of the entity that this mutation
     *        is being applied to. If this does not match the current version on
     *        the server, the mutation conflicts.
     * @return void
     * @throws InvalidArgumentException
     */
    public function mutate(
        $operation,
        array $input,
        $type,
        $baseVersion = null
    ) {
        $this->validateBatch($input, $type);

        foreach ($input as $element) {
            // If the given element is an Entity, it will use that baseVersion.
            if ($element instanceof Entity) {
                $baseVersion = $element->baseVersion();
                $data = $element->entityObject();
            } elseif ($element instanceof Key) {
                $data = $element->keyObject();
            } else {
                throw new InvalidArgumentException(sprintf(
                    'Element must be a Key or Entity, %s given',
                    get_class($element)
                ));
            }

            $this->mutations[] = array_filter([
                $operation => $data,
                'baseVersion' => $baseVersion
            ]);
        }
    }

    /**
     * Check whether an update or upsert operation may proceed safely
     *
     * @param Entity[] $entities the entities to be updated or upserted.
     * @param bool $allowOverwrite `false` by default. If `true`, safety will
     *        be disregarded.
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
     * @param array $entityResult The EntityResult from a Lookup.
     * @param string $className the class to create as an entity.
     * @return Entity[]
     */
    private function mapEntityResult(array $entityResult, $className)
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

            $excludes = [];
            array_walk($props, function (&$property, $key) use (&$excludes) {

                // Convert dates to an object
                if (key($property) === 'timestampValue') {
                    $property[key($property)] = new \DateTimeImmutable(current($property));
                }

                // Convert keys to an object
                if (key($property) === 'keyValue') {
                    $keyProp = current($property);
                        $namespaceId = (isset($keyProp['partitionId']['namespaceId']))
                            ? $keyProp['partitionId']['namespaceId']
                            : null;

                    $property[key($property)] = new Key($this->projectId, [
                        'path' => $keyProp['path'],
                        'namespaceId' => $namespaceId
                    ]);
                }

                if (isset($property['excludeFromIndexes']) && $property['excludeFromIndexes']) {
                    $excludes[] = $key;
                }

                $property = current($property);
            });

            $entities[] = $this->entity($key, $props, [
                'cursor' => (isset($result['cursor']))
                    ? $result['cursor']
                    : null,
                'baseVersion' => (isset($result['version']))
                    ? $result['version']
                    : null,
                'populatedByService' => true,
                'excludeFromIndexes' => $excludes,
                'className' => $className
            ]);
        }

        return $entities;
    }

    /**
     * Format the readOptions
     *
     * @param array $options {
     *      Read Options
     *
     *      @type string $transaction If set, query or lookup will run in transaction.
     *      @type string $readConsistency If not in a transaction, set to STRONG
     *            or EVENTUAL, depending on default value in DatastoreClient.
     * }
     * @return array
     */
    private function readOptions(array $options = [])
    {
        $options += [
            'readConsistency' => DatastoreClient::DEFAULT_READ_CONSISTENCY,
            'transaction' => null
        ];

        if ($options['transaction']) {
            return [
                'transaction' => $options['transaction']
            ];
        }

        return [
            'readConsistency' => $options['readConsistency']
        ];
    }

    /**
     * Check that each member of $input array is of type $type.
     *
     * @param array $input The input to validate.
     * @param string $type The type to check..
     * @param callable An additional check for each element of $input.
     *        This will be run count($input) times, so use with care.
     * @return void
     * @throws InvalidArgumentException
     */
    private function validateBatch(
        array $input,
        $type,
        callable $additionalCheck = null
    ) {
        foreach ($input as $element) {
            if (!($element instanceof $type)) {
                throw new InvalidArgumentException(sprintf(
                    'Each member of input array must be an instance of %s',
                    $type
                ));
            }

            if ($additionalCheck) {
                $additionalCheck($element);
            }
        }
    }
}

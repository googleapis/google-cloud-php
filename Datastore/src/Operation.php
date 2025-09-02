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

use Google\ApiCore\Serializer;
use Google\Cloud\Core\Timestamp;
use Google\Cloud\Core\TimestampTrait;
use Google\Cloud\Core\ValidateTrait;
use Google\Cloud\Datastore\Query\AggregationQuery;
use Google\Cloud\Datastore\Query\AggregationQueryResult;
use Google\Cloud\Datastore\Query\Query;
use Google\Cloud\Datastore\Query\QueryInterface;
use Google\Cloud\Datastore\V1\AllocateIdsRequest;
use Google\Cloud\Datastore\V1\BeginTransactionRequest;
use Google\Cloud\Datastore\V1\ExplainOptions;
use Google\Cloud\Datastore\V1\QueryResultBatch\MoreResultsType;
use Google\Cloud\Datastore\V1\Client\DatastoreClient;
use Google\Cloud\Datastore\V1\CommitRequest;
use Google\Cloud\Datastore\V1\CommitRequest\Mode;
use Google\Cloud\Datastore\V1\Key as GrpcKey;
use Google\Cloud\Datastore\V1\LookupRequest;
use Google\Cloud\Datastore\V1\Mutation;
use Google\Cloud\Datastore\V1\ReadOptions;
use Google\Cloud\Datastore\V1\ReadOptions_ReadConsistency;
use Google\Cloud\Datastore\V1\RollbackRequest;
use Google\Cloud\Datastore\V1\RunAggregationQueryRequest;
use Google\Cloud\Datastore\V1\RunQueryRequest;
use Google\Cloud\Datastore\V1\TransactionOptions;
use Google\Protobuf\Timestamp as ProtobufTimestamp;
use InvalidArgumentException;

/**
 * Run lookups and queries and commit changes.
 *
 * This class is used by {@see \Google\Cloud\Datastore\DatastoreClient}
 * and {@see \Google\Cloud\Datastore\Transaction} and is not intended to be used
 * directly.
 *
 * Examples are omitted for brevity. Detailed usage examples can be found in
 * {@see \Google\Cloud\Datastore\DatastoreClient} and
 * {@see \Google\Cloud\Datastore\Transaction}.
 */
class Operation
{
    use DatastoreTrait;
    use ValidateTrait;
    use TimestampTrait;

    /**
     * @var DatastoreClient
     * @internal
     */
    protected DatastoreClient $gapicClient;

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
    private $databaseId;

    /**
     * @var EntityMapper
     */
    private $entityMapper;

    /**
     * @var Serializer
     */
    private Serializer $serializer;

    /**
     * Create an operation
     *
     * @param DatastoreClient $gapicClient A Datastore Gapic Client instance.
     * @param string $projectId The Google Cloud Platform project ID.
     * @param string $namespaceId The namespace to use for all service requests.
     * @param EntityMapper $entityMapper A Datastore Entity Mapper instance.
     * @param string $databaseId ID of the database to which the entities belong.
     */
    public function __construct(
        DatastoreClient $gapicClient,
        $projectId,
        $namespaceId,
        EntityMapper $entityMapper,
        $databaseId = ''
    ) {
        $this->gapicClient = $gapicClient;
        $this->projectId = $projectId;
        $this->namespaceId = $namespaceId;
        $this->databaseId = $databaseId;
        $this->entityMapper = $entityMapper;
        $this->serializer = new Serializer();
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
     *     @type string $databaseId ID of the database to which the entities belong.
     * }
     * @return Key
     */
    public function key($kind, $identifier = null, array $options = [])
    {
        $options += [
            'namespaceId' => $this->namespaceId,
            'databaseId' => $this->databaseId,
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
     * @throws \InvalidArgumentException If the number of keys is less than 1.
     */
    public function keys($kind, array $options = [])
    {
        $options += [
            'number' => 1,
            'ancestors' => [],
            'id' => null,
            'name' => null,
        ];

        if ($options['number'] < 1) {
            throw new \InvalidArgumentException('Number of keys cannot be less than 1.');
        }

        $path = [];
        if (count($options['ancestors']) > 0) {
            $path = $options['ancestors'];
        }

        $path[] = array_filter([
            'kind' => $kind,
            'id' => $options['id'],
            'name' => $options['name'],
        ]);

        $key = new Key($this->projectId, [
            'path' => $path,
            'namespaceId' => $this->namespaceId,
            'databaseId' => $this->databaseId,
        ]);

        $keys = [$key];

        for ($i = 1; $i < $options['number']; $i++) {
            $keys[] = clone $key;
        }

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
     * In certain cases, you may want to create your own entity types.
     * Google Cloud PHP supports custom types implementing
     * {@see \Google\Cloud\Datastore\EntityInterface}. If the name of an
     * `EntityInterface` implementation is given in the options array, an
     * instance of that class will be returned instead of
     * {@see \Google\Cloud\Datastore\Entity}.
     *
     * @see https://cloud.google.com/datastore/reference/rest/v1/Entity Entity
     *
     * @param Key|string|null $key [optional] The key used to identify the record, or
     *        a string $kind. The key may be null only if the entity will be
     *        used as an embedded entity within another entity. Attempting to
     *        use keyless entities as root entities will result in error.
     * @param array $entity [optional] The data to fill the entity with.
     * @param array $options [optional] {
     *     Configuration Options
     *
     *     @type string $className If set, the given class will be returned.
     *           Value must be the name of a class implementing
     *           {@see \Google\Cloud\Datastore\EntityInterface}. **Defaults to**
     *           {@see \Google\Cloud\Datastore\Entity}.
     *     @type array $excludeFromIndexes A list of entity keys to exclude from
     *           datastore indexes.
     * }
     * @return EntityInterface
     * @throws \InvalidArgumentException
     */
    public function entity($key = null, array $entity = [], array $options = [])
    {
        $options += [
            'className' => null,
        ];

        if ($key && !is_string($key) && !($key instanceof Key)) {
            throw new \InvalidArgumentException(
                '$key must be an instance of Key or a string'
            );
        }

        if (is_string($key)) {
            $key = $this->key($key);
        }

        $className = $options['className'];
        if (!is_null($className) && !is_subclass_of($className, EntityInterface::class)) {
            throw new \InvalidArgumentException(sprintf(
                'Given classname %s must implement EntityInterface',
                $className
            ));
        }

        if (is_null($className)) {
            $className = Entity::class;
        }

        return $className::build($key, $entity, $options);
    }

    /**
     * Begin a Datastore Transaction.
     *
     * @param array $transactionOptions
     *        [Transaction Options](https://cloud.google.com/datastore/docs/reference/data/rest/v1/projects/beginTransaction#TransactionOptions)
     * @param array $options Configuration options.
     * @return string
     */
    public function beginTransaction($transactionOptions, array $options = [])
    {
        $protoTransactionOptions = new TransactionOptions();
        $protoTransactionOptions->mergeFromJsonString(json_encode($transactionOptions));

        $beginTransactionRequest = new BeginTransactionRequest();
        $beginTransactionRequest->setProjectId($this->projectId);
        $beginTransactionRequest->setDatabaseId($options['databaseId'] ?? $this->databaseId);
        $beginTransactionRequest->setTransactionOptions($protoTransactionOptions);

        $res = $this->gapicClient->beginTransaction($beginTransactionRequest, $options);

        return $res->getTransaction();
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
     * @throws \InvalidArgumentException
     */
    public function allocateIds(array $keys, array $options = [])
    {
        // Validate the given keys. First check types, then state of each.
        // The API will throw a 400 if the key is named, but it's an easy
        // check we can handle before going to the API to save a request.
        // @todo replace with json schema
        $this->validateBatch($keys, Key::class, function ($key) {
            if ($key->state() !== Key::STATE_INCOMPLETE) {
                throw new \InvalidArgumentException(sprintf(
                    'Given $key is in an invalid state. Can only allocate IDs for incomplete keys. ' .
                    'Given path was %s',
                    (string) $key
                ));
            }
        });

        $serviceKeys = [];
        foreach ($keys as $key) {
            $keyMessage = new GrpcKey();
            $keyMessage->mergeFromJsonString(json_encode($key->keyObject()));
            $serviceKeys[] = $keyMessage;
        }

        $request = new AllocateIdsRequest();
        $request->setProjectId($this->projectId);
        $request->setDatabaseId($options['databaseId'] ?? $this->databaseId);
        $request->setKeys($serviceKeys);

        $allocateIdsResponse = $this->gapicClient->allocateIds($request, $options);

        /** @var GrpcKey $responseKey */
        foreach ($allocateIdsResponse->getKeys() as $index => $responseKey) {
            $path = $responseKey->getPath();

            // @phpstan-ignore argument.type
            $lastPathElement = count($path) - 1;

            $id = $path[$lastPathElement]->getId();
            $keys[$index]->setLastElementIdentifier($id);
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
     *     @type string|array $className If a string, the given class will be
     *           returned. Value must be the name of a class implementing
     *           {@see \Google\Cloud\Datastore\EntityInterface}.
     *           If an array is given, it must be an associative array, where
     *           the key is a Kind and the value must implement
     *           {@see \Google\Cloud\Datastore\EntityInterface}. **Defaults to**
     *           {@see \Google\Cloud\Datastore\Entity}.
     *     @type bool $sort If set to true, results in each set will be sorted
     *           to match the order given in $keys. **Defaults to** `false`.
     *     @type string $databaseId ID of the database to which the entities belong.
     *     @type Timestamp $readTime Reads entities as they were at the given timestamp.
     * }
     * @return array Returns an array with keys [`found`, `missing`, and `deferred`].
     *         Members of `found` will be instance of
     *         {@see \Google\Cloud\Datastore\Entity}. Members of `missing` and
     *         `deferred` will be instance of {@see \Google\Cloud\Datastore\Key}.
     * @throws \InvalidArgumentException
     */
    public function lookup(array $keys, array $options = [])
    {
        $options += [
            'className' => Entity::class,
            'sort' => false,
        ];

        $serviceKeys = [];
        $this->validateBatch($keys, Key::class, function ($key) use (&$serviceKeys) {
            if ($key->state() !== Key::STATE_NAMED) {
                throw new \InvalidArgumentException(sprintf(
                    'Given $key is in an invalid state. Can only lookup records when given a complete key. ' .
                    'Given path was %s',
                    (string) $key
                ));
            }

            $grpcKey = new GrpcKey();
            $grpcKey->mergeFromJsonString(json_encode($key->keyObject()));
            $serviceKeys[] = $grpcKey;
        });

        $lookupRequest = new LookupRequest();
        $lookupRequest->setDatabaseId($options['databaseId'] ?? $this->databaseId);
        $lookupRequest->setProjectId($this->projectId);
        $lookupRequest->setKeys($serviceKeys);

        $lookupRequest->setReadOptions($this->createReadOptions($options));

        $lookupResponse = $this->gapicClient->lookup($lookupRequest, $options);

        $result = [
            'result' => [],
            'missing' => [],
            'deferred' => [],
        ];

        /** @var GrpcEntity $found */
        foreach ($lookupResponse->getFound() as $found) {
            $result['found'][] = $this->mapEntityResult(
                $this->serializer->encodeMessage($found), $options['className']
            );
        }

        if ($options['sort']) {
            $result['found'] = $this->sortEntities($result['found'], $keys);
        }

        /** @var GrpcEntity $missing */
        foreach ($lookupResponse->getMissing() as $missing) {
            $result['missing'][] = $this->key(
                $missing->getEntity()->getKey()->getPath(),
                $missing->getEntity()->getKey()->getPartitionId()
            );
        }

        /** @var GrpcKey $deferred */
        foreach ($lookupResponse->getDeferred() as $deferred) {
            $result['deferred'][] = $this->key(
                $deferred->getPath(),
                $deferred->getPartitionId()
            );
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
     *     @type string $className If set, the given class will be returned.
     *           Value must be the name of a class implementing
     *           {@see \Google\Cloud\Datastore\EntityInterface}. **Defaults to**
     *           {@see \Google\Cloud\Datastore\Entity}.
     *     @type string $readConsistency See
     *           [ReadConsistency](https://cloud.google.com/datastore/reference/rest/v1/ReadOptions#ReadConsistency).
     *     @type string $databaseId ID of the database to which the entities belong.
     *     @type Timestamp $readTime Reads entities as they were at the given timestamp.
     *     @type ExplainMetrics $explainMetrics The ExplainMetrics object for query stats.
     *           {@see \Google\Cloud\Datastore\V1\ExplainOptions}
     * }
     * @return EntityIterator<EntityInterface>
     * @throws InvalidArgumentException
     */
    public function runQuery(QueryInterface $query, array $options = [])
    {
        $options += [
            'className' => Entity::class,
            'namespaceId' => $this->namespaceId,
            'databaseId' => $this->databaseId,
        ];

        if (isset($options['explainOptions']) && !$options['explainOptions'] instanceof ExplainOptions) {
            throw new InvalidArgumentException('The explainOptions option should be an instance of ExplainOptions.');
        }

        $iteratorConfig = [
            'itemsKey' => 'batch.entityResults',
            'resultTokenKey' => 'query.startCursor',
            'nextResultTokenKey' => 'batch.endCursor',
            'setNextResultTokenCondition' => function ($res) use ($query) {
                if (isset($res['batch']['moreResults'])) {
                    $moreResultsType = $res['batch']['moreResults'];
                    // Transform gRPC enum to string
                    if (is_numeric($moreResultsType)) {
                        $moreResultsType = MoreResultsType::name($moreResultsType);
                    }

                    return $query->canPaginate() && $moreResultsType === 'NOT_FINISHED';
                }

                return false;
            },
        ];

        if (array_key_exists('limit', $query->queryObject())) {
            $remainingLimit = $query->queryObject()['limit'];
        }
        $runQueryObj = clone $query;
        $runQueryFn = function (array $args = []) use (&$runQueryObj, $options, &$remainingLimit) {
            $args += [
                'query' => [],
            ];

            // The iterator provides the startCursor for subsequent pages as an argument.
            $requestQueryArr = $args['query'] + $runQueryObj->queryObject();
            if (isset($remainingLimit)) {
                $requestQueryArr['limit'] = $remainingLimit;
            }
            $request = [
                'projectId' => $this->projectId,
                'partitionId' => $this->partitionId(
                    $this->projectId,
                    $options['namespaceId'],
                    $options['databaseId']
                ),
                $runQueryObj->queryKey() => $requestQueryArr,
            ] + $this->readOptions($options) + $options;

            $runQueryRequest = new RunQueryRequest();
            $runQueryRequest->mergeFromJsonString(json_encode($request), true);
            $runQueryResponse = $this->gapicClient->runQuery($runQueryRequest);

            $res = $this->serializer->encodeMessage($runQueryResponse);

            // When executing a GQL Query, the server will compute a query object
            // and return it with the first response batch.
            // Automatic pagination with GQL is accomplished by requesting
            // subsequent pages with this query object, and discarding the GQL
            // query. This is done by replacing the GQL object with a Query
            // instance prior to the next iteration of the page.
            if (isset($res['query'])) {
                $runQueryObj = new Query($this->entityMapper, $res['query']);
            }
            if (isset($res['query']['limit'])) {
                // limit for GqlQuery in REST mode
                $remainingLimit = $res['query']['limit'];
            }
            if (isset($remainingLimit['value'])) {
                // limit for GqlQuery in GRPC mode
                $remainingLimit = $remainingLimit['value'];
            }
            if (!is_null($remainingLimit)) {
                // entityResults is not present in REST mode for empty query results
                $remainingLimit -= count($res['batch']['entityResults'] ?? []);
            }

            return $res;
        };

        return new EntityIterator(
            new EntityPageIterator(
                function (array $entityResult) use ($options) {
                    return $this->mapEntityResult($entityResult, $options['className']);
                },
                $runQueryFn,
                [],
                $iteratorConfig
            )
        );
    }

    /**
     * Run an aggregation query and return aggregated results.
     *
     * @param AggregationQuery $query The Aggregation Query object.
     * @param array $options [optional] {
     *     Configuration Options
     *
     *     @type string $transaction The transaction ID, if the query should be
     *           run in a transaction.
     *     @type string $readConsistency See
     *           [ReadConsistency](https://cloud.google.com/datastore/reference/rest/v1/ReadOptions#ReadConsistency).
     *     @type string $databaseId ID of the database to which the entities belong.
     *     @type Timestamp $readTime Reads entities as they were at the given timestamp.
     * }
     * @return AggregationQueryResult
     */
    public function runAggregationQuery(AggregationQuery $runQueryObj, array $options = [])
    {
        $options += [
            'namespaceId' => $this->namespaceId,
            'databaseId' => $this->databaseId,
        ];

        if (isset($options['explainOptions']) && !$options['explainOptions'] instanceof ExplainOptions) {
            throw new InvalidArgumentException(
                'The explainOptions option needs to be an instance of the ExplainOptions class'
            );
        }

        $args = [
            'query' => [],
        ];
        $requestQueryArr = $args['query'] + $runQueryObj->queryObject();
        $request = [
            'projectId' => $this->projectId,
            'partitionId' => $this->partitionId(
                $this->projectId,
                $options['namespaceId'],
                $options['databaseId']
            ),
        ] + $requestQueryArr + $this->readOptions($options) + $options;

        $runAggregationQueryRequest = new RunAggregationQueryRequest();
        $runAggregationQueryRequest->mergeFromJsonString(json_encode($request), true);
        $runAggregationQueryResponse = $this->gapicClient->runAggregationQuery($runAggregationQueryRequest, $options);

        $res = $this->serializer->encodeMessage($runAggregationQueryResponse);

        return new AggregationQueryResult($res, $this->entityMapper);
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
     *     @type string $databaseId ID of the database to which the entities belong.
     * }
     * @return array [Response Body](https://cloud.google.com/datastore/reference/rest/v1/projects/commit#response-body)
     * @codingStandardsIgnoreEnd
     */
    public function commit(array $mutations, array $options = [])
    {
        $options += [
            'transaction' => null,
            'databaseId' => $this->databaseId,
        ];

        $protoMutations = [];
        foreach ($mutations as $mutation) {
            $protoMutation = new Mutation();
            $protoMutation->mergeFromJsonString(json_encode($mutation));
            $protoMutations[] = $protoMutation;
        }

        $commitRequest = new CommitRequest();
        $commitRequest->setMutations($protoMutations);
        $commitRequest->setDatabaseId($options['databaseId']);
        $commitRequest->setProjectId($this->projectId);
        $commitRequest->setMode(($options['transaction']) ? Mode::TRANSACTIONAL : Mode::NON_TRANSACTIONAL);

        $commitResponse = $this->gapicClient->commit($commitRequest, $options);

        return $this->serializer->encodeMessage($commitResponse);
    }

    /**
     * Patch any incomplete keys in the given array of entities
     *
     * Any incomplete keys will be allocated an ID. Named keys in the input
     * will remain unchanged.
     *
     * @param EntityInterface[] $entities A list of entities
     * @return EntityInterface[]
     */
    public function allocateIdsToEntities(array $entities)
    {
        $this->validateBatch($entities, EntityInterface::class);

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
     * @param EntityInterface|Key $input The entity or key to mutate.
     * @param string $type The type of the input array.
     * @param string $baseVersion [optional] The version of the entity that this mutation
     *        is being applied to. If this does not match the current version on
     *        the server, the mutation conflicts.
     * @return array [Mutation](https://cloud.google.com/datastore/docs/reference/rest/v1/projects/commit#Mutation).
     * @throws \InvalidArgumentException
     */
    public function mutation(
        $operation,
        $input,
        $type,
        $baseVersion = null
    ) {
        // If the given element is an EntityInterface, it will use that baseVersion.
        if ($input instanceof EntityInterface) {
            $baseVersion = $input->baseVersion();
            $data = $this->entityMapper->objectToRequest($input);

            if (!$input->key()) {
                throw new \InvalidArgumentException('Base entities must provide a datastore key.');
            }
        } elseif ($input instanceof Key) {
            $data = $input->keyObject();
        } else {
            throw new \InvalidArgumentException(sprintf(
                'Input must be a Key or Entity, %s given',
                get_class($input)
            ));
        }

        return array_filter([
            $operation => $data,
            'baseVersion' => $baseVersion,
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
        $rollbackRequest = new RollbackRequest();
        $rollbackRequest->setTransaction($transactionId);
        $rollbackRequest->setProjectId($this->projectId);
        $rollbackRequest->setDatabaseId($this->databaseId);

        $this->gapicClient->rollback($rollbackRequest);
    }

    /**
     * Check whether an update or upsert operation may proceed safely
     *
     * @param EntityInterface[] $entities the entities to be updated or upserted.
     * @param bool $allowOverwrite If `true`, entities may be overwritten.
     *        **Defaults to** `false`.
     * @throws \InvalidArgumentException
     * @return void
     */
    public function checkOverwrite(array $entities, $allowOverwrite = false)
    {
        $this->validateBatch($entities, EntityInterface::class);

        foreach ($entities as $entity) {
            if (!$entity->populatedByService() && !$allowOverwrite) {
                throw new \InvalidArgumentException(sprintf(
                    'Given entity cannot be saved because it may overwrite an ' .
                    'existing record. When updating manually created entities, ' .
                    'please set the options `$allowOverwrite` flag to `true`. ' .
                    'Invalid entity key was %s',
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
     *        Must implement {@see \Google\Cloud\Datastore\EntityInterface}.
     *        If not set, {@see \Google\Cloud\Datastore\Entity} will be used.
     *        If an array is given, it must be an associative array, where
     *        the key is a Kind and the value is an object implementing
     *        {@see \Google\Cloud\Datastore\EntityInterface}.
     * @return EntityInterface
     */
    private function mapEntityResult(array $result, $class)
    {
        $entity = $result['entity'];

        $namespaceId = (isset($entity['key']['partitionId']['namespaceId']))
            ? $entity['key']['partitionId']['namespaceId']
            : null;
        $databaseId = (isset($entity['key']['partitionId']['databaseId']))
            ? $entity['key']['partitionId']['databaseId']
            : '';

        $key = new Key($this->projectId, [
            'path' => $entity['key']['path'],
            'namespaceId' => $namespaceId,
            'databaseId' => $databaseId,
        ]);

        if (is_array($class)) {
            $lastPathElement = $key->pathEnd();
            if (!array_key_exists($lastPathElement['kind'], $class)) {
                throw new \InvalidArgumentException(sprintf(
                    'No class found for kind %s',
                    $lastPathElement['kind']
                ));
            }

            $className = $class[$lastPathElement['kind']];
        } else {
            $className = $class;
        }

        $properties = [];
        $excludes = [];
        $meanings = [];

        if (isset($entity['properties'])) {
            $res = $this->entityMapper->responseToEntityProperties($entity['properties'], $className);

            $properties = $res['properties'];
            $excludes = $res['excludes'];
            $meanings = $res['meanings'];
        }

        return $this->entity($key, $properties, [
            'cursor' => (isset($result['cursor']) && $result['cursor'] !== '')
                ? $result['cursor']
                : null,
            'baseVersion' => (isset($result['version']))
                ? $result['version']
                : null,
            'className' => $className,
            'populatedByService' => true,
            'excludeFromIndexes' => $excludes,
            'meanings' => $meanings,
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
     *      @type Timestamp $readTime Reads entities as they were at the given timestamp.
     * }
     * @return array
     */
    private function readOptions(array $options = [])
    {
        $options += [
            'readConsistency' => null,
            'transaction' => null,
            'readTime' => null
        ];

        $readOptions = array_filter([
            'readConsistency' => $options['readConsistency'],
            'transaction' => $options['transaction'],
            'readTime' => $options['readTime']
        ]);

        return array_filter([
            'readOptions' => $readOptions,
        ]);
    }

    /**
     * Sort entities into the order given in $keys.
     *
     * @param EntityInterface[] $entities
     * @param Key[] $keys
     * @return EntityInterface[]
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

    /**
     * Create a ReadOptions object from an options array.
     *
     * @param array $options The options.
     * @return null|ReadOptions
     */
    private function createReadOptions(array $options)
    {
        $empty = true;

        $readOptions = new ReadOptions();
        if (isset($options['transaction'])) {
            $empty = false;
            $readOptions->setTransaction($options['transaction']);
        }
        if (isset($options['readConsistency'])) {
            $empty = false;
            $readOptions->setReadConsistency($options['readConsistency']);
        }
        if (isset($options['readTime'])) {
            $empty = false;
            $protoTime = new ProtobufTimestamp();
            // Timestamps can be passed as an array or a Timestamp object.
            $protoTime->mergeFromJsonString(json_encode($options['readTime']));
            $readOptions->setReadTime($protoTime);
        }

        if ($empty) {
            return null;
        }

        return $readOptions;
    }
}

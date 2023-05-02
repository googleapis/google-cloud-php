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

namespace Google\Cloud\Firestore;

use Google\Cloud\Core\DebugInfoTrait;
use Google\Cloud\Core\ExponentialBackoff;
use Google\Cloud\Firestore\Connection\ConnectionInterface;
use Google\Cloud\Firestore\DocumentSnapshot;
use Google\Cloud\Firestore\FieldValue\FieldValueInterface;
use Google\Cloud\Firestore\QueryTrait;
use Google\Cloud\Firestore\SnapshotTrait;
use Google\Cloud\Firestore\V1\StructuredQuery\CompositeFilter\Operator;
use Google\Cloud\Firestore\V1\StructuredQuery\Direction;
use Google\Cloud\Firestore\V1\StructuredQuery\FieldFilter\Operator as FieldFilterOperator;
use Google\Cloud\Firestore\V1\StructuredQuery\UnaryFilter\Operator as UnaryFilterOperator;

/**
 * A Cloud Firestore Query.
 *
 * This class is immutable; any filters applied will return a new instance of
 * the class.
 *
 * Example:
 * ```
 * use Google\Cloud\Firestore\FirestoreClient;
 *
 * $firestore = new FirestoreClient();
 *
 * $collection = $firestore->collection('users');
 * $query = $collection->where('age', '>', 18);
 * ```
 */
class Query
{
    use DebugInfoTrait;
    use SnapshotTrait;
    use QueryTrait;

    /**
     * @deprecated
     */
    const OP_LESS_THAN = FieldFilterOperator::LESS_THAN;

    /**
     * @deprecated
     */
    const OP_LESS_THAN_OR_EQUAL = FieldFilterOperator::LESS_THAN_OR_EQUAL;

    /**
     * @deprecated
     */
    const OP_GREATER_THAN = FieldFilterOperator::GREATER_THAN;

    /**
     * @deprecated
     */
    const OP_GREATER_THAN_OR_EQUAL = FieldFilterOperator::GREATER_THAN_OR_EQUAL;

    /**
     * @deprecated
     */
    const OP_EQUAL = FieldFilterOperator::EQUAL;

    /**
     * @deprecated
     */
    const OP_ARRAY_CONTAINS = FieldFilterOperator::ARRAY_CONTAINS;

    const OP_NAN = UnaryFilterOperator::IS_NAN;
    const OP_NULL = UnaryFilterOperator::IS_NULL;

    const DIR_ASCENDING = Direction::ASCENDING;
    const DIR_DESCENDING = Direction::DESCENDING;

    const DOCUMENT_ID = '__name__';

    private $shortOperators = [
        '<'  => FieldFilterOperator::LESS_THAN,
        '<=' => FieldFilterOperator::LESS_THAN_OR_EQUAL,
        '>'  => FieldFilterOperator::GREATER_THAN,
        '>=' => FieldFilterOperator::GREATER_THAN_OR_EQUAL,
        '='  => FieldFilterOperator::EQUAL,
        '!=' => FieldFilterOperator::NOT_EQUAL,
        '=='  => FieldFilterOperator::EQUAL,
        '==='  => FieldFilterOperator::EQUAL,
        'array-contains' => FieldFilterOperator::ARRAY_CONTAINS,
        'array-contains-any' => FieldFilterOperator::ARRAY_CONTAINS_ANY,
        'in' => FieldFilterOperator::IN,
        'not_in' => FieldFilterOperator::NOT_IN,
    ];

    private $allowedDirections = [
        self::DIR_ASCENDING,
        self::DIR_DESCENDING
    ];

    private $shortDirections = [
        'ASC' => self::DIR_ASCENDING,
        'ASCENDING' => self::DIR_ASCENDING,
        'DESC' => self::DIR_DESCENDING,
        'DESCENDING' => self::DIR_DESCENDING
    ];

    /**
     * @var ConnectionInterface
     */
    private $connection;

    /**
     * @var ValueMapper
     */
    private $valueMapper;

    /**
     * @var string
     */
    private $parentName;

    /**
     * @var array
     */
    private $query;

    /**
     * @var bool
     */
    private $limitToLast;

    /**
     * @param ConnectionInterface $connection A Connection to Cloud Firestore.
     * @param ValueMapper $valueMapper A Firestore Value Mapper.
     * @param string $parent The parent of the query.
     * @param array $query The Query object
     * @param bool $limitToLast Limit a query to return only the last matching documents.
     * @throws \InvalidArgumentException If the query does not provide a valid selector.
     */
    public function __construct(
        ConnectionInterface $connection,
        ValueMapper $valueMapper,
        $parent,
        array $query,
        $limitToLast = false
    ) {
        $this->connection = $connection;
        $this->valueMapper = $valueMapper;
        $this->parentName = $parent;
        $this->query = $query;
        $this->limitToLast = $limitToLast;

        if (!isset($this->query['from'])) {
            throw new \InvalidArgumentException(
                'Cannot instantiate a query which does not specify a collection selector (`from`).'
            );
        }
    }

    /**
     * Gets the count of all documents matching the provided query filters.
     *
     * Example:
     * ```
     * $count = $query->count();
     * ```
     *
     * @param array $options [optional] {
     *     Configuration options is an array.
     *
     *     @type Timestamp $readTime Reads entities as they were at the given timestamp.
     * }
     * @return int
     */
    public function count(array $options = [])
    {
        $aggregateQuery = $this->addAggregation(Aggregate::count()->alias('count'));

        $aggregationResult = $aggregateQuery->getSnapshot($options);
        return $aggregationResult->get('count');
    }

    /**
     * Returns an aggregate query provided an aggregation with existing query filters.
     *
     * Example:
     * ```
     * use Google\Cloud\Firestore\Aggregate;
     *
     * $aggregation = Aggregate::count()->alias('count_upto_1');
     * $aggregateQuery = $query->limit(1)->addAggregation($aggregation);
     * $aggregateQuerySnapshot = $aggregateQuery->getSnapshot();
     * $countUpto1 = $aggregateQuerySnapshot->get('count_upto_1');
     * ```
     *
     * @param Aggregate $aggregate Aggregate properties to be applied over query.
     * @return AggregateQuery
     */
    public function addAggregation($aggregate)
    {
        $aggregateQuery = new AggregateQuery(
            $this->connection,
            $this->parentName,
            [
                'query' => $this->query,
                'limitToLast' => $this->limitToLast
            ],
            $aggregate
        );

        return $aggregateQuery;
    }

    /**
     * Get all documents matching the provided query filters.
     *
     * Example:
     * ```
     * $result = $query->documents();
     * ```
     *
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/firestore/docs/reference/rpc/google.firestore.v1beta1#google.firestore.v1beta1.Firestore.RunQuery RunQuery
     * @codingStandardsIgnoreEnd
     * @param array $options {
     *     Configuration options.
     *
     *     @type int $maxRetries The maximum number of times to retry a query.
     *           **Defaults to** `5`.
     * }
     * @return QuerySnapshot<DocumentSnapshot>
     * @throws \InvalidArgumentException if an invalid `$options.readTime` is
     *     specified.
     * @throws \RuntimeException If limit-to-last is enabled but no order-by has
     *     been specified.
     */
    public function documents(array $options = [])
    {
        $options = $this->formatReadTimeOption($options);

        $maxRetries = $this->pluck('maxRetries', $options, false);
        $maxRetries = $maxRetries === null
            ? FirestoreClient::MAX_RETRIES
            : $maxRetries;

        $query = $this->structuredQueryPrepare([
            'query' => $this->query,
            'limitToLast' => $this->limitToLast
        ]);
        $rows = (new ExponentialBackoff($maxRetries))->execute(function () use ($query, $options) {

            $generator = $this->connection->runQuery($this->arrayFilterRemoveNull([
                'parent' => $this->parentName,
                'structuredQuery' => $query,
                'retries' => 0
            ]) + $options);

            // cache collection references
            $collections = [];

            $out = [];
            while ($generator->valid()) {
                $result = $generator->current();

                if (isset($result['document']) && $result['document']) {
                    $collectionName = $this->parentPath($result['document']['name']);
                    if (!isset($collections[$collectionName])) {
                        $collections[$collectionName] = new CollectionReference(
                            $this->connection,
                            $this->valueMapper,
                            $collectionName
                        );
                    }

                    $ref = new DocumentReference(
                        $this->connection,
                        $this->valueMapper,
                        $collections[$collectionName],
                        $result['document']['name']
                    );

                    $document = $result['document'];
                    $document['readTime'] = $result['readTime'];

                    $out[] = $this->createSnapshotWithData($this->valueMapper, $ref, $document);
                }

                $generator->next();
            }

            // if limitToLast is on, reverse the results, since we already
            // reversed all the ordering constraints before sending the query.
            return $this->limitToLast
                ? array_reverse($out)
                : $out;
        });

        return new QuerySnapshot($this, $rows);
    }

    /**
     * Add a SELECT to the Query.
     *
     * Creates and returns a new Query instance that applies a field mask to the
     * result and returns only the specified subset of fields. You can specify a
     * list of field paths to return, or use an empty list to only return the
     * references of matching documents.
     *
     * Subsequent calls to this method will override previous values.
     *
     * Example:
     * ```
     * $query = $query->select(['firstName']);
     * ```
     *
     * @param string[]|FieldPath[] $fieldPaths The projection to return, in the
     *        form of an array of field paths. To only return the name of the
     *        document, provide an empty array.
     * @return Query A new instance of Query with the given changes applied.
     */
    public function select(array $fieldPaths)
    {
        $fields = [];
        foreach ($fieldPaths as $field) {
            if (!($field instanceof FieldPath)) {
                $field = FieldPath::fromString($field);
            }

            $fields[] = [
                'fieldPath' => $field->pathString()
            ];
        }

        if (!$fields) {
            $fields[] = [
                'fieldPath' => self::DOCUMENT_ID
            ];
        }

        return $this->newQuery([
            'select' => [
                'fields' => $fields
            ]
        ], true);
    }

    /**
     * Add a WHERE clause to the Query.
     *
     * For a list of all available operators, see
     * {@see Google\Cloud\Firestore\V1\StructuredQuery\FieldFilter\Operator}.
     * This method also supports a number of comparison operators which you will
     * be familiar with, such as `=`, `>`, `<`, `<=` and `>=`. For array fields,
     * the `array-contains`, `IN` and `array-contains-any` operators are also
     * available.
     * This method also supports usage of Filters (see {@see Google\Cloud\Firestore\Filter}).
     * The Filter class helps to create complex queries using AND and OR operators.
     *
     * Example:
     * ```
     * $query = $query->where('firstName', '=', 'John');
     * ```
     *
     * ```
     * // Filtering against `null` and `NAN` is supported only with the equality operator.
     * $query = $query->where('coolnessPercentage', '=', NAN);
     * ```
     *
     * ```
     * // Use `array-contains` to select documents where the array contains given elements.
     * $query = $query->where('friends', 'array-contains', ['Steve', 'Sarah']);
     * ```
     *
     * ```
     * use Google\Cloud\Firestore\Filter;
     *
     * // Filtering with Filter::or
     * $query = $query->where(Filter::or([
     *     Filter::field('firstName', '=', 'John'),
     *     Filter::field('firstName', '=', 'Monica')
     * ]));
     * ```
     *
     * @param string|array|FieldPath $fieldPath The field to filter by, or array of Filters.
     *     If filter array is provided, other params will be ignored.
     * @param string|int $operator The operator to filter by.
     * @param mixed $value The value to compare to.
     * @return Query A new instance of Query with the given changes applied.
     * @throws \InvalidArgumentException If an invalid operator or value is encountered.
     */
    public function where($fieldPath, $operator = null, $value = null)
    {
        if (is_array($fieldPath)) {
            $filters = $this->createCompositeFilter($fieldPath);
        } else {
            $filters = $this->createFieldFilter($fieldPath, $operator, $value);
        }

        $query = [
            'where' => [
                'compositeFilter' => [
                    'op' => Operator::PBAND,
                    'filters' => [$filters]
                ]
            ]
        ];

        return $this->newQuery($query);
    }

    /**
     * Add an ORDER BY clause to the Query.
     *
     * Example:
     * ```
     * $query = $query->orderBy('firstName', 'DESC');
     * ```
     *
     * @param string|FieldPath $fieldPath The field to order by.
     * @param string|int $direction The direction to order in. **Defaults to**
     *        `ASC`.
     * @return Query A new instance of Query with the given changes applied.
     * @throws \InvalidArgumentException If an invalid direction is given.
     * @throws \InvalidArgumentException If orderBy is called after `startAt()`,
     *         `startAfter()`, `endBefore()` or `endAt`().
     */
    public function orderBy($fieldPath, $direction = self::DIR_ASCENDING)
    {
        $direction = array_key_exists(strtoupper($direction), $this->shortDirections)
            ? $this->shortDirections[strtoupper($direction)]
            : $direction;

        if (!in_array($direction, $this->allowedDirections)) {
            throw new \InvalidArgumentException(sprintf(
                'Direction %s is not a valid direction',
                $direction
            ));
        }

        if ($this->queryHas('startAt') || $this->queryHas('endAt')) {
            throw new \InvalidArgumentException(
                'Cannot specify an orderBy constraint after calling any of ' .
                '`startAt()`, `startAfter()`, `endBefore()` or `endAt`().'
            );
        }

        if (!($fieldPath instanceof FieldPath)) {
            $fieldPath = FieldPath::fromString($fieldPath);
        }

        return $this->newQuery([
            'orderBy' => [
                [
                    'field' => [
                        'fieldPath' => $fieldPath->pathString()
                    ],
                    'direction' => $direction
                ]
            ]
        ]);
    }

    /**
     * Limits a query to return only the first matching documents.
     *
     * Applies after all other constraints. Must be >= 0 if specified.
     *
     * Example:
     * ```
     * $query = $query->limit(10);
     * ```
     *
     * @param int $number The number of results to return.
     * @return Query A new instance of Query with the given changes applied.
     */
    public function limit($number)
    {
        return $this->newQuery([
            'limit' => $number
        ], false, false); // create a new query, explicitly setting `limitToLast` to false.
    }

    /**
     * Limits a query to return only the last matching documents.
     *
     * Applies after all other constraints. Must be >= 0 if specified.
     *
     * You must specify at least one orderBy clause for limitToLast queries,
     * otherwise an exception will be thrown during execution.
     *
     * Example:
     * ```
     * $query = $query->limitToLast(10)
     *     ->orderBy('firstName');
     * ```
     *
     * @param int $number The number of results to return.
     * @return Query A new instance of Query with the given changes applied.
     */
    public function limitToLast($number)
    {
        return $this->newQuery([
            'limit' => $number
        ], false, true); // create a new query, explicitly setting `limitToLast` to true.
    }

    /**
     * The number of results to skip.
     *
     * Applies before limit, but after all other constraints. Must be >= 0 if specified.
     *
     * Example:
     * ```
     * $query = $query->offset(10);
     * ```
     *
     * @param int $number The number of results to skip.
     * @return Query A new instance of Query with the given changes applied.
     */
    public function offset($number)
    {
        return $this->newQuery([
            'offset' => $number
        ]);
    }

    /**
     * A starting point for the query results.
     *
     * Starts results at the provided set of field values relative to the order
     * of the query. The order of the provided values must match the order of
     * the order by clauses of the query. Values in the given cursor will be
     * included in the result set, if found.
     *
     * Multiple invocations of this call overwrite previous calls. Calling
     * `startAt()` will overwrite both previous `startAt()` and `startAfter()`
     * calls.
     *
     * Example:
     * ```
     * $query = $query->orderBy('age', 'ASC')->startAt([18]);
     * $users18YearsOrOlder = $query->documents();
     * ```
     *
     * @param mixed[]|DocumentSnapshot $fieldValues A list of values, or an
     *        instance of {@see Google\Cloud\Firestore\DocumentSnapshot}
     *        defining the query starting point.
     * @return Query A new instance of Query with the given changes applied.
     */
    public function startAt($fieldValues)
    {
        return $this->buildPosition('startAt', $fieldValues, true);
    }

    /**
     * A starting point for the query results.
     *
     * Starts results after the provided set of field values relative to the order
     * of the query. The order of the provided values must match the order of
     * the order by clauses of the query. Values in the given cursor will not be
     * included in the result set.
     *
     * Multiple invocations of this call overwrite previous calls. Calling
     * `startAt()` will overwrite both previous `startAt()` and `startAfter()`
     * calls.
     *
     * Example:
     * ```
     * $query = $query->orderBy('age', 'ASC')->startAfter([17]);
     * $users18YearsOrOlder = $query->documents();
     * ```
     *
     * @param mixed[]|DocumentSnapshot $fieldValues A list of values, or an
     *        instance of {@see Google\Cloud\Firestore\DocumentSnapshot}
     *        defining the query starting point.
     * @return Query A new instance of Query with the given changes applied.
     */
    public function startAfter($fieldValues)
    {
        return $this->buildPosition('startAt', $fieldValues, false);
    }

    /**
     * An end point for the query results.
     *
     * Ends results before the provided set of field values relative to the order
     * of the query. The order of the provided values must match the order of
     * the order by clauses of the query. Values in the given cursor will be
     * included in the result set, if found.
     *
     * Multiple invocations of this call overwrite previous calls. Calling
     * `endBefore()` will overwrite both previous `endBefore()` and `endAt()`
     * calls.
     *
     * Example:
     * ```
     * $query = $query->orderBy('age', 'ASC')->endBefore([18]);
     * $usersYoungerThan18 = $query->documents();
     * ```
     *
     * @param mixed[]|DocumentSnapshot $fieldValues A list of values, or an
     *        instance of {@see Google\Cloud\Firestore\DocumentSnapshot}
     *        defining the query end point.
     * @return Query A new instance of Query with the given changes applied.
     */
    public function endBefore($fieldValues)
    {
        return $this->buildPosition('endAt', $fieldValues, true);
    }

    /**
     * An end point for the query results.
     *
     * Ends results at the provided set of field values relative to the order
     * of the query. The order of the provided values must match the order of
     * the order by clauses of the query. Values in the given cursor will not be
     * included in the result set.
     *
     * Multiple invocations of this call overwrite previous calls. Calling
     * `endBefore()` will overwrite both previous `endBefore()` and `endAt()`
     * calls.
     *
     * Example:
     * ```
     * $query = $query->orderBy('age', 'ASC')->endAt([17]);
     * $usersYoungerThan18 = $query->documents();
     * ```
     *
     * @param mixed[]|DocumentSnapshot $fieldValues A list of values, or an
     *        instance of {@see Google\Cloud\Firestore\DocumentSnapshot}
     *        defining the query end point.
     * @return Query A new instance of Query with the given changes applied.
     */
    public function endAt($fieldValues)
    {
        return $this->buildPosition('endAt', $fieldValues, false);
    }

    /**
     * Check if a given constraint type has been specified on the query.
     *
     * @param string $key The constraint name.
     * @return bool
     * @access private
     */
    public function queryHas($key)
    {
        return isset($this->query[$key]);
    }

    /**
     * Get the constraint data from the current query.
     *
     * @param string $key The constraint name
     * @return mixed
     * @access private
     */
    public function queryKey($key)
    {
        return $this->queryHas($key)
            ? $this->query[$key]
            : null;
    }

    /**
     * Builds a Firestore query position.
     *
     * @param string $key The query key.
     * @param mixed[]|DocumentSnapshot $fieldValues An array of values, or an
     *        instance of {@see Google\Cloud\Firestore\DocumentSnapshot}
     *        to use as the query boundary.
     * @param bool $before Whether the query boundary lies just before or after
     *        the provided data.
     * @return Query
     */
    private function buildPosition($key, $fieldValues, $before)
    {
        $basePath = $this->basePath();

        $orderBy = $this->queryKey('orderBy') ?: [];
        if ($fieldValues instanceof DocumentSnapshot) {
            list($fieldValues, $orderBy) = $this->snapshotPosition($fieldValues, $orderBy);
        } else {
            if (!is_array($fieldValues)) {
                throw new \InvalidArgumentException(sprintf(
                    'Field values must be an array or an instance of `%s`.',
                    DocumentSnapshot::class
                ));
            }

            foreach ($fieldValues as $value) {
                if ($value instanceof DocumentSnapshot) {
                    throw new \InvalidArgumentException(sprintf(
                        'Instances of `%s` are not allowed in an array of field values. ' .
                        'Provide it as the method argument instead.',
                        DocumentSnapshot::class
                    ));
                }
                if ($value instanceof FieldValueInterface) {
                    throw new \InvalidArgumentException(sprintf(
                        'Value cannot be a `%s` value.',
                        FieldValue::class
                    ));
                }
            }
        }

        if (count($fieldValues) > count($orderBy)) {
            throw new \InvalidArgumentException(
                'Too many cursor values specified. The specified values must ' .
                'match the `orderBy` constraints of the query.'
            );
        }

        foreach ($fieldValues as $i => &$value) {
            if ($orderBy[$i]['field']['fieldPath'] === self::DOCUMENT_ID) {
                if (is_string($value)) {
                    $value = $this->createDocumentReference($basePath, $value);
                } else {
                    if ($value instanceof DocumentReference) {
                        $name = $value->name();
                        $parent = $value->parent()->name();
                    } else {
                        throw new \InvalidArgumentException(
                            'The corresponding value for DOCUMENT_ID must be a ' .
                            'string or a DocumentReference.'
                        );
                    }

                    if (!$this->isPrefixOf($basePath, $name)) {
                        throw new \InvalidArgumentException(sprintf(
                            '%s is not a part of the query result set and ' .
                            'cannot be used as a query boundary',
                            $name
                        ));
                    }

                    if ($parent !== $basePath && !$this->allDescendants()) {
                        throw new \InvalidArgumentException(
                            'Only direct children may be used as query boundaries.'
                        );
                    }
                }
            }
        }

        $clause = [
            'values' => $this->valueMapper->encodeValues($fieldValues)
        ];

        if ($before) {
            $clause['before'] = $before;
        }

        return $this->newQuery([
            $key => $clause,
            'orderBy' => $orderBy
        ], true);
    }

    /**
     * Find fieldFilters in a composite filter.
     *
     * @param array $filter The composite filter.
     * @return array array of field filters.
     */
    private function flattenFilter($filter)
    {
        $ret = [];
        $filters = $filter['compositeFilter']['filters'];
        foreach ($filters as $fltr) {
            $type = array_keys($fltr)[0];
            if ($type === 'compositeFilter') {
                $ret = array_merge($ret, $this->flattenFilter($fltr));
            } else {
                $ret[] = $fltr;
            }
        }
        return $ret;
    }

    /**
     * Build cursors for document snapshots.
     *
     * @param DocumentSnapshot $snapshot The document snapshot
     * @param array $orderBy A list of orderBy clauses.
     * @return array A list, where position 0 is fieldValues and position 1 is orderBy.
     */
    private function snapshotPosition(DocumentSnapshot $snapshot, array $orderBy)
    {
        $appendName = true;
        foreach ($orderBy as $order) {
            if ($order['field']['fieldPath'] === self::DOCUMENT_ID) {
                $appendName = false;
                break;
            }
        }

        if ($appendName) {
            // If there is inequality filter (anything other than equals),
            // append orderBy(the last inequality filter’s path, ascending).
            if (!$orderBy && $this->queryHas('where')) {
                // Flatten the filters array if compositeFilters are present
                $filters = $this->flattenFilter($this->query['where']);
                $inequality = array_filter($filters, function ($filter) {
                    $type = array_keys($filter)[0];
                    return !in_array($filter[$type]['op'], [
                        FieldFilterOperator::EQUAL,
                        FieldFilterOperator::ARRAY_CONTAINS
                    ]);
                });

                if ($inequality) {
                    $filter = end($inequality);
                    $type = array_keys($filter)[0];
                    $orderBy[] = [
                        'field' => [
                            'fieldPath' => $filter[$type]['field']['fieldPath'],
                        ],
                        'direction' => self::DIR_ASCENDING
                    ];
                }
            }

            // If the query has existing orderBy constraints
            if ($orderBy) {
                // Append orderBy(__name__, direction of last orderBy clause)
                $lastOrderDirection = end($orderBy)['direction'];
                $orderBy[] = [
                    'field' => [
                        'fieldPath' => self::DOCUMENT_ID
                    ],
                    'direction' => $lastOrderDirection
                ];
            } else {
                // no existing orderBy constraints
                // Otherwise append orderBy(__name__, ‘asc’)
                $orderBy[] = [
                    'field' => [
                        'fieldPath' => self::DOCUMENT_ID
                    ],
                    'direction' => self::DIR_ASCENDING
                ];
            }
        }

        $fieldValues = $this->snapshotCursorValues($snapshot, $orderBy);

        return [
            $fieldValues,
            $orderBy
        ];
    }

    /**
     * Determine field values for Document Snapshot cursors.
     *
     * @param DocumentSnapshot $snapshot
     * @param array $orderBy
     * @return array $fieldValues
     */
    private function snapshotCursorValues(DocumentSnapshot $snapshot, array $orderBy)
    {
        $fieldValues = [];
        foreach ($orderBy as $order) {
            $path = $order['field']['fieldPath'];
            if ($path === self::DOCUMENT_ID) {
                continue;
            }

            $fieldValues[] = $snapshot->get($path);
        }

        $fieldValues[] = $snapshot->reference();
        return $fieldValues;
    }

    /**
     * Create a new Query instance
     *
     * @param array $additionalConfig
     * @param bool $overrideTopLevelKeys If true, top-level keys will be replaced
     *        rather than recursively merged.
     * @param bool $limitToLast If true, the query limit will be applied from
     *        the end of the result set.
     * @return Query A new instance of Query with the given changes applied.
     */
    private function newQuery(array $additionalConfig, $overrideTopLevelKeys = false, $limitToLast = false)
    {
        $query = $this->query;

        if ($overrideTopLevelKeys) {
            $keys = array_keys($additionalConfig);
            foreach ($keys as $key) {
                unset($query[$key]);
            }
        }

        $query = $this->arrayMergeRecursive($query, $additionalConfig);

        return new self(
            $this->connection,
            $this->valueMapper,
            $this->parentName,
            $query,
            $limitToLast
        );
    }

    /**
     * Creates a document reference from a string, relative to a given base.
     *
     * Returns `false` if the path is not a valid document.
     *
     * @param string $basePath The relative base of the document reference.
     * @param mixed $document The document.
     * @return DocumentReference
     * @throws \InvalidArgumentException If $document is not a valid document.
     */
    private function createDocumentReference($basePath, $document)
    {
        if ($document instanceof DocumentReference || $document instanceof DocumentSnapshot) {
            return $document;
        }

        $exceptionMessage = 'When ordering or filtering by document ID, ' .
            'value must be a document reference or valid document name.';

        if (!is_string($document)) {
            throw new \InvalidArgumentException($exceptionMessage);
        }

        $childPath = $this->childPath($basePath, $document);
        if (!$this->isDocument($childPath)) {
            throw new \InvalidArgumentException($exceptionMessage);
        }

        $parent = new CollectionReference(
            $this->connection,
            $this->valueMapper,
            $this->parentPath($childPath)
        );

        return new DocumentReference(
            $this->connection,
            $this->valueMapper,
            $parent,
            $childPath
        );
    }

    /**
     * Indicates whether the current query should include all descendants.
     *
     * @return bool
     */
    private function allDescendants()
    {
        return isset($this->query['from'][0]['allDescendants']) && $this->query['from'][0]['allDescendants'];
    }

    /**
     * Returns the query base path, either the parent in an all descendants query,
     * or the parent with the given collection ID appended otherwise.
     *
     * @return string
     */
    private function basePath()
    {
        return $this->allDescendants()
            ? $this->parentName
            : $this->childPath($this->parentName, $this->query['from'][0]['collectionId']);
    }

    /**
     * Create a field/unary Filter.
     *
     * @param string|array|FieldPath $fieldPath A field to filter by.
     * @param string|int $operator An operator to filter by.
     * @param mixed $value A value to compare to.
     * @return array A field/unary Filter array.
     * @throws \InvalidArgumentException If an invalid operator or value is encountered.
     */
    private function createFieldFilter($fieldPath, $operator, $value)
    {
        $basePath = $this->basePath();
        if ($value instanceof FieldValueInterface) {
            throw new \InvalidArgumentException(sprintf(
                'Value cannot be a `%s` value.',
                FieldValue::class
            ));
        }

        if (!($fieldPath instanceof FieldPath)) {
            $fieldPath = FieldPath::fromString($fieldPath);
        }

        $escapedPathString = $fieldPath->pathString();

        // alias for friendlier error message below.
        $originalOperator = $operator;
        $operator = array_key_exists(strtolower($operator), $this->shortOperators)
            ? $this->shortOperators[strtolower($operator)]
            : $operator;

        try {
            FieldFilterOperator::name($operator);
        } catch (\UnexpectedValueException $e) {
            throw new \InvalidArgumentException(sprintf(
                'Operator %s is not a valid operator',
                $originalOperator
            ));
        }

        if ($escapedPathString === self::DOCUMENT_ID) {
            if ($operator === FieldFilterOperator::IN || $operator === FieldFilterOperator::NOT_IN) {
                $value = array_map(function ($value) use ($basePath) {
                    return $this->createDocumentReference($basePath, $value);
                }, (array) $value);
            } else {
                $value = $this->createDocumentReference($basePath, $value);
            }
        }

        if ((is_float($value) && is_nan($value)) || is_null($value)) {
            if ($operator !== FieldFilterOperator::EQUAL) {
                throw new \InvalidArgumentException('Null and NaN are allowed only with operator EQUALS.');
            }

            $unaryOperator = is_nan($value)
                ? self::OP_NAN
                : self::OP_NULL;

            $filter = [
                'unaryFilter' => [
                    'field' => [
                        'fieldPath' => $escapedPathString
                    ],
                    'op' => $unaryOperator
                ]
            ];
        } else {
            $encodedValue = ($operator === FieldFilterOperator::IN || $operator === FieldFilterOperator::NOT_IN)
                ? $this->valueMapper->encodeMultiValue((array)$value)
                : $this->valueMapper->encodeValue($value);

            $filter = [
                'fieldFilter' => [
                    'field' => [
                        'fieldPath' => $escapedPathString,
                    ],
                    'op' => $operator,
                    'value' => $encodedValue
                ]
            ];
        }

        return $filter;
    }

    /**
     * Find the filter type to either Field or Unary.
     *
     * @param array $filter A field/unary filter array.
     * @return array A field/unary Filter array.
     * @throws \InvalidArgumentException If an invalid filter is encountered.
     */
    private function findFilterType($filter)
    {
        $fieldFilter = $this->createFieldFilter(
            $filter['fieldFilter']['field'],
            $filter['fieldFilter']['op'],
            $filter['fieldFilter']['value']
        );

        return $fieldFilter;
    }

    /**
     * Create a composite filter from a filter array.
     *
     * @param array $filters A non sanitized composite filter array.
     * @return array A sanitized composite Filter array.
     * @throws \InvalidArgumentException If an invalid filter is encountered.
     */
    private function createCompositeFilter($filters)
    {
        foreach ($filters as $key => $filter) {
            if ($key === 'fieldFilter') {
                $fieldFilter = $this->findFilterType($filters);
                if (isset($fieldFilter['unaryFilter'])) {
                    unset($filters['fieldFilter']);
                    $filters['unaryFilter'] = $fieldFilter['unaryFilter'];
                } else {
                    $filters['fieldFilter'] = $fieldFilter['fieldFilter'];
                }
            } elseif (isset($filter['fieldFilter'])) {
                $filters[$key] = $this->findFilterType($filter);
            } elseif ($key === 'compositeFilter' && isset($filter['filters'])) {
                $filters[$key]['filters'] = $this->createCompositeFilter($filter['filters']);
            } elseif (isset($filter['compositeFilter']) &&
                isset($filter['compositeFilter']['filters'])) {
                $filters[$key]['compositeFilter']['filters'] =
                    $this->createCompositeFilter($filter['compositeFilter']['filters']);
            } else {
                throw new \InvalidArgumentException(
                    'The filter is not set correctly.'
                );
            }
        }

        return $filters;
    }
}

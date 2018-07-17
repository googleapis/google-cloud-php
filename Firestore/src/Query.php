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
use Google\Cloud\Firestore\FieldValue;
use Google\Cloud\Firestore\SnapshotTrait;
use Google\Cloud\Firestore\V1beta1\StructuredQuery_CompositeFilter_Operator;
use Google\Cloud\Firestore\V1beta1\StructuredQuery_Direction;
use Google\Cloud\Firestore\V1beta1\StructuredQuery_FieldFilter_Operator;
use Google\Cloud\Firestore\V1beta1\StructuredQuery_UnaryFilter_Operator;

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

    const OP_LESS_THAN = StructuredQuery_FieldFilter_Operator::LESS_THAN;
    const OP_LESS_THAN_OR_EQUAL = StructuredQuery_FieldFilter_Operator::LESS_THAN_OR_EQUAL;
    const OP_GREATER_THAN = StructuredQuery_FieldFilter_Operator::GREATER_THAN;
    const OP_GREATER_THAN_OR_EQUAL = StructuredQuery_FieldFilter_Operator::GREATER_THAN_OR_EQUAL;
    const OP_EQUAL = StructuredQuery_FieldFilter_Operator::EQUAL;

    const OP_NAN = StructuredQuery_UnaryFilter_Operator::IS_NAN;
    const OP_NULL = StructuredQuery_UnaryFilter_Operator::IS_NULL;

    const DIR_ASCENDING = StructuredQuery_Direction::ASCENDING;
    const DIR_DESCENDING = StructuredQuery_Direction::DESCENDING;

    const DOCUMENT_ID = '__name__';

    private $allowedOperators = [
        self::OP_LESS_THAN,
        self::OP_LESS_THAN_OR_EQUAL,
        self::OP_EQUAL,
        self::OP_GREATER_THAN,
        self::OP_GREATER_THAN_OR_EQUAL,
    ];

    private $shortOperators = [
        '<'  => self::OP_LESS_THAN,
        '<=' => self::OP_LESS_THAN_OR_EQUAL,
        '>'  => self::OP_GREATER_THAN,
        '>=' => self::OP_GREATER_THAN_OR_EQUAL,
        '='  => self::OP_EQUAL
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
    private $parent;

    /**
     * @var array
     */
    private $query;

    /**
     * @param ConnectionInterface $connection A Connection to Cloud Firestore.
     * @param ValueMapper $valueMapper A Firestore Value Mapper.
     * @param string $parent The parent of the query.
     * @param array $query The Query object
     * @throws \InvalidArgumentException If the query does not provide a valid selector.
     */
    public function __construct(
        ConnectionInterface $connection,
        ValueMapper $valueMapper,
        $parent,
        array $query
    ) {
        $this->connection = $connection;
        $this->valueMapper = $valueMapper;
        $this->parent = $parent;
        $this->query = $query + [
            'orderBy' => [],
            'offset' => 0
        ];

        if (!isset($this->query['from'])) {
            throw new \InvalidArgumentException(
                'Cannot instantiate a query which does not specify a collection selector (`from`).'
            );
        }
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
     */
    public function documents(array $options = [])
    {
        $maxRetries = $this->pluck('maxRetries', $options, false);
        $maxRetries = $maxRetries === null
            ? FirestoreClient::MAX_RETRIES
            : $maxRetries;

        $rows = (new ExponentialBackoff($maxRetries))->execute(function () use ($options) {
            $query = $this->finalQueryPrepare($this->query);
            $generator = $this->connection->runQuery($this->arrayFilterRemoveNull([
                'parent' => $this->parent,
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

            return $out;
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
            $fields[] = [
                'fieldPath' => $this->valueMapper->escapeFieldPath($field)
            ];
        }

        if (!$fields) {
            $fields[] = [
                'fieldPath' => '__name__'
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
     * @param string|FieldPath $fieldPath The field to filter by.
     * @param string $operator The operator to filter by.
     * @param mixed $value The value to compare to.
     * @return Query A new instance of Query with the given changes applied.
     * @throws \InvalidArgumentException If an invalid operator or value is encountered.
     */
    public function where($fieldPath, $operator, $value)
    {
        if (FieldValue::isSentinelValue($value)) {
            throw new \InvalidArgumentException(sprintf(
                'Value cannot be a `%s` value.',
                FieldValue::class
            ));
        }

        $escapedFieldPath = $this->valueMapper->escapeFieldPath($fieldPath);

        $operator = array_key_exists($operator, $this->shortOperators)
            ? $this->shortOperators[$operator]
            : $operator;

        if (!in_array($operator, $this->allowedOperators)) {
            throw new \InvalidArgumentException(sprintf(
                'Operator %s is not a valid operator',
                $operator
            ));
        }

        if ((is_float($value) && is_nan($value)) || is_null($value)) {
            if ($operator !== self::OP_EQUAL) {
                throw new \InvalidArgumentException('Null and NaN are allowed only with operator EQUALS.');
            }

            $unaryOperator = is_nan($value)
                ? self::OP_NAN
                : self::OP_NULL;

            $filter = [
                'unaryFilter' => [
                    'field' => [
                        'fieldPath' => $escapedFieldPath
                    ],
                    'op' => $unaryOperator
                ]
            ];
        } else {
            $filter = [
                'fieldFilter' => [
                    'field' => [
                        'fieldPath' => $escapedFieldPath,
                    ],
                    'op' => $operator,
                    'value' => $this->valueMapper->encodeValue($value)
                ]
            ];
        }

        $query = [
            'where' => [
                'compositeFilter' => [
                    'op' => StructuredQuery_CompositeFilter_Operator::PBAND,
                    'filters' => [
                        $filter
                    ]
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
     * @param string $direction The direction to order in. **Defaults to** `ASC`.
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

        return $this->newQuery([
            'orderBy' => [
                [
                    'field' => [
                        'fieldPath' => $this->valueMapper->escapeFieldPath($fieldPath)
                    ],
                    'direction' => $direction
                ]
            ]
        ]);
    }

    /**
     * The maximum number of results to return.
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
            'limit' => [
                'value' => $number
            ]
        ]);
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
     * @return array
     */
    private function buildPosition($key, $fieldValues, $before)
    {
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
                        'Instances of `%` are not allowed in an array of field values. ' .
                        'Provide it as the method argument instead.',
                        DocumentSnapshot::class
                    ));
                }
                if (FieldValue::isSentinelValue($value)) {
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
                $collection = $this->childPath(
                    $this->parent,
                    $this->query['from'][0]['collectionId']
                );

                if (is_string($value)) {
                    $parent = new CollectionReference(
                        $this->connection,
                        $this->valueMapper,
                        $collection
                    );

                    $name = $this->childPath($collection, $value);
                    $value = new DocumentReference(
                        $this->connection,
                        $this->valueMapper,
                        $parent,
                        $name
                    );
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

                    if (!$this->isPrefixOf($collection, $name)) {
                        throw new \InvalidArgumentException(sprintf(
                            '%s is not a part of the query result set and ' .
                            'cannot be used as a query boundary',
                            $name
                        ));
                    }

                    if ($parent !== $collection) {
                        throw new \InvalidArgumentException(
                            'Only direct children may be used as query boundaries.'
                        );
                    }
                }
            }
        }

        return $this->newQuery([
            $key => [
                'before' => $before,
                'values' => $this->valueMapper->encodeValues($fieldValues)
            ],
            'orderBy' => $orderBy
        ], true);
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
                $filters = $this->query['where']['compositeFilter']['filters'];
                $inequality = array_filter($filters, function ($filter) {
                    $type = array_keys($filter)[0];
                    return $filter[$type]['op'] !== self::OP_EQUAL;
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
     * @return $fieldValues
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
     * @return Query A new instance of Query with the given changes applied.
     */
    private function newQuery(array $additionalConfig, $overrideTopLevelKeys = false)
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
            $this->parent,
            $query
        );
    }

    /**
     * Clean up the query array before sending.
     *
     * Some optimizations cannot be performed ahead of time and must be done
     * at execution.
     *
     * @param array $query The incoming query
     * @return array The final query data
     */
    private function finalQueryPrepare(array $query)
    {
        if (isset($query['where']['compositeFilter']) && count($query['where']['compositeFilter']['filters']) === 1) {
            $filter = $query['where']['compositeFilter']['filters'][0];
            $query['where'] = $filter;
        }

        return $query;
    }
}

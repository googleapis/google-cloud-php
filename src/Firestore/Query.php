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

use Google\Cloud\Core\ArrayTrait;
use Google\Cloud\Core\DebugInfoTrait;
use Google\Firestore\V1beta1\StructuredQuery_Direction;
use Google\Cloud\Firestore\Connection\ConnectionInterface;
use Google\Firestore\V1beta1\StructuredQuery_FieldFilter_Operator;
use Google\Firestore\V1beta1\StructuredQuery_CompositeFilter_Operator;

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
 * $query = $collection->query();
 * ```
 */
class Query
{
    use ArrayTrait;
    use DebugInfoTrait;

    const OP_LESS_THAN = StructuredQuery_FieldFilter_Operator::LESS_THAN;
    const OP_LESS_THAN_OR_EQUAL = StructuredQuery_FieldFilter_Operator::LESS_THAN_OR_EQUAL;
    const OP_GREATER_THAN = StructuredQuery_FieldFilter_Operator::GREATER_THAN;
    const OP_GREATER_THAN_OR_EQUAL = StructuredQuery_FieldFilter_Operator::GREATER_THAN_OR_EQUAL;
    const OP_EQUAL = StructuredQuery_FieldFilter_Operator::EQUAL;

    const DIR_ASCENDING = StructuredQuery_Direction::ASCENDING;
    const DIR_DESCENDING = StructuredQuery_Direction::DESCENDING;

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
     * @var string?
     */
    private $transaction;

    /**
     * @param ConnectionInterface $connection A Connection to Cloud Firestore.
     * @param ValueMapper $valueMapper A Firestore Value Mapper.
     * @param array $query The Query object
     * @param string|null The transaction ID, if the query is run in a transaction.
     */
    public function __construct(
        ConnectionInterface $connection,
        ValueMapper $valueMapper,
        $parent,
        array $query,
        $transaction = null
    ) {
        $this->connection = $connection;
        $this->valueMapper = $valueMapper;
        $this->parent = $parent;
        $this->query = $query;
        $this->transaction = $transaction;

        if (!isset($this->query['from'])) {
            throw new \InvalidArgumentException(
                'Cannot instantiate a query which does not specify a collection selector (`from`).'
            );
        }
    }

    /**
     * Get all documents matching the provided query filters.
     *
     * This method will not execute an immediate service call. The Query will be
     * executed once you begin iterating over the rows (either by iterating
     * directly on the QuerySnapshot, or by iterating over
     * {@see Google\Cloud\Firestore\QuerySnapshot::rows()}).
     *
     * Example:
     * ```
     * $result = $query->snapshot();
     * ```
     *
     * @param array $options Configuration options.
     * @return QuerySnapshot
     */
    public function snapshot(array $options = [])
    {
        $options['maxRetries'] = (isset($options['maxRetries']))
            ? $options['maxReties']
            : FirestoreClient::MAX_RETRIES;

        $call = function () use ($options) {
            unset($options['maxRetries']);

            return $this->connection->runQuery([
                'parent' => $this->parent,
                'structuredQuery' => $this->query,
                'transaction' => $this->transaction,
                'retries' => 0,
            ] + $options);
        };

        return new QuerySnapshot($this->connection, $this->valueMapper, $this, $call, $options['maxRetries']);
    }

    /**
     * Add a SELECT to the Query.
     *
     * If set, adds a projection to the query, limiting the fields in returned
     * documents to only fields matching the given `$fieldPaths`.
     *
     * Example:
     * ```
     * $query = $query->select(['firstName']);
     * ```
     *
     * @param array $fieldPaths The projection to return, in the form of an
     *        array of field paths. To only return the name of the document, use
     *        `['__name__']`.
     * @return Query A new instance of Query with the given changes applied.
     */
    public function select(array $fieldPaths)
    {
        $fields = [];
        foreach ($fieldPaths as $field) {
            $fields[] = [
                'fieldPath' => $field
            ];
        }

        return $this->newQuery([
            'select' => [
                'fields' => $fields
            ]
        ]);
    }

    /**
     * Add a WHERE clause to the Query.
     *
     * Example:
     * ```
     * $query = $query->where('firstName', '=', 'John');
     * ```
     *
     * @param string $fieldPath The field to filter by.
     * @param string $operator The operator to filter by.
     * @param mixed $value The value to compare to.
     * @return Query A new instance of Query with the given changes applied.
     */
    public function where($fieldPath, $operator, $value)
    {
        $operator = array_key_exists($operator, $this->shortOperators)
            ? $this->shortOperators[$operator]
            : $operator;

        if (!in_array($operator, $this->allowedOperators)) {
            throw new \BadMethodCallException(sprintf(
                'Operator %s is not a valid operator',
                $operator
            ));
        }

        $query = [
            'where' => [
                'compositeFilter' => [
                    'op' => StructuredQuery_CompositeFilter_Operator::PBAND,
                    'filters' => [
                        [
                            'fieldFilter' => [
                                'field' => [
                                    'fieldPath' => $fieldPath,
                                ],
                                'op' => $operator,
                                'value' => $this->valueMapper->encodeValue($value)
                            ]
                        ]
                    ]
                ]
            ]
        ];

        return $this->newQuery($query);
    }

    /**
     * Add an ORDER BY clause to the Query
     *
     * Example:
     * ```
     * $query = $query->orderBy('firstName', 'DESC');
     * ```
     *
     * @param string $fieldPath The field to order by.
     * @param string $direction The direction to order in. **Defaults to** `ASC`.
     * @return Query A new instance of Query with the given changes applied.
     */
    public function orderBy($fieldPath, $direction = self::DIR_ASCENDING)
    {
        $direction = array_key_exists(strtoupper($direction), $this->shortDirections)
            ? $this->shortDirections[strtoupper($direction)]
            : $direction;

        if (!in_array($direction, $this->allowedDirections)) {
            throw new \BadMethodCallException(sprintf(
                'Direction %s is not a valid direction',
                $direction
            ));
        }

        return $this->newQuery([
            'orderBy' => [
                [
                    'field' => [
                        'fieldPath' => $fieldPath
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
     * Multiple invocations of this call overwrite previous calls. Calling
     * `startAt()` will overwrite both previous `startAt()` and `startAfter()`
     * calls.
     *
     * Example:
     * ```
     * $query = $query->startAt($cursor);
     * ```
     *
     * @param array $cursor A list of values.
     * @return Query A new instance of Query with the given changes applied.
     */
    public function startAt(array $cursor)
    {
        return $this->newQuery([
            'startAt' => [
                'before' => true,
                'values' => $this->valueMapper->encodeValues($cursor)
            ]
        ]);
    }

    /**
     * A starting point for the query results.
     *
     * This method starts the result set AFTER the occurence of the given cursor.
     *
     * Multiple invocations of this call overwrite previous calls. Calling
     * `startAt()` will overwrite both previous `startAt()` and `startAfter()`
     * calls.
     *
     * Example:
     * ```
     * $query = $query->startAfter($cursor);
     * ```
     *
     * @param array $cursor A list of values.
     * @return Query A new instance of Query with the given changes applied.
     */
    public function startAfter(array $cursor)
    {
        return $this->newQuery([
            'startAt' => [
                'before' => false,
                'values' => $this->valueMapper->encodeValues($cursor)
            ]
        ]);
    }

    /**
     * An end point for the query results.
     *
     * Multiple invocations of this call overwrite previous calls. Calling
     * `endBefore()` will overwrite both previous `endBefore()` and `endAt()`
     * calls.
     *
     * Example:
     * ```
     * $query = $query->endBefore($cursor);
     * ```
     *
     * @param array $cursor A list of values.
     * @return Query A new instance of Query with the given changes applied.
     */
    public function endBefore(array $cursor)
    {
        return $this->newQuery([
            'endAt' => [
                'before' => true,
                'values' => $this->valueMapper->encodeValues($cursor)
            ]
        ]);
    }

    /**
     * An end point for the query results.
     *
     * This method ends the result set AFTER the occurence of the given cursor.
     *
     * Multiple invocations of this call overwrite previous calls. Calling
     * `endBefore()` will overwrite both previous `endBefore()` and `endAt()`
     * calls.
     *
     * Example:
     * ```
     * $query = $query->endAt($cursor);
     * ```
     *
     * @param array $cursor A list of values.
     * @return Query A new instance of Query with the given changes applied.
     */
    public function endAt(array $cursor)
    {
        return $this->newQuery([
            'endAt' => [
                'before' => false,
                'values' => $this->valueMapper->encodeValues($cursor)
            ]
        ]);
    }

    /**
     * Create a new Query instance
     *
     * @param array $additionalConfig
     * @return Query A new instance of Query with the given changes applied.
     */
    private function newQuery(array $additionalConfig, $reset = false)
    {
        $query = !$reset
            ? $this->arrayMergeRecursive($this->query, $additionalConfig)
            : ['from' => $this->query['from']];

        return new static(
            $this->connection,
            $this->valueMapper,
            $this->parent,
            $query
        );
    }

    /**
     * A method, similar to PHP's `array_merge_recursive`, with two differences.
     *
     * 1. Keys in $array2 take precedence over keys in $array1.
     * 2. Non-array keys found in both inputs are not transformed into an array
     *    and appended. Rather, the value in $array2 is used.
     *
     * @param array $array1
     * @param array $array2
     * @return array
     */
    private function arrayMergeRecursive(array $array1, array $array2)
    {

        foreach ($array2 as $key => $value) {
            if (array_key_exists($key, $array1) && is_array($array1[$key]) && is_array($value)) {
                $array1[$key] = ($this->isAssoc($array1[$key]) && $this->isAssoc($value))
                    ? $this->arrayMergeRecursive($array1[$key], $value)
                    : array_merge($array1[$key], $value);
            } else {
                $array1[$key] = $value;
            }
        }

        return $array1;
    }
}

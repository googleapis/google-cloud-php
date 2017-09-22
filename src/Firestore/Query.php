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

use Google\Cloud\Firestore\Connection\ConnectionInterface;

/**
 * A Cloud Firestore Query.
 *
 * This class is immutable; any filters applied will return a new instance of
 * the class.
 */
class Query
{
    /**
     * @var ConnectionInterface
     */
    private $connection;

    /**
     * @var ValueMapper
     */
    private $valueMapper;

    /**
     * @var array
     */
    private $query;

    /**
     * @var string?
     */
    private $transactionId;

    /**
     * @param ConnectionInterface $connection
     * @param ValueMapper $valueMapper
     * @param array $query
     * @param string? $transactionId
     */
    public function __construct(
        ConnectionInterface $connection,
        ValueMapper $valueMapper,
        array $query,
        $transactionId = null
    ) {
        $this->connection = $connection;
        $this->valueMapper = $valueMapper;
        $this->query = $query;
        $this->transactionId = $transactionId;

        if (!isset($this->query['from'])) {
            throw new \InvalidArgumentException(
                'Cannot instantiate a query which does not specify a collection selector'
            );
        }
    }

    /**
     * Get all documents matching the provided query filters.
     *
     * @param array $options
     * @return QuerySnapshot<Document>
     */
    public function documents(array $options = [])
    {
        $call = function () {
            $res = $this->connection->runQuery([
                'parent' => $this->name,
                'structuredQuery' => $this->query
            ]);
        };

        return new QuerySnapshot($query, $call);
    }

    /**
     * Add a SELECT to the Query.
     *
     * @param array $fieldPaths
     * @return Collection
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
     * @param string $fieldPath
     * @param string $operator
     * @param mixed $value
     * @return Collection
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
                    'op' => StructuredQuery_CompositeFilter_Operator::AND,
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
     * @param string $fieldPath
     * @param string $direction
     * @return Collection
     */
    public function orderBy($fieldPath, $direction)
    {
        $direction = strtoupper($direction);

        $direction = array_key_exists($direction, $this->shortDirections)
            ? $this->shortDirections[$direction]
            : $direction;

        if (!in_array($direction, $this->allowedDirections)) {
            throw new \BadMethodCallException(sprintf(
                'Direction %s is not a valid direction',
                $direction
            ));
        }

        return $this->newQuery([
            'order' => [
                'field' => [
                    'fieldPath' => $fieldPath
                ],
                'direction' => $direction
            ]
        ]);
    }

    public function limit($number)
    {
        return $this->newQuery([
            'limit' => [
                'value' => $number
            ]
        ]);
    }

    public function offset($number)
    {
        return $this->newQuery([
            'offset' => $number
        ]);
    }

    public function startAt(array $fieldValues)
    {
        return $this->newQuery([
            'startAt' => [
                'before' => true,
                'values' => $this->valueMapper->encodeValues($fieldValues)
            ]
        ]);
    }

    public function startAfter(array $fieldValues)
    {
        return $this->newQuery([
            'startAt' => [
                'before' => false,
                'values' => $this->valueMapper->encodeValues($fieldValues)
            ]
        ]);
    }

    public function endBefore(array $fieldValues)
    {
        return $this->newQuery([
            'endAt' => [
                'before' => true,
                'values' => $this->valueMapper->encodeValues($fieldValues)
            ]
        ]);
    }

    public function endAt(array $fieldValues)
    {
        return $this->newQuery([
            'endAt' => [
                'before' => false,
                'values' => $this->valueMapper->encodeValues($fieldValues)
            ]
        ]);
    }

    public function clearQuery()
    {
        return $this->newQuery([], true);
    }

    /**
     * Create a new Query instance
     *
     * @param array $additionalConfig
     * @return Query
     */
    private function newQuery(array $additionalConfig, $reset = false)
    {
        $query = !$reset
            ? array_merge_recursive($this->query, $additionalConfig)
            : [];

        return new static($this->connection, $this->valueMapper, $query);
    }
}

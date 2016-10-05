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

namespace Google\Cloud\Datastore\Query;

use Google\Cloud\Datastore\DatastoreTrait;
use Google\Cloud\Datastore\EntityMapper;
use InvalidArgumentException;

/**
 * Represents a Cloud [Datastore Query](https://cloud.google.com/datastore/docs/concepts/queries)
 *
 * Queries can be created either by using the builder pattern, or by providing
 * a [Query](https://cloud.google.com/datastore/reference/rest/v1/projects/runQuery#query)
 * when creating this object.
 *
 * Example:
 * ```
 * use Google\Cloud\ServiceBuilder;
 *
 * $cloud = new ServiceBuilder();
 * $datastore = $cloud->datastore();
 *
 * $query = $datastore->query();
 * $query->kind('Person');
 * $query->filter('firstName', 'Bob');
 *
 * $result = $datastore->runQuery($query);
 * ```
 *
 * ```
 * // Queries can also be constructed using a Query Object:
 * $query = $datastore->query([
 *     'query' => [
 *         'kind' => [
 *             [
 *                 'name' => 'People'
 *             ]
 *         ],
 *         'filter' => [
 *             'propertyFilter' => [
 *                 'op' => 'EQUAL',
 *                 'property' => [
 *                     'name' => 'firstName'
 *                 ],
 *                 'value' => [
 *                     'stringValue': 'Bob'
 *                 ]
 *             ]
 *         ]
 *     ]
 * ]);
 *
 * $result = $datastore->runQuery($query);
 * ```
 *
 * @see https://cloud.google.com/datastore/reference/rest/v1/projects/runQuery#query Query Object Reference
 * @see https://cloud.google.com/datastore/docs/concepts/queries Datastore Queries
 */
class Query implements QueryInterface
{
    use DatastoreTrait;

    const OP_DEFAULT                = self::OP_EQUALS;
    const OP_LESS_THAN              = 'LESS_THAN';
    const OP_LESS_THAN_OR_EQUAL     = 'LESS_THAN_OR_EQUAL';
    const OP_GREATER_THAN           = 'GREATER_THAN';
    const OP_GREATER_THAN_OR_EQUAL  = 'GREATER_THAN_OR_EQUAL';
    const OP_EQUALS                 = 'EQUAL';
    const OP_HAS_ANCESTOR           = 'HAS_ANCESTOR';

    const ORDER_DEFAULT             = self::ORDER_ASCENDING;
    const ORDER_DESCENDING          = 'ASCENDING';
    const ORDER_ASCENDING           = 'DESCENDING';

    /**
     * @var array A list of all operators supported by datastore
     */
    private $allowedOperators = [
        self::OP_LESS_THAN,
        self::OP_LESS_THAN_OR_EQUAL,
        self::OP_GREATER_THAN,
        self::OP_GREATER_THAN_OR_EQUAL,
        self::OP_EQUALS,
        self::OP_HAS_ANCESTOR,
    ];

    /**
     * @var array A list of comparison operators that map to datastore operators
     */
    private $shortOperators = [
        '<' => self::OP_LESS_THAN,
        '<=' => self::OP_LESS_THAN_OR_EQUAL,
        '>' => self::OP_GREATER_THAN,
        '>=' => self::OP_GREATER_THAN_OR_EQUAL,
        '=' => self::OP_EQUALS
    ];

    /**
     * @var array A list of available ordering directions
     */
    private $allowedOrders = [
        self::ORDER_ASCENDING,
        self::ORDER_DESCENDING
    ];

    /**
     * @var EntityMapper
     */
    private $entityMapper;

    /**
     * @var array
     */
    private $options;

    /**
     * @param EntityMapper $entityMapper An instance of EntityMapper
     * @param array $options [optional] {
     *     Configuration Options
     *
     *     @type array $query [Query](https://cloud.google.com/datastore/reference/rest/v1/projects/runQuery#query)
     * }
     */
    public function __construct(EntityMapper $entityMapper, array $options = [])
    {
        $this->entityMapper = $entityMapper;
        $this->options = $options + [
            'query' => [
                'projection' => [],
                'kind' => [],
                'order' => [],
                'distinctOn' => []
            ]
        ];
    }

    /**
     * Set the Query Projection.
     *
     * Accepts an array of properties. If set, only these properties will be
     * returned.
     *
     * Example:
     * ```
     * $query->projection(['firstName', 'lastName']);
     * ```
     *
     * @param array|string $properties The property or properties to include in
     *        the result.
     * @return Query
     */
    public function projection($properties)
    {
        if (!is_array($properties)) {
            $properties = [$properties];
        }

        foreach ($properties as $property) {
            $this->options['query']['projection'][]['property']['name'] = $property;
        }

        return $this;
    }

    /**
     * Set the Kind to query.
     *
     * If empty, returns entities of all kinds. Must be set in order to filter
     * results. While you may supply as many kinds as you wish, datastore currently
     * only accepts one at a time.
     *
     * Example:
     * ```
     * $query->kind('Person');
     * ```
     *
     * @param array|string $kinds The kind or kinds to return. Only a single kind
     *        is currently supported.
     * @return Query
     */
    public function kind($kinds)
    {
        if (!is_array($kinds)) {
            $kinds = [$kinds];
        }

        foreach ($kinds as $kind) {
            $this->options['query']['kind'][] = $this->propertyName($kind);
        }

        return $this;
    }

    /**
     * Add a filter to the query.
     *
     * If the top-level filter is specified as a propertyFilter, it will be replaced.
     * Any composite filters will be preserved and the new filter will be added.
     *
     * Example:
     * ```
     * $query->filter('firstName', '=', 'Bob')
     *     ->filter('lastName', '=', 'Testguy');
     * ```
     *
     * @see https://cloud.google.com/datastore/reference/rest/v1/projects/runQuery#operator_1 Allowed Operators
     *
     * @param string $property The property to filter.
     * @param string $operator The operator to use in the filter. A list of
     *        allowed operators may be found
     *        [here](https://cloud.google.com/datastore/reference/rest/v1/projects/runQuery#operator_1).
     *        Short comparison operators are provided for convenience and are
     *        mapped to their datastore-compatible equivalents. Available short
     *        operators are `=`, `<`, `<=`, `>`, and `>=`.
     * @param mixed $value The value to check.
     * @return Query
     */
    public function filter($property, $operator, $value)
    {
        if (!isset($this->options['query']['filter']) || !isset($this->options['query']['filter']['compositeFilter'])) {
            $this->initializeFilter();
        }

        $this->options['query']['filter']['compositeFilter']['filters'][] = [
            'propertyFilter' => [
                'property' => $this->propertyName($property),
                'value' => $this->entityMapper->valueObject($value),
                'op' => $this->mapOperator($operator)
            ]
        ];

        return $this;
    }

    /**
     * Specify an order for the query
     *
     * Example:
     * ```
     * $query->order('birthDate');
     * ```
     *
     * @see https://cloud.google.com/datastore/reference/rest/v1/projects/runQuery#Direction Allowed Directions
     *
     * @param string $property The property to order by.
     * @param string $direction The direction to order in.
     * @return Query
     */
    public function order($property, $direction = self::ORDER_DEFAULT)
    {
        $this->options['query']['order'][] = [
            'property' => $this->propertyName($property),
            'direction' => $direction
        ];

        return $this;
    }

    /**
     * The properties to make distinct.
     *
     * The query results will contain the first result for each distinct
     * combination of values for the given properties (if empty, all results
     * are returned).
     *
     * Example:
     * ```
     * $query->distinctOn('lastName');
     * ```
     *
     * @param array|string $property The property or properties to make distinct.
     * @return Query
     */
    public function distinctOn($property)
    {
        if (!is_array($property)) {
            $property = [$property];
        }

        foreach ($property as $prop) {
            $this->options['query']['distinctOn'][] = $this->propertyName($prop);
        }

        return $this;
    }

    /**
     * The starting point for the query results
     *
     * Example:
     * ```
     * $query->start($lastResultCursor);
     * ```
     *
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/datastore/docs/concepts/queries#cursors_limits_and_offsets Cursors, Limits and Offsets
     * @codingStandardsIgnoreEnd
     *
     * @param string $cursor The cursor on which to start the result.
     * @return Query
     */
    public function start($cursor)
    {
        $this->options['query']['startCursor'] = $cursor;

        return $this;
    }

    /**
     * The ending point for the query results
     *
     * Example:
     * ```
     * $query->end($lastResultCursor);
     * ```
     *
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/datastore/docs/concepts/queries#cursors_limits_and_offsets Cursors, Limits and Offsets
     * @codingStandardsIgnoreEnd
     *
     * @param string $cursor The cursor on which to end the result.
     * @return Query
     */
    public function end($cursor)
    {
        $this->options['query']['endCursor'] = $cursor;

        return $this;
    }

    /**
     * The number of results to skip
     *
     * Example:
     * ```
     * $query->offset(2);
     * ```
     *
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/datastore/docs/concepts/queries#cursors_limits_and_offsets Cursors, Limits and Offsets
     * @codingStandardsIgnoreEnd
     *
     * @param int $num The number of results to skip.
     * @return Query
     */
    public function offset($num)
    {
        $this->options['query']['offset'] = $num;

        return $this;
    }

    /**
     * The number of results to return
     *
     * Example:
     * ```
     * $query->limit(50);
     * ```
     *
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/datastore/docs/concepts/queries#cursors_limits_and_offsets Cursors, Limits and Offsets
     * @codingStandardsIgnoreEnd
     *
     * @param int $num The number of results to return.
     * @return Query
     */
    public function limit($num)
    {
        $this->options['query']['limit'] = $num;

        return $this;
    }

    /**
     * Indicate that this type does support automatic pagination.
     *
     * @access private
     * @return bool
     */
    public function canPaginate()
    {
        return true;
    }

    /**
     * Return a service-compliant array.
     *
     * This method is intended for use internally by the PHP client.
     *
     * @access private
     * @return array
     */
    public function queryObject()
    {
        return array_filter($this->options['query']);
    }

    /**
     * Return the query_type union field name.
     *
     * @return string
     * @access private
     */
    public function queryKey()
    {
        return "query";
    }

    /**
     * @access private
     */
    public function jsonSerialize()
    {
        return $this->queryObject();
    }

    /**
     * Setup the filter object when the first filter is created
     *
     * @return void
     */
    private function initializeFilter()
    {
        $this->options['query']['filter'] = [
            'compositeFilter' => [
                'filters' => [],
                'op' => 'AND'
            ]
        ];
    }

    /**
     * Format a property name
     *
     * @param string $property The property name.
     * @return array
     */
    private function propertyName($property)
    {
        return [
            'name' => $property
        ];
    }

    /**
     * Convert given operator to API-compatible operator
     *
     * @param string $operator
     * @return string
     */
    private function mapOperator($operator)
    {
        if (array_key_exists($operator, $this->shortOperators)) {
            $operator = $this->shortOperators[$operator];
        }

        if (!in_array($operator, $this->allowedOperators)) {
            throw new InvalidArgumentException(sprintf(
                'Invalid operator `%s` given. Valid operators are %s.',
                $operator,
                implode(', ', $this->allowedOperators)
            ));
        }

        return $operator;
    }
}

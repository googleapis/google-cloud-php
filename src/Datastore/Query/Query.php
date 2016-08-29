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

use Google\Cloud\Datastore\DatastoreClient;
use Google\Cloud\Datastore\DatastoreTrait;
use InvalidArgumentException;

/**
 * Represents a Cloud [Datastore Query](https://cloud.google.com/datastore/docs/concepts/queries)
 *
 * Queries can be created either by using the builder pattern, or by providing
 * a [Query](https://cloud.google.com/datastore/reference/rest/v1beta3/projects/runQuery#query)
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
 * @see https://cloud.google.com/datastore/reference/rest/v1beta3/projects/runQuery#query Query Object Reference
 * @see https://cloud.google.com/datastore/docs/concepts/queries Datastore Queries
 */
class Query implements QueryInterface
{
    use DatastoreTrait;

    private $allowedOperators = [
        self::OP_LESS_THAN,
        self::OP_LESS_THAN_OR_EQUAL,
        self::OP_GREATER_THAN,
        self::OP_GREATER_THAN_OR_EQUAL,
        self::OP_EQUALS,
        self::OP_HAS_ANCESTOR,
    ];

    private $allowedOrders = [
        self::ORDER_ASCENDING,
        self::ORDER_DESCENDING
    ];

    /**
     * @var string
     */
    private $projectId;

    /**
     * @var array
     */
    private $options;

    /**
     * @param string $projectId The Google Cloud Platform Project ID
     * @param array $options {
     *     Configuration Options
     *
     *     @type array $query [Query](https://cloud.google.com/datastore/reference/rest/v1beta3/projects/runQuery#query)
     * }
     */
    public function __construct($projectId, array $options = [])
    {
        $this->projectId = $projectId;
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
        return [
            'partitionId' => $this->partitionId($this->projectId, $this->options),
            'readOptions' => $this->readOptions($this->options),
            'query' => array_filter($this->options['query'])
        ];
    }

    /**
     * @access private
     */
    public function jsonSerialize()
    {
        return $this->queryObject();
    }

    /**
     * Set the Query Projection.
     *
     * Accepts an array of properties. If set, only these properties will be
     * returned.
     *
     * @param array|string $properties The property or properties to include in
     *        the result
     * @return Query
     */
    public function projection($properties)
    {
        if (!is_array($properties)) {
            $properties = [$properties];
        }

        $this->options['query']['projection'] = $properties;

        return $this;
    }

    /**
     * Set the Kind to query.
     *
     * If empty, returns entities of all kinds. Must be set in order to filter
     * results. While you may supply as many kinds as you wish, datastore currently
     * only accepts one at a time.
     *
     * @param array|string $kinds
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
     * @see https://cloud.google.com/datastore/reference/rest/v1beta3/projects/runQuery#operator_1 Allowed Operators
     *
     * @param string $property The property to filter
     * @param mixed $value The value to check
     * @param string $operator The operator to use in the filter.
     * @return Query
     */
    public function filter($property, $value, $operator = self::OP_DEFAULT)
    {
        if (!isset($this->options['query']['filter']) || !isset($this->options['query']['filter']['compositeFilter'])) {
            $this->initializeFilter();
        }

        $this->options['query']['filter']['compositeFilter']['filters'][] = [
            'propertyFilter' => [
                'property' => $this->propertyName($property),
                'value' => $this->valueObject($value),
                'op' => $operator
            ]
        ];

        return $this;
    }

    /**
     * Specify an order for the query
     *
     * @see https://cloud.google.com/datastore/reference/rest/v1beta3/projects/runQuery#Direction Allowed Directions
     *
     * @param string $property The property to order by
     * @param string $direction The direction to order in
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
     * @param array|string $property The property or properties to make distinct
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
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/datastore/docs/concepts/queries#cursors_limits_and_offsets Cursors, Limits and Offsets
     * @codingStandardsIgnoreEnd
     *
     * @param string $cursor The cursor on which to start the result
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
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/datastore/docs/concepts/queries#cursors_limits_and_offsets Cursors, Limits and Offsets
     * @codingStandardsIgnoreEnd
     *
     * @param string $cursor The cursor on which to end the result
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
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/datastore/docs/concepts/queries#cursors_limits_and_offsets Cursors, Limits and Offsets
     * @codingStandardsIgnoreEnd
     *
     * @param int $num The number of results to skip
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
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/datastore/docs/concepts/queries#cursors_limits_and_offsets Cursors, Limits and Offsets
     * @codingStandardsIgnoreEnd
     *
     * @param int $num The number of results to retun
     * @return Query
     */
    public function limit($num)
    {
        $this->options['query']['limit'] = $num;

        return $this;
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
     * @param string $property The property name
     * @return array
     */
    private function propertyName($property)
    {
        return [
            'name' => $property
        ];
    }
}

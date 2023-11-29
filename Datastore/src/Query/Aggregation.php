<?php
/**
 * Copyright 2023 Google Inc. All Rights Reserved.
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

/**
 * Represents Aggregation properties.
 *
 * Example:
 * ```
 * $count = Aggregation::count();
 * $count->alias('count');
 * $count->limit(100);
 *
 * echo json_encode($count->getProps());
 * ```
 *
 * Aggregations considers non existing property name as an empty query set
 */
class Aggregation
{
    /**
     * Default placeholder for all count aggregation props.
     */
    private const TYPE_COUNT = 'count';

    /**
     * Default placeholder for all sum aggregation props.
     */
    private const TYPE_SUM = 'sum';

    /**
     * Default placeholder for all average aggregation props.
     */
    private const TYPE_AVG = 'avg';

    /**
     * @var array Properties for an aggregation query.
     */
    private array $props = [];

    /**
     * @var string Holds key for aggregation type.
     */
    private $aggregationType;

    /**
     * Construct an Aggregation object.
     *
     * @param string $aggregationType
     */
    private function __construct($aggregationType)
    {
        $this->aggregationType = $aggregationType;
    }

    /**
     * Creates count aggregation properties.
     *
     * Example:
     * ```
     * $count = Aggregation::count();
     * ```
     * @return Aggregation
     */
    public static function count()
    {
        return self::createAggregation(self::TYPE_COUNT);
    }

    /**
     * Creates sum aggregation properties.
     *
     * Example:
     * ```
     * $sum = Aggregate::sum('property_to_aggregate_upon');
     * ```
     * Result of SUM aggregation can be a integer or a float.
     * Sum of integers which exceed maxinum integer value returns a float.
     * Sum of numbers exceeding max float value returns `INF`.
     * Sum of data which contains `NaN` returns `NaN`.
     * Non numeric values are ignored.
     *
     * @param string $property The relative path of the field to aggregate upon.
     * @return Aggregation
     */
    public static function sum($property)
    {
        return self::createAggregation(self::TYPE_SUM, $property);
    }

    /**
     * Creates average aggregation properties.
     *
     * Example:
     * ```
     * $avg = Aggregate::avg('property_to_aggregate_upon');
     * ```
     * Result of AVG aggregation can be a float or a null.
     * Average of empty valid data set return `null`.
     * Average of numbers exceeding max float value returns `INF`.
     * Average of data which contains `NaN` returns `NaN`.
     * Non numeric values are ignored.
     *
     * @param string $property The relative path of the field to aggregate upon.
     * @return Aggregation
     */
    public static function avg($property)
    {
        return self::createAggregation(self::TYPE_AVG, $property);
    }

    private static function createAggregation(string $type, $property = null)
    {
        $aggregation = new Aggregation($type);
        $aggregation->props[$aggregation->aggregationType] = [];
        if (!is_null($property)) {
            $aggregation->props[$aggregation->aggregationType] = [
                'property' => [
                    'name' => $property
                ]
            ];
        }
        return $aggregation;
    }

    /**
     * Set the aggregation alias.
     *
     * Example:
     * ```
     * $count = Aggregation->count();
     * $count->alias('total');
     *
     * echo $count->props()['count']['alias'];
     * ```
     *
     * @param string $alias The alias for aggregation.
     * @return Aggregation
     */
    public function alias($alias)
    {
        $this->props['alias'] = $alias;
        return $this;
    }

    /**
     * Get the array representation for the aggregation.
     *
     * @return array
     */
    public function getProps()
    {
        return $this->props;
    }
}

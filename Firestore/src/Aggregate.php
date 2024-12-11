<?php
/**
 * Copyright 2023 Google Inc.
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

/**
 * Represents Aggregate properties.
 *
 * Example:
 * ```
 * $count = Aggregate::count();
 * $count->alias('count');
 *
 * echo json_encode($count->getProps());
 * ```
 */
class Aggregate
{
    /**
     * Default placeholder for all count aggregate props.
     */
    private const TYPE_COUNT = 'count';

    /**
     * Default placeholder for all sum aggregate props.
     */
    private const TYPE_SUM = 'sum';

    /**
     * Default placeholder for all average aggregate props.
     */
    private const TYPE_AVG = 'avg';

    /**
     * @var array Aggregation properties for an AggregateQuery.
     */
    private $props = [];

    /**
     * @var string Holds key for aggregation type.
     */
    private $aggregationType;

    private function __construct($aggregationType)
    {
        $this->aggregationType = $aggregationType;
    }

    /**
     * Creates count aggregation properties.
     *
     * Example:
     * ```
     * $count = Aggregate::count();
     * ```
     * @return Aggregate
     */
    public static function count()
    {
        return self::createAggregate(self::TYPE_COUNT);
    }

    /**
     * Creates sum aggregation properties.
     *
     * Example:
     * ```
     * $sum = Aggregate::sum('field_to_aggregate_upon');
     * ```
     * Result of SUM aggregation can be a integer or a float.
     * Sum of integers which exceed maxinum integer value returns a float.
     * Sum of numbers exceeding max float value returns `INF`.
     * Sum of data which contains `NaN` returns `NaN`.
     * Non numeric values are ignored.
     *
     * @param string $field The relative path of the field to aggregate upon.
     * @return Aggregate
     */
    public static function sum($field)
    {
        return self::createAggregate(self::TYPE_SUM, $field);
    }

    /**
     * Creates average aggregation properties.
     *
     * Example:
     * ```
     * $avg = Aggregate::avg('field_to_aggregate_upon');
     * ```
     *
     * Result of AVG aggregation can be a float or a null.
     * Average of empty valid data set return `null`.
     * Average of numbers exceeding max float value returns `INF`.
     * Average of data which contains `NaN` returns `NaN`.
     * Non numeric values are ignored.
     *
     * @param string|null $field The relative path of the field to aggregate upon.
     * @return Aggregate
     */
    public static function avg($field)
    {
        return self::createAggregate(self::TYPE_AVG, $field);
    }

    private static function createAggregate(string $type, $field = null)
    {
        $aggregate = new Aggregate($type);
        $aggregate->props[$aggregate->aggregationType] = [];
        if (!is_null($field)) {
            $aggregate->props[$aggregate->aggregationType] = [
                'field' => [
                    'fieldPath' => $field
                ]
            ];
        }
        return $aggregate;
    }

    /**
     * Set the aggregate alias.
     *
     * Example:
     * ```
     * $count = Aggregate->count();
     * $count->alias('total');
     *
     * echo $count->props()['alias'];
     * ```
     *
     * @param string $alias The alias for aggregate.
     * @return Aggregate
     */
    public function alias($alias)
    {
        $this->props['alias'] = $alias;
        return $this;
    }

    /**
     * Get the array representation for the aggregate.
     *
     * @return array
     */
    public function getProps()
    {
        return $this->props;
    }
}

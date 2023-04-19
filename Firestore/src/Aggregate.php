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

use InvalidArgumentException;

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
        $count = new Aggregate(self::TYPE_COUNT);
        $count->props[$count->aggregationType] = [];
        return $count;
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

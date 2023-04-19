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
 * Represents Count Aggregation properties.
 *
 * Example:
 * ```
 * $count = Aggregation::count();
 * $count->alias('count');
 * $count->limit(100);
 *
 * echo json_encode($count->getProps());
 * ```
 */
class Aggregation
{
    /**
     * Default placeholder for all count aggregation props.
     */
    private const TYPE_COUNT = 'count';

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
        $count = new Aggregation(self::TYPE_COUNT);
        $count->props[$count->aggregationType] = [];
        return $count;
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

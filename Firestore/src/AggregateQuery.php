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

use Google\Cloud\Firestore\Connection\ConnectionInterface;

/**
 * A Cloud Firestore Aggregate Query.
 *
 * Example:
 * ```
 * use Google\Cloud\Firestore\FirestoreClient;
 *
 * $firestore = new FirestoreClient();
 *
 * $collection = $firestore->collection('users');
 * $query = $collection->where('age', '>', 18)->count();
 * ```
 */
class AggregateQuery
{
    use QueryTrait;

    /**
     * @var ConnectionInterface
     * @internal
     */
    private $connection;

    /**
     * @var array
     */
    private $query;

    /**
     * @var string
     */
    private $parentName;

    /**
     * @var array
     */
    private $aggregates = [];

    /**
     * Create an aggregation query.
     *
     * @param ConnectionInterface $connection A Connection to Cloud Firestore.
     *        This object is created by FirestoreClient,
     *        and should not be instantiated outside of this client.
     * @param string $parent The parent of the query.
     * @param array $query Represents the underlying structured query.
     * @param Aggregate $aggregate Aggregation over the provided query.
     */
    public function __construct(
        ConnectionInterface $connection,
        $parent,
        array $query,
        Aggregate $aggregate
    ) {
        $this->connection = $connection;
        $this->parentName = $parent;
        $this->query = $query;
        $this->aggregates[] = $aggregate;
    }

    /**
     * Adds provided aggregation to AggregateQuery.
     *
     * @param Aggregate $aggregate Aggregate properties to be applied over query.
     * @return AggregateQuery
     */
    public function addAggregation($aggregate)
    {
        $this->aggregates[] = $aggregate;
        return $this;
    }

    /**
     * Executes the AggregateQuery.
     *
     * @param array $options [optional] {
     *     Configuration options is an array.
     *
     *     @type Timestamp $readTime Reads entities as they were at the given timestamp.
     * }
     * @return AggregateQuerySnapshot
     */
    public function getSnapshot($options = [])
    {
        $parsedAggregates = [];
        foreach ($this->aggregates as $aggregate) {
            $parsedAggregates[] = $aggregate->getProps();
        }
        $snapshot = $this->connection->runAggregationQuery([
            'parent' => $this->parentName,
            'structuredAggregationQuery' => $this->aggregateQueryPrepare([
                'aggregates' => $this->aggregates
            ] + $this->query),
        ] + $options)->current();

        return new AggregateQuerySnapshot($snapshot);
    }

    /**
     * Clean up the Aggregate query array before sending.
     *
     * @param array $query
     * @return array The final aggregation query data.
     */
    private function aggregateQueryPrepare(array $query)
    {
        $parsedAggregates = [];
        foreach ($query['aggregates'] as $aggregate) {
            $parsedAggregates[] = $aggregate->getProps();
        }
        unset($query['aggregates']);
        return [
            'structuredQuery' => $this->structuredQueryPrepare($query),
            'aggregations' => $parsedAggregates
        ];
    }
}

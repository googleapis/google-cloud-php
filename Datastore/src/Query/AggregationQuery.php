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

use Google\Cloud\Datastore\Query\Query;

/**
 * Represents an [Aggregation Query](https://cloud.google.com/datastore/docs/aggregation-queries).
 *
 * Example:
 * ```
 * use Google\Cloud\Datastore\DatastoreClient;
 *
 * $datastore = new DatastoreClient();
 *
 * $query = $datastore->AggregationQuery();
 * $query->kind('Companies');
 * $query->filter('companyName', '=', 'Google');
 * $query->addAggregation(Aggregation::count()->alias('total_upto_100'));
 *
 * $res = $datastore->runAggregationQuery($query);
 * echo $res->get('total_upto_100');
 * ```
 *
 * @see https://cloud.google.com/datastore/reference/rest/v1/projects/runAggregationQuery#query
 * Aggregation Query Object Reference
 * @see https://cloud.google.com/datastore/docs/aggregation-queries Aggregation Queries
 */
class AggregationQuery
{
    const TYPE_COUNT = 'count';

    /**
     * @var QueryInterface|null
     */
    private $query;

    /**
     * @var array
     */
    private $aggregates = [];

    /**
     * Create an aggregation query.
     *
     * @param QueryInterface|null $query
     */
    public function __construct($query = null)
    {
        $this->query = $query;
    }

    /**
     * Adds a Query Aggregation.
     *
     * Accepts an array of properties for aggregation.
     *
     * Example:
     * ```
     *
     * $query = $datastore->AggregationQuery();
     * $query->kind('Companies');
     * $query->filter('companyName', '=', 'Google');
     * $query->addAggregation(Aggregation::count()->alias('total'));
     * echo json_encode($query->queryObject());
     * ```
     *
     * @param Aggregation|null $aggregation The Aggregation to be included.
     *        Should be null for GqlQuery.
     * @return AggregationQuery
     */
    public function addAggregation($aggregation)
    {
        $this->aggregates[] = $aggregation->getProps();
        return $this;
    }

    /**
     * Set the Query Projection.
     *
     * Accepts an array of properties. If set, only these properties will be
     * returned.
     *
     * Example:
     * ```
     * $query = $datastore->query();
     * $query->kind('Companies');
     * $query->filter('companyName', '=', 'Google');
     *
     * $pipeline = $datastore->AggregationQuery()
     *     ->over($query)
     *     ->addAggregation(Aggregation::count()->alias('total'));
     * ```
     *
     * @param QueryInterface $query The query whose properties to include.
     * @return AggregationQuery
     */
    public function over($query)
    {
        $this->query = $query;
        return $this;
    }

    public function queryObject()
    {
        if ($this->query instanceof Query) {
            return [
                'aggregationQuery' => [
                    'nestedQuery' => $this->query->queryObject(),
                    'aggregations' => $this->aggregates,
                ]
            ];
        } elseif ($this->query instanceof GqlQuery) {
            return [
                'gqlQuery' => $this->query->queryObject(),
            ];
        } else {
            throw new \UnexpectedValueException('unknown query type');
        }
    }

    /**
     * Return the query_type union field name.
     *
     * @return string
     * @access private
     */
    public function queryKey()
    {
        return "aggregationQuery";
    }
}

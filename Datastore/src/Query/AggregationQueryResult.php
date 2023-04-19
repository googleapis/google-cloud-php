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

use Google\Cloud\Core\Timestamp;
use Google\Cloud\Core\TimestampTrait;
use InvalidArgumentException;

/**
 * Represents the result of an [Aggregation Query](https://cloud.google.com/datastore/docs/aggregation-queries)
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
 * $query->limit(100);
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
class AggregationQueryResult
{
    use TimestampTrait;

    /**
     * @var AggregationQuery
     */
    private $query;

    /**
     * @var Timestamp
     */
    private $readTime;

    /**
     * @var array
     */
    private array $aggregationResults = [];

    /**
     * @var string|null
     */
    private $transaction;

    /**
     * Create AggregationQueryResult object.
     *
     * @param array $result Response of
     *        [RunAggregationQuery](https://cloud.google.com/datastore/docs/reference/data/rest/v1/projects/runAggregationQuery)
     */
    public function __construct($result = [])
    {
        // When executing an Agggregation query nested with GqlQuery, the server will return
        // the parsed query with the first response batch.
        if (isset($result['query'])) {
            $this->query = new AggregationQuery(
                $result['query']['nestedQuery'],
                $result['query']['aggregations']
            );
        }
        if (isset($result['transaction'])) {
            $this->transaction = $result['transaction'];
        }
        if (isset($result['batch']['aggregationResults'])) {
            $this->aggregationResults = $result['batch']['aggregationResults'];
        }
        if (isset($result['batch']['readTime'])) {
            $this->readTime = $result['batch']['readTime'];
        }
    }

    /**
     * Get the Query Aggregation value.
     *
     * Example:
     * ```
     * $query = $datastore->AggregationQuery();
     * $query->kind('Companies');
     * $query->filter('companyName', '=', 'Google');
     * $query->addAggregation(Aggregation::count()->alias('total'));
     * $res = $client->runAggregationQuery($query);
     * echo $res->get('total');
     * ```
     *
     * @param string $alias The aggregation alias.
     * @return int
     * @throws InvalidArgumentException If provided alias does not exist in result.
     */
    public function get($alias)
    {
        if (!isset($this->aggregationResults[0]['aggregateProperties'][$alias])) {
            throw new InvalidArgumentException('alias does not exist');
        }
        $result = $this->aggregationResults[0]['aggregateProperties'][$alias];
        if (is_array($result)) {
            return $result['integerValue'];
        }
        return $result;
    }

    /**
     * Gets the value of query for example in case of a GqlQuery.
     *
     * @return AggregationQuery
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * Gets the transaction id when Aggregation is associated with a Transaction.
     *
     * @return string|null
     */
    public function getTransaction()
    {
        return $this->transaction;
    }

    /**
     * Gets the timsstamp when Aggregation was executed.
     *
     * @return Timestamp
     */
    public function getReadTime()
    {
        return $this->readTime;
    }
}

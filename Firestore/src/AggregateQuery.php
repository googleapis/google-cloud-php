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

use Google\ApiCore\ApiException;
use Google\ApiCore\Options\CallOptions;
use Google\Cloud\Core\ApiHelperTrait;
use Google\Cloud\Core\Exception\ServiceException;
use Google\Cloud\Core\OptionsValidator;
use Google\Cloud\Core\RequestProcessorTrait;
use Google\Cloud\Firestore\V1\Client\FirestoreClient;
use Google\Cloud\Firestore\V1\ExplainOptions;
use Google\Cloud\Firestore\V1\RunAggregationQueryRequest;
use InvalidArgumentException;

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
    use ApiHelperTrait;
    use QueryTrait;
    use RequestProcessorTrait;

    private FirestoreClient $gapicClient;
    private array $query;
    private string $parentName;
    private array $aggregates = [];
    private Serializer $serializer;
    private OptionsValidator $optionsValidator;

    /**
     * Create an aggregation query.
     *
     * @param FirestoreClient $firestoreClient A FirestoreClient instance.
     * @param string $parent The parent of the query.
     * @param array $query Represents the underlying structured query.
     * @param Aggregate $aggregate Aggregation over the provided query.
     */
    public function __construct(
        FirestoreClient $firestoreClient,
        $parent,
        array $query,
        Aggregate $aggregate
    ) {
        $this->gapicClient = $firestoreClient;
        $this->parentName = $parent;
        $this->query = $query;
        $this->aggregates[] = $aggregate;
        $this->serializer = new Serializer();
        $this->optionsValidator = new OptionsValidator($this->serializer);
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
     *     @type ExplainOptions $explainOptions An instance of the ExplainOptions class.
     *           {@see \Google\Cloud\Firestore\ExplainOptions}
     * }
     * @return AggregateQuerySnapshot
     * @throws ServiceException
     */
    public function getSnapshot($options = [])
    {
        $parsedAggregates = [];

        if (isset($options['explainOptions']) && !$options['explainOptions'] instanceof ExplainOptions) {
            throw new InvalidArgumentException(
                'The explainOptions option must be an instance of the ExplainOptions class.'
            );
        }

        /** @var Aggregate $aggregate */
        foreach ($this->aggregates as $aggregate) {
            $parsedAggregates[] = $aggregate->getProps();
        }

        $jsonStructuredAggregationQuery = $this->aggregateQueryPrepare([
            'aggregates' => $this->aggregates
        ] + $this->query);

        $options += [
            'structuredAggregationQuery' => $jsonStructuredAggregationQuery,
            'parent' => $this->parentName
        ];

        /**
         * @var RunAggregationQueryRequest $request
         * @var CallOptions $callOptions
         */
        [$request, $callOptions] = $this->validateOptions(
            $options,
            new RunAggregationQueryRequest(),
            CallOptions::class
        );

        try {
            $snapshot = $this->gapicClient->runAggregationQuery($request, $callOptions)->readAll()->current();
        } catch (ApiException $ex) {
            throw $this->convertToGoogleException($ex);
        }

        return new AggregateQuerySnapshot($this->serializer->encodeMessage($snapshot));
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

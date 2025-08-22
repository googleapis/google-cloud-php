<?php
/**
 * Copyright 2017 Google Inc. All Rights Reserved.
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

namespace Google\Cloud\Datastore;

use Google\Cloud\Core\Iterator\ItemIteratorTrait;
use Google\Cloud\Datastore\V1\ExplainMetrics;

/**
 * Iterates over a set of {@see \Google\Cloud\Datastore\Entity} items.
 */
class EntityIterator implements \Iterator
{
    use ItemIteratorTrait;

    /**
     * @var null|ExplainMetrics
     */
    private null|ExplainMetrics $explainMetrics = null;

    /**
     * The state of the query after the current batch.
     *
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/datastore/docs/reference/rest/v1/projects/runQuery#MoreResultsType MoreResultsType Documentation
     * @codingStandardsIgnoreEnd
     *
     * @return string|null
     */
    public function moreResultsType()
    {
        return method_exists($this->pageIterator, 'moreResultsType')
            ? $this->pageIterator->moreResultsType()
            : null;
    }

    /**
     * Returns a ExplainMetrics object from the query.
     *
     * By default, the query does not get executed and the explain metrics object
     * contains only the planning statistics {@see \Google\Cloud\Datastore\V1\ExplainMetrics}.
     *
     * If the request was configured with the ExplainOptions object `Analyze` attribute to true
     * the request then also gets executed, including the ExecutionStats on the ExplainMetrics
     * object
     *
     * Contrary to looping through the result of run query, this method caches the first metrics
     * to avoid variations when analyzing said metrics.
     *
     * Example:
     * ```
     * use Google\Cloud\Datastore\DatastoreClient;
     * use Google\Cloud\Datastore\V1\ExplainOptions;
     *
     * $datastore = new DatastoreClient();
     *
     * explainOptions = (new ExplainOptions())->setAnalyze(false);
     * $queryOptions = [
     *     'explainOptions' => $explainOptions
     * ];
     *
     * // The query does not get executed
     * $res = $datastore->runQuery($query, $queryOptions);
     *
     * $explainMetrics = $res->getExplainMetrics();
     *
     * // This is populated
     * $explainMetrics->planningSummary
     *
     * // This is not populated
     * $explainMetrics->executionStats
     * ```
     *
     * Example:
     * ```
     * explainOptions = (new ExplainOptions())->setAnalyze(true);
     * $queryOptions = [
     *     'explainOptions' => $explainOptions
     * ];
     *
     * // The query does not get executed
     * $res = $datastore->runQuery($query, $queryOptions);
     *
     * $explainMetrics = $res->getExplainMetrics();
     *
     * // This is populated
     * $explainMetrics->getPlanSummary()
     *
     * // This is also populated
     * $explainMetrics->getExecutionStats()
     * ```
     *
     * @return null|ExplainMetrics
     */
    public function getExplainMetrics(): null|ExplainMetrics
    {
        if (is_null($this->explainMetrics)) {
            $this->explainMetrics = $this->gatherExplainMetrics();
        }

        return $this->explainMetrics;
    }

    private function gatherExplainMetrics(): null|explainMetrics
    {
        $metrics = null;
        $this->pageIterator->current();

        while (is_null($metrics)) {
            $metrics = $this->pageIterator->getExplainMetrics();

            if (!$this->nextResultToken()) {
                break;
            }

            $this->pageIterator->next();
        }

        $this->rewind();

        if (is_null($metrics)) {
            return null;
        }

        $explainMetrics = new ExplainMetrics();
        $jsonString = json_encode($metrics);
        $explainMetrics->mergeFromJsonString($jsonString);

        return $explainMetrics;
    }
}

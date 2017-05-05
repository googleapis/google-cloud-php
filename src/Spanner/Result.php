<?php
/**
 * Copyright 2016 Google Inc.
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

namespace Google\Cloud\Spanner;

use Grpc;
use Google\Cloud\Core\Exception\ServiceException;
use Google\Cloud\Core\ExponentialBackoff;
use Google\Cloud\Spanner\Session\Session;
use Google\Cloud\Spanner\Session\SessionPoolInterface;
use Google\Cloud\Spanner\Timestamp;

/**
 * Represent a Cloud Spanner lookup result (either read or executeSql).
 *
 * Example:
 * ```
 * use Google\Cloud\Spanner\SpannerClient;
 *
 * $spanner = new SpannerClient();
 *
 * $database = $spanner->connect('my-instance', 'my-database');
 * $result = $database->execute('SELECT * FROM Posts');
 * ```
 *
 * @see https://cloud.google.com/spanner/docs/reference/rpc/google.spanner.v1#google.spanner.v1.ResultSet ResultSet
 */
class Result implements \IteratorAggregate
{
    const BUFFER_RESULT_LIMIT = 10;

    /**
     * @var array
     */
    private $columns = [];

    /**
     * @var int
     */
    private $columnCount;

    /**
     * @var ValueMapper
     */
    private $mapper;

    /**
     * @var array|null
     */
    private $metadata;

    /**
     * @var Operation
     */
    private $operation;

    /**
     * @var int
     */
    private $retries;

    /**
     * @var string|null
     */
    private $resumeToken;

    /**
     * @var Session
     */
    private $session;

    /**
     * @var Snapshot|null
     */
    private $snapshot;

    /**
     * @var array|null
     */
    private $stats;

    /**
     * @var Transaction|null
     */
    private $transaction;

    /**
     * @var string
     */
    private $transactionContext;

    /**
     * @param Operation $operation Runs operations against Google Cloud Spanner.
     * @param Session $session The session used for any operations executed.
     * @param \Generator $resultGenerator Reads rows from Google Cloud Spanner.
     * @param string $transactionContext The transaction's context.
     * @param ValueMapper $mapper Maps values.
     * @param int $retries Number of attempts to resume a broken stream, assuming
     *        a resume token is present. **Defaults to** 3.
     */
    public function __construct(
        Operation $operation,
        Session $session,
        callable $call,
        $transactionContext,
        ValueMapper $mapper,
        $retries = 3
    ) {
        $this->operation = $operation;
        $this->session = $session;
        $this->call = $call;
        $this->transactionContext = $transactionContext;
        $this->mapper = $mapper;
        $this->retries = $retries;
    }

    /**
     * Return the formatted and decoded rows. If the stream is interrupted and
     * a resume token is available, attempts will be made on your behalf to
     * resume.
     *
     * Example:
     * ```
     * $rows = $result->rows();
     * ```
     *
     * @return \Generator
     */
    public function rows()
    {
        $bufferedResults = [];
        $call = $this->call;
        $generator = $call();
        $shouldRetry = false;

        while ($generator->valid()) {
            try {
                $result = $generator->current();
                $bufferedResults[] = $result;
                $this->setResultData($result);

                if (!isset($result['values'])) {
                    return;
                }

                if (isset($result['resumeToken']) || count($bufferedResults) >= self::BUFFER_RESULT_LIMIT) {
                    list($yieldableRows, $chunkedResult) = $this->parseRowsFromBufferedResults($bufferedResults);

                    foreach ($yieldableRows as $row) {
                        yield $this->mapper->decodeValues($this->columns, $row);
                    }

                    // Now that we've yielded all available rows, flush the buffer.
                    $bufferedResults = [];
                    $shouldRetry = isset($result['resumeToken'])
                        ? true
                        : false;

                    // If the last item in the buffer had a chunked value let's
                    // hold on to it so we can stitch it together into a yieldable
                    // result.
                    if ($chunkedResult) {
                        $bufferedResults[] = $chunkedResult;
                    }
                }

                $generator->next();
            } catch (\Exception $ex) {
                if ($shouldRetry && $ex->getCode() === Grpc\STATUS_UNAVAILABLE) {
                    $backoff = new ExponentialBackoff($this->retries, function (\Exception $ex) {
                        return $ex->getCode() === Grpc\STATUS_UNAVAILABLE
                            ? true
                            : false;
                    });

                    // Attempt to resume using our last stored resume token. If we
                    // successfully resume, flush the buffer.
                    $generator = $backoff->execute($call, [$this->resumeToken]);
                    $bufferedResults = [];
                }

                throw $ex;
            }
        }

        // If there are any results remaining in the buffer, yield them.
        if ($bufferedResults) {
            list($yieldableRows, $chunkedResult) = $this->parseRowsFromBufferedResults($bufferedResults);

            foreach ($yieldableRows as $row) {
                yield $this->mapper->decodeValues($this->columns, $row);
            }
        }
    }

    /**
     * Return result metadata.
     *
     * Will be populated once the result set is iterated upon.
     *
     * Example:
     * ```
     * $metadata = $result->metadata();
     * ```
     *
     * @codingStandardsIgnoreStart
     * @return array|null [ResultSetMetadata](https://cloud.google.com/spanner/docs/reference/rpc/google.spanner.v1#google.spanner.v1.ResultSetMetadata).
     * @codingStandardsIgnoreEnd
     */
    public function metadata()
    {
        return $this->metadata;
    }

    /**
     * Get the query plan and execution statistics for the query that produced
     * this result set.
     *
     * Stats are not returned by default and will not be accessible until the
     * entire set of results has been iterated through.
     *
     * Example:
     * ```
     * $stats = $result->stats();
     * ```
     *
     * ```
     * // Executing a query with stats returned.
     * $res = $database->execute('SELECT * FROM Posts', [
     *     'queryMode' => 'PROFILE'
     * ]);
     * ```
     *
     * @codingStandardsIgnoreStart
     * @return array|null [ResultSetStats](https://cloud.google.com/spanner/docs/reference/rpc/google.spanner.v1#google.spanner.v1.ResultSetStats).
     * @codingStandardsIgnoreEnd
     */
    public function stats()
    {
        return $this->stats;
    }

    /**
     * Returns a snapshot which was begun in the read or execute, if one exists.
     *
     * Will be populated once the result set is iterated upon.
     *
     * Example:
     * ```
     * $snapshot = $result->snapshot();
     * ```
     *
     * @return Snapshot|null
     */
    public function snapshot()
    {
        return $this->snapshot;
    }

    /**
     * Returns a transaction which was begun in the read or execute, if one exists.
     *
     * Will be populated once the result set is iterated upon.
     *
     * Example:
     * ```
     * $transaction = $result->transaction();
     * ```
     *
     * @return Transaction|null
     */
    public function transaction()
    {
        return $this->transaction;
    }

    /**
     * @access private
     * @return \Generator
     */
    public function getIterator()
    {
        return $this->rows();
    }

    /**
     * @param array $bufferedResults
     * @return array
     */
    private function parseRowsFromBufferedResults(array $bufferedResults)
    {
        $values = [];
        $chunkedResult = null;
        $shouldMergeValues = isset($bufferedResults[0]['chunkedValue']);

        foreach ($bufferedResults as $key => $result) {
            if ($key === 0) {
                $values = $bufferedResults[0]['values'];
                continue;
            }

            $values = $shouldMergeValues
                ? $this->mergeValues($values, $result['values'])
                : array_merge($values, $result['values']);
            $shouldMergeValues = (isset($result['chunkedValue']))
                ? true
                : false;
        }

        $yieldableRows = array_chunk($values, $this->columnCount);

        if (isset($result['chunkedValue'])) {
            $chunkedResult = [
                'values' => array_pop($yieldableRows),
                'chunkedValue' => true
            ];
        }

        return [
            $yieldableRows,
            $chunkedResult
        ];
    }

    /**
     * @param array $result
     */
    private function setResultData(array $result)
    {
        $this->stats = isset($result['stats'])
            ? $result['stats']
            : null;

        if (isset($result['resumeToken'])) {
            $this->resumeToken = $result['resumeToken'];
        }

        if (isset($result['metadata'])) {
            $this->metadata = $result['metadata'];
            $this->columns = $result['metadata']['rowType']['fields'];
            $this->columnCount = count($this->columns);
        }

        if (isset($result['metadata']['transaction']['id'])) {
            if ($this->transactionContext === SessionPoolInterface::CONTEXT_READ) {
                $this->snapshot = $this->operation->createSnapshot(
                    $this->session,
                    $result['metadata']['transaction']
                );
            } else {
                $this->transaction = $this->operation->createTransaction(
                    $this->session,
                    $result['metadata']['transaction']
                );
            }
        }
    }

    /**
     * Merge result set values together.
     *
     * @param array $set1
     * @param array $set2
     * @return array
     */
    private function mergeValues(array $set1, array $set2)
    {
        $lastItemSet1 = array_pop($set1);
        $firstItemSet2 = array_shift($set2);
        $item = $firstItemSet2;

        if (is_string($lastItemSet1) && is_string($firstItemSet2)) {
            $item = $lastItemSet1 . $firstItemSet2;
        } elseif (is_array($lastItemSet1)) {
            $item = $this->mergeValues($lastItemSet1, $firstItemSet2);
        } else {
            array_push($set1, $lastItemSet1);
        }

        array_push($set1, $item);
        return array_merge($set1, $set2);
    }
}

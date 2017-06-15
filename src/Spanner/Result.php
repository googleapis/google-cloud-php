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

    const RETURN_NAME_VALUE_PAIR = 'nameValuePair';
    const RETURN_ASSOCIATIVE = 'associative';
    const RETURN_ZERO_INDEXED = 'zeroIndexed';

    /**
     * @var array
     */
    private $columns = [];

    /**
     * @var int
     */
    private $columnCount = 0;

    /**
     * @var array|null
     */
    private $columnNames;

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
     * @param string $format Determines the format in which rows are returned.
     *        `Result::RETURN_NAME_VALUE_PAIR` returns items as a
     *        multi-dimensional array containing a name and a value key.
     *        Ex: `[0 => ['name' => 'column1', 'value' => 'my_value']]`.
     *        `Result::RETURN_ASSOCIATIVE` returns items as an associative array
     *        with the column name as the key. Please note with this option, if
     *        duplicate column names are present a `\RuntimeException` will be
     *        thrown. `Result::RETURN_ZERO_INDEXED` returns items as a 0 indexed
     *        array, with the key representing the column number as found by
     *        executing {@see Google\Cloud\Spanner\Result::columns()}. Ex:
     *        `[0 => 'my_value']`. **Defaults to** `Result::RETURN_ASSOCIATIVE`.
     * @return \Generator
     * @throws \InvalidArgumentException When an invalid format is provided.
     * @throws \RuntimeException When duplicate column names exist with a
     *         selected format of `Result::RETURN_ASSOCIATIVE`.
     */
    public function rows($format = self::RETURN_ASSOCIATIVE)
    {
        $bufferedResults = [];
        $call = $this->call;
        $generator = $call();
        $shouldRetry = false;

        while ($generator->valid()) {
            try {
                $result = $generator->current();
                $bufferedResults[] = $result;
                $this->setResultData($result, $format);

                if (!isset($result['values'])) {
                    return;
                }

                $hasResumeToken = $this->isSetAndTrue($result, 'resumeToken');
                if ($hasResumeToken || count($bufferedResults) >= self::BUFFER_RESULT_LIMIT) {
                    list($yieldableRows, $chunkedResult) = $this->parseRowsFromBufferedResults($bufferedResults);

                    foreach ($yieldableRows as $row) {
                        yield $this->mapper->decodeValues($this->columns, $row, $format);
                    }

                    // Now that we've yielded all available rows, flush the buffer.
                    $bufferedResults = [];
                    $shouldRetry = $hasResumeToken;

                    // If the last item in the buffer had a chunked value let's
                    // hold on to it so we can stitch it together into a yieldable
                    // result.
                    if ($chunkedResult) {
                        $bufferedResults[] = $chunkedResult;
                    }
                }

                $generator->next();
            } catch (ServiceException $ex) {
                if ($shouldRetry && $ex->getCode() === Grpc\STATUS_UNAVAILABLE) {
                    $backoff = new ExponentialBackoff($this->retries, function (ServiceException $ex) {
                        return $ex->getCode() === Grpc\STATUS_UNAVAILABLE
                            ? true
                            : false;
                    });

                    // Attempt to resume using our last stored resume token. If we
                    // successfully resume, flush the buffer.
                    $generator = $backoff->execute($call, [$this->resumeToken]);
                    $bufferedResults = [];

                    continue;
                }

                throw $ex;
            }
        }

        // If there are any results remaining in the buffer, yield them.
        if ($bufferedResults) {
            list($yieldableRows, $chunkedResult) = $this->parseRowsFromBufferedResults($bufferedResults);

            foreach ($yieldableRows as $row) {
                yield $this->mapper->decodeValues($this->columns, $row, $format);
            }
        }
    }

    /**
     * Return column names.
     *
     * Will be populated once the result set is iterated upon.
     *
     * Example:
     * ```
     * $columns = $result->columns();
     * ```
     *
     * @return array|null
     */
    public function columns()
    {
        return $this->columnNames;
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
     * Return the session associated with the result stream.
     *
     * Example:
     * ```
     * $session = $result->session();
     * ```
     *
     * @return Session
     */
    public function session()
    {
        return $this->session;
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
        $shouldMergeValues = $this->isSetAndTrue($bufferedResults[0], 'chunkedValue');

        foreach ($bufferedResults as $key => $result) {
            if ($key === 0) {
                $values = $bufferedResults[0]['values'];
                continue;
            }

            $values = $shouldMergeValues
                ? $this->mergeValues($values, $result['values'])
                : array_merge($values, $result['values']);
            $shouldMergeValues = $this->isSetAndTrue($result, 'chunkedValue')
                ? true
                : false;
        }

        $yieldableRows = array_chunk($values, $this->columnCount);

        if ($this->isSetAndTrue($result, 'chunkedValue')) {
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
     * @param string $format
     * @throws \RuntimeException
     */
    private function setResultData(array $result, $format)
    {
        $this->stats = isset($result['stats'])
            ? $result['stats']
            : null;

        if ($this->isSetAndTrue($result, 'resumeToken')) {
            $this->resumeToken = $result['resumeToken'];
        }

        if (isset($result['metadata'])) {
            $this->columnNames = [];
            $this->columns = [];
            $this->columnCount = 0;
            $this->metadata = $result['metadata'];
            $this->columns = $result['metadata']['rowType']['fields'];

            foreach ($this->columns as $key => $column) {
                $this->columnNames[] = $this->isSetAndTrue($column, 'name')
                    ? $column['name']
                    : $key;
                $this->columnCount++;
            }

            if ($format === self::RETURN_ASSOCIATIVE
                && $this->columnCount !== count(array_unique($this->columnNames))
            ) {
                throw new \RuntimeException(
                    'Duplicate column names are not supported when returning' .
                    ' rows in the associative format. Please consider aliasing' .
                    ' your column names.'
                );
            }
        }

        if (isset($result['metadata']['transaction']['id']) && $result['metadata']['transaction']['id']) {
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

    /**
     * @param array $arr
     * @param string $key
     * @return bool
     */
    private function isSetAndTrue($arr, $key)
    {
        return isset($arr[$key]) && $arr[$key];
    }
}

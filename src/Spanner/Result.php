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

use Google\Cloud\Core\Exception\ServiceException;
use Google\Cloud\Spanner\Session\Session;
use Google\Cloud\Spanner\Session\SessionPoolInterface;

/**
 * Represent a Google Cloud Spanner lookup result (either read or executeSql).
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
    /**
     * @var array|null
     */
    private $cachedValues;

    /**
     * @var array
     */
    private $columns = [];

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
     */
    public function __construct(
        Operation $operation,
        Session $session,
        callable $call,
        $transactionContext,
        ValueMapper $mapper
    ) {
        $this->operation = $operation;
        $this->session = $session;
        $this->call = $call;
        $this->transactionContext = $transactionContext;
        $this->mapper = $mapper;
    }

    /**
     * Return the formatted and decoded rows.
     *
     * If the stream is interrupted an attempt will be made to resume.
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
        $call = $this->call;

        try {
            foreach ($this->getRows($call()) as $row) {
                yield $row;
            }
        } catch (ServiceException $ex) {
            if (!$this->resumeToken) {
                throw $ex;
            }

            // If we have a token, attempt to resume
            foreach ($this->getRows($call($this->resumeToken)) as $row) {
                yield $row;
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
     */
    public function getIterator()
    {
        return $this->rows();
    }

    /**
     * Yields rows from a partial result set.
     *
     * @return \Generator
     */
    private function getRowsFromPartial(array $partial)
    {
        $this->stats = isset($partial['stats']) ? $partial['stats'] : null;
        $this->resumeToken = isset($partial['resumeToken']) ? $partial['resumeToken'] : null;

        if (isset($partial['metadata'])) {
            $this->metadata = $partial['metadata'];
            $this->columns = $partial['metadata']['rowType']['fields'];
        }

        if (isset($partial['metadata']['transaction']['id'])) {
            if ($this->transactionContext === SessionPoolInterface::CONTEXT_READ) {
                $this->snapshot = $this->operation->createSnapshot(
                    $this->session,
                    $partial['metadata']['transaction']
                );
            } else {
                $this->transaction = $this->operation->createTransaction(
                    $this->session,
                    $partial['metadata']['transaction']
                );
            }
        }

        if ($this->cachedValues) {
            $partial['values'] = $this->mergeValues($this->cachedValues, $partial['values']);
            $this->cachedValues = null;
        }

        if (isset($partial['chunkedValue'])) {
            $this->cachedValues = $partial['values'];
            return;
        }

        $rows = [];
        $columnCount = count($this->columns);

        if ($columnCount > 0 && isset($partial['values'])) {
            $rows = array_chunk($partial['values'], $columnCount);
        }

        foreach ($rows as $row) {
            yield $this->mapper->decodeValues($this->columns, $row);
        }
    }

    /**
     * Merge result set values together.
     *
     * @param array $cached
     * @param array $new
     * @return mixed
     */
    private function mergeValues(array $cached, array $new)
    {
        $lastCachedItem = array_pop($cached);
        $firstNewItem = array_shift($new);
        $item = $firstNewItem;

        if (is_string($lastCachedItem) && is_string($firstNewItem)) {
            $item = $lastCachedItem . $firstNewItem;
        } elseif (is_array($lastCachedItem)) {
            $item = $this->mergeValues($lastCachedItem, $firstNewItem);
        } else {
            array_push($cached, $lastCachedItem);
        }

        array_push($cached, $item);
        return array_merge($cached, $new);
    }

    /**
     * @param \Generator $results
     * @return \Generator
     */
    private function getRows(\Generator $results)
    {
        foreach ($results as $partial) {
            foreach ($this->getRowsFromPartial($partial) as $row) {
                yield $row;
            }
        }
    }
}

<?php
/**
 * Copyright 2017 Google Inc.
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

use Grpc;
use Google\Cloud\Core\ExponentialBackoff;
use Google\Cloud\Core\Exception\ServiceException;
use Google\Cloud\Firestore\Connection\ConnectionInterface;

/**
 * Represents the result set of a Cloud Firestore Query.
 *
 * Example:
 * ```
 * use Google\Cloud\Firestore\FirestoreClient;
 *
 * $firestore = new FirestoreClient();
 * $collection = $firestore->collection('users');
 * $query = $collection->where('age', '>', 18);
 *
 * $snapshot = $query->documents();
 * ```
 *
 * ```
 * // Snapshots can be iterated with foreach:
 * foreach ($snapshot as $user) {
 *     echo $user['name'] . PHP_EOL;
 * }
 * ```
 */
class QuerySnapshot implements \IteratorAggregate
{
    use SnapshotTrait;

    /**
     * @var ConnectionInterface
     */
    private $connection;

    /**
     * @var ValueMapper
     */
    private $valueMapper;

    /**
     * @var Query
     */
    private $query;

    /**
     * @var callable
     */
    private $call;

    /**
     * @var int
     */
    private $retries;

    /**
     * @var bool|null
     */
    private $empty;

    /**
     * @var int|null
     */
    private $size;

    /**
     * @param ConnectionInterface $connection A connection to Cloud Firestore
     * @param ValueMapper $valueMapper A Firestore Value Mapper
     * @param Query $query The Query which generated this snapshot.
     * @param callable $call A callable function which executes the Firestore query.
     * @param int $retries The number of retries allowed on failure.
     */
    public function __construct(
        ConnectionInterface $connection,
        ValueMapper $valueMapper,
        Query $query,
        callable $call,
        $retries = FirestoreClient::MAX_RETRIES
    ) {
        $this->connection = $connection;
        $this->valueMapper = $valueMapper;
        $this->query = $query;
        $this->call = $call;
        $this->retries = $retries;
    }

    /**
     * Check if the result is empty.
     *
     * Please note that this value will be null until the result is first
     * iterated.
     *
     * Example:
     * ```
     * $empty = $snapshot->isEmpty();
     * ```
     *
     * @return bool|null
     */
    public function isEmpty()
    {
        return $this->empty;
    }

    /**
     * Returns the size of the result set.
     *
     * Please note that this value will be null until the entire result set
     * has been iterated. If the query results are ended before the set has been
     * fully enumerated, this value will never be set.
     *
     * Example:
     * ```
     * $size = $snapshot->size();
     * ```
     *
     * @return int|null
     */
    public function size()
    {
        return $this->size;
    }

    /**
     * Return the formatted and decoded rows. If the stream is interrupted,
     * attempts will be made on your behalf to resume.
     *
     * Example:
     * ```
     * $rows = $snapshot->rows();
     * ```
     *
     * @codingStandardsIgnoreStart
     * @see https://cloud.google.com/firestore/docs/reference/rpc/google.firestore.v1beta1#google.firestore.v1beta1.Firestore.RunQuery RunQuery
     * @codingStandardsIgnoreEnd
     *
     * @return \Generator<DocumentSnapshot>
     */
    public function rows()
    {
        $generator = $this->executeQuery();

        // cache collection references
        $collections = [];

        $this->empty = true;
        $size = 0;

        try {
            while ($generator->valid()) {
                $result = $generator->current();

                if (isset($result['document']) && $result['document']) {
                    $this->empty = false;
                    $size++;

                    $collectionName = $this->parentPath($result['document']['name']);
                    if (!isset($collections[$collectionName])) {
                        $collections[$collectionName] = new CollectionReference(
                            $this->connection,
                            $this->valueMapper,
                            $collectionName
                        );
                    }

                    $ref = new DocumentReference(
                        $this->connection,
                        $this->valueMapper,
                        $collections[$collectionName],
                        $result['document']['name']
                    );

                    $document = $result['document'];
                    $document['readTime'] = $result['readTime'];

                    yield $this->createSnapshotWithData($this->valueMapper, $ref, $document);
                }

                $generator->next();
            }
        } finally {
            $this->size = $size;
        }
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
     * Execute the query and return a Generator filled with streaming query results.
     *
     * Firestore does not support resuming broken queries. The retry logic
     * contained in this method is intended to allow retries of queries that
     * break on the initial call, but prevent retries if the stream is
     * interrupted due to error.
     *
     * @return \Generator
     */
    private function executeQuery()
    {
        $shouldRetry = true;
        $backoff = new ExponentialBackoff($this->retries, function () use (&$shouldRetry) {
            // @codeCoverageIgnoreStart
            return $shouldRetry;
            // @codeCoverageIgnoreEnd
        });

        return $backoff->execute(function () use (&$shouldRetry) {
            $call = $this->call;
            $res = $call();
            $shouldRetry = false;
            return $res;
        });
    }
}

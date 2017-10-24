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
 * $query = $collection->query();
 *
 * $snapshot = $query->snapshot();
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
     * Return the formatted and decoded rows. If the stream is interrupted,
     * attempts will be made on your behalf to resume.
     *
     * Example:
     * ```
     * $rows = $snapshot->rows();
     * ```
     *
     * @return \Generator<DocumentSnapshot>
     */
    public function rows()
    {
        $call = $this->call;
        $backoff = new ExponentialBackoff($this->maxRetries);
        $generator = $call();

        // cache collection references
        $collections = [];

        while ($generator->valid()) {
            $result = $generator->current();

            if (isset($result['transaction']) && $result['transaction']) {
                $this->transaction = $result['transaction'];
            } elseif (isset($result['document']) && $result['document']) {
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

                yield $this->createSnapshot($ref, [
                    'data' => $document
                ]);
            }

            $generator->next();
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
}

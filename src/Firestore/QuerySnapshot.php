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
 */
class QuerySnapshot implements \IteratorAggregate
{
    use SnapshotTrait;

    const MAX_RETRIES = 3;

    private $connection;
    private $valueMapper;
    private $query;
    private $call;
    private $retries;

    public function __construct(
        ConnectionInterface $connection,
        ValueMapper $valueMapper,
        Query $query,
        callable $call,
        $retries = self::MAX_RETRIES
    ) {
        $this->connection = $connection;
        $this->valueMapper = $valueMapper;
        $this->query = $query;
        $this->call = $call;
        $this->retries = $retries;
    }

    /**
     * The size of the Query result set.
     *
     * NOTE: If the Query has not been enumerated, this method will trigger
     * execution of the query. Additionally, if the query execution was
     * interrupted before completion, this method may not return an accurate
     * value.
     *
     * @return int
     */
    public function size()
    {
        if (is_null($this->size)) {
            $this->rows();
        }

        return $this->size;
    }

    /**
     * Return the formatted and decoded rows. If the stream is interrupted,
     * attempts will be made on your behalf to resume.
     *
     * Example:
     * ```
     * $rows = $result->rows();
     * ```
     *
     * @return \Generator<DocumentSnapshot>
     */
    public function rows()
    {
        $call = $this->call;
        $generator = $call();

        // cache collection references
        $collections = [];

        while ($generator->valid()) {
            try {
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
            } catch (ServiceException $ex) {
                if ($shouldRetry && $ex->getCode() === Grpc\STATUS_UNAVAILABLE) {
                    $backoff = new ExponentialBackoff($this->retries, function (ServiceException $ex) {
                        return $ex->getCode() === Grpc\STATUS_UNAVAILABLE
                            ? true
                            : false;
                    });

                    // Attempt to resume using our last stored resume token. If we
                    // successfully resume, flush the buffer.
                    $generator = $backoff->execute($call);

                    continue;
                }

                throw $ex;
            }
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

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

use Google\Cloud\Firestore\Connection\ConnectionInterface;

/**
 * Query Results
 *
 * @todo make iterable -- page results?
 */
class QuerySnapshot implements \IteratorAggregate
{
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
     * @var array
     */
    private $res;

    /**
     * @param ConnectionInterface $connection A Connection to Cloud Firestore.
     * @param ValueMapper $valueMapper A Firestore Value Mapper.
     * @param Query $query The Query which originated the call.
     * @param callable $call
     */
    public function __construct(ConnectionInterface $connection, ValueMapper $valueMapper, Query $query)
    {
        $this->connection = $connection;
        $this->valueMapper = $valueMapper;
        $this->query = $query;
    }

    /**
     * @return Query
     */
    public function query()
    {
        return $this->query;
    }

    /**
     * @access private
     * @return \Generator
     */
    public function getIterator()
    {
        return $this->documents();
    }
}

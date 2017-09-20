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
     * @var Query
     */
    private $query;

    /**
     * @var ValueMapper
     */
    private $valueMapper;

    /**
     * @var callable
     */
    private $call;

    /**
     * @var array
     */
    private $res;

    public function __construct(ConnectionInterface $connection, Query $query, ValueMapper $valueMapper, callable $call)
    {
        $this->connection = $connection;
        $this->query = $query;
        $this->valueMapper = $valueMapper;
        $this->call = $call;
    }

    public function query()
    {
        return $this->query;
    }

    public function documents()
    {
        $this->res = $this->res ?: call_user_func_array($this->call, $this->query);

        foreach ($this->res as $document) {
            $ref = $this->documentFactory($document['document']['name']);
            yield $ref->snapshot([
                'data' => $document['document']
            ]);
        }
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

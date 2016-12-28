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

/**
 * @todo should this be more like BigQuery\QueryResults?
 */
class Result implements \IteratorAggregate
{
    /**
     * @var array
     */
    private $result;

    /**
     * @var array
     */
    private $rows;

    /**
     * @param array $result The query or read result.
     * @param array $rows The rows, formatted and decoded.
     */
    public function __construct(array $result, array $rows)
    {
        $this->result = $result;
        $this->rows = $rows;
    }

    /**
     * Return result metadata
     *
     * @return array [ResultSetMetadata](https://cloud.google.com/spanner/reference/rest/v1/ResultSetMetadata).
     */
    public function metadata()
    {
        return $this->result['metadata'];
    }

    /**
     * Return the formatted and decoded rows.
     *
     * @return array|null
     */
    public function rows()
    {
        return $this->rows;
    }

    /**
     * Get the query plan and execution statistics for the query that produced
     * this result set.
     *
     * Stats are not returned by default.
     *
     * @todo explain how to get dem stats.
     *
     * @return array|null [ResultSetStats](https://cloud.google.com/spanner/reference/rest/v1/ResultSetStats).
     */
    public function stats()
    {
        return (isset($this->result['stats']))
            ? $result['stats']
            : null;
    }

    /**
     * Get the entire query or read response as given by the API.
     *
     * @return array [ResultSet](https://cloud.google.com/spanner/reference/rest/v1/ResultSet).
     */
    public function info()
    {
        return $this->result;
    }

    /**
     * @access private
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->rows);
    }
}

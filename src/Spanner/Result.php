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
class Result implements \Iterator
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
     * @var int
     */
    private $index = 0;

    /**
     * @var array $result The query or read result.
     */
    public function __construct(array $result)
    {
        $this->result = $result;
        $this->rows = $this->transformQueryResult($result);
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
     * Return the rows as represented by the API.
     *
     * For a more easily consumed result in which each row is represented as a
     * set of key/value pairs, see {@see Google\Cloud\Spanner\Result::result()}.
     *
     * @return array|null
     */
    public function rows()
    {
        return (isset($this->result['rows']))
            ? $result['rows']
            : null;
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
     * Transform the response from executeSql or read into a list of rows
     * represented as a collection of key/value arrays.
     *
     * @param array $result
     * @return array
     */
    private function transformQueryResult(array $result)
    {
        if (!isset($result['rows']) || count($result['rows']) === 0) {
            return null;
        }

        $cols = [];
        foreach (array_keys($result['rows'][0]) as $colIndex) {
            $cols[] = $result['metadata']['rowType']['fields'][$colIndex]['name'];
        }

        $rows = [];
        foreach ($result['rows'] as $row) {
            $rows[] = array_combine($cols, $row);
        }

        return $rows;
    }

    /**
     * @access private
     */
    public function rewind()
    {
        $this->index = 0;
    }

    /**
     * @access private
     */
    public function current()
    {
        return $this->rows[$this->index];
    }

    /**
     * @access private
     */
    public function key()
    {
        return $this->index;
    }

    /**
     * @access private
     */
    public function next()
    {
        ++$this->index;
    }

    /**
     * @access private
     */
    public function valid()
    {
        return isset($this->rows[$this->index]);
    }
}

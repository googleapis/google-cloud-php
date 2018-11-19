<?php
/**
 * Copyright 2018 Google LLC
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
 * Represents the result of a Batch DML operation.
 *
 * Example:
 * ```
 * use Google\Cloud\Spanner\SpannerClient;
 *
 * $spanner = new SpannerClient();
 * $database = $spanner->connect('my-instance', 'my-database');
 *
 * $batchDmlResult = $database->runTransaction(function ($t) {
 *     $result = $t->executeUpdateBatch([
 *         [
 *             'sql' => 'UPDATE posts SET author = @author WHERE id = @id',
 *             'params' => [
 *                 'author' => 'John',
 *                 'id' => 1
 *             ]
 *         ]
 *     ]);
 *
 *     $t->commit();
 *
 *     return $result;
 * });
 * ```
 */
class BatchDmlResult
{
    /**
     * @var array
     */
    private $data;

    /**
     * @var array|null
     */
    private $errorStatement;

    /**
     * @var array|null
     */
    private $rowCounts;

    /**
     * @param array $data The executeBatchDml response data.
     * @param array|null $errorStatement The statement (with params and types)
     *        which triggered an error.
     */
    public function __construct(array $data, array $errorStatement = null)
    {
        $this->data = $data;
        $this->errorStatement = $errorStatement;
    }

    /**
     * Get a list of integers indicating the number of modified rows for each
     * successful statement.
     *
     * Example:
     * ```
     * $counts = $batchDmlResult->rowCounts();
     * ```
     *
     * @return int[]
     */
    public function rowCounts()
    {
        if (!$this->rowCounts) {
            foreach ($this->data['resultSets'] as $resultSet) {
                $this->rowCounts[] = $resultSet['stats']['rowCountExact'];
            }
        }

        return $this->rowCounts;
    }

    /**
     * Get a Batch DML error, if one exists.
     *
     * If no error occurred, this method returns `null`.
     *
     * Example:
     * ```
     * $error = $batchDmlResult->error();
     * ```
     *
     * @return array|null
     */
    public function error()
    {
        return isset($this->data['status'])
            ? $this->data['status']
            : null;
    }

    /**
     * Get the statement which triggered an error, if an error occurred.
     *
     * If no error occurred, this method returns `null`.
     *
     * Example:
     * ```
     * $errorStatement = $batchDmlResult->errorStatement();
     * ```
     *
     * @return array|null
     */
    public function errorStatement()
    {
        return $this->errorStatement;
    }
}

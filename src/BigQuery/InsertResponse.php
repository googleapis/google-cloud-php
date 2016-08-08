<?php
/**
 * Copyright 2016 Google Inc. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Google\Cloud\BigQuery;

/**
 * Represents the result of streaming data into a table.
 *
 * This class should be not instantiated directly, but as a result of calling
 * {@see Google\Cloud\BigQuery\Table::insertRow} or
 * {@see Google\Cloud\BigQuery\Table::insertRows}.
 */
class InsertResponse
{
    /**
     * @var array The API response.
     */
    private $info;

    /**
     * @var array The rows provided in the original request.
     */
    private $rows;

    /**
     * @param array $info The API response.
     * @param array $rows The rows provided in the original request.
     */
    public function __construct(array $info, array $rows)
    {
        $this->info = $info;
        $this->rows = $rows;
    }

    /**
     * Determines if the request was successful.
     *
     * Example:
     * ```
     * if (!$insertResponse->isSuccessful()) {
     *    print_r($insertResponse->failedRows());
     * }
     * ```
     *
     * @return bool
     */
    public function isSuccessful()
    {
        return !isset($this->info['insertErrors']);
    }

    /**
     * Returns the rows which failed to insert along with their associated
     * errors and index in the original data set.
     *
     * Example:
     * ```
     * $rows = $insertResponse->failedRows();
     *
     * foreach ($rows as $row) {
     *     print_r($row['rowData']);
     *
     *     foreach ($row['errors'] as $error) {
     *         echo $error['reason'] . ': ' . $error['message'];
     *     }
     * }
     * ```
     *
     * @see https://cloud.google.com/bigquery/docs/reference/v2/tabledata/insertAll#response
     * Tabledata insertAll API response documentation.
     *
     * @return array
     */
    public function failedRows()
    {
        $rows = [];

        if ($this->isSuccessful()) {
            return $rows;
        }

        foreach ($this->info['insertErrors'] as $error) {
            $rows[] = $error + [
                'rowData' => $this->rows[$error['index']]['json']
            ];
        }

        return $rows;
    }

    /**
     * Retrieves the full API response.
     *
     * Example:
     * ```
     * $info = $insertResponse->info();
     * echo $info['insertErrors'];
     * ```
     *
     * @see https://cloud.google.com/bigquery/docs/reference/v2/tabledata/insertAll#response
     * Tabledata insertAll API response documentation.
     *
     * @return array
     */
    public function info()
    {
        return $this->info;
    }
}

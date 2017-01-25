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
 * Classes implementing this interface provide a means of reading data
 * from a Cloud Spanner database.
 */
interface ReaderInterface
{
    /**
     * Execute a SQL query.
     *
     * @param string $sql The SQL Query string.
     * @param array $options [optional] Configuration options.
     * @return Result
     */
    public function execute($sql, array $options = []);

    /**
     * Read data from a Cloud Spanner database.
     *
     * @param string $table The table name.
     * @param KeySet $keySet The KeySet to select rows.
     * @param array $columns A list of column names to return.
     * @param array $options [optional] Configuration Options.
     * @return Result
     */
    public function read($table, KeySet $keySet, array $columns, array $options = []);
}

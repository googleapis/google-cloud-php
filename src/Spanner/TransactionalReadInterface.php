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
 * Defines an interface for any Transaction which supports read operations,
 * and includes support for common data related to single-use transactions.
 */
interface TransactionalReadInterface
{
    const STATE_ACTIVE = 0;
    const STATE_ROLLED_BACK = 1;
    const STATE_COMMITTED = 2;
    const STATE_SINGLE_USE_USED = 3;

    const TYPE_SINGLE_USE = 0;
    const TYPE_PRE_ALLOCATED = 1;

    /**
     * Run a query.
     *
     * @param string $sql The query string to execute.
     * @param array $options [optional] Configuration options.
     * @return Result
     */
    public function execute($sql, array $options = []);

    /**
     * Lookup rows in a table.
     *
     * @param string $table The table name.
     * @param KeySet $keySet The KeySet to select rows.
     * @param array $columns A list of column names to return.
     * @param array $options [optional] Configuration Options.
     * @return Result
     */
    public function read($table, KeySet $keySet, array $columns, array $options = []);

    /**
     * Retrieve the Transaction ID.
     *
     * @return string|null
     */
    public function id();

    /**
     * Get the Transaction Type.
     *
     * @return int
     */
    public function type();
}

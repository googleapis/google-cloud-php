<?php
/*
 * Copyright 2018, Google LLC All rights reserved.
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

namespace Google\Cloud\Bigtable;

use Google\Cloud\Bigtable\ConnectionInterface;

/**
 * Connection to Bigtable TableAdmin API
 */
interface TableAdminConnectionInterface extends ConnectionInterface
{

    /**
     * Creates a new table in the specified instance.
     *
     * @param string $tableId      The name by which the new table should be referred to within the parent
     *                             instance, e.g., `foobar` rather than `<parent>/tables/foobar`.
     *
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type Split[] $initialSplits
     *          The optional list of row keys that will be used to initially split the
     *          table into several tablets (tablets are similar to HBase regions).
     *          Given two split keys, `s1` and `s2`, three tablets will be created,
     *          spanning the key ranges: `[, s1), [s1, s2), [s2, )`.
     *
     *          Example:
     *
     *          * Row keys := `["a", "apple", "custom", "customer_1", "customer_2",`
     *                         `"other", "zz"]`
     *          * initial_split_keys := `["apple", "customer_1", "customer_2", "other"]`
     *          * Key assignment:
     *              - Tablet 1 `[, apple)                => {"a"}.`
     *              - Tablet 2 `[apple, customer_1)      => {"apple", "custom"}.`
     *              - Tablet 3 `[customer_1, customer_2) => {"customer_1"}.`
     *              - Tablet 4 `[customer_2, other)      => {"customer_2"}.`
     *              - Tablet 5 `[other, )                => {"other", "zz"}.`
     *     @type \Google\GAX\RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\GAX\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\GAX\RetrySettings} for example usage.
     * }
     * @return TBD
     *
     */
    public function createTable($tableId, array $optionalArgs = []);

    /**
     * Creates a new table in the specified instance with column family.
     * The table can be created with a full set of initial column families,
     * specified in the request.
     *
     * @param string $tableId      The name by which the new table should be referred to within the parent
     *                             instance, e.g., `foobar` rather than `<parent>/tables/foobar`.
     * @param string $columnFamily e.g., `cf`
     *
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type Split[] $initialSplits
     *          The optional list of row keys that will be used to initially split the
     *          table into several tablets (tablets are similar to HBase regions).
     *          Given two split keys, `s1` and `s2`, three tablets will be created,
     *          spanning the key ranges: `[, s1), [s1, s2), [s2, )`.
     *
     *          Example:
     *
     *          * Row keys := `["a", "apple", "custom", "customer_1", "customer_2",`
     *                         `"other", "zz"]`
     *          * initial_split_keys := `["apple", "customer_1", "customer_2", "other"]`
     *          * Key assignment:
     *              - Tablet 1 `[, apple)                => {"a"}.`
     *              - Tablet 2 `[apple, customer_1)      => {"apple", "custom"}.`
     *              - Tablet 3 `[customer_1, customer_2) => {"customer_1"}.`
     *              - Tablet 4 `[customer_2, other)      => {"customer_2"}.`
     *              - Tablet 5 `[other, )                => {"other", "zz"}.`
     *     @type \Google\GAX\RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\GAX\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\GAX\RetrySettings} for example usage.
     * }
     * @return TBD
     *
     */
    public function createTableWithColumnFamily($tableId, $columnFamily, array $optionalArgs = []);

    /**
     * Permanently deletes a specified table and all of its data.
     *
     * @param string $tableId       The table should be deleted from the parent instance
     *
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type \Google\GAX\RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\GAX\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\GAX\RetrySettings} for example usage.
     * }
     *
     *
     * @return TBD
     *
     */
    public function deleteTable($tableId, array $optionalArgs = []);

    /**
     * Lists all tables served from a specified instance.
     *
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type int $view
     *          The view to be applied to the returned tables' fields.
     *          Defaults to `NAME_ONLY` if unspecified; no others are currently supported.
     *          For allowed values, use constants defined on {@see \Google\Bigtable\Admin\V2\Table_View}
     *     @type string $pageToken
     *          A page token is used to specify a page of values to be returned.
     *          If no page token is specified (the default), the first page
     *          of values will be returned. Any page token used here must have
     *          been generated by a previous call to the API.
     *     @type \Google\GAX\RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\GAX\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\GAX\RetrySettings} for example usage.
     * }
     *
     * @return TBD
     */
    public function listTables(array $optionalArgs = []);

    /**
     * Gets metadata information about the specified table.
     *
     * @param string $tableId
     *
     * @return TBD
     *
     */
    public function getTable($tableId);

    /**
     * Add column family to perticular table.
     *
     * @param string $tableId
     *
     * @param string $cfName        Column family name.
     *
     * @param array $optionalArgs  {
     *                              Optional.
     *
     *     @type \Google\GAX\RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\GAX\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\GAX\RetrySettings} for example usage.
     * }
     *
     * @return TBD
     *
     */
    public function addColumnFamilies($tableId, $cfName, array $optionalArgs = []);

    /**
     * Update column family to perticular table.
     *
     * @param string $tableId
     *
     * @param string $cfName        Column family name.
     *
     * @param array $optionalArgs  {
     *                              Optional.
     *
     *     @type \Google\GAX\RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\GAX\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\GAX\RetrySettings} for example usage.
     * }
     *
     * @return TBD
     *
     */
    public function updateColumnFamilies($tableId, $cfName, array $optionalArgs = []);

    /**
     * Delete column family from perticular table.
     *
     * @param string $tableId
     *
     * @param string $cfName        Column family name.
     *
     * @param array $optionalArgs  {
     *                              Optional.
     *
     *     @type \Google\GAX\RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\GAX\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\GAX\RetrySettings} for example usage.
     * }
     *
     * @return TBD
     *
     */
    public function deleteColumnFamilies($tableId, $cfName, array $optionalArgs = []);

    /**
     * Permanently drop/delete a row range from a specified table. The request can
     * specify whether to delete all rows in a table, or only those that match a
     * particular prefix.
     *
     * @param string $tableId       The unique name of the table on which to drop a range of rows.
     *
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type string $rowKeyPrefix
     *          Delete all rows that start with this row key prefix. Prefix cannot be
     *          zero length.
     *     @type bool $deleteAllDataFromTable
     *          Delete all rows in the table. Setting this to false is a no-op.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return TBD
     *
     */
    public function dropRowRange($tableId, array $optionalArgs = []);
}

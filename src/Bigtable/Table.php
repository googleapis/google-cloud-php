<?php
/*
 * Copyright 2017, Google LLC All rights reserved.
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

use Google\Cloud\Bigtable\ChunkFormatter;
use Google\Cloud\Bigtable\Admin\V2\BigtableTableAdminClient;
use Google\Cloud\Bigtable\Admin\V2\ColumnFamily;
use Google\Cloud\Bigtable\Admin\V2\GcRule;
use Google\Cloud\Bigtable\Admin\V2\ModifyColumnFamiliesRequest_Modification as Modification;
use Google\Cloud\Bigtable\V2\BigtableClient;
use Google\Cloud\Bigtable\V2\Mutation;
use Google\Cloud\Bigtable\V2\Mutation_SetCell;
use Google\Cloud\Bigtable\V2\MutateRowsRequest_Entry;
use Google\Cloud\Bigtable\V2\ReadModifyWriteRule;
use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\MapField;

/**
 * Service for creating, configuring, and deleting Cloud Bigtable tables.
 *
 * Provides access to the table schemas
 *
 * This class provides the ability to make client calls to the backing service through method
 * calls. Sample code to get started:
 *
 * Example:
 * ```
 * use Google\Cloud\Bigtable;
 *
 * $config = array('projectId' => '[PROJECT]', 'instanceId' => '[INSTANCE]')
 * $table = new Table($config);
 *
 * $tableId = 'foobar';
 * $response = $table->createTable($tableId);
 * ```
 *
 * Many parameters require resource names to be formatted in a particular way. To assist
 * with these names, this class includes a format method for each type of name, and additionally
 * a parseName method to extract the individual identifiers contained within formatted names
 * that are returned by the API.
 */
class Table
{
    /**
     * @var V2\BigtableClient
     */
    private $bigtableClient;

    /**
     * @var Admin\V2\BigtableTableAdminClient
     */
    private $bigtableTableAdminClient;

    /**
     * @var string
     */
    private $projectId;

    /**
     * @var string
     */
    private $instanceId;

    /**
     * @var string
     */
    private $tableId;

    /**
     * @var string formatted instance name
     */
    private $formattedInstance;

    /**
     * Create a Bigtable Client.
     *
     * @param array $config {
     *      Configuration Options.
     *
     *     @param string $projectId
     *
     *     @param string $instanceId
     */
    public function __construct(array $config)
    {
        $this->projectId = $config['projectId'];
        $this->instanceId = $config['instanceId'];
        $this->formattedInstance = BigtableTableAdminClient::instanceName($this->projectId, $this->instanceId);

        $this->bigtableClient = new BigtableClient();
        $this->bigtableTableAdminClient = new BigtableTableAdminClient();
    }

    /**
     * Formats a string containing the fully-qualified path to represent
     *
     * @param string $tableId
     *
     * @return string The formatted table resource.
     */
    private function tableName($tableId)
    {
        return BigtableTableAdminClient::tableName($this->projectId, $this->instanceId, $tableId);
    }

    /**
     * Creates a new table in the specified instance.
     *
     * Example:
     * ```
     * $tableId = 'foobar';
     * $response = $table->createTable($tableId);
     * ```
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
     * @return \Google\Bigtable\Admin\V2\Table
     *
     * @throws \Google\GAX\ApiException if the remote call fails
     */
    public function createTable($tableId, array $optionalArgs = [])
    {
        $parent = $this->formattedInstance;
        $table = new \Google\Cloud\Bigtable\Admin\V2\Table();
        return $this->bigtableTableAdminClient->createTable($parent, $tableId, $table, $optionalArgs);
    }

    /**
     * Creates a new table in the specified instance with column family.
     * The table can be created with a full set of initial column families,
     * specified in the request.
     *
     * Example:
     * ```
     * $tableId = 'foobar';
     * $columnFamily = 'cf';
     * $response = $table->createTableWithColumnFamily($tableId, $columnFamily);
     * ```
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
     * @return \Google\Bigtable\Admin\V2\Table
     *
     * @throws \Google\GAX\ApiException if the remote call fails.
     */
    public function createTableWithColumnFamily($tableId, $columnFamily, array $optionalArgs = [])
    {
        $table = new \Google\Cloud\Bigtable\Admin\V2\Table();
        $table->setGranularity(3);

        $mapField = $this->columnFamily(3, $columnFamily);
        $table->setColumnFamilies($mapField);

        $parent = $this->formattedInstance;
        return $this->bigtableTableAdminClient->createTable($parent, $tableId, $table, $optionalArgs);
    }

    /**
     * MapField of columnFamily.
     *
     * Example:
     * ```
     * $MaxNumVersions = 2;
     * $columnFamily = 'cf';
     * $MapField = $table->columnFamily($MaxNumVersions, $columnFamily);
     * ```
     *
     * @param integer $MaxNumVersions   Set max num of versions to GcRule.
     *
     * @param string $columnFamily e.g., `cf`
     *
     * @return \Google\Protobuf\Internal\MapField
     */
    public function columnFamily($MaxNumVersions, $columnFamily)
    {
        $gc = new GcRule();
        $gc->setMaxNumVersions($MaxNumVersions);

        $cf = new ColumnFamily();
        $cf->setGcRule($gc);

        $MapField = new MapField(GPBType::STRING, GPBType::MESSAGE, ColumnFamily::class);
        $MapField[$columnFamily] = $cf;
        return $MapField;
    }

    /**
     * Permanently deletes a specified table and all of its data.
     *
     * Example:
     * ```
     * $tableId = 'foobar';
     * $table->deleteTable($tableId);
     * ```
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
     * @return \Google\Protobuf\GPBEmpty
     *
     * @throws \Google\GAX\ApiException if the remote call fails
     */
    public function deleteTable($tableId, array $optionalArgs = [])
    {
        $formattedTable = $this->tableName($tableId);
        return $this->bigtableTableAdminClient->deleteTable($formattedTable, $optionalArgs);
    }

    /**
     * Lists all tables served from a specified instance.
     *
     * Example:
     * ```
     * $pagedResponse = $table->listTables();
     * foreach ($pagedResponse->iteratePages() as $page) {
     *      foreach ($page as $element) {
     *          // doSomethingWith($element);
     *      }
     * }
     * ```
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
     * @return \Google\GAX\PagedListResponse
     */
    public function listTables(array $optionalArgs = [])
    {
        return $this->bigtableTableAdminClient->listTables($this->formattedInstance, $optionalArgs);
    }

    /**
     * Gets metadata information about the specified table.
     *
     * Example:
     * ```
     * $tableId = 'foobar';
     * $response = $table->getTable($tableId);
     * ```
     *
     * $response = $bigtableTableAdminClient->getTable($formattedName);
     *
     * @param string $tableId
     *
     * @return \Google\Bigtable\Admin\V2\Table
     *
     * @throws \Google\GAX\ApiException if the remote call fails
     */
    public function getTable($tableId)
    {
        $formattedTable = $this->tableName($tableId);
        return $this->bigtableTableAdminClient->getTable($formattedTable);
    }

    /**
     * Add column family to perticular table.
     *
     * Example:
     * ```
     * $tableId = 'foobar';
     * $cfName = 'cf';
     * $response = $table->addColumnFamilies($tableId, $cfName);
     * ```
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
     * @return \Google\Bigtable\Admin\V2\Table
     *
     * @throws \Google\GAX\ApiException if the remote call fails
     */
    public function addColumnFamilies($tableId, $cfName, array $optionalArgs = [])
    {
        $formattedTable = $this->tableName($tableId);
        $gc = new GcRule();
        $gc->setMaxNumVersions(3);

        $cf = new ColumnFamily();
        $cf->setGcRule($gc);

        $Modification = new Modification();
        $Modification->setId($cfName);
        $Modification->setCreate($cf);

        $Modifications   = [];
        $Modifications[] = $Modification;

        return $this->bigtableTableAdminClient->modifyColumnFamilies($formattedTable, $Modifications, $optionalArgs);
    }

    /**
     * Update column family to perticular table.
     *
     * Example:
     * ```
     * $tableId = 'foobar';
     * $cfName = 'cf';
     * $response = $table->updateColumnFamilies($tableId, $cfName);
     * ```
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
     * @return \Google\Bigtable\Admin\V2\Table
     *
     * @throws \Google\GAX\ApiException if the remote call fails
     */
    public function updateColumnFamilies($tableId, $cfName, array $optionalArgs = [])
    {
        $formattedTable = $this->tableName($tableId);
        $gc = new GcRule();
        $gc->setMaxNumVersions(3);

        $cf = new ColumnFamily();
        $cf->setGcRule($gc);

        $Modification = new Modification();
        $Modification->setId($cfName);
        $Modification->setUpdate($cf);

        $Modifications    = [];
        $Modifications[] = $Modification;

        return $this->bigtableTableAdminClient->modifyColumnFamilies($formattedTable, $Modifications, $optionalArgs);
    }

    /**
     * Delete column family from perticular table.
     *
     * Example:
     * ```
     * $tableId = 'foobar';
     * $cfName = 'cf';
     * $response = $table->deleteColumnFamilies($tableId, $cfName);
     * ```
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
     * @return \Google\Bigtable\Admin\V2\Table
     *
     * @throws \Google\GAX\ApiException if the remote call fails
     */
    public function deleteColumnFamilies($tableId, $cfName, array $optionalArgs = [])
    {
        $formattedTable = $this->tableName($tableId);
        $Modification = new Modification();
        $Modification->setId($cfName);
        $Modification->setDrop(true);
        $Modifications = [];
        $Modifications[] = $Modification;

        return $this->bigtableTableAdminClient->modifyColumnFamilies($formattedTable, $Modifications, $optionalArgs);
    }

    /**
     * Permanently drop/delete a row range from a specified table. The request can
     * specify whether to delete all rows in a table, or only those that match a
     * particular prefix.
     *
     * Example:
     * ```
     * $tableId = 'foobar';
     * $table->dropRowRange($tableId);
     * ```
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
     * @return \Google\Protobuf\GPBEmpty
     *
     * @throws ApiException if the remote call fails
     */
    public function dropRowRange($tableId, array $optionalArgs = [])
    {
        $formattedName = $this->tableName($tableId);
        return $this->bigtableTableAdminClient->dropRowRange($formattedName, $optionalArgs);
    }

    /**
     * Mutates multiple rows in a batch. Each individual row is mutated
     * atomically as in MutateRow, but the entire batch is not executed
     * atomically.
     *
     * Example:
     * ```
     * $utc_str = gmdate("M d Y H:i:s", time());
     * $utc     = strtotime($utc_str)*1000;
     * $cell    = array(
     *              'cf' => 'cf',
     *              'qualifier' => 'field',
     *              'value' => 'val',
     *              'timestamp' => $utc
     *              );
     * $mutations[] = $table->mutationCell($cell);
     *
     * $rowKey = 'user00000000';
     * $entries[] = $table->mutateRowsRequest($rowKey, $mutations);
     *
     * $tableId = 'foobar';
     * $stream = $table->mutateRows($tableId, $entries);
     * foreach ($stream->readAll() as $element) {
     *      doSomethingWith($element);
     * }
     * ```
     *
     * @param string $tableId
     *
     * @param Entry[] $entries      The row keys and corresponding mutations to be applied in bulk.
     *                              Each entry is applied as an atomic mutation, but the entries may be
     *                              applied in arbitrary order (even between entries for the same row).
     *                              At least one entry must be specified, and in total the entries can
     *                              contain at most 100000 mutations.
     * @param array   $optionalArgs {
     *                              Optional.
     *
     *     @type int $timeoutMillis
     *          Timeout to use for this call.
     * }
     *
     * @return \Google\GAX\ServerStream
     *
     * @throws \Google\GAX\ApiException if the remote call fails
     */
    public function mutateRows($tableId, array $entries, array $optionalArgs = [])
    {
        $formattedTable = $this->tableName($tableId);
        return $this->bigtableClient->mutateRows($formattedTable, $entries, $optionalArgs);
    }

    /**
     * Mutates a row atomically. Cells already present in the row are left
     * unchanged unless explicitly changed by `mutation`.
     *
     * Example:
     * ```
     * $utc_str = gmdate("M d Y H:i:s", time());
     * $utc     = strtotime($utc_str)*1000;
     * $cell    = array(
     *              'cf' => 'cf',
     *              'qualifier' => 'field',
     *              'value' => 'val',
     *              'timestamp' => $utc
     *            );
     * $mutations[] = $table->mutationCell($cell);
     *
     * $rowKey = 'user0000000';
     * $tableId = 'foobar';
     * $response = $table->mutateRow($tableId, $rowKey, $mutations);
     * ```
     *
     * @param string $tableId
     *
     * @param string     $rowKey       The key of the row to which the mutation should be applied.
     *
     * @param Mutation[] $mutations    Changes to be atomically applied to the specified row. Entries are applied
     *                                 in order, meaning that earlier mutations can be masked by later ones.
     *                                 Must contain at least one entry and at most 100000.
     * @param array      $optionalArgs {
     *                                 Optional.
     *
     *     @type \Google\GAX\RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\GAX\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\GAX\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Bigtable\V2\MutateRowResponse
     *
     * @throws \Google\GAX\ApiException if the remote call fails
     */
    public function mutateRow($tableId, $rowKey, array $mutations, array $optionalArgs = [])
    {
        $formattedTable = $this->tableName($tableId);
        return $this->bigtableClient->mutateRow($formattedTable, $rowKey, $mutations, $optionalArgs);
    }

    /**
     * Set cell on Mutation.
     *
     * Example:
     * ```
     * $utc_str = gmdate("M d Y H:i:s", time());
     * $utc     = strtotime($utc_str)*1000;
     * $cell    = array(
     *              'cf' => 'cf',
     *              'qualifier' => 'field',
     *              'value' => 'val',
     *              'timestamp' => $utc
     *            );
     * $mutation = $table->mutationCell($cell);
     * ```
     *
     * @param array   $cell {
     *                 @param    string cf           Column Family name
     *                 @param    string qualifier    Qualifier name
     *                 @param    string value        value
     *                 @param    string timestamp    Timestamp in micros
     *
     * @return \Google\Bigtable\V2\Mutation
     */
    public function mutationCell(array $cell)
    {
        $Mutation_SetCell = new Mutation_SetCell();
        if (isset($cell['cf'])) {
            $Mutation_SetCell->setFamilyName($cell['cf']);
        }
        if (isset($cell['qualifier'])) {
            $Mutation_SetCell->setColumnQualifier($cell['qualifier']);
        }
        if (isset($cell['value'])) {
            $Mutation_SetCell->setValue($cell['value']);
        }
        if (isset($cell['timestamp'])) {
            $Mutation_SetCell->setTimestampMicros($cell['timestamp']);
        }

        $Mutation = new Mutation();
        $Mutation->setSetCell($Mutation_SetCell);
        return $Mutation;
    }

    /**
     * Set mutations into mutate Rows Request.
     *
     * Example:
     * ```
     * $utc_str = gmdate("M d Y H:i:s", time());
     * $utc     = strtotime($utc_str)*1000;
     * $cell    = array(
     *              'cf' => 'cf',
     *              'qualifier' => 'field',
     *              'value' => 'val',
     *              'timestamp' => $utc
     *            );
     * $mutations[] = $table->mutationCell($cell);
     *
     * $rowKey = 'user00000000';
     * $requestEntry = $table->mutateRowsRequest($rowKey, $mutations);
     * ```
     *
     * @param string $rowKey
     *
     * @param Mutation[] $mutations     array of \Google\Bigtable\V2\Mutation
     *
     * @return \Google\Bigtable\V2\MutateRowsRequest_Entry
     */
    public function mutateRowsRequest($rowKey, array $mutations)
    {
        $MutateRowsRequest_Entry = new MutateRowsRequest_Entry();
        $MutateRowsRequest_Entry->setRowKey($rowKey);
        $MutateRowsRequest_Entry->setMutations($mutations);
        return $MutateRowsRequest_Entry;
    }

    /**
     * Read rows from table.
     * Streams back the contents of all requested rows in key order, optionally
     * applying the same Reader filter to each. Depending on their size,
     * rows and cells may be broken up across multiple responses, but
     * atomicity of each row will still be preserved. See the
     * ReadRowsResponse documentation for details.
     *
     * Example:
     * ```
     * $tableId = 'foobar';
     * $flatRows = $table->readRows($tableId);
     *
     * // OR
     *
     * $rowKey = 'user00000000';
     * $rowSet = new \Google\Bigtable\V2\RowSet();
     * $rowSet->setRowKeys([$rowKey]);
     *
     * $rowFilter = new \Google\Bigtable\V2\RowFilter();
     * $rowFilter->setCellsPerRowLimitFilter(1);
     *
     * $options['rows'] = $rowSet;
     * $options['filter'] = $rowFilter;
     *
     * $tableId = 'foobar';
     * $flatRows = $table->readRows($tableId, $options);
     * ```
     *
     * @param string $tableId
     *
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type RowSet $rowKeys
     *          The row keys and/or ranges to read. If not specified, reads from all rows.
     *     @type RowFilter $filter
     *          The filter to apply to the contents of the specified row(s). If unset,
     *          reads the entirety of each row.
     *     @type int $rowsLimit
     *          The read will terminate after committing to N rows' worth of results. The
     *          default (zero) is to return all results.
     *     @type int $timeoutMillis
     *          Timeout to use for this call.
     * }
     *
     * @return \Google\Cloud\Bigtable\V2\FlatRow
     *
     * @throws \Google\GAX\ApiException if the remote call fails
     */
    public function readRows($tableId, $optionalArgs = [])
    {
        $formattedTable = $this->tableName($tableId);
        $serverStream   = $this->bigtableClient->readRows($formattedTable, $optionalArgs);
        $chunkFormatter = new ChunkFormatter($serverStream, $optionalArgs);
        $rows           = [];
        foreach ($chunkFormatter->readAll() as $flatRow) {
            $rows[] = $flatRow;
        }
        return $rows;
    }

    /**
     * Returns a sample of row keys in the table. The returned row keys will
     * delimit contiguous sections of the table of approximately equal size,
     * which can be used to break up the data for distributed tasks like
     * mapreduces.
     *
     * Example:
     * ```
     * $tableId = 'foobar';
     * $stream = $table->sampleRowKeys($tableId);
     * foreach ($stream->readAll() as $element) {
     *      // doSomethingWith($element);
     * }
     * ```
     *
     * @param string $tableId
     *
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type int $timeoutMillis
     *          Timeout to use for this call.
     * }
     *
     * @return \Google\GAX\ServerStream
     *
     * @throws \Google\GAX\ApiException if the remote call fails
     * @experimental
     */
    public function sampleRowKeys($tableId, array $optionalArgs = [])
    {
        $formattedTable = $this->tableName($tableId);
        return $this->bigtableClient->sampleRowKeys($formattedTable, $optionalArgs);
    }

    /**
     * Mutates a row atomically based on the output of a predicate Reader filter.
     *
     * Example:
     * ```
     * $tableId = 'foobar';
     * $rowKey = 'user00000000';
     * $response = $table->checkAndMutateRow($tableId, $rowKey);
     * ```
     *
     * @param string $tableId
     *
     * @param string $rowKey       The key of the row to which the conditional mutation should be applied.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type RowFilter $predicateFilter
     *          The filter to be applied to the contents of the specified row. Depending
     *          on whether or not any results are yielded, either `true_mutations` or
     *          `false_mutations` will be executed. If unset, checks that the row contains
     *          any values at all.
     *     @type Mutation[] $trueMutations
     *          Changes to be atomically applied to the specified row if `predicate_filter`
     *          yields at least one cell when applied to `row_key`. Entries are applied in
     *          order, meaning that earlier mutations can be masked by later ones.
     *          Must contain at least one entry if `false_mutations` is empty, and at most
     *          100000.
     *     @type Mutation[] $falseMutations
     *          Changes to be atomically applied to the specified row if `predicate_filter`
     *          does not yield any cells when applied to `row_key`. Entries are applied in
     *          order, meaning that earlier mutations can be masked by later ones.
     *          Must contain at least one entry if `true_mutations` is empty, and at most
     *          100000.
     *     @type \Google\GAX\RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\GAX\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\GAX\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Bigtable\V2\CheckAndMutateRowResponse
     *
     * @throws \Google\GAX\ApiException if the remote call fails
     * @experimental
     */
    public function checkAndMutateRow($tableId, $rowKey, array $optionalArgs = [])
    {
        $formattedTable = $this->tableName($tableId);
        return $this->bigtableClient->checkAndMutateRow($formattedTable, $rowKey, $optionalArgs);
    }

    /**
     * Modifies a row atomically. The method reads the latest existing timestamp
     * and value from the specified columns and writes a new entry based on
     * pre-defined read/modify/write rules. The new value for the timestamp is the
     * greater of the existing timestamp or the current server time. The method
     * returns the new contents of all modified cells.
     *
     * Example:
     * ```
     * $_rules = array();
     * $RowRules = new \Google\Bigtable\V2\ReadModifyWriteRule();
     * $RowRules->setFamilyName('cf');
     * $RowRules->setColumnQualifier('qualifier');
     * $RowRules->setAppendValue('VAl');
     * $_rules[] = $ReadModifyWriteRule;
     * $tableId = 'foobar';
     * $rowKey = 'user00000000';
     * $response = $table->readModifyWriteRow($tableId, $rowKey, $_rules);
     * ```
     *
     * @param string $tableId
     *
     * @param string                $rowKey       The key of the row to which the read/modify/write
     *                                            rules should be applied.
     * @param ReadModifyWriteRule[] $rules        Rules specifying how the specified row's
     *                                            contents are to be transformed into writes.
     *                                            Entries are applied in order, meaning that earlier rules will
     *                                            affect the results of later ones.
     * @param array                 $optionalArgs {
     *                                            Optional.
     *
     *     @type \Google\GAX\RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\GAX\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\GAX\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Bigtable\V2\ReadModifyWriteRowResponse
     *
     * @throws \Google\GAX\ApiException if the remote call fails
     * @experimental
     */
    public function readModifyWriteRow($tableId, $rowKey, array $rules, array $optionalArgs = [])
    {
        $formattedTable = $this->tableName($tableId);
        return $this->bigtableClient->readModifyWriteRow($formattedTable, $rowKey, $rules, $optionalArgs);
    }
}

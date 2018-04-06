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
 * Connection to Bigtable Table API
 */
interface TableConnectionInterface extends ConnectionInterface
{

    /**
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
     */
    public function mutateRows($tableId, array $entries, array $optionalArgs = []);

    /**
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
     * @return TBD
     *
     */
    public function mutateRow($tableId, $rowKey, array $mutations, array $optionalArgs = []);

    /**
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
     * @return TBD
     *
     */
    public function readRows($tableId, $optionalArgs = []);

    /**
     * @param string $tableId
     *
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type int $timeoutMillis
     *          Timeout to use for this call.
     * }
     *
     * @return TBD
     *
     */
    public function sampleRowKeys($tableId, array $optionalArgs = []);

    /**
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
     * @return TBD
     *
     */
    public function checkAndMutateRow($tableId, $rowKey, array $optionalArgs = []);

    /**
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
     * @return TBD
     *
     */
    public function readModifyWriteRow($tableId, $rowKey, array $rules, array $optionalArgs = []);
}

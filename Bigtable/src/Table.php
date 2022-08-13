<?php
/**
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

use Google\ApiCore\ApiException;
use Google\ApiCore\Serializer;
use Google\Cloud\Bigtable\Exception\BigtableDataOperationException;
use Google\Cloud\Bigtable\Filter\FilterInterface;
use Google\Cloud\Bigtable\Mutations;
use Google\Cloud\Bigtable\ReadModifyWriteRowRules;
use Google\Cloud\Bigtable\V2\BigtableClient as GapicClient;
use Google\Cloud\Bigtable\V2\MutateRowsRequest\Entry;
use Google\Cloud\Bigtable\V2\Row;
use Google\Cloud\Bigtable\V2\RowRange;
use Google\Cloud\Bigtable\V2\RowSet;
use Google\Cloud\Core\ArrayTrait;
use Google\Rpc\Code;

/**
 * A table instance can be used to read rows and to perform insert, update, and
 * delete operations.
 *
 * Example:
 * ```
 * use Google\Cloud\Bigtable\BigtableClient;
 *
 * $bigtable = new BigtableClient();
 * $table = $bigtable->table('my-instance', 'my-table');
 * ```
 */
class Table
{
    use ArrayTrait;

    /**
     * @var GapicClient
     */
    private $gapicClient;

    /**
     * @var array
     */
    private $options;

    /**
     * @var string
     */
    private $tableName;

    /**
     * @var Serializer
     */
    private $serializer;

    /**
     * Create a table instance.
     *
     * @param GapicClient $gapicClient The GAPIC client used to make requests.
     * @param string $tableName The full table name. Must match the following
     *        pattern: projects/{project}/instances/{instance}/tables/{table}.
     * @param array $options [optional] {
     *     Configuration options.
     *
     *     @type string $appProfileId This value specifies routing for
     *           replication. **Defaults to** the "default" application profile.
     *     @type array $headers Headers to be passed with each request.
     *     @type int $retries Number of times to retry. **Defaults to** `3`.
     *           This settings only applies to {@see Google\Cloud\Bigtable\Table::mutateRows()},
     *           {@see Google\Cloud\Bigtable\Table::upsert()} and
     *           {@see Google\Cloud\Bigtable\Table::readRows()}.
     * }
     */
    public function __construct(
        GapicClient $gapicClient,
        $tableName,
        array $options = []
    ) {
        $this->gapicClient = $gapicClient;
        $this->tableName = $tableName;
        $this->options = $options;
        $this->serializer = new Serializer();
    }

    /**
     * Mutates rows in a table.
     *
     * Example:
     * ```
     * use Google\Cloud\Bigtable\Mutations;
     *
     * $mutations = (new Mutations)
     *     ->upsert('cf1', 'cq1', 'value1', 1534183334215000);
     *
     * $table->mutateRows(['r1' => $mutations]);
     * ```
     *
     * @param array $rowMutations An associative array with the key being the
     *        row key and the value being the
     *        {@see Google\Cloud\Bigtable\Mutations} to perform.
     * @param array $options [optional] Configuration options.
     * @return void
     * @throws ApiException|BigtableDataOperationException If the remote call fails or operation fails.
     * @throws InvalidArgumentException If rowMutations is a list instead of associative array indexed by row key.
     */
    public function mutateRows(array $rowMutations, array $options = [])
    {
        if (!$this->isAssoc($rowMutations)) {
            throw new \InvalidArgumentException(
                'Expected rowMutations to be of type associative array, instead got list.'
            );
        }
        $entries = [];
        foreach ($rowMutations as $rowKey => $mutations) {
            $entries[] = $this->toEntry($rowKey, $mutations);
        }
        $this->mutateRowsWithEntries($entries, $options);
    }

    /**
     * Mutates a row atomically. Cells already present in the row are left
     * unchanged unless explicitly changed by `mutations`.
     *
     * Example:
     * ```
     * use Google\Cloud\Bigtable\Mutations;
     *
     * $mutations = (new Mutations)
     *     ->upsert('cf1', 'cq1', 'value1', 1534183334215000);
     *
     * $table->mutateRow('r1', $mutations);
     * ```
     *
     * @param string $rowKey The row key of the row to mutate.
     * @param Mutations $mutations Mutations to apply on row.
     * @param array $options [optional] {
     *     Configuration options.
     *
     *     @type int $retries Number of times to retry. **Defaults to** `3`.
     * }
     * @return void
     * @throws ApiException If the remote call fails.
     */
    public function mutateRow($rowKey, Mutations $mutations, array $options = [])
    {
        $this->gapicClient->mutateRow(
            $this->tableName,
            $rowKey,
            $mutations->toProto(),
            $options + $this->options
        );
    }

    /**
     * Insert/update rows in a table.
     *
     * Example:
     * ```
     * $table->upsert([
     *     'r1' => [
     *         'cf1' => [
     *             'cq1' => [
     *                 'value'=>'value1',
     *                 'timeStamp' => 1534183334215000
     *              ]
     *         ]
     *     ]
     *]);
     * ```
     *
     * @param array[] $rows An array of rows.
     * @param array $options [optional] {
     *     Configuration options.
     *
     *     @type int $retries Number of times to retry. **Defaults to** `3`.
     * }
     * @return void
     * @throws ApiException|BigtableDataOperationException If the remote call fails or operation fails
     */
    public function upsert(array $rows, array $options = [])
    {
        $entries = [];
        foreach ($rows as $rowKey => $families) {
            $mutations = new Mutations;
            foreach ($families as $family => $qualifiers) {
                foreach ($qualifiers as $qualifier => $value) {
                    if (isset($value['timeStamp'])) {
                        $mutations->upsert(
                            $family,
                            $qualifier,
                            $value['value'],
                            $value['timeStamp']
                        );
                    } else {
                        $mutations->upsert($family, $qualifier, $value['value']);
                    }
                }
            }
            $entries[] = $this->toEntry($rowKey, $mutations);
        }
        $this->mutateRowsWithEntries($entries, $options);
    }

    /**
     * Read rows from the table.
     *
     * Example:
     * ```
     * $rows = $table->readRows();
     *
     * foreach ($rows as $key => $row) {
     *     echo $key . ': ' . print_r($row, true) . PHP_EOL;
     * }
     * ```
     *
     * ```
     * // Specify a set of row ranges.
     * $rows = $table->readRows([
     *     'rowRanges' => [
     *         [
     *             'startKeyOpen' => 'jefferson',
     *             'endKeyOpen' => 'lincoln'
     *         ]
     *     ]
     * ]);
     *
     * foreach ($rows as $key => $row) {
     *     echo $key . ': ' . print_r($row, true) . PHP_EOL;
     * }
     * ```
     *
     * @param array $options [optional] {
     *     Configuration options.
     *
     *     @type string[] $rowKeys A set of row keys to read.
     *     @type array $rowRanges A set of row ranges. Each row range is an
     *           associative array which may contain a start key
     *           (`startKeyClosed` or `startKeyOpen`) and/or an end key
     *           (`endKeyOpen` or `endKeyClosed`).
     *     @type FilterInterface $filter A filter used to take an input row and
     *           produce an alternate view of the row based on the specified rules.
     *           To learn more please see {@see Google\Cloud\Bigtable\Filter} which
     *           provides static factory methods for the various filter types.
     *     @type int $rowsLimit The number of rows to scan.
     *     @type int $retries Number of times to retry. **Defaults to** `3`.
     * }
     * @return ChunkFormatter
     */
    public function readRows(array $options = [])
    {
        $rowKeys = $this->pluck('rowKeys', $options, false) ?: [];
        $ranges = $this->pluck('rowRanges', $options, false) ?: [];
        $filter = $this->pluck('filter', $options, false) ?: null;

        array_walk($ranges, function (&$range) {
            $range = $this->serializer->decodeMessage(
                new RowRange(),
                $range
            );
        });
        if (!is_array($rowKeys)) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Expected rowKeys to be of type array, instead got \'%s\'.',
                    gettype($rowKeys)
                )
            );
        }
        if ($ranges || $rowKeys) {
            $options['rows'] = $this->serializer->decodeMessage(
                new RowSet,
                [
                    'rowKeys' => $rowKeys,
                    'rowRanges' => $ranges
                ]
            );
        }
        if ($filter !== null) {
            if (!$filter instanceof FilterInterface) {
                throw new \InvalidArgumentException(
                    sprintf(
                        'Expected filter to be of type \'%s\', instead got \'%s\'.',
                        FilterInterface::class,
                        gettype($filter)
                    )
                );
            }
            $options['filter'] = $filter->toProto();
        }
        return new ChunkFormatter(
            [$this->gapicClient, 'readRows'],
            $this->tableName,
            $options + $this->options
        );
    }

    /**
     * Read a single row from the table.
     *
     * Example:
     * ```
     * $row = $table->readRow('jefferson');
     *
     * print_r($row);
     * ```
     *
     * @param string $rowKey The row key to read.
     * @param array $options [optional] Configuration options.
     * @return array|null
     */
    public function readRow($rowKey, array $options = [])
    {
        return $this->readRows(
            ['rowKeys' => [$rowKey]] + $options + $this->options
        )
            ->readAll()
            ->current();
    }

    /**
     * Modifies a row atomically on the server. The method reads the latest
     * existing timestamp and value from the specified columns and writes a new
     * entry based on pre-defined read/modify/write rules. The new value for the
     * timestamp is the greater of the existing timestamp or the current server
     * time. The method returns the new contents of all modified cells.
     *
     * Example:
     * ```
     * use Google\Cloud\Bigtable\ReadModifyWriteRowRules;
     *
     * $rules = (new ReadModifyWriteRowRules)
     *     ->append('cf1', 'cq1', 'value12');
     * $row = $table->readModifyWriteRow('rk1', $rules);
     *
     * print_r($row);
     * ```
     *
     * ```
     * // Increments value
     * use Google\Cloud\Bigtable\DataUtil;
     * use Google\Cloud\Bigtable\ReadModifyWriteRowRules;
     * use Google\Cloud\Bigtable\Mutations;
     *
     * $mutations = (new Mutations)
     *     ->upsert('cf1', 'cq1', DataUtil::intToByteString(2));
     *
     * $table->mutateRows(['rk1' => $mutations]);
     *
     * $rules = (new ReadModifyWriteRowRules)
     *     ->increment('cf1', 'cq1', 3);
     * $row = $table->readModifyWriteRow('rk1', $rules);
     *
     * print_r($row);
     * ```
     *
     * @param string $rowKey The row key to read.
     * @param ReadModifyWriteRowRules $rules Rules to apply on row.
     * @param array $options [optional] Configuration options.
     * @return array Returns array containing all column family keyed by family name.
     * @throws ApiException If the remote call fails or operation fails
     */
    public function readModifyWriteRow($rowKey, ReadModifyWriteRowRules $rules, array $options = [])
    {
        $readModifyWriteRowResponse = $this->gapicClient->readModifyWriteRow(
            $this->tableName,
            $rowKey,
            $rules->toProto(),
            $options + $this->options
        );
        return $this->convertToArray($readModifyWriteRowResponse->getRow());
    }

    /**
     * Returns a sample of row keys in the table. The returned row keys will
     * delimit contiguous sections of the table of approximately equal size,
     * which can be used to break up the data for distributed tasks like
     * mapreduces.
     *
     * Example:
     * ```
     * $rowKeyStream = $table->sampleRowKeys();
     * foreach ($rowKeyStream as $rowKey) {
     *     print_r($rowKey) . PHP_EOL;
     * }
     * ```
     *
     * @param array $options [optional] Configuration options.
     * @return \Generator<array> A list of associative arrays, each with the keys `rowKey` and `offset`.
     * @throws ApiException If the remote call fails or operation fails
     */
    public function sampleRowKeys(array $options = [])
    {
        $stream = $this->gapicClient->sampleRowKeys(
            $this->tableName,
            $options + $this->options
        );

        foreach ($stream->readAll() as $response) {
            yield [
                'rowKey' => $response->getRowKey(),
                'offset' => $response->getOffsetBytes()
            ];
        }
    }

    /**
     * Mutates the specified row atomically based on output of the filter.
     *
     * Example:
     * ```
     * use Google\Cloud\Bigtable\Mutations;
     *
     * $mutations = (new Mutations)->upsert('family', 'qualifier', 'value');
     * $result = $table->checkAndMutateRow('rk1', ['trueMutations' => $mutations]);
     * ```
     *
     * ```
     * // With predicate filter
     * use Google\Cloud\Bigtable\Filter;
     * use Google\Cloud\Bigtable\Mutations;
     *
     * $mutations = (new Mutations)->upsert('family', 'qualifier', 'value');
     * $predicateFilter = Filter::qualifier()->exactMatch('cq');
     * $options = ['predicateFilter' => $predicateFilter, 'trueMutations' => $mutations];
     * $result = $table->checkAndMutateRow('rk1', $options);
     * ```
     *
     * @param string $rowKey The row key to mutate row conditionally.
     * @param array $options [optional] {
     *     Configuration options.
     *
     *     @type FilterInterface $predicateFilter The filter to be applied to the specified
     *           row. Depending on whether or not any results are yielded, either the
     *           trueMutations or falseMutations will be executed. If unset, checks that the
     *           row contains any values at all. Only a single condition can be set, however
     *           that filter can be {@see Google\Cloud\Bigtable\Filter::chain()} or
     *           {@see Google\Cloud\Bigtable\Filter::interleave()} which can wrap multiple other
     *           filters.
     *           WARNING: {@see Google\Cloud\Bigtable\Filter::condition()} is not supported.
     *     @type Mutations $trueMutations Mutations to be atomically applied when the predicate
     *           filter's condition yields at least one cell when applied to the row. Please note
     *           either `trueMutations` or `falseMutations` must be provided.
     *     @type Mutations $falseMutations Mutations to be atomically applied when the predicate
     *           filter's condition does not yield any cells when applied to the row. Please note
     *           either `trueMutations` or `falseMutations` must be provided.
     * }
     *
     * @return bool Returns true if predicate filter yielded any output, false otherwise.
     * @throws ApiException If the remote call fails or operation fails
     * @throws \InvalidArgumentException If neither of $trueMutations or $falseMutations is set.
     *         If $predicateFilter is not instance of {@see Google\Cloud\Bigtable\Filter\FilterInterface}.
     *         If $trueMutations is set and is not instance of {@see Google\Cloud\Bigtable\Mutations}.
     *         If $falseMutations is set and is not instance of {@see Google\Cloud\Bigtable\Mutations}.
     */
    public function checkAndMutateRow($rowKey, array $options = [])
    {
        $hasSetMutations = false;

        if (isset($options['predicateFilter'])) {
            $this->convertToProto($options, 'predicateFilter', FilterInterface::class);
        }
        if (isset($options['trueMutations'])) {
            $this->convertToProto($options, 'trueMutations', Mutations::class);
            $hasSetMutations = true;
        }
        if (isset($options['falseMutations'])) {
            $this->convertToProto($options, 'falseMutations', Mutations::class);
            $hasSetMutations = true;
        }
        if (!$hasSetMutations) {
            throw new \InvalidArgumentException('checkAndMutateRow must have either trueMutations or falseMutations.');
        }

        return $this->gapicClient
            ->checkAndMutateRow(
                $this->tableName,
                $rowKey,
                $options + $this->options
            )
            ->getPredicateMatched();
    }

    private function mutateRowsWithEntries(array $entries, array $options = [])
    {
        $rowMutationsFailedResponse = [];
        $options = $options + $this->options;
        $argumentFunction = function () use (&$entries, &$rowMutationsFailedResponse, $options) {
            if (count($rowMutationsFailedResponse) > 0) {
                $entries = array_values($entries);
                $rowMutationsFailedResponse = [];
            }
            return [$this->tableName, $entries, $options];
        };
        $statusCode = Code::OK;
        $lastProcessedIndex = -1;
        $retryFunction = function ($ex) use (&$statusCode, &$lastProcessedIndex) {
            if (($ex && ResumableStream::isRetryable($ex->getCode())) || (ResumableStream::isRetryable($statusCode))) {
                $statusCode = Code::OK;
                $lastProcessedIndex = -1;
                return true;
            }
            return false;
        };
        $retryingStream = new ResumableStream(
            [$this->gapicClient, 'mutateRows'],
            $argumentFunction,
            $retryFunction,
            $this->pluck('retries', $options, false)
        );
        $message = 'partial failure';
        try {
            foreach ($retryingStream as $mutateRowsResponse) {
                foreach ($mutateRowsResponse->getEntries() as $mutateRowsResponseEntry) {
                    if ($mutateRowsResponseEntry->getStatus()->getCode() !== Code::OK) {
                        if ($statusCode === Code::OK
                            || !ResumableStream::isRetryable($mutateRowsResponseEntry->getStatus()->getCode())) {
                            $statusCode = $mutateRowsResponseEntry->getStatus()->getCode();
                        }
                        $rowMutationsFailedResponse[] = [
                            'rowKey' => $entries[$mutateRowsResponseEntry->getIndex()]->getRowKey(),
                            'statusCode' => $mutateRowsResponseEntry->getStatus()->getCode(),
                            'message' => $mutateRowsResponseEntry->getStatus()->getMessage()
                        ];
                    } else {
                        unset($entries[$mutateRowsResponseEntry->getIndex()]);
                    }
                    $lastProcessedIndex = $mutateRowsResponseEntry->getIndex();
                }
            }
        } catch (ApiException $ex) {
            $this->appendPendingEntryToFailedMutations(
                $lastProcessedIndex,
                $entries,
                $rowMutationsFailedResponse,
                $ex->getCode(),
                $ex->getMessage()
            );
            if ($ex->getErrorInfoMetadata()) {
                $rowMutationsFailedResponse = array_merge(
                    $rowMutationsFailedResponse,
                    $ex->getErrorInfoMetadata()
                );
            }
            throw new BigtableDataOperationException(
                $ex->getMessage(),
                $ex->getCode(),
                $rowMutationsFailedResponse
            );
        }

        if (!empty($rowMutationsFailedResponse)) {
            $this->appendPendingEntryToFailedMutations(
                $lastProcessedIndex,
                $entries,
                $rowMutationsFailedResponse,
                $statusCode,
                $message
            );
            throw new BigtableDataOperationException($message, $statusCode, $rowMutationsFailedResponse);
        }
    }

    private function appendPendingEntryToFailedMutations(
        $lastProcessedIndex,
        &$entries,
        &$rowMutationsFailedResponse,
        $statusCode,
        $message
    ) {
        if (count($rowMutationsFailedResponse) !== count($entries)) {
            end($entries);
            foreach (range($lastProcessedIndex + 1, key($entries)) as $index) {
                $rowMutationsFailedResponse[] = [
                    'rowKey' => $entries[$index]->getRowKey(),
                    'statusCode' => $statusCode,
                    'message' => $message
                ];
            }
        }
    }

    private function toEntry($rowKey, Mutations $mutations)
    {
        return (new Entry)
            ->setRowKey($rowKey)
            ->setMutations($mutations->toProto());
    }

    private function convertToArray(Row $row)
    {
        if ($row === null) {
            return [];
        }
        $families = [];
        foreach ($row->getFamilies() as $family) {
            $qualifiers = [];
            foreach ($family->getColumns() as $column) {
                $values = [];
                foreach ($column->getCells() as $cell) {
                    $values[] = [
                        'value' => $cell->getValue(),
                        'timeStamp' => $cell->getTimestampMicros(),
                        'labels' => ($cell->getLabels()->getIterator()->valid())
                            ? implode(iterator_to_array($cell->getLabels()->getIterator()))
                            : ''
                    ];
                }
                $qualifiers[$column->getQualifier()] = $values;
            }
            $families[$family->getName()] = $qualifiers;
        }
        return $families;
    }

    private function convertToProto(array &$options, $key, $expectedType)
    {
        if (!$options[$key] instanceof $expectedType) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Expected %s to be of type \'%s\', instead got \'%s\'.',
                    $key,
                    $expectedType,
                    gettype($options[$key])
                )
            );
        }

        $options[$key] = $options[$key]->toProto();
    }
}

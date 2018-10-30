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
use Google\Cloud\Bigtable\ReadModifyWriteRowRules;
use Google\Cloud\Bigtable\Mutations;
use Google\Cloud\Bigtable\V2\BigtableClient as TableClient;
use Google\Cloud\Bigtable\V2\MutateRowsRequest\Entry;
use Google\Cloud\Bigtable\V2\Row;
use Google\Cloud\Bigtable\V2\RowRange;
use Google\Cloud\Bigtable\V2\RowSet;
use Google\Cloud\Core\ArrayTrait;
use Google\Cloud\Core\ClientTrait;
use Google\Rpc\Code;

/**
 * Represents a DataOperation Client to perform data operation on Bigtable table.
 * This is used to perform insert,update, delete operation on table in Bigtable.
 *
 * Example:
 * ```
 * use Google\Cloud\Bigtable\DataClient;
 *
 * $dataClient = new DataClient('my-instance', 'my-table');
 * ```
 *
 */
class DataClient
{
    use ArrayTrait;
    use ClientTrait;

    /**
     * @var string
     */
    private $instanceId;

    /**
     * @var string
     */
    private $tableId;

    /**
     * @var TableClient
     */
    private $bigtableClient;

    /**
     * @var array
     */
    private $options;

    /**
     * @var string
     */
    private $tableName;

    /**
     * Create a Bigtable data client.
     *
     * @param string $instanceId The instance id.
     * @param string $tableId The table id on which operation to be performed.
     * @param array $config [optional] {
     *     Configuration Options.
     *
     *      @type string $appProfileId The appProfileId to be used.
     *      @type array $headers The headers to be passed to request.
     *      @type TableClient $bigtableClient The GAPIC Bigtable client to use.
     *            If not provided it will create one.
     *     @type array $keyFile The contents of the service account credentials
     *           .json file retrieved from the Google Developer's Console.
     *           Ex: `json_decode(file_get_contents($path), true)`.
     *     @type string $keyFilePath The full path to your service account
     *           credentials .json file retrieved from the Google Developers
     *           Console.
     * }
     */
    public function __construct($instanceId, $tableId, array $config = [])
    {
        $this->serializer = new Serializer();
        $this->instanceId = $instanceId;
        $this->tableId = $tableId;
        $this->options = [];
        if (isset($config['appProfileId'])) {
            $this->options['appProfileId'] = $config['appProfileId'];
        }
        if (isset($config['headers'])) {
            $this->options['headers'] = $config['headers'];
        }
        $config = $this->configureAuthentication($config);
        if (isset($config['bigtableClient'])) {
            $this->bigtableClient = $config['bigtableClient'];
        } else {
            // Temp workaround for large messages.
            $config['transportConfig'] = [
                'grpc' => [
                    'stubOpts' => [
                        'grpc.max_send_message_length' => -1,
                        'grpc.max_receive_message_length' => -1
                    ]
                ]
            ];
            $this->bigtableClient = new TableClient($config);
        }
        $this->tableName = TableClient::tableName($this->projectId, $instanceId, $tableId);
    }

    /**
     * Mutates rows in a table.
     *
     * Example:
     * ```
     * use Google\Cloud\Bigtable\DataClient;
     * use Google\Cloud\Bigtable\Mutations;
     *
     * $mutations = (new Mutations)
     *     ->upsert('cf1', 'cq1', 'value1', 1534183334215000);
     *
     * $dataClient->mutateRows(['r1' => $mutations]);
     * ```
     * @param array $rowMutations Associative array of rowKey as key and value as
     *        {@see Google\Cloud\Bigtable\Mutations}.
     * @param array $options [optional] Configuration options.
     * @return void
     * @throws ApiException|BigtableDataOperationException If the remote call fails or operation fails.
     * @throws InvalidArgumentException If rowMutations is a list instead of associative array indexed by rowkey.
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
     * use Google\Cloud\Bigtable\DataClient;
     * use Google\Cloud\Bigtable\Mutations;
     *
     * $mutations = (new Mutations)
     *     ->upsert('cf1', 'cq1', 'value1', 1534183334215000);
     *
     * $dataClient->mutateRow('r1', $mutations);
     * ```
     *
     * @param string $rowKey The row key of the row to mutate.
     * @param Mutations $mutations Mutations to apply on row.
     * @param array $options [optional] Configuration options.
     * @return void
     * @throws ApiException If the remote call fails.
     */
    public function mutateRow($rowKey, Mutations $mutations, array $options = [])
    {
        $this->bigtableClient->mutateRow(
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
     * use Google\Cloud\Bigtable\DataClient;
     *
     * $dataClient->upsert(['r1' => ['cf1' => ['cq1' => ['value'=>'value1', 'timeStamp' => 1534183334215000]]]]);
     * ```
     * @param array[] $rows array of row.
     * @param array $options [optional] Configuration options.
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
     * $rows = $dataClient->readRows();
     *
     * foreach ($rows as $row) {
     *     print_r($row) . PHP_EOL;
     * }
     * ```
     *
     * // Specify a set of row ranges.
     * ```
     * $rows = $dataClient->readRows([
     *     'rowRanges' => [
     *         [
     *             'startKeyOpen' => 'jefferson',
     *             'endKeyOpen' => 'lincoln'
     *         ]
     *     ]
     * ]);
     *
     * foreach ($rows as $row) {
     *     print_r($row) . PHP_EOL;
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

        $serverStream = $this->bigtableClient->readRows(
            $this->tableName,
            $options + $this->options
        );
        return new ChunkFormatter($serverStream);
    }

    /**
     * Read a single row from the table.
     *
     * Example:
     * ```
     * $row = $dataClient->readRow('jefferson');
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
            ['rowKeys' => [$rowKey]],
            $options + $this->options
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
     * $row = $dataClient->readModifyWriteRow('rk1', $rules);
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
     * $dataClient->mutateRows(['rk1' => $mutations]);
     *
     * $rules = (new ReadModifyWriteRowRules)
     *     ->increment('cf1', 'cq1', 3);
     * $row = $dataClient->readModifyWriteRow('rk1', $rules);
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
        $readModifyWriteRowResponse = $this->bigtableClient->readModifyWriteRow(
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
     * $rowKeyStream = $dataClient->sampleRowKeys();
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
        $stream = $this->bigtableClient->sampleRowKeys(
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
     * $result = $dataClient->checkAndMutateRow('rk1', ['trueMutations' => $mutations]);
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
     * $result = $dataClient->checkAndMutateRow('rk1', $options);
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

        return $this->bigtableClient
            ->checkAndMutateRow(
                $this->tableName,
                $rowKey,
                $options + $this->options
            )
            ->getPredicateMatched();
    }

    private function mutateRowsWithEntries(array $entries, array $options = [])
    {
        $responseStream = $this->bigtableClient->mutateRows($this->tableName, $entries, $options + $this->options);
        $rowMutationsFailedResponse = [];
        $failureCode = Code::OK;
        $message = 'partial failure';
        foreach ($responseStream->readAll() as $mutateRowsResponse) {
            $mutateRowsResponseEntries = $mutateRowsResponse->getEntries();
            foreach ($mutateRowsResponseEntries as $mutateRowsResponseEntry) {
                if ($mutateRowsResponseEntry->getStatus()->getCode() !== Code::OK) {
                    $failureCode = $mutateRowsResponseEntry->getStatus()->getCode();
                    $message = $mutateRowsResponseEntry->getStatus()->getMessage();
                    $rowMutationsFailedResponse[] = [
                        'rowKey' => $entries[$mutateRowsResponseEntry->getIndex()]->getRowKey(),
                        'statusCode' => $failureCode,
                        'message' => $message
                    ];
                }
            }
        }
        if (!empty($rowMutationsFailedResponse)) {
            throw new BigtableDataOperationException($message, $failureCode, $rowMutationsFailedResponse);
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

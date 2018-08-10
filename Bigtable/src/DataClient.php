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

use Google\Cloud\Bigtable\Exception\BigtableDataOperationException;
use Google\Cloud\Bigtable\V2\BigtableClient as TableClient;
use Google\Cloud\Bigtable\V2\MutateRowsRequest;
use Google\Cloud\Bigtable\V2\RowRange;
use Google\Cloud\Bigtable\V2\RowSet;
use Google\Rpc\Code;

/**
 * Represents a DataOperation Client to perform data operation on Bigtable table.
 * This is used to perform insert,update, delete operation on table in Bigtable.
 *
 * Example:
 * ```
 * use Google\Cloud\Bigtable\DataClient;
 *
 * $dataClient = new DataClient('my-project', 'my-instance', 'my-table');
 * ```
 *
 */
class DataClient
{

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
     * @var BigtableClient
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

    public function __construct($projectId, $instanceId, $tableId, array $config = [])
    {
        $this->projectId = $projectId;
        $this->instanceId = $instanceId;
        $this->tableId = $tableId;
        $this->options = [];
        if (isset($config['appProfile'])) {
            $this->options['appProfile'] = $config['appProfile'];
        }
        if (isset($config['headers'])) {
            $this->options['headers'] = $config['headers'];
        }
        if (isset($config['bigtableClient'])) {
            $this->bigtableClient = $config['bigtableClient'];
        } else {
            $this->bigtableClient = new TableClient();
        }
        $this->tableName = TableClient::tableName($projectId, $instanceId, $tableId);
    }

    /**
     * Mutates rows in a table.
     *
     * Example:
     * ```
     * use Google\Cloud\Bigtable\DataClient;
     * use Google\Cloud\Bigtable\RowMutation;
     *
     * $rowMutation = new RowMutation('r1');
     * $rowMutation->upsert('cf1','cq1','value1',5);
     *
     * $dataClient->mutateRows([$rowMutation]);
     * ```
     * @param array $rowMutations array of RowMutation object.
     * @return void
     * @throws ApiException|BigtableDataOperationException if the remote call fails or operation fails
     */
    public function mutateRows(array $rowMutations)
    {
        $entries = [];
        foreach ($rowMutations as $rowMutation) {
            $entries[] = $rowMutation->getEntry();
        }
        $responseStream = $this->bigtableClient->mutateRows($this->tableName, $entries, $this->options);
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
                        'rowKey' => $rowMutations[$mutateRowsResponseEntry->getIndex()],
                        'rowMutationIndex' => $mutateRowsResponseEntry->getIndex(),
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

    /**
     * Insert/update rows in a table.
     *
     * Example:
     * ```
     * use Google\Cloud\Bigtable\DataClient;
     *
     * $dataClient->upsert(['r1' => ['cf1' => ['cq1' => ['value'=>'value1', 'timeStamp' => 5]]]]);
     * ```
     * @param array[] $rows array of row.
     * @return void
     * @throws ApiException|BigtableDataOperationException if the remote call fails or operation fails
     */
    public function upsert(array $rows)
    {
        $rowMutations = [];
        foreach ($rows as $rowKey => $families) {
            $rowMutation = new RowMutation($rowKey);
            foreach ($families as $family => $qualifiers) {
                foreach ($qualifiers as $qualifier => $value) {
                    if (isset($value['timeStamp'])) {
                        $rowMutation->upsert(
                            $family,
                            $qualifier,
                            $value['value'],
                            $value['timeStamp']
                        );
                    } else {
                        $rowMutation->upsert($family, $qualifier, $value['value']);
                    }
                }
            }
            $rowMutations[] = $rowMutation;
        }
        $this->mutateRows($rowMutations);
    }
}

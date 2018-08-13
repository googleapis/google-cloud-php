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

namespace Google\Cloud\Bigtable\Tests\Unit;

use Google\ApiCore\ApiException;
use \Google\ApiCore\ServerStream;
use Google\Cloud\Bigtable\DataClient;
use Google\Cloud\Bigtable\Exception\BigtableDataOperationException;
use Google\Cloud\Bigtable\RowMutation;
use Google\Cloud\Bigtable\V2\BigtableClient as TableClient;
use Google\Cloud\Bigtable\V2\MutateRowsResponse;
use Google\Cloud\Bigtable\V2\MutateRowsResponse_Entry;
use Google\Rpc\Code;
use Google\Rpc\Status;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

/**
 * @group bigtable
 * @group bigtabledata
 */
class DataClientTest extends TestCase
{
    const PROJECT_ID = 'my-project';
    const INSTANCE_ID = 'my-instance';
    const TABLE_ID = 'my-table';
    const HEADER = 'my-header';
    const HEADER_VALUE = 'my-header-value';
    const APP_PROFILE = 'my-app-profile';
    const TABLE_NAME = 'projects/my-project/instances/my-instance/tables/my-table';
    const TIMESTAMP = 1534183334215000;

    private $bigtableClient;
    private $dataClient;
    private $rowMutations = [];
    private $entries = [];
    private $mutateRowsRequest;
    private $options;
    private $serverStream;

    public function setUp()
    {
        $this->bigtableClient = $this->prophesize(TableClient::class);
        $this->serverStream = $this->prophesize(ServerStream::class);
        $this->options = [
            'appProfileId' => self::APP_PROFILE,
            'headers' => [self::HEADER => self::HEADER_VALUE]
        ];
        $clientOptions = $this->options + [
            'bigtableClient' => $this->bigtableClient->reveal(),
            'projectId' => self::PROJECT_ID
        ];
        $this->dataClient = new DataClient(self::INSTANCE_ID, self::TABLE_ID, $clientOptions);
        $rowMutation = new RowMutation('rk1');
        $rowMutation->upsert('cf1', 'cq1', 'value1', self::TIMESTAMP);
        $this->entries[] = $rowMutation->getEntry();
        $this->rowMutations[] = $rowMutation;

        $rowMutation = new RowMutation('rk2');
        $rowMutation->upsert('cf2', 'cq2', 'value2', self::TIMESTAMP);
        $this->entries[] = $rowMutation->getEntry();
        $this->rowMutations[] = $rowMutation;
    }

    public function testMutateRows()
    {
        $statuses = [];
        foreach ($this->rowMutations as $rowMutation) {
            $status = new Status;
            $status->setCode(Code::OK);
            $statuses[] = $status;
        }
        $mutateRowsResponses = $this->getMutateRowsResponse($statuses);
        $this->serverStream->readAll()
            ->shouldBeCalled()
            ->willReturn(
                $this->arrayAsGenerator($mutateRowsResponses)
            );
        $this->bigtableClient->mutateRows(self::TABLE_NAME, $this->entries, $this->options)
            ->shouldBeCalled()
            ->willReturn(
                $this->serverStream->reveal()
            );
        $this->dataClient->mutateRows($this->rowMutations);
    }

    public function testMutateRowsFailure()
    {
        $statuses = [];
        $status = new Status;
        $status->setCode(Code::INVALID_ARGUMENT);
        $status->setMessage('Invalid argument');
        $statuses[] = $status;
        $status = new Status;
        $status->setCode(Code::OK);
        $statuses[] = $status;

        $mutateRowsResponses = $this->getMutateRowsResponse($statuses);
        $this->serverStream->readAll()
            ->shouldBeCalled()
            ->willReturn(
                $this->arrayAsGenerator($mutateRowsResponses)
            );
        $this->bigtableClient->mutateRows(self::TABLE_NAME, $this->entries, $this->options)
            ->shouldBeCalled()
            ->willReturn(
                $this->serverStream->reveal()
            );
        try {
            $this->dataClient->mutateRows($this->rowMutations);
            $this->fail('Expected exception is not thrown');
        } catch (BigtableDataOperationException $e) {
            $metadata = [
                [
                    'rowKey' => 'rk1',
                    'rowMutationIndex' => 0,
                    'statusCode' => Code::INVALID_ARGUMENT,
                    'message' => 'Invalid argument'
                ]
            ];
            $this->assertEquals('Invalid argument', $e->getMessage());
            $this->assertEquals(Code::INVALID_ARGUMENT, $e->getCode());
            $this->assertEquals(
                $metadata,
                $e->getMetadata()
            );
        }
    }

    /**
     * @expectedException Google\ApiCore\ApiException
     * @expectedExceptionMessage unauthenticated
     */
    public function testMutateRowsApiExceptionInMutateRows()
    {
        $apiException =  new ApiException('unauthenticated', Code::UNAUTHENTICATED, 'unauthenticated');
        $this->bigtableClient->mutateRows(self::TABLE_NAME, $this->entries, $this->options)
            ->shouldBeCalled()
            ->willThrow(
                $apiException
            );
        $this->dataClient->mutateRows($this->rowMutations);
    }

    /**
     * @expectedException Google\ApiCore\ApiException
     * @expectedExceptionMessage unauthenticated
     */
    public function testMutateRowsApiExceptionInReadAll()
    {
        $apiException =  new ApiException('unauthenticated', Code::UNAUTHENTICATED, 'unauthenticated');
        $this->serverStream->readAll()
            ->shouldBeCalled()
            ->willThrow(
                $apiException
            );
        $this->bigtableClient->mutateRows(self::TABLE_NAME, $this->entries, $this->options)
            ->shouldBeCalled()
            ->willReturn(
                $this->serverStream->reveal()
            );
        $this->dataClient->mutateRows($this->rowMutations);
    }

    public function testUpsert()
    {
        $statuses = [];
        foreach ($this->rowMutations as $rowMutation) {
            $status = new Status;
            $status->setCode(Code::OK);
            $statuses[] = $status;
        }
        $mutateRowsResponses = $this->getMutateRowsResponse($statuses);
        $this->serverStream->readAll()
            ->shouldBeCalled()
            ->willReturn(
                $this->arrayAsGenerator($mutateRowsResponses)
            );
        $this->bigtableClient->mutateRows(self::TABLE_NAME, $this->entries, $this->options)
            ->shouldBeCalled()
            ->willReturn(
                $this->serverStream->reveal()
            );
        $rows = [
            'rk1' => [
                'cf1' => [
                    'cq1' => [
                        'value' => 'value1',
                        'timeStamp' => self::TIMESTAMP
                    ]
                ]
            ],
            'rk2' => [
                'cf2' => [
                    'cq2' => [
                        'value' => 'value2',
                        'timeStamp' => self::TIMESTAMP
                    ]
                ]
            ]
        ];
        $this->dataClient->upsert($rows);
    }

    private function getMutateRowsResponse(array $status)
    {
        $mutateRowsResponses = [];
        $entryIndex = 0;
        foreach ($status as $value) {
            $mutateRowsResponse = new MutateRowsResponse;
            $mutateRowsResponseEntry = new MutateRowsResponse_Entry;
            $mutateRowsResponseEntry->setStatus($value);
            $mutateRowsResponseEntry->setIndex($entryIndex++);
            $mutateRowsResponse->setEntries([$mutateRowsResponseEntry]);
            $mutateRowsResponses[] = $mutateRowsResponse;
        }
        return $mutateRowsResponses;
    }
    private function arrayAsGenerator(array $array)
    {
        foreach ($array as $item) {
            yield $item;
        }
    }
}

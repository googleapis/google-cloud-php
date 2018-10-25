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
use Google\ApiCore\ServerStream;
use Google\Cloud\Bigtable\ChunkFormatter;
use Google\Cloud\Bigtable\DataClient;
use Google\Cloud\Bigtable\Exception\BigtableDataOperationException;
use Google\Cloud\Bigtable\Filter;
use Google\Cloud\Bigtable\Mutations;
use Google\Cloud\Bigtable\ReadModifyWriteRowRules;
use Google\Cloud\Bigtable\RowMutation;
use Google\Cloud\Bigtable\V2\BigtableClient as TableClient;
use Google\Cloud\Bigtable\V2\Cell;
use Google\Cloud\Bigtable\V2\CheckAndMutateRowResponse;
use Google\Cloud\Bigtable\V2\Column;
use Google\Cloud\Bigtable\V2\Family;
use Google\Cloud\Bigtable\V2\MutateRowsRequest\Entry as RequestEntry;
use Google\Cloud\Bigtable\V2\MutateRowsResponse;
use Google\Cloud\Bigtable\V2\MutateRowsResponse\Entry as ResponseEntry;
use Google\Cloud\Bigtable\V2\ReadModifyWriteRowResponse;
use Google\Cloud\Bigtable\V2\Row;
use Google\Cloud\Bigtable\V2\RowRange;
use Google\Cloud\Bigtable\V2\RowSet;
use Google\Cloud\Bigtable\V2\SampleRowKeysResponse;
use Google\Rpc\Code;
use Google\Rpc\Status;
use PHPUnit\Framework\TestCase;

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
        $mutations = (new Mutations)
            ->upsert('cf1', 'cq1', 'value1', self::TIMESTAMP);
        $this->entries[] = (new RequestEntry)
            ->setRowKey('rk1')
            ->setMutations($mutations->toProto());
        $this->rowMutations['rk1'] = $mutations;

        $mutations = (new Mutations)
            ->upsert('cf2', 'cq2', 'value2', self::TIMESTAMP);
        $this->entries[] = (new RequestEntry)
            ->setRowkey('rk2')
            ->setMutations($mutations->toProto());
        $this->rowMutations['rk2'] = $mutations;
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Expected rowMutations to be of type associative array, instead got list.
     */
    public function testMutateRowsThrowsExceptionWhenRowMutationsIsList()
    {
        $this->dataClient->mutateRows([1,2,3,4]);
    }

    public function testMutateRows()
    {
        $statuses = [];
        for ($i=0; $i<count($this->entries); $i++) {
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

    public function testMutateRowsOptionalConfiguration()
    {
        $this->serverStream->readAll()
            ->shouldBeCalled()
            ->willReturn(
                $this->arrayAsGenerator([])
            );
        $options = [
            'key1' => 'value1'
        ];
        $this->bigtableClient->mutateRows(self::TABLE_NAME, $this->entries, $this->options + $options)
            ->shouldBeCalled()
            ->willReturn(
                $this->serverStream->reveal()
            );
        $this->dataClient->mutateRows($this->rowMutations, $options);
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
     * @expectedException \Google\ApiCore\ApiException
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
     * @expectedException \Google\ApiCore\ApiException
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
        for ($i=0; $i<count($this->entries); $i++) {
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

    public function testUpsertOptionalConfiguration()
    {
        $this->serverStream->readAll()
            ->shouldBeCalled()
            ->willReturn(
                $this->arrayAsGenerator([])
            );
        $options = [
            'key1' => 'value1'
        ];
        $this->bigtableClient->mutateRows(self::TABLE_NAME, $this->entries, $this->options + $options)
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
        $this->dataClient->upsert($rows, $options);
    }

    public function testReadRowsNoArg()
    {
        $expectedArgs = $this->options;
        $this->bigtableClient->readRows(self::TABLE_NAME, $expectedArgs)
            ->shouldBeCalled()
            ->willReturn(
                $this->serverStream->reveal()
            );
        $args = [];
        $iterator = $this->dataClient->readRows($args);
        $this->assertInstanceOf(ChunkFormatter::class, $iterator);
    }

    public function testReadRow()
    {
        $rowSet = new RowSet();
        $rowSet->setRowKeys(['rk1']);
        $expectedArgs = $this->options + [
            'rows' => $rowSet
        ];
        $this->serverStream->readAll()
            ->shouldBeCalled()
            ->willReturn(
                $this->arrayAsGenerator([])
            );
        $this->bigtableClient->readRows(self::TABLE_NAME, $expectedArgs)
            ->shouldBeCalled()
            ->willReturn(
                $this->serverStream->reveal()
            );
        $row = $this->dataClient->readRow('rk1');
        $this->assertNull($row);
    }

    public function testReadRowsWithMultipleRowKeys()
    {
        $rowSet = new RowSet();
        $rowSet->setRowKeys(['rk1', 'rk2']);
        $expectedArgs = $this->options + [
            'rows' => $rowSet
        ];
        $this->bigtableClient->readRows(self::TABLE_NAME, $expectedArgs)
            ->shouldBeCalled()
            ->willReturn(
                $this->serverStream->reveal()
            );
        $args = [
            'rowKeys' => ['rk1', 'rk2']
        ];
        $iterator = $this->dataClient->readRows($args);
        $this->assertInstanceOf(ChunkFormatter::class, $iterator);
    }

    public function testReadRowsWithRowLimit()
    {
        $rowSet = new RowSet();
        $rowSet->setRowKeys(['rk1', 'rk2']);
        $expectedArgs = $this->options + [
            'rows' => $rowSet,
            'rowsLimit' => 10
        ];
        $this->bigtableClient->readRows(self::TABLE_NAME, $expectedArgs)
            ->shouldBeCalled()
            ->willReturn(
                $this->serverStream->reveal()
            );
        $args = [
            'rowKeys' => ['rk1', 'rk2'],
            'rowsLimit' => 10
        ];
        $iterator = $this->dataClient->readRows($args);
        $this->assertInstanceOf(ChunkFormatter::class, $iterator);
    }

    public function testReadRowsWithRowRangeKeysOpen()
    {
        $rowSet = new RowSet();
        $rowRange = new RowRange();
        $rowRange->setStartKeyOpen('so1');
        $rowRange->setEndKeyOpen('eo1');
        $rowSet->setRowRanges([$rowRange]);
        $expectedArgs = $this->options + [
            'rows' => $rowSet
        ];
        $this->bigtableClient->readRows(self::TABLE_NAME, $expectedArgs)
            ->shouldBeCalled()
            ->willReturn(
                $this->serverStream->reveal()
            );
        $args = [
            'rowRanges' =>[
                [
                    'startKeyOpen' => 'so1',
                    'endKeyOpen' => 'eo1'
                ]
            ]
        ];
        $iterator = $this->dataClient->readRows($args);
        $this->assertInstanceOf(ChunkFormatter::class, $iterator);
    }

    public function testReadRowsWithRowRangeKeysClosed()
    {
        $rowSet = new RowSet();
        $rowRange = new RowRange();
        $rowRange->setStartKeyClosed('sc1');
        $rowRange->setEndKeyClosed('ec1');
        $rowSet->setRowRanges([$rowRange]);
        $expectedArgs = $this->options + [
            'rows' => $rowSet
        ];
        $this->bigtableClient->readRows(self::TABLE_NAME, $expectedArgs)
            ->shouldBeCalled()
            ->willReturn(
                $this->serverStream->reveal()
            );
        $args = [
            'rowRanges' =>[
                [
                    'startKeyClosed' => 'sc1',
                    'endKeyClosed' => 'ec1'
                ]
            ]
        ];
        $iterator = $this->dataClient->readRows($args);
        $this->assertInstanceOf(ChunkFormatter::class, $iterator);
    }

    public function testReadRowsWithRowRangeKeysOpenClosed()
    {
        $rowSet = new RowSet();
        $rowRange = new RowRange();
        $rowRange->setStartKeyOpen('so1');
        $rowRange->setEndKeyClosed('ec1');
        $rowSet->setRowRanges([$rowRange]);
        $expectedArgs = $this->options + [
            'rows' => $rowSet
        ];
        $this->bigtableClient->readRows(self::TABLE_NAME, $expectedArgs)
            ->shouldBeCalled()
            ->willReturn(
                $this->serverStream->reveal()
            );
        $args = [
            'rowRanges' =>[
                [
                    'startKeyOpen' => 'so1',
                    'endKeyClosed' => 'ec1'
                ]
            ]
        ];
        $iterator = $this->dataClient->readRows($args);
        $this->assertInstanceOf(ChunkFormatter::class, $iterator);
    }

    public function testReadRowsWithRowRangeKeysClosedOpen()
    {
        $rowSet = new RowSet();
        $rowRange = new RowRange();
        $rowRange->setStartKeyClosed('sc1');
        $rowRange->setEndKeyOpen('eo1');
        $rowSet->setRowRanges([$rowRange]);
        $expectedArgs = $this->options + [
            'rows' => $rowSet
        ];
        $this->bigtableClient->readRows(self::TABLE_NAME, $expectedArgs)
            ->shouldBeCalled()
            ->willReturn(
                $this->serverStream->reveal()
            );
        $args = [
            'rowRanges' =>[
                [
                    'startKeyClosed' => 'sc1',
                    'endKeyOpen' => 'eo1'
                ]
            ]
        ];
        $iterator = $this->dataClient->readRows($args);
        $this->assertInstanceOf(ChunkFormatter::class, $iterator);
    }

    public function testReadRowsWithRowRangeKeysMultipleRowRanges()
    {
        $rowSet = new RowSet();
        $rowRange = new RowRange();
        $rowRange->setStartKeyClosed('sc1');
        $rowRange->setEndKeyOpen('eo1');
        $rowRanges[] = $rowRange;
        $rowRange = new RowRange();
        $rowRange->setStartKeyClosed('sc2');
        $rowRange->setEndKeyOpen('eo2');
        $rowRanges[] = $rowRange;
        $rowSet->setRowRanges($rowRanges);
        $expectedArgs = $this->options + [
            'rows' => $rowSet
        ];
        $this->bigtableClient->readRows(self::TABLE_NAME, $expectedArgs)
            ->shouldBeCalled()
            ->willReturn(
                $this->serverStream->reveal()
            );
        $args = [
            'rowRanges' =>[
                [
                    'startKeyClosed' => 'sc1',
                    'endKeyOpen' => 'eo1'
                ],
                [
                    'startKeyClosed' => 'sc2',
                    'endKeyOpen' => 'eo2'
                ]
            ]
        ];
        $iterator = $this->dataClient->readRows($args);
        $this->assertInstanceOf(ChunkFormatter::class, $iterator);
    }

    public function testReadRowsWithKeyAndRanges()
    {
        $rowSet = new RowSet();
        $rowRange = new RowRange();
        $rowSet->setRowKeys(['rk1']);
        $rowRange->setStartKeyClosed('sc1');
        $rowRange->setEndKeyOpen('eo1');
        $rowSet->setRowRanges([$rowRange]);
        $expectedArgs = $this->options + [
            'rows' => $rowSet
        ];
        $this->bigtableClient->readRows(self::TABLE_NAME, $expectedArgs)
            ->shouldBeCalled()
            ->willReturn(
                $this->serverStream->reveal()
            );
        $args = [
            'rowKeys' => ['rk1'],
            'rowRanges' => [
                [
                    'startKeyClosed' => 'sc1',
                    'endKeyOpen' => 'eo1'
                ]
            ]
        ];
        $iterator = $this->dataClient->readRows($args);
        $this->assertInstanceOf(ChunkFormatter::class, $iterator);
    }

    public function testReadRowsWithFilter()
    {
        $rowFilter = Filter::pass();
        $expectedArgs = $this->options + [
            'filter' => $rowFilter->toProto()
        ];
        $this->bigtableClient->readRows(self::TABLE_NAME, $expectedArgs)
            ->shouldBeCalled()
            ->willReturn(
                $this->serverStream->reveal()
            );
        $args = [
            'filter' => $rowFilter
        ];
        $iterator = $this->dataClient->readRows($args);
        $this->assertInstanceOf(ChunkFormatter::class, $iterator);
    }

    public function testReadModifyWriteRowAppend()
    {
        $readModifyWriteRowResponse = (new ReadModifyWriteRowResponse)
            ->setRow(
                (new Row)
                    ->setFamilies([
                        (new Family)
                            ->setName('cf1')
                            ->setColumns([
                                (new Column)
                                    ->setQualifier('cq1')
                                    ->setCells([
                                        (new Cell)
                                            ->setValue('value1')
                                            ->setTimestampMicros(5000)
                                    ])
                            ])
                    ])
            );
        $readModifyWriteRowRules = (new ReadModifyWriteRowRules)
            ->append('cf1', 'cq1', 'v1');
        $this->bigtableClient
            ->readModifyWriteRow(
                self::TABLE_NAME,
                'rk1',
                $readModifyWriteRowRules->toProto(),
                $this->options
            )
            ->shouldBeCalled()
            ->willReturn(
                $readModifyWriteRowResponse
            );
        $row = $this->dataClient->readModifyWriteRow('rk1', $readModifyWriteRowRules);
        $expectedRow = [
            'cf1' => [
                'cq1' => [[
                    'value' => 'value1',
                    'timeStamp' => 5000,
                    'labels' => ''
                ]]
            ]
        ];
        $this->assertEquals($expectedRow, $row);
    }

    /**
     * @requires PHP 5.6.0
     */
    public function testReadModifyWriteRowIncrement()
    {
        $readModifyWriteRowResponse = (new ReadModifyWriteRowResponse)
            ->setRow(
                (new Row)
                    ->setFamilies([
                        (new Family)
                            ->setName('cf1')
                            ->setColumns([
                                (new Column)
                                    ->setQualifier('cq1')
                                    ->setCells([
                                        (new Cell)
                                            ->setValue(10)
                                            ->setTimestampMicros(5000)
                                    ])
                            ])
                    ])
            );
        $readModifyWriteRowRules = (new ReadModifyWriteRowRules)
            ->increment('cf1', 'cq1', 5);
        $this->bigtableClient
            ->readModifyWriteRow(
                self::TABLE_NAME,
                'rk1',
                $readModifyWriteRowRules->toProto(),
                $this->options
            )
            ->shouldBeCalled()
            ->willReturn(
                $readModifyWriteRowResponse
            );
        $row = $this->dataClient->readModifyWriteRow('rk1', $readModifyWriteRowRules);
        $expectedRow = [
            'cf1' => [
                'cq1' => [[
                    'value' => 10,
                    'timeStamp' => 5000,
                    'labels' => ''
                ]]
            ]
        ];
        $this->assertEquals($expectedRow, $row);
    }

    public function testSampleRowKeys()
    {
        $sampleRowKeyResponses[] = (new SampleRowKeysResponse)
            ->setRowKey('rk1')
            ->setOffsetBytes(1);
        $sampleRowKeyResponses[] = (new SampleRowKeysResponse)
            ->setRowKey('rk2')
            ->setOffsetBytes(2);

        $this->serverStream->readAll()
            ->shouldBeCalled()
            ->willReturn(
                $this->arrayAsGenerator($sampleRowKeyResponses)
            );
        $this->bigtableClient->sampleRowKeys(self::TABLE_NAME, $this->options)
            ->shouldBeCalled()
            ->willReturn(
                $this->serverStream->reveal()
            );
        $rowKeyStream = $this->dataClient->sampleRowKeys();
        $rowKeys = iterator_to_array($rowKeyStream);
        $expectedRowKeys = [
            [
                'rowKey' => 'rk1',
                'offset' => 1
            ],
            [
                'rowKey' => 'rk2',
                'offset' => 2
            ]
        ];
        $this->assertEquals($expectedRowKeys, $rowKeys);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage checkAndMutateRow must have either trueMutations or falseMutations.
     */
    public function testCheckAndMutateRowShouldThrowWhenNoTrueOrFalseMutations()
    {
        $this->dataClient->checkAndMutateRow('rk1');
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage FilterInterface
     */
    public function testCheckAndMutateRowShouldThrowWhenPredicateFilterIsNotFilter()
    {
        $this->dataClient->checkAndMutateRow('rk1', ['predicateFilter' => new \stdClass()]);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Mutations
     */
    public function testCheckAndMutateRowShouldThrowWhenTrueMutationsNotMutations()
    {
        $this->dataClient->checkAndMutateRow('rk1', ['trueMutations' => new \stdClass()]);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Mutations
     */
    public function testCheckAndMutateRowShouldThrowWhenFalseMutationsNotMutations()
    {
        $this->dataClient->checkAndMutateRow('rk1', ['falseMutations' => new \stdClass()]);
    }

    public function testCheckAndMutateRowWithTrueMutations()
    {
        $mutations = (new Mutations)->upsert('family', 'qualifier', 'value');
        $expectedArgs = $this->options + [
            'trueMutations' => $mutations->toProto()
        ];
        $rowKey = 'rk1';
        $this->bigtableClient->checkAndMutateRow(self::TABLE_NAME, $rowKey, $expectedArgs)
            ->shouldBeCalled()
            ->willReturn(
                (new CheckAndMutateRowResponse)->setPredicateMatched(true)
            );
        $result = $this->dataClient->checkAndMutateRow($rowKey, ['trueMutations' => $mutations]);
        $this->assertTrue($result);
    }

    public function testCheckAndMutateRowWithFalseMutations()
    {
        $mutations = (new Mutations)->upsert('family', 'qualifier', 'value');
        $expectedArgs = $this->options + [
            'falseMutations' => $mutations->toProto()
        ];
        $rowKey = 'rk1';
        $this->bigtableClient->checkAndMutateRow(self::TABLE_NAME, $rowKey, $expectedArgs)
            ->shouldBeCalled()
            ->willReturn(
                (new CheckAndMutateRowResponse)->setPredicateMatched(false)
            );
        $result = $this->dataClient->checkAndMutateRow($rowKey, ['falseMutations' => $mutations]);
        $this->assertFalse($result);
    }

    public function testCheckAndMutateRowWithPredicateFilter()
    {
        $mutations = (new Mutations)->upsert('family', 'qualifier', 'value');
        $predicateFilter = Filter::family()->exactMatch('cf1');
        $expectedArgs = $this->options + [
            'predicateFilter' => $predicateFilter->toProto(),
            'trueMutations' => $mutations->toProto()
        ];
        $rowKey = 'rk1';
        $this->bigtableClient->checkAndMutateRow(self::TABLE_NAME, $rowKey, $expectedArgs)
            ->shouldBeCalled()
            ->willReturn(
                (new CheckAndMutateRowResponse)->setPredicateMatched(false)
            );
        $result = $this->dataClient->checkAndMutateRow(
            $rowKey,
            [
                'predicateFilter' => $predicateFilter,
                'trueMutations' => $mutations
            ]
        );
        $this->assertFalse($result);
    }

    private function getMutateRowsResponse(array $status)
    {
        $mutateRowsResponses = [];
        $entryIndex = 0;
        foreach ($status as $value) {
            $mutateRowsResponse = new MutateRowsResponse;
            $mutateRowsResponseEntry = new ResponseEntry;
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

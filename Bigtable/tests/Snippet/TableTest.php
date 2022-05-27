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

namespace Google\Cloud\Bigtable\Tests\Snippet;

use Google\ApiCore\ServerStream;
use Google\Cloud\Bigtable\DataUtil;
use Google\Cloud\Bigtable\Mutations;
use Google\Cloud\Bigtable\ReadModifyWriteRowRules;
use Google\Cloud\Bigtable\Table;
use Google\Cloud\Bigtable\V2\BigtableClient as TableClient;
use Google\Cloud\Bigtable\V2\Cell;
use Google\Cloud\Bigtable\V2\CheckAndMutateRowResponse;
use Google\Cloud\Bigtable\V2\Column;
use Google\Cloud\Bigtable\V2\Family;
use Google\Cloud\Bigtable\V2\MutateRowResponse;
use Google\Cloud\Bigtable\V2\MutateRowsRequest\Entry as MutateRowsRequest_Entry;
use Google\Cloud\Bigtable\V2\MutateRowsResponse;
use Google\Cloud\Bigtable\V2\MutateRowsResponse\Entry as MutateRowsResponse_Entry;
use Google\Cloud\Bigtable\V2\Mutation;
use Google\Cloud\Bigtable\V2\Mutation\SetCell;
use Google\Cloud\Bigtable\V2\ReadModifyWriteRowResponse;
use Google\Cloud\Bigtable\V2\ReadRowsResponse;
use Google\Cloud\Bigtable\V2\ReadRowsResponse_CellChunk as ReadRowsResponse_CellChunk;
use Google\Cloud\Bigtable\V2\Row;
use Google\Cloud\Bigtable\V2\RowRange;
use Google\Cloud\Bigtable\V2\RowSet;
use Google\Cloud\Bigtable\V2\SampleRowKeysResponse;
use Google\Cloud\Core\Testing\Snippet\SnippetTestCase;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Protobuf\StringValue;
use Google\Protobuf\BytesValue;
use Google\Rpc\Code;
use Google\Rpc\Status;
use Prophecy\Argument;

/**
 * @group bigtable
 * @group bigtabledata
 */
class TableTest extends SnippetTestCase
{
    const TABLE_NAME = 'projects/my-project/instances/my-instance/tables/my-table';

    private $bigtableClient;
    private $table;
    private $mutateRowsResponses = [];
    private $serverStream;
    private $entries = [];

    public function set_up()
    {
        $this->bigtableClient = $this->prophesize(TableClient::class);
        $this->serverStream = $this->prophesize(ServerStream::class);

        $mutateRowsRequestEntry = new MutateRowsRequest_Entry;
        $mutation = new Mutation;
        $mutationSetCell = new SetCell;
        $mutationSetCell->setFamilyName('cf1')
            ->setColumnQualifier('cq1')
            ->setValue('value1')
            ->setTimestampMicros(1534183334215000);
        $mutation->setSetCell($mutationSetCell);
        $mutateRowsRequestEntry->setRowKey('r1');
        $mutateRowsRequestEntry->setMutations([$mutation]);
        $this->entries[] = $mutateRowsRequestEntry;
        $mutateRowsResponse = new MutateRowsResponse;
        $mutateRowsResponseEntry = new MutateRowsResponse_Entry;
        $status = new Status;
        $status->setCode(Code::OK);
        $mutateRowsResponseEntry->setIndex(0);
        $mutateRowsResponseEntry->setStatus($status);
        $mutateRowsResponse->setEntries([$mutateRowsResponseEntry]);
        $this->mutateRowsResponses[] = $mutateRowsResponse;
        $this->table = TestHelpers::stub(
            Table::class,
            [
                $this->bigtableClient->reveal(),
                self::TABLE_NAME
            ]
        );
    }

    public function testClass()
    {
        $snippet = $this->snippetFromClass(Table::class);
        $snippet->replace(
            '$bigtable = new BigtableClient();',
            '$bigtable = new BigtableClient(["projectId" => "my-project"]);'
        );
        $res = $snippet->invoke('table');

        $this->assertInstanceOf(Table::class, $res->returnVal());
    }

    public function testMutateRows()
    {
        $this->serverStream->readAll()
            ->shouldBeCalled()
            ->willReturn(
                $this->arrayAsGenerator($this->mutateRowsResponses)
            );
        $this->bigtableClient->mutateRows(self::TABLE_NAME, $this->entries, [])
            ->shouldBeCalled()
            ->willReturn(
                $this->serverStream->reveal()
            );
        $snippet = $this->snippetFromMethod(Table::class, 'mutateRows');
        $snippet->addLocal('table', $this->table);
        $snippet->invoke();
    }

    public function testMutateRow()
    {
        $mutations = (new Mutations)
            ->upsert('cf1', 'cq1', 'value1', 1534183334215000);
        $this->bigtableClient->mutateRow(self::TABLE_NAME, 'r1', $mutations->toProto(), [])
            ->shouldBeCalled()
            ->willReturn(
                new MutateRowResponse
            );
        $snippet = $this->snippetFromMethod(Table::class, 'mutateRow');
        $snippet->addLocal('table', $this->table);
        $snippet->invoke();
    }

    public function testUpsert()
    {
        $this->serverStream->readAll()
            ->shouldBeCalled()
            ->willReturn(
                $this->arrayAsGenerator($this->mutateRowsResponses)
            );
        $this->bigtableClient->mutateRows(self::TABLE_NAME, $this->entries, [])
            ->shouldBeCalled()
            ->willReturn(
                $this->serverStream->reveal()
            );
        $snippet = $this->snippetFromMethod(Table::class, 'upsert');
        $snippet->addLocal('table', $this->table);
        $snippet->invoke();
    }

    public function testReadRows()
    {
        $this->serverStream->readAll()
            ->shouldBeCalled()
            ->willReturn(
                $this->arrayAsGenerator([$this->setUpReadRowsResponse()])
            );
        $this->bigtableClient->readRows(self::TABLE_NAME, [])
            ->shouldBeCalled()
            ->willReturn(
                $this->serverStream->reveal()
            );
        $snippet = $this->snippetFromMethod(Table::class, 'readRows');
        $snippet->addLocal('table', $this->table);
        $res = $snippet->invoke('rows');
        $expectedRows = [
            'cf1' => [
                'cq1' => [[
                    'value' => 'value1',
                    'labels' => '',
                    'timeStamp' => 0
                ]]
            ]
        ];
        $this->assertEquals(
            'rk1: ' . print_r($expectedRows, true) . PHP_EOL,
            $res->output()
        );
    }

    public function testReadRowsWithRowRanges()
    {
        $this->serverStream->readAll()
            ->shouldBeCalled()
            ->willReturn(
                $this->arrayAsGenerator([$this->setUpReadRowsResponse()])
            );
        $rowRange = (new RowRange)
            ->setStartKeyOpen('jefferson')
            ->setEndKeyOpen('lincoln');
        $rowSet = (new RowSet())
            ->setRowRanges([$rowRange]);
        $this->bigtableClient->readRows(self::TABLE_NAME, ['rows' => $rowSet])
            ->shouldBeCalled()
            ->willReturn($this->serverStream->reveal());

        $snippet = $this->snippetFromMethod(Table::class, 'readRows', 1);
        $snippet->addLocal('table', $this->table);
        $res = $snippet->invoke('rows');
        $expectedRows = [
            'cf1' => [
                'cq1' => [[
                    'value' => 'value1',
                    'labels' => '',
                    'timeStamp' => 0
                ]]
            ]
        ];
        $this->assertEquals(
            'rk1: ' . print_r($expectedRows, true) . PHP_EOL,
            $res->output()
        );
    }

    public function testReadRow()
    {
        $this->serverStream->readAll()
            ->shouldBeCalled()
            ->willReturn(
                $this->arrayAsGenerator([$this->setUpReadRowsResponse()])
            );
        $rowSet = (new RowSet())
            ->setRowKeys(['jefferson']);
        $this->bigtableClient->readRows(self::TABLE_NAME, ['rows' => $rowSet])
            ->shouldBeCalled()
            ->willReturn($this->serverStream->reveal());
        $snippet = $this->snippetFromMethod(Table::class, 'readRow');
        $snippet->addLocal('table', $this->table);
        $res = $snippet->invoke('row');
        $expectedRow = [
            'cf1' => [
                'cq1' => [[
                    'value' => 'value1',
                    'labels' => '',
                    'timeStamp' => 0
                ]]
            ]
        ];
        $this->assertEquals(
            print_r($expectedRow, true),
            $res->output()
        );
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
            ->append('cf1', 'cq1', 'value12');
        $this->bigtableClient
            ->readModifyWriteRow(
                self::TABLE_NAME,
                'rk1',
                $readModifyWriteRowRules->toProto(),
                []
            )
            ->shouldBeCalled()
            ->willReturn(
                $readModifyWriteRowResponse
            );
            $snippet = $this->snippetFromMethod(Table::class, 'readModifyWriteRow');
            $snippet->addLocal('table', $this->table);
            $res = $snippet->invoke('row');
            $expectedRow = [
                'cf1' => [
                    'cq1' => [[
                        'value' => 'value1',
                        'timeStamp' => 5000,
                        'labels' => ''
                    ]]
                ]
            ];
            $this->assertEquals(
                print_r($expectedRow, true),
                $res->output()
            );
    }

    public function testReadModifyWriteRowIncrement()
    {
        $snippet = $this->snippetFromMethod(Table::class, 'readModifyWriteRow', 1);

        if (!DataUtil::isSupported()) {
            $this->markTestSkipped('This test only runs on PHP 5.6 or above.');
            return;
        }

        $this->serverStream->readAll()
            ->shouldBeCalled()
            ->willReturn(
                $this->arrayAsGenerator($this->mutateRowsResponses)
            );
        $this->bigtableClient->mutateRows(self::TABLE_NAME, Argument::any(), [])
            ->shouldBeCalled()
            ->willReturn(
                $this->serverStream->reveal()
            );
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
                                            ->setValue(5)
                                            ->setTimestampMicros(5000)
                                    ])
                            ])
                    ])
            );
        $readModifyWriteRowRules = (new ReadModifyWriteRowRules)
            ->increment('cf1', 'cq1', 3);
        $this->bigtableClient
            ->readModifyWriteRow(
                self::TABLE_NAME,
                'rk1',
                $readModifyWriteRowRules->toProto(),
                []
            )
            ->shouldBeCalled()
            ->willReturn(
                $readModifyWriteRowResponse
            );
            $snippet->addLocal('table', $this->table);
            $res = $snippet->invoke('row');
            $expectedRow = [
                'cf1' => [
                    'cq1' => [[
                        'value' => 5,
                        'timeStamp' => 5000,
                        'labels' => ''
                    ]]
                ]
            ];
            $this->assertEquals(
                print_r($expectedRow, true),
                $res->output()
            );
    }

    public function testSampleRowKeys()
    {
        $sampleRowKeyResponses[] = (new SampleRowKeysResponse)
            ->setRowKey('rk1')
            ->setOffsetBytes(1);

        $this->serverStream->readAll()
            ->shouldBeCalled()
            ->willReturn(
                $this->arrayAsGenerator($sampleRowKeyResponses)
            );
        $this->bigtableClient->sampleRowKeys(self::TABLE_NAME, [])
            ->shouldBeCalled()
            ->willReturn(
                $this->serverStream->reveal()
            );
        $snippet = $this->snippetFromMethod(Table::class, 'sampleRowKeys');
        $snippet->addLocal('table', $this->table);
        $res = $snippet->invoke('rowKeyStream');
        $expectedRowKeys = [
            'rowKey' => 'rk1',
            'offset' => 1
        ];
        $this->assertEquals(
            print_r($expectedRowKeys, true),
            $res->output()
        );
    }

    public function testCheckAndMutateRow()
    {
        $this->bigtableClient->checkAndMutateRow(self::TABLE_NAME, 'rk1', Argument::any())
            ->shouldBeCalled()
            ->willReturn((new CheckAndMutateRowResponse)->setPredicateMatched(true));
        $snippet = $this->snippetFromMethod(Table::class, 'checkAndMutateRow');
        $snippet->addLocal('table', $this->table);
        $res = $snippet->invoke('result');
        $this->assertTrue($res->returnVal());
    }

    public function testCheckAndMutateRowWithFilter()
    {
        $this->bigtableClient
            ->checkAndMutateRow(
                self::TABLE_NAME,
                'rk1',
                Argument::any()
            )
            ->shouldBeCalled()
            ->willReturn((new CheckAndMutateRowResponse)->setPredicateMatched(true));
        $snippet = $this->snippetFromMethod(Table::class, 'checkAndMutateRow', 1);
        $snippet->addLocal('table', $this->table);
        $res = $snippet->invoke('result');
        $this->assertTrue($res->returnVal());
    }

    private function setUpReadRowsResponse()
    {
        $readRowsResponse = new ReadRowsResponse;
        $chunks = [];
        $chunk = new ReadRowsResponse_CellChunk();
        $chunk->setRowKey('rk1');
        $stringValue = new StringValue();
        $stringValue->setValue('cf1');
        $bytesValue = new BytesValue();
        $bytesValue->setValue('cq1');
        $chunk->setFamilyName($stringValue);
        $chunk->setQualifier($bytesValue);
        $chunk->setValue('value1');
        $chunk->setCommitRow(true);
        $chunks[] = $chunk;
        $readRowsResponse->setChunks($chunks);

        return $readRowsResponse;
    }

    private function arrayAsGenerator(array $array)
    {
        foreach ($array as $item) {
            yield $item;
        }
    }
}

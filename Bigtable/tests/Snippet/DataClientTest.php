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
use Google\Cloud\Bigtable\DataClient;
use Google\Cloud\Bigtable\V2\BigtableClient as TableClient;
use Google\Cloud\Bigtable\V2\MutateRowsRequest\Entry as MutateRowsRequest_Entry;
use Google\Cloud\Bigtable\V2\MutateRowsResponse;
use Google\Cloud\Bigtable\V2\MutateRowsResponse\Entry as MutateRowsResponse_Entry;
use Google\Cloud\Bigtable\V2\Mutation;
use Google\Cloud\Bigtable\V2\Mutation\SetCell;
use Google\Cloud\Bigtable\V2\ReadRowsResponse;
use Google\Cloud\Bigtable\V2\ReadRowsResponse_CellChunk as ReadRowsResponse_CellChunk;
use Google\Cloud\Bigtable\V2\RowRange;
use Google\Cloud\Bigtable\V2\RowSet;
use Google\Cloud\Core\Testing\Snippet\SnippetTestCase;
use Google\Cloud\Core\Testing\TestHelpers;
use Google\Protobuf\StringValue;
use Google\Protobuf\BytesValue;
use Google\Rpc\Code;
use Google\Rpc\Status;

/**
 * @group bigtable
 * @group bigtabledata
 */
class DataClientTest extends SnippetTestCase
{
    const PROJECT_ID = 'my-project';
    const INSTANCE_ID = 'my-instance';
    const TABLE_ID = 'my-table';
    const TABLE_NAME = 'projects/my-project/instances/my-instance/tables/my-table';

    private $bigtableClient;
    private $dataClient;
    private $mutateRowsResponses = [];
    private $serverStream;
    private $entries = [];

    public function setUp()
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
        $this->dataClient = TestHelpers::stub(
            DataClient::class,
            [
                self::INSTANCE_ID,
                self::TABLE_ID,
                [
                    'bigtableClient' => $this->bigtableClient->reveal(),
                    'projectId' => self::PROJECT_ID
                ]
            ]
        );
    }

    public function testClass()
    {
        $snippet = $this->snippetFromClass(DataClient::class);
        $res = $snippet->invoke('dataClient');

        $this->assertInstanceOf(DataClient::class, $res->returnVal());
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
        $snippet = $this->snippetFromMethod(DataClient::class, 'mutateRows');
        $snippet->addLocal('dataClient', $this->dataClient);
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
        $snippet = $this->snippetFromMethod(DataClient::class, 'upsert');
        $snippet->addLocal('dataClient', $this->dataClient);
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
        $snippet = $this->snippetFromMethod(DataClient::class, 'readRows');
        $snippet->addLocal('dataClient', $this->dataClient);
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
            print_r($expectedRows, true),
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
        $this->bigtableClient->readRows(
                self::TABLE_NAME,
                ['rows' => $rowSet]
            )
            ->shouldBeCalled()
            ->willReturn(
                $this->serverStream->reveal()
            );

        $snippet = $this->snippetFromMethod(DataClient::class, 'readRows', 1);
        $snippet->addLocal('dataClient', $this->dataClient);
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
            print_r($expectedRows, true),
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
        $this->bigtableClient->readRows(
                self::TABLE_NAME,
                ['rows' => $rowSet]
            )
            ->shouldBeCalled()
            ->willReturn(
                $this->serverStream->reveal()
            );
        $snippet = $this->snippetFromMethod(DataClient::class, 'readRow');
        $snippet->addLocal('dataClient', $this->dataClient);
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

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

use \Google\ApiCore\ServerStream;
use Google\Cloud\Bigtable\ChunkFormatter;
use Google\Cloud\Bigtable\V2\ReadRowsResponse;
use Google\Cloud\Bigtable\V2\ReadRowsResponse\CellChunk as ReadRowsResponse_CellChunk;
use Google\Protobuf\StringValue;
use Google\Protobuf\BytesValue;
use PHPUnit\Framework\TestCase;

/**
 * @group bigtable
 * @group bigtabledata
 */
class ChunkFormatterTest extends TestCase
{
    private $serverStream;
    private $chunkFormatter;

    public function setUp()
    {
        $this->serverStream = $this->prophesize(ServerStream::class);
        $this->chunkFormatter = new ChunkFormatter(
            $this->serverStream->reveal()
        );
    }

    /**
     * @expectedException \Google\Cloud\Bigtable\Exception\BigtableDataOperationException
     * @expectedExceptionMessage A row key must be set
     */
    public function testNewRowShouldThrowWhenNoRowKey()
    {
        $readRowsResponse = new ReadRowsResponse;
        $chunk = new ReadRowsResponse_CellChunk();
        $readRowsResponse->setChunks([$chunk]);
        $this->serverStream->readAll()->shouldBeCalled()->willReturn(
            $this->arrayAsGenerator([$readRowsResponse])
        );
        iterator_to_array($this->chunkFormatter->readAll());
    }

    /**
     * @expectedException \Google\Cloud\Bigtable\Exception\BigtableDataOperationException
     * @expectedExceptionMessage A new row cannot be reset
     */
    public function testNewRowShouldThrowWhenResetIsTrue()
    {
        $readRowsResponse = new ReadRowsResponse;
        $chunk = new ReadRowsResponse_CellChunk();
        $chunk->setRowKey('rk1');
        $chunk->setResetRow(true);
        $readRowsResponse->setChunks([$chunk]);
        $this->serverStream->readAll()->shouldBeCalled()->willReturn(
            $this->arrayAsGenerator([$readRowsResponse])
        );
        iterator_to_array($this->chunkFormatter->readAll());
    }

    /**
     * @expectedException \Google\Cloud\Bigtable\Exception\BigtableDataOperationException
     * @expectedExceptionMessage A family must be set
     */
    public function testNewRowShouldThrowWhenNoFamilyName()
    {
        $readRowsResponse = new ReadRowsResponse;
        $chunk = new ReadRowsResponse_CellChunk();
        $chunk->setRowKey('rk1');
        $readRowsResponse->setChunks([$chunk]);
        $this->serverStream->readAll()->shouldBeCalled()->willReturn(
            $this->arrayAsGenerator([$readRowsResponse])
        );
        iterator_to_array($this->chunkFormatter->readAll());
    }

    /**
     * @expectedException \Google\Cloud\Bigtable\Exception\BigtableDataOperationException
     * @expectedExceptionMessage A column qualifier must be set
     */
    public function testNewRowShouldThrowWhenNoQualifier()
    {
        $readRowsResponse = new ReadRowsResponse;
        $chunk = new ReadRowsResponse_CellChunk();
        $chunk->setRowKey('rk1');
        $stringValue = new StringValue();
        $stringValue->setValue('cf1');
        $chunk->setFamilyName($stringValue);
        $readRowsResponse->setChunks([$chunk]);
        $this->serverStream->readAll()->shouldBeCalled()->willReturn(
            $this->arrayAsGenerator([$readRowsResponse])
        );
        iterator_to_array($this->chunkFormatter->readAll());
    }

    /**
     * @expectedException \Google\Cloud\Bigtable\Exception\BigtableDataOperationException
     * @expectedExceptionMessage A row cannot be have a value size and be a commit row
     */
    public function testNewRowShouldThrowWhenValueSizeAndCommitRow()
    {
        $readRowsResponse = new ReadRowsResponse;
        $chunk = new ReadRowsResponse_CellChunk();
        $chunk->setRowKey('rk1');
        $stringValue = new StringValue();
        $stringValue->setValue('cf1');
        $bytesValue = new BytesValue();
        $bytesValue->setValue('cq1');
        $chunk->setFamilyName($stringValue);
        $chunk->setQualifier($bytesValue);
        $chunk->setValueSize(10);
        $chunk->setCommitRow(true);
        $readRowsResponse->setChunks([$chunk]);
        $this->serverStream->readAll()->shouldBeCalled()->willReturn(
            $this->arrayAsGenerator([$readRowsResponse])
        );
        iterator_to_array($this->chunkFormatter->readAll());
    }

    /**
     * @expectedException \Google\Cloud\Bigtable\Exception\BigtableDataOperationException
     * @expectedExceptionMessage A commit happened but the same key followed
     */
    public function testNewRowShouldThrowWhenSameRowKeyFollows()
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
        $chunk->setValue('Value1');
        $chunk->setCommitRow(true);
        $chunks[] = $chunk;
        $chunk = new ReadRowsResponse_CellChunk();
        $chunk->setRowKey('rk1');
        $stringValue = new StringValue();
        $stringValue->setValue('cf1');
        $bytesValue = new BytesValue();
        $bytesValue->setValue('cq1');
        $chunk->setFamilyName($stringValue);
        $chunk->setQualifier($bytesValue);
        $chunks[] = $chunk;
        $readRowsResponse->setChunks($chunks);
        $this->serverStream->readAll()->shouldBeCalled()->willReturn(
            $this->arrayAsGenerator([$readRowsResponse])
        );
        iterator_to_array($this->chunkFormatter->readAll());
    }

    public function testNewRowShouldGenerateNewRow()
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
        $this->serverStream->readAll()->shouldBeCalled()->willReturn(
            $this->arrayAsGenerator([$readRowsResponse])
        );
        $rows = iterator_to_array($this->chunkFormatter->readAll());
        $expectedRows = [
                'rk1' => [
                    'cf1' => [
                        'cq1' => [[
                            'value' => 'value1',
                            'labels' => '',
                            'timeStamp' => 0
                        ]]
                    ]
                ]
        ];
        $this->assertEquals($expectedRows, $rows);
    }

    public function testNewRowShouldGenerateNewRowWithBinaryData()
    {
        $readRowsResponse = new ReadRowsResponse;
        $chunks = [];
        $chunk = new ReadRowsResponse_CellChunk();
        $data = pack("C*", 23, 17, 208, 3, 25, 68, 87, 3, 2, 64, 76, 145, 235);
        $chunk->setRowKey('rk1');
        $stringValue = new StringValue();
        $stringValue->setValue('cf1');
        $bytesValue = new BytesValue();
        $bytesValue->setValue('cq1');
        $chunk->setFamilyName($stringValue);
        $chunk->setQualifier($bytesValue);
        $chunk->setValue($data);
        $chunk->setCommitRow(true);
        $chunks[] = $chunk;
        $readRowsResponse->setChunks($chunks);
        $this->serverStream->readAll()->shouldBeCalled()->willReturn(
            $this->arrayAsGenerator([$readRowsResponse])
        );
        $rows = iterator_to_array($this->chunkFormatter->readAll());
        $expectedRows = [
                'rk1' => [
                    'cf1' => [
                        'cq1' => [[
                            'value' => $data,
                            'labels' => '',
                            'timeStamp' => 0
                        ]]
                    ]
                ]
        ];
        $this->assertEquals($expectedRows, $rows);
    }

    public function testNewRowShouldGenerateNewRowWithBinaryRowKey()
    {
        $readRowsResponse = new ReadRowsResponse;
        $chunks = [];
        $chunk = new ReadRowsResponse_CellChunk();
        $data = pack("C*", 23, 17, 208, 3, 25, 68, 87, 3, 2, 64, 76, 145, 235);
        $chunk->setRowKey($data);
        $stringValue = new StringValue();
        $stringValue->setValue('cf1');
        $bytesValue = new BytesValue();
        $bytesValue->setValue($data);
        $chunk->setFamilyName($stringValue);
        $chunk->setQualifier($bytesValue);
        $chunk->setValue($data);
        $chunk->setCommitRow(true);
        $chunks[] = $chunk;
        $readRowsResponse->setChunks($chunks);
        $this->serverStream->readAll()->shouldBeCalled()->willReturn(
            $this->arrayAsGenerator([$readRowsResponse])
        );
        $rows = iterator_to_array($this->chunkFormatter->readAll());
        $expectedRows = [
            $data => [
                'cf1' => [
                    $data => [[
                            'value' => $data,
                            'labels' => '',
                            'timeStamp' => 0
                        ]]
                    ]
                ]
        ];
        $this->assertEquals($expectedRows, $rows);
    }

    public function testNewRowShouldGenerateNewRowWithTimeStamp()
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
        $chunk->setTimestampMicros(10);
        $chunk->setCommitRow(true);
        $chunks[] = $chunk;
        $readRowsResponse->setChunks($chunks);
        $this->serverStream->readAll()->shouldBeCalled()->willReturn(
            $this->arrayAsGenerator([$readRowsResponse])
        );
        $rows = iterator_to_array($this->chunkFormatter->readAll());
        $expectedRows = [
                'rk1' => [
                    'cf1' => [
                        'cq1' => [[
                            'value' => 'value1',
                            'labels' => '',
                            'timeStamp' => 10
                        ]]
                    ]
                ]
        ];
        $this->assertEquals($expectedRows, $rows);
    }

    public function testNewRowShouldGenerateNewRowWithLabels()
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
        $chunk->setTimestampMicros(10);
        $chunk->setLabels(['label1', 'label2']);
        $chunk->setCommitRow(true);
        $chunks[] = $chunk;
        $readRowsResponse->setChunks($chunks);
        $this->serverStream->readAll()->shouldBeCalled()->willReturn(
            $this->arrayAsGenerator([$readRowsResponse])
        );
        $rows = iterator_to_array($this->chunkFormatter->readAll());
        $expectedRows = [
                'rk1' => [
                    'cf1' => [
                        'cq1' => [[
                            'value' => 'value1',
                            'labels' => 'label1label2',
                            'timeStamp' => 10
                        ]]
                    ]
                ]
        ];
        $this->assertEquals($expectedRows, $rows);
    }

    /**
     * @expectedException \Google\Cloud\Bigtable\Exception\BigtableDataOperationException
     * @expectedExceptionMessage Response ended with pending row without commit
     */
    public function testNewRowShouldThrowWhenPendingRow()
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
        $chunk->setValue('Value1');
        $chunks[] = $chunk;
        $readRowsResponse->setChunks($chunks);
        $this->serverStream->readAll()->shouldBeCalled()->willReturn(
            $this->arrayAsGenerator([$readRowsResponse])
        );
        iterator_to_array($this->chunkFormatter->readAll());
    }

    /**
     * @expectedException \Google\Cloud\Bigtable\Exception\BigtableDataOperationException
     * @expectedExceptionMessage A reset should have no data
     */
    public function testValidateResetWithRowKey()
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
        $chunk->setValue('Value1');
        $chunks[] = $chunk;
        $chunk = new ReadRowsResponse_CellChunk();
        $chunk->setRowKey('rk1');
        $chunk->setResetRow(true);
        $chunks[] = $chunk;
        $readRowsResponse->setChunks($chunks);
        $this->serverStream->readAll()->shouldBeCalled()->willReturn(
            $this->arrayAsGenerator([$readRowsResponse])
        );
        iterator_to_array($this->chunkFormatter->readAll());
    }

    /**
     * @expectedException \Google\Cloud\Bigtable\Exception\BigtableDataOperationException
     * @expectedExceptionMessage A reset should have no data
     */
    public function testValidateResetWithQualifier()
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
        $chunk->setValue('Value1');
        $chunks[] = $chunk;
        $chunk = new ReadRowsResponse_CellChunk();
        $chunk->setQualifier($bytesValue);
        $chunk->setResetRow(true);
        $chunks[] = $chunk;
        $readRowsResponse->setChunks($chunks);
        $this->serverStream->readAll()->shouldBeCalled()->willReturn(
            $this->arrayAsGenerator([$readRowsResponse])
        );
        iterator_to_array($this->chunkFormatter->readAll());
    }

    /**
     * @expectedException \Google\Cloud\Bigtable\Exception\BigtableDataOperationException
     * @expectedExceptionMessage A reset should have no data
     */
    public function testValidateResetWithValue()
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
        $chunk->setValue('Value1');
        $chunks[] = $chunk;
        $chunk = new ReadRowsResponse_CellChunk();
        $chunk->setValue('value1');
        $chunk->setResetRow(true);
        $chunks[] = $chunk;
        $readRowsResponse->setChunks($chunks);
        $this->serverStream->readAll()->shouldBeCalled()->willReturn(
            $this->arrayAsGenerator([$readRowsResponse])
        );
        iterator_to_array($this->chunkFormatter->readAll());
    }

    /**
     * @expectedException \Google\Cloud\Bigtable\Exception\BigtableDataOperationException
     * @expectedExceptionMessage A reset should have no data
     */
    public function testValidateResetWithTimestampMicro()
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
        $chunk->setValue('Value1');
        $chunks[] = $chunk;
        $chunk = new ReadRowsResponse_CellChunk();
        $chunk->setTimestampMicros(20);
        $chunk->setResetRow(true);
        $chunks[] = $chunk;
        $readRowsResponse->setChunks($chunks);
        $this->serverStream->readAll()->shouldBeCalled()->willReturn(
            $this->arrayAsGenerator([$readRowsResponse])
        );
        iterator_to_array($this->chunkFormatter->readAll());
    }

    /**
     * @expectedException \Google\Cloud\Bigtable\Exception\BigtableDataOperationException
     * @expectedExceptionMessage A commit is required between row keys
     */
    public function testRowInProgressDifferentRowKey()
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
        $chunk->setValue('Value1');
        $chunks[] = $chunk;
        $chunk = new ReadRowsResponse_CellChunk();
        $chunk->setRowKey('rk2');
        $chunks[] = $chunk;
        $readRowsResponse->setChunks($chunks);
        $this->serverStream->readAll()->shouldBeCalled()->willReturn(
            $this->arrayAsGenerator([$readRowsResponse])
        );
        iterator_to_array($this->chunkFormatter->readAll());
    }

    /**
     * @expectedException \Google\Cloud\Bigtable\Exception\BigtableDataOperationException
     * @expectedExceptionMessage A qualifier must be specified
     */
    public function testRowInProgressFamilyNameWithouQualifier()
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
        $chunk->setValue('Value1');
        $chunks[] = $chunk;
        $chunk = new ReadRowsResponse_CellChunk();
        $chunk->setRowKey('rk1');
        $stringValue = new StringValue();
        $stringValue->setValue('cf2');
        $chunk->setFamilyName($stringValue);
        $chunks[] = $chunk;
        $readRowsResponse->setChunks($chunks);
        $this->serverStream->readAll()->shouldBeCalled()->willReturn(
            $this->arrayAsGenerator([$readRowsResponse])
        );
        iterator_to_array($this->chunkFormatter->readAll());
    }

    /**
     * @expectedException \Google\Cloud\Bigtable\Exception\BigtableDataOperationException
     * @expectedExceptionMessage A row cannot be have a value size and be a commit row
     */
    public function testRowInProgressValueSizeAndCommit()
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
        $chunk->setValue('Value1');
        $chunks[] = $chunk;
        $chunk = new ReadRowsResponse_CellChunk();
        $chunk->setRowKey('rk1');
        $stringValue = new StringValue();
        $stringValue->setValue('cf2');
        $bytesValue = new BytesValue();
        $bytesValue->setValue('cq2');
        $chunk->setFamilyName($stringValue);
        $chunk->setQualifier($bytesValue);
        $chunk->setValueSize(10);
        $chunk->setCommitRow(true);
        $chunks[] = $chunk;
        $readRowsResponse->setChunks($chunks);
        $this->serverStream->readAll()->shouldBeCalled()->willReturn(
            $this->arrayAsGenerator([$readRowsResponse])
        );
        iterator_to_array($this->chunkFormatter->readAll());
    }

    public function testRowInProgressResetShouldNotGenerateRow()
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
        $chunk->setValue('Value1');
        $chunks[] = $chunk;
        $chunk = new ReadRowsResponse_CellChunk();
        $chunk->setResetRow(true);
        $chunks[] = $chunk;
        $readRowsResponse->setChunks($chunks);
        $this->serverStream->readAll()->shouldBeCalled()->willReturn(
            $this->arrayAsGenerator([$readRowsResponse])
        );
        $rows = iterator_to_array($this->chunkFormatter->readAll());
        $this->assertEquals([], $rows);
    }

    public function testRowInProgressTwoFamily()
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
        $chunks[] = $chunk;
        $chunk = new ReadRowsResponse_CellChunk();
        $stringValue = new StringValue();
        $stringValue->setValue('cf2');
        $bytesValue = new BytesValue();
        $bytesValue->setValue('cq2');
        $chunk->setFamilyName($stringValue);
        $chunk->setQualifier($bytesValue);
        $chunk->setValue('value2');
        $chunk->setCommitRow(true);
        $chunks[] = $chunk;
        $readRowsResponse->setChunks($chunks);
        $this->serverStream->readAll()->shouldBeCalled()->willReturn(
            $this->arrayAsGenerator([$readRowsResponse])
        );
        $rows = iterator_to_array($this->chunkFormatter->readAll());
        $expectedRows = [
                'rk1' => [
                    'cf1' => [
                        'cq1' => [[
                            'value' => 'value1',
                            'labels' => '',
                            'timeStamp' => 0
                        ]]
                    ],
                    'cf2' => [
                        'cq2' => [[
                            'value' => 'value2',
                            'labels' => '',
                            'timeStamp' => 0
                        ]]
                    ]
                ]
        ];
        $this->assertEquals($expectedRows, $rows);
    }

    public function testRowInProgressOneFamilyTwoQualifier()
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
        $chunks[] = $chunk;
        $chunk = new ReadRowsResponse_CellChunk();
        $bytesValue = new BytesValue();
        $bytesValue->setValue('cq2');
        $chunk->setQualifier($bytesValue);
        $chunk->setValue('value2');
        $chunk->setCommitRow(true);
        $chunks[] = $chunk;
        $readRowsResponse->setChunks($chunks);
        $this->serverStream->readAll()->shouldBeCalled()->willReturn(
            $this->arrayAsGenerator([$readRowsResponse])
        );
        $rows = iterator_to_array($this->chunkFormatter->readAll());
        $expectedRows = [
                'rk1' => [
                    'cf1' => [
                        'cq1' => [[
                            'value' => 'value1',
                            'labels' => '',
                            'timeStamp' => 0
                        ]],
                        'cq2' => [[
                            'value' => 'value2',
                            'labels' => '',
                            'timeStamp' => 0
                        ]]
                    ]
                ]
        ];
        $this->assertEquals($expectedRows, $rows);
    }

    public function testRowInProgressWithTimestamp()
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
        $chunks[] = $chunk;
        $chunk = new ReadRowsResponse_CellChunk();
        $bytesValue = new BytesValue();
        $bytesValue->setValue('cq2');
        $chunk->setQualifier($bytesValue);
        $chunk->setValue('value2');
        $chunk->setTimestampMicros(10);
        $chunk->setCommitRow(true);
        $chunks[] = $chunk;
        $readRowsResponse->setChunks($chunks);
        $this->serverStream->readAll()->shouldBeCalled()->willReturn(
            $this->arrayAsGenerator([$readRowsResponse])
        );
        $rows = iterator_to_array($this->chunkFormatter->readAll());
        $expectedRows = [
                'rk1' => [
                    'cf1' => [
                        'cq1' => [[
                            'value' => 'value1',
                            'labels' => '',
                            'timeStamp' => 0
                        ]],
                        'cq2' => [[
                            'value' => 'value2',
                            'labels' => '',
                            'timeStamp' => 10
                        ]]
                    ]
                ]
        ];
        $this->assertEquals($expectedRows, $rows);
    }

    public function testRowInProgressWithLabels()
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
        $chunks[] = $chunk;
        $chunk = new ReadRowsResponse_CellChunk();
        $bytesValue = new BytesValue();
        $bytesValue->setValue('cq2');
        $chunk->setQualifier($bytesValue);
        $chunk->setValue('value2');
        $chunk->setLabels(['l1','l2']);
        $chunk->setCommitRow(true);
        $chunks[] = $chunk;
        $readRowsResponse->setChunks($chunks);
        $this->serverStream->readAll()->shouldBeCalled()->willReturn(
            $this->arrayAsGenerator([$readRowsResponse])
        );
        $rows = iterator_to_array($this->chunkFormatter->readAll());
        $expectedRows = [
                'rk1' => [
                    'cf1' => [
                        'cq1' => [[
                            'value' => 'value1',
                            'labels' => '',
                            'timeStamp' => 0
                        ]],
                        'cq2' => [[
                            'value' => 'value2',
                            'labels' => 'l1l2',
                            'timeStamp' => 0
                        ]]
                    ]
                ]
        ];
        $this->assertEquals($expectedRows, $rows);
    }

    /**
     * @expectedException \Google\Cloud\Bigtable\Exception\BigtableDataOperationException
     * @expectedExceptionMessage A row cannot be have a value size and be a commit row
     */
    public function testCellInProgressValueSizeAndCommit()
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
        $chunk->setValue('Value1');
        $chunk->setValueSize(10);
        $chunks[] = $chunk;
        $chunk = new ReadRowsResponse_CellChunk();
        $chunk->setValueSize(100);
        $chunk->setCommitRow(true);
        $chunks[] = $chunk;
        $readRowsResponse->setChunks($chunks);
        $this->serverStream->readAll()->shouldBeCalled()->willReturn(
            $this->arrayAsGenerator([$readRowsResponse])
        );
        iterator_to_array($this->chunkFormatter->readAll());
    }

    /**
     * @expectedException \Google\Cloud\Bigtable\Exception\BigtableDataOperationException
     * @expectedExceptionMessage A reset should have no data
     */
    public function testCellInProgressValidateResetWithRowKey()
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
        $chunk->setValue('Value1');
        $chunk->setValueSize(10);
        $chunks[] = $chunk;
        $chunk = new ReadRowsResponse_CellChunk();
        $chunk->setRowKey('rk1');
        $chunk->setResetRow(true);
        $chunks[] = $chunk;
        $readRowsResponse->setChunks($chunks);
        $this->serverStream->readAll()->shouldBeCalled()->willReturn(
            $this->arrayAsGenerator([$readRowsResponse])
        );
        iterator_to_array($this->chunkFormatter->readAll());
    }

    /**
     * @expectedException \Google\Cloud\Bigtable\Exception\BigtableDataOperationException
     * @expectedExceptionMessage A reset should have no data
     */
    public function testCellInProgressValidateResetWithQualifier()
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
        $chunk->setValue('Value1');
        $chunk->setValueSize(10);
        $chunks[] = $chunk;
        $chunk = new ReadRowsResponse_CellChunk();
        $bytesValue = new BytesValue();
        $bytesValue->setValue('cq1');
        $chunk->setQualifier($bytesValue);
        $chunk->setResetRow(true);
        $chunks[] = $chunk;
        $readRowsResponse->setChunks($chunks);
        $this->serverStream->readAll()->shouldBeCalled()->willReturn(
            $this->arrayAsGenerator([$readRowsResponse])
        );
        iterator_to_array($this->chunkFormatter->readAll());
    }

    /**
     * @expectedException \Google\Cloud\Bigtable\Exception\BigtableDataOperationException
     * @expectedExceptionMessage A reset should have no data
     */
    public function testCellInProgressValidateResetWithValue()
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
        $chunk->setValue('Value1');
        $chunk->setValueSize(10);
        $chunks[] = $chunk;
        $chunk = new ReadRowsResponse_CellChunk();
        $chunk->setValue('value1');
        $chunk->setResetRow(true);
        $chunks[] = $chunk;
        $readRowsResponse->setChunks($chunks);
        $this->serverStream->readAll()->shouldBeCalled()->willReturn(
            $this->arrayAsGenerator([$readRowsResponse])
        );
        iterator_to_array($this->chunkFormatter->readAll());
    }

    /**
     * @expectedException \Google\Cloud\Bigtable\Exception\BigtableDataOperationException
     * @expectedExceptionMessage A reset should have no data
     */
    public function testCellInProgressValidateResetWithTimestampMicro()
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
        $chunk->setValue('Value1');
        $chunk->setValueSize(10);
        $chunks[] = $chunk;
        $chunk = new ReadRowsResponse_CellChunk();
        $chunk->setTimestampMicros(20);
        $chunk->setResetRow(true);
        $chunks[] = $chunk;
        $readRowsResponse->setChunks($chunks);
        $this->serverStream->readAll()->shouldBeCalled()->willReturn(
            $this->arrayAsGenerator([$readRowsResponse])
        );
        iterator_to_array($this->chunkFormatter->readAll());
    }

    public function testCellInProgressResetShouldNotGenerateRow()
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
        $chunk->setValue('Value1');
        $chunk->setValueSize(10);
        $chunks[] = $chunk;
        $chunk = new ReadRowsResponse_CellChunk();
        $chunk->setResetRow(true);
        $chunks[] = $chunk;
        $readRowsResponse->setChunks($chunks);
        $this->serverStream->readAll()->shouldBeCalled()->willReturn(
            $this->arrayAsGenerator([$readRowsResponse])
        );
        $rows = iterator_to_array($this->chunkFormatter->readAll());
        $this->assertEquals([], $rows);
    }

    public function testCellInProgressOneFamilyTwoQualifier()
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
        $chunk->setValueSize(10);
        $chunks[] = $chunk;
        $chunk = new ReadRowsResponse_CellChunk();
        $chunk->setValue('value2');
        $chunk->setCommitRow(true);
        $chunks[] = $chunk;
        $readRowsResponse->setChunks($chunks);
        $this->serverStream->readAll()->shouldBeCalled()->willReturn(
            $this->arrayAsGenerator([$readRowsResponse])
        );
        $rows = iterator_to_array($this->chunkFormatter->readAll());
        $expectedRows = [
                'rk1' => [
                    'cf1' => [
                        'cq1' => [[
                            'value' => 'value1value2',
                            'labels' => '',
                            'timeStamp' => 0
                        ]]
                    ]
                ]
        ];
        $this->assertEquals($expectedRows, $rows);
    }

    private function arrayAsGenerator(array $array)
    {
        foreach ($array as $item) {
            yield $item;
        }
    }
}

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

use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Testing\MockTransport;
use Google\Cloud\Bigtable\ChunkFormatter;
use Google\Cloud\Bigtable\Exception\BigtableDataOperationException;
use Google\Cloud\Bigtable\V2\Client\BigtableClient;
use Google\Cloud\Bigtable\V2\ReadRowsRequest;
use Google\Cloud\Bigtable\V2\ReadRowsResponse;
use Google\Cloud\Bigtable\V2\ReadRowsResponse\CellChunk as ReadRowsResponse_CellChunk;
use Google\Protobuf\StringValue;
use Google\Protobuf\BytesValue;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;

/**
 * @group bigtable
 * @group bigtabledata
 */
class ChunkFormatterTest extends TestCase
{
    use ProphecyTrait;

    const TABLE_NAME = 'test-table';
    private $chunkFormatter;
    private $gapicClient;
    private $readRowsRequest;
    private $transport;

    public function setUp(): void
    {
        $this->transport = $this->createTransport();
        $this->gapicClient = $this->createClient([
            'transport' => $this->transport,
        ]);
        $this->readRowsRequest = new ReadRowsRequest(['table_name' => self::TABLE_NAME]);
        $this->chunkFormatter = new ChunkFormatter(
            $this->gapicClient,
            $this->readRowsRequest,
            []
        );
    }

    public function testNewRowShouldThrowWhenNoRowKey()
    {
        $this->expectException(BigtableDataOperationException::class);
        $this->expectExceptionMessage('A row key must be set.');

        // Add a mock response to our transport
        $readRowsResponse = new ReadRowsResponse;
        $chunk = new ReadRowsResponse_CellChunk();
        $readRowsResponse->setChunks([$chunk]);

        $this->transport->addResponse($readRowsResponse);

        iterator_to_array($this->chunkFormatter->readAll());
    }

    public function testNewRowShouldGenerateWhenRowKeyIsZero()
    {
        $readRowsResponse = new ReadRowsResponse;
        $chunk = new ReadRowsResponse_CellChunk();
        $chunk->setRowKey('0');
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

        // Add a mock response to our transport
        $this->transport->addResponse($readRowsResponse);

        // Execute the test
        $rows = iterator_to_array($this->chunkFormatter->readAll());
        $expectedRows = [
                '0' => [
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

    public function testNewRowShouldThrowWhenResetIsTrue()
    {
        $this->expectException(BigtableDataOperationException::class);
        $this->expectExceptionMessage('A new row cannot be reset.');

        $readRowsResponse = new ReadRowsResponse;
        $chunk = new ReadRowsResponse_CellChunk();
        $chunk->setRowKey('rk1');
        $chunk->setResetRow(true);
        $readRowsResponse->setChunks([$chunk]);

        // Add a mock response to our transport
        $this->transport->addResponse($readRowsResponse);

        iterator_to_array($this->chunkFormatter->readAll());
    }

    public function testNewRowShouldThrowWhenNoFamilyName()
    {
        $this->expectException(BigtableDataOperationException::class);
        $this->expectExceptionMessage('A family must be set.');

        $readRowsResponse = new ReadRowsResponse;
        $chunk = new ReadRowsResponse_CellChunk();
        $chunk->setRowKey('rk1');
        $readRowsResponse->setChunks([$chunk]);

        // Add a mock response to our transport
        $this->transport->addResponse($readRowsResponse);

        iterator_to_array($this->chunkFormatter->readAll());
    }

    public function testNewRowShouldThrowWhenNoQualifier()
    {
        $this->expectException(BigtableDataOperationException::class);
        $this->expectExceptionMessage('A column qualifier must be set.');

        $readRowsResponse = new ReadRowsResponse;
        $chunk = new ReadRowsResponse_CellChunk();
        $chunk->setRowKey('rk1');
        $stringValue = new StringValue();
        $stringValue->setValue('cf1');
        $chunk->setFamilyName($stringValue);
        $readRowsResponse->setChunks([$chunk]);

        // Add a mock response to our transport
        $this->transport->addResponse($readRowsResponse);

        iterator_to_array($this->chunkFormatter->readAll());
    }

    public function testNewRowShouldThrowWhenValueSizeAndCommitRow()
    {
        $this->expectException(BigtableDataOperationException::class);
        $this->expectExceptionMessage('A row cannot have a value size and be a commit row.');

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

        // Add a mock response to our transport
        $this->transport->addResponse($readRowsResponse);

        iterator_to_array($this->chunkFormatter->readAll());
    }

    public function testNewRowShouldThrowWhenSameRowKeyFollows()
    {
        $this->expectException(BigtableDataOperationException::class);
        $this->expectExceptionMessage('A commit happened but the same key followed.');

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

        // Add a mock response to our transport
        $this->transport->addResponse($readRowsResponse);

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

        // Add a mock response to our transport
        $this->transport->addResponse($readRowsResponse);

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

        // Add a mock response to our transport
        $this->transport->addResponse($readRowsResponse);

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

        // Add a mock response to our transport
        $this->transport->addResponse($readRowsResponse);

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

        // Add a mock response to our transport
        $this->transport->addResponse($readRowsResponse);

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

        // Add a mock response to our transport
        $this->transport->addResponse($readRowsResponse);

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

    public function testNewRowShouldThrowWhenPendingRow()
    {
        $this->expectException(BigtableDataOperationException::class);
        $this->expectExceptionMessage('Response ended with pending row without commit.');

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

        // Add a mock response to our transport
        $this->transport->addResponse($readRowsResponse);

        iterator_to_array($this->chunkFormatter->readAll());
    }

    public function testValidateResetWithRowKey()
    {
        $this->expectException(BigtableDataOperationException::class);
        $this->expectExceptionMessage('A reset should have no data.');

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

        // Add a mock response to our transport
        $this->transport->addResponse($readRowsResponse);

        iterator_to_array($this->chunkFormatter->readAll());
    }

    public function testValidateResetWithQualifier()
    {
        $this->expectException(BigtableDataOperationException::class);
        $this->expectExceptionMessage('A reset should have no data.');

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

        // Add a mock response to our transport
        $this->transport->addResponse($readRowsResponse);

        iterator_to_array($this->chunkFormatter->readAll());
    }

    public function testValidateResetWithValue()
    {
        $this->expectException(BigtableDataOperationException::class);
        $this->expectExceptionMessage('A reset should have no data.');

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

        // Add a mock response to our transport
        $this->transport->addResponse($readRowsResponse);

        iterator_to_array($this->chunkFormatter->readAll());
    }

    public function testValidateResetWithTimestampMicro()
    {
        $this->expectException(BigtableDataOperationException::class);
        $this->expectExceptionMessage('A reset should have no data.');

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

        // Add a mock response to our transport
        $this->transport->addResponse($readRowsResponse);

        iterator_to_array($this->chunkFormatter->readAll());
    }

    public function testRowInProgressDifferentRowKey()
    {
        $this->expectException(BigtableDataOperationException::class);
        $this->expectExceptionMessage('A commit is required between row keys.');

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

        // Add a mock response to our transport
        $this->transport->addResponse($readRowsResponse);

        iterator_to_array($this->chunkFormatter->readAll());
    }

    public function testRowInProgressFamilyNameWithouQualifier()
    {
        $this->expectException(BigtableDataOperationException::class);
        $this->expectExceptionMessage('A qualifier must be specified.');

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

        // Add a mock response to our transport
        $this->transport->addResponse($readRowsResponse);

        iterator_to_array($this->chunkFormatter->readAll());
    }

    public function testRowInProgressValueSizeAndCommit()
    {
        $this->expectException(BigtableDataOperationException::class);
        $this->expectExceptionMessage('A row cannot have a value size and be a commit row.');

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

        // Add a mock response to our transport
        $this->transport->addResponse($readRowsResponse);

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
        
        // Add a mock response to our transport
        $this->transport->addResponse($readRowsResponse);

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
        
        // Add a mock response to our transport
        $this->transport->addResponse($readRowsResponse);

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
        
        // Add a mock response to our transport
        $this->transport->addResponse($readRowsResponse);

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
        
        // Add a mock response to our transport
        $this->transport->addResponse($readRowsResponse);

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
        
        // Add a mock response to our transport
        $this->transport->addResponse($readRowsResponse);

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

    public function testCellInProgressValueSizeAndCommit()
    {
        $this->expectException(BigtableDataOperationException::class);
        $this->expectExceptionMessage('A row cannot have a value size and be a commit row.');

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
        
        // Add a mock response to our transport
        $this->transport->addResponse($readRowsResponse);

        iterator_to_array($this->chunkFormatter->readAll());
    }

    public function testCellInProgressValidateResetWithRowKey()
    {
        $this->expectException(BigtableDataOperationException::class);
        $this->expectExceptionMessage('A reset should have no data.');

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
        
        // Add a mock response to our transport
        $this->transport->addResponse($readRowsResponse);

        iterator_to_array($this->chunkFormatter->readAll());
    }

    public function testCellInProgressValidateResetWithQualifier()
    {
        $this->expectException(BigtableDataOperationException::class);
        $this->expectExceptionMessage('A reset should have no data.');

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
        
        // Add a mock response to our transport
        $this->transport->addResponse($readRowsResponse);

        iterator_to_array($this->chunkFormatter->readAll());
    }

    public function testCellInProgressValidateResetWithValue()
    {
        $this->expectException(BigtableDataOperationException::class);
        $this->expectExceptionMessage('A reset should have no data.');

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
        
        // Add a mock response to our transport
        $this->transport->addResponse($readRowsResponse);

        iterator_to_array($this->chunkFormatter->readAll());
    }

    public function testCellInProgressValidateResetWithTimestampMicro()
    {
        $this->expectException(BigtableDataOperationException::class);
        $this->expectExceptionMessage('A reset should have no data.');

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
        
        // Add a mock response to our transport
        $this->transport->addResponse($readRowsResponse);

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
        
        // Add a mock response to our transport
        $this->transport->addResponse($readRowsResponse);

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
        
        // Add a mock response to our transport
        $this->transport->addResponse($readRowsResponse);

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

    private function createTransport($deserialize = null)
    {
        return new MockTransport($deserialize);
    }

    /** @return CredentialsWrapper */
    private function createCredentials()
    {
        return $this->getMockBuilder(CredentialsWrapper::class)->disableOriginalConstructor()->getMock();
    }

    /** @return BigtableClient */
    private function createClient(array $options = [])
    {
        $options += [
            'credentials' => $this->createCredentials(),
        ];
        return new BigtableClient($options);
    }
}

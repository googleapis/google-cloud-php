<?php

namespace Google\Cloud\Bigtable\Tests\Unit;

use \Google\Cloud\Bigtable\V2\ReadRowsResponse_CellChunk;
use \Google\Cloud\Bigtable\V2\BigtableReadRowsBuffer;
use \Google\Protobuf\StringValue;
use \Google\Protobuf\BytesValue;
use PHPUnit\Framework\TestCase;

/**
 * @group bigtable
 */
class BigtableReadRowsBufferTest extends TestCase
{
    public function setupCellChunk($args)
    {
        $cellChunk = new ReadRowsResponse_CellChunk();

        if (array_key_exists('row_key', $args)) {
            $cellChunk->setRowKey($args['row_key']);
        }

        if (array_key_exists('family_name', $args)) {
            $familyNameStringValue = new StringValue();
            $familyNameStringValue->setValue($args['family_name']);
            $cellChunk->setFamilyName($familyNameStringValue);
        }

        if (array_key_exists('col_name', $args)) {
            $colNameBytesValue = new BytesValue();
            $colNameBytesValue->setValue($args['col_name']);
            $cellChunk->setQualifier($colNameBytesValue);
        }

        if (array_key_exists('timestamp', $args)) {
            $cellChunk->setTimestampMicros($args['timestamp']);
        }

        if (array_key_exists('value', $args)) {
            $cellChunk->setValue($args['value']);
        }

        if (array_key_exists('commit_row', $args)) {
            $cellChunk->setCommitRow($args['commit_row']);
        }

        if (array_key_exists('value_size', $args)) {
            $cellChunk->setValueSize($args['value_size']);
        }

        if (array_key_exists('reset_row', $args)) {
            $cellChunk->setResetRow($args['reset_row']);
        }

        return $cellChunk;
    }

    public function assertColumnSingleCellValue(
        $rowData,
        $familyName,
        $colName,
        $expectedVal,
        $expectedTimestamp = 0
    ) {

        $cells = $rowData->getCells()[$familyName][$colName];
        $this->assertCount(1, $cells);
        $this->assertEquals($expectedVal, $cells[0]->getValue());
        $this->assertEquals($expectedTimestamp, $cells[0]->getTimestampMicros());
    }

    public function consumeSingleRow($chunks)
    {
        $buffer = new BigtableReadRowsBuffer();
        $rows = $buffer->consumeCellChunks($chunks);
        $rowArray = iterator_to_array($rows);
        $this->assertCount(1, $rowArray);
        return $rowArray[0];
    }

    public function testConsumeSingleCellChunk()
    {
        $cellChunk = $this->setupCellChunk(
            [
            'value' => 'val1',
            'row_key' => 'key1',
            'family_name' => 'family1',
            'col_name' => 'col1',
            'timestamp' => 1000
            ]
        );

        $cellChunk->setCommitRow(true);

        $row = $this->consumeSingleRow([$cellChunk]);

        $this->assertEquals($row->getRowKey(), 'key1');
        $this->assertColumnSingleCellValue($row, 'family1', 'col1', 'val1', 1000);
    }

    public function testConsumeSingleValueMultipleChunks()
    {
        $val1 = 'hello';
        $val2 = 'world';
        $finalVal = $val1.$val2;

        $chunk1 = $this->setupCellChunk(
            [
            'value' => $val1,
            'row_key' => 'key1',
            'family_name' => 'family1',
            'col_name' => 'col1',
            'timestamp' => 1000,
            'valueSize' => strlen($finalVal)
            ]
        );

        $chunk1->setValueSize(strlen($finalVal));
        $chunk2 = $this->setupCellChunk(['value' => $val2, 'commit_row' => true]);

        $row = $this->consumeSingleRow([$chunk1, $chunk2]);

        $this->assertEquals($row->getRowKey(), 'key1');
        $this->assertColumnSingleCellValue($row, 'family1', 'col1', $finalVal, 1000);
    }

    public function testConsumeMultipleColumns()
    {
        $chunk1 = $this->setupCellChunk(
            [
            'value' => 'val1',
            'row_key' => 'key1',
            'family_name' => 'family1',
            'col_name' => 'col1',
            'timestamp' => 1000
            ]
        );

        $chunk2 = $this->setupCellChunk(
            [
            'value' => 'val2',
            'col_name' => 'col2',
            'timestamp' => 1000,
            'commit_row' => true
            ]
        );

        $row = $this->consumeSingleRow([$chunk1, $chunk2]);

        $this->assertEquals($row->getRowKey(), 'key1');
        $this->assertCount(1, $row->getCells());

        $this->assertColumnSingleCellValue($row, 'family1', 'col1', 'val1', 1000);
        $this->assertColumnSingleCellValue($row, 'family1', 'col2', 'val2', 1000);
    }

    public function testConsumeMultipleColumnFamilies()
    {
        $chunk1 = $this->setupCellChunk(
            [
            'value' => 'val1',
            'row_key' => 'key1',
            'family_name' => 'family1',
            'col_name' => 'col1',
            'timestamp' => 1000
            ]
        );

        $chunk2 = $this->setupCellChunk(
            [
            'value' => 'val2',
            'family_name' => 'family2',
            'col_name' => 'col2',
            'timestamp' => 1000,
            'commit_row' => true
            ]
        );

        $row = $this->consumeSingleRow([$chunk1, $chunk2]);

        $this->assertEquals($row->getRowKey(), 'key1');
        $this->assertCount(2, $row->getCells());

        $this->assertColumnSingleCellValue($row, 'family1', 'col1', 'val1', 1000);
        $this->assertColumnSingleCellValue($row, 'family2', 'col2', 'val2', 1000);
    }

    public function testConsumeMultipleCells()
    {
        $chunk1 = $this->setupCellChunk(
            [
            'value' => 'val1',
            'row_key' => 'key1',
            'family_name' => 'family1',
            'col_name' => 'col1',
            'timestamp' => 1000
            ]
        );

        $chunk2 = $this->setupCellChunk(
            [
            'value' => 'val2',
            'timestamp' => 2000,
            'commit_row' => true
            ]
        );

        $row = $this->consumeSingleRow([$chunk1, $chunk2]);

        $this->assertEquals($row->getRowKey(), 'key1');
        $this->assertCount(1, $row->getCells());

        $cells = $row->getCells()['family1']['col1'];

        $this->assertCount(2, $cells);

        $this->assertEquals('val1', $cells[0]->getValue());
        $this->assertEquals(1000, $cells[0]->getTimestampMicros());

        $this->assertEquals('val2', $cells[1]->getValue());
        $this->assertEquals(2000, $cells[1]->getTimestampMicros());
    }

    public function testResetRow()
    {
        $chunk1 = $this->setupCellChunk(
            [
            'value' => 'val1',
            'row_key' => 'key1',
            'family_name' => 'family1',
            'col_name' => 'col1',
            'timestamp' => 1000
            ]
        );

        $chunk2 = $this->setupCellChunk(
            [
            'value' => 'val2',
            'col_name' => 'col2',
            'timestamp' => 1000
            ]
        );


        $chunk3 = $this->setupCellChunk(['reset_row' => true]);

        $chunk4 = $this->setupCellChunk(
            [
            'value' => 'val3',
            'row_key' => 'key1',
            'family_name' => 'family1',
            'col_name' => 'col1',
            'timestamp' => 1000
            ]
        );

        $chunk5 = $this->setupCellChunk(
            [
            'value' => 'val4',
            'col_name' => 'col2',
            'timestamp' => 1000,
            'commit_row' => true
            ]
        );

        $row = $this->consumeSingleRow([$chunk1, $chunk2, $chunk3, $chunk4, $chunk5]);

        $this->assertEquals($row->getRowKey(), 'key1');
        $this->assertCount(1, $row->getCells());

        $this->assertColumnSingleCellValue($row, 'family1', 'col1', 'val3', 1000);
        $this->assertColumnSingleCellValue($row, 'family1', 'col2', 'val4', 1000);
    }

    /**
     * @expectedException Google\Cloud\Bigtable\V2\Exception\InvalidChunkException
     */
    public function testRaisesOnNewRowKeyInRow()
    {
        $chunk1 = $this->setupCellChunk(
            [
            'value' => 'val1',
            'row_key' => 'key1',
            'family_name' => 'family1',
            'col_name' => 'col1',
            'timestamp' => 1000
            ]
        );

        $chunk2 = $this->setupCellChunk(
            [
            'value' => 'val2',
            'row_key' => 'key2',
            'family_name' => 'family1',
            'col_name' => 'col1',
            'timestamp' => 1000,
            'commit_row' => true
            ]
        );

        $chunk2->setCommitRow(true);
        $row = $this->consumeSingleRow([$chunk1, $chunk2]);
    }

    /**
     * @expectedException Google\Cloud\Bigtable\V2\Exception\InvalidChunkException
     */
    public function testRaisesOnNewColumnInCell()
    {
        $chunk1 = $this->setupCellChunk(
            [
            'value' => 'val1',
            'row_key' => 'key1',
            'family_name' => 'family1',
            'col_name' => 'col1',
            'timestamp' => 1000,
            'value_size' => 10
            ]
        );

        $chunk2 = $this->setupCellChunk(
            [
            'value' => 'val2',
            'col_name' => 'col2',
            'timestamp' => 1000,
            'commit_row' => true
            ]
        );

        $row = $this->consumeSingleRow([$chunk1, $chunk2]);
    }

    /**
     * @expectedException Google\Cloud\Bigtable\V2\Exception\InvalidChunkException
     */
    public function testRaisesOnResetRowWithValues()
    {
        $chunk1 = $this->setupCellChunk(
            [
            'value' => 'val1',
            'reset_row' => true
            ]
        );

        $buffer = new BigtableReadRowsBuffer();
        $rows = $buffer->consumeCellChunks([$chunk1]);
        iterator_to_array($rows);
    }

    /**
     * @expectedException Google\Cloud\Bigtable\V2\Exception\InvalidChunkException
     */
    public function testRaisesOnCommitRowWithValueSize()
    {
        $chunk1 = $this->setupCellChunk(
            [
            'value' => 'val1',
            'value_size' => 10,
            'commit_row' => true
            ]
        );

        $buffer = new BigtableReadRowsBuffer();
        $rows = $buffer->consumeCellChunks([$chunk1]);
        iterator_to_array($rows);
    }
}

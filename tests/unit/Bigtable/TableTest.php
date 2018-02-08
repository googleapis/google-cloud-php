<?php

use Google\Cloud\Bigtable\src\BigtableTable;
use Google\Cloud\Bigtable\Admin\V2\Table;
use Google\Protobuf\GPBEmpty;

use Google\Cloud\Bigtable\Admin\V2\ColumnFamily;
use Google\Cloud\Bigtable\Admin\V2\GcRule;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\MapField;
use Google\Bigtable\Admin\V2\ModifyColumnFamiliesRequest;
use Google\Bigtable\Admin\V2\ModifyColumnFamiliesRequest_Modification as Modification;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

use Google\Cloud\Bigtable\V2\Mutation_SetCell;
use Google\Cloud\Bigtable\V2\Mutation;

use Google\Cloud\Bigtable\V2\MutateRowResponse;
use Google\GAX\ServerStream;

use Google\Cloud\Bigtable\V2\MutateRowsRequest_Entry;
use Google\Protobuf\Internal\RepeatedField;
use Google\Cloud\Bigtable\V2\FlatRow;
use Google\GAX\PagedListResponse;

/**
 *
 */
class TableTest extends TestCase
{
    const PROJECT_ID = 'grass-clump-479';
    const INSTANCE_ID = 'php-perf';
    const TABLE_ID = 'myTableId';

    public function testInstanceName()
    {
        $expected = 'projects/'.self::PROJECT_ID.'/instances/'.self::INSTANCE_ID;

        $mock = $this->createMock(BigtableTable::class);
        $mock->method('instanceName')
             ->willReturn($expected);

        $formatedName = $mock->instanceName(Argument::type('string'), Argument::type('string'));
        $this->assertEquals($formatedName, $expected);
    }
    
    public function testCreateTable()
    {
        $parent = 'projects/'.self::PROJECT_ID.'/instances/'.self::INSTANCE_ID;
        $fakeTable = new Table();
        $fakeTable->setName($parent);

        $mock = $this->createMock(BigtableTable::class);
        $mock->method('createTable')
             ->willReturn($fakeTable);

        $table = $mock->createTable(Argument::type('string'), Argument::type('string'));
        $this->assertEquals($table->getName(), $parent);
        $this->assertInstanceOf(Table::class, $table);
    }
    
    public function testTableName()
    {
        $expected = 'projects/'.self::PROJECT_ID.'/instances/'.self::INSTANCE_ID.'/tables/'.self::TABLE_ID;
        
        $mock = $this->createMock(BigtableTable::class);
        $mock->method('tableName')
             ->willReturn($expected);

        $formatedName = $mock->tableName(Argument::type('string'), Argument::type('string'), Argument::type('string'));
        $this->assertEquals($formatedName, $expected);
    }

    public function testCreateTableWithColumnFamily()
    {
        $columnFamily = 'cf';
        $parent = 'projects/'.self::PROJECT_ID.'/instances/'.self::INSTANCE_ID;
        
        $fakeTable = new Table();
        $fakeTable->setName($parent);
        
        $BigtableTable = new BigtableTable();
        $MapField = $BigtableTable->columnFamily(3, $columnFamily);
        $fakeTable->setColumnFamilies($MapField);
        $fakeTable->setGranularity(2);

        $mock = $this->createMock(BigtableTable::class);
        $mock->method('createTableWithColumnFamily')
             ->willReturn($fakeTable);
        $table = $mock->createTableWithColumnFamily(Argument::type('string'), Argument::type('string'), Argument::type('string'));
        
        $this->assertInstanceOf(Table::class, $table);
        $this->assertEquals($table->getName(), $parent);
    }
    
    public function testColumnFamily()
    {
        $columnFamily = 'cf';
        $gcRule = new GcRule();
		$gcRule->setMaxNumVersions(2);

		$cf = new ColumnFamily();
		$cf->setGcRule($gcRule);

		$MapField = new MapField(GPBType::STRING, GPBType::MESSAGE, ColumnFamily::class );
        $MapField[$columnFamily] = $cf;

        $mock = $this->createMock(BigtableTable::class);
        $mock->method('columnFamily')
             ->willReturn($MapField);
        $MapField = $mock->columnFamily(Argument::type('integer'), Argument::type('string'));
        
        $this->assertInstanceOf(MapField::class, $MapField);
    }

    public function testDeleteTable()
    {
        $GPBEmpty = new GPBEmpty();
        $mock = $this->createMock(BigtableTable::class);
        $mock->method('deleteTable')
             ->willReturn($GPBEmpty);

        $table = $mock->deleteTable(Argument::type('string'));
        $this->assertInstanceOf(GPBEmpty::class, $table);
    }

    public function testGetTable()
    {
        $expected = 'projects/'.self::PROJECT_ID.'/instances/'.self::INSTANCE_ID.'/tables/'.self::TABLE_ID;
        $fakeTable = new Table();
        $fakeTable->setName($expected);

        $mock = $this->createMock(BigtableTable::class);
        $mock->method('getTable')
             ->willReturn($fakeTable);
        $table = $mock->getTable(Argument::type('string'));

        $this->assertInstanceOf(Table::class, $table);
        $this->assertEquals($table->getName(), $expected);
    }
    
    public function testAddColumnFamilies()
    {
        $parent = 'projects/'.self::PROJECT_ID.'/instances/'.self::INSTANCE_ID.'/tables/'.self::TABLE_ID;
        $cfName = 'cf';

        $fakeTable = new Table();
        $fakeTable->setName($parent);

        $mock = $this->createMock(BigtableTable::class);
        $mock->method('addColumnFamilies')
             ->willReturn($fakeTable);
        $table = $mock->addColumnFamilies(Argument::type('string'), Argument::type('string'));

        $this->assertInstanceOf(Table::class, $table);
        $this->assertEquals($table->getName(), $parent);
    }

    public function testDeleteColumnFamilies()
    {
        $fakeTable = new Table();
        $mock = $this->createMock(BigtableTable::class);
        $mock->method('deleteColumnFamilies')
             ->willReturn($fakeTable);
        $table = $mock->deleteColumnFamilies(Argument::type('string'), Argument::type('string'));
        $this->assertInstanceOf(Table::class, $table);
    }

    public function testMutateRow()
    {
        $MutateRowResponse = new MutateRowResponse();
        $mock = $this->createMock(BigtableTable::class);
        $mock->method('mutateRow')
             ->willReturn($MutateRowResponse);

        $mutateRow = $mock->mutateRow(Argument::type('string'), Argument::type('string'), Argument::type('array'));
        $this->assertInstanceOf(MutateRowResponse::class, $mutateRow);
    }
    
    public function testMutationCell()
    {
        $cell['cf'] = 'cf';
        $cell['qualifier'] = 'qualifier';
        $cell['value'] = 'value';

        $utc_str           = gmdate("M d Y H:i:s", time());
	$utc               = strtotime($utc_str);
        $cell['timestamp'] = $utc;

        $Mutation_SetCell = new Mutation_SetCell();
        $Mutation_SetCell->setFamilyName($cell['cf']);
        $Mutation_SetCell->setColumnQualifier($cell['qualifier']);
        $Mutation_SetCell->setValue($cell['value']);
        $Mutation_SetCell->setTimestampMicros($cell['timestamp']);

        $Mutation = new Mutation();
        $Mutation->setSetCell($Mutation_SetCell);
        
        $mock = $this->createMock(BigtableTable::class);
        $mock->method('mutationCell')
             ->willReturn($Mutation);

        $mutationCell = $mock->mutationCell(Argument::type('array'));
        $this->assertInstanceOf(Mutation::class, $mutationCell);        
    }

    public function testMutateRowsRequest()
    {   
        $BigtableTable = new BigtableTable();
        $rowKey = 'perf';
        $utc_str           = gmdate("M d Y H:i:s", time());
        $utc               = strtotime($utc_str);
        $cell['cf']        = 'cf';
        $cell['qualifier'] = 'qualifier';
        $cell['value']     = 'value';
        $cell['timestamp'] = $utc*1000;
        $mutations[] = $BigtableTable->mutationCell($cell);
                    
        $MutateRowsRequest_Entry = new MutateRowsRequest_Entry();
        $MutateRowsRequest_Entry->setRowKey($rowKey);
        $MutateRowsRequest_Entry->setMutations($mutations);
        
        $mock = $this->createMock(BigtableTable::class);
        $mock->method('mutateRowsRequest')
             ->willReturn($MutateRowsRequest_Entry);

        $mutateRowsRequest = $mock->mutateRowsRequest(Argument::type('string'), Argument::type('array'));
        $this->assertEquals($mutateRowsRequest->getRowKey(), $rowKey);
        $this->assertInstanceOf(RepeatedField::class, $mutateRowsRequest->getMutations());
        $this->assertInstanceOf(MutateRowsRequest_Entry::class, $mutateRowsRequest);
    }

    public function testReadRows()
    {   
        $FlatRow = new FlatRow();
        $mock = $this->createMock(BigtableTable::class);
        $mock->method('readRows')
             ->willReturn($FlatRow);

        $readRows = $mock->readRows(Argument::type('string'));
        $this->assertInstanceOf(FlatRow::class, $readRows);
    }
}
?>

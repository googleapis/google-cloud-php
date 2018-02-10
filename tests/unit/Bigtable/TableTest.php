<?php
/*
 * Copyright 2017 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     https://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Google\Cloud\Tests\Unit\Bigtable;

use Google\Cloud\Bigtable\src\BigtableTable;
use Google\Cloud\Bigtable\Admin\V2\Table;
use Google\Protobuf\GPBEmpty;

use Google\Cloud\Bigtable\Admin\V2\ColumnFamily;
use Google\Cloud\Bigtable\Admin\V2\GcRule;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\MapField;
use Google\Cloud\Bigtable\Admin\V2\ModifyColumnFamiliesRequest;
use Google\Cloud\Bigtable\Admin\V2\ModifyColumnFamiliesRequest_Modification as Modification;

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

    public $mock;

    public function setUp()
    {
        $this->mock = $this->getMockBuilder(BigtableTable::class)
                            ->disableOriginalConstructor()
                            ->getMock();
    }

    public function testInstanceName()
    {
        $expected = 'projects/'.self::PROJECT_ID.'/instances/'.self::INSTANCE_ID;
        $this->mock->method('instanceName')
             ->willReturn($expected);

        $formatedName = $this->mock->instanceName(Argument::type('string'), Argument::type('string'));
        $this->assertEquals($formatedName, $expected);
    }
    
    public function testCreateTable()
    {
        $parent = 'projects/'.self::PROJECT_ID.'/instances/'.self::INSTANCE_ID;
        $fakeTable = new Table();
        $fakeTable->setName($parent);

        $this->mock->method('createTable')
             ->willReturn($fakeTable);

        $table = $this->mock->createTable(Argument::type('string'), Argument::type('string'));
        $this->assertEquals($table->getName(), $parent);
        $this->assertInstanceOf(Table::class, $table);
    }
    
    public function testTableName()
    {
        $expected = 'projects/'.self::PROJECT_ID.'/instances/'.self::INSTANCE_ID.'/tables/'.self::TABLE_ID;
        $this->mock->method('tableName')
             ->willReturn($expected);

        $formatedName = $this->mock->tableName(Argument::type('string'), Argument::type('string'), Argument::type('string'));
        $this->assertEquals($formatedName, $expected);
    }

    public function testCreateTableWithColumnFamily()
    {
        $columnFamily = 'cf';
        $parent = 'projects/'.self::PROJECT_ID.'/instances/'.self::INSTANCE_ID;
        
        $fakeTable = new Table();
        $fakeTable->setName($parent);

        //Set GcRule
        $gcRule = new GcRule();
		$gcRule->setMaxNumVersions(2);

		$cf = new ColumnFamily();
		$cf->setGcRule($gcRule);

		$MapField = new MapField(GPBType::STRING, GPBType::MESSAGE, ColumnFamily::class );
        $MapField[$columnFamily] = $cf;

        $fakeTable->setColumnFamilies($MapField);
        $fakeTable->setGranularity(2);

        $this->mock->method('createTableWithColumnFamily')
             ->willReturn($fakeTable);
        $table = $this->mock->createTableWithColumnFamily(Argument::type('string'), Argument::type('string'), Argument::type('string'));
        
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

        $this->mock->method('columnFamily')
             ->willReturn($MapField);
        $MapField = $this->mock->columnFamily(Argument::type('integer'), Argument::type('string'));
        
        $this->assertInstanceOf(MapField::class, $MapField);
    }

    public function testDeleteTable()
    {
        $GPBEmpty = new GPBEmpty();
        $this->mock->method('deleteTable')
             ->willReturn($GPBEmpty);

        $table = $this->mock->deleteTable(Argument::type('string'));
        $this->assertInstanceOf(GPBEmpty::class, $table);
    }

    public function testGetTable()
    {
        $expected = 'projects/'.self::PROJECT_ID.'/instances/'.self::INSTANCE_ID.'/tables/'.self::TABLE_ID;
        $fakeTable = new Table();
        $fakeTable->setName($expected);

        $this->mock->method('getTable')
             ->willReturn($fakeTable);
        $table = $this->mock->getTable(Argument::type('string'));

        $this->assertInstanceOf(Table::class, $table);
        $this->assertEquals($table->getName(), $expected);
    }
    
    public function testAddColumnFamilies()
    {
        $parent = 'projects/'.self::PROJECT_ID.'/instances/'.self::INSTANCE_ID.'/tables/'.self::TABLE_ID;
        $cfName = 'cf';

        $fakeTable = new Table();
        $fakeTable->setName($parent);

        $this->mock->method('addColumnFamilies')
             ->willReturn($fakeTable);
        $table = $this->mock->addColumnFamilies(Argument::type('string'), Argument::type('string'));

        $this->assertInstanceOf(Table::class, $table);
        $this->assertEquals($table->getName(), $parent);
    }

    public function testDeleteColumnFamilies()
    {
        $fakeTable = new Table();
        $this->mock->method('deleteColumnFamilies')
             ->willReturn($fakeTable);
        $table = $this->mock->deleteColumnFamilies(Argument::type('string'), Argument::type('string'));
        $this->assertInstanceOf(Table::class, $table);
    }

    public function testMutateRow()
    {
        $MutateRowResponse = new MutateRowResponse();
        $this->mock->method('mutateRow')
             ->willReturn($MutateRowResponse);

        $mutateRow = $this->mock->mutateRow(Argument::type('string'), Argument::type('string'), Argument::type('array'));
        $this->assertInstanceOf(MutateRowResponse::class, $mutateRow);
    }
    
    public function testMutationCell()
    {
        $utc_str = gmdate("M d Y H:i:s", time());
	    $utc = strtotime($utc_str);
        $Mutation_SetCell = new Mutation_SetCell();
        $Mutation_SetCell->setFamilyName('cf');
        $Mutation_SetCell->setColumnQualifier('qualifier');
        $Mutation_SetCell->setValue('value');
        $Mutation_SetCell->setTimestampMicros($utc*1000);

        $Mutation = new Mutation();
        $Mutation->setSetCell($Mutation_SetCell);
        
        $this->mock->method('mutationCell')
             ->willReturn($Mutation);

        $mutationCell = $this->mock->mutationCell(Argument::type('array'));
        $this->assertInstanceOf(Mutation::class, $mutationCell);        
    }

    public function testMutateRowsRequest()
    {
        $rowKey = 'perf';
        $utc_str           = gmdate("M d Y H:i:s", time());
        $utc               = strtotime($utc_str);

        //Set cell
        $Mutation_SetCell = new Mutation_SetCell();
        $Mutation_SetCell->setFamilyName('cf');
        $Mutation_SetCell->setColumnQualifier('qualifier');
        $Mutation_SetCell->setValue('value');
        $Mutation_SetCell->setTimestampMicros($utc*1000);
        
        //Set mutations cell
        $Mutation = new Mutation();
        $Mutation->setSetCell($Mutation_SetCell);
        $mutations[] = $Mutation;
                    
        $MutateRowsRequest_Entry = new MutateRowsRequest_Entry();
        $MutateRowsRequest_Entry->setRowKey($rowKey);
        $MutateRowsRequest_Entry->setMutations($mutations);
        
        $this->mock->method('mutateRowsRequest')
             ->willReturn($MutateRowsRequest_Entry);

        $mutateRowsRequest = $this->mock->mutateRowsRequest(Argument::type('string'), Argument::type('array'));
        $this->assertEquals($mutateRowsRequest->getRowKey(), $rowKey);
        $this->assertInstanceOf(RepeatedField::class, $mutateRowsRequest->getMutations());
        $this->assertInstanceOf(MutateRowsRequest_Entry::class, $mutateRowsRequest);
    }

    public function testReadRows()
    {   
        $FlatRow = new FlatRow();
        $this->mock->method('readRows')
             ->willReturn($FlatRow);

        $readRows = $this->mock->readRows(Argument::type('string'));
        $this->assertInstanceOf(FlatRow::class, $readRows);
    }
}

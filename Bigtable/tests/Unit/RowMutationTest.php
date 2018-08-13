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

use Google\Cloud\Bigtable\RowMutation;
use Google\Cloud\Bigtable\V2\MutateRowsRequest_Entry;
use Google\Cloud\Bigtable\V2\Mutation;
use Google\Cloud\Bigtable\V2\Mutation_DeleteFromColumn;
use Google\Cloud\Bigtable\V2\Mutation_DeleteFromFamily;
use Google\Cloud\Bigtable\V2\Mutation_DeleteFromRow;
use Google\Cloud\Bigtable\V2\Mutation_SetCell;
use Google\Cloud\Bigtable\V2\TimestampRange;
use PHPUnit\Framework\TestCase;

/**
 * @group bigtable
 * @group bigtabledata
 */
class RowMutationTest extends TestCase
{
    const ROW_KEY = 'r1';
    const COLUMN_FAMILY = 'cf1';
    const COLUMN_QUALIFIER = 'cq1';
    const VALUE = 'value1';

    private $rowMutation;

    public function setUp()
    {
        $this->rowMutation = new RowMutation(self::ROW_KEY);
    }

    public function testGetRowKey()
    {
        $this->assertEquals(self::ROW_KEY, $this->rowMutation->getRowKey());
    }

    public function testUpsertWithTimeRange()
    {
        $return = $this->rowMutation->upsert(self::COLUMN_FAMILY, self::COLUMN_QUALIFIER, self::VALUE, 1534175145);

        $entry = $this->rowMutation->getEntry();
        $mutationSetCell = new Mutation_SetCell;
        $mutationSetCell->setFamilyName(self::COLUMN_FAMILY)
            ->setColumnQualifier(self::COLUMN_QUALIFIER)
            ->setValue(self::VALUE)
            ->setTimestampMicros(1534175145);
        $mutation = new Mutation;
        $mutation->setSetCell($mutationSetCell);
        $mutateRowsRequestEntry = $this->getMutateRowsRequestEntry($mutation);
        $this->assertEquals($this->rowMutation, $return);
        $this->assertEquals($mutateRowsRequestEntry, $entry);
    }

    public function testDeleteFromFamily()
    {
        $return = $this->rowMutation->deleteFromFamily(self::COLUMN_FAMILY);
        $entry = $this->rowMutation->getEntry();
        $deleteFromFamily = new Mutation_DeleteFromFamily;
        $deleteFromFamily->setFamilyName(self::COLUMN_FAMILY);
        $mutation = new Mutation;
        $mutation->setDeleteFromFamily($deleteFromFamily);
        $mutateRowsRequestEntry = $this->getMutateRowsRequestEntry($mutation);
        $this->assertEquals($this->rowMutation, $return);
        $this->assertEquals($mutateRowsRequestEntry, $entry);
    }

    public function testDeleteFromColumn()
    {
        $return = $this->rowMutation->deleteFromColumn(self::COLUMN_FAMILY, self::COLUMN_QUALIFIER);
        $entry = $this->rowMutation->getEntry();
        $deleteFromColumn = new Mutation_DeleteFromColumn;
        $deleteFromColumn->setFamilyName(self::COLUMN_FAMILY)->setColumnQualifier(self::COLUMN_QUALIFIER);
        $mutation = new Mutation;
        $mutation->setDeleteFromColumn($deleteFromColumn);
        $mutateRowsRequestEntry = $this->getMutateRowsRequestEntry($mutation);
        $this->assertEquals($this->rowMutation, $return);
        $this->assertEquals($mutateRowsRequestEntry, $entry);
    }

    public function testDeleteFromColumnWithTimeRange()
    {
        $return = $this->rowMutation->deleteFromColumn(
            self::COLUMN_FAMILY,
            self::COLUMN_QUALIFIER,
            ['start' => 1, 'end' => 5]
        );
        $entry = $this->rowMutation->getEntry();
        $deleteFromColumn = new Mutation_DeleteFromColumn;
        $deleteFromColumn->setFamilyName(self::COLUMN_FAMILY)
            ->setColumnQualifier(self::COLUMN_QUALIFIER);
        $timestampRange = new TimestampRange;
        $timestampRange->setStartTimestampMicros(1);
        $timestampRange->setEndTimestampMicros(5);
        $deleteFromColumn->setTimeRange($timestampRange);
        $mutation = new Mutation;
        $mutation->setDeleteFromColumn($deleteFromColumn);
        $mutateRowsRequestEntry = $this->getMutateRowsRequestEntry($mutation);
        $this->assertEquals($this->rowMutation, $return);
        $this->assertEquals($mutateRowsRequestEntry, $entry);
    }

    public function testDeleteRow()
    {
        $return = $this->rowMutation->deleteRow();
        $entry = $this->rowMutation->getEntry();
        $mutation = new Mutation;
        $mutation->setDeleteFromRow(new Mutation_DeleteFromRow);
        $mutateRowsRequestEntry = $this->getMutateRowsRequestEntry($mutation);
        $this->assertEquals($this->rowMutation, $return);
        $this->assertEquals($mutateRowsRequestEntry, $entry);
    }

    private function getMutateRowsRequestEntry($mutation)
    {
        $mutateRowsRequestEntry = new MutateRowsRequest_Entry;
        $mutateRowsRequestEntry->setRowKey(self::ROW_KEY);
        $mutateRowsRequestEntry->setMutations([$mutation]);
        return $mutateRowsRequestEntry;
    }
}

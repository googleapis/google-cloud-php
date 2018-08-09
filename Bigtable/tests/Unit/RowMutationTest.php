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
        $this->rowMutation = new RowMutation(ROW_KEY);
    }

    public function testGetRowKey()
    {
        $this->assertEquals(ROW_KEY, $this->rowMutation->getRowKey());
    }

    public function testUpsert()
    {
        $this->rowMutation->upsert(COLUMN_FAMILY, COLUMN_QUALIFIER, VALUE);

        $entry = $this->rowMutation->getEntry();
        $mutationSetCell = new Mutation_SetCell;
        $mutationSetCell->setFamilyName(COLUMN_FAMILY)->setColumnQualifier(COLUMN_QUALIFIER)
                        ->setValue(VALUE);
        $mutation = new Mutation;
        $mutation->setSetCell($mutationSetCell);
        $mutateRowsRequestEntry = $this->getMutateRowsRequestEntry($mutation);
        $this->assertEquals($mutateRowsRequestEntry, $entry);
    }

    public function testUpsertWithTimeRange()
    {
        $this->rowMutation->upsert(COLUMN_FAMILY, COLUMN_QUALIFIER, VALUE, 20);

        $entry = $this->rowMutation->getEntry();
        $mutationSetCell = new Mutation_SetCell;
        $mutationSetCell->setFamilyName(COLUMN_FAMILY)->setColumnQualifier(COLUMN_QUALIFIER)
                        ->setValue(VALUE)
                        ->setTimestampMicros(20);
        $mutation = new Mutation;
        $mutation->setSetCell($mutationSetCell);
        $mutateRowsRequestEntry = $this->getMutateRowsRequestEntry($mutation);
        $this->assertEquals($mutateRowsRequestEntry, $entry);
    }

    public function testDeleteFromFamily()
    {
        $this->rowMutation->deleteFromFamily(COLUMN_FAMILY);
        $entry = $this->rowMutation->getEntry();
        $deleteFromFamily = new Mutation_DeleteFromFamily;
        $deleteFromFamily->setFamilyName(COLUMN_FAMILY);
        $mutation = new Mutation;
        $mutation->setDeleteFromFamily($deleteFromFamily);
        $mutateRowsRequestEntry = $this->getMutateRowsRequestEntry($mutation);
        $this->assertEquals($mutateRowsRequestEntry, $entry);
    }

    public function testDeleteFromColumn()
    {
        $this->rowMutation->deleteFromColumn(COLUMN_FAMILY, COLUMN_QUALIFIER);
        $entry = $this->rowMutation->getEntry();
        $deleteFromColumn = new Mutation_DeleteFromColumn;
        $deleteFromColumn->setFamilyName(COLUMN_FAMILY)->setColumnQualifier(COLUMN_QUALIFIER);
        $mutation = new Mutation;
        $mutation->setDeleteFromColumn($deleteFromColumn);
        $mutateRowsRequestEntry = $this->getMutateRowsRequestEntry($mutation);
        $this->assertEquals($mutateRowsRequestEntry, $entry);
    }

    public function testDeleteFromColumnWithTimeRange()
    {
        $this->rowMutation->deleteFromColumn(COLUMN_FAMILY, COLUMN_QUALIFIER, ['start' => 1, 'end' => 5]);
        $entry = $this->rowMutation->getEntry();
        $deleteFromColumn = new Mutation_DeleteFromColumn;
        $deleteFromColumn->setFamilyName(COLUMN_FAMILY)->setColumnQualifier(COLUMN_QUALIFIER);
        $timestampRange = new TimestampRange;
        $timestampRange->setStartTimestampMicros(1);
        $timestampRange->setEndTimestampMicros(5);
        $deleteFromColumn->setTimeRange($timestampRange);
        $mutation = new Mutation;
        $mutation->setDeleteFromColumn($deleteFromColumn);
        $mutateRowsRequestEntry = $this->getMutateRowsRequestEntry($mutation);
        $this->assertEquals($mutateRowsRequestEntry, $entry);
    }

    public function testDeleteFromRow()
    {
        $this->rowMutation->deleteFromRow();
        $entry = $this->rowMutation->getEntry();
        $mutation = new Mutation;
        $mutation->setDeleteFromRow(new Mutation_DeleteFromRow);
        $mutateRowsRequestEntry = $this->getMutateRowsRequestEntry($mutation);
        $this->assertEquals($mutateRowsRequestEntry, $entry);
    }

    private function getMutateRowsRequestEntry($mutation)
    {
        $mutateRowsRequestEntry = new MutateRowsRequest_Entry;
        $mutateRowsRequestEntry->setRowKey(ROW_KEY);
        $mutateRowsRequestEntry->setMutations([$mutation]);
        return $mutateRowsRequestEntry;
    }
}

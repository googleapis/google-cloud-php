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

use Google\Cloud\Bigtable\Mutations;
use Google\Cloud\Bigtable\V2\Mutation;
use Google\Cloud\Bigtable\V2\Mutation\DeleteFromColumn;
use Google\Cloud\Bigtable\V2\Mutation\DeleteFromFamily;
use Google\Cloud\Bigtable\V2\Mutation\DeleteFromRow;
use Google\Cloud\Bigtable\V2\Mutation\SetCell;
use Google\Cloud\Bigtable\V2\TimestampRange;
use Yoast\PHPUnitPolyfills\TestCases\TestCase;

/**
 * @group bigtable
 * @group bigtabledata
 */
class MutationsTest extends TestCase
{
    const COLUMN_FAMILY = 'cf1';
    const COLUMN_QUALIFIER = 'cq1';
    const VALUE = 'value1';
    const TIMESTAMP_VALUE = 315532800.000000;

    private $mutations;

    public function set_up()
    {
        $this->mutations = new MutationsStub;
    }

    public function testUpsert()
    {
        $return = $this->mutations->upsert(
            self::COLUMN_FAMILY,
            self::COLUMN_QUALIFIER,
            self::VALUE
        );
        $proto = $this->mutations->toProto();
        $expectedProto[] = (new Mutation)
            ->setSetCell(
                (new SetCell)
                    ->setFamilyName(self::COLUMN_FAMILY)
                    ->setColumnQualifier(self::COLUMN_QUALIFIER)
                    ->setValue(self::VALUE)
                    ->setTimestampMicros(315532800000000)
            );
        $this->assertEquals($this->mutations, $return);
        $this->assertEquals($expectedProto, $proto);
    }

    public function testUpsertWithTimeRange()
    {
        $return = $this->mutations->upsert(
            self::COLUMN_FAMILY,
            self::COLUMN_QUALIFIER,
            self::VALUE,
            1534183334215000
        );
        $proto = $this->mutations->toProto();
        $expectedProto[] = (new Mutation)
            ->setSetCell(
                (new SetCell)
                    ->setFamilyName(self::COLUMN_FAMILY)
                    ->setColumnQualifier(self::COLUMN_QUALIFIER)
                    ->setValue(self::VALUE)
                    ->setTimestampMicros(1534183334215000)
            );
        $this->assertEquals($this->mutations, $return);
        $this->assertEquals($expectedProto, $proto);
    }

    public function testDeleteFromFamily()
    {
        $return = $this->mutations->deleteFromFamily(self::COLUMN_FAMILY);
        $proto = $this->mutations->toProto();
        $expectedProto[] = (new Mutation)
            ->setDeleteFromFamily(
                (new DeleteFromFamily)->setFamilyName(self::COLUMN_FAMILY)
            );
        $this->assertEquals($this->mutations, $return);
        $this->assertEquals($expectedProto, $proto);
    }

    public function testDeleteFromColumn()
    {
        $return = $this->mutations->deleteFromColumn(self::COLUMN_FAMILY, self::COLUMN_QUALIFIER);
        $proto = $this->mutations->toProto();
        $expectedProto[] = (new Mutation)
            ->setDeleteFromColumn(
                (new DeleteFromColumn)
                    ->setFamilyName(self::COLUMN_FAMILY)
                    ->setColumnQualifier(self::COLUMN_QUALIFIER)
            );
        $this->assertEquals($this->mutations, $return);
        $this->assertEquals($expectedProto, $proto);
    }

    public function testDeleteFromColumnWithTimeRange()
    {
        $return = $this->mutations->deleteFromColumn(
            self::COLUMN_FAMILY,
            self::COLUMN_QUALIFIER,
            ['start' => 1, 'end' => 5]
        );
        $proto = $this->mutations->toProto();
        $expectedProto[] = (new Mutation)
            ->setDeleteFromColumn(
                (new DeleteFromColumn)
                    ->setFamilyName(self::COLUMN_FAMILY)
                    ->setColumnQualifier(self::COLUMN_QUALIFIER)
                    ->setTimeRange(
                        (new TimestampRange)
                            ->setStartTimestampMicros(1)
                            ->setEndTimestampMicros(5)
                    )
            );
        $this->assertEquals($this->mutations, $return);
        $this->assertEquals($expectedProto, $proto);
    }

    public function testDeleteRow()
    {
        $return = $this->mutations->deleteRow();
        $proto = $this->mutations->toProto();
        $expectedProto[] = (new Mutation)->setDeleteFromRow(new DeleteFromRow);
        $this->assertEquals($this->mutations, $return);
        $this->assertEquals($expectedProto, $proto);
    }
}

//@codingStandardsIgnoreStart
class MutationsStub extends Mutations
{
    protected function microtime()
    {
        return MutationsTest::TIMESTAMP_VALUE;
    }
}
//@codingStandardsIgnoreEnd

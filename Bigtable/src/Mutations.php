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

namespace Google\Cloud\Bigtable;

use Google\Cloud\Bigtable\V2\Mutation;
use Google\Cloud\Bigtable\V2\Mutation\DeleteFromColumn;
use Google\Cloud\Bigtable\V2\Mutation\DeleteFromFamily;
use Google\Cloud\Bigtable\V2\Mutation\DeleteFromRow;
use Google\Cloud\Bigtable\V2\Mutation\SetCell;
use Google\Cloud\Bigtable\V2\TimestampRange;

/**
 * Represents a Mutation to perform data operation on Bigtable table.
 * This is used to insert,update, delete operation on row in Bigtable table.
 */
class Mutations
{
    /**
     * @var array Mutation
     */
    private $mutations = [];

    /**
     * @var array
     */
    private $options;

    public function __construct(array $options = [])
    {
        $this->options = $options;
    }

    /**
     * Creates Insert/Update mutation for a row.
     *
     * @param string $family Family name of the row.
     * @param string $qualifier Column qualifier of the row.
     * @param string $value Value of the Column qualifier.
     * @param int $timeStamp optional timestamp value.
     *
     * @return Mutations returns current Mutations object.
     */
    public function upsert($family, $qualifier, $value, $timeStamp = null)
    {
        $mutationSetCell = (new SetCell)
            ->setFamilyName($family)
            ->setColumnQualifier($qualifier)
            ->setValue($value);
        if ($timeStamp === null) {
            $mutationSetCell->setTimestampMicros(
                // gives milli second
                round(microtime(true) * 1000)
                // multiply by 1000 to get micro
                * 1000
            );
        } else {
            $mutationSetCell->setTimestampMicros($timeStamp);
        }
        $this->mutations[] = (new Mutation)->setSetCell($mutationSetCell);
        return $this;
    }

    /**
     * Creates delete from family mutation for a row.
     *
     * @param string $family Family name of the row.
     *
     * @return Mutations returns current Mutations object.
     */
    public function deleteFromFamily($family)
    {
        $this->mutations[] = (new Mutation)
            ->setDeleteFromFamily(
                (new DeleteFromFamily)->setFamilyName($family)
            );
        return $this;
    }

    /**
     * Creates delete from column mutation for a row.
     *
     * @param string $family Family name of the row.
     * @param string $qualifier Column qualifier of the row.
     * @param array $timeRange optional array of time range to delete from column,
     *        keyed by `start` and `end` representing time range window.
     * @return Mutations returns current Mutations object.
     */
    public function deleteFromColumn($family, $qualifier, array $timeRange = [])
    {
        $deleteFromColumn = (new DeleteFromColumn)
            ->setFamilyName($family)
            ->setColumnQualifier($qualifier);
        if (!empty($timeRange)) {
            $deleteFromColumn->setTimeRange(
                (new TimestampRange)
                    ->setStartTimestampMicros($timeRange['start'])
                    ->setEndTimestampMicros($timeRange['end'])
            );
        }
        $this->mutations[] = (new Mutation)->setDeleteFromColumn($deleteFromColumn);
        return $this;
    }

    /**
     * Creates delete row mutation for a row.
     *
     * @return Mutations returns current Mutations object.
     */
    public function deleteRow()
    {
        $this->mutations[] = (new Mutation)->setDeleteFromRow(new DeleteFromRow);
        return $this;
    }

    /**
     * Returns protobuf representation of Mutations.
     *
     * @return array returns array of protobuf representation of Mutations.
     */
    public function toProto()
    {
        return $this->mutations;
    }
}

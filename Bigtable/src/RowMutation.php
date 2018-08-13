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

use Google\Cloud\Bigtable\V2\MutateRowsRequest_Entry;
use Google\Cloud\Bigtable\V2\Mutation;
use Google\Cloud\Bigtable\V2\Mutation_DeleteFromColumn;
use Google\Cloud\Bigtable\V2\Mutation_DeleteFromFamily;
use Google\Cloud\Bigtable\V2\Mutation_DeleteFromRow;
use Google\Cloud\Bigtable\V2\Mutation_SetCell;
use Google\Cloud\Bigtable\V2\TimestampRange;

/**
 * Represents a RowMutation to perform data operation on Bigtable table.
 * This is used to insert,update, delete operation on row in Bigtable table.
 *
 */
class RowMutation
{

    /**
     * @var string
     */
    private $rowKey;

    /**
     * @var array Mutation
     */
    private $mutations = [];

    public function __construct($rowKey, array $options = [])
    {
        $this->rowKey = $rowKey;
    }

    /**
     * Return the row key.
     *
     * @return string RowKey of the Row.
     */
    public function getRowKey()
    {
        return $this->rowKey;
    }

    /**
     * Creates Insert/Update mutation for a row.
     *
     * @param string $family Family name of the row.
     * @param string $qualifier Column qualifier of the row.
     * @param string $value Value of the Column qualifier.
     * @param int $timeStamp optional timestamp value.
     *
     * @return RowMutation returns current RowMutation object.
     */
    public function upsert($family, $qualifier, $value, $timeStamp = null)
    {
        $mutation = new Mutation;
        $mutationSetCell = new Mutation_SetCell;
        $mutationSetCell->setFamilyName($family)
            ->setColumnQualifier($qualifier)
            ->setValue($value);
        if ($timeStamp === null) {
            $mutationSetCell->setTimestampMicros(
                //gives milli second
                round(microtime(true) * 1000)
                // multiply by 1000 to get micro
                * 1000
            );
        } else {
            $mutationSetCell->setTimestampMicros($timeStamp);
        }
        $mutation->setSetCell($mutationSetCell);
        $this->mutations[] = $mutation;
        return $this;
    }

    /**
     * Creates delete from family mutation for a row.
     *
     * @param string $family Family name of the row.
     *
     * @return RowMutation returns current RowMutation object.
     */
    public function deleteFromFamily($family)
    {
        $mutation = new Mutation;
        $deleteFromFamily = new Mutation_DeleteFromFamily;
        $deleteFromFamily->setFamilyName($family);
        $mutation->setDeleteFromFamily($deleteFromFamily);
        $this->mutations[] = $mutation;
        return $this;
    }

    /**
     * Creates delete from column mutation for a row.
     *
     * @param string $family Family name of the row.
     * @param string $qualifier Column qualifier of the row.
     * @param array $timeRange optional array of time range to delete from column,
     *        keyed by `start` and `end` representing time range window.
     * @return RowMutation returns current RowMutation object.
     */
    public function deleteFromColumn($family, $qualifier, array $timeRange = [])
    {
        $mutation = new Mutation;
        $deleteFromColumn = new Mutation_DeleteFromColumn;
        $deleteFromColumn->setFamilyName($family)->setColumnQualifier($qualifier);
        if (!empty($timeRange)) {
            $timestampRange = new TimestampRange;
            $timestampRange->setStartTimestampMicros($timeRange['start']);
            $timestampRange->setEndTimestampMicros($timeRange['end']);
            $deleteFromColumn->setTimeRange($timestampRange);
        }
        $mutation->setDeleteFromColumn($deleteFromColumn);
        $this->mutations[] = $mutation;
        return $this;
    }

    /**
     * Creates delete row mutation for a row.
     *
     * @return RowMutation returns current RowMutation object.
     */
    public function deleteRow()
    {
        $mutation = new Mutation;
        $mutation->setDeleteFromRow(new Mutation_DeleteFromRow);
        $this->mutations[] = $mutation;
        return $this;
    }

    /**
     * Returns proto represenation of RowMutation.
     *
     * @return MutateRowsRequest_Entry Entry for Row.
     */
    public function getEntry()
    {
        $mutateRowsRequestEntry = new MutateRowsRequest_Entry;
        $mutateRowsRequestEntry->setRowKey($this->rowKey);
        $mutateRowsRequestEntry->setMutations($this->mutations);
        return $mutateRowsRequestEntry;
    }
}

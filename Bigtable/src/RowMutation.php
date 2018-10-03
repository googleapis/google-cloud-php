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

use Google\Cloud\Bigtable\Mutations;
use Google\Cloud\Bigtable\V2\MutateRowsRequest\Entry;

/**
 * Represents a RowMutation to perform data operation on Bigtable table.
 * This is used to insert,update, delete operation on row in Bigtable table.
 */
class RowMutation
{
    /**
     * @var string
     */
    private $rowKey;

    /**
     * @var Mutations
     */
    private $mutations;

    public function __construct($rowKey, array $options = [])
    {
        $this->rowKey = $rowKey;
        $this->mutations = new Mutations($options);
    }

    /**
     * Returns the row key.
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
        $this->mutations->upsert($family, $qualifier, $value, $timeStamp);
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
        $this->mutations->deleteFromFamily($family);
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
        $this->mutations->deleteFromColumn($family, $qualifier, $timeRange);
        return $this;
    }

    /**
     * Creates delete row mutation for a row.
     *
     * @return RowMutation returns current RowMutation object.
     */
    public function deleteRow()
    {
        $this->mutations->deleteRow();
        return $this;
    }

    /**
     * Returns proto representation of RowMutation.
     *
     * @return Entry Entry for Row.
     */
    public function toProto()
    {
        $mutateRowsRequestEntry = new Entry;
        $mutateRowsRequestEntry->setRowKey($this->rowKey);
        $mutateRowsRequestEntry->setMutations($this->mutations->toProto());
        return $mutateRowsRequestEntry;
    }
}

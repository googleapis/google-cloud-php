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

namespace Google\Cloud\Bigtable\V2;

/**
 *
 */
class FlatRow
{

    private $rowKey = null;
    private $cells  = [];

    /**
     * @param string $rowKey
     * @param string $cells
     */
    public function setFlatRow($rowKey, $cells)
    {
        $this->rowKey = $rowKey;
        $this->cells  = $cells;
    }

    /**
     * Reset rowKey and cells
     */
    public function reSetFlatRow()
    {
        $this->rowKey = '';
        $this->cells  = [];
    }

    /**
     * @param string $rowKey
     */
    public function setRowKey($rowKey)
    {
        $this->rowKey = $rowKey;
    }

    /**
     * @return string
     */
    public function getRowKey()
    {
        return $this->rowKey;
    }

    /**
     * @param $cell Google\Cloud\Bigtable\V2\Cell
     */
    public function setCells($cell)
    {
        $this->cells = $cell;
    }

    /**
     * @return Google\Cloud\Bigtable\V2\Cell
     */
    public function getCells()
    {
        return $this->cells;
    }

    /**
     * @param $cell Google\Cloud\Bigtable\V2\Cell
     */
    public function addCell($cell)
    {
        array_push($this->cells, $cell);
    }
}

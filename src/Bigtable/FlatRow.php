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

namespace Google\Cloud\Bigtable;

/**
 * Set and get cell values.
 *
 * Example:
 * ```
 * use Google\Cloud\Bigtable;
 *
 * $flatRow = new FlatRow();
 *
 * $rowKey = 'perf';
 * $cells = [];
 * $flatRow->setFlatRow($rowKey, $cells);
 * ```
 *
 */
class FlatRow
{
    /**
     * @var string
     */
    private $rowKey = null;

    /**
     * @var array
     */
    private $cells  = [];

    /**
     * Set rowKey and cell values to be form in array.
     *
     * Example:
     * ```
     * $rowKey = 'perf';
     * $cells = [];
     * $flatRow->setFlatRow($rowKey, $cells);
     * ```
     *
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
     *
     * Example:
     * ```
     * $flatRow->reSetFlatRow();
     * ```
     *
     */
    public function reSetFlatRow()
    {
        $this->rowKey = '';
        $this->cells  = [];
    }

    /**
     * Set the rowKey of the row.
     *
     * Example:
     * ```
     * $rowKey = 'perf';
     * $flatRow->setFlatRow($rowKey);
     * ```
     *
     * @param string $rowKey
     */
    public function setRowKey($rowKey)
    {
        $this->rowKey = $rowKey;
    }

    /**
     * Get the rowKey of the row.
     *
     * Example:
     * ```
     * $rowKey = $flatRow->getRowKey();
     * ```
     *
     * @return string
     */
    public function getRowKey()
    {
        return $this->rowKey;
    }

    /**
     * Set the cell object.
     *
     * Example:
     * ```
     * $cell = new Cell();
     * $flatRow->setCells($cell);
     * ```
     *
     * @param $cell Google\Cloud\Bigtable\Cell
     */
    public function setCells($cell)
    {
        $this->cells = $cell;
    }

    /**
     * Get the cell object.
     *
     * Example:
     * ```
     * $cell = $flatRow->getCells();
     * ```
     *
     * @return Google\Cloud\Bigtable\Cell
     */
    public function getCells()
    {
        return $this->cells;
    }

    /**
     * Push ROW_IN_PROGRSS or ROW_IN_CELL to current row.
     *
     * Example:
     * ```
     * $cell = new Cell();
     * $flatRow->addCell($cell);
     * ```
     *
     * @param $cell Google\Cloud\Bigtable\Cell
     */
    public function addCell($cell)
    {
        array_push($this->cells, $cell);
    }
}

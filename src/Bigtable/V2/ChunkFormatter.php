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

use Google\Cloud\Bigtable\V2\Cell;
use Google\Cloud\Bigtable\V2\FlatRow;
use Google\ApiCore\ValidationException;

/**
 *
 */
class ChunkFormatter
{
    private $RowStateEnum;
    private $prevRowKey;
    private $familyName;
    private $qualifierName;
    private $state;
    private $serverStream;
    private $options;
    private $flatRow;
    private $cell;
    private $timestamp;
    private $lables;

    /**
     * Enum for chunk formatter Row state.
     * NEW_ROW: inital state or state after commitRow or resetRow
     * ROW_IN_PROGRESS: state after first valid chunk without commitRow or resetRow
     * CELL_IN_PROGRESS: state when valueSize > 0(partial cell)
     */
    public function __construct($stream, $options)
    {
        $this->serverStream = $stream;
        $this->options      = $options;
        $this->RowStateEnum = array(
            'NEW_ROW'          => 1,
            'ROW_IN_PROGRESS'  => 2,
            'CELL_IN_PROGRESS' => 3,
        );
        $this->reset();
    }

    /**
     * Formats the row chunks into friendly format. Chunks contain 3 properties:
     *
     * `rowContents` The row contents, this essentially is all data pertaining
     *     to a single family.
     *
     * `commitRow` This is a boolean telling us the all previous chunks for this
     *     row are ok to consume.
     *
     * `resetRow` This is a boolean telling us that all the previous chunks are to
     *     be discarded.
     *
     * @public
     * @throws Error if it detects invalid state
     */
    public function readAll()
    {
        foreach ($this->serverStream->readAll() as $readRowResponse) {
            foreach ($readRowResponse->getChunks() as $chunk) {
                switch ($this->state) {
                    case $this->RowStateEnum['NEW_ROW']:
                        $row = $this->newRow($chunk);
                        break;
                    case $this->RowStateEnum['ROW_IN_PROGRESS']:
                        $row = $this->rowInProgress($chunk);
                        break;
                    case $this->RowStateEnum['CELL_IN_PROGRESS']:
                        $row = $this->cellInProgress($chunk);
                        break;
                }
                if (!is_null($row)) {
                    yield $row;
                }
            }
        }
        $this->onStreamEnd();
    }

    /**
     * should be called at end of the stream to check if there is any pending row.
     * @public
     * @throws Error if there is any uncommitted row.
     */
    public function onStreamEnd()
    {
        $this->isError(
            !is_null($this->flatRow->getRowKey()),
            'Response ended with pending row without commit',
            $this->flatRow
        );
    }

    /**
     * Error checker if true throws error
     * @private
     * @param {boolean} $condition condition to evaluate
     * @param {string} $text Error text
     * @param {object} $chunk chunk object to append to text
     */
    public function isError($condition, $text, $chunk)
    {
        if ($condition) {
            throw new ValidationException($text);
        }
    }

    /**
     * Validates valuesize and commitrow in a chunk
     * @private
     * @param {chunk} $chunk to validate for valuesize and commitRow
     */
    public function validateValueSizeAndCommitRow($chunk)
    {
        $this->isError(
            $chunk->getValueSize() > 0 && $chunk->getCommitRow(),
            'A row cannot be have a value size and be a commit row',
            $chunk
        );
    }

    /**
     * Validates state for new row.
     * @private
     * @param {chunk} $chunk chunk to validate
     */
    public function validateNewRow($chunk)
    {
        $prevRowKey = $this->prevRowKey;
        $newRowKey  = $chunk->getRowKey();
        $this->isError(
            !is_null($this->flatRow->getRowKey()),
            'A new row cannot have existing state',
            $chunk
        );
        $this->isError(
            !$chunk->getRowKey() || $chunk->getRowKey() === '' || is_null($chunk->getRowKey()),
            'A row key must be set',
            $chunk
        );
        $this->isError($chunk->getResetRow(), 'A new row cannot be reset', $chunk);
        $this->isError(
            $prevRowKey === $newRowKey,
            'A commit happened but the same key followed',
            $chunk
        );
        $this->isError(!$chunk->getFamilyName(), 'A family must be set', $chunk);
        $this->isError(!$chunk->getQualifier(), 'A column qualifier must be set', $chunk);
        $this->validateValueSizeAndCommitRow($chunk);
    }

    /**
     * Resets state of formatter
     * @private
     */
    public function reset()
    {
        $this->prevRowKey    = '';
        $this->familyName    = '';
        $this->qualifierName = '';
        $this->state         = $this->RowStateEnum['NEW_ROW'];
        $this->lables        = '';
        $this->timestamp     = 0;
        $this->flatRow       = new FlatRow();
        $this->cell          = null;
    }

    /**
     * sets prevRowkey and calls reset when row is committed.
     * @private
     */
    public function commit()
    {
        $row = $this->flatRow;
        $this->reset();
        $this->prevRowKey = $row->getRowKey();
    }

    /**
     * Moves to next state in processing.
     * @private
     * @param {chunk}    $chunkchunk in process
     * @param {*}         $callback callback to call with row as and when generates
     */
    public function moveToNextState($chunk)
    {
        if ($chunk->getCommitRow()) {
            $flatRow = $this->flatRow;
            $this->commit();
            return $flatRow;
        } else {
            if ($chunk->getValueSize() > 0) {
                $this->state = $this->RowStateEnum['CELL_IN_PROGRESS'];
            } else {
                $this->state = $this->RowStateEnum['ROW_IN_PROGRESS'];
            }
        }
    }

    /**
     * Process chunk when in NEW_ROW state.
     * @private
     * @param {chunks} $chunks chunk to process
     */
    public function newRow($chunk)
    {
        $newRowKey = $chunk->getRowKey();
        $this->validateNewRow($chunk);
        $this->flatRow->setRowKey($newRowKey);
        $this->familyName    = $chunk->getFamilyName()->getValue();
        $this->qualifierName = $chunk->getQualifier()->getValue();
        $labels              = ($chunk->getLabels()->getIterator()->valid())?$chunk->getLabels()->getIterator()->current():'';
        $timestamp           = $chunk->getTimestampMicros();
        $this->cell          = new Cell();
        $this->cell->setFamily($this->familyName);
        $this->cell->setQualifier($this->qualifierName);
        $this->cell->setLabels($labels);
        $this->cell->setTimestamp($timestamp);
        $this->cell->setValue($chunk->getValue());
        $this->flatRow->addCell($this->cell);
        $test = $this->moveToNextState($chunk);
        return $test;
        // yield $test;
    }

    /**
     * Validates resetRow condition for chunk
     * @private
     * @param $chunk chunk to validate for resetrow
     */
    public function validateResetRow($chunk)
    {
        $this->isError(
            $chunk->getResetRow() &&
            ($chunk->getRowKey() ||
                $chunk->getFamilyName() ||
                $chunk->getQualifier() ||
                $chunk->getValue() ||
                $chunk->getTimestampMicros() > 0),
            'A reset should have no data',
            $chunk
        );
    }

    /**
     * Validates state for rowInProgress
     * @private
     * @param $chunk chunk to validate
     */
    public function validateRowInProgress($chunk)
    {
        $this->validateResetRow($chunk);
        $newRowKey = $chunk->getRowKey();
        $this->isError(
            $chunk->getRowKey() && $newRowKey !== $this->flatRow->getRowKey(),
            'A commit is required between row keys',
            $chunk
        );
        // $this->validateValueSizeAndCommitRow($chunk);
        $this->isError(
            $chunk->getFamilyName() && !$chunk->getQualifier(),
            'A qualifier must be specified',
            $chunk
        );
    }

    /**
     * Process chunk when in ROW_IN_PROGRESS state.
     * @private
     * @param $chunk  chunk to process
     */
    public function rowInProgress($chunk)
    {
        $this->validateRowInProgress($chunk);
        if ($chunk->getResetRow()) {
            return $this->reset();
        }
        if ($chunk->getFamilyName()) {
            $this->familyName = $chunk->getFamilyName()->getValue();
        }

        if ($chunk->getQualifier()) {
            $this->qualifierName = $chunk->getQualifier()->getValue();
        }
        $labels    = ($chunk->getLabels()->getIterator()->valid())?$chunk->getLabels()->getIterator()->current():'';
        $timestamp = $chunk->getTimestampMicros();
        $cell      = $this->cell      = new Cell();
        $cell->setFamily($this->familyName);
        $cell->setQualifier($this->qualifierName);
        $cell->setLabels($labels);
        $cell->setTimestamp($timestamp);
        $cell->setValue($chunk->getValue());

        $flatRow = $this->flatRow;
        $flatRow->addCell($cell);
        return $this->moveToNextState($chunk);
    }

    /**
     * Validates chunk for cellInProgress state.
     * @private
     * @param $chunk chunk to validate
     */
    public function validateCellInProgress($chunk)
    {
        $this->validateResetRow($chunk);
        $this->validateValueSizeAndCommitRow($chunk);
    }

    /**
     * Process chunk when in CELl_IN_PROGRESS state.
     * @private
     * @param $chunk chunk to cellInProcess
     */
    public function cellInProgress($chunk)
    {
        $this->validateCellInProgress($chunk);
        if ($chunk->getResetRow()) {
            return $this->reset();
        }
        $this->cell->appendValue($chunk->getValue());
        return $this->moveToNextState($chunk);
    }
}

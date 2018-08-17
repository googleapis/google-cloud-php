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

use Google\Cloud\Bigtable\Exception\BigtableDataOperationException;

class ChunkFormatter
{
    private $RowStateEnum;
    private $prevRowKey = null;
    private $state;
    private $serverStream;
    private $options;
    private $rowKey = null;
    private $row = [];
    private $family = null;
    private $qualifiers = null;
    private $qualifierValue = null;

    /**
     * Constructs ChunkFormatter.
     *
     * @param ServerStream $stream input server stream.
     * @param array $options optional argument.
     */
    public function __construct($stream, array $options = [])
    {
        $this->serverStream = $stream;
        $this->options = $options;
        $this->RowStateEnum = array(
            'NEW_ROW' => 1,
            'ROW_IN_PROGRESS' => 2,
            'CELL_IN_ROGRESS' =>3,
        );
        $this->reset();
    }

    /**
     * Formats the row chunks into friendly format. Chunks contain 3 properties:
     *
     * `rowContents` The row contents, this essentially is all data pertaining
     * to a single family.
     *
     * `commitRow` This is a boolean telling us the all previous chunks for this
     * row are ok to consume.
     *
     * `resetRow` This is a boolean telling us that all the previous chunks are to
     * be discarded.
     *
     * @return Generator
     * @throws Error if it detects invalid state
     */
    public function readAll()
    {
        foreach ($this->serverStream->readAll() as $readRowsResponse) {
            foreach ($readRowsResponse->getChunks() as $chunk) {
                switch ($this->state) {
                    case $this->RowStateEnum['NEW_ROW']:
                        yield from $this->newRow($chunk);
                        break;
                    case $this->RowStateEnum['ROW_IN_PROGRESS']:
                        yield from $this->rowInProgress($chunk);
                        break;
                    case $this->RowStateEnum['CELL_IN_PROGRESS']:
                        yield from $this->cellInProgress($chunk);
                        break;
                }
            }
        }
        $this->onStreamEnd();
    }

    /**
     * should be called at end of the stream to check if there is any pending row.
     *
     * @throws Error if there is any uncommitted row.
     */
    private function onStreamEnd()
    {
        $this->isError(
            !empty($this->row),
            'Response ended with pending row without commit',
            $this->row
        );
    }

    /**
     * Error checker if true throws error
     *
     * @param boolean $condition condition to evaluate
     * @param string $text Error text
     * @param Google\Cloud\Bigtable\V2\ReadRowsResponse\CellChunk $chunk chunk object to append to text
     * @throws Google\Cloud\Bigtable\Exception\BigtableDataOperationException
     */
    private function isError($condition, $text, $chunk)
    {
        if ($condition) {
            throw new BigtableDataOperationException($text);
        }
    }

    /**
     * Validates valuesize and commitrow in a chunk
     *
     * @param Google\Cloud\Bigtable\V2\ReadRowsResponse\CellChunk $chunk chunk to validate for valuesize and commitRow.
     * @return void
     */
    private function validateValueSizeAndCommitRow($chunk)
    {
        $this->isError(
            $chunk->getValueSize() > 0 && $chunk->getCommitRow(),
            'A row cannot be have a value size and be a commit row',
            $chunk
        );
    }

    /**
     * Validates state for new row.
     *
     * @param Google\Cloud\Bigtable\V2\ReadRowsResponse\CellChunk $chunk chunk to validate.
     * @return void
     */
    private function validateNewRow($chunk)
    {
        $this->isError(
            !empty($this->row),
            'A new row cannot have existing state',
            $chunk
        );
        $this->isError(
            !$chunk->getRowKey() || $chunk->getRowKey() === '' || is_null($chunk->getRowKey()),
            'A row key must be set',
            $chunk
        );
        $this->isError(
            $chunk->getResetRow(),
            'A new row cannot be reset',
            $chunk
        );
        $this->isError(
            $this->prevRowKey !== null &&
            $this->prevRowKey === $chunk->getRowKey(),
            'A commit happened but the same key followed',
            $chunk
        );
        $this->isError(!$chunk->getFamilyName(), 'A family must be set', $chunk);
        $this->isError(!$chunk->getQualifier(), 'A column qualifier must be set', $chunk);
        $this->validateValueSizeAndCommitRow($chunk);
    }

    /**
     * Resets state of formatter
     *
     * @return void
     */
    private function reset()
    {
        $this->prevRowKey = null;
        $this->rowKey = null;
        $this->state = $this->RowStateEnum['NEW_ROW'];
        $this->row = [];
    }

    /**
     * sets prevRowkey and calls reset when row is committed.
     *
     * @return void
     */
    private function commit()
    {
        $rowKey = $this->rowKey;
        $this->reset();
        $this->prevRowKey = $rowKey;
    }

    /**
     * Moves to next state in processing.
     *
     * @param Google\Cloud\Bigtable\V2\ReadRowsResponse\CellChunk $chunk in process.
     * @return row
     */
    private function moveToNextState($chunk)
    {
        if ($chunk->getCommitRow()) {
            $row = $this->row;
            $rowKey = $this->rowKey;
            $this->commit();
            yield $rowKey => $row;
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
     *
     * @param Google\Cloud\Bigtable\V2\ReadRowsResponse\CellChunk $chunk chunk to process.
     * @return Generator
     */
    private function newRow($chunk)
    {
        $newRowkey = $chunk->getRowKey();
        $this->validateNewRow($chunk);
        $this->rowKey = $newRowkey;
        $familyName = $chunk->getFamilyName()->getValue();
        $qualifierName = $chunk->getQualifier()->getValue();
        $labels = ($chunk->getLabels()->getIterator()->valid())?
            implode(iterator_to_array($chunk->getLabels()->getIterator())):'';
        $timestamp = $chunk->getTimestampMicros();
        $this->row[$familyName] = [];
        $this->family = &$this->row[$familyName];
        $this->family[$qualifierName] = [];
        $this->qualifiers = &$this->family[$qualifierName];
        $qualifier = [
            'value' => $chunk->getValue(),
            'labels' => $labels,
            'timeStamp' => $timestamp
        ];
        $this->qualifierValue = &$qualifier['value'];
        $this->qualifiers[] = &$qualifier;
        yield from $this->moveToNextState($chunk);
    }

    /**
     * Validates resetRow condition for chunk
     *
     * @param Google\Cloud\Bigtable\V2\ReadRowsResponse\CellChunk $chunk chunk to validate for resetrow.
     * @return void
     */
    private function validateResetRow($chunk)
    {
        $this->isError(
            $chunk->getResetRow() &&
            (
                $chunk->getRowKey() ||
                $chunk->getQualifier() ||
                $chunk->getValue() ||
                $chunk->getTimestampMicros() > 0
            ),
            'A reset should have no data',
            $chunk
        );
    }

    /**
     * Validates state for rowInProgress
     *
     * @param CellChunk $chunk chunk to validate.
     * @return void
     */
    private function validateRowInProgress($chunk)
    {
        $this->validateResetRow($chunk);
        $newRowKey = $chunk->getRowKey();
        $this->isError(
            $chunk->getRowKey() && $newRowKey !== $this->rowKey,
            'A commit is required between row keys',
            $chunk
        );
        $this->isError(
            $chunk->getFamilyName() && !$chunk->getQualifier(),
            'A qualifier must be specified',
            $chunk
        );
        $this->validateValueSizeAndCommitRow($chunk);
    }

    /**
     * Process chunk when in ROW_IN_PROGRESS state.
     *
     * @param Google\Cloud\Bigtable\V2\ReadRowsResponse\CellChunk $chunk chunk to process.
     * @return Generator
     */
    private function rowInProgress($chunk)
    {
        $this->validateRowInProgress($chunk);
        if ($chunk->getResetRow()) {
            return $this->reset();
        }
        if ($chunk->getFamilyName()) {
            $familyName = $chunk->getFamilyName()->getValue();
            if (!isset($this->row[$familyName])) {
                $this->row[$familyName] = [];
            }
            $this->family = &$this->row[$familyName];
        }
        if ($chunk->getQualifier()) {
            $qualifierName = $chunk->getQualifier()->getValue();
            if (!isset($this->family[$qualifierName])) {
                $this->family[$qualifierName] = [];
            }
            $this->qualifiers = &$this->family[$qualifierName];
        }
        $labels = ($chunk->getLabels()->getIterator()->valid())?
            implode(iterator_to_array($chunk->getLabels()->getIterator())):'';
        $timestamp = $chunk->getTimestampMicros();
        $qualifier = [
            'value' => $chunk->getValue(),
            'labels' => $labels,
            'timeStamp' => $timestamp
        ];
        $this->qualifierValue = &$qualifier['value'];
        $this->qualifiers[] = &$qualifier;
        yield from $this->moveToNextState($chunk);
    }

    /**
     * Validates chunk for CELL_IN_PROGRESS state.
     *
     * @param Google\Cloud\Bigtable\V2\ReadRowsResponse\CellChunk $chunk chunk to validate.
     * @return void
     */
    private function validateCellInProgress($chunk)
    {
        $this->validateResetRow($chunk);
        $this->validateValueSizeAndCommitRow($chunk);
    }

    /**
     * Process chunk when in CELL_IN_PROGRESS state.
     *
     * @param Google\Cloud\Bigtable\V2\ReadRowsResponse\CellChunk $chunk chunk to process.
     * @return Generator
     */
    private function cellInProgress($chunk)
    {
        $this->validateCellInProgress($chunk);
        if ($chunk->getResetRow()) {
            return $this->reset();
        }
        $this->qualifierValue = $this->qualifierValue . $chunk->getValue();
        yield from $this->moveToNextState($chunk);
    }

    /**
     * Represent the class in a more readable and digestable fashion.
     *
     * @access private
     * @codeCoverageIgnore
     */
    public function __debugInfo()
    {
        return [
            'state' => $this->state,
            'rowKey' => $this->rowKey,
            'prevRowKey' => $this->prevRowKey,
            'row' => $this->row
        ];
    }
}

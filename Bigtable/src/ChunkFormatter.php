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
use Google\Cloud\Bigtable\V2\ReadRowsResponse\CellChunk;
use Google\Cloud\Bigtable\V2\RowRange;
use Google\Cloud\Bigtable\V2\RowSet;
use Google\Cloud\Core\ArrayTrait;

/**
 * Converts cell chunks into an easily digestable format. Please note this class
 * implements the IteratorAggregate interface, and as such can be iterated over
 * directly in order to access the formatted rows.
 *
 * Example:
 * ```
 * use Google\Cloud\Bigtable\BigtableClient;
 *
 * $bigtable = new BigtableClient();
 * $table = $bigtable->table('my-instance', 'my-table');
 * $formatter = $table->readRows();
 * ```
 */
class ChunkFormatter implements \IteratorAggregate
{
    use ArrayTrait;

    /**
     * @var array
     */
    private static $rowStateEnum = [
        'NEW_ROW'          => 1,
        'ROW_IN_PROGRESS'  => 2,
        'CELL_IN_PROGRESS' => 3,
    ];

    /**
     * @var string
     */
    private $state;

    /**
     * @var ResumableStream
     */
    private $stream;

    /**
     * @var string|null
     */
    private $prevRowKey = null;

    /**
     * @var string|null
     */
    private $rowKey = null;

    /**
     * @var array
     */
    private $row = [];

    /**
     * @var array|null
     */
    private $family = null;

    /**
     * @var array|null
     */
    private $qualifiers = null;

    /**
     * @var string|null
     */
    private $qualifierValue = null;

    /**
     * @var string
     */
    private $tableName;

    /**
     * @var array
     */
    private $options;

    /**
     * @var int
     */
    private $numberOfRowsRead = 0;

    /**
     * @var int|null
     */
    private $originalRowsLimit = null;

    /**
     * Constructs the ChunkFormatter.
     *
     * @param callable $readRowsCall A callable which executes a read rows call and returns a stream.
     * @param string $tableName The table name used for the read rows call.
     * @param array $options [optional] Configuration options for read rows call.
     */
    public function __construct(callable $readRowsCall, $tableName, array $options = [])
    {
        $this->tableName = $tableName;
        $this->options = $options;
        if (isset($options['rowsLimit'])) {
            $this->originalRowsLimit = $options['rowsLimit'];
        }
        $this->stream = new ResumableStream(
            $readRowsCall,
            function () {
                $prevRowKey = $this->prevRowKey;
                $this->reset();
                if ($prevRowKey) {
                    $this->updateOptions($prevRowKey);
                }
                return [$this->tableName, $this->options];
            },
            function ($ex) {
                if ($ex && ResumableStream::isRetryable($ex->getCode())) {
                    return true;
                }
                return false;
            },
            $this->pluck('retries', $this->options, false)
        );
    }

    /**
     * Formats the row's chunks into a friendly format.
     *
     * Example:
     * ```
     * $rows = $formatter->readAll();
     * ```
     *
     * @return \Generator
     * @throws BigtableDataOperationException If a malformed response is received.
     */
    public function readAll()
    {
        // Chunks contain 3 properties:
        // - rowContents: The row contents, this essentially is all data
        //   pertaining to a single family.
        // - commitRow: This is a boolean telling us the all previous chunks for
        //   this row are ok to consume.
        // - resetRow: This is a boolean telling us that all the previous chunks
        //   are to be discarded.

        foreach ($this->stream as $readRowsResponse) {
            foreach ($readRowsResponse->getChunks() as $chunk) {
                switch ($this->state) {
                    case self::$rowStateEnum['NEW_ROW']:
                        $this->newRow($chunk);
                        break;
                    case self::$rowStateEnum['ROW_IN_PROGRESS']:
                        $this->rowInProgress($chunk);
                        break;
                    case self::$rowStateEnum['CELL_IN_PROGRESS']:
                        $this->cellInProgress($chunk);
                        break;
                }

                if ($chunk->getCommitRow()) {
                    $row = $this->row;
                    $rowKey = $this->rowKey;
                    $this->commit();
                    yield $rowKey => $row;
                    $this->numberOfRowsRead++;
                }
            }
        }

        $this->onStreamEnd();
    }

    private function updateOptions($prevRowKey)
    {
        if ($this->originalRowsLimit) {
            $this->options['rowsLimit'] = $this->originalRowsLimit - $this->numberOfRowsRead;
        }
        if (isset($this->options['rows'])) {
            $rowSet = $this->options['rows'];
            if (count($rowSet->getRowKeys()) > 0) {
                $rowKeys = [];
                foreach ($rowSet->getRowKeys() as $rowKey) {
                    if ($rowKey > $prevRowKey) {
                        $rowKeys[] = $rowKey;
                    }
                }
                $rowSet->setRowKeys($rowKeys);
            }
            if (count($rowSet->getRowRanges()) > 0) {
                $ranges = [];
                foreach ($rowSet->getRowRanges() as $range) {
                    if (($range->getEndKeyOpen() && $prevRowKey > $range->getEndKeyOpen())
                        || ($range->getEndKeyClosed() && $prevRowKey >= $range->getEndKeyClosed())) {
                            continue;
                    } elseif ((!$range->getStartKeyOpen() || $prevRowKey > $range->getStartKeyOpen())
                        && (!$range->getStartKeyClosed() || $prevRowKey >= $range->getStartKeyClosed())) {
                        $range->setStartKeyOpen($prevRowKey);
                    }
                    $ranges[] = $range;
                }
                $rowSet->setRowRanges($ranges);
            }
        } else {
            $range = (new RowRange)->setStartKeyOpen($prevRowKey);
            $this->options['rows'] = (new RowSet)->setRowRanges([$range]);
        }
    }

    /**
     * Should be called at end of the stream to check if there are any pending
     * rows.
     *
     * @throws BigtableDataOperationException
     */
    private function onStreamEnd()
    {
        $this->isError(
            !empty($this->row),
            'Response ended with pending row without commit.'
        );
    }

    /**
     * Error checker. If the condition is true throws an exception.
     *
     * @param boolean $condition condition to evaluate
     * @param string $text Error text
     * @throws BigtableDataOperationException
     */
    private function isError($condition, $text)
    {
        if ($condition) {
            throw new BigtableDataOperationException($text);
        }
    }

    /**
     * Validates value size and commit row in a chunk.
     *
     * @param CellChunk $chunk The chunk to validate.
     * @return void
     * @throws BigtableDataOperationException
     */
    private function validateValueSizeAndCommitRow(CellChunk $chunk)
    {
        $this->isError(
            $chunk->getValueSize() > 0 && $chunk->getCommitRow(),
            'A row cannot have a value size and be a commit row.'
        );
    }

    /**
     * Validates state for a new row.
     *
     * @param CellChunk $chunk The chunk to validate.
     * @return void
     * @throws BigtableDataOperationException
     */
    private function validateNewRow(CellChunk $chunk)
    {
        $this->isError(
            $this->row,
            'A new row cannot have existing state.'
        );
        $this->isError(
            $chunk->getRowKey() === '',
            'A row key must be set.'
        );
        $this->isError(
            $chunk->getResetRow(),
            'A new row cannot be reset.'
        );
        $this->isError(
            $this->prevRowKey &&
            $this->prevRowKey === $chunk->getRowKey(),
            'A commit happened but the same key followed.'
        );
        $this->isError(!$chunk->getFamilyName(), 'A family must be set.');
        $this->isError(!$chunk->getQualifier(), 'A column qualifier must be set.');
        $this->validateValueSizeAndCommitRow($chunk);
    }

    /**
     * Resets the state of formatter.
     *
     * @return void
     */
    private function reset()
    {
        $this->prevRowKey = null;
        $this->rowKey = null;
        $this->state = self::$rowStateEnum['NEW_ROW'];
        $this->row = [];
    }

    /**
     * Sets the previous row key and calls reset.
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
     * Moves to the next state in processing.
     *
     * @param CellChunk $chunk The chunk to analyze.
     * @return void
     */
    private function moveToNextState(CellChunk $chunk)
    {
        $this->state = $chunk->getValueSize() > 0
            ? self::$rowStateEnum['CELL_IN_PROGRESS']
            : self::$rowStateEnum['ROW_IN_PROGRESS'];
    }

    /**
     * Processes a chunk when in the NEW_ROW state.
     *
     * @param CellChunk $chunk The chunk to process.
     * @return void
     * @throws BigtableDataOperationException
     */
    private function newRow(CellChunk $chunk)
    {
        $this->validateNewRow($chunk);
        $this->rowKey = $chunk->getRowKey();
        $familyName = $chunk->getFamilyName()->getValue();
        $qualifierName = $chunk->getQualifier()->getValue();
        $labels = ($chunk->getLabels()->getIterator()->valid())
            ? implode(iterator_to_array($chunk->getLabels()->getIterator()))
            : '';
        $this->row[$familyName] = [];
        $this->family = &$this->row[$familyName];
        $this->family[$qualifierName] = [];
        $this->qualifiers = &$this->family[$qualifierName];
        $qualifier = [
            'value' => $chunk->getValue(),
            'labels' => $labels,
            'timeStamp' => $chunk->getTimestampMicros()
        ];
        $this->qualifierValue = &$qualifier['value'];
        $this->qualifiers[] = &$qualifier;
        $this->moveToNextState($chunk);
    }

    /**
     * Validates the reset row condition for a chunk.
     *
     * @param CellChunk $chunk chunk The chunk to validate.
     * @return void
     * @throws BigtableDataOperationException
     */
    private function validateResetRow(CellChunk $chunk)
    {
        $this->isError(
            $chunk->getResetRow() &&
            (
                $chunk->getRowKey() ||
                $chunk->getQualifier() ||
                $chunk->getValue() ||
                $chunk->getTimestampMicros() > 0
            ),
            'A reset should have no data.'
        );
    }

    /**
     * Validates state for a row in progress.
     *
     * @param CellChunk $chunk The chunk to validate.
     * @return void
     * @throws BigtableDataOperationException
     */
    private function validateRowInProgress(CellChunk $chunk)
    {
        $this->validateResetRow($chunk);
        $newRowKey = $chunk->getRowKey();
        $this->isError(
            $chunk->getRowKey() && $newRowKey !== $this->rowKey,
            'A commit is required between row keys.'
        );
        $this->isError(
            $chunk->getFamilyName() && !$chunk->getQualifier(),
            'A qualifier must be specified.'
        );
        $this->validateValueSizeAndCommitRow($chunk);
    }

    /**
     * Process a chunk when in ROW_IN_PROGRESS state.
     *
     * @param CellChunk $chunk The chunk to process.
     * @return void
     * @throws BigtableDataOperationException
     */
    private function rowInProgress(CellChunk $chunk)
    {
        $this->validateRowInProgress($chunk);
        if ($chunk->getResetRow()) {
            $this->reset();
            return;
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
        $labels = ($chunk->getLabels()->getIterator()->valid())
            ? implode(iterator_to_array($chunk->getLabels()->getIterator()))
            : '';
        $qualifier = [
            'value' => $chunk->getValue(),
            'labels' => $labels,
            'timeStamp' => $chunk->getTimestampMicros()
        ];
        $this->qualifierValue = &$qualifier['value'];
        $this->qualifiers[] = &$qualifier;
        $this->moveToNextState($chunk);
    }

    /**
     * Validates chunk for CELL_IN_PROGRESS state.
     *
     * @param CellChunk $chunk The chunk to validate.
     * @return void
     * @throws BigtableDataOperationException
     */
    private function validateCellInProgress(CellChunk $chunk)
    {
        $this->validateResetRow($chunk);
        $this->validateValueSizeAndCommitRow($chunk);
    }

    /**
     * Process chunk when in CELL_IN_PROGRESS state.
     *
     * @param CellChunk $chunk The chunk to process.
     * @return void
     * @throws BigtableDataOperationException
     */
    private function cellInProgress(CellChunk $chunk)
    {
        $this->validateCellInProgress($chunk);
        if ($chunk->getResetRow()) {
            $this->reset();
            return;
        }
        $this->qualifierValue = $this->qualifierValue . $chunk->getValue();
        $this->moveToNextState($chunk);
    }

    /**
     * @access private
     * @return \Generator
     * @throws BigtableDataOperationException Thrown in the case of a malformed response.
     */
    #[\ReturnTypeWillChange]
    public function getIterator()
    {
        return $this->readAll();
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

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

use Google\ApiCore\ApiException;
use Google\ApiCore\ArrayTrait;
use Google\Cloud\Bigtable\Exception\BigtableDataOperationException;
use Google\Cloud\Bigtable\V2\Client\BigtableClient as GapicClient;
use Google\Cloud\Bigtable\V2\ReadRowsRequest;
use Google\Cloud\Bigtable\V2\ReadRowsResponse\CellChunk;
use Google\Cloud\Bigtable\V2\RowRange;
use Google\Cloud\Bigtable\V2\RowSet;
use Google\Protobuf\Internal\Message;
use Google\Rpc\Code;

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

    // When we use ChunkFormatter, we know that we always
    // need to readRows.
    private const GAPIC_CLIENT_METHOD = 'readRows';

    /**
     * @var GapicClient
     */
    private $gapicClient;

    /**
     * @var Message
     */
    private $request;

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
     * @param GapicClient $gapicClient The GAPIC client to use in order to send requests.
     * @param ReadRowsRequest $request The proto request to be passed to the Gapic client.
     * @param array $options [optional] Configuration options for read rows call.
     */
    public function __construct(
        GapicClient $gapicClient,
        ReadRowsRequest $request,
        array $options = []
    ) {
        $this->gapicClient = $gapicClient;
        $this->request = $request;
        $this->options = $options;

        if ($request->getRowsLimit()) {
            $this->originalRowsLimit = $request->getRowsLimit();
        }

        $argumentFunction = function ($request, $options) {
            $prevRowKey = $this->prevRowKey;
            $this->reset();
            if ($prevRowKey) {
                list($request, $options) = $this->updateReadRowsRequest($request, $options, $prevRowKey);
            }
            return [$request, $options];
        };

        $retryFunction = function ($ex) {
            if ($ex && ResumableStream::isRetryable($ex->getCode())) {
                return true;
            }
            return false;
        };

        $this->stream = new ResumableStream(
            $this->gapicClient,
            self::GAPIC_CLIENT_METHOD,
            $request,
            $argumentFunction,
            $retryFunction,
            $options
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
            if ($lastScannedRowKey = $readRowsResponse->getLastScannedRowKey()) {
                // The server sends the response with a "last_scanned_row_key" in some cases
                $this->prevRowKey = $lastScannedRowKey;
            }
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

    /**
     * Helper to modify the request and the options in b/w retries.
     */
    private function updateReadRowsRequest($request, $options, $prevRowKey)
    {
        if ($this->originalRowsLimit) {
            $request->setRowsLimit($this->originalRowsLimit - $this->numberOfRowsRead);
            if ($this->numberOfRowsRead === $this->originalRowsLimit) {
                $options['requestCompleted'] = true;
            }
        }
        if ($request->hasRows()) {
            $rowSet = $request->getRows();
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
                    }
                    if ((!$range->getStartKeyOpen() || $prevRowKey > $range->getStartKeyOpen())
                        && (!$range->getStartKeyClosed() || $prevRowKey >= $range->getStartKeyClosed())) {
                        $range->setStartKeyOpen($prevRowKey);
                    }
                    $ranges[] = $range;
                }
                $rowSet->setRowRanges($ranges);
            }

            // This flag enables `ResumableStream->readAll()` to skip backend network
            // call. It's used to avoid the unintentional full table scan in the
            // event when a retryable error (for eg `Code::DEADLINE_EXCEEDED`) happens
            // after all data is received causing empty rows to be sent in next retry
            // request resulting in a full table scan.
            if (empty($rowKeys) && empty($ranges)) {
                $options['requestCompleted'] = true;
            }
        } else {
            $range = (new RowRange());
            $range->setStartKeyOpen($prevRowKey);
            $rowset = (new RowSet())->setRowRanges([$range]);
            $request->setRows($rowset);
        }

        return [$request, $options];
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
        if ($this->prevRowKey) {
            // Validate that row keys are in ascending order
            $cmp = strcmp($this->prevRowKey, $rowKey);
            if ($this->request->getReversed()) {
                $cmp *= -1;
            }
            if ($cmp >= 0) {
                throw new ApiException(
                    sprintf(
                        'last scanned key must be strictly %s. New last scanned key=%s',
                        $this->request->getReversed() ? 'decreasing' : 'increasing',
                        $rowKey
                    ),
                    Code::INTERNAL
                );
            }
        }
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

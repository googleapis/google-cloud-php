<?php

namespace Google\Cloud\Bigtable\V2;

use Google\Cloud\Bigtable\V2\Exception\InvalidChunkException;

class BigtableCellBuffer
{
    const NEW_CELL = 0;
    const IN_PROGRESS = 1;
    const COMPLETE = 2;

    private $rowKey;
    private $familyName;
    private $columnName;
    private $timestampMicros;
    private $valueBuffer;
    private $isCommitRowCell;
    private $state;

    public function __construct()
    {
        $this->rowKey = null;
        $this->familyName = null;
        $this->columnName = null;
        $this->resetValueBuffer();
    }

    /**
     * Merge a cell chunk into this buffer.
     *
     * @param ReadRowsResponse_CellChunk $chunk
     *
     * @throws InvalidChunkException if the chunk is invalid,
     * or this buffer enters an inconsistent state.
     */
    public function merge($chunk)
    {
        $rowKey = $chunk->getRowKey();
        $qualifier = $chunk->getQualifier();
        $familyName = $chunk->getFamilyName();
        $timestampMicros = $chunk->getTimestampMicros();

        if (!is_null($rowKey) && $rowKey != '') {
            $this->rowKey = $rowKey;
        };

        if (!is_null($qualifier)) {
            InvalidChunkException::assert($this->state === self::NEW_CELL);
            $this->columnName = $qualifier->getValue();
        };

        if (!is_null($familyName)) {
            InvalidChunkException::assert($this->state === self::NEW_CELL);
            $this->familyName = $familyName->getValue();
        };

        if ($timestampMicros != 0) {
            InvalidChunkException::assert($this->state === self::NEW_CELL);
            $this->timestampMicros = $timestampMicros;
        }

        $this->valueBuffer .= $chunk->getValue();

        if ($chunk->getCommitRow()) {
            $this->validateCommitRowChunk($chunk);
            $this->isCommitRowCell = true;
        };

        if ($chunk->getValueSize() === 0) {
            $this->validateCellComplete();
            $this->state = self::COMPLETE;
        } else {
            $this->state = self::IN_PROGRESS;
        }
    }

    /**
     * Return a Cell representation of this buffer.
     *
     * @returns Cell $chunk
     *
     * @throws \RuntimeException if this buffer is not complete.
     */
    public function asCell()
    {
        $cell = new Cell();
        $cell->setTimestampMicros($this->timestampMicros);
        $cell->setValue($this->getValue());

        return $cell;
    }

    /**
     * Reset the current value state, but keep the current
     * row/column/column family context.
     */
    public function resetValueBuffer()
    {
        $this->valueBuffer = '';
        $this->timestampMicros = 0;
        $this->isCommitRowCell = false;
        $this->state = self::NEW_CELL;
    }

    /**
     * @param ReadRowsResponse_CellChunk $chunk
     *
     * @throws InvalidChunkException
     */
    private function validateCommitRowChunk($chunk)
    {
        InvalidChunkException::assert($chunk->getValueSize() === 0);
    }

    /**
     * @param ReadRowsResponse_CellChunk $chunk
     *
     * @throws InvalidChunkException
     */
    private function validateCellComplete()
    {
        InvalidChunkException::assert(!is_null($this->familyName));
        InvalidChunkException::assert(!is_null($this->columnName));
    }

    public function getRowKey()
    {
        return $this->rowKey;
    }

    public function getFamilyName()
    {
        return $this->familyName;
    }

    public function getColumnName()
    {
        return $this->columnName;
    }

    public function getValue()
    {
        if ($this->state != self::COMPLETE) {
            throw new \RuntimeException("Attempted to read incomplete cell value");
        }
        return $this->valueBuffer;
    }

    public function getIsCommitRowCell()
    {
        return $this->isCommitRowCell;
    }

    public function getState()
    {
        return $this->state;
    }
}

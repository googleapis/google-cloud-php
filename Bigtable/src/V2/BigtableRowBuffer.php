<?php

namespace Google\Cloud\Bigtable\V2;

use Google\Cloud\Bigtable\V2\Exception\InvalidChunkException;

class BigtableRowBuffer
{
    const NEW_ROW = 0;
    const IN_PROGRESS = 1;
    const COMPLETE = 2;

    private $rowKey;
    private $cells;
    private $state;

    public function __construct()
    {
        $this->rowKey = null;
        $this->cells = [];
        $this->state = self::NEW_ROW;
    }

    /**
     * Merge a cell buffer into this buffer.
     *
     * @param BigtableCellBuffer $cellBuffer
     *
     * @throws InvalidChunkException if this buffer enters an inconsistent state.
     */
    public function merge($cellBuffer)
    {
        $familyName = $cellBuffer->getFamilyName();
        $columnName = $cellBuffer->getColumnName();

        if (!array_key_exists($familyName, $this->cells)) {
            $this->cells[$familyName] = [];
        };

        $family = $this->cells[$familyName];
        if (!array_key_exists($columnName, $family)) {
            $family[$columnName] = [];
        };

        if ($this->state === self::IN_PROGRESS) {
            InvalidChunkException::assert($cellBuffer->getRowKey() === $this->rowKey);
        } else {
            $this->rowKey = $cellBuffer->getRowKey();
        };

        $this->cells[$familyName][$columnName][] = $cellBuffer->asCell();

        if ($cellBuffer->getIsCommitRowCell()) {
            $this->state = self::COMPLETE;
        } else {
            $this->state = self::IN_PROGRESS;
        }

        $cellBuffer->resetValueBuffer();
    }

    public function getRowKey()
    {
        return $this->rowKey;
    }

    /**
     * @return array An associative array where the top-level keys
     * are column family names, the second-level keys are column names,
     * and the values are Cells.
     */
    public function getCells()
    {
        if ($this->state != self::COMPLETE) {
            throw new RuntimeException("Attempted to read incomplete row");
        };
        return $this->cells;
    }

    public function getState()
    {
        return $this->state;
    }
}

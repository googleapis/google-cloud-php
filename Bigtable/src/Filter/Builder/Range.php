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

namespace Google\Cloud\Bigtable\Filter\Builder;

/**
 * Abstract class representing filter range for Rowkey, ColumnFamily,
 * ColumnQualifier and Value.
 */
abstract class Range
{
    const BOUND_TYPE_UNBOUNDED = 0;
    const BOUND_TYPE_OPEN = 1;
    const BOUND_TYPE_CLOSED = 2;

    /**
     * @var string|int|null
     */
    private $start;

    /**
     * @var string|int|null
     */
    private $end;

    /**
     * @var int
     */
    private $startBound;

    /**
     * @var int
     */
    private $endBound;

    /**
     * @param int $startBound
     * @param string|int $start
     * @param int $endBound
     * @param string|int $end
     */
    public function __construct(
        $startBound = self::BOUND_TYPE_UNBOUNDED,
        $start = null,
        $endBound = self::BOUND_TYPE_UNBOUNDED,
        $end = null
    ) {
        $this->startBound = $startBound;
        $this->start = $start;
        $this->endBound = $endBound;
        $this->end = $end;
    }

    /**
     * @param string|int $startClosed
     * @param string|int $endOpen
     * @return Range
     */
    public function of($startClosed, $endOpen)
    {
        return $this->startClosed($startClosed)->endOpen($endOpen);
    }

    /**
     * @return Range
     */
    public function startUnbounded()
    {
        $this->start = null;
        $this->startBound = self::BOUND_TYPE_UNBOUNDED;
        return $this;
    }

    /**
     * @param string|int $start
     * @return Range
     * @throws \InvalidArgumentException
     */
    public function startOpen($start)
    {
        $this->validateStringOrNumeric($start, __FUNCTION__);
        $this->start = $start;
        $this->startBound = self::BOUND_TYPE_OPEN;
        return $this;
    }

    /**
     * @param string|int $start
     * @return Range
     * @throws \InvalidArgumentException
     */
    public function startClosed($start)
    {
        $this->validateStringOrNumeric($start, __FUNCTION__);
        $this->start = $start;
        $this->startBound = self::BOUND_TYPE_CLOSED;
        return $this;
    }

    /**
     * @return Range
     */
    public function endUnbounded()
    {
        $this->end = null;
        $this->endBound = self::BOUND_TYPE_UNBOUNDED;
        return $this;
    }

    /**
     * @param string|int $end
     * @return Range
     * @throws \InvalidArgumentException
     */
    public function endOpen($end)
    {
        $this->validateStringOrNumeric($end, __FUNCTION__);
        $this->end = $end;
        $this->endBound = self::BOUND_TYPE_OPEN;
        return $this;
    }

    /**
     * @param string|int $end
     * @return Range
     * @throws \InvalidArgumentException
     */
    public function endClosed($end)
    {
        $this->validateStringOrNumeric($end, __FUNCTION__);
        $this->end = $end;
        $this->endBound = self::BOUND_TYPE_CLOSED;
        return $this;
    }

    /**
     * @return int
     */
    public function getStartBound()
    {
        return $this->startBound;
    }

    /**
     * @return string|int|null
     */
    public function getStart()
    {
        if ($this->startBound === self::BOUND_TYPE_UNBOUNDED) {
            throw new \RuntimeException('Start is unbounded.');
        }
        return $this->start;
    }

    /**
     * @return int
     */
    public function getEndBound()
    {
        return $this->endBound;
    }

    /**
     * @return string|int|null
     */
    public function getEnd()
    {
        if ($this->endBound === self::BOUND_TYPE_UNBOUNDED) {
            throw new \RuntimeException('End is unbounded.');
        }
        return $this->end;
    }

    /**
     * @param $value
     * @param $func
     * @return bool
     * @throws \InvalidArgumentException
     */
    private function validateStringOrNumeric($value, $func)
    {
        if (is_string($value) || is_numeric($value)) {
            return true;
        }

        throw new \InvalidArgumentException(
            sprintf(
                '%s accepts only string or numeric types.',
                $func
            )
        );
    }
}

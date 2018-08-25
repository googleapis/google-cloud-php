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

namespace Google\Cloud\Bigtable\Filter;

use Exception;
use Google\Cloud\Bigtable\Filter;

abstract class Range
{
    const BOUND_TYPE_UNBOUNDED = 0;
    const BOUND_TYPE_OPEN = 1;
    const BOUND_TYPE_CLOSED = 2;

    private $start;
    private $end;
    private $startBound;
    private $endBound;

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

    public function of($startClosed, $endOpen)
    {
        return $this->startClosed($startClosed)->endOpen($endOpen);
    }

    public function startUnbounded()
    {
        $this->start = null;
        $this->startBound = self::BOUND_TYPE_UNBOUNDED;
        return $this;
    }

    public function startOpen($start)
    {
        if ($start === null) {
            throw new Exception('Start can`t be null');
        }
        $this->start = $start;
        $this->startBound = self::BOUND_TYPE_OPEN;
        return $this;
    }

    public function startClosed($start)
    {
        if ($start === null) {
            throw new Exception('Start can`t be null');
        }
        $this->start = $start;
        $this->startBound = self::BOUND_TYPE_CLOSED;
        return $this;
    }

    public function endUnBounded()
    {
        $this->end = null;
        $this->endBound = self::BOUND_TYPE_UNBOUNDED;
        return $this;
    }

    public function endOpen($end)
    {
        if ($end === null) {
            throw new Exception('End can`t be null');
        }
        $this->end = $end;
        $this->endBound = self::BOUND_TYPE_OPEN;
        return $this;
    }

    public function endClosed($end)
    {
        if ($end === null) {
            throw new Exception('End can`t be null');
        }
        $this->end = $end;
        $this->endBound = self::BOUND_TYPE_CLOSED;
        return $this;
    }

    public function getStartBound()
    {
        return $this->startBound;
    }

    public function getStart()
    {
        if ($this->startBound === self::BOUND_TYPE_UNBOUNDED) {
            throw new Exception('Start is unbounded');
        }
        return $this->start;
    }

    public function getEndBound()
    {
        return $this->endBound;
    }

    public function getEnd()
    {
        if ($this->endBound === self::BOUND_TYPE_UNBOUNDED) {
            throw new Exception('End is unbounded');
        }
        return $this->end;
    }
}

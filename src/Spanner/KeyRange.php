<?php
/**
 * Copyright 2016 Google Inc.
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

namespace Google\Cloud\Spanner;

class KeyRange
{
    /**
     * @var mixed
     */
    private $startOpen;

    /**
     * @var mixed
     */
    private $startClosed;

    /**
     * @var mixed
     */
    private $endOpen;

    /**
     * @var mixed
     */
    private $endClosed;

    public function __construct(array $range)
    {
        $this->startOpen = (isset($range['startOpen']))
            ? $range['startOpen']
            : null;

        $this->startClosed = (isset($range['startClosed']))
            ? $range['startClosed']
            : null;

        $this->endOpen = (isset($range['endOpen']))
            ? $range['endOpen']
            : null;

        $this->endClosed = (isset($range['endClosed']))
            ? $range['endClosed']
            : null;

    }

    public function setStartOpen($startOpen)
    {
        $this->startOpen = $startOpen;
    }

    public function setStartClosed($startClosed)
    {
        $this->startClosed = $startClosed;
    }

    public function setEndOpen($endOpen)
    {
        $this->endOpen = $endOpen;
    }

    public function setEndClosed($endClosed)
    {
        $this->endClosed = $endClosed;
    }

    public function keyRangeObject()
    {
        return [
            'startOpen' => $this->startOpen,
            'startClosed' => $this->startClosed,
            'endOpen' => $this->endOpen,
            'endClosed' => $this->endClosed,
        ];
    }
}

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

namespace Google\Cloud\Tests\Spanner;

use Google\Cloud\Spanner\KeyRange;

/**
 * @group spanner
 */
class KeyRangeTest extends \PHPUnit_Framework_TestCase
{
    private $startOpen = 'startOpen';
    private $startClosed = 'startClosed';
    private $endOpen = 'endOpen';
    private $endClosed = 'endClosed';

    public function testSetters()
    {
        $kr = new KeyRange([]);
        $kr->setStartOpen($this->startOpen);
        $kr->setStartClosed($this->startClosed);
        $kr->setEndOpen($this->endOpen);
        $kr->setEndClosed($this->endClosed);

        $this->assertThings($kr);
    }

    public function testConstructValues()
    {
        $kr = new KeyRange([
            'startOpen' => $this->startOpen,
            'startClosed' => $this->startClosed,
            'endOpen' => $this->endOpen,
            'endClosed' => $this->endClosed
        ]);

        $this->assertThings($kr);
    }

    private function assertThings($kr)
    {
        $this->assertEquals([
            'startOpen' => $this->startOpen,
            'startClosed' => $this->startClosed,
            'endOpen' => $this->endOpen,
            'endClosed' => $this->endClosed
        ], $kr->keyRangeObject());
    }
}

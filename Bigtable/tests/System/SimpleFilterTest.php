<?php
/**
 * Copyright 2018 Google LLC.
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

namespace Google\Cloud\Bigtable\Tests\System;

use Google\Cloud\Bigtable\Filter;
use Google\Cloud\Bigtable\Tests\System\FilterTest;

/**
 * @group bigtable
 * @group bigtabledata
 */
class SimpleFilterTest extends FilterTest
{
    public function testPass()
    {
        $rowFilter = Filter::pass();
        $rows = iterator_to_array(
            self::$dataClient->readRows(
                [
                    'filter' => $rowFilter
                ]
            )->readAll()
        );
        $this->assertEquals(self::$expectedRows, $rows);
    }

    public function testBlock()
    {
        $rowFilter = Filter::block();
        $rows = iterator_to_array(
            self::$dataClient->readRows(
                [
                    'filter' => $rowFilter
                ]
            )->readAll()
        );
        $this->assertEquals([], $rows);
    }

    public function testSink()
    {
        $rowFilter = Filter::sink();
        $rows = iterator_to_array(
            self::$dataClient->readRows(
                [
                    'filter' => $rowFilter
                ]
            )->readAll()
        );
        $this->assertEquals(self::$expectedRows, $rows);
    }

    public function testLabel()
    {
        //TODO Implement label test
    }

    private static function applyLabelToExpectedRows($label)
    {
        $expectedRows = self::$expectedRows;
        foreach ($expectedRows as &$row) {
            foreach ($row as &$family) {
                foreach ($family as &$qualifier) {
                    $qualifier['labels'] = $label;
                    $qualifier = [$qualifier];
                }
            }
        }
    }
}

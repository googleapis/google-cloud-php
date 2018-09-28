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
class KeyFilterTest extends FilterTest
{
    public function testExactMatch()
    {
        $rowFilter = Filter::key()->exactMatch('rk1');
        $rows = iterator_to_array(
            self::$dataClient->readRows(
                [
                    'filter' => $rowFilter
                ]
            )->readAll()
        );
        $expectedRows = ['rk1' => self::$expectedRows['rk1']];
        $this->assertEquals($expectedRows, $rows);
    }

    public function testRegex()
    {
        $rowFilter = Filter::key()->regex('rk[12]+');
        $rows = iterator_to_array(
            self::$dataClient->readRows(
                [
                    'filter' => $rowFilter
                ]
            )->readAll()
        );
        $expectedRows = [
            'rk1' => self::$expectedRows['rk1'],
            'rk2' => self::$expectedRows['rk2']
        ];
        $this->assertEquals($expectedRows, $rows);
    }

    public function testSample()
    {
        $rowFilter = Filter::key()->sample(.50);
        $rows = iterator_to_array(
            self::$dataClient->readRows(
                [
                    'filter' => $rowFilter
                ]
            )->readAll()
        );
        $this->assertTrue(count($rows) > 0);
    }
}

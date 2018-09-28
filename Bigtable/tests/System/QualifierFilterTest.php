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
class QualifierFilterTest extends FilterTest
{
    public function testExactMatch()
    {
        $rowFilter = Filter::chain()
            ->addFilter(Filter::family()->exactMatch('cf1'))
            ->addFilter(Filter::qualifier()->exactMatch('cq1'));
        $rows = iterator_to_array(
            self::$dataClient->readRows(
                [
                    'rowKeys' => 'rk1',
                    'filter' => $rowFilter
                ]
            )->readAll()
        );
        $expectedRows = ['rk1' => [
            'cf1' => [
                'cq1' => self::$expectedRows['rk1']['cf1']['cq1']
            ]
        ]];
        $this->assertEquals($expectedRows, $rows);
    }

    public function testRegex()
    {
        $rowFilter = Filter::chain()
            ->addFilter(Filter::family()->exactMatch('cf1'))
            ->addFilter(Filter::qualifier()->regex('cq[12]+'));
        $rows = iterator_to_array(
            self::$dataClient->readRows(
                [
                    'rowKeys' => 'rk1',
                    'filter' => $rowFilter
                ]
            )->readAll()
        );
        $expectedRows = ['rk1' => [
            'cf1' => [
                'cq1' => self::$expectedRows['rk1']['cf1']['cq1'],
                'cq2' => self::$expectedRows['rk1']['cf1']['cq2']
            ]
        ]];
        $this->assertEquals($expectedRows, $rows);
    }

    public function testRangeWithInFamily()
    {
        $rowFilter = Filter::qualifier()->rangeWithInFamily('cf1')->of('cq1', 'cq3');
        $rows = iterator_to_array(
            self::$dataClient->readRows(
                [
                    'rowKeys' => 'rk1',
                    'filter' => $rowFilter
                ]
            )->readAll()
        );
        $expectedRows = ['rk1' => [
            'cf1' => [
                'cq1' => self::$expectedRows['rk1']['cf1']['cq1'],
                'cq2' => self::$expectedRows['rk1']['cf1']['cq2']
            ]
        ]];
        $this->assertEquals($expectedRows, $rows);
    }
}

<?php
/**
 * Copyright 2018 Google Inc.
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
use Google\Cloud\Bigtable\Mutations;

/**
 * @group bigtable
 * @group bigtabledata
 */
class CheckAndMutateRowTest extends BigtableTestCase
{
    public static function set_up_before_class()
    {
        parent::set_up_before_class();
        $insertRows = [
            'rk1' => [
                'cf1' => [
                    'cq1' => [
                        'value' => 'value1',
                        'timeStamp' => 5000
                    ]
                ]
            ],
        ];
        self::$table->upsert($insertRows);
    }

    public function testCheckAndMutateRowWithEmptyFilter()
    {
        $mutations = (new Mutations)->upsert('cf1', 'cq1', 'value11', 6000);
        $result = self::$table->checkAndMutateRow(
            'rk1',
            ['trueMutations' => $mutations]
        );
        $this->assertTrue($result);
        $row = self::$table->readRow('rk1');
        $expectedRow = [
            'cf1' => [
                'cq1' => [
                    [
                        'value' => 'value11',
                        'timeStamp' => 6000,
                        'labels' => ''
                    ],
                    [
                        'value' => 'value1',
                        'timeStamp' => 5000,
                        'labels' => ''
                    ]
                ]
            ]
        ];
        $this->assertEquals($expectedRow, $row);
    }

    public function testCheckAndMutateRowWithFilterYieldingCell()
    {
        $predicateFilter = Filter::family()->exactMatch('cf1');
        $mutations = (new Mutations)->upsert('cf1', 'cq1', 'value11', 6000);
        $result = self::$table->checkAndMutateRow(
            'rk1',
            [
                'predicateFilter' => $predicateFilter,
                'trueMutations' => $mutations
            ]
        );
        $this->assertTrue($result);
        $row = self::$table->readRow('rk1');
        $expectedRow = [
            'cf1' => [
                'cq1' => [
                    [
                        'value' => 'value11',
                        'timeStamp' => 6000,
                        'labels' => ''
                    ],
                    [
                        'value' => 'value1',
                        'timeStamp' => 5000,
                        'labels' => ''
                    ]
                ]
            ]
        ];
        $this->assertEquals($expectedRow, $row);
    }

    public function testCheckAndMutateRowWithFilterNotYieldingCell()
    {
        $predicateFilter = Filter::qualifier()->exactMatch('cq10');
        $trueMutations = (new Mutations)->upsert('cf1', 'cq1', 'value12', 6000);
        $falseMutations = (new Mutations)->upsert('cf1', 'cq1', 'value11', 6000);
        $result = self::$table->checkAndMutateRow(
            'rk1',
            [
                'predicateFilter' => $predicateFilter,
                'trueMutations' => $trueMutations,
                'falseMutations' => $falseMutations
            ]
        );
        $this->assertFalse($result);
        $row = self::$table->readRow('rk1');
        $expectedRow = [
            'cf1' => [
                'cq1' => [
                    [
                        'value' => 'value11',
                        'timeStamp' => 6000,
                        'labels' => ''
                    ],
                    [
                        'value' => 'value1',
                        'timeStamp' => 5000,
                        'labels' => ''
                    ]
                ]
            ]
        ];
        $this->assertEquals($expectedRow, $row);
    }
}

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

use Google\Cloud\Bigtable\Mutations;

/**
 * @group bigtable
 * @group bigtabledata
 */
class MutateRowsTest extends BigtableTestCase
{
    public function testBasicWriteAndReadDataOperation()
    {
        $insertRows = [
            'rk1' => [
                'cf1' => [
                    'cq1' => [
                        'value' => 'value1',
                        'timeStamp' => 5000
                    ]
                ]
            ]
        ];
        self::$table->upsert($insertRows);
        $readRows = [
            'rk1' => [
                'cf1' => [
                    'cq1' => [[
                        'value' => 'value1',
                        'timeStamp' => 5000,
                        'labels' => ''
                    ]]
                ]
            ]
        ];
        $rows = iterator_to_array(self::$table->readRows(['rowKeys' => ['rk1']])->readAll());
        $this->assertEquals($readRows, $rows);
    }

    public function testBasicWriteAndReadDataOperationUsingMutateRow()
    {
        $mutations = (new Mutations)
            ->upsert('cf1', 'cq1', 'value1', 5000);
        self::$dataClient->mutateRow('rk10', $mutations);
        $readRows = [
            'rk10' => [
                'cf1' => [
                    'cq1' => [[
                        'value' => 'value1',
                        'timeStamp' => 5000,
                        'labels' => ''
                    ]]
                ]
            ]
        ];
        $rows = iterator_to_array(self::$dataClient->readRows(['rowKeys' => ['rk10']])->readAll());
        $this->assertEquals($readRows, $rows);
    }

    public function testDeleteRow()
    {
        $insertRows = [
            'rk2' => [
                'cf1' => [
                    'cq1' => [
                        'value' => 'value1',
                        'timeStamp' => 5000
                    ]
                ]
            ]
        ];
        self::$table->upsert($insertRows);
        $mutations = (new Mutations)->deleteRow();
        self::$table->mutateRows(['rk2' => $mutations]);
        $rows = iterator_to_array(self::$table->readRows(['rowKeys' => ['rk2']])->readAll());
        $this->assertEquals([], $rows);
    }

    public function testDeleteFromFamily()
    {
        $insertRows = [
            'rk3' => [
                'cf1' => [
                    'cq1' => [
                        'value' => 'value1',
                        'timeStamp' => 5000
                    ]
                ],
                'cf2' => [
                    'cq1' => [
                        'value' => 'value1',
                        'timeStamp' => 5000
                    ]
                ]
            ]
        ];
        self::$table->upsert($insertRows);
        $mutations = (new Mutations)->deleteFromFamily('cf2');
        self::$table->mutateRows(['rk3' => $mutations]);
        $rows = iterator_to_array(self::$table->readRows(['rowKeys' => ['rk3']])->readAll());
        $expectedRows = [
            'rk3' => [
                'cf1' => [
                    'cq1' => [[
                        'value' => 'value1',
                        'timeStamp' => 5000,
                        'labels' => ''
                    ]]
                ]
            ]
        ];
        $this->assertEquals($expectedRows, $rows);
    }

    public function testDeleteFromColumn()
    {
        $insertRows = [
            'rk4' => [
                'cf1' => [
                    'cq1' => [
                        'value' => 'value1',
                        'timeStamp' => 5000
                    ],
                    'cq2' => [
                        'value' => 'value2',
                        'timeStamp' => 10000
                    ]
                ]
            ]
        ];
        self::$table->upsert($insertRows);
        $mutations = (new Mutations)->deleteFromColumn('cf1', 'cq2');
        self::$table->mutateRows(['rk4' => $mutations]);
        $rows = iterator_to_array(self::$table->readRows(['rowKeys' => ['rk4']])->readAll());
        $expectedRows = [
            'rk4' => [
                'cf1' => [
                    'cq1' => [[
                        'value' => 'value1',
                        'timeStamp' => 5000,
                        'labels' => ''
                    ]]
                ]
            ]
        ];
        $this->assertEquals($expectedRows, $rows);
    }

    public function testDeleteFromColumnWithRange()
    {
        $insertRows = [
            'rk5' => [
                'cf1' => [
                    'cq1' => [
                        'value' => 'value1',
                        'timeStamp' => 5000
                    ],
                    'cq2' => [
                        'value' => 'value2',
                        'timeStamp' => 10000
                    ]
                ]
            ]
        ];
        self::$table->upsert($insertRows);
        $insertRows = [
            'rk5' => [
                'cf1' => [
                    'cq2' => [
                        'value' => 'value2',
                        'timeStamp' => 20000
                    ]
                ]
            ]
        ];
        self::$table->upsert($insertRows);
        $insertRows = [
            'rk5' => [
                'cf1' => [
                    'cq2' => [
                        'value' => 'value2',
                        'timeStamp' => 30000
                    ]
                ]
            ]
        ];
        self::$table->upsert($insertRows);
        $mutations = (new Mutations)->deleteFromColumn('cf1', 'cq2', ['start' => 21000, 'end' => 40000]);
        self::$table->mutateRows(['rk5' => $mutations]);
        $rows = iterator_to_array(self::$table->readRows(['rowKeys' => ['rk5']])->readAll());
        $expectedRows = [
            'rk5' => [
                'cf1' => [
                    'cq1' => [[
                        'value' => 'value1',
                        'timeStamp' => 5000,
                        'labels' => ''
                    ]],
                    'cq2'=> [
                        [
                            'value' => 'value2',
                            'timeStamp' => 20000,
                            'labels' => ''
                        ],
                        [
                            'value' => 'value2',
                            'timeStamp' => 10000,
                            'labels' => ''
                        ]
                    ]
                ]
            ]
        ];
        $this->assertEquals($expectedRows, $rows);
    }
}

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

use Google\Cloud\Bigtable\Tests\System\DataClientTest;
use Google\Cloud\Bigtable\RowMutation;

/**
 * @group bigtable
 * @group bigtabledata
 */
class DataClientMutateRowsTest extends DataClientTest
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
        self::$dataClient->upsert($insertRows);
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
        $rows = iterator_to_array(self::$dataClient->readRows(['rowKeys' => 'rk1'])->readAll());
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
        self::$dataClient->upsert($insertRows);
        $rowMutation = new RowMutation('rk2');
        $rowMutation->deleteRow();
        self::$dataClient->mutateRows([$rowMutation]);
        $rows = iterator_to_array(self::$dataClient->readRows(['rowKeys' => 'rk2'])->readAll());
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
        self::$dataClient->upsert($insertRows);
        $rowMutation = new RowMutation('rk3');
        $rowMutation->deleteFromFamily('cf2');
        self::$dataClient->mutateRows([$rowMutation]);
        $rows = iterator_to_array(self::$dataClient->readRows(['rowKeys' => 'rk3'])->readAll());
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
        self::$dataClient->upsert($insertRows);
        $rowMutation = new RowMutation('rk4');
        $rowMutation->deleteFromColumn('cf1', 'cq2');
        self::$dataClient->mutateRows([$rowMutation]);
        $rows = iterator_to_array(self::$dataClient->readRows(['rowKeys' => 'rk4'])->readAll());
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
        self::$dataClient->upsert($insertRows);
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
        self::$dataClient->upsert($insertRows);
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
        self::$dataClient->upsert($insertRows);
        $rowMutation = new RowMutation('rk5');
        $rowMutation->deleteFromColumn('cf1', 'cq2', ['start' => 21000, 'end' => 40000]);
        self::$dataClient->mutateRows([$rowMutation]);
        $rows = iterator_to_array(self::$dataClient->readRows(['rowKeys' => 'rk5'])->readAll());
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

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
class LimitFilterTest extends FilterTest
{
    public function testCellsPerRow()
    {
        $rowFilter = Filter::limit()->cellsPerRow(2);
        $rows = iterator_to_array(
            self::$dataClient->readRows(
                [
                    'rowKeys' => ['rk1', 'rk2'],
                    'filter' => $rowFilter
                ]
            )->readAll()
        );
        $expectedRows = [
            'rk1' => [
                'cf0' => [
                    'cq0' => self::$expectedRows['rk1']['cf0']['cq0'],
                    'cq1' => self::$expectedRows['rk1']['cf0']['cq1']
                ]
            ],
            'rk2' => [
                'cf0' => [
                    'cq0' => self::$expectedRows['rk2']['cf0']['cq0'],
                    'cq1' => self::$expectedRows['rk2']['cf0']['cq1']
                ]
            ]
        ];
        $this->assertEquals($expectedRows, $rows);
    }

    public function testCellsPerColumn()
    {
        $insertExtraCell = [
            'rk1' => [
                'cf0' => [
                    'cq0' => [
                        'value' => 'value1001',
                        'timeStamp' => 4000
                    ],
                    'cq1' => [
                        'value' => 'value1011',
                        'timeStamp' => 4000
                    ]
                ]
            ],
            'rk2' => [
                'cf0' => [
                    'cq0' => [
                        'value' => 'value1001',
                        'timeStamp' => 4000
                    ],
                    'cq1' => [
                        'value' => 'value1011',
                        'timeStamp' => 4000
                    ]
                ]
            ]
        ];
        self::$dataClient->upsert($insertExtraCell);
        $insertExtraCell = [
            'rk1' => [
                'cf0' => [
                    'cq0' => [
                        'value' => 'value1002',
                        'timeStamp' => 5000
                    ],
                    'cq1' => [
                        'value' => 'value1012',
                        'timeStamp' => 5000
                    ]
                ]
            ],
            'rk2' => [
                'cf0' => [
                    'cq0' => [
                        'value' => 'value1002',
                        'timeStamp' => 5000
                    ],
                    'cq1' => [
                        'value' => 'value1012',
                        'timeStamp' => 5000
                    ]
                ]
            ]
        ];
        self::$dataClient->upsert($insertExtraCell);
        $rowFilter = Filter::chain()
            ->addFilter(Filter::family()->exactMatch('cf0'))
            ->addFilter(Filter::qualifier()->regex('cq[01]+'))
            ->addFilter(Filter::limit()->cellsPerColumn(2));
        $rows = iterator_to_array(
            self::$dataClient->readRows(
                [
                    'rowKeys' => ['rk1', 'rk2'],
                    'filter' => $rowFilter
                ]
            )->readAll()
        );
        $expectedRows = [
            'rk1' => [
                'cf0' => [
                    'cq0' => [
                        [
                            'value' => 'value1002',
                            'timeStamp' => 5000,
                            'labels' => ''
                        ],
                        [
                            'value' => 'value1001',
                            'timeStamp' => 4000,
                            'labels' => ''
                        ]
                    ],
                    'cq1' => [
                        [
                            'value' => 'value1012',
                            'timeStamp' => 5000,
                            'labels' => ''
                        ],
                        [
                            'value' => 'value1011',
                            'timeStamp' => 4000,
                            'labels' => ''
                        ]
                    ]
                ]
            ],
            'rk2' => [
                'cf0' => [
                    'cq0' => [
                        [
                            'value' => 'value1002',
                            'timeStamp' => 5000,
                            'labels' => ''
                        ],
                        [
                            'value' => 'value1001',
                            'timeStamp' => 4000,
                            'labels' => ''
                        ]
                    ],
                    'cq1' => [
                        [
                            'value' => 'value1012',
                            'timeStamp' => 5000,
                            'labels' => ''
                        ],
                        [
                            'value' => 'value1011',
                            'timeStamp' => 4000,
                            'labels' => ''
                        ]
                    ]
                ]
            ]
        ];
        $this->assertEquals($expectedRows, $rows);
    }
}

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

/**
 * @group bigtable
 * @group bigtabledata
 */
class ReadRowsTest extends BigtableTestCase
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
            'rk2' => [
                'cf1' => [
                    'cq2' => [
                        'value' => 'value2',
                        'timeStamp' => 5000
                    ]
                ]
            ],
            'rk3' => [
                'cf1' => [
                    'cq3' => [
                        'value' => 'value3',
                        'timeStamp' => 5000
                    ]
                ]
            ],
            'rk4' => [
                'cf1' => [
                    'cq4' => [
                        'value' => 'value4',
                        'timeStamp' => 5000
                    ]
                ]
            ],
            'rk5' => [
                'cf1' => [
                    'cq5' => [
                        'value' => 'value5',
                        'timeStamp' => 5000
                    ]
                ]
            ]
        ];
        self::$table->upsert($insertRows);
    }

    public function testReadRowsRowsLimit()
    {
        $rows = iterator_to_array(
            self::$table->readRows(
                [
                    'rowsLimit' => 2
                ]
            )->readAll()
        );
        $expectedRows = [
            'rk1' => [
                'cf1' => [
                    'cq1' => [
                        [
                            'value' => 'value1',
                            'timeStamp' => 5000,
                            'labels' => ''
                        ]
                    ]
                ]
            ],
            'rk2' => [
                'cf1' => [
                    'cq2' => [
                        [
                            'value' => 'value2',
                            'timeStamp' => 5000,
                            'labels' => ''
                        ]
                    ]
                ]
            ]
        ];
        $this->assertEquals($expectedRows, $rows);
    }

    public function testReadRowsSingleKey()
    {
        $rows = iterator_to_array(
            self::$table->readRows(
                [
                    'rowKeys' => ['rk2']
                ]
            )->readAll()
        );
        $expectedRows = [
            'rk2' => [
                'cf1' => [
                    'cq2' => [
                        [
                            'value' => 'value2',
                            'timeStamp' => 5000,
                            'labels' => ''
                        ]
                    ]
                ]
            ]
        ];
        $this->assertEquals($expectedRows, $rows);
    }

    public function testReadRowsMultipleRows()
    {
        $rows = iterator_to_array(
            self::$table->readRows(
                [
                    'rowKeys' => ['rk2', 'rk3']
                ]
            )->readAll()
        );
        $expectedRows = [
            'rk2' => [
                'cf1' => [
                    'cq2' => [
                        [
                            'value' => 'value2',
                            'timeStamp' => 5000,
                            'labels' => ''
                        ]
                    ]
                ]
            ],
            'rk3' => [
                'cf1' => [
                    'cq3' => [
                        [
                            'value' => 'value3',
                            'timeStamp' => 5000,
                            'labels' => ''
                        ]
                    ]
                ]
            ]
        ];
        $this->assertEquals($expectedRows, $rows);
    }

    public function testReadRowsRowRangesStartOpen()
    {
        $rows = iterator_to_array(
            self::$table->readRows(
                [
                    'rowRanges' => [
                         [
                            'startKeyOpen' => 'rk3'
                         ]
                    ]
                ]
            )->readAll()
        );
        $expectedRows = [
            'rk4' => [
                'cf1' => [
                    'cq4' => [
                        [
                            'value' => 'value4',
                            'timeStamp' => 5000,
                            'labels' => ''
                        ]
                    ]
                ]
            ],
            'rk5' => [
                'cf1' => [
                    'cq5' => [
                        [
                            'value' => 'value5',
                            'timeStamp' => 5000,
                            'labels' => ''
                        ]
                    ]
                ]
            ]
        ];
        $this->assertEquals($expectedRows, $rows);
    }

    public function testReadRowsRowRangesStartClosed()
    {
        $rows = iterator_to_array(
            self::$table->readRows(
                [
                    'rowRanges' => [
                         [
                            'startKeyClosed' => 'rk4'
                         ]
                    ]
                ]
            )->readAll()
        );
        $expectedRows = [
            'rk4' => [
                'cf1' => [
                    'cq4' => [
                        [
                            'value' => 'value4',
                            'timeStamp' => 5000,
                            'labels' => ''
                        ]
                    ]
                ]
            ],
            'rk5' => [
                'cf1' => [
                    'cq5' => [
                        [
                            'value' => 'value5',
                            'timeStamp' => 5000,
                            'labels' => ''
                        ]
                    ]
                ]
            ]
        ];
        $this->assertEquals($expectedRows, $rows);
    }

    public function testReadRowsRowRangesEndOpen()
    {
        $rows = iterator_to_array(
            self::$table->readRows(
                [
                    'rowRanges' => [
                         [
                            'endKeyOpen' => 'rk3'
                         ]
                    ]
                ]
            )->readAll()
        );
        $expectedRows = [
            'rk1' => [
                'cf1' => [
                    'cq1' => [
                        [
                            'value' => 'value1',
                            'timeStamp' => 5000,
                            'labels' => ''
                        ]
                    ]
                ]
            ],
            'rk2' => [
                'cf1' => [
                    'cq2' => [
                        [
                            'value' => 'value2',
                            'timeStamp' => 5000,
                            'labels' => ''
                        ]
                    ]
                ]
            ]
        ];
        $this->assertEquals($expectedRows, $rows);
    }

    public function testReadRowsRowRangesEndClosed()
    {
        $rows = iterator_to_array(
            self::$table->readRows(
                [
                    'rowRanges' => [
                         [
                            'endKeyOpen' => 'rk2'
                         ]
                    ]
                ]
            )->readAll()
        );
        $expectedRows = [
            'rk1' => [
                'cf1' => [
                    'cq1' => [
                        [
                            'value' => 'value1',
                            'timeStamp' => 5000,
                            'labels' => ''
                        ]
                    ]
                ]
            ]
        ];
        $this->assertEquals($expectedRows, $rows);
    }

    public function testReadRowsRowRangesStartOpenEndClosed()
    {
        $rows = iterator_to_array(
            self::$table->readRows(
                [
                    'rowRanges' => [
                         [
                            'startKeyOpen' => 'rk1',
                            'endKeyClosed' => 'rk2'
                         ]
                    ]
                ]
            )->readAll()
        );
        $expectedRows = [
            'rk2' => [
                'cf1' => [
                    'cq2' => [
                        [
                            'value' => 'value2',
                            'timeStamp' => 5000,
                            'labels' => ''
                        ]
                    ]
                ]
            ]
        ];
        $this->assertEquals($expectedRows, $rows);
    }

    public function testReadRowsRowRangesStartClosedEndClosed()
    {
        $rows = iterator_to_array(
            self::$table->readRows(
                [
                    'rowRanges' => [
                         [
                            'startKeyClosed' => 'rk1',
                            'endKeyClosed' => 'rk2'
                         ]
                    ]
                ]
            )->readAll()
        );
        $expectedRows = [
            'rk1' => [
                'cf1' => [
                    'cq1' => [
                        [
                            'value' => 'value1',
                            'timeStamp' => 5000,
                            'labels' => ''
                        ]
                    ]
                ]
            ],
            'rk2' => [
                'cf1' => [
                    'cq2' => [
                        [
                            'value' => 'value2',
                            'timeStamp' => 5000,
                            'labels' => ''
                        ]
                    ]
                ]
            ]
        ];
        $this->assertEquals($expectedRows, $rows);
    }

    public function testReadRowsRowRangesStartOpenEndOpen()
    {
        $rows = iterator_to_array(
            self::$table->readRows(
                [
                    'rowRanges' => [
                         [
                            'startKeyOpen' => 'rk1',
                            'endKeyOpen' => 'rk3'
                         ]
                    ]
                ]
            )->readAll()
        );
        $expectedRows = [
            'rk2' => [
                'cf1' => [
                    'cq2' => [
                        [
                            'value' => 'value2',
                            'timeStamp' => 5000,
                            'labels' => ''
                        ]
                    ]
                ]
            ]
        ];
        $this->assertEquals($expectedRows, $rows);
    }

    public function testReadRowsRowRangesStartClosedEndOpen()
    {
        $rows = iterator_to_array(
            self::$table->readRows(
                [
                    'rowRanges' => [
                         [
                            'startKeyClosed' => 'rk1',
                            'endKeyOpen' => 'rk3'
                         ]
                    ]
                ]
            )->readAll()
        );
        $expectedRows = [
            'rk1' => [
                'cf1' => [
                    'cq1' => [
                        [
                            'value' => 'value1',
                            'timeStamp' => 5000,
                            'labels' => ''
                        ]
                    ]
                ]
            ],
            'rk2' => [
                'cf1' => [
                    'cq2' => [
                        [
                            'value' => 'value2',
                            'timeStamp' => 5000,
                            'labels' => ''
                        ]
                    ]
                ]
            ]
        ];
        $this->assertEquals($expectedRows, $rows);
    }

    public function testReadRowsMultipleRanges()
    {
        $rows = iterator_to_array(
            self::$table->readRows(
                [
                    'rowRanges' => [
                         [
                            'startKeyClosed' => 'rk2',
                            'endKeyClosed' => 'rk2'
                         ],
                         [
                            'startKeyClosed' => 'rk4',
                            'endKeyClosed' => 'rk4'
                         ]
                    ]
                ]
            )->readAll()
        );
        $expectedRows = [
            'rk2' => [
                'cf1' => [
                    'cq2' => [
                        [
                            'value' => 'value2',
                            'timeStamp' => 5000,
                            'labels' => ''
                        ]
                    ]
                ]
            ],
            'rk4' => [
                'cf1' => [
                    'cq4' => [
                        [
                            'value' => 'value4',
                            'timeStamp' => 5000,
                            'labels' => ''
                        ]
                    ]
                ]
            ]
        ];
        $this->assertEquals($expectedRows, $rows);
    }
}

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
use Google\Cloud\Bigtable\Mutations;

/**
 * @group bigtable
 * @group bigtabledata
 */
class FilterTest extends BigtableTestCase
{
    protected static $rowMutations = [];

    public static function set_up_before_class()
    {
        parent::set_up_before_class();
        self::$table->mutateRows(self::$rowMutations);
    }

    private static function createExpectedRows($insertRows)
    {
        $expectedRows = $insertRows;
        foreach ($expectedRows as &$row) {
            foreach ($row as &$family) {
                foreach ($family as &$qualifier) {
                    $qualifier['labels'] = '';
                    $qualifier = [$qualifier];
                }
            }
        }
        return $expectedRows;
    }

    /**
     * @dataProvider filterProvider
     */
    public function testFilter($args, $expectedRows, $message, $emulatorMessage = null)
    {
        if (isset($emulatorMessage)) {
            self::skipIfEmulatorUsed($emulatorMessage);
        }

        $rows = iterator_to_array(
            self::$table->readRows($args)->readAll()
        );
        $this->assertEquals($expectedRows, $rows, $message);
    }

    public function filterProvider()
    {
        $text = file_get_contents(__DIR__ . '/data/data.json');
        $data = explode(PHP_EOL, $text);
        $insertRows = [];
        foreach ($data as $row) {
            $row = json_decode($row, true);
            foreach ($row as $rowKey => $family) {
                $mutations = isset(self::$rowMutations[$rowKey])
                    ? self::$rowMutations[$rowKey]
                    : new Mutations;
                $insertRows[$rowKey] = $family;
                foreach ($family as $familyName => $qualifier) {
                    foreach ($qualifier as $qualifierName => $value) {
                        $mutations->upsert($familyName, $qualifierName, $value['value'], $value['timeStamp']);
                    }
                }
                self::$rowMutations[$rowKey] = $mutations;
            }
        }
        $expectedRows = self::createExpectedRows($insertRows);
        return [
            [
                [
                    'rowKeys' => ['rk1'],
                    'filter' => Filter::chain()
                        ->addFilter(Filter::family()->exactMatch('cf1'))
                        ->addFilter(Filter::value()->exactMatch('value1'))
                ],
                [
                    'rk1' => [
                        'cf1' => [
                            'cq1' => $expectedRows['rk1']['cf1']['cq1']
                        ]
                    ]
                ],
                'testChain failed'
            ],
            [
                [
                    'filter' => Filter::condition(Filter::key()->exactMatch('rk1'))
                        ->then(Filter::family()->exactMatch('cf1'))
                ],
                [
                    'rk1' => [
                        'cf1' => $expectedRows['rk1']['cf1']
                    ]
                ],
                'testConditionThen failed'
            ],
            [
                [
                    'filter' => Filter::condition(Filter::qualifier()->exactMatch('cq20'))
                        ->otherwise(Filter::key()->exactMatch('rk1'))
                ],
                [
                    'rk1' => $expectedRows['rk1']
                ],
                'testConditionOtherwise failed'
            ],
            [
                [
                    'rowKeys' => ['rk1'],
                    'filter' => Filter::family()->exactMatch('cf1')
                ],
                [
                    'rk1' => [
                        'cf1' => $expectedRows['rk1']['cf1']
                    ]
                ],
                'testFamilyExactMatch failed'
            ],
            [
                [
                    'rowKeys' => ['rk1'],
                    'filter' => Filter::family()->regex('cf[12]+')
                ],
                [
                    'rk1' => [
                        'cf1' => $expectedRows['rk1']['cf1'],
                        'cf2' => $expectedRows['rk1']['cf2'],
                    ]
                ],
                'testFamilyRegex failed'
            ],
            [
                [
                    'rowKeys' => ['rk5'],
                    'filter' => Filter::interleave()
                        ->addFilter(Filter::qualifier()->exactMatch('cq1'))
                        ->addFilter(Filter::qualifier()->exactMatch('cq2'))
                ],
                [
                    'rk5' => [
                        'cf1' => [
                            'cq1' => $expectedRows['rk5']['cf1']['cq1'],
                            'cq2' => $expectedRows['rk5']['cf1']['cq2']
                        ]
                    ]
                ],
                'testInterleave failed'
            ],
            [
                [
                    'filter' => Filter::key()->exactMatch('rk1')
                ],
                [
                    'rk1' => $expectedRows['rk1']
                ],
                'testKeyExactMatch failed'
            ],
            [
                [
                    'filter' => Filter::key()->regex('rk[12]+')
                ],
                [
                    'rk1' => $expectedRows['rk1'],
                    'rk2' => $expectedRows['rk2']
                ],
                'testKeyRegex failed'
            ],
            [
                [
                    'rowKeys' => ['rk1', 'rk2'],
                    'filter' => Filter::limit()->cellsPerRow(2)
                ],
                [
                    'rk1' => [
                        'cf0' => [
                            'cq0' => $expectedRows['rk1']['cf0']['cq0'],
                            'cq1' => $expectedRows['rk1']['cf0']['cq1']
                        ]
                    ],
                    'rk2' => [
                        'cf0' => [
                            'cq0' => $expectedRows['rk2']['cf0']['cq0'],
                            'cq1' => $expectedRows['rk2']['cf0']['cq1']
                        ]
                    ]
                ],
                'testLimitCellsPerRow failed',
                'Limit cells per row: cannot rely on filtered cells order when using emulator.',
            ],
            [
                [
                    'rowKeys' => ['rk8', 'rk9'],
                    'filter' => Filter::limit()->cellsPerColumn(2)
                ],
                [
                    'rk8' => [
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
                    'rk9' => [
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
                ],
                'testLimitCellsPerColumn failed'
            ],
            [
                [
                    'rowKeys' => ['rk1', 'rk2'],
                    'filter' => Filter::offset()->cellsPerRow(90)
                ],
                [
                    'rk1' => [
                        'cf9' => $expectedRows['rk1']['cf9']
                    ],
                    'rk2' => [
                        'cf9' => $expectedRows['rk2']['cf9']
                    ]
                ],
                'testOffsetCellsPerRow failed',
                'Offset cells per row: cannot rely on filtered cells order when using emulator.',
            ],
            [
                [
                    'rowKeys' => ['rk5'],
                    'filter' => Filter::qualifier()->exactMatch('cq1')
                ],
                [
                    'rk5' => [
                        'cf1' => [
                            'cq1' => $expectedRows['rk5']['cf1']['cq1']
                        ]
                    ]
                ],
                'testQualifierExactMatch failed'
            ],
            [
                [
                    'rowKeys' => ['rk5'],
                    'filter' => Filter::qualifier()->regex('cq[12]+')
                ],
                [
                    'rk5' => [
                        'cf1' => [
                            'cq1' => $expectedRows['rk5']['cf1']['cq1'],
                            'cq2' => $expectedRows['rk5']['cf1']['cq2']
                        ]
                    ]
                ],
                'testQualifierRegex failed'
            ],
            [
                [
                    'rowKeys' => ['rk6'],
                    'filter' => Filter::qualifier()->rangeWithinFamily('cf1')->of('cq1', 'cq3')
                ],
                [
                    'rk6' => [
                        'cf1' => [
                            'cq1' => $expectedRows['rk6']['cf1']['cq1'],
                            'cq2' => $expectedRows['rk6']['cf1']['cq2']
                        ]
                    ]
                ],
                'testQualifierRangeWithinFamily failed'
            ],
            [
                [
                    'rowKeys' => ['rk1'],
                    'filter' => Filter::pass()
                ],
                [
                    'rk1' => $expectedRows['rk1']
                ],
                'testPass failed'
            ],
            [
                [
                    'filter' => Filter::block()
                ],
                [],
                'testBlock failed'
            ],
            [
                [
                    'rowKeys' => ['rk1'],
                    'filter' => Filter::sink()
                ],
                [
                    'rk1' => $expectedRows['rk1']
                ],
                'testSink failed',
                'Sink: this filter type is not implemented in emulator.'
            ],
            [
                [
                    'rowKeys' => ['rk5'],
                    'filter' => Filter::timestamp()->range()->of(3000, 5000)
                ],
                [
                    'rk5' => [
                        'cf1' => [
                            'cq2' => $expectedRows['rk5']['cf1']['cq2'],
                            'cq3' => $expectedRows['rk5']['cf1']['cq3']
                        ]
                    ]
                ],
                'testTimestampRange failed'
            ],
            [
                [
                    'rowKeys' => ['rk5'],
                    'filter' => Filter::value()->exactMatch('value1')
                ],
                [
                    'rk5' => [
                        'cf1' => [
                            'cq1' => $expectedRows['rk5']['cf1']['cq1']
                        ]
                    ]
                ],
                'testValueExactMatch failed'
            ],
            [
                [
                    'rowKeys' => ['rk5'],
                    'filter' => Filter::value()->regex('value[12]+')
                ],
                [
                    'rk5' => [
                        'cf1' => [
                            'cq1' => $expectedRows['rk5']['cf1']['cq1'],
                            'cq2' => $expectedRows['rk5']['cf1']['cq2']
                        ]
                    ]
                ],
                'testValueRegex failed'
            ],
            [
                [
                    'rowKeys' => ['rk5'],
                    'filter' => Filter::value()->range()->of('value1', 'value3')
                ],
                [
                    'rk5' => [
                        'cf1' => [
                            'cq1' => $expectedRows['rk5']['cf1']['cq1'],
                            'cq2' => $expectedRows['rk5']['cf1']['cq2']
                        ]
                    ]
                ],
                'testValueRange failed'
            ],
            [
                [
                    'rowKeys' => ['rk7'],
                    'filter' => Filter::value()->strip()
                ],
                [
                    'rk7' => [
                        'cf1' => [
                            'cq1' => [[
                                'value' => '',
                                'labels' => '',
                                'timeStamp' => 2000
                            ]]
                        ]
                    ]
                ],
                'testValueStrip failed'
            ],
        ];
    }

    public function testSample()
    {
        $rowFilter = Filter::key()->sample(.50);
        $rows = iterator_to_array(
            self::$table->readRows(
                [
                    'filter' => $rowFilter
                ]
            )->readAll()
        );
        $this->assertGreaterThan(0, count($rows));
    }

    public function testLabel()
    {
        //TODO Implement label test
    }
}

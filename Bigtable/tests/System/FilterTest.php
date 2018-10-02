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
use Google\Cloud\Bigtable\RowMutation;
use Google\Cloud\Bigtable\Tests\System\DataClientTest;

/**
 * @group bigtable
 * @group bigtabledata
 */
class FilterTest extends DataClientTest
{
    protected static $insertRows = [];
    protected static $expectedRows = [];
    protected static $rowMutations = [];
    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();
        self::$dataClient->mutateRows(self::$rowMutations);
    }

    private static function createExpectedRows()
    {
        self::$expectedRows = self::$insertRows;
        foreach (self::$expectedRows as &$row) {
            foreach ($row as &$family) {
                foreach ($family as &$qualifier) {
                    $qualifier['labels'] = '';
                    $qualifier = [$qualifier];
                }
            }
        }
    }

    /**
     * @dataProvider filterProvider
     */
    public function testFilter($args, $expectedRows, $message)
    {
        $rows = iterator_to_array(
            self::$dataClient->readRows($args)->readAll()
        );
        $this->assertEquals($expectedRows, $rows, $message);
    }

    public function filterProvider()
    {
        $text = file_get_contents(__DIR__ . '/data/data.json');
        $data = explode(PHP_EOL, $text);
        foreach ($data as $row) {
            $row = json_decode($row, true);
            foreach ($row as $rowKey => $family) {
                $rowMutation = new RowMutation($rowKey);
                self::$insertRows[$rowKey] = $family;
                foreach ($family as $familyName => $qualifier) {
                    foreach ($qualifier as $qualifierName => $value) {
                        $rowMutation->upsert($familyName, $qualifierName, $value['value'], $value['timeStamp']);
                    }
                }
                self::$rowMutations[] = $rowMutation;
            }
        }
        self::createExpectedRows();
        $returnData = [
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
                            'cq1' => self::$expectedRows['rk1']['cf1']['cq1']
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
                        'cf1' => self::$expectedRows['rk1']['cf1']
                    ]
                ],
                'testCondtionThen failed'
            ],
            [
                [
                    'filter' => Filter::condition(Filter::qualifier()->exactMatch('cq20'))
                        ->otherwise(Filter::key()->exactMatch('rk1'))
                ],
                [
                    'rk1' => self::$expectedRows['rk1']
                ],
                'testCondtionOtherwise failed'
            ],
            [
                [
                    'rowKeys' => ['rk1'],
                    'filter' => Filter::family()->exactMatch('cf1')
                ],
                [
                    'rk1' => [
                        'cf1' => self::$expectedRows['rk1']['cf1']
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
                        'cf1' => self::$expectedRows['rk1']['cf1'],
                        'cf2' => self::$expectedRows['rk1']['cf2'],
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
                            'cq1' => self::$expectedRows['rk5']['cf1']['cq1'],
                            'cq2' => self::$expectedRows['rk5']['cf1']['cq2']
                        ]
                    ]
                ],
                'testinterleave failed'
            ],
            [
                [
                    'filter' => Filter::key()->exactMatch('rk1')
                ],
                [
                    'rk1' => self::$expectedRows['rk1']
                ],
                'testKeyExactMatch failed'
            ],
            [
                [
                    'filter' => Filter::key()->regex('rk[12]+')
                ],
                [
                    'rk1' => self::$expectedRows['rk1'],
                    'rk2' => self::$expectedRows['rk2']
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
                ],
                'testLimitCellsPerRow failed'
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
                        'cf9' => self::$expectedRows['rk1']['cf9']
                    ],
                    'rk2' => [
                        'cf9' => self::$expectedRows['rk2']['cf9']
                    ]
                ],
                'testOffsetCellsPerRow failed'
            ],
            [
                [
                    'rowKeys' => ['rk5'],
                    'filter' => Filter::qualifier()->exactMatch('cq1')
                ],
                [
                    'rk5' => [
                        'cf1' => [
                            'cq1' => self::$expectedRows['rk5']['cf1']['cq1']
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
                            'cq1' => self::$expectedRows['rk5']['cf1']['cq1'],
                            'cq2' => self::$expectedRows['rk5']['cf1']['cq2']
                        ]
                    ]
                ],
                'testQualifierRegex failed'
            ],
            [
                [
                    'rowKeys' => ['rk6'],
                    'filter' => Filter::qualifier()->rangeWithInFamily('cf1')->of('cq1', 'cq3')
                ],
                [
                    'rk6' => [
                        'cf1' => [
                            'cq1' => self::$expectedRows['rk6']['cf1']['cq1'],
                            'cq2' => self::$expectedRows['rk6']['cf1']['cq2']
                        ]
                    ]
                ],
                'testQualifierRangeWithInFamily failed'
            ],
            [
                [
                    'rowKeys' => ['rk1'],
                    'filter' => Filter::pass()
                ],
                [
                    'rk1' => self::$expectedRows['rk1']
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
                    'rk1' => self::$expectedRows['rk1']
                ],
                'testSink failed'
            ],
            [
                [
                    'rowKeys' => ['rk5'],
                    'filter' => Filter::timestamp()->range()->of(3000, 5000)
                ],
                [
                    'rk5' => [
                        'cf1' => [
                            'cq2' => self::$expectedRows['rk5']['cf1']['cq2'],
                            'cq3' => self::$expectedRows['rk5']['cf1']['cq3']
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
                            'cq1' => self::$expectedRows['rk5']['cf1']['cq1']
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
                            'cq1' => self::$expectedRows['rk5']['cf1']['cq1'],
                            'cq2' => self::$expectedRows['rk5']['cf1']['cq2']
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
                            'cq1' => self::$expectedRows['rk5']['cf1']['cq1'],
                            'cq2' => self::$expectedRows['rk5']['cf1']['cq2']
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
        return $returnData;
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

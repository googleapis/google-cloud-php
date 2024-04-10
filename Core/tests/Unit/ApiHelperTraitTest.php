<?php
/**
 * Copyright 2023 Google Inc.
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

namespace Google\Cloud\Core\Tests\Unit;

use Google\Cloud\Core\Duration;
use Google\Cloud\Core\Testing\GrpcTestTrait;
use Google\Cloud\Core\Tests\Unit\Stubs\ApiHelpersTraitImpl;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;

/**
 * @group core
 */
class ApiHelperTraitTest extends TestCase
{
    use GrpcTestTrait;
    use ProphecyTrait;

    private $implementation;

    public function setUp(): void
    {
        $this->implementation = new ApiHelpersTraitImpl();
    }

    public function testFormatsTimestamp()
    {
        $timestamp = [
            'seconds' => '1471242909',
            'nanos' => '1'
        ];

        $this->assertEquals(
            '2016-08-15T06:35:09.000000001Z',
            $this->implementation->formatTimestampFromApi($timestamp)
        );
    }

    public function testFormatsStruct()
    {
        $value = 'test';
        $struct = [
            $value => [
                $value => $value
            ]
        ];

        $expected = [
            'fields' => [
                $value => [
                    'struct_value' => [
                        'fields' => [
                            $value => [
                                'string_value' => $value
                            ]
                        ]
                    ]
                ]
            ]
        ];

        $this->assertEquals($expected, $this->implementation->formatStructForApi($struct));
    }

    public function testFormatsList()
    {
        $value = 'test';
        $list = [
            $value,
            $value
        ];
        $expected = [
            'values' => [
                [
                    'string_value' => $value,
                ],
                [
                    'string_value' => $value
                ]
            ]
        ];

        $this->assertEquals($expected, $this->implementation->formatListForApi($list));
    }

    /**
     * @dataProvider timestampProvider
     */
    public function testFormatTimestampForApi($timestamp, $expectedSeconds, $expectedNanos)
    {
        $result = $this->implementation->formatTimestampForApi($timestamp);

        $this->assertEquals($expectedSeconds, $result['seconds']);
        $this->assertEquals($expectedNanos, $result['nanos']);
    }

    public function timestampProvider()
    {
        return [
            [
                '2017-08-24T00:38:30.611529Z',
                '1503535110',
                '611529000'
            ],
            [
                '2017-08-24T00:38:30.000000000Z',
                '1503535110',
                '0'
            ],
            [
                '2017-08-24T00:38:30.000000001Z',
                '1503535110',
                '1'
            ],
            [
                '2017-04-06T20:52:45.989898989Z',
                '1491511965',
                '989898989'
            ]
        ];
    }

    /**
     * @dataProvider durationProvider
     */
    public function testFormatsDuration($value, $expected)
    {
        $this->assertEquals($expected, $this->implementation->formatDurationForApi($value));
    }

    public function durationProvider()
    {
        return [
            [
                '1.0s',
                ['seconds' => 1, 'nanos' => 0]
            ], [
                '5.11111111s',
                ['seconds' => 5, 'nanos' => 111111110]
            ], [
                new Duration(1, 0),
                ['seconds' => 1, 'nanos' => 0]
            ], [
                new Duration(1, 1),
                ['seconds' => 1, 'nanos' => 1]
            ], [
                new Duration(1, 1e+9),
                ['seconds' => 1, 'nanos' => 1e+9]
            ]
        ];
    }

    /**
     * @dataProvider formatValueProvider
     */
    public function testFormatsValue($value, $expected)
    {
        $this->assertEquals($expected, $this->implementation->formatValueForApi($value));
    }

    public function formatValueProvider()
    {
        return [
            ['string', ['string_value' => 'string']],
            [true, ['bool_value' => true]],
            [1, ['number_value' => 1]],
            [
                ['1'],
                [
                    'list_value' => [
                        'values' => [
                            [
                                'string_value' => '1'
                            ]
                        ]
                    ]
                ]
            ],
            [
                ['test' => 'test'],
                [
                    'struct_value' => [
                        'fields' => [
                            'test' => [
                                'string_value' => 'test'
                            ]
                        ]
                    ]
                ]
            ]
        ];
    }

    /**
     * @dataProvider unpackValueProvider
     */
    public function testUnpackValue($expected, $value)
    {
        $this->assertEquals($expected, $this->implementation->unpackValue($value));
    }

    public function unpackValueProvider()
    {
        return [
            ['string', ['stringValue' => 'string']],
            [
                ['1'],
                [
                    'listValue' => [
                        'values' => [
                            [
                                'stringValue' => '1'
                            ]
                        ]
                    ]
                ]
            ],
            [
                [
                    'test' =>'test',
                    'nested' => [
                        'test' => 'test'
                    ]
                ],
                [
                    'structValue' => [
                        'fields' => [
                            'test' => [
                                'stringValue' => 'test'
                            ],
                            'nested' => [
                                'structValue' => [
                                    'fields' => [
                                        'test' => [
                                            'stringValue' => 'test'
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];
    }
}

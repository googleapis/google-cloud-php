<?php
/**
 * Copyright 2016 Google Inc.
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

namespace Google\Cloud\BigQuery\Tests\Unit;

use Google\Cloud\BigQuery\Bytes;
use Google\Cloud\BigQuery\Date;
use Google\Cloud\BigQuery\Numeric;
use Google\Cloud\BigQuery\Time;
use Google\Cloud\BigQuery\Timestamp;
use Google\Cloud\BigQuery\ValueMapper;
use Google\Cloud\Core\Int64;
use PHPUnit\Framework\TestCase;

/**
 * @group bigquery
 */
class ValueMapperTest extends TestCase
{
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testThrowsExceptionWithUnhandledClass()
    {
        $mapper = new ValueMapper(false);
        $mapper->toParameter(new \stdClass());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testToParameterThrowsExceptionWithUnhandledType()
    {
        $f = fopen('php://temp','r');
        fclose($f);
        $mapper = new ValueMapper(false);
        $mapper->toParameter($f);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testFromBigQueryThrowsExceptionWithUnhandledType()
    {
        $mapper = new ValueMapper(false);
        $mapper->fromBigQuery(['v' => 'hi'], ['type' => 'BLAH']);
    }

    public function testReturnsInt64Object()
    {
        $mapper = new ValueMapper(true);
        $actual = $mapper->fromBigQuery(['v' => '123'], ['type' => 'INTEGER']);

        $this->assertInstanceOf(Int64::class, $actual);
        $this->assertEquals('123', $actual->get());
    }

    public function testParameterFromInt64Object()
    {
        $value = '123';
        $mapper = new ValueMapper(true);
        $int = new Int64($value);
        $actual = $mapper->toParameter($int);

        $this->assertEquals([
            'parameterType' => [
                'type' => 'INT64'
            ],
            'parameterValue' => [
                'value' => $value
            ]
        ], $actual);
    }

    /**
     * @dataProvider bigQueryValueProvider
     */
    public function testMapsFromBigQuery($value, $schema, $expected)
    {
        $mapper = new ValueMapper(false);
        $actual = $mapper->fromBigQuery($value, $schema);

        $this->assertEquals($expected, $actual);
    }

    public function bigQueryValueProvider()
    {
        return [
            [
                ['v' => 'true'],
                ['type' => 'BOOLEAN'],
                true
            ],
            [
                ['v' => '123'],
                ['type' => 'INTEGER'],
                123
            ],
            [
                ['v' => '12.3'],
                ['type' => 'FLOAT'],
                12.3
            ],
            [
                ['v' => '99999999999999999999999999999999999999.999999999'],
                ['type' => 'NUMERIC'],
                new Numeric('99999999999999999999999999999999999999.999999999')
            ],
            [
                ['v' => 'Hello'],
                ['type' => 'STRING'],
                'Hello'
            ],
            [
                ['v' => '1980-01-01'],
                ['type' => 'DATE'],
                new Date(new \DateTime('1980-01-01'))
            ],
            [
                ['v' => '1980-01-01 12:15:15'],
                ['type' => 'DATETIME'],
                new \DateTime('1980-01-01 12:15:15')
            ],
            [
                ['v' => '12:15:15'],
                ['type' => 'TIME'],
                new Time(new \DateTime('12:15:15'))
            ],
            [
                ['v' => '1.438712914E9'],
                ['type' => 'TIMESTAMP'],
                new Timestamp(new \DateTime('2015-08-04 18:28:34Z'))
            ],
            [
                ['v' => '2678400.0'],
                ['type' => 'TIMESTAMP'],
                new Timestamp(new \DateTime('1970-02-01', new \DateTimeZone('UTC')))
            ],
            [
                ['v' => '-3.1561919984985E8'],
                ['type' => 'TIMESTAMP'],
                new Timestamp(new \DateTime('1960-01-01 00:00:00.150150Z'))
            ],
            [
                ['v' => '9.4668480015015E8'],
                ['type' => 'TIMESTAMP'],
                new Timestamp(new \DateTime('2000-01-01 00:00:00.150150Z'))
            ],
            [
                [
                    'v' => [
                        'f' => [
                            [
                                'v' => 'Hello'
                            ],
                            [
                                'v' => 'World'
                            ]
                        ]
                    ]
                ],
                [
                    'type' => 'RECORD',
                    'fields' => [
                        [
                            'name' => 'Say',
                            'type' => 'STRING'
                        ],
                        [
                            'name' => 'To the',
                            'type' => 'STRING'
                        ]
                    ]
                ],
                ['Say' => 'Hello', 'To the' => 'World']
            ],
            [
                [
                    'v' => [
                        ['v' => 'Hello'],
                        ['v' => 'World']
                    ]
                ],
                [
                    'type' => 'STRING',
                    'mode' => 'REPEATED'
                ],
                ['Hello', 'World']
            ],
            [
                ['v' => null],
                [
                    'type' => 'STRING',
                    'mode' => 'NULLABLE'
                ],
                null
            ]
        ];
    }

    public function testMapsBytesFromBigQuery()
    {
        $mapper = new ValueMapper(false);
        $actual = $mapper->fromBigQuery(
            ['v' => base64_encode('abcd')],
            ['type' => 'BYTES']
        );

        $this->assertEquals((string) new Bytes('abcd'), (string) $actual);
    }

    /**
     * @dataProvider toBigQueryValueProvider
     */
    public function testMapsToBigQuery($value, $expected)
    {
        $mapper = new ValueMapper(false);
        $actual = $mapper->toBigQuery($value);

        $this->assertEquals($expected, $actual);
    }

    public function toBigQueryValueProvider()
    {
        $dt = new \DateTime();
        $date = new Date($dt);
        $int64 = new Int64('123');
        $numeric = new Numeric('99999999999999999999999999999999999999.999999999');

        return [
            [$dt, $dt->format('Y-m-d\TH:i:s.u')],
            [$date, (string) $date],
            [
                ['date' => $date],
                ['date' => (string) $date]
            ],
            [1, 1],
            [$int64, '123'],
            [$numeric, $numeric->formatAsString()],
        ];
    }

    /**
     * @dataProvider parameterValueProvider
     */
    public function testMapsToParameter($value, $expected)
    {
        if (is_resource($value)) {
            rewind($value);
        }
        $mapper = new ValueMapper(false);
        $actual = $mapper->toParameter($value);

        $this->assertEquals($expected, $actual);
    }

    public function parameterValueProvider()
    {
        $bool = false;
        $int = 1234;
        $float = 1.234;
        $string = 'string';
        $resource = fopen('php://temp', 'r+');
        fwrite($resource, $string);
        rewind($resource);
        $dt = new \DateTime();
        $date = new Date($dt);
        $array = [1, 2, 3];
        $struct = [
            'key1' => 1,
            'key2' => 'string'
        ];

        return [
            [
                $string,
                [
                    'parameterType' => [
                        'type' => 'STRING'
                    ],
                    'parameterValue' => [
                        'value' => $string
                    ]
                ]
            ],
            [
                $bool,
                [
                    'parameterType' => [
                        'type' => 'BOOL'
                    ],
                    'parameterValue' => [
                        'value' => $bool
                    ]
                ]
            ],
            [
                $int,
                [
                    'parameterType' => [
                        'type' => 'INT64'
                    ],
                    'parameterValue' => [
                        'value' => $int
                    ]
                ]
            ],
            [
                $float,
                [
                    'parameterType' => [
                        'type' => 'FLOAT64'
                    ],
                    'parameterValue' => [
                        'value' => $float
                    ]
                ]
            ],
            [
                $resource,
                [
                    'parameterType' => [
                        'type' => 'BYTES'
                    ],
                    'parameterValue' => [
                        'value' => base64_encode(stream_get_contents($resource))
                    ]
                ]
            ],
            [
                $date,
                [
                    'parameterType' => [
                        'type' => 'DATE'
                    ],
                    'parameterValue' => [
                        'value' => $dt->format('Y-m-d')
                    ]
                ]
            ],
            [
                $dt,
                [
                    'parameterType' => [
                        'type' => 'DATETIME'
                    ],
                    'parameterValue' => [
                        'value' => $dt->format('Y-m-d H:i:s.u')
                    ]
                ]
            ],
            [
                $array,
                [
                    'parameterType' => [
                        'type' => 'ARRAY',
                        'arrayType' => [
                            'type' => 'INT64'
                        ]
                    ],
                    'parameterValue' => [
                        'arrayValues' => [
                            ['value' => $array[0]],
                            ['value' => $array[1]],
                            ['value' => $array[2]]
                        ]
                    ]
                ]
            ],
            [
                $struct,
                [
                    'parameterType' => [
                        'type' => 'STRUCT',
                        'structTypes' => [
                            [
                                'name' => 'key1',
                                'type' => [
                                    'type' => 'INT64'
                                ]
                            ],
                            [
                                'name' => 'key2',
                                'type' => [
                                    'type' => 'STRING'
                                ]
                            ]
                        ]
                    ],
                    'parameterValue' => [
                        'structValues' => [
                            'key1' => ['value' => $struct['key1']],
                            'key2' => ['value' => $struct['key2']],
                        ]
                    ]
                ]
            ]
        ];
    }
}

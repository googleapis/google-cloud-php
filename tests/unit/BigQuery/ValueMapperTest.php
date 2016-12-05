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

namespace Google\Cloud\Tests\BigQuery;

use Google\Cloud\BigQuery\Date;
use Google\Cloud\BigQuery\ValueMapper;

/**
 * @group bigquery
 */
class ValueMapperTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testThrowsExceptionWithUnhandledClass()
    {
        $mapper = new ValueMapper();
        $mapper->toParameter(new \stdClass());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testThrowsExceptionWithUnhandledType()
    {
        $f = fopen('php://temp','r');
        fclose($f);
        $mapper = new ValueMapper();
        $mapper->toParameter($f);
    }

    /**
     * @dataProvider valueProvider
     */
    public function testMapsToParameter($value, $expected)
    {
        if (is_resource($value)) {
            rewind($value);
        }
        $mapper = new ValueMapper();
        $actual = $mapper->toParameter($value);

        $this->assertEquals($expected, $actual);
    }

    public function valueProvider()
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

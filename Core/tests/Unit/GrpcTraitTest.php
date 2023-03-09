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

namespace Google\Cloud\Core\Tests\Unit;

use Google\ApiCore\CredentialsWrapper;
use Google\Auth\FetchAuthTokenInterface;
use Google\Cloud\Core\Duration;
use Google\Cloud\Core\Exception\NotFoundException;
use Google\Cloud\Core\GrpcRequestWrapper;
use Google\Cloud\Core\GrpcTrait;
use Google\Cloud\Core\Testing\GrpcTestTrait;
use Google\Cloud\Core\Testing\TestHelpers;
use Yoast\PHPUnitPolyfills\TestCases\TestCase;
use Yoast\PHPUnitPolyfills\Polyfills\AssertStringContains;
use Prophecy\Argument;

/**
 * @group core
 */
class GrpcTraitTest extends TestCase
{
    use AssertStringContains;
    use GrpcTestTrait;

    private $implementation;
    private $requestWrapper;

    public function set_up()
    {
        $this->checkAndSkipGrpcTests();

        $this->implementation = TestHelpers::impl(GrpcTrait::class);
        $this->requestWrapper = $this->prophesize(GrpcRequestWrapper::class);
    }

    public function testSetGetRequestWrapper()
    {
        $this->implementation->setRequestWrapper($this->requestWrapper->reveal());
        $this->assertInstanceOf(GrpcRequestWrapper::class, $this->implementation->requestWrapper());
    }

    public function testSendsRequest()
    {
        $grpcOptions = [
            'timeoutMs' => 100
        ];
        $message = ['successful' => 'message'];
        $this->requestWrapper->send(
            Argument::type('callable'),
            Argument::type('array'),
            ['grpcOptions' => $grpcOptions]
        )->willReturn($message);

        $this->implementation->setRequestWrapper($this->requestWrapper->reveal());
        $actualResponse = $this->implementation->send(function () {
            return true;
        }, [['grpcOptions' => $grpcOptions]]);

        $this->assertEquals($message, $actualResponse);
    }

    public function testSendsRequestWithOptions()
    {
        $options = [
            'requestTimeout' => 3.5,
            'grpcOptions' => ['timeoutMs' => 100],
            'retries' => 0
        ];
        $message = ['successful' => 'message'];
        $this->requestWrapper->send(
            Argument::type('callable'),
            Argument::type('array'),
            $options
        )->willReturn($message);

        $this->implementation->setRequestWrapper($this->requestWrapper->reveal());
        $actualResponse = $this->implementation->send(function () {
            return true;
        }, [$options]);

        $this->assertEquals($message, $actualResponse);
    }

    public function testSendsRequestWithRetryFunction()
    {
        $timesCalled = 0;
        $options = [
            'retries' => 1,
            'grpcRetryFunction' => function (\Exception $ex) {
                return $ex->getMessage() === 'test retry';
            }
        ];
        $requestWrapper = new GrpcRequestWrapper();
        $this->implementation->setRequestWrapper($requestWrapper);
        $actualResponse = $this->implementation->send(
            function () use (&$timesCalled) {
                if (2 === ++$timesCalled) {
                    // succeed on second try
                    return;
                }
                throw new NotFoundException('test retry');
            },
            [$options]
        );

        $this->assertEquals(2, $timesCalled);
    }

    public function testSendsRequestNotFoundWhitelisted()
    {
        $grpcOptions = [
            'timeoutMs' => 100
        ];
        $this->requestWrapper->send(
            Argument::type('callable'),
            Argument::type('array'),
            ['grpcOptions' => $grpcOptions]
        )->willThrow(new NotFoundException('uh oh'));

        $this->implementation->setRequestWrapper($this->requestWrapper->reveal());

        $msg = null;
        try {
            $this->implementation->send($this->noop(), [['grpcOptions' => $grpcOptions]], true);
        } catch (NotFoundException $e) {
            $msg = $e->getMessage();
        }

        $this->assertStringContainsString('NOTE: Error may be due to Whitelist Restriction.', $msg);
    }

    public function testSendsRequestNotFoundNotWhitelisted()
    {
        $grpcOptions = [
            'timeoutMs' => 100
        ];
        $this->requestWrapper->send(
            Argument::type('callable'),
            Argument::type('array'),
            ['grpcOptions' => $grpcOptions]
        )->willThrow(new NotFoundException('uh oh'));

        $this->implementation->setRequestWrapper($this->requestWrapper->reveal());

        $msg = null;
        try {
            $this->implementation->send($this->noop(), [['grpcOptions' => $grpcOptions]], false);
        } catch (NotFoundException $e) {
            $msg = $e->getMessage();
        }

        $this->assertStringNotContainsString('NOTE: Error may be due to Whitelist Restriction.', $msg);
    }

    public function testGetsGaxConfig()
    {
        $version = '1.0.0';

        $fetcher = $this->prophesize(FetchAuthTokenInterface::class)->reveal();
        $this->requestWrapper->getCredentialsFetcher()->willReturn($fetcher);
        $this->implementation->setRequestWrapper($this->requestWrapper->reveal());
        $expected = [
            'libName' => 'gccl',
            'libVersion' => $version,
            'transport' => 'grpc',
            'credentials' => new CredentialsWrapper($fetcher, function () {
                return true;
            })
        ];

        $this->assertEquals(
            $expected,
            $this->implementation->call(
                'getGaxConfig',
                [
                    $version,
                    function () {
                        return true;
                    }
                ]
            )
        );
    }

    public function testFormatsTimestamp()
    {
        $timestamp = [
            'seconds' => '1471242909',
            'nanos' => '1'
        ];

        $this->assertEquals(
            '2016-08-15T06:35:09.000000001Z',
            $this->implementation->call('formatTimestampFromApi', [$timestamp])
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

        $this->assertEquals($expected, $this->implementation->call('formatStructForApi', [$struct]));
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

        $this->assertEquals($expected, $this->implementation->call('formatListForApi', [$list]));
    }

    /**
     * @dataProvider timestampProvider
     */
    public function testFormatTimestampForApi($timestamp, $expectedSeconds, $expectedNanos)
    {
        $result = $this->implementation->call(
            'formatTimestampForApi',
            [$timestamp]
        );

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
        $this->assertEquals($expected, $this->implementation->call('formatDurationForApi', [$value]));
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
        $this->assertEquals($expected, $this->implementation->call('formatValueForApi', [$value]));
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
        $this->assertEquals($expected, $this->implementation->call('unpackValue', [$value]));
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

    private function noop()
    {
        return function () {
            return;
        };
    }
}

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

namespace Google\Cloud\Tests\Unit\Core;

use Google\Auth\Cache\MemoryCacheItemPool;
use Google\Auth\FetchAuthTokenCache;
use Google\Auth\FetchAuthTokenInterface;
use Google\Cloud\Core\GrpcRequestWrapper;
use Google\Cloud\Core\GrpcTrait;
use Prophecy\Argument;

/**
 * @group core
 */
class GrpcTraitTest extends \PHPUnit_Framework_TestCase
{
    private $implementation;
    private $requestWrapper;

    public function setUp()
    {
        if (!extension_loaded('grpc')) {
            $this->markTestSkipped('Must have the grpc extension installed to run this test.');
        }

        $this->implementation = new GrpcTraitStub();
        $this->requestWrapper = $this->prophesize(GrpcRequestWrapper::class);
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

    public function testGetsGaxConfig()
    {
        $version = '1.0.0';

        $fetcher = $this->prophesize(FetchAuthTokenInterface::class)->reveal();
        $this->requestWrapper->getCredentialsFetcher()->willReturn($fetcher);
        $this->implementation->setRequestWrapper($this->requestWrapper->reveal());
        $expected = [
            'credentialsLoader' => $fetcher,
            'enableCaching' => false,
            'libName' => 'gccl',
            'libVersion' => $version
        ];

        $this->assertEquals($expected, $this->implementation->call('getGaxConfig', [$version]));
    }

    public function testFormatsTimestamp()
    {
        $timestamp = [
            'seconds' => '1471242909',
            'nanos' => '1'
        ];

        $this->assertEquals('2016-08-15T06:35:09.1Z', $this->implementation->call('formatTimestampFromApi', [$timestamp]));
    }

    public function testFormatsLabels()
    {
        $labels = ['test' => 'label'];
        $expected = [
            [
                'key' => key($labels),
                'value' => current($labels)
            ]
        ];

        $this->assertEquals($expected, $this->implementation->call('formatLabelsForApi', [$labels]));
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
                [
                    'key' => $value,
                    'value' => [
                        'struct_value' => [
                            'fields' => [
                                [
                                    'key' => $value,
                                    'value' => [
                                        'string_value' => $value
                                    ]
                                ]
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
     * @dataProvider valueProvider
     */
    public function testFormatsValue($value, $expected)
    {
        $this->assertEquals($expected, $this->implementation->call('formatValueForApi', [$value]));
    }

    public function valueProvider()
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
                            [
                                'key' => 'test',
                                'value' => [
                                    'string_value' => 'test'
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];
    }
}

class GrpcTraitStub
{
    use GrpcTrait;

    public function call($fn, array $args = [])
    {
        return call_user_func_array([$this, $fn], $args);
    }
}

<?php
/*
 * Copyright 2018 Google LLC
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are
 * met:
 *
 *     * Redistributions of source code must retain the above copyright
 * notice, this list of conditions and the following disclaimer.
 *     * Redistributions in binary form must reproduce the above
 * copyright notice, this list of conditions and the following disclaimer
 * in the documentation and/or other materials provided with the
 * distribution.
 *     * Neither the name of Google Inc. nor the names of its
 * contributors may be used to endorse or promote products derived from
 * this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 */

namespace Google\ApiCore\Tests\Unit;

use GapicClientStub;
use Google\ApiCore\AgentHeader;
use Google\ApiCore\BidiStream;
use Google\ApiCore\Call;
use Google\ApiCore\ClientStream;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\GapicClientTrait;
use Google\ApiCore\LongRunning\OperationsClient;
use Google\ApiCore\OperationResponse;
use Google\ApiCore\RequestParamsHeaderDescriptor;
use Google\ApiCore\RetrySettings;
use Google\ApiCore\ServerStream;
use Google\ApiCore\Testing\MockRequest;
use Google\ApiCore\Testing\MockRequestBody;
use Google\ApiCore\Testing\MockResponse;
use Google\ApiCore\Transport\GrpcFallbackTransport;
use Google\ApiCore\Transport\GrpcTransport;
use Google\ApiCore\Transport\RestTransport;
use Google\ApiCore\Transport\TransportInterface;
use Google\ApiCore\ValidationException;
use Google\Auth\CredentialsLoader;
use Google\Auth\FetchAuthTokenInterface;
use Google\LongRunning\Operation;
use Grpc\Gcp\ApiConfig;
use Grpc\Gcp\Config;
use GuzzleHttp\Promise\FulfilledPromise;
use InvalidArgumentException;
use Prophecy\Argument;
use Yoast\PHPUnitPolyfills\TestCases\TestCase;

class GapicClientTraitTest extends TestCase
{
    use TestTrait;

    public function tear_down()
    {
        // Reset the static gapicVersion field between tests
        $client = new GapicClientTraitStub();
        $client->set('gapicVersionFromFile', null, true);
    }

    public function testHeadersOverwriteBehavior()
    {
        $unaryDescriptors = [
            'callType' => Call::UNARY_CALL,
            'responseType' => 'decodeType',
            'headerParams' => [
                [
                    'fieldAccessors' => ['getName'],
                    'keyName' => 'name'
                ]
            ]
        ];
        $request = new MockRequestBody(['name' => 'foos/123/bars/456']);
        $header = AgentHeader::buildAgentHeader([
            'libName' => 'gccl',
            'libVersion' => '0.0.0',
            'gapicVersion' => '0.9.0',
            'apiCoreVersion' => '1.0.0',
            'phpVersion' => '5.5.0',
            'grpcVersion' => '1.0.1',
            'protobufVersion' => '6.6.6',
        ]);
        $headers = [
            'x-goog-api-client' => ['this-should-not-be-used'],
            'new-header' => ['this-should-be-used']
        ];
        $expectedHeaders = [
            'x-goog-api-client' => ['gl-php/5.5.0 gccl/0.0.0 gapic/0.9.0 gax/1.0.0 grpc/1.0.1 rest/1.0.0 pb/6.6.6'],
            'new-header' => ['this-should-be-used'],
            'x-goog-request-params' => ['name=foos%2F123%2Fbars%2F456']
        ];
        $transport = $this->getMockBuilder(TransportInterface::class)->disableOriginalConstructor()->getMock();
        $credentialsWrapper = CredentialsWrapper::build([
            'keyFile' => __DIR__ . '/testdata/json-key-file.json'
        ]);
        $transport->expects($this->once())
            ->method('startUnaryCall')
            ->with(
                $this->isInstanceOf(Call::class),
                $this->equalTo([
                    'headers' => $expectedHeaders,
                    'credentialsWrapper' => $credentialsWrapper,
                ])
            );
        $client = new GapicClientTraitStub();
        $client->set('agentHeader', $header);
        $client->set('retrySettings', [
            'method' => $this->getMockBuilder(RetrySettings::class)
                ->disableOriginalConstructor()
                ->getMock()
            ]
        );
        $client->set('transport', $transport);
        $client->set('credentialsWrapper', $credentialsWrapper);
        $client->set('descriptors', ['method' => $unaryDescriptors]);
        $client->call('startApiCall', [
            'method',
            $request,
            ['headers' => $headers]
        ]);
    }

    public function testConfigureCallConstructionOptionsAcceptsRetryObjectOrArray()
    {
        $defaultRetrySettings = RetrySettings::constructDefault();
        $client = new GapicClientTraitStub();
        $client->set('retrySettings', ['method' => $defaultRetrySettings]);
        $expectedOptions = [
            'retrySettings' => $defaultRetrySettings
                ->with(['rpcTimeoutMultiplier' => 5])
        ];
        $actualOptionsWithObject = $client->call(
            'configureCallConstructionOptions',
            [
                'method',
                [
                    'retrySettings' => $defaultRetrySettings
                        ->with(['rpcTimeoutMultiplier' => 5])
                ]
            ]
        );
        $actualOptionsWithArray = $client->call(
            'configureCallConstructionOptions',
            [
                'method',
                [
                    'retrySettings' => ['rpcTimeoutMultiplier' => 5]
                ]
            ]
        );

        $this->assertEquals($expectedOptions, $actualOptionsWithObject);
        $this->assertEquals($expectedOptions, $actualOptionsWithArray);
    }

    public function testStartOperationsCall()
    {
        $header = AgentHeader::buildAgentHeader([]);
        $retrySettings = $this->getMockBuilder(RetrySettings::class)
            ->disableOriginalConstructor()
            ->getMock();

        $longRunningDescriptors = [
            'longRunning' => [
                'operationReturnType' => 'operationType',
                'metadataReturnType' => 'metadataType',
                'initialPollDelayMillis' => 100,
                'pollDelayMultiplier' => 1.0,
                'maxPollDelayMillis' => 200,
                'totalPollTimeoutMillis' => 300,
            ]
        ];
        $expectedPromise = new FulfilledPromise(new Operation());
        $transport = $this->getMockBuilder(TransportInterface::class)->getMock();
        $transport->expects($this->once())
             ->method('startUnaryCall')
             ->will($this->returnValue($expectedPromise));
        $credentialsWrapper = CredentialsWrapper::build([]);
        $client = new GapicClientTraitStub();
        $client->set('transport', $transport);
        $client->set('credentialsWrapper', $credentialsWrapper);
        $client->set('agentHeader', $header);
        $client->set('retrySettings', ['method' => $retrySettings]);
        $client->set('descriptors', ['method' => $longRunningDescriptors]);
        $message = new MockRequest();
        $operationsClient = $this->getMockBuilder(OperationsClient::class)
            ->disableOriginalConstructor()
            ->setMethodsExcept(['validate'])
            ->getMock();

        $response = $client->call('startOperationsCall', [
            'method',
            [],
            $message,
            $operationsClient
        ])->wait();

        $expectedResponse = new OperationResponse(
            '',
            $operationsClient,
            $longRunningDescriptors['longRunning'] + ['lastProtoResponse' => new Operation()]
        );

        $this->assertEquals($expectedResponse, $response);
    }

    public function testStartApiCallOperation()
    {
        $header = AgentHeader::buildAgentHeader([]);
        $retrySettings = $this->getMockBuilder(RetrySettings::class)
            ->disableOriginalConstructor()
            ->getMock();

        $longRunningDescriptors = [
            'callType' => Call::LONGRUNNING_CALL,
            'longRunning' => [
                'operationReturnType' => 'operationType',
                'metadataReturnType' => 'metadataType',
                'initialPollDelayMillis' => 100,
                'pollDelayMultiplier' => 1.0,
                'maxPollDelayMillis' => 200,
                'totalPollTimeoutMillis' => 300,
            ]
        ];
        $expectedPromise = new FulfilledPromise(new Operation());
        $transport = $this->getMockBuilder(TransportInterface::class)->getMock();
        $transport->expects($this->once())
             ->method('startUnaryCall')
             ->will($this->returnValue($expectedPromise));
        $credentialsWrapper = CredentialsWrapper::build([]);
        $client = new GapicClientTraitOperationsStub();
        $client->set('transport', $transport);
        $client->set('credentialsWrapper', $credentialsWrapper);
        $client->set('agentHeader', $header);
        $client->set('retrySettings', ['method' => $retrySettings]);
        $client->set('descriptors', ['method' => $longRunningDescriptors]);
        $operationsClient = $this->getMockBuilder(OperationsClient::class)
            ->disableOriginalConstructor()
            ->setMethodsExcept(['validate'])
            ->getMock();
        $client->set('operationsClient', $operationsClient);

        $request = new MockRequest();
        $response = $client->call('startApiCall', [
            'method',
            $request
        ])->wait();

        $expectedResponse = new OperationResponse(
            '',
            $operationsClient,
            $longRunningDescriptors['longRunning'] + ['lastProtoResponse' => new Operation()]
        );

        $this->assertEquals($expectedResponse, $response);
    }

    public function testStartApiCallCustomOperation()
    {
        $header = AgentHeader::buildAgentHeader([]);
        $retrySettings = $this->getMockBuilder(RetrySettings::class)
            ->disableOriginalConstructor()
            ->getMock();

        $longRunningDescriptors = [
            'callType' => Call::LONGRUNNING_CALL,
            'responseType' => 'Google\ApiCore\Testing\MockResponse',
            'longRunning' => [
                'operationReturnType' => 'operationType',
                'metadataReturnType' => 'metadataType',
                'initialPollDelayMillis' => 100,
                'pollDelayMultiplier' => 1.0,
                'maxPollDelayMillis' => 200,
                'totalPollTimeoutMillis' => 300,
            ]
        ];
        $expectedPromise = new FulfilledPromise(new MockResponse());
        $transport = $this->getMockBuilder(TransportInterface::class)->getMock();
        $transport->expects($this->once())
             ->method('startUnaryCall')
             ->will($this->returnValue($expectedPromise));
        $credentialsWrapper = CredentialsWrapper::build([]);
        $client = new GapicClientTraitOperationsStub();
        $client->set('transport', $transport);
        $client->set('credentialsWrapper', $credentialsWrapper);
        $client->set('agentHeader', $header);
        $client->set('retrySettings', ['method' => $retrySettings]);
        $client->set('descriptors', ['method' => $longRunningDescriptors]);
        $operationsClient = $this->getMockBuilder(OperationsClient::class)
            ->disableOriginalConstructor()
            ->setMethodsExcept(['validate'])
            ->getMock();
        $client->set('operationsClient', $operationsClient);

        $request = new MockRequest();
        $response = $client->call('startApiCall', [
            'method',
            $request,
        ])->wait();

        $expectedResponse = new OperationResponse(
            '',
            $operationsClient,
            $longRunningDescriptors['longRunning'] + ['lastProtoResponse' => new MockResponse()]
        );

        $this->assertEquals($expectedResponse, $response);
    }

    /**
     * @dataProvider startApiCallExceptions
     */
    public function testStartApiCallException($descriptor, $expected)
    {
        $client = new GapicClientTraitStub();
        $client->set('descriptors', $descriptor);

        // All descriptor config checks throw Validation exceptions
        $this->expectException(ValidationException::class);
        // Check that the proper exception is being thrown for the given descriptor.
        $this->expectExceptionMessage($expected);

        $client->call('startApiCall', [
            'method',
            new MockRequest()
        ])->wait();
    }

    public function startApiCallExceptions()
    {
        return [
            [
                [],
                'does not exist'
            ],
            [
                [
                    'method' => []
                ],
                'does not have a callType' 
            ],
            [
                [
                    'method' => ['callType' => Call::LONGRUNNING_CALL]
                ],
                'does not have a longRunning config' 
            ],
            [
                [
                    'method' => ['callType' => Call::LONGRUNNING_CALL, 'longRunning' => []]
                ],
                'missing required getOperationsClient'
            ],
            [
                [
                    'method'=> ['callType' => Call::UNARY_CALL]
                ],
                'does not have a responseType'
            ],
            [
                [
                    'method'=> ['callType' => Call::PAGINATED_CALL, 'responseType' => 'foo']
                ],
                'does not have a pageStreaming'
            ],
        ];
    }

    public function testStartApiCallUnary()
    {
        $header = AgentHeader::buildAgentHeader([]);
        $retrySettings = $this->getMockBuilder(RetrySettings::class)
            ->disableOriginalConstructor()
            ->getMock();
        $unaryDescriptors = [
            'callType' => Call::UNARY_CALL,
            'responseType' => 'Google\Longrunning\Operation',
            'interfaceOverride' => 'google.cloud.foo.v1.Foo'
        ];
        $expectedPromise = new FulfilledPromise(new Operation());
        $transport = $this->getMockBuilder(TransportInterface::class)->getMock();
        $transport->expects($this->once())
             ->method('startUnaryCall')
             ->with(
                $this->callback(function($call) use ($unaryDescriptors) {
                    return strpos($call->getMethod(), $unaryDescriptors['interfaceOverride']) !== false;
                }),
                $this->anything()
            )
             ->will($this->returnValue($expectedPromise));
        $credentialsWrapper = CredentialsWrapper::build([]);
        $client = new GapicClientTraitStub();
        $client->set('transport', $transport);
        $client->set('credentialsWrapper', $credentialsWrapper);
        $client->set('agentHeader', $header);
        $client->set('retrySettings', ['method' => $retrySettings]);
        $client->set('descriptors', ['method' => $unaryDescriptors]);

        $request = new MockRequest();
        $client->call('startApiCall', [
            'method',
            $request
        ])->wait();
    }

    public function testStartApiCallPaged()
    {
        $header = AgentHeader::buildAgentHeader([]);
        $retrySettings = $this->getMockBuilder(RetrySettings::class)
            ->disableOriginalConstructor()
            ->getMock();
        $pagedDescriptors = [
            'callType' => Call::PAGINATED_CALL,
            'responseType' => 'Google\Longrunning\ListOperationsResponse',
            'pageStreaming' => [
                'requestPageTokenGetMethod' => 'getPageToken',
                'requestPageTokenSetMethod' => 'setPageToken',
                'requestPageSizeGetMethod' => 'getPageSize',
                'requestPageSizeSetMethod' => 'setPageSize',
                'responsePageTokenGetMethod' => 'getNextPageToken',
                'resourcesGetMethod' => 'getOperations',
            ],
        ];
        $expectedPromise = new FulfilledPromise(new Operation());
        $transport = $this->getMockBuilder(TransportInterface::class)->getMock();
        $transport->expects($this->once())
             ->method('startUnaryCall')
             ->will($this->returnValue($expectedPromise));
        $credentialsWrapper = CredentialsWrapper::build([]);
        $client = new GapicClientTraitStub();
        $client->set('transport', $transport);
        $client->set('credentialsWrapper', $credentialsWrapper);
        $client->set('agentHeader', $header);
        $client->set('retrySettings', ['method' => $retrySettings]);
        $client->set('descriptors', ['method' => $pagedDescriptors]);

        $request = new MockRequest();
        $client->call('startApiCall', [
            'method',
            $request
        ]);
    }

    public function testStartAsyncCall()
    {
        $header = AgentHeader::buildAgentHeader([]);
        $retrySettings = $this->getMockBuilder(RetrySettings::class)
            ->disableOriginalConstructor()
            ->getMock();
        $unaryDescriptors = [
            'callType' => Call::UNARY_CALL,
            'responseType' => 'Google\Longrunning\Operation'
        ];
        $expectedPromise = new FulfilledPromise(new Operation());
        $transport = $this->getMockBuilder(TransportInterface::class)->getMock();
        $transport->expects($this->once())
             ->method('startUnaryCall')
             ->will($this->returnValue($expectedPromise));
        $credentialsWrapper = CredentialsWrapper::build([]);
        $client = new GapicClientTraitStub();
        $client->set('transport', $transport);
        $client->set('credentialsWrapper', $credentialsWrapper);
        $client->set('agentHeader', $header);
        $client->set('retrySettings', ['Method' => $retrySettings]);
        $client->set('descriptors', ['Method' => $unaryDescriptors]);

        $request = new MockRequest();
        $client->call('startAsyncCall', [
            'method',
            $request
        ])->wait();
    }

    public function testStartAsyncCallPaged()
    {
        $header = AgentHeader::buildAgentHeader([]);
        $retrySettings = $this->getMockBuilder(RetrySettings::class)
            ->disableOriginalConstructor()
            ->getMock();
        $pagedDescriptors = [
            'callType' => Call::PAGINATED_CALL,
            'responseType' => 'Google\Longrunning\ListOperationsResponse',
            'interfaceOverride' => 'google.cloud.foo.v1.Foo',
            'pageStreaming' => [
                'requestPageTokenGetMethod' => 'getPageToken',
                'requestPageTokenSetMethod' => 'setPageToken',
                'requestPageSizeGetMethod' => 'getPageSize',
                'requestPageSizeSetMethod' => 'setPageSize',
                'responsePageTokenGetMethod' => 'getNextPageToken',
                'resourcesGetMethod' => 'getOperations',
            ],
        ];
        $expectedPromise = new FulfilledPromise(new Operation());
        $transport = $this->getMockBuilder(TransportInterface::class)->getMock();
        $transport->expects($this->once())
             ->method('startUnaryCall')
             ->with(
                $this->callback(function($call) use ($pagedDescriptors) {
                    return strpos($call->getMethod(), $pagedDescriptors['interfaceOverride']) !== false;
                }),
                $this->anything()
            )
             ->will($this->returnValue($expectedPromise));
        $credentialsWrapper = CredentialsWrapper::build([]);
        $client = new GapicClientTraitStub();
        $client->set('transport', $transport);
        $client->set('credentialsWrapper', $credentialsWrapper);
        $client->set('agentHeader', $header);
        $client->set('retrySettings', ['Method' => $retrySettings]);
        $client->set('descriptors', ['Method' => $pagedDescriptors]);

        $request = new MockRequest();
        $client->call('startAsyncCall', [
            'method',
            $request
        ])->wait();
    }

    /**
     * @dataProvider startAsyncCallExceptions
     */
    public function testStartAsyncCallException($descriptor, $expected)
    {
        $client = new GapicClientTraitStub();
        $client->set('descriptors', $descriptor);

        // All descriptor config checks throw Validation exceptions
        $this->expectException(ValidationException::class);
        // Check that the proper exception is being thrown for the given descriptor.
        $this->expectExceptionMessage($expected);

        $client->call('startAsyncCall', [
            'method',
            new MockRequest()
        ])->wait();
    }

    public function startAsyncCallExceptions()
    {
        return [
            [
                [],
                'does not exist'
            ],
            [
                [
                    'Method' => []
                ],
                'does not have a callType' 
            ],
            [
                [
                    'Method' => [
                        'callType' => Call::SERVER_STREAMING_CALL,
                        'responseType' => 'Google\Longrunning\Operation'
                    ]
                ],
                'not supported for async execution'
            ],
            [
                [
                    'Method' => [
                        'callType' => Call::CLIENT_STREAMING_CALL, 'longRunning' => [],
                        'responseType' => 'Google\Longrunning\Operation'
                    ]
                ],
                'not supported for async execution'
            ],
            [
                [
                    'Method'=> [
                        'callType' => Call::BIDI_STREAMING_CALL,
                        'responseType' => 'Google\Longrunning\Operation'
                    ]
                ],
                'not supported for async execution'
            ],
        ];
    }

    public function testGetGapicVersionWithVersionFile()
    {
        require_once __DIR__ . '/testdata/src/GapicClientStub.php';
        $version = '1.2.3-dev';
        $client = new \GapicClientStub();
        $this->assertEquals($version, $client->call('getGapicVersion', [[]]));
    }

    public function testGetGapicVersionWithNoAvailableVersion()
    {
        $client = new GapicClientTraitStub();
        $this->assertSame('', $client->call('getGapicVersion', [[]]));
    }

    public function testGetGapicVersionWithLibVersion()
    {
        $version = '1.2.3-dev';
        $client = new GapicClientTraitStub();
        $client->set('gapicVersionFromFile', $version, true);
        $options = ['libVersion' => $version];
        $this->assertEquals($version, $client->call('getGapicVersion', [
            $options
        ]));
    }

    /**
     * @dataProvider createCredentialsWrapperData
     */
    public function testCreateCredentialsWrapper($auth, $authConfig, $expectedCredentialsWrapper)
    {
        $client = new GapicClientTraitStub();
        $actualCredentialsWrapper = $client->call('createCredentialsWrapper', [
            $auth,
            $authConfig,
        ]);

        $this->assertEquals($expectedCredentialsWrapper, $actualCredentialsWrapper);
    }

    public function createCredentialsWrapperData()
    {
        $keyFilePath = __DIR__ . '/testdata/json-key-file.json';
        $keyFile = json_decode(file_get_contents($keyFilePath), true);
        $fetcher = $this->prophesize(FetchAuthTokenInterface::class)->reveal();
        $credentialsWrapper = new CredentialsWrapper($fetcher);
        return [
            [null, [], CredentialsWrapper::build()],
            [$keyFilePath, [], CredentialsWrapper::build(['keyFile' => $keyFile])],
            [$keyFile, [], CredentialsWrapper::build(['keyFile' => $keyFile])],
            [$fetcher, [], new CredentialsWrapper($fetcher)],
            [$credentialsWrapper, [], $credentialsWrapper],
        ];
    }

    /**
     * @dataProvider createCredentialsWrapperValidationExceptionData
     */
    public function testCreateCredentialsWrapperValidationException($auth, $authConfig)
    {
        $client = new GapicClientTraitStub();

        $this->expectException(ValidationException::class);

        $client->call('createCredentialsWrapper', [
            $auth,
            $authConfig,
        ]);
    }

    public function createCredentialsWrapperValidationExceptionData()
    {
        return [
            ['not a json string', []],
            [new \stdClass(), []],
        ];
    }

    /**
     * @dataProvider createCredentialsWrapperInvalidArgumentExceptionData
     */
    public function testCreateCredentialsWrapperInvalidArgumentException($auth, $authConfig)
    {
        $client = new GapicClientTraitStub();

        $this->expectException(InvalidArgumentException::class);

        $client->call('createCredentialsWrapper', [
            $auth,
            $authConfig,
        ]);
    }

    public function createCredentialsWrapperInvalidArgumentExceptionData()
    {
        return [
            [['array' => 'without right keys'], []],
        ];
    }

    /**
     * @dataProvider createTransportData
     */
    public function testCreateTransport($apiEndpoint, $transport, $transportConfig, $expectedTransportClass)
    {
        if ($expectedTransportClass == GrpcTransport::class) {
            $this->requiresGrpcExtension();
        }
        $client = new GapicClientTraitStub();
        $transport = $client->call('createTransport', [
            $apiEndpoint,
            $transport,
            $transportConfig
        ]);

        $this->assertEquals($expectedTransportClass, get_class($transport));
    }

    public function createTransportData()
    {
        $defaultTransportClass = extension_loaded('grpc')
            ? GrpcTransport::class
            : RestTransport::class;
        $apiEndpoint = 'address:443';
        $transport = extension_loaded('grpc')
            ? 'grpc'
            : 'rest';
        $transportConfig = [
            'rest' => [
                'restClientConfigPath' => __DIR__ . '/testdata/test_service_rest_client_config.php',
            ],
        ];
        return [
            [$apiEndpoint, $transport, $transportConfig, $defaultTransportClass],
            [$apiEndpoint, 'grpc', $transportConfig, GrpcTransport::class],
            [$apiEndpoint, 'rest', $transportConfig, RestTransport::class],
            [$apiEndpoint, 'grpc-fallback', $transportConfig, GrpcFallbackTransport::class],
        ];
    }

    /**
     * @dataProvider createTransportDataInvalid
     */
    public function testCreateTransportInvalid($apiEndpoint, $transport, $transportConfig)
    {
        $client = new GapicClientTraitStub();

        $this->expectException(ValidationException::class);

        $client->call('createTransport', [
            $apiEndpoint,
            $transport,
            $transportConfig
        ]);
    }

    public function createTransportDataInvalid()
    {
        $apiEndpoint = 'address:443';
        $transportConfig = [
            'rest' => [
                'restConfigPath' => __DIR__ . '/testdata/test_service_rest_client_config.php',
            ],
        ];
        return [
            [$apiEndpoint, null, $transportConfig],
            [$apiEndpoint, ['transport' => 'weirdstring'], $transportConfig],
            [$apiEndpoint, ['transport' => new \stdClass()], $transportConfig],
            [$apiEndpoint, ['transport' => 'rest'], []],
        ];
    }

    public function testServiceAddressAlias()
    {
        $client = new GapicClientTraitStub();
        $apiEndpoint = 'test.address.com:443';
        $updatedOptions = $client->call('buildClientOptions', [
            ['serviceAddress' => $apiEndpoint]
        ]);
        $client->call('setClientOptions', [$updatedOptions]);

        $this->assertEquals($apiEndpoint, $updatedOptions['apiEndpoint']);
        $this->assertArrayNotHasKey('serviceAddress', $updatedOptions);
    }

    public function testOperationClientClassOption()
    {
        $options = ['operationsClientClass' => CustomOperationsClient::class];
        $client = new GapicClientTraitStub();
        $operationsClient = $client->call('createOperationsClient', [$options]);
        $this->assertInstanceOf(CustomOperationsClient::class, $operationsClient);
    }

    public function testAdditionalArgumentMethods()
    {
        $client = new GapicClientTraitStub();

        // Set the LRO descriptors we are testing.
        $longRunningDescriptors = [
            'longRunning' => [
                'additionalArgumentMethods' => [
                    'getPageToken',
                    'getPageSize',
                ]
            ]
        ];
        $client->set('descriptors', ['method.name' => $longRunningDescriptors]);

        // Set our mock transport.
        $expectedOperation = new Operation(['name' => 'test-123']);
        $transport = $this->prophesize(TransportInterface::class);
        $transport->startUnaryCall(Argument::any(), Argument::any())
             ->shouldBeCalledOnce()
             ->willReturn(new FulfilledPromise($expectedOperation));
        $client->set('transport', $transport->reveal());

        // Set up things for the mock call to work.
        $client->set('credentialsWrapper', CredentialsWrapper::build([]));
        $client->set('agentHeader', []);
        $retrySettings = $this->prophesize(RetrySettings::class);
        $client->set('retrySettings', [
            'method.name' => RetrySettings::constructDefault()
        ]);

        // Create the mock request object which will have additional argument
        // methods called on it.
        $request = new MockRequest([
            'page_token' => 'abc',
            'page_size'  => 100,
        ]);

        // Create mock operations client to test the additional arguments from
        // the request object are used.
        $operationsClient = $this->prophesize(CustomOperationsClient::class);
        $operationsClient->getOperation('test-123', 'abc', 100)
            ->shouldBeCalledOnce();

        $operationResponse = $client->call('startOperationsCall', [
            'method.name',
            [],
            $request,
            $operationsClient->reveal()
        ])->wait();

        // This will invoke $operationsClient->getOperation with values from
        // the additional argument methods.
        $operationResponse->reload();
    }

    /**
     * @dataProvider setClientOptionsData
     */
    public function testSetClientOptions($options, $expectedProperties)
    {
        $client = new GapicClientTraitStub();
        $updatedOptions = $client->call('buildClientOptions', [$options]);
        $client->call('setClientOptions', [$updatedOptions]);
        foreach ($expectedProperties as $propertyName => $expectedValue) {
            $actualValue = $client->get($propertyName);
            $this->assertEquals($expectedValue, $actualValue);
        }
    }

    public function setClientOptionsData()
    {
        $clientDefaults = GapicClientTraitStub::getClientDefaults();
        $expectedRetrySettings = RetrySettings::load(
            $clientDefaults['serviceName'],
            json_decode(file_get_contents($clientDefaults['clientConfig']), true)
        );
        $disabledRetrySettings = [];
        foreach ($expectedRetrySettings as $method => $retrySettingsItem) {
            $disabledRetrySettings[$method] = $retrySettingsItem->with([
                'retriesEnabled' => false
            ]);
        }
        $expectedProperties = [
            'serviceName' => 'test.interface.v1.api',
            'agentHeader' => AgentHeader::buildAgentHeader([]),
            'retrySettings' => $expectedRetrySettings,
        ];
        return [
            [[], $expectedProperties],
            [['disableRetries' => true], ['retrySettings' => $disabledRetrySettings] + $expectedProperties],
        ];
    }

    /**
     * @dataProvider buildClientOptionsProvider
     */
    public function testBuildClientOptions($options, $expectedUpdatedOptions)
    {
        if (!extension_loaded('sysvshm')) {
            $this->markTestSkipped('The sysvshm extension must be installed to execute this test.');
        }
        $client = new GapicClientTraitStub();
        $updatedOptions = $client->call('buildClientOptions', [$options]);
        $this->assertEquals($expectedUpdatedOptions, $updatedOptions);
    }

    public function buildClientOptionsProvider()
    {
        $apiConfig = new ApiConfig();
        $apiConfig->mergeFromJsonString(
            file_get_contents(__DIR__.'/testdata/test_service_grpc_config.json')
        );
        $grpcGcpConfig = new Config('test.address.com:443', $apiConfig);

        $defaultOptions = [
            'apiEndpoint' => 'test.address.com:443',
            'serviceName' => 'test.interface.v1.api',
            'clientConfig' => __DIR__ . '/testdata/test_service_client_config.json',
            'descriptorsConfigPath' => __DIR__.'/testdata/test_service_descriptor_config.php',
            'gcpApiConfigPath' => __DIR__.'/testdata/test_service_grpc_config.json',
            'disableRetries' => false,
            'auth' => null,
            'authConfig' => null,
            'transport' => null,
            'transportConfig' => [
                'grpc' => [
                    'stubOpts' => [
                        'grpc_call_invoker' => $grpcGcpConfig->callInvoker(),
                        'grpc.service_config_disable_resolution' => 1
                    ]
                ],
                'rest' => [
                    'restClientConfigPath' => __DIR__.'/testdata/test_service_rest_client_config.php',
                ],
                'grpc-fallback' => [],
            ],
            'credentials' => null,
            'credentialsConfig' => [],
            'gapicVersion' => null,
            'libName' => null,
            'libVersion' => null,
            'clientCertSource' => null,
        ];

        $restConfigOptions = $defaultOptions;
        $restConfigOptions['transportConfig']['rest'] += [
            'customRestConfig' => 'value'
        ];
        $grpcConfigOptions = $defaultOptions;
        $grpcConfigOptions['transportConfig']['grpc'] += [
            'customGrpcConfig' => 'value'
        ];
        return [
            [[], $defaultOptions],
            [
                [
                    'transportConfig' => [
                        'rest' => [
                            'customRestConfig' => 'value'
                        ]
                    ]
                ], $restConfigOptions
            ],
            [
                [
                    'transportConfig' => [
                        'grpc' => [
                            'customGrpcConfig' => 'value'
                        ]
                    ]
                ], $grpcConfigOptions
            ],
        ];
    }

    /**
     * @dataProvider buildClientOptionsProviderRestOnly
     */
    public function testBuildClientOptionsRestOnly($options, $expectedUpdatedOptions)
    {
        if (!extension_loaded('sysvshm')) {
            $this->markTestSkipped('The sysvshm extension must be installed to execute this test.');
        }
        $client = new GapicClientTraitRestOnly();
        $updatedOptions = $client->call('buildClientOptions', [$options]);
        $this->assertEquals($expectedUpdatedOptions, $updatedOptions);
    }

    public function buildClientOptionsProviderRestOnly()
    {
        $defaultOptions = [
            'apiEndpoint' => 'test.address.com:443',
            'serviceName' => 'test.interface.v1.api',
            'clientConfig' => __DIR__ . '/testdata/test_service_client_config.json',
            'descriptorsConfigPath' => __DIR__.'/testdata/test_service_descriptor_config.php',
            'disableRetries' => false,
            'transport' => null,
            'transportConfig' => [
                'rest' => [
                    'restClientConfigPath' => __DIR__.'/testdata/test_service_rest_client_config.php',
                ],
                'fake-transport' => []
            ],
            'credentials' => null,
            'credentialsConfig' => [],
            'gapicVersion' => null,
            'libName' => null,
            'libVersion' => null,
            'clientCertSource' => null,
        ];

        $restConfigOptions = $defaultOptions;
        $restConfigOptions['transportConfig']['rest'] += [
            'customRestConfig' => 'value'
        ];

        $fakeTransportConfigOptions = $defaultOptions;
        $fakeTransportConfigOptions['transportConfig']['fake-transport'] += [
            'customRestConfig' => 'value'
        ];
        return [
            [[], $defaultOptions],
            [
                [
                    'transportConfig' => [
                        'rest' => [
                            'customRestConfig' => 'value'
                        ]
                    ]
                ], $restConfigOptions
            ],
            [
                [
                    'transportConfig' => [
                        'fake-transport' => [
                            'customRestConfig' => 'value'
                        ]
                    ]
                ], $fakeTransportConfigOptions
            ],
        ];
    }

    /**
     * @dataProvider buildRequestHeaderParams
     */
    public function testBuildRequestHeaders($headerParams, $request, $expected)
    {
        $client = new GapicClientTraitStub();
        $actual = $client->call('buildRequestParamsHeader', [$headerParams, $request]);
        $this->assertEquals($actual[RequestParamsHeaderDescriptor::HEADER_KEY], $expected);
    }

    public function buildRequestHeaderParams()
    {
        $simple = new MockRequestBody([
            'name' => 'foos/123/bars/456'
        ]);
        $simpleNull = new MockRequestBody();
        $nested = new MockRequestBody([
            'nested_message' => new MockRequestBody([
                'name' => 'foos/123/bars/456'
            ])
        ]);
        $unsetNested = new MockRequestBody([]);
        $nestedNull = new MockRequestBody([
            'nested_message' => new MockRequestBody()
        ]);

        return [
            [
                /* $headerParams */ [
                    [
                        'fieldAccessors' => ['getName'],
                        'keyName' => 'name_field'
                    ],
                ],
                /* $request */ $simple,
                /* $expected */ ['name_field=foos%2F123%2Fbars%2F456']
            ],
            [
                /* $headerParams */ [
                    [
                        'fieldAccessors' => ['getName'],
                        'keyName' => 'name_field'
                    ],
                ],
                /* $request */ $simpleNull,

                // For some reason RequestParamsHeaderDescriptor creates an array
                // with an empty string if there are no headers set in it.
                /* $expected */ ['']
            ],
            [
                /* $headerParams */ [
                    [
                        'fieldAccessors' => ['getNestedMessage','getName'],
                        'keyName' => 'name_field'
                    ],
                ],
                /* $request */ $nested,
                /* $expected */ ['name_field=foos%2F123%2Fbars%2F456']
            ],
            [
                /* $headerParams */ [
                    [
                        'fieldAccessors' => ['getNestedMessage','getName'],
                        'keyName' => 'name_field'
                    ],
                ],
                /* $request */ $unsetNested,
                /* $expected */ ['']
            ],
            [
                /* $headerParams */ [
                    [
                        'fieldAccessors' => ['getNestedMessage','getName'],
                        'keyName' => 'name_field'
                    ],
                ],
                /* $request */ $nestedNull,
                /* $expected */ ['']
            ],
        ];
    }

    public function testModifyClientOptions()
    {
        $options = [];
        $client = new GapicClientTraitStubExtension();
        $updatedOptions = $client->call('buildClientOptions', [$options]);

        $this->assertArrayHasKey('addNewOption', $updatedOptions);
        $this->assertTrue($updatedOptions['disableRetries']);
    }

    private function buildClientToTestModifyCallMethods()
    {
        $header = AgentHeader::buildAgentHeader([]);
        $retrySettings = $this->getMockBuilder(RetrySettings::class)
            ->disableOriginalConstructor()
            ->getMock();

        $longRunningDescriptors = [
            'longRunning' => [
                'operationReturnType' => 'operationType',
                'metadataReturnType' => 'metadataType',
            ]
        ];
        $pageStreamingDescriptors = [
            'pageStreaming' => [
                'requestPageTokenGetMethod' => 'getPageToken',
                'requestPageTokenSetMethod' => 'setPageToken',
                'requestPageSizeGetMethod' => 'getPageSize',
                'requestPageSizeSetMethod' => 'setPageSize',
                'responsePageTokenGetMethod' => 'getNextPageToken',
                'resourcesGetMethod' => 'getResources',
            ],
        ];
        $transport = $this->getMockBuilder(TransportInterface::class)->disableOriginalConstructor()->getMock();
        $credentialsWrapper = CredentialsWrapper::build([
            'keyFile' => __DIR__ . '/testdata/json-key-file.json'
        ]);
        $client = new GapicClientTraitStubExtension();
        $client->set('transport', $transport);
        $client->set('credentialsWrapper', $credentialsWrapper);
        $client->set('agentHeader', $header);
        $client->set('retrySettings', [
            'simpleMethod' => $retrySettings,
            'longRunningMethod' => $retrySettings,
            'pagedMethod' => $retrySettings,
            'bidiStreamingMethod' => $retrySettings,
            'clientStreamingMethod' => $retrySettings,
            'serverStreamingMethod' => $retrySettings,
        ]);
        $client->set('descriptors', [
            'longRunningMethod' => $longRunningDescriptors,
            'pagedMethod' => $pageStreamingDescriptors,
        ]);
        return [$client, $transport];
    }

    public function testModifyUnaryCallFromStartCall()
    {
        list($client, $transport) = $this->buildClientToTestModifyCallMethods();
        $transport->expects($this->once())
            ->method('startUnaryCall')
            ->with(
                $this->isInstanceOf(Call::class),
                $this->equalTo([
                    'transportOptions' => [
                        'custom' => ['addModifyUnaryCallableOption' => true]
                    ],
                    'headers' => AgentHeader::buildAgentHeader([]),
                    'credentialsWrapper' => CredentialsWrapper::build([
                        'keyFile' => __DIR__ . '/testdata/json-key-file.json'
                    ])
                ])
            )
            ->willReturn(new FulfilledPromise(new Operation()));
        $client->call('startCall', [
            'simpleMethod',
            'decodeType',
            [],
            new MockRequest(),
        ])->wait();
    }

    public function testModifyUnaryCallFromOperationsCall()
    {
        list($client, $transport) = $this->buildClientToTestModifyCallMethods();
        $transport->expects($this->once())
            ->method('startUnaryCall')
            ->with(
                $this->isInstanceOf(Call::class),
                $this->equalTo([
                    'transportOptions' => [
                        'custom' => ['addModifyUnaryCallableOption' => true]
                    ],
                    'headers' => AgentHeader::buildAgentHeader([]),
                    'credentialsWrapper' => CredentialsWrapper::build([
                        'keyFile' => __DIR__ . '/testdata/json-key-file.json'
                    ])
                ])
            )
            ->willReturn(new FulfilledPromise(new Operation()));
        $operationsClient = $this->getMockBuilder(OperationsClient::class)
                ->disableOriginalConstructor()
                ->setMethodsExcept(['validate'])
                ->getMock();
        $client->call('startOperationsCall', [
            'longRunningMethod',
            [],
            new MockRequest(),
            $operationsClient
        ])->wait();
    }

    public function testModifyUnaryCallFromGetPagedListResponse()
    {
        list($client, $transport) = $this->buildClientToTestModifyCallMethods();
        $transport->expects($this->once())
            ->method('startUnaryCall')
            ->with(
                $this->isInstanceOf(Call::class),
                $this->equalTo([
                    'transportOptions' => [
                        'custom' => ['addModifyUnaryCallableOption' => true]
                    ],
                    'headers' => AgentHeader::buildAgentHeader([]),
                    'credentialsWrapper' => CredentialsWrapper::build([
                        'keyFile' => __DIR__ . '/testdata/json-key-file.json'
                    ])
                ])
            )
            ->willReturn(new FulfilledPromise(new Operation()));
        $client->call('getPagedListResponse', [
            'pagedMethod',
            [],
            'decodeType',
            new MockRequest(),
        ]);
    }

    /**
     * @dataProvider modifyStreamingCallFromStartCallData
     */
    public function testModifyStreamingCallFromStartCall($callArgs, $expectedMethod, $expectedResponse)
    {
        list($client, $transport) = $this->buildClientToTestModifyCallMethods();
        $transport->expects($this->once())
            ->method($expectedMethod)
            ->with(
                $this->isInstanceOf(Call::class),
                $this->equalTo([
                    'transportOptions' => [
                        'custom' => ['addModifyStreamingCallable' => true]
                    ],
                    'headers' => AgentHeader::buildAgentHeader([]),
                    'credentialsWrapper' => CredentialsWrapper::build([
                        'keyFile' => __DIR__ . '/testdata/json-key-file.json'
                    ])
                ])
            )
            ->willReturn($expectedResponse);
        $client->call('startCall', $callArgs);
    }

    public function modifyStreamingCallFromStartCallData()
    {
        return [
            [
                [
                    'bidiStreamingMethod',
                    '',
                    [],
                    null,
                    Call::BIDI_STREAMING_CALL
                ],
                'startBidiStreamingCall',
                $this->getMockBuilder(BidiStream::class)
                    ->disableOriginalConstructor()
                    ->getMock()
            ],
            [
                [
                    'clientStreamingMethod',
                    '',
                    [],
                    null,
                    Call::CLIENT_STREAMING_CALL
                ],
                'startClientStreamingCall',
                $this->getMockBuilder(ClientStream::class)
                    ->disableOriginalConstructor()
                    ->getMock()
            ],
            [
                [
                    'serverStreamingMethod',
                    '',
                    [],
                    new MockRequest(),
                    Call::SERVER_STREAMING_CALL
                ],
                'startServerStreamingCall',
                $this->getMockBuilder(ServerStream::class)
                    ->disableOriginalConstructor()
                    ->getMock()
            ],
        ];
    }

    public function testGetTransport()
    {
        $transport = $this->getMockBuilder(TransportInterface::class)->getMock();
        $client = new GapicClientTraitStub();
        $client->set('transport', $transport);
        $this->assertEquals($transport, $client->call('getTransport'));
    }

    public function testGetCredentialsWrapper()
    {
        $credentialsWrapper = $this->getMockBuilder(CredentialsWrapper::class)
            ->disableOriginalConstructor()
            ->getMock();
        $client = new GapicClientTraitStub();
        $client->set('credentialsWrapper', $credentialsWrapper);
        $this->assertEquals($credentialsWrapper, $client->call('getCredentialsWrapper'));
    }

    public function testUserProjectHeaderIsSetWhenProvidingQuotaProject()
    {
        $quotaProject = 'test-quota-project';
        $credentialsWrapper = $this->getMockBuilder(CredentialsWrapper::class)
            ->disableOriginalConstructor()
            ->getMock();
        $credentialsWrapper->expects($this->once())
            ->method('getQuotaProject')
            ->willReturn($quotaProject);
        $transport = $this->getMockBuilder(TransportInterface::class)->getMock();
        $transport->expects($this->once())
            ->method('startUnaryCall')
            ->with(
                $this->isInstanceOf(Call::class),
                $this->equalTo([
                    'headers' => AgentHeader::buildAgentHeader([]) + [
                        'X-Goog-User-Project' => [$quotaProject]
                    ],
                    'credentialsWrapper' => $credentialsWrapper
                ])
            );
        $client = new GapicClientTraitStub();
        $updatedOptions = $client->call('buildClientOptions', [
            [
                'transport' => $transport,
                'credentials' => $credentialsWrapper,
            ]
        ]);
        $client->call('setClientOptions', [$updatedOptions]);
        $client->set('retrySettings', [
            'method' => $this->getMockBuilder(RetrySettings::class)
                ->disableOriginalConstructor()
                ->getMock()
            ]
        );
        $client->call('startCall', [
            'method',
            'decodeType'
        ]);
    }

    public function testDefaultScopes()
    {
        $client = new GapicClientTraitDefaultScopeAndAudienceStub();

        // verify scopes are not set by default
        $defaultOptions = $client->call('buildClientOptions', [[]]);
        $this->assertArrayNotHasKey('scopes', $defaultOptions['credentialsConfig']);

        // verify scopes are set when a custom api endpoint is used
        $defaultOptions = $client->call('buildClientOptions', [[
            'apiEndpoint' => 'www.someotherendpoint.com',
        ]]);
        $this->assertArrayHasKey('scopes', $defaultOptions['credentialsConfig']);
        $this->assertEquals(
            $client::$serviceScopes,
            $defaultOptions['credentialsConfig']['scopes']
        );

        // verify user-defined scopes override default scopes
        $defaultOptions = $client->call('buildClientOptions', [[
            'credentialsConfig' => ['scopes' => ['user-scope-1']],
            'apiEndpoint' => 'www.someotherendpoint.com',
        ]]);
        $this->assertArrayHasKey('scopes', $defaultOptions['credentialsConfig']);
        $this->assertEquals(
            ['user-scope-1'],
            $defaultOptions['credentialsConfig']['scopes']
        );

        // verify empty default scopes has no effect
        $client::$serviceScopes = null;
        $defaultOptions = $client->call('buildClientOptions', [[
            'apiEndpoint' => 'www.someotherendpoint.com',
        ]]);
        $this->assertArrayNotHasKey('scopes', $defaultOptions['credentialsConfig']);
    }

    public function testDefaultAudience()
    {
        $retrySettings = $this->prophesize(RetrySettings::class);
        $credentialsWrapper = $this->prophesize(CredentialsWrapper::class)
            ->reveal();
        $transport = $this->prophesize(TransportInterface::class);
        $transport
            ->startUnaryCall(
                Argument::any(),
                [
                    'audience' => 'https://service-address/',
                    'headers' => [],
                    'credentialsWrapper' => $credentialsWrapper,
                ]
            )
            ->shouldBeCalledOnce();

        $client = new GapicClientTraitDefaultScopeAndAudienceStub();
        $client->set('credentialsWrapper', $credentialsWrapper);
        $client->set('agentHeader', []);
        $client->set(
            'retrySettings',
            ['method.name' => $retrySettings->reveal()]
        );
        $client->set('transport', $transport->reveal());
        $client->call('startCall', ['method.name', 'decodeType']);

        $transport
            ->startUnaryCall(
                Argument::any(),
                [
                    'audience' => 'custom-audience',
                    'headers' => [],
                    'credentialsWrapper' => $credentialsWrapper,
                ]
            )
            ->shouldBeCalledOnce();

        $client->call('startCall', ['method.name', 'decodeType', [
            'audience' => 'custom-audience',
        ]]);
    }

    public function testDefaultAudienceWithOperations()
    {
        $retrySettings = $this->prophesize(RetrySettings::class);
        $credentialsWrapper = $this->prophesize(CredentialsWrapper::class)
            ->reveal();
        $transport = $this->prophesize(TransportInterface::class);
        $transport
            ->startUnaryCall(
                Argument::any(),
                [
                    'audience' => 'https://service-address/',
                    'headers' => [],
                    'credentialsWrapper' => $credentialsWrapper,
                ]
            )
            ->shouldBeCalledOnce()
            ->willReturn(new FulfilledPromise(new Operation()));

        $longRunningDescriptors = [
            'longRunning' => [
                'operationReturnType' => 'operationType',
                'metadataReturnType' => 'metadataType',
                'initialPollDelayMillis' => 100,
                'pollDelayMultiplier' => 1.0,
                'maxPollDelayMillis' => 200,
                'totalPollTimeoutMillis' => 300,
            ]
        ];
        $client = new GapicClientTraitDefaultScopeAndAudienceStub();
        $client->set('credentialsWrapper', $credentialsWrapper);
        $client->set('agentHeader', []);
        $client->set(
            'retrySettings',
            ['method.name' => $retrySettings->reveal()]
        );
        $client->set('transport', $transport->reveal());
        $client->set('descriptors', ['method.name' => $longRunningDescriptors]);
        $operationsClient = $this->getMockBuilder(OperationsClient::class)
            ->disableOriginalConstructor()
            ->setMethodsExcept(['validate'])
            ->getMock();

        // Test startOperationsCall with default audience
        $client->call('startOperationsCall', [
            'method.name',
            [],
            new MockRequest(),
            $operationsClient,
        ])->wait();
    }

    public function testDefaultAudienceWithPagedList()
    {
        $retrySettings = $this->prophesize(RetrySettings::class);
        $credentialsWrapper = $this->prophesize(CredentialsWrapper::class)
            ->reveal();
        $transport = $this->prophesize(TransportInterface::class);
        $transport
            ->startUnaryCall(
                Argument::any(),
                [
                    'audience' => 'https://service-address/',
                    'headers' => [],
                    'credentialsWrapper' => $credentialsWrapper,
                ]
            )
            ->shouldBeCalledOnce()
            ->willReturn(new FulfilledPromise(new Operation()));
        $pageStreamingDescriptors = [
            'pageStreaming' => [
                'requestPageTokenGetMethod' => 'getPageToken',
                'requestPageTokenSetMethod' => 'setPageToken',
                'requestPageSizeGetMethod' => 'getPageSize',
                'requestPageSizeSetMethod' => 'setPageSize',
                'responsePageTokenGetMethod' => 'getNextPageToken',
                'resourcesGetMethod' => 'getResources',
            ],
        ];
        $client = new GapicClientTraitDefaultScopeAndAudienceStub();
        $client->set('credentialsWrapper', $credentialsWrapper);
        $client->set('agentHeader', []);
        $client->set(
            'retrySettings',
            ['method.name' => $retrySettings->reveal()]
        );
        $client->set('transport', $transport->reveal());
        $client->set('descriptors', [
            'method.name' => $pageStreamingDescriptors
        ]);

        // Test getPagedListResponse with default audience
        $client->call('getPagedListResponse', [
            'method.name',
            [],
            'decodeType',
            new MockRequest(),
        ]);
    }

    public function testSupportedTransportOverrideWithInvalidTransport()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Unexpected transport option "grpc". Supported transports: rest');

        new GapicClientTraitRestOnly(['transport' => 'grpc']);
    }

    public function testSupportedTransportOverrideWithDefaultTransport()
    {
        $client = new GapicClientTraitRestOnly();
        $this->assertInstanceOf(RestTransport::class, $client->getTransport());
    }

    public function testSupportedTransportOverrideWithExplicitTransport()
    {
        $client = new GapicClientTraitRestOnly(['transport' => 'rest']);
        $this->assertInstanceOf(RestTransport::class, $client->getTransport());
    }

    /** @dataProvider provideDetermineMtlsEndpoint */
    public function testDetermineMtlsEndpoint($apiEndpoint, $expected)
    {
        $client = new GapicClientTraitStub();

        $this->assertEquals(
            $expected,
            $client->call('determineMtlsEndpoint', [$apiEndpoint])
        );
    }

    public function provideDetermineMtlsEndpoint()
    {
        return [
            ['foo', 'foo'],         // invalid no-op
            ['api.dev', 'api.dev'], // invalid no-op
            // normal endpoint
            ['vision.googleapis.com', 'vision.mtls.googleapis.com'],
            // endpoint with protocol
            ['https://vision.googleapis.com', 'https://vision.mtls.googleapis.com'],
            // endpoint with protocol and path
            ['https://vision.googleapis.com/foo', 'https://vision.mtls.googleapis.com/foo'],
            // regional endpoint
            ['us-documentai.googleapis.com', 'us-documentai.mtls.googleapis.com'],
        ];
    }

    /**
     * @runInSeparateProcess
     * @dataProvider provideShouldUseMtlsEndpoint
     */
    public function testShouldUseMtlsEndpoint($envVarValue, $options, $expected)
    {
        $client = new GapicClientTraitStub();

        putenv('GOOGLE_API_USE_MTLS_ENDPOINT=' . $envVarValue);
        $this->assertEquals(
            $expected,
            $client->call('shouldUseMtlsEndpoint', [$options])
        );
    }

    public function provideShouldUseMtlsEndpoint()
    {
        return [
            ['', [], false],
            ['always', [], true],
            ['never', [], false],
            ['never', ['clientCertSource' => true], false],
            ['auto', ['clientCertSource' => true], true],
            ['invalid', ['clientCertSource' => true], true],
            ['', ['clientCertSource' => true], true],
        ];
    }

    /**
     * @runInSeparateProcess
     * @dataProvider provideMtlsClientOptions
     */
    public function testMtlsClientOptions($envVars, $options, $expected)
    {
        foreach ($envVars as $envVar) {
            putenv($envVar);
        }

        $client = new GapicClientTraitStub();
        $options = $client->call('buildClientOptions', [$options]);

        // Only check the keys we care about
        $options = array_intersect_key(
            $options,
            array_flip(['apiEndpoint', 'clientCertSource'])
        );

        $this->assertEquals($expected, $options);
    }

    public function provideMtlsClientOptions()
    {
        $defaultEndpoint = 'test.address.com:443';
        $mtlsEndpoint = 'test.mtls.address.com:443';
        return [
            [
                [],
                [],
                ['apiEndpoint' => $defaultEndpoint, 'clientCertSource' => null]
            ],
            [
                ['GOOGLE_API_USE_MTLS_ENDPOINT=always'],
                [],
                ['apiEndpoint' => $mtlsEndpoint, 'clientCertSource' => null]
            ],
            [
                ['GOOGLE_API_USE_MTLS_ENDPOINT=always'],
                ['apiEndpoint' => 'user.supplied.endpoint:443'],
                ['apiEndpoint' => 'user.supplied.endpoint:443', 'clientCertSource' => null]
            ],
            [
                ['GOOGLE_API_USE_MTLS_ENDPOINT=never'],
                ['clientCertSource' => true],
                ['apiEndpoint' => $defaultEndpoint, 'clientCertSource' => true]
            ],
            [
                [
                    'GOOGLE_API_USE_MTLS_ENDPOINT=auto'
                ],
                ['clientCertSource' => true],
                ['apiEndpoint' => $mtlsEndpoint, 'clientCertSource' => true]
            ],
            [
                [
                    'HOME=' . __DIR__ . '/testdata/nonexistant',
                    'GOOGLE_API_USE_MTLS_ENDPOINT', // no env var
                    CredentialsLoader::MTLS_CERT_ENV_VAR . '=true',
                ],
                [],
                ['apiEndpoint' => $defaultEndpoint, 'clientCertSource' => null]
            ],
        ];
    }

    /**
     * @runInSeparateProcess
     */
    public function testMtlsClientOptionWithDefaultClientCertSource()
    {
        putenv('HOME=' . __DIR__ . '/testdata/mtls');
        putenv('GOOGLE_API_USE_MTLS_ENDPOINT=auto');
        putenv(CredentialsLoader::MTLS_CERT_ENV_VAR . '=true');

        $client = new GapicClientTraitStub();
        $options = $client->call('buildClientOptions', [[]]);

        $this->assertSame('test.mtls.address.com:443', $options['apiEndpoint']);
        $this->assertTrue(is_callable($options['clientCertSource']));
        $this->assertEquals(['foo', 'foo'], $options['clientCertSource']());
    }
}

class GapicClientTraitStub
{
    use GapicClientTrait;

    public static function getClientDefaults()
    {
        return [
            'apiEndpoint' => 'test.address.com:443',
            'serviceName' => 'test.interface.v1.api',
            'clientConfig' => __DIR__ . '/testdata/test_service_client_config.json',
            'descriptorsConfigPath' => __DIR__.'/testdata/test_service_descriptor_config.php',
            'gcpApiConfigPath' => __DIR__.'/testdata/test_service_grpc_config.json',
            'disableRetries' => false,
            'auth' => null,
            'authConfig' => null,
            'transport' => null,
            'transportConfig' => [
                'rest' => [
                    'restClientConfigPath' => __DIR__.'/testdata/test_service_rest_client_config.php',
                ]
            ],
        ];
    }

    public function call($fn, array $args = [])
    {
        return call_user_func_array([$this, $fn], $args);
    }

    public function set($name, $val, $static = false)
    {
        if (!property_exists($this, $name)) {
            throw new \InvalidArgumentException("Property not found: $name");
        }
        if ($static) {
            $this::$$name = $val;
        } else {
            $this->$name = $val;
        }
    }

    public function get($name)
    {
        if (!property_exists($this, $name)) {
            throw new \InvalidArgumentException("Property not found: $name");
        }
        return $this->$name;
    }
}

class GapicClientTraitStubExtension extends GapicClientTraitStub
{
    protected function modifyClientOptions(array &$options)
    {
        $options['disableRetries'] = true;
        $options['addNewOption'] = true;
    }

    protected function modifyUnaryCallable(callable &$callable)
    {
        $originalCallable = $callable;
        $callable = function ($call, $options) use ($originalCallable) {
            $options['transportOptions'] = [
                'custom' => ['addModifyUnaryCallableOption' => true]
            ];
            return $originalCallable($call, $options);
        };
    }

    protected function modifyStreamingCallable(callable &$callable)
    {
        $originalCallable = $callable;
        $callable = function ($call, $options) use ($originalCallable) {
            $options['transportOptions'] = [
                'custom' => ['addModifyStreamingCallable' => true]
            ];
            return $originalCallable($call, $options);
        };
    }
}

class GapicClientTraitDefaultScopeAndAudienceStub
{
    use GapicClientTrait;

    const SERVICE_ADDRESS = 'service-address';

    public static $serviceScopes = [
        'default-scope-1',
        'default-scope-2',
    ];

    public static function getClientDefaults()
    {
        return [
            'apiEndpoint' => 'test.address.com:443',
            'credentialsConfig' => [
                'defaultScopes' => self::$serviceScopes,
            ],
        ];
    }

    public function call($fn, array $args = [])
    {
        return call_user_func_array([$this, $fn], $args);
    }

    public function set($name, $val, $static = false)
    {
        if (!property_exists($this, $name)) {
            throw new \InvalidArgumentException("Property not found: $name");
        }
        if ($static) {
            $this::$$name = $val;
        } else {
            $this->$name = $val;
        }
    }
}

class GapicClientTraitRestOnly
{
    use GapicClientTrait;

    public function __construct($options = [])
    {
        $options['apiEndpoint'] = 'api.example.com';
        $this->setClientOptions($this->buildClientOptions($options));
    }

    public static function getClientDefaults()
    {
        return [
            'apiEndpoint' => 'test.address.com:443',
            'serviceName' => 'test.interface.v1.api',
            'clientConfig' => __DIR__ . '/testdata/test_service_client_config.json',
            'descriptorsConfigPath' => __DIR__.'/testdata/test_service_descriptor_config.php',
            'transportConfig' => [
                'rest' => [
                    'restClientConfigPath' => __DIR__.'/testdata/test_service_rest_client_config.php',
                ]
            ],
        ];
    }

    public function call($fn, array $args = [])
    {
        return call_user_func_array([$this, $fn], $args);
    }

    public function getTransport()
    {
        return $this->transport;
    }

    private static function supportedTransports()
    {
        return ['rest', 'fake-transport'];
    }

    private static function defaultTransport()
    {
        return 'rest';
    }
}

class GapicClientTraitOperationsStub extends GapicClientTraitStub
{
    public $operationsClient;

    public function getOperationsClient()
    {
        return $this->operationsClient;
    }
}

class CustomOperationsClient
{
    public function getOperation($name, $arg1, $arg2)
    {
    }
}

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

use Google\ApiCore\AgentHeader;
use Google\ApiCore\BidiStream;
use Google\ApiCore\Call;
use Google\ApiCore\ClientStream;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\GapicClientTrait;
use Google\ApiCore\LongRunning\OperationsClient;
use Google\ApiCore\Middleware\MiddlewareInterface;
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
use Google\LongRunning\Operation;
use Grpc\Gcp\Config;
use GuzzleHttp\Promise\FulfilledPromise;
use GuzzleHttp\Promise\PromiseInterface;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;

class GapicClientTraitTest extends TestCase
{
    use ProphecyTrait;
    use TestTrait;

    public function tearDown(): void
    {
        // Reset the static gapicVersion field between tests
        $client = new StubGapicClient();
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
            )
            ->willReturn($this->prophesize(PromiseInterface::class)->reveal());
        $client = new StubGapicClient();
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
        $client->startApiCall(
            'method',
            $request,
            ['headers' => $headers]
        );
    }

    public function testConfigureCallConstructionOptionsAcceptsRetryObjectOrArray()
    {
        $defaultRetrySettings = RetrySettings::constructDefault();
        $client = new StubGapicClient();
        $client->set('retrySettings', ['method' => $defaultRetrySettings]);
        $expectedOptions = [
            'retrySettings' => $defaultRetrySettings
                ->with(['rpcTimeoutMultiplier' => 5])
        ];
        $actualOptionsWithObject = $client->configureCallConstructionOptions(
            'method',
            [
                'retrySettings' => $defaultRetrySettings
                    ->with(['rpcTimeoutMultiplier' => 5])
            ]
        );
        $actualOptionsWithArray = $client->configureCallConstructionOptions(
            'method',
            [
                'retrySettings' => ['rpcTimeoutMultiplier' => 5]
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
        $client = new StubGapicClient();
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

        $response = $client->startOperationsCall(
            'method',
            [],
            $message,
            $operationsClient
        )->wait();

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
        $client = new OperationsGapicClient();
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
        $response = $client->startApiCall(
            'method',
            $request
        )->wait();

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
        $client = new OperationsGapicClient();
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
        $response = $client->startApiCall(
            'method',
            $request,
        )->wait();

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
        $client = new StubGapicClient();
        $client->set('descriptors', $descriptor);

        // All descriptor config checks throw Validation exceptions
        $this->expectException(ValidationException::class);
        // Check that the proper exception is being thrown for the given descriptor.
        $this->expectExceptionMessage($expected);

        $client->startApiCall(
            'method',
            new MockRequest()
        )->wait();
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
                 $this->callback(function ($call) use ($unaryDescriptors) {
                     return strpos($call->getMethod(), $unaryDescriptors['interfaceOverride']) !== false;
                 }),
                 $this->anything()
             )
             ->will($this->returnValue($expectedPromise));
        $credentialsWrapper = CredentialsWrapper::build([]);
        $client = new StubGapicClient();
        $client->set('transport', $transport);
        $client->set('credentialsWrapper', $credentialsWrapper);
        $client->set('agentHeader', $header);
        $client->set('retrySettings', ['method' => $retrySettings]);
        $client->set('descriptors', ['method' => $unaryDescriptors]);

        $request = new MockRequest();
        $client->startApiCall(
            'method',
            $request
        )->wait();
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
        $client = new StubGapicClient();
        $client->set('transport', $transport);
        $client->set('credentialsWrapper', $credentialsWrapper);
        $client->set('agentHeader', $header);
        $client->set('retrySettings', ['method' => $retrySettings]);
        $client->set('descriptors', ['method' => $pagedDescriptors]);

        $request = new MockRequest();
        $client->startApiCall(
            'method',
            $request
        );
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
        $client = new StubGapicClient();
        $client->set('transport', $transport);
        $client->set('credentialsWrapper', $credentialsWrapper);
        $client->set('agentHeader', $header);
        $client->set('retrySettings', ['Method' => $retrySettings]);
        $client->set('descriptors', ['Method' => $unaryDescriptors]);

        $request = new MockRequest();
        $client->startAsyncCall(
            'method',
            $request
        )->wait();
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
                 $this->callback(function ($call) use ($pagedDescriptors) {
                     return strpos($call->getMethod(), $pagedDescriptors['interfaceOverride']) !== false;
                 }),
                 $this->anything()
             )
             ->will($this->returnValue($expectedPromise));
        $credentialsWrapper = CredentialsWrapper::build([]);
        $client = new StubGapicClient();
        $client->set('transport', $transport);
        $client->set('credentialsWrapper', $credentialsWrapper);
        $client->set('agentHeader', $header);
        $client->set('retrySettings', ['Method' => $retrySettings]);
        $client->set('descriptors', ['Method' => $pagedDescriptors]);

        $request = new MockRequest();
        $client->startAsyncCall(
            'method',
            $request
        )->wait();
    }

    /**
     * @dataProvider startAsyncCallExceptions
     */
    public function testStartAsyncCallException($descriptor, $expected)
    {
        $client = new StubGapicClient();
        $client->set('descriptors', $descriptor);

        // All descriptor config checks throw Validation exceptions
        $this->expectException(ValidationException::class);
        // Check that the proper exception is being thrown for the given descriptor.
        $this->expectExceptionMessage($expected);

        $client->startAsyncCall(
            'method',
            new MockRequest()
        )->wait();
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

    /**
     * @dataProvider createTransportData
     */
    public function testCreateTransport($apiEndpoint, $transport, $transportConfig, $expectedTransportClass)
    {
        if ($expectedTransportClass == GrpcTransport::class) {
            $this->requiresGrpcExtension();
        }
        $client = new StubGapicClient();
        $transport = $client->createTransport(
            $apiEndpoint,
            $transport,
            $transportConfig
        );

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
        $client = new StubGapicClient();

        $this->expectException(ValidationException::class);

        $client->createTransport(
            $apiEndpoint,
            $transport,
            $transportConfig
        );
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
        $client = new StubGapicClient();
        $apiEndpoint = 'test.address.com:443';
        $updatedOptions = $client->buildClientOptions(
            ['serviceAddress' => $apiEndpoint]
        );
        $client->setClientOptions($updatedOptions);

        $this->assertEquals($apiEndpoint, $updatedOptions['apiEndpoint']);
        $this->assertArrayNotHasKey('serviceAddress', $updatedOptions);
    }

    public function testOperationClientClassOption()
    {
        $options = ['operationsClientClass' => CustomOperationsClient::class];
        $client = new StubGapicClient();
        $operationsClient = $client->createOperationsClient($options);
        $this->assertInstanceOf(CustomOperationsClient::class, $operationsClient);
    }

    public function testAdditionalArgumentMethods()
    {
        $client = new StubGapicClient();

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

        $operationResponse = $client->startOperationsCall(
            'method.name',
            [],
            $request,
            $operationsClient->reveal()
        )->wait();

        // This will invoke $operationsClient->getOperation with values from
        // the additional argument methods.
        $operationResponse->reload();
    }

    /**
     * @dataProvider setClientOptionsData
     */
    public function testSetClientOptions($options, $expectedProperties)
    {
        $client = new StubGapicClient();
        $updatedOptions = $client->buildClientOptions($options);
        $client->setClientOptions($updatedOptions);
        foreach ($expectedProperties as $propertyName => $expectedValue) {
            $actualValue = $client->get($propertyName);
            $this->assertEquals($expectedValue, $actualValue);
        }
    }

    public function setClientOptionsData()
    {
        $clientDefaults = StubGapicClient::getClientDefaults();
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
            'agentHeader' => AgentHeader::buildAgentHeader([]) + ['User-Agent' => ['gcloud-php-legacy/']],
            'retrySettings' => $expectedRetrySettings,
        ];
        return [
            [[], $expectedProperties],
            [['disableRetries' => true], ['retrySettings' => $disabledRetrySettings] + $expectedProperties],
        ];
    }

    /**
     * @dataProvider buildRequestHeaderParams
     */
    public function testBuildRequestHeaders($headerParams, $request, $expected)
    {
        $client = new StubGapicClient();
        $actual = $client->buildRequestParamsHeader($headerParams, $request);
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
                        'fieldAccessors' => ['getNestedMessage', 'getName'],
                        'keyName' => 'name_field'
                    ],
                ],
                /* $request */ $nested,
                /* $expected */ ['name_field=foos%2F123%2Fbars%2F456']
            ],
            [
                /* $headerParams */ [
                    [
                        'fieldAccessors' => ['getNestedMessage', 'getName'],
                        'keyName' => 'name_field'
                    ],
                ],
                /* $request */ $unsetNested,
                /* $expected */ ['']
            ],
            [
                /* $headerParams */ [
                    [
                        'fieldAccessors' => ['getNestedMessage', 'getName'],
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
        $client = new StubGapicClientExtension();
        $updatedOptions = $client->buildClientOptions($options);
        $client->setClientOptions($updatedOptions);

        $this->assertArrayHasKey('addNewOption', $updatedOptions);
        $this->assertTrue($updatedOptions['disableRetries']);
        $this->assertEquals('abc123', $updatedOptions['apiEndpoint']);
    }

    private function buildClientToTestModifyCallMethods($clientClass = null)
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
        $clientClass = $clientClass ?: StubGapicClientExtension::class;
        $client = new $clientClass();
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
        $client->startCall(
            'simpleMethod',
            'decodeType',
            [],
            new MockRequest(),
        )->wait();
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
                    ]),
                    'metadataReturnType' => 'metadataType'
                ])
            )
            ->willReturn(new FulfilledPromise(new Operation()));
        $operationsClient = $this->getMockBuilder(OperationsClient::class)
                ->disableOriginalConstructor()
                ->setMethodsExcept(['validate'])
                ->getMock();
        $client->startOperationsCall(
            'longRunningMethod',
            [],
            new MockRequest(),
            $operationsClient
        )->wait();
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
        $client->getPagedListResponse(
            'pagedMethod',
            [],
            'decodeType',
            new MockRequest(),
        );
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
        $client->startCall(...$callArgs);
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
        $client = new StubGapicClient();
        $client->set('transport', $transport);
        $this->assertEquals($transport, $client->getTransport());
    }

    public function testGetCredentialsWrapper()
    {
        $credentialsWrapper = $this->getMockBuilder(CredentialsWrapper::class)
            ->disableOriginalConstructor()
            ->getMock();
        $client = new StubGapicClient();
        $client->set('credentialsWrapper', $credentialsWrapper);
        $this->assertEquals($credentialsWrapper, $client->getCredentialsWrapper());
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
                        'X-Goog-User-Project' => [$quotaProject],
                        'User-Agent' => ['gcloud-php-legacy/']
                    ],
                    'credentialsWrapper' => $credentialsWrapper
                ])
            )
            ->willReturn($this->prophesize(PromiseInterface::class)->reveal());
        $client = new StubGapicClient();
        $updatedOptions = $client->buildClientOptions(
            [
                'transport' => $transport,
                'credentials' => $credentialsWrapper,
            ]
        );
        $client->setClientOptions($updatedOptions);
        $client->set('retrySettings', [
            'method' => $this->getMockBuilder(RetrySettings::class)
                ->disableOriginalConstructor()
                ->getMock()
            ]
        );
        $client->startCall(
            'method',
            'decodeType'
        );
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
            ->shouldBeCalledOnce()
            ->willReturn($this->prophesize(PromiseInterface::class)->reveal());

        $client = new DefaultScopeAndAudienceGapicClient();
        $client->set('credentialsWrapper', $credentialsWrapper);
        $client->set('agentHeader', []);
        $client->set(
            'retrySettings',
            ['method.name' => $retrySettings->reveal()]
        );
        $client->set('transport', $transport->reveal());
        $client->startCall('method.name', 'decodeType');

        $transport
            ->startUnaryCall(
                Argument::any(),
                [
                    'audience' => 'custom-audience',
                    'headers' => [],
                    'credentialsWrapper' => $credentialsWrapper,
                ]
            )
            ->shouldBeCalledOnce()
            ->willReturn($this->prophesize(PromiseInterface::class)->reveal());

        $client->startCall('method.name', 'decodeType', [
            'audience' => 'custom-audience',
        ]);
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
                    'metadataReturnType' => 'metadataType'
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
        $client = new DefaultScopeAndAudienceGapicClient();
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
        $client->startOperationsCall(
            'method.name',
            [],
            new MockRequest(),
            $operationsClient,
        )->wait();
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
        $client = new DefaultScopeAndAudienceGapicClient();
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
        $client->getPagedListResponse(
            'method.name',
            [],
            'decodeType',
            new MockRequest(),
        );
    }

    public function testSupportedTransportOverrideWithInvalidTransport()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Unexpected transport option "grpc". Supported transports: rest');

        new RestOnlyGapicClient(['transport' => 'grpc']);
    }

    public function testSupportedTransportOverrideWithDefaultTransport()
    {
        $client = new RestOnlyGapicClient();
        $this->assertInstanceOf(RestTransport::class, $client->getTransport());
    }

    public function testSupportedTransportOverrideWithExplicitTransport()
    {
        $client = new RestOnlyGapicClient(['transport' => 'rest']);
        $this->assertInstanceOf(RestTransport::class, $client->getTransport());
    }

    public function testAddMiddlewares()
    {
        list($client, $transport) = $this->buildClientToTestModifyCallMethods();

        $m1Called = false;
        $m2Called = false;
        $middleware1 = function (MiddlewareInterface $handler) use (&$m1Called) {
            return new class($handler, $m1Called) implements MiddlewareInterface {
                private MiddlewareInterface $handler;
                private bool $m1Called;
                public function __construct(
                    MiddlewareInterface $handler,
                    bool &$m1Called
                ) {
                    $this->handler = $handler;
                    $this->m1Called = &$m1Called;
                }
                public function __invoke(Call $call, array $options)
                {
                    $this->m1Called = true;
                    return ($this->handler)($call, $options);
                }
            };
        };
        $middleware2 = function (MiddlewareInterface $handler) use (&$m2Called) {
            return new class($handler, $m2Called) implements MiddlewareInterface {
                private MiddlewareInterface $handler;
                private bool $m2Called;
                public function __construct(
                    MiddlewareInterface $handler,
                    bool &$m2Called
                ) {
                    $this->handler = $handler;
                    $this->m2Called = &$m2Called;
                }
                public function __invoke(Call $call, array $options)
                {
                    $this->m2Called = true;
                    return ($this->handler)($call, $options);
                }
            };
        };
        $client->addMiddleware($middleware1);
        $client->addMiddleware($middleware2);

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

        $client->startCall(
            'simpleMethod',
            'decodeType',
            [],
            new MockRequest(),
        )->wait();

        $this->assertTrue($m1Called);
        $this->assertTrue($m2Called);
    }

    public function testInvalidClientOptionsTypeThrowsExceptionForV2SurfaceOnly()
    {
        // v1 client
        new StubGapicClient(['apiEndpoint' => ['foo']]);
        $this->assertTrue(true, 'Test made it to here without throwing an exception');

        $this->expectException(\TypeError::class);
        $this->expectExceptionMessage(
            PHP_MAJOR_VERSION < 8
                ? 'Argument 1 passed to Google\ApiCore\Options\ClientOptions::setApiEndpoint() '
                    . 'must be of the type string or null, array given'
                : 'Google\ApiCore\Options\ClientOptions::setApiEndpoint(): Argument #1 '
                    . '($apiEndpoint) must be of type ?string, array given'
        );

        // v2 client
        new GapicV2SurfaceClient(['apiEndpoint' => ['foo']]);
    }

    public function testCallOptionsForV2Surface()
    {
        list($client, $transport) = $this->buildClientToTestModifyCallMethods(
            GapicV2SurfaceClient::class
        );

        $transport->expects($this->once())
            ->method('startUnaryCall')
            ->with(
                $this->isInstanceOf(Call::class),
                $this->equalTo([
                    'headers' => AgentHeader::buildAgentHeader([]) + ['Foo' => 'Bar'],
                    'credentialsWrapper' => CredentialsWrapper::build([
                        'keyFile' => __DIR__ . '/testdata/json-key-file.json'
                    ]),
                    'timeoutMillis' => null, // adds null timeoutMillis,
                    'transportOptions' => [],
                ])
            )
            ->willReturn(new FulfilledPromise(new Operation()));

        $callOptions = [
            'headers' => ['Foo' => 'Bar'],
            'invalidOption' => 'wont-be-passed'
        ];
        $client->startCall(
            'simpleMethod',
            'decodeType',
            $callOptions,
            new MockRequest(),
        )->wait();
    }

    public function testInvalidCallOptionsTypeForV1SurfaceDoesNotThrowException()
    {
        list($client, $transport) = $this->buildClientToTestModifyCallMethods();

        $transport->expects($this->once())
            ->method('startUnaryCall')
            ->with(
                $this->isInstanceOf(Call::class),
                $this->equalTo([
                    'transportOptions' => ['custom' => ['addModifyUnaryCallableOption' => true]],
                    'headers' => AgentHeader::buildAgentHeader([]),
                    'credentialsWrapper' => CredentialsWrapper::build([
                        'keyFile' => __DIR__ . '/testdata/json-key-file.json'
                    ]),
                    'timeoutMillis' => 'blue', // invalid type, this is ignored
                ])
            )
            ->willReturn(new FulfilledPromise(new Operation()));

        $client->startCall(
            'simpleMethod',
            'decodeType',
            ['timeoutMillis' => 'blue'],
            new MockRequest(),
        )->wait();
    }

    public function testInvalidCallOptionsTypeForV2SurfaceThrowsException()
    {
        $this->expectException(\TypeError::class);
        $this->expectExceptionMessage(
            PHP_MAJOR_VERSION < 8
                ? 'Argument 1 passed to Google\ApiCore\Options\CallOptions::setTimeoutMillis() '
                    . 'must be of the type int or null, string given'
                : 'Google\ApiCore\Options\CallOptions::setTimeoutMillis(): Argument #1 '
                    . '($timeoutMillis) must be of type ?int, string given'
        );

        list($client, $_) = $this->buildClientToTestModifyCallMethods(GapicV2SurfaceClient::class);

        $client->startCall(
            'simpleMethod',
            'decodeType',
            ['timeoutMillis' => 'blue'], // invalid type, will throw exception
            new MockRequest(),
        )->wait();
    }

    public function testSurfaceAgentHeaders()
    {
        // V1 does not contain new headers
        $client = new RestOnlyGapicClient([
            'gapicVersion' => '0.0.2',
        ]);
        $agentHeader = $client->getAgentHeader();
        $this->assertStringContainsString(' gapic/0.0.2 ', $agentHeader['x-goog-api-client'][0]);
        $this->assertEquals('gcloud-php-legacy/0.0.2', $agentHeader['User-Agent'][0]);

        // V2 contains new headers
        $client = new GapicV2SurfaceClient([
            'gapicVersion' => '0.0.1',
        ]);
        $agentHeader = $client->getAgentHeader();
        $this->assertStringContainsString(' gapic/0.0.1 ', $agentHeader['x-goog-api-client'][0]);
        $this->assertEquals('gcloud-php-new/0.0.1', $agentHeader['User-Agent'][0]);
    }
}

class StubGapicClient
{
    use GapicClientTrait {
        buildClientOptions as public;
        buildRequestParamsHeader as public;
        configureCallConstructionOptions as public;
        createCredentialsWrapper as public;
        createOperationsClient as public;
        createTransport as public;
        determineMtlsEndpoint as public;
        getGapicVersion as public;
        getCredentialsWrapper as public;
        getPagedListResponse as public;
        getTransport as public;
        setClientOptions as public;
        shouldUseMtlsEndpoint as public;
        startApiCall as public;
        startAsyncCall as public;
        startCall as public;
        startOperationsCall as public;
    }
    use GapicClientStubTrait;

    public static function getClientDefaults()
    {
        return [
            'apiEndpoint' => 'test.address.com:443',
            'serviceName' => 'test.interface.v1.api',
            'clientConfig' => __DIR__ . '/testdata/test_service_client_config.json',
            'descriptorsConfigPath' => __DIR__ . '/testdata/test_service_descriptor_config.php',
            'gcpApiConfigPath' => __DIR__ . '/testdata/test_service_grpc_config.json',
            'disableRetries' => false,
            'auth' => null,
            'authConfig' => null,
            'transport' => null,
            'transportConfig' => [
                'rest' => [
                    'restClientConfigPath' => __DIR__ . '/testdata/test_service_rest_client_config.php',
                ]
            ],
        ];
    }
}

trait GapicClientStubTrait
{
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

class StubGapicClientExtension extends StubGapicClient
{
    protected function modifyClientOptions(array &$options)
    {
        $options['disableRetries'] = true;
        $options['addNewOption'] = true;
        $options['apiEndpoint'] = 'abc123';
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

class DefaultScopeAndAudienceGapicClient
{
    use GapicClientTrait {
        buildClientOptions as public;
        startCall as public;
        startOperationsCall as public;
        getPagedListResponse as public;
    }
    use GapicClientStubTrait;

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
}

class RestOnlyGapicClient
{
    use GapicClientTrait {
        buildClientOptions as public;
        getTransport as public;
    }

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
            'descriptorsConfigPath' => __DIR__ . '/testdata/test_service_descriptor_config.php',
            'transportConfig' => [
                'rest' => [
                    'restClientConfigPath' => __DIR__ . '/testdata/test_service_rest_client_config.php',
                ]
            ],
        ];
    }

    private static function supportedTransports()
    {
        return ['rest', 'fake-transport'];
    }

    private static function defaultTransport()
    {
        return 'rest';
    }

    public function getAgentHeader()
    {
        return $this->agentHeader;
    }
}

class OperationsGapicClient extends StubGapicClient
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

class GapicV2SurfaceClient
{
    use GapicClientTrait {
        startCall as public;
    }
    use GapicClientStubTrait;

    public function __construct(array $options = [])
    {
        $clientOptions = $this->buildClientOptions($options);
        $this->setClientOptions($clientOptions);
    }

    public static function getClientDefaults()
    {
        return [
            'apiEndpoint' => 'test.address.com:443',
            'serviceName' => 'test.interface.v1.api',
            'clientConfig' => __DIR__ . '/testdata/test_service_client_config.json',
            'descriptorsConfigPath' => __DIR__ . '/testdata/test_service_descriptor_config.php',
            'transportConfig' => [
                'rest' => [
                    'restClientConfigPath' => __DIR__ . '/testdata/test_service_rest_client_config.php',
                ]
            ],
        ];
    }

    public function getAgentHeader()
    {
        return $this->agentHeader;
    }
}

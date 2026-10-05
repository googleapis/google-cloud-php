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
use Google\ApiCore\ApiKeyHeaderCredentials;
use Google\ApiCore\BidiStream;
use Google\ApiCore\Call;
use Google\ApiCore\ClientStream;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\GapicClientTrait;
use Google\ApiCore\HeaderCredentialsInterface;
use Google\ApiCore\IamProviderInterface;
use Google\ApiCore\InsecureCredentialsWrapper;
use Google\ApiCore\LongRunningOperationProviderInterface;
use Google\ApiCore\Middleware\MiddlewareInterface;
use Google\ApiCore\OperationResponse;
use Google\ApiCore\RequestParamsHeaderDescriptor;
use Google\ApiCore\RetrySettings;
use Google\ApiCore\ServerStream;
use Google\ApiCore\ServiceInterface;
use Google\ApiCore\Testing\MockRequest;
use Google\ApiCore\Testing\MockRequestBody;
use Google\ApiCore\Testing\MockResponse;
use Google\ApiCore\Transport\GrpcFallbackTransport;
use Google\ApiCore\Transport\GrpcTransport;
use Google\ApiCore\Transport\RestTransport;
use Google\ApiCore\Transport\TransportInterface;
use Google\ApiCore\ValidationException;
use Google\Auth\FetchAuthTokenInterface;
use Google\Cloud\Iam\V1\GetIamPolicyRequest;
use Google\Cloud\Iam\V1\Policy;
use Google\Cloud\Iam\V1\SetIamPolicyRequest;
use Google\Cloud\Iam\V1\TestIamPermissionsRequest;
use Google\Cloud\Iam\V1\TestIamPermissionsResponse;
use Google\LongRunning\Client\OperationsClient;
use Google\LongRunning\GetOperationRequest;
use Google\LongRunning\Operation;
use GuzzleHttp\Promise\FulfilledPromise;
use GuzzleHttp\Promise\PromiseInterface;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Psr\Log\LogLevel;

class GapicClientTraitTest extends TestCase
{
    use ProphecyTrait;
    use TestTrait;

    public static function setUpBeforeClass(): void
    {
        self::autoloadTestdata('mocks', 'Google');
    }

    public function setUp(): void
    {
        $keyFilePath = __DIR__ . '/testdata/creds/json-key-file.json';
        putenv('GOOGLE_APPLICATION_CREDENTIALS=' . $keyFilePath);
    }

    public function tearDown(): void
    {
        // Reset the static gapicVersion field between tests
        $client = new StubGapicClient();
        $client->set('gapicVersionFromFile', null, true);
        putenv('GOOGLE_APPLICATION_CREDENTIALS=');
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
        $transport = $this->prophesize(TransportInterface::class);
        $credentialsWrapper = CredentialsWrapper::build();
        $transport->startUnaryCall(
            Argument::type(Call::class),
            [
                'headers' => $expectedHeaders,
                'credentialsWrapper' => $credentialsWrapper,
                'timeoutMillis' => 30000,
                'transportOptions' => [],
                'metadataCallback' => null,
                'middlewareOptions' => null,
            ]
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->prophesize(PromiseInterface::class)->reveal());
        $client = new StubGapicClient();
        $client->set('agentHeader', $header);
        $client->set(
            'retrySettings',
            ['method' => RetrySettings::constructDefault()]
        );
        $client->set('transport', $transport->reveal());
        $client->set('credentialsWrapper', $credentialsWrapper);
        $client->set('descriptors', ['method' => $unaryDescriptors]);
        $client->startApiCall(
            'method',
            $request,
            ['headers' => $headers]
        );
    }

    public function testMiddlewareOptionsIsPreservedByFilterAndVisibleToMiddlewares()
    {
        $unaryDescriptors = [
            'callType' => Call::UNARY_CALL,
            'responseType' => 'decodeType'
        ];
        $request = new MockRequestBody([]);
        $transport = $this->prophesize(TransportInterface::class);

        $middlewareOptions = ['myCustomKey' => 'myCustomValue'];

        $transport->startUnaryCall(
            Argument::type(Call::class),
            Argument::that(function ($options) use ($middlewareOptions) {
                return isset($options['middlewareOptions'])
                    && $options['middlewareOptions'] === $middlewareOptions;
            })
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->prophesize(PromiseInterface::class)->reveal());

        $credentialsWrapper = CredentialsWrapper::build();

        $client = new StubGapicClient();
        $client->set('agentHeader', []);
        $client->set(
            'retrySettings',
            ['method' => RetrySettings::constructDefault()]
        );
        $client->set('transport', $transport->reveal());
        $client->set('credentialsWrapper', $credentialsWrapper);
        $client->set('descriptors', ['method' => $unaryDescriptors]);

        $appendedCalled = false;
        $client->addMiddleware(function (callable $handler) use (&$appendedCalled, $middlewareOptions) {
            return function (Call $call, array $options) use ($handler, &$appendedCalled, $middlewareOptions) {
                $appendedCalled = true;
                $this->assertEquals($middlewareOptions, $options['middlewareOptions'] ?? null);
                return $handler($call, $options);
            };
        });

        $prependedCalled = false;
        $client->prependMiddleware(function (callable $handler) use (&$prependedCalled, $middlewareOptions) {
            return function (Call $call, array $options) use ($handler, &$prependedCalled, $middlewareOptions) {
                $prependedCalled = true;
                $this->assertEquals($middlewareOptions, $options['middlewareOptions'] ?? null);
                return $handler($call, $options);
            };
        });

        $client->startApiCall(
            'method',
            $request,
            ['middlewareOptions' => $middlewareOptions]
        );

        $this->assertTrue($appendedCalled, 'Appended middleware should have been called');
        $this->assertTrue($prependedCalled, 'Prepended middleware should have been called');
    }

    public function testMiddlewareOptionsPreservedByCallOptionsOnNewSurface()
    {
        $middlewareOptions = ["metricsContext" => new \stdClass()];
        $callOptions = new \Google\ApiCore\Options\CallOptions([
            "middlewareOptions" => $middlewareOptions,
        ]);
        $this->assertEquals($middlewareOptions, $callOptions->toArray()["middlewareOptions"] ?? null);

        $unaryDescriptors = [
            "callType" => Call::UNARY_CALL,
            "responseType" => "decodeType"
        ];
        $request = new MockRequestBody([]);
        $transport = $this->prophesize(TransportInterface::class);

        $transport->startUnaryCall(
            Argument::type(Call::class),
            Argument::that(function ($options) use ($middlewareOptions) {
                return isset($options["middlewareOptions"])
                    && $options["middlewareOptions"] === $middlewareOptions;
            })
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->prophesize(PromiseInterface::class)->reveal());

        $credentialsWrapper = CredentialsWrapper::build();

        $client = new StubGapicClient();

        $client->set("agentHeader", []);
        $client->set(
            "retrySettings",
            ["method" => RetrySettings::constructDefault()]
        );
        $client->set("transport", $transport->reveal());
        $client->set("credentialsWrapper", $credentialsWrapper);
        $client->set("descriptors", ["method" => $unaryDescriptors]);

        $middlewareCalled = false;
        $client->addMiddleware(function (callable $handler) use (&$middlewareCalled, $middlewareOptions) {
            return function (Call $call, array $options) use ($handler, &$middlewareCalled, $middlewareOptions) {
                $middlewareCalled = true;
                $this->assertArrayHasKey("middlewareOptions", $options);
                $this->assertEquals($middlewareOptions, $options["middlewareOptions"]);
                return $handler($call, $options);
            };
        });

        $client->startApiCall(
            "method",
            $request,
            ["middlewareOptions" => $middlewareOptions]
        );

        $this->assertTrue($middlewareCalled, "Middleware should have received middlewareOptions on new surface");
    }

    public function testVersionedHeadersOverwriteBehavior()
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
            'new-header' => ['this-should-be-used'],
            'X-Goog-Api-Version' => ['this-should-not-be-used'],
        ];
        $expectedHeaders = [
            'x-goog-api-client' => ['gl-php/5.5.0 gccl/0.0.0 gapic/0.9.0 gax/1.0.0 grpc/1.0.1 rest/1.0.0 pb/6.6.6'],
            'new-header' => ['this-should-be-used'],
            'X-Goog-Api-Version' => ['20240418'],
            'x-goog-request-params' => ['name=foos%2F123%2Fbars%2F456'],
        ];
        $transport = $this->prophesize(TransportInterface::class);
        $credentialsWrapper = CredentialsWrapper::build();
        $transport->startUnaryCall(
            Argument::type(Call::class),
            [
                'headers' => $expectedHeaders,
                'credentialsWrapper' => $credentialsWrapper,
                'timeoutMillis' => 30000,
                'transportOptions' => [],
                'metadataCallback' => null,
                'middlewareOptions' => null,
            ]
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->prophesize(PromiseInterface::class)->reveal());
        $client = new VersionedStubGapicClient();
        $client->set('agentHeader', $header);
        $client->set(
            'retrySettings',
            ['method' => RetrySettings::constructDefault()]
        );
        $client->set('transport', $transport->reveal());
        $client->set('credentialsWrapper', $credentialsWrapper);
        $client->set('descriptors', ['method' => $unaryDescriptors]);
        $client->startApiCall(
            'method',
            $request,
            ['headers' => $headers]
        );
    }

    public function testConfigureCallConstructionOptions()
    {
        $client = new StubGapicClient();
        $client->setClientOptions($client->buildClientOptions([]));
        $retrySettings = RetrySettings::constructDefault();
        $expected = [
            'retrySettings' => $retrySettings,
            'autoPopulationSettings' => [
                'pageToken' => \Google\Api\FieldInfo\Format::UUID4,
            ],
        ];
        $actual = $client->configureCallConstructionOptions('PageStreamingMethod', ['retrySettings' => $retrySettings]);
        $this->assertEquals($expected, $actual);
    }

    public function testConfigureCallConstructionOptionsAcceptsRetryObjectOrArray()
    {
        $defaultRetrySettings = RetrySettings::constructDefault();
        $client = new StubGapicClient();
        $client->set('retrySettings', ['method' => $defaultRetrySettings]);
        $expectedOptions = [
            'retrySettings' => $defaultRetrySettings
                ->with(['rpcTimeoutMultiplier' => 5]),
            'autoPopulationSettings' => []
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
        $retrySettings = RetrySettings::constructDefault();
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
        $transport = $this->prophesize(TransportInterface::class);
        $transport->startUnaryCall(Argument::cetera())
            ->shouldBeCalledOnce()
            ->willReturn($expectedPromise);
        $credentialsWrapper = CredentialsWrapper::build([]);
        $client = new StubGapicClient();
        $client->set('transport', $transport->reveal());
        $client->set('credentialsWrapper', $credentialsWrapper);
        $client->set('agentHeader', $header);
        $client->set('retrySettings', ['method' => $retrySettings]);
        $client->set('descriptors', ['method' => $longRunningDescriptors]);
        $message = new MockRequest();
        $operationsClient = $this->prophesize(OperationsClient::class);

        $response = $client->startOperationsCall(
            'method',
            [],
            $message,
            $operationsClient->reveal()
        )->wait();

        $expectedResponse = new OperationResponse(
            '',
            $operationsClient->reveal(),
            $longRunningDescriptors['longRunning'] + ['lastProtoResponse' => new Operation()]
        );

        $this->assertEquals($expectedResponse, $response);
    }

    public function testStartApiCallOperation()
    {
        $header = AgentHeader::buildAgentHeader([]);
        $retrySettings = RetrySettings::constructDefault();

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
        $transport = $this->prophesize(TransportInterface::class);
        $transport->startUnaryCall(Argument::cetera())
            ->shouldBeCalledOnce()
            ->willReturn($expectedPromise);
        $credentialsWrapper = CredentialsWrapper::build([]);
        $client = new OperationsGapicClient();
        $client->set('transport', $transport->reveal());
        $client->set('credentialsWrapper', $credentialsWrapper);
        $client->set('agentHeader', $header);
        $client->set('retrySettings', ['method' => $retrySettings]);
        $client->set('descriptors', ['method' => $longRunningDescriptors]);
        $operationsClient = $this->prophesize(OperationsClient::class);
        $client->set('operationsClient', $operationsClient->reveal());

        $request = new MockRequest();
        $response = $client->startApiCall(
            'method',
            $request
        )->wait();

        $expectedResponse = new OperationResponse(
            '',
            $operationsClient->reveal(),
            $longRunningDescriptors['longRunning'] + ['lastProtoResponse' => new Operation()]
        );

        $this->assertEquals($expectedResponse, $response);
    }

    public function testStartApiCallCustomOperation()
    {
        $header = AgentHeader::buildAgentHeader([]);
        $retrySettings = RetrySettings::constructDefault();

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
        $transport = $this->prophesize(TransportInterface::class);
        $transport->startUnaryCall(Argument::cetera())
            ->shouldBeCalledOnce()
            ->willReturn($expectedPromise);
        $credentialsWrapper = CredentialsWrapper::build([]);
        $client = new OperationsGapicClient();
        $client->set('transport', $transport->reveal());
        $client->set('credentialsWrapper', $credentialsWrapper);
        $client->set('agentHeader', $header);
        $client->set('retrySettings', ['method' => $retrySettings]);
        $client->set('descriptors', ['method' => $longRunningDescriptors]);
        $operationsClient = $this->prophesize(OperationsClient::class)->reveal();
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
                    'method' => ['callType' => Call::UNARY_CALL]
                ],
                'does not have a responseType'
            ],
            [
                [
                    'method' => ['callType' => Call::PAGINATED_CALL, 'responseType' => 'foo']
                ],
                'does not have a pageStreaming'
            ],
        ];
    }

    public function testStartApiCallUnary()
    {
        $header = AgentHeader::buildAgentHeader([]);
        $retrySettings = RetrySettings::constructDefault();
        $unaryDescriptors = [
            'callType' => Call::UNARY_CALL,
            'responseType' => 'Google\Longrunning\Operation',
            'interfaceOverride' => 'google.cloud.foo.v1.Foo'
        ];
        $expectedPromise = new FulfilledPromise(new Operation());
        $transport = $this->prophesize(TransportInterface::class);
        $transport->startUnaryCall(
            Argument::that(function ($call) use ($unaryDescriptors) {
                return strpos($call->getMethod(), $unaryDescriptors['interfaceOverride']) !== false;
            }),
            Argument::any()
        )
            ->shouldBeCalledOnce()
            ->willReturn($expectedPromise);
        $credentialsWrapper = CredentialsWrapper::build([]);
        $client = new StubGapicClient();
        $client->set('transport', $transport->reveal());
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
        $retrySettings = RetrySettings::constructDefault();
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
        $transport = $this->prophesize(TransportInterface::class);
        $transport->startUnaryCall(Argument::cetera())
            ->shouldBeCalledOnce()
            ->willReturn($expectedPromise);
        $credentialsWrapper = CredentialsWrapper::build([]);
        $client = new StubGapicClient();
        $client->set('transport', $transport->reveal());
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
        $retrySettings = RetrySettings::constructDefault();
        $unaryDescriptors = [
            'callType' => Call::UNARY_CALL,
            'responseType' => 'Google\Longrunning\Operation'
        ];
        $expectedPromise = new FulfilledPromise(new Operation());
        $transport = $this->prophesize(TransportInterface::class);
        $transport->startUnaryCall(Argument::cetera())
            ->shouldBeCalledOnce()
            ->willReturn($expectedPromise);
        $credentialsWrapper = CredentialsWrapper::build([]);
        $client = new StubGapicClient();
        $client->set('transport', $transport->reveal());
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
        $retrySettings = RetrySettings::constructDefault();
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
        $transport = $this->prophesize(TransportInterface::class);
        $transport->startUnaryCall(
            Argument::that(function ($call) use ($pagedDescriptors) {
                return strpos($call->getMethod(), $pagedDescriptors['interfaceOverride']) !== false;
            }),
            Argument::any()
        )
            ->shouldBeCalledOnce()
            ->willReturn($expectedPromise);
        $credentialsWrapper = CredentialsWrapper::build([]);
        $client = new StubGapicClient();
        $client->set('transport', $transport->reveal());
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
                    'Method' => [
                        'callType' => Call::BIDI_STREAMING_CALL,
                        'responseType' => 'Google\Longrunning\Operation'
                    ]
                ],
                'not supported for async execution'
            ],
            [
                [
                    'Method' => [
                        'callType' => Call::RESUMABLE_UPLOAD_CALL,
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
            self::requiresGrpcExtension();
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
                'restClientConfigPath' => __DIR__ . '/testdata/resources/test_service_rest_client_config.php',
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
                'restConfigPath' => __DIR__ . '/testdata/resources/test_service_rest_client_config.php',
            ],
        ];
        return [
            [$apiEndpoint, 'weirdstring', $transportConfig],
            [$apiEndpoint, 'rest', []],
        ];
    }

    public function testAdditionalArgumentMethods()
    {
        $client = new StubGapicClient();

        // Set the LRO descriptors we are testing.
        $longRunningDescriptors = [
            'longRunning' => [
                'getOperationRequest' => \Google\CustomOperation\GetOperationRequest::class,
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
        $operationsClient->getOperation(
            \Google\CustomOperation\GetOperationRequest::build('abc', 100, 'test-123')
        )
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
            'agentHeader' => AgentHeader::buildAgentHeader([]),
            'retrySettings' => $expectedRetrySettings,
        ];
        return [
            [[], $expectedProperties],
            [['disableRetries' => true], ['retrySettings' => $disabledRetrySettings] + $expectedProperties],
        ];
    }

    /**
     * @dataProvider buildClientOptionsRegionalEndpointData
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testBuildClientOptionsRegionalEndpoint(?string $apiEndpoint, ?string $envVarValue, bool $rabEnabled)
    {
        if ($envVarValue !== null) {
            putenv('GOOGLE_AUTH_TRUST_BOUNDARY_ENABLE_EXPERIMENT=' . $envVarValue);
        }

        $client = new class() extends StubGapicClient {
            public array $capturedCredentialsConfig = [];

            public function createCredentialsWrapper(
                string|array|FetchAuthTokenInterface|HeaderCredentialsInterface|null $credentials,
                array $credentialsConfig,
                string $universeDomain
            ): HeaderCredentialsInterface {
                $this->capturedCredentialsConfig = $credentialsConfig;
                return new InsecureCredentialsWrapper();
            }
        };

        $clientOptions = $client->buildClientOptions(
            $apiEndpoint !== null ? ['apiEndpoint' => $apiEndpoint] : []
        );
        $client->setClientOptions($clientOptions);

        $this->assertEquals(
            $rabEnabled,
            $client->capturedCredentialsConfig['enableRegionalAccessBoundary'] ?? null
        );
    }

    public function buildClientOptionsRegionalEndpointData()
    {
        return [
            ['test.googleapis.com', 'true', true],
            ['test.rep.googleapis.com', 'true', false],
            ['test.rep.sandbox.googleapis.com', 'true', false],
            ['test.googleapis.com', 'false', false],
            ['test.googleapis.com', null, false],
            ['', 'true', true], // Empty endpoint case
            [null, 'true', true], // Unset endpoint case
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

    public function testServiceAddressOption()
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
        $retrySettings = RetrySettings::constructDefault();

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
        $transport = $this->prophesize(TransportInterface::class);
        $credentialsWrapper = CredentialsWrapper::build();
        $clientClass = $clientClass ?: StubGapicClientExtension::class;
        $client = new $clientClass();
        $client->set('transport', $transport->reveal());
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
        $transport->startUnaryCall(
            Argument::type(Call::class),
            [
                'transportOptions' => [
                    'custom' => ['addModifyUnaryCallableOption' => true]
                ],
                'headers' => AgentHeader::buildAgentHeader([]),
                'credentialsWrapper' => CredentialsWrapper::build(),
                'timeoutMillis' => 30000,
                'metadataCallback' => null,
                'middlewareOptions' => null,
            ]
        )
            ->shouldBeCalledOnce()
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
        $transport->startUnaryCall(
            Argument::type(Call::class),
            [
                'transportOptions' => [
                    'custom' => ['addModifyUnaryCallableOption' => true]
                ],
                'headers' => AgentHeader::buildAgentHeader([]),
                'credentialsWrapper' => CredentialsWrapper::build(),
                'metadataReturnType' => 'metadataType',
                'timeoutMillis' => 30000,
                'metadataCallback' => null,
                'middlewareOptions' => null,
            ]
        )
            ->shouldBeCalledOnce()
            ->willReturn(new FulfilledPromise(new Operation()));
        $operationsClient = $this->prophesize(OperationsClient::class);

        $client->startOperationsCall(
            'longRunningMethod',
            [],
            new MockRequest(),
            $operationsClient->reveal()
        )->wait();
    }

    public function testModifyUnaryCallFromGetPagedListResponse()
    {
        list($client, $transport) = $this->buildClientToTestModifyCallMethods();
        $transport->startUnaryCall(
            Argument::type(Call::class),
            [
                'transportOptions' => [
                    'custom' => ['addModifyUnaryCallableOption' => true]
                ],
                'headers' => AgentHeader::buildAgentHeader([]),
                'credentialsWrapper' => CredentialsWrapper::build(),
                'timeoutMillis' => 30000,
                'metadataCallback' => null,
                'middlewareOptions' => null,
            ]
        )
            ->shouldBeCalledOnce()
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
        $transport->$expectedMethod(
            Argument::type(Call::class),
            [
                'transportOptions' => [
                    'custom' => ['addModifyStreamingCallable' => true]
                ],
                'headers' => AgentHeader::buildAgentHeader([]),
                'credentialsWrapper' => CredentialsWrapper::build(),
                'timeoutMillis' => 30000,
                'metadataCallback' => null,
                'middlewareOptions' => null,
            ]
        )
            ->shouldBeCalledOnce()
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
                $this->prophesize(BidiStream::class)->reveal()
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
                $this->prophesize(ClientStream::class)->reveal()
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
                $this->prophesize(ServerStream::class)->reveal()
            ],
        ];
    }

    public function testGetTransport()
    {
        $transport = $this->prophesize(TransportInterface::class)->reveal();
        $client = new StubGapicClient();
        $client->set('transport', $transport);
        $this->assertEquals($transport, $client->getTransport());
    }

    public function testGetCredentialsWrapper()
    {
        $credentialsWrapper = $this->prophesize(CredentialsWrapper::class)->reveal();
        $client = new StubGapicClient();
        $client->set('credentialsWrapper', $credentialsWrapper);
        $this->assertEquals($credentialsWrapper, $client->getCredentialsWrapper());
    }

    public function testUserProjectHeaderIsSetWhenProvidingQuotaProject()
    {
        $quotaProject = 'test-quota-project';
        $credentialsWrapper = $this->prophesize(CredentialsWrapper::class);
        $credentialsWrapper->getQuotaProject()
            ->shouldBeCalledOnce()
            ->willReturn($quotaProject);
        $transport = $this->prophesize(TransportInterface::class);
        $transport->startUnaryCall(
            Argument::type(Call::class),
            [
                'headers' => AgentHeader::buildAgentHeader([]) + [
                    'X-Goog-User-Project' => [$quotaProject],
                ],
                'credentialsWrapper' => $credentialsWrapper->reveal(),
                'timeoutMillis' => 30000,
                'transportOptions' => [],
                'metadataCallback' => null,
                'middlewareOptions' => null,
            ]
        )
            ->shouldBeCalledOnce()
            ->willReturn($this->prophesize(PromiseInterface::class)->reveal());
        $client = new StubGapicClient();
        $updatedOptions = $client->buildClientOptions(
            [
                'transport' => $transport->reveal(),
                'credentials' => $credentialsWrapper->reveal(),
            ]
        );
        $client->setClientOptions($updatedOptions);
        $client->set(
            'retrySettings',
            ['method' => RetrySettings::constructDefault()]
        );
        $client->startCall(
            'method',
            'decodeType'
        );
    }

    public function testDefaultAudience()
    {
        $retrySettings = RetrySettings::constructDefault();
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
                    'timeoutMillis' => 30000,
                    'transportOptions' => [],
                    'metadataCallback' => null,
                    'middlewareOptions' => null,
                ]
            )
            ->shouldBeCalledOnce()
            ->willReturn($this->prophesize(PromiseInterface::class)->reveal());

        $client = new DefaultScopeAndAudienceGapicClient();
        $client->set('credentialsWrapper', $credentialsWrapper);
        $client->set('agentHeader', []);
        $client->set(
            'retrySettings',
            ['method.name' => $retrySettings]
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
                    'timeoutMillis' => 30000,
                    'transportOptions' => [],
                    'metadataCallback' => null,
                    'middlewareOptions' => null,
                ]
            )
            ->shouldBeCalledOnce()
            ->willReturn($this->prophesize(PromiseInterface::class)->reveal());

        $client->addMiddleware(function (MiddlewareInterface $handler) {
            return new class ($handler) implements MiddlewareInterface {
                public function __construct(private MiddlewareInterface $handler)
                {
                }
                public function __invoke(Call $call, array $options): PromiseInterface
                {
                    $options['audience'] = 'custom-audience';
                    return ($this->handler)($call, $options);
                }
            };
        });
        $client->startCall('method.name', 'decodeType');
    }

    public function testDefaultAudienceWithOperations()
    {
        $retrySettings = RetrySettings::constructDefault();
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
                    'metadataReturnType' => 'metadataType',
                    'timeoutMillis' => 30000,
                    'transportOptions' => [],
                    'metadataCallback' => null,
                    'middlewareOptions' => null,
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
            ['method.name' => $retrySettings]
        );
        $client->set('transport', $transport->reveal());
        $client->set('descriptors', ['method.name' => $longRunningDescriptors]);
        $operationsClient = $this->prophesize(OperationsClient::class)->reveal();

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
        $retrySettings = RetrySettings::constructDefault();
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
                    'timeoutMillis' => 30000,
                    'transportOptions' => [],
                    'metadataCallback' => null,
                    'middlewareOptions' => null,
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
            ['method.name' => $retrySettings]
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
                public function __invoke(Call $call, array $options): PromiseInterface
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
                public function __invoke(Call $call, array $options): PromiseInterface
                {
                    $this->m2Called = true;
                    return ($this->handler)($call, $options);
                }
            };
        };
        $client->addMiddleware($middleware1);
        $client->addMiddleware($middleware2);

        $transport->startUnaryCall(
            Argument::type(Call::class),
            [
                'transportOptions' => [
                    'custom' => ['addModifyUnaryCallableOption' => true]
                ],
                'headers' => AgentHeader::buildAgentHeader([]),
                'credentialsWrapper' => CredentialsWrapper::build(),
                'timeoutMillis' => 30000,
                'metadataCallback' => null,
                'middlewareOptions' => null,
            ]
        )
            ->shouldBeCalledOnce()
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

    public function testPrependMiddleware()
    {
        list($client, $transport) = $this->buildClientToTestModifyCallMethods();

        $callOrder = [];
        $middleware1 = function (callable $handler) use (&$callOrder) {
            return new class($handler, $callOrder) implements MiddlewareInterface {
                private $handler;
                private array $callOrder;
                public function __construct(
                    callable $handler,
                    array &$callOrder
                ) {
                    $this->handler = $handler;
                    $this->callOrder = &$callOrder;
                }
                public function __invoke(Call $call, array $options): PromiseInterface
                {
                    $this->callOrder[] = 'middleware1';
                    return ($this->handler)($call, $options);
                }
            };
        };
        $middleware2 = function (callable $handler) use (&$callOrder) {
            return new class($handler, $callOrder) implements MiddlewareInterface {
                private $handler;
                private array $callOrder;
                public function __construct(
                    callable $handler,
                    array &$callOrder
                ) {
                    $this->handler = $handler;
                    $this->callOrder = &$callOrder;
                }
                public function __invoke(Call $call, array $options): PromiseInterface
                {
                    $this->callOrder[] = 'middleware2';
                    return ($this->handler)($call, $options);
                }
            };
        };
        $client->addMiddleware($middleware1);
        $client->prependMiddleware($middleware2);

        $transport->startUnaryCall(
            Argument::type(Call::class),
            [
                'transportOptions' => [
                    'custom' => ['addModifyUnaryCallableOption' => true]
                ],
                'headers' => AgentHeader::buildAgentHeader([]),
                'credentialsWrapper' => CredentialsWrapper::build(),
                'timeoutMillis' => 30000,
                'metadataCallback' => null,
                'middlewareOptions' => null,
            ]
        )
            ->shouldBeCalledOnce()
            ->willReturn(new FulfilledPromise(new Operation()));

        $client->startCall(
            'simpleMethod',
            'decodeType',
            [],
            new MockRequest(),
        )->wait();

        $this->assertEquals(['middleware1', 'middleware2'], $callOrder);
    }

    public function testPrependMiddlewareOrder()
    {
        list($client, $transport) = $this->buildClientToTestModifyCallMethods();

        $callOrder = [];
        $middleware1 = function (callable $handler) use (&$callOrder) {
            return new class($handler, $callOrder) implements MiddlewareInterface {
                private $handler;
                private array $callOrder;
                public function __construct(
                    callable $handler,
                    array &$callOrder
                ) {
                    $this->handler = $handler;
                    $this->callOrder = &$callOrder;
                }
                public function __invoke(Call $call, array $options): PromiseInterface
                {
                    $this->callOrder[] = 'middleware1';
                    return ($this->handler)($call, $options);
                }
            };
        };
        $middleware2 = function (callable $handler) use (&$callOrder) {
            return new class($handler, $callOrder) implements MiddlewareInterface {
                private $handler;
                private array $callOrder;
                public function __construct(
                    callable $handler,
                    array &$callOrder
                ) {
                    $this->handler = $handler;
                    $this->callOrder = &$callOrder;
                }
                public function __invoke(Call $call, array $options): PromiseInterface
                {
                    $this->callOrder[] = 'middleware2';
                    return ($this->handler)($call, $options);
                }
            };
        };

        $client->prependMiddleware($middleware1);
        $client->prependMiddleware($middleware2);

        $transport->startUnaryCall(
            Argument::type(Call::class),
            [
                'transportOptions' => [
                    'custom' => ['addModifyUnaryCallableOption' => true]
                ],
                'headers' => AgentHeader::buildAgentHeader([]),
                'credentialsWrapper' => CredentialsWrapper::build(),
                'timeoutMillis' => 30000,
                'metadataCallback' => null,
                'middlewareOptions' => null,
            ]
        )
           ->shouldBeCalledOnce()
           ->willReturn(new FulfilledPromise(new Operation()));

        $client->startCall(
            'simpleMethod',
            'decodeType',
            [],
            new MockRequest(),
        )->wait();

        $this->assertEquals(['middleware2', 'middleware1'], $callOrder);
    }

    public function testInvalidClientOptionsTypeThrowsException()
    {
        $this->expectException(\TypeError::class);
        $this->expectExceptionMessage(
            PHP_MAJOR_VERSION < 8
                ? 'Argument 1 passed to Google\ApiCore\Options\ClientOptions::setApiEndpoint() '
                    . 'must be of the type string or null, array given'
                : 'Google\ApiCore\Options\ClientOptions::setApiEndpoint(): Argument #1 '
                    . '($apiEndpoint) must be of type ?string, array given'
        );

        new GapicV2SurfaceClient(['apiEndpoint' => ['foo']]);
    }

    public function testCallOptionsForV2Surface()
    {
        list($client, $transport) = $this->buildClientToTestModifyCallMethods(
            GapicV2SurfaceClient::class
        );

        $transport->startUnaryCall(
            Argument::type(Call::class),
            [
                'headers' => AgentHeader::buildAgentHeader([]) + ['Foo' => 'Bar'],
                'credentialsWrapper' => CredentialsWrapper::build(),
                'timeoutMillis' => 30000, // adds null timeoutMillis,
                'transportOptions' => [],
                'metadataCallback' => null,
                'middlewareOptions' => null,
            ]
        )

            ->shouldBeCalledOnce()
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

    public function testApiKeyOption()
    {
        $transport = $this->prophesize(TransportInterface::class);
        $transport->startUnaryCall(
            Argument::type(Call::class),
            Argument::that(function ($options) {
                // assert API key
                $this->assertArrayHasKey('credentialsWrapper', $options);
                $headers = $options['credentialsWrapper']->getAuthorizationHeaderCallback()();
                $this->assertArrayHasKey('x-goog-api-key', $headers);
                $this->assertEquals(['abc-123'], $headers['x-goog-api-key']);

                return true;
            })
        )
            ->shouldBeCalledOnce()
            ->willReturn(new FulfilledPromise(new MockResponse()));

        $client = new GapicV2SurfaceClient([
            'transport' => $transport->reveal(),
            'apiKey' => 'abc-123',
        ]);

        $response = $client->startCall('SimpleMethod', 'decodeType');
    }

    public function testApiKeyOptionThrowsExceptionWhenCredentialsAreSupplied()
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage(
            'API Keys and Credentials are mutually exclusive authentication methods and cannot be used together.'
        );

        $credentials = $this->prophesize(FetchAuthTokenInterface::class);
        $client = new GapicV2SurfaceClient([
            'apiKey' => 'abc-123',
            'credentials' => $credentials->reveal(),
        ]);
    }

    public function testKeyFileIsIgnoredWhenApiKeyOptionIsSupplied()
    {
        $credentials = $this->prophesize(FetchAuthTokenInterface::class);
        $client = new GapicV2SurfaceClient([
            'apiKey' => 'abc-123',
            'credentialsConfig' => [
                'keyFile' => __DIR__ . '/testdata/creds/json-key-file.json',
            ],
        ]);

        $prop = new \ReflectionProperty($client, 'credentialsWrapper');
        $this->assertInstanceOf(ApiKeyHeaderCredentials::class, $prop->getValue($client));
    }

    public function testApiKeyOptionAndQuotaProject()
    {
        $transport = $this->prophesize(TransportInterface::class);
        $transport->startUnaryCall(
            Argument::type(Call::class),
            Argument::that(function ($options) {
                // assert API key
                $this->assertArrayHasKey('credentialsWrapper', $options);
                $headers = $options['credentialsWrapper']->getAuthorizationHeaderCallback()();
                $this->assertArrayHasKey('x-goog-api-key', $headers);
                $this->assertEquals(['abc-123'], $headers['x-goog-api-key']);

                // assert quota project
                $this->assertArrayHasKey('headers', $options);
                $this->assertArrayHasKey('X-Goog-User-Project', $options['headers']);
                $this->assertEquals(['def-456'], $options['headers']['X-Goog-User-Project']);

                return true;
            })
        )
            ->shouldBeCalledOnce()
            ->willReturn(new FulfilledPromise(new MockResponse()));

        $client = new GapicV2SurfaceClient([
            'transport' => $transport->reveal(),
            'apiKey' => 'abc-123',
            'credentialsConfig' => ['quotaProject' => 'def-456']
        ]);

        $response = $client->startCall('SimpleMethod', 'decodeType');
    }

    public function testHasEmulatorOption()
    {
        $mockTransport = $this->prophesize(TransportInterface::class)->reveal();
        $gapic = new class($mockTransport) {
            public bool $hasEmulator;
            private TransportInterface $mockTransport;

            public function __construct(TransportInterface $mockTransport)
            {
                $this->mockTransport = $mockTransport;
            }

            use GapicClientTrait {
                buildClientOptions as public;
                setClientOptions as public;
                getCredentialsWrapper as public;
            }
            use ClientDefaultsTrait {
                ClientDefaultsTrait::getClientDefaults insteadof GapicClientTrait;
            }

            private function createTransport(
                string $apiEndpoint,
                string|TransportInterface $transport,
                $transportConfig,
                ?callable $clientCertSource = null,
                bool $hasEmulator = false
            ): TransportInterface {
                $this->hasEmulator = $hasEmulator;
                return $this->mockTransport;
            }
        };

        $options = $gapic->buildClientOptions(['hasEmulator' => true]);
        $gapic->setClientOptions($options);

        $this->assertTrue($gapic->hasEmulator);
        $this->assertInstanceOf(
            \Google\ApiCore\InsecureCredentialsWrapper::class,
            $gapic->getCredentialsWrapper()
        );
    }

    public function testGetServiceScopes()
    {
        $this->assertEquals(
            ['default-scope-1', 'default-scope-2'],
            DefaultScopeAndAudienceGapicClient::getServiceScopes()
        );
    }

    public function testCreateOperationsClientDefaultClass()
    {
        $client = new StubGapicClient();
        $this->assertInstanceOf(
            OperationsClient::class,
            $client->createOperationsClient([])
        );
    }

    public function testServiceInterface()
    {
        $transport = $this->prophesize(TransportInterface::class);
        $transport->close()->shouldBeCalledOnce();

        $client = new GapicV2SurfaceClient([
            'transport' => $transport->reveal(),
        ]);

        $this->assertInstanceOf(ServiceInterface::class, $client);
        $this->assertEquals([], GapicV2SurfaceClient::getServiceScopes());
        $client->close();
    }

    public function testLongRunningOperationProviderInterface()
    {
        $operationsClient = $this->prophesize(OperationsClient::class);
        $operationsClient->getOperation(
            Argument::that(fn (GetOperationRequest $req) => $req->getName() === 'operations/test-op')
        )
            ->shouldBeCalledOnce()
            ->willReturn(new Operation(['name' => 'operations/test-op', 'done' => true]));

        $client = new GapicV2SurfaceClient([
            'operationsClient' => $operationsClient->reveal(),
        ]);

        $this->assertInstanceOf(LongRunningOperationProviderInterface::class, $client);
        $this->assertSame($operationsClient->reveal(), $client->getOperationsClient());

        $operation = $client->resumeOperation('operations/test-op');
        $this->assertInstanceOf(OperationResponse::class, $operation);
        $this->assertEquals('operations/test-op', $operation->getName());
        $this->assertTrue($operation->isDone());
    }

    public function testIamProviderInterface()
    {
        $policy = new Policy();
        $permissionsResponse = new TestIamPermissionsResponse();

        $transport = $this->prophesize(TransportInterface::class);
        $transport->startUnaryCall(
            Argument::that(fn (Call $call) => $call->getMethod() === 'test.interface.v1.api/GetIamPolicy'),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn(new FulfilledPromise($policy));
        $transport->startUnaryCall(
            Argument::that(fn (Call $call) => $call->getMethod() === 'test.interface.v1.api/SetIamPolicy'),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn(new FulfilledPromise($policy));
        $transport->startUnaryCall(
            Argument::that(fn (Call $call) => $call->getMethod() === 'test.interface.v1.api/TestIamPermissions'),
            Argument::type('array')
        )
            ->shouldBeCalledOnce()
            ->willReturn(new FulfilledPromise($permissionsResponse));

        $client = new GapicV2SurfaceClient([
            'transport' => $transport->reveal(),
        ]);
        $client->set('descriptors', [
            'GetIamPolicy' => [
                'callType' => Call::UNARY_CALL,
                'responseType' => Policy::class,
            ],
            'SetIamPolicy' => [
                'callType' => Call::UNARY_CALL,
                'responseType' => Policy::class,
            ],
            'TestIamPermissions' => [
                'callType' => Call::UNARY_CALL,
                'responseType' => TestIamPermissionsResponse::class,
            ],
        ]);
        $retrySettings = RetrySettings::constructDefault();
        $client->set('retrySettings', [
            'GetIamPolicy' => $retrySettings,
            'SetIamPolicy' => $retrySettings,
            'TestIamPermissions' => $retrySettings,
        ]);

        $this->assertInstanceOf(IamProviderInterface::class, $client);
        $this->assertSame($policy, $client->getIamPolicy(new GetIamPolicyRequest()));
        $this->assertSame($policy, $client->setIamPolicy(new SetIamPolicyRequest()));
        $this->assertSame($permissionsResponse, $client->testIamPermissions(new TestIamPermissionsRequest()));
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
    use ClientDefaultsTrait {
        ClientDefaultsTrait::getClientDefaults insteadof GapicClientTrait;
    }
}

trait ClientDefaultsTrait
{
    public static function getClientDefaults()
    {
        return [
            'apiEndpoint' => 'test.address.com:443',
            'serviceName' => 'test.interface.v1.api',
            'clientConfig' => __DIR__ . '/testdata/resources/test_service_client_config.json',
            'descriptorsConfigPath' => __DIR__ . '/testdata/resources/test_service_descriptor_config.php',
            'disableRetries' => false,
            'auth' => null,
            'authConfig' => null,
            'transport' => null,
            'transportConfig' => [
                'rest' => [
                    'restClientConfigPath' => __DIR__ . '/testdata/resources/test_service_rest_client_config.php',
                ]
            ],
        ];
    }
}

class VersionedStubGapicClient extends StubGapicClient
{
    // The API version will come from the client library who uses the GapicClientTrait
    // so in that one it will be private vs Protected. In this case I used protected so
    // the parent class can see it.
    protected $apiVersion = '20240418';
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
    use ClientDefaultsTrait {
        ClientDefaultsTrait::getClientDefaults insteadof GapicClientTrait;
    }
    public function __construct($options = [])
    {
        $options['apiEndpoint'] = 'api.example.com';
        $this->setClientOptions($this->buildClientOptions($options));
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
    public function getOperation($request)
    {
    }
}

class GapicV2SurfaceClient implements ServiceInterface, LongRunningOperationProviderInterface, IamProviderInterface
{
    use GapicClientTrait {
        startCall as public;
    }
    use GapicClientStubTrait;
    use ClientDefaultsTrait {
        ClientDefaultsTrait::getClientDefaults insteadof GapicClientTrait;
    }

    public static array $serviceScopes = [];
    private OperationsClient $operationsClient;

    public function __construct(array $options = [])
    {
        $clientOptions = $this->buildClientOptions($options);
        $this->setClientOptions($clientOptions);
        $this->operationsClient = $this->createOperationsClient($clientOptions);
    }

    public function getAgentHeader()
    {
        return $this->agentHeader;
    }

    public function getOperationsClient(): OperationsClient
    {
        return $this->operationsClient;
    }

    public function resumeOperation(string $operationName, ?string $methodName = null): OperationResponse
    {
        $options = $this->descriptors[$methodName]['longRunning'] ?? [];
        $operation = new OperationResponse($operationName, $this->getOperationsClient(), $options);
        $operation->reload();
        return $operation;
    }

    public function getIamPolicy(GetIamPolicyRequest $request, array $callOptions = []): Policy
    {
        return $this->startApiCall('GetIamPolicy', $request, $callOptions)->wait();
    }

    public function setIamPolicy(SetIamPolicyRequest $request, array $callOptions = []): Policy
    {
        return $this->startApiCall('SetIamPolicy', $request, $callOptions)->wait();
    }

    public function testIamPermissions(
        TestIamPermissionsRequest $request,
        array $callOptions = []
    ): TestIamPermissionsResponse {
        return $this->startApiCall('TestIamPermissions', $request, $callOptions)->wait();
    }
}

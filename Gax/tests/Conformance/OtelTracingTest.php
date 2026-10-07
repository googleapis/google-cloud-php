<?php
/*
 * Copyright 2026 Google LLC
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     https://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */
declare(strict_types=1);

namespace Google\Generator\Tests\Conformance;

use Google\ApiCore\ApiException;
use Google\ApiCore\ApiStatus;
use Google\ApiCore\InsecureCredentialsWrapper;
use Google\ApiCore\InsecureRequestBuilder;
use Google\ApiCore\RequestBuilder;
use Google\ApiCore\RetrySettings;
use Google\ApiCore\Telemetry\SpanAttributes;
use Google\ApiCore\Transport\GrpcTransport;
use Google\ApiCore\Transport\RestTransport;
use Google\ApiCore\Transport\TransportInterface;
use Google\Auth\HttpHandler\HttpHandlerFactory;
use Google\Protobuf\Any;
use Google\Rpc\Code;
use Google\Rpc\ErrorInfo;
use Google\Rpc\Status;
use Google\Showcase\V1beta1\AttemptSequenceRequest;
use Google\Showcase\V1beta1\Client\EchoClient;
use Google\Showcase\V1beta1\Client\IdentityClient;
use Google\Showcase\V1beta1\Client\SequenceServiceClient;
use Google\Showcase\V1beta1\CreateSequenceRequest;
use Google\Showcase\V1beta1\EchoRequest;
use Google\Showcase\V1beta1\FailEchoWithDetailsRequest;
use Google\Showcase\V1beta1\GetUserRequest;
use Google\Showcase\V1beta1\Sequence;
use Google\Showcase\V1beta1\Sequence\Response;
use Grpc\ChannelCredentials;
use GuzzleHttp\Client;
use OpenTelemetry\API\Trace\SpanKind;
use OpenTelemetry\API\Trace\StatusCode;
use OpenTelemetry\API\Trace\TracerProviderInterface;
use OpenTelemetry\SDK\Trace\SpanDataInterface;
use OpenTelemetry\SDK\Trace\SpanExporter\InMemoryExporter;
use OpenTelemetry\SDK\Trace\SpanProcessor\SimpleSpanProcessor;
use OpenTelemetry\SDK\Trace\TracerProvider;
use PHPUnit\Framework\TestCase;

final class OtelTracingTest extends TestCase
{
    private const HOST = 'localhost:7469';
    private const SERVER_ADDRESS = 'localhost';
    private const SERVER_PORT = 7469;
    private const PEM_PATH = __DIR__ . '/showcase.pem';

    private const ECHO_REST_CONFIG = __DIR__ . '/src/V1beta1/resources/echo_rest_client_config.php';
    private const IDENTITY_REST_CONFIG = __DIR__ . '/src/V1beta1/resources/identity_rest_client_config.php';
    private const SEQUENCE_REST_CONFIG = __DIR__ . '/src/V1beta1/resources/sequence_service_rest_client_config.php';

    private InMemoryExporter $exporter;
    private TracerProvider $tracerProvider;

    protected function setUp(): void
    {
        parent::setUp();
        $this->exporter = new InMemoryExporter();
        $this->tracerProvider = new TracerProvider(new SimpleSpanProcessor($this->exporter));
    }

    protected function tearDown(): void
    {
        $this->tracerProvider->shutdown();
        parent::tearDown();
    }

    public function provideTransportType(): array
    {
        return [
            'grpc' => ['grpc'],
            'rest' => ['rest'],
        ];
    }

    /**
     * @dataProvider provideTransportType
     */
    public function testTracingDisabledEmitsOnlyAppSpan(string $transportType): void
    {
        $transport = $this->buildTransport($transportType, self::ECHO_REST_CONFIG, null);
        $echoClient = new EchoClient([
            // @TODO: Remove apiEndpoint once https://github.com/googleapis/gapic-generator-php/pull/889 is merged
            // and the Showcase client is regenerated.
            'apiEndpoint' => self::HOST,
            'credentials' => new InsecureCredentialsWrapper(),
            'transport' => $transport,
        ]);

        $appSpan = $this->tracerProvider->getTracer('test-app')->spanBuilder('app-operation')->startSpan();
        $appScope = $appSpan->activate();

        try {
            $response = $echoClient->echo(new EchoRequest(['content' => 'trace disabled']));
            $this->assertSame('trace disabled', $response->getContent());
        } finally {
            $appScope->detach();
            $appSpan->end();
            $echoClient->close();
        }

        $spans = $this->exporter->getSpans();
        $this->assertCount(1, $spans);
        $this->assertSame('app-operation', $spans[0]->getName());
    }

    /**
     * @dataProvider provideTransportType
     */
    public function testTracingSuccessfulEcho(string $transportType): void
    {
        $transport = $this->buildTransport($transportType, self::ECHO_REST_CONFIG, $this->tracerProvider);
        $echoClient = new EchoClient([
            // @TODO: Remove apiEndpoint once https://github.com/googleapis/gapic-generator-php/pull/889 is merged
            // and the Showcase client is regenerated.
            'apiEndpoint' => self::HOST,
            'credentials' => new InsecureCredentialsWrapper(),
            'transport' => $transport,
            'openTelemetryTracerProvider' => $this->tracerProvider,
        ]);

        $appSpan = $this->tracerProvider->getTracer('test-app')->spanBuilder('app-operation')->startSpan();
        $appScope = $appSpan->activate();

        try {
            $response = $echoClient->echo(new EchoRequest(['content' => 'hello tracing']));
            $this->assertSame('hello tracing', $response->getContent());
        } finally {
            $appScope->detach();
            $appSpan->end();
            $echoClient->close();
        }

        /** @var SpanDataInterface[] $spans */
        $spans = $this->exporter->getSpans();
        $expectedMethod = 'google.showcase.v1beta1.Echo/Echo';

        if ($transportType === 'grpc') {
            $this->assertCount(3, $spans);
            $t4Span = $spans[0];
            $t3Span = $spans[1];
            $exportedAppSpan = $spans[2];

            $this->assertSame($t3Span->getSpanId(), $t4Span->getParentSpanId());
            $this->assertSame(SpanKind::KIND_CLIENT, $t4Span->getKind());
            $this->assertSame($expectedMethod, $t4Span->getName());
            $this->assertSame(StatusCode::STATUS_OK, $t4Span->getStatus()->getCode());
            $this->assertSame('google-cloud-php', $t4Span->getInstrumentationScope()->getName());

            $t4Attrs = $t4Span->getAttributes()->toArray();
            $this->assertSame('grpc', $t4Attrs[SpanAttributes::RPC_SYSTEM_NAME]);
            $this->assertSame($expectedMethod, $t4Attrs[SpanAttributes::RPC_METHOD]);
            $this->assertSame('OK', $t4Attrs[SpanAttributes::RPC_RESPONSE_STATUS_CODE]);
            $this->assertSame(self::SERVER_ADDRESS, $t4Attrs[SpanAttributes::SERVER_ADDRESS]);
            $this->assertSame(self::SERVER_PORT, $t4Attrs[SpanAttributes::SERVER_PORT]);
            $this->assertArrayNotHasKey(SpanAttributes::ERROR_TYPE, $t4Attrs);
            $this->assertArrayNotHasKey(SpanAttributes::STATUS_MESSAGE, $t4Attrs);
            $this->assertArrayNotHasKey(SpanAttributes::EXCEPTION_TYPE, $t4Attrs);
        } else {
            $this->assertCount(2, $spans);
            $t3Span = $spans[0];
            $exportedAppSpan = $spans[1];
        }

        $this->assertSame($exportedAppSpan->getSpanId(), $t3Span->getParentSpanId());
        $this->assertSame(SpanKind::KIND_INTERNAL, $t3Span->getKind());
        $this->assertSame($expectedMethod, $t3Span->getName());
        $this->assertSame(StatusCode::STATUS_OK, $t3Span->getStatus()->getCode());
        $this->assertSame('google-cloud-php', $t3Span->getInstrumentationScope()->getName());

        $t3Attrs = $t3Span->getAttributes()->toArray();
        $this->assertSame($transportType === 'grpc' ? 'grpc' : 'http', $t3Attrs[SpanAttributes::RPC_SYSTEM_NAME]);
        $this->assertSame($expectedMethod, $t3Attrs[SpanAttributes::RPC_METHOD]);
        $this->assertSame(self::SERVER_ADDRESS, $t3Attrs[SpanAttributes::SERVER_ADDRESS]);
        $this->assertSame(self::SERVER_PORT, $t3Attrs[SpanAttributes::SERVER_PORT]);
        $this->assertArrayNotHasKey(SpanAttributes::ERROR_TYPE, $t3Attrs);
        $this->assertArrayNotHasKey(SpanAttributes::STATUS_MESSAGE, $t3Attrs);
        $this->assertArrayNotHasKey(SpanAttributes::EXCEPTION_TYPE, $t3Attrs);
    }

    /**
     * @dataProvider provideTransportType
     */
    public function testTracingIdentityGetUserFailure(string $transportType): void
    {
        $transport = $this->buildTransport($transportType, self::IDENTITY_REST_CONFIG, $this->tracerProvider);
        $identityClient = new IdentityClient([
            // @TODO: Remove apiEndpoint once https://github.com/googleapis/gapic-generator-php/pull/889 is merged
            // and the Showcase client is regenerated.
            'apiEndpoint' => self::HOST,
            'credentials' => new InsecureCredentialsWrapper(),
            'transport' => $transport,
            'openTelemetryTracerProvider' => $this->tracerProvider,
        ]);

        try {
            $request = new GetUserRequest([
                'name' => IdentityClient::userName('nonexistent-user'),
            ]);
            try {
                $identityClient->getUser($request);
                $this->fail('Expected ApiException for nonexistent user');
            } catch (ApiException $e) {
                $this->assertSame('NOT_FOUND', $e->getStatus());
            }
        } finally {
            $identityClient->close();
        }

        /** @var SpanDataInterface[] $spans */
        $spans = $this->exporter->getSpans();
        $expectedMethod = 'google.showcase.v1beta1.Identity/GetUser';

        if ($transportType === 'grpc') {
            $this->assertCount(2, $spans);
            $t4Span = $spans[0];
            $t3Span = $spans[1];

            $this->assertSame($t3Span->getSpanId(), $t4Span->getParentSpanId());
            $this->assertSame(SpanKind::KIND_CLIENT, $t4Span->getKind());
            $this->assertSame($expectedMethod, $t4Span->getName());
            $this->assertSame(StatusCode::STATUS_ERROR, $t4Span->getStatus()->getCode());
            $this->assertSame('NOT_FOUND', $t4Span->getAttributes()->get(SpanAttributes::RPC_RESPONSE_STATUS_CODE));
            $this->assertSame('NOT_FOUND', $t4Span->getAttributes()->get(SpanAttributes::ERROR_TYPE));
            $this->assertSame(ApiException::class, $t4Span->getAttributes()->get(SpanAttributes::EXCEPTION_TYPE));
        } else {
            $this->assertCount(1, $spans);
            $t3Span = $spans[0];
        }

        $this->assertSame(SpanKind::KIND_INTERNAL, $t3Span->getKind());
        $this->assertSame($expectedMethod, $t3Span->getName());
        $this->assertSame(StatusCode::STATUS_ERROR, $t3Span->getStatus()->getCode());
        $this->assertSame('NOT_FOUND', $t3Span->getAttributes()->get(SpanAttributes::ERROR_TYPE));
        $this->assertSame(ApiException::class, $t3Span->getAttributes()->get(SpanAttributes::EXCEPTION_TYPE));
        $this->assertNotEmpty($t3Span->getAttributes()->get(SpanAttributes::STATUS_MESSAGE));
        $this->assertSame(self::SERVER_ADDRESS, $t3Span->getAttributes()->get(SpanAttributes::SERVER_ADDRESS));
        $this->assertSame(self::SERVER_PORT, $t3Span->getAttributes()->get(SpanAttributes::SERVER_PORT));
    }

    /**
     * @dataProvider provideTransportType
     */
    public function testTracingRetrySucceedsWithSequenceService(string $transportType): void
    {
        $transport = $this->buildTransport($transportType, self::SEQUENCE_REST_CONFIG, $this->tracerProvider);
        $sequenceClient = new SequenceServiceClient([
            // @TODO: Remove apiEndpoint once https://github.com/googleapis/gapic-generator-php/pull/889 is merged
            // and the Showcase client is regenerated.
            'apiEndpoint' => self::HOST,
            'credentials' => new InsecureCredentialsWrapper(),
            'transport' => $transport,
            'openTelemetryTracerProvider' => $this->tracerProvider,
        ]);

        try {
            $sequence = new Sequence([
                'responses' => [
                    new Response([
                        'status' => new Status([
                            'code' => Code::UNAVAILABLE,
                            'message' => 'Temporary failure on attempt 1',
                        ]),
                    ]),
                    new Response([
                        'status' => new Status([
                            'code' => Code::OK,
                        ]),
                    ]),
                ],
            ]);

            $createdSequence = $sequenceClient->createSequence(
                new CreateSequenceRequest(['sequence' => $sequence])
            );
            $this->exporter->getStorage()->exchangeArray([]);

            $appSpan = $this->tracerProvider->getTracer('test-app')->spanBuilder('app-operation')->startSpan();
            $appScope = $appSpan->activate();

            try {
                $sequenceClient->attemptSequence(
                    new AttemptSequenceRequest(['name' => $createdSequence->getName()])
                );
            } finally {
                $appScope->detach();
                $appSpan->end();
            }
        } finally {
            $sequenceClient->close();
        }

        /** @var SpanDataInterface[] $spans */
        $spans = $this->exporter->getSpans();
        $expectedMethod = 'google.showcase.v1beta1.SequenceService/AttemptSequence';

        if ($transportType === 'grpc') {
            $this->assertCount(4, $spans);
            $t4Attempt1 = $spans[0];
            $t4Attempt2 = $spans[1];
            $t3Span = $spans[2];
            $exportedAppSpan = $spans[3];

            $this->assertSame($exportedAppSpan->getSpanId(), $t3Span->getParentSpanId());
            $this->assertSame($t3Span->getSpanId(), $t4Attempt1->getParentSpanId());
            $this->assertSame($t3Span->getSpanId(), $t4Attempt2->getParentSpanId());

            $this->assertSame(SpanKind::KIND_CLIENT, $t4Attempt1->getKind());
            $this->assertSame($expectedMethod, $t4Attempt1->getName());
            $this->assertSame(StatusCode::STATUS_ERROR, $t4Attempt1->getStatus()->getCode());
            $this->assertSame(
                'UNAVAILABLE',
                $t4Attempt1->getAttributes()->get(SpanAttributes::RPC_RESPONSE_STATUS_CODE)
            );
            $this->assertSame('UNAVAILABLE', $t4Attempt1->getAttributes()->get(SpanAttributes::ERROR_TYPE));

            $this->assertSame(SpanKind::KIND_CLIENT, $t4Attempt2->getKind());
            $this->assertSame($expectedMethod, $t4Attempt2->getName());
            $this->assertSame(StatusCode::STATUS_OK, $t4Attempt2->getStatus()->getCode());
            $this->assertSame('OK', $t4Attempt2->getAttributes()->get(SpanAttributes::RPC_RESPONSE_STATUS_CODE));
            $this->assertNull($t4Attempt2->getAttributes()->get(SpanAttributes::ERROR_TYPE));
        } else {
            $this->assertCount(2, $spans);
            $t3Span = $spans[0];
            $exportedAppSpan = $spans[1];
            $this->assertSame($exportedAppSpan->getSpanId(), $t3Span->getParentSpanId());
        }

        $this->assertSame(SpanKind::KIND_INTERNAL, $t3Span->getKind());
        $this->assertSame($expectedMethod, $t3Span->getName());
        $this->assertSame(StatusCode::STATUS_OK, $t3Span->getStatus()->getCode());
        $this->assertNull($t3Span->getAttributes()->get(SpanAttributes::ERROR_TYPE));
        $this->assertNull($t3Span->getAttributes()->get(SpanAttributes::STATUS_MESSAGE));
        $this->assertNull($t3Span->getAttributes()->get(SpanAttributes::EXCEPTION_TYPE));
    }

    /**
     * @dataProvider provideTransportType
     */
    public function testTracingRetriesExhausted(string $transportType): void
    {
        $transport = $this->buildTransport($transportType, self::ECHO_REST_CONFIG, $this->tracerProvider);
        $echoClient = new EchoClient([
            // @TODO: Remove apiEndpoint once https://github.com/googleapis/gapic-generator-php/pull/889 is merged
            // and the Showcase client is regenerated.
            'apiEndpoint' => self::HOST,
            'credentials' => new InsecureCredentialsWrapper(),
            'transport' => $transport,
            'openTelemetryTracerProvider' => $this->tracerProvider,
        ]);

        $retrySettings = RetrySettings::constructDefault()
            ->with([
                'retriesEnabled' => true,
                'retryableCodes' => [ApiStatus::UNAVAILABLE],
                'maxRetries' => 4,
                'initialRetryDelayMillis' => 10,
                'maxRetryDelayMillis' => 50,
            ]);

        $appSpan = $this->tracerProvider->getTracer('test-app')->spanBuilder('app-operation')->startSpan();
        $appScope = $appSpan->activate();

        try {
            $request = new EchoRequest([
                'error' => new Status([
                    'code' => Code::UNAVAILABLE,
                    'message' => 'Test error',
                ]),
            ]);

            try {
                $echoClient->echo($request, ['retrySettings' => $retrySettings]);
                $this->fail('Expected ApiException after exhausting retries');
            } catch (ApiException $e) {
                $this->assertSame('UNAVAILABLE', $e->getStatus());
            }
        } finally {
            $appScope->detach();
            $appSpan->end();
            $echoClient->close();
        }

        /** @var SpanDataInterface[] $spans */
        $spans = $this->exporter->getSpans();
        $expectedMethod = 'google.showcase.v1beta1.Echo/Echo';

        if ($transportType === 'grpc') {
            // 5 T4 attempt spans (1 initial + 4 retries) + 1 T3 span + 1 APP span = 7 spans
            $this->assertCount(7, $spans);
            $t3Span = $spans[5];
            $exportedAppSpan = $spans[6];

            $this->assertSame($exportedAppSpan->getSpanId(), $t3Span->getParentSpanId());
            for ($i = 0; $i < 5; $i++) {
                $t4Span = $spans[$i];
                $this->assertSame($t3Span->getSpanId(), $t4Span->getParentSpanId());
                $this->assertSame(SpanKind::KIND_CLIENT, $t4Span->getKind());
                $this->assertSame($expectedMethod, $t4Span->getName());
                $this->assertSame(StatusCode::STATUS_ERROR, $t4Span->getStatus()->getCode());
                $this->assertSame(
                    'UNAVAILABLE',
                    $t4Span->getAttributes()->get(SpanAttributes::RPC_RESPONSE_STATUS_CODE)
                );
                $this->assertSame('UNAVAILABLE', $t4Span->getAttributes()->get(SpanAttributes::ERROR_TYPE));
                $this->assertSame('Test error', $t4Span->getAttributes()->get(SpanAttributes::STATUS_MESSAGE));
            }
        } else {
            $this->assertCount(2, $spans);
            $t3Span = $spans[0];
            $exportedAppSpan = $spans[1];
            $this->assertSame($exportedAppSpan->getSpanId(), $t3Span->getParentSpanId());
        }

        $this->assertSame(SpanKind::KIND_INTERNAL, $t3Span->getKind());
        $this->assertSame($expectedMethod, $t3Span->getName());
        $this->assertSame(StatusCode::STATUS_ERROR, $t3Span->getStatus()->getCode());
        $this->assertSame('UNAVAILABLE', $t3Span->getAttributes()->get(SpanAttributes::ERROR_TYPE));
        $this->assertSame('Test error', $t3Span->getAttributes()->get(SpanAttributes::STATUS_MESSAGE));
        $this->assertSame(ApiException::class, $t3Span->getAttributes()->get(SpanAttributes::EXCEPTION_TYPE));
    }

    /**
     * @dataProvider provideTransportType
     */
    public function testTracingErrorInfoReasonAndStatusCodes(string $transportType): void
    {
        $transport = $this->buildTransport($transportType, self::ECHO_REST_CONFIG, $this->tracerProvider);
        $echoClient = new EchoClient([
            // @TODO: Remove apiEndpoint once https://github.com/googleapis/gapic-generator-php/pull/889 is merged
            // and the Showcase client is regenerated.
            'apiEndpoint' => self::HOST,
            'credentials' => new InsecureCredentialsWrapper(),
            'transport' => $transport,
            'openTelemetryTracerProvider' => $this->tracerProvider,
        ]);

        try {
            // 1. Successful Echo (OK)
            $echoClient->echo(new EchoRequest(['content' => 'success']));

            // 2. Echo with ErrorInfo detail (verifies ErrorInfo reason is used for error.type)
            $errorInfo = new ErrorInfo([
                'reason' => 'CUSTOM_SHOWCASE_ERROR_REASON',
                'domain' => 'showcase.googleapis.com',
                'metadata' => ['key' => 'value'],
            ]);
            $anyDetail = new Any();
            $anyDetail->pack($errorInfo);

            try {
                $echoClient->echo(new EchoRequest([
                    'error' => new Status([
                        'code' => Code::INVALID_ARGUMENT,
                        'message' => 'Invalid argument with ErrorInfo',
                        'details' => [$anyDetail],
                    ]),
                ]));
                $this->fail('Expected ApiException');
            } catch (ApiException $e) {
                $this->assertSame('INVALID_ARGUMENT', $e->getStatus());
            }

            // 3. FailEchoWithDetails (standard Showcase error details RPC)
            try {
                $echoClient->failEchoWithDetails(new FailEchoWithDetailsRequest([
                    'message' => 'Failed echo with details',
                ]));
                $this->fail('Expected ApiException from failEchoWithDetails');
            } catch (ApiException $e) {
                $this->assertNotEmpty($e->getErrorDetails());
            }
        } finally {
            $echoClient->close();
        }

        /** @var SpanDataInterface[] $spans */
        $spans = $this->exporter->getSpans();

        if ($transportType === 'grpc') {
            $this->assertCount(6, $spans);
            $okT4Span = $spans[0];
            $okT3Span = $spans[1];
            $errInfoT4Span = $spans[2];
            $errInfoT3Span = $spans[3];
            $failDetailsT4Span = $spans[4];
            $failDetailsT3Span = $spans[5];

            $this->assertSame('OK', $okT4Span->getAttributes()->get(SpanAttributes::RPC_RESPONSE_STATUS_CODE));
            $this->assertNull($okT4Span->getAttributes()->get(SpanAttributes::ERROR_TYPE));
            $this->assertNull($okT3Span->getAttributes()->get(SpanAttributes::ERROR_TYPE));

            $this->assertSame(
                'INVALID_ARGUMENT',
                $errInfoT4Span->getAttributes()->get(SpanAttributes::RPC_RESPONSE_STATUS_CODE)
            );
            $this->assertSame(
                'CUSTOM_SHOWCASE_ERROR_REASON',
                $errInfoT4Span->getAttributes()->get(SpanAttributes::ERROR_TYPE)
            );
            $this->assertSame(
                'CUSTOM_SHOWCASE_ERROR_REASON',
                $errInfoT3Span->getAttributes()->get(SpanAttributes::ERROR_TYPE)
            );

            $this->assertSame(
                'google.showcase.v1beta1.Echo/FailEchoWithDetails',
                $failDetailsT4Span->getName()
            );
            $this->assertSame(StatusCode::STATUS_ERROR, $failDetailsT4Span->getStatus()->getCode());
            $this->assertSame(StatusCode::STATUS_ERROR, $failDetailsT3Span->getStatus()->getCode());
            $this->assertSame(
                ApiException::class,
                $failDetailsT3Span->getAttributes()->get(SpanAttributes::EXCEPTION_TYPE)
            );
        } else {
            $this->assertCount(3, $spans);
            $okT3Span = $spans[0];
            $errInfoT3Span = $spans[1];
            $failDetailsT3Span = $spans[2];

            $this->assertSame(StatusCode::STATUS_OK, $okT3Span->getStatus()->getCode());
            $this->assertNull($okT3Span->getAttributes()->get(SpanAttributes::ERROR_TYPE));

            $this->assertSame(StatusCode::STATUS_ERROR, $errInfoT3Span->getStatus()->getCode());
            $this->assertSame(
                'CUSTOM_SHOWCASE_ERROR_REASON',
                $errInfoT3Span->getAttributes()->get(SpanAttributes::ERROR_TYPE)
            );

            $this->assertSame(
                'google.showcase.v1beta1.Echo/FailEchoWithDetails',
                $failDetailsT3Span->getName()
            );
            $this->assertSame(StatusCode::STATUS_ERROR, $failDetailsT3Span->getStatus()->getCode());
            $this->assertSame(
                ApiException::class,
                $failDetailsT3Span->getAttributes()->get(SpanAttributes::EXCEPTION_TYPE)
            );
        }
    }

    private function buildTransport(
        string $transportType,
        string $restConfigPath,
        ?TracerProviderInterface $tracerProvider
    ): TransportInterface {
        if (file_exists(self::PEM_PATH)) {
            $pemContents = file_get_contents(self::PEM_PATH);
            $grpcCredentials = ChannelCredentials::createSsl($pemContents);
            $requestBuilder = new RequestBuilder(self::HOST, $restConfigPath);
            $guzzleClient = new Client(['verify' => self::PEM_PATH]);
        } else {
            $grpcCredentials = ChannelCredentials::createInsecure();
            $requestBuilder = new InsecureRequestBuilder(self::HOST, $restConfigPath);
            $guzzleClient = null;
        }

        if ($transportType === 'grpc') {
            return GrpcTransport::build(
                self::HOST,
                [
                    'stubOpts' => [
                        'credentials' => $grpcCredentials,
                    ],
                    'openTelemetryTracerProvider' => $tracerProvider,
                ]
            );
        }

        $httpHandler = HttpHandlerFactory::build($guzzleClient);
        return new RestTransport($requestBuilder, [$httpHandler, 'async']);
    }
}

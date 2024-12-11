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

namespace Google\ApiCore\Transport;

use Exception;
use Google\ApiCore\ApiException;
use Google\ApiCore\BidiStream;
use Google\ApiCore\Call;
use Google\ApiCore\ClientStream;
use Google\ApiCore\GrpcSupportTrait;
use Google\ApiCore\ServerStream;
use Google\ApiCore\ServiceAddressTrait;
use Google\ApiCore\Transport\Grpc\ServerStreamingCallWrapper;
use Google\ApiCore\Transport\Grpc\UnaryInterceptorInterface;
use Google\ApiCore\ValidationException;
use Google\ApiCore\ValidationTrait;
use Google\Auth\Logging\LoggingTrait;
use Google\Auth\Logging\RpcLogEvent;
use Google\Rpc\Code;
use Grpc\BaseStub;
use Grpc\Channel;
use Grpc\ChannelCredentials;
use Grpc\Interceptor;
use GuzzleHttp\Promise\Promise;
use Psr\Log\LoggerInterface;

/**
 * A gRPC based transport implementation.
 */
class GrpcTransport extends BaseStub implements TransportInterface
{
    use ValidationTrait;
    use GrpcSupportTrait;
    use ServiceAddressTrait;
    use LoggingTrait;

    private null|LoggerInterface $logger;

    /**
     * @param string $hostname
     * @param array $opts
     *  - 'update_metadata': (optional) a callback function which takes in a
     * metadata array, and returns an updated metadata array
     *  - 'grpc.primary_user_agent': (optional) a user-agent string
     * @param Channel $channel An already created Channel object (optional)
     * @param Interceptor[]|UnaryInterceptorInterface[] $interceptors *EXPERIMENTAL*
     *        Interceptors used to intercept RPC invocations before a call starts.
     *        Please note that implementations of
     *        {@see \Google\ApiCore\Transport\Grpc\UnaryInterceptorInterface} are
     *        considered deprecated and support will be removed in a future
     *        release. To prepare for this, please take the time to convert
     *        `UnaryInterceptorInterface` implementations over to a class which
     *        extends {@see Grpc\Interceptor}.
     * @param null|false|LoggerInterface $logger A PSR-3 Compliant logger.
     * @throws Exception
     */
    public function __construct(
        string $hostname,
        array $opts,
        ?Channel $channel = null,
        array $interceptors = [],
        null|false|LoggerInterface $logger = null
    ) {
        if ($interceptors) {
            $channel = Interceptor::intercept(
                $channel ?: new Channel($hostname, $opts),
                $interceptors
            );
        }

        parent::__construct($hostname, $opts, $channel);
        $this->logger = $logger;
    }

    /**
     * Builds a GrpcTransport.
     *
     * @param string $apiEndpoint
     *        The address of the API remote host, for example "example.googleapis.com. May also
     *        include the port, for example "example.googleapis.com:443"
     * @param array $config {
     *    Config options used to construct the gRPC transport.
     *
     *    @type array $stubOpts Options used to construct the gRPC stub (see
     *          {@link https://grpc.github.io/grpc/core/group__grpc__arg__keys.html}).
     *    @type Channel $channel Grpc channel to be used.
     *    @type Interceptor[]|UnaryInterceptorInterface[] $interceptors *EXPERIMENTAL*
     *          Interceptors used to intercept RPC invocations before a call starts.
     *          Please note that implementations of
     *          {@see \Google\ApiCore\Transport\Grpc\UnaryInterceptorInterface} are
     *          considered deprecated and support will be removed in a future
     *          release. To prepare for this, please take the time to convert
     *          `UnaryInterceptorInterface` implementations over to a class which
     *          extends {@see Grpc\Interceptor}.
     *    @type callable $clientCertSource A callable which returns the client cert as a string.
     * }
     * @return GrpcTransport
     * @throws ValidationException
     */
    public static function build(string $apiEndpoint, array $config = [])
    {
        self::validateGrpcSupport();
        $config += [
            'stubOpts'         => [],
            'channel'          => null,
            'interceptors'     => [],
            'clientCertSource' => null,
            'logger'           => null,
        ];
        list($addr, $port) = self::normalizeServiceAddress($apiEndpoint);
        $host = "$addr:$port";
        $stubOpts = $config['stubOpts'];
        // Set the required 'credentials' key in stubOpts if it is not already set. Use
        // array_key_exists because null is a valid value.
        if (!array_key_exists('credentials', $stubOpts)) {
            if (isset($config['clientCertSource'])) {
                list($cert, $key) = self::loadClientCertSource($config['clientCertSource']);
                $stubOpts['credentials'] = ChannelCredentials::createSsl(null, $key, $cert);
            } else {
                $stubOpts['credentials'] = ChannelCredentials::createSsl();
            }
        }
        $channel = $config['channel'];
        if (!is_null($channel) && !($channel instanceof Channel)) {
            throw new ValidationException(
                "Channel argument to GrpcTransport must be of type \Grpc\Channel, " .
                'instead got: ' . print_r($channel, true)
            );
        }
        try {
            if ($config['logger'] === false) {
                $config['logger'] = null;
            }
            return new GrpcTransport($host, $stubOpts, $channel, $config['interceptors'], $config['logger']);
        } catch (Exception $ex) {
            throw new ValidationException(
                'Failed to build GrpcTransport: ' . $ex->getMessage(),
                $ex->getCode(),
                $ex
            );
        }
    }

    /**
     * {@inheritdoc}
     */
    public function startBidiStreamingCall(Call $call, array $options)
    {
        $this->verifyUniverseDomain($options);

        return new BidiStream(
            $this->_bidiRequest(
                '/' . $call->getMethod(),
                [$call->getDecodeType(), 'decode'],
                isset($options['headers']) ? $options['headers'] : [],
                $this->getCallOptions($options)
            ),
            $call->getDescriptor(),
            $this->logger
        );
    }

    /**
     * {@inheritdoc}
     */
    public function startClientStreamingCall(Call $call, array $options)
    {

        $this->verifyUniverseDomain($options);

        return new ClientStream(
            $this->_clientStreamRequest(
                '/' . $call->getMethod(),
                [$call->getDecodeType(), 'decode'],
                isset($options['headers']) ? $options['headers'] : [],
                $this->getCallOptions($options)
            ),
            $call->getDescriptor(),
            $this->logger
        );
    }

    /**
     * {@inheritdoc}
     */
    public function startServerStreamingCall(Call $call, array $options)
    {
        $this->verifyUniverseDomain($options);

        $message = $call->getMessage();

        if (!$message) {
            throw new \InvalidArgumentException('A message is required for ServerStreaming calls.');
        }

        // This simultaenously creates and starts a \Grpc\ServerStreamingCall.
        $stream = $this->_serverStreamRequest(
            '/' . $call->getMethod(),
            $message,
            [$call->getDecodeType(), 'decode'],
            isset($options['headers']) ? $options['headers'] : [],
            $this->getCallOptions($options)
        );

        $serverStream = new ServerStream(
            new ServerStreamingCallWrapper($stream),
            $call->getDescriptor(),
            $this->logger
        );

        if ($this->logger) {
            $requestEvent = new RpcLogEvent();

            $requestEvent->headers = $options['headers'];
            $requestEvent->payload = $call->getMessage()->serializeToJsonString();
            $requestEvent->retryAttempt = $options['retryAttempt'] ?? null;
            $requestEvent->serviceName = $options['serviceName'] ?? null;
            $requestEvent->rpcName = $call->getMethod();
            $requestEvent->processId = (int) getmypid();
            $requestEvent->requestId = crc32((string) spl_object_id($serverStream) . getmypid());

            $this->logRequest($requestEvent);
        }

        return $serverStream;
    }

    /**
     * {@inheritdoc}
     */
    public function startUnaryCall(Call $call, array $options)
    {
        $this->verifyUniverseDomain($options);
        $headers = $options['headers'] ?? [];
        $requestEvent = null;

        $unaryCall = $this->_simpleRequest(
            '/' . $call->getMethod(),
            $call->getMessage(),
            [$call->getDecodeType(), 'decode'],
            isset($options['headers']) ? $options['headers'] : [],
            $this->getCallOptions($options)
        );

        if ($this->logger) {
            $requestEvent = new RpcLogEvent();

            $requestEvent->headers = $headers;
            $requestEvent->payload = $call->getMessage()->serializeToJsonString();
            $requestEvent->retryAttempt = $options['retryAttempt'] ?? null;
            $requestEvent->serviceName = $options['serviceName'] ?? null;
            $requestEvent->rpcName = $call->getMethod();
            $requestEvent->processId = (int) getmypid();
            $requestEvent->requestId = crc32((string) spl_object_id($call) . getmypid());

            $this->logRequest($requestEvent);
        }

        /** @var Promise $promise */
        $promise = new Promise(
            function () use ($unaryCall, $options, &$promise, $requestEvent) {
                list($response, $status) = $unaryCall->wait();

                if ($this->logger) {
                    $responseEvent = new RpcLogEvent($requestEvent->milliseconds);

                    $responseEvent->headers = $status->metadata;
                    $responseEvent->payload = ($response) ? $response->serializeToJsonString() : null;
                    $responseEvent->status = $status->code;
                    $responseEvent->processId = $requestEvent->processId;
                    $responseEvent->requestId = $requestEvent->requestId;

                    $this->logResponse($responseEvent);
                }

                if ($status->code == Code::OK) {
                    if (isset($options['metadataCallback'])) {
                        $metadataCallback = $options['metadataCallback'];
                        $metadataCallback($unaryCall->getMetadata());
                    }
                    $promise->resolve($response);
                } else {
                    throw ApiException::createFromStdClass($status);
                }
            },
            [$unaryCall, 'cancel']
        );

        return $promise;
    }

    private function verifyUniverseDomain(array $options)
    {
        if (isset($options['credentialsWrapper'])) {
            $options['credentialsWrapper']->checkUniverseDomain();
        }
    }

    private function getCallOptions(array $options)
    {
        $callOptions = $options['transportOptions']['grpcOptions'] ?? [];

        if (isset($options['credentialsWrapper'])) {
            $audience = $options['audience'] ?? null;
            $credentialsWrapper = $options['credentialsWrapper'];
            $callOptions['call_credentials_callback'] = $credentialsWrapper
                ->getAuthorizationHeaderCallback($audience);
        }

        if (isset($options['timeoutMillis'])) {
            $callOptions['timeout'] = $options['timeoutMillis'] * 1000;
        }

        return $callOptions;
    }

    private static function loadClientCertSource(callable $clientCertSource)
    {
        return call_user_func($clientCertSource);
    }
}

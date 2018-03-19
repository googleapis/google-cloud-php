<?php
/*
 * Copyright 2018, Google Inc.
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

namespace Google\ApiCore;

use Google\ApiCore\LongRunning\OperationsClient;
use Google\ApiCore\Middleware\AgentHeaderMiddleware;
use Google\ApiCore\Middleware\RetryMiddleware;
use Google\ApiCore\Transport\TransportInterface;
use Google\LongRunning\Operation;
use Google\Protobuf\Internal\Message;
use GuzzleHttp\Promise\PromiseInterface;

/**
 * Common functions used to work with various clients.
 */
trait GapicClientTrait
{
    use ArrayTrait;
    use ValidationTrait;

    protected $transport;
    private static $gapicVersion;
    private $retrySettings;
    private $serviceName;
    private $agentHeaderDescriptor;
    private $descriptors;
    private $transportCallMethods = [
        Call::UNARY_CALL => 'startUnaryCall',
        Call::BIDI_STREAMING_CALL => 'startBidiStreamingCall',
        Call::CLIENT_STREAMING_CALL => 'startClientStreamingCall',
        Call::SERVER_STREAMING_CALL => 'startServerStreamingCall',
    ];

    /**
     * Initiates an orderly shutdown in which preexisting calls continue but new
     * calls are immediately cancelled.
     *
     * @experimental
     */
    public function close()
    {
        $this->transport->close();
    }

    private static function getGapicVersion(array $options)
    {
        if (!self::$gapicVersion) {
            if (isset($options['versionFile']) && file_exists($options['versionFile'])) {
                self::$gapicVersion = trim(file_get_contents(
                    $options['versionFile']
                ));
            } elseif (isset($options['libVersion'])) {
                self::$gapicVersion = $options['libVersion'];
            }
        }

        return self::$gapicVersion;
    }

    /**
     * Configures the GAPIC client based on an array of options.
     *
     * @param array $options {
     *     An array of required and optional arguments.
     *
     *     @type string $versionFile
     *           The path to a file which contains the current version of the
     *           client.
     *     @type string $restClientConfigPath
     *           The path to a REST configuration file.
     *     @type string $descriptorsConfigPath
     *           The path to a descriptor configuration file.
     *     @type string $serviceName
     *           The name of the service.
     *     @type string $serviceAddress
     *           The domain name of the API remote host.
     *     @type mixed $port
     *           The port on which to connect to the remote host.
     *     @type Channel $channel
     *           A `Channel` object. If not specified, a channel will be constructed.
     *           NOTE: This option is only valid when utilizing the gRPC transport.
     *     @type ChannelCredentials $sslCreds
     *           A `ChannelCredentials` object for use with an SSL-enabled channel.
     *           Default: a credentials object returned from
     *           \Grpc\ChannelCredentials::createSsl().
     *           NOTE: This option is only valid when utilizing the gRPC
     *           transport. Also, if the $channel optional argument is
     *           specified, then this argument is unused.
     *     @type bool $forceNewChannel
     *           If true, this forces gRPC to create a new channel instead of
     *           using a persistent channel. Defaults to false.
     *           NOTE: This option is only valid when utilizing the gRPC
     *           transport. Also, if the $channel optional argument is
     *           specified, then this option is unused.
     *     @type CredentialsLoader $credentialsLoader
     *           A CredentialsLoader object created using the Google\Auth library.
     *     @type array $scopes
     *           A string array of scopes to use when acquiring credentials.
     *     @type string $clientConfigPath
     *           Path to a JSON file containing client method configuration, including retry settings.
     *           Specify this setting to specify the retry behavior of all methods on the client.
     *           By default this settings points to the default client config file, which is provided
     *           in the resources folder. The retry settings provided in this option can be overridden
     *           by settings in $retryingOverride
     *     @type array $retryingOverride
     *           An associative array in which the keys are method names (e.g. 'createFoo'), and
     *           the values are retry settings to use for that method. The retry settings for each
     *           method can be a {@see Google\ApiCore\RetrySettings} object, or an associative array
     *           of retry settings parameters. See the documentation on {@see Google\ApiCore\RetrySettings}
     *           for example usage. Passing a value of null is equivalent to a value of
     *           ['retriesEnabled' => false]. Retry settings provided in this setting override the
     *           settings in $clientConfigPath.
     *     @type callable $authHttpHandler A handler used to deliver PSR-7
     *           requests specifically for authentication. Should match a
     *           signature of
     *           `function (RequestInterface $request, array $options) : ResponseInterface`.
     *     @type callable $httpHandler A handler used to deliver PSR-7 requests.
     *           Should match a signature of
     *           `function (RequestInterface $request, array $options) : PromiseInterface`.
     *           NOTE: This option is only valid when utilizing the REST transport.
     *     @type string|TransportInterface $transport
     *           The transport used for executing network requests. May be either
     *           the string `rest` or `grpc`. Additionally, it is possible
     *           to pass in an already instantiated transport. Defaults to `grpc`
     *           if gRPC support is detected on the system.
     *     @type string $libName
     *           The name of the client application.
     *     @type string $libVersion
     *           The version of the client application.
     *     @type string $gapicVersion
     *           The code generator version of the GAPIC library.
     * }
     */
    protected function setClientOptions(array $options)
    {
        $this->validateNotNull($options, [
            'serviceName',
            'descriptorsConfigPath',
            'clientConfigPath'
        ]);
        $transport = isset($options['transport'])
            ? $options['transport']
            : null;
        $clientConfig = json_decode(
            file_get_contents($options['clientConfigPath']),
            true
        );
        $this->serviceName = $options['serviceName'];
        $this->retrySettings = RetrySettings::load(
            $this->serviceName,
            $clientConfig,
            $this->pluck('retryingOverride', $options, false)
        );
        if (!isset($options['gapicVersion'])) {
            $options['gapicVersion'] = self::getGapicVersion($options);
        }
        $this->agentHeaderDescriptor = new AgentHeaderDescriptor([
            'libName' => $this->pluck('libName', $options, false),
            'libVersion' => $this->pluck('libVersion', $options, false),
            'gapicVersion' => $options['gapicVersion'],
        ]);

        $descriptors = require($options['descriptorsConfigPath']);
        $this->descriptors = $descriptors['interfaces'][$this->serviceName];
        $this->transport = $transport instanceof TransportInterface
            ? $transport
            : TransportFactory::build($options);
    }

    /**
     * @param string $methodName
     * @param string $decodeType
     * @param array $optionalArgs {
     *     Call Options
     *
     *     @type array $headers [optional] key-value array containing headers
     *     @type int $timeoutMillis [optional] the timeout in milliseconds for the call
     *     @type array $transportOptions [optional] transport-specific call options
     *     @type RetrySettings $retrySettings [optional] A retry settings override
     *           For the call.
     * }
     * @param Message $request
     * @param int $callType
     * @param string $interfaceName
     *
     * @return PromiseInterface|BidiStream|ClientStream|ServerStream
     */
    protected function startCall(
        $methodName,
        $decodeType,
        array $optionalArgs = [],
        Message $request = null,
        $callType = Call::UNARY_CALL,
        $interfaceName = null
    ) {
        $callStack = $this->createCallStack(
            $this->configureCallConstructionOptions($methodName, $optionalArgs)
        );

        $descriptor = isset($this->descriptors[$methodName]['grpcStreaming'])
            ? $this->descriptors[$methodName]['grpcStreaming']
            : null;

        $call = new Call(
            $this->buildMethod($interfaceName, $methodName),
            $decodeType,
            $request,
            $descriptor,
            $callType
        );
        return $callStack(
            $call,
            $this->configureCallOptions($optionalArgs)
        );
    }

    /**
     * @param array $callConstructionOptions {
     *     Call Construction Options
     *
     *     @type RetrySettings $retrySettings [optional] A retry settings override
     *           For the call.
     * }
     *
     * @return callable
     */
    protected function createCallStack(array $callConstructionOptions)
    {
        return new RetryMiddleware(
            new AgentHeaderMiddleware(
                function (Call $call, array $options) {
                    $startCallMethod = $this->transportCallMethods[$call->getCallType()];
                    return $this->transport->$startCallMethod($call, $options);
                },
                $this->agentHeaderDescriptor
            ),
            $callConstructionOptions['retrySettings']
        );
    }

    /**
     * @param array $optionalArgs {
     *     Optional arguments
     *
     *     @type array $headers [optional] key-value array containing headers
     *     @type int $timeoutMillis [optional] the timeout in milliseconds for the call
     *     @type array $transportOptions [optional] transport-specific call options
     * }
     *
     * @return array
     */
    protected function configureCallOptions(array $optionalArgs)
    {
        return $this->pluckArray([
            'headers',
            'timeoutMillis',
            'transportOptions',
        ], $optionalArgs);
    }

    /**
     * @param string $methodName
     * @param array $optionalArgs {
     *     Optional arguments
     *
     *     @type RetrySettings $retrySettings [optional] A retry settings override
     *           For the call.
     * }
     *
     * @return array
     */
    protected function configureCallConstructionOptions($methodName, array $optionalArgs)
    {
        $retrySettings = $this->retrySettings[$methodName];
        // Allow for retry settings to be changed at call time
        if (isset($optionalArgs['retrySettings'])) {
            $retrySettings = $retrySettings->with(
                $optionalArgs['retrySettings']
            );
        }
        return [
            'retrySettings' => $retrySettings,
        ];
    }

    /**
     * @param string $methodName
     * @param array $optionalArgs {
     *     Call Options
     *
     *     @type array $headers [optional] key-value array containing headers
     *     @type int $timeoutMillis [optional] the timeout in milliseconds for the call
     *     @type array $transportOptions [optional] transport-specific call options
     * }
     * @param Message $request
     * @param OperationsClient $client
     * @param string $interfaceName
     *
     * @return PromiseInterface
     */
    protected function startOperationsCall(
        $methodName,
        array $optionalArgs,
        Message $request,
        OperationsClient $client,
        $interfaceName = null
    ) {
        $descriptor = $this->descriptors[$methodName]['longRunning'];
        return $this->startCall(
            $methodName,
            Operation::class,
            $optionalArgs,
            $request,
            Call::UNARY_CALL,
            $interfaceName
        )->then(function (Message $response) use ($client, $descriptor) {
            $options = $descriptor + [
                'lastProtoResponse' => $response
            ];

            return new OperationResponse($response->getName(), $client, $options);
        });
    }

    /**
     * @param string $methodName
     * @param array $optionalArgs
     * @param string $decodeType
     * @param Message $request
     * @param string $interfaceName
     *
     * @return PagedListResponse
     */
    protected function getPagedListResponse(
        $methodName,
        array $optionalArgs,
        $decodeType,
        Message $request,
        $interfaceName = null
    ) {
        $call = new Call(
            $this->buildMethod($interfaceName, $methodName),
            $decodeType,
            $request
        );
        return new PagedListResponse(
            $call,
            $this->configureCallOptions($optionalArgs),
            $this->createCallStack(
                $this->configureCallConstructionOptions($methodName, $optionalArgs)
            ),
            new PageStreamingDescriptor(
                $this->descriptors[$methodName]['pageStreaming']
            )
        );
    }

    /**
     * @param string $interfaceName
     * @param string $methodName
     *
     * @return string
     */
    protected function buildMethod($interfaceName, $methodName)
    {
        return sprintf(
            '%s/%s',
            $interfaceName ?: $this->serviceName,
            $methodName
        );
    }
}

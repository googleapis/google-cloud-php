<?php
/*
 * Copyright 2017, Google Inc.
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
namespace Google\Cloud\Core\Grpc;

use Google\Auth\ApplicationDefaultCredentials;
use Google\Auth\CredentialsLoader;
use Google\Auth\FetchAuthTokenCache;
use Google\Auth\Cache\MemoryCacheItemPool;
use Google\Cloud\Core\CallStackTrait;
use Google\GAX\CallSettings;
use Google\GAX\ValidationTrait;
use Google\GAX\ValidationException;
use Grpc\ChannelCredentials;

class GrpcTransport
{
    use CallStackTrait;
    use ValidationTrait;

    protected $grpcStub;
    private $credentialsCallback;

    /**
     * Accepts an optional credentialsLoader argument, to be used instead of using
     * the ApplicationDefaultCredentials
     *
     * @param array $args {
     *     Required. An array of required and optional arguments. Arguments in addition to those documented below
     *     will be passed as optional arguments to Google\Auth\FetchAuthTokenCache when caching is enabled.
     *
     *     @type string $serviceAddress
     *           Required. The domain name of the API remote host.
     *     @type mixed $port
     *           Required. The port on which to connect to the remote host.
     *     @type string[] $scopes
     *           Optional. A list of scopes required for API access.
     *           Exactly one of $scopes or $credentialsLoader must be provided.
     *           NOTE: if $credentialsLoader is provided, this argument is ignored.
     *     @type \Google\Auth\CredentialsLoader $credentialsLoader
     *           Optional. A user-created CredentialsLoader object. Defaults to using
     *           ApplicationDefaultCredentials with the provided $scopes argument.
     *           Exactly one of $scopes or $credentialsLoader must be provided.
     *     @type \Grpc\Channel $channel
     *           Optional. A `Channel` object to be used by gRPC. If not specified, a channel will be constructed.
     *     @type \Grpc\ChannelCredentials $sslCreds
     *           Optional. A `ChannelCredentials` object for use with an SSL-enabled channel.
     *           Default: a credentials object returned from
     *           \Grpc\ChannelCredentials::createSsl()
     *           NOTE: if the $channel optional argument is specified, then this option is unused.
     *     @type bool $forceNewChannel
     *           Optional. If true, this forces gRPC to create a new channel instead of using a persistent channel.
     *           Defaults to false.
     *           NOTE: if the $channel optional argument is specified, then this option is unused.
     *     @type boolean $enableCaching
     *           Optional. Enable caching of access tokens. Defaults to true.
     * }
     */
    public function __construct($args)
    {
        $this->validateNotNull($args, [
            'serviceAddress',
            'port',
            'createGrpcStubFunction',
        ]);

        $defaultOptions = [
            'forceNewChannel' => false,
            'enableCaching' => true,
        ];
        $args = array_merge($defaultOptions, $args);

        if (empty($args['credentialsLoader'])) {
            $this->validateNotNull($args, ['scopes']);
            $args['credentialsLoader'] = $this->getADCCredentials($args['scopes']);
        }

        if ($args['enableCaching']) {
            $cachingOptions = array_diff_key($args, array_flip([
                'serviceAddress',
                'port',
                'scopes',
                'credentialsLoader',
                'channel',
                'sslCreds',
                'forceNewChannel',
                'enableCaching'
            ]));
            $args['credentialsLoader'] = new FetchAuthTokenCache(
                $args['credentialsLoader'],
                $cachingOptions,
                new MemoryCacheItemPool()
            );
        }

        $credentialsLoader = $args['credentialsLoader'];
        $this->credentialsCallback = function () use ($credentialsLoader) {
            $token = $credentialsLoader->fetchAuthToken();
            return ['authorization' => array('Bearer ' . $token['access_token'])];
        };

        $stubOpts = [];
        // We need to use array_key_exists here because null is a valid value
        if (!array_key_exists('sslCreds', $args)) {
            $stubOpts['credentials'] = $this->createSslChannelCredentials();
        } else {
            $stubOpts['credentials'] = $args['sslCreds'];
        }

        $serviceAddress = $args['serviceAddress'];
        $port = $args['port'];
        $fullAddress = "$serviceAddress:$port";
        $stubOpts['grpc.ssl_target_name_override'] = $fullAddress;

        if (isset($args['channel'])) {
            $channel = $args['channel'];
        } else {
            $channel = null;
        }

        if (isset($args['forceNewChannel']) && $args['forceNewChannel']) {
            $stubOpts['force_new'] = true;
        }
        $this->grpcStub = call_user_func_array(
            $args['createGrpcStubFunction'],
            [$fullAddress, $stubOpts, $channel]
        );
    }

    /**
     * @param string $methodName the method name to return a callable for.
     * @param \Google\GAX\CallSettings $settings the call settings to use for this call.
     * @param array $options {
     *     Optional.
     *     @type \Google\GAX\PageStreamingDescriptor $pageStreamingDescriptor
     *           the descriptor used for page-streaming.
     *     @type \Google\GAX\AgentHeaderDescriptor $headerDescriptor
     *           the descriptor used for creating GAPIC header.
     * }
     *
     * @throws \Google\GAX\ValidationException
     * @return callable
     */
    public function createApiCall($methodName, CallSettings $settings, $options = [])
    {
        $this->validateApiCallSettings($settings, $options);

        $callClass = GrpcUnaryCall::class;
        if (array_key_exists('grpcStreamingDescriptor', $options)) {
            $grpcStreamingDescriptor = $options['grpcStreamingDescriptor'];
            switch ($grpcStreamingDescriptor['grpcStreamingType']) {
                case 'ClientStreaming':
                    $callClass = GrpcClientStream::class;
                    break;
                case 'ServerStreaming':
                    $callClass = GrpcServerStream::class;
                    break;
                case 'BidiStreaming':
                    $callClass = GrpcBidiStream::class;
                    break;
                default:
                    throw new ValidationException('Unexpected gRPC streaming type: ' .
                        $grpcStreamingDescriptor['grpcStreamingType']);
            }
        }

        $handler = function () use ($methodName, $callClass) {
            $args = func_get_args();
            $optionalArgs = array_pop($args);
            $args = array_merge($args, $this->constructGrpcArgs($optionalArgs));
            $innerCall = call_user_func_array([$this->grpcStub, $methodName], $args);
            return new $callClass($innerCall);
        };

        // Call the sync method "wait" if this is not a gRPC call
        if (array_key_exists('grpcStreamingDescriptor', $options)) {
            $callable = function () use ($handler) {
                return call_user_func_array($handler, func_get_args());
            };
        } else {
            $callable = function () use ($handler) {
                return call_user_func_array($handler, func_get_args())->wait();
            };
        }

        return $this->createCallStack($callable, $settings, $options);
    }

    protected function constructGrpcArgs($optionalArgs = [])
    {
        $metadata = [];
        $options = [];
        if (array_key_exists('timeoutMillis', $optionalArgs)) {
            $options['timeout'] = $optionalArgs['timeoutMillis'] * 1000;
        }
        if (array_key_exists('headers', $optionalArgs)) {
            $metadata = $optionalArgs['headers'];
        }
        if (array_key_exists('credentialsLoader', $optionalArgs)) {
            $credentialsLoader = $optionalArgs['credentialsLoader'];
            $callback = function () use ($credentialsLoader) {
                $token = $credentialsLoader->fetchAuthToken();
                return ['authorization' => array('Bearer ' . $token['access_token'])];
            };
            $options['call_credentials_callback'] = $callback;
        }
        if (empty($options['call_credentials_callback'])) {
            $options['call_credentials_callback'] = $this->credentialsCallback;
        }
        return [$metadata, $options];
    }

    private function validateApiCallSettings(CallSettings $settings, $options)
    {
        $retrySettings = $settings->getRetrySettings();
        $isGrpcStreaming = array_key_exists('grpcStreamingDescriptor', $options);
        if ($isGrpcStreaming) {
            if (!is_null($retrySettings) && $retrySettings->retriesEnabled()) {
                throw new ValidationException(
                    'grpcStreamingDescriptor not compatible with retry settings'
                );
            }
            if (array_key_exists('pageStreamingDescriptor', $options)) {
                throw new ValidationException(
                    'grpcStreamingDescriptor not compatible with pageStreamingDescriptor'
                );
            }
            if (array_key_exists('longRunningDescriptor', $options)) {
                throw new ValidationException(
                    'grpcStreamingDescriptor not compatible with longRunningDescriptor'
                );
            }
        }
    }

    /**
     * Gets credentials from ADC. This exists to allow overriding in unit tests.
     *
     * @param string[] $scopes
     * @return CredentialsLoader
     */
    protected function getADCCredentials($scopes)
    {
        return ApplicationDefaultCredentials::getCredentials($scopes);
    }

    /**
     * Construct ssl channel credentials. This exists to allow overriding in unit tests.
     *
     * @return \Grpc\ChannelCredentials
     */
    protected function createSslChannelCredentials()
    {
        return ChannelCredentials::createSsl();
    }
}

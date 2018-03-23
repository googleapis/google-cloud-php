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

use Google\ApiCore\Transport\TransportInterface;
use Google\ApiCore\Transport\GrpcTransport;
use Google\ApiCore\Transport\RestTransport;
use Google\Auth\ApplicationDefaultCredentials;
use Google\Auth\Cache\MemoryCacheItemPool;
use Google\Auth\CredentialsLoader;
use Google\Auth\FetchAuthTokenCache;
use Google\Auth\HttpHandler\HttpHandlerFactory;
use Grpc\Channel;
use Grpc\ChannelCredentials;
use InvalidArgumentException;

class TransportFactory
{
    use ValidationTrait;

    private static $defaults = [
        'forceNewChannel'   => false,
        'enableCaching'     => true,
        'channel'           => null,
        'transport'         => null,
        'authCacheOptions'  => null,
        'httpHandler'       => null,
        'authHttpHandler'   => null,
    ];

    /**
     * Builds a transport given an array of arguments.
     *
     * @param array $args {
     *     Required. An array of required and optional arguments.
     *
     *     @type string $serviceAddress
     *           Required. The domain name of the API remote host.
     *     @type mixed $port
     *           Required. The port on which to connect to the remote host.
     *     @type string[] $scopes
     *           Optional. A list of scopes required for API access.
     *           Exactly one of $scopes or $credentialsLoader must be provided.
     *           NOTE: if $credentialsLoader is provided, this argument is ignored.
     *     @type CredentialsLoader $credentialsLoader
     *           Optional. A user-created CredentialsLoader object. Defaults to using
     *           ApplicationDefaultCredentials with the provided $scopes argument.
     *           Exactly one of $scopes or $credentialsLoader must be provided.
     *     @type Channel $channel
     *           Optional. A `Channel` object. If not specified, a channel will be constructed.
     *           NOTE: This option is only valid when utilizing the gRPC transport.
     *     @type ChannelCredentials $sslCreds
     *           Optional. A `ChannelCredentials` object for use with an SSL-enabled channel.
     *           Default: a credentials object returned from
     *           \Grpc\ChannelCredentials::createSsl()
     *           NOTE: This option is only valid when utilizing the gRPC transport. Also, if the $channel
     *           optional argument is specified, then this argument is unused.
     *     @type bool $forceNewChannel
     *           Optional. If true, this forces gRPC to create a new channel instead of using a persistent channel.
     *           Defaults to false.
     *           NOTE: This option is only valid when utilizing the gRPC transport. Also, if the $channel
     *           optional argument is specified, then this option is unused.
     *     @type bool $enableCaching
     *           Optional. Enable caching of access tokens. Defaults to true.
     *     @type CacheItemPoolInterface $authCache
     *           Optional. A cache for storing access tokens. Defaults to a simple in memory implementation.
     *     @type array $authCacheOptions
     *           Optional. Cache configuration options.
     *     @type callable $authHttpHandler
     *           A handler used to deliver PSR-7 requests specifically for
     *           authentication. Should match a signature of
     *           `function (RequestInterface $request, array $options) : ResponseInterface`.
     *     @type callable $httpHandler
     *           A handler used to deliver PSR-7 requests. Should match a
     *           signature of
     *           `function (RequestInterface $request, array $options) : PromiseInterface`.
     *           NOTE: This option is only valid when utilizing the REST transport.
     *     @type string $transport
     *           The type of transport to build.
     * }
     * @return TransportInterface
     */
    public static function build(array $args)
    {
        self::validateNotNull($args, [
            'serviceAddress',
            'port'
        ]);
        $args += self::$defaults;
        $host = sprintf(
            '%s:%s',
            $args['serviceAddress'],
            $args['port']
        );

        $args['transport'] = self::handleTransport($args['transport']);

        $authWrapper = self::buildAuthWrapper($args);

        switch ($args['transport']) {
            case 'grpc':
                if (!self::getGrpcDependencyStatus()) {
                    throw new InvalidArgumentException(
                        'gRPC support has been requested but required dependencies ' .
                        'have not been found. For details on how to install the ' .
                        'gRPC extension please see https://cloud.google.com/php/grpc.'
                    );
                }
                $stubOpts = [
                    'force_new' => $args['forceNewChannel']
                ];
                // We need to use array_key_exists here because null is a valid value
                if (!array_key_exists('sslCreds', $args)) {
                    $stubOpts['credentials'] = self::createSslChannelCredentials();
                } else {
                    $stubOpts['credentials'] = $args['sslCreds'];
                }

                return new GrpcTransport(
                    $host,
                    $authWrapper,
                    $stubOpts,
                    $args['channel']
                );
            case 'rest':
                self::validateNotNull($args, ['restClientConfigPath']);

                return new RestTransport(
                    new RequestBuilder(
                        $host,
                        $args['restClientConfigPath']
                    ),
                    $authWrapper,
                    $args['httpHandler'] ?: [HttpHandlerFactory::build(), 'async']
                );
            default:
                throw new InvalidArgumentException('Unknown transport type.');
        }
    }

    /**
     * Abstract the checking of the grpc extension for unit testing.
     *
     * @codeCoverageIgnore
     * @return bool
     */
    protected static function getGrpcDependencyStatus()
    {
        return extension_loaded('grpc');
    }

    /**
     * Gets credentials from ADC. This exists to allow overriding in unit tests.
     *
     * @param string[] $scopes
     * @param callable $httpHandler
     * @return CredentialsLoader
     */
    protected static function getADCCredentials(array $scopes, callable $httpHandler)
    {
        return ApplicationDefaultCredentials::getCredentials($scopes, $httpHandler);
    }

    /**
     * Construct ssl channel credentials. This exists to allow overriding in unit tests.
     *
     * @return ChannelCredentials
     */
    protected static function createSslChannelCredentials()
    {
        return ChannelCredentials::createSsl();
    }

    /**
     * @param string|null $transport
     * @return string
     */
    private static function handleTransport($transport)
    {
        if ($transport) {
            return strtolower($transport);
        }

        $transport = self::getGrpcDependencyStatus()
            ? 'grpc'
            : 'rest';

        return $transport;
    }

    /**
     * @param array $args
     * @return AuthWrapper
     */
    private static function buildAuthWrapper(array $args)
    {
        $authHttpHandler = $args['authHttpHandler'] ?: HttpHandlerFactory::build();

        if (isset($args['credentialsLoader'])) {
            $credentialsLoader = $args['credentialsLoader'];
        } else {
            self::validateNotNull($args, ['scopes']);

            $credentialsLoader = self::getADCCredentials(
                $args['scopes'],
                $authHttpHandler
            );

            if ($args['enableCaching']) {
                if (!isset($args['authCache'])) {
                    $args['authCache'] = new MemoryCacheItemPool();
                }

                $credentialsLoader = new FetchAuthTokenCache(
                    $credentialsLoader,
                    $args['authCacheOptions'],
                    $args['authCache']
                );
            }
        }

        return new AuthWrapper($credentialsLoader, $authHttpHandler);
    }
}

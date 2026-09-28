<?php
/*
 * Copyright 2023 Google LLC
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

namespace Google\ApiCore\Options;

use ArrayAccess;
use Closure;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\Transport\TransportInterface;
use Google\Auth\FetchAuthTokenInterface;
use InvalidArgumentException;
use Psr\Log\LoggerInterface;

/**
 * The ClientOptions class adds typing to the associative array of options
 * passed into each API client constructor. To use this class directly, pass
 * the result of {@see \Google\ApiCore\Options\ClientOptions::toArray()} to the
 * client constructor:
 *
 * ```
 * use Google\ApiCore\ClientOptions;
 * use Google\Cloud\SecretManager\Client\SecretManagerClient;
 *
 * $options = new ClientOptions([
 *     'credentials' => '/path/to/my/credentials.json'
 * ]);
 * $secretManager = new SecretManagerClient($options->toArray());
 * ```
 *
 * Note: It's possible to pass an associative array to the API clients as well,
 * as ClientOptions will still be used internally for validation.
 */
class ClientOptions implements ArrayAccess, OptionsInterface
{
    use OptionsTrait;

    private ?string $apiEndpoint;

    private bool $disableRetries;

    private array $clientConfig;

    /** @var string|array|FetchAuthTokenInterface|CredentialsWrapper|null */
    private $credentials;

    private array $credentialsConfig;

    /** @var string|TransportInterface|null $transport */
    private $transport;

    private TransportOptions $transportConfig;

    private ?string $versionFile;

    private ?string $descriptorsConfigPath;

    private ?string $serviceName;

    private ?string $libName;

    private ?string $libVersion;

    private ?string $gapicVersion;

    private ?Closure $clientCertSource;

    private ?string $universeDomain;

    private ?string $apiKey;

    private null|false|LoggerInterface $logger;

    /**
     * @param array $options {
     *     @type string $apiEndpoint
     *           The address of the API remote host, for example "example.googleapis.com. May also
     *           include the port, for example "example.googleapis.com:443"
     *     @type bool $disableRetries
     *           Determines whether or not retries defined by the client configuration should be
     *           disabled. Defaults to `false`.
     *     @type string|array $clientConfig
     *           Client method configuration, including retry settings. This option can be either a
     *           path to a JSON file, or a PHP array containing the decoded JSON data.
     *           By default this settings points to the default client config file, which is provided
     *           in the resources folder.
     *     @type FetchAuthTokenInterface|CredentialsWrapper $credentials
     *           This option should only be used with a pre-constructed \Google\Auth\FetchAuthTokenInterface
     *           object or \Google\ApiCore\CredentialsWrapper object. Note that when one of these objects
     *           are provided, any settings in $authConfig will be ignored.
     *           **Important**: If you are providing a path to a credentials file, or a decoded credentials
     *           file as a PHP array, this usage is now DEPRECATED. Providing an unvalidated credential
     *           configuration to Google APIs can compromise the security of your systems and data. It is now
     *           recommended to create the credentials explicitly:
     *           ```
     *           use Google\Auth\Credentials\ServiceAccountCredentials;
     *           use Google\ApiCore\Options\ClientOptions;
     *           $creds = new ServiceAccountCredentials($scopes, $json);
     *           $options = new ClientOptions(['credentials' => $creds]);
     *           ```
     *           For more information
     *           {@see https://cloud.google.com/docs/authentication/external/externally-sourced-credentials}
     *     @type array $credentialsConfig
     *           Options used to configure credentials, including auth token caching, for the client.
     *           For a full list of supporting configuration options, see
     *           \Google\ApiCore\CredentialsWrapper::build.
     *     @type string|TransportInterface|null $transport
     *           The transport used for executing network requests. May be either the string `rest`,
     *           `grpc`, or 'grpc-fallback'. Defaults to `grpc` if gRPC support is detected on the system.
     *           *Advanced usage*: Additionally, it is possible to pass in an already instantiated
     *           TransportInterface object. Note that when this objects is provided, any settings in
     *           $transportConfig, and any `$apiEndpoint` setting, will be ignored.
     *     @type array $transportConfig
     *           Configuration options that will be used to construct the transport. Options for
     *           each supported transport type should be passed in a key for that transport. For
     *           example:
     *           $transportConfig = [
     *               'grpc' => [...],
     *               'rest' => [...],
     *               'grpc-fallback' => [...],
     *           ];
     *           See the GrpcTransport::build and RestTransport::build
     *           methods for the supported options.
     *     @type string $versionFile
     *           The path to a file which contains the current version of the client.
     *     @type string $descriptorsConfigPath
     *           The path to a descriptor configuration file.
     *     @type string $serviceName
     *           The name of the service.
     *     @type string $libName
     *           The name of the client application.
     *     @type string $libVersion
     *           The version of the client application.
     *     @type string $gapicVersion
     *           The code generator version of the GAPIC library.
     *     @type callable $clientCertSource
     *           A callable which returns the client cert as a string.
     *     @type string $universeDomain
     *           The default service domain for a given Cloud universe.
     *     @type string $apiKey
     *          The API key to be used for the client.
     *     @type null|false|LoggerInterface
     *           A PSR-3 compliant logger.
     * }
     */
    public function __construct(array $options)
    {
        $this->fromArray($options);
    }

    /**
     * Sets the array of options as class properites.
     *
     * @param array $arr See the constructor for the list of supported options.
     */
    private function fromArray(array $arr): void
    {
        $this->setApiEndpoint($arr['apiEndpoint'] ?? null);
        $this->setDisableRetries($arr['disableRetries'] ?? false);
        $this->setClientConfig($arr['clientConfig'] ?? []);
        $this->setCredentials($arr['credentials'] ?? null);
        $this->setCredentialsConfig($arr['credentialsConfig'] ?? []);
        $this->setTransport($arr['transport'] ?? null);
        $this->setTransportConfig(new TransportOptions($arr['transportConfig'] ?? []));
        $this->setVersionFile($arr['versionFile'] ?? null);
        $this->setDescriptorsConfigPath($arr['descriptorsConfigPath'] ?? null);
        $this->setServiceName($arr['serviceName'] ?? null);
        $this->setLibName($arr['libName'] ?? null);
        $this->setLibVersion($arr['libVersion'] ?? null);
        $this->setGapicVersion($arr['gapicVersion'] ?? null);
        $this->setClientCertSource($arr['clientCertSource'] ?? null);
        $this->setUniverseDomain($arr['universeDomain'] ?? null);
        $this->setApiKey($arr['apiKey'] ?? null);
        $this->setLogger($arr['logger'] ?? null);
    }

    /**
     * @param ?string $apiEndpoint
     *
     * @return $this
     */
    public function setApiEndpoint(?string $apiEndpoint): self
    {
        $this->apiEndpoint = $apiEndpoint;

        return $this;
    }

    /**
     * @param bool $disableRetries
     *
     * @return $this
     */
    public function setDisableRetries(bool $disableRetries): self
    {
        $this->disableRetries = $disableRetries;

        return $this;
    }

    /**
     * @param string|array $clientConfig
     *
     * @return $this
     * @throws InvalidArgumentException
     */
    public function setClientConfig($clientConfig): self
    {
        if (is_string($clientConfig)) {
            $this->clientConfig = json_decode(file_get_contents($clientConfig), true);
        } elseif (is_array($clientConfig)) {
            $this->clientConfig = $clientConfig;
        } else {
            throw new InvalidArgumentException('Invalid client config');
        }

        return $this;
    }

    /**
     * @param string|array|FetchAuthTokenInterface|CredentialsWrapper|null $credentials
     *
     * @return $this
     */
    public function setCredentials($credentials): self
    {
        $this->credentials = $credentials;

        return $this;
    }

    /**
     * @param array $credentialsConfig
     *
     * @return $this
     */
    public function setCredentialsConfig(array $credentialsConfig): self
    {
        $this->credentialsConfig = $credentialsConfig;

        return $this;
    }

    /**
     * @param string|TransportInterface|null $transport
     *
     * @return $this
     */
    public function setTransport($transport): self
    {
        $this->transport = $transport;

        return $this;
    }

    /**
     * @param TransportOptions $transportConfig
     *
     * @return $this
     */
    public function setTransportConfig(TransportOptions $transportConfig): self
    {
        $this->transportConfig = $transportConfig;

        return $this;
    }

    /**
     * @param ?string $versionFile
     *
     * @return $this
     */
    public function setVersionFile(?string $versionFile): self
    {
        $this->versionFile = $versionFile;

        return $this;
    }

    /**
     * @param ?string $descriptorsConfigPath
     *
     * @return $this
     */
    private function setDescriptorsConfigPath(?string $descriptorsConfigPath): self
    {
        if (!is_null($descriptorsConfigPath)) {
            self::validateFileExists($descriptorsConfigPath);
        }
        $this->descriptorsConfigPath = $descriptorsConfigPath;

        return $this;
    }

    /**
     * @param ?string $serviceName
     *
     * @return $this
     */
    public function setServiceName(?string $serviceName): self
    {
        $this->serviceName = $serviceName;

        return $this;
    }

    /**
     * @param ?string $libName
     *
     * @return $this
     */
    public function setLibName(?string $libName): self
    {
        $this->libName = $libName;

        return $this;
    }

    /**
     * @param ?string $libVersion
     *
     * @return $this
     */
    public function setLibVersion(?string $libVersion): self
    {
        $this->libVersion = $libVersion;

        return $this;
    }

    /**
     * @param ?string $gapicVersion
     *
     * @return $this
     */
    public function setGapicVersion(?string $gapicVersion): self
    {
        $this->gapicVersion = $gapicVersion;

        return $this;
    }

    /**
     * @param ?callable $clientCertSource
     *
     * @return $this
     */
    public function setClientCertSource(?callable $clientCertSource): self
    {
        if (!is_null($clientCertSource)) {
            $clientCertSource = Closure::fromCallable($clientCertSource);
        }
        $this->clientCertSource = $clientCertSource;

        return $this;
    }

    /**
     * @param string $universeDomain
     *
     * @return $this
     */
    public function setUniverseDomain(?string $universeDomain): self
    {
        $this->universeDomain = $universeDomain;

        return $this;
    }

    /**
     * @param string $apiKey
     *
     * @return $this
     */
    public function setApiKey(?string $apiKey): self
    {
        $this->apiKey = $apiKey;

        return $this;
    }

    /**
     * @param null|false|LoggerInterface $logger
     *
     * @return $this
     */
    public function setLogger(null|false|LoggerInterface $logger): self
    {
        $this->logger = $logger;

        return $this;
    }
}

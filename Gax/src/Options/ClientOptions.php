<?php
declare(strict_types=1);

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
use Google\ApiCore\HeaderCredentialsInterface;
use Google\ApiCore\Transport\TransportInterface;
use Google\Auth\FetchAuthTokenInterface;
use Psr\Log\LoggerInterface;

/**
 * The ClientOptions class adds typing to the associative array of options
 * passed into each API client constructor:
 *
 * ```
 * use Google\ApiCore\Options\ClientOptions;
 * use Google\Cloud\SecretManager\V1\Client\SecretManagerServiceClient;
 *
 * $options = (new ClientOptions())
 *     ->setApiEndpoint('my-custom-endpoint.com');
 * $secretManager = new SecretManagerServiceClient($options);
 * ```
 *
 * Note: It's possible to pass an associative array to the API clients as well,
 * as ClientOptions will still be used internally for validation.
 */
class ClientOptions implements ArrayAccess, OptionsInterface
{
    use OptionsTrait;

    protected ?string $apiEndpoint = null;

    protected bool $disableRetries = false;

    protected array $clientConfig = [];

    protected string|array|FetchAuthTokenInterface|HeaderCredentialsInterface|null $credentials = null;

    protected array $credentialsConfig = [];

    protected string|TransportInterface|null $transport = null;

    protected TransportOptions $transportConfig;

    protected ?string $versionFile = null;

    protected ?string $descriptorsConfigPath = null;

    protected ?string $serviceName = null;

    protected ?string $libName = null;

    protected ?string $libVersion = null;

    protected ?string $gapicVersion = null;

    protected ?Closure $clientCertSource = null;

    protected ?string $universeDomain = null;

    protected ?string $apiKey = null;

    protected null|false|LoggerInterface $logger = null;

    protected array $customOptions = [];

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
     *     @type string|array|FetchAuthTokenInterface|HeaderCredentialsInterface $credentials
     *           This option should only be used with a pre-constructed \Google\Auth\FetchAuthTokenInterface
     *           object or \Google\ApiCore\HeaderCredentialsInterface object. Note that when one of these objects
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
    public function __construct(array $options = [])
    {
        $this->fromArray($options);
    }

    /**
     * Sets the array of options as class properties.
     *
     * @param array $arr See the constructor for the list of supported options.
     *
     * @return static
     */
    public function fromArray(array $arr): static
    {
        if (!isset($this->transportConfig) || isset($arr['transportConfig'])) {
            $this->setTransportConfig($arr['transportConfig'] ?? []);
        }

        // serviceAddress is deprecated and acts as an alias for apiEndpoint
        if (isset($arr['serviceAddress'])) {
            $arr['apiEndpoint'] = $arr['serviceAddress'];
            unset($arr['serviceAddress']);
        }

        foreach ($arr as $key => $value) {
            if ($key === 'transportConfig') {
                continue;
            }
            $setter = 'set' . str_replace(['-', '_'], '', ucwords((string) $key, '-_'));
            if (method_exists($this, $setter)) {
                $this->$setter($value);
            } else {
                $this->setCustomOption((string) $key, $value);
            }
        }

        return $this;
    }

    /**
     * @param ?string $apiEndpoint
     *
     * @return static
     */
    public function setApiEndpoint(?string $apiEndpoint): static
    {
        $this->apiEndpoint = $apiEndpoint;

        return $this;
    }

    /**
     * @deprecated Use {@see ClientOptions::setApiEndpoint()} instead.
     * @param ?string $serviceAddress
     *
     * @return static
     */
    public function setServiceAddress(?string $serviceAddress): static
    {
        return $this->setApiEndpoint($serviceAddress);
    }

    /**
     * @param bool $disableRetries
     *
     * @return static
     */
    public function setDisableRetries(bool $disableRetries): static
    {
        $this->disableRetries = $disableRetries;

        return $this;
    }

    /**
     * @param string|array $clientConfig
     *
     * @return static
     */
    public function setClientConfig(string|array $clientConfig): static
    {
        if (is_string($clientConfig)) {
            $this->clientConfig = json_decode(file_get_contents($clientConfig), true);
        } else {
            $this->clientConfig = $clientConfig;
        }

        return $this;
    }

    /**
     * @param string|array|FetchAuthTokenInterface|HeaderCredentialsInterface|null $credentials
     *
     * @return static
     */
    public function setCredentials(
        string|array|FetchAuthTokenInterface|HeaderCredentialsInterface|null $credentials
    ): static {
        $this->credentials = $credentials;

        return $this;
    }

    /**
     * @param array $credentialsConfig
     *
     * @return static
     */
    public function setCredentialsConfig(array $credentialsConfig): static
    {
        $this->credentialsConfig = $credentialsConfig;

        return $this;
    }

    /**
     * @param string|TransportInterface|null $transport
     *
     * @return static
     */
    public function setTransport(string|TransportInterface|null $transport): static
    {
        $this->transport = $transport;

        return $this;
    }

    /**
     * @param TransportOptions|array $transportConfig
     *
     * @return static
     */
    public function setTransportConfig(TransportOptions|array $transportConfig): static
    {
        if (is_array($transportConfig)) {
            $transportConfig = new TransportOptions($transportConfig);
        }
        $this->transportConfig = $transportConfig;

        return $this;
    }

    /**
     * @param ?string $versionFile
     *
     * @return static
     */
    public function setVersionFile(?string $versionFile): static
    {
        $this->versionFile = $versionFile;

        return $this;
    }

    /**
     * @param ?string $descriptorsConfigPath
     *
     * @return static
     */
    public function setDescriptorsConfigPath(?string $descriptorsConfigPath): static
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
     * @return static
     */
    public function setServiceName(?string $serviceName): static
    {
        $this->serviceName = $serviceName;

        return $this;
    }

    /**
     * @param ?string $libName
     *
     * @return static
     */
    public function setLibName(?string $libName): static
    {
        $this->libName = $libName;

        return $this;
    }

    /**
     * @param ?string $libVersion
     *
     * @return static
     */
    public function setLibVersion(?string $libVersion): static
    {
        $this->libVersion = $libVersion;

        return $this;
    }

    /**
     * @param ?string $gapicVersion
     *
     * @return static
     */
    public function setGapicVersion(?string $gapicVersion): static
    {
        $this->gapicVersion = $gapicVersion;

        return $this;
    }

    /**
     * @param ?callable $clientCertSource
     *
     * @return static
     */
    public function setClientCertSource(?callable $clientCertSource): static
    {
        if (!is_null($clientCertSource)) {
            $clientCertSource = Closure::fromCallable($clientCertSource);
        }
        $this->clientCertSource = $clientCertSource;

        return $this;
    }

    /**
     * @param ?string $universeDomain
     *
     * @return static
     */
    public function setUniverseDomain(?string $universeDomain): static
    {
        $this->universeDomain = $universeDomain;

        return $this;
    }

    /**
     * @param ?string $apiKey
     *
     * @return static
     */
    public function setApiKey(?string $apiKey): static
    {
        $this->apiKey = $apiKey;

        return $this;
    }

    /**
     * @param null|false|LoggerInterface $logger
     *
     * @return static
     */
    public function setLogger(null|false|LoggerInterface $logger): static
    {
        $this->logger = $logger;

        return $this;
    }

    /**
     * Set a custom or experimental option not explicitly defined on ClientOptions.
     *
     * @param string $key
     * @param mixed $value
     *
     * @return static
     */
    public function setCustomOption(string $key, mixed $value): static
    {
        $this->customOptions[$key] = $value;

        return $this;
    }

    /**
     * Get a custom or experimental option value.
     *
     * @param string $key
     * @param mixed $default
     *
     * @return mixed
     */
    public function getCustomOption(string $key, mixed $default = null): mixed
    {
        return $this->customOptions[$key] ?? $default;
    }

    /**
     * Get all custom or experimental options.
     *
     * @return array
     */
    public function getCustomOptions(): array
    {
        return $this->customOptions;
    }
}

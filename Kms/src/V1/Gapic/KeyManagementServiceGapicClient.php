<?php
/*
 * Copyright 2018 Google LLC
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

/*
 * GENERATED CODE WARNING
 * This file was generated from the file
 * https://github.com/google/googleapis/blob/master/google/cloud/kms/v1/service.proto
 * and updates to that file get reflected here through a refresh process.
 *
 * @experimental
 */

namespace Google\Cloud\Kms\V1\Gapic;

use Google\ApiCore\ApiException;
use Google\ApiCore\Call;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\FetchAuthTokenInterface;
use Google\ApiCore\GapicClientTrait;
use Google\ApiCore\PathTemplate;
use Google\ApiCore\RequestParamsHeaderDescriptor;
use Google\ApiCore\RetrySettings;
use Google\ApiCore\Transport\TransportInterface;
use Google\ApiCore\ValidationException;
use Google\Cloud\Iam\V1\GetIamPolicyRequest;
use Google\Cloud\Iam\V1\Policy;
use Google\Cloud\Iam\V1\SetIamPolicyRequest;
use Google\Cloud\Iam\V1\TestIamPermissionsRequest;
use Google\Cloud\Iam\V1\TestIamPermissionsResponse;
use Google\Cloud\Kms\V1\CreateCryptoKeyRequest;
use Google\Cloud\Kms\V1\CreateCryptoKeyVersionRequest;
use Google\Cloud\Kms\V1\CreateKeyRingRequest;
use Google\Cloud\Kms\V1\CryptoKey;
use Google\Cloud\Kms\V1\CryptoKeyVersion;
use Google\Cloud\Kms\V1\DecryptRequest;
use Google\Cloud\Kms\V1\DecryptResponse;
use Google\Cloud\Kms\V1\DestroyCryptoKeyVersionRequest;
use Google\Cloud\Kms\V1\EncryptRequest;
use Google\Cloud\Kms\V1\EncryptResponse;
use Google\Cloud\Kms\V1\GetCryptoKeyRequest;
use Google\Cloud\Kms\V1\GetCryptoKeyVersionRequest;
use Google\Cloud\Kms\V1\GetKeyRingRequest;
use Google\Cloud\Kms\V1\KeyRing;
use Google\Cloud\Kms\V1\ListCryptoKeyVersionsRequest;
use Google\Cloud\Kms\V1\ListCryptoKeyVersionsResponse;
use Google\Cloud\Kms\V1\ListCryptoKeysRequest;
use Google\Cloud\Kms\V1\ListCryptoKeysResponse;
use Google\Cloud\Kms\V1\ListKeyRingsRequest;
use Google\Cloud\Kms\V1\ListKeyRingsResponse;
use Google\Cloud\Kms\V1\RestoreCryptoKeyVersionRequest;
use Google\Cloud\Kms\V1\UpdateCryptoKeyPrimaryVersionRequest;
use Google\Cloud\Kms\V1\UpdateCryptoKeyRequest;
use Google\Cloud\Kms\V1\UpdateCryptoKeyVersionRequest;
use Google\Protobuf\FieldMask;

/**
 * Service Description: Google Cloud Key Management Service.
 *
 * Manages cryptographic keys and operations using those keys. Implements a REST
 * model with the following objects:
 *
 * * [KeyRing][google.cloud.kms.v1.KeyRing]
 * * [CryptoKey][google.cloud.kms.v1.CryptoKey]
 * * [CryptoKeyVersion][google.cloud.kms.v1.CryptoKeyVersion]
 *
 * This class provides the ability to make remote calls to the backing service through method
 * calls that map to API methods. Sample code to get started:
 *
 * ```
 * $keyManagementServiceClient = new KeyManagementServiceClient();
 * try {
 *     $formattedParent = $keyManagementServiceClient->locationName('[PROJECT]', '[LOCATION]');
 *     // Iterate through all elements
 *     $pagedResponse = $keyManagementServiceClient->listKeyRings($formattedParent);
 *     foreach ($pagedResponse->iterateAllElements() as $element) {
 *         // doSomethingWith($element);
 *     }
 *
 *     // OR iterate over pages of elements
 *     $pagedResponse = $keyManagementServiceClient->listKeyRings($formattedParent);
 *     foreach ($pagedResponse->iteratePages() as $page) {
 *         foreach ($page as $element) {
 *             // doSomethingWith($element);
 *         }
 *     }
 * } finally {
 *     $keyManagementServiceClient->close();
 * }
 * ```
 *
 * Many parameters require resource names to be formatted in a particular way. To assist
 * with these names, this class includes a format method for each type of name, and additionally
 * a parseName method to extract the individual identifiers contained within formatted names
 * that are returned by the API.
 *
 * @experimental
 */
class KeyManagementServiceGapicClient
{
    use GapicClientTrait;

    /**
     * The name of the service.
     */
    const SERVICE_NAME = 'google.cloud.kms.v1.KeyManagementService';

    /**
     * The default address of the service.
     */
    const SERVICE_ADDRESS = 'cloudkms.googleapis.com';

    /**
     * The default port of the service.
     */
    const DEFAULT_SERVICE_PORT = 443;

    /**
     * The name of the code generator, to be included in the agent header.
     */
    const CODEGEN_NAME = 'gapic';

    /**
     * The default scopes required by the service.
     */
    public static $serviceScopes = [
        'https://www.googleapis.com/auth/cloud-platform',
    ];
    private static $keyRingNameTemplate;
    private static $cryptoKeyPathNameTemplate;
    private static $locationNameTemplate;
    private static $cryptoKeyNameTemplate;
    private static $cryptoKeyVersionNameTemplate;
    private static $pathTemplateMap;

    private static function getClientDefaults()
    {
        return [
            'serviceName' => self::SERVICE_NAME,
            'serviceAddress' => self::SERVICE_ADDRESS.':'.self::DEFAULT_SERVICE_PORT,
            'clientConfig' => __DIR__.'/../resources/key_management_service_client_config.json',
            'descriptorsConfigPath' => __DIR__.'/../resources/key_management_service_descriptor_config.php',
            'credentialsConfig' => [
                'scopes' => self::$serviceScopes,
            ],
            'transportConfig' => [
                'rest' => [
                    'restClientConfigPath' => __DIR__.'/../resources/key_management_service_rest_client_config.php',
                ],
            ],
        ];
    }

    private static function getKeyRingNameTemplate()
    {
        if (self::$keyRingNameTemplate == null) {
            self::$keyRingNameTemplate = new PathTemplate('projects/{project}/locations/{location}/keyRings/{key_ring}');
        }

        return self::$keyRingNameTemplate;
    }

    private static function getCryptoKeyPathNameTemplate()
    {
        if (self::$cryptoKeyPathNameTemplate == null) {
            self::$cryptoKeyPathNameTemplate = new PathTemplate('projects/{project}/locations/{location}/keyRings/{key_ring}/cryptoKeys/{crypto_key_path=**}');
        }

        return self::$cryptoKeyPathNameTemplate;
    }

    private static function getLocationNameTemplate()
    {
        if (self::$locationNameTemplate == null) {
            self::$locationNameTemplate = new PathTemplate('projects/{project}/locations/{location}');
        }

        return self::$locationNameTemplate;
    }

    private static function getCryptoKeyNameTemplate()
    {
        if (self::$cryptoKeyNameTemplate == null) {
            self::$cryptoKeyNameTemplate = new PathTemplate('projects/{project}/locations/{location}/keyRings/{key_ring}/cryptoKeys/{crypto_key}');
        }

        return self::$cryptoKeyNameTemplate;
    }

    private static function getCryptoKeyVersionNameTemplate()
    {
        if (self::$cryptoKeyVersionNameTemplate == null) {
            self::$cryptoKeyVersionNameTemplate = new PathTemplate('projects/{project}/locations/{location}/keyRings/{key_ring}/cryptoKeys/{crypto_key}/cryptoKeyVersions/{crypto_key_version}');
        }

        return self::$cryptoKeyVersionNameTemplate;
    }

    private static function getPathTemplateMap()
    {
        if (self::$pathTemplateMap == null) {
            self::$pathTemplateMap = [
                'keyRing' => self::getKeyRingNameTemplate(),
                'cryptoKeyPath' => self::getCryptoKeyPathNameTemplate(),
                'location' => self::getLocationNameTemplate(),
                'cryptoKey' => self::getCryptoKeyNameTemplate(),
                'cryptoKeyVersion' => self::getCryptoKeyVersionNameTemplate(),
            ];
        }

        return self::$pathTemplateMap;
    }

    /**
     * Formats a string containing the fully-qualified path to represent
     * a key_ring resource.
     *
     * @param string $project
     * @param string $location
     * @param string $keyRing
     *
     * @return string The formatted key_ring resource.
     * @experimental
     */
    public static function keyRingName($project, $location, $keyRing)
    {
        return self::getKeyRingNameTemplate()->render([
            'project' => $project,
            'location' => $location,
            'key_ring' => $keyRing,
        ]);
    }

    /**
     * Formats a string containing the fully-qualified path to represent
     * a crypto_key_path resource.
     *
     * @param string $project
     * @param string $location
     * @param string $keyRing
     * @param string $cryptoKeyPath
     *
     * @return string The formatted crypto_key_path resource.
     * @experimental
     */
    public static function cryptoKeyPathName($project, $location, $keyRing, $cryptoKeyPath)
    {
        return self::getCryptoKeyPathNameTemplate()->render([
            'project' => $project,
            'location' => $location,
            'key_ring' => $keyRing,
            'crypto_key_path' => $cryptoKeyPath,
        ]);
    }

    /**
     * Formats a string containing the fully-qualified path to represent
     * a location resource.
     *
     * @param string $project
     * @param string $location
     *
     * @return string The formatted location resource.
     * @experimental
     */
    public static function locationName($project, $location)
    {
        return self::getLocationNameTemplate()->render([
            'project' => $project,
            'location' => $location,
        ]);
    }

    /**
     * Formats a string containing the fully-qualified path to represent
     * a crypto_key resource.
     *
     * @param string $project
     * @param string $location
     * @param string $keyRing
     * @param string $cryptoKey
     *
     * @return string The formatted crypto_key resource.
     * @experimental
     */
    public static function cryptoKeyName($project, $location, $keyRing, $cryptoKey)
    {
        return self::getCryptoKeyNameTemplate()->render([
            'project' => $project,
            'location' => $location,
            'key_ring' => $keyRing,
            'crypto_key' => $cryptoKey,
        ]);
    }

    /**
     * Formats a string containing the fully-qualified path to represent
     * a crypto_key_version resource.
     *
     * @param string $project
     * @param string $location
     * @param string $keyRing
     * @param string $cryptoKey
     * @param string $cryptoKeyVersion
     *
     * @return string The formatted crypto_key_version resource.
     * @experimental
     */
    public static function cryptoKeyVersionName($project, $location, $keyRing, $cryptoKey, $cryptoKeyVersion)
    {
        return self::getCryptoKeyVersionNameTemplate()->render([
            'project' => $project,
            'location' => $location,
            'key_ring' => $keyRing,
            'crypto_key' => $cryptoKey,
            'crypto_key_version' => $cryptoKeyVersion,
        ]);
    }

    /**
     * Parses a formatted name string and returns an associative array of the components in the name.
     * The following name formats are supported:
     * Template: Pattern
     * - keyRing: projects/{project}/locations/{location}/keyRings/{key_ring}
     * - cryptoKeyPath: projects/{project}/locations/{location}/keyRings/{key_ring}/cryptoKeys/{crypto_key_path=**}
     * - location: projects/{project}/locations/{location}
     * - cryptoKey: projects/{project}/locations/{location}/keyRings/{key_ring}/cryptoKeys/{crypto_key}
     * - cryptoKeyVersion: projects/{project}/locations/{location}/keyRings/{key_ring}/cryptoKeys/{crypto_key}/cryptoKeyVersions/{crypto_key_version}.
     *
     * The optional $template argument can be supplied to specify a particular pattern, and must
     * match one of the templates listed above. If no $template argument is provided, or if the
     * $template argument does not match one of the templates listed, then parseName will check
     * each of the supported templates, and return the first match.
     *
     * @param string $formattedName The formatted name string
     * @param string $template      Optional name of template to match
     *
     * @return array An associative array from name component IDs to component values.
     *
     * @throws ValidationException If $formattedName could not be matched.
     * @experimental
     */
    public static function parseName($formattedName, $template = null)
    {
        $templateMap = self::getPathTemplateMap();

        if ($template) {
            if (!isset($templateMap[$template])) {
                throw new ValidationException("Template name $template does not exist");
            }

            return $templateMap[$template]->match($formattedName);
        }

        foreach ($templateMap as $templateName => $pathTemplate) {
            try {
                return $pathTemplate->match($formattedName);
            } catch (ValidationException $ex) {
                // Swallow the exception to continue trying other path templates
            }
        }
        throw new ValidationException("Input did not match any known format. Input: $formattedName");
    }

    /**
     * Constructor.
     *
     * @param array $options {
     *                       Optional. Options for configuring the service API wrapper.
     *
     *     @type string $serviceAddress
     *           The address of the API remote host. May optionally include the port, formatted
     *           as "<uri>:<port>". Default 'cloudkms.googleapis.com:443'.
     *     @type string|array|FetchAuthTokenInterface|CredentialsWrapper $credentials
     *           The credentials to be used by the client to authorize API calls. This option
     *           accepts either a path to a credentials file, or a decoded credentials file as a
     *           PHP array.
     *           *Advanced usage*: In addition, this option can also accept a pre-constructed
     *           {@see \Google\Auth\FetchAuthTokenInterface} object or
     *           {@see \Google\ApiCore\CredentialsWrapper} object. Note that when one of these
     *           objects are provided, any settings in $credentialsConfig will be ignored.
     *     @type array $credentialsConfig
     *           Options used to configure credentials, including auth token caching, for the client.
     *           For a full list of supporting configuration options, see
     *           {@see \Google\ApiCore\CredentialsWrapper::build()}.
     *     @type bool $disableRetries
     *           Determines whether or not retries defined by the client configuration should be
     *           disabled. Defaults to `false`.
     *     @type string|array $clientConfig
     *           Client method configuration, including retry settings. This option can be either a
     *           path to a JSON file, or a PHP array containing the decoded JSON data.
     *           By default this settings points to the default client config file, which is provided
     *           in the resources folder.
     *     @type string|TransportInterface $transport
     *           The transport used for executing network requests. May be either the string `rest`
     *           or `grpc`. Defaults to `grpc` if gRPC support is detected on the system.
     *           *Advanced usage*: Additionally, it is possible to pass in an already instantiated
     *           {@see \Google\ApiCore\Transport\TransportInterface} object. Note that when this
     *           object is provided, any settings in $transportConfig, and any $serviceAddress
     *           setting, will be ignored.
     *     @type array $transportConfig
     *           Configuration options that will be used to construct the transport. Options for
     *           each supported transport type should be passed in a key for that transport. For
     *           example:
     *           $transportConfig = [
     *               'grpc' => [...],
     *               'rest' => [...]
     *           ];
     *           See the {@see \Google\ApiCore\Transport\GrpcTransport::build()} and
     *           {@see \Google\ApiCore\Transport\RestTransport::build()} methods for the
     *           supported options.
     * }
     *
     * @throws ValidationException
     * @experimental
     */
    public function __construct(array $options = [])
    {
        $clientOptions = $this->buildClientOptions($options);
        $this->setClientOptions($clientOptions);
    }

    /**
     * Lists [KeyRings][google.cloud.kms.v1.KeyRing].
     *
     * Sample code:
     * ```
     * $keyManagementServiceClient = new KeyManagementServiceClient();
     * try {
     *     $formattedParent = $keyManagementServiceClient->locationName('[PROJECT]', '[LOCATION]');
     *     // Iterate through all elements
     *     $pagedResponse = $keyManagementServiceClient->listKeyRings($formattedParent);
     *     foreach ($pagedResponse->iterateAllElements() as $element) {
     *         // doSomethingWith($element);
     *     }
     *
     *     // OR iterate over pages of elements
     *     $pagedResponse = $keyManagementServiceClient->listKeyRings($formattedParent);
     *     foreach ($pagedResponse->iteratePages() as $page) {
     *         foreach ($page as $element) {
     *             // doSomethingWith($element);
     *         }
     *     }
     * } finally {
     *     $keyManagementServiceClient->close();
     * }
     * ```
     *
     * @param string $parent       Required. The resource name of the location associated with the
     *                             [KeyRings][google.cloud.kms.v1.KeyRing], in the format `projects/&#42;/locations/*`.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type int $pageSize
     *          The maximum number of resources contained in the underlying API
     *          response. The API may return fewer values in a page, even if
     *          there are additional values to be retrieved.
     *     @type string $pageToken
     *          A page token is used to specify a page of values to be returned.
     *          If no page token is specified (the default), the first page
     *          of values will be returned. Any page token used here must have
     *          been generated by a previous call to the API.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\ApiCore\PagedListResponse
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function listKeyRings($parent, array $optionalArgs = [])
    {
        $request = new ListKeyRingsRequest();
        $request->setParent($parent);
        if (isset($optionalArgs['pageSize'])) {
            $request->setPageSize($optionalArgs['pageSize']);
        }
        if (isset($optionalArgs['pageToken'])) {
            $request->setPageToken($optionalArgs['pageToken']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'parent' => $request->getParent(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->getPagedListResponse(
            'ListKeyRings',
            $optionalArgs,
            ListKeyRingsResponse::class,
            $request
        );
    }

    /**
     * Lists [CryptoKeys][google.cloud.kms.v1.CryptoKey].
     *
     * Sample code:
     * ```
     * $keyManagementServiceClient = new KeyManagementServiceClient();
     * try {
     *     $formattedParent = $keyManagementServiceClient->keyRingName('[PROJECT]', '[LOCATION]', '[KEY_RING]');
     *     // Iterate through all elements
     *     $pagedResponse = $keyManagementServiceClient->listCryptoKeys($formattedParent);
     *     foreach ($pagedResponse->iterateAllElements() as $element) {
     *         // doSomethingWith($element);
     *     }
     *
     *     // OR iterate over pages of elements
     *     $pagedResponse = $keyManagementServiceClient->listCryptoKeys($formattedParent);
     *     foreach ($pagedResponse->iteratePages() as $page) {
     *         foreach ($page as $element) {
     *             // doSomethingWith($element);
     *         }
     *     }
     * } finally {
     *     $keyManagementServiceClient->close();
     * }
     * ```
     *
     * @param string $parent       Required. The resource name of the [KeyRing][google.cloud.kms.v1.KeyRing] to list, in the format
     *                             `projects/&#42;/locations/&#42;/keyRings/*`.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type int $pageSize
     *          The maximum number of resources contained in the underlying API
     *          response. The API may return fewer values in a page, even if
     *          there are additional values to be retrieved.
     *     @type string $pageToken
     *          A page token is used to specify a page of values to be returned.
     *          If no page token is specified (the default), the first page
     *          of values will be returned. Any page token used here must have
     *          been generated by a previous call to the API.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\ApiCore\PagedListResponse
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function listCryptoKeys($parent, array $optionalArgs = [])
    {
        $request = new ListCryptoKeysRequest();
        $request->setParent($parent);
        if (isset($optionalArgs['pageSize'])) {
            $request->setPageSize($optionalArgs['pageSize']);
        }
        if (isset($optionalArgs['pageToken'])) {
            $request->setPageToken($optionalArgs['pageToken']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'parent' => $request->getParent(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->getPagedListResponse(
            'ListCryptoKeys',
            $optionalArgs,
            ListCryptoKeysResponse::class,
            $request
        );
    }

    /**
     * Lists [CryptoKeyVersions][google.cloud.kms.v1.CryptoKeyVersion].
     *
     * Sample code:
     * ```
     * $keyManagementServiceClient = new KeyManagementServiceClient();
     * try {
     *     $formattedParent = $keyManagementServiceClient->cryptoKeyName('[PROJECT]', '[LOCATION]', '[KEY_RING]', '[CRYPTO_KEY]');
     *     // Iterate through all elements
     *     $pagedResponse = $keyManagementServiceClient->listCryptoKeyVersions($formattedParent);
     *     foreach ($pagedResponse->iterateAllElements() as $element) {
     *         // doSomethingWith($element);
     *     }
     *
     *     // OR iterate over pages of elements
     *     $pagedResponse = $keyManagementServiceClient->listCryptoKeyVersions($formattedParent);
     *     foreach ($pagedResponse->iteratePages() as $page) {
     *         foreach ($page as $element) {
     *             // doSomethingWith($element);
     *         }
     *     }
     * } finally {
     *     $keyManagementServiceClient->close();
     * }
     * ```
     *
     * @param string $parent       Required. The resource name of the [CryptoKey][google.cloud.kms.v1.CryptoKey] to list, in the format
     *                             `projects/&#42;/locations/&#42;/keyRings/&#42;/cryptoKeys/*`.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type int $pageSize
     *          The maximum number of resources contained in the underlying API
     *          response. The API may return fewer values in a page, even if
     *          there are additional values to be retrieved.
     *     @type string $pageToken
     *          A page token is used to specify a page of values to be returned.
     *          If no page token is specified (the default), the first page
     *          of values will be returned. Any page token used here must have
     *          been generated by a previous call to the API.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\ApiCore\PagedListResponse
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function listCryptoKeyVersions($parent, array $optionalArgs = [])
    {
        $request = new ListCryptoKeyVersionsRequest();
        $request->setParent($parent);
        if (isset($optionalArgs['pageSize'])) {
            $request->setPageSize($optionalArgs['pageSize']);
        }
        if (isset($optionalArgs['pageToken'])) {
            $request->setPageToken($optionalArgs['pageToken']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'parent' => $request->getParent(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->getPagedListResponse(
            'ListCryptoKeyVersions',
            $optionalArgs,
            ListCryptoKeyVersionsResponse::class,
            $request
        );
    }

    /**
     * Returns metadata for a given [KeyRing][google.cloud.kms.v1.KeyRing].
     *
     * Sample code:
     * ```
     * $keyManagementServiceClient = new KeyManagementServiceClient();
     * try {
     *     $formattedName = $keyManagementServiceClient->keyRingName('[PROJECT]', '[LOCATION]', '[KEY_RING]');
     *     $response = $keyManagementServiceClient->getKeyRing($formattedName);
     * } finally {
     *     $keyManagementServiceClient->close();
     * }
     * ```
     *
     * @param string $name         The [name][google.cloud.kms.v1.KeyRing.name] of the [KeyRing][google.cloud.kms.v1.KeyRing] to get.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Kms\V1\KeyRing
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function getKeyRing($name, array $optionalArgs = [])
    {
        $request = new GetKeyRingRequest();
        $request->setName($name);

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'GetKeyRing',
            KeyRing::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Returns metadata for a given [CryptoKey][google.cloud.kms.v1.CryptoKey], as well as its
     * [primary][google.cloud.kms.v1.CryptoKey.primary] [CryptoKeyVersion][google.cloud.kms.v1.CryptoKeyVersion].
     *
     * Sample code:
     * ```
     * $keyManagementServiceClient = new KeyManagementServiceClient();
     * try {
     *     $formattedName = $keyManagementServiceClient->cryptoKeyName('[PROJECT]', '[LOCATION]', '[KEY_RING]', '[CRYPTO_KEY]');
     *     $response = $keyManagementServiceClient->getCryptoKey($formattedName);
     * } finally {
     *     $keyManagementServiceClient->close();
     * }
     * ```
     *
     * @param string $name         The [name][google.cloud.kms.v1.CryptoKey.name] of the [CryptoKey][google.cloud.kms.v1.CryptoKey] to get.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Kms\V1\CryptoKey
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function getCryptoKey($name, array $optionalArgs = [])
    {
        $request = new GetCryptoKeyRequest();
        $request->setName($name);

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'GetCryptoKey',
            CryptoKey::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Returns metadata for a given [CryptoKeyVersion][google.cloud.kms.v1.CryptoKeyVersion].
     *
     * Sample code:
     * ```
     * $keyManagementServiceClient = new KeyManagementServiceClient();
     * try {
     *     $formattedName = $keyManagementServiceClient->cryptoKeyVersionName('[PROJECT]', '[LOCATION]', '[KEY_RING]', '[CRYPTO_KEY]', '[CRYPTO_KEY_VERSION]');
     *     $response = $keyManagementServiceClient->getCryptoKeyVersion($formattedName);
     * } finally {
     *     $keyManagementServiceClient->close();
     * }
     * ```
     *
     * @param string $name         The [name][google.cloud.kms.v1.CryptoKeyVersion.name] of the [CryptoKeyVersion][google.cloud.kms.v1.CryptoKeyVersion] to get.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Kms\V1\CryptoKeyVersion
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function getCryptoKeyVersion($name, array $optionalArgs = [])
    {
        $request = new GetCryptoKeyVersionRequest();
        $request->setName($name);

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'GetCryptoKeyVersion',
            CryptoKeyVersion::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Create a new [KeyRing][google.cloud.kms.v1.KeyRing] in a given Project and Location.
     *
     * Sample code:
     * ```
     * $keyManagementServiceClient = new KeyManagementServiceClient();
     * try {
     *     $formattedParent = $keyManagementServiceClient->locationName('[PROJECT]', '[LOCATION]');
     *     $keyRingId = '';
     *     $keyRing = new KeyRing();
     *     $response = $keyManagementServiceClient->createKeyRing($formattedParent, $keyRingId, $keyRing);
     * } finally {
     *     $keyManagementServiceClient->close();
     * }
     * ```
     *
     * @param string  $parent       Required. The resource name of the location associated with the
     *                              [KeyRings][google.cloud.kms.v1.KeyRing], in the format `projects/&#42;/locations/*`.
     * @param string  $keyRingId    Required. It must be unique within a location and match the regular
     *                              expression `[a-zA-Z0-9_-]{1,63}`
     * @param KeyRing $keyRing      A [KeyRing][google.cloud.kms.v1.KeyRing] with initial field values.
     * @param array   $optionalArgs {
     *                              Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Kms\V1\KeyRing
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function createKeyRing($parent, $keyRingId, $keyRing, array $optionalArgs = [])
    {
        $request = new CreateKeyRingRequest();
        $request->setParent($parent);
        $request->setKeyRingId($keyRingId);
        $request->setKeyRing($keyRing);

        $requestParams = new RequestParamsHeaderDescriptor([
          'parent' => $request->getParent(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'CreateKeyRing',
            KeyRing::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Create a new [CryptoKey][google.cloud.kms.v1.CryptoKey] within a [KeyRing][google.cloud.kms.v1.KeyRing].
     *
     * [CryptoKey.purpose][google.cloud.kms.v1.CryptoKey.purpose] is required.
     *
     * Sample code:
     * ```
     * $keyManagementServiceClient = new KeyManagementServiceClient();
     * try {
     *     $formattedParent = $keyManagementServiceClient->keyRingName('[PROJECT]', '[LOCATION]', '[KEY_RING]');
     *     $cryptoKeyId = 'my-app-key';
     *     $purpose = CryptoKeyPurpose::ENCRYPT_DECRYPT;
     *     $seconds = 2147483647;
     *     $nextRotationTime = new Timestamp();
     *     $nextRotationTime->setSeconds($seconds);
     *     $seconds2 = 604800;
     *     $rotationPeriod = new Duration();
     *     $rotationPeriod->setSeconds($seconds2);
     *     $cryptoKey = new CryptoKey();
     *     $cryptoKey->setPurpose($purpose);
     *     $cryptoKey->setNextRotationTime($nextRotationTime);
     *     $cryptoKey->setRotationPeriod($rotationPeriod);
     *     $response = $keyManagementServiceClient->createCryptoKey($formattedParent, $cryptoKeyId, $cryptoKey);
     * } finally {
     *     $keyManagementServiceClient->close();
     * }
     * ```
     *
     * @param string    $parent       Required. The [name][google.cloud.kms.v1.KeyRing.name] of the KeyRing associated with the
     *                                [CryptoKeys][google.cloud.kms.v1.CryptoKey].
     * @param string    $cryptoKeyId  Required. It must be unique within a KeyRing and match the regular
     *                                expression `[a-zA-Z0-9_-]{1,63}`
     * @param CryptoKey $cryptoKey    A [CryptoKey][google.cloud.kms.v1.CryptoKey] with initial field values.
     * @param array     $optionalArgs {
     *                                Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Kms\V1\CryptoKey
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function createCryptoKey($parent, $cryptoKeyId, $cryptoKey, array $optionalArgs = [])
    {
        $request = new CreateCryptoKeyRequest();
        $request->setParent($parent);
        $request->setCryptoKeyId($cryptoKeyId);
        $request->setCryptoKey($cryptoKey);

        $requestParams = new RequestParamsHeaderDescriptor([
          'parent' => $request->getParent(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'CreateCryptoKey',
            CryptoKey::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Create a new [CryptoKeyVersion][google.cloud.kms.v1.CryptoKeyVersion] in a [CryptoKey][google.cloud.kms.v1.CryptoKey].
     *
     * The server will assign the next sequential id. If unset,
     * [state][google.cloud.kms.v1.CryptoKeyVersion.state] will be set to
     * [ENABLED][google.cloud.kms.v1.CryptoKeyVersion.CryptoKeyVersionState.ENABLED].
     *
     * Sample code:
     * ```
     * $keyManagementServiceClient = new KeyManagementServiceClient();
     * try {
     *     $formattedParent = $keyManagementServiceClient->cryptoKeyName('[PROJECT]', '[LOCATION]', '[KEY_RING]', '[CRYPTO_KEY]');
     *     $cryptoKeyVersion = new CryptoKeyVersion();
     *     $response = $keyManagementServiceClient->createCryptoKeyVersion($formattedParent, $cryptoKeyVersion);
     * } finally {
     *     $keyManagementServiceClient->close();
     * }
     * ```
     *
     * @param string           $parent           Required. The [name][google.cloud.kms.v1.CryptoKey.name] of the [CryptoKey][google.cloud.kms.v1.CryptoKey] associated with
     *                                           the [CryptoKeyVersions][google.cloud.kms.v1.CryptoKeyVersion].
     * @param CryptoKeyVersion $cryptoKeyVersion A [CryptoKeyVersion][google.cloud.kms.v1.CryptoKeyVersion] with initial field values.
     * @param array            $optionalArgs     {
     *                                           Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Kms\V1\CryptoKeyVersion
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function createCryptoKeyVersion($parent, $cryptoKeyVersion, array $optionalArgs = [])
    {
        $request = new CreateCryptoKeyVersionRequest();
        $request->setParent($parent);
        $request->setCryptoKeyVersion($cryptoKeyVersion);

        $requestParams = new RequestParamsHeaderDescriptor([
          'parent' => $request->getParent(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'CreateCryptoKeyVersion',
            CryptoKeyVersion::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Update a [CryptoKey][google.cloud.kms.v1.CryptoKey].
     *
     * Sample code:
     * ```
     * $keyManagementServiceClient = new KeyManagementServiceClient();
     * try {
     *     $cryptoKey = new CryptoKey();
     *     $updateMask = new FieldMask();
     *     $response = $keyManagementServiceClient->updateCryptoKey($cryptoKey, $updateMask);
     * } finally {
     *     $keyManagementServiceClient->close();
     * }
     * ```
     *
     * @param CryptoKey $cryptoKey    [CryptoKey][google.cloud.kms.v1.CryptoKey] with updated values.
     * @param FieldMask $updateMask   Required list of fields to be updated in this request.
     * @param array     $optionalArgs {
     *                                Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Kms\V1\CryptoKey
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function updateCryptoKey($cryptoKey, $updateMask, array $optionalArgs = [])
    {
        $request = new UpdateCryptoKeyRequest();
        $request->setCryptoKey($cryptoKey);
        $request->setUpdateMask($updateMask);

        $requestParams = new RequestParamsHeaderDescriptor([
          'crypto_key.name' => $request->getCryptoKey()->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'UpdateCryptoKey',
            CryptoKey::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Update a [CryptoKeyVersion][google.cloud.kms.v1.CryptoKeyVersion]'s metadata.
     *
     * [state][google.cloud.kms.v1.CryptoKeyVersion.state] may be changed between
     * [ENABLED][google.cloud.kms.v1.CryptoKeyVersion.CryptoKeyVersionState.ENABLED] and
     * [DISABLED][google.cloud.kms.v1.CryptoKeyVersion.CryptoKeyVersionState.DISABLED] using this
     * method. See [DestroyCryptoKeyVersion][google.cloud.kms.v1.KeyManagementService.DestroyCryptoKeyVersion] and [RestoreCryptoKeyVersion][google.cloud.kms.v1.KeyManagementService.RestoreCryptoKeyVersion] to
     * move between other states.
     *
     * Sample code:
     * ```
     * $keyManagementServiceClient = new KeyManagementServiceClient();
     * try {
     *     $cryptoKeyVersion = new CryptoKeyVersion();
     *     $updateMask = new FieldMask();
     *     $response = $keyManagementServiceClient->updateCryptoKeyVersion($cryptoKeyVersion, $updateMask);
     * } finally {
     *     $keyManagementServiceClient->close();
     * }
     * ```
     *
     * @param CryptoKeyVersion $cryptoKeyVersion [CryptoKeyVersion][google.cloud.kms.v1.CryptoKeyVersion] with updated values.
     * @param FieldMask        $updateMask       Required list of fields to be updated in this request.
     * @param array            $optionalArgs     {
     *                                           Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Kms\V1\CryptoKeyVersion
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function updateCryptoKeyVersion($cryptoKeyVersion, $updateMask, array $optionalArgs = [])
    {
        $request = new UpdateCryptoKeyVersionRequest();
        $request->setCryptoKeyVersion($cryptoKeyVersion);
        $request->setUpdateMask($updateMask);

        $requestParams = new RequestParamsHeaderDescriptor([
          'crypto_key_version.name' => $request->getCryptoKeyVersion()->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'UpdateCryptoKeyVersion',
            CryptoKeyVersion::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Encrypts data, so that it can only be recovered by a call to [Decrypt][google.cloud.kms.v1.KeyManagementService.Decrypt].
     *
     * Sample code:
     * ```
     * $keyManagementServiceClient = new KeyManagementServiceClient();
     * try {
     *     $formattedName = $keyManagementServiceClient->cryptoKeyPathName('[PROJECT]', '[LOCATION]', '[KEY_RING]', '[CRYPTO_KEY_PATH]');
     *     $plaintext = '';
     *     $response = $keyManagementServiceClient->encrypt($formattedName, $plaintext);
     * } finally {
     *     $keyManagementServiceClient->close();
     * }
     * ```
     *
     * @param string $name Required. The resource name of the [CryptoKey][google.cloud.kms.v1.CryptoKey] or [CryptoKeyVersion][google.cloud.kms.v1.CryptoKeyVersion]
     *                     to use for encryption.
     *
     * If a [CryptoKey][google.cloud.kms.v1.CryptoKey] is specified, the server will use its
     * [primary version][google.cloud.kms.v1.CryptoKey.primary].
     * @param string $plaintext    Required. The data to encrypt. Must be no larger than 64KiB.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type string $additionalAuthenticatedData
     *          Optional data that, if specified, must also be provided during decryption
     *          through [DecryptRequest.additional_authenticated_data][google.cloud.kms.v1.DecryptRequest.additional_authenticated_data].  Must be no
     *          larger than 64KiB.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Kms\V1\EncryptResponse
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function encrypt($name, $plaintext, array $optionalArgs = [])
    {
        $request = new EncryptRequest();
        $request->setName($name);
        $request->setPlaintext($plaintext);
        if (isset($optionalArgs['additionalAuthenticatedData'])) {
            $request->setAdditionalAuthenticatedData($optionalArgs['additionalAuthenticatedData']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'Encrypt',
            EncryptResponse::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Decrypts data that was protected by [Encrypt][google.cloud.kms.v1.KeyManagementService.Encrypt].
     *
     * Sample code:
     * ```
     * $keyManagementServiceClient = new KeyManagementServiceClient();
     * try {
     *     $formattedName = $keyManagementServiceClient->cryptoKeyName('[PROJECT]', '[LOCATION]', '[KEY_RING]', '[CRYPTO_KEY]');
     *     $ciphertext = '';
     *     $response = $keyManagementServiceClient->decrypt($formattedName, $ciphertext);
     * } finally {
     *     $keyManagementServiceClient->close();
     * }
     * ```
     *
     * @param string $name         Required. The resource name of the [CryptoKey][google.cloud.kms.v1.CryptoKey] to use for decryption.
     *                             The server will choose the appropriate version.
     * @param string $ciphertext   Required. The encrypted data originally returned in
     *                             [EncryptResponse.ciphertext][google.cloud.kms.v1.EncryptResponse.ciphertext].
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type string $additionalAuthenticatedData
     *          Optional data that must match the data originally supplied in
     *          [EncryptRequest.additional_authenticated_data][google.cloud.kms.v1.EncryptRequest.additional_authenticated_data].
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Kms\V1\DecryptResponse
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function decrypt($name, $ciphertext, array $optionalArgs = [])
    {
        $request = new DecryptRequest();
        $request->setName($name);
        $request->setCiphertext($ciphertext);
        if (isset($optionalArgs['additionalAuthenticatedData'])) {
            $request->setAdditionalAuthenticatedData($optionalArgs['additionalAuthenticatedData']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'Decrypt',
            DecryptResponse::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Update the version of a [CryptoKey][google.cloud.kms.v1.CryptoKey] that will be used in [Encrypt][google.cloud.kms.v1.KeyManagementService.Encrypt].
     *
     * Sample code:
     * ```
     * $keyManagementServiceClient = new KeyManagementServiceClient();
     * try {
     *     $formattedName = $keyManagementServiceClient->cryptoKeyName('[PROJECT]', '[LOCATION]', '[KEY_RING]', '[CRYPTO_KEY]');
     *     $cryptoKeyVersionId = '';
     *     $response = $keyManagementServiceClient->updateCryptoKeyPrimaryVersion($formattedName, $cryptoKeyVersionId);
     * } finally {
     *     $keyManagementServiceClient->close();
     * }
     * ```
     *
     * @param string $name               The resource name of the [CryptoKey][google.cloud.kms.v1.CryptoKey] to update.
     * @param string $cryptoKeyVersionId The id of the child [CryptoKeyVersion][google.cloud.kms.v1.CryptoKeyVersion] to use as primary.
     * @param array  $optionalArgs       {
     *                                   Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Kms\V1\CryptoKey
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function updateCryptoKeyPrimaryVersion($name, $cryptoKeyVersionId, array $optionalArgs = [])
    {
        $request = new UpdateCryptoKeyPrimaryVersionRequest();
        $request->setName($name);
        $request->setCryptoKeyVersionId($cryptoKeyVersionId);

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'UpdateCryptoKeyPrimaryVersion',
            CryptoKey::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Schedule a [CryptoKeyVersion][google.cloud.kms.v1.CryptoKeyVersion] for destruction.
     *
     * Upon calling this method, [CryptoKeyVersion.state][google.cloud.kms.v1.CryptoKeyVersion.state] will be set to
     * [DESTROY_SCHEDULED][google.cloud.kms.v1.CryptoKeyVersion.CryptoKeyVersionState.DESTROY_SCHEDULED]
     * and [destroy_time][google.cloud.kms.v1.CryptoKeyVersion.destroy_time] will be set to a time 24
     * hours in the future, at which point the [state][google.cloud.kms.v1.CryptoKeyVersion.state]
     * will be changed to
     * [DESTROYED][google.cloud.kms.v1.CryptoKeyVersion.CryptoKeyVersionState.DESTROYED], and the key
     * material will be irrevocably destroyed.
     *
     * Before the [destroy_time][google.cloud.kms.v1.CryptoKeyVersion.destroy_time] is reached,
     * [RestoreCryptoKeyVersion][google.cloud.kms.v1.KeyManagementService.RestoreCryptoKeyVersion] may be called to reverse the process.
     *
     * Sample code:
     * ```
     * $keyManagementServiceClient = new KeyManagementServiceClient();
     * try {
     *     $formattedName = $keyManagementServiceClient->cryptoKeyVersionName('[PROJECT]', '[LOCATION]', '[KEY_RING]', '[CRYPTO_KEY]', '[CRYPTO_KEY_VERSION]');
     *     $response = $keyManagementServiceClient->destroyCryptoKeyVersion($formattedName);
     * } finally {
     *     $keyManagementServiceClient->close();
     * }
     * ```
     *
     * @param string $name         The resource name of the [CryptoKeyVersion][google.cloud.kms.v1.CryptoKeyVersion] to destroy.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Kms\V1\CryptoKeyVersion
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function destroyCryptoKeyVersion($name, array $optionalArgs = [])
    {
        $request = new DestroyCryptoKeyVersionRequest();
        $request->setName($name);

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'DestroyCryptoKeyVersion',
            CryptoKeyVersion::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Restore a [CryptoKeyVersion][google.cloud.kms.v1.CryptoKeyVersion] in the
     * [DESTROY_SCHEDULED][google.cloud.kms.v1.CryptoKeyVersion.CryptoKeyVersionState.DESTROY_SCHEDULED],
     * state.
     *
     * Upon restoration of the CryptoKeyVersion, [state][google.cloud.kms.v1.CryptoKeyVersion.state]
     * will be set to [DISABLED][google.cloud.kms.v1.CryptoKeyVersion.CryptoKeyVersionState.DISABLED],
     * and [destroy_time][google.cloud.kms.v1.CryptoKeyVersion.destroy_time] will be cleared.
     *
     * Sample code:
     * ```
     * $keyManagementServiceClient = new KeyManagementServiceClient();
     * try {
     *     $formattedName = $keyManagementServiceClient->cryptoKeyVersionName('[PROJECT]', '[LOCATION]', '[KEY_RING]', '[CRYPTO_KEY]', '[CRYPTO_KEY_VERSION]');
     *     $response = $keyManagementServiceClient->restoreCryptoKeyVersion($formattedName);
     * } finally {
     *     $keyManagementServiceClient->close();
     * }
     * ```
     *
     * @param string $name         The resource name of the [CryptoKeyVersion][google.cloud.kms.v1.CryptoKeyVersion] to restore.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Kms\V1\CryptoKeyVersion
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function restoreCryptoKeyVersion($name, array $optionalArgs = [])
    {
        $request = new RestoreCryptoKeyVersionRequest();
        $request->setName($name);

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'RestoreCryptoKeyVersion',
            CryptoKeyVersion::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Sets the access control policy on the specified resource. Replaces any
     * existing policy.
     *
     * Sample code:
     * ```
     * $keyManagementServiceClient = new KeyManagementServiceClient();
     * try {
     *     $formattedResource = $keyManagementServiceClient->keyRingName('[PROJECT]', '[LOCATION]', '[KEY_RING]');
     *     $policy = new Policy();
     *     $response = $keyManagementServiceClient->setIamPolicy($formattedResource, $policy);
     * } finally {
     *     $keyManagementServiceClient->close();
     * }
     * ```
     *
     * @param string $resource     REQUIRED: The resource for which the policy is being specified.
     *                             `resource` is usually specified as a path. For example, a Project
     *                             resource is specified as `projects/{project}`.
     * @param Policy $policy       REQUIRED: The complete policy to be applied to the `resource`. The size of
     *                             the policy is limited to a few 10s of KB. An empty policy is a
     *                             valid policy but certain Cloud Platform services (such as Projects)
     *                             might reject them.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Iam\V1\Policy
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function setIamPolicy($resource, $policy, array $optionalArgs = [])
    {
        $request = new SetIamPolicyRequest();
        $request->setResource($resource);
        $request->setPolicy($policy);

        $requestParams = new RequestParamsHeaderDescriptor([
          'resource' => $request->getResource(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'SetIamPolicy',
            Policy::class,
            $optionalArgs,
            $request,
            Call::UNARY_CALL,
            'google.iam.v1.IAMPolicy'
        )->wait();
    }

    /**
     * Gets the access control policy for a resource.
     * Returns an empty policy if the resource exists and does not have a policy
     * set.
     *
     * Sample code:
     * ```
     * $keyManagementServiceClient = new KeyManagementServiceClient();
     * try {
     *     $formattedResource = $keyManagementServiceClient->keyRingName('[PROJECT]', '[LOCATION]', '[KEY_RING]');
     *     $response = $keyManagementServiceClient->getIamPolicy($formattedResource);
     * } finally {
     *     $keyManagementServiceClient->close();
     * }
     * ```
     *
     * @param string $resource     REQUIRED: The resource for which the policy is being requested.
     *                             `resource` is usually specified as a path. For example, a Project
     *                             resource is specified as `projects/{project}`.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Iam\V1\Policy
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function getIamPolicy($resource, array $optionalArgs = [])
    {
        $request = new GetIamPolicyRequest();
        $request->setResource($resource);

        $requestParams = new RequestParamsHeaderDescriptor([
          'resource' => $request->getResource(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'GetIamPolicy',
            Policy::class,
            $optionalArgs,
            $request,
            Call::UNARY_CALL,
            'google.iam.v1.IAMPolicy'
        )->wait();
    }

    /**
     * Returns permissions that a caller has on the specified resource.
     * If the resource does not exist, this will return an empty set of
     * permissions, not a NOT_FOUND error.
     *
     * Sample code:
     * ```
     * $keyManagementServiceClient = new KeyManagementServiceClient();
     * try {
     *     $formattedResource = $keyManagementServiceClient->keyRingName('[PROJECT]', '[LOCATION]', '[KEY_RING]');
     *     $permissions = [];
     *     $response = $keyManagementServiceClient->testIamPermissions($formattedResource, $permissions);
     * } finally {
     *     $keyManagementServiceClient->close();
     * }
     * ```
     *
     * @param string   $resource     REQUIRED: The resource for which the policy detail is being requested.
     *                               `resource` is usually specified as a path. For example, a Project
     *                               resource is specified as `projects/{project}`.
     * @param string[] $permissions  The set of permissions to check for the `resource`. Permissions with
     *                               wildcards (such as '*' or 'storage.*') are not allowed. For more
     *                               information see
     *                               [IAM Overview](https://cloud.google.com/iam/docs/overview#permissions).
     * @param array    $optionalArgs {
     *                               Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Iam\V1\TestIamPermissionsResponse
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function testIamPermissions($resource, $permissions, array $optionalArgs = [])
    {
        $request = new TestIamPermissionsRequest();
        $request->setResource($resource);
        $request->setPermissions($permissions);

        $requestParams = new RequestParamsHeaderDescriptor([
          'resource' => $request->getResource(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'TestIamPermissions',
            TestIamPermissionsResponse::class,
            $optionalArgs,
            $request,
            Call::UNARY_CALL,
            'google.iam.v1.IAMPolicy'
        )->wait();
    }
}

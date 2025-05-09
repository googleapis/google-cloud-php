<?php
/*
 * Copyright 2025 Google LLC
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
 * Generated by gapic-generator-php from the file
 * https://github.com/googleapis/googleapis/blob/master/google/iam/v3/principal_access_boundary_policies_service.proto
 * Updates to the above are reflected here through a refresh process.
 */

namespace Google\Cloud\Iam\V3\Client;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\GapicClientTrait;
use Google\ApiCore\OperationResponse;
use Google\ApiCore\PagedListResponse;
use Google\ApiCore\ResourceHelperTrait;
use Google\ApiCore\RetrySettings;
use Google\ApiCore\Transport\TransportInterface;
use Google\ApiCore\ValidationException;
use Google\Auth\FetchAuthTokenInterface;
use Google\Cloud\Iam\V3\CreatePrincipalAccessBoundaryPolicyRequest;
use Google\Cloud\Iam\V3\DeletePrincipalAccessBoundaryPolicyRequest;
use Google\Cloud\Iam\V3\GetPrincipalAccessBoundaryPolicyRequest;
use Google\Cloud\Iam\V3\ListPrincipalAccessBoundaryPoliciesRequest;
use Google\Cloud\Iam\V3\PrincipalAccessBoundaryPolicy;
use Google\Cloud\Iam\V3\SearchPrincipalAccessBoundaryPolicyBindingsRequest;
use Google\Cloud\Iam\V3\UpdatePrincipalAccessBoundaryPolicyRequest;
use Google\LongRunning\Client\OperationsClient;
use Google\LongRunning\Operation;
use GuzzleHttp\Promise\PromiseInterface;
use Psr\Log\LoggerInterface;

/**
 * Service Description: Manages Identity and Access Management (IAM) principal access boundary
 * policies.
 *
 * This class provides the ability to make remote calls to the backing service through method
 * calls that map to API methods.
 *
 * Many parameters require resource names to be formatted in a particular way. To
 * assist with these names, this class includes a format method for each type of
 * name, and additionally a parseName method to extract the individual identifiers
 * contained within formatted names that are returned by the API.
 *
 * @method PromiseInterface<OperationResponse> createPrincipalAccessBoundaryPolicyAsync(CreatePrincipalAccessBoundaryPolicyRequest $request, array $optionalArgs = [])
 * @method PromiseInterface<OperationResponse> deletePrincipalAccessBoundaryPolicyAsync(DeletePrincipalAccessBoundaryPolicyRequest $request, array $optionalArgs = [])
 * @method PromiseInterface<PrincipalAccessBoundaryPolicy> getPrincipalAccessBoundaryPolicyAsync(GetPrincipalAccessBoundaryPolicyRequest $request, array $optionalArgs = [])
 * @method PromiseInterface<PagedListResponse> listPrincipalAccessBoundaryPoliciesAsync(ListPrincipalAccessBoundaryPoliciesRequest $request, array $optionalArgs = [])
 * @method PromiseInterface<PagedListResponse> searchPrincipalAccessBoundaryPolicyBindingsAsync(SearchPrincipalAccessBoundaryPolicyBindingsRequest $request, array $optionalArgs = [])
 * @method PromiseInterface<OperationResponse> updatePrincipalAccessBoundaryPolicyAsync(UpdatePrincipalAccessBoundaryPolicyRequest $request, array $optionalArgs = [])
 */
final class PrincipalAccessBoundaryPoliciesClient
{
    use GapicClientTrait;
    use ResourceHelperTrait;

    /** The name of the service. */
    private const SERVICE_NAME = 'google.iam.v3.PrincipalAccessBoundaryPolicies';

    /**
     * The default address of the service.
     *
     * @deprecated SERVICE_ADDRESS_TEMPLATE should be used instead.
     */
    private const SERVICE_ADDRESS = 'iam.googleapis.com';

    /** The address template of the service. */
    private const SERVICE_ADDRESS_TEMPLATE = 'iam.UNIVERSE_DOMAIN';

    /** The default port of the service. */
    private const DEFAULT_SERVICE_PORT = 443;

    /** The name of the code generator, to be included in the agent header. */
    private const CODEGEN_NAME = 'gapic';

    /** The default scopes required by the service. */
    public static $serviceScopes = ['https://www.googleapis.com/auth/cloud-platform'];

    private $operationsClient;

    private static function getClientDefaults()
    {
        return [
            'serviceName' => self::SERVICE_NAME,
            'apiEndpoint' => self::SERVICE_ADDRESS . ':' . self::DEFAULT_SERVICE_PORT,
            'clientConfig' => __DIR__ . '/../resources/principal_access_boundary_policies_client_config.json',
            'descriptorsConfigPath' =>
                __DIR__ . '/../resources/principal_access_boundary_policies_descriptor_config.php',
            'gcpApiConfigPath' => __DIR__ . '/../resources/principal_access_boundary_policies_grpc_config.json',
            'credentialsConfig' => [
                'defaultScopes' => self::$serviceScopes,
            ],
            'transportConfig' => [
                'rest' => [
                    'restClientConfigPath' =>
                        __DIR__ . '/../resources/principal_access_boundary_policies_rest_client_config.php',
                ],
            ],
        ];
    }

    /**
     * Return an OperationsClient object with the same endpoint as $this.
     *
     * @return OperationsClient
     */
    public function getOperationsClient()
    {
        return $this->operationsClient;
    }

    /**
     * Resume an existing long running operation that was previously started by a long
     * running API method. If $methodName is not provided, or does not match a long
     * running API method, then the operation can still be resumed, but the
     * OperationResponse object will not deserialize the final response.
     *
     * @param string $operationName The name of the long running operation
     * @param string $methodName    The name of the method used to start the operation
     *
     * @return OperationResponse
     */
    public function resumeOperation($operationName, $methodName = null)
    {
        $options = isset($this->descriptors[$methodName]['longRunning'])
            ? $this->descriptors[$methodName]['longRunning']
            : [];
        $operation = new OperationResponse($operationName, $this->getOperationsClient(), $options);
        $operation->reload();
        return $operation;
    }

    /**
     * Create the default operation client for the service.
     *
     * @param array $options ClientOptions for the client.
     *
     * @return OperationsClient
     */
    private function createOperationsClient(array $options)
    {
        // Unset client-specific configuration options
        unset($options['serviceName'], $options['clientConfig'], $options['descriptorsConfigPath']);

        if (isset($options['operationsClient'])) {
            return $options['operationsClient'];
        }

        return new OperationsClient($options);
    }

    /**
     * Formats a string containing the fully-qualified path to represent a
     * organization_location resource.
     *
     * @param string $organization
     * @param string $location
     *
     * @return string The formatted organization_location resource.
     */
    public static function organizationLocationName(string $organization, string $location): string
    {
        return self::getPathTemplate('organizationLocation')->render([
            'organization' => $organization,
            'location' => $location,
        ]);
    }

    /**
     * Formats a string containing the fully-qualified path to represent a
     * principal_access_boundary_policy resource.
     *
     * @param string $organization
     * @param string $location
     * @param string $principalAccessBoundaryPolicy
     *
     * @return string The formatted principal_access_boundary_policy resource.
     */
    public static function principalAccessBoundaryPolicyName(
        string $organization,
        string $location,
        string $principalAccessBoundaryPolicy
    ): string {
        return self::getPathTemplate('principalAccessBoundaryPolicy')->render([
            'organization' => $organization,
            'location' => $location,
            'principal_access_boundary_policy' => $principalAccessBoundaryPolicy,
        ]);
    }

    /**
     * Parses a formatted name string and returns an associative array of the components in the name.
     * The following name formats are supported:
     * Template: Pattern
     * - organizationLocation: organizations/{organization}/locations/{location}
     * - principalAccessBoundaryPolicy: organizations/{organization}/locations/{location}/principalAccessBoundaryPolicies/{principal_access_boundary_policy}
     *
     * The optional $template argument can be supplied to specify a particular pattern,
     * and must match one of the templates listed above. If no $template argument is
     * provided, or if the $template argument does not match one of the templates
     * listed, then parseName will check each of the supported templates, and return
     * the first match.
     *
     * @param string  $formattedName The formatted name string
     * @param ?string $template      Optional name of template to match
     *
     * @return array An associative array from name component IDs to component values.
     *
     * @throws ValidationException If $formattedName could not be matched.
     */
    public static function parseName(string $formattedName, ?string $template = null): array
    {
        return self::parseFormattedName($formattedName, $template);
    }

    /**
     * Constructor.
     *
     * @param array $options {
     *     Optional. Options for configuring the service API wrapper.
     *
     *     @type string $apiEndpoint
     *           The address of the API remote host. May optionally include the port, formatted
     *           as "<uri>:<port>". Default 'iam.googleapis.com:443'.
     *     @type string|array|FetchAuthTokenInterface|CredentialsWrapper $credentials
     *           The credentials to be used by the client to authorize API calls. This option
     *           accepts either a path to a credentials file, or a decoded credentials file as a
     *           PHP array.
     *           *Advanced usage*: In addition, this option can also accept a pre-constructed
     *           {@see \Google\Auth\FetchAuthTokenInterface} object or
     *           {@see \Google\ApiCore\CredentialsWrapper} object. Note that when one of these
     *           objects are provided, any settings in $credentialsConfig will be ignored.
     *           *Important*: If you accept a credential configuration (credential
     *           JSON/File/Stream) from an external source for authentication to Google Cloud
     *           Platform, you must validate it before providing it to any Google API or library.
     *           Providing an unvalidated credential configuration to Google APIs can compromise
     *           the security of your systems and data. For more information {@see
     *           https://cloud.google.com/docs/authentication/external/externally-sourced-credentials}
     *     @type array $credentialsConfig
     *           Options used to configure credentials, including auth token caching, for the
     *           client. For a full list of supporting configuration options, see
     *           {@see \Google\ApiCore\CredentialsWrapper::build()} .
     *     @type bool $disableRetries
     *           Determines whether or not retries defined by the client configuration should be
     *           disabled. Defaults to `false`.
     *     @type string|array $clientConfig
     *           Client method configuration, including retry settings. This option can be either
     *           a path to a JSON file, or a PHP array containing the decoded JSON data. By
     *           default this settings points to the default client config file, which is
     *           provided in the resources folder.
     *     @type string|TransportInterface $transport
     *           The transport used for executing network requests. May be either the string
     *           `rest` or `grpc`. Defaults to `grpc` if gRPC support is detected on the system.
     *           *Advanced usage*: Additionally, it is possible to pass in an already
     *           instantiated {@see \Google\ApiCore\Transport\TransportInterface} object. Note
     *           that when this object is provided, any settings in $transportConfig, and any
     *           $apiEndpoint setting, will be ignored.
     *     @type array $transportConfig
     *           Configuration options that will be used to construct the transport. Options for
     *           each supported transport type should be passed in a key for that transport. For
     *           example:
     *           $transportConfig = [
     *               'grpc' => [...],
     *               'rest' => [...],
     *           ];
     *           See the {@see \Google\ApiCore\Transport\GrpcTransport::build()} and
     *           {@see \Google\ApiCore\Transport\RestTransport::build()} methods for the
     *           supported options.
     *     @type callable $clientCertSource
     *           A callable which returns the client cert as a string. This can be used to
     *           provide a certificate and private key to the transport layer for mTLS.
     *     @type false|LoggerInterface $logger
     *           A PSR-3 compliant logger. If set to false, logging is disabled, ignoring the
     *           'GOOGLE_SDK_PHP_LOGGING' environment flag
     * }
     *
     * @throws ValidationException
     */
    public function __construct(array $options = [])
    {
        $clientOptions = $this->buildClientOptions($options);
        $this->setClientOptions($clientOptions);
        $this->operationsClient = $this->createOperationsClient($clientOptions);
    }

    /** Handles execution of the async variants for each documented method. */
    public function __call($method, $args)
    {
        if (substr($method, -5) !== 'Async') {
            trigger_error('Call to undefined method ' . __CLASS__ . "::$method()", E_USER_ERROR);
        }

        array_unshift($args, substr($method, 0, -5));
        return call_user_func_array([$this, 'startAsyncCall'], $args);
    }

    /**
     * Creates a principal access boundary policy, and returns a long running
     * operation.
     *
     * The async variant is
     * {@see PrincipalAccessBoundaryPoliciesClient::createPrincipalAccessBoundaryPolicyAsync()}
     * .
     *
     * @example samples/V3/PrincipalAccessBoundaryPoliciesClient/create_principal_access_boundary_policy.php
     *
     * @param CreatePrincipalAccessBoundaryPolicyRequest $request     A request to house fields associated with the call.
     * @param array                                      $callOptions {
     *     Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *           Retry settings to use for this call. Can be a {@see RetrySettings} object, or an
     *           associative array of retry settings parameters. See the documentation on
     *           {@see RetrySettings} for example usage.
     * }
     *
     * @return OperationResponse
     *
     * @throws ApiException Thrown if the API call fails.
     */
    public function createPrincipalAccessBoundaryPolicy(
        CreatePrincipalAccessBoundaryPolicyRequest $request,
        array $callOptions = []
    ): OperationResponse {
        return $this->startApiCall('CreatePrincipalAccessBoundaryPolicy', $request, $callOptions)->wait();
    }

    /**
     * Deletes a principal access boundary policy.
     *
     * The async variant is
     * {@see PrincipalAccessBoundaryPoliciesClient::deletePrincipalAccessBoundaryPolicyAsync()}
     * .
     *
     * @example samples/V3/PrincipalAccessBoundaryPoliciesClient/delete_principal_access_boundary_policy.php
     *
     * @param DeletePrincipalAccessBoundaryPolicyRequest $request     A request to house fields associated with the call.
     * @param array                                      $callOptions {
     *     Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *           Retry settings to use for this call. Can be a {@see RetrySettings} object, or an
     *           associative array of retry settings parameters. See the documentation on
     *           {@see RetrySettings} for example usage.
     * }
     *
     * @return OperationResponse
     *
     * @throws ApiException Thrown if the API call fails.
     */
    public function deletePrincipalAccessBoundaryPolicy(
        DeletePrincipalAccessBoundaryPolicyRequest $request,
        array $callOptions = []
    ): OperationResponse {
        return $this->startApiCall('DeletePrincipalAccessBoundaryPolicy', $request, $callOptions)->wait();
    }

    /**
     * Gets a principal access boundary policy.
     *
     * The async variant is
     * {@see PrincipalAccessBoundaryPoliciesClient::getPrincipalAccessBoundaryPolicyAsync()}
     * .
     *
     * @example samples/V3/PrincipalAccessBoundaryPoliciesClient/get_principal_access_boundary_policy.php
     *
     * @param GetPrincipalAccessBoundaryPolicyRequest $request     A request to house fields associated with the call.
     * @param array                                   $callOptions {
     *     Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *           Retry settings to use for this call. Can be a {@see RetrySettings} object, or an
     *           associative array of retry settings parameters. See the documentation on
     *           {@see RetrySettings} for example usage.
     * }
     *
     * @return PrincipalAccessBoundaryPolicy
     *
     * @throws ApiException Thrown if the API call fails.
     */
    public function getPrincipalAccessBoundaryPolicy(
        GetPrincipalAccessBoundaryPolicyRequest $request,
        array $callOptions = []
    ): PrincipalAccessBoundaryPolicy {
        return $this->startApiCall('GetPrincipalAccessBoundaryPolicy', $request, $callOptions)->wait();
    }

    /**
     * Lists principal access boundary policies.
     *
     * The async variant is
     * {@see PrincipalAccessBoundaryPoliciesClient::listPrincipalAccessBoundaryPoliciesAsync()}
     * .
     *
     * @example samples/V3/PrincipalAccessBoundaryPoliciesClient/list_principal_access_boundary_policies.php
     *
     * @param ListPrincipalAccessBoundaryPoliciesRequest $request     A request to house fields associated with the call.
     * @param array                                      $callOptions {
     *     Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *           Retry settings to use for this call. Can be a {@see RetrySettings} object, or an
     *           associative array of retry settings parameters. See the documentation on
     *           {@see RetrySettings} for example usage.
     * }
     *
     * @return PagedListResponse
     *
     * @throws ApiException Thrown if the API call fails.
     */
    public function listPrincipalAccessBoundaryPolicies(
        ListPrincipalAccessBoundaryPoliciesRequest $request,
        array $callOptions = []
    ): PagedListResponse {
        return $this->startApiCall('ListPrincipalAccessBoundaryPolicies', $request, $callOptions);
    }

    /**
     * Returns all policy bindings that bind a specific policy if a user has
     * searchPolicyBindings permission on that policy.
     *
     * The async variant is
     * {@see PrincipalAccessBoundaryPoliciesClient::searchPrincipalAccessBoundaryPolicyBindingsAsync()}
     * .
     *
     * @example samples/V3/PrincipalAccessBoundaryPoliciesClient/search_principal_access_boundary_policy_bindings.php
     *
     * @param SearchPrincipalAccessBoundaryPolicyBindingsRequest $request     A request to house fields associated with the call.
     * @param array                                              $callOptions {
     *     Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *           Retry settings to use for this call. Can be a {@see RetrySettings} object, or an
     *           associative array of retry settings parameters. See the documentation on
     *           {@see RetrySettings} for example usage.
     * }
     *
     * @return PagedListResponse
     *
     * @throws ApiException Thrown if the API call fails.
     */
    public function searchPrincipalAccessBoundaryPolicyBindings(
        SearchPrincipalAccessBoundaryPolicyBindingsRequest $request,
        array $callOptions = []
    ): PagedListResponse {
        return $this->startApiCall('SearchPrincipalAccessBoundaryPolicyBindings', $request, $callOptions);
    }

    /**
     * Updates a principal access boundary policy.
     *
     * The async variant is
     * {@see PrincipalAccessBoundaryPoliciesClient::updatePrincipalAccessBoundaryPolicyAsync()}
     * .
     *
     * @example samples/V3/PrincipalAccessBoundaryPoliciesClient/update_principal_access_boundary_policy.php
     *
     * @param UpdatePrincipalAccessBoundaryPolicyRequest $request     A request to house fields associated with the call.
     * @param array                                      $callOptions {
     *     Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *           Retry settings to use for this call. Can be a {@see RetrySettings} object, or an
     *           associative array of retry settings parameters. See the documentation on
     *           {@see RetrySettings} for example usage.
     * }
     *
     * @return OperationResponse
     *
     * @throws ApiException Thrown if the API call fails.
     */
    public function updatePrincipalAccessBoundaryPolicy(
        UpdatePrincipalAccessBoundaryPolicyRequest $request,
        array $callOptions = []
    ): OperationResponse {
        return $this->startApiCall('UpdatePrincipalAccessBoundaryPolicy', $request, $callOptions)->wait();
    }
}

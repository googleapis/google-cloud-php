<?php
/*
 * Copyright 2023 Google LLC
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
 * https://github.com/googleapis/googleapis/blob/master/google/cloud/compute/v1/compute.proto
 * Updates to the above are reflected here through a refresh process.
 */

namespace Google\Cloud\Compute\V1\Client;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\GapicClientTrait;
use Google\ApiCore\OperationResponse;
use Google\ApiCore\PagedListResponse;
use Google\ApiCore\RetrySettings;
use Google\ApiCore\Transport\TransportInterface;
use Google\ApiCore\ValidationException;
use Google\Auth\FetchAuthTokenInterface;
use Google\Cloud\Compute\V1\AggregatedListRoutersRequest;
use Google\Cloud\Compute\V1\DeleteRoutePolicyRouterRequest;
use Google\Cloud\Compute\V1\DeleteRouterRequest;
use Google\Cloud\Compute\V1\GetNatIpInfoRouterRequest;
use Google\Cloud\Compute\V1\GetNatMappingInfoRoutersRequest;
use Google\Cloud\Compute\V1\GetRoutePolicyRouterRequest;
use Google\Cloud\Compute\V1\GetRouterRequest;
use Google\Cloud\Compute\V1\GetRouterStatusRouterRequest;
use Google\Cloud\Compute\V1\InsertRouterRequest;
use Google\Cloud\Compute\V1\ListBgpRoutesRoutersRequest;
use Google\Cloud\Compute\V1\ListRoutePoliciesRoutersRequest;
use Google\Cloud\Compute\V1\ListRoutersRequest;
use Google\Cloud\Compute\V1\NatIpInfoResponse;
use Google\Cloud\Compute\V1\PatchRoutePolicyRouterRequest;
use Google\Cloud\Compute\V1\PatchRouterRequest;
use Google\Cloud\Compute\V1\PreviewRouterRequest;
use Google\Cloud\Compute\V1\RegionOperationsClient;
use Google\Cloud\Compute\V1\Router;
use Google\Cloud\Compute\V1\RouterStatusResponse;
use Google\Cloud\Compute\V1\RoutersGetRoutePolicyResponse;
use Google\Cloud\Compute\V1\RoutersListBgpRoutes;
use Google\Cloud\Compute\V1\RoutersListRoutePolicies;
use Google\Cloud\Compute\V1\RoutersPreviewResponse;
use Google\Cloud\Compute\V1\UpdateRoutePolicyRouterRequest;
use Google\Cloud\Compute\V1\UpdateRouterRequest;
use GuzzleHttp\Promise\PromiseInterface;
use Psr\Log\LoggerInterface;

/**
 * Service Description: The Routers API.
 *
 * This class provides the ability to make remote calls to the backing service through method
 * calls that map to API methods.
 *
 * @method PromiseInterface<PagedListResponse> aggregatedListAsync(AggregatedListRoutersRequest $request, array $optionalArgs = [])
 * @method PromiseInterface<OperationResponse> deleteAsync(DeleteRouterRequest $request, array $optionalArgs = [])
 * @method PromiseInterface<OperationResponse> deleteRoutePolicyAsync(DeleteRoutePolicyRouterRequest $request, array $optionalArgs = [])
 * @method PromiseInterface<Router> getAsync(GetRouterRequest $request, array $optionalArgs = [])
 * @method PromiseInterface<NatIpInfoResponse> getNatIpInfoAsync(GetNatIpInfoRouterRequest $request, array $optionalArgs = [])
 * @method PromiseInterface<PagedListResponse> getNatMappingInfoAsync(GetNatMappingInfoRoutersRequest $request, array $optionalArgs = [])
 * @method PromiseInterface<RoutersGetRoutePolicyResponse> getRoutePolicyAsync(GetRoutePolicyRouterRequest $request, array $optionalArgs = [])
 * @method PromiseInterface<RouterStatusResponse> getRouterStatusAsync(GetRouterStatusRouterRequest $request, array $optionalArgs = [])
 * @method PromiseInterface<OperationResponse> insertAsync(InsertRouterRequest $request, array $optionalArgs = [])
 * @method PromiseInterface<PagedListResponse> listAsync(ListRoutersRequest $request, array $optionalArgs = [])
 * @method PromiseInterface<RoutersListBgpRoutes> listBgpRoutesAsync(ListBgpRoutesRoutersRequest $request, array $optionalArgs = [])
 * @method PromiseInterface<RoutersListRoutePolicies> listRoutePoliciesAsync(ListRoutePoliciesRoutersRequest $request, array $optionalArgs = [])
 * @method PromiseInterface<OperationResponse> patchAsync(PatchRouterRequest $request, array $optionalArgs = [])
 * @method PromiseInterface<OperationResponse> patchRoutePolicyAsync(PatchRoutePolicyRouterRequest $request, array $optionalArgs = [])
 * @method PromiseInterface<RoutersPreviewResponse> previewAsync(PreviewRouterRequest $request, array $optionalArgs = [])
 * @method PromiseInterface<OperationResponse> updateAsync(UpdateRouterRequest $request, array $optionalArgs = [])
 * @method PromiseInterface<OperationResponse> updateRoutePolicyAsync(UpdateRoutePolicyRouterRequest $request, array $optionalArgs = [])
 */
final class RoutersClient
{
    use GapicClientTrait;

    /** The name of the service. */
    private const SERVICE_NAME = 'google.cloud.compute.v1.Routers';

    /**
     * The default address of the service.
     *
     * @deprecated SERVICE_ADDRESS_TEMPLATE should be used instead.
     */
    private const SERVICE_ADDRESS = 'compute.googleapis.com';

    /** The address template of the service. */
    private const SERVICE_ADDRESS_TEMPLATE = 'compute.UNIVERSE_DOMAIN';

    /** The default port of the service. */
    private const DEFAULT_SERVICE_PORT = 443;

    /** The name of the code generator, to be included in the agent header. */
    private const CODEGEN_NAME = 'gapic';

    /** The default scopes required by the service. */
    public static $serviceScopes = [
        'https://www.googleapis.com/auth/compute',
        'https://www.googleapis.com/auth/cloud-platform',
    ];

    private $operationsClient;

    private static function getClientDefaults()
    {
        return [
            'serviceName' => self::SERVICE_NAME,
            'apiEndpoint' => self::SERVICE_ADDRESS . ':' . self::DEFAULT_SERVICE_PORT,
            'clientConfig' => __DIR__ . '/../resources/routers_client_config.json',
            'descriptorsConfigPath' => __DIR__ . '/../resources/routers_descriptor_config.php',
            'credentialsConfig' => [
                'defaultScopes' => self::$serviceScopes,
                'useJwtAccessWithScope' => false,
            ],
            'transportConfig' => [
                'rest' => [
                    'restClientConfigPath' => __DIR__ . '/../resources/routers_rest_client_config.php',
                ],
            ],
            'operationsClientClass' => RegionOperationsClient::class,
        ];
    }

    /** Implements GapicClientTrait::defaultTransport. */
    private static function defaultTransport()
    {
        return 'rest';
    }

    /** Implements ClientOptionsTrait::supportedTransports. */
    private static function supportedTransports()
    {
        return [
            'rest',
        ];
    }

    /**
     * Return an RegionOperationsClient object with the same endpoint as $this.
     *
     * @return RegionOperationsClient
     */
    public function getOperationsClient()
    {
        return $this->operationsClient;
    }

    /** Return the default longrunning operation descriptor config. */
    private function getDefaultOperationDescriptor()
    {
        return [
            'additionalArgumentMethods' => [
                'getProject',
                'getRegion',
            ],
            'getOperationMethod' => 'get',
            'cancelOperationMethod' => null,
            'deleteOperationMethod' => 'delete',
            'operationErrorCodeMethod' => 'getHttpErrorStatusCode',
            'operationErrorMessageMethod' => 'getHttpErrorMessage',
            'operationNameMethod' => 'getName',
            'operationStatusMethod' => 'getStatus',
            'operationStatusDoneValue' => \Google\Cloud\Compute\V1\Operation\Status::DONE,
            'getOperationRequest' => '\Google\Cloud\Compute\V1\GetRegionOperationRequest',
            'cancelOperationRequest' => null,
            'deleteOperationRequest' => '\Google\Cloud\Compute\V1\DeleteRegionOperationRequest',
        ];
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
        $options = isset($this->descriptors[$methodName]['longRunning']) ? $this->descriptors[$methodName]['longRunning'] : $this->getDefaultOperationDescriptor();
        $operation = new OperationResponse($operationName, $this->getOperationsClient(), $options);
        $operation->reload();
        return $operation;
    }

    /**
     * Constructor.
     *
     * @param array $options {
     *     Optional. Options for configuring the service API wrapper.
     *
     *     @type string $apiEndpoint
     *           The address of the API remote host. May optionally include the port, formatted
     *           as "<uri>:<port>". Default 'compute.googleapis.com:443'.
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
     *           The transport used for executing network requests. At the moment, supports only
     *           `rest`. *Advanced usage*: Additionally, it is possible to pass in an already
     *           instantiated {@see \Google\ApiCore\Transport\TransportInterface} object. Note
     *           that when this object is provided, any settings in $transportConfig, and any
     *           $apiEndpoint setting, will be ignored.
     *     @type array $transportConfig
     *           Configuration options that will be used to construct the transport. Options for
     *           each supported transport type should be passed in a key for that transport. For
     *           example:
     *           $transportConfig = [
     *               'rest' => [...],
     *           ];
     *           See the {@see \Google\ApiCore\Transport\RestTransport::build()} method for the
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
     * Retrieves an aggregated list of routers. To prevent failure, Google recommends that you set the `returnPartialSuccess` parameter to `true`.
     *
     * The async variant is {@see RoutersClient::aggregatedListAsync()} .
     *
     * @example samples/V1/RoutersClient/aggregated_list.php
     *
     * @param AggregatedListRoutersRequest $request     A request to house fields associated with the call.
     * @param array                        $callOptions {
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
    public function aggregatedList(AggregatedListRoutersRequest $request, array $callOptions = []): PagedListResponse
    {
        return $this->startApiCall('AggregatedList', $request, $callOptions);
    }

    /**
     * Deletes the specified Router resource.
     *
     * The async variant is {@see RoutersClient::deleteAsync()} .
     *
     * @example samples/V1/RoutersClient/delete.php
     *
     * @param DeleteRouterRequest $request     A request to house fields associated with the call.
     * @param array               $callOptions {
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
    public function delete(DeleteRouterRequest $request, array $callOptions = []): OperationResponse
    {
        return $this->startApiCall('Delete', $request, $callOptions)->wait();
    }

    /**
     * Deletes Route Policy
     *
     * The async variant is {@see RoutersClient::deleteRoutePolicyAsync()} .
     *
     * @example samples/V1/RoutersClient/delete_route_policy.php
     *
     * @param DeleteRoutePolicyRouterRequest $request     A request to house fields associated with the call.
     * @param array                          $callOptions {
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
    public function deleteRoutePolicy(DeleteRoutePolicyRouterRequest $request, array $callOptions = []): OperationResponse
    {
        return $this->startApiCall('DeleteRoutePolicy', $request, $callOptions)->wait();
    }

    /**
     * Returns the specified Router resource.
     *
     * The async variant is {@see RoutersClient::getAsync()} .
     *
     * @example samples/V1/RoutersClient/get.php
     *
     * @param GetRouterRequest $request     A request to house fields associated with the call.
     * @param array            $callOptions {
     *     Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *           Retry settings to use for this call. Can be a {@see RetrySettings} object, or an
     *           associative array of retry settings parameters. See the documentation on
     *           {@see RetrySettings} for example usage.
     * }
     *
     * @return Router
     *
     * @throws ApiException Thrown if the API call fails.
     */
    public function get(GetRouterRequest $request, array $callOptions = []): Router
    {
        return $this->startApiCall('Get', $request, $callOptions)->wait();
    }

    /**
     * Retrieves runtime NAT IP information.
     *
     * The async variant is {@see RoutersClient::getNatIpInfoAsync()} .
     *
     * @example samples/V1/RoutersClient/get_nat_ip_info.php
     *
     * @param GetNatIpInfoRouterRequest $request     A request to house fields associated with the call.
     * @param array                     $callOptions {
     *     Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *           Retry settings to use for this call. Can be a {@see RetrySettings} object, or an
     *           associative array of retry settings parameters. See the documentation on
     *           {@see RetrySettings} for example usage.
     * }
     *
     * @return NatIpInfoResponse
     *
     * @throws ApiException Thrown if the API call fails.
     */
    public function getNatIpInfo(GetNatIpInfoRouterRequest $request, array $callOptions = []): NatIpInfoResponse
    {
        return $this->startApiCall('GetNatIpInfo', $request, $callOptions)->wait();
    }

    /**
     * Retrieves runtime Nat mapping information of VM endpoints.
     *
     * The async variant is {@see RoutersClient::getNatMappingInfoAsync()} .
     *
     * @example samples/V1/RoutersClient/get_nat_mapping_info.php
     *
     * @param GetNatMappingInfoRoutersRequest $request     A request to house fields associated with the call.
     * @param array                           $callOptions {
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
    public function getNatMappingInfo(GetNatMappingInfoRoutersRequest $request, array $callOptions = []): PagedListResponse
    {
        return $this->startApiCall('GetNatMappingInfo', $request, $callOptions);
    }

    /**
     * Returns specified Route Policy
     *
     * The async variant is {@see RoutersClient::getRoutePolicyAsync()} .
     *
     * @example samples/V1/RoutersClient/get_route_policy.php
     *
     * @param GetRoutePolicyRouterRequest $request     A request to house fields associated with the call.
     * @param array                       $callOptions {
     *     Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *           Retry settings to use for this call. Can be a {@see RetrySettings} object, or an
     *           associative array of retry settings parameters. See the documentation on
     *           {@see RetrySettings} for example usage.
     * }
     *
     * @return RoutersGetRoutePolicyResponse
     *
     * @throws ApiException Thrown if the API call fails.
     */
    public function getRoutePolicy(GetRoutePolicyRouterRequest $request, array $callOptions = []): RoutersGetRoutePolicyResponse
    {
        return $this->startApiCall('GetRoutePolicy', $request, $callOptions)->wait();
    }

    /**
     * Retrieves runtime information of the specified router.
     *
     * The async variant is {@see RoutersClient::getRouterStatusAsync()} .
     *
     * @example samples/V1/RoutersClient/get_router_status.php
     *
     * @param GetRouterStatusRouterRequest $request     A request to house fields associated with the call.
     * @param array                        $callOptions {
     *     Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *           Retry settings to use for this call. Can be a {@see RetrySettings} object, or an
     *           associative array of retry settings parameters. See the documentation on
     *           {@see RetrySettings} for example usage.
     * }
     *
     * @return RouterStatusResponse
     *
     * @throws ApiException Thrown if the API call fails.
     */
    public function getRouterStatus(GetRouterStatusRouterRequest $request, array $callOptions = []): RouterStatusResponse
    {
        return $this->startApiCall('GetRouterStatus', $request, $callOptions)->wait();
    }

    /**
     * Creates a Router resource in the specified project and region using the data included in the request.
     *
     * The async variant is {@see RoutersClient::insertAsync()} .
     *
     * @example samples/V1/RoutersClient/insert.php
     *
     * @param InsertRouterRequest $request     A request to house fields associated with the call.
     * @param array               $callOptions {
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
    public function insert(InsertRouterRequest $request, array $callOptions = []): OperationResponse
    {
        return $this->startApiCall('Insert', $request, $callOptions)->wait();
    }

    /**
     * Retrieves a list of Router resources available to the specified project.
     *
     * The async variant is {@see RoutersClient::listAsync()} .
     *
     * @example samples/V1/RoutersClient/list.php
     *
     * @param ListRoutersRequest $request     A request to house fields associated with the call.
     * @param array              $callOptions {
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
    public function list(ListRoutersRequest $request, array $callOptions = []): PagedListResponse
    {
        return $this->startApiCall('List', $request, $callOptions);
    }

    /**
     * Retrieves a list of router bgp routes available to the specified project.
     *
     * The async variant is {@see RoutersClient::listBgpRoutesAsync()} .
     *
     * @example samples/V1/RoutersClient/list_bgp_routes.php
     *
     * @param ListBgpRoutesRoutersRequest $request     A request to house fields associated with the call.
     * @param array                       $callOptions {
     *     Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *           Retry settings to use for this call. Can be a {@see RetrySettings} object, or an
     *           associative array of retry settings parameters. See the documentation on
     *           {@see RetrySettings} for example usage.
     * }
     *
     * @return RoutersListBgpRoutes
     *
     * @throws ApiException Thrown if the API call fails.
     */
    public function listBgpRoutes(ListBgpRoutesRoutersRequest $request, array $callOptions = []): RoutersListBgpRoutes
    {
        return $this->startApiCall('ListBgpRoutes', $request, $callOptions)->wait();
    }

    /**
     * Retrieves a list of router route policy subresources available to the specified project.
     *
     * The async variant is {@see RoutersClient::listRoutePoliciesAsync()} .
     *
     * @example samples/V1/RoutersClient/list_route_policies.php
     *
     * @param ListRoutePoliciesRoutersRequest $request     A request to house fields associated with the call.
     * @param array                           $callOptions {
     *     Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *           Retry settings to use for this call. Can be a {@see RetrySettings} object, or an
     *           associative array of retry settings parameters. See the documentation on
     *           {@see RetrySettings} for example usage.
     * }
     *
     * @return RoutersListRoutePolicies
     *
     * @throws ApiException Thrown if the API call fails.
     */
    public function listRoutePolicies(ListRoutePoliciesRoutersRequest $request, array $callOptions = []): RoutersListRoutePolicies
    {
        return $this->startApiCall('ListRoutePolicies', $request, $callOptions)->wait();
    }

    /**
     * Patches the specified Router resource with the data included in the request. This method supports PATCH semantics and uses JSON merge patch format and processing rules.
     *
     * The async variant is {@see RoutersClient::patchAsync()} .
     *
     * @example samples/V1/RoutersClient/patch.php
     *
     * @param PatchRouterRequest $request     A request to house fields associated with the call.
     * @param array              $callOptions {
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
    public function patch(PatchRouterRequest $request, array $callOptions = []): OperationResponse
    {
        return $this->startApiCall('Patch', $request, $callOptions)->wait();
    }

    /**
     * Patches Route Policy
     *
     * The async variant is {@see RoutersClient::patchRoutePolicyAsync()} .
     *
     * @example samples/V1/RoutersClient/patch_route_policy.php
     *
     * @param PatchRoutePolicyRouterRequest $request     A request to house fields associated with the call.
     * @param array                         $callOptions {
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
    public function patchRoutePolicy(PatchRoutePolicyRouterRequest $request, array $callOptions = []): OperationResponse
    {
        return $this->startApiCall('PatchRoutePolicy', $request, $callOptions)->wait();
    }

    /**
     * Preview fields auto-generated during router create and update operations. Calling this method does NOT create or update the router.
     *
     * The async variant is {@see RoutersClient::previewAsync()} .
     *
     * @example samples/V1/RoutersClient/preview.php
     *
     * @param PreviewRouterRequest $request     A request to house fields associated with the call.
     * @param array                $callOptions {
     *     Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *           Retry settings to use for this call. Can be a {@see RetrySettings} object, or an
     *           associative array of retry settings parameters. See the documentation on
     *           {@see RetrySettings} for example usage.
     * }
     *
     * @return RoutersPreviewResponse
     *
     * @throws ApiException Thrown if the API call fails.
     */
    public function preview(PreviewRouterRequest $request, array $callOptions = []): RoutersPreviewResponse
    {
        return $this->startApiCall('Preview', $request, $callOptions)->wait();
    }

    /**
     * Updates the specified Router resource with the data included in the request. This method conforms to PUT semantics, which requests that the state of the target resource be created or replaced with the state defined by the representation enclosed in the request message payload.
     *
     * The async variant is {@see RoutersClient::updateAsync()} .
     *
     * @example samples/V1/RoutersClient/update.php
     *
     * @param UpdateRouterRequest $request     A request to house fields associated with the call.
     * @param array               $callOptions {
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
    public function update(UpdateRouterRequest $request, array $callOptions = []): OperationResponse
    {
        return $this->startApiCall('Update', $request, $callOptions)->wait();
    }

    /**
     * Updates or creates new Route Policy
     *
     * The async variant is {@see RoutersClient::updateRoutePolicyAsync()} .
     *
     * @example samples/V1/RoutersClient/update_route_policy.php
     *
     * @param UpdateRoutePolicyRouterRequest $request     A request to house fields associated with the call.
     * @param array                          $callOptions {
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
    public function updateRoutePolicy(UpdateRoutePolicyRouterRequest $request, array $callOptions = []): OperationResponse
    {
        return $this->startApiCall('UpdateRoutePolicy', $request, $callOptions)->wait();
    }
}

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
 * https://github.com/googleapis/googleapis/blob/master/google/appengine/v1/appengine.proto
 * Updates to the above are reflected here through a refresh process.
 */

namespace Google\Cloud\AppEngine\V1\Client\BaseClient;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\GapicClientTrait;
use Google\ApiCore\LongRunning\OperationsClient;
use Google\ApiCore\OperationResponse;
use Google\ApiCore\PagedListResponse;
use Google\ApiCore\RetrySettings;
use Google\ApiCore\Transport\TransportInterface;
use Google\ApiCore\ValidationException;
use Google\Auth\FetchAuthTokenInterface;
use Google\Cloud\AppEngine\V1\DebugInstanceRequest;
use Google\Cloud\AppEngine\V1\DeleteInstanceRequest;
use Google\Cloud\AppEngine\V1\GetInstanceRequest;
use Google\Cloud\AppEngine\V1\Instance;
use Google\Cloud\AppEngine\V1\ListInstancesRequest;
use Google\LongRunning\Operation;
use GuzzleHttp\Promise\PromiseInterface;

/**
 * Service Description: Manages instances of a version.
 *
 * This class provides the ability to make remote calls to the backing service through method
 * calls that map to API methods.
 *
 * This class is currently experimental and may be subject to changes. See {@see
 * \Google\Cloud\AppEngine\V1\InstancesClient} for the stable implementation
 *
 * @experimental
 *
 * @internal
 *
 * @method PromiseInterface debugInstanceAsync(DebugInstanceRequest $request, array $optionalArgs = [])
 * @method PromiseInterface deleteInstanceAsync(DeleteInstanceRequest $request, array $optionalArgs = [])
 * @method PromiseInterface getInstanceAsync(GetInstanceRequest $request, array $optionalArgs = [])
 * @method PromiseInterface listInstancesAsync(ListInstancesRequest $request, array $optionalArgs = [])
 */
abstract class InstancesBaseClient
{
    use GapicClientTrait;

    /** The name of the service. */
    private const SERVICE_NAME = 'google.appengine.v1.Instances';

    /** The default address of the service. */
    private const SERVICE_ADDRESS = 'appengine.googleapis.com';

    /** The default port of the service. */
    private const DEFAULT_SERVICE_PORT = 443;

    /** The name of the code generator, to be included in the agent header. */
    private const CODEGEN_NAME = 'gapic';

    /** The default scopes required by the service. */
    public static $serviceScopes = [
        'https://www.googleapis.com/auth/appengine.admin',
        'https://www.googleapis.com/auth/cloud-platform',
        'https://www.googleapis.com/auth/cloud-platform.read-only',
    ];

    private $operationsClient;

    private static function getClientDefaults()
    {
        return [
            'serviceName' => self::SERVICE_NAME,
            'apiEndpoint' => self::SERVICE_ADDRESS . ':' . self::DEFAULT_SERVICE_PORT,
            'clientConfig' => __DIR__ . '/../../resources/instances_client_config.json',
            'descriptorsConfigPath' => __DIR__ . '/../../resources/instances_descriptor_config.php',
            'gcpApiConfigPath' => __DIR__ . '/../../resources/instances_grpc_config.json',
            'credentialsConfig' => [
                'defaultScopes' => self::$serviceScopes,
            ],
            'transportConfig' => [
                'rest' => [
                    'restClientConfigPath' => __DIR__ . '/../../resources/instances_rest_client_config.php',
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
        $options = isset($this->descriptors[$methodName]['longRunning']) ? $this->descriptors[$methodName]['longRunning'] : [];
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
     *           as "<uri>:<port>". Default 'appengine.googleapis.com:443'.
     *     @type string|array|FetchAuthTokenInterface|CredentialsWrapper $credentials
     *           The credentials to be used by the client to authorize API calls. This option
     *           accepts either a path to a credentials file, or a decoded credentials file as a
     *           PHP array.
     *           *Advanced usage*: In addition, this option can also accept a pre-constructed
     *           {@see \Google\Auth\FetchAuthTokenInterface} object or
     *           {@see \Google\ApiCore\CredentialsWrapper} object. Note that when one of these
     *           objects are provided, any settings in $credentialsConfig will be ignored.
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
     * Enables debugging on a VM instance. This allows you to use the SSH
     * command to connect to the virtual machine where the instance lives.
     * While in "debug mode", the instance continues to serve live traffic.
     * You should delete the instance when you are done debugging and then
     * allow the system to take over and determine if another instance
     * should be started.
     *
     * Only applicable for instances in App Engine flexible environment.
     *
     * The async variant is {@see self::debugInstanceAsync()} .
     *
     * @param DebugInstanceRequest $request     A request to house fields associated with the call.
     * @param array                $callOptions {
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
    public function debugInstance(DebugInstanceRequest $request, array $callOptions = []): OperationResponse
    {
        return $this->startApiCall('DebugInstance', $request, $callOptions)->wait();
    }

    /**
     * Stops a running instance.
     *
     * The instance might be automatically recreated based on the scaling settings
     * of the version. For more information, see "How Instances are Managed"
     * ([standard environment](https://cloud.google.com/appengine/docs/standard/python/how-instances-are-managed) |
     * [flexible environment](https://cloud.google.com/appengine/docs/flexible/python/how-instances-are-managed)).
     *
     * To ensure that instances are not re-created and avoid getting billed, you
     * can stop all instances within the target version by changing the serving
     * status of the version to `STOPPED` with the
     * [`apps.services.versions.patch`](https://cloud.google.com/appengine/docs/admin-api/reference/rest/v1/apps.services.versions/patch)
     * method.
     *
     * The async variant is {@see self::deleteInstanceAsync()} .
     *
     * @param DeleteInstanceRequest $request     A request to house fields associated with the call.
     * @param array                 $callOptions {
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
    public function deleteInstance(DeleteInstanceRequest $request, array $callOptions = []): OperationResponse
    {
        return $this->startApiCall('DeleteInstance', $request, $callOptions)->wait();
    }

    /**
     * Gets instance information.
     *
     * The async variant is {@see self::getInstanceAsync()} .
     *
     * @param GetInstanceRequest $request     A request to house fields associated with the call.
     * @param array              $callOptions {
     *     Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *           Retry settings to use for this call. Can be a {@see RetrySettings} object, or an
     *           associative array of retry settings parameters. See the documentation on
     *           {@see RetrySettings} for example usage.
     * }
     *
     * @return Instance
     *
     * @throws ApiException Thrown if the API call fails.
     */
    public function getInstance(GetInstanceRequest $request, array $callOptions = []): Instance
    {
        return $this->startApiCall('GetInstance', $request, $callOptions)->wait();
    }

    /**
     * Lists the instances of a version.
     *
     * Tip: To aggregate details about instances over time, see the
     * [Stackdriver Monitoring API](https://cloud.google.com/monitoring/api/ref_v3/rest/v3/projects.timeSeries/list).
     *
     * The async variant is {@see self::listInstancesAsync()} .
     *
     * @param ListInstancesRequest $request     A request to house fields associated with the call.
     * @param array                $callOptions {
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
    public function listInstances(ListInstancesRequest $request, array $callOptions = []): PagedListResponse
    {
        return $this->startApiCall('ListInstances', $request, $callOptions);
    }
}
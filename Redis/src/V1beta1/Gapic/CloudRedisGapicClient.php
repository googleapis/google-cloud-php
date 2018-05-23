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
 * https://github.com/google/googleapis/blob/master/google/cloud/redis/v1beta1/cloud_redis.proto
 * and updates to that file get reflected here through a refresh process.
 *
 * EXPERIMENTAL: This client library class has not yet been declared GA (1.0). This means that
 * even though we intend the surface to be stable, we may make backwards incompatible changes
 * if necessary.
 *
 * @experimental
 */

namespace Google\Cloud\Redis\V1beta1\Gapic;

use Google\ApiCore\ApiException;
use Google\ApiCore\Call;
use Google\ApiCore\GapicClientTrait;
use Google\ApiCore\LongRunning\OperationsClient;
use Google\ApiCore\OperationResponse;
use Google\ApiCore\PathTemplate;
use Google\ApiCore\RetrySettings;
use Google\ApiCore\Transport\TransportInterface;
use Google\ApiCore\ValidationException;
use Google\Auth\CredentialsLoader;
use Google\Cloud\Redis\V1beta1\CreateInstanceRequest;
use Google\Cloud\Redis\V1beta1\DeleteInstanceRequest;
use Google\Cloud\Redis\V1beta1\GetInstanceRequest;
use Google\Cloud\Redis\V1beta1\Instance;
use Google\Cloud\Redis\V1beta1\ListInstancesRequest;
use Google\Cloud\Redis\V1beta1\ListInstancesResponse;
use Google\Cloud\Redis\V1beta1\UpdateInstanceRequest;
use Google\LongRunning\Operation;
use Google\Protobuf\Any;
use Google\Protobuf\FieldMask;
use Grpc\Channel;
use Grpc\ChannelCredentials;

/**
 * Service Description: Configures and manages Cloud Memorystore for Redis instances.
 *
 * Google Cloud Memorystore for Redis v1beta1
 *
 * The `redis.googleapis.com` service implements the Google Cloud Memorystore
 * for Redis API and defines the following resource model for managing Redis
 * instances:
 * * The service works with a collection of cloud projects, named: `/projects/*`
 * * Each project has a collection of available locations, named: `/locations/*`
 * * Each location has a collection of Redis instances, named: `/instances/*`
 * * As such, Redis instances are resources of the form:
 *   `/projects/{project_id}/locations/{location_id}/instances/{instance_id}`
 *
 * Note that location_id must be refering to a GCP `region`; for example:
 * * `projects/redpepper-1290/locations/us-central1/instances/my-redis`
 *
 * EXPERIMENTAL: This client library class has not yet been declared GA (1.0). This means that
 * even though we intend the surface to be stable, we may make backwards incompatible changes
 * if necessary.
 *
 * This class provides the ability to make remote calls to the backing service through method
 * calls that map to API methods. Sample code to get started:
 *
 * ```
 * $cloudRedisClient = new CloudRedisClient();
 * try {
 *     $formattedParent = $cloudRedisClient->locationName('[PROJECT]', '[LOCATION]');
 *     // Iterate through all elements
 *     $pagedResponse = $cloudRedisClient->listInstances($formattedParent);
 *     foreach ($pagedResponse->iterateAllElements() as $element) {
 *         // doSomethingWith($element);
 *     }
 *
 *     // OR iterate over pages of elements
 *     $pagedResponse = $cloudRedisClient->listInstances($formattedParent);
 *     foreach ($pagedResponse->iteratePages() as $page) {
 *         foreach ($page as $element) {
 *             // doSomethingWith($element);
 *         }
 *     }
 * } finally {
 *     $cloudRedisClient->close();
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
class CloudRedisGapicClient
{
    use GapicClientTrait;

    /**
     * The name of the service.
     */
    const SERVICE_NAME = 'google.cloud.redis.v1beta1.CloudRedis';

    /**
     * The default address of the service.
     */
    const SERVICE_ADDRESS = 'redis.googleapis.com';

    /**
     * The default port of the service.
     */
    const DEFAULT_SERVICE_PORT = 443;

    /**
     * The name of the code generator, to be included in the agent header.
     */
    const CODEGEN_NAME = 'gapic';

    /**
     * The code generator version, to be included in the agent header.
     */
    const CODEGEN_VERSION = '0.0.5';

    private static $locationNameTemplate;
    private static $instanceNameTemplate;
    private static $pathTemplateMap;

    private $operationsClient;

    private static function getClientDefaults()
    {
        return [
            'serviceName' => self::SERVICE_NAME,
            'serviceAddress' => self::SERVICE_ADDRESS,
            'port' => self::DEFAULT_SERVICE_PORT,
            'scopes' => [
                'https://www.googleapis.com/auth/cloud-platform',
            ],
            'clientConfigPath' => __DIR__.'/../resources/cloud_redis_client_config.json',
            'restClientConfigPath' => __DIR__.'/../resources/cloud_redis_rest_client_config.php',
            'descriptorsConfigPath' => __DIR__.'/../resources/cloud_redis_descriptor_config.php',
            'versionFile' => __DIR__.'/../../VERSION',
        ];
    }

    private static function getLocationNameTemplate()
    {
        if (self::$locationNameTemplate == null) {
            self::$locationNameTemplate = new PathTemplate('projects/{project}/locations/{location}');
        }

        return self::$locationNameTemplate;
    }

    private static function getInstanceNameTemplate()
    {
        if (self::$instanceNameTemplate == null) {
            self::$instanceNameTemplate = new PathTemplate('projects/{project}/locations/{location}/instances/{instance}');
        }

        return self::$instanceNameTemplate;
    }

    private static function getPathTemplateMap()
    {
        if (self::$pathTemplateMap == null) {
            self::$pathTemplateMap = [
                'location' => self::getLocationNameTemplate(),
                'instance' => self::getInstanceNameTemplate(),
            ];
        }

        return self::$pathTemplateMap;
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
     * a instance resource.
     *
     * @param string $project
     * @param string $location
     * @param string $instance
     *
     * @return string The formatted instance resource.
     * @experimental
     */
    public static function instanceName($project, $location, $instance)
    {
        return self::getInstanceNameTemplate()->render([
            'project' => $project,
            'location' => $location,
            'instance' => $instance,
        ]);
    }

    /**
     * Parses a formatted name string and returns an associative array of the components in the name.
     * The following name formats are supported:
     * Template: Pattern
     * - location: projects/{project}/locations/{location}
     * - instance: projects/{project}/locations/{location}/instances/{instance}.
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
     * Return an OperationsClient object with the same endpoint as $this.
     *
     * @return OperationsClient
     * @experimental
     */
    public function getOperationsClient()
    {
        return $this->operationsClient;
    }

    /**
     * Resume an existing long running operation that was previously started
     * by a long running API method. If $methodName is not provided, or does
     * not match a long running API method, then the operation can still be
     * resumed, but the OperationResponse object will not deserialize the
     * final response.
     *
     * @param string $operationName The name of the long running operation
     * @param string $methodName    The name of the method used to start the operation
     *
     * @return OperationResponse
     * @experimental
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
     * Constructor.
     *
     * @param array $options {
     *                       Optional. Options for configuring the service API wrapper.
     *
     *     @type string $serviceAddress The domain name of the API remote host.
     *                                  Default 'redis.googleapis.com'.
     *     @type mixed $port The port on which to connect to the remote host. Default 443.
     *     @type Channel $channel
     *           A `Channel` object. If not specified, a channel will be constructed.
     *           NOTE: This option is only valid when utilizing the gRPC transport.
     *     @type ChannelCredentials $sslCreds
     *           A `ChannelCredentials` object for use with an SSL-enabled channel.
     *           Default: a credentials object returned from
     *           \Grpc\ChannelCredentials::createSsl().
     *           NOTE: This option is only valid when utilizing the gRPC transport. Also, if the $channel
     *           optional argument is specified, then this argument is unused.
     *     @type bool $forceNewChannel
     *           If true, this forces gRPC to create a new channel instead of using a persistent channel.
     *           Defaults to false.
     *           NOTE: This option is only valid when utilizing the gRPC transport. Also, if the $channel
     *           optional argument is specified, then this option is unused.
     *     @type CredentialsLoader $credentialsLoader
     *           A CredentialsLoader object created using the Google\Auth library.
     *     @type string[] $scopes A string array of scopes to use when acquiring credentials.
     *                          Defaults to the scopes for the Google Cloud Memorystore for Redis API.
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
     *     @type callable $authHttpHandler A handler used to deliver PSR-7 requests specifically
     *           for authentication. Should match a signature of
     *           `function (RequestInterface $request, array $options) : ResponseInterface`.
     *     @type callable $httpHandler A handler used to deliver PSR-7 requests. Should match a
     *           signature of `function (RequestInterface $request, array $options) : PromiseInterface`.
     *           NOTE: This option is only valid when utilizing the REST transport.
     *     @type string|TransportInterface $transport The transport used for executing network
     *           requests. May be either the string `rest` or `grpc`. Additionally, it is possible
     *           to pass in an already instantiated transport. Defaults to `grpc` if gRPC support is
     *           detected on the system.
     * }
     * @experimental
     */
    public function __construct($options = [])
    {
        $options += self::getClientDefaults();
        $this->setClientOptions($options);
        $this->pluckArray([
            'serviceName',
            'clientConfigPath',
            'descriptorsConfigPath',
        ], $options);
        $this->operationsClient = $this->pluck('operationsClient', $options, false)
            ?: new OperationsClient($options);
    }

    /**
     * Lists all Redis instances owned by a project in either the specified
     * location (region) or all locations.
     *
     * The location should have the following format:
     * * `projects/{project_id}/locations/{location_id}`
     *
     * If `location_id` is specified as `-` (wildcard), then all regions
     * available to the project are queried, and the results are aggregated.
     *
     * Sample code:
     * ```
     * $cloudRedisClient = new CloudRedisClient();
     * try {
     *     $formattedParent = $cloudRedisClient->locationName('[PROJECT]', '[LOCATION]');
     *     // Iterate through all elements
     *     $pagedResponse = $cloudRedisClient->listInstances($formattedParent);
     *     foreach ($pagedResponse->iterateAllElements() as $element) {
     *         // doSomethingWith($element);
     *     }
     *
     *     // OR iterate over pages of elements
     *     $pagedResponse = $cloudRedisClient->listInstances($formattedParent);
     *     foreach ($pagedResponse->iteratePages() as $page) {
     *         foreach ($page as $element) {
     *             // doSomethingWith($element);
     *         }
     *     }
     * } finally {
     *     $cloudRedisClient->close();
     * }
     * ```
     *
     * @param string $parent       Required. The resource name of the instance location using the form:
     *                             `projects/{project_id}/locations/{location_id}`
     *                             where `location_id` refers to a GCP region
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
    public function listInstances($parent, $optionalArgs = [])
    {
        $request = new ListInstancesRequest();
        $request->setParent($parent);
        if (isset($optionalArgs['pageSize'])) {
            $request->setPageSize($optionalArgs['pageSize']);
        }
        if (isset($optionalArgs['pageToken'])) {
            $request->setPageToken($optionalArgs['pageToken']);
        }

        return $this->getPagedListResponse(
            'ListInstances',
            $optionalArgs,
            ListInstancesResponse::class,
            $request
        );
    }

    /**
     * Gets the details of a specific Redis instance.
     *
     * Sample code:
     * ```
     * $cloudRedisClient = new CloudRedisClient();
     * try {
     *     $formattedName = $cloudRedisClient->instanceName('[PROJECT]', '[LOCATION]', '[INSTANCE]');
     *     $response = $cloudRedisClient->getInstance($formattedName);
     * } finally {
     *     $cloudRedisClient->close();
     * }
     * ```
     *
     * @param string $name         Required. Redis instance resource name using the form:
     *                             `projects/{project_id}/locations/{location_id}/instances/{instance_id}`
     *                             where `location_id` refers to a GCP region
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
     * @return \Google\Cloud\Redis\V1beta1\Instance
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function getInstance($name, $optionalArgs = [])
    {
        $request = new GetInstanceRequest();
        $request->setName($name);

        return $this->startCall(
            'GetInstance',
            Instance::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Creates a Redis instance based on the specified tier and memory size.
     *
     * By default, the instance is peered to the project's
     * [default network](https://cloud.google.com/compute/docs/networks-and-firewalls#networks).
     *
     * The creation is executed asynchronously and callers may check the returned
     * operation to track its progress. Once the operation is completed the Redis
     * instance will be fully functional. Completed longrunning.Operation will
     * contain the new instance object in the response field.
     *
     * The returned operation is automatically deleted after a few hours, so there
     * is no need to call DeleteOperation.
     *
     * Sample code:
     * ```
     * $cloudRedisClient = new CloudRedisClient();
     * try {
     *     $formattedParent = $cloudRedisClient->locationName('[PROJECT]', '[LOCATION]');
     *     $instanceId = 'test_instance';
     *     $tier = Instance_Tier::BASIC;
     *     $memorySizeGb = 1;
     *     $instance = new Instance();
     *     $instance->setTier($tier);
     *     $instance->setMemorySizeGb($memorySizeGb);
     *     $operationResponse = $cloudRedisClient->createInstance($formattedParent, $instanceId, $instance);
     *     $operationResponse->pollUntilComplete();
     *     if ($operationResponse->operationSucceeded()) {
     *       $result = $operationResponse->getResult();
     *       // doSomethingWith($result)
     *     } else {
     *       $error = $operationResponse->getError();
     *       // handleError($error)
     *     }
     *
     *     // OR start the operation, keep the operation name, and resume later
     *     $operationResponse = $cloudRedisClient->createInstance($formattedParent, $instanceId, $instance);
     *     $operationName = $operationResponse->getName();
     *     // ... do other work
     *     $newOperationResponse = $cloudRedisClient->resumeOperation($operationName, 'createInstance');
     *     while (!$newOperationResponse->isDone()) {
     *         // ... do other work
     *         $newOperationResponse->reload();
     *     }
     *     if ($newOperationResponse->operationSucceeded()) {
     *       $result = $newOperationResponse->getResult();
     *       // doSomethingWith($result)
     *     } else {
     *       $error = $newOperationResponse->getError();
     *       // handleError($error)
     *     }
     * } finally {
     *     $cloudRedisClient->close();
     * }
     * ```
     *
     * @param string $parent     Required. The resource name of the instance location using the form:
     *                           `projects/{project_id}/locations/{location_id}`
     *                           where `location_id` refers to a GCP region
     * @param string $instanceId Required. The logical name of the Redis instance in the customer project
     *                           with the following restrictions:
     *
     * * Must contain only lowercase letters, numbers, and hyphens.
     * * Must start with a letter.
     * * Must be between 1-40 characters.
     * * Must end with a number or a letter.
     * * Must be unique within the customer project / location
     * @param Instance $instance     Required. A Redis [Instance] resource
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
     * @return \Google\ApiCore\OperationResponse
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function createInstance($parent, $instanceId, $instance, $optionalArgs = [])
    {
        $request = new CreateInstanceRequest();
        $request->setParent($parent);
        $request->setInstanceId($instanceId);
        $request->setInstance($instance);

        return $this->startOperationsCall(
            'CreateInstance',
            $optionalArgs,
            $request,
            $this->getOperationsClient()
        )->wait();
    }

    /**
     * Updates the metadata and configuration of a specific Redis instance.
     *
     * Completed longrunning.Operation will contain the new instance object
     * in the response field. The returned operation is automatically deleted
     * after a few hours, so there is no need to call DeleteOperation.
     *
     * Sample code:
     * ```
     * $cloudRedisClient = new CloudRedisClient();
     * try {
     *     $pathsElement = 'display_name';
     *     $pathsElement2 = 'memory_size_gb';
     *     $paths = [$pathsElement, $pathsElement2];
     *     $updateMask = new FieldMask();
     *     $updateMask->setPaths($paths);
     *     $displayName = 'UpdatedDisplayName';
     *     $memorySizeGb = 4;
     *     $instance = new Instance();
     *     $instance->setDisplayName($displayName);
     *     $instance->setMemorySizeGb($memorySizeGb);
     *     $operationResponse = $cloudRedisClient->updateInstance($updateMask, $instance);
     *     $operationResponse->pollUntilComplete();
     *     if ($operationResponse->operationSucceeded()) {
     *       $result = $operationResponse->getResult();
     *       // doSomethingWith($result)
     *     } else {
     *       $error = $operationResponse->getError();
     *       // handleError($error)
     *     }
     *
     *     // OR start the operation, keep the operation name, and resume later
     *     $operationResponse = $cloudRedisClient->updateInstance($updateMask, $instance);
     *     $operationName = $operationResponse->getName();
     *     // ... do other work
     *     $newOperationResponse = $cloudRedisClient->resumeOperation($operationName, 'updateInstance');
     *     while (!$newOperationResponse->isDone()) {
     *         // ... do other work
     *         $newOperationResponse->reload();
     *     }
     *     if ($newOperationResponse->operationSucceeded()) {
     *       $result = $newOperationResponse->getResult();
     *       // doSomethingWith($result)
     *     } else {
     *       $error = $newOperationResponse->getError();
     *       // handleError($error)
     *     }
     * } finally {
     *     $cloudRedisClient->close();
     * }
     * ```
     *
     * @param FieldMask $updateMask   Required. Mask of fields to update. At least one path must be supplied in
     *                                this field. The elements of the repeated paths field may only include these
     *                                fields from [Instance][CloudRedis.Instance]:
     *                                * `display_name`
     *                                * `labels`
     *                                * `memory_size_gb`
     *                                * `redis_config`
     * @param Instance  $instance     Required. Update description.
     *                                Only fields specified in update_mask are updated.
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
     * @return \Google\ApiCore\OperationResponse
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function updateInstance($updateMask, $instance, $optionalArgs = [])
    {
        $request = new UpdateInstanceRequest();
        $request->setUpdateMask($updateMask);
        $request->setInstance($instance);

        return $this->startOperationsCall(
            'UpdateInstance',
            $optionalArgs,
            $request,
            $this->getOperationsClient()
        )->wait();
    }

    /**
     * Deletes a specific Redis instance.  Instance stops serving and data is
     * deleted.
     *
     * Sample code:
     * ```
     * $cloudRedisClient = new CloudRedisClient();
     * try {
     *     $formattedName = $cloudRedisClient->instanceName('[PROJECT]', '[LOCATION]', '[INSTANCE]');
     *     $operationResponse = $cloudRedisClient->deleteInstance($formattedName);
     *     $operationResponse->pollUntilComplete();
     *     if ($operationResponse->operationSucceeded()) {
     *       // operation succeeded and returns no value
     *     } else {
     *       $error = $operationResponse->getError();
     *       // handleError($error)
     *     }
     *
     *     // OR start the operation, keep the operation name, and resume later
     *     $operationResponse = $cloudRedisClient->deleteInstance($formattedName);
     *     $operationName = $operationResponse->getName();
     *     // ... do other work
     *     $newOperationResponse = $cloudRedisClient->resumeOperation($operationName, 'deleteInstance');
     *     while (!$newOperationResponse->isDone()) {
     *         // ... do other work
     *         $newOperationResponse->reload();
     *     }
     *     if ($newOperationResponse->operationSucceeded()) {
     *       // operation succeeded and returns no value
     *     } else {
     *       $error = $newOperationResponse->getError();
     *       // handleError($error)
     *     }
     * } finally {
     *     $cloudRedisClient->close();
     * }
     * ```
     *
     * @param string $name         Required. Redis instance resource name using the form:
     *                             `projects/{project_id}/locations/{location_id}/instances/{instance_id}`
     *                             where `location_id` refers to a GCP region
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
     * @return \Google\ApiCore\OperationResponse
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function deleteInstance($name, $optionalArgs = [])
    {
        $request = new DeleteInstanceRequest();
        $request->setName($name);

        return $this->startOperationsCall(
            'DeleteInstance',
            $optionalArgs,
            $request,
            $this->getOperationsClient()
        )->wait();
    }
}

<?php
/*
 * Copyright 2017 Google LLC
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
 * https://github.com/google/googleapis/blob/master/google/bigtable/admin/v2/bigtable_instance_admin.proto
 * and updates to that file get reflected here through a refresh process.
 *
 * @experimental
 */

namespace Google\Cloud\Bigtable\Admin\V2\Gapic;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\GapicClientTrait;
use Google\ApiCore\LongRunning\OperationsClient;
use Google\ApiCore\OperationResponse;
use Google\ApiCore\PathTemplate;
use Google\ApiCore\RequestParamsHeaderDescriptor;
use Google\ApiCore\RetrySettings;
use Google\ApiCore\Transport\TransportInterface;
use Google\ApiCore\ValidationException;
use Google\Auth\FetchAuthTokenInterface;
use Google\Cloud\Bigtable\Admin\V2\AppProfile;
use Google\Cloud\Bigtable\Admin\V2\Cluster;
use Google\Cloud\Bigtable\Admin\V2\CreateAppProfileRequest;
use Google\Cloud\Bigtable\Admin\V2\CreateClusterRequest;
use Google\Cloud\Bigtable\Admin\V2\CreateInstanceRequest;
use Google\Cloud\Bigtable\Admin\V2\DeleteAppProfileRequest;
use Google\Cloud\Bigtable\Admin\V2\DeleteClusterRequest;
use Google\Cloud\Bigtable\Admin\V2\DeleteInstanceRequest;
use Google\Cloud\Bigtable\Admin\V2\GetAppProfileRequest;
use Google\Cloud\Bigtable\Admin\V2\GetClusterRequest;
use Google\Cloud\Bigtable\Admin\V2\GetInstanceRequest;
use Google\Cloud\Bigtable\Admin\V2\Instance;
use Google\Cloud\Bigtable\Admin\V2\Instance\State;
use Google\Cloud\Bigtable\Admin\V2\Instance\Type;
use Google\Cloud\Bigtable\Admin\V2\ListAppProfilesRequest;
use Google\Cloud\Bigtable\Admin\V2\ListAppProfilesResponse;
use Google\Cloud\Bigtable\Admin\V2\ListClustersRequest;
use Google\Cloud\Bigtable\Admin\V2\ListClustersResponse;
use Google\Cloud\Bigtable\Admin\V2\ListInstancesRequest;
use Google\Cloud\Bigtable\Admin\V2\ListInstancesResponse;
use Google\Cloud\Bigtable\Admin\V2\PartialUpdateInstanceRequest;
use Google\Cloud\Bigtable\Admin\V2\UpdateAppProfileRequest;
use Google\Cloud\Iam\V1\GetIamPolicyRequest;
use Google\Cloud\Iam\V1\Policy;
use Google\Cloud\Iam\V1\SetIamPolicyRequest;
use Google\Cloud\Iam\V1\TestIamPermissionsRequest;
use Google\Cloud\Iam\V1\TestIamPermissionsResponse;
use Google\LongRunning\Operation;
use Google\Protobuf\FieldMask;
use Google\Protobuf\GPBEmpty;

/**
 * Service Description: Service for creating, configuring, and deleting Cloud Bigtable Instances and
 * Clusters. Provides access to the Instance and Cluster schemas only, not the
 * tables' metadata or data stored in those tables.
 *
 * This class provides the ability to make remote calls to the backing service through method
 * calls that map to API methods. Sample code to get started:
 *
 * ```
 * $bigtableInstanceAdminClient = new Google\Cloud\Bigtable\Admin\V2\BigtableInstanceAdminClient();
 * try {
 *     $formattedParent = $bigtableInstanceAdminClient->projectName('[PROJECT]');
 *     $instanceId = '';
 *     $instance = new Google\Cloud\Bigtable\Admin\V2\Instance();
 *     $clusters = [];
 *     $operationResponse = $bigtableInstanceAdminClient->createInstance($formattedParent, $instanceId, $instance, $clusters);
 *     $operationResponse->pollUntilComplete();
 *     if ($operationResponse->operationSucceeded()) {
 *         $result = $operationResponse->getResult();
 *         // doSomethingWith($result)
 *     } else {
 *         $error = $operationResponse->getError();
 *         // handleError($error)
 *     }
 *
 *
 *     // Alternatively:
 *
 *     // start the operation, keep the operation name, and resume later
 *     $operationResponse = $bigtableInstanceAdminClient->createInstance($formattedParent, $instanceId, $instance, $clusters);
 *     $operationName = $operationResponse->getName();
 *     // ... do other work
 *     $newOperationResponse = $bigtableInstanceAdminClient->resumeOperation($operationName, 'createInstance');
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
 *     $bigtableInstanceAdminClient->close();
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
class BigtableInstanceAdminGapicClient
{
    use GapicClientTrait;

    /**
     * The name of the service.
     */
    const SERVICE_NAME = 'google.bigtable.admin.v2.BigtableInstanceAdmin';

    /**
     * The default address of the service.
     */
    const SERVICE_ADDRESS = 'bigtableadmin.googleapis.com';

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
        'https://www.googleapis.com/auth/bigtable.admin',
        'https://www.googleapis.com/auth/bigtable.admin.cluster',
        'https://www.googleapis.com/auth/bigtable.admin.instance',
        'https://www.googleapis.com/auth/bigtable.admin.table',
        'https://www.googleapis.com/auth/cloud-bigtable.admin',
        'https://www.googleapis.com/auth/cloud-bigtable.admin.cluster',
        'https://www.googleapis.com/auth/cloud-bigtable.admin.table',
        'https://www.googleapis.com/auth/cloud-platform',
        'https://www.googleapis.com/auth/cloud-platform.read-only',
    ];
    private static $appProfileNameTemplate;
    private static $clusterNameTemplate;
    private static $instanceNameTemplate;
    private static $locationNameTemplate;
    private static $projectNameTemplate;
    private static $pathTemplateMap;

    private $operationsClient;

    private static function getClientDefaults()
    {
        return [
            'serviceName' => self::SERVICE_NAME,
            'serviceAddress' => self::SERVICE_ADDRESS.':'.self::DEFAULT_SERVICE_PORT,
            'clientConfig' => __DIR__.'/../resources/bigtable_instance_admin_client_config.json',
            'descriptorsConfigPath' => __DIR__.'/../resources/bigtable_instance_admin_descriptor_config.php',
            'gcpApiConfigPath' => __DIR__.'/../resources/bigtable_instance_admin_grpc_config.json',
            'credentialsConfig' => [
                'scopes' => self::$serviceScopes,
            ],
            'transportConfig' => [
                'rest' => [
                    'restClientConfigPath' => __DIR__.'/../resources/bigtable_instance_admin_rest_client_config.php',
                ],
            ],
        ];
    }

    private static function getAppProfileNameTemplate()
    {
        if (null == self::$appProfileNameTemplate) {
            self::$appProfileNameTemplate = new PathTemplate('projects/{project}/instances/{instance}/appProfiles/{app_profile}');
        }

        return self::$appProfileNameTemplate;
    }

    private static function getClusterNameTemplate()
    {
        if (null == self::$clusterNameTemplate) {
            self::$clusterNameTemplate = new PathTemplate('projects/{project}/instances/{instance}/clusters/{cluster}');
        }

        return self::$clusterNameTemplate;
    }

    private static function getInstanceNameTemplate()
    {
        if (null == self::$instanceNameTemplate) {
            self::$instanceNameTemplate = new PathTemplate('projects/{project}/instances/{instance}');
        }

        return self::$instanceNameTemplate;
    }

    private static function getLocationNameTemplate()
    {
        if (null == self::$locationNameTemplate) {
            self::$locationNameTemplate = new PathTemplate('projects/{project}/locations/{location}');
        }

        return self::$locationNameTemplate;
    }

    private static function getProjectNameTemplate()
    {
        if (null == self::$projectNameTemplate) {
            self::$projectNameTemplate = new PathTemplate('projects/{project}');
        }

        return self::$projectNameTemplate;
    }

    private static function getPathTemplateMap()
    {
        if (null == self::$pathTemplateMap) {
            self::$pathTemplateMap = [
                'appProfile' => self::getAppProfileNameTemplate(),
                'cluster' => self::getClusterNameTemplate(),
                'instance' => self::getInstanceNameTemplate(),
                'location' => self::getLocationNameTemplate(),
                'project' => self::getProjectNameTemplate(),
            ];
        }

        return self::$pathTemplateMap;
    }

    /**
     * Formats a string containing the fully-qualified path to represent
     * a app_profile resource.
     *
     * @param string $project
     * @param string $instance
     * @param string $appProfile
     *
     * @return string The formatted app_profile resource.
     * @experimental
     */
    public static function appProfileName($project, $instance, $appProfile)
    {
        return self::getAppProfileNameTemplate()->render([
            'project' => $project,
            'instance' => $instance,
            'app_profile' => $appProfile,
        ]);
    }

    /**
     * Formats a string containing the fully-qualified path to represent
     * a cluster resource.
     *
     * @param string $project
     * @param string $instance
     * @param string $cluster
     *
     * @return string The formatted cluster resource.
     * @experimental
     */
    public static function clusterName($project, $instance, $cluster)
    {
        return self::getClusterNameTemplate()->render([
            'project' => $project,
            'instance' => $instance,
            'cluster' => $cluster,
        ]);
    }

    /**
     * Formats a string containing the fully-qualified path to represent
     * a instance resource.
     *
     * @param string $project
     * @param string $instance
     *
     * @return string The formatted instance resource.
     * @experimental
     */
    public static function instanceName($project, $instance)
    {
        return self::getInstanceNameTemplate()->render([
            'project' => $project,
            'instance' => $instance,
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
     * a project resource.
     *
     * @param string $project
     *
     * @return string The formatted project resource.
     * @experimental
     */
    public static function projectName($project)
    {
        return self::getProjectNameTemplate()->render([
            'project' => $project,
        ]);
    }

    /**
     * Parses a formatted name string and returns an associative array of the components in the name.
     * The following name formats are supported:
     * Template: Pattern
     * - appProfile: projects/{project}/instances/{instance}/appProfiles/{app_profile}
     * - cluster: projects/{project}/instances/{instance}/clusters/{cluster}
     * - instance: projects/{project}/instances/{instance}
     * - location: projects/{project}/locations/{location}
     * - project: projects/{project}.
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
     *     @type string $serviceAddress
     *           The address of the API remote host. May optionally include the port, formatted
     *           as "<uri>:<port>". Default 'bigtableadmin.googleapis.com:443'.
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
        $this->operationsClient = $this->createOperationsClient($clientOptions);
    }

    /**
     * Create an instance within a project.
     *
     * Sample code:
     * ```
     * $bigtableInstanceAdminClient = new Google\Cloud\Bigtable\Admin\V2\BigtableInstanceAdminClient();
     * try {
     *     $formattedParent = $bigtableInstanceAdminClient->projectName('[PROJECT]');
     *     $instanceId = '';
     *     $instance = new Google\Cloud\Bigtable\Admin\V2\Instance();
     *     $clusters = [];
     *     $operationResponse = $bigtableInstanceAdminClient->createInstance($formattedParent, $instanceId, $instance, $clusters);
     *     $operationResponse->pollUntilComplete();
     *     if ($operationResponse->operationSucceeded()) {
     *         $result = $operationResponse->getResult();
     *         // doSomethingWith($result)
     *     } else {
     *         $error = $operationResponse->getError();
     *         // handleError($error)
     *     }
     *
     *
     *     // Alternatively:
     *
     *     // start the operation, keep the operation name, and resume later
     *     $operationResponse = $bigtableInstanceAdminClient->createInstance($formattedParent, $instanceId, $instance, $clusters);
     *     $operationName = $operationResponse->getName();
     *     // ... do other work
     *     $newOperationResponse = $bigtableInstanceAdminClient->resumeOperation($operationName, 'createInstance');
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
     *     $bigtableInstanceAdminClient->close();
     * }
     * ```
     *
     * @param string   $parent       The unique name of the project in which to create the new instance.
     *                               Values are of the form `projects/<project>`.
     * @param string   $instanceId   The ID to be used when referring to the new instance within its project,
     *                               e.g., just `myinstance` rather than
     *                               `projects/myproject/instances/myinstance`.
     * @param Instance $instance     The instance to create.
     *                               Fields marked `OutputOnly` must be left blank.
     * @param array    $clusters     The clusters to be created within the instance, mapped by desired
     *                               cluster ID, e.g., just `mycluster` rather than
     *                               `projects/myproject/instances/myinstance/clusters/mycluster`.
     *                               Fields marked `OutputOnly` must be left blank.
     *                               Currently, at most two clusters can be specified.
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
    public function createInstance($parent, $instanceId, $instance, $clusters, array $optionalArgs = [])
    {
        $request = new CreateInstanceRequest();
        $request->setParent($parent);
        $request->setInstanceId($instanceId);
        $request->setInstance($instance);
        $request->setClusters($clusters);

        $requestParams = new RequestParamsHeaderDescriptor([
          'parent' => $request->getParent(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startOperationsCall(
            'CreateInstance',
            $optionalArgs,
            $request,
            $this->getOperationsClient()
        )->wait();
    }

    /**
     * Gets information about an instance.
     *
     * Sample code:
     * ```
     * $bigtableInstanceAdminClient = new Google\Cloud\Bigtable\Admin\V2\BigtableInstanceAdminClient();
     * try {
     *     $formattedName = $bigtableInstanceAdminClient->instanceName('[PROJECT]', '[INSTANCE]');
     *     $response = $bigtableInstanceAdminClient->getInstance($formattedName);
     * } finally {
     *     $bigtableInstanceAdminClient->close();
     * }
     * ```
     *
     * @param string $name         The unique name of the requested instance. Values are of the form
     *                             `projects/<project>/instances/<instance>`.
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
     * @return \Google\Cloud\Bigtable\Admin\V2\Instance
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function getInstance($name, array $optionalArgs = [])
    {
        $request = new GetInstanceRequest();
        $request->setName($name);

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'GetInstance',
            Instance::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Lists information about instances in a project.
     *
     * Sample code:
     * ```
     * $bigtableInstanceAdminClient = new Google\Cloud\Bigtable\Admin\V2\BigtableInstanceAdminClient();
     * try {
     *     $formattedParent = $bigtableInstanceAdminClient->projectName('[PROJECT]');
     *     $response = $bigtableInstanceAdminClient->listInstances($formattedParent);
     * } finally {
     *     $bigtableInstanceAdminClient->close();
     * }
     * ```
     *
     * @param string $parent       The unique name of the project for which a list of instances is requested.
     *                             Values are of the form `projects/<project>`.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type string $pageToken
     *          DEPRECATED: This field is unused and ignored.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Bigtable\Admin\V2\ListInstancesResponse
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function listInstances($parent, array $optionalArgs = [])
    {
        $request = new ListInstancesRequest();
        $request->setParent($parent);
        if (isset($optionalArgs['pageToken'])) {
            $request->setPageToken($optionalArgs['pageToken']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'parent' => $request->getParent(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'ListInstances',
            ListInstancesResponse::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Updates an instance within a project.
     *
     * Sample code:
     * ```
     * $bigtableInstanceAdminClient = new Google\Cloud\Bigtable\Admin\V2\BigtableInstanceAdminClient();
     * try {
     *     $formattedName = $bigtableInstanceAdminClient->instanceName('[PROJECT]', '[INSTANCE]');
     *     $displayName = '';
     *     $type = Google\Cloud\Bigtable\Admin\V2\Instance\Type::TYPE_UNSPECIFIED;
     *     $labels = [];
     *     $response = $bigtableInstanceAdminClient->updateInstance($formattedName, $displayName, $type, $labels);
     * } finally {
     *     $bigtableInstanceAdminClient->close();
     * }
     * ```
     *
     * @param string $name        (`OutputOnly`)
     *                            The unique name of the instance. Values are of the form
     *                            `projects/<project>/instances/[a-z][a-z0-9\\-]+[a-z0-9]`.
     * @param string $displayName The descriptive name for this instance as it appears in UIs.
     *                            Can be changed at any time, but should be kept globally unique
     *                            to avoid confusion.
     * @param int    $type        The type of the instance. Defaults to `PRODUCTION`.
     *                            For allowed values, use constants defined on {@see \Google\Cloud\Bigtable\Admin\V2\Instance\Type}
     * @param array  $labels      Labels are a flexible and lightweight mechanism for organizing cloud
     *                            resources into groups that reflect a customer's organizational needs and
     *                            deployment strategies. They can be used to filter resources and aggregate
     *                            metrics.
     *
     * * Label keys must be between 1 and 63 characters long and must conform to
     *   the regular expression: `[\p{Ll}\p{Lo}][\p{Ll}\p{Lo}\p{N}_-]{0,62}`.
     * * Label values must be between 0 and 63 characters long and must conform to
     *   the regular expression: `[\p{Ll}\p{Lo}\p{N}_-]{0,63}`.
     * * No more than 64 labels can be associated with a given resource.
     * * Keys and values must both be under 128 bytes.
     * @param array $optionalArgs {
     *                            Optional.
     *
     *     @type int $state
     *          (`OutputOnly`)
     *          The current state of the instance.
     *          For allowed values, use constants defined on {@see \Google\Cloud\Bigtable\Admin\V2\Instance\State}
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Bigtable\Admin\V2\Instance
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function updateInstance($name, $displayName, $type, $labels, array $optionalArgs = [])
    {
        $request = new Instance();
        $request->setName($name);
        $request->setDisplayName($displayName);
        $request->setType($type);
        $request->setLabels($labels);
        if (isset($optionalArgs['state'])) {
            $request->setState($optionalArgs['state']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'UpdateInstance',
            Instance::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Partially updates an instance within a project.
     *
     * Sample code:
     * ```
     * $bigtableInstanceAdminClient = new Google\Cloud\Bigtable\Admin\V2\BigtableInstanceAdminClient();
     * try {
     *     $instance = new Google\Cloud\Bigtable\Admin\V2\Instance();
     *     $updateMask = new Google\Protobuf\FieldMask();
     *     $operationResponse = $bigtableInstanceAdminClient->partialUpdateInstance($instance, $updateMask);
     *     $operationResponse->pollUntilComplete();
     *     if ($operationResponse->operationSucceeded()) {
     *         $result = $operationResponse->getResult();
     *         // doSomethingWith($result)
     *     } else {
     *         $error = $operationResponse->getError();
     *         // handleError($error)
     *     }
     *
     *
     *     // Alternatively:
     *
     *     // start the operation, keep the operation name, and resume later
     *     $operationResponse = $bigtableInstanceAdminClient->partialUpdateInstance($instance, $updateMask);
     *     $operationName = $operationResponse->getName();
     *     // ... do other work
     *     $newOperationResponse = $bigtableInstanceAdminClient->resumeOperation($operationName, 'partialUpdateInstance');
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
     *     $bigtableInstanceAdminClient->close();
     * }
     * ```
     *
     * @param Instance  $instance     The Instance which will (partially) replace the current value.
     * @param FieldMask $updateMask   The subset of Instance fields which should be replaced.
     *                                Must be explicitly set.
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
    public function partialUpdateInstance($instance, $updateMask, array $optionalArgs = [])
    {
        $request = new PartialUpdateInstanceRequest();
        $request->setInstance($instance);
        $request->setUpdateMask($updateMask);

        $requestParams = new RequestParamsHeaderDescriptor([
          'instance.name' => $request->getInstance()->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startOperationsCall(
            'PartialUpdateInstance',
            $optionalArgs,
            $request,
            $this->getOperationsClient()
        )->wait();
    }

    /**
     * Delete an instance from a project.
     *
     * Sample code:
     * ```
     * $bigtableInstanceAdminClient = new Google\Cloud\Bigtable\Admin\V2\BigtableInstanceAdminClient();
     * try {
     *     $formattedName = $bigtableInstanceAdminClient->instanceName('[PROJECT]', '[INSTANCE]');
     *     $bigtableInstanceAdminClient->deleteInstance($formattedName);
     * } finally {
     *     $bigtableInstanceAdminClient->close();
     * }
     * ```
     *
     * @param string $name         The unique name of the instance to be deleted.
     *                             Values are of the form `projects/<project>/instances/<instance>`.
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
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function deleteInstance($name, array $optionalArgs = [])
    {
        $request = new DeleteInstanceRequest();
        $request->setName($name);

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'DeleteInstance',
            GPBEmpty::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Creates a cluster within an instance.
     *
     * Sample code:
     * ```
     * $bigtableInstanceAdminClient = new Google\Cloud\Bigtable\Admin\V2\BigtableInstanceAdminClient();
     * try {
     *     $formattedParent = $bigtableInstanceAdminClient->instanceName('[PROJECT]', '[INSTANCE]');
     *     $clusterId = '';
     *     $cluster = new Google\Cloud\Bigtable\Admin\V2\Cluster();
     *     $operationResponse = $bigtableInstanceAdminClient->createCluster($formattedParent, $clusterId, $cluster);
     *     $operationResponse->pollUntilComplete();
     *     if ($operationResponse->operationSucceeded()) {
     *         $result = $operationResponse->getResult();
     *         // doSomethingWith($result)
     *     } else {
     *         $error = $operationResponse->getError();
     *         // handleError($error)
     *     }
     *
     *
     *     // Alternatively:
     *
     *     // start the operation, keep the operation name, and resume later
     *     $operationResponse = $bigtableInstanceAdminClient->createCluster($formattedParent, $clusterId, $cluster);
     *     $operationName = $operationResponse->getName();
     *     // ... do other work
     *     $newOperationResponse = $bigtableInstanceAdminClient->resumeOperation($operationName, 'createCluster');
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
     *     $bigtableInstanceAdminClient->close();
     * }
     * ```
     *
     * @param string  $parent       The unique name of the instance in which to create the new cluster.
     *                              Values are of the form
     *                              `projects/<project>/instances/<instance>`.
     * @param string  $clusterId    The ID to be used when referring to the new cluster within its instance,
     *                              e.g., just `mycluster` rather than
     *                              `projects/myproject/instances/myinstance/clusters/mycluster`.
     * @param Cluster $cluster      The cluster to be created.
     *                              Fields marked `OutputOnly` must be left blank.
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
     * @return \Google\ApiCore\OperationResponse
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function createCluster($parent, $clusterId, $cluster, array $optionalArgs = [])
    {
        $request = new CreateClusterRequest();
        $request->setParent($parent);
        $request->setClusterId($clusterId);
        $request->setCluster($cluster);

        $requestParams = new RequestParamsHeaderDescriptor([
          'parent' => $request->getParent(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startOperationsCall(
            'CreateCluster',
            $optionalArgs,
            $request,
            $this->getOperationsClient()
        )->wait();
    }

    /**
     * Gets information about a cluster.
     *
     * Sample code:
     * ```
     * $bigtableInstanceAdminClient = new Google\Cloud\Bigtable\Admin\V2\BigtableInstanceAdminClient();
     * try {
     *     $formattedName = $bigtableInstanceAdminClient->clusterName('[PROJECT]', '[INSTANCE]', '[CLUSTER]');
     *     $response = $bigtableInstanceAdminClient->getCluster($formattedName);
     * } finally {
     *     $bigtableInstanceAdminClient->close();
     * }
     * ```
     *
     * @param string $name         The unique name of the requested cluster. Values are of the form
     *                             `projects/<project>/instances/<instance>/clusters/<cluster>`.
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
     * @return \Google\Cloud\Bigtable\Admin\V2\Cluster
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function getCluster($name, array $optionalArgs = [])
    {
        $request = new GetClusterRequest();
        $request->setName($name);

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'GetCluster',
            Cluster::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Lists information about clusters in an instance.
     *
     * Sample code:
     * ```
     * $bigtableInstanceAdminClient = new Google\Cloud\Bigtable\Admin\V2\BigtableInstanceAdminClient();
     * try {
     *     $formattedParent = $bigtableInstanceAdminClient->instanceName('[PROJECT]', '[INSTANCE]');
     *     $response = $bigtableInstanceAdminClient->listClusters($formattedParent);
     * } finally {
     *     $bigtableInstanceAdminClient->close();
     * }
     * ```
     *
     * @param string $parent       The unique name of the instance for which a list of clusters is requested.
     *                             Values are of the form `projects/<project>/instances/<instance>`.
     *                             Use `<instance> = '-'` to list Clusters for all Instances in a project,
     *                             e.g., `projects/myproject/instances/-`.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type string $pageToken
     *          DEPRECATED: This field is unused and ignored.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Bigtable\Admin\V2\ListClustersResponse
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function listClusters($parent, array $optionalArgs = [])
    {
        $request = new ListClustersRequest();
        $request->setParent($parent);
        if (isset($optionalArgs['pageToken'])) {
            $request->setPageToken($optionalArgs['pageToken']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'parent' => $request->getParent(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'ListClusters',
            ListClustersResponse::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Updates a cluster within an instance.
     *
     * Sample code:
     * ```
     * $bigtableInstanceAdminClient = new Google\Cloud\Bigtable\Admin\V2\BigtableInstanceAdminClient();
     * try {
     *     $formattedName = $bigtableInstanceAdminClient->clusterName('[PROJECT]', '[INSTANCE]', '[CLUSTER]');
     *     $serveNodes = 0;
     *     $operationResponse = $bigtableInstanceAdminClient->updateCluster($formattedName, $serveNodes);
     *     $operationResponse->pollUntilComplete();
     *     if ($operationResponse->operationSucceeded()) {
     *         $result = $operationResponse->getResult();
     *         // doSomethingWith($result)
     *     } else {
     *         $error = $operationResponse->getError();
     *         // handleError($error)
     *     }
     *
     *
     *     // Alternatively:
     *
     *     // start the operation, keep the operation name, and resume later
     *     $operationResponse = $bigtableInstanceAdminClient->updateCluster($formattedName, $serveNodes);
     *     $operationName = $operationResponse->getName();
     *     // ... do other work
     *     $newOperationResponse = $bigtableInstanceAdminClient->resumeOperation($operationName, 'updateCluster');
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
     *     $bigtableInstanceAdminClient->close();
     * }
     * ```
     *
     * @param string $name         (`OutputOnly`)
     *                             The unique name of the cluster. Values are of the form
     *                             `projects/<project>/instances/<instance>/clusters/[a-z][-a-z0-9]*`.
     * @param int    $serveNodes   The number of nodes allocated to this cluster. More nodes enable higher
     *                             throughput and more consistent performance.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type string $location
     *          (`CreationOnly`)
     *          The location where this cluster's nodes and storage reside. For best
     *          performance, clients should be located as close as possible to this
     *          cluster. Currently only zones are supported, so values should be of the
     *          form `projects/<project>/locations/<zone>`.
     *     @type int $state
     *          (`OutputOnly`)
     *          The current state of the cluster.
     *          For allowed values, use constants defined on {@see \Google\Cloud\Bigtable\Admin\V2\Cluster\State}
     *     @type int $defaultStorageType
     *          (`CreationOnly`)
     *          The type of storage used by this cluster to serve its
     *          parent instance's tables, unless explicitly overridden.
     *          For allowed values, use constants defined on {@see \Google\Cloud\Bigtable\Admin\V2\StorageType}
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
    public function updateCluster($name, $serveNodes, array $optionalArgs = [])
    {
        $request = new Cluster();
        $request->setName($name);
        $request->setServeNodes($serveNodes);
        if (isset($optionalArgs['location'])) {
            $request->setLocation($optionalArgs['location']);
        }
        if (isset($optionalArgs['state'])) {
            $request->setState($optionalArgs['state']);
        }
        if (isset($optionalArgs['defaultStorageType'])) {
            $request->setDefaultStorageType($optionalArgs['defaultStorageType']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startOperationsCall(
            'UpdateCluster',
            $optionalArgs,
            $request,
            $this->getOperationsClient()
        )->wait();
    }

    /**
     * Deletes a cluster from an instance.
     *
     * Sample code:
     * ```
     * $bigtableInstanceAdminClient = new Google\Cloud\Bigtable\Admin\V2\BigtableInstanceAdminClient();
     * try {
     *     $formattedName = $bigtableInstanceAdminClient->clusterName('[PROJECT]', '[INSTANCE]', '[CLUSTER]');
     *     $bigtableInstanceAdminClient->deleteCluster($formattedName);
     * } finally {
     *     $bigtableInstanceAdminClient->close();
     * }
     * ```
     *
     * @param string $name         The unique name of the cluster to be deleted. Values are of the form
     *                             `projects/<project>/instances/<instance>/clusters/<cluster>`.
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
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function deleteCluster($name, array $optionalArgs = [])
    {
        $request = new DeleteClusterRequest();
        $request->setName($name);

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'DeleteCluster',
            GPBEmpty::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Creates an app profile within an instance.
     *
     * Sample code:
     * ```
     * $bigtableInstanceAdminClient = new Google\Cloud\Bigtable\Admin\V2\BigtableInstanceAdminClient();
     * try {
     *     $formattedParent = $bigtableInstanceAdminClient->instanceName('[PROJECT]', '[INSTANCE]');
     *     $appProfileId = '';
     *     $appProfile = new Google\Cloud\Bigtable\Admin\V2\AppProfile();
     *     $response = $bigtableInstanceAdminClient->createAppProfile($formattedParent, $appProfileId, $appProfile);
     * } finally {
     *     $bigtableInstanceAdminClient->close();
     * }
     * ```
     *
     * @param string     $parent       The unique name of the instance in which to create the new app profile.
     *                                 Values are of the form
     *                                 `projects/<project>/instances/<instance>`.
     * @param string     $appProfileId The ID to be used when referring to the new app profile within its
     *                                 instance, e.g., just `myprofile` rather than
     *                                 `projects/myproject/instances/myinstance/appProfiles/myprofile`.
     * @param AppProfile $appProfile   The app profile to be created.
     *                                 Fields marked `OutputOnly` will be ignored.
     * @param array      $optionalArgs {
     *                                 Optional.
     *
     *     @type bool $ignoreWarnings
     *          If true, ignore safety checks when creating the app profile.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Bigtable\Admin\V2\AppProfile
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function createAppProfile($parent, $appProfileId, $appProfile, array $optionalArgs = [])
    {
        $request = new CreateAppProfileRequest();
        $request->setParent($parent);
        $request->setAppProfileId($appProfileId);
        $request->setAppProfile($appProfile);
        if (isset($optionalArgs['ignoreWarnings'])) {
            $request->setIgnoreWarnings($optionalArgs['ignoreWarnings']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'parent' => $request->getParent(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'CreateAppProfile',
            AppProfile::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Gets information about an app profile.
     *
     * Sample code:
     * ```
     * $bigtableInstanceAdminClient = new Google\Cloud\Bigtable\Admin\V2\BigtableInstanceAdminClient();
     * try {
     *     $formattedName = $bigtableInstanceAdminClient->appProfileName('[PROJECT]', '[INSTANCE]', '[APP_PROFILE]');
     *     $response = $bigtableInstanceAdminClient->getAppProfile($formattedName);
     * } finally {
     *     $bigtableInstanceAdminClient->close();
     * }
     * ```
     *
     * @param string $name         The unique name of the requested app profile. Values are of the form
     *                             `projects/<project>/instances/<instance>/appProfiles/<app_profile>`.
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
     * @return \Google\Cloud\Bigtable\Admin\V2\AppProfile
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function getAppProfile($name, array $optionalArgs = [])
    {
        $request = new GetAppProfileRequest();
        $request->setName($name);

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'GetAppProfile',
            AppProfile::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Lists information about app profiles in an instance.
     *
     * Sample code:
     * ```
     * $bigtableInstanceAdminClient = new Google\Cloud\Bigtable\Admin\V2\BigtableInstanceAdminClient();
     * try {
     *     $formattedParent = $bigtableInstanceAdminClient->instanceName('[PROJECT]', '[INSTANCE]');
     *     // Iterate over pages of elements
     *     $pagedResponse = $bigtableInstanceAdminClient->listAppProfiles($formattedParent);
     *     foreach ($pagedResponse->iteratePages() as $page) {
     *         foreach ($page as $element) {
     *             // doSomethingWith($element);
     *         }
     *     }
     *
     *
     *     // Alternatively:
     *
     *     // Iterate through all elements
     *     $pagedResponse = $bigtableInstanceAdminClient->listAppProfiles($formattedParent);
     *     foreach ($pagedResponse->iterateAllElements() as $element) {
     *         // doSomethingWith($element);
     *     }
     * } finally {
     *     $bigtableInstanceAdminClient->close();
     * }
     * ```
     *
     * @param string $parent       The unique name of the instance for which a list of app profiles is
     *                             requested. Values are of the form
     *                             `projects/<project>/instances/<instance>`.
     *                             Use `<instance> = '-'` to list AppProfiles for all Instances in a project,
     *                             e.g., `projects/myproject/instances/-`.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type int $pageSize
     *          Maximum number of results per page.
     *          CURRENTLY UNIMPLEMENTED AND IGNORED.
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
    public function listAppProfiles($parent, array $optionalArgs = [])
    {
        $request = new ListAppProfilesRequest();
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
            'ListAppProfiles',
            $optionalArgs,
            ListAppProfilesResponse::class,
            $request
        );
    }

    /**
     * Updates an app profile within an instance.
     *
     * Sample code:
     * ```
     * $bigtableInstanceAdminClient = new Google\Cloud\Bigtable\Admin\V2\BigtableInstanceAdminClient();
     * try {
     *     $appProfile = new Google\Cloud\Bigtable\Admin\V2\AppProfile();
     *     $updateMask = new Google\Protobuf\FieldMask();
     *     $operationResponse = $bigtableInstanceAdminClient->updateAppProfile($appProfile, $updateMask);
     *     $operationResponse->pollUntilComplete();
     *     if ($operationResponse->operationSucceeded()) {
     *         $result = $operationResponse->getResult();
     *         // doSomethingWith($result)
     *     } else {
     *         $error = $operationResponse->getError();
     *         // handleError($error)
     *     }
     *
     *
     *     // Alternatively:
     *
     *     // start the operation, keep the operation name, and resume later
     *     $operationResponse = $bigtableInstanceAdminClient->updateAppProfile($appProfile, $updateMask);
     *     $operationName = $operationResponse->getName();
     *     // ... do other work
     *     $newOperationResponse = $bigtableInstanceAdminClient->resumeOperation($operationName, 'updateAppProfile');
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
     *     $bigtableInstanceAdminClient->close();
     * }
     * ```
     *
     * @param AppProfile $appProfile   The app profile which will (partially) replace the current value.
     * @param FieldMask  $updateMask   The subset of app profile fields which should be replaced.
     *                                 If unset, all fields will be replaced.
     * @param array      $optionalArgs {
     *                                 Optional.
     *
     *     @type bool $ignoreWarnings
     *          If true, ignore safety checks when updating the app profile.
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
    public function updateAppProfile($appProfile, $updateMask, array $optionalArgs = [])
    {
        $request = new UpdateAppProfileRequest();
        $request->setAppProfile($appProfile);
        $request->setUpdateMask($updateMask);
        if (isset($optionalArgs['ignoreWarnings'])) {
            $request->setIgnoreWarnings($optionalArgs['ignoreWarnings']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'app_profile.name' => $request->getAppProfile()->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startOperationsCall(
            'UpdateAppProfile',
            $optionalArgs,
            $request,
            $this->getOperationsClient()
        )->wait();
    }

    /**
     * Deletes an app profile from an instance.
     *
     * Sample code:
     * ```
     * $bigtableInstanceAdminClient = new Google\Cloud\Bigtable\Admin\V2\BigtableInstanceAdminClient();
     * try {
     *     $formattedName = $bigtableInstanceAdminClient->appProfileName('[PROJECT]', '[INSTANCE]', '[APP_PROFILE]');
     *     $ignoreWarnings = false;
     *     $bigtableInstanceAdminClient->deleteAppProfile($formattedName, $ignoreWarnings);
     * } finally {
     *     $bigtableInstanceAdminClient->close();
     * }
     * ```
     *
     * @param string $name           The unique name of the app profile to be deleted. Values are of the form
     *                               `projects/<project>/instances/<instance>/appProfiles/<app_profile>`.
     * @param bool   $ignoreWarnings If true, ignore safety checks when deleting the app profile.
     * @param array  $optionalArgs   {
     *                               Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function deleteAppProfile($name, $ignoreWarnings, array $optionalArgs = [])
    {
        $request = new DeleteAppProfileRequest();
        $request->setName($name);
        $request->setIgnoreWarnings($ignoreWarnings);

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'DeleteAppProfile',
            GPBEmpty::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Gets the access control policy for an instance resource. Returns an empty
     * policy if an instance exists but does not have a policy set.
     *
     * Sample code:
     * ```
     * $bigtableInstanceAdminClient = new Google\Cloud\Bigtable\Admin\V2\BigtableInstanceAdminClient();
     * try {
     *     $formattedResource = $bigtableInstanceAdminClient->instanceName('[PROJECT]', '[INSTANCE]');
     *     $response = $bigtableInstanceAdminClient->getIamPolicy($formattedResource);
     * } finally {
     *     $bigtableInstanceAdminClient->close();
     * }
     * ```
     *
     * @param string $resource     REQUIRED: The resource for which the policy is being requested.
     *                             See the operation documentation for the appropriate value for this field.
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
            $request
        )->wait();
    }

    /**
     * Sets the access control policy on an instance resource. Replaces any
     * existing policy.
     *
     * Sample code:
     * ```
     * $bigtableInstanceAdminClient = new Google\Cloud\Bigtable\Admin\V2\BigtableInstanceAdminClient();
     * try {
     *     $formattedResource = $bigtableInstanceAdminClient->instanceName('[PROJECT]', '[INSTANCE]');
     *     $policy = new Google\Cloud\Iam\V1\Policy();
     *     $response = $bigtableInstanceAdminClient->setIamPolicy($formattedResource, $policy);
     * } finally {
     *     $bigtableInstanceAdminClient->close();
     * }
     * ```
     *
     * @param string $resource     REQUIRED: The resource for which the policy is being specified.
     *                             See the operation documentation for the appropriate value for this field.
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
            $request
        )->wait();
    }

    /**
     * Returns permissions that the caller has on the specified instance resource.
     *
     * Sample code:
     * ```
     * $bigtableInstanceAdminClient = new Google\Cloud\Bigtable\Admin\V2\BigtableInstanceAdminClient();
     * try {
     *     $formattedResource = $bigtableInstanceAdminClient->instanceName('[PROJECT]', '[INSTANCE]');
     *     $permissions = [];
     *     $response = $bigtableInstanceAdminClient->testIamPermissions($formattedResource, $permissions);
     * } finally {
     *     $bigtableInstanceAdminClient->close();
     * }
     * ```
     *
     * @param string   $resource     REQUIRED: The resource for which the policy detail is being requested.
     *                               See the operation documentation for the appropriate value for this field.
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
            $request
        )->wait();
    }
}

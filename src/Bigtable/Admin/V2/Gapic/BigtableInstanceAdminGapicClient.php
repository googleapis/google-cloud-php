<?php
/*
 * Copyright 2017, Google LLC All rights reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
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
 * EXPERIMENTAL: this client library class has not yet been declared GA (1.0). This means that
 * even though we intent the surface to be stable, we may make backwards incompatible changes
 * if necessary.
 *
 * @experimental
 */

namespace Google\Cloud\Bigtable\Admin\V2\Gapic;

use Google\ApiCore\AgentHeaderDescriptor;
use Google\ApiCore\ApiCallable;
use Google\ApiCore\CallSettings;
use Google\ApiCore\GrpcCredentialsHelper;
use Google\ApiCore\LongRunning\OperationsClient;
use Google\ApiCore\OperationResponse;
use Google\ApiCore\PathTemplate;
use Google\ApiCore\ValidationException;
use Google\Cloud\Bigtable\Admin\V2\BigtableInstanceAdminGrpcClient;
use Google\Cloud\Bigtable\Admin\V2\Cluster;
use Google\Cloud\Bigtable\Admin\V2\CreateClusterRequest;
use Google\Cloud\Bigtable\Admin\V2\CreateInstanceRequest;
use Google\Cloud\Bigtable\Admin\V2\DeleteClusterRequest;
use Google\Cloud\Bigtable\Admin\V2\DeleteInstanceRequest;
use Google\Cloud\Bigtable\Admin\V2\GetClusterRequest;
use Google\Cloud\Bigtable\Admin\V2\GetInstanceRequest;
use Google\Cloud\Bigtable\Admin\V2\Instance;
use Google\Cloud\Bigtable\Admin\V2\Instance_State as State;
use Google\Cloud\Bigtable\Admin\V2\Instance_Type as Type;
use Google\Cloud\Bigtable\Admin\V2\ListClustersRequest;
use Google\Cloud\Bigtable\Admin\V2\ListInstancesRequest;
use Google\Cloud\Bigtable\Admin\V2\StorageType;
use Google\Cloud\Version;

/**
 * Service Description: Service for creating, configuring, and deleting Cloud Bigtable Instances and
 * Clusters. Provides access to the Instance and Cluster schemas only, not the
 * tables' metadata or data stored in those tables.
 *
 * EXPERIMENTAL: this client library class has not yet been declared GA (1.0). This means that
 * even though we intent the surface to be stable, we may make backwards incompatible changes
 * if necessary.
 *
 * This class provides the ability to make remote calls to the backing service through method
 * calls that map to API methods. Sample code to get started:
 *
 * ```
 * try {
 *     $bigtableInstanceAdminClient = new BigtableInstanceAdminClient();
 *     $formattedParent = $bigtableInstanceAdminClient->projectName('[PROJECT]');
 *     $instanceId = '';
 *     $instance = new Instance();
 *     $clusters = [];
 *     $operationResponse = $bigtableInstanceAdminClient->createInstance($formattedParent, $instanceId, $instance, $clusters);
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
     * The code generator version, to be included in the agent header.
     */
    const CODEGEN_VERSION = '0.0.5';

    private static $projectNameTemplate;
    private static $instanceNameTemplate;
    private static $clusterNameTemplate;
    private static $locationNameTemplate;
    private static $pathTemplateMap;
    private static $gapicVersion;
    private static $gapicVersionLoaded = false;

    protected $grpcCredentialsHelper;
    protected $bigtableInstanceAdminStub;
    private $scopes;
    private $defaultCallSettings;
    private $descriptors;
    private $operationsClient;

    private static function getProjectNameTemplate()
    {
        if (self::$projectNameTemplate == null) {
            self::$projectNameTemplate = new PathTemplate('projects/{project}');
        }

        return self::$projectNameTemplate;
    }

    private static function getInstanceNameTemplate()
    {
        if (self::$instanceNameTemplate == null) {
            self::$instanceNameTemplate = new PathTemplate('projects/{project}/instances/{instance}');
        }

        return self::$instanceNameTemplate;
    }

    private static function getClusterNameTemplate()
    {
        if (self::$clusterNameTemplate == null) {
            self::$clusterNameTemplate = new PathTemplate('projects/{project}/instances/{instance}/clusters/{cluster}');
        }

        return self::$clusterNameTemplate;
    }

    private static function getLocationNameTemplate()
    {
        if (self::$locationNameTemplate == null) {
            self::$locationNameTemplate = new PathTemplate('projects/{project}/locations/{location}');
        }

        return self::$locationNameTemplate;
    }

    private static function getPathTemplateMap()
    {
        if (self::$pathTemplateMap == null) {
            self::$pathTemplateMap = [
                'project' => self::getProjectNameTemplate(),
                'instance' => self::getInstanceNameTemplate(),
                'cluster' => self::getClusterNameTemplate(),
                'location' => self::getLocationNameTemplate(),
            ];
        }

        return self::$pathTemplateMap;
    }

    private static function getLongRunningDescriptors()
    {
        return [
            'createInstance' => [
                'operationReturnType' => '\Google\Cloud\Bigtable\Admin\V2\Instance',
                'metadataReturnType' => '\Google\Cloud\Bigtable\Admin\V2\CreateInstanceMetadata',
            ],
            'createCluster' => [
                'operationReturnType' => '\Google\Cloud\Bigtable\Admin\V2\Cluster',
                'metadataReturnType' => '\Google\Cloud\Bigtable\Admin\V2\CreateClusterMetadata',
            ],
            'updateCluster' => [
                'operationReturnType' => '\Google\Cloud\Bigtable\Admin\V2\Cluster',
                'metadataReturnType' => '\Google\Cloud\Bigtable\Admin\V2\UpdateClusterMetadata',
            ],
        ];
    }

    private static function getGapicVersion()
    {
        if (!self::$gapicVersionLoaded) {
            if (file_exists(__DIR__.'/../VERSION')) {
                self::$gapicVersion = trim(file_get_contents(__DIR__.'/../VERSION'));
            } elseif (class_exists(Version::class)) {
                self::$gapicVersion = Version::VERSION;
            }
            self::$gapicVersionLoaded = true;
        }

        return self::$gapicVersion;
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
     * Parses a formatted name string and returns an associative array of the components in the name.
     * The following name formats are supported:
     * Template: Pattern
     * - project: projects/{project}
     * - instance: projects/{project}/instances/{instance}
     * - cluster: projects/{project}/instances/{instance}/clusters/{cluster}
     * - location: projects/{project}/locations/{location}.
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
     * @return \Google\ApiCore\LongRunning\OperationsClient
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
     * @return \Google\ApiCore\OperationResponse
     * @experimental
     */
    public function resumeOperation($operationName, $methodName = null)
    {
        $lroDescriptors = self::getLongRunningDescriptors();
        if (!is_null($methodName) && array_key_exists($methodName, $lroDescriptors)) {
            $options = $lroDescriptors[$methodName];
        } else {
            $options = [];
        }
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
     *                                  Default 'bigtableadmin.googleapis.com'.
     *     @type mixed $port The port on which to connect to the remote host. Default 443.
     *     @type \Grpc\Channel $channel
     *           A `Channel` object to be used by gRPC. If not specified, a channel will be constructed.
     *     @type \Grpc\ChannelCredentials $sslCreds
     *           A `ChannelCredentials` object for use with an SSL-enabled channel.
     *           Default: a credentials object returned from
     *           \Grpc\ChannelCredentials::createSsl()
     *           NOTE: if the $channel optional argument is specified, then this argument is unused.
     *     @type bool $forceNewChannel
     *           If true, this forces gRPC to create a new channel instead of using a persistent channel.
     *           Defaults to false.
     *           NOTE: if the $channel optional argument is specified, then this option is unused.
     *     @type \Google\Auth\CredentialsLoader $credentialsLoader
     *           A CredentialsLoader object created using the Google\Auth library.
     *     @type array $scopes A string array of scopes to use when acquiring credentials.
     *                          Defaults to the scopes for the Cloud Bigtable Admin API.
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
     * }
     * @experimental
     */
    public function __construct($options = [])
    {
        $defaultOptions = [
            'serviceAddress' => self::SERVICE_ADDRESS,
            'port' => self::DEFAULT_SERVICE_PORT,
            'scopes' => [
                'https://www.googleapis.com/auth/bigtable.admin',
                'https://www.googleapis.com/auth/bigtable.admin.cluster',
                'https://www.googleapis.com/auth/bigtable.admin.instance',
                'https://www.googleapis.com/auth/bigtable.admin.table',
                'https://www.googleapis.com/auth/cloud-bigtable.admin',
                'https://www.googleapis.com/auth/cloud-bigtable.admin.cluster',
                'https://www.googleapis.com/auth/cloud-bigtable.admin.table',
                'https://www.googleapis.com/auth/cloud-platform',
                'https://www.googleapis.com/auth/cloud-platform.read-only',
            ],
            'retryingOverride' => null,
            'libName' => null,
            'libVersion' => null,
            'clientConfigPath' => __DIR__.'/../resources/bigtable_instance_admin_client_config.json',
        ];
        $options = array_merge($defaultOptions, $options);

        if (array_key_exists('operationsClient', $options)) {
            $this->operationsClient = $options['operationsClient'];
        } else {
            $operationsClientOptions = $options;
            unset($operationsClientOptions['retryingOverride']);
            unset($operationsClientOptions['clientConfigPath']);
            $this->operationsClient = new OperationsClient($operationsClientOptions);
        }

        $gapicVersion = $options['libVersion'] ?: self::getGapicVersion();

        $headerDescriptor = new AgentHeaderDescriptor([
            'libName' => $options['libName'],
            'libVersion' => $options['libVersion'],
            'gapicVersion' => $gapicVersion,
        ]);

        $defaultDescriptors = ['headerDescriptor' => $headerDescriptor];
        $this->descriptors = [
            'createInstance' => $defaultDescriptors,
            'getInstance' => $defaultDescriptors,
            'listInstances' => $defaultDescriptors,
            'updateInstance' => $defaultDescriptors,
            'deleteInstance' => $defaultDescriptors,
            'createCluster' => $defaultDescriptors,
            'getCluster' => $defaultDescriptors,
            'listClusters' => $defaultDescriptors,
            'updateCluster' => $defaultDescriptors,
            'deleteCluster' => $defaultDescriptors,
        ];
        $longRunningDescriptors = self::getLongRunningDescriptors();
        foreach ($longRunningDescriptors as $method => $longRunningDescriptor) {
            $this->descriptors[$method]['longRunningDescriptor'] = $longRunningDescriptor + ['operationsClient' => $this->operationsClient];
        }

        $clientConfigJsonString = file_get_contents($options['clientConfigPath']);
        $clientConfig = json_decode($clientConfigJsonString, true);
        $this->defaultCallSettings =
                CallSettings::load(
                    'google.bigtable.admin.v2.BigtableInstanceAdmin',
                    $clientConfig,
                    $options['retryingOverride']
                );

        $this->scopes = $options['scopes'];

        $createStubOptions = [];
        if (array_key_exists('sslCreds', $options)) {
            $createStubOptions['sslCreds'] = $options['sslCreds'];
        }
        $this->grpcCredentialsHelper = new GrpcCredentialsHelper($options);

        $createBigtableInstanceAdminStubFunction = function ($hostname, $opts, $channel) {
            return new BigtableInstanceAdminGrpcClient($hostname, $opts, $channel);
        };
        if (array_key_exists('createBigtableInstanceAdminStubFunction', $options)) {
            $createBigtableInstanceAdminStubFunction = $options['createBigtableInstanceAdminStubFunction'];
        }
        $this->bigtableInstanceAdminStub = $this->grpcCredentialsHelper->createStub($createBigtableInstanceAdminStubFunction);
    }

    /**
     * Create an instance within a project.
     *
     * Sample code:
     * ```
     * try {
     *     $bigtableInstanceAdminClient = new BigtableInstanceAdminClient();
     *     $formattedParent = $bigtableInstanceAdminClient->projectName('[PROJECT]');
     *     $instanceId = '';
     *     $instance = new Instance();
     *     $clusters = [];
     *     $operationResponse = $bigtableInstanceAdminClient->createInstance($formattedParent, $instanceId, $instance, $clusters);
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
     *                               Currently exactly one cluster must be specified.
     * @param array    $optionalArgs {
     *                               Optional.
     *
     *     @type \Google\ApiCore\RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\ApiCore\OperationResponse
     *
     * @throws \Google\ApiCore\ApiException if the remote call fails
     * @experimental
     */
    public function createInstance($parent, $instanceId, $instance, $clusters, $optionalArgs = [])
    {
        $request = new CreateInstanceRequest();
        $request->setParent($parent);
        $request->setInstanceId($instanceId);
        $request->setInstance($instance);
        $request->setClusters($clusters);

        $defaultCallSettings = $this->defaultCallSettings['createInstance'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));
        $callable = ApiCallable::createApiCall(
            $this->bigtableInstanceAdminStub,
            'CreateInstance',
            $mergedSettings,
            $this->descriptors['createInstance']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Gets information about an instance.
     *
     * Sample code:
     * ```
     * try {
     *     $bigtableInstanceAdminClient = new BigtableInstanceAdminClient();
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
     *     @type \Google\ApiCore\RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Bigtable\Admin\V2\Instance
     *
     * @throws \Google\ApiCore\ApiException if the remote call fails
     * @experimental
     */
    public function getInstance($name, $optionalArgs = [])
    {
        $request = new GetInstanceRequest();
        $request->setName($name);

        $defaultCallSettings = $this->defaultCallSettings['getInstance'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));
        $callable = ApiCallable::createApiCall(
            $this->bigtableInstanceAdminStub,
            'GetInstance',
            $mergedSettings,
            $this->descriptors['getInstance']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Lists information about instances in a project.
     *
     * Sample code:
     * ```
     * try {
     *     $bigtableInstanceAdminClient = new BigtableInstanceAdminClient();
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
     *          The value of `next_page_token` returned by a previous call.
     *     @type \Google\ApiCore\RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Bigtable\Admin\V2\ListInstancesResponse
     *
     * @throws \Google\ApiCore\ApiException if the remote call fails
     * @experimental
     */
    public function listInstances($parent, $optionalArgs = [])
    {
        $request = new ListInstancesRequest();
        $request->setParent($parent);
        if (isset($optionalArgs['pageToken'])) {
            $request->setPageToken($optionalArgs['pageToken']);
        }

        $defaultCallSettings = $this->defaultCallSettings['listInstances'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));
        $callable = ApiCallable::createApiCall(
            $this->bigtableInstanceAdminStub,
            'ListInstances',
            $mergedSettings,
            $this->descriptors['listInstances']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Updates an instance within a project.
     *
     * Sample code:
     * ```
     * try {
     *     $bigtableInstanceAdminClient = new BigtableInstanceAdminClient();
     *     $formattedName = $bigtableInstanceAdminClient->instanceName('[PROJECT]', '[INSTANCE]');
     *     $displayName = '';
     *     $type = Type::TYPE_UNSPECIFIED;
     *     $response = $bigtableInstanceAdminClient->updateInstance($formattedName, $displayName, $type);
     * } finally {
     *     $bigtableInstanceAdminClient->close();
     * }
     * ```
     *
     * @param string $name         (`OutputOnly`)
     *                             The unique name of the instance. Values are of the form
     *                             `projects/<project>/instances/[a-z][a-z0-9\\-]+[a-z0-9]`.
     * @param string $displayName  The descriptive name for this instance as it appears in UIs.
     *                             Can be changed at any time, but should be kept globally unique
     *                             to avoid confusion.
     * @param int    $type         The type of the instance. Defaults to `PRODUCTION`.
     *                             For allowed values, use constants defined on {@see \Google\Cloud\Bigtable\Admin\V2\Instance_Type}
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type int $state
     *          (`OutputOnly`)
     *          The current state of the instance.
     *          For allowed values, use constants defined on {@see \Google\Cloud\Bigtable\Admin\V2\Instance_State}
     *     @type \Google\ApiCore\RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Bigtable\Admin\V2\Instance
     *
     * @throws \Google\ApiCore\ApiException if the remote call fails
     * @experimental
     */
    public function updateInstance($name, $displayName, $type, $optionalArgs = [])
    {
        $request = new Instance();
        $request->setName($name);
        $request->setDisplayName($displayName);
        $request->setType($type);
        if (isset($optionalArgs['state'])) {
            $request->setState($optionalArgs['state']);
        }

        $defaultCallSettings = $this->defaultCallSettings['updateInstance'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));
        $callable = ApiCallable::createApiCall(
            $this->bigtableInstanceAdminStub,
            'UpdateInstance',
            $mergedSettings,
            $this->descriptors['updateInstance']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Delete an instance from a project.
     *
     * Sample code:
     * ```
     * try {
     *     $bigtableInstanceAdminClient = new BigtableInstanceAdminClient();
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
     *     @type \Google\ApiCore\RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @throws \Google\ApiCore\ApiException if the remote call fails
     * @experimental
     */
    public function deleteInstance($name, $optionalArgs = [])
    {
        $request = new DeleteInstanceRequest();
        $request->setName($name);

        $defaultCallSettings = $this->defaultCallSettings['deleteInstance'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));
        $callable = ApiCallable::createApiCall(
            $this->bigtableInstanceAdminStub,
            'DeleteInstance',
            $mergedSettings,
            $this->descriptors['deleteInstance']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Creates a cluster within an instance.
     *
     * Sample code:
     * ```
     * try {
     *     $bigtableInstanceAdminClient = new BigtableInstanceAdminClient();
     *     $formattedParent = $bigtableInstanceAdminClient->instanceName('[PROJECT]', '[INSTANCE]');
     *     $clusterId = '';
     *     $cluster = new Cluster();
     *     $operationResponse = $bigtableInstanceAdminClient->createCluster($formattedParent, $clusterId, $cluster);
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
     *     @type \Google\ApiCore\RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\ApiCore\OperationResponse
     *
     * @throws \Google\ApiCore\ApiException if the remote call fails
     * @experimental
     */
    public function createCluster($parent, $clusterId, $cluster, $optionalArgs = [])
    {
        $request = new CreateClusterRequest();
        $request->setParent($parent);
        $request->setClusterId($clusterId);
        $request->setCluster($cluster);

        $defaultCallSettings = $this->defaultCallSettings['createCluster'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));
        $callable = ApiCallable::createApiCall(
            $this->bigtableInstanceAdminStub,
            'CreateCluster',
            $mergedSettings,
            $this->descriptors['createCluster']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Gets information about a cluster.
     *
     * Sample code:
     * ```
     * try {
     *     $bigtableInstanceAdminClient = new BigtableInstanceAdminClient();
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
     *     @type \Google\ApiCore\RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Bigtable\Admin\V2\Cluster
     *
     * @throws \Google\ApiCore\ApiException if the remote call fails
     * @experimental
     */
    public function getCluster($name, $optionalArgs = [])
    {
        $request = new GetClusterRequest();
        $request->setName($name);

        $defaultCallSettings = $this->defaultCallSettings['getCluster'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));
        $callable = ApiCallable::createApiCall(
            $this->bigtableInstanceAdminStub,
            'GetCluster',
            $mergedSettings,
            $this->descriptors['getCluster']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Lists information about clusters in an instance.
     *
     * Sample code:
     * ```
     * try {
     *     $bigtableInstanceAdminClient = new BigtableInstanceAdminClient();
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
     *          The value of `next_page_token` returned by a previous call.
     *     @type \Google\ApiCore\RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Bigtable\Admin\V2\ListClustersResponse
     *
     * @throws \Google\ApiCore\ApiException if the remote call fails
     * @experimental
     */
    public function listClusters($parent, $optionalArgs = [])
    {
        $request = new ListClustersRequest();
        $request->setParent($parent);
        if (isset($optionalArgs['pageToken'])) {
            $request->setPageToken($optionalArgs['pageToken']);
        }

        $defaultCallSettings = $this->defaultCallSettings['listClusters'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));
        $callable = ApiCallable::createApiCall(
            $this->bigtableInstanceAdminStub,
            'ListClusters',
            $mergedSettings,
            $this->descriptors['listClusters']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Updates a cluster within an instance.
     *
     * Sample code:
     * ```
     * try {
     *     $bigtableInstanceAdminClient = new BigtableInstanceAdminClient();
     *     $formattedName = $bigtableInstanceAdminClient->clusterName('[PROJECT]', '[INSTANCE]', '[CLUSTER]');
     *     $location = '';
     *     $serveNodes = 0;
     *     $defaultStorageType = StorageType::STORAGE_TYPE_UNSPECIFIED;
     *     $operationResponse = $bigtableInstanceAdminClient->updateCluster($formattedName, $location, $serveNodes, $defaultStorageType);
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
     *     $operationResponse = $bigtableInstanceAdminClient->updateCluster($formattedName, $location, $serveNodes, $defaultStorageType);
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
     * @param string $name               (`OutputOnly`)
     *                                   The unique name of the cluster. Values are of the form
     *                                   `projects/<project>/instances/<instance>/clusters/[a-z][-a-z0-9]*`.
     * @param string $location           (`CreationOnly`)
     *                                   The location where this cluster's nodes and storage reside. For best
     *                                   performance, clients should be located as close as possible to this cluster.
     *                                   Currently only zones are supported, so values should be of the form
     *                                   `projects/<project>/locations/<zone>`.
     * @param int    $serveNodes         The number of nodes allocated to this cluster. More nodes enable higher
     *                                   throughput and more consistent performance.
     * @param int    $defaultStorageType (`CreationOnly`)
     *                                   The type of storage used by this cluster to serve its
     *                                   parent instance's tables, unless explicitly overridden.
     *                                   For allowed values, use constants defined on {@see \Google\Cloud\Bigtable\Admin\V2\StorageType}
     * @param array  $optionalArgs       {
     *                                   Optional.
     *
     *     @type int $state
     *          (`OutputOnly`)
     *          The current state of the cluster.
     *          For allowed values, use constants defined on {@see \Google\Cloud\Bigtable\Admin\V2\Cluster_State}
     *     @type \Google\ApiCore\RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\ApiCore\OperationResponse
     *
     * @throws \Google\ApiCore\ApiException if the remote call fails
     * @experimental
     */
    public function updateCluster($name, $location, $serveNodes, $defaultStorageType, $optionalArgs = [])
    {
        $request = new Cluster();
        $request->setName($name);
        $request->setLocation($location);
        $request->setServeNodes($serveNodes);
        $request->setDefaultStorageType($defaultStorageType);
        if (isset($optionalArgs['state'])) {
            $request->setState($optionalArgs['state']);
        }

        $defaultCallSettings = $this->defaultCallSettings['updateCluster'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));
        $callable = ApiCallable::createApiCall(
            $this->bigtableInstanceAdminStub,
            'UpdateCluster',
            $mergedSettings,
            $this->descriptors['updateCluster']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Deletes a cluster from an instance.
     *
     * Sample code:
     * ```
     * try {
     *     $bigtableInstanceAdminClient = new BigtableInstanceAdminClient();
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
     *     @type \Google\ApiCore\RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @throws \Google\ApiCore\ApiException if the remote call fails
     * @experimental
     */
    public function deleteCluster($name, $optionalArgs = [])
    {
        $request = new DeleteClusterRequest();
        $request->setName($name);

        $defaultCallSettings = $this->defaultCallSettings['deleteCluster'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));
        $callable = ApiCallable::createApiCall(
            $this->bigtableInstanceAdminStub,
            'DeleteCluster',
            $mergedSettings,
            $this->descriptors['deleteCluster']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Initiates an orderly shutdown in which preexisting calls continue but new
     * calls are immediately cancelled.
     *
     * @experimental
     */
    public function close()
    {
        $this->bigtableInstanceAdminStub->close();
    }

    private function createCredentialsCallback()
    {
        return $this->grpcCredentialsHelper->createCallCredentialsCallback();
    }
}

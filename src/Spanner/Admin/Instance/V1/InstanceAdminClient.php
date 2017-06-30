<?php
/*
 * Copyright 2017, Google Inc. All rights reserved.
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
 * https://github.com/google/googleapis/blob/master/google/spanner/admin/instance/v1/spanner_instance_admin.proto
 * and updates to that file get reflected here through a refresh process.
 *
 * EXPERIMENTAL: this client library class has not yet been declared beta. This class may change
 * more frequently than those which have been declared beta or 1.0, including changes which break
 * backwards compatibility.
 *
 * @experimental
 */

namespace Google\Cloud\Spanner\Admin\Instance\V1;

use Google\GAX\AgentHeaderDescriptor;
use Google\GAX\ApiCallable;
use Google\GAX\CallSettings;
use Google\GAX\GrpcConstants;
use Google\GAX\GrpcCredentialsHelper;
use Google\GAX\LongRunning\OperationsClient;
use Google\GAX\OperationResponse;
use Google\GAX\PageStreamingDescriptor;
use Google\GAX\PathTemplate;
use Google\Iam\V1\GetIamPolicyRequest;
use Google\Iam\V1\Policy;
use Google\Iam\V1\SetIamPolicyRequest;
use Google\Iam\V1\TestIamPermissionsRequest;
use Google\Protobuf\FieldMask;
use Google\Spanner\Admin\Instance\V1\CreateInstanceMetadata;
use Google\Spanner\Admin\Instance\V1\CreateInstanceRequest;
use Google\Spanner\Admin\Instance\V1\DeleteInstanceRequest;
use Google\Spanner\Admin\Instance\V1\GetInstanceConfigRequest;
use Google\Spanner\Admin\Instance\V1\GetInstanceRequest;
use Google\Spanner\Admin\Instance\V1\Instance;
use Google\Spanner\Admin\Instance\V1\InstanceAdminGrpcClient;
use Google\Spanner\Admin\Instance\V1\ListInstanceConfigsRequest;
use Google\Spanner\Admin\Instance\V1\ListInstancesRequest;
use Google\Spanner\Admin\Instance\V1\UpdateInstanceMetadata;
use Google\Spanner\Admin\Instance\V1\UpdateInstanceRequest;

/**
 * Service Description: Cloud Spanner Instance Admin API.
 *
 * The Cloud Spanner Instance Admin API can be used to create, delete,
 * modify and list instances. Instances are dedicated Cloud Spanner serving
 * and storage resources to be used by Cloud Spanner databases.
 *
 * Each instance has a "configuration", which dictates where the
 * serving resources for the Cloud Spanner instance are located (e.g.,
 * US-central, Europe). Configurations are created by Google based on
 * resource availability.
 *
 * Cloud Spanner billing is based on the instances that exist and their
 * sizes. After an instance exists, there are no additional
 * per-database or per-operation charges for use of the instance
 * (though there may be additional network bandwidth charges).
 * Instances offer isolation: problems with databases in one instance
 * will not affect other instances. However, within an instance
 * databases can affect each other. For example, if one database in an
 * instance receives a lot of requests and consumes most of the
 * instance resources, fewer resources are available for other
 * databases in that instance, and their performance may suffer.
 *
 * EXPERIMENTAL: this client library class has not yet been declared beta. This class may change
 * more frequently than those which have been declared beta or 1.0, including changes which break
 * backwards compatibility.
 *
 * This class provides the ability to make remote calls to the backing service through method
 * calls that map to API methods. Sample code to get started:
 *
 * ```
 * try {
 *     $instanceAdminClient = new InstanceAdminClient();
 *     $formattedParent = InstanceAdminClient::formatProjectName("[PROJECT]");
 *     // Iterate through all elements
 *     $pagedResponse = $instanceAdminClient->listInstanceConfigs($formattedParent);
 *     foreach ($pagedResponse->iterateAllElements() as $element) {
 *         // doSomethingWith($element);
 *     }
 *
 *     // OR iterate over pages of elements, with the maximum page size set to 5
 *     $pagedResponse = $instanceAdminClient->listInstanceConfigs($formattedParent, ['pageSize' => 5]);
 *     foreach ($pagedResponse->iteratePages() as $page) {
 *         foreach ($page as $element) {
 *             // doSomethingWith($element);
 *         }
 *     }
 * } finally {
 *     $instanceAdminClient->close();
 * }
 * ```
 *
 * Many parameters require resource names to be formatted in a particular way. To assist
 * with these names, this class includes a format method for each type of name, and additionally
 * a parse method to extract the individual identifiers contained within names that are
 * returned.
 *
 * @experimental
 */
class InstanceAdminClient
{
    /**
     * The default address of the service.
     */
    const SERVICE_ADDRESS = 'spanner.googleapis.com';

    /**
     * The default port of the service.
     */
    const DEFAULT_SERVICE_PORT = 443;

    /**
     * The default timeout for non-retrying methods.
     */
    const DEFAULT_TIMEOUT_MILLIS = 30000;

    /**
     * The name of the code generator, to be included in the agent header.
     */
    const CODEGEN_NAME = 'gapic';

    /**
     * The code generator version, to be included in the agent header.
     */
    const CODEGEN_VERSION = '0.0.5';

    private static $projectNameTemplate;
    private static $instanceConfigNameTemplate;
    private static $instanceNameTemplate;

    private $grpcCredentialsHelper;
    private $instanceAdminStub;
    private $scopes;
    private $defaultCallSettings;
    private $descriptors;
    private $operationsClient;

    /**
     * Formats a string containing the fully-qualified path to represent
     * a project resource.
     *
     * @param string $project
     *
     * @return string The formatted project resource.
     * @experimental
     */
    public static function formatProjectName($project)
    {
        return self::getProjectNameTemplate()->render([
            'project' => $project,
        ]);
    }

    /**
     * Formats a string containing the fully-qualified path to represent
     * a instance_config resource.
     *
     * @param string $project
     * @param string $instanceConfig
     *
     * @return string The formatted instance_config resource.
     * @experimental
     */
    public static function formatInstanceConfigName($project, $instanceConfig)
    {
        return self::getInstanceConfigNameTemplate()->render([
            'project' => $project,
            'instance_config' => $instanceConfig,
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
    public static function formatInstanceName($project, $instance)
    {
        return self::getInstanceNameTemplate()->render([
            'project' => $project,
            'instance' => $instance,
        ]);
    }

    /**
     * Parses the project from the given fully-qualified path which
     * represents a project resource.
     *
     * @param string $projectName The fully-qualified project resource.
     *
     * @return string The extracted project value.
     * @experimental
     */
    public static function parseProjectFromProjectName($projectName)
    {
        return self::getProjectNameTemplate()->match($projectName)['project'];
    }

    /**
     * Parses the project from the given fully-qualified path which
     * represents a instance_config resource.
     *
     * @param string $instanceConfigName The fully-qualified instance_config resource.
     *
     * @return string The extracted project value.
     * @experimental
     */
    public static function parseProjectFromInstanceConfigName($instanceConfigName)
    {
        return self::getInstanceConfigNameTemplate()->match($instanceConfigName)['project'];
    }

    /**
     * Parses the instance_config from the given fully-qualified path which
     * represents a instance_config resource.
     *
     * @param string $instanceConfigName The fully-qualified instance_config resource.
     *
     * @return string The extracted instance_config value.
     * @experimental
     */
    public static function parseInstanceConfigFromInstanceConfigName($instanceConfigName)
    {
        return self::getInstanceConfigNameTemplate()->match($instanceConfigName)['instance_config'];
    }

    /**
     * Parses the project from the given fully-qualified path which
     * represents a instance resource.
     *
     * @param string $instanceName The fully-qualified instance resource.
     *
     * @return string The extracted project value.
     * @experimental
     */
    public static function parseProjectFromInstanceName($instanceName)
    {
        return self::getInstanceNameTemplate()->match($instanceName)['project'];
    }

    /**
     * Parses the instance from the given fully-qualified path which
     * represents a instance resource.
     *
     * @param string $instanceName The fully-qualified instance resource.
     *
     * @return string The extracted instance value.
     * @experimental
     */
    public static function parseInstanceFromInstanceName($instanceName)
    {
        return self::getInstanceNameTemplate()->match($instanceName)['instance'];
    }

    private static function getProjectNameTemplate()
    {
        if (self::$projectNameTemplate == null) {
            self::$projectNameTemplate = new PathTemplate('projects/{project}');
        }

        return self::$projectNameTemplate;
    }

    private static function getInstanceConfigNameTemplate()
    {
        if (self::$instanceConfigNameTemplate == null) {
            self::$instanceConfigNameTemplate = new PathTemplate('projects/{project}/instanceConfigs/{instance_config}');
        }

        return self::$instanceConfigNameTemplate;
    }

    private static function getInstanceNameTemplate()
    {
        if (self::$instanceNameTemplate == null) {
            self::$instanceNameTemplate = new PathTemplate('projects/{project}/instances/{instance}');
        }

        return self::$instanceNameTemplate;
    }

    private static function getPageStreamingDescriptors()
    {
        $listInstanceConfigsPageStreamingDescriptor =
                new PageStreamingDescriptor([
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getInstanceConfigs',
                ]);
        $listInstancesPageStreamingDescriptor =
                new PageStreamingDescriptor([
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getInstances',
                ]);

        $pageStreamingDescriptors = [
            'listInstanceConfigs' => $listInstanceConfigsPageStreamingDescriptor,
            'listInstances' => $listInstancesPageStreamingDescriptor,
        ];

        return $pageStreamingDescriptors;
    }

    private static function getLongRunningDescriptors()
    {
        return [
            'createInstance' => [
                'operationReturnType' => '\Google\Spanner\Admin\Instance\V1\Instance',
                'metadataReturnType' => '\Google\Spanner\Admin\Instance\V1\CreateInstanceMetadata',
            ],
            'updateInstance' => [
                'operationReturnType' => '\Google\Spanner\Admin\Instance\V1\Instance',
                'metadataReturnType' => '\Google\Spanner\Admin\Instance\V1\UpdateInstanceMetadata',
            ],
        ];
    }

    private static function getGapicVersion()
    {
        if (file_exists(__DIR__.'/../VERSION')) {
            return trim(file_get_contents(__DIR__.'/../VERSION'));
        } elseif (class_exists('\Google\Cloud\ServiceBuilder')) {
            return \Google\Cloud\ServiceBuilder::VERSION;
        } else {
            return;
        }
    }

    /**
     * Return an OperationsClient object with the same endpoint as $this.
     *
     * @return \Google\GAX\LongRunning\OperationsClient
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
     * @return \Google\GAX\OperationResponse
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

    // TODO(garrettjones): add channel (when supported in gRPC)
    /**
     * Constructor.
     *
     * @param array $options {
     *                       Optional. Options for configuring the service API wrapper.
     *
     *     @type string $serviceAddress The domain name of the API remote host.
     *                                  Default 'spanner.googleapis.com'.
     *     @type mixed $port The port on which to connect to the remote host. Default 443.
     *     @type \Grpc\ChannelCredentials $sslCreds
     *           A `ChannelCredentials` for use with an SSL-enabled channel.
     *           Default: a credentials object returned from
     *           \Grpc\ChannelCredentials::createSsl()
     *     @type array $scopes A string array of scopes to use when acquiring credentials.
     *                         Default the scopes for the Cloud Spanner Instance Admin API.
     *     @type array $retryingOverride
     *           An associative array of string => RetryOptions, where the keys
     *           are method names (e.g. 'createFoo'), that overrides default retrying
     *           settings. A value of null indicates that the method in question should
     *           not retry.
     *     @type int $timeoutMillis The timeout in milliseconds to use for calls
     *                              that don't use retries. For calls that use retries,
     *                              set the timeout in RetryOptions.
     *                              Default: 30000 (30 seconds)
     *     @type \Google\Auth\CredentialsLoader $credentialsLoader
     *                              A CredentialsLoader object created using the
     *                              Google\Auth library.
     * }
     * @experimental
     */
    public function __construct($options = [])
    {
        $defaultOptions = [
            'serviceAddress' => self::SERVICE_ADDRESS,
            'port' => self::DEFAULT_SERVICE_PORT,
            'scopes' => [
                'https://www.googleapis.com/auth/cloud-platform',
                'https://www.googleapis.com/auth/spanner.admin',
            ],
            'retryingOverride' => null,
            'timeoutMillis' => self::DEFAULT_TIMEOUT_MILLIS,
            'libName' => null,
            'libVersion' => null,
        ];
        $options = array_merge($defaultOptions, $options);

        if (array_key_exists('operationsClient', $options)) {
            $this->operationsClient = $options['operationsClient'];
        } else {
            $operationsClientOptions = $options;
            unset($operationsClientOptions['timeoutMillis']);
            unset($operationsClientOptions['retryingOverride']);
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
            'listInstanceConfigs' => $defaultDescriptors,
            'getInstanceConfig' => $defaultDescriptors,
            'listInstances' => $defaultDescriptors,
            'getInstance' => $defaultDescriptors,
            'createInstance' => $defaultDescriptors,
            'updateInstance' => $defaultDescriptors,
            'deleteInstance' => $defaultDescriptors,
            'setIamPolicy' => $defaultDescriptors,
            'getIamPolicy' => $defaultDescriptors,
            'testIamPermissions' => $defaultDescriptors,
        ];
        $pageStreamingDescriptors = self::getPageStreamingDescriptors();
        foreach ($pageStreamingDescriptors as $method => $pageStreamingDescriptor) {
            $this->descriptors[$method]['pageStreamingDescriptor'] = $pageStreamingDescriptor;
        }
        $longRunningDescriptors = self::getLongRunningDescriptors();
        foreach ($longRunningDescriptors as $method => $longRunningDescriptor) {
            $this->descriptors[$method]['longRunningDescriptor'] = $longRunningDescriptor + ['operationsClient' => $this->operationsClient];
        }

        $clientConfigJsonString = file_get_contents(__DIR__.'/resources/instance_admin_client_config.json');
        $clientConfig = json_decode($clientConfigJsonString, true);
        $this->defaultCallSettings =
                CallSettings::load(
                    'google.spanner.admin.instance.v1.InstanceAdmin',
                    $clientConfig,
                    $options['retryingOverride'],
                    GrpcConstants::getStatusCodeNames(),
                    $options['timeoutMillis']
                );

        $this->scopes = $options['scopes'];

        $createStubOptions = [];
        if (array_key_exists('sslCreds', $options)) {
            $createStubOptions['sslCreds'] = $options['sslCreds'];
        }
        $grpcCredentialsHelperOptions = array_diff_key($options, $defaultOptions);
        $this->grpcCredentialsHelper = new GrpcCredentialsHelper($this->scopes, $grpcCredentialsHelperOptions);

        $createInstanceAdminStubFunction = function ($hostname, $opts) {
            return new InstanceAdminGrpcClient($hostname, $opts);
        };
        if (array_key_exists('createInstanceAdminStubFunction', $options)) {
            $createInstanceAdminStubFunction = $options['createInstanceAdminStubFunction'];
        }
        $this->instanceAdminStub = $this->grpcCredentialsHelper->createStub(
            $createInstanceAdminStubFunction,
            $options['serviceAddress'],
            $options['port'],
            $createStubOptions
        );
    }

    /**
     * Lists the supported instance configurations for a given project.
     *
     * Sample code:
     * ```
     * try {
     *     $instanceAdminClient = new InstanceAdminClient();
     *     $formattedParent = InstanceAdminClient::formatProjectName("[PROJECT]");
     *     // Iterate through all elements
     *     $pagedResponse = $instanceAdminClient->listInstanceConfigs($formattedParent);
     *     foreach ($pagedResponse->iterateAllElements() as $element) {
     *         // doSomethingWith($element);
     *     }
     *
     *     // OR iterate over pages of elements, with the maximum page size set to 5
     *     $pagedResponse = $instanceAdminClient->listInstanceConfigs($formattedParent, ['pageSize' => 5]);
     *     foreach ($pagedResponse->iteratePages() as $page) {
     *         foreach ($page as $element) {
     *             // doSomethingWith($element);
     *         }
     *     }
     * } finally {
     *     $instanceAdminClient->close();
     * }
     * ```
     *
     * @param string $parent       Required. The name of the project for which a list of supported instance
     *                             configurations is requested. Values are of the form
     *                             `projects/<project>`.
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
     *     @type \Google\GAX\RetrySettings $retrySettings
     *          Retry settings to use for this call. If present, then
     *          $timeoutMillis is ignored.
     *     @type int $timeoutMillis
     *          Timeout to use for this call. Only used if $retrySettings
     *          is not set.
     * }
     *
     * @return \Google\GAX\PagedListResponse
     *
     * @throws \Google\GAX\ApiException if the remote call fails
     * @experimental
     */
    public function listInstanceConfigs($parent, $optionalArgs = [])
    {
        $request = new ListInstanceConfigsRequest();
        $request->setParent($parent);
        if (isset($optionalArgs['pageSize'])) {
            $request->setPageSize($optionalArgs['pageSize']);
        }
        if (isset($optionalArgs['pageToken'])) {
            $request->setPageToken($optionalArgs['pageToken']);
        }

        $mergedSettings = $this->defaultCallSettings['listInstanceConfigs']->merge(
            new CallSettings($optionalArgs)
        );
        $callable = ApiCallable::createApiCall(
            $this->instanceAdminStub,
            'ListInstanceConfigs',
            $mergedSettings,
            $this->descriptors['listInstanceConfigs']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Gets information about a particular instance configuration.
     *
     * Sample code:
     * ```
     * try {
     *     $instanceAdminClient = new InstanceAdminClient();
     *     $formattedName = InstanceAdminClient::formatInstanceConfigName("[PROJECT]", "[INSTANCE_CONFIG]");
     *     $response = $instanceAdminClient->getInstanceConfig($formattedName);
     * } finally {
     *     $instanceAdminClient->close();
     * }
     * ```
     *
     * @param string $name         Required. The name of the requested instance configuration. Values are of
     *                             the form `projects/<project>/instanceConfigs/<config>`.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type \Google\GAX\RetrySettings $retrySettings
     *          Retry settings to use for this call. If present, then
     *          $timeoutMillis is ignored.
     *     @type int $timeoutMillis
     *          Timeout to use for this call. Only used if $retrySettings
     *          is not set.
     * }
     *
     * @return \Google\Spanner\Admin\Instance\V1\InstanceConfig
     *
     * @throws \Google\GAX\ApiException if the remote call fails
     * @experimental
     */
    public function getInstanceConfig($name, $optionalArgs = [])
    {
        $request = new GetInstanceConfigRequest();
        $request->setName($name);

        $mergedSettings = $this->defaultCallSettings['getInstanceConfig']->merge(
            new CallSettings($optionalArgs)
        );
        $callable = ApiCallable::createApiCall(
            $this->instanceAdminStub,
            'GetInstanceConfig',
            $mergedSettings,
            $this->descriptors['getInstanceConfig']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Lists all instances in the given project.
     *
     * Sample code:
     * ```
     * try {
     *     $instanceAdminClient = new InstanceAdminClient();
     *     $formattedParent = InstanceAdminClient::formatProjectName("[PROJECT]");
     *     // Iterate through all elements
     *     $pagedResponse = $instanceAdminClient->listInstances($formattedParent);
     *     foreach ($pagedResponse->iterateAllElements() as $element) {
     *         // doSomethingWith($element);
     *     }
     *
     *     // OR iterate over pages of elements, with the maximum page size set to 5
     *     $pagedResponse = $instanceAdminClient->listInstances($formattedParent, ['pageSize' => 5]);
     *     foreach ($pagedResponse->iteratePages() as $page) {
     *         foreach ($page as $element) {
     *             // doSomethingWith($element);
     *         }
     *     }
     * } finally {
     *     $instanceAdminClient->close();
     * }
     * ```
     *
     * @param string $parent       Required. The name of the project for which a list of instances is
     *                             requested. Values are of the form `projects/<project>`.
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
     *     @type string $filter
     *          An expression for filtering the results of the request. Filter rules are
     *          case insensitive. The fields eligible for filtering are:
     *
     *            * name
     *            * display_name
     *            * labels.key where key is the name of a label
     *
     *          Some examples of using filters are:
     *
     *            * name:* --> The instance has a name.
     *            * name:Howl --> The instance's name contains the string "howl".
     *            * name:HOWL --> Equivalent to above.
     *            * NAME:howl --> Equivalent to above.
     *            * labels.env:* --> The instance has the label "env".
     *            * labels.env:dev --> The instance has the label "env" and the value of
     *                                 the label contains the string "dev".
     *            * name:howl labels.env:dev --> The instance's name contains "howl" and
     *                                           it has the label "env" with its value
     *                                           containing "dev".
     *     @type \Google\GAX\RetrySettings $retrySettings
     *          Retry settings to use for this call. If present, then
     *          $timeoutMillis is ignored.
     *     @type int $timeoutMillis
     *          Timeout to use for this call. Only used if $retrySettings
     *          is not set.
     * }
     *
     * @return \Google\GAX\PagedListResponse
     *
     * @throws \Google\GAX\ApiException if the remote call fails
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
        if (isset($optionalArgs['filter'])) {
            $request->setFilter($optionalArgs['filter']);
        }

        $mergedSettings = $this->defaultCallSettings['listInstances']->merge(
            new CallSettings($optionalArgs)
        );
        $callable = ApiCallable::createApiCall(
            $this->instanceAdminStub,
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
     * Gets information about a particular instance.
     *
     * Sample code:
     * ```
     * try {
     *     $instanceAdminClient = new InstanceAdminClient();
     *     $formattedName = InstanceAdminClient::formatInstanceName("[PROJECT]", "[INSTANCE]");
     *     $response = $instanceAdminClient->getInstance($formattedName);
     * } finally {
     *     $instanceAdminClient->close();
     * }
     * ```
     *
     * @param string $name         Required. The name of the requested instance. Values are of the form
     *                             `projects/<project>/instances/<instance>`.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type \Google\GAX\RetrySettings $retrySettings
     *          Retry settings to use for this call. If present, then
     *          $timeoutMillis is ignored.
     *     @type int $timeoutMillis
     *          Timeout to use for this call. Only used if $retrySettings
     *          is not set.
     * }
     *
     * @return \Google\Spanner\Admin\Instance\V1\Instance
     *
     * @throws \Google\GAX\ApiException if the remote call fails
     * @experimental
     */
    public function getInstance($name, $optionalArgs = [])
    {
        $request = new GetInstanceRequest();
        $request->setName($name);

        $mergedSettings = $this->defaultCallSettings['getInstance']->merge(
            new CallSettings($optionalArgs)
        );
        $callable = ApiCallable::createApiCall(
            $this->instanceAdminStub,
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
     * Creates an instance and begins preparing it to begin serving. The
     * returned [long-running operation][google.longrunning.Operation]
     * can be used to track the progress of preparing the new
     * instance. The instance name is assigned by the caller. If the
     * named instance already exists, `CreateInstance` returns
     * `ALREADY_EXISTS`.
     *
     * Immediately upon completion of this request:
     *
     *   * The instance is readable via the API, with all requested attributes
     *     but no allocated resources. Its state is `CREATING`.
     *
     * Until completion of the returned operation:
     *
     *   * Cancelling the operation renders the instance immediately unreadable
     *     via the API.
     *   * The instance can be deleted.
     *   * All other attempts to modify the instance are rejected.
     *
     * Upon completion of the returned operation:
     *
     *   * Billing for all successfully-allocated resources begins (some types
     *     may have lower than the requested levels).
     *   * Databases can be created in the instance.
     *   * The instance's allocated resource levels are readable via the API.
     *   * The instance's state becomes `READY`.
     *
     * The returned [long-running operation][google.longrunning.Operation] will
     * have a name of the format `<instance_name>/operations/<operation_id>` and
     * can be used to track creation of the instance.  The
     * [metadata][google.longrunning.Operation.metadata] field type is
     * [CreateInstanceMetadata][google.spanner.admin.instance.v1.CreateInstanceMetadata].
     * The [response][google.longrunning.Operation.response] field type is
     * [Instance][google.spanner.admin.instance.v1.Instance], if successful.
     *
     * Sample code:
     * ```
     * try {
     *     $instanceAdminClient = new InstanceAdminClient();
     *     $formattedParent = InstanceAdminClient::formatProjectName("[PROJECT]");
     *     $instanceId = "";
     *     $instance = new Instance();
     *     $operationResponse = $instanceAdminClient->createInstance($formattedParent, $instanceId, $instance);
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
     *     $operationResponse = $instanceAdminClient->createInstance($formattedParent, $instanceId, $instance);
     *     $operationName = $operationResponse->getName();
     *     // ... do other work
     *     $newOperationResponse = $instanceAdminClient->resumeOperation($operationName, 'createInstance');
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
     *     $instanceAdminClient->close();
     * }
     * ```
     *
     * @param string   $parent       Required. The name of the project in which to create the instance. Values
     *                               are of the form `projects/<project>`.
     * @param string   $instanceId   Required. The ID of the instance to create.  Valid identifiers are of the
     *                               form `[a-z][-a-z0-9]*[a-z0-9]` and must be between 6 and 30 characters in
     *                               length.
     * @param Instance $instance     Required. The instance to create.  The name may be omitted, but if
     *                               specified must be `<parent>/instances/<instance_id>`.
     * @param array    $optionalArgs {
     *                               Optional.
     *
     *     @type \Google\GAX\RetrySettings $retrySettings
     *          Retry settings to use for this call. If present, then
     *          $timeoutMillis is ignored.
     *     @type int $timeoutMillis
     *          Timeout to use for this call. Only used if $retrySettings
     *          is not set.
     * }
     *
     * @return \Google\Longrunning\Operation
     *
     * @throws \Google\GAX\ApiException if the remote call fails
     * @experimental
     */
    public function createInstance($parent, $instanceId, $instance, $optionalArgs = [])
    {
        $request = new CreateInstanceRequest();
        $request->setParent($parent);
        $request->setInstanceId($instanceId);
        $request->setInstance($instance);

        $mergedSettings = $this->defaultCallSettings['createInstance']->merge(
            new CallSettings($optionalArgs)
        );
        $callable = ApiCallable::createApiCall(
            $this->instanceAdminStub,
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
     * Updates an instance, and begins allocating or releasing resources
     * as requested. The returned [long-running
     * operation][google.longrunning.Operation] can be used to track the
     * progress of updating the instance. If the named instance does not
     * exist, returns `NOT_FOUND`.
     *
     * Immediately upon completion of this request:
     *
     *   * For resource types for which a decrease in the instance's allocation
     *     has been requested, billing is based on the newly-requested level.
     *
     * Until completion of the returned operation:
     *
     *   * Cancelling the operation sets its metadata's
     *     [cancel_time][google.spanner.admin.instance.v1.UpdateInstanceMetadata.cancel_time], and begins
     *     restoring resources to their pre-request values. The operation
     *     is guaranteed to succeed at undoing all resource changes,
     *     after which point it terminates with a `CANCELLED` status.
     *   * All other attempts to modify the instance are rejected.
     *   * Reading the instance via the API continues to give the pre-request
     *     resource levels.
     *
     * Upon completion of the returned operation:
     *
     *   * Billing begins for all successfully-allocated resources (some types
     *     may have lower than the requested levels).
     *   * All newly-reserved resources are available for serving the instance's
     *     tables.
     *   * The instance's new resource levels are readable via the API.
     *
     * The returned [long-running operation][google.longrunning.Operation] will
     * have a name of the format `<instance_name>/operations/<operation_id>` and
     * can be used to track the instance modification.  The
     * [metadata][google.longrunning.Operation.metadata] field type is
     * [UpdateInstanceMetadata][google.spanner.admin.instance.v1.UpdateInstanceMetadata].
     * The [response][google.longrunning.Operation.response] field type is
     * [Instance][google.spanner.admin.instance.v1.Instance], if successful.
     *
     * Authorization requires `spanner.instances.update` permission on
     * resource [name][google.spanner.admin.instance.v1.Instance.name].
     *
     * Sample code:
     * ```
     * try {
     *     $instanceAdminClient = new InstanceAdminClient();
     *     $instance = new Instance();
     *     $fieldMask = new FieldMask();
     *     $operationResponse = $instanceAdminClient->updateInstance($instance, $fieldMask);
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
     *     $operationResponse = $instanceAdminClient->updateInstance($instance, $fieldMask);
     *     $operationName = $operationResponse->getName();
     *     // ... do other work
     *     $newOperationResponse = $instanceAdminClient->resumeOperation($operationName, 'updateInstance');
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
     *     $instanceAdminClient->close();
     * }
     * ```
     *
     * @param Instance  $instance     Required. The instance to update, which must always include the instance
     *                                name.  Otherwise, only fields mentioned in [][google.spanner.admin.instance.v1.UpdateInstanceRequest.field_mask] need be included.
     * @param FieldMask $fieldMask    Required. A mask specifying which fields in [][google.spanner.admin.instance.v1.UpdateInstanceRequest.instance] should be updated.
     *                                The field mask must always be specified; this prevents any future fields in
     *                                [][google.spanner.admin.instance.v1.Instance] from being erased accidentally by clients that do not know
     *                                about them.
     * @param array     $optionalArgs {
     *                                Optional.
     *
     *     @type \Google\GAX\RetrySettings $retrySettings
     *          Retry settings to use for this call. If present, then
     *          $timeoutMillis is ignored.
     *     @type int $timeoutMillis
     *          Timeout to use for this call. Only used if $retrySettings
     *          is not set.
     * }
     *
     * @return \Google\Longrunning\Operation
     *
     * @throws \Google\GAX\ApiException if the remote call fails
     * @experimental
     */
    public function updateInstance($instance, $fieldMask, $optionalArgs = [])
    {
        $request = new UpdateInstanceRequest();
        $request->setInstance($instance);
        $request->setFieldMask($fieldMask);

        $mergedSettings = $this->defaultCallSettings['updateInstance']->merge(
            new CallSettings($optionalArgs)
        );
        $callable = ApiCallable::createApiCall(
            $this->instanceAdminStub,
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
     * Deletes an instance.
     *
     * Immediately upon completion of the request:
     *
     *   * Billing ceases for all of the instance's reserved resources.
     *
     * Soon afterward:
     *
     *   * The instance and *all of its databases* immediately and
     *     irrevocably disappear from the API. All data in the databases
     *     is permanently deleted.
     *
     * Sample code:
     * ```
     * try {
     *     $instanceAdminClient = new InstanceAdminClient();
     *     $formattedName = InstanceAdminClient::formatInstanceName("[PROJECT]", "[INSTANCE]");
     *     $instanceAdminClient->deleteInstance($formattedName);
     * } finally {
     *     $instanceAdminClient->close();
     * }
     * ```
     *
     * @param string $name         Required. The name of the instance to be deleted. Values are of the form
     *                             `projects/<project>/instances/<instance>`
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type \Google\GAX\RetrySettings $retrySettings
     *          Retry settings to use for this call. If present, then
     *          $timeoutMillis is ignored.
     *     @type int $timeoutMillis
     *          Timeout to use for this call. Only used if $retrySettings
     *          is not set.
     * }
     *
     * @throws \Google\GAX\ApiException if the remote call fails
     * @experimental
     */
    public function deleteInstance($name, $optionalArgs = [])
    {
        $request = new DeleteInstanceRequest();
        $request->setName($name);

        $mergedSettings = $this->defaultCallSettings['deleteInstance']->merge(
            new CallSettings($optionalArgs)
        );
        $callable = ApiCallable::createApiCall(
            $this->instanceAdminStub,
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
     * Sets the access control policy on an instance resource. Replaces any
     * existing policy.
     *
     * Authorization requires `spanner.instances.setIamPolicy` on
     * [resource][google.iam.v1.SetIamPolicyRequest.resource].
     *
     * Sample code:
     * ```
     * try {
     *     $instanceAdminClient = new InstanceAdminClient();
     *     $formattedResource = InstanceAdminClient::formatInstanceName("[PROJECT]", "[INSTANCE]");
     *     $policy = new Policy();
     *     $response = $instanceAdminClient->setIamPolicy($formattedResource, $policy);
     * } finally {
     *     $instanceAdminClient->close();
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
     *     @type \Google\GAX\RetrySettings $retrySettings
     *          Retry settings to use for this call. If present, then
     *          $timeoutMillis is ignored.
     *     @type int $timeoutMillis
     *          Timeout to use for this call. Only used if $retrySettings
     *          is not set.
     * }
     *
     * @return \Google\Iam\V1\Policy
     *
     * @throws \Google\GAX\ApiException if the remote call fails
     * @experimental
     */
    public function setIamPolicy($resource, $policy, $optionalArgs = [])
    {
        $request = new SetIamPolicyRequest();
        $request->setResource($resource);
        $request->setPolicy($policy);

        $mergedSettings = $this->defaultCallSettings['setIamPolicy']->merge(
            new CallSettings($optionalArgs)
        );
        $callable = ApiCallable::createApiCall(
            $this->instanceAdminStub,
            'SetIamPolicy',
            $mergedSettings,
            $this->descriptors['setIamPolicy']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Gets the access control policy for an instance resource. Returns an empty
     * policy if an instance exists but does not have a policy set.
     *
     * Authorization requires `spanner.instances.getIamPolicy` on
     * [resource][google.iam.v1.GetIamPolicyRequest.resource].
     *
     * Sample code:
     * ```
     * try {
     *     $instanceAdminClient = new InstanceAdminClient();
     *     $formattedResource = InstanceAdminClient::formatInstanceName("[PROJECT]", "[INSTANCE]");
     *     $response = $instanceAdminClient->getIamPolicy($formattedResource);
     * } finally {
     *     $instanceAdminClient->close();
     * }
     * ```
     *
     * @param string $resource     REQUIRED: The resource for which the policy is being requested.
     *                             `resource` is usually specified as a path. For example, a Project
     *                             resource is specified as `projects/{project}`.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type \Google\GAX\RetrySettings $retrySettings
     *          Retry settings to use for this call. If present, then
     *          $timeoutMillis is ignored.
     *     @type int $timeoutMillis
     *          Timeout to use for this call. Only used if $retrySettings
     *          is not set.
     * }
     *
     * @return \Google\Iam\V1\Policy
     *
     * @throws \Google\GAX\ApiException if the remote call fails
     * @experimental
     */
    public function getIamPolicy($resource, $optionalArgs = [])
    {
        $request = new GetIamPolicyRequest();
        $request->setResource($resource);

        $mergedSettings = $this->defaultCallSettings['getIamPolicy']->merge(
            new CallSettings($optionalArgs)
        );
        $callable = ApiCallable::createApiCall(
            $this->instanceAdminStub,
            'GetIamPolicy',
            $mergedSettings,
            $this->descriptors['getIamPolicy']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Returns permissions that the caller has on the specified instance resource.
     *
     * Attempting this RPC on a non-existent Cloud Spanner instance resource will
     * result in a NOT_FOUND error if the user has `spanner.instances.list`
     * permission on the containing Google Cloud Project. Otherwise returns an
     * empty set of permissions.
     *
     * Sample code:
     * ```
     * try {
     *     $instanceAdminClient = new InstanceAdminClient();
     *     $formattedResource = InstanceAdminClient::formatInstanceName("[PROJECT]", "[INSTANCE]");
     *     $permissions = [];
     *     $response = $instanceAdminClient->testIamPermissions($formattedResource, $permissions);
     * } finally {
     *     $instanceAdminClient->close();
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
     *     @type \Google\GAX\RetrySettings $retrySettings
     *          Retry settings to use for this call. If present, then
     *          $timeoutMillis is ignored.
     *     @type int $timeoutMillis
     *          Timeout to use for this call. Only used if $retrySettings
     *          is not set.
     * }
     *
     * @return \Google\Iam\V1\TestIamPermissionsResponse
     *
     * @throws \Google\GAX\ApiException if the remote call fails
     * @experimental
     */
    public function testIamPermissions($resource, $permissions, $optionalArgs = [])
    {
        $request = new TestIamPermissionsRequest();
        $request->setResource($resource);
        $request->setPermissions($permissions);

        $mergedSettings = $this->defaultCallSettings['testIamPermissions']->merge(
            new CallSettings($optionalArgs)
        );
        $callable = ApiCallable::createApiCall(
            $this->instanceAdminStub,
            'TestIamPermissions',
            $mergedSettings,
            $this->descriptors['testIamPermissions']
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
        $this->instanceAdminStub->close();
    }

    private function createCredentialsCallback()
    {
        return $this->grpcCredentialsHelper->createCallCredentialsCallback();
    }
}

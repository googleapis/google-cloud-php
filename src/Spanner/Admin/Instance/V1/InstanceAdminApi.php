<?php
/*
 * Copyright 2016 Google Inc. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may not use this file except
 * in compliance with the License. You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software distributed under the License
 * is distributed on an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express
 * or implied. See the License for the specific language governing permissions and limitations under
 * the License.
 */

/*
 * GENERATED CODE WARNING
 * This file was generated from the file
 * https://github.com/google/googleapis/blob/master/google/spanner/admin/instance/v1/spanner_instance_admin.proto
 * and updates to that file get reflected here through a refresh process.
 */

namespace Google\Cloud\Spanner\Admin\Instance\V1;

use Google\GAX\AgentHeaderDescriptor;
use Google\GAX\ApiCallable;
use Google\GAX\CallSettings;
use Google\GAX\GrpcConstants;
use Google\GAX\GrpcCredentialsHelper;
use Google\GAX\PageStreamingDescriptor;
use Google\GAX\PathTemplate;
use google\iam\v1\GetIamPolicyRequest;
use google\iam\v1\Policy;
use google\iam\v1\SetIamPolicyRequest;
use google\iam\v1\TestIamPermissionsRequest;
use google\spanner\admin\instance\v1\DeleteInstanceRequest;
use google\spanner\admin\instance\v1\GetInstanceConfigRequest;
use google\spanner\admin\instance\v1\GetInstanceRequest;
use google\spanner\admin\instance\v1\Instance;
use google\spanner\admin\instance\v1\InstanceAdminClient;
use google\spanner\admin\instance\v1\Instance\LabelsEntry;
use google\spanner\admin\instance\v1\Instance\State;
use google\spanner\admin\instance\v1\ListInstanceConfigsRequest;
use google\spanner\admin\instance\v1\ListInstancesRequest;

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
 * This class provides the ability to make remote calls to the backing service through method
 * calls that map to API methods. Sample code to get started:
 *
 * ```
 * try {
 *     $instanceAdminApi = new InstanceAdminApi();
 *     $formattedName = InstanceAdminApi::formatProjectName("[PROJECT]");
 *     foreach ($instanceAdminApi->listInstanceConfigs($formattedName) as $element) {
 *         // doThingsWith(element);
 *     }
 * } finally {
 *     if (isset($instanceAdminApi)) {
 *         $instanceAdminApi->close();
 *     }
 * }
 * ```
 *
 * Many parameters require resource names to be formatted in a particular way. To assist
 * with these names, this class includes a format method for each type of name, and additionally
 * a parse method to extract the individual identifiers contained within names that are
 * returned.
 */
class InstanceAdminApi
{
    /**
     * The default address of the service.
     */
    const SERVICE_ADDRESS = 'wrenchworks.googleapis.com';

    /**
     * The default port of the service.
     */
    const DEFAULT_SERVICE_PORT = 443;

    /**
     * The default timeout for non-retrying methods.
     */
    const DEFAULT_TIMEOUT_MILLIS = 30000;

    const _GAX_VERSION = '0.1.0';
    const _CODEGEN_NAME = 'GAPIC';
    const _CODEGEN_VERSION = '0.0.0';

    private static $projectNameTemplate;
    private static $instanceConfigNameTemplate;
    private static $instanceNameTemplate;

    private $grpcCredentialsHelper;
    private $instanceAdminStub;
    private $scopes;
    private $defaultCallSettings;
    private $descriptors;

    /**
     * Formats a string containing the fully-qualified path to represent
     * a project resource.
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
     */
    public static function parseProjectFromProjectName($projectName)
    {
        return self::getProjectNameTemplate()->match($projectName)['project'];
    }

    /**
     * Parses the project from the given fully-qualified path which
     * represents a instanceConfig resource.
     */
    public static function parseProjectFromInstanceConfigName($instanceConfigName)
    {
        return self::getInstanceConfigNameTemplate()->match($instanceConfigName)['project'];
    }

    /**
     * Parses the instance_config from the given fully-qualified path which
     * represents a instanceConfig resource.
     */
    public static function parseInstanceConfigFromInstanceConfigName($instanceConfigName)
    {
        return self::getInstanceConfigNameTemplate()->match($instanceConfigName)['instance_config'];
    }

    /**
     * Parses the project from the given fully-qualified path which
     * represents a instance resource.
     */
    public static function parseProjectFromInstanceName($instanceName)
    {
        return self::getInstanceNameTemplate()->match($instanceName)['project'];
    }

    /**
     * Parses the instance from the given fully-qualified path which
     * represents a instance resource.
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
                    'requestPageTokenField' => 'page_token',
                    'requestPageSizeField' => 'page_size',
                    'responsePageTokenField' => 'next_page_token',
                    'resourceField' => 'instance_configs',
                ]);
        $listInstancesPageStreamingDescriptor =
                new PageStreamingDescriptor([
                    'requestPageTokenField' => 'page_token',
                    'requestPageSizeField' => 'page_size',
                    'responsePageTokenField' => 'next_page_token',
                    'resourceField' => 'instances',
                ]);

        $pageStreamingDescriptors = [
            'listInstanceConfigs' => $listInstanceConfigsPageStreamingDescriptor,
            'listInstances' => $listInstancesPageStreamingDescriptor,
        ];

        return $pageStreamingDescriptors;
    }

    // TODO(garrettjones): add channel (when supported in gRPC)
    /**
     * Constructor.
     *
     * @param array $options {
     *                       Optional. Options for configuring the service API wrapper.
     *
     *     @type string $serviceAddress The domain name of the API remote host.
     *                                  Default 'wrenchworks.googleapis.com'.
     *     @type mixed $port The port on which to connect to the remote host. Default 443.
     *     @type Grpc\ChannelCredentials $sslCreds
     *           A `ChannelCredentials` for use with an SSL-enabled channel.
     *           Default: a credentials object returned from
     *           Grpc\ChannelCredentials::createSsl()
     *     @type array $scopes A string array of scopes to use when acquiring credentials.
     *                         Default the scopes for the Google Cloud Spanner Admin Instance API.
     *     @type array $retryingOverride
     *           An associative array of string => RetryOptions, where the keys
     *           are method names (e.g. 'createFoo'), that overrides default retrying
     *           settings. A value of null indicates that the method in question should
     *           not retry.
     *     @type int $timeoutMillis The timeout in milliseconds to use for calls
     *                              that don't use retries. For calls that use retries,
     *                              set the timeout in RetryOptions.
     *                              Default: 30000 (30 seconds)
     *     @type string $appName The codename of the calling service. Default 'gax'.
     *     @type string $appVersion The version of the calling service.
     *                              Default: the current version of GAX.
     *     @type Google\Auth\CredentialsLoader $credentialsLoader
     *                              A CredentialsLoader object created using the
     *                              Google\Auth library.
     * }
     */
    public function __construct($options = [])
    {
        $defaultScopes = [
            'https://www.googleapis.com/auth/cloud-platform',
            'https://www.googleapis.com/auth/spanner.admin',
        ];
        $defaultOptions = [
            'serviceAddress' => self::SERVICE_ADDRESS,
            'port' => self::DEFAULT_SERVICE_PORT,
            'scopes' => $defaultScopes,
            'retryingOverride' => null,
            'timeoutMillis' => self::DEFAULT_TIMEOUT_MILLIS,
            'appName' => 'gax',
            'appVersion' => self::_GAX_VERSION,
            'credentialsLoader' => null,
        ];
        $options = array_merge($defaultOptions, $options);

        $headerDescriptor = new AgentHeaderDescriptor([
            'clientName' => $options['appName'],
            'clientVersion' => $options['appVersion'],
            'codeGenName' => self::_CODEGEN_NAME,
            'codeGenVersion' => self::_CODEGEN_VERSION,
            'gaxVersion' => self::_GAX_VERSION,
            'phpVersion' => phpversion(),
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
        if (!empty($options['sslCreds'])) {
            $createStubOptions['sslCreds'] = $options['sslCreds'];
        }
        $grpcCredentialsHelperOptions = array_diff_key($options, $defaultOptions);
        $this->grpcCredentialsHelper = new GrpcCredentialsHelper($this->scopes, $grpcCredentialsHelperOptions);

        $createInstanceAdminStubFunction = function ($hostname, $opts) {
            return new InstanceAdminClient($hostname, $opts);
        };
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
     *     $instanceAdminApi = new InstanceAdminApi();
     *     $formattedName = InstanceAdminApi::formatProjectName("[PROJECT]");
     *     foreach ($instanceAdminApi->listInstanceConfigs($formattedName) as $element) {
     *         // doThingsWith(element);
     *     }
     * } finally {
     *     if (isset($instanceAdminApi)) {
     *         $instanceAdminApi->close();
     *     }
     * }
     * ```
     *
     * @param string $name         The name of the project for which a list of supported instance
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
     *     @type Google\GAX\RetrySettings $retrySettings
     *          Retry settings to use for this call. If present, then
     *          $timeoutMillis is ignored.
     *     @type int $timeoutMillis
     *          Timeout to use for this call. Only used if $retrySettings
     *          is not set.
     * }
     *
     * @return Google\GAX\PagedListResponse
     *
     * @throws Google\GAX\ApiException if the remote call fails
     */
    public function listInstanceConfigs($name, $optionalArgs = [])
    {
        $request = new ListInstanceConfigsRequest();
        $request->setName($name);
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
     *     $instanceAdminApi = new InstanceAdminApi();
     *     $formattedName = InstanceAdminApi::formatInstanceConfigName("[PROJECT]", "[INSTANCE_CONFIG]");
     *     $response = $instanceAdminApi->getInstanceConfig($formattedName);
     * } finally {
     *     if (isset($instanceAdminApi)) {
     *         $instanceAdminApi->close();
     *     }
     * }
     * ```
     *
     * @param string $name         The name of the requested instance configuration. Values are of the form
     *                             `projects/<project>/instanceConfigs/<config>`.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type Google\GAX\RetrySettings $retrySettings
     *          Retry settings to use for this call. If present, then
     *          $timeoutMillis is ignored.
     *     @type int $timeoutMillis
     *          Timeout to use for this call. Only used if $retrySettings
     *          is not set.
     * }
     *
     * @return google\spanner\admin\instance\v1\InstanceConfig
     *
     * @throws Google\GAX\ApiException if the remote call fails
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
     *     $instanceAdminApi = new InstanceAdminApi();
     *     $formattedName = InstanceAdminApi::formatProjectName("[PROJECT]");
     *     foreach ($instanceAdminApi->listInstances($formattedName) as $element) {
     *         // doThingsWith(element);
     *     }
     * } finally {
     *     if (isset($instanceAdminApi)) {
     *         $instanceAdminApi->close();
     *     }
     * }
     * ```
     *
     * @param string $name         The name of the project for which a list of instances is
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
     *            * name:Howl --> The instance's name is howl.
     *            * name:HOWL --> Equivalent to above.
     *            * NAME:howl --> Equivalent to above.
     *            * labels.env:* --> The instance has the label env.
     *            * labels.env:dev --> The instance's label env has the value dev.
     *            * name:howl labels.env:dev --> The instance's name is howl and it has
     *                                           the label env with value dev.
     *     @type Google\GAX\RetrySettings $retrySettings
     *          Retry settings to use for this call. If present, then
     *          $timeoutMillis is ignored.
     *     @type int $timeoutMillis
     *          Timeout to use for this call. Only used if $retrySettings
     *          is not set.
     * }
     *
     * @return Google\GAX\PagedListResponse
     *
     * @throws Google\GAX\ApiException if the remote call fails
     */
    public function listInstances($name, $optionalArgs = [])
    {
        $request = new ListInstancesRequest();
        $request->setName($name);
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
     *     $instanceAdminApi = new InstanceAdminApi();
     *     $formattedName = InstanceAdminApi::formatInstanceName("[PROJECT]", "[INSTANCE]");
     *     $response = $instanceAdminApi->getInstance($formattedName);
     * } finally {
     *     if (isset($instanceAdminApi)) {
     *         $instanceAdminApi->close();
     *     }
     * }
     * ```
     *
     * @param string $name         The name of the requested instance. Values are of the form
     *                             `projects/<project>/instances/<instance>`.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type Google\GAX\RetrySettings $retrySettings
     *          Retry settings to use for this call. If present, then
     *          $timeoutMillis is ignored.
     *     @type int $timeoutMillis
     *          Timeout to use for this call. Only used if $retrySettings
     *          is not set.
     * }
     *
     * @return google\spanner\admin\instance\v1\Instance
     *
     * @throws Google\GAX\ApiException if the remote call fails
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
     * The returned operation's
     * [metadata][google.longrunning.Operation.metadata] field type is
     * [CreateInstanceMetadata][google.spanner.admin.instance.v1.CreateInstanceMetadata]
     * The returned operation's
     * [response][google.longrunning.Operation.response] field type is
     * [Instance][google.spanner.admin.instance.v1.Instance], if
     * successful.
     *
     * Authorization requires `spanner.instances.create` permission on
     * resource [name][google.spanner.admin.instance.v1.Instance.name].
     *
     * Sample code:
     * ```
     * try {
     *     $instanceAdminApi = new InstanceAdminApi();
     *     $formattedName = InstanceAdminApi::formatInstanceName("[PROJECT]", "[INSTANCE]");
     *     $config = "";
     *     $displayName = "";
     *     $nodeCount = 0;
     *     $response = $instanceAdminApi->createInstance($formattedName, $config, $displayName, $nodeCount);
     * } finally {
     *     if (isset($instanceAdminApi)) {
     *         $instanceAdminApi->close();
     *     }
     * }
     * ```
     *
     * @param string $name         A unique identifier for the instance, which cannot be changed after
     *                             the instance is created. Values are of the form
     *                             `projects/<project>/instances/[a-z][-a-z0-9]*[a-z0-9]`. The final
     *                             segment of the name must be between 6 and 30 characters in length.
     * @param string $config       The name of the instance's configuration. Values are of the form
     *                             `projects/<project>/instanceConfigs/<configuration>`. See
     *                             also [InstanceConfig][google.spanner.admin.instance.v1.InstanceConfig] and
     *                             [ListInstanceConfigs][google.spanner.admin.instance.v1.InstanceAdmin.ListInstanceConfigs].
     * @param string $displayName  The descriptive name for this instance as it appears in UIs.
     *                             Must be unique per project and between 4 and 30 characters in length.
     * @param int    $nodeCount    The number of nodes allocated to this instance.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type State $state
     *          The current instance state. For
     *          [CreateInstance][google.spanner.admin.instance.v1.InstanceAdmin.CreateInstance], the state must be
     *          either omitted or set to `CREATING`. For
     *          [UpdateInstance][google.spanner.admin.instance.v1.InstanceAdmin.UpdateInstance], the state must be
     *          either omitted or set to `READY`.
     *     @type array $labels
     *          Cloud Labels are a flexible and lightweight mechanism for organizing cloud
     *          resources into groups that reflect a customer's organizational needs and
     *          deployment strategies. Cloud Labels can be used to filter collections of
     *          resources. They can be used to control how resource metrics are aggregated.
     *          And they can be used as arguments to policy management rules (e.g. route,
     *          firewall, load balancing, etc.).
     *
     *           * Label keys must be between 1 and 63 characters long and must conform to
     *             the following regular expression: `[a-z]([-a-z0-9]*[a-z0-9])?`.
     *           * Label values must be between 0 and 63 characters long and must conform
     *             to the regular expression `([a-z]([-a-z0-9]*[a-z0-9])?)?`.
     *           * No more than 64 labels can be associated with a given resource.
     *
     *          See https://goo.gl/xmQnxf for more information on and examples of labels.
     *
     *          If you plan to use labels in your own code, please note that additional
     *          characters may be allowed in the future. And so you are advised to use an
     *          internal label representation, such as JSON, which doesn't rely upon
     *          specific characters being disallowed.  For example, representing labels
     *          as the string:  name + "_" + value  would prove problematic if we were to
     *          allow "_" in a future release.
     *     @type Google\GAX\RetrySettings $retrySettings
     *          Retry settings to use for this call. If present, then
     *          $timeoutMillis is ignored.
     *     @type int $timeoutMillis
     *          Timeout to use for this call. Only used if $retrySettings
     *          is not set.
     * }
     *
     * @return google\longrunning\Operation
     *
     * @throws Google\GAX\ApiException if the remote call fails
     */
    public function createInstance($name, $config, $displayName, $nodeCount, $optionalArgs = [])
    {
        $request = new Instance();
        $request->setName($name);
        $request->setConfig($config);
        $request->setDisplayName($displayName);
        $request->setNodeCount($nodeCount);
        if (isset($optionalArgs['state'])) {
            $request->setState($optionalArgs['state']);
        }
        if (isset($optionalArgs['labels'])) {
            foreach ($optionalArgs['labels'] as $key => $value) {
                $request->addLabels((new LabelsEntry())->setKey($key)->setValue($value));
            }
        }

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
     * The returned operation's
     * [metadata][google.longrunning.Operation.metadata] field type is
     * [UpdateInstanceMetadata][google.spanner.admin.instance.v1.UpdateInstanceMetadata]
     * The returned operation's
     * [response][google.longrunning.Operation.response] field type is
     * [Instance][google.spanner.admin.instance.v1.Instance], if
     * successful.
     *
     * Authorization requires `spanner.instances.update` permission on
     * resource [name][google.spanner.admin.instance.v1.Instance.name].
     *
     * Sample code:
     * ```
     * try {
     *     $instanceAdminApi = new InstanceAdminApi();
     *     $formattedName = InstanceAdminApi::formatInstanceName("[PROJECT]", "[INSTANCE]");
     *     $config = "";
     *     $displayName = "";
     *     $nodeCount = 0;
     *     $response = $instanceAdminApi->updateInstance($formattedName, $config, $displayName, $nodeCount);
     * } finally {
     *     if (isset($instanceAdminApi)) {
     *         $instanceAdminApi->close();
     *     }
     * }
     * ```
     *
     * @param string $name         A unique identifier for the instance, which cannot be changed after
     *                             the instance is created. Values are of the form
     *                             `projects/<project>/instances/[a-z][-a-z0-9]*[a-z0-9]`. The final
     *                             segment of the name must be between 6 and 30 characters in length.
     * @param string $config       The name of the instance's configuration. Values are of the form
     *                             `projects/<project>/instanceConfigs/<configuration>`. See
     *                             also [InstanceConfig][google.spanner.admin.instance.v1.InstanceConfig] and
     *                             [ListInstanceConfigs][google.spanner.admin.instance.v1.InstanceAdmin.ListInstanceConfigs].
     * @param string $displayName  The descriptive name for this instance as it appears in UIs.
     *                             Must be unique per project and between 4 and 30 characters in length.
     * @param int    $nodeCount    The number of nodes allocated to this instance.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type State $state
     *          The current instance state. For
     *          [CreateInstance][google.spanner.admin.instance.v1.InstanceAdmin.CreateInstance], the state must be
     *          either omitted or set to `CREATING`. For
     *          [UpdateInstance][google.spanner.admin.instance.v1.InstanceAdmin.UpdateInstance], the state must be
     *          either omitted or set to `READY`.
     *     @type array $labels
     *          Cloud Labels are a flexible and lightweight mechanism for organizing cloud
     *          resources into groups that reflect a customer's organizational needs and
     *          deployment strategies. Cloud Labels can be used to filter collections of
     *          resources. They can be used to control how resource metrics are aggregated.
     *          And they can be used as arguments to policy management rules (e.g. route,
     *          firewall, load balancing, etc.).
     *
     *           * Label keys must be between 1 and 63 characters long and must conform to
     *             the following regular expression: `[a-z]([-a-z0-9]*[a-z0-9])?`.
     *           * Label values must be between 0 and 63 characters long and must conform
     *             to the regular expression `([a-z]([-a-z0-9]*[a-z0-9])?)?`.
     *           * No more than 64 labels can be associated with a given resource.
     *
     *          See https://goo.gl/xmQnxf for more information on and examples of labels.
     *
     *          If you plan to use labels in your own code, please note that additional
     *          characters may be allowed in the future. And so you are advised to use an
     *          internal label representation, such as JSON, which doesn't rely upon
     *          specific characters being disallowed.  For example, representing labels
     *          as the string:  name + "_" + value  would prove problematic if we were to
     *          allow "_" in a future release.
     *     @type Google\GAX\RetrySettings $retrySettings
     *          Retry settings to use for this call. If present, then
     *          $timeoutMillis is ignored.
     *     @type int $timeoutMillis
     *          Timeout to use for this call. Only used if $retrySettings
     *          is not set.
     * }
     *
     * @return google\longrunning\Operation
     *
     * @throws Google\GAX\ApiException if the remote call fails
     */
    public function updateInstance($name, $config, $displayName, $nodeCount, $optionalArgs = [])
    {
        $request = new Instance();
        $request->setName($name);
        $request->setConfig($config);
        $request->setDisplayName($displayName);
        $request->setNodeCount($nodeCount);
        if (isset($optionalArgs['state'])) {
            $request->setState($optionalArgs['state']);
        }
        if (isset($optionalArgs['labels'])) {
            foreach ($optionalArgs['labels'] as $key => $value) {
                $request->addLabels((new LabelsEntry())->setKey($key)->setValue($value));
            }
        }

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
     *     $instanceAdminApi = new InstanceAdminApi();
     *     $formattedName = InstanceAdminApi::formatInstanceName("[PROJECT]", "[INSTANCE]");
     *     $instanceAdminApi->deleteInstance($formattedName);
     * } finally {
     *     if (isset($instanceAdminApi)) {
     *         $instanceAdminApi->close();
     *     }
     * }
     * ```
     *
     * @param string $name         The name of the instance to be deleted. Values are of the form
     *                             `projects/<project>/instances/<instance>`
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type Google\GAX\RetrySettings $retrySettings
     *          Retry settings to use for this call. If present, then
     *          $timeoutMillis is ignored.
     *     @type int $timeoutMillis
     *          Timeout to use for this call. Only used if $retrySettings
     *          is not set.
     * }
     *
     * @throws Google\GAX\ApiException if the remote call fails
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
     * Sample code:
     * ```
     * try {
     *     $instanceAdminApi = new InstanceAdminApi();
     *     $formattedResource = InstanceAdminApi::formatInstanceName("[PROJECT]", "[INSTANCE]");
     *     $policy = new Policy();
     *     $response = $instanceAdminApi->setIamPolicy($formattedResource, $policy);
     * } finally {
     *     if (isset($instanceAdminApi)) {
     *         $instanceAdminApi->close();
     *     }
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
     *     @type Google\GAX\RetrySettings $retrySettings
     *          Retry settings to use for this call. If present, then
     *          $timeoutMillis is ignored.
     *     @type int $timeoutMillis
     *          Timeout to use for this call. Only used if $retrySettings
     *          is not set.
     * }
     *
     * @return google\iam\v1\Policy
     *
     * @throws Google\GAX\ApiException if the remote call fails
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
     * Sample code:
     * ```
     * try {
     *     $instanceAdminApi = new InstanceAdminApi();
     *     $formattedResource = InstanceAdminApi::formatInstanceName("[PROJECT]", "[INSTANCE]");
     *     $response = $instanceAdminApi->getIamPolicy($formattedResource);
     * } finally {
     *     if (isset($instanceAdminApi)) {
     *         $instanceAdminApi->close();
     *     }
     * }
     * ```
     *
     * @param string $resource     REQUIRED: The resource for which the policy is being requested.
     *                             `resource` is usually specified as a path. For example, a Project
     *                             resource is specified as `projects/{project}`.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type Google\GAX\RetrySettings $retrySettings
     *          Retry settings to use for this call. If present, then
     *          $timeoutMillis is ignored.
     *     @type int $timeoutMillis
     *          Timeout to use for this call. Only used if $retrySettings
     *          is not set.
     * }
     *
     * @return google\iam\v1\Policy
     *
     * @throws Google\GAX\ApiException if the remote call fails
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
     * Sample code:
     * ```
     * try {
     *     $instanceAdminApi = new InstanceAdminApi();
     *     $formattedResource = InstanceAdminApi::formatInstanceName("[PROJECT]", "[INSTANCE]");
     *     $permissions = [];
     *     $response = $instanceAdminApi->testIamPermissions($formattedResource, $permissions);
     * } finally {
     *     if (isset($instanceAdminApi)) {
     *         $instanceAdminApi->close();
     *     }
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
     *     @type Google\GAX\RetrySettings $retrySettings
     *          Retry settings to use for this call. If present, then
     *          $timeoutMillis is ignored.
     *     @type int $timeoutMillis
     *          Timeout to use for this call. Only used if $retrySettings
     *          is not set.
     * }
     *
     * @return google\iam\v1\TestIamPermissionsResponse
     *
     * @throws Google\GAX\ApiException if the remote call fails
     */
    public function testIamPermissions($resource, $permissions, $optionalArgs = [])
    {
        $request = new TestIamPermissionsRequest();
        $request->setResource($resource);
        foreach ($permissions as $elem) {
            $request->addPermissions($elem);
        }

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

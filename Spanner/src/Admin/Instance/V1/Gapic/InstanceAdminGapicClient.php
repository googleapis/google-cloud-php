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
 * https://github.com/google/googleapis/blob/master/google/spanner/admin/instance/v1/spanner_instance_admin.proto
 * and updates to that file get reflected here through a refresh process.
 *
 * @experimental
 */

namespace Google\Cloud\Spanner\Admin\Instance\V1\Gapic;

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
use Google\Cloud\Iam\V1\GetIamPolicyRequest;
use Google\Cloud\Iam\V1\GetPolicyOptions;
use Google\Cloud\Iam\V1\Policy;
use Google\Cloud\Iam\V1\SetIamPolicyRequest;
use Google\Cloud\Iam\V1\TestIamPermissionsRequest;
use Google\Cloud\Iam\V1\TestIamPermissionsResponse;
use Google\Cloud\Spanner\Admin\Instance\V1\CreateInstanceMetadata;
use Google\Cloud\Spanner\Admin\Instance\V1\CreateInstanceRequest;
use Google\Cloud\Spanner\Admin\Instance\V1\DeleteInstanceRequest;
use Google\Cloud\Spanner\Admin\Instance\V1\GetInstanceConfigRequest;
use Google\Cloud\Spanner\Admin\Instance\V1\GetInstanceRequest;
use Google\Cloud\Spanner\Admin\Instance\V1\Instance;
use Google\Cloud\Spanner\Admin\Instance\V1\InstanceConfig;
use Google\Cloud\Spanner\Admin\Instance\V1\ListInstanceConfigsRequest;
use Google\Cloud\Spanner\Admin\Instance\V1\ListInstanceConfigsResponse;
use Google\Cloud\Spanner\Admin\Instance\V1\ListInstancesRequest;
use Google\Cloud\Spanner\Admin\Instance\V1\ListInstancesResponse;
use Google\Cloud\Spanner\Admin\Instance\V1\UpdateInstanceMetadata;
use Google\Cloud\Spanner\Admin\Instance\V1\UpdateInstanceRequest;
use Google\LongRunning\Operation;
use Google\Protobuf\FieldMask;
use Google\Protobuf\GPBEmpty;

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
 * $instanceAdminClient = new InstanceAdminClient();
 * try {
 *     $formattedParent = $instanceAdminClient->projectName('[PROJECT]');
 *     // Iterate over pages of elements
 *     $pagedResponse = $instanceAdminClient->listInstanceConfigs($formattedParent);
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
 *     $pagedResponse = $instanceAdminClient->listInstanceConfigs($formattedParent);
 *     foreach ($pagedResponse->iterateAllElements() as $element) {
 *         // doSomethingWith($element);
 *     }
 * } finally {
 *     $instanceAdminClient->close();
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
class InstanceAdminGapicClient
{
    use GapicClientTrait;

    /**
     * The name of the service.
     */
    const SERVICE_NAME = 'google.spanner.admin.instance.v1.InstanceAdmin';

    /**
     * The default address of the service.
     */
    const SERVICE_ADDRESS = 'spanner.googleapis.com';

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
        'https://www.googleapis.com/auth/spanner.admin',
    ];
    private static $instanceNameTemplate;
    private static $instanceConfigNameTemplate;
    private static $projectNameTemplate;
    private static $pathTemplateMap;

    private $operationsClient;

    private static function getClientDefaults()
    {
        return [
            'serviceName' => self::SERVICE_NAME,
            'apiEndpoint' => self::SERVICE_ADDRESS.':'.self::DEFAULT_SERVICE_PORT,
            'clientConfig' => __DIR__.'/../resources/instance_admin_client_config.json',
            'descriptorsConfigPath' => __DIR__.'/../resources/instance_admin_descriptor_config.php',
            'gcpApiConfigPath' => __DIR__.'/../resources/instance_admin_grpc_config.json',
            'credentialsConfig' => [
                'scopes' => self::$serviceScopes,
            ],
            'transportConfig' => [
                'rest' => [
                    'restClientConfigPath' => __DIR__.'/../resources/instance_admin_rest_client_config.php',
                ],
            ],
        ];
    }

    private static function getInstanceNameTemplate()
    {
        if (null == self::$instanceNameTemplate) {
            self::$instanceNameTemplate = new PathTemplate('projects/{project}/instances/{instance}');
        }

        return self::$instanceNameTemplate;
    }

    private static function getInstanceConfigNameTemplate()
    {
        if (null == self::$instanceConfigNameTemplate) {
            self::$instanceConfigNameTemplate = new PathTemplate('projects/{project}/instanceConfigs/{instance_config}');
        }

        return self::$instanceConfigNameTemplate;
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
                'instance' => self::getInstanceNameTemplate(),
                'instanceConfig' => self::getInstanceConfigNameTemplate(),
                'project' => self::getProjectNameTemplate(),
            ];
        }

        return self::$pathTemplateMap;
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
     * a instance_config resource.
     *
     * @param string $project
     * @param string $instanceConfig
     *
     * @return string The formatted instance_config resource.
     * @experimental
     */
    public static function instanceConfigName($project, $instanceConfig)
    {
        return self::getInstanceConfigNameTemplate()->render([
            'project' => $project,
            'instance_config' => $instanceConfig,
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
     * - instance: projects/{project}/instances/{instance}
     * - instanceConfig: projects/{project}/instanceConfigs/{instance_config}
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
     *           **Deprecated**. This option will be removed in a future major release. Please
     *           utilize the `$apiEndpoint` option instead.
     *     @type string $apiEndpoint
     *           The address of the API remote host. May optionally include the port, formatted
     *           as "<uri>:<port>". Default 'spanner.googleapis.com:443'.
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
     *           object is provided, any settings in $transportConfig, and any `$apiEndpoint`
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
     * Lists the supported instance configurations for a given project.
     *
     * Sample code:
     * ```
     * $instanceAdminClient = new InstanceAdminClient();
     * try {
     *     $formattedParent = $instanceAdminClient->projectName('[PROJECT]');
     *     // Iterate over pages of elements
     *     $pagedResponse = $instanceAdminClient->listInstanceConfigs($formattedParent);
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
     *     $pagedResponse = $instanceAdminClient->listInstanceConfigs($formattedParent);
     *     foreach ($pagedResponse->iterateAllElements() as $element) {
     *         // doSomethingWith($element);
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
    public function listInstanceConfigs($parent, array $optionalArgs = [])
    {
        $request = new ListInstanceConfigsRequest();
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
            'ListInstanceConfigs',
            $optionalArgs,
            ListInstanceConfigsResponse::class,
            $request
        );
    }

    /**
     * Gets information about a particular instance configuration.
     *
     * Sample code:
     * ```
     * $instanceAdminClient = new InstanceAdminClient();
     * try {
     *     $formattedName = $instanceAdminClient->instanceConfigName('[PROJECT]', '[INSTANCE_CONFIG]');
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
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Spanner\Admin\Instance\V1\InstanceConfig
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function getInstanceConfig($name, array $optionalArgs = [])
    {
        $request = new GetInstanceConfigRequest();
        $request->setName($name);

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'GetInstanceConfig',
            InstanceConfig::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Lists all instances in the given project.
     *
     * Sample code:
     * ```
     * $instanceAdminClient = new InstanceAdminClient();
     * try {
     *     $formattedParent = $instanceAdminClient->projectName('[PROJECT]');
     *     // Iterate over pages of elements
     *     $pagedResponse = $instanceAdminClient->listInstances($formattedParent);
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
     *     $pagedResponse = $instanceAdminClient->listInstances($formattedParent);
     *     foreach ($pagedResponse->iterateAllElements() as $element) {
     *         // doSomethingWith($element);
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
     *            * `name`
     *            * `display_name`
     *            * `labels.key` where key is the name of a label
     *
     *          Some examples of using filters are:
     *
     *            * `name:*` --> The instance has a name.
     *            * `name:Howl` --> The instance's name contains the string "howl".
     *            * `name:HOWL` --> Equivalent to above.
     *            * `NAME:howl` --> Equivalent to above.
     *            * `labels.env:*` --> The instance has the label "env".
     *            * `labels.env:dev` --> The instance has the label "env" and the value of
     *                                 the label contains the string "dev".
     *            * `name:howl labels.env:dev` --> The instance's name contains "howl" and
     *                                           it has the label "env" with its value
     *                                           containing "dev".
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
    public function listInstances($parent, array $optionalArgs = [])
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

        $requestParams = new RequestParamsHeaderDescriptor([
          'parent' => $request->getParent(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->getPagedListResponse(
            'ListInstances',
            $optionalArgs,
            ListInstancesResponse::class,
            $request
        );
    }

    /**
     * Gets information about a particular instance.
     *
     * Sample code:
     * ```
     * $instanceAdminClient = new InstanceAdminClient();
     * try {
     *     $formattedName = $instanceAdminClient->instanceName('[PROJECT]', '[INSTANCE]');
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
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Spanner\Admin\Instance\V1\Instance
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
     * $instanceAdminClient = new InstanceAdminClient();
     * try {
     *     $formattedParent = $instanceAdminClient->projectName('[PROJECT]');
     *     $instanceId = '';
     *     $instance = new Instance();
     *     $operationResponse = $instanceAdminClient->createInstance($formattedParent, $instanceId, $instance);
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
    public function createInstance($parent, $instanceId, $instance, array $optionalArgs = [])
    {
        $request = new CreateInstanceRequest();
        $request->setParent($parent);
        $request->setInstanceId($instanceId);
        $request->setInstance($instance);

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
     *     [cancel_time][google.spanner.admin.instance.v1.UpdateInstanceMetadata.cancel_time],
     *     and begins restoring resources to their pre-request values. The
     *     operation is guaranteed to succeed at undoing all resource changes,
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
     * $instanceAdminClient = new InstanceAdminClient();
     * try {
     *     $instance = new Instance();
     *     $fieldMask = new FieldMask();
     *     $operationResponse = $instanceAdminClient->updateInstance($instance, $fieldMask);
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
     *                                name.  Otherwise, only fields mentioned in
     *                                [][google.spanner.admin.instance.v1.UpdateInstanceRequest.field_mask] need
     *                                be included.
     * @param FieldMask $fieldMask    Required. A mask specifying which fields in
     *                                [][google.spanner.admin.instance.v1.UpdateInstanceRequest.instance] should
     *                                be updated. The field mask must always be specified; this prevents any
     *                                future fields in
     *                                [][google.spanner.admin.instance.v1.Instance] from being erased
     *                                accidentally by clients that do not know about them.
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
    public function updateInstance($instance, $fieldMask, array $optionalArgs = [])
    {
        $request = new UpdateInstanceRequest();
        $request->setInstance($instance);
        $request->setFieldMask($fieldMask);

        $requestParams = new RequestParamsHeaderDescriptor([
          'instance.name' => $request->getInstance()->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startOperationsCall(
            'UpdateInstance',
            $optionalArgs,
            $request,
            $this->getOperationsClient()
        )->wait();
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
     * $instanceAdminClient = new InstanceAdminClient();
     * try {
     *     $formattedName = $instanceAdminClient->instanceName('[PROJECT]', '[INSTANCE]');
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
     * Sets the access control policy on an instance resource. Replaces any
     * existing policy.
     *
     * Authorization requires `spanner.instances.setIamPolicy` on
     * [resource][google.iam.v1.SetIamPolicyRequest.resource].
     *
     * Sample code:
     * ```
     * $instanceAdminClient = new InstanceAdminClient();
     * try {
     *     $formattedResource = $instanceAdminClient->instanceName('[PROJECT]', '[INSTANCE]');
     *     $policy = new Policy();
     *     $response = $instanceAdminClient->setIamPolicy($formattedResource, $policy);
     * } finally {
     *     $instanceAdminClient->close();
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
     * Gets the access control policy for an instance resource. Returns an empty
     * policy if an instance exists but does not have a policy set.
     *
     * Authorization requires `spanner.instances.getIamPolicy` on
     * [resource][google.iam.v1.GetIamPolicyRequest.resource].
     *
     * Sample code:
     * ```
     * $instanceAdminClient = new InstanceAdminClient();
     * try {
     *     $formattedResource = $instanceAdminClient->instanceName('[PROJECT]', '[INSTANCE]');
     *     $response = $instanceAdminClient->getIamPolicy($formattedResource);
     * } finally {
     *     $instanceAdminClient->close();
     * }
     * ```
     *
     * @param string $resource     REQUIRED: The resource for which the policy is being requested.
     *                             See the operation documentation for the appropriate value for this field.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type GetPolicyOptions $options
     *          OPTIONAL: A `GetPolicyOptions` object for specifying options to
     *          `GetIamPolicy`. This field is only used by Cloud IAM.
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
        if (isset($optionalArgs['options'])) {
            $request->setOptions($optionalArgs['options']);
        }

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
     * Returns permissions that the caller has on the specified instance resource.
     *
     * Attempting this RPC on a non-existent Cloud Spanner instance resource will
     * result in a NOT_FOUND error if the user has `spanner.instances.list`
     * permission on the containing Google Cloud Project. Otherwise returns an
     * empty set of permissions.
     *
     * Sample code:
     * ```
     * $instanceAdminClient = new InstanceAdminClient();
     * try {
     *     $formattedResource = $instanceAdminClient->instanceName('[PROJECT]', '[INSTANCE]');
     *     $permissions = [];
     *     $response = $instanceAdminClient->testIamPermissions($formattedResource, $permissions);
     * } finally {
     *     $instanceAdminClient->close();
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

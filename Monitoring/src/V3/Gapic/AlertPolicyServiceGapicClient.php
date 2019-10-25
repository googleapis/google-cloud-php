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
 * https://github.com/google/googleapis/blob/master/google/monitoring/v3/alert_service.proto
 * and updates to that file get reflected here through a refresh process.
 *
 * @experimental
 */

namespace Google\Cloud\Monitoring\V3\Gapic;

use Google\ApiCore\ApiException;
use Google\ApiCore\CredentialsWrapper;
use Google\ApiCore\GapicClientTrait;
use Google\ApiCore\PathTemplate;
use Google\ApiCore\RequestParamsHeaderDescriptor;
use Google\ApiCore\RetrySettings;
use Google\ApiCore\Transport\TransportInterface;
use Google\ApiCore\ValidationException;
use Google\Auth\FetchAuthTokenInterface;
use Google\Cloud\Monitoring\V3\AlertPolicy;
use Google\Cloud\Monitoring\V3\CreateAlertPolicyRequest;
use Google\Cloud\Monitoring\V3\DeleteAlertPolicyRequest;
use Google\Cloud\Monitoring\V3\GetAlertPolicyRequest;
use Google\Cloud\Monitoring\V3\ListAlertPoliciesRequest;
use Google\Cloud\Monitoring\V3\ListAlertPoliciesResponse;
use Google\Cloud\Monitoring\V3\UpdateAlertPolicyRequest;
use Google\Protobuf\FieldMask;
use Google\Protobuf\GPBEmpty;

/**
 * Service Description: The AlertPolicyService API is used to manage (list, create, delete,
 * edit) alert policies in Stackdriver Monitoring. An alerting policy is
 * a description of the conditions under which some aspect of your
 * system is considered to be "unhealthy" and the ways to notify
 * people or services about this state. In addition to using this API, alert
 * policies can also be managed through
 * [Stackdriver Monitoring](https://cloud.google.com/monitoring/docs/),
 * which can be reached by clicking the "Monitoring" tab in
 * [Cloud Console](https://console.cloud.google.com/).
 *
 * This class provides the ability to make remote calls to the backing service through method
 * calls that map to API methods. Sample code to get started:
 *
 * ```
 * $alertPolicyServiceClient = new Google\Cloud\Monitoring\V3\AlertPolicyServiceClient();
 * try {
 *     $formattedName = $alertPolicyServiceClient->projectName('[PROJECT]');
 *     // Iterate over pages of elements
 *     $pagedResponse = $alertPolicyServiceClient->listAlertPolicies($formattedName);
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
 *     $pagedResponse = $alertPolicyServiceClient->listAlertPolicies($formattedName);
 *     foreach ($pagedResponse->iterateAllElements() as $element) {
 *         // doSomethingWith($element);
 *     }
 * } finally {
 *     $alertPolicyServiceClient->close();
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
class AlertPolicyServiceGapicClient
{
    use GapicClientTrait;

    /**
     * The name of the service.
     */
    const SERVICE_NAME = 'google.monitoring.v3.AlertPolicyService';

    /**
     * The default address of the service.
     */
    const SERVICE_ADDRESS = 'monitoring.googleapis.com';

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
        'https://www.googleapis.com/auth/monitoring',
        'https://www.googleapis.com/auth/monitoring.read',
        'https://www.googleapis.com/auth/monitoring.write',
    ];
    private static $alertPolicyNameTemplate;
    private static $alertPolicyConditionNameTemplate;
    private static $projectNameTemplate;
    private static $pathTemplateMap;

    private static function getClientDefaults()
    {
        return [
            'serviceName' => self::SERVICE_NAME,
            'apiEndpoint' => self::SERVICE_ADDRESS.':'.self::DEFAULT_SERVICE_PORT,
            'clientConfig' => __DIR__.'/../resources/alert_policy_service_client_config.json',
            'descriptorsConfigPath' => __DIR__.'/../resources/alert_policy_service_descriptor_config.php',
            'gcpApiConfigPath' => __DIR__.'/../resources/alert_policy_service_grpc_config.json',
            'credentialsConfig' => [
                'scopes' => self::$serviceScopes,
            ],
            'transportConfig' => [
                'rest' => [
                    'restClientConfigPath' => __DIR__.'/../resources/alert_policy_service_rest_client_config.php',
                ],
            ],
        ];
    }

    private static function getAlertPolicyNameTemplate()
    {
        if (null == self::$alertPolicyNameTemplate) {
            self::$alertPolicyNameTemplate = new PathTemplate('projects/{project}/alertPolicies/{alert_policy}');
        }

        return self::$alertPolicyNameTemplate;
    }

    private static function getAlertPolicyConditionNameTemplate()
    {
        if (null == self::$alertPolicyConditionNameTemplate) {
            self::$alertPolicyConditionNameTemplate = new PathTemplate('projects/{project}/alertPolicies/{alert_policy}/conditions/{condition}');
        }

        return self::$alertPolicyConditionNameTemplate;
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
                'alertPolicy' => self::getAlertPolicyNameTemplate(),
                'alertPolicyCondition' => self::getAlertPolicyConditionNameTemplate(),
                'project' => self::getProjectNameTemplate(),
            ];
        }

        return self::$pathTemplateMap;
    }

    /**
     * Formats a string containing the fully-qualified path to represent
     * a alert_policy resource.
     *
     * @param string $project
     * @param string $alertPolicy
     *
     * @return string The formatted alert_policy resource.
     * @experimental
     */
    public static function alertPolicyName($project, $alertPolicy)
    {
        return self::getAlertPolicyNameTemplate()->render([
            'project' => $project,
            'alert_policy' => $alertPolicy,
        ]);
    }

    /**
     * Formats a string containing the fully-qualified path to represent
     * a alert_policy_condition resource.
     *
     * @param string $project
     * @param string $alertPolicy
     * @param string $condition
     *
     * @return string The formatted alert_policy_condition resource.
     * @experimental
     */
    public static function alertPolicyConditionName($project, $alertPolicy, $condition)
    {
        return self::getAlertPolicyConditionNameTemplate()->render([
            'project' => $project,
            'alert_policy' => $alertPolicy,
            'condition' => $condition,
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
     * - alertPolicy: projects/{project}/alertPolicies/{alert_policy}
     * - alertPolicyCondition: projects/{project}/alertPolicies/{alert_policy}/conditions/{condition}
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
     *           as "<uri>:<port>". Default 'monitoring.googleapis.com:443'.
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
    }

    /**
     * Lists the existing alerting policies for the project.
     *
     * Sample code:
     * ```
     * $alertPolicyServiceClient = new Google\Cloud\Monitoring\V3\AlertPolicyServiceClient();
     * try {
     *     $formattedName = $alertPolicyServiceClient->projectName('[PROJECT]');
     *     // Iterate over pages of elements
     *     $pagedResponse = $alertPolicyServiceClient->listAlertPolicies($formattedName);
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
     *     $pagedResponse = $alertPolicyServiceClient->listAlertPolicies($formattedName);
     *     foreach ($pagedResponse->iterateAllElements() as $element) {
     *         // doSomethingWith($element);
     *     }
     * } finally {
     *     $alertPolicyServiceClient->close();
     * }
     * ```
     *
     * @param string $name The project whose alert policies are to be listed. The format is
     *
     *     projects/[PROJECT_ID]
     *
     * Note that this field names the parent container in which the alerting
     * policies to be listed are stored. To retrieve a single alerting policy
     * by name, use the
     * [GetAlertPolicy][google.monitoring.v3.AlertPolicyService.GetAlertPolicy]
     * operation, instead.
     * @param array $optionalArgs {
     *                            Optional.
     *
     *     @type string $filter
     *          If provided, this field specifies the criteria that must be met by
     *          alert policies to be included in the response.
     *
     *          For more details, see [sorting and
     *          filtering](https://cloud.google.com/monitoring/api/v3/sorting-and-filtering).
     *     @type string $orderBy
     *          A comma-separated list of fields by which to sort the result. Supports
     *          the same set of field references as the `filter` field. Entries can be
     *          prefixed with a minus sign to sort by the field in descending order.
     *
     *          For more details, see [sorting and
     *          filtering](https://cloud.google.com/monitoring/api/v3/sorting-and-filtering).
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
    public function listAlertPolicies($name, array $optionalArgs = [])
    {
        $request = new ListAlertPoliciesRequest();
        $request->setName($name);
        if (isset($optionalArgs['filter'])) {
            $request->setFilter($optionalArgs['filter']);
        }
        if (isset($optionalArgs['orderBy'])) {
            $request->setOrderBy($optionalArgs['orderBy']);
        }
        if (isset($optionalArgs['pageSize'])) {
            $request->setPageSize($optionalArgs['pageSize']);
        }
        if (isset($optionalArgs['pageToken'])) {
            $request->setPageToken($optionalArgs['pageToken']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->getPagedListResponse(
            'ListAlertPolicies',
            $optionalArgs,
            ListAlertPoliciesResponse::class,
            $request
        );
    }

    /**
     * Gets a single alerting policy.
     *
     * Sample code:
     * ```
     * $alertPolicyServiceClient = new Google\Cloud\Monitoring\V3\AlertPolicyServiceClient();
     * try {
     *     $formattedName = $alertPolicyServiceClient->alertPolicyName('[PROJECT]', '[ALERT_POLICY]');
     *     $response = $alertPolicyServiceClient->getAlertPolicy($formattedName);
     * } finally {
     *     $alertPolicyServiceClient->close();
     * }
     * ```
     *
     * @param string $name The alerting policy to retrieve. The format is
     *
     *     projects/[PROJECT_ID]/alertPolicies/[ALERT_POLICY_ID]
     * @param array $optionalArgs {
     *                            Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Monitoring\V3\AlertPolicy
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function getAlertPolicy($name, array $optionalArgs = [])
    {
        $request = new GetAlertPolicyRequest();
        $request->setName($name);

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'GetAlertPolicy',
            AlertPolicy::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Creates a new alerting policy.
     *
     * Sample code:
     * ```
     * $alertPolicyServiceClient = new Google\Cloud\Monitoring\V3\AlertPolicyServiceClient();
     * try {
     *     $formattedName = $alertPolicyServiceClient->projectName('[PROJECT]');
     *     $alertPolicy = new Google\Cloud\Monitoring\V3\AlertPolicy();
     *     $response = $alertPolicyServiceClient->createAlertPolicy($formattedName, $alertPolicy);
     * } finally {
     *     $alertPolicyServiceClient->close();
     * }
     * ```
     *
     * @param string $name The project in which to create the alerting policy. The format is
     *                     `projects/[PROJECT_ID]`.
     *
     * Note that this field names the parent container in which the alerting
     * policy will be written, not the name of the created policy. The alerting
     * policy that is returned will have a name that contains a normalized
     * representation of this name as a prefix but adds a suffix of the form
     * `/alertPolicies/[POLICY_ID]`, identifying the policy in the container.
     * @param AlertPolicy $alertPolicy  The requested alerting policy. You should omit the `name` field in this
     *                                  policy. The name will be returned in the new policy, including
     *                                  a new [ALERT_POLICY_ID] value.
     * @param array       $optionalArgs {
     *                                  Optional.
     *
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Monitoring\V3\AlertPolicy
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function createAlertPolicy($name, $alertPolicy, array $optionalArgs = [])
    {
        $request = new CreateAlertPolicyRequest();
        $request->setName($name);
        $request->setAlertPolicy($alertPolicy);

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'CreateAlertPolicy',
            AlertPolicy::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Deletes an alerting policy.
     *
     * Sample code:
     * ```
     * $alertPolicyServiceClient = new Google\Cloud\Monitoring\V3\AlertPolicyServiceClient();
     * try {
     *     $formattedName = $alertPolicyServiceClient->alertPolicyName('[PROJECT]', '[ALERT_POLICY]');
     *     $alertPolicyServiceClient->deleteAlertPolicy($formattedName);
     * } finally {
     *     $alertPolicyServiceClient->close();
     * }
     * ```
     *
     * @param string $name The alerting policy to delete. The format is:
     *
     *     projects/[PROJECT_ID]/alertPolicies/[ALERT_POLICY_ID]
     *
     * For more information, see [AlertPolicy][google.monitoring.v3.AlertPolicy].
     * @param array $optionalArgs {
     *                            Optional.
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
    public function deleteAlertPolicy($name, array $optionalArgs = [])
    {
        $request = new DeleteAlertPolicyRequest();
        $request->setName($name);

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'DeleteAlertPolicy',
            GPBEmpty::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Updates an alerting policy. You can either replace the entire policy with
     * a new one or replace only certain fields in the current alerting policy by
     * specifying the fields to be updated via `updateMask`. Returns the
     * updated alerting policy.
     *
     * Sample code:
     * ```
     * $alertPolicyServiceClient = new Google\Cloud\Monitoring\V3\AlertPolicyServiceClient();
     * try {
     *     $alertPolicy = new Google\Cloud\Monitoring\V3\AlertPolicy();
     *     $response = $alertPolicyServiceClient->updateAlertPolicy($alertPolicy);
     * } finally {
     *     $alertPolicyServiceClient->close();
     * }
     * ```
     *
     * @param AlertPolicy $alertPolicy  Required. The updated alerting policy or the updated values for the
     *                                  fields listed in `update_mask`.
     *                                  If `update_mask` is not empty, any fields in this policy that are
     *                                  not in `update_mask` are ignored.
     * @param array       $optionalArgs {
     *                                  Optional.
     *
     *     @type FieldMask $updateMask
     *          Optional. A list of alerting policy field names. If this field is not
     *          empty, each listed field in the existing alerting policy is set to the
     *          value of the corresponding field in the supplied policy (`alert_policy`),
     *          or to the field's default value if the field is not in the supplied
     *          alerting policy.  Fields not listed retain their previous value.
     *
     *          Examples of valid field masks include `display_name`, `documentation`,
     *          `documentation.content`, `documentation.mime_type`, `user_labels`,
     *          `user_label.nameofkey`, `enabled`, `conditions`, `combiner`, etc.
     *
     *          If this field is empty, then the supplied alerting policy replaces the
     *          existing policy. It is the same as deleting the existing policy and
     *          adding the supplied policy, except for the following:
     *
     *          +   The new policy will have the same `[ALERT_POLICY_ID]` as the former
     *              policy. This gives you continuity with the former policy in your
     *              notifications and incidents.
     *          +   Conditions in the new policy will keep their former `[CONDITION_ID]` if
     *              the supplied condition includes the `name` field with that
     *              `[CONDITION_ID]`. If the supplied condition omits the `name` field,
     *              then a new `[CONDITION_ID]` is created.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Monitoring\V3\AlertPolicy
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function updateAlertPolicy($alertPolicy, array $optionalArgs = [])
    {
        $request = new UpdateAlertPolicyRequest();
        $request->setAlertPolicy($alertPolicy);
        if (isset($optionalArgs['updateMask'])) {
            $request->setUpdateMask($optionalArgs['updateMask']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'alert_policy.name' => $request->getAlertPolicy()->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'UpdateAlertPolicy',
            AlertPolicy::class,
            $optionalArgs,
            $request
        )->wait();
    }
}

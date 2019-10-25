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
 * https://github.com/google/googleapis/blob/master/google/monitoring/v3/group_service.proto
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
use Google\Cloud\Monitoring\V3\CreateGroupRequest;
use Google\Cloud\Monitoring\V3\DeleteGroupRequest;
use Google\Cloud\Monitoring\V3\GetGroupRequest;
use Google\Cloud\Monitoring\V3\Group;
use Google\Cloud\Monitoring\V3\ListGroupMembersRequest;
use Google\Cloud\Monitoring\V3\ListGroupMembersResponse;
use Google\Cloud\Monitoring\V3\ListGroupsRequest;
use Google\Cloud\Monitoring\V3\ListGroupsResponse;
use Google\Cloud\Monitoring\V3\TimeInterval;
use Google\Cloud\Monitoring\V3\UpdateGroupRequest;
use Google\Protobuf\GPBEmpty;

/**
 * Service Description: The Group API lets you inspect and manage your
 * [groups](https://cloud.google.com#google.monitoring.v3.Group).
 *
 * A group is a named filter that is used to identify
 * a collection of monitored resources. Groups are typically used to
 * mirror the physical and/or logical topology of the environment.
 * Because group membership is computed dynamically, monitored
 * resources that are started in the future are automatically placed
 * in matching groups. By using a group to name monitored resources in,
 * for example, an alert policy, the target of that alert policy is
 * updated automatically as monitored resources are added and removed
 * from the infrastructure.
 *
 * This class provides the ability to make remote calls to the backing service through method
 * calls that map to API methods. Sample code to get started:
 *
 * ```
 * $groupServiceClient = new Google\Cloud\Monitoring\V3\GroupServiceClient();
 * try {
 *     $formattedName = $groupServiceClient->projectName('[PROJECT]');
 *     // Iterate over pages of elements
 *     $pagedResponse = $groupServiceClient->listGroups($formattedName);
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
 *     $pagedResponse = $groupServiceClient->listGroups($formattedName);
 *     foreach ($pagedResponse->iterateAllElements() as $element) {
 *         // doSomethingWith($element);
 *     }
 * } finally {
 *     $groupServiceClient->close();
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
class GroupServiceGapicClient
{
    use GapicClientTrait;

    /**
     * The name of the service.
     */
    const SERVICE_NAME = 'google.monitoring.v3.GroupService';

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
    private static $groupNameTemplate;
    private static $projectNameTemplate;
    private static $pathTemplateMap;

    private static function getClientDefaults()
    {
        return [
            'serviceName' => self::SERVICE_NAME,
            'apiEndpoint' => self::SERVICE_ADDRESS.':'.self::DEFAULT_SERVICE_PORT,
            'clientConfig' => __DIR__.'/../resources/group_service_client_config.json',
            'descriptorsConfigPath' => __DIR__.'/../resources/group_service_descriptor_config.php',
            'gcpApiConfigPath' => __DIR__.'/../resources/group_service_grpc_config.json',
            'credentialsConfig' => [
                'scopes' => self::$serviceScopes,
            ],
            'transportConfig' => [
                'rest' => [
                    'restClientConfigPath' => __DIR__.'/../resources/group_service_rest_client_config.php',
                ],
            ],
        ];
    }

    private static function getGroupNameTemplate()
    {
        if (null == self::$groupNameTemplate) {
            self::$groupNameTemplate = new PathTemplate('projects/{project}/groups/{group}');
        }

        return self::$groupNameTemplate;
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
                'group' => self::getGroupNameTemplate(),
                'project' => self::getProjectNameTemplate(),
            ];
        }

        return self::$pathTemplateMap;
    }

    /**
     * Formats a string containing the fully-qualified path to represent
     * a group resource.
     *
     * @param string $project
     * @param string $group
     *
     * @return string The formatted group resource.
     * @experimental
     */
    public static function groupName($project, $group)
    {
        return self::getGroupNameTemplate()->render([
            'project' => $project,
            'group' => $group,
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
     * - group: projects/{project}/groups/{group}
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
     * Lists the existing groups.
     *
     * Sample code:
     * ```
     * $groupServiceClient = new Google\Cloud\Monitoring\V3\GroupServiceClient();
     * try {
     *     $formattedName = $groupServiceClient->projectName('[PROJECT]');
     *     // Iterate over pages of elements
     *     $pagedResponse = $groupServiceClient->listGroups($formattedName);
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
     *     $pagedResponse = $groupServiceClient->listGroups($formattedName);
     *     foreach ($pagedResponse->iterateAllElements() as $element) {
     *         // doSomethingWith($element);
     *     }
     * } finally {
     *     $groupServiceClient->close();
     * }
     * ```
     *
     * @param string $name         The project whose groups are to be listed. The format is
     *                             `"projects/{project_id_or_number}"`.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type string $childrenOfGroup
     *          A group name: `"projects/{project_id_or_number}/groups/{group_id}"`.
     *          Returns groups whose `parentName` field contains the group
     *          name.  If no groups have this parent, the results are empty.
     *     @type string $ancestorsOfGroup
     *          A group name: `"projects/{project_id_or_number}/groups/{group_id}"`.
     *          Returns groups that are ancestors of the specified group.
     *          The groups are returned in order, starting with the immediate parent and
     *          ending with the most distant ancestor.  If the specified group has no
     *          immediate parent, the results are empty.
     *     @type string $descendantsOfGroup
     *          A group name: `"projects/{project_id_or_number}/groups/{group_id}"`.
     *          Returns the descendants of the specified group.  This is a superset of
     *          the results returned by the `childrenOfGroup` filter, and includes
     *          children-of-children, and so forth.
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
    public function listGroups($name, array $optionalArgs = [])
    {
        $request = new ListGroupsRequest();
        $request->setName($name);
        if (isset($optionalArgs['childrenOfGroup'])) {
            $request->setChildrenOfGroup($optionalArgs['childrenOfGroup']);
        }
        if (isset($optionalArgs['ancestorsOfGroup'])) {
            $request->setAncestorsOfGroup($optionalArgs['ancestorsOfGroup']);
        }
        if (isset($optionalArgs['descendantsOfGroup'])) {
            $request->setDescendantsOfGroup($optionalArgs['descendantsOfGroup']);
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
            'ListGroups',
            $optionalArgs,
            ListGroupsResponse::class,
            $request
        );
    }

    /**
     * Gets a single group.
     *
     * Sample code:
     * ```
     * $groupServiceClient = new Google\Cloud\Monitoring\V3\GroupServiceClient();
     * try {
     *     $formattedName = $groupServiceClient->groupName('[PROJECT]', '[GROUP]');
     *     $response = $groupServiceClient->getGroup($formattedName);
     * } finally {
     *     $groupServiceClient->close();
     * }
     * ```
     *
     * @param string $name         The group to retrieve. The format is
     *                             `"projects/{project_id_or_number}/groups/{group_id}"`.
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
     * @return \Google\Cloud\Monitoring\V3\Group
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function getGroup($name, array $optionalArgs = [])
    {
        $request = new GetGroupRequest();
        $request->setName($name);

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'GetGroup',
            Group::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Creates a new group.
     *
     * Sample code:
     * ```
     * $groupServiceClient = new Google\Cloud\Monitoring\V3\GroupServiceClient();
     * try {
     *     $formattedName = $groupServiceClient->projectName('[PROJECT]');
     *     $group = new Google\Cloud\Monitoring\V3\Group();
     *     $response = $groupServiceClient->createGroup($formattedName, $group);
     * } finally {
     *     $groupServiceClient->close();
     * }
     * ```
     *
     * @param string $name         The project in which to create the group. The format is
     *                             `"projects/{project_id_or_number}"`.
     * @param Group  $group        A group definition. It is an error to define the `name` field because
     *                             the system assigns the name.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type bool $validateOnly
     *          If true, validate this request but do not create the group.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Monitoring\V3\Group
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function createGroup($name, $group, array $optionalArgs = [])
    {
        $request = new CreateGroupRequest();
        $request->setName($name);
        $request->setGroup($group);
        if (isset($optionalArgs['validateOnly'])) {
            $request->setValidateOnly($optionalArgs['validateOnly']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'CreateGroup',
            Group::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Updates an existing group.
     * You can change any group attributes except `name`.
     *
     * Sample code:
     * ```
     * $groupServiceClient = new Google\Cloud\Monitoring\V3\GroupServiceClient();
     * try {
     *     $group = new Google\Cloud\Monitoring\V3\Group();
     *     $response = $groupServiceClient->updateGroup($group);
     * } finally {
     *     $groupServiceClient->close();
     * }
     * ```
     *
     * @param Group $group        The new definition of the group.  All fields of the existing group,
     *                            excepting `name`, are replaced with the corresponding fields of this group.
     * @param array $optionalArgs {
     *                            Optional.
     *
     *     @type bool $validateOnly
     *          If true, validate this request but do not update the existing group.
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Monitoring\V3\Group
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function updateGroup($group, array $optionalArgs = [])
    {
        $request = new UpdateGroupRequest();
        $request->setGroup($group);
        if (isset($optionalArgs['validateOnly'])) {
            $request->setValidateOnly($optionalArgs['validateOnly']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'group.name' => $request->getGroup()->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'UpdateGroup',
            Group::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Deletes an existing group.
     *
     * Sample code:
     * ```
     * $groupServiceClient = new Google\Cloud\Monitoring\V3\GroupServiceClient();
     * try {
     *     $formattedName = $groupServiceClient->groupName('[PROJECT]', '[GROUP]');
     *     $groupServiceClient->deleteGroup($formattedName);
     * } finally {
     *     $groupServiceClient->close();
     * }
     * ```
     *
     * @param string $name         The group to delete. The format is
     *                             `"projects/{project_id_or_number}/groups/{group_id}"`.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type bool $recursive
     *          If this field is true, then the request means to delete a group with all
     *          its descendants. Otherwise, the request means to delete a group only when
     *          it has no descendants. The default value is false.
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
    public function deleteGroup($name, array $optionalArgs = [])
    {
        $request = new DeleteGroupRequest();
        $request->setName($name);
        if (isset($optionalArgs['recursive'])) {
            $request->setRecursive($optionalArgs['recursive']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'DeleteGroup',
            GPBEmpty::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Lists the monitored resources that are members of a group.
     *
     * Sample code:
     * ```
     * $groupServiceClient = new Google\Cloud\Monitoring\V3\GroupServiceClient();
     * try {
     *     $formattedName = $groupServiceClient->groupName('[PROJECT]', '[GROUP]');
     *     // Iterate over pages of elements
     *     $pagedResponse = $groupServiceClient->listGroupMembers($formattedName);
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
     *     $pagedResponse = $groupServiceClient->listGroupMembers($formattedName);
     *     foreach ($pagedResponse->iterateAllElements() as $element) {
     *         // doSomethingWith($element);
     *     }
     * } finally {
     *     $groupServiceClient->close();
     * }
     * ```
     *
     * @param string $name         The group whose members are listed. The format is
     *                             `"projects/{project_id_or_number}/groups/{group_id}"`.
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
     *          An optional [list filter](https://cloud.google.com/monitoring/api/learn_more#filtering) describing
     *          the members to be returned.  The filter may reference the type, labels, and
     *          metadata of monitored resources that comprise the group.
     *          For example, to return only resources representing Compute Engine VM
     *          instances, use this filter:
     *
     *              resource.type = "gce_instance"
     *     @type TimeInterval $interval
     *          An optional time interval for which results should be returned. Only
     *          members that were part of the group during the specified interval are
     *          included in the response.  If no interval is provided then the group
     *          membership over the last minute is returned.
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
    public function listGroupMembers($name, array $optionalArgs = [])
    {
        $request = new ListGroupMembersRequest();
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
        if (isset($optionalArgs['interval'])) {
            $request->setInterval($optionalArgs['interval']);
        }

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->getPagedListResponse(
            'ListGroupMembers',
            $optionalArgs,
            ListGroupMembersResponse::class,
            $request
        );
    }
}

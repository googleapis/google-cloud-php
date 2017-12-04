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
 * https://github.com/google/googleapis/blob/master/google/monitoring/v3/group_service.proto
 * and updates to that file get reflected here through a refresh process.
 */

namespace Google\Cloud\Monitoring\V3\Gapic;

use Google\ApiCore\AgentHeaderDescriptor;
use Google\ApiCore\ApiCallable;
use Google\ApiCore\CallSettings;
use Google\ApiCore\GrpcCredentialsHelper;
use Google\ApiCore\PageStreamingDescriptor;
use Google\ApiCore\PathTemplate;
use Google\ApiCore\ValidationException;
use Google\Cloud\Monitoring\V3\CreateGroupRequest;
use Google\Cloud\Monitoring\V3\DeleteGroupRequest;
use Google\Cloud\Monitoring\V3\GetGroupRequest;
use Google\Cloud\Monitoring\V3\Group;
use Google\Cloud\Monitoring\V3\GroupServiceGrpcClient;
use Google\Cloud\Monitoring\V3\ListGroupMembersRequest;
use Google\Cloud\Monitoring\V3\ListGroupsRequest;
use Google\Cloud\Monitoring\V3\TimeInterval;
use Google\Cloud\Monitoring\V3\UpdateGroupRequest;
use Google\Cloud\Version;

/**
 * Service Description: The Group API lets you inspect and manage your
 * [groups](https://cloud.google.comgoogle.monitoring.v3.Group).
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
 * try {
 *     $groupServiceClient = new GroupServiceClient();
 *     $formattedName = $groupServiceClient->projectName('[PROJECT]');
 *     // Iterate through all elements
 *     $pagedResponse = $groupServiceClient->listGroups($formattedName);
 *     foreach ($pagedResponse->iterateAllElements() as $element) {
 *         // doSomethingWith($element);
 *     }
 *
 *     // OR iterate over pages of elements
 *     $pagedResponse = $groupServiceClient->listGroups($formattedName);
 *     foreach ($pagedResponse->iteratePages() as $page) {
 *         foreach ($page as $element) {
 *             // doSomethingWith($element);
 *         }
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
 */
class GroupServiceGapicClient
{
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
     * The code generator version, to be included in the agent header.
     */
    const CODEGEN_VERSION = '0.0.5';

    private static $projectNameTemplate;
    private static $groupNameTemplate;
    private static $pathTemplateMap;
    private static $gapicVersion;
    private static $gapicVersionLoaded = false;

    protected $grpcCredentialsHelper;
    protected $groupServiceStub;
    private $scopes;
    private $defaultCallSettings;
    private $descriptors;

    private static function getProjectNameTemplate()
    {
        if (self::$projectNameTemplate == null) {
            self::$projectNameTemplate = new PathTemplate('projects/{project}');
        }

        return self::$projectNameTemplate;
    }

    private static function getGroupNameTemplate()
    {
        if (self::$groupNameTemplate == null) {
            self::$groupNameTemplate = new PathTemplate('projects/{project}/groups/{group}');
        }

        return self::$groupNameTemplate;
    }

    private static function getPathTemplateMap()
    {
        if (self::$pathTemplateMap == null) {
            self::$pathTemplateMap = [
                'project' => self::getProjectNameTemplate(),
                'group' => self::getGroupNameTemplate(),
            ];
        }

        return self::$pathTemplateMap;
    }

    private static function getPageStreamingDescriptors()
    {
        $listGroupsPageStreamingDescriptor =
                new PageStreamingDescriptor([
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getGroup',
                ]);
        $listGroupMembersPageStreamingDescriptor =
                new PageStreamingDescriptor([
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getMembers',
                ]);

        $pageStreamingDescriptors = [
            'listGroups' => $listGroupsPageStreamingDescriptor,
            'listGroupMembers' => $listGroupMembersPageStreamingDescriptor,
        ];

        return $pageStreamingDescriptors;
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
     * Parses a formatted name string and returns an associative array of the components in the name.
     * The following name formats are supported:
     * Template: Pattern
     * - project: projects/{project}
     * - group: projects/{project}/groups/{group}.
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
     *     @type string $serviceAddress The domain name of the API remote host.
     *                                  Default 'monitoring.googleapis.com'.
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
     *                          Defaults to the scopes for the Stackdriver Monitoring API.
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
                'https://www.googleapis.com/auth/cloud-platform',
                'https://www.googleapis.com/auth/monitoring',
                'https://www.googleapis.com/auth/monitoring.read',
                'https://www.googleapis.com/auth/monitoring.write',
            ],
            'retryingOverride' => null,
            'libName' => null,
            'libVersion' => null,
            'clientConfigPath' => __DIR__.'/../resources/group_service_client_config.json',
        ];
        $options = array_merge($defaultOptions, $options);

        $gapicVersion = $options['libVersion'] ?: self::getGapicVersion();

        $headerDescriptor = new AgentHeaderDescriptor([
            'libName' => $options['libName'],
            'libVersion' => $options['libVersion'],
            'gapicVersion' => $gapicVersion,
        ]);

        $defaultDescriptors = ['headerDescriptor' => $headerDescriptor];
        $this->descriptors = [
            'listGroups' => $defaultDescriptors,
            'getGroup' => $defaultDescriptors,
            'createGroup' => $defaultDescriptors,
            'updateGroup' => $defaultDescriptors,
            'deleteGroup' => $defaultDescriptors,
            'listGroupMembers' => $defaultDescriptors,
        ];
        $pageStreamingDescriptors = self::getPageStreamingDescriptors();
        foreach ($pageStreamingDescriptors as $method => $pageStreamingDescriptor) {
            $this->descriptors[$method]['pageStreamingDescriptor'] = $pageStreamingDescriptor;
        }

        $clientConfigJsonString = file_get_contents($options['clientConfigPath']);
        $clientConfig = json_decode($clientConfigJsonString, true);
        $this->defaultCallSettings =
                CallSettings::load(
                    'google.monitoring.v3.GroupService',
                    $clientConfig,
                    $options['retryingOverride']
                );

        $this->scopes = $options['scopes'];

        $createStubOptions = [];
        if (array_key_exists('sslCreds', $options)) {
            $createStubOptions['sslCreds'] = $options['sslCreds'];
        }
        $this->grpcCredentialsHelper = new GrpcCredentialsHelper($options);

        $createGroupServiceStubFunction = function ($hostname, $opts, $channel) {
            return new GroupServiceGrpcClient($hostname, $opts, $channel);
        };
        if (array_key_exists('createGroupServiceStubFunction', $options)) {
            $createGroupServiceStubFunction = $options['createGroupServiceStubFunction'];
        }
        $this->groupServiceStub = $this->grpcCredentialsHelper->createStub($createGroupServiceStubFunction);
    }

    /**
     * Lists the existing groups.
     *
     * Sample code:
     * ```
     * try {
     *     $groupServiceClient = new GroupServiceClient();
     *     $formattedName = $groupServiceClient->projectName('[PROJECT]');
     *     // Iterate through all elements
     *     $pagedResponse = $groupServiceClient->listGroups($formattedName);
     *     foreach ($pagedResponse->iterateAllElements() as $element) {
     *         // doSomethingWith($element);
     *     }
     *
     *     // OR iterate over pages of elements
     *     $pagedResponse = $groupServiceClient->listGroups($formattedName);
     *     foreach ($pagedResponse->iteratePages() as $page) {
     *         foreach ($page as $element) {
     *             // doSomethingWith($element);
     *         }
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
     *     @type \Google\ApiCore\RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\ApiCore\PagedListResponse
     *
     * @throws \Google\ApiCore\ApiException if the remote call fails
     * @experimental
     */
    public function listGroups($name, $optionalArgs = [])
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

        $defaultCallSettings = $this->defaultCallSettings['listGroups'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));
        $callable = ApiCallable::createApiCall(
            $this->groupServiceStub,
            'ListGroups',
            $mergedSettings,
            $this->descriptors['listGroups']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Gets a single group.
     *
     * Sample code:
     * ```
     * try {
     *     $groupServiceClient = new GroupServiceClient();
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
     *     @type \Google\ApiCore\RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Monitoring\V3\Group
     *
     * @throws \Google\ApiCore\ApiException if the remote call fails
     * @experimental
     */
    public function getGroup($name, $optionalArgs = [])
    {
        $request = new GetGroupRequest();
        $request->setName($name);

        $defaultCallSettings = $this->defaultCallSettings['getGroup'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));
        $callable = ApiCallable::createApiCall(
            $this->groupServiceStub,
            'GetGroup',
            $mergedSettings,
            $this->descriptors['getGroup']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Creates a new group.
     *
     * Sample code:
     * ```
     * try {
     *     $groupServiceClient = new GroupServiceClient();
     *     $formattedName = $groupServiceClient->projectName('[PROJECT]');
     *     $group = new Group();
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
     *     @type \Google\ApiCore\RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Monitoring\V3\Group
     *
     * @throws \Google\ApiCore\ApiException if the remote call fails
     * @experimental
     */
    public function createGroup($name, $group, $optionalArgs = [])
    {
        $request = new CreateGroupRequest();
        $request->setName($name);
        $request->setGroup($group);
        if (isset($optionalArgs['validateOnly'])) {
            $request->setValidateOnly($optionalArgs['validateOnly']);
        }

        $defaultCallSettings = $this->defaultCallSettings['createGroup'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));
        $callable = ApiCallable::createApiCall(
            $this->groupServiceStub,
            'CreateGroup',
            $mergedSettings,
            $this->descriptors['createGroup']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Updates an existing group.
     * You can change any group attributes except `name`.
     *
     * Sample code:
     * ```
     * try {
     *     $groupServiceClient = new GroupServiceClient();
     *     $group = new Group();
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
     *     @type \Google\ApiCore\RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Cloud\Monitoring\V3\Group
     *
     * @throws \Google\ApiCore\ApiException if the remote call fails
     * @experimental
     */
    public function updateGroup($group, $optionalArgs = [])
    {
        $request = new UpdateGroupRequest();
        $request->setGroup($group);
        if (isset($optionalArgs['validateOnly'])) {
            $request->setValidateOnly($optionalArgs['validateOnly']);
        }

        $defaultCallSettings = $this->defaultCallSettings['updateGroup'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));
        $callable = ApiCallable::createApiCall(
            $this->groupServiceStub,
            'UpdateGroup',
            $mergedSettings,
            $this->descriptors['updateGroup']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Deletes an existing group.
     *
     * Sample code:
     * ```
     * try {
     *     $groupServiceClient = new GroupServiceClient();
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
    public function deleteGroup($name, $optionalArgs = [])
    {
        $request = new DeleteGroupRequest();
        $request->setName($name);

        $defaultCallSettings = $this->defaultCallSettings['deleteGroup'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));
        $callable = ApiCallable::createApiCall(
            $this->groupServiceStub,
            'DeleteGroup',
            $mergedSettings,
            $this->descriptors['deleteGroup']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Lists the monitored resources that are members of a group.
     *
     * Sample code:
     * ```
     * try {
     *     $groupServiceClient = new GroupServiceClient();
     *     $formattedName = $groupServiceClient->groupName('[PROJECT]', '[GROUP]');
     *     // Iterate through all elements
     *     $pagedResponse = $groupServiceClient->listGroupMembers($formattedName);
     *     foreach ($pagedResponse->iterateAllElements() as $element) {
     *         // doSomethingWith($element);
     *     }
     *
     *     // OR iterate over pages of elements
     *     $pagedResponse = $groupServiceClient->listGroupMembers($formattedName);
     *     foreach ($pagedResponse->iteratePages() as $page) {
     *         foreach ($page as $element) {
     *             // doSomethingWith($element);
     *         }
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
     *     @type \Google\ApiCore\RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\ApiCore\PagedListResponse
     *
     * @throws \Google\ApiCore\ApiException if the remote call fails
     * @experimental
     */
    public function listGroupMembers($name, $optionalArgs = [])
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

        $defaultCallSettings = $this->defaultCallSettings['listGroupMembers'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));
        $callable = ApiCallable::createApiCall(
            $this->groupServiceStub,
            'ListGroupMembers',
            $mergedSettings,
            $this->descriptors['listGroupMembers']
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
        $this->groupServiceStub->close();
    }

    private function createCredentialsCallback()
    {
        return $this->grpcCredentialsHelper->createCallCredentialsCallback();
    }
}

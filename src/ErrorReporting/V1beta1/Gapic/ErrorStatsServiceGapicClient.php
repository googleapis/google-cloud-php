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
 * https://github.com/google/googleapis/blob/master/google/devtools/clouderrorreporting/v1beta1/error_stats_service.proto
 * and updates to that file get reflected here through a refresh process.
 */

namespace Google\Cloud\ErrorReporting\V1beta1\Gapic;

use Google\ApiCore\AgentHeaderDescriptor;
use Google\ApiCore\ApiCallable;
use Google\ApiCore\CallSettings;
use Google\ApiCore\GrpcCredentialsHelper;
use Google\ApiCore\PageStreamingDescriptor;
use Google\ApiCore\PathTemplate;
use Google\ApiCore\ValidationException;
use Google\Cloud\ErrorReporting\V1beta1\DeleteEventsRequest;
use Google\Cloud\ErrorReporting\V1beta1\ErrorStatsServiceGrpcClient;
use Google\Cloud\ErrorReporting\V1beta1\ListEventsRequest;
use Google\Cloud\ErrorReporting\V1beta1\ListGroupStatsRequest;
use Google\Cloud\ErrorReporting\V1beta1\QueryTimeRange;
use Google\Cloud\ErrorReporting\V1beta1\ServiceContextFilter;
use Google\Cloud\Version;
use Google\Protobuf\Duration;
use Google\Protobuf\Timestamp;

/**
 * Service Description: An API for retrieving and managing error statistics as well as data for
 * individual events.
 *
 * This class provides the ability to make remote calls to the backing service through method
 * calls that map to API methods. Sample code to get started:
 *
 * ```
 * try {
 *     $errorStatsServiceClient = new ErrorStatsServiceClient();
 *     $formattedProjectName = $errorStatsServiceClient->projectName('[PROJECT]');
 *     $timeRange = new QueryTimeRange();
 *     // Iterate through all elements
 *     $pagedResponse = $errorStatsServiceClient->listGroupStats($formattedProjectName, $timeRange);
 *     foreach ($pagedResponse->iterateAllElements() as $element) {
 *         // doSomethingWith($element);
 *     }
 *
 *     // OR iterate over pages of elements
 *     $pagedResponse = $errorStatsServiceClient->listGroupStats($formattedProjectName, $timeRange);
 *     foreach ($pagedResponse->iteratePages() as $page) {
 *         foreach ($page as $element) {
 *             // doSomethingWith($element);
 *         }
 *     }
 * } finally {
 *     $errorStatsServiceClient->close();
 * }
 * ```
 *
 * Many parameters require resource names to be formatted in a particular way. To assist
 * with these names, this class includes a format method for each type of name, and additionally
 * a parseName method to extract the individual identifiers contained within formatted names
 * that are returned by the API.
 */
class ErrorStatsServiceGapicClient
{
    /**
     * The default address of the service.
     */
    const SERVICE_ADDRESS = 'clouderrorreporting.googleapis.com';

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
    private static $pathTemplateMap;
    private static $gapicVersion;
    private static $gapicVersionLoaded = false;

    protected $grpcCredentialsHelper;
    protected $errorStatsServiceStub;
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

    private static function getPathTemplateMap()
    {
        if (self::$pathTemplateMap == null) {
            self::$pathTemplateMap = [
                'project' => self::getProjectNameTemplate(),
            ];
        }

        return self::$pathTemplateMap;
    }

    private static function getPageStreamingDescriptors()
    {
        $listGroupStatsPageStreamingDescriptor =
                new PageStreamingDescriptor([
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getErrorGroupStats',
                ]);
        $listEventsPageStreamingDescriptor =
                new PageStreamingDescriptor([
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getErrorEvents',
                ]);

        $pageStreamingDescriptors = [
            'listGroupStats' => $listGroupStatsPageStreamingDescriptor,
            'listEvents' => $listEventsPageStreamingDescriptor,
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
     * Parses a formatted name string and returns an associative array of the components in the name.
     * The following name formats are supported:
     * Template: Pattern
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
     *     @type string $serviceAddress The domain name of the API remote host.
     *                                  Default 'clouderrorreporting.googleapis.com'.
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
     *                          Defaults to the scopes for the Stackdriver Error Reporting API.
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
            ],
            'retryingOverride' => null,
            'libName' => null,
            'libVersion' => null,
            'clientConfigPath' => __DIR__.'/../resources/error_stats_service_client_config.json',
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
            'listGroupStats' => $defaultDescriptors,
            'listEvents' => $defaultDescriptors,
            'deleteEvents' => $defaultDescriptors,
        ];
        $pageStreamingDescriptors = self::getPageStreamingDescriptors();
        foreach ($pageStreamingDescriptors as $method => $pageStreamingDescriptor) {
            $this->descriptors[$method]['pageStreamingDescriptor'] = $pageStreamingDescriptor;
        }

        $clientConfigJsonString = file_get_contents($options['clientConfigPath']);
        $clientConfig = json_decode($clientConfigJsonString, true);
        $this->defaultCallSettings =
                CallSettings::load(
                    'google.devtools.clouderrorreporting.v1beta1.ErrorStatsService',
                    $clientConfig,
                    $options['retryingOverride']
                );

        $this->scopes = $options['scopes'];

        $createStubOptions = [];
        if (array_key_exists('sslCreds', $options)) {
            $createStubOptions['sslCreds'] = $options['sslCreds'];
        }
        $this->grpcCredentialsHelper = new GrpcCredentialsHelper($options);

        $createErrorStatsServiceStubFunction = function ($hostname, $opts, $channel) {
            return new ErrorStatsServiceGrpcClient($hostname, $opts, $channel);
        };
        if (array_key_exists('createErrorStatsServiceStubFunction', $options)) {
            $createErrorStatsServiceStubFunction = $options['createErrorStatsServiceStubFunction'];
        }
        $this->errorStatsServiceStub = $this->grpcCredentialsHelper->createStub($createErrorStatsServiceStubFunction);
    }

    /**
     * Lists the specified groups.
     *
     * Sample code:
     * ```
     * try {
     *     $errorStatsServiceClient = new ErrorStatsServiceClient();
     *     $formattedProjectName = $errorStatsServiceClient->projectName('[PROJECT]');
     *     $timeRange = new QueryTimeRange();
     *     // Iterate through all elements
     *     $pagedResponse = $errorStatsServiceClient->listGroupStats($formattedProjectName, $timeRange);
     *     foreach ($pagedResponse->iterateAllElements() as $element) {
     *         // doSomethingWith($element);
     *     }
     *
     *     // OR iterate over pages of elements
     *     $pagedResponse = $errorStatsServiceClient->listGroupStats($formattedProjectName, $timeRange);
     *     foreach ($pagedResponse->iteratePages() as $page) {
     *         foreach ($page as $element) {
     *             // doSomethingWith($element);
     *         }
     *     }
     * } finally {
     *     $errorStatsServiceClient->close();
     * }
     * ```
     *
     * @param string $projectName [Required] The resource name of the Google Cloud Platform project. Written
     *                            as <code>projects/</code> plus the
     *                            <a href="https://support.google.com/cloud/answer/6158840">Google Cloud
     *                            Platform project ID</a>.
     *
     * Example: <code>projects/my-project-123</code>.
     * @param QueryTimeRange $timeRange    [Optional] List data for the given time range.
     *                                     If not set a default time range is used. The field time_range_begin
     *                                     in the response will specify the beginning of this time range.
     *                                     Only <code>ErrorGroupStats</code> with a non-zero count in the given time
     *                                     range are returned, unless the request contains an explicit group_id list.
     *                                     If a group_id list is given, also <code>ErrorGroupStats</code> with zero
     *                                     occurrences are returned.
     * @param array          $optionalArgs {
     *                                     Optional.
     *
     *     @type string[] $groupId
     *          [Optional] List all <code>ErrorGroupStats</code> with these IDs.
     *     @type ServiceContextFilter $serviceFilter
     *          [Optional] List only <code>ErrorGroupStats</code> which belong to a service
     *          context that matches the filter.
     *          Data for all service contexts is returned if this field is not specified.
     *     @type Duration $timedCountDuration
     *          [Optional] The preferred duration for a single returned `TimedCount`.
     *          If not set, no timed counts are returned.
     *     @type int $alignment
     *          [Optional] The alignment of the timed counts to be returned.
     *          Default is `ALIGNMENT_EQUAL_AT_END`.
     *          For allowed values, use constants defined on {@see \Google\Cloud\ErrorReporting\V1beta1\TimedCountAlignment}
     *     @type Timestamp $alignmentTime
     *          [Optional] Time where the timed counts shall be aligned if rounded
     *          alignment is chosen. Default is 00:00 UTC.
     *     @type int $order
     *          [Optional] The sort order in which the results are returned.
     *          Default is `COUNT_DESC`.
     *          For allowed values, use constants defined on {@see \Google\Cloud\ErrorReporting\V1beta1\ErrorGroupOrder}
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
    public function listGroupStats($projectName, $timeRange, $optionalArgs = [])
    {
        $request = new ListGroupStatsRequest();
        $request->setProjectName($projectName);
        $request->setTimeRange($timeRange);
        if (isset($optionalArgs['groupId'])) {
            $request->setGroupId($optionalArgs['groupId']);
        }
        if (isset($optionalArgs['serviceFilter'])) {
            $request->setServiceFilter($optionalArgs['serviceFilter']);
        }
        if (isset($optionalArgs['timedCountDuration'])) {
            $request->setTimedCountDuration($optionalArgs['timedCountDuration']);
        }
        if (isset($optionalArgs['alignment'])) {
            $request->setAlignment($optionalArgs['alignment']);
        }
        if (isset($optionalArgs['alignmentTime'])) {
            $request->setAlignmentTime($optionalArgs['alignmentTime']);
        }
        if (isset($optionalArgs['order'])) {
            $request->setOrder($optionalArgs['order']);
        }
        if (isset($optionalArgs['pageSize'])) {
            $request->setPageSize($optionalArgs['pageSize']);
        }
        if (isset($optionalArgs['pageToken'])) {
            $request->setPageToken($optionalArgs['pageToken']);
        }

        $defaultCallSettings = $this->defaultCallSettings['listGroupStats'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));
        $callable = ApiCallable::createApiCall(
            $this->errorStatsServiceStub,
            'ListGroupStats',
            $mergedSettings,
            $this->descriptors['listGroupStats']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Lists the specified events.
     *
     * Sample code:
     * ```
     * try {
     *     $errorStatsServiceClient = new ErrorStatsServiceClient();
     *     $formattedProjectName = $errorStatsServiceClient->projectName('[PROJECT]');
     *     $groupId = '';
     *     // Iterate through all elements
     *     $pagedResponse = $errorStatsServiceClient->listEvents($formattedProjectName, $groupId);
     *     foreach ($pagedResponse->iterateAllElements() as $element) {
     *         // doSomethingWith($element);
     *     }
     *
     *     // OR iterate over pages of elements
     *     $pagedResponse = $errorStatsServiceClient->listEvents($formattedProjectName, $groupId);
     *     foreach ($pagedResponse->iteratePages() as $page) {
     *         foreach ($page as $element) {
     *             // doSomethingWith($element);
     *         }
     *     }
     * } finally {
     *     $errorStatsServiceClient->close();
     * }
     * ```
     *
     * @param string $projectName  [Required] The resource name of the Google Cloud Platform project. Written
     *                             as `projects/` plus the
     *                             [Google Cloud Platform project
     *                             ID](https://support.google.com/cloud/answer/6158840).
     *                             Example: `projects/my-project-123`.
     * @param string $groupId      [Required] The group for which events shall be returned.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type ServiceContextFilter $serviceFilter
     *          [Optional] List only ErrorGroups which belong to a service context that
     *          matches the filter.
     *          Data for all service contexts is returned if this field is not specified.
     *     @type QueryTimeRange $timeRange
     *          [Optional] List only data for the given time range.
     *          If not set a default time range is used. The field time_range_begin
     *          in the response will specify the beginning of this time range.
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
    public function listEvents($projectName, $groupId, $optionalArgs = [])
    {
        $request = new ListEventsRequest();
        $request->setProjectName($projectName);
        $request->setGroupId($groupId);
        if (isset($optionalArgs['serviceFilter'])) {
            $request->setServiceFilter($optionalArgs['serviceFilter']);
        }
        if (isset($optionalArgs['timeRange'])) {
            $request->setTimeRange($optionalArgs['timeRange']);
        }
        if (isset($optionalArgs['pageSize'])) {
            $request->setPageSize($optionalArgs['pageSize']);
        }
        if (isset($optionalArgs['pageToken'])) {
            $request->setPageToken($optionalArgs['pageToken']);
        }

        $defaultCallSettings = $this->defaultCallSettings['listEvents'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));
        $callable = ApiCallable::createApiCall(
            $this->errorStatsServiceStub,
            'ListEvents',
            $mergedSettings,
            $this->descriptors['listEvents']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Deletes all error events of a given project.
     *
     * Sample code:
     * ```
     * try {
     *     $errorStatsServiceClient = new ErrorStatsServiceClient();
     *     $formattedProjectName = $errorStatsServiceClient->projectName('[PROJECT]');
     *     $response = $errorStatsServiceClient->deleteEvents($formattedProjectName);
     * } finally {
     *     $errorStatsServiceClient->close();
     * }
     * ```
     *
     * @param string $projectName  [Required] The resource name of the Google Cloud Platform project. Written
     *                             as `projects/` plus the
     *                             [Google Cloud Platform project
     *                             ID](https://support.google.com/cloud/answer/6158840).
     *                             Example: `projects/my-project-123`.
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
     * @return \Google\Cloud\ErrorReporting\V1beta1\DeleteEventsResponse
     *
     * @throws \Google\ApiCore\ApiException if the remote call fails
     * @experimental
     */
    public function deleteEvents($projectName, $optionalArgs = [])
    {
        $request = new DeleteEventsRequest();
        $request->setProjectName($projectName);

        $defaultCallSettings = $this->defaultCallSettings['deleteEvents'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));
        $callable = ApiCallable::createApiCall(
            $this->errorStatsServiceStub,
            'DeleteEvents',
            $mergedSettings,
            $this->descriptors['deleteEvents']
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
        $this->errorStatsServiceStub->close();
    }

    private function createCredentialsCallback()
    {
        return $this->grpcCredentialsHelper->createCallCredentialsCallback();
    }
}

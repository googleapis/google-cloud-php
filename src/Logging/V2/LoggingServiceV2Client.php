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
 * https://github.com/google/googleapis/blob/master/google/logging/v2/logging.proto
 * and updates to that file get reflected here through a refresh process.
 *
 * EXPERIMENTAL: this client library class has not yet been declared beta. This class may change
 * more frequently than those which have been declared beta or 1.0, including changes which break
 * backwards compatibility.
 *
 * @experimental
 */

namespace Google\Cloud\Logging\V2;

use Google\Api\MonitoredResource;
use Google\GAX\AgentHeaderDescriptor;
use Google\GAX\ApiCallable;
use Google\GAX\CallSettings;
use Google\GAX\GrpcConstants;
use Google\GAX\GrpcCredentialsHelper;
use Google\GAX\PageStreamingDescriptor;
use Google\GAX\PathTemplate;
use Google\Logging\V2\DeleteLogRequest;
use Google\Logging\V2\ListLogEntriesRequest;
use Google\Logging\V2\ListLogsRequest;
use Google\Logging\V2\ListMonitoredResourceDescriptorsRequest;
use Google\Logging\V2\LogEntry;
use Google\Logging\V2\LoggingServiceV2GrpcClient;
use Google\Logging\V2\WriteLogEntriesRequest;

/**
 * Service Description: Service for ingesting and querying logs.
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
 *     $loggingServiceV2Client = new LoggingServiceV2Client();
 *     $formattedLogName = LoggingServiceV2Client::formatLogName("[PROJECT]", "[LOG]");
 *     $loggingServiceV2Client->deleteLog($formattedLogName);
 * } finally {
 *     $loggingServiceV2Client->close();
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
class LoggingServiceV2Client
{
    /**
     * The default address of the service.
     */
    const SERVICE_ADDRESS = 'logging.googleapis.com';

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
    private static $logNameTemplate;

    private $grpcCredentialsHelper;
    private $loggingServiceV2Stub;
    private $scopes;
    private $defaultCallSettings;
    private $descriptors;

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
     * a log resource.
     *
     * @param string $project
     * @param string $log
     *
     * @return string The formatted log resource.
     * @experimental
     */
    public static function formatLogName($project, $log)
    {
        return self::getLogNameTemplate()->render([
            'project' => $project,
            'log' => $log,
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
     * represents a log resource.
     *
     * @param string $logName The fully-qualified log resource.
     *
     * @return string The extracted project value.
     * @experimental
     */
    public static function parseProjectFromLogName($logName)
    {
        return self::getLogNameTemplate()->match($logName)['project'];
    }

    /**
     * Parses the log from the given fully-qualified path which
     * represents a log resource.
     *
     * @param string $logName The fully-qualified log resource.
     *
     * @return string The extracted log value.
     * @experimental
     */
    public static function parseLogFromLogName($logName)
    {
        return self::getLogNameTemplate()->match($logName)['log'];
    }

    private static function getProjectNameTemplate()
    {
        if (self::$projectNameTemplate == null) {
            self::$projectNameTemplate = new PathTemplate('projects/{project}');
        }

        return self::$projectNameTemplate;
    }

    private static function getLogNameTemplate()
    {
        if (self::$logNameTemplate == null) {
            self::$logNameTemplate = new PathTemplate('projects/{project}/logs/{log}');
        }

        return self::$logNameTemplate;
    }

    private static function getPageStreamingDescriptors()
    {
        $listLogEntriesPageStreamingDescriptor =
                new PageStreamingDescriptor([
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getEntries',
                ]);
        $listMonitoredResourceDescriptorsPageStreamingDescriptor =
                new PageStreamingDescriptor([
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getResourceDescriptors',
                ]);
        $listLogsPageStreamingDescriptor =
                new PageStreamingDescriptor([
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getLogNames',
                ]);

        $pageStreamingDescriptors = [
            'listLogEntries' => $listLogEntriesPageStreamingDescriptor,
            'listMonitoredResourceDescriptors' => $listMonitoredResourceDescriptorsPageStreamingDescriptor,
            'listLogs' => $listLogsPageStreamingDescriptor,
        ];

        return $pageStreamingDescriptors;
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

    // TODO(garrettjones): add channel (when supported in gRPC)
    /**
     * Constructor.
     *
     * @param array $options {
     *                       Optional. Options for configuring the service API wrapper.
     *
     *     @type string $serviceAddress The domain name of the API remote host.
     *                                  Default 'logging.googleapis.com'.
     *     @type mixed $port The port on which to connect to the remote host. Default 443.
     *     @type \Grpc\ChannelCredentials $sslCreds
     *           A `ChannelCredentials` for use with an SSL-enabled channel.
     *           Default: a credentials object returned from
     *           \Grpc\ChannelCredentials::createSsl()
     *     @type array $scopes A string array of scopes to use when acquiring credentials.
     *                         Default the scopes for the Stackdriver Logging API.
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
                'https://www.googleapis.com/auth/cloud-platform.read-only',
                'https://www.googleapis.com/auth/logging.admin',
                'https://www.googleapis.com/auth/logging.read',
                'https://www.googleapis.com/auth/logging.write',
            ],
            'retryingOverride' => null,
            'timeoutMillis' => self::DEFAULT_TIMEOUT_MILLIS,
            'libName' => null,
            'libVersion' => null,
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
            'deleteLog' => $defaultDescriptors,
            'writeLogEntries' => $defaultDescriptors,
            'listLogEntries' => $defaultDescriptors,
            'listMonitoredResourceDescriptors' => $defaultDescriptors,
            'listLogs' => $defaultDescriptors,
        ];
        $pageStreamingDescriptors = self::getPageStreamingDescriptors();
        foreach ($pageStreamingDescriptors as $method => $pageStreamingDescriptor) {
            $this->descriptors[$method]['pageStreamingDescriptor'] = $pageStreamingDescriptor;
        }

        $clientConfigJsonString = file_get_contents(__DIR__.'/resources/logging_service_v2_client_config.json');
        $clientConfig = json_decode($clientConfigJsonString, true);
        $this->defaultCallSettings =
                CallSettings::load(
                    'google.logging.v2.LoggingServiceV2',
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

        $createLoggingServiceV2StubFunction = function ($hostname, $opts) {
            return new LoggingServiceV2GrpcClient($hostname, $opts);
        };
        if (array_key_exists('createLoggingServiceV2StubFunction', $options)) {
            $createLoggingServiceV2StubFunction = $options['createLoggingServiceV2StubFunction'];
        }
        $this->loggingServiceV2Stub = $this->grpcCredentialsHelper->createStub(
            $createLoggingServiceV2StubFunction,
            $options['serviceAddress'],
            $options['port'],
            $createStubOptions
        );
    }

    /**
     * Deletes all the log entries in a log.
     * The log reappears if it receives new entries.
     * Log entries written shortly before the delete operation might not be
     * deleted.
     *
     * Sample code:
     * ```
     * try {
     *     $loggingServiceV2Client = new LoggingServiceV2Client();
     *     $formattedLogName = LoggingServiceV2Client::formatLogName("[PROJECT]", "[LOG]");
     *     $loggingServiceV2Client->deleteLog($formattedLogName);
     * } finally {
     *     $loggingServiceV2Client->close();
     * }
     * ```
     *
     * @param string $logName Required. The resource name of the log to delete:
     *
     *     "projects/[PROJECT_ID]/logs/[LOG_ID]"
     *     "organizations/[ORGANIZATION_ID]/logs/[LOG_ID]"
     *     "billingAccounts/[BILLING_ACCOUNT_ID]/logs/[LOG_ID]"
     *     "folders/[FOLDER_ID]/logs/[LOG_ID]"
     *
     * `[LOG_ID]` must be URL-encoded. For example,
     * `"projects/my-project-id/logs/syslog"`,
     * `"organizations/1234567890/logs/cloudresourcemanager.googleapis.com%2Factivity"`.
     * For more information about log names, see
     * [LogEntry][google.logging.v2.LogEntry].
     * @param array $optionalArgs {
     *                            Optional.
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
    public function deleteLog($logName, $optionalArgs = [])
    {
        $request = new DeleteLogRequest();
        $request->setLogName($logName);

        $mergedSettings = $this->defaultCallSettings['deleteLog']->merge(
            new CallSettings($optionalArgs)
        );
        $callable = ApiCallable::createApiCall(
            $this->loggingServiceV2Stub,
            'DeleteLog',
            $mergedSettings,
            $this->descriptors['deleteLog']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Writes log entries to Stackdriver Logging.
     *
     * Sample code:
     * ```
     * try {
     *     $loggingServiceV2Client = new LoggingServiceV2Client();
     *     $entries = [];
     *     $response = $loggingServiceV2Client->writeLogEntries($entries);
     * } finally {
     *     $loggingServiceV2Client->close();
     * }
     * ```
     *
     * @param LogEntry[] $entries Required.  The log entries to write. Values supplied for the fields
     *                            `log_name`, `resource`, and `labels` in this `entries.write` request are
     *                            inserted into those log entries in this list that do not provide their own
     *                            values.
     *
     * Stackdriver Logging also creates and inserts values for `timestamp` and
     * `insert_id` if the entries do not provide them. The created `insert_id` for
     * the N'th entry in this list will be greater than earlier entries and less
     * than later entries.  Otherwise, the order of log entries in this list does
     * not matter.
     *
     * To improve throughput and to avoid exceeding the
     * [quota limit](https://cloud.google.com/logging/quota-policy) for calls to `entries.write`,
     * you should write multiple log entries at once rather than
     * calling this method for each individual log entry.
     * @param array $optionalArgs {
     *                            Optional.
     *
     *     @type string $logName
     *          Optional. A default log resource name that is assigned to all log entries
     *          in `entries` that do not specify a value for `log_name`:
     *
     *              "projects/[PROJECT_ID]/logs/[LOG_ID]"
     *              "organizations/[ORGANIZATION_ID]/logs/[LOG_ID]"
     *              "billingAccounts/[BILLING_ACCOUNT_ID]/logs/[LOG_ID]"
     *              "folders/[FOLDER_ID]/logs/[LOG_ID]"
     *
     *          `[LOG_ID]` must be URL-encoded. For example,
     *          `"projects/my-project-id/logs/syslog"` or
     *          `"organizations/1234567890/logs/cloudresourcemanager.googleapis.com%2Factivity"`.
     *          For more information about log names, see
     *          [LogEntry][google.logging.v2.LogEntry].
     *     @type MonitoredResource $resource
     *          Optional. A default monitored resource object that is assigned to all log
     *          entries in `entries` that do not specify a value for `resource`. Example:
     *
     *              { "type": "gce_instance",
     *                "labels": {
     *                  "zone": "us-central1-a", "instance_id": "00000000000000000000" }}
     *
     *          See [LogEntry][google.logging.v2.LogEntry].
     *     @type array $labels
     *          Optional. Default labels that are added to the `labels` field of all log
     *          entries in `entries`. If a log entry already has a label with the same key
     *          as a label in this parameter, then the log entry's label is not changed.
     *          See [LogEntry][google.logging.v2.LogEntry].
     *     @type bool $partialSuccess
     *          Optional. Whether valid entries should be written even if some other
     *          entries fail due to INVALID_ARGUMENT or PERMISSION_DENIED errors. If any
     *          entry is not written, then the response status is the error associated
     *          with one of the failed entries and the response includes error details
     *          keyed by the entries' zero-based index in the `entries.write` method.
     *     @type \Google\GAX\RetrySettings $retrySettings
     *          Retry settings to use for this call. If present, then
     *          $timeoutMillis is ignored.
     *     @type int $timeoutMillis
     *          Timeout to use for this call. Only used if $retrySettings
     *          is not set.
     * }
     *
     * @return \Google\Logging\V2\WriteLogEntriesResponse
     *
     * @throws \Google\GAX\ApiException if the remote call fails
     * @experimental
     */
    public function writeLogEntries($entries, $optionalArgs = [])
    {
        $request = new WriteLogEntriesRequest();
        $request->setEntries($entries);
        if (isset($optionalArgs['logName'])) {
            $request->setLogName($optionalArgs['logName']);
        }
        if (isset($optionalArgs['resource'])) {
            $request->setResource($optionalArgs['resource']);
        }
        if (isset($optionalArgs['labels'])) {
            $request->setLabels($optionalArgs['labels']);
        }
        if (isset($optionalArgs['partialSuccess'])) {
            $request->setPartialSuccess($optionalArgs['partialSuccess']);
        }

        $mergedSettings = $this->defaultCallSettings['writeLogEntries']->merge(
            new CallSettings($optionalArgs)
        );
        $callable = ApiCallable::createApiCall(
            $this->loggingServiceV2Stub,
            'WriteLogEntries',
            $mergedSettings,
            $this->descriptors['writeLogEntries']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Lists log entries.  Use this method to retrieve log entries from
     * Stackdriver Logging.  For ways to export log entries, see
     * [Exporting Logs](https://cloud.google.com/logging/docs/export).
     *
     * Sample code:
     * ```
     * try {
     *     $loggingServiceV2Client = new LoggingServiceV2Client();
     *     $resourceNames = [];
     *     // Iterate through all elements
     *     $pagedResponse = $loggingServiceV2Client->listLogEntries($resourceNames);
     *     foreach ($pagedResponse->iterateAllElements() as $element) {
     *         // doSomethingWith($element);
     *     }
     *
     *     // OR iterate over pages of elements, with the maximum page size set to 5
     *     $pagedResponse = $loggingServiceV2Client->listLogEntries($resourceNames, ['pageSize' => 5]);
     *     foreach ($pagedResponse->iteratePages() as $page) {
     *         foreach ($page as $element) {
     *             // doSomethingWith($element);
     *         }
     *     }
     * } finally {
     *     $loggingServiceV2Client->close();
     * }
     * ```
     *
     * @param string[] $resourceNames Required. Names of one or more parent resources from which to
     *                                retrieve log entries:
     *
     *     "projects/[PROJECT_ID]"
     *     "organizations/[ORGANIZATION_ID]"
     *     "billingAccounts/[BILLING_ACCOUNT_ID]"
     *     "folders/[FOLDER_ID]"
     *
     * Projects listed in the `project_ids` field are added to this list.
     * @param array $optionalArgs {
     *                            Optional.
     *
     *     @type string[] $projectIds
     *          Deprecated. Use `resource_names` instead.  One or more project identifiers
     *          or project numbers from which to retrieve log entries.  Example:
     *          `"my-project-1A"`. If present, these project identifiers are converted to
     *          resource name format and added to the list of resources in
     *          `resource_names`.
     *     @type string $filter
     *          Optional. A filter that chooses which log entries to return.  See [Advanced
     *          Logs Filters](https://cloud.google.com/logging/docs/view/advanced_filters).  Only log entries that
     *          match the filter are returned.  An empty filter matches all log entries in
     *          the resources listed in `resource_names`. Referencing a parent resource
     *          that is not listed in `resource_names` will cause the filter to return no
     *          results.
     *          The maximum length of the filter is 20000 characters.
     *     @type string $orderBy
     *          Optional. How the results should be sorted.  Presently, the only permitted
     *          values are `"timestamp asc"` (default) and `"timestamp desc"`. The first
     *          option returns entries in order of increasing values of
     *          `LogEntry.timestamp` (oldest first), and the second option returns entries
     *          in order of decreasing timestamps (newest first).  Entries with equal
     *          timestamps are returned in order of their `insert_id` values.
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
    public function listLogEntries($resourceNames, $optionalArgs = [])
    {
        $request = new ListLogEntriesRequest();
        $request->setResourceNames($resourceNames);
        if (isset($optionalArgs['projectIds'])) {
            $request->setProjectIds($optionalArgs['projectIds']);
        }
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

        $mergedSettings = $this->defaultCallSettings['listLogEntries']->merge(
            new CallSettings($optionalArgs)
        );
        $callable = ApiCallable::createApiCall(
            $this->loggingServiceV2Stub,
            'ListLogEntries',
            $mergedSettings,
            $this->descriptors['listLogEntries']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Lists the descriptors for monitored resource types used by Stackdriver
     * Logging.
     *
     * Sample code:
     * ```
     * try {
     *     $loggingServiceV2Client = new LoggingServiceV2Client();
     *
     *     // Iterate through all elements
     *     $pagedResponse = $loggingServiceV2Client->listMonitoredResourceDescriptors();
     *     foreach ($pagedResponse->iterateAllElements() as $element) {
     *         // doSomethingWith($element);
     *     }
     *
     *     // OR iterate over pages of elements, with the maximum page size set to 5
     *     $pagedResponse = $loggingServiceV2Client->listMonitoredResourceDescriptors(['pageSize' => 5]);
     *     foreach ($pagedResponse->iteratePages() as $page) {
     *         foreach ($page as $element) {
     *             // doSomethingWith($element);
     *         }
     *     }
     * } finally {
     *     $loggingServiceV2Client->close();
     * }
     * ```
     *
     * @param array $optionalArgs {
     *                            Optional.
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
    public function listMonitoredResourceDescriptors($optionalArgs = [])
    {
        $request = new ListMonitoredResourceDescriptorsRequest();
        if (isset($optionalArgs['pageSize'])) {
            $request->setPageSize($optionalArgs['pageSize']);
        }
        if (isset($optionalArgs['pageToken'])) {
            $request->setPageToken($optionalArgs['pageToken']);
        }

        $mergedSettings = $this->defaultCallSettings['listMonitoredResourceDescriptors']->merge(
            new CallSettings($optionalArgs)
        );
        $callable = ApiCallable::createApiCall(
            $this->loggingServiceV2Stub,
            'ListMonitoredResourceDescriptors',
            $mergedSettings,
            $this->descriptors['listMonitoredResourceDescriptors']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Lists the logs in projects, organizations, folders, or billing accounts.
     * Only logs that have entries are listed.
     *
     * Sample code:
     * ```
     * try {
     *     $loggingServiceV2Client = new LoggingServiceV2Client();
     *     $formattedParent = LoggingServiceV2Client::formatProjectName("[PROJECT]");
     *     // Iterate through all elements
     *     $pagedResponse = $loggingServiceV2Client->listLogs($formattedParent);
     *     foreach ($pagedResponse->iterateAllElements() as $element) {
     *         // doSomethingWith($element);
     *     }
     *
     *     // OR iterate over pages of elements, with the maximum page size set to 5
     *     $pagedResponse = $loggingServiceV2Client->listLogs($formattedParent, ['pageSize' => 5]);
     *     foreach ($pagedResponse->iteratePages() as $page) {
     *         foreach ($page as $element) {
     *             // doSomethingWith($element);
     *         }
     *     }
     * } finally {
     *     $loggingServiceV2Client->close();
     * }
     * ```
     *
     * @param string $parent Required. The resource name that owns the logs:
     *
     *     "projects/[PROJECT_ID]"
     *     "organizations/[ORGANIZATION_ID]"
     *     "billingAccounts/[BILLING_ACCOUNT_ID]"
     *     "folders/[FOLDER_ID]"
     * @param array $optionalArgs {
     *                            Optional.
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
    public function listLogs($parent, $optionalArgs = [])
    {
        $request = new ListLogsRequest();
        $request->setParent($parent);
        if (isset($optionalArgs['pageSize'])) {
            $request->setPageSize($optionalArgs['pageSize']);
        }
        if (isset($optionalArgs['pageToken'])) {
            $request->setPageToken($optionalArgs['pageToken']);
        }

        $mergedSettings = $this->defaultCallSettings['listLogs']->merge(
            new CallSettings($optionalArgs)
        );
        $callable = ApiCallable::createApiCall(
            $this->loggingServiceV2Stub,
            'ListLogs',
            $mergedSettings,
            $this->descriptors['listLogs']
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
        $this->loggingServiceV2Stub->close();
    }

    private function createCredentialsCallback()
    {
        return $this->grpcCredentialsHelper->createCallCredentialsCallback();
    }
}

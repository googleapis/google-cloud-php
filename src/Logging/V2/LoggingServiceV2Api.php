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
 * https://github.com/google/googleapis/blob/master/google/logging/v2/logging.proto
 * and updates to that file get reflected here through a refresh process.
 */

namespace Google\Cloud\Logging\V2;

use Google\GAX\AgentHeaderDescriptor;
use Google\GAX\ApiCallable;
use Google\GAX\CallSettings;
use Google\GAX\GrpcConstants;
use Google\GAX\GrpcCredentialsHelper;
use Google\GAX\PageStreamingDescriptor;
use Google\GAX\PathTemplate;
use google\api\MonitoredResource;
use google\logging\v2\DeleteLogRequest;
use google\logging\v2\ListLogEntriesRequest;
use google\logging\v2\ListMonitoredResourceDescriptorsRequest;
use google\logging\v2\LogEntry;
use google\logging\v2\LoggingServiceV2Client;
use google\logging\v2\WriteLogEntriesRequest;
use google\logging\v2\WriteLogEntriesRequest\LabelsEntry;

/**
 * Service Description: Service for ingesting and querying logs.
 *
 * This class provides the ability to make remote calls to the backing service through method
 * calls that map to API methods. Sample code to get started:
 *
 * ```
 * try {
 *     $loggingServiceV2Api = new LoggingServiceV2Api();
 *     $formattedLogName = LoggingServiceV2Api::formatLogName("[PROJECT]", "[LOG]");
 *     $loggingServiceV2Api->deleteLog($formattedLogName);
 * } finally {
 *     if (isset($loggingServiceV2Api)) {
 *         $loggingServiceV2Api->close();
 *     }
 * }
 * ```
 *
 * Many parameters require resource names to be formatted in a particular way. To assist
 * with these names, this class includes a format method for each type of name, and additionally
 * a parse method to extract the individual identifiers contained within names that are
 * returned.
 */
class LoggingServiceV2Api
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

    const _GAX_VERSION = '0.1.0';
    const _CODEGEN_NAME = 'GAPIC';
    const _CODEGEN_VERSION = '0.0.0';

    private static $projectNameTemplate;
    private static $logNameTemplate;

    private $grpcCredentialsHelper;
    private $stub;
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
     * a log resource.
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
     */
    public static function parseProjectFromProjectName($projectName)
    {
        return self::getProjectNameTemplate()->match($projectName)['project'];
    }

    /**
     * Parses the project from the given fully-qualified path which
     * represents a log resource.
     */
    public static function parseProjectFromLogName($logName)
    {
        return self::getLogNameTemplate()->match($logName)['project'];
    }

    /**
     * Parses the log from the given fully-qualified path which
     * represents a log resource.
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
                    'requestPageTokenField' => 'page_token',
                    'responsePageTokenField' => 'next_page_token',
                    'resourceField' => 'entries',
                ]);
        $listMonitoredResourceDescriptorsPageStreamingDescriptor =
                new PageStreamingDescriptor([
                    'requestPageTokenField' => 'page_token',
                    'responsePageTokenField' => 'next_page_token',
                    'resourceField' => 'resource_descriptors',
                ]);

        $pageStreamingDescriptors = [
            'listLogEntries' => $listLogEntriesPageStreamingDescriptor,
            'listMonitoredResourceDescriptors' => $listMonitoredResourceDescriptorsPageStreamingDescriptor,
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
     *                                  Default 'logging.googleapis.com'.
     *     @type mixed $port The port on which to connect to the remote host. Default 443.
     *     @type Grpc\ChannelCredentials $sslCreds
     *           A `ChannelCredentials` for use with an SSL-enabled channel.
     *           Default: a credentials object returned from
     *           Grpc\ChannelCredentials::createSsl()
     *     @type array $scopes A string array of scopes to use when acquiring credentials.
     *                         Default the scopes for the Google Cloud Logging API.
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
            'https://www.googleapis.com/auth/cloud-platform.read-only',
            'https://www.googleapis.com/auth/logging.admin',
            'https://www.googleapis.com/auth/logging.read',
            'https://www.googleapis.com/auth/logging.write',
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
            'deleteLog' => $defaultDescriptors,
            'writeLogEntries' => $defaultDescriptors,
            'listLogEntries' => $defaultDescriptors,
            'listMonitoredResourceDescriptors' => $defaultDescriptors,
        ];
        $pageStreamingDescriptors = self::getPageStreamingDescriptors();
        foreach ($pageStreamingDescriptors as $method => $pageStreamingDescriptor) {
            $this->descriptors[$method]['pageStreamingDescriptor'] = $pageStreamingDescriptor;
        }

        // TODO load the client config in a more package-friendly way
        // https://github.com/googleapis/toolkit/issues/332
        $clientConfigJsonString = file_get_contents(__DIR__ . '/resources/logging_service_v2_client_config.json');
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

        $generatedCreateStub = function ($hostname, $opts) {
            return new LoggingServiceV2Client($hostname, $opts);
        };
        $createStubOptions = [];
        if (!empty($options['sslCreds'])) {
            $createStubOptions['sslCreds'] = $options['sslCreds'];
        }
        $grpcCredentialsHelperOptions = array_diff_key($options, $defaultOptions);
        $this->grpcCredentialsHelper = new GrpcCredentialsHelper($this->scopes, $grpcCredentialsHelperOptions);
        $this->stub = $this->grpcCredentialsHelper->createStub(
            $generatedCreateStub,
            $options['serviceAddress'],
            $options['port'],
            $createStubOptions
        );
    }

    /**
     * Deletes a log and all its log entries.
     * The log will reappear if it receives new entries.
     *
     * Sample code:
     * ```
     * try {
     *     $loggingServiceV2Api = new LoggingServiceV2Api();
     *     $formattedLogName = LoggingServiceV2Api::formatLogName("[PROJECT]", "[LOG]");
     *     $loggingServiceV2Api->deleteLog($formattedLogName);
     * } finally {
     *     if (isset($loggingServiceV2Api)) {
     *         $loggingServiceV2Api->close();
     *     }
     * }
     * ```
     *
     * @param string $logName      Required. The resource name of the log to delete.  Example:
     *                             `"projects/my-project/logs/syslog"`.
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
    public function deleteLog($logName, $optionalArgs = [])
    {
        $request = new DeleteLogRequest();
        $request->setLogName($logName);

        $mergedSettings = $this->defaultCallSettings['deleteLog']->merge(
            new CallSettings($optionalArgs)
        );
        $callable = ApiCallable::createApiCall(
            $this->stub,
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
     * Writes log entries to Stackdriver Logging.  All log entries are
     * written by this method.
     *
     * Sample code:
     * ```
     * try {
     *     $loggingServiceV2Api = new LoggingServiceV2Api();
     *     $entries = [];
     *     $response = $loggingServiceV2Api->writeLogEntries($entries);
     * } finally {
     *     if (isset($loggingServiceV2Api)) {
     *         $loggingServiceV2Api->close();
     *     }
     * }
     * ```
     *
     * @param LogEntry[] $entries Required. The log entries to write. The log entries must have values for
     *                            all required fields.
     *
     * To improve throughput and to avoid exceeding the quota limit for calls
     * to `entries.write`, use this field to write multiple log entries at once
     * rather than  // calling this method for each log entry.
     * @param array $optionalArgs {
     *                            Optional.
     *
     *     @type string $logName
     *          Optional. A default log resource name for those log entries in `entries`
     *          that do not specify their own `logName`.  Example:
     *          `"projects/my-project/logs/syslog"`.  See
     *          [LogEntry][google.logging.v2.LogEntry].
     *     @type MonitoredResource $resource
     *          Optional. A default monitored resource for those log entries in `entries`
     *          that do not specify their own `resource`.
     *     @type array $labels
     *          Optional. User-defined `key:value` items that are added to
     *          the `labels` field of each log entry in `entries`, except when a log
     *          entry specifies its own `key:value` item with the same key.
     *          Example: `{ "size": "large", "color":"red" }`
     *     @type bool $partialSuccess
     *          Optional. Whether valid entries should be written even if some other
     *          entries fail due to INVALID_ARGUMENT or PERMISSION_DENIED errors. If any
     *          entry is not written, the response status will be the error associated
     *          with one of the failed entries and include error details in the form of
     *          WriteLogEntriesPartialErrors.
     *     @type Google\GAX\RetrySettings $retrySettings
     *          Retry settings to use for this call. If present, then
     *          $timeoutMillis is ignored.
     *     @type int $timeoutMillis
     *          Timeout to use for this call. Only used if $retrySettings
     *          is not set.
     * }
     *
     * @return google\logging\v2\WriteLogEntriesResponse
     *
     * @throws Google\GAX\ApiException if the remote call fails
     */
    public function writeLogEntries($entries, $optionalArgs = [])
    {
        $request = new WriteLogEntriesRequest();
        foreach ($entries as $elem) {
            $request->addEntries($elem);
        }
        if (isset($optionalArgs['logName'])) {
            $request->setLogName($optionalArgs['logName']);
        }
        if (isset($optionalArgs['resource'])) {
            $request->setResource($optionalArgs['resource']);
        }
        if (isset($optionalArgs['labels'])) {
            foreach ($optionalArgs['labels'] as $key => $value) {
                $request->addLabels((new LabelsEntry())->setKey($key)->setValue($value));
            }
        }
        if (isset($optionalArgs['partialSuccess'])) {
            $request->setPartialSuccess($optionalArgs['partialSuccess']);
        }

        $mergedSettings = $this->defaultCallSettings['writeLogEntries']->merge(
            new CallSettings($optionalArgs)
        );
        $callable = ApiCallable::createApiCall(
            $this->stub,
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
     * Lists log entries.  Use this method to retrieve log entries from Cloud
     * Logging.  For ways to export log entries, see
     * [Exporting Logs](/logging/docs/export).
     *
     * Sample code:
     * ```
     * try {
     *     $loggingServiceV2Api = new LoggingServiceV2Api();
     *     $projectIds = [];
     *     foreach ($loggingServiceV2Api->listLogEntries($projectIds) as $element) {
     *         // doThingsWith(element);
     *     }
     * } finally {
     *     if (isset($loggingServiceV2Api)) {
     *         $loggingServiceV2Api->close();
     *     }
     * }
     * ```
     *
     * @param string[] $projectIds   Required. One or more project IDs or project numbers from which to retrieve
     *                               log entries.  Examples of a project ID: `"my-project-1A"`, `"1234567890"`.
     * @param array    $optionalArgs {
     *                               Optional.
     *
     *     @type string $filter
     *          Optional. An [advanced logs filter](/logging/docs/view/advanced_filters).
     *          The filter is compared against all log entries in the projects specified by
     *          `projectIds`.  Only entries that match the filter are retrieved.  An empty
     *          filter matches all log entries.
     *     @type string $orderBy
     *          Optional. How the results should be sorted.  Presently, the only permitted
     *          values are `"timestamp asc"` (default) and `"timestamp desc"`. The first
     *          option returns entries in order of increasing values of
     *          `LogEntry.timestamp` (oldest first), and the second option returns entries
     *          in order of decreasing timestamps (newest first).  Entries with equal
     *          timestamps are returned in order of `LogEntry.insertId`.
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
    public function listLogEntries($projectIds, $optionalArgs = [])
    {
        $request = new ListLogEntriesRequest();
        foreach ($projectIds as $elem) {
            $request->addProjectIds($elem);
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
            $this->stub,
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
     * Lists the monitored resource descriptors used by Stackdriver Logging.
     *
     * Sample code:
     * ```
     * try {
     *     $loggingServiceV2Api = new LoggingServiceV2Api();
     *
     *     foreach ($loggingServiceV2Api->listMonitoredResourceDescriptors() as $element) {
     *         // doThingsWith(element);
     *     }
     * } finally {
     *     if (isset($loggingServiceV2Api)) {
     *         $loggingServiceV2Api->close();
     *     }
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
            $this->stub,
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
     * Initiates an orderly shutdown in which preexisting calls continue but new
     * calls are immediately cancelled.
     */
    public function close()
    {
        $this->stub->close();
    }

    private function createCredentialsCallback()
    {
        return $this->grpcCredentialsHelper->createCallCredentialsCallback();
    }
}

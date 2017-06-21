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
 * https://github.com/google/googleapis/blob/master/google/logging/v2/logging_metrics.proto
 * and updates to that file get reflected here through a refresh process.
 *
 * EXPERIMENTAL: this client library class has not yet been declared beta. This class may change
 * more frequently than those which have been declared beta or 1.0, including changes which break
 * backwards compatibility.
 *
 * @experimental
 */

namespace Google\Cloud\Logging\V2;

use Google\GAX\AgentHeaderDescriptor;
use Google\GAX\ApiCallable;
use Google\GAX\CallSettings;
use Google\GAX\GrpcConstants;
use Google\GAX\GrpcCredentialsHelper;
use Google\GAX\PageStreamingDescriptor;
use Google\GAX\PathTemplate;
use Google\Logging\V2\CreateLogMetricRequest;
use Google\Logging\V2\DeleteLogMetricRequest;
use Google\Logging\V2\GetLogMetricRequest;
use Google\Logging\V2\ListLogMetricsRequest;
use Google\Logging\V2\LogMetric;
use Google\Logging\V2\MetricsServiceV2GrpcClient;
use Google\Logging\V2\UpdateLogMetricRequest;

/**
 * Service Description: Service for configuring logs-based metrics.
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
 *     $metricsServiceV2Client = new MetricsServiceV2Client();
 *     $formattedParent = MetricsServiceV2Client::formatProjectName("[PROJECT]");
 *     // Iterate through all elements
 *     $pagedResponse = $metricsServiceV2Client->listLogMetrics($formattedParent);
 *     foreach ($pagedResponse->iterateAllElements() as $element) {
 *         // doSomethingWith($element);
 *     }
 *
 *     // OR iterate over pages of elements, with the maximum page size set to 5
 *     $pagedResponse = $metricsServiceV2Client->listLogMetrics($formattedParent, ['pageSize' => 5]);
 *     foreach ($pagedResponse->iteratePages() as $page) {
 *         foreach ($page as $element) {
 *             // doSomethingWith($element);
 *         }
 *     }
 * } finally {
 *     $metricsServiceV2Client->close();
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
class MetricsServiceV2Client
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
    private static $metricNameTemplate;

    private $grpcCredentialsHelper;
    private $metricsServiceV2Stub;
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
     * a metric resource.
     *
     * @param string $project
     * @param string $metric
     *
     * @return string The formatted metric resource.
     * @experimental
     */
    public static function formatMetricName($project, $metric)
    {
        return self::getMetricNameTemplate()->render([
            'project' => $project,
            'metric' => $metric,
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
     * represents a metric resource.
     *
     * @param string $metricName The fully-qualified metric resource.
     *
     * @return string The extracted project value.
     * @experimental
     */
    public static function parseProjectFromMetricName($metricName)
    {
        return self::getMetricNameTemplate()->match($metricName)['project'];
    }

    /**
     * Parses the metric from the given fully-qualified path which
     * represents a metric resource.
     *
     * @param string $metricName The fully-qualified metric resource.
     *
     * @return string The extracted metric value.
     * @experimental
     */
    public static function parseMetricFromMetricName($metricName)
    {
        return self::getMetricNameTemplate()->match($metricName)['metric'];
    }

    private static function getProjectNameTemplate()
    {
        if (self::$projectNameTemplate == null) {
            self::$projectNameTemplate = new PathTemplate('projects/{project}');
        }

        return self::$projectNameTemplate;
    }

    private static function getMetricNameTemplate()
    {
        if (self::$metricNameTemplate == null) {
            self::$metricNameTemplate = new PathTemplate('projects/{project}/metrics/{metric}');
        }

        return self::$metricNameTemplate;
    }

    private static function getPageStreamingDescriptors()
    {
        $listLogMetricsPageStreamingDescriptor =
                new PageStreamingDescriptor([
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getMetrics',
                ]);

        $pageStreamingDescriptors = [
            'listLogMetrics' => $listLogMetricsPageStreamingDescriptor,
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
            'listLogMetrics' => $defaultDescriptors,
            'getLogMetric' => $defaultDescriptors,
            'createLogMetric' => $defaultDescriptors,
            'updateLogMetric' => $defaultDescriptors,
            'deleteLogMetric' => $defaultDescriptors,
        ];
        $pageStreamingDescriptors = self::getPageStreamingDescriptors();
        foreach ($pageStreamingDescriptors as $method => $pageStreamingDescriptor) {
            $this->descriptors[$method]['pageStreamingDescriptor'] = $pageStreamingDescriptor;
        }

        $clientConfigJsonString = file_get_contents(__DIR__.'/resources/metrics_service_v2_client_config.json');
        $clientConfig = json_decode($clientConfigJsonString, true);
        $this->defaultCallSettings =
                CallSettings::load(
                    'google.logging.v2.MetricsServiceV2',
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

        $createMetricsServiceV2StubFunction = function ($hostname, $opts) {
            return new MetricsServiceV2GrpcClient($hostname, $opts);
        };
        if (array_key_exists('createMetricsServiceV2StubFunction', $options)) {
            $createMetricsServiceV2StubFunction = $options['createMetricsServiceV2StubFunction'];
        }
        $this->metricsServiceV2Stub = $this->grpcCredentialsHelper->createStub(
            $createMetricsServiceV2StubFunction,
            $options['serviceAddress'],
            $options['port'],
            $createStubOptions
        );
    }

    /**
     * Lists logs-based metrics.
     *
     * Sample code:
     * ```
     * try {
     *     $metricsServiceV2Client = new MetricsServiceV2Client();
     *     $formattedParent = MetricsServiceV2Client::formatProjectName("[PROJECT]");
     *     // Iterate through all elements
     *     $pagedResponse = $metricsServiceV2Client->listLogMetrics($formattedParent);
     *     foreach ($pagedResponse->iterateAllElements() as $element) {
     *         // doSomethingWith($element);
     *     }
     *
     *     // OR iterate over pages of elements, with the maximum page size set to 5
     *     $pagedResponse = $metricsServiceV2Client->listLogMetrics($formattedParent, ['pageSize' => 5]);
     *     foreach ($pagedResponse->iteratePages() as $page) {
     *         foreach ($page as $element) {
     *             // doSomethingWith($element);
     *         }
     *     }
     * } finally {
     *     $metricsServiceV2Client->close();
     * }
     * ```
     *
     * @param string $parent Required. The name of the project containing the metrics:
     *
     *     "projects/[PROJECT_ID]"
     * @param array $optionalArgs {
     *                            Optional.
     *
     *     @type string $pageToken
     *          A page token is used to specify a page of values to be returned.
     *          If no page token is specified (the default), the first page
     *          of values will be returned. Any page token used here must have
     *          been generated by a previous call to the API.
     *     @type int $pageSize
     *          The maximum number of resources contained in the underlying API
     *          response. The API may return fewer values in a page, even if
     *          there are additional values to be retrieved.
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
    public function listLogMetrics($parent, $optionalArgs = [])
    {
        $request = new ListLogMetricsRequest();
        $request->setParent($parent);
        if (isset($optionalArgs['pageToken'])) {
            $request->setPageToken($optionalArgs['pageToken']);
        }
        if (isset($optionalArgs['pageSize'])) {
            $request->setPageSize($optionalArgs['pageSize']);
        }

        $mergedSettings = $this->defaultCallSettings['listLogMetrics']->merge(
            new CallSettings($optionalArgs)
        );
        $callable = ApiCallable::createApiCall(
            $this->metricsServiceV2Stub,
            'ListLogMetrics',
            $mergedSettings,
            $this->descriptors['listLogMetrics']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Gets a logs-based metric.
     *
     * Sample code:
     * ```
     * try {
     *     $metricsServiceV2Client = new MetricsServiceV2Client();
     *     $formattedMetricName = MetricsServiceV2Client::formatMetricName("[PROJECT]", "[METRIC]");
     *     $response = $metricsServiceV2Client->getLogMetric($formattedMetricName);
     * } finally {
     *     $metricsServiceV2Client->close();
     * }
     * ```
     *
     * @param string $metricName The resource name of the desired metric:
     *
     *     "projects/[PROJECT_ID]/metrics/[METRIC_ID]"
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
     * @return \Google\Logging\V2\LogMetric
     *
     * @throws \Google\GAX\ApiException if the remote call fails
     * @experimental
     */
    public function getLogMetric($metricName, $optionalArgs = [])
    {
        $request = new GetLogMetricRequest();
        $request->setMetricName($metricName);

        $mergedSettings = $this->defaultCallSettings['getLogMetric']->merge(
            new CallSettings($optionalArgs)
        );
        $callable = ApiCallable::createApiCall(
            $this->metricsServiceV2Stub,
            'GetLogMetric',
            $mergedSettings,
            $this->descriptors['getLogMetric']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Creates a logs-based metric.
     *
     * Sample code:
     * ```
     * try {
     *     $metricsServiceV2Client = new MetricsServiceV2Client();
     *     $formattedParent = MetricsServiceV2Client::formatProjectName("[PROJECT]");
     *     $metric = new LogMetric();
     *     $response = $metricsServiceV2Client->createLogMetric($formattedParent, $metric);
     * } finally {
     *     $metricsServiceV2Client->close();
     * }
     * ```
     *
     * @param string $parent The resource name of the project in which to create the metric:
     *
     *     "projects/[PROJECT_ID]"
     *
     * The new metric must be provided in the request.
     * @param LogMetric $metric       The new logs-based metric, which must not have an identifier that
     *                                already exists.
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
     * @return \Google\Logging\V2\LogMetric
     *
     * @throws \Google\GAX\ApiException if the remote call fails
     * @experimental
     */
    public function createLogMetric($parent, $metric, $optionalArgs = [])
    {
        $request = new CreateLogMetricRequest();
        $request->setParent($parent);
        $request->setMetric($metric);

        $mergedSettings = $this->defaultCallSettings['createLogMetric']->merge(
            new CallSettings($optionalArgs)
        );
        $callable = ApiCallable::createApiCall(
            $this->metricsServiceV2Stub,
            'CreateLogMetric',
            $mergedSettings,
            $this->descriptors['createLogMetric']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Creates or updates a logs-based metric.
     *
     * Sample code:
     * ```
     * try {
     *     $metricsServiceV2Client = new MetricsServiceV2Client();
     *     $formattedMetricName = MetricsServiceV2Client::formatMetricName("[PROJECT]", "[METRIC]");
     *     $metric = new LogMetric();
     *     $response = $metricsServiceV2Client->updateLogMetric($formattedMetricName, $metric);
     * } finally {
     *     $metricsServiceV2Client->close();
     * }
     * ```
     *
     * @param string $metricName The resource name of the metric to update:
     *
     *     "projects/[PROJECT_ID]/metrics/[METRIC_ID]"
     *
     * The updated metric must be provided in the request and it's
     * `name` field must be the same as `[METRIC_ID]` If the metric
     * does not exist in `[PROJECT_ID]`, then a new metric is created.
     * @param LogMetric $metric       The updated metric.
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
     * @return \Google\Logging\V2\LogMetric
     *
     * @throws \Google\GAX\ApiException if the remote call fails
     * @experimental
     */
    public function updateLogMetric($metricName, $metric, $optionalArgs = [])
    {
        $request = new UpdateLogMetricRequest();
        $request->setMetricName($metricName);
        $request->setMetric($metric);

        $mergedSettings = $this->defaultCallSettings['updateLogMetric']->merge(
            new CallSettings($optionalArgs)
        );
        $callable = ApiCallable::createApiCall(
            $this->metricsServiceV2Stub,
            'UpdateLogMetric',
            $mergedSettings,
            $this->descriptors['updateLogMetric']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Deletes a logs-based metric.
     *
     * Sample code:
     * ```
     * try {
     *     $metricsServiceV2Client = new MetricsServiceV2Client();
     *     $formattedMetricName = MetricsServiceV2Client::formatMetricName("[PROJECT]", "[METRIC]");
     *     $metricsServiceV2Client->deleteLogMetric($formattedMetricName);
     * } finally {
     *     $metricsServiceV2Client->close();
     * }
     * ```
     *
     * @param string $metricName The resource name of the metric to delete:
     *
     *     "projects/[PROJECT_ID]/metrics/[METRIC_ID]"
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
    public function deleteLogMetric($metricName, $optionalArgs = [])
    {
        $request = new DeleteLogMetricRequest();
        $request->setMetricName($metricName);

        $mergedSettings = $this->defaultCallSettings['deleteLogMetric']->merge(
            new CallSettings($optionalArgs)
        );
        $callable = ApiCallable::createApiCall(
            $this->metricsServiceV2Stub,
            'DeleteLogMetric',
            $mergedSettings,
            $this->descriptors['deleteLogMetric']
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
        $this->metricsServiceV2Stub->close();
    }

    private function createCredentialsCallback()
    {
        return $this->grpcCredentialsHelper->createCallCredentialsCallback();
    }
}

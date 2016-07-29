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
 * https://github.com/google/googleapis/blob/master/google/logging/v2/logging_metrics.proto
 * and updates to that file get reflected here through a refresh process.
 */

namespace Google\Cloud\Toolkit\Logging\V2;

use Google\GAX\AgentHeaderDescriptor;
use Google\GAX\ApiCallable;
use Google\GAX\CallSettings;
use Google\GAX\GrpcBootstrap;
use Google\GAX\GrpcConstants;
use Google\GAX\PageStreamingDescriptor;
use Google\GAX\PathTemplate;
use google\logging\v2\CreateLogMetricRequest;
use google\logging\v2\DeleteLogMetricRequest;
use google\logging\v2\GetLogMetricRequest;
use google\logging\v2\ListLogMetricsRequest;
use google\logging\v2\LogMetric;
use google\logging\v2\MetricsServiceV2Client;
use google\logging\v2\UpdateLogMetricRequest;

/**
 * Service Description: Service for configuring logs-based metrics.
 *
 * This class provides the ability to make remote calls to the backing service through method
 * calls that map to API methods. Sample code to get started:
 *
 * ```
 * try {
 *     $metricsServiceV2Api = new MetricsServiceV2Api();
 *     $formattedParent = MetricsServiceV2Api::formatProjectName("[PROJECT]");
 *     foreach ($metricsServiceV2Api->listLogMetrics($formattedParent) as $element) {
 *         // doThingsWith(element);
 *     }
 * } finally {
 *     if (isset($metricsServiceV2Api)) {
 *         $metricsServiceV2Api->close();
 *     }
 * }
 * ```
 *
 * Many parameters require resource names to be formatted in a particular way. To assist
 * with these names, this class includes a format method for each type of name, and additionally
 * a parse method to extract the individual identifiers contained within names that are
 * returned.
 */
class MetricsServiceV2Api
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
    private static $metricNameTemplate;

    private $grpcBootstrap;
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
     * a metric resource.
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
     */
    public static function parseProjectFromProjectName($projectName)
    {
        return self::getProjectNameTemplate()->match($projectName)['project'];
    }

    /**
     * Parses the project from the given fully-qualified path which
     * represents a metric resource.
     */
    public static function parseProjectFromMetricName($metricName)
    {
        return self::getMetricNameTemplate()->match($metricName)['project'];
    }

    /**
     * Parses the metric from the given fully-qualified path which
     * represents a metric resource.
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
                    'requestPageTokenField' => 'page_token',
                    'responsePageTokenField' => 'next_page_token',
                    'resourceField' => 'metrics',
                ]);

        $pageStreamingDescriptors = [
            'listLogMetrics' => $listLogMetricsPageStreamingDescriptor,
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
     *     @var string $serviceAddress The domain name of the API remote host.
     *                                  Default 'logging.googleapis.com'.
     *     @var mixed $port The port on which to connect to the remote host. Default 443.
     *     @var Grpc\ChannelCredentials $sslCreds
     *           A `ChannelCredentials` for use with an SSL-enabled channel.
     *           Default: a credentials object returned from
     *           Grpc\ChannelCredentials::createSsl()
     *     @var array $scopes A string array of scopes to use when acquiring credentials.
     *                         Default the scopes for the Google Cloud Logging API.
     *     @var array $retryingOverride
     *           An associative array of string => RetryOptions, where the keys
     *           are method names (e.g. 'createFoo'), that overrides default retrying
     *           settings. A value of null indicates that the method in question should
     *           not retry.
     *     @var int $timeoutMillis The timeout in milliseconds to use for calls
     *                              that don't use retries. For calls that use retries,
     *                              set the timeout in RetryOptions.
     *                              Default: 30000 (30 seconds)
     *     @var string $appName The codename of the calling service. Default 'gax'.
     *     @var string $appVersion The version of the calling service.
     *                              Default: the current version of GAX.
     *     @var Google\Auth\CredentialsLoader $credentialsLoader
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

        // TODO load the client config in a more package-friendly way
        // https://github.com/googleapis/toolkit/issues/332
        $clientConfigJsonString = file_get_contents('./resources/metrics_service_v2_client_config.json');
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

        $generatedCreateStub = function ($hostname, $opts) {
            return new MetricsServiceV2Client($hostname, $opts);
        };
        $createStubOptions = [];
        if (!empty($options['sslCreds'])) {
            $createStubOptions['sslCreds'] = $options['sslCreds'];
        }
        $grpcBootstrapOptions = array_intersect_key($options, [
            'credentialsLoader' => null,
        ]);
        $this->grpcBootstrap = new GrpcBootstrap($this->scopes, $grpcBootstrapOptions);
        $this->stub = $this->grpcBootstrap->createStub(
            $generatedCreateStub,
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
     *     $metricsServiceV2Api = new MetricsServiceV2Api();
     *     $formattedParent = MetricsServiceV2Api::formatProjectName("[PROJECT]");
     *     foreach ($metricsServiceV2Api->listLogMetrics($formattedParent) as $element) {
     *         // doThingsWith(element);
     *     }
     * } finally {
     *     if (isset($metricsServiceV2Api)) {
     *         $metricsServiceV2Api->close();
     *     }
     * }
     * ```
     *
     * @param string $parent       Required. The resource name containing the metrics.
     *                             Example: `"projects/my-project-id"`.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @var string $pageToken
     *          A page token is used to specify a page of values to be returned.
     *          If no page token is specified (the default), the first page
     *          of values will be returned. Any page token used here must have
     *          been generated by a previous call to the API.
     *     @var int $pageSize
     *          The maximum number of resources contained in the underlying API
     *          response. The API may return fewer values in a page, even if
     *          there are additional values to be retrieved.
     *     @var Google\GAX\RetrySettings $retrySettings
     *          Retry settings to use for this call. If present, then
     *          $timeoutMillis is ignored.
     *     @var int $timeoutMillis
     *          Timeout to use for this call. Only used if $retrySettings
     *          is not set.
     * }
     *
     * @return Google\GAX\PagedListResponse
     *
     * @throws Google\GAX\ApiException if the remote call fails
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
            $this->stub,
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
     *     $metricsServiceV2Api = new MetricsServiceV2Api();
     *     $formattedMetricName = MetricsServiceV2Api::formatMetricName("[PROJECT]", "[METRIC]");
     *     $response = $metricsServiceV2Api->getLogMetric($formattedMetricName);
     * } finally {
     *     if (isset($metricsServiceV2Api)) {
     *         $metricsServiceV2Api->close();
     *     }
     * }
     * ```
     *
     * @param string $metricName   The resource name of the desired metric.
     *                             Example: `"projects/my-project-id/metrics/my-metric-id"`.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @var Google\GAX\RetrySettings $retrySettings
     *          Retry settings to use for this call. If present, then
     *          $timeoutMillis is ignored.
     *     @var int $timeoutMillis
     *          Timeout to use for this call. Only used if $retrySettings
     *          is not set.
     * }
     *
     * @return google\logging\v2\LogMetric
     *
     * @throws Google\GAX\ApiException if the remote call fails
     */
    public function getLogMetric($metricName, $optionalArgs = [])
    {
        $request = new GetLogMetricRequest();
        $request->setMetricName($metricName);

        $mergedSettings = $this->defaultCallSettings['getLogMetric']->merge(
            new CallSettings($optionalArgs)
        );
        $callable = ApiCallable::createApiCall(
            $this->stub,
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
     *     $metricsServiceV2Api = new MetricsServiceV2Api();
     *     $formattedParent = MetricsServiceV2Api::formatProjectName("[PROJECT]");
     *     $metric = new LogMetric();
     *     $response = $metricsServiceV2Api->createLogMetric($formattedParent, $metric);
     * } finally {
     *     if (isset($metricsServiceV2Api)) {
     *         $metricsServiceV2Api->close();
     *     }
     * }
     * ```
     *
     * @param string $parent The resource name of the project in which to create the metric.
     *                       Example: `"projects/my-project-id"`.
     *
     * The new metric must be provided in the request.
     * @param LogMetric $metric       The new logs-based metric, which must not have an identifier that
     *                                already exists.
     * @param array     $optionalArgs {
     *                                Optional.
     *
     *     @var Google\GAX\RetrySettings $retrySettings
     *          Retry settings to use for this call. If present, then
     *          $timeoutMillis is ignored.
     *     @var int $timeoutMillis
     *          Timeout to use for this call. Only used if $retrySettings
     *          is not set.
     * }
     *
     * @return google\logging\v2\LogMetric
     *
     * @throws Google\GAX\ApiException if the remote call fails
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
            $this->stub,
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
     *     $metricsServiceV2Api = new MetricsServiceV2Api();
     *     $formattedMetricName = MetricsServiceV2Api::formatMetricName("[PROJECT]", "[METRIC]");
     *     $metric = new LogMetric();
     *     $response = $metricsServiceV2Api->updateLogMetric($formattedMetricName, $metric);
     * } finally {
     *     if (isset($metricsServiceV2Api)) {
     *         $metricsServiceV2Api->close();
     *     }
     * }
     * ```
     *
     * @param string $metricName The resource name of the metric to update.
     *                           Example: `"projects/my-project-id/metrics/my-metric-id"`.
     *
     * The updated metric must be provided in the request and have the
     * same identifier that is specified in `metricName`.
     * If the metric does not exist, it is created.
     * @param LogMetric $metric       The updated metric, whose name must be the same as the
     *                                metric identifier in `metricName`. If `metricName` does not
     *                                exist, then a new metric is created.
     * @param array     $optionalArgs {
     *                                Optional.
     *
     *     @var Google\GAX\RetrySettings $retrySettings
     *          Retry settings to use for this call. If present, then
     *          $timeoutMillis is ignored.
     *     @var int $timeoutMillis
     *          Timeout to use for this call. Only used if $retrySettings
     *          is not set.
     * }
     *
     * @return google\logging\v2\LogMetric
     *
     * @throws Google\GAX\ApiException if the remote call fails
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
            $this->stub,
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
     *     $metricsServiceV2Api = new MetricsServiceV2Api();
     *     $formattedMetricName = MetricsServiceV2Api::formatMetricName("[PROJECT]", "[METRIC]");
     *     $metricsServiceV2Api->deleteLogMetric($formattedMetricName);
     * } finally {
     *     if (isset($metricsServiceV2Api)) {
     *         $metricsServiceV2Api->close();
     *     }
     * }
     * ```
     *
     * @param string $metricName   The resource name of the metric to delete.
     *                             Example: `"projects/my-project-id/metrics/my-metric-id"`.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @var Google\GAX\RetrySettings $retrySettings
     *          Retry settings to use for this call. If present, then
     *          $timeoutMillis is ignored.
     *     @var int $timeoutMillis
     *          Timeout to use for this call. Only used if $retrySettings
     *          is not set.
     * }
     *
     * @throws Google\GAX\ApiException if the remote call fails
     */
    public function deleteLogMetric($metricName, $optionalArgs = [])
    {
        $request = new DeleteLogMetricRequest();
        $request->setMetricName($metricName);

        $mergedSettings = $this->defaultCallSettings['deleteLogMetric']->merge(
            new CallSettings($optionalArgs)
        );
        $callable = ApiCallable::createApiCall(
            $this->stub,
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
     */
    public function close()
    {
        $this->stub->close();
    }

    private function createCredentialsCallback()
    {
        return $this->grpcBootstrap->createCallCredentialsCallback();
    }
}

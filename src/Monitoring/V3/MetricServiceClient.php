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
 * https://github.com/google/googleapis/blob/master/google/monitoring/v3/metric_service.proto
 * and updates to that file get reflected here through a refresh process.
 *
 * EXPERIMENTAL: this client library class has not yet been declared beta. This class may change
 * more frequently than those which have been declared beta or 1.0, including changes which break
 * backwards compatibility.
 *
 * @experimental
 */

namespace Google\Cloud\Monitoring\V3;

use Google\Api\MetricDescriptor;
use Google\GAX\AgentHeaderDescriptor;
use Google\GAX\ApiCallable;
use Google\GAX\CallSettings;
use Google\GAX\GrpcConstants;
use Google\GAX\GrpcCredentialsHelper;
use Google\GAX\PageStreamingDescriptor;
use Google\GAX\PathTemplate;
use Google\Monitoring\V3\Aggregation;
use Google\Monitoring\V3\CreateMetricDescriptorRequest;
use Google\Monitoring\V3\CreateTimeSeriesRequest;
use Google\Monitoring\V3\DeleteMetricDescriptorRequest;
use Google\Monitoring\V3\GetMetricDescriptorRequest;
use Google\Monitoring\V3\GetMonitoredResourceDescriptorRequest;
use Google\Monitoring\V3\ListMetricDescriptorsRequest;
use Google\Monitoring\V3\ListMonitoredResourceDescriptorsRequest;
use Google\Monitoring\V3\ListTimeSeriesRequest;
use Google\Monitoring\V3\ListTimeSeriesRequest_TimeSeriesView as TimeSeriesView;
use Google\Monitoring\V3\MetricServiceGrpcClient;
use Google\Monitoring\V3\TimeInterval;
use Google\Monitoring\V3\TimeSeries;

/**
 * Service Description: Manages metric descriptors, monitored resource descriptors, and
 * time series data.
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
 *     $metricServiceClient = new MetricServiceClient();
 *     $formattedName = MetricServiceClient::formatProjectName("[PROJECT]");
 *     // Iterate through all elements
 *     $pagedResponse = $metricServiceClient->listMonitoredResourceDescriptors($formattedName);
 *     foreach ($pagedResponse->iterateAllElements() as $element) {
 *         // doSomethingWith($element);
 *     }
 *
 *     // OR iterate over pages of elements, with the maximum page size set to 5
 *     $pagedResponse = $metricServiceClient->listMonitoredResourceDescriptors($formattedName, ['pageSize' => 5]);
 *     foreach ($pagedResponse->iteratePages() as $page) {
 *         foreach ($page as $element) {
 *             // doSomethingWith($element);
 *         }
 *     }
 * } finally {
 *     $metricServiceClient->close();
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
class MetricServiceClient
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
    private static $metricDescriptorNameTemplate;
    private static $monitoredResourceDescriptorNameTemplate;

    private $grpcCredentialsHelper;
    private $metricServiceStub;
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
     * a metric_descriptor resource.
     *
     * @param string $project
     * @param string $metricDescriptor
     *
     * @return string The formatted metric_descriptor resource.
     * @experimental
     */
    public static function formatMetricDescriptorName($project, $metricDescriptor)
    {
        return self::getMetricDescriptorNameTemplate()->render([
            'project' => $project,
            'metric_descriptor' => $metricDescriptor,
        ]);
    }

    /**
     * Formats a string containing the fully-qualified path to represent
     * a monitored_resource_descriptor resource.
     *
     * @param string $project
     * @param string $monitoredResourceDescriptor
     *
     * @return string The formatted monitored_resource_descriptor resource.
     * @experimental
     */
    public static function formatMonitoredResourceDescriptorName($project, $monitoredResourceDescriptor)
    {
        return self::getMonitoredResourceDescriptorNameTemplate()->render([
            'project' => $project,
            'monitored_resource_descriptor' => $monitoredResourceDescriptor,
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
     * represents a metric_descriptor resource.
     *
     * @param string $metricDescriptorName The fully-qualified metric_descriptor resource.
     *
     * @return string The extracted project value.
     * @experimental
     */
    public static function parseProjectFromMetricDescriptorName($metricDescriptorName)
    {
        return self::getMetricDescriptorNameTemplate()->match($metricDescriptorName)['project'];
    }

    /**
     * Parses the metric_descriptor from the given fully-qualified path which
     * represents a metric_descriptor resource.
     *
     * @param string $metricDescriptorName The fully-qualified metric_descriptor resource.
     *
     * @return string The extracted metric_descriptor value.
     * @experimental
     */
    public static function parseMetricDescriptorFromMetricDescriptorName($metricDescriptorName)
    {
        return self::getMetricDescriptorNameTemplate()->match($metricDescriptorName)['metric_descriptor'];
    }

    /**
     * Parses the project from the given fully-qualified path which
     * represents a monitored_resource_descriptor resource.
     *
     * @param string $monitoredResourceDescriptorName The fully-qualified monitored_resource_descriptor resource.
     *
     * @return string The extracted project value.
     * @experimental
     */
    public static function parseProjectFromMonitoredResourceDescriptorName($monitoredResourceDescriptorName)
    {
        return self::getMonitoredResourceDescriptorNameTemplate()->match($monitoredResourceDescriptorName)['project'];
    }

    /**
     * Parses the monitored_resource_descriptor from the given fully-qualified path which
     * represents a monitored_resource_descriptor resource.
     *
     * @param string $monitoredResourceDescriptorName The fully-qualified monitored_resource_descriptor resource.
     *
     * @return string The extracted monitored_resource_descriptor value.
     * @experimental
     */
    public static function parseMonitoredResourceDescriptorFromMonitoredResourceDescriptorName($monitoredResourceDescriptorName)
    {
        return self::getMonitoredResourceDescriptorNameTemplate()->match($monitoredResourceDescriptorName)['monitored_resource_descriptor'];
    }

    private static function getProjectNameTemplate()
    {
        if (self::$projectNameTemplate == null) {
            self::$projectNameTemplate = new PathTemplate('projects/{project}');
        }

        return self::$projectNameTemplate;
    }

    private static function getMetricDescriptorNameTemplate()
    {
        if (self::$metricDescriptorNameTemplate == null) {
            self::$metricDescriptorNameTemplate = new PathTemplate('projects/{project}/metricDescriptors/{metric_descriptor=**}');
        }

        return self::$metricDescriptorNameTemplate;
    }

    private static function getMonitoredResourceDescriptorNameTemplate()
    {
        if (self::$monitoredResourceDescriptorNameTemplate == null) {
            self::$monitoredResourceDescriptorNameTemplate = new PathTemplate('projects/{project}/monitoredResourceDescriptors/{monitored_resource_descriptor}');
        }

        return self::$monitoredResourceDescriptorNameTemplate;
    }

    private static function getPageStreamingDescriptors()
    {
        $listMonitoredResourceDescriptorsPageStreamingDescriptor =
                new PageStreamingDescriptor([
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getResourceDescriptors',
                ]);
        $listMetricDescriptorsPageStreamingDescriptor =
                new PageStreamingDescriptor([
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getMetricDescriptors',
                ]);
        $listTimeSeriesPageStreamingDescriptor =
                new PageStreamingDescriptor([
                    'requestPageTokenGetMethod' => 'getPageToken',
                    'requestPageTokenSetMethod' => 'setPageToken',
                    'requestPageSizeGetMethod' => 'getPageSize',
                    'requestPageSizeSetMethod' => 'setPageSize',
                    'responsePageTokenGetMethod' => 'getNextPageToken',
                    'resourcesGetMethod' => 'getTimeSeries',
                ]);

        $pageStreamingDescriptors = [
            'listMonitoredResourceDescriptors' => $listMonitoredResourceDescriptorsPageStreamingDescriptor,
            'listMetricDescriptors' => $listMetricDescriptorsPageStreamingDescriptor,
            'listTimeSeries' => $listTimeSeriesPageStreamingDescriptor,
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
     *                                  Default 'monitoring.googleapis.com'.
     *     @type mixed $port The port on which to connect to the remote host. Default 443.
     *     @type \Grpc\ChannelCredentials $sslCreds
     *           A `ChannelCredentials` for use with an SSL-enabled channel.
     *           Default: a credentials object returned from
     *           \Grpc\ChannelCredentials::createSsl()
     *     @type array $scopes A string array of scopes to use when acquiring credentials.
     *                         Default the scopes for the Stackdriver Monitoring API.
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
                'https://www.googleapis.com/auth/monitoring',
                'https://www.googleapis.com/auth/monitoring.read',
                'https://www.googleapis.com/auth/monitoring.write',
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
            'listMonitoredResourceDescriptors' => $defaultDescriptors,
            'getMonitoredResourceDescriptor' => $defaultDescriptors,
            'listMetricDescriptors' => $defaultDescriptors,
            'getMetricDescriptor' => $defaultDescriptors,
            'createMetricDescriptor' => $defaultDescriptors,
            'deleteMetricDescriptor' => $defaultDescriptors,
            'listTimeSeries' => $defaultDescriptors,
            'createTimeSeries' => $defaultDescriptors,
        ];
        $pageStreamingDescriptors = self::getPageStreamingDescriptors();
        foreach ($pageStreamingDescriptors as $method => $pageStreamingDescriptor) {
            $this->descriptors[$method]['pageStreamingDescriptor'] = $pageStreamingDescriptor;
        }

        $clientConfigJsonString = file_get_contents(__DIR__.'/resources/metric_service_client_config.json');
        $clientConfig = json_decode($clientConfigJsonString, true);
        $this->defaultCallSettings =
                CallSettings::load(
                    'google.monitoring.v3.MetricService',
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

        $createMetricServiceStubFunction = function ($hostname, $opts) {
            return new MetricServiceGrpcClient($hostname, $opts);
        };
        if (array_key_exists('createMetricServiceStubFunction', $options)) {
            $createMetricServiceStubFunction = $options['createMetricServiceStubFunction'];
        }
        $this->metricServiceStub = $this->grpcCredentialsHelper->createStub(
            $createMetricServiceStubFunction,
            $options['serviceAddress'],
            $options['port'],
            $createStubOptions
        );
    }

    /**
     * Lists monitored resource descriptors that match a filter. This method does not require a Stackdriver account.
     *
     * Sample code:
     * ```
     * try {
     *     $metricServiceClient = new MetricServiceClient();
     *     $formattedName = MetricServiceClient::formatProjectName("[PROJECT]");
     *     // Iterate through all elements
     *     $pagedResponse = $metricServiceClient->listMonitoredResourceDescriptors($formattedName);
     *     foreach ($pagedResponse->iterateAllElements() as $element) {
     *         // doSomethingWith($element);
     *     }
     *
     *     // OR iterate over pages of elements, with the maximum page size set to 5
     *     $pagedResponse = $metricServiceClient->listMonitoredResourceDescriptors($formattedName, ['pageSize' => 5]);
     *     foreach ($pagedResponse->iteratePages() as $page) {
     *         foreach ($page as $element) {
     *             // doSomethingWith($element);
     *         }
     *     }
     * } finally {
     *     $metricServiceClient->close();
     * }
     * ```
     *
     * @param string $name         The project on which to execute the request. The format is
     *                             `"projects/{project_id_or_number}"`.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type string $filter
     *          An optional [filter](https://cloud.google.com/monitoring/api/v3/filters) describing
     *          the descriptors to be returned.  The filter can reference
     *          the descriptor's type and labels. For example, the
     *          following filter returns only Google Compute Engine descriptors
     *          that have an `id` label:
     *
     *              resource.type = starts_with("gce_") AND resource.label:id
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
    public function listMonitoredResourceDescriptors($name, $optionalArgs = [])
    {
        $request = new ListMonitoredResourceDescriptorsRequest();
        $request->setName($name);
        if (isset($optionalArgs['filter'])) {
            $request->setFilter($optionalArgs['filter']);
        }
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
            $this->metricServiceStub,
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
     * Gets a single monitored resource descriptor. This method does not require a Stackdriver account.
     *
     * Sample code:
     * ```
     * try {
     *     $metricServiceClient = new MetricServiceClient();
     *     $formattedName = MetricServiceClient::formatMonitoredResourceDescriptorName("[PROJECT]", "[MONITORED_RESOURCE_DESCRIPTOR]");
     *     $response = $metricServiceClient->getMonitoredResourceDescriptor($formattedName);
     * } finally {
     *     $metricServiceClient->close();
     * }
     * ```
     *
     * @param string $name         The monitored resource descriptor to get.  The format is
     *                             `"projects/{project_id_or_number}/monitoredResourceDescriptors/{resource_type}"`.
     *                             The `{resource_type}` is a predefined type, such as
     *                             `cloudsql_database`.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type \Google\GAX\RetrySettings $retrySettings
     *          Retry settings to use for this call. If present, then
     *          $timeoutMillis is ignored.
     *     @type int $timeoutMillis
     *          Timeout to use for this call. Only used if $retrySettings
     *          is not set.
     * }
     *
     * @return \Google\Api\MonitoredResourceDescriptor
     *
     * @throws \Google\GAX\ApiException if the remote call fails
     * @experimental
     */
    public function getMonitoredResourceDescriptor($name, $optionalArgs = [])
    {
        $request = new GetMonitoredResourceDescriptorRequest();
        $request->setName($name);

        $mergedSettings = $this->defaultCallSettings['getMonitoredResourceDescriptor']->merge(
            new CallSettings($optionalArgs)
        );
        $callable = ApiCallable::createApiCall(
            $this->metricServiceStub,
            'GetMonitoredResourceDescriptor',
            $mergedSettings,
            $this->descriptors['getMonitoredResourceDescriptor']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Lists metric descriptors that match a filter. This method does not require a Stackdriver account.
     *
     * Sample code:
     * ```
     * try {
     *     $metricServiceClient = new MetricServiceClient();
     *     $formattedName = MetricServiceClient::formatProjectName("[PROJECT]");
     *     // Iterate through all elements
     *     $pagedResponse = $metricServiceClient->listMetricDescriptors($formattedName);
     *     foreach ($pagedResponse->iterateAllElements() as $element) {
     *         // doSomethingWith($element);
     *     }
     *
     *     // OR iterate over pages of elements, with the maximum page size set to 5
     *     $pagedResponse = $metricServiceClient->listMetricDescriptors($formattedName, ['pageSize' => 5]);
     *     foreach ($pagedResponse->iteratePages() as $page) {
     *         foreach ($page as $element) {
     *             // doSomethingWith($element);
     *         }
     *     }
     * } finally {
     *     $metricServiceClient->close();
     * }
     * ```
     *
     * @param string $name         The project on which to execute the request. The format is
     *                             `"projects/{project_id_or_number}"`.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type string $filter
     *          If this field is empty, all custom and
     *          system-defined metric descriptors are returned.
     *          Otherwise, the [filter](https://cloud.google.com/monitoring/api/v3/filters)
     *          specifies which metric descriptors are to be
     *          returned. For example, the following filter matches all
     *          [custom metrics](https://cloud.google.com/monitoring/custom-metrics):
     *
     *              metric.type = starts_with("custom.googleapis.com/")
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
    public function listMetricDescriptors($name, $optionalArgs = [])
    {
        $request = new ListMetricDescriptorsRequest();
        $request->setName($name);
        if (isset($optionalArgs['filter'])) {
            $request->setFilter($optionalArgs['filter']);
        }
        if (isset($optionalArgs['pageSize'])) {
            $request->setPageSize($optionalArgs['pageSize']);
        }
        if (isset($optionalArgs['pageToken'])) {
            $request->setPageToken($optionalArgs['pageToken']);
        }

        $mergedSettings = $this->defaultCallSettings['listMetricDescriptors']->merge(
            new CallSettings($optionalArgs)
        );
        $callable = ApiCallable::createApiCall(
            $this->metricServiceStub,
            'ListMetricDescriptors',
            $mergedSettings,
            $this->descriptors['listMetricDescriptors']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Gets a single metric descriptor. This method does not require a Stackdriver account.
     *
     * Sample code:
     * ```
     * try {
     *     $metricServiceClient = new MetricServiceClient();
     *     $formattedName = MetricServiceClient::formatMetricDescriptorName("[PROJECT]", "[METRIC_DESCRIPTOR]");
     *     $response = $metricServiceClient->getMetricDescriptor($formattedName);
     * } finally {
     *     $metricServiceClient->close();
     * }
     * ```
     *
     * @param string $name         The metric descriptor on which to execute the request. The format is
     *                             `"projects/{project_id_or_number}/metricDescriptors/{metric_id}"`.
     *                             An example value of `{metric_id}` is
     *                             `"compute.googleapis.com/instance/disk/read_bytes_count"`.
     * @param array  $optionalArgs {
     *                             Optional.
     *
     *     @type \Google\GAX\RetrySettings $retrySettings
     *          Retry settings to use for this call. If present, then
     *          $timeoutMillis is ignored.
     *     @type int $timeoutMillis
     *          Timeout to use for this call. Only used if $retrySettings
     *          is not set.
     * }
     *
     * @return \Google\Api\MetricDescriptor
     *
     * @throws \Google\GAX\ApiException if the remote call fails
     * @experimental
     */
    public function getMetricDescriptor($name, $optionalArgs = [])
    {
        $request = new GetMetricDescriptorRequest();
        $request->setName($name);

        $mergedSettings = $this->defaultCallSettings['getMetricDescriptor']->merge(
            new CallSettings($optionalArgs)
        );
        $callable = ApiCallable::createApiCall(
            $this->metricServiceStub,
            'GetMetricDescriptor',
            $mergedSettings,
            $this->descriptors['getMetricDescriptor']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Creates a new metric descriptor.
     * User-created metric descriptors define
     * [custom metrics](https://cloud.google.com/monitoring/custom-metrics).
     *
     * Sample code:
     * ```
     * try {
     *     $metricServiceClient = new MetricServiceClient();
     *     $formattedName = MetricServiceClient::formatProjectName("[PROJECT]");
     *     $metricDescriptor = new MetricDescriptor();
     *     $response = $metricServiceClient->createMetricDescriptor($formattedName, $metricDescriptor);
     * } finally {
     *     $metricServiceClient->close();
     * }
     * ```
     *
     * @param string           $name             The project on which to execute the request. The format is
     *                                           `"projects/{project_id_or_number}"`.
     * @param MetricDescriptor $metricDescriptor The new [custom metric](https://cloud.google.com/monitoring/custom-metrics)
     *                                           descriptor.
     * @param array            $optionalArgs     {
     *                                           Optional.
     *
     *     @type \Google\GAX\RetrySettings $retrySettings
     *          Retry settings to use for this call. If present, then
     *          $timeoutMillis is ignored.
     *     @type int $timeoutMillis
     *          Timeout to use for this call. Only used if $retrySettings
     *          is not set.
     * }
     *
     * @return \Google\Api\MetricDescriptor
     *
     * @throws \Google\GAX\ApiException if the remote call fails
     * @experimental
     */
    public function createMetricDescriptor($name, $metricDescriptor, $optionalArgs = [])
    {
        $request = new CreateMetricDescriptorRequest();
        $request->setName($name);
        $request->setMetricDescriptor($metricDescriptor);

        $mergedSettings = $this->defaultCallSettings['createMetricDescriptor']->merge(
            new CallSettings($optionalArgs)
        );
        $callable = ApiCallable::createApiCall(
            $this->metricServiceStub,
            'CreateMetricDescriptor',
            $mergedSettings,
            $this->descriptors['createMetricDescriptor']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Deletes a metric descriptor. Only user-created
     * [custom metrics](https://cloud.google.com/monitoring/custom-metrics) can be deleted.
     *
     * Sample code:
     * ```
     * try {
     *     $metricServiceClient = new MetricServiceClient();
     *     $formattedName = MetricServiceClient::formatMetricDescriptorName("[PROJECT]", "[METRIC_DESCRIPTOR]");
     *     $metricServiceClient->deleteMetricDescriptor($formattedName);
     * } finally {
     *     $metricServiceClient->close();
     * }
     * ```
     *
     * @param string $name         The metric descriptor on which to execute the request. The format is
     *                             `"projects/{project_id_or_number}/metricDescriptors/{metric_id}"`.
     *                             An example of `{metric_id}` is:
     *                             `"custom.googleapis.com/my_test_metric"`.
     * @param array  $optionalArgs {
     *                             Optional.
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
    public function deleteMetricDescriptor($name, $optionalArgs = [])
    {
        $request = new DeleteMetricDescriptorRequest();
        $request->setName($name);

        $mergedSettings = $this->defaultCallSettings['deleteMetricDescriptor']->merge(
            new CallSettings($optionalArgs)
        );
        $callable = ApiCallable::createApiCall(
            $this->metricServiceStub,
            'DeleteMetricDescriptor',
            $mergedSettings,
            $this->descriptors['deleteMetricDescriptor']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Lists time series that match a filter. This method does not require a Stackdriver account.
     *
     * Sample code:
     * ```
     * try {
     *     $metricServiceClient = new MetricServiceClient();
     *     $formattedName = MetricServiceClient::formatProjectName("[PROJECT]");
     *     $filter = "";
     *     $interval = new TimeInterval();
     *     $view = TimeSeriesView::FULL;
     *     // Iterate through all elements
     *     $pagedResponse = $metricServiceClient->listTimeSeries($formattedName, $filter, $interval, $view);
     *     foreach ($pagedResponse->iterateAllElements() as $element) {
     *         // doSomethingWith($element);
     *     }
     *
     *     // OR iterate over pages of elements, with the maximum page size set to 5
     *     $pagedResponse = $metricServiceClient->listTimeSeries($formattedName, $filter, $interval, $view, ['pageSize' => 5]);
     *     foreach ($pagedResponse->iteratePages() as $page) {
     *         foreach ($page as $element) {
     *             // doSomethingWith($element);
     *         }
     *     }
     * } finally {
     *     $metricServiceClient->close();
     * }
     * ```
     *
     * @param string $name   The project on which to execute the request. The format is
     *                       "projects/{project_id_or_number}".
     * @param string $filter A [monitoring filter](https://cloud.google.com/monitoring/api/v3/filters) that specifies which time
     *                       series should be returned.  The filter must specify a single metric type,
     *                       and can additionally specify metric labels and other information. For
     *                       example:
     *
     *     metric.type = "compute.googleapis.com/instance/cpu/usage_time" AND
     *         metric.label.instance_name = "my-instance-name"
     * @param TimeInterval $interval     The time interval for which results should be returned. Only time series
     *                                   that contain data points in the specified interval are included
     *                                   in the response.
     * @param int          $view         Specifies which information is returned about the time series.
     *                                   For allowed values, use constants defined on {@see \Google\Monitoring\V3\ListTimeSeriesRequest_TimeSeriesView}
     * @param array        $optionalArgs {
     *                                   Optional.
     *
     *     @type Aggregation $aggregation
     *          By default, the raw time series data is returned.
     *          Use this field to combine multiple time series for different
     *          views of the data.
     *     @type string $orderBy
     *          Specifies the order in which the points of the time series should
     *          be returned.  By default, results are not ordered.  Currently,
     *          this field must be left blank.
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
    public function listTimeSeries($name, $filter, $interval, $view, $optionalArgs = [])
    {
        $request = new ListTimeSeriesRequest();
        $request->setName($name);
        $request->setFilter($filter);
        $request->setInterval($interval);
        $request->setView($view);
        if (isset($optionalArgs['aggregation'])) {
            $request->setAggregation($optionalArgs['aggregation']);
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

        $mergedSettings = $this->defaultCallSettings['listTimeSeries']->merge(
            new CallSettings($optionalArgs)
        );
        $callable = ApiCallable::createApiCall(
            $this->metricServiceStub,
            'ListTimeSeries',
            $mergedSettings,
            $this->descriptors['listTimeSeries']
        );

        return $callable(
            $request,
            [],
            ['call_credentials_callback' => $this->createCredentialsCallback()]);
    }

    /**
     * Creates or adds data to one or more time series.
     * The response is empty if all time series in the request were written.
     * If any time series could not be written, a corresponding failure message is
     * included in the error response.
     *
     * Sample code:
     * ```
     * try {
     *     $metricServiceClient = new MetricServiceClient();
     *     $formattedName = MetricServiceClient::formatProjectName("[PROJECT]");
     *     $timeSeries = [];
     *     $metricServiceClient->createTimeSeries($formattedName, $timeSeries);
     * } finally {
     *     $metricServiceClient->close();
     * }
     * ```
     *
     * @param string       $name         The project on which to execute the request. The format is
     *                                   `"projects/{project_id_or_number}"`.
     * @param TimeSeries[] $timeSeries   The new data to be added to a list of time series.
     *                                   Adds at most one data point to each of several time series.  The new data
     *                                   point must be more recent than any other point in its time series.  Each
     *                                   `TimeSeries` value must fully specify a unique time series by supplying
     *                                   all label values for the metric and the monitored resource.
     * @param array        $optionalArgs {
     *                                   Optional.
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
    public function createTimeSeries($name, $timeSeries, $optionalArgs = [])
    {
        $request = new CreateTimeSeriesRequest();
        $request->setName($name);
        $request->setTimeSeries($timeSeries);

        $mergedSettings = $this->defaultCallSettings['createTimeSeries']->merge(
            new CallSettings($optionalArgs)
        );
        $callable = ApiCallable::createApiCall(
            $this->metricServiceStub,
            'CreateTimeSeries',
            $mergedSettings,
            $this->descriptors['createTimeSeries']
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
        $this->metricServiceStub->close();
    }

    private function createCredentialsCallback()
    {
        return $this->grpcCredentialsHelper->createCallCredentialsCallback();
    }
}

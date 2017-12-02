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
 * https://github.com/google/googleapis/blob/master/google/monitoring/v3/metric_service.proto
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
use Google\Api\MetricDescriptor;
use Google\Cloud\Monitoring\V3\Aggregation;
use Google\Cloud\Monitoring\V3\CreateMetricDescriptorRequest;
use Google\Cloud\Monitoring\V3\CreateTimeSeriesRequest;
use Google\Cloud\Monitoring\V3\DeleteMetricDescriptorRequest;
use Google\Cloud\Monitoring\V3\GetMetricDescriptorRequest;
use Google\Cloud\Monitoring\V3\GetMonitoredResourceDescriptorRequest;
use Google\Cloud\Monitoring\V3\ListMetricDescriptorsRequest;
use Google\Cloud\Monitoring\V3\ListMonitoredResourceDescriptorsRequest;
use Google\Cloud\Monitoring\V3\ListTimeSeriesRequest;
use Google\Cloud\Monitoring\V3\ListTimeSeriesRequest_TimeSeriesView as TimeSeriesView;
use Google\Cloud\Monitoring\V3\MetricServiceGrpcClient;
use Google\Cloud\Monitoring\V3\TimeInterval;
use Google\Cloud\Monitoring\V3\TimeSeries;
use Google\Cloud\Version;

/**
 * Service Description: Manages metric descriptors, monitored resource descriptors, and
 * time series data.
 *
 * This class provides the ability to make remote calls to the backing service through method
 * calls that map to API methods. Sample code to get started:
 *
 * ```
 * try {
 *     $metricServiceClient = new MetricServiceClient();
 *     $formattedName = $metricServiceClient->projectName('[PROJECT]');
 *     // Iterate through all elements
 *     $pagedResponse = $metricServiceClient->listMonitoredResourceDescriptors($formattedName);
 *     foreach ($pagedResponse->iterateAllElements() as $element) {
 *         // doSomethingWith($element);
 *     }
 *
 *     // OR iterate over pages of elements
 *     $pagedResponse = $metricServiceClient->listMonitoredResourceDescriptors($formattedName);
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
 * a parseName method to extract the individual identifiers contained within formatted names
 * that are returned by the API.
 */
class MetricServiceGapicClient
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
    private static $metricDescriptorNameTemplate;
    private static $monitoredResourceDescriptorNameTemplate;
    private static $pathTemplateMap;
    private static $gapicVersion;
    private static $gapicVersionLoaded = false;

    protected $grpcCredentialsHelper;
    protected $metricServiceStub;
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

    private static function getPathTemplateMap()
    {
        if (self::$pathTemplateMap == null) {
            self::$pathTemplateMap = [
                'project' => self::getProjectNameTemplate(),
                'metricDescriptor' => self::getMetricDescriptorNameTemplate(),
                'monitoredResourceDescriptor' => self::getMonitoredResourceDescriptorNameTemplate(),
            ];
        }

        return self::$pathTemplateMap;
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
     * a metric_descriptor resource.
     *
     * @param string $project
     * @param string $metricDescriptor
     *
     * @return string The formatted metric_descriptor resource.
     * @experimental
     */
    public static function metricDescriptorName($project, $metricDescriptor)
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
    public static function monitoredResourceDescriptorName($project, $monitoredResourceDescriptor)
    {
        return self::getMonitoredResourceDescriptorNameTemplate()->render([
            'project' => $project,
            'monitored_resource_descriptor' => $monitoredResourceDescriptor,
        ]);
    }

    /**
     * Parses a formatted name string and returns an associative array of the components in the name.
     * The following name formats are supported:
     * Template: Pattern
     * - project: projects/{project}
     * - metricDescriptor: projects/{project}/metricDescriptors/{metric_descriptor=**}
     * - monitoredResourceDescriptor: projects/{project}/monitoredResourceDescriptors/{monitored_resource_descriptor}.
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
            'clientConfigPath' => __DIR__.'/../resources/metric_service_client_config.json',
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

        $clientConfigJsonString = file_get_contents($options['clientConfigPath']);
        $clientConfig = json_decode($clientConfigJsonString, true);
        $this->defaultCallSettings =
                CallSettings::load(
                    'google.monitoring.v3.MetricService',
                    $clientConfig,
                    $options['retryingOverride']
                );

        $this->scopes = $options['scopes'];

        $createStubOptions = [];
        if (array_key_exists('sslCreds', $options)) {
            $createStubOptions['sslCreds'] = $options['sslCreds'];
        }
        $this->grpcCredentialsHelper = new GrpcCredentialsHelper($options);

        $createMetricServiceStubFunction = function ($hostname, $opts, $channel) {
            return new MetricServiceGrpcClient($hostname, $opts, $channel);
        };
        if (array_key_exists('createMetricServiceStubFunction', $options)) {
            $createMetricServiceStubFunction = $options['createMetricServiceStubFunction'];
        }
        $this->metricServiceStub = $this->grpcCredentialsHelper->createStub($createMetricServiceStubFunction);
    }

    /**
     * Lists monitored resource descriptors that match a filter. This method does not require a Stackdriver account.
     *
     * Sample code:
     * ```
     * try {
     *     $metricServiceClient = new MetricServiceClient();
     *     $formattedName = $metricServiceClient->projectName('[PROJECT]');
     *     // Iterate through all elements
     *     $pagedResponse = $metricServiceClient->listMonitoredResourceDescriptors($formattedName);
     *     foreach ($pagedResponse->iterateAllElements() as $element) {
     *         // doSomethingWith($element);
     *     }
     *
     *     // OR iterate over pages of elements
     *     $pagedResponse = $metricServiceClient->listMonitoredResourceDescriptors($formattedName);
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

        $defaultCallSettings = $this->defaultCallSettings['listMonitoredResourceDescriptors'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));
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
     *     $formattedName = $metricServiceClient->monitoredResourceDescriptorName('[PROJECT]', '[MONITORED_RESOURCE_DESCRIPTOR]');
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
     *     @type \Google\ApiCore\RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Api\MonitoredResourceDescriptor
     *
     * @throws \Google\ApiCore\ApiException if the remote call fails
     * @experimental
     */
    public function getMonitoredResourceDescriptor($name, $optionalArgs = [])
    {
        $request = new GetMonitoredResourceDescriptorRequest();
        $request->setName($name);

        $defaultCallSettings = $this->defaultCallSettings['getMonitoredResourceDescriptor'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));
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
     *     $formattedName = $metricServiceClient->projectName('[PROJECT]');
     *     // Iterate through all elements
     *     $pagedResponse = $metricServiceClient->listMetricDescriptors($formattedName);
     *     foreach ($pagedResponse->iterateAllElements() as $element) {
     *         // doSomethingWith($element);
     *     }
     *
     *     // OR iterate over pages of elements
     *     $pagedResponse = $metricServiceClient->listMetricDescriptors($formattedName);
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

        $defaultCallSettings = $this->defaultCallSettings['listMetricDescriptors'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));
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
     *     $formattedName = $metricServiceClient->metricDescriptorName('[PROJECT]', '[METRIC_DESCRIPTOR]');
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
     *     @type \Google\ApiCore\RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Api\MetricDescriptor
     *
     * @throws \Google\ApiCore\ApiException if the remote call fails
     * @experimental
     */
    public function getMetricDescriptor($name, $optionalArgs = [])
    {
        $request = new GetMetricDescriptorRequest();
        $request->setName($name);

        $defaultCallSettings = $this->defaultCallSettings['getMetricDescriptor'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));
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
     *     $formattedName = $metricServiceClient->projectName('[PROJECT]');
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
     *     @type \Google\ApiCore\RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Api\MetricDescriptor
     *
     * @throws \Google\ApiCore\ApiException if the remote call fails
     * @experimental
     */
    public function createMetricDescriptor($name, $metricDescriptor, $optionalArgs = [])
    {
        $request = new CreateMetricDescriptorRequest();
        $request->setName($name);
        $request->setMetricDescriptor($metricDescriptor);

        $defaultCallSettings = $this->defaultCallSettings['createMetricDescriptor'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));
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
     *     $formattedName = $metricServiceClient->metricDescriptorName('[PROJECT]', '[METRIC_DESCRIPTOR]');
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
    public function deleteMetricDescriptor($name, $optionalArgs = [])
    {
        $request = new DeleteMetricDescriptorRequest();
        $request->setName($name);

        $defaultCallSettings = $this->defaultCallSettings['deleteMetricDescriptor'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));
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
     *     $formattedName = $metricServiceClient->projectName('[PROJECT]');
     *     $filter = '';
     *     $interval = new TimeInterval();
     *     $view = TimeSeriesView::FULL;
     *     // Iterate through all elements
     *     $pagedResponse = $metricServiceClient->listTimeSeries($formattedName, $filter, $interval, $view);
     *     foreach ($pagedResponse->iterateAllElements() as $element) {
     *         // doSomethingWith($element);
     *     }
     *
     *     // OR iterate over pages of elements
     *     $pagedResponse = $metricServiceClient->listTimeSeries($formattedName, $filter, $interval, $view);
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
     *                                   For allowed values, use constants defined on {@see \Google\Cloud\Monitoring\V3\ListTimeSeriesRequest_TimeSeriesView}
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

        $defaultCallSettings = $this->defaultCallSettings['listTimeSeries'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));
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
     *     $formattedName = $metricServiceClient->projectName('[PROJECT]');
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
    public function createTimeSeries($name, $timeSeries, $optionalArgs = [])
    {
        $request = new CreateTimeSeriesRequest();
        $request->setName($name);
        $request->setTimeSeries($timeSeries);

        $defaultCallSettings = $this->defaultCallSettings['createTimeSeries'];
        if (isset($optionalArgs['retrySettings']) && is_array($optionalArgs['retrySettings'])) {
            $optionalArgs['retrySettings'] = $defaultCallSettings->getRetrySettings()->with(
                $optionalArgs['retrySettings']
            );
        }
        $mergedSettings = $defaultCallSettings->merge(new CallSettings($optionalArgs));
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

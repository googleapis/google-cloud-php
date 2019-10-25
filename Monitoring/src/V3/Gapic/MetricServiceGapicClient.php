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
 * https://github.com/google/googleapis/blob/master/google/monitoring/v3/metric_service.proto
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
use Google\Api\MetricDescriptor;
use Google\Api\MonitoredResourceDescriptor;
use Google\Auth\FetchAuthTokenInterface;
use Google\Cloud\Monitoring\V3\Aggregation;
use Google\Cloud\Monitoring\V3\CreateMetricDescriptorRequest;
use Google\Cloud\Monitoring\V3\CreateTimeSeriesRequest;
use Google\Cloud\Monitoring\V3\DeleteMetricDescriptorRequest;
use Google\Cloud\Monitoring\V3\GetMetricDescriptorRequest;
use Google\Cloud\Monitoring\V3\GetMonitoredResourceDescriptorRequest;
use Google\Cloud\Monitoring\V3\ListMetricDescriptorsRequest;
use Google\Cloud\Monitoring\V3\ListMetricDescriptorsResponse;
use Google\Cloud\Monitoring\V3\ListMonitoredResourceDescriptorsRequest;
use Google\Cloud\Monitoring\V3\ListMonitoredResourceDescriptorsResponse;
use Google\Cloud\Monitoring\V3\ListTimeSeriesRequest;
use Google\Cloud\Monitoring\V3\ListTimeSeriesRequest\TimeSeriesView;
use Google\Cloud\Monitoring\V3\ListTimeSeriesResponse;
use Google\Cloud\Monitoring\V3\TimeInterval;
use Google\Cloud\Monitoring\V3\TimeSeries;
use Google\Protobuf\GPBEmpty;

/**
 * Service Description: Manages metric descriptors, monitored resource descriptors, and
 * time series data.
 *
 * This class provides the ability to make remote calls to the backing service through method
 * calls that map to API methods. Sample code to get started:
 *
 * ```
 * $metricServiceClient = new Google\Cloud\Monitoring\V3\MetricServiceClient();
 * try {
 *     $formattedName = $metricServiceClient->projectName('[PROJECT]');
 *     // Iterate over pages of elements
 *     $pagedResponse = $metricServiceClient->listMonitoredResourceDescriptors($formattedName);
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
 *     $pagedResponse = $metricServiceClient->listMonitoredResourceDescriptors($formattedName);
 *     foreach ($pagedResponse->iterateAllElements() as $element) {
 *         // doSomethingWith($element);
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
 *
 * @experimental
 */
class MetricServiceGapicClient
{
    use GapicClientTrait;

    /**
     * The name of the service.
     */
    const SERVICE_NAME = 'google.monitoring.v3.MetricService';

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
    private static $metricDescriptorNameTemplate;
    private static $monitoredResourceDescriptorNameTemplate;
    private static $projectNameTemplate;
    private static $pathTemplateMap;

    private static function getClientDefaults()
    {
        return [
            'serviceName' => self::SERVICE_NAME,
            'apiEndpoint' => self::SERVICE_ADDRESS.':'.self::DEFAULT_SERVICE_PORT,
            'clientConfig' => __DIR__.'/../resources/metric_service_client_config.json',
            'descriptorsConfigPath' => __DIR__.'/../resources/metric_service_descriptor_config.php',
            'gcpApiConfigPath' => __DIR__.'/../resources/metric_service_grpc_config.json',
            'credentialsConfig' => [
                'scopes' => self::$serviceScopes,
            ],
            'transportConfig' => [
                'rest' => [
                    'restClientConfigPath' => __DIR__.'/../resources/metric_service_rest_client_config.php',
                ],
            ],
        ];
    }

    private static function getMetricDescriptorNameTemplate()
    {
        if (null == self::$metricDescriptorNameTemplate) {
            self::$metricDescriptorNameTemplate = new PathTemplate('projects/{project}/metricDescriptors/{metric_descriptor=**}');
        }

        return self::$metricDescriptorNameTemplate;
    }

    private static function getMonitoredResourceDescriptorNameTemplate()
    {
        if (null == self::$monitoredResourceDescriptorNameTemplate) {
            self::$monitoredResourceDescriptorNameTemplate = new PathTemplate('projects/{project}/monitoredResourceDescriptors/{monitored_resource_descriptor}');
        }

        return self::$monitoredResourceDescriptorNameTemplate;
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
                'metricDescriptor' => self::getMetricDescriptorNameTemplate(),
                'monitoredResourceDescriptor' => self::getMonitoredResourceDescriptorNameTemplate(),
                'project' => self::getProjectNameTemplate(),
            ];
        }

        return self::$pathTemplateMap;
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
     * - metricDescriptor: projects/{project}/metricDescriptors/{metric_descriptor=**}
     * - monitoredResourceDescriptor: projects/{project}/monitoredResourceDescriptors/{monitored_resource_descriptor}
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
     * Lists monitored resource descriptors that match a filter. This method does not require a Stackdriver account.
     *
     * Sample code:
     * ```
     * $metricServiceClient = new Google\Cloud\Monitoring\V3\MetricServiceClient();
     * try {
     *     $formattedName = $metricServiceClient->projectName('[PROJECT]');
     *     // Iterate over pages of elements
     *     $pagedResponse = $metricServiceClient->listMonitoredResourceDescriptors($formattedName);
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
     *     $pagedResponse = $metricServiceClient->listMonitoredResourceDescriptors($formattedName);
     *     foreach ($pagedResponse->iterateAllElements() as $element) {
     *         // doSomethingWith($element);
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
    public function listMonitoredResourceDescriptors($name, array $optionalArgs = [])
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

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->getPagedListResponse(
            'ListMonitoredResourceDescriptors',
            $optionalArgs,
            ListMonitoredResourceDescriptorsResponse::class,
            $request
        );
    }

    /**
     * Gets a single monitored resource descriptor. This method does not require a Stackdriver account.
     *
     * Sample code:
     * ```
     * $metricServiceClient = new Google\Cloud\Monitoring\V3\MetricServiceClient();
     * try {
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
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Api\MonitoredResourceDescriptor
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function getMonitoredResourceDescriptor($name, array $optionalArgs = [])
    {
        $request = new GetMonitoredResourceDescriptorRequest();
        $request->setName($name);

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'GetMonitoredResourceDescriptor',
            MonitoredResourceDescriptor::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Lists metric descriptors that match a filter. This method does not require a Stackdriver account.
     *
     * Sample code:
     * ```
     * $metricServiceClient = new Google\Cloud\Monitoring\V3\MetricServiceClient();
     * try {
     *     $formattedName = $metricServiceClient->projectName('[PROJECT]');
     *     // Iterate over pages of elements
     *     $pagedResponse = $metricServiceClient->listMetricDescriptors($formattedName);
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
     *     $pagedResponse = $metricServiceClient->listMetricDescriptors($formattedName);
     *     foreach ($pagedResponse->iterateAllElements() as $element) {
     *         // doSomethingWith($element);
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
    public function listMetricDescriptors($name, array $optionalArgs = [])
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

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->getPagedListResponse(
            'ListMetricDescriptors',
            $optionalArgs,
            ListMetricDescriptorsResponse::class,
            $request
        );
    }

    /**
     * Gets a single metric descriptor. This method does not require a Stackdriver account.
     *
     * Sample code:
     * ```
     * $metricServiceClient = new Google\Cloud\Monitoring\V3\MetricServiceClient();
     * try {
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
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Api\MetricDescriptor
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function getMetricDescriptor($name, array $optionalArgs = [])
    {
        $request = new GetMetricDescriptorRequest();
        $request->setName($name);

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'GetMetricDescriptor',
            MetricDescriptor::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Creates a new metric descriptor.
     * User-created metric descriptors define
     * [custom metrics](https://cloud.google.com/monitoring/custom-metrics).
     *
     * Sample code:
     * ```
     * $metricServiceClient = new Google\Cloud\Monitoring\V3\MetricServiceClient();
     * try {
     *     $formattedName = $metricServiceClient->projectName('[PROJECT]');
     *     $metricDescriptor = new Google\Cloud\Monitoring\V3\MetricDescriptor();
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
     *     @type RetrySettings|array $retrySettings
     *          Retry settings to use for this call. Can be a
     *          {@see Google\ApiCore\RetrySettings} object, or an associative array
     *          of retry settings parameters. See the documentation on
     *          {@see Google\ApiCore\RetrySettings} for example usage.
     * }
     *
     * @return \Google\Api\MetricDescriptor
     *
     * @throws ApiException if the remote call fails
     * @experimental
     */
    public function createMetricDescriptor($name, $metricDescriptor, array $optionalArgs = [])
    {
        $request = new CreateMetricDescriptorRequest();
        $request->setName($name);
        $request->setMetricDescriptor($metricDescriptor);

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'CreateMetricDescriptor',
            MetricDescriptor::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Deletes a metric descriptor. Only user-created
     * [custom metrics](https://cloud.google.com/monitoring/custom-metrics) can be deleted.
     *
     * Sample code:
     * ```
     * $metricServiceClient = new Google\Cloud\Monitoring\V3\MetricServiceClient();
     * try {
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
    public function deleteMetricDescriptor($name, array $optionalArgs = [])
    {
        $request = new DeleteMetricDescriptorRequest();
        $request->setName($name);

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'DeleteMetricDescriptor',
            GPBEmpty::class,
            $optionalArgs,
            $request
        )->wait();
    }

    /**
     * Lists time series that match a filter. This method does not require a Stackdriver account.
     *
     * Sample code:
     * ```
     * $metricServiceClient = new Google\Cloud\Monitoring\V3\MetricServiceClient();
     * try {
     *     $formattedName = $metricServiceClient->projectName('[PROJECT]');
     *     $filter = '';
     *     $interval = new Google\Cloud\Monitoring\V3\TimeInterval();
     *     $view = Google\Cloud\Monitoring\V3\ListTimeSeriesRequest\TimeSeriesView::FULL;
     *     // Iterate over pages of elements
     *     $pagedResponse = $metricServiceClient->listTimeSeries($formattedName, $filter, $interval, $view);
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
     *     $pagedResponse = $metricServiceClient->listTimeSeries($formattedName, $filter, $interval, $view);
     *     foreach ($pagedResponse->iterateAllElements() as $element) {
     *         // doSomethingWith($element);
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
     *         metric.labels.instance_name = "my-instance-name"
     * @param TimeInterval $interval     The time interval for which results should be returned. Only time series
     *                                   that contain data points in the specified interval are included
     *                                   in the response.
     * @param int          $view         Specifies which information is returned about the time series.
     *                                   For allowed values, use constants defined on {@see \Google\Cloud\Monitoring\V3\ListTimeSeriesRequest\TimeSeriesView}
     * @param array        $optionalArgs {
     *                                   Optional.
     *
     *     @type Aggregation $aggregation
     *          By default, the raw time series data is returned.
     *          Use this field to combine multiple time series for different
     *          views of the data.
     *     @type string $orderBy
     *          Unsupported: must be left blank. The points in each time series are
     *          returned in reverse time order.
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
    public function listTimeSeries($name, $filter, $interval, $view, array $optionalArgs = [])
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

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->getPagedListResponse(
            'ListTimeSeries',
            $optionalArgs,
            ListTimeSeriesResponse::class,
            $request
        );
    }

    /**
     * Creates or adds data to one or more time series.
     * The response is empty if all time series in the request were written.
     * If any time series could not be written, a corresponding failure message is
     * included in the error response.
     *
     * Sample code:
     * ```
     * $metricServiceClient = new Google\Cloud\Monitoring\V3\MetricServiceClient();
     * try {
     *     $formattedName = $metricServiceClient->projectName('[PROJECT]');
     *     $timeSeries = [];
     *     $metricServiceClient->createTimeSeries($formattedName, $timeSeries);
     * } finally {
     *     $metricServiceClient->close();
     * }
     * ```
     *
     * @param string       $name       The project on which to execute the request. The format is
     *                                 `"projects/{project_id_or_number}"`.
     * @param TimeSeries[] $timeSeries The new data to be added to a list of time series.
     *                                 Adds at most one data point to each of several time series.  The new data
     *                                 point must be more recent than any other point in its time series.  Each
     *                                 `TimeSeries` value must fully specify a unique time series by supplying
     *                                 all label values for the metric and the monitored resource.
     *
     * The maximum number of `TimeSeries` objects per `Create` request is 200.
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
    public function createTimeSeries($name, $timeSeries, array $optionalArgs = [])
    {
        $request = new CreateTimeSeriesRequest();
        $request->setName($name);
        $request->setTimeSeries($timeSeries);

        $requestParams = new RequestParamsHeaderDescriptor([
          'name' => $request->getName(),
        ]);
        $optionalArgs['headers'] = isset($optionalArgs['headers'])
            ? array_merge($requestParams->getHeader(), $optionalArgs['headers'])
            : $requestParams->getHeader();

        return $this->startCall(
            'CreateTimeSeries',
            GPBEmpty::class,
            $optionalArgs,
            $request
        )->wait();
    }
}
